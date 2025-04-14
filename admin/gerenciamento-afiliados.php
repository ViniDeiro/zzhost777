<?php include 'partials/html.php' ?>

<?php

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

checa_login_adm();

if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}

function get_afiliados_config()
{
    global $mysqli;
    $qry = "SELECT * FROM afiliados_config WHERE id=1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

function update_afiliados_config($data)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE afiliados_config SET 
        cpaLvl1 = ?, 
        cpaLvl2 = ?, 
        cpaLvl3 = ?, 
        chanceCpa = ?, 
        revShareFalso = ?, 
        revShareLvl1 = ?, 
        revShareLvl2 = ?, 
        revShareLvl3 = ?, 
        minDepForCpa = ?, 
        minResgate = ? 
        WHERE id = 1");

    $qry->bind_param(
        "dddddddddd",
        $data['cpaLvl1'],
        $data['cpaLvl2'],
        $data['cpaLvl3'],
        $data['chanceCpa'],
        $data['revShareFalso'],
        $data['revShareLvl1'],
        $data['revShareLvl2'],
        $data['revShareLvl3'],
        $data['minDepForCpa'],
        $data['minResgate']
    );
    return $qry->execute();
}

$toastType = null;
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'cpaLvl1' => floatval($_POST['cpaLvl1']),
        'cpaLvl2' => floatval($_POST['cpaLvl2']),
        'cpaLvl3' => floatval($_POST['cpaLvl3']),
        'chanceCpa' => floatval($_POST['chanceCpa']),
        'revShareFalso' => floatval($_POST['revShareFalso']),
        'revShareLvl1' => floatval($_POST['revShareLvl1']),
        'revShareLvl2' => floatval($_POST['revShareLvl2']),
        'revShareLvl3' => floatval($_POST['revShareLvl3']),
        'minDepForCpa' => floatval($_POST['minDepForCpa']),
        'minResgate' => floatval($_POST['minResgate']),
    ];

    if (update_afiliados_config($data)) {
        $toastType = 'success';
        $toastMessage = 'Configurações de afiliados atualizadas com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar as configurações. Tente novamente.';
    }
}

$config = get_afiliados_config();
?>

<head>
    <?php $title = "Configurações de Afiliados";
    include 'partials/title-meta.php' ?>

    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php' ?>
</head>

<body>

    <?php include 'partials/topbar.php' ?>
    <?php include 'partials/startbar.php' ?>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gerenciamento de Configurações de Afiliados</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="row">
                                        <!-- Chance de CPA -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-percentage-circle"></i> Chances de Indicados
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                       No momento do cadastro, sortearemos um número entre 1 e 100, se estiver acima do definido, iremos definir o usuário como afiliado da indicação. (Exemplo: Se está definido 80, somente se o usuário for sorteado acima de 80 será marcado como afiliado. Portanto, para ativar todos indicados, coloque 0, pois 1 é maior do que 0.
                                                    </p>
                                                    <input type="text" name="chanceCpa" class="form-control"
                                                        value="<?= $config['chanceCpa'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- RevShare Nível 1 -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-percent-rotate-out"></i> RevShare (%)
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Porcentagem de Percas que o afiliado (influenciador) terá das percas dos indicados dele(a)s.
                                                    </p>
                                                    <input type="text" name="revShareLvl1" class="form-control"
                                                        value="<?= $config['revShareLvl1'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Depósito Mínimo para CPA -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-send-dollars"></i> Depósito Mínimo (Baú)
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Esse é o valor exato que o indicado precisa depositar para "ativar" o baú do afiliado.
                                                    </p>
                                                    <input type="text" name="minDepForCpa" class="form-control"
                                                        value="<?= $config['minDepForCpa'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Valor Mínimo para Resgate -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-send-dollars"></i> Valor apostado (Baú)
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Esse é o valor exato que o indicado precisa apostar para o afiliado "resgatar" o baú.
                                                    </p>
                                                    <input type="text" name="minResgate" class="form-control"
                                                        value="<?= $config['minResgate'] ?>" required>
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

    <?php if ($toastType && $toastMessage): ?>
        <script>
            showToast('<?= $toastType ?>', '<?= $toastMessage ?>');
        </script>
    <?php endif; ?>

</body>
</html>