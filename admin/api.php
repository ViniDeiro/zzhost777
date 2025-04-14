<?php include 'partials/html.php' ?>

<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
include_once __DIR__ . '/../services/database.php';
include_once 'logs/registrar_logs.php';
include_once "services/funcao.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "validar_2fa.php";
include_once "services/CSRF_Protect.php";
$csrf = new CSRF_Protect();

checa_login_adm();

/* 
   As funções de atualização foram alteradas para realizar um upsert, 
   inserindo o registro caso não exista, ou atualizando-o caso já exista.
*/

function get_igamewin_config() {
    global $mysqli;
    $qry = "SELECT * FROM igamewin WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_igamewin_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO igamewin (id, url, agent_code, agent_token, ativo) VALUES (1, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE url = VALUES(url), agent_code = VALUES(agent_code), agent_token = VALUES(agent_token), ativo = VALUES(ativo)");
    $qry->bind_param("sssi",
        $data['url'],
        $data['agent_code'],
        $data['agent_token'],
        $data['ativo']
    );
    return $qry->execute();
}

function get_fiverscan_config() {
    global $mysqli;
    $qry = "SELECT * FROM fiverscan WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_fiverscan_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO fiverscan (id, url, agent_code, agent_token, ativo) VALUES (1, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE url = VALUES(url), agent_code = VALUES(agent_code), agent_token = VALUES(agent_token), ativo = VALUES(ativo)");
    $qry->bind_param("sssi",
        $data['url'],
        $data['agent_code'],
        $data['agent_token'],
        $data['ativo']
    );
    return $qry->execute();
}

function get_pragmatic_config() {
    global $mysqli;
    $qry = "SELECT * FROM apipragmatic WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_pragmatic_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO apipragmatic (id, url, agent_code, agent_token, agent_secret, ativo) VALUES (1, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE url = VALUES(url), agent_code = VALUES(agent_code), agent_token = VALUES(agent_token), agent_secret = VALUES(agent_secret), ativo = VALUES(ativo)");
    $qry->bind_param("ssssi",
        $data['url'],
        $data['agent_code'],
        $data['agent_token'],
        $data['agent_secret'],
        $data['ativo']
    );
    return $qry->execute();
}

function get_beeplay_config() {
    global $mysqli;
    $qry = "SELECT * FROM beeplay WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_beeplay_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO beeplay (id, url, agent_code, agent_token, ativo) VALUES (1, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE url = VALUES(url), agent_code = VALUES(agent_code), agent_token = VALUES(agent_token), ativo = VALUES(ativo)");
    $qry->bind_param("sssi",
        $data['url'],
        $data['agent_code'],
        $data['agent_token'],
        $data['ativo']
    );
    return $qry->execute();
}

function get_pgclone_config() {
    global $mysqli;
    $qry = "SELECT * FROM pgclone WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_pgclone_config($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO pgclone (id, url, agent_code, agent_token, agent_secret, ativo) VALUES (1, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE url = VALUES(url), agent_code = VALUES(agent_code), agent_token = VALUES(agent_token), agent_secret = VALUES(agent_secret), ativo = VALUES(ativo)");
    $qry->bind_param("ssssi",
        $data['url'],
        $data['agent_code'],
        $data['agent_token'],
        $data['agent_secret'],
        $data['ativo']
    );
    return $qry->execute();
}

$toastType = null;
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_igamewin'])) {
        $data = [
            'url'         => $_POST['url_igamewin'],
            'agent_code'  => $_POST['agent_code_igamewin'],
            'agent_token' => $_POST['agent_token_igamewin'],
            'ativo'       => intval($_POST['ativo_igamewin']),
        ];
        if (update_igamewin_config($data)) {
            $toastType = 'success';
            $toastMessage = 'Credenciais do iGameWin atualizadas com sucesso!';
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao atualizar as credenciais do iGameWin. Tente novamente.';
        }
    }
    
    if (isset($_POST['update_fiverscan'])) {
        $data = [
            'url'         => $_POST['url_fiverscan'],
            'agent_code'  => $_POST['agent_code_fiverscan'],
            'agent_token' => $_POST['agent_token_fiverscan'],
            'ativo'       => intval($_POST['ativo_fiverscan']),
        ];
        if (update_fiverscan_config($data)) {
            $toastType = 'success';
            $toastMessage = 'Credenciais do PlayFiver atualizadas com sucesso!';
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao atualizar as credenciais do PlayFiver. Tente novamente.';
        }
    }
    
    if (isset($_POST['update_pragmatic'])) {
        $data = [
            'url'           => $_POST['url_pragmatic'],
            'agent_code'    => $_POST['agent_code_pragmatic'],
            'agent_token'   => $_POST['agent_token_pragmatic'],
            'agent_secret'  => $_POST['agent_secret_pragmatic'],
            'ativo'         => intval($_POST['ativo_pragmatic']),
        ];
        if (update_pragmatic_config($data)) {
            $toastType = 'success';
            $toastMessage = 'Credenciais do Pragmatic Clone atualizadas com sucesso!';
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao atualizar as credenciais do Pragmatic Clone. Tente novamente.';
        }
    }
    
    if (isset($_POST['update_beeplay'])) {
        $data = [
            'url'         => $_POST['url_beeplay'],
            'agent_code'  => $_POST['agent_code_beeplay'],
            'agent_token' => $_POST['agent_token_beeplay'],
            'ativo'       => intval($_POST['ativo_beeplay']),
        ];
        if (update_beeplay_config($data)) {
            $toastType = 'success';
            $toastMessage = 'Credenciais do BeePlay atualizadas com sucesso!';
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao atualizar as credenciais do BeePlay. Tente novamente.';
        }
    }
    
    if (isset($_POST['update_pgclone'])) {
        $data = [
            'url'           => $_POST['url_pgclone'],
            'agent_code'    => $_POST['agent_code_pgclone'],
            'agent_token'   => $_POST['agent_token_pgclone'],
            'agent_secret'  => $_POST['agent_secret_pgclone'],
            'ativo'         => intval($_POST['ativo_pgclone']),
        ];
        if (update_pgclone_config($data)) {
            $toastType = 'success';
            $toastMessage = 'Credenciais do PGClone atualizadas com sucesso!';
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao atualizar as credenciais do PGClone. Tente novamente.';
        }
    }
}

