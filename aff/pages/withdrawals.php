<?php
session_start();
global $mysqli;

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    echo "<p>Usuário não logado.</p>";
    exit;
}

$saldoDisponivel = 0.0;
$saqueMinimo = 100.00; 
$querySaldo = "SELECT saldo_afiliados, saque_minimo FROM usuarios WHERE id = $user_id LIMIT 1";
$resultSaldo = mysqli_query($mysqli, $querySaldo);
if ($resultSaldo && mysqli_num_rows($resultSaldo) > 0) {
    $row = mysqli_fetch_assoc($resultSaldo);
    $saldoDisponivel = (float)$row['saldo_afiliados'];
    $saqueMinimo = isset($row['saque_minimo']) ? (float)$row['saque_minimo'] : 100.00;
}


$msg = "";
$msgType = "info"; // 'info', 'success' ou 'error'


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e sanitiza os valores
    $valorSaque = floatval(str_replace(',', '.', $_POST['valor_saque'] ?? '0'));
    $chavePix   = trim($_POST['chave_pix'] ?? '');
    
    if ($valorSaque <= 0) {
        $msg = "Valor de saque inválido.";
        $msgType = "error";
    } elseif ($valorSaque < $saqueMinimo) {
        $msg = "O valor do saque deve ser no mínimo R$ " . number_format($saqueMinimo, 2, ',', '.') . ".";
        $msgType = "error";
    } elseif ($valorSaque > $saldoDisponivel) {
        $msg = "Você não possui saldo suficiente para esse saque.";
        $msgType = "error";
    } else {

        $transacao_id = uniqid('SW');
        $tipo = 'pix';
        $tipo_saque = 1;
        $status = 0;

        $data_cad  = date('Y-m-d');
        $data_hora = date('H:i:s');

        $sqlInsert = "
            INSERT INTO solicitacao_saques 
            (id_user, transacao_id, valor, tipo, pix, data_cad, data_hora, status, tipo_saque)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $mysqli->prepare($sqlInsert);
        $stmt->bind_param(
            "issssssii", 
            $user_id,
            $transacao_id,
            $valorSaque,
            $tipo,
            $chavePix,
            $data_cad,
            $data_hora,
            $status,
            $tipo_saque
        );
        
        if ($stmt->execute()) {

            $novoSaldo = $saldoDisponivel - $valorSaque;
            $updSaldo = "UPDATE usuarios 
                         SET saldo_afiliados = ? 
                         WHERE id = ?";
            $stmtUpd = $mysqli->prepare($updSaldo);
            $stmtUpd->bind_param("di", $novoSaldo, $user_id);
            $stmtUpd->execute();
            $stmtUpd->close();

            $msg = "Saque solicitado com sucesso!";
            $msgType = "success";

            $saldoDisponivel = $novoSaldo;
        } else {
            $msg = "Erro ao solicitar saque: " . $stmt->error;
            $msgType = "error";
        }
        $stmt->close();
    }
}

$historico = [];
$qHist = "SELECT 
            id,
            transacao_id,
            valor,
            tipo,
            pix,
            data_cad,
            data_hora,
            status
          FROM solicitacao_saques
          WHERE id_user = $user_id
          ORDER BY id DESC";
