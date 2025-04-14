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

// Função para obter o jackpot atual
function get_jackpot_atual()
{
    global $mysqli;
    $qry = "SELECT jackpot FROM config WHERE id = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['jackpot'];
}

// Função para atualizar o jackpot no banco de dados
function update_jackpot($jackpot)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE config SET jackpot = ? WHERE id = 1");
    $qry->bind_param("i", $jackpot);
    return $qry->execute();
}

$toastType = null;
$toastMessage = '';

// Processar o formulário enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jackpot_selecionado = intval($_POST['jackpot']);

    // Verificar se foi enviado um jackpot customizado
    if (!empty($_FILES['custom_jackpot']['name'])) {
        $custom_img = "../uploads/jackpot5.png";
        if (move_uploaded_file($_FILES["custom_jackpot"]["tmp_name"], $custom_img)) {
            $jackpot_selecionado = 5; // Definir como o jackpot personalizado
        } else {
            $toastType = 'error';
            $toastMessage = 'Erro ao enviar o jackpot customizado.';
        }
    }

    // Atualizar o jackpot no banco de dados
    if (update_jackpot($jackpot_selecionado)) {
        $toastType = 'success';
        $toastMessage = 'Jackpot atualizado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar o jackpot. Tente novamente.';
    }
}

// Obter o jackpot atual
$jackpot_atual = get_jackpot_atual();
?>

<head>
    <?php $title = "Configurações de Jackpot"; ?>
    <?php include 'partials/title-meta.php' ?>
    <?php include 'partials/head-css.php' ?>
</head>

<style>
.img-container {
    width: 100%;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.img-container img {
    width: auto;
    object-fit: cover;
}
</style>

<body>
    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php' ?>
    <!-- Top Bar End -->
    <!-- Left Bar Start -->
    <?php include 'partials/startbar.php' ?>
    <!-- End Left Bar -->

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Selecione um jackpot para personalizar</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <?php
                                        // Exibir os jackpots padrões (1 a 4)
                                        for ($i = 1; $i <= 4; $i++) {
                                            $selected = ($jackpot_atual == $i) ? 'border border-success' : '';
                                            echo "
                                            <div class='col-6 col-md-4 col-lg-3'>
                                                <div class='card mb-4'>
                                                <div class='img-container'>
                                                    <img src='/uploads/jackpot$i.png' class='card-img-top img-fluid $selected' alt='jackpot $i'>
                                                </div>
                                                    <div class='card-body text-center'>
                                                        <input type='radio' name='jackpot' value='$i' id='jackpot$i' ".($jackpot_atual == $i ? 'checked' : '').">
                                                        <label for='jackpot$i'>Jackpot $i</label>
                                                    </div>
                                                </div>
                                            </div>";
                                        }
                                        ?>
                                    </div>

                                    <div class="row mt-12">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <label for="custom_jackpot" class="form-label">Jackpot Personalizável</label>
                                                    <?php
                                                        $custom_jackpot_path = '/uploads/jackpot5.png';
                                                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $custom_jackpot_path)) {
                                                            echo "<div class='mb-3'>
                                                                <img src='$custom_jackpot_path' class='img-fluid' alt='Custom Jackpot' style='max-height: 150px;'>
                                                            </div>";
                                                        } else {
                                                            echo "<p class='text-muted'>Nenhuma imagem customizada de jackpot enviada ainda.</p>";
                                                        }
                                                    ?>
                                                    <input type="file" name="custom_jackpot" id="custom_jackpot"
                                                        class="form-control">
                                                    <input type="radio" style="margin-top: 10px" name="jackpot"
                                                        value="5" id="custom_jackpot_radio"
                                                        <?= $jackpot_atual == 5 ? 'checked' : '' ?>>
                                                    <label for="custom_jackpot_radio"
                                                        style="margin-top: -5px">Selecionar Custom Jackpot</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Salvar Jackpot</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php include 'partials/endbar.php' ?>
            <?php include 'partials/footer.php' ?>
            <!-- Footer End -->
        </div>
    </div>

    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <!-- JS and Scripts -->
    <?php include 'partials/vendorjs.php' ?>
    <script src="assets/js/app.js"></script>

    <!-- Toast notification script -->
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

        setTimeout(function() {
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