// Buscar os dados atuais e definir valores padrão caso não existam
$igamewin_config   = get_igamewin_config();
if (!$igamewin_config) {
    $igamewin_config = ['url' => '', 'agent_code' => '', 'agent_token' => '', 'ativo' => 0];
}
$fiverscan_config  = get_fiverscan_config();
if (!$fiverscan_config) {
    $fiverscan_config = ['url' => '', 'agent_code' => '', 'agent_token' => '', 'ativo' => 0];
}
$pragmatic_config  = get_pragmatic_config();
if (!$pragmatic_config) {
    $pragmatic_config = ['url' => '', 'agent_code' => '', 'agent_token' => '', 'agent_secret' => '', 'ativo' => 0];
}
$beeplay_config    = get_beeplay_config();
if (!$beeplay_config) {
    $beeplay_config = ['url' => '', 'agent_code' => '', 'agent_token' => '', 'ativo' => 0];
}
$pgclone_config    = get_pgclone_config();
if (!$pgclone_config) {
    $pgclone_config = ['url' => '', 'agent_code' => '', 'agent_token' => '', 'agent_secret' => '', 'ativo' => 0];
}
?>

<head>
    <?php $title = "Configurações das APIs"; ?>
    <?php include 'partials/title-meta.php' ?>
    <?php include 'partials/head-css.php' ?>
</head>

<body>

    <?php include 'partials/topbar.php' ?>
    <?php include 'partials/startbar.php' ?>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <!-- API iGameWin - Primeiro container -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">API iGameWin ou iSlotFlix</h4>
                                <p>Callback, exatamente: https://seusite.com/callback/igamewin</p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="update_igamewin">
                                    <div class="row">
                                        <!-- URL -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">URL</h5>
                                                    <input type="text" name="url_igamewin" class="form-control" value="<?= $igamewin_config['url'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Agent Code -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Agent Code</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="agent_code_igamewin" name="agent_code_igamewin" class="form-control" value="<?= $igamewin_config['agent_code'] ?>" required>
                                                        <span class="input-group-text" onclick="togglePassword('agent_code_igamewin', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Agent Token -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Agent Token</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="agent_token_igamewin" name="agent_token_igamewin" class="form-control" value="<?= $igamewin_config['agent_token'] ?>" required>
                                                        <span class="input-group-text" onclick="togglePassword('agent_token_igamewin', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ativo -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-check-circle"></i> Ativo</h5>
                                                    <select name="ativo_igamewin" class="form-select" required>
                                                        <option value="1" <?= $igamewin_config['ativo'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="0" <?= $igamewin_config['ativo'] == 0 ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- Botão Adquirir -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title"><i class="iconoir-cart"></i> Recarga via EXPFY Brasil</h5>
                                                    <a href="https://wa.me/5584915035" target="_blank" class="btn btn-primary">Recarregar</a>
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
                </div>

                <!-- API PGClone (PGSoft 16 jogos) -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">API PGSoft 16 jogos</h4>
                                <p>Callback, exatamente: https://seusite.com/</p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="update_pgclone">
                                    <div class="row">
                                        <!-- URL -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">URL</h5>
                                                    <input type="text" name="url_pgclone" class="form-control" value="<?= $pgclone_config['url'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Agent Code -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Agent Code</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="agent_code_pgclone" name="agent_code_pgclone" class="form-control" value="<?= $pgclone_config['agent_code'] ?>" required>
                                                        <span class="input-group-text" onclick="togglePassword('agent_code_pgclone', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Agent Token -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Agent Token</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="agent_token_pgclone" name="agent_token_pgclone" class="form-control" value="<?= $pgclone_config['agent_token'] ?>" required>
                                                        <span class="input-group-text" onclick="togglePassword('agent_token_pgclone', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Agent Secret -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Agent Secret</h5>
                                                    <div class="input-group">
                                                        <input type="password" id="agent_secret_pgclone" name="agent_secret_pgclone" class="form-control" value="<?= $pgclone_config['agent_secret'] ?>" required>
                                                        <span class="input-group-text" onclick="togglePassword('agent_secret_pgclone', this)">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ativo -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title"><i class="iconoir-check-circle"></i> Ativo</h5>
                                                    <select name="ativo_pgclone" class="form-select" required>
                                                        <option value="1" <?= $pgclone_config['ativo'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="0" <?= $pgclone_config['ativo'] == 0 ? 'selected' : '' ?>>Não</option>
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
                </div>


            </div> <!-- container-xxl -->
            
            <?php include 'partials/endbar.php' ?>
            <?php include 'partials/footer.php' ?>
            
        </div> <!-- page-content -->
    </div> <!-- page-wrapper -->

    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- Javascript -->
    <?php include 'partials/vendorjs.php' ?>
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

    <!-- Exibir o Toast baseado nas ações do formulário -->
    <?php if ($toastType && $toastMessage): ?>
        <script>
            showToast('<?= $toastType ?>', '<?= $toastMessage ?>');
        </script>
    <?php endif; ?>

</body>
</html>
