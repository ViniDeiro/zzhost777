<?php
date_default_timezone_set('America/Sao_Paulo');
include_once('database.php');
include_once('funcao.php');
#=====================================================#
# DATA CONFIG
function data_config()
{
	global $mysqli;
	$qry = "SELECT * FROM config WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$dataconfig = data_config();
#=====================================================#
# DATA POPUPS
function data_popups($id)
{
	global $mysqli;
	$qry = "SELECT * FROM popups WHERE id = '" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
#=====================================================#
# DATA CONFIG
function data_fiverscanPanel()
{
	global $mysqli;
	$qry = "SELECT * FROM fiverscan WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_fiverscanpanel = data_fiverscanPanel();

#=====================================================#
# DATA CONFIG
function data_apipragmatic()
{
	global $mysqli;
	$qry = "SELECT * FROM apipragmatic WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_apipragmatic = data_apipragmatic();

# DATA CONFIG
function data_pgclone()
{
	global $mysqli;
	$qry = "SELECT * FROM pgclone WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_pgclone = data_pgclone();

# DATA CONFIG
function data_igamewin()
{
	global $mysqli;
	$qry = "SELECT * FROM igamewin WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_igamewin = data_igamewin();

function cupom_usado($cupom, $user_id){
    global $mysqli;
    
    $sql = "SELECT id FROM cupom_usados WHERE id_cupom = '{$cupom}' AND id_user = '{$user_id}'";
    $res = mysqli_query($mysqli, $sql);
	//$data = mysqli_fetch_assoc($res);
	$qtd = mysqli_num_rows($res);
	
	return $qtd;
}

function usar_cupom($user_id, $valor){
    global $mysqli;
    
    $sql = "SELECT * FROM cupom";
    $res = mysqli_query($mysqli, $sql);
	$data = mysqli_fetch_all($res);
	$cupons = [];
	
	foreach ($data as $i => $cupom){
	    $cupons[$cupom[0]] = [
	        "valor"    => $cupom[3],
	        "qtd"    => $cupom[4],
	        "qtd_insert"    => $cupom[5],
	        "status"    => $cupom[6],
 	    ];
	}
	

	foreach ($cupons as $id => $cupom) {
	    if (intval($valor) >= intval($cupom['valor']) && $cupom['status'] == 1 && $cupom['qtd'] > 0 && cupom_usado($id, $user_id) == 0) {
	        
	        $horario = date('Y-m-d H:m:s');

	        $insert_saldo = mysqli_query($mysqli, "UPDATE usuarios SET saldo = saldo + {$cupom['qtd_insert']} WHERE id = {$user_id}");
	        $remove_cupom_usado = mysqli_query($mysqli, "UPDATE cupom SET qtd = qtd - 1 WHERE id = {$id}");
	        $insert = mysqli_query($mysqli, "INSERT INTO cupom_usados SET id_user = {$user_id}, id_cupom = {$id}, valor = \"{$cupom['qtd_insert']}\", data_time = '{$horario}'");
	        
	        return [
	            "sucesso" => true,
	            "cupom_id" => $id,
	            "mensagem" => "Cupom válido encontrado.",
	        ];
	    }/*else{
	        return [
        	    "sucesso" => false,
        	    "mensagem" => "Cupom não encontrado ou já utilizado.",
        	];
	    }*/
	}
	
	return [
	    "sucesso" => false,
	    "mensagem" => "Nenhum cupom válido encontrado para o valor especificado.",
	];
}

function enviarSaldo($email, $saldo)
{
    global $data_fiverscanpanel;
    $keys = $data_fiverscanpanel;
    $url = $keys['url'];
    $num = floatval($saldo);

    $data = array(
        "method" => "user_deposit",
        'agent_code' => $keys['agent_code'],
        'agent_token' => $keys['agent_token'],
        'user_code' => $email,
        "amount" => $num
    );

    $json_data = json_encode($data);
    logMessage("Dados JSON enviados: " . $json_data);
    $response = enviarRequest('https://api.payigaming.com.br/', $json_data);
    logMessage("Resposta da API: " . $response);

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logMessage("Erro ao decodificar JSON: " . json_last_error_msg());
        return ['success' => false, 'message' => 'Erro de decodificação JSON']; // Retorna uma estrutura
    }

    if (isset($data['msg']) && $data['msg'] === 'SUCCESS') {
        return ['success' => true, 'message' => 'Saldo adicionado com sucesso.']; // Retorna uma estrutura
    } else {
        return ['success' => false, 'message' => $data['msg'] ?? 'Erro desconhecido']; // Retorna uma estrutura
    }
}

function withdrawSaldo($email, $saldo)
{
    global $data_fiverscanpanel;
    $keys = $data_fiverscanpanel;
    $num = floatval($saldo);

    // Verifique se o saldo é um número positivo
    if ($num <= 0) {
        return ['success' => false, 'message' => 'Valor inválido para retirada.'];
    }

    // Montar os dados da solicitação
    $data = array(
        "method" => "user_withdraw",
        'agent_code' => $keys['agent_code'],
        'agent_token' => $keys['agent_token'],
        'user_code' => $email,
        "amount" => $num
    );

    $json_data = json_encode($data);
    logMessage("Dados JSON para withdraw: " . $json_data); // Loga os dados enviados
    $response = enviarRequest('https://api.payigaming.com.br/', $json_data);
    logMessage("Resposta da API: " . $response); // Loga a resposta da API

    // Decodificar a resposta da API
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logMessage("Erro ao decodificar JSON: " . json_last_error_msg());
        return ['success' => false, 'message' => 'Erro de decodificação JSON'];
    }

    // Verifique se a resposta contém a mensagem de sucesso ou erro
    if (isset($data['msg']) && $data['msg'] === 'SUCCESS') {
        return ['success' => true, 'message' => 'Saldo removido com sucesso.'];
    } else {
        logMessage("Erro na resposta da API: " . print_r($data, true)); // Loga a resposta completa
        return ['success' => false, 'message' => $data['msg'] ?? 'Erro desconhecido'];
    }
}


#=====================================================#
function afiliado_de_quem($invitation_code_usado) {
    global $mysqli;

    if (empty($invitation_code_usado)) {
        return 'Sem afiliação';
    }

    $query = "SELECT id, mobile FROM usuarios WHERE invite_code = ? LIMIT 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $invitation_code_usado);
    $stmt->execute();
    $stmt->bind_result($id, $mobile);
    $stmt->fetch();
    $stmt->close();

    return $mobile ? "[$id] $mobile" : 'Não encontrado';
}
function dados_afiliador($invitation_code) {
    global $mysqli;

    if (empty($invitation_code)) {
        return null;
    }

    $query = "SELECT id, mobile FROM usuarios WHERE invite_code = ? LIMIT 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $invitation_code);
    $stmt->execute();
    $stmt->bind_result($id, $mobile);
    $stmt->fetch();
    $stmt->close();

    if ($id) {
        return ['id' => $id, 'mobile' => $mobile];
    }

    return null;
}
#=====================================================#
# DATA CONFIG SUITPAY
function data_suitpay()
{
	global $mysqli;
	$qry = "SELECT * FROM suitpay WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_suitpay = data_suitpay();
# saldo api fiverscan

#=====================================================#
# DATA CONFIG BSPAY
function data_bspay()
{
	global $mysqli;
	$qry = "SELECT * FROM bspay WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_bspay = data_bspay();
# saldo api fiverscan

#=====================================================#
# DATA CONFIG EXPFYPAY
function data_expfypay()
{
	global $mysqli;
	$qry = "SELECT * FROM expfypay WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_expfypay = data_expfypay();
# saldo api fiverscan
#=====================================================#
# DATA CONFIG
function data_afiliados_cpa_rev()
{
	global $mysqli;
	$qry = "SELECT * FROM afiliados_config WHERE id=1";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}
$data_afiliados_cpa_rev = data_afiliados_cpa_rev();
#=====================================================#
#criar financeiro
function criar_financeiro($id)
{
	global $mysqli;
	$sql1 = $mysqli->prepare("INSERT INTO financeiro (usuario,saldo,bonus) VALUES (?,0,0)");
	$sql1->bind_param("i", $id);
	if ($sql1->execute()) {
		$tr = 1; //certo
	} else {
		$tr = 0; //erro
	}
	return $tr;
}

# count saque
function tabelasaldouser($id)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE id='" . intval($id) . "'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['saldo'] > 0) {
			$dinheiro = $row['saldo'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}
#=====================================================#
#criar financeiro
function criar_tokenrefer($id)
{
	global $mysqli;
	$aftoken = 'af' . $id . token_aff();
	$sql = $mysqli->prepare("UPDATE usuarios SET token_refer=? WHERE id=?");
	$sql->bind_param("si", $aftoken, $id);
	if ($sql->execute()) {
		$tr = 1; //certo
	} else {
		$tr = 0; //erro

	}
	return $tr;
}
#=====================================================#
// request curl (fiverscan)
function enviarRequest($url, $config)
{
    $ch = curl_init();
    $headerArray = ['Content-Type: application/json'];

    // Configurando as opções do cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $config);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Não recomendado em produção

    // Executando a requisição e obtendo a resposta
    $response = curl_exec($ch);

    // Verificando se houve erro na execução do cURL
    if ($response === false) {
        logMessage("Erro cURL: " . curl_error($ch)); // Loga o erro do cURL
    }

    // Fechando a conexão cURL
    curl_close($ch);
    return $response;
}


function logMessage($message) {
    $logFile = 'log.txt'; // Caminho para o arquivo de log
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
}


#=====================================================#
// saldo atual do user
function saldo_user($id)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE id='" . intval($id) . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$data = mysqli_fetch_assoc($res);
		$saldo_arr = array(
			"saldo" => $data['saldo'],
			"saldo_afiliado" => $data['saldo_afiliados']
		);
	} else {
		$saldo_arr = array(
			"saldo" => 0,
			"saldo_afiliado" => 0
		);
	}
	return $saldo_arr;
}

function saldo_user_email($id)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE mobile='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$data = mysqli_fetch_assoc($res);
		$saldo_arr = array(
			"saldo" => $data['saldo'],
			"user_id" => $data['id'],
			"saldo_afiliado" => $data['saldo_afiliados']
		);
	} else {
		$saldo_arr = array(
			"saldo" => 0,
			"user_id" => 0,
			"saldo_afiliado" => 0
		);
	}
	return $saldo_arr;
}

function saldo_user_pix($id)
{
	global $mysqli;
	$qry = "SELECT * FROM metodos_pagamentos WHERE pix_id='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$data = mysqli_fetch_assoc($res);
		$saldo = saldo_user($data['user_id'])['saldo'];
		
		$info = array(
		    "saldo" => $saldo,
		    "user_id" => $data['user_id']
		);
		
		return $info;
	}
}

function pegarLinkJogoigamewin($provider, $game, $email)
{
    global $data_igamewin; 
    

    $dataRequest = array(
        "method"        => "game_launch",
        "agent_code"    => $data_igamewin['agent_code'],
        "agent_token"   => $data_igamewin['agent_token'],
        "user_code"     => $email,
        "provider_code" => $provider,
        "game_code"     => $game,
        "lang"          => "en"
    );
    
    $json_data = json_encode($dataRequest);
    $response = enviarRequest($data_igamewin['url'], $json_data);
    $data = json_decode($response, true);
    
    if (isset($data['launch_url'])) {
        $games = array('gameURL' => $data['launch_url']);
    } else {
        error_log("pegarLinkJogoigamewin - Resposta inválida: " . $response);
        $games = array('gameURL' => null, 'error' => $data);
    }
    
    return $games;
}

function pegarLinkJogoPlayFiver($provedor, $game, $email)
{
    global $data_fiverscanpanel;
    $keys = $data_fiverscanpanel;
	$saldo = saldo_user_email($email)['saldo'];
	$dataRequest = array(
                "agentToken" => $keys['agent_code'],
                "secretKey" => $keys['agent_token'],
                "user_code" => $email,
                "game_code" => $game,
                "user_balance" => $saldo
	    );
	    
	$json_data = json_encode($dataRequest);
	$response = enviarRequest($keys['url'].'/api/v2/game_launch', $json_data);
	$data = json_decode($response, true);
    //echo $response;
	// sera q retornar algo assim? kkkkkkkk n sei
	//file_put_contents('log.game', $data, FILE_APPEND);
	//die(var_dump($data));
	$games = array('gameURL' => $data['launch_url']);
	return $games;
}

if (!file_exists('logs')) {
    mkdir('logs', 0755, true);
}

function pegarLinkJogoPragmatic($provedor, $game, $email) {
    global $data_apipragmatic;
    $keys = $data_apipragmatic;
    $saldo = saldo_user_email($email)['saldo'];
    
    // Preparar dados da requisição
    $dataRequest = array(
        "method" => "game_launch",
        "agent_token" => $keys['agent_token'],
        "agent_code" => $keys['agent_code'],
        "user_code" => $email,
        "game_code" => $game,
        "user_balance" => $saldo,
        "provider_code"=> "PGSOFT",
        "lang" => "pt"
    );
    
    // Converter para JSON
    $json_data = json_encode($dataRequest);
    
    // Criar mensagem de log para dados enviados
    $log_message = "==== PRAGMATIC REQUEST - " . date('Y-m-d H:i:s') . " ====\n";
    $log_message .= "URL: " . $keys['url'] . "\n";
    $log_message .= "Dados Enviados: " . $json_data . "\n";
    
    // Fazer a requisição
    $response = enviarRequest($keys['url'], $json_data);
    
    // Adicionar resposta ao log
    $log_message .= "Resposta Recebida: " . $response . "\n";
    $log_message .= "================================\n\n";
    
    // Salvar no arquivo de log
    file_put_contents('logs/pragmatic_requests.log', $log_message, FILE_APPEND);
    
    // Processar resposta
    $data = json_decode($response, true);
    $games = array('gameURL' => $data['launch_url']);
    
    return $games;
}
function pegarLinkJogo($provedor, $game, $email)
{
    global $data_pgclone, $ids;
    $saldo = saldo_user_email($email)['saldo'];
    $keys = $data_pgclone;

    $data = array(
        'agentToken' => $keys['agent_token'],
        'secretKey' => $keys['agent_secret'],
        'user_code' => $email,
        "provider_code" => 'PGSOFT',
        "game_code" => $game,
        "user_balance" => floatval($saldo)
    );
    
    $json_data = json_encode($data);
    
    // Enviar a requisição
    $response = enviarRequest($keys['url'].'/api/v1/game_launch', $json_data);
    
    // Gravar log da requisição e da resposta
    $log_message = "==== CLONE REQUEST - " . date('Y-m-d H:i:s') . " ====\n";
    $log_message .= "URL: " . $keys['url'].'/api/v1/game_launch' . "\n";
    $log_message .= "Dados Enviados: " . $json_data . "\n";
    $log_message .= "Resposta Recebida: " . $response . "\n";
    $log_message .= "================================\n\n";
    
    // Certifique-se de que o diretório 'logs' existe
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    file_put_contents('logs/clone_requests.log', $log_message, FILE_APPEND);
    
    $data_response = json_decode($response, true);
    
    // Verificar se o índice 'launch_url' existe para evitar erros
    $gameURL = isset($data_response['launch_url']) ? $data_response['launch_url'] : null;
    
    $games = array('gameURL' => $gameURL);
    return $games;
}

//  CRIAR USER API FIVERSCAN
function criarUsuarioAPI($email)
{
    return 1;
	global $data_fiverscanpanel;

	$keys = $data_fiverscanpanel;

	$postArray = [
		'agent_code' => $keys['agent_code'],
		'agent_token' => $keys['agent_token'],
		'user_code' => $email
	];
	$jsonData = json_encode($postArray);
	$headerArray = ['Content-Type: application/json'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.expfygaming.net/api/v1/user_create');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($ch);
	curl_close($ch);
	// Verifique se houve algum erro durante a solicitação
	//$json = '{"status":1,"msg":"SUCCESS","fc_code":"fc104688","user_code":"claudio.web.dev@gmail.com","user_balance":0}';
	$data = json_decode($res, true);

	//var_dump($data);
	// Verifica se a decodificação foi bem-sucedida
	if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
		$SF = 0;
		die('Erro na decodificação JSON: ' . json_last_error_msg());
	}
	if ($data['status'] == 1 and $data['msg'] == "SUCCESS") {
		$SF = 1;
	} else {
		$SF = 0;
	}
	return $SF;
}
#=====================================================#
// atualiza saldo do user
function att_saldo_user($saldo, $id)
{
    global $mysqli;
    $id_user = intval($id);

    error_log("Atualizando saldo para usuário $id_user. Novo saldo: " . $saldo);

    $sql = $mysqli->prepare("UPDATE usuarios SET saldo=? WHERE id=?");
    $sql->bind_param("di", $saldo, $id_user);
    
    if ($sql->execute()) {
        $rt = 1;
    } else {
        $rt = 0;
        // Log de erro para debug
        error_log("Erro ao atualizar saldo para usuário $id_user: " . $sql->error);
    }
    return $rt;
}
#=====================================================#
// financeiro user atual do user
function financeiro_saldo_user($id)
{
	global $mysqli;
	$qry = "SELECT * FROM financeiro WHERE usuario='" . intval($id) . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$saldo = mysqli_fetch_assoc($res);
	} else {
		$saldo = 0;
	}
	return $saldo;
}
#=====================================================#
//  se exisitr refer 1
function pegar_refer($refer)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE token_refer='" . $refer . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$ex_refer = 1;
	} else {
		$ex_refer = 0;
	}
	return $ex_refer;
}
#=====================================================#
#=====================================================#
//  DELETAR USER
function deletar_user($id)
{
	global $mysqli;
	$sql = $mysqli->prepare("DELETE FROM  usuarios WHERE id=?");
	$sql->bind_param("i", $id);
	$sql->execute();

	$sql99 = $mysqli->prepare("DELETE FROM  financeiro WHERE usuario=?");
	$sql99->bind_param("i", $id);
	$sql99->execute();
}
#=====================================================#
function enviarRequest_PAYMENT($url, $header, $data = null)
{
	$ch = curl_init();
	$data_json = json_encode($data);

	// Configurando as opções do cURL
	curl_setopt($ch, CURLOPT_URL, $url);
	if (!$data == null) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Executando a requisição e obtendo a resposta
	$response = curl_exec($ch);

	// Fechando a conexão cURL
	curl_close($ch);

	return $response;
}
#=====================================================#
function requestToken_PAYMENT($url, $header, $data)
{
	$ch = curl_init();

	// Configurando as opções do cURL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Executando a requisição e obtendo a resposta
	$response = curl_exec($ch);

	// Fechando a conexão cURL
	curl_close($ch);

	return $response;
}
#=====================================================#
#request pix
function request_paymentPIX($transactionId)
{
	global $data_suitpay, $tipoAPI_SUITPAY;
	if ($tipoAPI_SUITPAY == 0) {
		$url = 'https://sandbox.ws.suitpay.app/api/v1/gateway/consult-status-transaction';
		$data = array(
			'typeTransaction' => "PIX",
			'idTransaction' => $transactionId
		);
		$header = array(
			'ci: testesandbox_1687443996536',
			'cs: 5b7d6ed3407bc8c7efd45ac9d4c277004145afb96752e1252c2082d3211fe901177e09493c0d4f57b650d2b2fc1b062d',
			'Content-Type: application/json',
		);
	} else {
		$url = $data_suitpay['url'] . '/api/v1/gateway/consult-status-transaction';
		$data = array(
			'typeTransaction' => "PIX",
			'idTransaction' => $transactionId
		);
		$header = array(
			'ci: ' . $data_suitpay['client_id'],
			'cs: ' . $data_suitpay['client_secret'],
			'Content-Type: application/json'
		);

	}
	$response = enviarRequest_PAYMENT($url, $header, $data);
	$dados = json_decode($response, true);
	return $dados;
}
#=====================================================#
# coun refer direto
function count_refer_direto($refer)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE invitation_code='" . $refer . "'";
	$res = mysqli_query($mysqli, $qry);
	$ex_refer = mysqli_num_rows($res);
	return $ex_refer;
}
#=====================================================#
# count saque
function total_saques_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE id_user='" . $id . "'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}
#=====================================================#
# count depositos
function total_dep_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE usuario='" . $id . "' AND tipo='deposito'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}

