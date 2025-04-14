<?php
// Incluir a conexão e serviços necessários
include '../services/database.php';
include '../services/crud.php';
include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
checa_login_adm();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("update_proximo_salario.php: Recebendo dados via POST.");

    // Obter os dados enviados
    $data = json_decode(file_get_contents('php://input'), true);
    logMessage("Dados recebidos: " . print_r($data, true));

    // Validar os campos necessários
    if (isset($data['user_id'], $data['prox_salario_valor'], $data['prox_salario'])) {
        $user_id = intval($data['user_id']);
        $valor = floatval($data['prox_salario_valor']);
        $dataSalario = $data['prox_salario']; // Espera-se uma string de data (YYYY-MM-DD)

        $query = "UPDATE usuarios SET prox_salario_valor = ?, prox_salario = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("dsi", $valor, $dataSalario, $user_id);

        if ($stmt->execute()) {
            logMessage("update_proximo_salario.php: Próximo salário atualizado com sucesso para o usuário $user_id.");
            echo json_encode(['success' => true, 'message' => 'Próximo salário atualizado com sucesso.']);
        } else {
            logMessage("update_proximo_salario.php: Erro ao atualizar próximo salário para o usuário $user_id: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o próximo salário.']);
        }
    } else {
        logMessage("update_proximo_salario.php: Dados inválidos fornecidos.");
        echo json_encode(['success' => false, 'message' => 'Dados inválidos fornecidos.']);
    }
} else {
    logMessage("update_proximo_salario.php: Método inválido de requisição.");
    echo json_encode(['success' => false, 'message' => 'Método inválido de requisição.']);
}

$mysqli->close();
?>
