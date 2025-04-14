<?php
// Incluir a conexão e serviços necessários
include '../services/database.php';
include '../services/crud.php';
include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
checa_login_adm();

// Verificar se os dados foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("update_config.php: Recebendo dados via POST.");

    // Obter os dados enviados
    $data = json_decode(file_get_contents('php://input'), true);
    logMessage("Dados recebidos: " . print_r($data, true));

    // Validar os dados obrigatórios
    if (isset($data['user_id'], $data['comissao_percentual'], $data['saque_minimo'])) {
        $user_id = intval($data['user_id']);
        $comissao = floatval($data['comissao_percentual']);
        $saqueMinimo = floatval($data['saque_minimo']);

        // Atualizar os campos no banco de dados
        $query = "UPDATE usuarios SET comissao_percentual = ?, saque_minimo = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ddi", $comissao, $saqueMinimo, $user_id);

        if ($stmt->execute()) {
            logMessage("update_config.php: Configurações atualizadas com sucesso para o usuário $user_id.");
            echo json_encode(['success' => true, 'message' => 'Configurações atualizadas com sucesso.']);
        } else {
            logMessage("update_config.php: Erro ao atualizar configurações para o usuário $user_id: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar configurações.']);
        }
    } else {
        logMessage("update_config.php: Dados inválidos fornecidos.");
        echo json_encode(['success' => false, 'message' => 'Dados inválidos fornecidos.']);
    }
} else {
    logMessage("update_config.php: Método inválido de requisição.");
    echo json_encode(['success' => false, 'message' => 'Método inválido de requisição.']);
}

// Fechar a conexão
$mysqli->close();
?>
