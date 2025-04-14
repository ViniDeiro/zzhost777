<?php
session_start();
include_once('../admin/services/database.php');
include_once('../admin/services/funcao.php');
include_once('../admin/services/crud.php');
global $mysqli;

// Receber dados da solicitação POST JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar se o JSON foi decodificado com sucesso
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    // Erro ao decodificar o JSON
    http_response_code(400); // Bad Request
    exit;
}

$idTransaction = PHP_SEGURO($data['requestBody']['transactionId']);         // id da transação
$typeTransaction = PHP_SEGURO($data['requestBody']['transactionType']);     // tipo de transação

#====================================================================#
# Webhook para testes de integração
$dev_hook = 'https://webhook.site/003837df-769c-46d7-a50b-3cbdcad7ee81';
//===================================================================#
function url_send(){
    global $data, $dev_hook;
    // URL de SUA API
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
//url_send();

#====================================================================#
function busca_valor_ipn($transacao_id){
    global $mysqli;
    $qry = "SELECT usuario, valor FROM transacoes WHERE transacao_id='" . $transacao_id . "'";
    $res = mysqli_query($mysqli, $qry);
    if (mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);
        $retornaUSER = get_user_by_id($data['usuario']);
        
        $info_user = saldo_user_email($retornaUSER['mobile']);
        $saldo = $info_user['saldo'] ?? 0;
        $user_id = $info_user['user_id'] ?? 0;
        att_saldo_user($saldo+$data['valor'], $user_id);
        
        usar_cupom($user_id, $data['valor']);
        
        $retorna_insert_saldo_suit_pay = enviarSaldo($retornaUSER['mobile'], $data['valor']);
        $url = getCurrentUrl();
        WebhookPixPagos($retornaUSER['mobile'], $url, $data['valor']);

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

#====================================================================#
function att_paymentpix($transacao_id){
    global $mysqli;
    $sql = $mysqli->prepare("UPDATE transacoes SET status='1' WHERE transacao_id=?");
    $sql->bind_param("s", $transacao_id);
    if ($sql->execute()) {
        $buscar = busca_valor_ipn($transacao_id);
        if ($buscar) {
            $rf = 1;
        } else {
            $rf = 0;
        }
    } else {
        $rf = 0;
    }
    return $rf;
}

#====================================================================#
#01
if (isset($idTransaction) && $typeTransaction == "RECEIVEPIX") {
    $att_transacao = att_paymentpix($idTransaction);
}
#====================================================================#
?>
