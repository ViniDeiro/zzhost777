<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
parse_str(file_get_contents("php://input"), $data);
date_default_timezone_set('America/Sao_Paulo');
include_once('logger.php');

// Verificar se o JSON foi decodificado com sucesso
#if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
if ($data === null) {
    // Erro ao decodificar o JSON
    #http_response_code(400); // Bad Request
    //echo json_encode(array('error' => 'Erro na decodificação do JSON.'));
    #exit;
}
#=================================================================================================#
include_once "./../../admin/services/database.php";
include_once "./../../admin/services/funcao.php";
include_once "./../../admin/services/crud.php";
#=================================================================================================#
#CRIANDO AS ROTAS POST PARA API
#=================================================================================================#
#variaveis que pode trocar
$telegram_link = "https://t.me/#";
#=================================================================================================#

#CRIAR ROTA DE PAYMENT PIXCODE SUITPAY
function generateQRCode($data)
{
    // Carregue a biblioteca PHP QR Code
    require_once 'phpqrcode/qrlib.php';
    // Caminho onde você deseja salvar o arquivo PNG do QRCode (opcional)
    $file = './../../uploads/qrcode.png';
    // Gere o QRCode
    QRcode::png($data, $file);
    // Carregue o arquivo PNG do QRCode
    $qrCodeImage = file_get_contents($file);
    // Converta a imagem para base64
    $base64QRCode = base64_encode($qrCodeImage);
    return $base64QRCode;
}
function insert_payment($insert)
{
    global $mysqli;

    $sql = $mysqli->prepare("INSERT INTO transacoes 
        (transacao_id, usuario, valor, tipo, data_hora, qrcode, code, status, comissao, afiliado_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $sql->bind_param(
        "sssssssssd", // d = double (comissão), s = string, i = inteiro
        $insert['transacao_id'],
        $insert['usuario'],
        $insert['valor'],
        $insert['tipo'],
        $insert['data_hora'],
        $insert['qrcode'],
        $insert['code'],
        $insert['status'],
        $insert['comissao'],
        $insert['afiliado_id']
    );

    if ($sql->execute()) {
        return 1;
    } else {
        error_log("[INSERT_PAYMENT] Erro: " . $sql->error); // log de erro se falhar
        return 0;
    }
}


function update_real_name($id, $real_name)
{
    global $mysqli;
    $sql = $mysqli->prepare("UPDATE usuarios SET real_name = ? WHERE id = ?");
    $sql->bind_param("si", $real_name, $id); // "si" significa string e integer
    if ($sql->execute()) {
        return 1; // Sucesso
    } else {
        return 0; // Falha
    }
}
function update_payment_method($user_id, $realname, $pix_id, $flag = 1, $pix_account = null, $state = 1)
{
    global $mysqli;
    $count = 0;

    $sql_check = $mysqli->prepare("SELECT COUNT(*) FROM metodos_pagamentos WHERE user_id = ? AND pix_id = ? AND state = ?");
    $sql_check->bind_param("isi", $user_id, $pix_id, $state);
    $sql_check->execute();
    $sql_check->bind_result($count);
    $sql_check->fetch();
    $sql_check->close();

    if ($count > 0) {
        return 0;
    }

    $sql_insert = $mysqli->prepare("INSERT INTO metodos_pagamentos (user_id, realname, pix_id, flag, pix_account, state) VALUES (?, ?, ?, ?, ?, ?)");
    $sql_insert->bind_param("isssii", $user_id, $realname, $pix_id, $flag, $pix_account, $state);

    if ($sql_insert->execute()) {
        return 1;
    } else {
        return 0;
    }
}

function generateUniqueId()
{
    return uniqid();
}
function mod($dividendo, $divisor)
{
    return round($dividendo - (floor($dividendo / $divisor) * $divisor));
}

/**
 * Método para gerar CPF válido, com máscara ou não
 * @example cpfRandom(0)
 *          para retornar CPF sem máscar
 * @param int $mascara
 * @return string
 */
function cpfRandom($mascara = "1")
{
    $n1 = rand(0, 9);
    $n2 = rand(0, 9);
    $n3 = rand(0, 9);
    $n4 = rand(0, 9);
    $n5 = rand(0, 9);
    $n6 = rand(0, 9);
    $n7 = rand(0, 9);
    $n8 = rand(0, 9);
    $n9 = rand(0, 9);
    $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
    $d1 = 11 - (mod($d1, 11));
    if ($d1 >= 10) {
        $d1 = 0;
    }
    $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
    $d2 = 11 - (mod($d2, 11));
    if ($d2 >= 10) {
        $d2 = 0;
    }
    $retorno = '';
    if ($mascara == 1) {
        $retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
    } else {
        $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
    }
    return $retorno;
}

function criarQrCode($valor, $nome, $id)
{
    global $data_bspay, $url_base;
    $transacao_id = 'SP' . rand(0, 999) . '-' . date('YMDHms');
    // Pega a data de hoje
    $dataDeHoje = new DateTime();
    // Adiciona um dia
    $dataDeAmanha = $dataDeHoje->modify('+1 day');
    // Formata a data para exibição
    $dataFormatada = $dataDeAmanha->format('Y-m-d');
    #===============================================#
    $arraypix = array("057.033.734-84", "078.557.864-14", "094.977.774-93", "033.734.824-37", "091.665.934-84", "081.299.854-54", "086.861.364-94", "033.727.064-39");
    $randomKey = array_rand($arraypix);


    //CPF ANTIGO
    //$cpf = $arraypix[$randomKey];

    $cpf = cpfRandom(1);
    #===============================================#
    $arrayemail = array("asd4_yasmin@gmail.com", "asd4_6549498@gmail.com", "asd43_5874@gmail.com", "asd14_652549498@gmail.com", "asf5_654489498@gmail.com", "asd4_659749498@gmail.com", "asd458_78@bol.com", "ab11_2589@gmail.com");
    $randomKeyemail = array_rand($arrayemail);
    $email = $arrayemail[$randomKeyemail];
    $usuario_pixup = ""; // SE QUISER COLOCAR SPLIT, COLOCA O USUARIO AQUI!!
    #===============================================#

    $bearer = base64_encode($data_bspay['client_id'] . ':' . $data_bspay['client_secret']);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $data_bspay['url'] . '/v2/oauth/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Basic ' . $bearer
        ),
    ));

    $bearerResponse = curl_exec($curl);
    $bearerToken = json_decode($bearerResponse)->access_token;
    curl_close($curl);

    //die(var_dump($bearerResponse));
    $url2 = $url_base;
    $url = $data_bspay['url'] . '/v2/pix/qrcode';
    $data = array(
        'amount' => $valor,
        "external_id" => $transacao_id,
        'postbackUrl' => $url_base . 'gateway/bspay',
        'payer' => array(
            'name' => !empty($nome) ? $nome : 'Matheus',
            'document' => preg_replace("/[^0-9]/", "", $cpf),
            "email" => $email,
        ),
//          'split' => array( array('username' => $usuario_pixup, 'percentageSplit' => "15",))
    );

    $header = array(
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    );

    $response = enviarRequest_PAYMENT($url, $header, $data);

    //die(var_dump($response));

    $dados = json_decode($response, true);

    $datapixreturn = [];

    if (isset($dados['transactionId'])) {
        // Remover espaços da string paymentCodeBase64
        $paymentCodeBase64 = preg_replace('/\s+/', '', generateQRCode($dados['qrcode']));
        // Codificar para URL
        $paymentCodeBase64Encoded = urlencode($paymentCodeBase64);
        // Log para depuração
        //error_log("paymentCodeBase64 Gerado: " . $paymentCodeBase64);
        //error_log("paymentCodeBase64 Codificado: " . $paymentCodeBase64Encoded);
        $insert = array(
            'transacao_id' => $dados['transactionId'],
            'usuario' => $id,
            'valor' => $valor,
            'tipo' => 'deposito',
            'data_hora' => date('Y-m-d H:i:s'),
            'qrcode' => $paymentCodeBase64,
            'status' => 'processamento',
            'code' => $dados['transactionId'],
        );
        //insert transação
        $insert_paymentBD = insert_payment($insert);
        if ($insert_paymentBD == 1) {
            $datapixreturn = array(
                'code' => $dados['qrcode'],
                'qrcode' => $paymentCodeBase64Encoded,
                'amount' => $valor,
            );
        } else {
            $datapixreturn = array(
                'code' => null,
                'qrcode' => null,
                'amount' => null,
            );
        }
    }

    WebhookPixGerado($nome, $url2, $valor);
    return $datapixreturn;
}


function expfypayAuth()
{
    global $data_expfypay;
    

    return [
        'public_key' => $data_expfypay['client_id'],
        'secret_key' => $data_expfypay['client_secret']
    ];
}

/**
 * Gera um QR Code PIX utilizando a API da ExpfyPay.
 *
 * @param float  $valor Valor do pagamento.
 * @param string $nome  Nome do cliente.
 * @param mixed  $id    ID do usuário em seu sistema.
 * @param float|null $comissao Valor da comissão (opcional)
 * @param int|null   $afiliado_id ID do afiliado (opcional)
 *
 * @return array 
 */
function criarQrexpfypay($valor, $nome, $id, $comissao = null, $afiliado_id = null)
{
    global $data_expfypay, $url_base;

    $auth = expfypayAuth();
    $url = rtrim($data_expfypay['url'], '/') . '/api/v1/payments';
    $order_id = rand(11111, 99999);

    $arrayemail = [
        "asd4_yasmin@gmail.com",
        "asd4_6549498@gmail.com",
        "asd43_5874@gmail.com",
        "asd14_652549498@gmail.com",
        "asf5_654489498@gmail.com",
        "asd4_659749498@gmail.com",
        "asd458_78@bol.com",
        "ab11_2589@gmail.com"
    ];
    $email = $arrayemail[array_rand($arrayemail)];

    $payload = [
        "amount"      => (float) $valor,
        "description" => "Depósito " . $order_id,
        "customer"    => [
            "name"     => $nome,
            "document" => cpfRandom(0),
            "email"    => $email
        ],
        "external_id" => (string) $order_id,
        "callback_url"=> $url_base . '/gateway/expfypay'
    ];

    $payloadJson = json_encode($payload);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payloadJson,
        CURLOPT_HTTPHEADER => [
            'X-Public-Key: ' . $auth['public_key'],
            'X-Secret-Key: ' . $auth['secret_key'],
            'Content-Type: application/json'
        ],
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        curl_close($curl);
        error_log("[EXPFYPAY] CURL error: " . curl_error($curl));
        return [];
    }
    curl_close($curl);

    $dados = json_decode($response, true);
    error_log("[EXPFYPAY] Resposta da API: " . print_r($dados, true));

    $datapixreturn = [];

    if (isset($dados['success']) && $dados['success'] === true && isset($dados['data']['transaction_id'])) {
        $transaction_id = $dados['data']['transaction_id'];
        $qr_code        = $dados['data']['qr_code'];
        $qr_code_image  = $dados['data']['qr_code_image'];

        $apiStatus = strtolower(trim($dados['data']['status']));
        $status = ($apiStatus === 'completed') ? 'confirmado' : 'processamento';

        $insert = [
            'transacao_id' => $transaction_id,
            'usuario'      => $id,
            'valor'        => $valor,
            'tipo'         => 'deposito',
            'data_hora'    => date('Y-m-d H:i:s'),
            'qrcode'       => $qr_code,
            'status'       => $status,
            'external_id'  => $dados['data']['external_id'] ?? $order_id,
            'code'         => $qr_code,
            'comissao'     => $comissao,
            'afiliado_id'  => $afiliado_id
        ];

        error_log("[INSERT] Dados para salvar: " . print_r($insert, true));

        $insert_paymentBD = insert_payment($insert);
        if ($insert_paymentBD == 1) {
            error_log("[INSERT] Sucesso ao inserir a transação.");
            $datapixreturn = [
                'transaction_id' => $transaction_id,
                'external_id'    => $dados['data']['external_id'] ?? $order_id,
                'qrcode'         => urlencode($qr_code),
                'qr_code_image'  => $qr_code_image,
                'amount'         => $dados['data']['amount'],
                'status'         => $status,
                'code'           => $qr_code
            ];
        } else {
            error_log("[INSERT] Falha ao inserir transação no banco.");
        }
    }

    WebhookPixGerado($nome, $url_base, $valor);

    return $datapixreturn;
}


function criarQrCodeSuitPay($valor, $nome, $id, $realNome, $cpf)
{
    global $data_suitpay, $url_base;
    $transacao_id = 'SP' . rand(0, 999) . '-' . date('YMDHms');
    // Pega a data de hoje
    $dataDeHoje = new DateTime();
    // Adiciona um dia
    $dataDeAmanha = $dataDeHoje->modify('+1 day');
    // Formata a data para exibição
    $dataFormatada = $dataDeAmanha->format('Y-m-d');
    #===============================================#
    #MODO DE PAGAMENTO 0 SANBOX | 1 REAL
    $tipoAPI_SUITPAY = 0;
    #===============================================#
    $arrayemail = array("asd4_yasmin@gmail.com", "asd4_6549498@gmail.com", "asd43_5874@gmail.com", "asd14_652549498@gmail.com", "asf5_654489498@gmail.com", "asd4_659749498@gmail.com", "asd458_78@bol.com", "ab11_2589@gmail.com");
    $randomKeyemail = array_rand($arrayemail);
    $email = $arrayemail[$randomKeyemail];
    $usuario_split = ""; // SE QUISER COLOCAR SPLIT, COLOCA O USUARIO AQUI!!
    #===============================================#
    if ($tipoAPI_SUITPAY == 0) {
        $url2 = $url_base;
        $url = $data_suitpay['url'] . '/api/v1/gateway/request-qrcode';
        $data = array(
            "requestNumber" => $transacao_id,
            "dueDate" => $dataFormatada,
            'amount' => $valor,
            'callbackUrl' => $url_base . '/gateway/suitpay',
            'client' => array(
                'name' => !empty($realNome) ? $realNome : 'Matheus',
                'document' => preg_replace("/[^0-9]/", "", $cpf),
                "email" => $email,
            ),
//                'split' => array('username' => $usuario_split, 'percentageSplit' => 15,),
        );
        $header = array(
            'ci: ' . $data_suitpay['client_id'],
            'cs: ' . $data_suitpay['client_secret'],
            'Content-Type: application/json',
        );
    } else {
        $url = 'https://sandbox.ws.suitpay.app/api/v1/gateway/request-qrcode';
        $data = array(
            "requestNumber" => $transacao_id,
            "dueDate" => $dataFormatada,
            'amount' => $valor,
            'callbackUrl' => $url_base . '/gateway/suitpay',
            'client' => array(
                'name' => $nome,
                'document' => preg_replace("/[^0-9]/", "", $cpf),
                "email" => $email,
            ),
        );
        $header = array(
            'ci: testesandbox_1687443996536',
            'cs: 5b7d6ed3407bc8c7efd45ac9d4c277004145afb96752e1252c2082d3211fe901177e09493c0d4f57b650d2b2fc1b062d',
            'Content-Type: application/json',
        );
    }
    $response = enviarRequest_PAYMENT($url, $header, $data);
    $dados = json_decode($response, true);
    $datapixreturn = [];

    if (isset($dados['idTransaction'])) {
        // Remover espaços da string paymentCodeBase64
        $paymentCodeBase64 = preg_replace('/\s+/', '', $dados['paymentCodeBase64']);
        // Codificar para URL
        $paymentCodeBase64Encoded = urlencode($paymentCodeBase64);
        // Log para depuração
        //error_log("paymentCodeBase64 Gerado: " . $paymentCodeBase64);
        //error_log("paymentCodeBase64 Codificado: " . $paymentCodeBase64Encoded);
        $insert = array(
            'transacao_id' => $dados['idTransaction'],
            'usuario' => $id,
            'valor' => $valor,
            'tipo' => 'deposito',
            'data_hora' => date('Y-m-d H:i:s'),
            'qrcode' => $paymentCodeBase64,
            'status' => 'processamento',
            'code' => $dados['paymentCode'],
        );
        //insert transação
        $insert_paymentBD = insert_payment($insert);
        if ($insert_paymentBD == 1) {
            $datapixreturn = array(
                'code' => $dados['paymentCode'],
                'qrcode' => $paymentCodeBase64Encoded,
                'amount' => $valor,
            );
        } else {
            $datapixreturn = array(
                'code' => null,
                'qrcode' => null,
                'amount' => null,
            );
        }
    }

    WebhookPixGerado($nome, $url2, $valor);
    return $datapixreturn;
}

function pegarSaldo($usercode, $id)
{
    global $data_fiverscanpanel;
    $keys = $data_fiverscanpanel;
    $saldoreq = saldo_user($id);
    //$url = $data_fiverscanpanel['url'];
    // Dados para o corpo da requisição em formato JSON
    $data = array(
        'method' => 'money_info',
        'agent_code' => $keys['agent_code'],
        'agent_token' => $keys['agent_token'],
        'user_code' => $usercode,
    );
    $json_data = json_encode($data);
    $response = enviarRequest('https://api.payigaming.com.br/', $json_data);
    $dados = json_decode($response, true);
    if (!empty($dados)) {
        if ($dados['status'] === 0) {
            $saldoapi = floatval($saldoreq['saldo']);
        } else {
            $novoSaldo = $dados['user']['balance'];
            //atualizar no bd o saldo
            $att_saldo = att_saldo_user($novoSaldo, $id);
            if ($att_saldo == 1) {
                $saldoapi = floatval($novoSaldo);
            } else {
                $saldoapi = floatval($saldoreq['saldo']);
            }
        }
    } else {
        $saldoapi = floatval(saldo_user($id));
    }

    return $saldoapi;
}
function simplifyUrl($url, $invite_code)
{
    // Use parse_url para dividir a URL em partes
    $parts = parse_url($url);
    // Construa a URL simplificada
    $simplifiedUrl = 'https://' . $parts['host'] . '/?id=' . $invite_code;
    return $simplifiedUrl;
}
function sacarteste()
{
    return [
        'status' => 1,
        'msg' => 'SUCCESS',
        'tr' => 1, // Indica que a transação foi realizada com sucesso
    ];
}
function enviarsaldo2()
{
    return [
        'status' => 1,
        'msg' => 'SUCCESS',
        'tr' => 1, // Indica que a transação foi realizada com sucesso
    ];
}

function enviarsaldoAfiliado($mobile, $valorbau)
{
    global $mysqli;

    $qry = "UPDATE usuarios SET saldo_afiliados = saldo_afiliados + $valorbau WHERE mobile = '$mobile'";
    $qry2 = "UPDATE usuarios SET saldo = saldo + $valorbau WHERE mobile = '$mobile'";
    $resp = mysqli_query($mysqli, $qry);
    mysqli_query($mysqli, $qry2);

    if (mysqli_affected_rows($mysqli) >= 1) {
        return true;
    } else {
        return false;
    }
}


function criarUsuarioAPI2()
{
    return 1;
}

#=================================================================================================#
header('Content-Type: application/json');
#=================================================================================================#

// COISAS PARA FAZER AINDA!!!!!
// ARRUMAR A LOGICA DO BAU PARA SALVAR A QUANTIDADE DE PESSOAS E IR SOMANDO AO INVES DE SALVAR O ID

// PARTE DE REGISTRO E LOGIN E LOGOUT

// Pong
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'ping') {
    $response = [
        "status" => 'success',
        "message" => '<<< expfygaming',
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'finance/withdraw/fee?') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "",
                "tag_id" => "",
                "fmin" => 0,
                "fmax" => 20,
                "amount" => 0,
                "flags" => 1,
                "updated_name" => "",
                "updated_at" => 0,
            ],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/customer/list?flag=2') {

    // Captura o link base do site atual
    $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

    // Busca o valor de grupoplataforma no banco de dados
    $stmt = $mysqli->prepare("SELECT grupoplataforma FROM config WHERE id = 1"); // ajuste o id conforme necessário
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $grupoplataforma = $row['grupoplataforma'];

        $data = [
            [
                "float_id" => 3,
                "id" => "764031310417011114",
                "imId" => "20",
                "im" => "/image/ccf50ec6-ec6f-4e66-965d-32f6070dac10.gif",
                "name" => "telegram",
                "link" => $base_url . "/activity/recommend-friends",
                "remark" => "",
                "flag" => 2,
                "sort" => 1,
                "status" => 2,
                "method" => 0,
                "createdAt" => 1712838327,
                "updatedAt" => 1720066187,
            ],
            [
                "float_id" => 1,
                "id" => "764031310417011112",
                "imId" => "20",
                "im" => "/image/1f19575d-85e2-43ef-a6e1-84839311c8c2.png",
                "name" => "telegram",
                "link" => "https://t.me/" . $grupoplataforma,
                "remark" => "",
                "flag" => 2,
                "sort" => 1,
                "status" => 2,
                "method" => 0,
                "createdAt" => 1712838327,
                "updatedAt" => 1720066187,
            ],
            [
                "float_id" => 2,
                "id" => "150809726257797389",
                "imId" => "8",
                "im" => "/image/1709636294056..gif",
                "name" => "tlelgram",
                "link" => "https://t.me/" . $grupoplataforma,
                "remark" => "",
                "flag" => 2,
                "sort" => 1,
                "status" => 2,
                "method" => 0,
                "createdAt" => 1709636325,
                "updatedAt" => 1720066167,
            ],
        ];

        $filteredData = [];
        foreach ($data as $item) {
            $floatStmt = $mysqli->prepare("SELECT status FROM floats WHERE id = ?");
            $floatStmt->bind_param("i", $item['float_id']);
            $floatStmt->execute();
            $floatResult = $floatStmt->get_result();
            $floatRow = $floatResult->fetch_assoc();

            if ($floatRow && $floatRow['status'] == 1) {
                $filteredData[] = $item;
            }
        }

        $response = [
            "status" => true,
            "data" => $filteredData,
            "msg" => null,
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["status" => false, "msg" => "Grupo não encontrado no banco de dados."]);
    }
}


