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
include_once "validar_2fa.php";
include_once "services/CSRF_Protect.php";
$csrf = new CSRF_Protect();

checa_login_adm();

if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}

function get_afiliados_config()
{
    global $mysqli;
    $qry = "SELECT * FROM config WHERE id=1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result);
}

# Função para atualizar os dados da tabela afiliados_config
function update_config($data)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE config SET 
        qntsbaus = ?, 
        niveisbau = ?, 
        pessoasbau = ?
        WHERE id = 1");

    $qry->bind_param(
        "dsd",
        $data['qntsbaus'],
        $data['niveisbau'],
        $data['pessoasbau']
    );
    return $qry->execute();
}

# Se o formulário for enviado, atualizar os dados
$toastType = null; // Variável para definir o tipo de Toast
$toastMessage = ''; // Variável para definir a mensagem do Toast

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'qntsbaus' => floatval($_POST['qntsbaus']),
        'niveisbau' => $_POST['niveisbau'],
        'pessoasbau' => floatval($_POST['pessoasbau']),
    ];

    if (update_config($data)) {
        $toastType = 'success';
        $toastMessage = 'Configurações de Baús atualizadas com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar as configurações. Tente novamente.';
    }
}

# Buscar os dados atuais
$config = get_afiliados_config();
?>

<head>
    <?php $title = "Configurações de Baús";
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
                                <h4 class="card-title">Gerenciamento de baús da plataforma</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="row">
                                        <!-- Saque Minimo -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-box"></i> Qtd. Baús
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Quantidade de baús que será exibido na tela de afiliados. Ex: 50, será 50 baús disponíveis.
                                                    </p>
                                                    <input type="text" name="qntsbaus" class="form-control"
                                                        value="<?= $config['qntsbaus'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Saque automatico maximo -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-group"></i> Valores dos Baús
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Valores de cada baú baseado na quantidade de baús exibidos. Ex: 10,20 para 20 baús exibidos = 10 baús R$ 10 e + 10 baús R$ 20.
                                                    </p>
                                                    <input type="text" name="niveisbau" class="form-control"
                                                        value="<?= $config['niveisbau'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Depósito minimo -->
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="iconoir-community"></i> Qtd. Pessoas
                                                    </h5>
                                                    <p class="card-subtitle text-muted mb-2">
                                                        Quantidade de pessoas que será exibido na tela de afiliados dentro baú. Ex: Primeiro baú = 1 pessoa.
                                                    </p>
                                                    <input type="text" name="pessoasbau" class="form-control"
                                                        value="<?= $config['pessoasbau'] ?>" required>
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
            
                <?php include 'partials/endbar.php' ?>
    <?php include 'partials/footer.php' ?>
            
        </div><!-- page content -->
    </div><!-- page-wrapper -->

    <!-- Toast container -->
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
                    <img src="/uploads/logo.png.webp" alt="" height="20" class="me-1">
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

    <!-- Exibir o Toast baseado nas ações do formulário -->
    <?php if ($toastType && $toastMessage): ?>
        <script>
            showToast('<?= $toastType ?>', '<?= $toastMessage ?>');
        </script>
    <?php endif; ?>

</body>
</html>
