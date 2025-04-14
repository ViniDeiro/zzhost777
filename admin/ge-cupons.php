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

function get_coupons($limit, $offset)
{
    global $mysqli;
    $qry = "SELECT * FROM cupom LIMIT $limit OFFSET $offset";
    $result = mysqli_query($mysqli, $qry);
    $coupons = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $coupons[] = $row;
    }
    return $coupons;
}

function count_coupons()
{
    global $mysqli;
    $qry = "SELECT COUNT(*) as total FROM cupom";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total'];
}

function update_coupon($data)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE cupom SET 
        nome = ?, 
        tipo = ?, 
        valor = ?, 
        qtd = ?, 
        qtd_insert = ?, 
        status = ? 
        WHERE id = ?");

    $qry->bind_param(
        "siiisii",
        $data['nome'],
        $data['tipo'],
        $data['valor'],
        $data['qtd'],
        $data['qtd_insert'],
        $data['status'],
        $data['id']
    );
    return $qry->execute();
}

$toastType = null; 
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => intval($_POST['id']),
        'nome' => $_POST['nome'],
        'tipo' => intval($_POST['tipo']),
        'valor' => intval($_POST['valor']),
        'qtd' => intval($_POST['qtd']),
        'qtd_insert' => intval($_POST['qtd_insert']),
        'status' => intval($_POST['status']),
    ];

    if (update_coupon($data)) {
        $toastType = 'success';
        $toastMessage = 'Bônus atualizado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar o bônus. Tente novamente.';
    }
}

$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total_coupons = count_coupons();
$total_pages = ceil($total_coupons / $limit);

$coupons = get_coupons($limit, $offset);
?>

<head>
    <?php $title = "Gerenciamento de Cupons";
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
                                <h4 class="card-title">Gerenciamento de Bônus</h4>
                            </div>

                            <div class="card-body">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Valor</th>
                                            <th>Quantidade</th>
                                            <th>Inseridos</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($coupons as $coupon): ?>
                                            <tr>
                                                <td><?= $coupon['nome'] ?></td>
                                                <td><?= $coupon['tipo'] == 1 ? 'Recarga' : 'Saldo' ?></td>
                                                <td>R$ <?= $coupon['valor'] ?></td>
                                                <td>Disponível <?= $coupon['qtd'] ?> para uso</td>
                                                <td>R$ <?= $coupon['qtd_insert'] ?></td>
                                                <td><?= $coupon['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCouponModal<?= $coupon['id'] ?>">Editar</button>
                                                </td>
                                            </tr>

                                            <!-- Modal de Edição -->
                                            <div class="modal fade" id="editCouponModal<?= $coupon['id'] ?>" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editCouponModalLabel">Editar Bônus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nome" class="form-label">Nome</label>
                                                                    <input type="text" name="nome" class="form-control" value="<?= $coupon['nome'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tipo" class="form-label">Tipo</label>
                                                                    <select name="tipo" class="form-select" required>
                                                                        <option value="1" <?= $coupon['tipo'] == 1 ? 'selected' : '' ?>>Recarga</option>
                                                                        <option value="2" <?= $coupon['tipo'] == 2 ? 'selected' : '' ?>>Saldo</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="valor" class="form-label">Valor</label>
                                                                    <input type="number" name="valor" class="form-control" value="<?= $coupon['valor'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="qtd" class="form-label">Quantidade</label>
                                                                    <input type="number" name="qtd" class="form-control" value="<?= $coupon['qtd'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="qtd_insert" class="form-label">Inseridos</label>
                                                                    <input type="number" name="qtd_insert" class="form-control" value="<?= $coupon['qtd_insert'] ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="1" <?= $coupon['status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                                                        <option value="0" <?= $coupon['status'] == 0 ? 'selected' : '' ?>>Inativo</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?= $coupon['id'] ?>">
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