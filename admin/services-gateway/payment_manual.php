<?php
// Configuração de erros (desative display_errors em produção)
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();

include_once('../services/database.php');
include_once('../services/funcao.php');
include_once('../services/crud.php');

global $mysqli, $data_expfypay, $url_base;

/**
 * Função para validar CPF (já existente)
 */
function validaCPF($cpf){
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++){
        for ($d = 0, $c = 0; $c < $t; $c++){
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d){
            return false;
        }
    }
    return true;
}

/**
 * Função para determinar o tipo de chave PIX
 */
function identificarTipoChavePix($chavepix)
{
    if (preg_match('/^\d{10,11}$/', $chavepix)) {
        if(validaCPF($chavepix)){
            return 'document';
        }
        return 'phoneNumber';
    } elseif (preg_match('/^\d{11}$/', $chavepix)) {
        return 'document';
    } elseif (preg_match('/^\d{14}$/', $chavepix)) {
        return 'document';
    } elseif (filter_var($chavepix, FILTER_VALIDATE_EMAIL)) {
        return 'email';
    } elseif (preg_match('/^[0-9a-f]{32}$/i', $chavepix)) {
        return 'randomKey';
    } else {
        return 'invalid';
    }
}

// Recupera os dados da solicitação de saque
if (isset($_GET['id'])) {
    $id = PHP_SEGURO($_GET['id']);

    $sql = "SELECT valor, pix FROM solicitacao_saques WHERE transacao_id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($valor, $chavepix);
        $stmt->fetch();
        $stmt->close();

        if ($valor && $chavepix) {
            // Formata o valor e identifica o tipo da chave PIX
            $valor = number_format($valor, 2, '.', '');
            $tipoChave = identificarTipoChavePix($chavepix);
            
            if ($tipoChave === 'invalid') {
                echo json_encode(["success" => false, "message" => "Chave PIX inválida."]);
                exit;
            }
            
            // Mapeia o retorno para os valores esperados pela ExpfyPay
            switch($tipoChave) {
                case 'document':
                    $pix_key_type = 'CPF';
                    break;
                case 'phoneNumber':
                    $pix_key_type = 'PHONE';
                    break;
                case 'email':
                    $pix_key_type = 'EMAIL';
                    break;
                case 'randomKey':
                    $pix_key_type = 'EVP';
                    break;
                default:
                    echo json_encode(["success" => false, "message" => "Tipo de chave PIX não identificado."]);
                    exit;
            }

            $external_id = $id . '_' . time();
            $callback_url = $url_base . '/gateway/expfypay.php';

            $payload = json_encode([
                "amount"       => (float) $valor,
                "pix_key"      => $chavepix,
                "pix_key_type" => $pix_key_type,
                "description"  => "Saque via ExpfyPay",
                "callback_url" => $callback_url,
                "external_id"  => $external_id
            ]);
            
            $urlExpfyPay = rtrim($data_expfypay['url'], '/') . '/api/v1/withdrawls';

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $urlExpfyPay,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => [
                    'X-Public-Key: ' . $data_expfypay['client_id'],
                    'X-Secret-Key: ' . $data_expfypay['client_secret'],
                    'Content-Type: application/json'
                ],
            ]);
            
            $response = curl_exec($curl);
            $curl_error = curl_error($curl);
            curl_close($curl);
            
            if ($curl_error) {
                echo json_encode(["success" => false, "message" => "Erro na comunicação com a ExpfyPay: " . $curl_error]);
                exit;
            }
            
            $responsejson = json_decode($response, true);
            $response_gateway = $responsejson['success'] ?? false;
            $message_gateway = $responsejson['message'] ?? '';
            $withdrawal_id   = $responsejson['data']['withdrawal_id'] ?? '';

            if (empty($message_gateway)) {
                $message_gateway = "Erro desconhecido. Resposta completa: " . $response;
            }
            
            if ($response_gateway === true && !empty($withdrawal_id)) {
                // Atualiza o status da solicitação de saque sem deduzir novamente o saldo,
                // pois o valor já foi descontado no momento da solicitação.
                $sql_update = "UPDATE solicitacao_saques SET status = 1, transaction_id_gateway = ? WHERE transacao_id = ?";
                if ($stmt_update = $mysqli->prepare($sql_update)) {
                    $stmt_update->bind_param("ss", $withdrawal_id, $id);
                    $stmt_update->execute();

                    if ($stmt_update->affected_rows > 0) {
                        echo json_encode([
                            "success" => true, 
                            "message" => "Saque aprovado com sucesso.", 
                            "transaction_id_gateway" => $withdrawal_id
                        ]);
                        exit;
                    } else {
                        echo json_encode(["success" => false, "message" => "Erro ao atualizar o status do saque no banco de dados."]);
                        exit;
                    }
                    $stmt_update->close();
                } else {
                    echo json_encode(["success" => false, "message" => "Erro ao preparar a query de atualização."]);
                    exit;
                }
            } else {
                echo json_encode(["success" => false, "message" => "Erro do gateway: " . $message_gateway]);
                exit;
            }
            
        } else {
            echo json_encode(["success" => false, "message" => "Saque não encontrado ou parâmetros inválidos."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao preparar a query para buscar solicitação de saque."]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "message" => "Erro: ID não informado."]);
    exit;
}
?>
