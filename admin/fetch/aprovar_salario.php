<?php
// fetch/aprovar_salario.php
header('Content-Type: application/json');
include '../services/database.php';
include '../services/crud.php';

include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";

// Recebe o JSON
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['prox_salario_valor'], $data['prox_salario'])) {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes.']);
    exit;
}

$user_id = (int)$data['user_id'];
$valor = floatval($data['prox_salario_valor']);
$dataSalario = $data['prox_salario']; // formato 'YYYY-MM-DD'

// Aqui você pode realizar as validações necessárias
// Exemplo: atualizar o status do salário para aprovado em alguma tabela ou coluna

// Exemplo de atualização no banco:
global $mysqli;
$query = "UPDATE usuarios 
          SET saldo_afiliados = saldo_afiliados + ?, 
              prox_salario_valor = NULL, 
              prox_salario = NULL 
          WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("di", $valor, $user_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Salário aprovado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro na atualização: ' . $mysqli->error]);
}
$stmt->close();
?>
