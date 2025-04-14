<?php
// Incluir a conexão com o banco de dados
include '../services/database.php';
include '../services/crud.php';
include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
#======================================#
#expulsa user
checa_login_adm();


header('Content-Type: application/json'); // Para enviar uma resposta JSON

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuário ausente.']);
    exit;
}

$id = intval($data['user_id']);

$query = "UPDATE usuarios SET invitation_code = NULL WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Afiliação removida com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover afiliação.']);
}

$stmt->close();