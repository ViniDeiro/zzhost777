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

$idTransaction    = isset($data['transaction_id']) ? PHP_SEGURO($data['transaction_id']) : '';
$statusTransaction = isset($data['status']) ? PHP_SEGURO($data['status']) : '';
$valor            = isset($data['amount']) ? PHP_SEGURO($data['amount']) : '';

// Exemplo de hook para ambiente de teste (opcional)
function url_send(){
    global $data, $dev_hook;
    // Se não usar um hook de teste, comente ou remova essa função.
    $ch = curl_init($dev_hook);
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
        
        // Ao finalizar o saque (completed), incrementa o saldo do usuário,
        // aplica cupom, envia saldo, etc.
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

/**
 * Função que atualiza a transação para "completo" e ajusta o saldo do usuário.
 * Aqui, definimos status='1' para indicar que o saque foi finalizado.
 */
function att_paymentpix($transacao_id) {
    global $mysqli;

    // Atualiza status da transação para 'pago'
    $sql = $mysqli->prepare("UPDATE transacoes SET status='1' WHERE transacao_id=?");
    $sql->bind_param("s", $transacao_id);

    if ($sql->execute()) {

        // Busca valores e usuário para crédito normal
        $buscar = busca_valor_ipn($transacao_id);

        // ✅ Agora buscamos comissão e afiliado
        $query = "SELECT afiliado_id, comissao FROM transacoes WHERE transacao_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $transacao_id);
        $stmt->execute();
        $stmt->bind_result($afiliado_id, $comissao);
        $stmt->fetch();
        $stmt->close();

        // Se houver afiliado e comissão definida
        if (!empty($afiliado_id) && !empty($comissao) && $comissao > 0) {
            // Atualiza saldo_afiliados do usuário afiliado
            $sql_up = "UPDATE usuarios SET saldo_afiliados = saldo_afiliados + ? WHERE id = ?";
            $stmt_up = $mysqli->prepare($sql_up);
            $stmt_up->bind_param("di", $comissao, $afiliado_id);
            if ($stmt_up->execute()) {
                error_log("[WEBHOOK] Comissão de R$ $comissao adicionada para afiliado ID $afiliado_id.");
            } else {
                error_log("[WEBHOOK] Falha ao adicionar comissão ao afiliado ID $afiliado_id.");
            }
            $stmt_up->close();
        }

        return 1;
    } else {
        return 0;
    }
}

// Processa o webhook conforme o status recebido:
if (!empty($idTransaction)) {
    $status_lower = strtolower($statusTransaction);
    if ($status_lower === "completed") {
        // Se o saque está finalizado, atualiza a transação para 'pago' e libera o crédito.
        $att_transacao = att_paymentpix($idTransaction);
    } elseif ($status_lower === "processing") {
        // Se o saque ainda está em processamento, atualiza o status para "processamento".
        $stmt = $mysqli->prepare("UPDATE transacoes SET status='processamento' WHERE transacao_id=?");
        $stmt->bind_param("s", $idTransaction);
        $stmt->execute();
        $stmt->close();
    }
}
?>
