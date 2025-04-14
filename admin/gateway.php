<?php include 'partials/html.php' ?>

<?php
#======================================#
ini_set('display_errors', 0);
error_reporting(E_ALL);
#======================================#
session_start();
include_once "services/database.php";
include_once 'logs/registrar_logs.php';
include_once "services/funcao.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "services/CSRF_Protect.php";
include_once "validar_2fa.php";
$csrf = new CSRF_Protect();
#======================================#
#expulsa user
checa_login_adm();
#======================================#

if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}

function get_afiliados_config()
{
    global $mysqli;
    $suitpayQuery = "SELECT * FROM suitpay WHERE id = 1";
    $suitpayResult = mysqli_query($mysqli, $suitpayQuery);
    $suitpayConfig = mysqli_fetch_assoc($suitpayResult);

    $bspayQuery = "SELECT * FROM bspay WHERE id = 1";
    $bspayResult = mysqli_query($mysqli, $bspayQuery);
    $bspayConfig = mysqli_fetch_assoc($bspayResult);
    
    $expfypayQuery = "SELECT * FROM expfypay WHERE id = 1";
    $expfypayResult = mysqli_query($mysqli, $expfypayQuery);
    $expfypayConfig = mysqli_fetch_assoc($expfypayResult);

    return [
        'suitpay' => $suitpayConfig,
        'bspay' => $bspayConfig,
        'expfypay' => $expfypayConfig
    ];
}

function update_gateway_status($selectedGateway)
{
    global $mysqli;

    $query1 = $mysqli->query("UPDATE suitpay SET ativo = 0 WHERE id = 1");
    $query2 = $mysqli->query("UPDATE bspay SET ativo = 0 WHERE id = 1");
    $query3 = $mysqli->query("UPDATE expfypay SET ativo = 0 WHERE id = 1");

    if (!$query1 || !$query2) {
        die("Erro ao desativar gateways: " . $mysqli->error);
    }

    if ($selectedGateway === 'SuitPay') {
        $query = $mysqli->query("UPDATE suitpay SET ativo = 1 WHERE id = 1");
    } elseif ($selectedGateway === 'BSPay') {
        $query = $mysqli->query("UPDATE bspay SET ativo = 1 WHERE id = 1");
    } elseif ($selectedGateway === 'expfypay') {
        $query = $mysqli->query("UPDATE expfypay SET ativo = 1 WHERE id = 1");
    }

    if (!$query) {
        die("Erro ao ativar o gateway selecionado: " . $mysqli->error);
    }
}

function update_config($data)
{
    global $mysqli;

    if ($data['gateway'] === 'SuitPay') {
        $qry = $mysqli->prepare("UPDATE suitpay SET url = ?, client_id = ?, client_secret = ? WHERE id = 1");
    } elseif ($data['gateway'] === 'BSPay') {
        $qry = $mysqli->prepare("UPDATE bspay SET url = ?, client_id = ?, client_secret = ? WHERE id = 1");
    } elseif ($data['gateway'] === 'expfypay') {
        $qry = $mysqli->prepare("UPDATE expfypay SET url = ?, client_id = ?, client_secret = ? WHERE id = 1");
    }

    $qry->bind_param("sss", $data['url'], $data['client_id'], $data['client_secret']);
    $success = $qry->execute();

    if (!$success) {
        die("Erro ao atualizar credenciais: " . $qry->error);
    }

    if ($success) {
        update_gateway_status($data['gateway']);
    }

    return $success;
}

function get_active_gateway($mysqli)
{
    $resultSuitPay = $mysqli->query("SELECT ativo FROM suitpay WHERE id = 1");
    $resultBSPay = $mysqli->query("SELECT ativo FROM bspay WHERE id = 1");
    $resultexpfypay = $mysqli->query("SELECT ativo FROM expfypay WHERE id = 1");

    if ($resultSuitPay && $resultBSPay && $resultexpfypay) {
        $suitPay = $resultSuitPay->fetch_assoc();
        $bspay = $resultBSPay->fetch_assoc();
        $expfypay = $resultexpfypay->fetch_assoc();

        // Verifica qual gateway está ativo
        if ($suitPay['ativo'] == 1) {
            return 'SuitPay'; // Retorna SuitPay se ativo
        } elseif ($bspay['ativo'] == 1) {
            return 'BSPay'; // Retorna BSPay se ativo
        } elseif ($expfypay['ativo'] == 1) {
            return 'expfypay'; // Retorna expfypay se ativo
        }
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'gateway' => $_POST['gateway'],
        'client_id' => $_POST['client_id'],
        'client_secret' => $_POST['client_secret'],
        'url' => $_POST['url'],
    ];

    if (update_config($data)) {
        $toastType = 'success';
        $toastMessage = 'Credenciais atualizadas com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar as Credenciais. Tente novamente.';
    }
}