if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/favorites/save') {
    $response = [
        "status" => true,
        "data" => 1000,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/history/save') {
    $response = [
        "status" => true,
        "data" => 1000,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/favorites/remove') {
    $response = [
        "status" => true,
        "data" => 1000,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/app/upgrade?dv=36') {
    $response = [
        "status" => true,
        "data" => [
            "id" => "",
            "platform" => "ios",
            "version" => $dataconfig['versao_app_ios'],
            "is_force" => 0,
            "content" => "
        1 Otimização de campanha
        ",
            "url" => $dataconfig['link_app_ios'],
            "updated_at" => 0,
            "updated_uid" => "",
            "updated_name" => "",
            "prefix" => "",
            "model_type" => 0
        ]
    ];
    // Use JSON_UNESCAPED_UNICODE to avoid escaping Unicode characters
    $response_json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/app/upgrade?dv=35') {
    $response = [
        "status" => true,
        "data" => [
            "id" => "",
            "platform" => "android",
            "version" => $dataconfig['versao_app_android'],
            "is_force" => 0,
            "content" => "
             1 Otimização de campanha
             ",
            "url" => $dataconfig['link_app_android'],
            "updated_at" => 0,
            "updated_uid" => "",
            "updated_name" => "",
            "prefix" => "",
            "model_type" => 0
        ]
    ];
    // Use JSON_UNESCAPED_UNICODE to avoid escaping Unicode characters
    $response_json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'promo/welfare/config?') !== false) {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "122609400672191826",
                "promo_id" => "85100667711113",
                "welfare_id" => "1",
                "prefix" => "f51",
                "title" => 'Faça o download do APP, instale e faça login no aplicativo pela primeira vez',
                "uid" => "138820231",
                "username" => "expfygaming",
                "flag" => 1,
                "state" => 501,
                "limited_at" => 0,
                "expired_at" => 0,
                "receipt_at" => 1725613454,
                "remark" => "",
                "device" => "0",
                "device_ty" => "",
                "ip" => "",
                "amount" => 0.99,
                "flow_multiple" => 1,
                "created_at" => 1725613454,
                "check_deposit" => 1,
                "first_deposit_done" => 0,
            ],
            [
                "id" => "122609401349143740",
                "promo_id" => "85100667711113",
                "welfare_id" => "2",
                "prefix" => "f51",
                "title" => "Salve atalho de mesa",
                "uid" => "138820231",
                "username" => "expfygaming",
                "flag" => 1,
                "state" => 501,
                "limited_at" => 0,
                "expired_at" => 0,
                "receipt_at" => 1725613454,
                "remark" => "",
                "device" => "0",
                "device_ty" => "",
                "ip" => "",
                "amount" => 0.99,
                "flow_multiple" => 1,
                "created_at" => 1725613454,
                "check_deposit" => 0,
                "first_deposit_done" => 0,
            ],
        ],
        "msg" => null,
    ];
    // Use JSON_UNESCAPED_UNICODE to avoid escaping Unicode characters
    $response_json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $response_json;
}


