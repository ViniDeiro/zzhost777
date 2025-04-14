<?php
// webhook.php
session_start();
include_once("../../admin/services/database.php");
include_once("../../admin/services/funcao.php");
include_once("../../admin/services/crud.php");
include_once('suitpay.php'); // Caso esta biblioteca seja necessária

global $mysqli;

function webhook() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo 'erro404';
        exit;
    }

    // Recebe e decodifica o JSON enviado pelo provedor
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (!isset($data['idTransaction']) || !isset($data['typeTransaction']) || !isset($data['statusTransaction'])) {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
        return;
    }

    // Sanitiza os dados recebidos
    $idTransaction    = PHP_SEGURO($data['idTransaction']);
    $typeTransaction  = PHP_SEGURO($data['typeTransaction']);
    $statusTransaction = PHP_SEGURO($data['statusTransaction']);

    if ($statusTransaction === 'PAID_OUT') {
        // Atualiza o status da transação no banco de dados
        $att_transacao = att_paymentpix($idTransaction);
        // Se necessário, outras ações podem ser realizadas (ex.: notificar o usuário, atualizar saldo, etc.)
    }

    echo json_encode(['status' => 'success']);
}

webhook();
?>