$rHist = mysqli_query($mysqli, $qHist);
if ($rHist && mysqli_num_rows($rHist) > 0) {
    while ($rowH = mysqli_fetch_assoc($rHist)) {
        $historico[] = $rowH;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Saques Afiliados</title>
    <style>
        /* Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            min-width: 250px;
            margin-top: 10px;
            padding: 15px 20px;
            border-radius: 4px;
            color: #fff;
            animation: fadeIn 0.5s;
        }
        .toast-success {
            background-color: #22c55e;
        }
        .toast-error {
            background-color: #ef4444;
        }
        .toast-info {
            background-color: #3b82f6;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }

        /* Layout */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 20px;
        }
        .page-title {
            font-size: 1.5rem;
            margin: 0;
        }
        .card {
            margin: 20px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .card-header {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #f9fafb;
        }
        .card-title {
            margin: 0;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #f3f3f3;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
        }
        .status-approved {
            background-color: #10b981;
        }
        .status-pending {
            background-color: #fbbf24;
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .btn-outline {
            background-color: #fff;
            border: 1px solid #bbb;
        }
        .btn-sm {
            padding: 4px 8px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

<div class="toast-container" id="toastContainer"></div>

<div class="navbar">
    <div class="navbar-left">
        <h1 class="page-title">Saques</h1>
    </div>
</div>

<!-- Card: Solicitar Saque -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informações</h3>
    </div>
    <div class="card-body">
        <!-- Saldo Disponível -->
        <div style="margin-bottom: 1.5rem;">
            <p style="margin-bottom: 0.25rem;">Saldo Disponível</p>
            <div style="font-size: 1.75rem; font-weight: 600;">
                R$ <?php echo number_format($saldoDisponivel, 2, ',', '.'); ?>
            </div>
            <p style="font-size: 0.875rem;">
                Mínimo para saque: R$ <?php echo number_format($saqueMinimo, 2, ',', '.'); ?>
            </p>
        </div>

        <!-- Formulário para Solicitar Saque -->
        <form method="POST" action="">
            <!-- Valor do Saque -->
            <div style="margin-bottom: 1rem;">
                <label>Valor do Saque</label>
                <input 
                    type="text" 
                    name="valor_saque"
                    placeholder="Ex: 100,00"
                    style="
                        width:100%;
                        padding: 0.5rem;
                        border-radius: 0.25rem;
                        border: 1px solid #ccc;
                        margin-top: 0.25rem;
                    "
                />
            </div>

            <!-- Método de Pagamento (Pix fixo) -->
            <div style="margin-bottom: 1rem;">
                <label>Método de Pagamento</label>
                <input 
                    type="text" 
                    value="Pix" 
                    disabled
                    style="
                        width:100%;
                        padding: 0.5rem;
                        border-radius: 0.25rem;
                        border: 1px solid #ccc;
                        margin-top: 0.25rem;
                        background-color: #f3f3f3;
                    "
                />
            </div>

            <!-- Chave Pix (CPF) -->
            <div style="margin-bottom: 1rem;">
                <label>Chave Pix (CPF)</label>
                <input 
                    type="text" 
                    name="chave_pix"
                    placeholder="Ex.: 123.456.789-00"
                    style="
                        width:100%;
                        padding: 0.5rem;
                        border-radius: 0.25rem;
                        border: 1px solid #ccc;
                        margin-top: 0.25rem;
                    "
                />
            </div>

            <!-- Botão Solicitar Saque -->
            <button 
                type="submit" 
                class="btn"
                style="
                    padding: 0.75rem 1.5rem;
                    border: none;
                    border-radius: 0.25rem;
                    background-color: #6366f1;
                    color: #fff;
                    cursor: pointer;
                "
            >
                Solicitar Saque
            </button>
        </form>
    </div>
</div>

<!-- Card: Histórico de Saques -->
<div class="card" style="margin-top: 1rem;">
    <div class="card-header" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h3 class="card-title">Histórico de Saques</h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Valor</th>
                    <th>Método</th>
                    <th>Status</th>
                    <th>Comprovante</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($historico)): ?>
                <?php foreach ($historico as $hrow): ?>
                    <?php
                    // Define status: 0 => Pendente, 1 => Pago, etc.
                    $statusLabel = 'Pendente';
                    $statusClass = 'status-pending';
                    if ($hrow['status'] == 1) {
                        $statusLabel = 'Pago';
                        $statusClass = 'status-approved';
                    }
                    ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($hrow['data_cad'])); ?></td>
                        <td><?php echo date('H:i', strtotime($hrow['data_hora'])); ?></td>
                        <td>R$ <?php echo number_format($hrow['valor'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($hrow['tipo']); ?></td>
                        <td>
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo $statusLabel; ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-outline btn-sm" disabled>
                                <i class="fas fa-download"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhuma solicitação de saque encontrada.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
/**
 * Exibe toast no canto superior direito
 * @param {string} message 
 * @param {string} type - 'success'|'error'|'info'
 */
function showToast(message, type) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    container.appendChild(toast);

    // Remove automaticamente depois de 3s
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.5s forwards';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Se houver mensagem do servidor, chama o toast
<?php if (!empty($msg)): ?>
    showToast("<?php echo addslashes($msg); ?>", "<?php echo $msgType; ?>");
<?php endif; ?>
</script>

</body>
</html>