if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'promo/welfare/getconf?') {
    $response = [
        "status" => true,
        "data" => [
            "entrance" => "2,1",
            "limited" => '""',
            "pick" => "1",
            "login_before" => "",
            "login_after" => "",
            "flow_multiple" => "1",
            "is_audit" => 1,
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'promo/promo/wait/pick?data[state]=502') {
    $response = [
        "status" => true,
        "data" => [
            "d" => null,
            "agg" => "0",
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/message/num?') {
    $response = [
        "status" => true,
        "data" => 0,
        "msg" => null
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/notices?') {
    $response = [
        "status" => true,
        "data" => []
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'promo/list?') {
    // Base URL automática
    $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/uploads/'; // Protocolo + Domínio + Caminho

    // Consulta SQL para pegar as promoções ativas (status = 1)
    $query = "SELECT img FROM promocoes WHERE status = 1";

    $result = $mysqli->query($query);

    // Verifica se há resultados
    if ($result->num_rows > 0) {
        $promocoes = [];

        while ($row = $result->fetch_assoc()) {
            $promocoes[] = [
                "static" => [
                    "list_web" => $base_url . $row['img'], // Adicionando a URL base para a imagem
                    "list_h5" => $base_url . $row['img'],  // Adicionando a URL base para a imagem
                    "title_web" => $base_url . $row['img'], // Adicionando a URL base para a imagem
                    "title_h5" => $base_url . $row['img'],  // Adicionando a URL base para a imagem
                    "share_h5" => "", // Removido o link de redirecionamento
                ],
                "id" => uniqid(), // ID único para cada promoção
                "title" => "Promoção ativa", // Título fixo ou pegue da tabela se necessário
                "state" => 1, // Status ativo
                "flag" => "invite", // Ajuste conforme o tipo de promoção
                "grade" => "", // Adicione os grades se necessário
                "login_af" => 0,
                "login_bf" => 0,
                "link_url" => "", // Removido o link de redirecionamento
            ];
        }

        // Preparando a resposta JSON
        $response = [
            "status" => true,
            "data" => $promocoes,
            "msg" => null,
        ];

        // Envia a resposta como JSON
        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        // Caso não encontre promoções ativas
        echo json_encode([
            "status" => false,
            "msg" => "Nenhuma promoção ativa encontrada.",
        ]);
    }
}


// Verificando se a variável 'expfygaming' está definida e não está vazia
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/webset/list?item=pop') {

    $stmt = $mysqli->prepare("SELECT id, titulo AS name, redirect_url AS link, img, status FROM popups WHERE status = 1");
    $stmt->execute();
    $result = $stmt->get_result();

    $popups = [];
    while ($row = $result->fetch_assoc()) {
        $popups[] = [
            "id" => $row['id'],
            "ty" => "",
            "name" => $row['name'],
            "portal" => ["pc", "h5", "app"],
            "img" => SITE_URL . '/uploads/' . $row['img'],
            "link" => $row['link'],
            "oper" => "",
            "sway" => 0,
            "sort" => 0,
            "state" => $row['status'],
            "op_at" => time(),
            "login_bf" => 2,
            "login_af" => 2,
            "close_today" => 0,
            "recipient_type" => 0,
            "recipient" => "",
        ];
    }

    if (!empty($popups)) {
        $response = [
            "status" => true,
            "data" => ["pop" => $popups],
            "msg" => null,
        ];
    } else {
        $response = [
            "status" => false,
            "msg" => "Nenhum popup encontrado.",
        ];
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/platform/list') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "26595015200105",
                "game_type" => 1,
                "name" => "EVO Cassino",
            ],
            [
                "id" => "26595015200115",
                "game_type" => 1,
                "name" => "DB Cassino",
            ],
            [
                "id" => "26595015200201",
                "game_type" => 2,
                "name" => "JL Pescaria",
            ],
            [
                "id" => "26595015200203",
                "game_type" => 2,
                "name" => "JDB Pescaria",
            ],
            [
                "id" => "26595015200206",
                "game_type" => 2,
                "name" => "SG Pescaria",
            ],
            [
                "id" => "26595015200210",
                "game_type" => 2,
                "name" => "JDB Pescaria",
            ],
            [
                "id" => "26595015200304",
                "game_type" => 3,
                "name" => "JDB Slots",
            ],
            [
                "id" => "26595015200305",
                "game_type" => 3,
                "name" => "PG Slots",
            ],
            [
                "id" => "26595015200306",
                "game_type" => 3,
                "name" => "JL Slots",
            ],
            [
                "id" => "26595015200309",
                "game_type" => 3,
                "name" => "SG Slots",
            ],
            [
                "id" => "26595015200310",
                "game_type" => 3,
                "name" => "PP Slots",
            ],
            [
                "id" => "26595015200313",
                "game_type" => 3,
                "name" => "PG Slots",
            ],
            [
                "id" => "26595015200314",
                "game_type" => 3,
                "name" => "ACEWIN Slots",
            ],
            [
                "id" => "26595015200315",
                "game_type" => 3,
                "name" => "CG Slots",
            ],
            [
                "id" => "26595015200316",
                "game_type" => 3,
                "name" => "CQ9 Slots",
            ],
            [
                "id" => "26595015200317",
                "game_type" => 3,
                "name" => "FC Slots",
            ],
            [
                "id" => "26595015200321",
                "game_type" => 3,
                "name" => "JDB Slots",
            ],
            [
                "id" => "26595015200329",
                "game_type" => 3,
                "name" => "WG Slots",
            ],
            [
                "id" => "26595015200407",
                "game_type" => 4,
                "name" => "DB Sport",
            ],
            [
                "id" => "26595015200503",
                "game_type" => 5,
                "name" => "JL Cartas",
            ],
            [
                "id" => "26595015200505",
                "game_type" => 5,
                "name" => "JDB Cartas",
            ],
            [
                "id" => "26595015200511",
                "game_type" => 5,
                "name" => "JDB Cartas",
            ],
            [
                "id" => "26595015200604",
                "game_type" => 6,
                "name" => "DB Esport",
            ],
            [
                "id" => "26595015200702",
                "game_type" => 7,
                "name" => "DB Loteria",
            ],
            [
                "id" => "26595015200902",
                "game_type" => 9,
                "name" => "JDB Blockchain",
            ],
                        [
                "id" => "26595015200910",
                "game_type" => 3,
                "name" => "HACKSAW",
            ],
            [
                "id" => "26595015200905",
                "game_type" => 9,
                "name" => "JDB Blockchain",
            ],
            [
                "id" => "26595015200999",
                "game_type" => 3,
                "name" => "Jelly",
            ],
            [
                "id" => "26595315200999",
                "game_type" => 3,
                "name" => "BGaming",
            ],
            [
                "id" => "26495315200999",
                "game_type" => 3,
                "name" => "JILI",
            ],
                        [
                "id" => "16595315200999",
                "game_type" => 3,
                "name" => "DreamTech",
            ],
            
            
            
            
            
            
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

// Verificar se a requisição está correta
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'promo/list/sort?') {

    // Consulta SQL para buscar as promoções ativas
    $sql = "SELECT img AS banner, status FROM promocoes WHERE status = 1";
    $result = $mysqli->query($sql);

    // Verifica se encontrou resultados
    if ($result->num_rows > 0) {
        // Estrutura de resposta JSON
        $response = [
            "status" => true,
            "data" => []
        ];

        // Processa cada promoção e adiciona ao array de resposta
        while ($promo = $result->fetch_assoc()) {
            $response["data"][] = [
                "static" => [
                    "list_web" => $promo['banner'],
                    "list_h5" => $promo['banner'],
                    //                    "share_h5" => $promo['link_url']
                ],
                "id" => uniqid(), // Gera um ID único temporário para cada item
                "state" => $promo['status'],
                "flag" => "static",
                "grade" => "1001,1002,1003", // Coloque a grade conforme necessário
                "login_af" => 0,
                "login_bf" => 0
            ];
        }

        // Retorna o JSON com os dados das promoções
        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        // Caso não encontre nenhuma promoção ativa
        echo json_encode(["status" => false, "message" => "Nenhuma promoção ativa encontrada."]);
    }
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/vip/config?') {
    $vip_level = mysqli_query($mysqli, "SELECT * FROM vip_levels")->fetch_all();

    $levels = [];

    $indice = 1;
    foreach ($vip_level as $v) {
        if(isset($v[1]) && isset($v[2]) && isset($v[3])){
            $levels[] = [
                "id" => $indice,
                "level" => $v[1],
                "level_name" => "VIP" . $v[1], //NOME DO LEVEL
                "recharge_num" => 0,
                "upgrade_deposit" => 0,
                "upgrade_record" => $v[2], //VALOR PARA APOSTAR
                "relegation_flowing" => 0,
                "upgrade_gift" => $v[3], //VALOR DO BONUS
                "birth_gift" => 0,
                "withdraw_count" => 10,
                "withdraw_max" => 1000000,
                "early_month_packet" => 0,
                "late_month_packet" => 0,
                "created_at" => 0,
                "updated_at" => 1717205463,
                "user_count" => 195,
                "remark" => "",
                "flow_multiple" => 1,
            ];
    
            //$requisitos_niveis[$indice] = $v[2];
            //$bonus_niveis[$indice] = $v[3];
            $indice++;
        }
    }

    $response = [
        "status" => true,
        "data" => $levels,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/rebate/config?') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => 3117973535451604,
                "game_type" => 3,
                "bet_amount" => 0,
                "rebate_amount" => 0.1,
                "ty" => 1,
            ],
            [
                "id" => 3118183146219625,
                "game_type" => 3,
                "bet_amount" => 1,
                "rebate_amount" => 0.15,
                "ty" => 1,
            ],
            [
                "id" => 3118402711650122,
                "game_type" => 3,
                "bet_amount" => 5,
                "rebate_amount" => 0.18,
                "ty" => 1,
            ],
            [
                "id" => 3118603221577640,
                "game_type" => 3,
                "bet_amount" => 10,
                "rebate_amount" => 0.2,
                "ty" => 1,
            ],
            [
                "id" => 3118811288439380,
                "game_type" => 3,
                "bet_amount" => 50,
                "rebate_amount" => 0.3,
                "ty" => 1,
            ],
            [
                "id" => 3119007217308780,
                "game_type" => 3,
                "bet_amount" => 100,
                "rebate_amount" => 0.4,
                "ty" => 1,
            ],
            [
                "id" => 3119159847745440,
                "game_type" => 3,
                "bet_amount" => 200,
                "rebate_amount" => 0.6,
                "ty" => 1,
            ],
            [
                "id" => 3119305445801466,
                "game_type" => 3,
                "bet_amount" => 500,
                "rebate_amount" => 1,
                "ty" => 1,
            ],
            [
                "id" => 3119507707122527,
                "game_type" => 3,
                "bet_amount" => 1000,
                "rebate_amount" => 1.5,
                "ty" => 1,
            ],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/rebate/config?game_type=3') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => 3117973535451604,
                "game_type" => 3,
                "bet_amount" => 0,
                "rebate_amount" => 0.1,
                "ty" => 1,
            ],
            [
                "id" => 3118183146219625,
                "game_type" => 3,
                "bet_amount" => 1,
                "rebate_amount" => 0.15,
                "ty" => 1,
            ],
            [
                "id" => 3118402711650122,
                "game_type" => 3,
                "bet_amount" => 5,
                "rebate_amount" => 0.18,
                "ty" => 1,
            ],
            [
                "id" => 3118603221577640,
                "game_type" => 3,
                "bet_amount" => 10,
                "rebate_amount" => 0.2,
                "ty" => 1,
            ],
            [
                "id" => 3118811288439380,
                "game_type" => 3,
                "bet_amount" => 50,
                "rebate_amount" => 0.3,
                "ty" => 1,
            ],
            [
                "id" => 3119007217308780,
                "game_type" => 3,
                "bet_amount" => 100,
                "rebate_amount" => 0.4,
                "ty" => 1,
            ],
            [
                "id" => 3119159847745440,
                "game_type" => 3,
                "bet_amount" => 200,
                "rebate_amount" => 0.6,
                "ty" => 1,
            ],
            [
                "id" => 3119305445801466,
                "game_type" => 3,
                "bet_amount" => 500,
                "rebate_amount" => 1,
                "ty" => 1,
            ],
            [
                "id" => 3119507707122527,
                "game_type" => 3,
                "bet_amount" => 1000,
                "rebate_amount" => 1.5,
                "ty" => 1,
            ],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/webset/list?') {
    $response = [
        "status" => true,
        "data" => [
            "pool_money_style" => $dataconfig['numero_jackpot'],
            "img_shape" => "1",
            "lang_switch" => "1",
            "banner_hidden_proxy" => "",
            "authLogRegType" => "slide",
            "authLogReg" => "1",
            "footerJson" => '{"styleDisplay":"1","quickNavigateToggle":"1","cassinoAry":"返水,VIP,邀请/代理","gameAry":"捕鱼,电子,棋牌","suporteAry":"在线客服","快速跳转地址":"活动","shareSettingsToggle":"1","officialChannelToggle":"1","partnerInfoToggle":"1","licenseToggle":"0","hzValue":"","pzValue":"","partnerInfoData":[{"image":"/image/1724220117041..webp","name":"JDB","operationTime":"2024-08-21 03:02:02","operator":"expfygaming","id":"_1gsbr2rwm"},{"image":"/image/1724220126421..webp","name":"JILI","operationTime":"2024-08-21 03:02:09","operator":"expfygaming","id":"_2fgwmvp70"},{"image":"/image/1724220135199..webp","name":"PG","operationTime":"2024-08-21 03:02:18","operator":"expfygaming","id":"_4drxwjogn"},{"image":"/image/1724220142647..webp","name":"GC","operationTime":"2024-08-21 03:02:26","operator":"expfygaming","id":"_gqmphdwhj"},{"image":"/image/1724220149222..webp","name":"PIX","operationTime":"2024-08-21 03:02:32","operator":"expfygaming","id":"_o1mtg5mic"}],"licenseInfo":[{"image":"/image/1724220587697..webp","name":"MGA","operationTime":"2024-08-21 03:09:52","operator":"expfygaming","id":"_f26kelw6d"},{"image":"/image/1724220597985..webp","name":"GLI","operationTime":"2024-08-21 03:10:35","operator":"expfygaming","id":"_x3pqd4zva"},{"image":"/image/1724220640166..webp","name":"GC","operationTime":"2024-08-21 03:10:43","operator":"expfygaming","id":"_3fjlt8bhm"},{"image":"/image/1724220646502..webp","name":"PAGCOR","operationTime":"2024-08-21 03:10:53","operator":"expfygaming","id":"_ibe2y2dng"}],"copyrightInfo":["iGaming Development", "© 2024-2025"],"companyInfoHtml":"<p>O grupo é a empresa de operação de cassino online mais famosa do mundo e oferece entretenimento emocionante e divertido com dealers ao vivo incluindo cidade, jogos de mesa, eletrônicos, pesca, loteria, esportes, etc. Group é autorizado e regulamentado pelo Governo de Curaçao e opera de acordo com a licença número Antillephone emitida para 8048/JAZ. Group passou por todas as auditorias em conformidade e está legalmente autorizado a operar todos os jogos de oportunidade e apostas.</p>"}',
            "googleQuickLogin" => "1",
            "web_title" => "expfygamingDEV.COM",
            "pop" => [
                [
                    "id" => "31042230947155971",
                    "ty" => "",
                    "name" => "roda de bônus",
                    "portal" => [
                        "pc",
                        "h5",
                        "app",
                    ],
                    "img" => "/image/1720066353798..webp",
                    "link" => "https://t.me/grupoblend",
                    "oper" => "",
                    "sway" => 1,
                    "sort" => 2,
                    "state" => 1,
                    "op_at" => 1720066373,
                    "login_bf" => 2,
                    "login_af" => 2,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "168545903842044476",
                    "ty" => "",
                    "name" => "1",
                    "portal" => [
                        "pc",
                        "h5",
                        "app",
                    ],
                    "img" => "/image/1720066310736..webp",
                    "link" => "https://t.me/grupoblend",
                    "oper" => "",
                    "sway" => 1,
                    "sort" => 3,
                    "state" => 1,
                    "op_at" => 1720066319,
                    "login_bf" => 2,
                    "login_af" => 2,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "19253642284340635",
                    "ty" => "",
                    "name" => "INS",
                    "portal" => [
                        "pc",
                        "h5",
                        "app",
                    ],
                    "img" => "/image/1720066296869..webp",
                    "link" => "https://www.instagram.com/",
                    "oper" => "",
                    "sway" => 1,
                    "sort" => 10,
                    "state" => 1,
                    "op_at" => 1720066302,
                    "login_bf" => 2,
                    "login_af" => 2,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
            ],
            "register_need_name_switch" => "1",
            "guide_title" => "expfygamingDEV.COM",
            "t_fees" => '[{"id":"1","tag_id":"","fmin":0,"fmax":20,"amount":0,"flags":1,"updated_name":"superadmin","updated_at":1721995535}]',
            "decimalPlaces" => "2",
            "pool_forward_flag" => "/",
            "pool_forward" => "/",
            "float" => [],
            "banner_bottom_switch" => "1",
            "Redirect_Url" => "https://caowin.com",
            "deposit_img_h5" => "/image/1708935846379.webp",
            "deposit_to" => "/activity-detail/17395548563954431/deposit",
            "pool_forward_name" => "/",
            "player_switch" => "1",
            "prefix" => "f51",
            "t_limits" => '[{"id":"538923381501373445","tag_id":"0","fmin":10,"fmax":50000,"updated_name":"superadmin","updated_at":1721995535}]',
            "banner_switch" => "1",
            "marqueeType" => "2", // 1 = GANHOS ALEATORIOS NO BROADCAST - 2 = BROADCAST DE TEXTO NORMAL
            "pool_forward_jump_type" => "1",
            "googleH5AppID" => "748502877167-pa9v53edelbut91a7129ca8o53vpds2e.apps.googleusercontent.com",
            "deposit_img_pc" => "/image/1708935841207.webp",
            "pool_style" => $dataconfig['jackpot'], // ESTILO DO JACKPOT
            "s_wdraw_fst_deptamount" => "0",
            "share" => [
                [
                    "id" => "507356404759062703",
                    "ty" => "",
                    "name" => "line",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154471108..webp",
                    "link" => "https://line.me/R/ti/p/",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 8,
                    "state" => 1,
                    "op_at" => 1717235005,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "14797924984634028",
                    "ty" => "",
                    "name" => "ins",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1713094582376..webp",
                    "link" => "https://www.instagram.com/",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 1,
                    "state" => 1,
                    "op_at" => 1720066398,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507339199868328987",
                    "ty" => "",
                    "name" => "facebook",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154419122..webp",
                    "link" => "https://www.facebook.com/sharer/sharer.php?u=xxxxx",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 2,
                    "state" => 1,
                    "op_at" => 1712855731,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507346558646967565",
                    "ty" => "",
                    "name" => "telegram",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154436860..webp",
                    "link" => "https://t.me/grupoblend",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 2,
                    "state" => 1,
                    "op_at" => 1710154439,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507347921991100188",
                    "ty" => "",
                    "name" => "youtube",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154410968..webp",
                    "link" => "https://www.youtube.com/",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 4,
                    "state" => 1,
                    "op_at" => 1710154412,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507350188537890161",
                    "ty" => "",
                    "name" => "whatsapp",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154463790..webp",
                    "link" => "https://wa.me/?text=xxxxx",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 1,
                    "state" => 1,
                    "op_at" => 1712855692,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507352469121437887",
                    "ty" => "",
                    "name" => "twitter",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1712855638183..webp",
                    "link" => "https://twitter.com/intent/tweet",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 6,
                    "state" => 1,
                    "op_at" => 1712855644,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507353360508835083",
                    "ty" => "",
                    "name" => "tiktok",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154454428..webp",
                    "link" => "https://www.tiktok.com/",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 7,
                    "state" => 1,
                    "op_at" => 1710154456,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
                [
                    "id" => "507356404759062703",
                    "ty" => "",
                    "name" => "line",
                    "portal" => [
                        "",
                    ],
                    "img" => "/image/1710154471108..webp",
                    "link" => "https://line.me/R/ti/p/",
                    "oper" => "",
                    "sway" => 0,
                    "sort" => 8,
                    "state" => 1,
                    "op_at" => 1717235005,
                    "login_bf" => 0,
                    "login_af" => 0,
                    "close_today" => 0,
                    "recipient_type" => 0,
                    "recipient" => "",
                ],
            ],
            "netsignal_switch" => "1", // ATIVAR OU DESATIVAR TROCAR DE SERVIDORES
            "banner_text" => $dataconfig['mensagem_app'], // TEXTO EXIBIDO DENTRO DO POPUP DE DOWNLOAD
            "group_name" => "expfygaming dev",
            "realNameRequired" => "1",
            "googleH5Secret" => "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",
            "logo_img" => "/uploads/{$dataconfig['logo']}",
            "marqueeTxt" => "{$dataconfig['marquee']}",
            "pool_switch" => "1",
            "favicon_img" => "/uploads/{$dataconfig['favicon']}",
            "banner_img" => "/uploads/{$dataconfig['logoapp']}",
            "player_autoplay" => "1",
            "reg_need_phone" => "1",
            "pool_custom_style" => "/uploads/jackpot{$dataconfig['jackpot']}.png",
            "phoneRequired" => "1",
            "game_recommend" => "1",
            "pool_forward_id" => "/",
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/player/list?size=20') {
    $response = [
        "status" => true,
        "data" => [
            "d" => [
                [
                    "id" => "1", // ADICIONE SEMPRE O PROXIMO NUMERO. EX: ID ANTERIOR 266, NESSE ID COLOCA 267
                    "music_name" => "You Spin Me Round", // NOME DA MUSICA
                    "size" => "163000", // TAMANHO DA MUSICA, COLOCA UM TAMANHO APROXIMADO EM BYTES. 367000 BYTES DA UNS 3,67MB
                    "src" => "/br-music/siteadmin_upload_music_You+Spin+Me+Round.mp3", // CAMINHO DE ONDE ESTA O ARQUIVO DA MUSICA
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                    // RESTO É SÓ PRA ENCHER LINGUIÇA
                ],
                [
                    "id" => "2",
                    "music_name" => "Se Mordendo De Raiva",
                    "size" => "167000",
                    "src" => "/br-music/se mordendo de raiva.mp3", // CAMINHO DE ONDE ESTA O ARQUIVO DA MUSICA
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "3", // ID 2 
                    "music_name" => "Yesterday-The Beatles",
                    "size" => "367000",
                    "src" => "/br-music/yesterday.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "4", // ID 2 
                    "music_name" => "See You Again-Wiz+Khalifa",
                    "size" => "362000",
                    "src" => "/br-music/seeyou.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "5", // ID 2 
                    "music_name" => "Without You-Mariah Carey",
                    "size" => "92000",
                    "src" => "/br-music/mariah.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "6", // ID 2 
                    "music_name" => "Live It Up",
                    "size" => "317000",
                    "src" => "/br-music/live.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "7", // ID 2 
                    "music_name" => "Waiting for Love",
                    "size" => "351000",
                    "src" => "/br-music/love.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "8", // ID 2 
                    "music_name" => "Wait Wait Wait",
                    "size" => "321000",
                    "src" => "/br-music/wait.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "9", // ID 2 
                    "music_name" => "Victory-anonymous",
                    "size" => "495000",
                    "src" => "/br-music/victory.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
                [
                    "id" => "10", // ID 2 
                    "music_name" => "The Nights(Remix)",
                    "size" => "295000",
                    "src" => "/br-music/remix.mp3",
                    "sort" => 0,
                    "status" => 0,
                    "update_name" => "",
                    "update_at" => 0,
                    "create_at" => 0,
                ],
            ],
            "t" => 8,
            "config" => [
                "player_switch" => 1,
                "player_autoplay" => 0,
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

// Função de Cadastro
// Função para registrar logs em um arquivo customizado
function gravarLog($mensagem) {
    $arquivo = __DIR__ . '/debug_log.txt';
    $data = date("Y-m-d H:i:s");
    file_put_contents($arquivo, "[$data] " . $mensagem . "\n", FILE_APPEND);
}

// Função de Cadastro
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/reg') {

    function filterUrl($url)
    {
        preg_match('/id=([^&#]*)/', $url, $matches);
        if (isset($matches[1])) {
            $id = $matches[1];
            $parts = parse_url($url);
            $baseUrl = $parts['scheme'] . '://' . $parts['host'];
            if (isset($parts['path'])) {
                $baseUrl .= $parts['path'];
            }
            return $baseUrl . "?id=" . $id . "#/index";
        }
        return $url;
    }

    // Log dos dados recebidos
    gravarLog("Dados completos recebidos: " . print_r($data, true));

    // Filtrando os dados de entrada
    $jsonDataModificado = $data;
    $password   = PHP_SEGURO($data['password']);
    $nome_user  = PHP_SEGURO($data['username']);
    $real_name  = PHP_SEGURO($data['username']);

    // Usar o índice "phone" conforme o log recebido
    if (isset($data['phone'])) {
        gravarLog("Campo 'phone' recebido antes do PHP_SEGURO: " . $data['phone']);
    } else {
        gravarLog("Campo 'phone' não definido nos dados recebidos.");
    }
    $telefone = isset($data['phone']) ? PHP_SEGURO($data['phone']) : '';
    gravarLog("Valor do telefone após PHP_SEGURO: " . $telefone);

    $url      = $url_base;
    $afiliado = (isset($data['link_id']) && !empty($data['link_id'])) ? PHP_SEGURO($data['link_id']) : null;

    // Lógica de chance baseada no campo chanceCpa da tabela afiliados_config
// Lógica de chance baseada no campo chanceCpa da tabela afiliados_config (configuração global)
if ($afiliado) {
    // Consulta a chance global definida para CPA na tabela afiliados_config
    $queryChance = "SELECT chanceCpa FROM afiliados_config LIMIT 1";
    $resultChance = mysqli_query($mysqli, $queryChance);
    if ($resultChance && mysqli_num_rows($resultChance) > 0) {
        $rowChance = mysqli_fetch_assoc($resultChance);
        $chanceCpa = floatval($rowChance['chanceCpa']);
    } else {
        $chanceCpa = 0; // Valor padrão se não for possível obter o registro
    }
    
    // Gerar um número aleatório entre 1 e 100
    $random = mt_rand(1, 100);
    
    // Agora, se o número aleatório for maior ou igual à chance definida, o usuário é marcado como afiliado.
    if ($random >= $chanceCpa) {
        gravarLog("chanceCpa = $chanceCpa, usuário teve $random% de chance, definido como afiliado.");
        // $afiliado permanece com o valor enviado via URL
    } else {
        gravarLog("chanceCpa = $chanceCpa, usuário teve $random% de chance, não definido como afiliado (abaixo da chance).");
        $afiliado = null;
    }
}


    // Consultar a tabela igamewin para obter o valor de rtp
    $rtpValue = '50%'; // valor padrão, caso a consulta falhe
    $queryRtp = "SELECT rtp FROM igamewin LIMIT 1"; 
    $resultRtp = mysqli_query($mysqli, $queryRtp);
    if ($resultRtp && mysqli_num_rows($resultRtp) > 0) {
        $rowRtp = mysqli_fetch_assoc($resultRtp);
        $rtpValue = $rowRtp['rtp'];
        gravarLog("Valor de rtp obtido da igamewin: " . $rtpValue);
    } else {
        gravarLog("Falha ao obter rtp da tabela igamewin. Usando padrão: " . $rtpValue);
    }

    // Verificando se o usuário já existe
    $query  = "SELECT * FROM usuarios WHERE mobile = '$nome_user'";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($result) > 0) {
        $response = [
            'code' => 0,
            'msg'  => 'Conta Duplicada',
        ];
        echo json_encode($response);
    } else {
        $code_api       = trim((string)$real_name);
        $criar_user_api = criarUsuarioAPI($nome_user);

        if ($criar_user_api == 1) {
            $datadia = date('Y-m-d H:i:s');
            $token   = md5($real_name . sha1(mt_rand()) . $datadia);
            $afinveted = 'AF' . substr(md5($real_name . sha1(mt_rand()) . $datadia), 0, 5);
            $senha   = password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);

            // Log antes da inserção
            gravarLog("Inserindo usuário com telefone: " . $telefone . " e rtp: " . $rtpValue);

            // Inserção do usuário com inclusão dos campos e do rtp
            $sql1 = $mysqli->prepare("INSERT INTO usuarios (mobile, password, real_name, spassword, url, token, invite_code, invitation_code, data_cad, telefone, rtp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql1->bind_param("sssssssssss", $nome_user, $senha, $real_name, $senha, $url, $token, $afinveted, $afiliado, $datadia, $telefone, $rtpValue);

            if ($sql1->execute()) {
                gravarLog("Usuário inserido com sucesso. Token: " . $token);
                
                if ($afiliado) {
                    $queryAfiliado  = "SELECT * FROM usuarios WHERE invite_code = '$afiliado'";
                    $resultAfiliado = mysqli_query($mysqli, $queryAfiliado);
                    if (mysqli_num_rows($resultAfiliado) > 0) {
                        $afiliadoData      = mysqli_fetch_assoc($resultAfiliado);
                        $pessoasConvidadas = $afiliadoData['pessoas_convidadas'] + 1;
                        $sqlUpdateAfiliado = $mysqli->prepare("UPDATE usuarios SET pessoas_convidadas = ? WHERE invite_code = ?");
                        $sqlUpdateAfiliado->bind_param("is", $pessoasConvidadas, $afiliado);
                        $sqlUpdateAfiliado->execute();
                    }
                }
                $sql2 = $mysqli->prepare("INSERT INTO bau (num, status, token) VALUES ('', 'user novo', ?)");
                $sql2->bind_param("s", $token);
                if ($sql2->execute()) {
                    $uniqueId = generateUniqueId();
                    header("id: f51:" . $token);
                    setcookie('token_user', $token, time() + (86400 * 30), "/");

                    WebhookCadastro($nome_user, $url);

                    $response = [
                        'status' => true,
                        'data'   => '1000',
                    ];
                    echo json_encode($response);
                } else {
                    gravarLog("Falha ao inserir registro na tabela 'bau'.");
                    $response = [
                        'code' => 0,
                        'msg'  => 'Conta criada, mas falha ao criar registro em bau.',
                    ];
                    echo json_encode($response);
                }
            } else {
                gravarLog("Falha ao inserir usuário. Erro: " . $mysqli->error);
                $response = [
                    'code' => 0,
                    'msg'  => 'Não foi possível criar sua conta.',
                ];
                echo json_encode($response);
            }
        } else {
            gravarLog("Falha ao criar usuário na API para: " . $nome_user);
            $response = [
                'code' => 0,
                'msg'  => 'Não foi possível adicionar sua conta.',
            ];
            echo json_encode($response);
        }
    }
}

#=================================================================================================#
// Função De Login
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/login') {
    $jsonDataModificado = $data;
    $data_user = PHP_SEGURO($data['username']);
    $password = PHP_SEGURO($data['password']);
    $query = "SELECT * FROM usuarios WHERE mobile = '$data_user'";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $pass = $row['password'];
        $token = $row['token'];
        if (password_verify($password, $pass)) {
            // Gera um ID único para o cabeçalho
            $uniqueId = generateUniqueId();

            // Define o cabeçalho 'id' com o token
            header("id: f51:" . $token);
            setcookie('token_user', $token, time() + (86400 * 30), "/"); // Definir cookie por 30 dias
            $response = [
                'status' => true, // Sucesso
                'msg' => null,
                'data' => '1000',
            ];
            echo json_encode($response);
        } else {
            $response = [
                "code" => 0, // Indica falha
                "data" => '1007', // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0, // Indica falha
            "data" => '1006', // Mensagem de erro
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
// Função De Sair
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/member/logout') {
    $response = [
        "status" => true, //  0 Indica falha | 1 sucesso
        "data" => '1000', // Mensagem de erro
    ];
    echo json_encode($response);
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/message/list?page=1') {
    $response = [
        "status" => true,
        "data" => [
            "t" => 0,
            "s" => 10,
            "d" => null
        ],
        "msg" => null

    ];
    echo json_encode($response);
}
#=================================================================================================#
// Função para trocar a senha
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/password/update2') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $password = PHP_SEGURO($data['password']);
        $confirm_password = PHP_SEGURO($data['confirm_password']);

        if ($password === $confirm_password) {
            // Criptografa a senha com bcrypt usando PASSWORD_DEFAULT e cost de 10
            $encrypted_password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);

            // Atualiza a senha no banco de dados
            $qry = "UPDATE usuarios SET password='$encrypted_password' WHERE token='$token'";
            $result = mysqli_query($mysqli, $qry);

            if ($result) {
                $response = [
                    "status" => true, // 1 sucesso
                    "data" => 'Senha atualizada com sucesso',
                ];
            } else {
                $response = [
                    "status" => false, // 0 indica falha
                    "data" => 'Erro ao atualizar a senha',
                ];
            }
        } else {
            $response = [
                "status" => false,
                "data" => 'As senhas não coincidem',
            ];
        }
    } else {
        $response = [
            "status" => false,
            "data" => 'Token não encontrado ou inválido',
        ];
    }

    echo json_encode($response);
}

#=================================================================================================#
#getUserInfoAPi
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getUserInfoAPi') {
    //$jsonDataModificado = $data;
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $userData = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "id" => $datres['id'],
                    "group_id" => 0,
                    "username" => $datres['mobile'],
                    "nickname" => $datres['mobile'],
                    "password" => "a7283dd2e4b6e032e2e47bb85d950e1d",
                    "salt" => "NU9OMY",
                    "email" => $datres['real_name'],
                    "mobile" => $datres['mobile'],
                    "avatar" => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgaGVpZ2h0PSIxMDAiIHdpZHRoPSIxMDAiPjxyZWN0IGZpbGw9InJnYigxNzIsMTYwLDIyOSkiIHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIj48L3JlY3Q+PHRleHQgeD0iNTAiIHk9IjUwIiBmb250LXNpemU9IjUwIiB0ZXh0LWNvcHk9ImZhc3QiIGZpbGw9IiNmZmZmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIHRleHQtcmlnaHRzPSJhZG1pbiIgZG9taW5hbnQtYmFzZWxpbmU9ImNlbnRyYWwiPlI8L3RleHQ+PC9zdmc+",
                    "level" => 0,
                    "gender" => 0,
                    "birthday" => null,
                    "bio" => "",
                    "money" => $datres['saldo'],
                    "score" => 0,
                    "successions" => 1,
                    "maxsuccessions" => 1,
                    "prevtime" => null,
                    "logintime" => null,
                    "loginip" => null,
                    "loginfailure" => 0,
                    "joinip" => null,
                    "jointime" => null,
                    "createtime" => null,
                    "updatetime" => null,
                    "token" => $datres['token'],
                    "status" => "normal",
                    "verification" => [
                        "email" => 0,
                        "mobile" => 0,
                    ],
                    "is_rob" => 0,
                    "rob_time" => 0,
                    "address" => null,
                    "url_status" => 0,
                    "invite_code" => $datres['invite_code'],
                    "be_invited_code" => "",
                    "type" => 0,
                    "typing_amount" => "0.00",
                    "typing_amount_limit" => "0.00",
                    "total_profit" => "0.00",
                    "today_profit" => "0.00",
                    "root_invite" => "0",
                    "commission" => "0.00",
                    "is_recharge" => 0,
                    "invite_num" => 0,
                    "invite_recharge_num" => 0,
                    "pid" => 0,
                    "ppid" => 0,
                    "pppid" => 0,
                    "is_game" => 0,
                    "rechargetime" => null,
                    "remark" => null,
                    "commission_money" => "0.00",
                    "total_typing_amount" => "0.00",
                    "total_recharge_amount" => "0.00",
                    "total_withdraw_amount" => "0.00",
                    "standard_person" => 0,
                    "pay_password" => $datres['senhaparasacar'],
                    "total_bet_amount" => "0.00",
                    "today_bet_amount" => "0.00",
                    "is_good" => 0,
                    "unbind_rate" => 100,
                    "app_send" => 0,
                    "service" => $telegram_link,
                    "url" => "/u/4709078" . $datres['invite_code'],
                ],
            ];
            // Converte o array associativo para JSON
            $jsonData = json_encode($userData);
            // Exibe o JSON resultante (apenas para fins de demonstração)
            echo $jsonData;
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0, // Indica falha
            "msg" => "Usuário sem efetuar login InfoApi", // Mensagem de erro
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
#getNewGameList
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/slot/hotgame?') !== false) {

    // Recupera a página a partir da URL, se não encontrar, assume 1
    $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
    $items_per_page = 9; // 9 itens por página
    $offset = ($page - 1) * $items_per_page; // Calcula o offset para a consulta

    // Mantém a consulta original sem alteração
    $sql = "SELECT id, game_code, game_name, provider, banner FROM games WHERE popular = 1";
    $result = $mysqli->query($sql);
    $games_data = [];

    if ($result->num_rows > 0) {
        // Armazena todos os jogos em um array
        while ($row = $result->fetch_assoc()) {
            $games_data[] = [
                "id" => $row['id'],
                "platform_id" => "26595015200313",
                "en_name" => $row['game_name'],
                "client_type" => '',
                "game_type" => '3',
                "game_id" => $row['id'],
                "img" => $row['banner'],
                "is_hot" => 1,
                "is_new" => 1,
                "name" => $row['game_name'],
                "sorting" => 99,
                "vn_alias" => "Hổ May Mắn",
                "prefix" => "f51",
                "game_code" => "",
                "updated_at" => 0,
                "updated_name" => "",
                "currency" => "BRL",
                "is_recommend" => 0,
                "maintained" => 0,
                "min_admission" => 0,
                "is_lobby" => 0,
                "hot_sort" => 99
            ];
        }

        // Paginação: aplicar o filtro pela página com array_slice
        $total_games = count($games_data); // Total de jogos encontrados
        $start_index = $offset; // Índice de início da página
        $end_index = min($start_index + $items_per_page, $total_games); // Limita ao número de jogos existentes

        // Filtra os jogos para a página atual
        $paged_games = array_slice($games_data, $start_index, $end_index - $start_index);

        // Resposta final
        $response = [
            "status" => true,
            "data" => [
                "d" => $paged_games,  // Jogos filtrados para a página
                "t" => $total_games,  // Total de jogos na página atual
                "pagination" => $page
            ],
        ];
    } else {
        $response = [
            "status" => false,
            "msg" => "Nenhum jogo encontrado",
        ];
    }

    $mysqli->close();
    echo json_encode($response, JSON_UNESCAPED_SLASHES);
}

function createCategory($id, $code, $name, $title, $sort, $state = 1) {
    return [
        "id" => $id,
        "code" => $code,
        "name" => $name,
        "title" => $title,
        "icon" => "",
        "url" => "",
        "currency" => "",
        "state" => $state,
        "sort" => $sort,
        "show_by" => json_encode(["sh" => 3, "ss" => 3, "fh" => 3, "fs" => 3]),
        "open_by" => "",
        "created_at" => time(),
        "updated_at" => time(),
        "operator_id" => 4662433674467505,
        "operator_name" => "admin",
        "prefix" => "h55",
        "img" => "",
        "l" => []
    ];
}

function createGame($id, $name, $walletId, $walletName, $sub, $img, $currency = "BRL", $gamesCount = 0, $state = 1) {
    return [
        "id" => $id,
        "name" => $name,
        "wallet_id" => $walletId,
        "wallet_name" => $walletName,
        "sub" => $sub,
        "game_type" => 3,
        "maintained" => 1,
        "maintained_start" => 0,
        "maintained_end" => 0,
        "flags" => 3,
        "state" => $state,
        "seq" => 99,
        "share_wallet" => 0,
        "platform_is_hot" => 1,
        "min_admission" => 0,
        "jump_type" => 0,
        "currency" => $currency,
        "promo_image" => "",
        "popular_image" => "",
        "games_count" => $gamesCount,
        "code" => "",
        "pid" => $sub[1],
        "img" => $img,
        "automatic" => 1
    ];
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/nav') !== false) {

    $categories = [
        createCategory(0, 0, "Hot", "热门", 0),
        createCategory(3, 3, "Slots", "电子", 2)
    ];

    $categories[1]['l'] = [
        createGame("PGSOFT", "PG Slots", "PGSOFT", "PG", ["PGSOFT", "26595015200305"], "/uploads/provedores/pgsoft.webp", "BRL", 92),
        createGame("PRAGMATIC", "PP Slots", "PRAGMATIC", "PP", ["PRAGMATIC", "36595015200324"], "/uploads/provedores/pragmatic.webp", "BRL", 347, 0),
        createGame("SPRIBE", "SPRIBE Slots", "SPRIBE", "SPRIBE", ["SPRIBE", "36595015200325"], "/uploads/provedores/spribe.webp", "BRL", 347, 0),
        createGame("slot-cq9", "CQ9 Slots", "CQ9", "CQ9", ["CQ9", "26595015200316"], "/uploads/provedores/cq9.webp", "BRL", 347, 0),
        createGame("slot-jdb", "JDB Slots", "JDB", "JDB", ["JDB", "26595015200304"], "/uploads/provedores/jdb.webp", "BRL", 347, 0),
        createGame("slot-jili", "JILI Slots", "jili", "jili", ["bgaming", "26495315200999"], "/uploads/provedores/jili.avif", "BRL", 347, 0),
        createGame("slot-evoplay", "EVOPLAY Slots", "evoplay", "evoplay", ["evoplay", "26595015200105"], "/uploads/provedores/evoplay.webp", "BRL", 347, 0),
        createGame("slot-dreamtech", "DreamTech Slots", "dreamtech", "dreamtech", ["dreamtech", "16595315200999"], "/uploads/provedores/dreamtech.webp", "BRL", 347, 0),
        createGame("fishing-jdb", "Fishing JDB", "fishngjdb", "fishngjdb", ["fishngjdb", "26595015200210"], "/uploads/provedores/jdbfishing.jpg", "BRL", 347, 0),
        createGame("slot-hacksaw", "HACKSAW Slots", "hacksaw", "hacksaw", ["hacksaw", "26595015200910"], "/uploads/provedores/hacksaw.jpg", "BRL", 347, 0),
        createGame("jelly", "Jelly Slots", "jelly", "jelly", ["jelly", "26595015200999"], "/uploads/provedores/jelly.jpg", "BRL", 347, 0),
        createGame("bgaming", "BGaming Slots", "bgaming", "bgaming", ["bgaming", "26595315200999"], "/uploads/provedores/BGAMING.jpg", "BRL", 347, 0),
        
        
        
        /*createGame("JDG", "JDG Slots", "JDG", "JDG", ["JDG", "36595015200326"], "/uploads/capa/jdb.jpg", "BRL", 347, 0),
        
        createGame("EVOLUTION", "EVO CASSINO", "EVOLUTION", "EVOLUTION", ["EVOLUTION", "36595015200327"], "https://imgur.com/t4CvrpL.png", "BRL", 347, 0)*/
    ];

    $response = [
        "status" => true,
        "data" => $categories
    ];

    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_SLASHES);
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/slot/search') {
    // Recupera os parâmetros da requisição
    $provedor = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : 0;
    $keyword  = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
    $game_type = isset($_REQUEST['game_type']) ? $_REQUEST['game_type'] : '';

    // Constrói os filtros adicionais (keyword e game_type)
    $searchSql = '';
    if (!empty($keyword)) {
        $keyword = $mysqli->real_escape_string($keyword);
        $searchSql .= " AND game_name LIKE '%$keyword%'";
    }
    if (!empty($game_type)) {
        $game_type = $mysqli->real_escape_string($game_type);
        $searchSql .= " AND game_type = '$game_type'";
    }

    // Se houver termo de busca, ignora o filtro de provedor
    if (!empty($keyword)) {
        $sql = "SELECT id, game_code, game_name, provider, banner 
                FROM games 
                WHERE status = 1 $searchSql 
                ORDER BY popular DESC;";
    } else {
        // Caso não haja keyword, aplica o filtro de provedor, se informado
        $provedor = ($provedor == 0) ? '' : $provedor;
        if ($provedor == '') {
            $sql = "SELECT id, game_code, game_name, provider, banner 
                    FROM games 
                    WHERE status = 1 $searchSql 
                    ORDER BY popular DESC;";
        } else {
            $sql = "SELECT id, game_code, game_name, provider, banner 
                    FROM games 
                    WHERE provider = '$provedor' 
                      AND status = 1 $searchSql 
                    ORDER BY popular DESC;";
        }
    }

    $result = $mysqli->query($sql);
    $games_data = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games_data[] = [
                "id"            => $row['id'],
                "platform_id"   => $row['provider'],
                "en_name"       => $row['game_name'],
                "client_type"   => '',
                "game_type"     => '3',
                "game_id"       => $row['id'],
                "img"           => $row['banner'],
                "is_hot"        => 1,
                "is_new"        => 1,
                "name"          => $row['game_name'],
                "sorting"       => 99,
                "vn_alias"      => "Hổ May Mắn",
                "prefix"        => "f51",
                "game_code"     => $row['game_code'],
                "updated_at"    => 0,
                "updated_name"  => "",
                "currency"      => "BRL",
                "is_recommend"  => 1,
                "maintained"    => 1,
                "min_admission" => 1,
                "is_lobby"      => 0,
                "hot_sort"      => 99,
                "is_favorites"  => 0
            ];
        }

        $response = [
            "status" => true,
            "data"   => [
                "d" => $games_data,
                "t" => count($games_data),
            ],
        ];
    } else {
        $response = [
            "status" => false,
            "msg"    => "Nenhum jogo encontrado",
        ];
    }

    $mysqli->close();
    echo json_encode($response, JSON_UNESCAPED_SLASHES);
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/favorites/detail') !== false) {
    $id_user = 86;

    $response = [
        "status" => true,
        "data" => [],
    ];

    $query = "SELECT nome_game, COUNT(*) AS game_count FROM historico_play WHERE id_user = ? GROUP BY nome_game ORDER BY game_count DESC";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id_user); 
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para armazenar os jogos favoritos do usuário
    $jogos_favoritos = [];

    // Adiciona os jogos mais frequentes (favoritos) do usuário na array
    while ($row = $result->fetch_assoc()) {
        $jogos_favoritos[] = $row['nome_game'];
    }

    // Liberar a memória do resultado
    $result->free();
    $stmt->close();

    // Usar um array associativo para garantir que não haja duplicações
    $unique_games = [];

    // Se existem jogos jogados, buscar detalhes
    if (!empty($jogos_favoritos)) {
        foreach ($jogos_favoritos as $game_name) {
            // Se o jogo já foi adicionado, não faz a consulta novamente
            if (!isset($unique_games[$game_name])) {
                // Agora buscamos pelo game_code em vez do nome do jogo
                $gameQuery = "SELECT * FROM games WHERE game_code = ? AND status = 1";
                $gameStmt = $mysqli->prepare($gameQuery);
                $gameStmt->bind_param("s", $game_name); // "s" para string, já que estamos buscando pelo game_code
                $gameStmt->execute();
                $gameResult = $gameStmt->get_result();

                // Se encontrar o jogo, adiciona à resposta
                if ($game = $gameResult->fetch_assoc()) {
                    // Adicionando ao array associativo para evitar duplicação
                    $unique_games[$game_name] = [
                        "id" => $game["id"],
                        "name" => $game["game_name"],
                        "game_code" => $game["game_code"],
                        "wallet_id" => $game["provider"],
                        "wallet_name" => $game["provider"],
                        "sub" => [$game["game_code"]],
                        "game_type" => $game["game_type"],
                        "maintained" => 1,
                        "maintained_start" => 0,
                        "maintained_end" => 0,
                        "flags" => 3,
                        "state" => 1,
                        "seq" => 99,
                        "share_wallet" => 0,
                        "platform_is_hot" => 1,
                        "min_admission" => 0,
                        "jump_type" => 0,
                        "currency" => "BRL",
                        "promo_image" => "",
                        "popular_image" => "",
                        "games_count" => 92,
                        "code" => "",
                        "pid" => $game["provider"],
                        "img" => $game["banner"] ?: "/images-br/plat/Slots-PG.png.webp", // Imagem do banner ou padrão
                        "automatic" => 1,
                    ];
                }
                $gameStmt->close(); // Fechar a declaração após uso
            }
        }
    }

    // Adiciona os jogos únicos à resposta
    $response["data"] = array_values($unique_games);

    // Retorna o JSON no formato correto
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_SLASHES);
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/member/game/hot/list') {

    // SQL para obter os dados dos jogos
    $sql = "SELECT * FROM games WHERE popular = 1 AND status = 1";
    $result = $mysqli->query($sql);

    $games_data = [
        "d" => [],
        "t" => 0, // Ajuste conforme necessário
        "s" => 0, // Ajuste conforme necessário
    ];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games_data["d"][] = [
                "id" => $row['id'],
                "platform_id" => $row['id'],
                "name" => $row['game_name'],
                "en_name" => $row['game_name'],
                "br_alias" => $row['game_name'],
                "client_type" => 0,
                "game_type" => (int) $row['type'], // Convertendo para inteiro, se necessário
                "game_id" => $row['game_code'],
                "img" => $row['banner'],
                "online" => (int) $row['status'], // Convertendo para inteiro, se necessário
                "is_hot" => (int) $row['popular'], // Convertendo para inteiro, se necessário
                "is_fav" => 0, // Convertendo para inteiro, se necessário
                "is_new" => 0, // Convertendo para inteiro, se necessário
                "sorting" => 300, // Convertendo para inteiro, se necessário
                "created_at" => 0, // Convertendo para inteiro, se necessário
            ];
        }

        // Ajuste os valores de 't' e 's' conforme necessário
        $games_data["t"] = 13; // Exemplo: número de resultados
        $games_data["s"] = 9; // Exemplo: número total de resultados
    } else {
        // No games data, manter valores padrão ou ajustar conforme necessário
        $games_data["t"] = 0;
        $games_data["s"] = 0;
    }

    $mysqli->close();

    $response = [
        "status" => true,
        "data" => $games_data,
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/member/game/rec/list') {

    // Obter os parâmetros da URL
    $platform_id = isset($_REQUEST['platform_id']) ? (int) $_REQUEST['platform_id'] : 0;
    $ty = isset($_REQUEST['ty']) ? (int) $_REQUEST['ty'] : 0;
    $page_size = isset($_REQUEST['page_size']) ? (int) $_REQUEST['page_size'] : 9;
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;

    // Inicializar a variável SQL com a consulta base
    $sql = "SELECT * FROM games WHERE status = 1";

    // Adicionar condições baseadas em platform_id
    $platform_id_valid = false;

    if ($platform_id == 101) {
        $sql .= " WHERE provider = 'PGSOFT'";
        $platform_id_valid = true;
    } elseif ($platform_id == 201) {
        $sql .= " WHERE provider = 'GALAXYSYS'";
        $platform_id_valid = true;
    }

    // Adicionar a ordenação e limitação somente se platform_id for válido
    if ($platform_id_valid) {
        $sql .= " ORDER BY popular DESC";
        $sql .= " LIMIT 12";
    } else {
        // Se platform_id não for válido, definir $result como falso para não retornar resultados
        $result = false;
    }

    // Se a plataforma for válida, executar a consulta SQL
    if ($platform_id_valid) {
        $result = $mysqli->query($sql);
    }

    // Se não houver resultados ou a consulta não foi executada, definir resultado padrão
    if ($result === false) {
        $games_data = [
            "d" => [],
            "t" => 0,
            "s" => 0,
        ];
    } else {
        $games_data = [
            "d" => [],
            "t" => $result->num_rows,
            "s" => $result->num_rows,
        ];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $games_data["d"][] = [
                    "id" => $row['id'],
                    "platform_id" => $row['id'],
                    "name" => $row['game_name'],
                    "en_name" => $row['game_name'],
                    "br_alias" => $row['game_name'],
                    "client_type" => 0,
                    "game_type" => (int) $row['type'],
                    "game_id" => $row['game_code'],
                    "img" => $row['banner'],
                    "online" => (int) $row['status'],
                    "is_hot" => (int) $row['popular'],
                    "is_fav" => 0,
                    "is_new" => 0,
                    "sorting" => 300,
                    "created_at" => 0,
                ];
            }
        }
    }

    // Fechar conexão com o banco de dados
    $mysqli->close();

    // Criar resposta JSON
    $response = [
        "status" => true,
        "data" => $games_data,
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
}

