<?php
// Incluir a conexão e serviços necessários
include '../services/database.php';
include '../services/crud.php';
include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
checa_login_adm();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("converter_saldo.php: Recebendo dados via POST.");

    // Obter os dados enviados
    $data = json_decode(file_get_contents('php://input'), true);
    logMessage("Dados recebidos: " . print_r($data, true));

    if (isset($data['user_id'])) {
        $user_id = intval($data['user_id']);

        // Consultar o saldo atual e o saldo de afiliado do usuário
        $query = "SELECT saldo, saldo_afiliados FROM usuarios WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $resposta = $stmt->get_result();
        $usuario = $resposta->fetch_assoc();

        if (!$usuario) {
            logMessage("converter_saldo.php: Usuário não encontrado: ID $user_id");
            echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
            exit;
        }

        $saldoAtual = floatval($usuario['saldo']);
        $saldoAfiliado = floatval($usuario['saldo_afiliados']);
        logMessage("converter_saldo.php: Saldo atual: $saldoAtual, Saldo de afiliado: $saldoAfiliado para o usuário $user_id.");

        if ($saldoAfiliado <= 0) {
            logMessage("converter_saldo.php: Saldo de afiliado insuficiente para conversão para o usuário $user_id.");
            echo json_encode(['success' => false, 'message' => 'Saldo de afiliado insuficiente para conversão.']);
            exit;
        }

        // Converter: somar o saldo de afiliado ao saldo principal e zerar o saldo de afiliado
        $novoSaldo = $saldoAtual + $saldoAfiliado;
        $query = "UPDATE usuarios SET saldo = ?, saldo_afiliados = 0 WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("di", $novoSaldo, $user_id);

        if ($stmt->execute()) {
            logMessage("converter_saldo.php: Saldo convertido com sucesso para o usuário $user_id.");
            echo json_encode(['success' => true, 'message' => 'Saldo convertido com sucesso.']);
        } else {
            logMessage("converter_saldo.php: Erro ao converter saldo para o usuário $user_id: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Erro ao converter saldo.']);
        }
    } else {
        logMessage("converter_saldo.php: Dados inválidos fornecidos.");
        echo json_encode(['success' => false, 'message' => 'Dados inválidos fornecidos.']);
    }
} else {
    logMessage("converter_saldo.php: Método inválido de requisição.");
    echo json_encode(['success' => false, 'message' => 'Método inválido de requisição.']);
}

$mysqli->close();
?>
