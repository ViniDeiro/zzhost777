<?php
// admin/fetch/rollover_status.php
header('Content-Type: application/json');
include '../services/database.php';
include '../services/crud.php';

// Se necessário, incluir verificação de login ou CSRF
// include_once '../services/checa_login_adm.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes.']);
    exit;
}

$user_id = (int)$data['user_id'];

// Consulta o total de depósitos pagos
$qryDep = "SELECT SUM(valor) as total_depositos 
           FROM transacoes 
           WHERE usuario=? AND tipo='deposito' AND status='pago'";
$stmt = $mysqli->prepare($qryDep);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultado = $stmt->get_result();
$row = $resultado->fetch_assoc();
$total_depositos = $row['total_depositos'] ?? 0;
$stmt->close();

// Para debug: log o valor de depósitos
error_log("User {$user_id} - Total Depósitos: " . $total_depositos);

// Utilize seu valor de rollover configurado – substitua o 3 pelo valor correto se necessário
$rolloverMultiplier = 3;
$rollover_necessario = $total_depositos * $rolloverMultiplier;

// Consulta o total apostado (apostas aprovadas)
$qryApostas = "
    SELECT SUM(bet_money) as total_apostado 
    FROM historico_play 
    WHERE id_user=? 
      AND status_play=1
";
$stmt = $mysqli->prepare($qryApostas);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultadoApostas = $stmt->get_result();
$rowApostas = $resultadoApostas->fetch_assoc();
$total_apostado = $rowApostas['total_apostado'] ?? 0;
$stmt->close();

// Para debug: log o valor apostado
error_log("User {$user_id} - Total Apostado: " . $total_apostado);

$rollover_restante = $rollover_necessario - $total_apostado;

// Para debug: log os cálculos do rollover
error_log("User {$user_id} - Rollover Necessário: " . $rollover_necessario . " | Rollover Restante: " . $rollover_restante);

if ($rollover_restante > 0) {
    echo json_encode([
        "success"           => true,
        "rollover_active"   => true,
        "rollover_restante" => number_format($rollover_restante, 2, ',', '.')
    ]);
} else {
    echo json_encode([
        "success"           => true,
        "rollover_active"   => false,
        "rollover_restante" => "0,00"
    ]);
}
?>