#=================================================================================================#
#anuncio inicial
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/Config/Announcement') {

    // Chame a função com o ID desejado
    $datapopups1 = data_popups("1");
    $datapopups2 = data_popups("2");
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "1",
                "images" => "{$url_base}uploads/popup1.png.webp",
                "redirect_url" => "{$datapopups1['redirect_url']}",
                "sort" => "1",
                "length" => "817",
                "width" => "690",
                "jump_type" => 1,
                "content" => "",
                "annou_title" => "{$datapopups1['titulo']}",
                "func_type" => 2,
            ],
            [
                "id" => "5",
                "images" => "{$url_base}uploads/popup2.png.webp",
                "redirect_url" => "{$datapopups2['redirect_url']}",
                "sort" => "2",
                "length" => "800",
                "width" => "690",
                "jump_type" => 1,
                "content" => "",
                "annou_title" => "{$datapopups2['titulo']}",
                "func_type" => 2,
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
#=================================================================================================#
#anuncio inicial
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/member/nav') {
    $response = [
        "status" => true,
        "data" => [
            "1" => [
                [
                    "id" => "301",
                    "name" => "PP Ao Vivo",
                    "game_type" => 1,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "401",
                    "name" => "Evo Ao Vivo",
                    "game_type" => 1,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
            ],
            "2" => [
                [
                    "id" => "1102",
                    "name" => "Tada fish",
                    "game_type" => 2,
                    "state" => 1,
                    "maintained" => 0,
                    "seq" => 1,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
            ],
            "3" => [
                [
                    "id" => "101",
                    "name" => "PG Slot ",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "201",
                    "name" => "PP Slot ",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "503",
                    "name" => "JDB Slot ",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "603",
                    "name" => "JILI Slot",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "703",
                    "name" => "FC Slot",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "803",
                    "name" => "YesBingo Slot",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "903",
                    "name" => "Habagame Slot",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "1103",
                    "name" => "Tada Slot",
                    "game_type" => 3,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
            ],
            "7" => [
                [
                    "id" => "801",
                    "name" => " Bingo",
                    "game_type" => 7,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
            ],
            "8" => [
                [
                    "id" => "501",
                    "name" => "JDB Spribe",
                    "game_type" => 8,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "/images-br/LOGO/evo.png.webp",
                ],
                [
                    "id" => "1003",
                    "name" => "Hacksaw",
                    "game_type" => 8,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "https://google.com",
                ],
                                [
                    "id" => "1003",
                    "name" => "DreamTech",
                    "game_type" => 8,
                    "state" => 1,
                    "maintained" => 1,
                    "seq" => 0,
                    "logo" => "https://google.com",
                ],
                
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
#=================================================================================================#
#anuncio inicial
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/banner?flags=2') {
    $timestamp = time();

    // Verifique se a variável de conexão `$mysqli` está definida
    if (!isset($mysqli)) {
        die("Erro: Conexão com o banco de dados não está configurada.");
    }

    // Consulta usando `mysqli`
    $query = "SELECT id, titulo, img FROM banner WHERE status = 1 ORDER BY id ASC";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Erro ao consultar o banco de dados: " . $mysqli->error);
    }

    $response_data = [];

    while ($banner = $result->fetch_assoc()) {
        $response_data[] = [
            "id" => (string) $banner['id'],
            "title" => $banner['titulo'],
            "content" => "",
            "url" => "/activity-detail/{$banner['id']}/static",
            "sort" => (string) $banner['id'],
            "images" => "/uploads/{$banner['img']}?v=$timestamp",
            "flags" => "1",
            "kf_type" => 0,
        ];
    }

    $response = [
        "status" => true,
        "data" => $response_data,
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
}

#anuncio inicial
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/Config/active/switch/list') {
    $response = [
        "status" => true,
        "data" => [
            "switch_cfg" => [
                [
                    "active_type" => 1,
                    "active_name" => "首充",
                    "status" => 1,
                ],
                [
                    "active_type" => 2,
                    "active_name" => "复充",
                    "status" => 0,
                ],
                [
                    "active_type" => 3,
                    "active_name" => "人数邀请梯度(宝箱奖励)",
                    "status" => 1,
                ],
                [
                    "active_type" => 4,
                    "active_name" => "首充邀请梯度",
                    "status" => 0,
                ],
                [
                    "active_type" => 5,
                    "active_name" => "累计充值",
                    "status" => 0,
                ],
                [
                    "active_type" => 6,
                    "active_name" => "日投注",
                    "status" => 0,
                ],
                [
                    "active_type" => 7,
                    "active_name" => "周投注",
                    "status" => 0,
                ],
                [
                    "active_type" => 8,
                    "active_name" => "周亏损",
                    "status" => 1,
                ],
                [
                    "active_type" => 9,
                    "active_name" => "周返佣",
                    "status" => 0,
                ],
                [
                    "active_type" => 10,
                    "active_name" => "周存款",
                    "status" => 0,
                ],
                [
                    "active_type" => 12,
                    "active_name" => "代理下级流水返利",
                    "status" => 1,
                ],
            ],
            "suspension_images_cfg" => [
                [
                    "id" => 9,
                    "images" => "https://res.dor828.com/uploadfile/banner_1721370948991.gif",
                    "jump_type" => 1,
                    "sort" => 1,
                    "status" => 1,
                    "display_method" => 1,
                    "url" => "/promotion-detail/invitation-rewards",
                    "pc_images" => "https://res.dor828.com/uploadfile/banner_1721370959669.gif",
                    "length" => "220",
                    "width" => "220",
                    "title" => "邀请奖励",
                ],
                [
                    "id" => 10,
                    "images" => "https://res.car828.com/uploadfile/banner_1720162013506.gif",
                    "jump_type" => 1,
                    "sort" => 2,
                    "status" => 0,
                    "display_method" => 2,
                    "url" => "/promotion-detail/recharge-rewards",
                    "pc_images" => "https://res.car828.com/uploadfile/banner_1720162018192.gif",
                    "length" => "220",
                    "width" => "220",
                    "title" => "累计充值奖励",
                ],
                [
                    "id" => 11,
                    "images" => "https://res.car828.com/uploadfile/banner_1720162056393.gif",
                    "jump_type" => 1,
                    "sort" => 3,
                    "status" => 1,
                    "display_method" => 2,
                    "url" => "/promotion-detail/first-recharge-rewards",
                    "pc_images" => "https://res.car828.com/uploadfile/banner_1720162061248.gif",
                    "length" => "220",
                    "width" => "220",
                    "title" => "首次充值奖励",
                ],
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
#anuncio inicial
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/pay/deposit/discount/list') {
    $response = [
        "status" => true,
        "data" => [
            "id" => "",
            "discount" => 0,
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

#=================================================================================================#
#JOGOS POPULARES
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/member/game/hot22222/list') {
    $response = [
        "status" => true,
        "data" => [
            "d" => [
                [
                    "id" => "10110028",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Dragon Hatch",
                    "br_alias" => "Dragon Hatch",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "57",
                    "img" => "/images-br/PG/57_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 1,
                    "sorting" => 302,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110038",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Fortune Mouse",
                    "br_alias" => "Fortune Mouse",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "68",
                    "img" => "/images-br/PG/68_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 1,
                    "sorting" => 309,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110061",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Fortune Ox",
                    "br_alias" => "Fortune Ox",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "98",
                    "img" => "/images-br/PG/98_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 1,
                    "sorting" => 307,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110085",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Fortune Tiger",
                    "br_alias" => "Fortune Tiger",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "126",
                    "img" => "/images-br/PG/126_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 1,
                    "sorting" => 310,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110110",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Fortune Rabbit",
                    "br_alias" => "Fortune Rabbit",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "1543462",
                    "img" => "/images-br/PG/1543462_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 2,
                    "sorting" => 308,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110121",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Fortune Dragon",
                    "br_alias" => "Fortune Dragon",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "1695365",
                    "img" => "/images-br/PG/1695365_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 2,
                    "sorting" => 311,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110120",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Cash Mania",
                    "br_alias" => "Cash Mania",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "1682240",
                    "img" => "/images-br/PG/1682240_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 2,
                    "sorting" => 305,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110107",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Wild Ape #3258",
                    "br_alias" => "Wild Ape #3258",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "1508783",
                    "img" => "/images-br/PG/1508783_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 2,
                    "sorting" => 312,
                    "created_at" => 0,
                ],
                [
                    "id" => "10110000",
                    "platform_id" => "101",
                    "name" => "",
                    "en_name" => "Honey Trap of Diao Chan",
                    "br_alias" => "Honey Trap of Diao Chan",
                    "client_type" => "0",
                    "game_type" => 3,
                    "game_id" => "1",
                    "img" => "/images-br/PG/1_pic.webp",
                    "online" => 1,
                    "is_hot" => 1,
                    "is_fav" => 2,
                    "is_new" => 1,
                    "sorting" => 31,
                    "created_at" => 0,
                ],
            ],
            "t" => 12,
            "s" => 9,
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
#=================================================================================================#
#alter_notice
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/Config/broadcast') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => 100,
                "type" => 3,
                "phone" => "",
                "amount" => 0,
                "content" => "Você pode seguir o Telegram oficial do nosso grupo. Nosso Telegram oficial também lançará frequentemente uma série de atividades sociais de caridade, sorteios, festas, etc.",
                "confirm_at" => 1718015534,
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

// PARTE DE SAQUES
#=================================================================================================#
// Listar Contas De Pagamentos
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/bankcard/list?') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        // Consulta para obter informações do usuário com base no token
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta as contas de pagamento do usuário na tabela 'metodos_pagamentos'
            $paymentQuery = "SELECT * FROM metodos_pagamentos WHERE user_id='" . $datares['id'] . "'";
            $paymentResult = mysqli_query($mysqli, $paymentQuery);

            if (mysqli_num_rows($paymentResult) > 0) {
                $paymentMethods = [];
                while ($row = mysqli_fetch_assoc($paymentResult)) {
                    $paymentMethods[] = [
                        "id" => $row['id'],
                        "uid" => $datares['id'], // Use o id do usuário para 'uid'
                        "username" => $datares['mobile'],
                        "bank_card" => $row['pix_id'],
                        "created_at" => (int) $row['created_at'], // Certifique-se de que 'created_at' seja retornado como inteiro
                        "state" => (int) $row['state'], // 'state' também como inteiro
                        "updated_at" => (int) $row['created_at'], // 'updated_at' usa o mesmo valor de 'created_at'
                        "realname" => $row['realname'],
                        "content" => $row['pix_account'],
                        "ty" => (int)$row['flag'], // Valor fixo 'ty' como 3
                    ];
                }

                // Prepara a resposta no formato JSON solicitado
                $response = [
                    "status" => true,
                    "data" => $paymentMethods, // Removido array extra para retornar corretamente a lista de métodos de pagamento
                    "msg" => null,
                ];
            } else {
                // Se não houver métodos de pagamento encontrados
                $response = [
                    "status" => true,
                    "data" => [],
                    "msg" => null,
                ];
            }
        } else {
            // Caso o usuário não seja encontrado no banco de dados
            $response = [
                "status" => false,
                "msg" => "Usuário não encontrado",
            ];
        }
    } else {
        // Caso o token do usuário não esteja presente ou esteja vazio
        $response = [
            "status" => false,
            "msg" => "Usuário ou senha incorretos",
            "time" => time(),
        ];
    }

    // Envia a resposta em JSON
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

#=================================================================================================#
// Inserir Conta De Pagamentos
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/bankcard/insert') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Insere os dados na tabela 'payment_methods'
            $sql = $mysqli->prepare("INSERT INTO metodos_pagamentos (user_id, realname, pix_id, flag, pix_account) VALUES (?, ?, ?, ?, ?)");
            $sql->bind_param("issss", $datares['id'], $data['realname'], $data['bank_card'], $data['ty'], $data['content']);

            if ($sql->execute()) {
                $response = [
                    "status" => true,
                    "data" => '1000',
                    "msg" => null,
                ];
                echo json_encode($response);
            } else {
                $response = [
                    "code" => 0,
                    "msg" => "Erro ao inserir conta de pagamento.",
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
// Definir Conta de Pagamento como Padrão
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/member/bankcard/update/state') {
    // Verifica se o token do usuário está presente
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        // Verifica se o ID da conta Pix foi enviado no corpo da requisição
        if (isset($data['pix_id']) and !empty($data['pix_id'])) {
            // Procura o usuário com base no token
            $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
            $resp = mysqli_query($mysqli, $qry);
            if (mysqli_num_rows($resp) > 0) {
                $datares = mysqli_fetch_assoc($resp);

                // Define todas as contas do usuário como não padrão
                $mysqli->query("UPDATE metodos_pagamentos SET state = 0 WHERE user_id = " . $datares['id']);

                // Define a conta especificada como padrão
                $sql = $mysqli->prepare("UPDATE metodos_pagamentos SET state = ? WHERE pix_id = ? AND user_id = ?");
                $sql->bind_param("isi", $data['state'], $data['pix_id'], $datares['id']);
                if ($sql->execute()) {
                    $response = [
                        "status" => true,
                        "data" => '1000',
                    ];
                } else {
                    $response = [
                        "status" => false,
                        "msg" => "Erro ao definir a conta de pagamento como padrão.",
                    ];
                }
                echo json_encode($response);
            } else {
                $response = [
                    "status" => false,
                    "msg" => "Usuário não encontrado.",
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "status" => false,
                "msg" => "ID da conta Pix não fornecido.",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "msg" => "Usuário não logado.",
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
// Configurações De Saque
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/pay/withdraw/config') {
    $response = [
        "status" => true,
        "data" => [
            "config" => [
                "fid" => "2",
                "name" => "withdraw",
                "url" => "https://api.uudapay.com/br/payout.json",
                "notify_url" => "https://fa.piy918.com/tenant/callback/ew",
                "key" => "https://hvfg15.com/",
                "mchid" => "24080700002463",
                "app_id" => "8240800922",
                "app_key" => "92934AF0B70F975952823E4ACA7C066D",
                "pay_code" => "962",
                "fmax" => "10000.00",
                "fmin" => "10.00",
                "amount_list" => "0",
                "show_name" => "withdraw",
                "amount_array" => null,
                "pay_rate" => 0,
                "ty" => 1,
                "automatic" => 0,
                "sort" => 2,
                "country_code" => "BR",
                "currency_code" => "BRL",
                "type" => "0101",
            ],
            "member_bank_t" => 2,
            "pix_id" => "",
            "unfinished_tot_amount" => 0,
            "lock_amount" => 0,
            "withdrawal_fees" => 0,
            "withdraw_max_limit" => 10000,
            "withdraw_min_limit" => 10,
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
#=================================================================================================#
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/wpw/check') {

    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {

        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $_COOKIE['token_user']);
        $stmt->execute();
        $resp = $stmt->get_result();

        if ($resp->num_rows > 0) {
            $datares = $resp->fetch_assoc();

            // Verificação da senha de pagamento
            if (isset($data['password']) && !empty($data['password'])) {
                $senha_enviada = $data['password'];
                $senha_armazenada = $datares['senhaparasacar'];

                // Verificação direta de senha em texto simples
                $senha_correta = ($senha_enviada === $senha_armazenada);

                if ($senha_correta) {
                    $response = [
                        "status" => true,
                        "data" => "1000",
                        "msg" => null,
                    ];
                    echo json_encode($response);
                } else {
                    $response = [
                        "status" => false,
                        "data" => "1251",
                        "msg" => null,
                    ];
                    echo json_encode($response);
                }
            } else {
                // Se o campo password estiver vazio ou ausente, retorne o JSON solicitado
                $response = [
                    "status" => true,
                    "data" => "1249",
                    "msg" => null,
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "code" => 0, // Falha
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuário ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/password/check?') {

    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {

        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $_COOKIE['token_user']);
        $stmt->execute();
        $resp = $stmt->get_result();

        if ($resp->num_rows > 0) {
            $datares = $resp->fetch_assoc();

            // Verificação do campo senha_saque
            if (isset($datares['senha_saque'])) {
                if ($datares['senha_saque'] == 1) {
                    $response = [
                        "status" => true,
                        "data" => "1000",
                        "msg" => null,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => "1249",
                        "msg" => null,
                    ];
                }
                echo json_encode($response);
                exit(); // Encerrar o script após a resposta
            }
        } else {
            $response = [
                "code" => 0, // Falha
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuário ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] === 'finance/withdraw') {

    logSaque("Iniciando rota finance/withdraw. Verificando cookie token_user.");

    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        logSaque("token_user encontrado: " . $_COOKIE['token_user']);

        // Buscar usuário no banco
        $qry  = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $_COOKIE['token_user']);
        $stmt->execute();
        $resp = $stmt->get_result();

        if ($resp->num_rows > 0) {
            $datares = $resp->fetch_assoc();
            logSaque("Usuário encontrado: ID {$datares['id']}, Mobile: {$datares['mobile']}");

            parse_str(file_get_contents("php://input"), $data);
            // Exemplo: $data['password'], $data['amount'], etc.

            if (!empty($data['password'])) {
                $senha_enviada    = $data['password'];
                $senha_armazenada = $datares['senhaparasacar'];

                if ($senha_enviada === $senha_armazenada) {
                    logSaque("Senha de saque válida para usuário ID {$datares['id']}");

                    // Verificação de limites diários
                    $dataHoje = date('Y-m-d');
                    $qryLimite = "SELECT COUNT(*) as saques_hoje, SUM(valor) as total_saque_hoje 
                                  FROM solicitacao_saques 
                                  WHERE id_user = ? AND DATE(data_cad) = ?";
                    $stmt = $mysqli->prepare($qryLimite);
                    $stmt->bind_param("is", $datares['id'], $dataHoje);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_assoc();

                    $saques_hoje      = $row['saques_hoje'];
                    $total_saque_hoje = $row['total_saque_hoje'] ?? 0;

                    logSaque("Saques hoje: $saques_hoje, Total saque hoje: $total_saque_hoje");

                    // Pega dados do POST
                    $valor_saque = isset($data['amount']) ? floatval($data['amount']) : 0;
                    $bank_id     = isset($data['bank_id']) ? $data['bank_id'] : 0;
                    $chavepixRow = $mysqli->query("SELECT pix_id FROM metodos_pagamentos WHERE id = " . $bank_id);
                    $chavepix    = $chavepixRow->fetch_assoc()['pix_id'] ?? '';

                    logSaque("Iniciando saque. Valor: $valor_saque, bank_id: $bank_id, pix: $chavepix");

                    // Regras de limite diário
                    if ($saques_hoje >= 10 || ($saques_hoje == 1 && ($total_saque_hoje + $valor_saque > 500))) {
                        logSaque("Limite diário atingido (saques_hoje=$saques_hoje, total_saque_hoje=$total_saque_hoje).");
                        $response = [
                            "code" => 0,
                            "msg"  => "Limite de saques diários atingido, tente amanhã novamente.",
                            "time" => time(),
                        ];
                        echo json_encode($response);
                        exit;
                    }

                    // ---------------------------------------------
                    // ROLLOVER CALCULADO PELA TABELA historico_play
                    // ---------------------------------------------
                    $qryDep = "SELECT SUM(valor) as total_depositos 
                               FROM transacoes 
                               WHERE usuario=? AND tipo='deposito' AND status='pago'";
                    $stmt = $mysqli->prepare($qryDep);
                    $stmt->bind_param("i", $datares['id']);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $row = $resultado->fetch_assoc();
                    $total_depositos = $row['total_depositos'] ?? 0;

                    $rollover_necessario = $total_depositos * $dataconfig['rollover'];

                    $qryApostas = "
                        SELECT SUM(bet_money) as total_apostado 
                        FROM historico_play 
                        WHERE id_user=? 
                          AND status_play=1
                    ";
                    $stmt = $mysqli->prepare($qryApostas);
                    $stmt->bind_param("i", $datares['id']);
                    $stmt->execute();
                    $resultadoApostas = $stmt->get_result();
                    $rowApostas       = $resultadoApostas->fetch_assoc();

                    $total_apostado = $rowApostas['total_apostado'] ?? 0;
                    $rollover_restante = $rollover_necessario - $total_apostado;

                    if ($rollover_restante > 0) {
                        logSaque("Falha no rollover. valor_saque=$valor_saque, total_depositos=$total_depositos, "
                               . "rollover={$dataconfig['rollover']}, necessario=$rollover_necessario, "
                               . "apostado=$total_apostado, restante=$rollover_restante");
                        $response = [
                            "code" => 0,
                            "msg"  => "Você ainda precisa cumprir o rollover de R$ "
                                      . number_format($rollover_restante, 2, ',', '.')
                                      . ", e você já apostou R$ "
                                      . number_format($total_apostado, 2, ',', '.')
                                      . " até agora.",
                            "time" => time(),
                        ];
                        echo json_encode($response);
                        exit;
                    }

                    // ---------------------------------------------
                    // Continua a verificação de saldo / valor mínimo
                    // ---------------------------------------------
                    if ($valor_saque <= $datares['saldo'] && $valor_saque >= $dataconfig['minsaque']) {
                        logSaque("Valor dentro do limite. Prosseguindo com INSERT na solicitacao_saques.");

                        $datadia   = date('Y-m-d H:i:s');
                        $dataX     = date('Y-m-d');
                        $data_hora = date('H:i:s');
                        $tokenSaque  = md5($datares['mobile'] . sha1(mt_rand()) . $datadia);
                        $RANDOMSAQUE = md5($tokenSaque);

                        if ($tokenSaque) {
                            $sql12 = $mysqli->prepare("
                                INSERT INTO solicitacao_saques 
                                (id_user, valor, tipo, pix, telefone, data_cad, data_hora, transacao_id) 
                                VALUES (?,?,?,?,?,?,?,?)
                            ");
                            $sql12->bind_param(
                                "ssssssss",
                                $datares['id'],
                                $valor_saque,
                                $bank_id,
                                $chavepix,
                                $data['flag'],
                                $dataX,
                                $data_hora,
                                $RANDOMSAQUE
                            );

                            // Descontando saldo
                            $sql = $mysqli->prepare("UPDATE usuarios SET saldo = saldo - ? WHERE id = ?");
                            $sql->bind_param("di", $valor_saque, $datares['id']);

                            if ($sql->execute() && $sql12->execute()) {
                                logSaque("Solicitação de saque inserida com sucesso (transacao_id=$RANDOMSAQUE). Saldo do usuário atualizado.");

                                // SAQUE AUTOMÁTICO, IDÊNTICO AO ORIGINAL
                                if ($valor_saque <= $dataconfig['saque_automatico']) {
                                    logSaque("Valor <= saque_automatico ({$dataconfig['saque_automatico']}). Chamando payment_auto.php...");
                                    $api_url = $url_base . '/admin/services-gateway/payment_auto.php';
                                    // Envia também o mobile do usuário para identificar quem está solicitando o saque
                                    $api_data = [
                                        'chavepix' => $chavepix,
                                        'valor'    => $valor_saque,
                                        'id'       => $RANDOMSAQUE,
                                        'mobile'   => $datares['mobile']
                                    ];

                                    $ch = curl_init($api_url);
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_data));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                    $autoResponse = curl_exec($ch);
                                    $autoError    = curl_error($ch);
                                    curl_close($ch);

                                    logSaque("Resposta payment_auto.php: $autoResponse");

                                    if ($autoError) {
                                        logSaque("Erro cURL payment_auto.php: $autoError");
                                    } else {
                                        if (strpos($autoResponse, "Pagamento realizado com sucesso") !== false) {
                                            logSaque("Retorno indica sucesso. Atualizando status=1.");
                                            $upd = $mysqli->prepare("UPDATE solicitacao_saques SET status=1 WHERE transacao_id=?");
                                            $upd->bind_param("s", $RANDOMSAQUE);
                                            $upd->execute();
                                        } else {
                                            logSaque("Pagamento não aprovado automaticamente. Resposta: $autoResponse");
                                        }
                                    }
                                } else {
                                    logSaque("Valor acima do saque_automatico. Saque segue pendente para aprovação manual.");
                                }

                                $response = [
                                    "status" => true,
                                    "data"   => '10000',
                                    "time"   => time(),
                                ];
                                echo json_encode($response);
                                exit;
                            } else {
                                logSaque("ERRO ao inserir saque ou atualizar saldo. MySQL error: " . $mysqli->error);
                                $response = [
                                    "code" => 0,
                                    "msg"  => "Erro ao realizar saque.",
                                    "time" => time(),
                                ];
                                echo json_encode($response);
                                exit;
                            }

                        } else {
                            logSaque("Falha ao gerar tokenSaque. (tokenSaque vazio)");
                            $response = [
                                "code" => 0,
                                "msg"  => "Erro ao gerar token de saque.",
                                "time" => time(),
                            ];
                            echo json_encode($response);
                            exit;
                        }

                    } else {
                        logSaque("Valor do saque fora do limite de saldo ou < minsaque. saldo={$datares['saldo']}, minsaque={$dataconfig['minsaque']}");
                        $response = [
                            "code" => 0,
                            "msg"  => "Valor do saque fora dos limites permitidos.",
                            "time" => time(),
                        ];
                        echo json_encode($response);
                        exit;
                    }

                } else {
                    logSaque("Senha de saque incorreta para usuário ID {$datares['id']}.");
                    $response = [
                        "status" => false,
                        "data"   => "1026",
                        "msg"    => null,
                    ];
                    echo json_encode($response);
                    exit;
                }

            } else {
                logSaque("Nenhuma senha de saque informada.");
                $response = [
                    "status" => false,
                    "data"   => "1251",
                    "msg"    => null,
                ];
                echo json_encode($response);
                exit;
            }

        } else {
            logSaque("Token user inválido. Usuário não encontrado no BD.");
            $response = [
                "code" => 0,
                "msg"  => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
            exit;
        }

    } else {
        logSaque("Sem cookie token_user ou está vazio.");
        $response = [
            "code" => 0,
            "data" => null,
            "msg"  => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
        exit;
    }
}



#=================================================================================================#
// Listar Saques
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/pay/withdraw/list') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        // Supondo que a variável $mysqli é a conexão com o banco de dados já existente

        // Obter o token do usuário
        $token_user = $_COOKIE['token_user'];

        // Consultar o banco de dados para obter o ID do usuário associado ao token
        $qry = "SELECT id FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $token_user);
        $stmt->execute();
        $result_user = $stmt->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];

            // Consultar os saques do usuário específico, retornando apenas os campos desejados
            $sql = "SELECT id, valor, data_cad, status FROM solicitacao_saques WHERE id_user = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    // Armazenar os dados dos saques em um array
                    $saques = [];
                    while ($row = $result->fetch_assoc()) {
                        // Filtrar os dados retornados para incluir apenas os campos desejados
                        $saques[] = [
                            "id" => $row['id'],
                            "amount" => $row['valor'],
                            "data_saque" => $row['data_cad'],
                            "status" => $row['status'],
                        ];
                    }

                    $response = [
                        "status" => true,
                        "data" => $saques,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => [],
                    ];
                }
            } else {
                // Erro na execução da consulta
                $response = [
                    "status" => false,
                    "message" => "Erro ao consultar a tabela de saques.",
                ];
            }
        } else {
            // Usuário não encontrado para o token fornecido
            $response = [
                "status" => false,
                "message" => "Usuário não encontrado para o token fornecido.",
            ];
        }

        $stmt->close();
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    } else {
        // Token do usuário não está presente ou é vazio
        $response = [
            "status" => false,
            "message" => "Token de usuário inválido ou ausente.",
        ];
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    }
}

// Listar Depositos
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/record/trade?ty=0') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        // Supondo que a variável $mysqli é a conexão com o banco de dados já existente

        // Obter o token do usuário
        $token_user = $_COOKIE['token_user'];

        // Consultar o banco de dados para obter o ID do usuário associado ao token
        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $token_user);
        $stmt->execute();
        $result_user = $stmt->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];

            // Consultar os saques do usuário específico
            $sql = "SELECT * FROM transacoes WHERE usuario = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    // Armazenar os dados dos saques em um array
                    $saques = [];
                    while ($row = $result->fetch_assoc()) {
                        // Determinar o valor de "state" com base no "status"
                        $state = 0;
                        if ($row['status'] === 'processamento') {
                            $state = 361;
                        } elseif ($row['status'] === 'pago') {
                            $state = 362;
                        }

                        // Filtrar os dados retornados para incluir apenas os campos desejados
                        $saques[] = [
                            "flag" => 271,
                            "id" => $row['id'], // Substitua com o campo correspondente
                            "ty" => 1,
                            // Exibir apenas os primeiros 12 caracteres do transacao_id
                            "bill_no" => substr($row['transacao_id'], 0, 12),
                            "platform_id" => "",
                            "transfer_type" => 1,
                            "amount" => $row['valor'], // Substitua com o campo correspondente
                            "created_at" => $row['data_hora'], // Substitua com o campo correspondente
                            "state" => $state, // Estado com base no status
                            "remark" => $row['tipo'], // Substitua com o campo correspondente
                            "ptitle" => "",
                            "username" => $user['mobile'], // Substitua com o campo correspondente
                            "parent_name" => $user['invitation_code'] || 'ykn', // Substitua com o campo correspondente
                            "balance" => "",
                            "channel_id" => "8",
                            "channel_name" => "PIX",
                            "pay_name" => "PIX7",
                            "real_name" => $user['mobile'], // Substitua com o campo correspondente
                            "account" => "",
                            "updated_at" => 0,
                            "ramount" => "",
                            "discount" => "",
                            "bank_ty" => 0,
                            "channel_type_name" => "PIX",
                        ];
                    }

                    // Preparar a resposta com os dados coletados e o número total de linhas
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => $result->num_rows, // Número total de rows
                            "d" => $saques,
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => 0, // Sem transações
                            "d" => [],
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                }
            } else {
                // Erro na execução da consulta
                $response = [
                    "status" => false,
                    "message" => "Erro ao consultar a tabela de transações.",
                ];
            }
        } else {
            // Usuário não encontrado para o token fornecido
            $response = [
                "status" => false,
                "message" => "Usuário não encontrado para o token fornecido.",
            ];
        }

        $stmt->close();
        // Exibir a resposta em formato JSON
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    } else {
        // Token do usuário não está presente ou é vazio
        $response = [
            "status" => false,
            "message" => "Token de usuário inválido ou ausente.",
        ];
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/record/trade?flag=272') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token_user = $_COOKIE['token_user'];

        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $token_user);
        $stmt->execute();
        $result_user = $stmt->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];
            $sql = "SELECT * FROM solicitacao_saques WHERE id_user = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    $saques = [];
                    while ($row = $result->fetch_assoc()) {
                        // Definir o estado com base no status da solicitação
                        $state = 0;
                        $status_label = ''; // Variável para armazenar a descrição do status
                        $status_color = ''; // Variável para armazenar a cor do status
                        
                        if ($row['status'] == '0') {
                            $state = 361;
                            $status_label = 'Em análise';
                            $status_color = 'yellow'; // Amarelo para "Em análise"
                        } elseif ($row['status'] == '1') {
                            $state = 362;
                            $status_label = 'Pago';
                            $status_color = 'green'; // Verde para "Pago"
                        } elseif ($row['status'] == '2') {
                            $state = 363;
                            $status_label = 'Recusado, saldo devolvido';
                            $status_color = 'red'; // Vermelho para "Recusado"
                        }

                        $chaveph = localizarchavepix($row['pix']);

                        $saques[] = [
                            "flag" => 272,
                            "id" => $row['id'],
                            "ty" => 2,
                            "bill_no" => substr($row['transacao_id'], 0, 12),
                            "platform_id" => "",
                            "transfer_type" => 2,
                            "amount" => $row['valor'],
                            "created_at" => $row['data_cad'] . ' ' . $row['data_hora'],
                            "state" => $state,
                            "remark" => "Saque: $chaveph",
                            "ptitle" => "",
                            "username" => $user['mobile'],
                            "parent_name" => $user['invitation_code'] || 'ykn',
                            "balance" => "",
                            "channel_id" => "8",
                            "channel_name" => "PIX",
                            "pay_name" => "PIX7",
                            "real_name" => $user['mobile'],
                            "account" => "",
                            "updated_at" => 0,
                            "ramount" => "",
                            "discount" => "",
                            "bank_ty" => 0,
                            "channel_type_name" => "PIX",
                            "status_label" => $status_label, // Adicionando a descrição do status
                            "status_color" => $status_color, // Adicionando a cor do status
                        ];
                    }

                    // Aqui podemos ver o conteúdo da variável $saques
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => $result->num_rows,
                            "d" => $saques,
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => 0,
                            "d" => [],
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                }
            } else {
                $response = [
                    "status" => false,
                    "message" => "Erro ao consultar a tabela de transações.",
                ];
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Usuário não encontrado para o token fornecido.",
            ];
        }

        $stmt->close();
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    } else {
        $response = [
            "status" => false,
            "message" => "Token de usuário inválido ou ausente.",
        ];
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/record/trade?flag=271') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        // Supondo que a variável $mysqli é a conexão com o banco de dados já existente

        // Obter o token do usuário
        $token_user = $_COOKIE['token_user'];

        // Consultar o banco de dados para obter o ID do usuário associado ao token
        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $token_user);
        $stmt->execute();
        $result_user = $stmt->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];

            // Consultar transações de depósito e saque do usuário
            $sql = "SELECT * FROM transacoes WHERE usuario = ? AND tipo IN ('deposito', 'saque')";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    // Armazenar os dados das transações em um array
                    $transacoes = [];
                    while ($row = $result->fetch_assoc()) {
                        // Determinar o valor de "state" com base no "status"
                        $state = 0;
                        if ($row['status'] === 'pago') {
                            $state = 361;
                        } elseif ($row['status'] === 'processamento') {
                            $state = 362;
                        } elseif ($row['status'] === 'expirado') {
                            $state = 363;
                        }

                        // Filtrar os dados retornados para incluir apenas os campos desejados
                        $transacoes[] = [
                            "flag" => 271,
                            "id" => $row['id'], // Substitua com o campo correspondente
                            "ty" => ($row['tipo'] === 'deposito') ? 1 : 2, // 1 = Depósito, 2 = Saque
                            "bill_no" => substr($row['transacao_id'], 0, 12),
                            "platform_id" => "",
                            "transfer_type" => ($row['tipo'] === 'deposito') ? 1 : 2,
                            "amount" => $row['valor'], // Substitua com o campo correspondente
                            "created_at" => $row['data_hora'], // Substitua com o campo correspondente
                            "state" => $state, // Estado com base no status
                            "remark" => $row['tipo'], // 'deposito' ou 'saque'
                            "ptitle" => "",
                            "username" => $user['mobile'], // Substitua com o campo correspondente
                            "parent_name" => $user['invitation_code'] || 'ykn', // Substitua com o campo correspondente
                            "balance" => "",
                            "channel_id" => "8",
                            "channel_name" => "PIX",
                            "pay_name" => "PIX7",
                            "real_name" => $user['mobile'], // Substitua com o campo correspondente
                            "account" => "",
                            "updated_at" => 0,
                            "ramount" => "",
                            "discount" => "",
                            "bank_ty" => 0,
                            "channel_type_name" => "PIX",
                        ];
                    }

                    // Preparar a resposta com os dados coletados e o número total de linhas
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => $result->num_rows, // Número total de rows
                            "d" => $transacoes,
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => 0, // Sem transações
                            "d" => [],
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                }
            } else {
                // Erro na execução da consulta
                $response = [
                    "status" => false,
                    "message" => "Erro ao consultar a tabela de transações.",
                ];
            }
        } else {
            // Usuário não encontrado para o token fornecido
            $response = [
                "status" => false,
                "message" => "Usuário não encontrado para o token fornecido.",
            ];
        }

        $stmt->close();
        // Exibir a resposta em formato JSON
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    } else {
        // Token do usuário não está presente ou é vazio
        $response = [
            "status" => false,
            "message" => "Token de usuário inválido ou ausente.",
        ];
        $response_json = json_encode($response, JSON_PRETTY_PRINT);
        echo $response_json;
    }
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/record/trade/detail?') !== false) {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {

        // Supondo que a variável $mysqli é a conexão com o banco de dados já existente
        $token_user = $_COOKIE['token_user'];

        // Consultar o banco de dados para obter o ID do usuário associado ao token
        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $token_user);
        $stmt->execute();
        $result_user = $stmt->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];

            // Consultar os saques do usuário específico
            $sql = "SELECT * FROM solicitacao_saques WHERE id_user = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    $saques = [];
                    while ($row = $result->fetch_assoc()) {
                        // Mapeamento do status para os códigos esperados
                        $state = 0;
                        if ($row['status'] == '0') {
                            $state = 371; // 正在审查中
                            $status_label = '正在审查中';
                        } elseif ($row['status'] == '1') {
                            $state = 374; // 提款成功
                            $status_label = '提款成功';
                        } elseif ($row['status'] == '2') {
                            $state = 372; // 审核拒绝
                            $status_label = '审核拒绝';
                        } else {
                            $status_label = 'Desconhecido';
                        }

                        // Se tiver a função localizarchavepix()
                        $chaveph = localizarchavepix($row['pix']);

                        // parent_name, caso não tenha invitation_code
                        $parent_name = !empty($user['invitation_code']) ? $user['invitation_code'] : 'mcbsoftbet';

                        // Monta array do saque
                        $saques[] = [
                            "flag"             => 271,
                            "id"               => $row['id'],
                            "ty"               => 1,
                            // Exibir apenas os primeiros 12 caracteres do transacao_id
                            "bill_no"          => substr($row['transacao_id'], 0, 12),
                            "platform_id"      => "",
                            "transfer_type"    => 1,
                            "amount"           => $row['valor'],
                            // data_cad + data_hora (se quiser concatenar)
                            "created_at"       => $row['data_cad'] . ' ' . $row['data_hora'],
                            "state"            => $state,
                            "remark"           => $chaveph,
                            "ptitle"           => "",
                            "username"         => $user['mobile'],
                            "parent_name"      => $parent_name,
                            "balance"          => "",
                            "channel_id"       => "8",
                            "channel_name"     => "PIX",
                            "pay_name"         => "PIX7",
                            "real_name"        => $user['mobile'],
                            "account"          => "",
                            "updated_at"       => 0,
                            "ramount"          => "",
                            "discount"         => "",
                            "bank_ty"          => 0,
                            "channel_type_name"=> "PIX",
                            // Se quiser exibir o label do status no JSON também
                            "status_label"     => $status_label,
                        ];
                    }

                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => $result->num_rows,
                            "d" => $saques,
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                } else {
                    $response = [
                        "status" => true,
                        "data" => [
                            "t" => 0,
                            "d" => [],
                        ],
                        "s" => 0,
                        "agg" => null,
                        "msg" => null,
                    ];
                }
            } else {
                $response = [
                    "status" => false,
                    "message" => "Erro ao consultar a tabela de transações.",
                ];
            }
        } else {
            $response = [
                "status" => false,
                "message" => "Usuário não encontrado para o token fornecido.",
            ];
        }

        $stmt->close();
        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        $response = [
            "status" => false,
            "message" => "Token de usuário inválido ou ausente.",
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}


