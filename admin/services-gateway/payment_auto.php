<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
include_once('../services/database.php');
include_once('../services/funcao.php');
include_once('../services/crud.php');

function logSaque($message) {
    error_log("[SAQUE AUTO] " . $message);
}

function validaCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
    if (strlen($cpf) != 11) return false;
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

function identificarTipoChavePix($chavepix) {
    if (preg_match('/^\d{11}$/', $chavepix)) {
        if (validaCPF($chavepix)) return 'CPF';
        return 'PHONE';
    }
    if (preg_match('/^\d{14}$/', $chavepix)) return 'CNPJ';
    if (filter_var($chavepix, FILTER_VALIDATE_EMAIL)) return 'EMAIL';
    if (preg_match('/^[0-9a-f]{32}$/i', $chavepix)) return 'EVP';
    return 'INVALID';
}

$qry = "SELECT * FROM config WHERE id=1";
$res = $mysqli->query($qry);
$data = $res->fetch_assoc();
logSaque("Configurações carregadas: saque_automatico={$data['saque_automatico']}");

$sqlExpfyPay = "SELECT * FROM expfypay WHERE id = 1 AND ativo = 1";
$resultExpfyPay = $mysqli->query($sqlExpfyPay);
if ($resultExpfyPay && $resultExpfyPay->num_rows > 0) {
    $expfyPayCred = $resultExpfyPay->fetch_assoc();
    $publicKey  = $expfyPayCred['client_id'];
    $secretKey  = $expfyPayCred['client_secret'];
    $urlExpfyPay = rtrim($expfyPayCred['url'], '/') . '/api/v1/withdrawls';
    logSaque("Credenciais ExpfyPay carregadas. URL: $urlExpfyPay");

    $chavepix1 = $_POST['chavepix'] ?? '';
    $valor = floatval($_POST['valor'] ?? 0);
    $id = $_POST['id'] ?? '';
    logSaque("Dados recebidos - ChavePix: $chavepix1, Valor: $valor, ID: $id");

    $mobile = $_POST['mobile'] ?? '';
    if (!$mobile) {
        logSaque("Mobile do usuário não informado.");
        die("Usuário não autenticado.");
    }
    $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $resultUser = $stmt->get_result();
    $userData = $resultUser->fetch_assoc();
    if (!$userData) {
        logSaque("Usuário com mobile $mobile não encontrado.");
        die("Usuário não autenticado.");
    }
    $user_id = $userData['id'];
    $saldo = $userData['saldo'] ?? 0;
    logSaque("Informações do usuário (via mobile) - UserID: $user_id, Saldo: $saldo");

    if (!$chavepix1 || $valor <= 0) {
        logSaque("Chave Pix ou valor inválidos.");
        die("Chave Pix ou valor inválidos.");
    }

    if ($valor > $data['saque_automatico']) {
        logSaque("Valor de saque ($valor) excede o limite automático ({$data['saque_automatico']}). Saque pendente para aprovação manual.");
        die("O valor excede o limite do saque automático. Seu saque ficará pendente para aprovação manual.");
    } else {
        logSaque("Valor de saque ($valor) está dentro do limite automático ({$data['saque_automatico']}). Processando automaticamente.");
    }

    /*if ($valor > $saldo) {
        logSaque("Saldo insuficiente. Saldo atual: $saldo, Valor solicitado: $valor.");
        die("Saldo insuficiente para concluir o saque.");
    }*/

    $filename = 'used_ids.json';
    $used_ids = [];
    if (file_exists($filename)) {
        $file_content = file_get_contents($filename);
        if ($file_content) {
            $used_ids = json_decode($file_content, true);
        }
    }
    if (in_array($id, $used_ids)) {
        logSaque("Anti-fraude acionado: ID $id já foi utilizado.");
        die("Anti-fraude acionado: Este ID já foi usado.");
    }
    if (!empty($id)) {
        $used_ids[] = $id;
        file_put_contents($filename, json_encode($used_ids, JSON_PRETTY_PRINT));
        logSaque("ID $id registrado para anti-fraude.");
    } else {
        logSaque("ID inválido recebido.");
        die("ID inválido.");
    }

    $pixKeyType = identificarTipoChavePix($chavepix1);
    if ($pixKeyType === 'INVALID') {
        logSaque("Tipo de chave Pix inválida: $chavepix1");
        die("Tipo de chave Pix inválida para ExpfyPay.");
    }
    logSaque("Tipo de chave Pix identificado: $pixKeyType");

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $url_base = $scheme . "://" . $_SERVER['HTTP_HOST'];
    $callback_url = $url_base . '/gateway/expfypay.php';
    $external_id = $id . '_' . time();

    $payload = [
        "amount"       => (float) $valor,
        "pix_key"      => $chavepix1,
        "pix_key_type" => $pixKeyType,
        "description"  => "Saque automático",
        "callback_url" => $callback_url,
        "external_id"  => $external_id
    ];
    $jsonPayload = json_encode($payload);
    logSaque("Payload preparado para ExpfyPay: $jsonPayload");

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => $urlExpfyPay,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => $jsonPayload,
        CURLOPT_HTTPHEADER     => [
            'X-Public-Key: ' . $publicKey,
            'X-Secret-Key: ' . $secretKey,
            'Content-Type: application/json'
        ],
    ]);
    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    curl_close($curl);
    if ($curl_error) {
        logSaque("Erro cURL ao contatar ExpfyPay: $curl_error");
        die("Erro na comunicação com a ExpfyPay: " . $curl_error);
    }
    logSaque("Resposta recebida da ExpfyPay: $response");

    $responseJson = json_decode($response, true);
    $responseSuccess = $responseJson['success'] ?? false;
    $message_gateway = $responseJson['message'] ?? '(sem mensagem)';
    $withdrawal_id   = $responseJson['data']['withdrawal_id'] ?? null;
    if ($responseSuccess === true && $withdrawal_id) {
        logSaque("Saque automático processado com sucesso. Withdrawal ID: $withdrawal_id");
        die("Pagamento realizado com sucesso (ExpfyPay). ID: $withdrawal_id");
    } else {
        logSaque("Erro ao processar saque via ExpfyPay: $message_gateway");
        die("Erro ao processar o saque via ExpfyPay: $message_gateway");
    }
} else {
    logSaque("Credenciais da ExpfyPay não encontradas no banco de dados.");
    echo "Credenciais da ExpfyPay não encontradas no banco de dados.";
    exit;
}
?>
