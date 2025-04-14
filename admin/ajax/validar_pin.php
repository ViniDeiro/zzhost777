<?php
session_start();
include_once '../services/database.php'; // Certifique-se de que o caminho esteja correto

// Usamos sempre o admin com ID 1
$admin_id = 1;

if (!isset($_POST['pin']) || empty($_POST['pin'])) {
    echo json_encode(['success' => false, 'message' => 'PIN não informado']);
    exit;
}

$pin = $_POST['pin'];

// Consulta para buscar o PIN armazenado na tabela admin_users (coluna "2fa") para o admin ID 1
$query = "SELECT `2fa` FROM admin_users WHERE id = " . (int)$admin_id . " LIMIT 1";
$result = mysqli_query($mysqli, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo json_encode(['success' => false, 'message' => 'Admin não encontrado']);
    exit;
}

$data = mysqli_fetch_assoc($result);
$stored_pin = $data['2fa'];

// Se o PIN estiver armazenado como texto simples, comparamos diretamente.
// Se estiver utilizando hash, utilize password_verify() em seu lugar.
if ($pin === $stored_pin) {
    echo json_encode(['success' => true, 'message' => 'PIN válido']);
} else {
    echo json_encode(['success' => false, 'message' => 'PIN incorreto']);
}
?>
