<?php include 'partials/html.php' ?>

<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
include_once "services/database.php"; // Certifique-se de que a conexão está correta
include_once 'logs/registrar_logs.php';
include_once "services/funcao.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "services/CSRF_Protect.php";
include_once "validar_2fa.php";

$csrf = new CSRF_Protect();

checa_login_adm();

function get_vip_levels($limit, $offset)
{
    global $mysqli;
    $qry = "SELECT * FROM vip_levels LIMIT $limit OFFSET $offset";
    $result = mysqli_query($mysqli, $qry);
    $vip_levels = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $vip_levels[] = $row;
    }
    return $vip_levels;
}

function count_vip_levels()
{
    global $mysqli;
    $qry = "SELECT COUNT(*) as total FROM vip_levels";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total'];
}

function update_vip_level($data)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE vip_levels SET 
        id_vip = ?, 
        meta = ?, 
        bonus = ? 
        WHERE id = ?");

    $qry->bind_param(
        "iidi",
        $data['id_vip'],
        $data['meta'],
        $data['bonus'],
        $data['id']
    );
    return $qry->execute();
}

$toastType = null; 
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => intval($_POST['id']),
        'id_vip' => intval($_POST['id_vip']),
        'meta' => floatval($_POST['meta']),
        'bonus' => floatval($_POST['bonus']),
    ];

    if (update_vip_level($data)) {
        $toastType = 'success';
        $toastMessage = 'Nível VIP atualizado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar o nível VIP. Tente novamente.';
    }
}

$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total_vip_levels = count_vip_levels();
$total_pages = ceil($total_vip_levels / $limit);

$vip_levels = get_vip_levels($limit, $offset);
?>


<head>
    <?php $title = "Gerenciamento de Níveis";
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
                                <h4 class="card-title">Gerenciamento de Níveis</h4>
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID VIP</th>
                                        <th>Meta</th>
                                        <th>Bônus</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vip_levels as $level): ?>
                                        <tr>
                                            <td><img src="https://pngfre.com/wp-content/uploads/Trophy-10.png" style="width: 20px;"> Nível <?= $level['id_vip'] ?></td>
                                            <td>R$ <?= number_format($level['meta'], 2, ',', '.') ?> em apostas</td>
                                            <td>R$ <?= number_format($level['bonus'], 2, ',', '.') ?> em saldo</td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editVipModal<?= $level['id'] ?>">Editar</button>
                                            </td>
                                        </tr>
                            
                                        <!-- Modal de Edição -->
                                        <div class="modal fade" id="editVipModal<?= $level['id'] ?>" tabindex="-1" aria-labelledby="editVipModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editVipModalLabel">Editar Nível VIP</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="id_vip" class="form-label">ID VIP</label>
                                                                <input type="number" name="id_vip" class="form-control" value="<?= $level['id_vip'] ?>" readonly="">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="meta" class="form-label">Meta</label>
                                                                <input type="number" step="0.01" name="meta" class="form-control" value="<?= $level['meta'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bonus" class="form-label">Bônus</label>
                                                                <input type="number" step="0.01" name="bonus" class="form-control" value="<?= $level['bonus'] ?>" required>
                                                            </div>
                                                            <input type="hidden" name="id" value="<?= $level['id'] ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>

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