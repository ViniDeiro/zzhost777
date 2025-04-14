<?php
session_start();
include_once('../admin/services/database.php');
include_once('../admin/services/funcao.php');
include_once('../admin/services/crud.php');
global $mysqli;

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit;
}

$idTransaction = PHP_SEGURO($data['idTransaction']);
$typeTransaction = PHP_SEGURO($data['typeTransaction']);
$statusTransaction = PHP_SEGURO($data['statusTransaction']);
$valor = PHP_SEGURO($data['valor']);

// $dev_hook = 'https://webhook.site/003837df-769c-46d7-a50b-3cbdcad7ee81';

function url_send(){
    global $data, $dev_hook;
    $url = $dev_hook;
    $ch = curl_init($url);
    $corpo = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $corpo);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resultado = curl_exec($ch);
    curl_close($ch);
    return $resultado;
}

url_send();

function busca_valor_ipn($transacao_id){
    global $mysqli;
    $qry = "SELECT valor, usuario FROM transacoes WHERE transacao_id = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param("s", $transacao_id);
    $stmt->execute();
    $stmt->bind_result($valor, $usuario);
    $stmt->fetch();
    $stmt->close();
    
    if ($valor && $usuario) {
        $retornaUSER = get_user_by_id($usuario);
        $info_user = saldo_user_email($retornaUSER['mobile']);
        $saldo = $info_user['saldo'] ?? 0;
        $user_id = $info_user['user_id'] ?? 0;
        
        att_saldo_user($saldo + $valor, $user_id);
        usar_cupom($user_id, $valor);
        
        $retorna_insert_saldo_suit_pay = enviarSaldo($retornaUSER['mobile'], $valor);
        $url = getCurrentUrl();
        WebhookPixPagos($retornaUSER['mobile'], $url, $valor);
        return $retorna_insert_saldo_suit_pay;
    }
    return false;
}


function get_user_by_id($user_id) {
    global $mysqli;
    $qry = "SELECT mobile FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($mobile);
    $stmt->fetch();
    $stmt->close();
    return ['mobile' => $mobile];
}

function att_paymentpix($transacao_id) {
    global $mysqli;
    
    $sql = $mysqli->prepare("UPDATE transacoes SET status='1' WHERE transacao_id=?");
    $sql->bind_param("s", $transacao_id);
    
    if ($sql->execute()) {
        $buscar = busca_valor_ipn($transacao_id);
        
        if ($buscar) {
            $qry = "SELECT usuario FROM transacoes WHERE transacao_id='" . $transacao_id . "'";
            $res = mysqli_query($mysqli, $qry);
            $data = mysqli_fetch_assoc($res);
            $user_id = $data['usuario'];
            
            $user_info = get_user_by_id($user_id);
            $nome_user = $user_info['mobile'];
            $valor = is_array($buscar) ? $buscar['valor'] : $buscar;

            $rf = 1;
        } else {
            $rf = 0;
        }
    } else {
        $rf = 0;
    }
    return $rf;
}

if (isset($idTransaction) && $typeTransaction == "PIX" && $statusTransaction == "PAID_OUT") {
    $att_transacao = att_paymentpix($idTransaction);
}

if ($tipoAPI_SUITPAY == 0) {
    if (isset($idTransaction) && $typeTransaction == "PIX" && $statusTransaction == "UNPAID") {
        $att_transacao = att_paymentpix($idTransaction);
    }
}

?>