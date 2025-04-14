<?php
// Inicia a sessão
session_start();

// Inclui arquivos de conexão, funções etc.
include_once "../services/database.php";
include_once '../logs/registrar_logs.php';
include_once "../services/funcao.php";
include_once "../services/crud.php";
include_once "../services/crud-adm.php";
include_once '../services/checa_login_adm.php';
include_once "../services/CSRF_Protect.php";
include_once "../validar_2fa.php";

// Instancia a proteção CSRF
$csrf = new CSRF_Protect();

// Verifica se o usuário é admin (ou está autenticado)
// Se não for, a função deve redirecionar ou encerrar a execução
checa_login_adm();
// Define os headers para exportar um arquivo CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=usuarios.csv');

// Abre a "stream" de saída
$output = fopen('php://output', 'w');

// Escreve a linha de cabeçalho no CSV
fputcsv($output, ['Nome de Usuário', 'Telefone']);

// Query para buscar os dados desejados
$query = "SELECT mobile, telefone FROM usuarios";
$result = mysqli_query($mysqli, $query);

// Itera sobre os resultados e escreve cada linha no CSV
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [$row['mobile'], $row['telefone']]);
}

fclose($output);
exit;
?>
