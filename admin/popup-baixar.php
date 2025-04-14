<?php
ob_start(); // Inicia o output buffering

include 'partials/html.php';

// É recomendável habilitar o display de erros em ambiente de desenvolvimento para facilitar o debug
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

ini_set('display_errors', 0);
error_reporting(E_ALL);
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

// Verifica se o usuário está logado e autorizado
checa_login_adm();
if ($_SESSION['data_adm']['status'] != '1') {
    header("Location: bloqueado.php");
    exit();
}

// Função para buscar os dados atuais da tabela config
function get_afiliados_config() {
    global $mysqli;
    $qry = "SELECT * FROM config WHERE id=1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

// Função para atualizar os dados da tabela config, incluindo os novos campos
function update_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE config SET 
        versao_app_android = ?, 
        versao_app_ios = ?, 
        mensagem_app = ?, 
        link_app_android = ?,
        link_app_ios = ?,
        mostrar_barra_topo = ?,
        mostrar_barra_inferior = ?,
        mostrar_modal_download = ?
        WHERE id = 1");

    // Ajuste de "ssssssiii" para "sssssiii" para corresponder a 5 strings e 3 inteiros
    $qry->bind_param(
        "sssssiii",
        $data['versao_app_android'],
        $data['versao_app_ios'],
        $data['mensagem_app'],
        $data['link_app_android'],
        $data['link_app_ios'],
        $data['mostrar_barra_topo'],
        $data['mostrar_barra_inferior'],
        $data['mostrar_modal_download']
    );
    return $qry->execute();
}

// Processamento do POST para atualizar os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'versao_app_android'     => $_POST['versao_app_android'],
        'versao_app_ios'         => $_POST['versao_app_ios'],
        'mensagem_app'           => $_POST['mensagem_app'],
        'link_app_android'       => $_POST['link_app_android'],
        'link_app_ios'           => $_POST['link_app_ios'],
        'mostrar_barra_topo'     => isset($_POST['mostrar_barra_topo']) ? intval($_POST['mostrar_barra_topo']) : 0,
        'mostrar_barra_inferior' => isset($_POST['mostrar_barra_inferior']) ? intval($_POST['mostrar_barra_inferior']) : 0,
        'mostrar_modal_download' => isset($_POST['mostrar_modal_download']) ? intval($_POST['mostrar_modal_download']) : 0
    ];

    if (update_config($data)) {
        $_SESSION['toastType'] = 'success';
        $_SESSION['toastMessage'] = 'Configurações de apps atualizadas com sucesso!';
    } else {
        $_SESSION['toastType'] = 'error';
        $_SESSION['toastMessage'] = 'Erro ao atualizar as configurações. Tente novamente.';
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Recupera os dados atuais para exibição no formulário
$config = get_afiliados_config();

// Recupera e limpa as variáveis de notificação (toast)
$toastType = isset($_SESSION['toastType']) ? $_SESSION['toastType'] : null;
$toastMessage = isset($_SESSION['toastMessage']) ? $_SESSION['toastMessage'] : '';
unset($_SESSION['toastType'], $_SESSION['toastMessage']);
?>
<!doctype html>
<html lang="pt">
<head>
    <?php $title = "Configurações de App"; include 'partials/title-meta.php'; ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php'; ?>
</head>
<body>
    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php'; ?>
    <!-- Top Bar End -->
    <!-- Leftbar-Tab-Menu -->
    <?php include 'partials/startbar.php'; ?>
    <!-- End Leftbar-Tab-Menu -->

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <!-- Formulário de Configurações -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gerenciamento de popup de download</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="row">
                                        <!-- Versão Do Aplicativo Android -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-user"></i> Versão Do Aplicativo Android</h5>
                                                    <input type="text" name="versao_app_android" class="form-control"
                                                           value="<?= $config['versao_app_android'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Versão Do Aplicativo IOS -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-group"></i> Versão Do Aplicativo IOS</h5>
                                                    <input type="text" name="versao_app_ios" class="form-control"
                                                           value="<?= $config['versao_app_ios'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Mensagem Popup (Android/IOS) -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-community"></i> Mensagem No Popup (Android/IOS)</h5>
                                                    <input type="text" name="mensagem_app" class="form-control"
                                                           value="<?= $config['mensagem_app'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Link Do App Android-->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-percentage-circle"></i> Link Do App Android</h5>
                                                    <input type="text" name="link_app_android" class="form-control"
                                                           value="<?= $config['link_app_android'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Link Do App IOS -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-percentage-circle"></i> Link Do App IOS</h5>
                                                    <input type="text" name="link_app_ios" class="form-control"
                                                           value="<?= $config['link_app_ios'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Exibir/Ocultar Barra de Download Superior -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-download"></i> Exibir Barra de Download Superior</h5>
                                                    <select name="mostrar_barra_topo" class="form-control" required>
                                                        <option value="1" <?= $config['mostrar_barra_topo'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="0" <?= $config['mostrar_barra_topo'] == 0 ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Exibir/Ocultar Barra de Download Inferior -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-download"></i> Exibir Barra de Download Inferior</h5>
                                                    <select name="mostrar_barra_inferior" class="form-control" required>
                                                        <option value="1" <?= $config['mostrar_barra_inferior'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="0" <?= $config['mostrar_barra_inferior'] == 0 ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Exibir/Ocultar Modal de Download -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-download"></i> Exibir Modal de Download</h5>
                                                    <select name="mostrar_modal_download" class="form-control" required>
                                                        <option value="1" <?= $config['mostrar_modal_download'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="0" <?= $config['mostrar_modal_download'] == 0 ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Salvar Configurações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div><!-- container -->

            <?php include 'partials/endbar.php'; ?>
            <?php include 'partials/footer.php'; ?>
        </div><!-- page content -->
    </div><!-- page-wrapper -->

    <!-- Toast container -->
    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- Javascript -->
    <?php include 'partials/vendorjs.php'; ?>
    <script src="assets/js/app.js"></script>

    <!-- Função de Toast -->
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

    <!-- Exibir o Toast somente quando houver notificação -->
    <?php if ($toastType && $toastMessage): ?>
        <script>
            showToast('<?= $toastType ?>', '<?= $toastMessage ?>');
        </script>
    <?php endif; ?>

</body>
</html>
<?php
ob_end_flush(); // Envia a saída
?>
