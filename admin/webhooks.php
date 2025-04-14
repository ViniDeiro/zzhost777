<?php
include 'partials/html.php';

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



function get_webhooks($limit, $offset)
{
    global $mysqli;
    $qry = "SELECT * FROM webhook LIMIT ? OFFSET ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $webhooks = [];
    while ($row = $result->fetch_assoc()) {
        $webhooks[] = $row;
    }
    return $webhooks;
}

function count_webhooks()
{
    global $mysqli;
    $qry = "SELECT COUNT(*) as total FROM webhook";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total'];
}

function update_webhook($data)
{
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE webhook SET 
        bot_id = ?, 
        chat_id = ?, 
        status = ? 
        WHERE id = ?");

    // "siii" se chat_id for int, "ssii" se chat_id for string
    $qry->bind_param(
        "ssii",
        $data['bot_id'],
        $data['chat_id'],
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
        'bot_id' => trim($_POST['bot_id']),
        'chat_id' => trim($_POST['chat_id']), // Use intval($_POST['chat_id']) se for int
        'status' => intval($_POST['status']),
    ];

    if (update_webhook($data)) {
        $toastType = 'success';
        $toastMessage = 'Webhook atualizado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar o webhook. Tente novamente.';
    }
}

$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total_webhooks = count_webhooks();
$total_pages = ceil($total_webhooks / $limit);

$webhooks = get_webhooks($limit, $offset);
?>
<!DOCTYPE html>
<html>
<head>
    <?php 
    $title = "Gerenciamento de Webhooks";
    include 'partials/title-meta.php'; 
    ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php'; ?>
</head>
<body>
    <?php include 'partials/topbar.php'; ?>
    <?php include 'partials/startbar.php'; ?>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gerenciamento de Webhooks</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Bot ID</th>
                                            <th>Chat ID</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($webhooks as $webhook): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($webhook['nome']) ?></td>
                                                <td><?= htmlspecialchars($webhook['bot_id']) ?></td>
                                                <td><?= htmlspecialchars($webhook['chat_id']) ?></td>
                                                <td><?= $webhook['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editWebhookModal<?= $webhook['id'] ?>">Editar</button>
                                                </td>
                                            </tr>

                                            <!-- Modal de Edição -->
                                            <div class="modal fade" id="editWebhookModal<?= $webhook['id'] ?>" tabindex="-1" aria-labelledby="editWebhookModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editWebhookModalLabel">Editar Webhook</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nome" class="form-label">Nome</label>
                                                                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($webhook['nome']) ?>" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="bot_id" class="form-label">Bot ID</label>
                                                                    <input type="text" name="bot_id" class="form-control" value="<?= htmlspecialchars($webhook['bot_id']) ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="chat_id" class="form-label">Chat ID</label>
                                                                    <input type="text" name="chat_id" class="form-control" value="<?= htmlspecialchars($webhook['chat_id']) ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" class="form-select" required>
                                                                        <option value="1" <?= $webhook['status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                                                        <option value="0" <?= $webhook['status'] == 0 ? 'selected' : '' ?>>Inativo</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?= $webhook['id'] ?>">
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
            <?php include 'partials/endbar.php'; ?>
            <?php include 'partials/footer.php'; ?>
        </div>
    </div>
    
    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>
    <?php include 'partials/vendorjs.php'; ?>
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
