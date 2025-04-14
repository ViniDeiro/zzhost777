<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../admin/services/funcao.php');
include_once('../admin/services/crud.php');

function calcularSaldoEsperado($usuario_id) {
    global $mysqli;
    
    // Busca o saldo atual do usuário no momento da requisição
    $stmt = mysqli_prepare($mysqli, "SELECT saldo FROM usuarios WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dados = mysqli_fetch_assoc($result);
    
    // Se não encontrar o usuário ou saldo, retorna 0
    if (!$dados) {
        error_log("Erro: Usuário não encontrado para o ID $usuario_id.");
        return 0;
    }

    $saldo_atual = $dados['saldo'];
    error_log("Saldo atual do usuário $usuario_id: $saldo_atual");

    // Calcula o saldo esperado baseado no histórico de transações
    $stmt = mysqli_prepare($mysqli, 
        "SELECT COALESCE(SUM(win_money - bet_money), 0) as total_ganhos 
         FROM historico_play 
         WHERE id_user = ? AND status_play = 1"
    );
    mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dados = mysqli_fetch_assoc($result);

    $total_ganhos = $dados['total_ganhos'];
    error_log("Total de ganhos calculados para o usuário $usuario_id: $total_ganhos");

    // Retorna o saldo esperado (saldo atual + total de ganhos)
    $saldo_esperado = $saldo_atual + $total_ganhos;
    error_log("Saldo esperado para o usuário $usuario_id: $saldo_esperado");

    return $saldo_esperado;
}


function webhook($data)
{
    global $mysqli;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['msg' => 'error404']);
        error_log("Requisição não POST recebida, retornando erro 404.");
        return;
    }

    error_log("Requisição POST recebida.");

    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    error_log("Dados recebidos: " . print_r($data, true));

    // Dentro do bloco onde o saldo é verificado e atualizado
    if ($data['method'] === 'user_balance' && !empty($data['user_code'])) {
        $stmtUsr = mysqli_prepare($mysqli, "SELECT * FROM usuarios WHERE mobile = ?");
        mysqli_stmt_bind_param($stmtUsr, 's', $data['user_code']);
        mysqli_stmt_execute($stmtUsr);
        $result = mysqli_stmt_get_result($stmtUsr);
        $usuario = mysqli_fetch_assoc($result);
    
        if (!$usuario) {
            // Resposta com erro de usuário não encontrado
            echo json_encode([
                'status' => 0,
                'message' => 'INVALID_USER',
                'user_balance' => 0
            ]);
            return;
        }
    
        // Processando o saldo do usuário
        error_log("Processando saldo do usuário: " . $data['user_code']);
    
        // Recuperando o saldo atual do usuário
        $saldo_atual = $usuario['saldo'];
        error_log("Saldo atual do usuário {$usuario['id']}: {$saldo_atual}");
    
        // Calcula o saldo esperado (aqui o saldo será igual ao saldo atual, pois não há histórico)
        $saldo_esperado = $saldo_atual; // No caso de saldo inicial como saldo atual
    
        error_log("Saldo esperado para o usuário {$usuario['id']}: {$saldo_esperado}");
    
        // Verifica se há discrepância entre o saldo atual e o esperado
        if (abs($saldo_atual - $saldo_esperado) > 0.01) {
            // Se houver discrepância, atualiza para o saldo esperado
            $stmtUpdate = mysqli_prepare($mysqli, "UPDATE usuarios SET saldo = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmtUpdate, 'di', $saldo_esperado, $usuario['id']);
            mysqli_stmt_execute($stmtUpdate);
    
            // Retorna a resposta no formato JSON
            $response = [
                'status' => 1,
                'user_balance' => floatval($saldo_esperado)
            ];
        } else {
            // Retorna a resposta sem atualizações, pois o saldo está correto
            $response = [
                'status' => 1,
                'user_balance' => floatval($saldo_atual)
            ];
        }
    
        echo json_encode($response);
        return; // Adicionando o return para evitar que o código continue após enviar a resposta.
    } 

    // Processa o tipo WinBet
    elseif ($data['method'] === 'transaction' && !empty($data['user_code'])) {
        error_log("Processando transação para o usuário: " . $data['user_code']);
    
        $stmtUsr = mysqli_prepare($mysqli, "SELECT * FROM usuarios WHERE mobile = ?");
        mysqli_stmt_bind_param($stmtUsr, 's', $data['user_code']);
        mysqli_stmt_execute($stmtUsr);
        $result = mysqli_stmt_get_result($stmtUsr);
        $usuario = mysqli_fetch_assoc($result);
    
        if ($usuario) {
            $dataPost = [
                'id_user' => $usuario['id'],
                'nome_game' => $data['slot']['game_code'] ?? null,  // Acessando game_code dentro de 'slot'
                'bet_money' => $data['slot']['bet_money'] ?? null,  // Acessando bet_money dentro de 'slot'
                'win_money' => $data['slot']['win_money'] ?? null,  // Acessando win_money dentro de 'slot'
                'txn_id' => $data['slot']['txn_id'] ?? null,  // Acessando txn_id dentro de 'slot'
                'created_at' => $data['slot']['created_at'] ?? null,  // Acessando created_at dentro de 'slot'
                'status_play' => 1,  // Status da transação (assumido como 1)
            ];
    
            error_log("Inserindo dados da transação no histórico de jogo: " . print_r($dataPost, true));
    
            $stmtInsert = mysqli_prepare($mysqli, "INSERT INTO historico_play (id_user, nome_game, bet_money, win_money, txn_id, created_at, status_play) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtInsert, 'issdssi', $dataPost['id_user'], $dataPost['nome_game'], $dataPost['bet_money'], $dataPost['win_money'], $dataPost['txn_id'], $dataPost['created_at'], $dataPost['status_play']);
    
            mysqli_begin_transaction($mysqli);
            try {
                if (mysqli_stmt_execute($stmtInsert)) {
                    // Calcula ganho/perda da aposta atual
                    $ganho = $data['slot']['win_money'] - $data['slot']['bet_money'];  // Acesso correto aos valores de 'slot'
                    $novosaldo = $usuario['saldo'] + $ganho;
    
                    error_log("Novo saldo calculado: $novosaldo");
    
                    // Verifica se o novo saldo seria negativo
                    if ($novosaldo < 0) {
                        throw new Exception("Saldo insuficiente após o ganho/perda.");
                    }
    
                    // Atualiza o saldo do usuário
                    $stmtGanho = mysqli_prepare($mysqli, "UPDATE usuarios SET saldo = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmtGanho, 'di', $novosaldo, $usuario['id']);
                    mysqli_stmt_execute($stmtGanho);
    
                    // Commit da transação se tudo ocorrer sem erros
                    mysqli_commit($mysqli);
    
                    echo json_encode(['msg' => 'SUCCESS', 'balance' => $novosaldo]);
                    error_log("Transação processada com sucesso. Novo saldo: $novosaldo");
                } else {
                    throw new Exception('Erro ao registrar histórico da aposta.');
                }
            } catch (Exception $e) {
                // Rollback da transação em caso de erro
                mysqli_rollBack($mysqli);
                echo json_encode(['msg' => 'ERROR', 'error' => $e->getMessage()]);
                error_log("Erro ao processar transação: " . $e->getMessage());
            }
        } else {
            echo json_encode(['msg' => 'INVALID_USER', 'balance' => 0]);
            error_log("Usuário não encontrado: " . $data['user_code']);
        }
    } else {
        echo json_encode(['msg' => 'INVALID_TYPE']);
        error_log("Tipo de método inválido ou dados ausentes.");
    }
}

// Chamada da função webhook
webhook($_POST);

?>