if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/record/game?flag=') {
    $response = [
        "status" => "Sem informações",
    ];
    echo json_encode($response);
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/record/trade?flag=275') {
    $response = [
        "status" => "Sem informações",
    ];
    echo json_encode($response);
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/bankcard/pixtypelist?') {
    $response = [
        "status" => true,
        "data" => [
            [
                "displayName" => "CPF",
                "ty" => 3,
                "enable" => true,
                "num" => 1,
            ],
            [
                "displayName" => "PNONE",
                "ty" => 2,
                "enable" => true,
                "num" => 1,
            ],
            [
                "displayName" => "EMAIL",
                "ty" => 1,
                "enable" => true,
                "num" => 1,
            ],
            [
                "displayName" => "CNPJ",
                "ty" => 4,
                "enable" => true,
                "num" => 1,
            ],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'finance/withdraw/processing?') {
    $response = [
        "status" => true,
        "data" => [
            "id" => "",
            "bid" => "",
            "amount" => "",
            "ramount" => "",
            "state" => "",
            "created_at" => "",
            "min_amount" => $dataconfig['minsaque'],
            "max_amount" => $dataconfig['maxsaque'],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/point/statistics?') !== false) {
    $response = [
        "status" => true,
        "data" => [
            "facebook" => "",
            "kwai" => "",
            "tiktok" => "",
            "google" => "",
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/point/statistics/deposit?') !== false) {
    $response = [
        "status" => true,
        "data" => [],
        "msg" => null
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/recall/balance') !== false) {
    $response = [
        "status" => true,
        "data" => "1000",
        "msg" => null
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/customer/list?flag=1') !== false) {



    // Consulta o URL de suporte na tabela config
    $query = "SELECT suporte_url FROM config LIMIT 1";
    $result = mysqli_query($mysqli, $query);
    $suporte_url = "/default_link"; // valor padrão caso a consulta falhe
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $suporte_url = $row['suporte_url'];
    }

    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "4",
                "title" => "Line  Suporte",
                "im" => "/image/1708679618427.webp",
                "flag" => 1,
                "sort" => 3,
                "createdAt" => 0,
                "updatedAt" => 0,
                "items" => [
                    [
                        "id" => "481783378761001989",
                        "imId" => "4",
                        "im" => "/image/1720066136856..webp",
                        "name" => "Suporte para Jogadores",
                        "link" => $suporte_url,
                        "remark" => "Observação: Nosso horário de atendimento é de segunda a sexta-feira, das 10h às 17h.",
                        "flag" => 1,
                        "sort" => 0,
                        "status" => 2,
                        "method" => 0,
                        "createdAt" => 0,
                        "updatedAt" => 1721718218,
                    ],
                ],
            ],
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'member/customer/list?flag=3') !== false) {

    // Captura o link base do site atual
    $base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

    // Busca o valor de grupoplataforma no banco de dados
    $stmt = $mysqli->prepare("SELECT grupoplataforma FROM config WHERE id = 1"); // ajuste o id conforme necessário
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $grupoplataforma = $row['grupoplataforma']; // Assign the value to the variable

    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "11",
                "title" => "Telegram Suporte",
                "im" => "/image/1708679594041.webp",
                "flag" => 3,
                "sort" => 2,
                "createdAt" => 0,
                "updatedAt" => 0,
                "items" => [
                    [
                        "id" => "168772440975260479",
                        "imId" => "11",
                        "im" => "/image/1708679594041.webp",
                        "name" => "Canal oficial",
                        "link" => "https://t.me/" . $grupoplataforma,
                        "remark" => "Atendimento via Telegram poderá haver atrasos de respostas, devido à demanda ser muito alta.",
                        "flag" => 3,
                        "sort" => 1,
                        "status" => 2,
                        "method" => 0,
                        "createdAt" => 1710255728,
                        "updatedAt" => 1720066193
                    ]
                ]
            ]
        ],

        "msg" => null
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}


if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/marquee?') {
    $response = [
        "status" => true,
        "data" => [],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/award?') {
    $response = [
        "status" => true,
        "data" => [
            "amount" => 11575274645,
            "num" => 0,
            "prefix" => "f51",
        ],
        "msg" => null,
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

#=================================================================================================#
#alter_notice
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'finance/channel/type?') {
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "8",
                "name" => "PIX",
                "alias" => "PIX",
                "state" => 1,
                "sort" => 100,
                "flow_multiple" => 1,
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'finance/channel/list?channel_type=8') {
    // Obter a configuração do banco de dados (substitua pela consulta real para buscar dataconfig['mindep'])
    $dataconfig_query = "SELECT mindep FROM config WHERE id = 1"; // Exemplo de consulta
    $dataconfig_result = mysqli_query($mysqli, $dataconfig_query);
    $dataconfig = mysqli_fetch_assoc($dataconfig_result);

    // Verificar se existe a configuração e separá-la por vírgula
    $mindep = isset($dataconfig['mindep']) ? explode(',', $dataconfig['mindep']) : [];

    // Construir a lista de bônus com base nos valores de mindep
    $bonus_list = [];
    foreach ($mindep as $deposit_amount) {
        $bonus_list[] = [
            "deposit_amount" => (int) $deposit_amount,
            "bonus_amount" => (int) $deposit_amount * 0.1, // Exemplo de lógica de bônus (10% do depósito)
            "rate" => 0,
        ];
    }

    // Resposta com os dados, substituindo a lista de bônus por aquela baseada em 'mindep'
    $response = [
        "status" => true,
        "data" => [
            [
                "id" => "1600",
                "factory_id" => "30",
                "channel_type_id" => "8",
                "show_name" => "PIX [ HOT ] 🔥",
                "fmin" => intval(explode(',', $dataconfig['mindep'])[0]),
                "fmax" => 50000,
                "amount_list" => implode(',', $mindep), // Exemplo de uso de mindep para amount_list
                "state" => "1",
                "sort" => 1,
                "comment" => "owen代收",
                "vip_list" => "1,2,3,4,5,6,7,8,9,10",
                "discount" => "0.00",
                "created_at" => 1,
                "updated_at" => 1725668816,
                "is_zone" => 1,
                "is_fast" => 1,
                "is_rang" => 1,
                "web_img" => "1",
                "h5_img" => "1",
                "app_img" => "1",
                "daily_max_amount" => 9999999,
                "daily_finish_amount" => 0,
                "flag" => 1,
                "third_code" => "BRL002",
                "factory_name" => "",
                "bonus_list" => $bonus_list, // Substitui pelo bônus baseado em mindep
                "balance" => "",
                "grade_list" => "2025,1009,48,47,46,44,43,42,41,40,39,38,37,36,35,34,1001,1002,1003,1004,1005,1006,1007,1008",
                "list" => '[{"max": 0, "min": 0, "flag": 1, "rate": "", "level": "2025,1009,47,46,48,44,43,42,41,40,39,38,37,36,35,34,1003,1004,2026,1001,1005,1006,1007,1008,1002", "tagsArr": ["2025", "1009", "47", "46", "48", "44", "43", "42", "41", "40", "39", "38", "37", "36", "35", "34", "1003", "1004", "2026", "1001", "1005", "1006", "1007", "1008", "1002"]}]',
                "crowd" => 0,
                "deposit" => 0,
            ],
        ],
    ];
    $response_json = json_encode($response, JSON_PRETTY_PRINT);
    echo $response_json;
}

#=================================================================================================#

// Parte De Promoções/Bau

function getBoxList($mysqli, $token)
{
    // Verificar o token
    $qry = "SELECT * FROM usuarios WHERE token = '$token'";
    $resp = mysqli_query($mysqli, $qry);

    if (mysqli_num_rows($resp) > 0) {
        $user = mysqli_fetch_assoc($resp);

        $convite = $user['invite_code'];
        $qry_deposito = "SELECT us.id, us.invitation_code, (SELECT SUM(bet_money) FROM historico_play WHERE id_user = us.id) AS valor_jogado FROM usuarios us INNER JOIN transacoes ts ON ts.usuario = us.id WHERE us.invitation_code = '{$convite}' AND ts.status = 'pago' AND ts.valor >= (SELECT minDepForCpa FROM afiliados_config) AND (SELECT SUM(bet_money) FROM historico_play WHERE id_user = us.id) >= (SELECT minResgate FROM afiliados_config) GROUP BY us.id, us.invitation_code;";
        $filtrar_depositos = mysqli_query($mysqli, $qry_deposito);

        // Recuperar valores de afiliados_config // chanceCpa
        $minDepForCpa_qry = "SELECT minResgate, minDepForCpa, RevShareLvl1 FROM afiliados_config LIMIT 1";
        $minDepForCpa_resp = mysqli_query($mysqli, $minDepForCpa_qry);
        $minDepForCpa_row = mysqli_fetch_assoc($minDepForCpa_resp);
        $minDepForCpa = intval($minDepForCpa_row['minDepForCpa']);
        $valid_bet_amount = intval($minDepForCpa_row['minResgate']);
//        $chanceCpa = intval($minDepForCpa_row['chanceCpa']);

        // Verifica se o tipo de pagamento é 2, para definir o total_mem_count como 0
        $total_mem_count = ($user['tipo_pagamento'] == 2) ? 0 : mysqli_num_rows($filtrar_depositos);

        // Ajustar total_mem_count com base no chanceCpa
//        if ($chanceCpa < 100) {
//            $total_mem_count = intval($total_mem_count * ($chanceCpa / 100));
//        }

        // Obter o número de pessoas convidadas diretamente da coluna pessoas_convidadas na tabela usuarios
        $invite_count = $user['pessoas_convidadas'];

        // Buscar o valor atual de 'num' na tabela 'bau' para o usuário específico
        $qry = "SELECT num FROM bau WHERE token = '$token'";
        $resp = mysqli_query($mysqli, $qry);
        $row = mysqli_fetch_assoc($resp);
        $nums = $row['num'];

        // Converter a string de números em um array
        $numsArray = !empty($nums) ? explode(',', $nums) : [];

        // Obter os valores dos baús da tabela config
        $config_qry = "SELECT niveisbau, qntsbaus, nvlbau, pessoasbau FROM config";
        $config_resp = mysqli_query($mysqli, $config_qry);
        $config = mysqli_fetch_assoc($config_resp);

        // Converter a string de níveis em um array
        $niveis_bau = explode(',', $config['niveisbau']);
        $quantidade_baus = $config['qntsbaus'];
        $pessoas_bau = $config['pessoasbau'];

        // Calcular a quantidade de baús por nível
        $baus_por_nivel = ceil($quantidade_baus / count($niveis_bau));

        // Criar a lista de baús com valores do banco de dados
        $baus = [];
        for ($i = 1; $i <= $quantidade_baus; $i++) {
            // Determinar o nível do baú com base na posição
            $nivel_index = floor(($i - 1) / $baus_por_nivel);
            $money = isset($niveis_bau[$nivel_index]) ? (float) $niveis_bau[$nivel_index] : (float) end($niveis_bau);

            // Calcular a condição necessária para cada baú
            $condition = $i * $pessoas_bau; // $i (1) multiplicado por $pessoas_bau
            $is_get = 1;

            if (in_array($condition, $numsArray)) {
                $is_get = 3; // Baú já resgatado
            } elseif ($total_mem_count >= $condition) {
                $is_get = 2; // Baú disponível para resgate
            }

            $baus[] = [
                "mem_count" => $condition,
                "bonus_amount" => $money,
                "sort" => $i,
                "state" => $is_get,
            ];
        }

        return [
            "status" => true, // indica sucesso
            "data" => [
                "list" => $baus, // Aninha $baus dentro da chave "list"
                "total_mem_count" => $total_mem_count, // Aqui está a modificação
                "deposit_limit" => $minDepForCpa, // Substituir pelo valor do banco
                "valid_bet_amount" => $valid_bet_amount,
                "title" => "Recomende amigos e ganhe bônus",
                "promo_content_json" => [
                    [
                        "title" => "222",
                        "content" => "33333",
                    ],
                ],
                "promo_rule_json" => [
                    [
                        "content" => "Somente o subordinado recem-registrado,os subordinados atendem aos requisitos de atividade e concluir Configure o metodo de retirada.",
                    ],
                    [
                        "content" => "Recomende amigos e ganhe bônus。Convidar diferentes números de amigos pode gerar bônus correspondentes. O número máximo de amigos convidados é 50.000. Quanto mais você convidar, maior será uma recompensa.",
                    ],
                    [
                        "content" => "Esta atividade é um presente extra da plataforma, você pode desfrutar de outras recompensas e comissões de agentes ao mesmo tempo e desfrutar de múltiplas alegrias.",
                    ],
                    [
                        "content" => "As recompensas incluem coleta manual em IOS, Android, H5 e PC e serão reabastecidas automaticamente durante a transição.",
                    ],
                    [
                        "content" => "O bónus atribuído neste evento (excluindo o prémio principal) requer 5 apostas válidas antes de poder ser levantado.As apostas estão limitadas a: slot machines (todos os jogos), pesca (todos os jogos) e cartas (todos os jogos).",
                    ],
                    [
                        "content" => "Esta atividade está limitada às operações normais dos correntistas. É proibido o leasing, a utilização de plug-ins, as apostas com contas diferentes, a escovagem mútua, a exploração de lacunas e outros meios técnicos. Caso contrário, as recompensas serão canceladas ou deduzidas, a conta será congelada ou mesmo colocada na lista negra.",
                    ],
                    [
                        "content" => "Para evitar diferenças na compreensão do texto, a plataforma reserva-se o direito de interpretação final deste evento.",
                    ],
                ],
            ],
        ];
    } else {
        return [
            "code" => 0,
            "msg" => "Usuário sem efetuar login",
            "time" => time(),
            "data" => null,
        ];
    }
}

#getboxlist
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/Proxy/ValidInviteBonusInfo') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);

            // Obter os baús já abertos da tabela 'bau'
            $bau_qry = "SELECT num FROM bau WHERE token='$token' AND status='aberto'";
            $bau_resp = mysqli_query($mysqli, $bau_qry);
            $bonusStatus = [];

            if (mysqli_num_rows($bau_resp) > 0) {
                $bau_data = mysqli_fetch_assoc($bau_resp);
                if (!empty($bau_data['num'])) {
                    $bonusStatus = explode(',', $bau_data['num']); // Array com os IDs dos baús abertos
                }
            }

            $userData = array(
                "status" => true,
                "data" => array(
                    "ValidInviteCount" => $datres['pessoas_convidadas'],
                    "BonusStatus" => 0, // Retorna o array com os IDs dos baús abertos
                ),
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0, // indica falha
            "msg" => "Token não fornecido",
            "time" => time(),
            "data" => null,
        ];
        echo json_encode($response);
    }
}

#getboxlist
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'promo/invite/list') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $response = getBoxList($mysqli, $_COOKIE['token_user']);
        echo json_encode($response);
    } else {
        $response = [
            "code" => 0,
            "msg" => "Token não fornecido",
            "time" => time(),
            "data" => null,
        ];
        echo json_encode($response);
    }
}
#getboxlist
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/Config/platformLink') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $response = [
            "status" => true,
            "data" => [
                "telegram" => "https://t.me/grupoblend",
                "facebook" => "",
                "twitter" => "",
                "instagram" => "",
                "AppDownloadBonus" => "1",
                "ValidInviteWagedReq" => 0,
                "ValidInviteMinDeposit" => 10,
            ],
        ];
        echo json_encode($response);
    } else {
        $response = [
            "code" => 0,
            "msg" => "Token não fornecido",
            "time" => time(),
            "data" => null,
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
#addBoxList
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'promo/invite/open') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        // Verificar o token
        $qry = "SELECT * FROM usuarios WHERE token = '" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) === 0) {
            $array = [
                "code" => 0,
                "msg" => "Faça login primeiramente",
                "time" => time(),
                "data" => null,
            ];
        } else {
            $datres = mysqli_fetch_assoc($resp);
            if (isset($data['mem_count']) && !empty($data['mem_count'])) {
                $numerobau = $data['mem_count'];

                // Obter a lista de baús para o usuário
                $boxList = getBoxList($mysqli, $_COOKIE['token_user']);
                $baus = $boxList['data']['list'];
                $valorbau = 0;
                $bau_id = null; // Variável para armazenar o 'sort' do baú

                // Encontrar o valor e o ID (sort) do baú correspondente
                foreach ($baus as $bau) {
                    if ($bau['sort'] == $numerobau) {
                        $valorbau = $bau['bonus_amount']; // O campo 'bonus' contém o valor do baú
                        $bau_id = $bau['sort']; // Salvar o ID do baú correspondente
                        break; // Saia do loop ao encontrar o baú
                    }
                }

                if ($valorbau > 0 && $bau_id !== null) {
                    // Buscar o valor atual de 'num' na tabela 'bau' para o usuário específico
                    $qry = "SELECT num FROM bau WHERE token='" . $_COOKIE['token_user'] . "'";
                    $resp = mysqli_query($mysqli, $qry);
                    $row = mysqli_fetch_assoc($resp);
                    $nums = $row['num'];

                    // Adicionar o novo número do baú ao valor existente
                    if (!empty($nums)) {
                        $numsArray = explode(',', $nums);
                        if (!in_array($bau_id, $numsArray)) { // Verificar se o ID do baú já não está presente
                            $numsArray[] = $bau_id; // Adicionar o novo ID do baú
                            $newNums = implode(',', $numsArray);
                        } else {
                            $newNums = $nums; // O número já está presente
                        }
                    } else {
                        $newNums = $bau_id; // Primeira vez que está adicionando o ID do baú
                    }

                    // Atualizar o valor do campo 'num' na tabela 'bau'
                    $abrirbau_qry = "UPDATE bau SET num='$newNums' WHERE token='" . $_COOKIE['token_user'] . "'";
                    $abrirbau_resp = mysqli_query($mysqli, $abrirbau_qry);

                    if (mysqli_affected_rows($mysqli) >= 1) {
                        // Chamar a função enviarSaldo
                        if (enviarsaldoAfiliado($datres['mobile'], $valorbau)) {
                            $array = [
                                'status' => true, // Sucesso
                                'msg' => null,
                                'data' => '1000',
                            ];
                        } else {
                            $array = [
                                'status' => true, // Sucesso
                                'msg' => 'Erro ao enviar saldo',
                                'data' => '1006',
                            ];
                        }
                    } else {
                        $array = [
                            "code" => 0,
                            "msg" => "Erro ao resgatar baú",
                            "time" => time(),
                            "data" => null,
                        ];
                    }
                } else {
                    $array = [
                        "code" => 0,
                        "msg" => "Valor do baú não encontrado ou inválido",
                        "time" => time(),
                        "data" => null,
                    ];
                }
            } else {
                $array = [
                    "code" => 0,
                    "msg" => "Número do baú não fornecido",
                    "time" => time(),
                    "data" => null,
                ];
            }
        }
    } else {
        $array = [
            "code" => 0,
            "msg" => "Token não fornecido",
            "time" => time(),
            "data" => null,
        ];
    }

    $jsonData = json_encode($array);
    echo $jsonData;
}

