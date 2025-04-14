<?php
    date_default_timezone_set('America/Sao_Paulo');
	include_once('database.php');
	include_once('funcao.php');
	#-------------------------------------#
	#=====================================================#
	# DATA CONFIG
	function data_api_fiverscan(){
		global $mysqli;
		$qry = "SELECT * FROM fiverscan WHERE id=1";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_fetch_assoc($res );
		return $data;
	}
	$data_fiverscan = data_api_fiverscan();
	#=====================================================#
	# saldo api fiverscan
	function balance_api(){
		global $data_fiverscan;
	 $balance =0;
	 $postArray = [
		 "method" => "money_info",
		 'agent_code' => $data_fiverscan['agent_code'], 
		 'agent_token' => $data_fiverscan['agent_token']
	 ];
	 $jsonData = json_encode($postArray);
	 $headerArray = ['Content-Type: application/json'];
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, 'https://api.payigaming.com.br/');
	 curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	 curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
	 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 $res = curl_exec($ch);
	 
	 //var_dump($res);
	 // Verifique se houve algum erro durante a solicitação
	 if (curl_errno($ch)) {
		 $status = 'erro';
		 $balance = 0;
	 } else {
		 // Decodifique o JSON retornado
		 $responseData = json_decode($res, true);
		 // Verifique se a decodificação foi bem-sucedida
		 if ($responseData === null) {
			 $status = 'erro';
			 $balance = 0;
		 } else {
			 // Agora você pode acessar os dados como um array associativo
			 if($responseData['msg'] == "SUCCESS"){
				 $balance = $responseData['agent']['balance'];
			 }else{
				 $balance = 0;
			 }
		 }
	 }
 
	 curl_close($ch);
	 return $balance;
 }
	#=====================================================#
	# DATA AVATAR
	function data_avatar(){
		global $mysqli;
		$qry = "SELECT * FROM admin_users WHERE id=1";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_fetch_assoc($res );
		return $data;
	}
	$data_avatar = data_avatar();
	#=====================================================#
	
	#=====================================================#
	# DATA CONFIG
	function qtd_provedor_games($provedor){
		global $mysqli;
		$qry = "SELECT * FROM games WHERE provider='".$provedor."'";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_num_rows($res);
		return $data;
	}
	#=====================================================#
	# DATA RPOVEDOR count
	function qtd_provedor_ativos(){
		global $mysqli;
		$qry = "SELECT * FROM provedores WHERE status=1";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_num_rows($res);
		return $data;
	}
	#=====================================================#
	# DATA games count
	function qtd_games_ativos(){
		global $mysqli;
		$qry = "SELECT * FROM games WHERE status=1";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_num_rows($res);
		return $data;
	}
	#=====================================================#
	# DATA user count
	function qtd_usuarios(){
		global $mysqli;
		$qry = "SELECT * FROM usuarios";
		$res = mysqli_query($mysqli,$qry);
		$data = mysqli_num_rows($res);
		return $data;
	}
	
	function qtd_usuarios_depositantes(){
    global $mysqli;

    // Query to get the number of unique users who have made a 'pago' deposit
    $qry = "
        SELECT COUNT(DISTINCT usuario) as depositantes 
        FROM transacoes 
        WHERE tipo = 'deposito' AND status = 'pago'
    ";
    $res = mysqli_query($mysqli, $qry);
    $data = mysqli_fetch_assoc($res)['depositantes'];

    return $data;
    }
	#=====================================================#
	# DATA SALDO CASSINO
	function saldo_cassino(){
		global $mysqli;
		$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE tipo='deposito' AND status='pago'";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		#-
		$qry_saques = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE status=1";
		$result_saques = mysqli_query($mysqli, $qry_saques);
		while($row_saques = mysqli_fetch_assoc($result_saques)){
			if($row_saques['total_soma'] >0){
				$saques = $row_saques['total_soma'];
			}else{
			   $saques = '0.00';
			}
		}
		$total = $deposito-$saques;
		return $total;
	}
	#=====================================================#
	# DATA deposito pendentes
	function depositos_pendentes(){
		global $mysqli;
		$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE tipo='deposito' AND status='processamento'";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		return $deposito;
	}
	#=====================================================#
	# DATA deposito diario
	function depositos_diarios(){
		global $mysqli;
		$data = date('Y-m-d');
		$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE tipo='deposito' AND DATE(data_hora) = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param("s", $data);
		$stmt->execute();
		$result = $stmt->get_result();
		
		$deposito = '0.00'; // Valor padrão
	
		if($row = $result->fetch_assoc()){
			if($row['total_soma'] > 0){
				$deposito = $row['total_soma'];
			}
		}
		
		return $deposito;
	}

	# DATA deposito diario
	function depositos_diarios_pagos(){
		global $mysqli;
		$data = date('Y-m-d');
		$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE tipo='deposito' AND status='pago' AND DATE(data_hora) = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param("s", $data);
		$stmt->execute();
		$result = $stmt->get_result();
		
		$deposito = '0.00'; // Valor padrão
	
		if($row = $result->fetch_assoc()){
			if($row['total_soma'] > 0){
				$deposito = $row['total_soma'];
			}
		}
		
		return $deposito;
	}
	#=====================================================#
	# DATA deposito diario
	function depositos_total(){
		global $mysqli;
		$data = date('Y-m-d');
		$qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE tipo='deposito' AND status='pago'";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		return $deposito;
	}
	#=====================================================#
	# DATA saque pendentes 
	function saques_pendentes(){
		global $mysqli;
		$qry = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE status=0";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		return $deposito;
	}
	#=====================================================#
	# DATA saque diarios pagos 
	function saques_diarios_pagos(){
		global $mysqli;
		$data = date('Y-m-d');
		$qry = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE data_cad='".$data."' AND status=1";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		return $deposito;
	}
	#=====================================================#
	# DATA saque diarios pagos 
	function saques_total(){
		global $mysqli;
		$data = date('Y-m-d');
		$qry = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE status= '1'";
		$result = mysqli_query($mysqli, $qry);
		while($row = mysqli_fetch_assoc($result)){
			if($row['total_soma'] >0){
				$deposito = $row['total_soma'];
			}else{
			   $deposito = '0.00';
			}
		}
		return $deposito;
	}
	#=====================================================#
	#count saques pendentes
	function count_saques_pendentes(){
		global $mysqli;
		$qry = "SELECT * FROM solicitacao_saques WHERE status=0";
		$res = mysqli_query($mysqli, $qry);
		$count = mysqli_num_rows($res);
		return $count;
	}
	#=====================================================#
	# DATA user count
    function qtd_usuarios_diarios(){
        global $mysqli;
        $data = date('Y-m-d');
    
        // Query to get the total number of users registered today
        $qry = "SELECT COUNT(*) as total FROM usuarios WHERE DATE_FORMAT(data_cad, '%Y-%m-%d') = '$data'";
        $res = mysqli_query($mysqli, $qry);
        $data = mysqli_fetch_assoc($res)['total'];
    
        return $data;
    }
    
    function qtd_usuarios_depositantes_diarios(){
        global $mysqli;
        $data = date('Y-m-d');
    
        // Query to get the number of unique users who made a 'pago' deposit today
        $qry = "
            SELECT COUNT(DISTINCT usuario) as depositantes 
            FROM transacoes 
            WHERE tipo = 'deposito' AND status = 'pago' AND DATE(data_hora) = '$data'
        ";
        $res = mysqli_query($mysqli, $qry);
        $data = mysqli_fetch_assoc($res)['depositantes'];
    
        return $data;
    }
	#=====================================================#
	
    function qtd_usuarios_90d() {
        global $mysqli;
        $data_inicio = date('Y-m-d', strtotime('-90 days'));
        $qry = "SELECT * FROM usuarios WHERE data_cad >= '$data_inicio'";
        $res = mysqli_query($mysqli, $qry);
        $total = mysqli_num_rows($res);
        return $total;
    }
    
    function qtd_primeiro_deposito_usuarios_90d() {
    global $mysqli;
    $data_inicio = date('Y-m-d', strtotime('-90 days'));

    // Query to get the count of unique users who made their first deposit in the last 90 days
    $qry = "
        SELECT COUNT(DISTINCT usuario) as total
        FROM transacoes t1
        WHERE tipo = 'deposito' 
        AND status = 'pago'
        AND DATE(data_hora) >= '$data_inicio'
        AND data_hora = (
            SELECT MIN(data_hora)
            FROM transacoes t2
            WHERE t2.usuario = t1.usuario 
            AND t2.tipo = 'deposito' 
            AND t2.status = 'pago'
        )
    ";

    $res = mysqli_query($mysqli, $qry);
    $total = mysqli_fetch_assoc($res)['total'];

    return $total;
    }

    function total_jogadas() {
        global $mysqli;
        $qry = "SELECT COUNT(*) as total FROM historico_play";
        $result = mysqli_query($mysqli, $qry);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    
    function formatar_nome_jogo($nome_game) {
    return ucwords(str_replace('-', ' ', $nome_game));
    }

    function jogo_mais_jogado() {
        global $mysqli;
        $qry = "SELECT nome_game, COUNT(*) as total FROM historico_play GROUP BY nome_game ORDER BY total DESC LIMIT 1";
        $result = mysqli_query($mysqli, $qry);
        $row = mysqli_fetch_assoc($result);
    
        return $row ? formatar_nome_jogo($row['nome_game']) : 'Nenhum jogo encontrado';
    }

    function percentual_usuarios_diarios() {
        $total = qtd_usuarios();
        $diarios = qtd_usuarios_diarios();
        
        if ($total > 0) {
            $percentual = ($diarios / $total) * 100;
        } else {
            $percentual = 0;
        }
        
        return number_format($percentual, 1);
    }
    
    function percentual_usuarios_90d() {
        $total = qtd_usuarios();
        $usuarios_90d = qtd_usuarios_90d();
        
        if ($total > 0) {
            $percentual = ($usuarios_90d / $total) * 100;
        } else {
            $percentual = 0;
        }
        
        return number_format($percentual, 1);
    }
    
    function percentual_lucro() {
    $total_depositos = depositos_total();
    $total_saques = saques_total();
    
    if ($total_depositos > 0) {
        $percentual_lucro = (($total_depositos - $total_saques) / $total_depositos) * 100;
    } else {
        $percentual_lucro = 0;
    }
    
    return number_format($percentual_lucro, 1);
    }

    function count_saques_total(){
        global $mysqli;
        $qry = "SELECT COUNT(*) as total_count FROM solicitacao_saques WHERE status = '1'";
        $result = mysqli_query($mysqli, $qry);
        $row = mysqli_fetch_assoc($result);
        return $row['total_count'] ?? 0;
    }

?>