function total_dep_pagos_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE usuario='" . $id . "' AND tipo='deposito' AND status='pago'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}

function total_dep_afiliado($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE usuario IN (SELECT id FROM usuarios where invitation_code = '" . $id . "') AND tipo='deposito' AND status='pago'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}
#=====================================================#
# SUM TOTAL ID CPA/REV
function total_CPA_REV_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM pay_valores_cassino WHERE id_user='" . $id . "' AND tipo=0 OR tipo=1";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}

function total_CPA_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM pay_valores_cassino WHERE id_user='" . $id . "' AND tipo=0";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}

function total_REV_id($id)
{
	global $mysqli;
	$qry = "SELECT SUM(valor) as total_soma FROM pay_valores_cassino WHERE id_user='" . $id . "' AND tipo=1";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_soma'] > 0) {
			$dinheiro = $row['total_soma'];
		} else {
			$dinheiro = '0.00';
		}
	}
	return $dinheiro;
}

#=====================================================#
# DATA USER ID
function data_user_id($id)
{
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE id='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}

function distribution($id)
{
	global $mysqli;
	$qry = "SELECT distribution FROM games WHERE id='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data['distribution'];
}

function gamecode($id)
{
	global $mysqli;
	$qry = "SELECT game_code FROM games WHERE id='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data['game_code'];
}

function gameprovider($id)
{
    global $mysqli;
    $qry = "SELECT provider FROM games WHERE game_code='" . mysqli_real_escape_string($mysqli, $id) . "' LIMIT 1";
    $res = mysqli_query($mysqli, $qry);
    $data = mysqli_fetch_assoc($res);
    
    if($data && isset($data['provider'])){
        return $data['provider'];
    }
    
    // Retorna um provider padrão caso não encontre nenhum registro
    return 'PGSOFT';
}


function localizarchavepix($id)
{
    global $mysqli;
    $qry = "SELECT pix_id FROM metodos_pagamentos WHERE id='" . $id . "'";
    $res = mysqli_query($mysqli, $qry);
    
    if ($res && $data = mysqli_fetch_assoc($res)) {
        return $data['pix_id'];
    } else {
        return null; // Return null if no result is found
    }
}



function localizarusuarioporpix($id)
{
    error_log("ID-->>".$id);
    
	global $mysqli;
	$qry = "SELECT * FROM usuarios WHERE id = (SELECT user_id FROM metodos_pagamentos WHERE pix_id = '" . $id . "')";
	
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	
	return $data['real_name'];
}

#=====================================================#
#inserir saldo
function adicionarsaldo($id, $valor)
{
	global $mysqli;
	$qry = "UPDATE financeiro SET saldo= saldo + '" . $valor . "' WHERE usuario='" . $id . "'";
	$res = mysqli_query($mysqli, $qry);
	$data = mysqli_fetch_assoc($res);
	return $data;
}

function requestaddsaldo($email, $valor)
{
	$data = array(
		'user_code' => $email,
		'valor' => $valor
	);
	$json_data = json_encode($data);
	$response = enviarRequest('https://api.zenbet.online/api/v1/adicionarsaldo', $json_data);
	$dados = json_decode($response, true);
	return $dados;
}

#=====================================================#
#inserir saldo
function insert_payment_adm($id, $email, $valor)
{
	global $mysqli;
	$tokentrans = '#pixdinamic-' . rand(99, 99999);
	$data_hora = date('Y-m-d H:i:s');
	$sql1 = $mysqli->prepare("INSERT INTO transacoes (transacao_id,usuario,valor,data_hora,tipo,status,code) VALUES (?,?,?,?,'deposito','pago','dinamico')");
	$sql1->bind_param("ssss", $tokentrans, $id, $valor, $data_hora);
	#ENVIA SALDO VIA API
	$retorna_insert_saldo_suit_pay = enviarSaldo($email, $valor);
	if ($retorna_insert_saldo_suit_pay['status'] == 1 and $retorna_insert_saldo_suit_pay['msg'] == "SUCCESS" and $sql1->execute()) {
		$ert = 1;
	} else {
		$ert = 0;
	}
	return $ert;
}


function numero_total_dep($id)
{
	global $mysqli;
	$qry = "SELECT COUNT(*) as total_count FROM transacoes WHERE usuario IN (SELECT id FROM usuarios WHERE invitation_code = '" . $id . "') AND tipo='deposito' AND status='pago'";
	$result = mysqli_query($mysqli, $qry);
	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['total_count'] > 0) {
			$total_count = $row['total_count'];
		} else {
			$total_count = 0;
		}
	}
	return $total_count;
}