// Parte De Agente

#=================================================================================================#
// Função De Mostrar Subordinados E Link De Ref
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/link/list?') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $userData = [
                "status" => true,
                "data" => [
                    [
                        "id" => $datres["id"],
                        "uid" => $datres["id"],
                        "username" => $datres["mobile"],
                        "short_url" => "id=" . $datres["invite_code"],
                        "code" => $datres["invite_code"],
                        "prefix" => "",
                        "created_at" => "",
                        "tester" => "",
                    ],
                ],
                "msg" => null,
            ];

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
// Meus dados
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == '/Proxy/QueryProxyChildInfo') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $invitationCode = $datres['invite_code']; // Obtém o código de convite do usuário principal

            // Inicializa valores como zero
            $totalDeposits = 0;
            $firstDepositCount = 0;
            $commission = 0;

            $levelBTotalDeposits = 0;
            $levelBFirstDepositCount = 0;
            $levelBCommission = 0;

            $levelCTotalDeposits = 0;
            $levelCFirstDepositCount = 0;
            $levelCCommission = 0;

            // Consulta para obter IDs dos afiliados de nível A (diretos)
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$invitationCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);
            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            if (!empty($invitedUserIds)) {
                $invitedUserIdsStr = implode(',', $invitedUserIds); // Converte o array de IDs em uma string para usar na consulta

                // Total de depósitos pagos dos afiliados de nível A
                $depositQuery = "SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits FROM transacoes WHERE usuario IN ($invitedUserIdsStr) AND status = 'pago'";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                if ($depositResult) {
                    $depositData = mysqli_fetch_assoc($depositResult);
                    $totalDeposits = (float) $depositData['totalDeposits'];
                    $firstDepositCount = (int) $depositData['depositCount'];

                    // Quantidade de primeiros depósitos
                    $firstDepositQuery = "SELECT COUNT(DISTINCT usuario) as firstDepositCount FROM transacoes WHERE usuario IN ($invitedUserIdsStr) AND status = 'pago'";
                    $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                    if ($firstDepositResult) {
                        $firstDepositData = mysqli_fetch_assoc($firstDepositResult);
                        $firstDepositCount = (int) $firstDepositData['firstDepositCount'];
                    }

                    // Valor fixo do CPA
                    $cpaValue = $data_afiliados_cpa_rev['cpaLvl1']; // Valor padrão

                    // Calcule a comissão
                    $commission = $firstDepositCount * $cpaValue;
                }

                // Consulta para afiliados de nível B
                $levelBQuery = "SELECT id FROM usuarios WHERE invitation_code IN ($invitedUserIdsStr)";
                $levelBResult = mysqli_query($mysqli, $levelBQuery);
                $levelBUserIds = [];
                while ($row = mysqli_fetch_assoc($levelBResult)) {
                    $levelBUserIds[] = $row['id'];
                }

                if (!empty($levelBUserIds)) {
                    $levelBUserIdsStr = implode(',', $levelBUserIds); // Converte o array de IDs em uma string para usar na consulta

                    // Total de depósitos pagos dos afiliados de nível B
                    $levelBDepositQuery = "SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits FROM transacoes WHERE usuario IN ($levelBUserIdsStr) AND status = 'pago'";
                    $levelBDepositResult = mysqli_query($mysqli, $levelBDepositQuery);
                    if ($levelBDepositResult) {
                        $levelBDepositData = mysqli_fetch_assoc($levelBDepositResult);
                        $levelBTotalDeposits = (float) $levelBDepositData['totalDeposits'];
                        $levelBFirstDepositCount = (int) $levelBDepositData['depositCount'];

                        // Calcule a comissão para nível B
                        $levelBCommission = $levelBFirstDepositCount * $cpaValue;
                    }

                    // Consulta para afiliados de nível C
                    $levelCQuery = "SELECT id FROM usuarios WHERE invitation_code IN ($levelBUserIdsStr)";
                    $levelCResult = mysqli_query($mysqli, $levelCQuery);
                    $levelCUserIds = [];
                    while ($row = mysqli_fetch_assoc($levelCResult)) {
                        $levelCUserIds[] = $row['id'];
                    }

                    if (!empty($levelCUserIds)) {
                        $levelCUserIdsStr = implode(',', $levelCUserIds); // Converte o array de IDs em uma string para usar na consulta

                        // Total de depósitos pagos dos afiliados de nível C
                        $levelCDepositQuery = "SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits FROM transacoes WHERE usuario IN ($levelCUserIdsStr) AND status = 'pago'";
                        $levelCDepositResult = mysqli_query($mysqli, $levelCDepositQuery);
                        if ($levelCDepositResult) {
                            $levelCDepositData = mysqli_fetch_assoc($levelCDepositResult);
                            $levelCTotalDeposits = (float) $levelCDepositData['totalDeposits'];
                            $levelCFirstDepositCount = (int) $levelCDepositData['depositCount'];

                            // Calcule a comissão para nível C
                            $levelCCommission = $levelCFirstDepositCount * $cpaValue;
                        }
                    }
                }
            }

            $userData = array(
                "status" => true,
                "data" => array(
                    "ChildCounts" => isset($datres['pessoas_convidadas']) ? (int) $datres['pessoas_convidadas'] : 0,
                    "OtherCounts" => isset($datres['outros_counts']) ? (int) $datres['outros_counts'] : 0, // Ajuste conforme necessário
                    "ChildWaged" => $totalDeposits,
                    "OtherdWaged" => $levelBTotalDeposits,
                    "ChildWageReturn" => $levelBCommission, // Ajuste conforme necessário
                    "OtherWageReturn" => $levelCCommission, // Ajuste conforme necessário
                    "ChildCommi" => $commission,
                    "OtherCommi" => $levelBCommission,
                    "LevelCCommi" => $levelCCommission,
                ),
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/rebate/agency/brief') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];

            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            if (count($invitedUserIds) > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Exemplo: Quantidade de primeiros depósitos pagos (um por cada afiliado)
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Exemplo: Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                // Verificar se os dados foram retornados corretamente
                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;
            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;
            }

            // Construindo a resposta com os valores zeros como solicitado
            $userData = array(
                "status" => true,
                "data" => [
                    "parent_uid" => 0,
                    "paid_amount" => 0,
                    "total_bet_amount" => 0,
                    "total_amount" => 0,
                    "last_paid_amount" => 0,
                    "last_total_amount" => 0,
                    "total_num" => 0,
                    "child1_total_num" => isset($datres['pessoas_convidadas']) ? (int) $datres['pessoas_convidadas'] : 0,
                    "child1_total_amount" => 0,
                    "other_total_num" => 0,
                    "other_total_amount" => 0,
                    "net_amount" => 0,
                    "valid_bet_amount" => 0,
                    "bet_num" => 0
                ],
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}

// Meus dados 2
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/agency/mydata') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];

            // Pega o saldo_afiliados do usuário principal
            $cgRebate = isset($datres['saldo_afiliados']) ? $datres['saldo_afiliados'] : 0;

            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            // Número total de usuários indicados
            $totalInvitedUsers = count($invitedUserIds);

            if ($totalInvitedUsers > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Filtra usuários que realizaram depósitos pagos
                $depositingUsersQuery = "
                    SELECT DISTINCT usuario
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositingUsersResult = mysqli_query($mysqli, $depositingUsersQuery);
                $depositingUsersCount = mysqli_num_rows($depositingUsersResult);

                // Calcula o desempenho (percentual de indicados que depositaram)
                $performance = ($depositingUsersCount / $totalInvitedUsers) * 100;

                // Quantidade de primeiros depósitos pagos
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;
            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;
                $performance = 0.00; // Sem indicados, desempenho é zero
            }

            // Construindo a resposta com os valores calculados
            $userData = array(
                "status" => true,
                "data" => array(
                    "add_lvl1_num" => $totalInvitedUsers,
                    "first_deposit_count" => $firstDepositCount,
                    "deposit_mem_count" => $depositCount,
                    "deposit_amount" => $totalDeposits,
                    "valid_bet_amount" => round($performance), // Desempenho arredondado a 2 casas decimais
                    "cg_rebate" => $cgRebate
                ),
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}


if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/agency/alldata') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];

            $cgRebate = isset($datres['saldo_afiliados']) ? $datres['saldo_afiliados'] : 0;

            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            if (count($invitedUserIds) > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Exemplo: Quantidade de primeiros depósitos pagos (um por cada afiliado)
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Exemplo: Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                // Verificar se os dados foram retornados corretamente
                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;

                // Aqui é onde você deve ajustar os valores conforme o seu cálculo necessário
                $child_lvl1_num = $firstDepositCount; // Por exemplo
                $child_lvl1_validbet = $totalDeposits; // Por exemplo

            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;

                // Valores baseados na ausência de convidados
                $child_lvl1_num = 0;
                $child_lvl1_validbet = 0;
            }

            // Construindo a resposta com os valores calculados
            $userData = array(
                "status" => true,
                "data" => array(
                    "child_num" => count($invitedUserIds),  // Número de usuários convidados
                    "child_lvl1_num" => count($invitedUserIds),  // Número de afiliados de primeiro nível
                    "child_other_num" => 0,  // Outros níveis, ajuste se necessário
                    "child_validbet" => $totalDeposits,  // Soma dos valores de depósito
                    "child_lvl1_validbet" => $child_lvl1_validbet,  // Total de depósitos do nível 1
                    "child_other_validbet" => 0,  // Ajuste conforme necessário para outros níveis
                    "rebate_all" => $cgRebate,  // Ajuste conforme necessário para rebate total
                    "rebate_lvl1" => $cgRebate,  // Ajuste conforme necessário para rebate do nível 1
                    "rebate_other" => 0  // Ajuste conforme necessário para rebate de outros níveis
                ),
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/agency/report/sub/plat') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];

            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            if (count($invitedUserIds) > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Exemplo: Quantidade de primeiros depósitos pagos (um por cada afiliado)
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Exemplo: Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                // Verificar se os dados foram retornados corretamente
                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;

                // Aqui é onde você deve ajustar os valores conforme o seu cálculo necessário
                $child_lvl1_num = $firstDepositCount; // Por exemplo
                $child_lvl1_validbet = $totalDeposits; // Por exemplo

            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;

                // Valores baseados na ausência de convidados
                $child_lvl1_num = 0;
                $child_lvl1_validbet = 0;
            }

            // Construindo a resposta com os valores calculados
            $userData = array(
                "status" => true,
                "data" => array(
                    "child_num" => count($invitedUserIds),  // Número de usuários convidados
                    "child_lvl1_num" => count($invitedUserIds),  // Número de afiliados de primeiro nível
                    "child_other_num" => 0,  // Outros níveis, ajuste se necessário
                    "child_validbet" => $totalDeposits,  // Soma dos valores de depósito
                    "child_lvl1_validbet" => $child_lvl1_validbet,  // Total de depósitos do nível 1
                    "child_other_validbet" => 0,  // Ajuste conforme necessário para outros níveis
                    "rebate_all" => 0,  // Ajuste conforme necessário para rebate total
                    "rebate_lvl1" => 0,  // Ajuste conforme necessário para rebate do nível 1
                    "rebate_other" => 0  // Ajuste conforme necessário para rebate de outros níveis
                ),
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/agent/sub/member') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
//        $qry2 = "SELECT chanceCpa FROM afiliados_config";
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);
//        $resp2 = mysqli_query($mysqli, $qry2);

        if (mysqli_num_rows($resp) > 0) {
//           $chanceCpa = mysqli_fetch_assoc($resp2)["chanceCpa"];
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];
            
            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

//            $chanceCpa_Valited = count($invitedUserIds) * ($chanceCpa / 100);  LIMIT $chanceCpa_Valited
            // Consulta para obter os usuários que entraram pelo invite_code do usuário autenticado
            $qry_subs = "SELECT * FROM usuarios WHERE invitation_code='" . $inviteCode . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_users = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                // Buscar o primeiro depósito do usuário convidado
                $firstDepositQuery = "
                    SELECT valor 
                    FROM transacoes 
                    WHERE usuario = '" . $sub['id'] . "' AND status = 'pago' 
                    ORDER BY data_hora ASC 
                    LIMIT 1
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositData = mysqli_fetch_assoc($firstDepositResult);
                $firstDepositAmount = isset($firstDepositData['valor']) ? $firstDepositData['valor'] : "0.00";

                $totalBetQuery = "
                    SELECT SUM(bet_money) as totalBet
                    FROM historico_play
                    WHERE id_user = '" . $sub['id'] . "'
                ";
                $totalBetResult = mysqli_query($mysqli, $totalBetQuery);
                $totalBetData = mysqli_fetch_assoc($totalBetResult);
                $totalBetAmount = isset($totalBetData['totalBet']) ? $totalBetData['totalBet'] : "0.00";

                $createdAt = date('Y-m-d H:i:s', strtotime($sub['data_cad']));

                $sub_users[] = [
                    'username' => $sub['id'],
                    'level' => 0,
                    'money' => "0.00",
                    'bet_amount' => $totalBetAmount,
                    'deposit_amount' => $firstDepositAmount,  // Use o valor do primeiro depósito
                    'is_recharge' => 0,
                    'is_good' => 0,
                    'created_at' => $createdAt,
                ];
            }

            if (count($invitedUserIds) > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Exemplo: Quantidade de primeiros depósitos pagos (um por cada afiliado)
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Exemplo: Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                // Verificar se os dados foram retornados corretamente
                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;
            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;
            }

            // Construindo a resposta com os valores zeros como solicitado
            $userData = array(
                "status" => true,
                "data" => [
                    "t" => 0,
                    "d" => $sub_users,
                    "extra" => [
                        "total_deposit_amount" => $totalDeposits,
                        "total_first_deposit_num" => $firstDepositCount,
                        "other_deposit_amount" => 0,
                        "other_first_deposit_num" => 0,
                        "direct_deposit_amount" => 0,
                        "direct_first_deposit_num" => 0
                    ]
                ],
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#

if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'promo/invite/record/detail') {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);

        // Busca o usuário principal com base no token
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $inviteCode = $datres['invite_code'];

            // Busca os usuários convidados pelo usuário principal
            $invitedUsersQuery = "SELECT id FROM usuarios WHERE invitation_code = '$inviteCode'";
            $invitedUsersResult = mysqli_query($mysqli, $invitedUsersQuery);

            $invitedUserIds = [];
            while ($row = mysqli_fetch_assoc($invitedUsersResult)) {
                $invitedUserIds[] = $row['id'];
            }

            // Consulta para obter os usuários que entraram pelo invite_code do usuário autenticado
            $qry_subs = "SELECT * FROM usuarios WHERE invitation_code='" . $inviteCode . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_users = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                // Buscar o primeiro depósito do usuário convidado
                $firstDepositQuery = "
                    SELECT valor 
                    FROM transacoes 
                    WHERE usuario = '" . $sub['id'] . "' AND status = 'pago' 
                    ORDER BY data_hora ASC 
                    LIMIT 1
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositData = mysqli_fetch_assoc($firstDepositResult);
                $firstDepositAmount = isset($firstDepositData['valor']) ? $firstDepositData['valor'] : "0.00";

                $totalBetQuery = "
                    SELECT SUM(bet_money) as totalBet
                    FROM historico_play
                    WHERE id_user = '" . $sub['id'] . "'
                ";
                $totalBetResult = mysqli_query($mysqli, $totalBetQuery);
                $totalBetData = mysqli_fetch_assoc($totalBetResult);
                $totalBetAmount = isset($totalBetData['totalBet']) ? $totalBetData['totalBet'] : "0.00";

                $createdAt = date('Y-m-d H:i:s', strtotime($sub['data_cad']));

                $sub_users[] = [
                    'username' => $sub['id'],
                    'level' => 0,
                    'money' => "0.00",
                    'bet_amount' => $totalBetAmount,
                    'deposit_amount' => $firstDepositAmount,  // Use o valor do primeiro depósito
                    'is_recharge' => 0,
                    'is_good' => 0,
                    'created_at' => $createdAt,
                ];
            }

            if (count($invitedUserIds) > 0) {
                $invitedUserIdsStr = implode(',', $invitedUserIds);

                // Exemplo: Quantidade de primeiros depósitos pagos (um por cada afiliado)
                $firstDepositQuery = "
                    SELECT COUNT(DISTINCT usuario) as firstDepositCount
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $firstDepositResult = mysqli_query($mysqli, $firstDepositQuery);
                $firstDepositCount = mysqli_fetch_assoc($firstDepositResult)['firstDepositCount'];

                // Exemplo: Total de depósitos pagos e soma dos valores
                $depositQuery = "
                    SELECT COUNT(*) as depositCount, SUM(valor) as totalDeposits
                    FROM transacoes
                    WHERE usuario IN ($invitedUserIdsStr)
                    AND status = 'pago'
                ";
                $depositResult = mysqli_query($mysqli, $depositQuery);
                $depositData = mysqli_fetch_assoc($depositResult);

                // Verificar se os dados foram retornados corretamente
                $depositCount = isset($depositData['depositCount']) ? $depositData['depositCount'] : 0;
                $totalDeposits = isset($depositData['totalDeposits']) ? $depositData['totalDeposits'] : 0;
            } else {
                // Se não houver usuários convidados, os valores serão zero
                $firstDepositCount = 0;
                $depositCount = 0;
                $totalDeposits = 0.00;
            }

            // Construindo a resposta com os valores zeros como solicitado
            $userData = array(
                "status" => true,
                "data" => [
                    "t" => 0,
                    "d" => $sub_users,
                    "extra" => [
                        "total_deposit_amount" => $totalDeposits,
                        "total_first_deposit_num" => $firstDepositCount,
                        "other_deposit_amount" => 0,
                        "other_first_deposit_num" => 0,
                        "direct_deposit_amount" => 0,
                        "direct_first_deposit_num" => 0
                    ]
                ],
                "msg" => null
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "status" => false,
                "data" => null,
                "msg" => "Usuário sem efetuar login",
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "status" => false,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && ($_REQUEST['expfygaming'] == 'member/info?' || $_REQUEST['expfygaming'] == 'member/short/info?')) {
    // Verifica se o cookie 'token_user' está definido e não está vazio
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $user_id = $datres['id'];

            //VIP CONFIG
            $vip_level = mysqli_query($mysqli, "SELECT * FROM vip_levels")->fetch_all();
            $valor_lvl_atual = mysqli_query($mysqli, "SELECT SUM(bet_money) as money FROM historico_play WHERE id_user = '{$user_id}'")->fetch_assoc()['money'] ?? 0;
            $lvl_atual_db = empty($datres['lvl_vip']) ? 1 : $datres['lvl_vip'];
            $valor_nivel = 0;
            $valor_bonus = 0;
            $lvl_atual = $lvl_atual_db;

            $requisitos_niveis = [];
            $bonus_niveis = [];

            $indice = 1;
            foreach ($vip_level as $v) {
                if(isset($v[2]) && isset($v[3])){
                    $requisitos_niveis[$indice] = $v[2]; // Segundo campo para requisito
                    $bonus_niveis[$indice] = $v[3];     // Terceiro campo para bônus
                    $indice++;
                }
            }

            //die(print_r($requisitos_niveis));
            if(count($requisitos_niveis) > 0 && count($bonus_niveis) > 0){
                foreach ($requisitos_niveis as $nivel => $requisito) {
                    if ($valor_lvl_atual >= $requisito) {
                        $lvl_atual = $nivel + 1;
                        $valor_bonus = $bonus_niveis[$lvl_atual - 1];
                        $valor_nivel = $requisitos_niveis[$lvl_atual];
                    } else {
                        $valor_bonus = isset($bonus_niveis[$lvl_atual-1]) ? $bonus_niveis[$lvl_atual-1] : 0;
                        $valor_nivel = $requisitos_niveis[$lvl_atual];
                        break;
                    }
                }
    
                if ($lvl_atual > $lvl_atual_db) {
                    $data_atual = date('Y-m-d H:m:s');
                    mysqli_query($mysqli, "INSERT INTO historico_vip SET id_user = '{$user_id}', bonus = '{$valor_bonus}', data = '{$data_atual}'");
                    mysqli_query($mysqli, "UPDATE usuarios SET lvl_vip = '{$lvl_atual}', saldo = saldo + '{$valor_bonus}' WHERE id = '{$user_id}'");
                }
    
                $proximo_lvl = $lvl_atual + 1;
            }

            $userData = array(
                "status" => true,
                "data" => [
                    "uid" => $user_id,
                    "username" => $datres['mobile'],
                    "password" => "0",
                    "birth" => "0",
                    "realname" => "",
                    "email" => "",
                    "phone" => "+55*******",
                    "zalo" => "",
                    "prefix" => "f51",
                    "tester" => "1",
                    "withdraw_pwd" => 0,
                    "regip" => "2804:15fc:1013:7601:d9b5:26b6:ded1:f82a",
                    "reg_device" => "xbwrlskpkz4b67ygeadbpj08hkssujif",
                    "reg_url" => "https://caowin.com/?id=205158614",
                    "created_at" => 1725613453,
                    "last_login_ip" => "2804:15fc:1013:7601:d9b5:26b6:ded1:f82a",
                    "last_login_at" => 1725618194,
                    "source_id" => 1,
                    "first_deposit_at" => 0,
                    "first_deposit_amount" => "0.000",
                    "first_bet_at" => 0,
                    "first_bet_amount" => "0.000",
                    "second_deposit_at" => 0,
                    "second_deposit_amount" => "0.000",
                    "top_uid" => "174474690",
                    "top_name" => "xingchencaowin",
                    "parent_uid" => "205158614",
                    "parent_name" => "marciotb",
                    "bankcard_total" => 0,
                    "last_login_device" => "y4670ybncamy9l2mf59zvzlgme50cwaj",
                    "last_login_source" => 24,
                    "remarks" => "",
                    "state" => 1,
                    "level" => $lvl_atual,
                    "balance" => "0.0000",
                    "lock_amount" => "0.0000",
                    "commission" => "0.0000",
                    "group_name" => "xingchencaowin",
                    "agency_type" => 391,
                    "address" => "",
                    "avatar" => "1",
                    "last_withdraw_at" => "0",
                    "automatic" => 1,
                    "facebook" => "",
                    "whatsapp" => "",
                    "telegram" => "",
                    "twitter" => "",
                    "referer" => "",
                    "link_id" => "",
                    "device" => 0,
                    "fphone" => "",
                    "total_dept_amount" => "0.000",
                    "total_wdraw_amount" => "0.000",
                    "link_black_list" => 0,
                    "next" => $valor_nivel,
                    "now" => $valor_lvl_atual,
                    "rate" => "0.00000",
                    "next_level" => $proximo_lvl,
                    "rebate_amount" => "",
                    "agency_amount" => "",
                    "token" => $datres['token'],
                ],
                "msg" => null,
            );

            // Converte o array associativo para JSON
            echo json_encode($userData);
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'member/balance?') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $token = mysqli_real_escape_string($mysqli, $_COOKIE['token_user']);
        $qry = "SELECT * FROM usuarios WHERE token='$token'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datres = mysqli_fetch_assoc($resp);
            $userData = array(
                "status" => true,
                "data" => [
                    "uid" => $datres['id'],
                    "balance" => $datres['saldo'],
                    "lock_amount" => "0",
                ],
            );

            echo json_encode($userData);
        } else {
            $response = [
                "code" => 0, 
                "msg" => "Usuário sem efetuar login", 
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Token não encontrado ou inválido",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
#rechargeConfigList
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'rechargeConfigList') {
    //$jsonDataModificado = $data;
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $response = [
                "code" => 1,
                "msg" => "OK",
                "time" => "1715817864",
                "data" => [
                    "config_list" => [
                        [
                            "id" => 5,
                            "min_money" => 30,
                            "max_money" => "49.00",
                            "typing_amount" => "6.00",
                            "gift_amount" => 2,
                            "create_time" => time(),
                            "update_time" => 1709122728,
                        ],
                        [
                            "id" => 6,
                            "min_money" => 50,
                            "max_money" => "99.00",
                            "typing_amount" => "12.00",
                            "gift_amount" => 3,
                            "create_time" => time(),
                            "update_time" => 1709122786,
                        ],
                        [
                            "id" => 7,
                            "min_money" => 100,
                            "max_money" => "299.00",
                            "typing_amount" => "20.00",
                            "gift_amount" => 6,
                            "create_time" => time(),
                            "update_time" => 1709122827,
                        ],
                        [
                            "id" => 15,
                            "min_money" => 300,
                            "max_money" => "499.00",
                            "typing_amount" => "60.00",
                            "gift_amount" => 20,
                            "create_time" => time(),
                            "update_time" => 1711983980,
                        ],
                        [
                            "id" => 8,
                            "min_money" => 500,
                            "max_money" => "999.00",
                            "typing_amount" => "100.00",
                            "gift_amount" => 35,
                            "create_time" => 1709122848,
                            "update_time" => 1709122848,
                        ],
                        [
                            "id" => 9,
                            "min_money" => 1000,
                            "max_money" => "4999.00",
                            "typing_amount" => "128.00",
                            "gift_amount" => 128,
                            "create_time" => time(),
                            "update_time" => 1709122861,
                        ],
                        [
                            "id" => 14,
                            "min_money" => 3000,
                            "max_money" => "4999.00",
                            "typing_amount" => "333.00",
                            "gift_amount" => 333,
                            "create_time" => time(),
                            "update_time" => 1711983958,
                        ],
                        [
                            "id" => 10,
                            "min_money" => 5000,
                            "max_money" => "9999.00",
                            "typing_amount" => "555.00",
                            "gift_amount" => 555,
                            "create_time" => time(),
                            "update_time" => 1709122882,
                        ],
                        [
                            "id" => 11,
                            "min_money" => 10000,
                            "max_money" => "49999.00",
                            "typing_amount" => "1188.00",
                            "gift_amount" => 1188,
                            "create_time" => time(),
                            "update_time" => 1709122924,
                        ],
                        [
                            "id" => 12,
                            "min_money" => 50000,
                            "max_money" => "999999.00",
                            "typing_amount" => "5688.00",
                            "gift_amount" => 5688,
                            "create_time" => time(),
                            "update_time" => 1709122954,
                        ],
                    ],
                    "is_open" => true,
                ],
            ];
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            ];
        }
    } else {
        $response = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }
    echo json_encode($response);
}
#=================================================================================================#
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] == 'getLink') {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta para obter os usuários que entraram pelo invite_code do usuário autenticado
            $invite_code = $datares['invite_code'];
            $qry_subs = "SELECT COUNT(*) AS total FROM usuarios WHERE invitation_code='" . $invite_code . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);
            $affiliatesCount = 0;
            if ($resp_subs) {
                $subs_data = mysqli_fetch_assoc($resp_subs);
                $affiliatesCount = $subs_data['total'];
            }

            // Use a função simplifyUrl para criar o link simplificado
            $simplifiedLink = simplifyUrl($datares['url'], $datares['invite_code']);
            $array = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "link" => $simplifiedLink,
                    "good_num" => $affiliatesCount,
                    "good_bet" => "50",
                    "good_recharge" => "20",
                ],
            ];
        } else {
            $array = [
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            ];
        }
    } else {
        $array = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }
    $jsonData = json_encode($array);
    // Exibe o JSON resultante (apenas para fins de demonstração)
    echo $jsonData;
}
#=================================================================================================#
#check_pid_info
#AFILIADOS NIVEL A
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'check_pid_info') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta para obter os usuários que entraram pelo invite_code do usuário autenticado
            $invite_code = $datares['invite_code'];
            $qry_subs = "SELECT * FROM usuarios WHERE invitation_code='" . $invite_code . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_users = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                $sub_users[] = [
                    'id' => $sub['id'],
                    'level' => 0,
                    'money' => "0.00",
                    'total_bet_amount' => "0.00",
                    'total_recharge_amount' => "0.00",
                    'is_recharge' => 0,
                    'is_good' => 0,
                    'createtime' => $sub['data_cad'],
                ];
            }

            $response = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "total" => [
                        "num" => count($sub_users),
                        "first_recharge_num" => 0,
                        "good_num" => 0,
                        "total_bet_money" => "0.00",
                        "total_recharge_money" => "0.00",
                        "average_recharge" => 0,
                    ],
                    "users" => $sub_users,
                ],
            ];
            echo json_encode($response);
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#AFILIADOS NIVEL B
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'check_ppid_info') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta para obter os afiliados de nível 1
            $invite_code = $datares['invite_code'];
            $qry_subs = "SELECT id FROM usuarios WHERE invitation_code='" . $invite_code . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_ids_level1 = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                $sub_ids_level1[] = $sub['id'];
            }

            $sub_users_level2 = [];
            if (!empty($sub_ids_level1)) {
                $sub_ids_level1_str = implode("','", $sub_ids_level1);
                $qry_subs_level2 = "SELECT * FROM usuarios WHERE invitation_code IN ('" . $sub_ids_level1_str . "')";
                $resp_subs_level2 = mysqli_query($mysqli, $qry_subs_level2);

                while ($sub2 = mysqli_fetch_assoc($resp_subs_level2)) {
                    $sub_users_level2[] = [
                        'id' => $sub2['id'],
                        'level' => 2,
                        'money' => "0.00",
                        'total_bet_amount' => "0.00",
                        'total_recharge_amount' => "0.00",
                        'is_recharge' => 0,
                        'is_good' => 0,
                        'createtime' => $sub2['data_cad'],
                    ];
                }
            }

            $response = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "total" => [
                        "num" => count($sub_users_level2),
                        "first_recharge_num" => 0,
                        "good_num" => 0,
                        "total_bet_money" => "0.00",
                        "total_recharge_money" => "0.00",
                        "average_recharge" => 0,
                    ],
                    "users" => $sub_users_level2,
                ],
            ];
            echo json_encode($response);
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#AFILIADOS NIVEL C
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'check_pppid_info') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta para obter os afiliados de nível 1
            $invite_code = $datares['invite_code'];
            $qry_subs = "SELECT id FROM usuarios WHERE invitation_code='" . $invite_code . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_ids_level1 = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                $sub_ids_level1[] = $sub['id'];
            }

            $sub_ids_level2 = [];
            if (!empty($sub_ids_level1)) {
                $sub_ids_level1_str = implode("','", $sub_ids_level1);
                $qry_subs_level2 = "SELECT id FROM usuarios WHERE invitation_code IN ('" . $sub_ids_level1_str . "')";
                $resp_subs_level2 = mysqli_query($mysqli, $qry_subs_level2);

                while ($sub2 = mysqli_fetch_assoc($resp_subs_level2)) {
                    $sub_ids_level2[] = $sub2['id'];
                }
            }

            $sub_users_level3 = [];
            if (!empty($sub_ids_level2)) {
                $sub_ids_level2_str = implode("','", $sub_ids_level2);
                $qry_subs_level3 = "SELECT * FROM usuarios WHERE invitation_code IN ('" . $sub_ids_level2_str . "')";
                $resp_subs_level3 = mysqli_query($mysqli, $qry_subs_level3);

                while ($sub3 = mysqli_fetch_assoc($resp_subs_level3)) {
                    $sub_users_level3[] = [
                        'id' => $sub3['id'],
                        'level' => 3,
                        'money' => "0.00",
                        'total_bet_amount' => "0.00",
                        'total_recharge_amount' => "0.00",
                        'is_recharge' => 0,
                        'is_good' => 0,
                        'createtime' => $sub3['data_cad'],
                    ];
                }
            }

            $response = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "total" => [
                        "num" => count($sub_users_level3),
                        "first_recharge_num" => 0,
                        "good_num" => 0,
                        "total_bet_money" => "0.00",
                        "total_recharge_money" => "0.00",
                        "average_recharge" => 0,
                    ],
                    "users" => $sub_users_level3,
                ],
            ];
            echo json_encode($response);
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
#hasWithdrawPassword
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'hasWithdrawPassword') {
    //$jsonDataModificado = $data;
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $resrow = mysqli_fetch_assoc($resp);
            $json = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "is_set" => $resrow['senha_saque'],
                ],
            ];
            // Converte o array associativo para JSON
            $jsonData = json_encode($json);
            // Exibe o JSON resultante (apenas para fins de demonstração)
            echo $jsonData;
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
#getWithdrawInfo
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getWithdrawInfo') {
    //$jsonDataModificado = $data;
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            //$saldo = $datares['saldo'];
            $json = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "min_withdraw_amount" => "{$dataconfig['minsaque']}",
                    "withdraw_rate" => "0",
                    "can_withdraw_amount" => "{$datares['saldo']}",
                    "can_withdraw_commission" => "0.00",
                    "commission_withdraw_rate" => "5",
                    "cpf" => "",
                    "need_bet" => "0.00",
                ],
            ];
            // Converte o array associativo para JSON
            $jsonData = json_encode($json);
            // Exibe o JSON resultante (apenas para fins de demonstração)
            echo $jsonData;
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
#Verificação De Senha De Saque
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == '/member/pay/password/verification') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token=?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param("s", $_COOKIE['token_user']);
        $stmt->execute();
        $resp = $stmt->get_result();

        if ($resp->num_rows > 0) {
            $datares = $resp->fetch_assoc();

            // Verificação da senha de pagamento
            if (isset($data['pay_password']) && !empty($data['pay_password'])) {
                $senha_enviada = $data['pay_password'];
                $senha_armazenada = $datares['senhaparasacar'];

                // Supondo que a senha esteja armazenada como um hash
                // Se a senha estiver armazenada em texto simples, remova ou comente a linha abaixo
                //$senha_correta = password_verify($senha_enviada, $senha_armazenada);

                // Verificação direta de senha em texto simples
                $senha_correta = ($senha_enviada === $senha_armazenada);

                if ($senha_correta) {
                    $response = [
                        "status" => true,
                        "data" => '1000',
                        "time" => time(),
                    ];
                    echo json_encode($response);
                } else {
                    $response = [
                        "status" => false,
                        "data" => '1251',
                        "time" => time(),
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = [
                    "code" => 0,
                    "msg" => "Senha de pagamento não fornecida.",
                    "time" => time(),
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "code" => 0, // Falha
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
#Setar Senha De Saque
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'member/password/update') {
    //$jsonDataModificado = $data;
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $sql = $mysqli->prepare("UPDATE usuarios SET senhaparasacar = ?,senha_saque = 1 WHERE id = ?");
            $sql->bind_param("si", $data['password'], $datares['id']);
            if ($sql->execute()) {
                $response = [
                    "status" => true,
                    "data" => '1000',
                    "msg" => null,
                ];
                echo json_encode($response);
            } else {
                $response = [
                    "code" => 0,
                    "msg" => "Erro ao realizar saque.",
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "code" => 0, // Indica falha
                "msg" => "Usuário sem efetuar login", // Mensagem de erro
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}
#=================================================================================================#
#getUserSubInfo
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getUserSubInfo') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);

            // Consulta para obter os usuários que entraram pelo invite_code do usuário autenticado
            $invite_code = $datares['invite_code'];
            $qry_subs = "SELECT * FROM usuarios WHERE invitation_code='" . $invite_code . "'";
            $resp_subs = mysqli_query($mysqli, $qry_subs);

            $sub_users = [];
            while ($sub = mysqli_fetch_assoc($resp_subs)) {
                $sub_users[] = $sub;
            }

            $response = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "commission_money" => 0,
                    "had_money" => 0,
                    "last_money" => 0,
                    "sub_num" => count($sub_users),
                    "sub_recharge_num" => 0,
                    "sub_recharge_sum" => 0,
                    "sub_bet_sum" => 0,
                    "sub_today_register_num" => 0,
                    "sub_today_recharge_num" => 0,
                    "sub_today_bet" => 0,
                    "sub_users" => $sub_users,
                ],
            ];
            echo json_encode($response);
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário sem efetuar login",
                "time" => time(),
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            "code" => 0,
            "data" => null,
            "msg" => "Usuario ou senha incorretos",
            "time" => time(),
        ];
        echo json_encode($response);
    }
}

#=================================================================================================#
#status
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'status') {
    $response = [
        "status" => "Api Ativa",
    ];
    echo json_encode($response);
}
#=================================================================================================#
#getJackpotNumber
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getJackpotNumber') {
    $response = [
        "code" => 1,
        "msg" => "ok",
        "time" => time(),
        "data" => [
            "money" => "{$dataconfig['jackpot']}",
        ],
    ];
    echo json_encode($response);
}
#=================================================================================================#
#betRecord
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'betRecord') {
    $response = [
        "code" => 1,
        "data" => [],
        "msg" => "ok",
        "time" => time(),
    ];
    echo json_encode($response);
}

