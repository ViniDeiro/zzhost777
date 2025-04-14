<?php

// Configurações de erros
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include_once('../dash/services/funcao.php');
include_once('../dash/services/crud.php');
$logFilePath = __DIR__ . '/log.json';

function webhook()
{
    global $pdo;
    $logFilePath = __DIR__ . '/log.json';
    $logFileUserPath = __DIR__ . '/user.json';

    // Verifica se a requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['msg' => 'error404']);
        return;
    }

    // Captura e registra o conteúdo JSON recebido
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    file_put_contents($logFilePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Usando switch para lidar com diferentes métodos
    switch ($data['method']) {
        case 'user_balance':
            $stmtUsr = $pdo->prepare("SELECT id, saldo FROM usuarios WHERE id = :id");
            $stmtUsr->execute(['id' => $data['user_code']]);
            $usuario = $stmtUsr->fetch();

            $balance = $usuario['saldo'] ?? 0;
            echo json_encode(['status' => 1, 'user_balance' => $balance]);
            break;

        case 'transaction':
        case 'game_callback':
            //file_put_contents($logFilePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $stmtUsr = $pdo->prepare("SELECT id, saldo FROM usuarios WHERE id = :id");
            $stmtUsr->execute(['id' => $data['user_code']]);
            $usuario = $stmtUsr->fetch();
            if (isset($usuario)) {

                $gameData = $data[$data['game_type']] ?? [];
                $dataPost = [
                    'id_user' => $usuario['id'],
                    'nome_game' => $gameData['game_code'] ?? null,
                    'bet_money' => $gameData['bet'] ?? null,
                    'win_money' => $gameData['win'] ?? null,
                    'txn_id' => $gameData['txn_id'] ?? null,
                    'created_at' => formatDate($gameData['created_at']) ?? null,
                    'status_play' => 1,
                ];

                //file_put_contents($logFilePath, json_encode($dataPost, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $stmtInsert = $pdo->prepare("INSERT INTO historico_play (id_user, nome_game, bet_money, win_money, txn_id, created_at, status_play) VALUES (:id_user, :nome_game, :bet_money, :win_money, :txn_id, :created_at, :status_play)");

                if ($stmtInsert->execute($dataPost)) {
                    $ganho = floatval($gameData['win'] ?? 0) - floatval($gameData['bet'] ?? 0);
                    $novosaldo = floatval($usuario['saldo']) + $ganho;


                    $stmtGanho = $pdo->prepare("UPDATE usuarios SET saldo = :saldo WHERE id = :id");
                    $stmtGanho->execute(['saldo' => $novosaldo, 'id' => $usuario['id']]);
                    file_put_contents($logFilePath, json_encode(['saldo' => $novosaldo, 'id' => $usuario['id']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    echo json_encode(['status' => 1, 'user_balance' => $novosaldo]);
                } else {
                    echo json_encode(['status' => 0, "msg" => 'DUPLICATED_REQUEST', 'user_balance' => 0]);
                }
            } else {
                echo json_encode(['status' => 0, 'msg' => 'INVALID_USER', 'user_balance' => 0]);
            }
            break;

        default:
            echo json_encode(['status' => 0, "msg" => 'DUPLICATED_REQUEST', 'user_balance' => 0]);
            break;
    }
}

// Chama a função webhook
webhook();

function createUser($id, $code, $token)
{
    global $pdo;

    $user = [
        "method" => "user_create",
        "agent_code" => $code,
        "agent_token" => $token,
        "user_code" => $id,
    ];

    // Exemplo de inserção no banco de dados (não especificado no escopo original)
    // Aqui precisaria ajustar de acordo com a tabela e dados reais
    $insert = $pdo->prepare("INSERT INTO usuarios (id, agent_code, agent_token) VALUES (:user_code, :agent_code, :agent_token)");

    $insert->execute($user);
}

function formatDate($date)
{
    $data = new DateTime($date);

    // Define o fuso horário UTC (opcional, mas garante que o "Z" seja tratado corretamente)
    $data->setTimezone(new DateTimeZone('UTC'));

    // Formata a data para o formato desejado
    $dataFormatada = $data->format('Y-m-d H:i:s');

    return $dataFormatada;
}