#retirar saldo
function retirarsaldo($email, $valor)
{
	$data = array(
		'user_code' => $email,
		'valor' => $valor
	);
	$json_data = json_encode($data);
	$response = enviarRequest('https://api.zenbet.online/api/v1/removersaldo', $json_data);
	$dados = json_decode($response, true);
	return $dados;
}
#=====================================================#
#contar visitas
function visitas_count($tipo)
{
    global $mysqli;
    $data_hoje = date("Y-m-d");
    $data_90_dias = date("Y-m-d", strtotime("-90 days"));

    if ($tipo == 'diario') {
        $qry = "SELECT * FROM visita_site WHERE data_cad = '$data_hoje'";
        $res = mysqli_query($mysqli, $qry);
        $count = mysqli_num_rows($res);
    } elseif ($tipo == 'total') {
        $qry = "SELECT * FROM visita_site";
        $res = mysqli_query($mysqli, $qry);
        $count = mysqli_num_rows($res);
    } elseif ($tipo == '90d') {
        $qry = "SELECT * FROM visita_site WHERE data_cad >= '$data_90_dias'";
        $res = mysqli_query($mysqli, $qry);
        $count = mysqli_num_rows($res);
    } else {
        $count = 0;
    }
    
    return $count;
}

#=====================================================#
# busca por token retorn o id
function busca_id_por_refer($token)
{
	global $mysqli;

	$qry = "SELECT * FROM usuarios WHERE token_refer='" . $token . "'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$data = mysqli_fetch_assoc($res);
		$count = $data['id'];
	} else {
		$count = 0;
	}
	return $count;
}
#=====================================================#
function generateQRCode_pix($data)
{
	// Carregue a biblioteca PHP QR Code
	require_once('../docs_cassino/libraries/phpqrcode/qrlib.php');
	// Caminho onde você deseja salvar o arquivo PNG do QRCode (opcional)
	$file = '../uploads/qrcode.png';
	// Gere o QRCode
	QRcode::png($data, $file);
	// Carregue o arquivo PNG do QRCode
	$qrCodeImage = file_get_contents($file);
	// Converta a imagem para base64
	$base64QRCode = base64_encode($qrCodeImage);
	return $base64QRCode;
}
#=====================================================#
# busca por ALERT DEP PENDENTES id
function busca_dep_pendentes($id)
{
	global $mysqli;
	$qry = "SELECT * FROM transacoes WHERE usuario='" . $id . "' AND tipo='deposito' AND status='processamento'";
	$res = mysqli_query($mysqli, $qry);
	if (mysqli_num_rows($res) > 0) {
		$data = 1;
	} else {
		$data = 0;
	}
	return $data;
}