#=================================================================================================#
#getCostservice
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getCostservice') {
    $response = [
        "code" => 1,
        "msg" => "ok",
        "time" => time(),
        "data" => [
            [
                "id" => 6,
                "name" => "Canal oficial do Telegram",
                "channel" => "0",
                "url" => $telegram_link,
                "image" => "https://admin.10000xbet.com/uploads/20240119/ffebadadbbf5640e7e55de58c81aa764.webp",
                "content" => "<p><font color=\"#ffffff\">Canal exclusivo do Telegram&nbsp;</font></p><p><font color=\"#ffffff\">Todas as informações da plataforma sobre o nosso cassino serão divulgadas lá🎉🎉🎉</font></p>",
                "weigh" => 6,
                "status" => "1",
                "createtime" => time(),
                "updatetime" => 1714016379,
            ],
            [
                "id" => 1,
                "name" => "Telegram grupo",
                "channel" => "0",
                "url" => $telegram_link,
                "image" => "https://admin.10000xbet.com/uploads/20240119/ffebadadbbf5640e7e55de58c81aa764.webp",
                "content" => "<p><font color=\"#ffffff\"><span style=\"font-size: 14px;\">Existem muitas atividades no grupo Telegram.Recompensas de recarga estão sendo distribuídas no grupo Telegram Você pode trocar suas idéias e experiências com os jogadores. Venha e participe.</span></font><br></p>",
                "weigh" => 3,
                "status" => "1",
                "createtime" => time(),
                "updatetime" => null,
            ],
            [
                "id" => 3,
                "name" => "Suporte Telegram",
                "channel" => "0",
                "url" => $telegram_link,
                "image" => "https://admin.10000xbet.com/uploads/20240119/ffebadadbbf5640e7e55de58c81aa764.webp",
                "content" => "<p><span style=\"font-size: 14px;\"><font color=\"#ffffff\">Atendimento profissional ao cliente, 24 horas online, atendimento atencioso para resolver todos os seus problemas</font></span><br></p>",
                "weigh" => 1,
                "status" => "1",
                "createtime" => null,
                "updatetime" => null,
            ],
        ],
    ];
    echo json_encode($response);
}
#=================================================================================================#
#getTodaybetInfo
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'getTodaybetInfo') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            // Colocar PegarSaldo Aqui
            $obt_saldo = pegarSaldo($datares['mobile'], $datares['id']);
            $response = [
                "code" => 1,
                "msg" => "ok",
                "time" => time(),
                "data" => [
                    "today_bet_amount" => 0,
                    "next_bet" => $datares['saldo'],
                    "next_bet_money" => 0.5,
                    "today_money" => 0,
                    "percent" => "0",
                ],
            ];
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            ];
        }
    } else {
        $response = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }
    echo json_encode($response);
}
#=================================================================================================#
#addrecharge
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'fetchname') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $userId = $datares['id'];

            $qry_payment = "SELECT realname, pix_id FROM metodos_pagamentos WHERE user_id = ?";
            $stmt_payment = $mysqli->prepare($qry_payment);
            $stmt_payment->bind_param("i", $userId); 
            $stmt_payment->execute();
            $stmt_payment->store_result();

            if ($stmt_payment->num_rows > 0) {
                $stmt_payment->bind_result($realname, $pix_id);
                $stmt_payment->fetch();
                
                $response = [
                    'realname' => $realname,
                    'pix_id' => $pix_id,
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false,
                    'username' => $datares['mobile'],
                    'message' => 'Método de pagamento não encontrado.'
                ];
            }
            $stmt_payment->close();
        } else {
            $response = [
                'status' => false,
                'message' => 'Usuário não encontrado.'
            ];
        }
    } else {
        $response = [
            'status' => false,
            'message' => 'Token de usuário não encontrado.'
        ];
    }

    echo json_encode($response);
}