$toastType = null;
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'gateway' => $_POST['gateway'],
        'client_id' => $_POST['client_id'],
        'client_secret' => $_POST['client_secret'],
        'url' => $_POST['url'],
    ];

    if (isset($_POST['gateway']) && $_POST['gateway'] === 'SuitPay') {
        $data['client_id'] = $_POST['client_id'];
        $data['client_secret'] = $_POST['client_secret'];
        $data['url'] = $_POST['url'];
        $update_success = update_config($data);
    } elseif (isset($_POST['gateway']) && $_POST['gateway'] === 'BSPay') {
        $data['client_id'] = $_POST['bspay_client_id'];
        $data['client_secret'] = $_POST['bspay_client_secret'];
        $data['url'] = $_POST['bspay_url'];
        $update_success = update_config($data);
    } elseif (isset($_POST['gateway']) && $_POST['gateway'] === 'expfypay') {
        $data['client_id'] = $_POST['expfypay_client_id'];
        $data['client_secret'] = $_POST['expfypay_client_secret'];
        $data['url'] = $_POST['expfypay_url'];
        $update_success = update_config($data);
    }

    if ($update_success) {
        $toastType = 'success';
        $toastMessage = 'Credenciais atualizadas com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar as Credenciais. Tente novamente.';
    }
}

$config = get_afiliados_config();
$activeGateway = get_active_gateway($mysqli);
?>

<head>
    <?php $title = "Configurações de Credenciais";
    include 'partials/title-meta.php' ?>

    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php' ?>
</head>

<body>

    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php' ?>
    <!-- Top Bar End -->
    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php' ?>
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Configurações de Gateway de Pagamentos</h4>
                            </div>

                            <div class="card-body">
                                <!-- Select Menu para Escolher Gateway -->
                                <div class="mb-4">
                                    <label for="gateway" class="form-label">Escolha o Gateway de Pagamento</label>
                                    <select id="gateway" name="gateway" class="form-select">
                                        <option value="expfypay" <?php echo ($activeGateway === 'expfypay') ? 'selected' : ''; ?>>ExpfyPay.com</option>
                                    </select>
                                </div>
                                
                                <!-- Formulário expfypay -->
                                <form method="POST" action="">
                                    <input type="hidden" name="gateway" value="expfypay">
                                    <div class="row">
                                        <h5 class="card-title">ExpfyPay</h5>
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Public Key</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="expfypay_client_id"
                                                            name="expfypay_client_id" class="form-control"
                                                            value="<?= $config['expfypay']['client_id'] ?>" required>
                                                        <span class="input-group-text"
                                                            onclick="togglePassword('expfypay_client_id', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Secret Key</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="expfypay_client_secret"
                                                            name="expfypay_client_secret" class="form-control"
                                                            value="<?= $config['expfypay']['client_secret'] ?>" required>
                                                        <span class="input-group-text"
                                                            onclick="togglePassword('expfypay_client_secret', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Endpoint</h5>
                                                    <input type="text" readonly="" name="expfypay_url" class="form-control"
                                                        value="<?= $config['expfypay']['url'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Salvar EXPFY Pay</button>
                                    </div>
                                </for
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                                        <?php include 'partials/endbar.php' ?>
    <?php include 'partials/footer.php' ?>
            
        </div>
    </div>

    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <?php include 'partials/vendorjs.php' ?>
    <script src="assets/js/app.js"></script>

    <script>
        function showToast(type, message) {
            var toastPlacement = document.getElementById('toastPlacement');
            var toast = document.createElement('div');
            toast.className = `toast align-items-center bg-light border-0 fade show`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = `
                <div class="toast-header">
                    <img src="assets/images/logo-sm.png" alt="" height="20" class="me-1">
                    <h5 class="me-auto my-0">Atualização</h5>
                    <small>Agora</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${message}</div>
            `;
            toastPlacement.appendChild(toast);

            var bootstrapToast = new bootstrap.Toast(toast);
            bootstrapToast.show();

            setTimeout(function () {
                bootstrapToast.hide();
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    </script>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            const iconElement = icon.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                iconElement.classList.remove('fa-eye');
                iconElement.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                iconElement.classList.remove('fa-eye-slash');
                iconElement.classList.add('fa-eye');
            }
        }
    </script>

    <?php if ($toastType && $toastMessage): ?>
        <script>
            showToast('<?= $toastType ?>', '<?= $toastMessage ?>');
        </script>
    <?php endif; ?>

</body>

</html>