// Função para buscar depósitos por dia
function depositos_por_dia() {
    global $mysqli;
    // Usamos DATE() para extrair apenas a data, ignorando a hora
    $qry = "SELECT DATE(data_hora) as dia, COUNT(*) as total FROM transacoes WHERE status = 'pago' AND tipo = 'deposito' GROUP BY DATE(data_hora) ORDER BY dia DESC LIMIT 7";
    $result = mysqli_query($mysqli, $qry);
    
    $dados = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dados[] = [
                'dia' => $row['dia'],          // Retorna a data no formato YYYY-MM-DD
                'total' => intval($row['total']) // Conta a quantidade de depósitos
            ];
        }
    }
    return $dados;
}



// Função para buscar saques por dia
function saques_por_dia() {
    global $mysqli;
    $qry = "SELECT DATE(data_cad) as dia, COUNT(*) as total FROM solicitacao_saques WHERE status = 1 GROUP BY DATE(data_cad) ORDER BY dia DESC LIMIT 7";
    $result = mysqli_query($mysqli, $qry);
    
    $dados = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dados[] = [
                'dia' => $row['dia'],
                'total' => intval($row['total'])  // Conta a quantidade de saques
            ];
        }
    }
    return $dados;
}

function WebhookCadastro($nome_user, $url)
{
    global $mysqli;

    $queryWebhook = "SELECT * FROM webhook WHERE status = 1";
    $resultWebhook = mysqli_query($mysqli, $queryWebhook);
    
    while ($webhook = mysqli_fetch_assoc($resultWebhook)) {
        $bot_id = $webhook['bot_id'];
        $chat_id = $webhook['chat_id'];
        $message = "✅ Cadastro realizado com sucesso!\n";
        $message .= "🏷️ Nome: $nome_user\n";
        $message .= "🌐 URL do site: $url";
        $urlTelegram = "https://api.telegram.org/bot$bot_id/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
        file_get_contents($urlTelegram);
    }
}