if (isset($_REQUEST['expfygaming']) && $_REQUEST['expfygaming'] === 'finance/third/deposit') {
    global $data_bspay, $data_suitpay, $data_expfypay;

    $nome = $_POST['nome_real'];

    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $valorDeposito = floatval($data['amount']);

            $comissaoCalculada = null;
            $afiliado_id = null;
            $codigo_indicador = $datares['invitation_code'] ?? null;

            if (!empty($codigo_indicador)) {
                $queryAfiliado = "SELECT id, tipo_pagamento, comissao_percentual FROM usuarios WHERE invite_code = '$codigo_indicador' LIMIT 1";
                $resAfiliado = mysqli_query($mysqli, $queryAfiliado);

                if ($resAfiliado && mysqli_num_rows($resAfiliado) > 0) {
                    $dadosAfiliado = mysqli_fetch_assoc($resAfiliado);

                    if (intval($dadosAfiliado['tipo_pagamento']) === 3) {
                        $percentual = floatval($dadosAfiliado['comissao_percentual']);
                        $comissaoCalculada = $valorDeposito * ($percentual / 100);
                        $afiliado_id = $dadosAfiliado['id'];
                    }
                }
            }

            error_log("[ROTA] Valor: $valorDeposito | Comissão: " . ($comissaoCalculada ?? 'null') . " | Afiliado ID: " . ($afiliado_id ?? 'null'));

            if (intval($data_expfypay['ativo']) == 1) {
                $return_data_pix = criarQrexpfypay(
                    $valorDeposito,
                    $datares['real_name'] ?? $datares['username'],
                    $datares['id'],
                    $comissaoCalculada,
                    $afiliado_id
                );
            } elseif (intval($data_bspay['ativo']) == 1) {
                $return_data_pix = criarQrCode(...); // se quiser adaptar depois
            } elseif (intval($data_suitpay['ativo']) == 1) {
                $return_data_pix = criarQrCodeSuitPay(...);
            }

            update_real_name($datares['id'], $nome);

            if (!empty($return_data_pix)) {
                $codePix = $return_data_pix['code'] ?? '';
                $qrcodePix = $return_data_pix['qrcode'] ?? '';
                $transacao_id = $return_data_pix['transaction_id'] ?? '';

                $response = [
                    "status" => true,
                    "data" => [
                        "url" => $url_api_gatewayPix . '?paymentCodeBase64=' . $qrcodePix . '&paymentCode=' . $codePix . '&valorPix=' . $valorDeposito,
                        "transacao_id" => $transacao_id
                    ],
                ];
            } else {
                $response = [
                    "code" => 0,
                    "msg" => "Erro PixApi",
                    "time" => time(),
                ];
            }
        } else {
            $response = [
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            ];
        }
    } else {
        $response = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }

    echo json_encode($response);
}



#=================================================================================================#
#rechargeList
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'rechargeList') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $qrypagamentos = "SELECT * FROM transacoes WHERE usuario='" . $datares['id'] . "'";
            $resppagamentos = mysqli_query($mysqli, $qrypagamentos);
            $dataArray = array();
            if (mysqli_num_rows($resppagamentos) > 0) {
                while ($row = mysqli_fetch_assoc($resppagamentos)) {
                    $dataArray[] = array(
                        "id" => $datares['id'],
                        "uid" => $datares['id'],
                        "root_invite" => "0",
                        "order_no" => $row['id'],
                        "type" => "0",
                        "channel_id" => 7,
                        "money" => $row['valor'],
                        "typing_amount" => $row['valor'],
                        "real_amount" => "0.00",
                        "status" => 0,
                        "real_pay_amount" => "0.00",
                        "time" => $row['data_hora'],
                    );
                }
            }

            $response = array(
                "code" => 1,
                "msg" => "OK",
                "time" => 1720254756370,
                "data" => $dataArray,
            );
        } else {
            $response = array(
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            );
        }
    } else {
        $response = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }
    echo json_encode($response);
}
#=================================================================================================#
#withdrawList
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'withdrawList') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $qrypagamentos = "SELECT * FROM solicitacao_saques WHERE id_user='" . $datares['id'] . "'";
            $resppagamentos = mysqli_query($mysqli, $qrypagamentos);
            $dataArray = array();
            if (mysqli_num_rows($resppagamentos) > 0) {
                while ($row = mysqli_fetch_assoc($resppagamentos)) {
                    $dataArray[] = array(
                        "id" => $datares['id'],
                        "order_no" => $datares['id'],
                        "type" => "0",
                        "channel_id" => 7,
                        "money" => $row['valor'],
                        "fee" => $row['valor'],
                        "typing_amount" => $row['valor'],
                        "real_money" => "0.00",
                        "status" => $row['status'],
                        "phone_number" => $row['telefone'],
                        "real_pay_amount" => "0.00",
                        "time" => $row['data_hora'],
                    );
                }
            }

            $response = array(
                "code" => 1,
                "msg" => "OK",
                "time" => time(),
                "data" => $dataArray,
            );
        } else {
            $response = array(
                "code" => 0,
                "msg" => "Usuário não logado",
                "time" => time(),
            );
        }
    } else {
        $response = [
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        ];
    }
    echo json_encode($response);
}
#=================================================================================================#
#game_launch
// Verificar se 'expfygaming' está definido e se os parâmetros 'id' e 'code' foram passados na URL
if (isset($_REQUEST['expfygaming']) && !empty($_REQUEST['expfygaming']) && strpos($_REQUEST['expfygaming'], 'expfygaming/launch/') !== false) {
    if (isset($_COOKIE['token_user']) && !empty($_COOKIE['token_user'])) {

        // Capturar os parâmetros 'id' e 'code'
        $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : 'null';
        $game_type = isset($_REQUEST['id']) ? $_REQUEST['id'] : 'null';

        if (!empty($code) && !empty($game_type)) {
            // Buscar o usuário pelo token
            $qry = "SELECT * FROM usuarios WHERE token='" . mysqli_real_escape_string($mysqli, $_COOKIE['token_user']) . "'";
            $resp = mysqli_query($mysqli, $qry);

            if (mysqli_num_rows($resp) > 0) {
                $datares = mysqli_fetch_assoc($resp);

                // Determina o game_code e a distribuição
                $provedorInicial = gameprovider($code);
                $game_code = gamecode($code);
                $distribution = distribution($code);

                // Branch para cada integração
                if ($distribution === "Clone") {
                    $gameretur = pegarLinkJogo('PROVEDOR', $game_code, $datares['mobile']);
                } elseif ($distribution === "PlayFiver") {
                    $gameretur = pegarLinkJogoPlayFiver('PROVEDOR', $game_code, $datares['mobile']);
                } elseif ($distribution === "igamewin") {

                    $provider = '';
                    $qryProvider = "SELECT provider FROM games WHERE game_code = '" . mysqli_real_escape_string($mysqli, $game_code) . "' LIMIT 1";
                    $resProvider = mysqli_query($mysqli, $qryProvider);
                    if ($resProvider && mysqli_num_rows($resProvider) > 0) {
                        $gameData = mysqli_fetch_assoc($resProvider);
                        $provider = $gameData['provider'];
                    }

                    if (empty($provider)) {
                        $provider = 'PGSOFT';
                    }
                    $gameretur = pegarLinkJogoigamewin($provider, $game_code, $datares['mobile']);
                } elseif ($distribution === "Pragmatic") {
                    $gameretur = pegarLinkJogoPragmatic('PROVEDOR', $game_code, $datares['mobile']);
                } else {
                    
                    $gameretur = array('gameURL' => null);
                }

                $response = array(
                    "status" => true,
                    "data" => $gameretur['gameURL'],
                );
            } else {
                $response = array(
                    "status" => 0,
                    "msg" => "Usuário não logado [2]",
                );
            }
        } else {
            $response = array(
                "status" => 0,
                "msg" => "Parâmetro 'code' ou 'id' não encontrado",
            );
        }
    } else {
        $response = array(
            "status" => 0,
            "msg" => "Usuário não logado [1]",
        );
    }
    echo json_encode($response);
}


#=================================================================================================#

#=================================================================================================#
#vip_config_list
if (isset($_REQUEST['expfygaming']) and !empty($_REQUEST['expfygaming']) and $_REQUEST['expfygaming'] == 'attbalance') {
    if (isset($_COOKIE['token_user']) and !empty($_COOKIE['token_user'])) {
        $qry = "SELECT * FROM usuarios WHERE token='" . $_COOKIE['token_user'] . "'";
        $resp = mysqli_query($mysqli, $qry);
        if (mysqli_num_rows($resp) > 0) {
            $datares = mysqli_fetch_assoc($resp);
            $obt_saldo = pegarSaldo($datares['mobile'], $datares['id']);
            $response = array(
                "code" => 1,
                "msg" => "ok",
                "saldo" => $obt_saldo,
                "time" => time(),
            );
        }
    } else {
        $response = array(
            "code" => 0,
            "msg" => "Usuário não logado",
            "time" => time(),
        );
    }
    echo json_encode($response);
}
#=================================================================================================#