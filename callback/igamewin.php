<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../admin/services/database.php';
include_once __DIR__ . '/../admin/services/funcao.php';

function callbackUserBalance($request) {
    global $mysqli;
    
    $user_code = isset($request['user_code']) ? $request['user_code'] : '';
    
    $qry = "SELECT saldo FROM usuarios WHERE mobile = ?";
    $stmt = $mysqli->prepare($qry);
    if (!$stmt) {
        error_log("Erro ao preparar a consulta: " . $mysqli->error);
        return json_encode(['status' => 0, 'msg' => 'ERROR_PREPARING_QUERY']);
    }
    
    $stmt->bind_param("s", $user_code);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $saldo = $row['saldo'];
            $response = ['status' => 1, 'user_balance' => floatval($saldo)];
        } else {
            $response = ['status' => 0, 'msg' => 'INVALID_USER', 'user_code' => $user_code];
        }
        $stmt->close();
    } else {
        $response = ['status' => 0, 'msg' => 'ERROR_QUERY', 'error' => $stmt->error];
    }
    
    return json_encode($response);
}

function callbackTransaction($request) {
    global $mysqli;

    $user_code  = $request['user_code'] ?? '';
    $game_type  = $request['game_type'] ?? '';
    $slotData   = $request['slot'] ?? [];
    $provider_code = $slotData['provider_code'] ?? '';
    $game_code  = $slotData['game_code'] ?? '';
    $bet_money  = $slotData['bet_money'] ?? 0;
    $win_money  = $slotData['win_money'] ?? 0;
    $txn_id     = $slotData['txn_id'] ?? '';
    $txn_type   = $slotData['txn_type'] ?? '';

    $qry = "SELECT id, saldo FROM usuarios WHERE mobile = ?";
    $stmt = $mysqli->prepare($qry);
    if (!$stmt) {
        error_log("Erro ao preparar consulta de usuário: " . $mysqli->error);
        return json_encode(['status' => 0, 'msg' => 'ERROR_PREPARING_QUERY']);
    }
    $stmt->bind_param("s", $user_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $response = ['status' => 0, 'msg' => 'INVALID_USER', 'user_code' => $user_code];
        return json_encode($response);
    }
    $row = $result->fetch_assoc();
    $id_user = $row['id'];
    $current_balance = $row['saldo'];
    $stmt->close();

    $new_balance = $current_balance - $bet_money + $win_money;

    $sqlInsert = "INSERT INTO historico_play (id_user, nome_game, bet_money, win_money, txn_id, created_at, status_play) 
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmtInsert = $mysqli->prepare($sqlInsert);
    if (!$stmtInsert) {
        error_log("Erro ao preparar inserção no histórico: " . $mysqli->error);
        $response = ['status' => 0, 'msg' => 'ERROR_PREPARING_INSERT'];
        return json_encode($response);
    }
    $nome_game = $game_code;
    $status_play = 1;
    $stmtInsert->bind_param("isddsi", $id_user, $nome_game, $bet_money, $win_money, $txn_id, $status_play);
    $stmtInsert->execute();
    $stmtInsert->close();
    
    $update_query = "UPDATE usuarios SET saldo = ? WHERE id = ?";
    $stmtUpdate = $mysqli->prepare($update_query);
    if (!$stmtUpdate) {
        error_log("Erro ao preparar atualização de saldo: " . $mysqli->error);
        $response = ['status' => 0, 'msg' => 'ERROR_PREPARING_UPDATE'];
        return json_encode($response);
    }
    $stmtUpdate->bind_param("di", $new_balance, $id_user);
    if ($stmtUpdate->execute()) {
        $response = ['status' => 1, 'user_balance' => floatval($new_balance)];
    } else {
        $response = ['status' => 0, 'msg' => 'FAILED_TO_UPDATE_BALANCE'];
    }
    $stmtUpdate->close();
    
    return json_encode($response);
}

$input = file_get_contents('php://input');
$reqData = json_decode($input, true);

if (!$reqData) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['status' => 0, 'msg' => 'Invalid JSON']);
    exit;
}

if (isset($reqData['method'])) {
    $method = $reqData['method'];
    if ($method === "user_balance") {
        $response = callbackUserBalance($reqData);
        echo $response;
    } elseif ($method === "transaction") {
        $response = callbackTransaction($reqData);
        echo $response;
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Method not supported']);
    }
} else {
    echo json_encode(['status' => 0, 'msg' => 'Method not specified']);
}
