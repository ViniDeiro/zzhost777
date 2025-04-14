<?php
include_once("../../admin/services/database.php");
include_once("../../admin/services/funcao.php");
include_once("../../admin/services/crud.php");

header('Content-Type: application/json');

// Verifica se o parâmetro paymentCode foi passado
if (!isset($_GET['paymentCode'])) {
    echo json_encode(['status' => 'error', 'message' => 'paymentCode não fornecido']);
    exit;
}

$paymentCode = $_GET['paymentCode'];

// Consulta na tabela "transacoes" usando a coluna "qrcode"
$query = "SELECT status FROM transacoes WHERE qrcode = ?";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $paymentCode);
    $stmt->execute();
    $stmt->bind_result($status);

    if ($stmt->fetch()) {
        if (strtolower($status) === 'pago') {
            echo json_encode(['status' => 'pago']);
        } else {
            echo json_encode(['status' => 'aguardando']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transação não encontrada']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar consulta']);
}
?>