function WebhookPixGerado($nome_user, $url, $valor)
{
    global $mysqli;
    $valor = number_format((float)$valor, 2, '.', ''); 

    $queryWebhook = "SELECT * FROM webhook WHERE status = 1";
    $resultWebhook = mysqli_query($mysqli, $queryWebhook);
    
    while ($webhook = mysqli_fetch_assoc($resultWebhook)) {
        $bot_id = $webhook['bot_id'];
        $chat_id = $webhook['chat_id'];
        $message = "✅ Pix gerado com sucesso\n";
        $message .= "💰 Valor: R$$valor\n";
        $message .= "⏳ Status: Pendente\n";
        $message .= "🏷️ Nome: $nome_user\n";
        $message .= "🌐 URL do site: $url";
        $urlTelegram = "https://api.telegram.org/bot$bot_id/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
        file_get_contents($urlTelegram);
    }
}

function WebhookPixPagos($nome_user, $url, $valor)
{
    global $mysqli;

    $valorFormatado = is_array($valor) || is_object($valor) ? $valor['valor'] : $valor;

    $queryWebhook = "SELECT * FROM webhook WHERE status = 1";
    $resultWebhook = mysqli_query($mysqli, $queryWebhook);
    
    while ($webhook = mysqli_fetch_assoc($resultWebhook)) {
        $bot_id = $webhook['bot_id'];
        $chat_id = $webhook['chat_id'];
        $message = "✅ Pix pago com sucesso\n";
        $message .= "💰 Valor: R$$valorFormatado\n";
        $message .= "⏳ Status: Pago\n";
        $message .= "🏷️ Nome: $nome_user\n";
        $message .= "🌐 URL do site: $url";
        $urlTelegram = "https://api.telegram.org/bot$bot_id/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
        file_get_contents($urlTelegram);
    }
}


function getCurrentUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . $host;
}

?>