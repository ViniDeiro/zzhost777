<?php
session_start();
header('Content-Type: text/plain');

require_once "services/database.php";

// Verifica o token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "Token CSRF inválido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order']) && is_array($_POST['order'])) {
    $order = $_POST['order']; // Exemplo: [12, 100, 7, ...]

    try {
        // Inicia a transação
        $mysqli->begin_transaction();

        // ===============================================
        // Passo 1: Atribuir IDs temporários negativos para evitar colisões
        // Percorre o array do final para o início
        // ===============================================
        for ($i = count($order) - 1; $i >= 0; $i--) {
            $oldID = (int)$order[$i];
            $tempID = -($i + 1); // Se i = 0 → tempID = -1; i = 1 → -2; etc.
            $sql = "UPDATE games SET id = $tempID WHERE id = $oldID";
            if (!$mysqli->query($sql)) {
                throw new Exception("Erro ao renomear ID $oldID para $tempID: " . $mysqli->error);
            }
        }

        // ===============================================
        // Passo 2: Atribuir os novos IDs (1, 2, 3, …) na ordem correta
        // Percorre do início para o fim
        // ===============================================
        for ($i = 0; $i < count($order); $i++) {
            $tempID = -($i + 1);
            $newID  = $i + 1;
            $sql = "UPDATE games SET id = $newID WHERE id = $tempID";
            if (!$mysqli->query($sql)) {
                throw new Exception("Erro ao renomear ID $tempID para $newID: " . $mysqli->error);
            }
        }

        // Confirma a transação
        $mysqli->commit();
        echo "OK. Nova ordem aplicada com sucesso.";
    } catch (Exception $e) {
        // Em caso de erro, reverte a transação
        $mysqli->rollback();
        echo "Erro ao reordenar: " . $e->getMessage();
    }
} else {
    echo "Dados inválidos.";
}
?>
