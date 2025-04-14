<?php
header('Content-Type: application/json');

$cpf = $_GET['cpf'];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://consulta.expfygaming.net/index.php?cpf='.$cpf,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  //CURLOPT_POSTFIELDS =>'',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
