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

// Processamento do formulário para redefinir 2FA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['redefinir_2fa'])) {
    $id = intval($_POST['id']);
    $current2fa = $_POST['current2fa'];
    $new2fa = $_POST['new2fa'];
    $confirm2fa = $_POST['confirm2fa'];
    
    // Busca o 2FA atual do admin no banco
    $qry = "SELECT `2fa` FROM admin_users WHERE id = $id LIMIT 1";
    $result = mysqli_query($mysqli, $qry);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        // Se estiver usando hash, use password_verify() em vez de comparação direta
        if ($data['2fa'] !== $current2fa) {
            $toastType = 'error';
            $toastMessage = '2FA atual incorreto.';
        } else if ($new2fa !== $confirm2fa) {
            $toastType = 'error';
            $toastMessage = 'O novo 2FA e a confirmação não coincidem.';
        } else {
            $update = $mysqli->prepare("UPDATE admin_users SET `2fa` = ? WHERE id = ?");
            $update->bind_param("si", $new2fa, $id);
            if ($update->execute()) {
                $toastType = 'success';
                $toastMessage = '2FA atualizado com sucesso!';
            } else {
                $toastType = 'error';
                $toastMessage = 'Erro ao atualizar 2FA.';
            }
        }
    } else {
        $toastType = 'error';
        $toastMessage = 'Administrador não encontrado.';
    }
}

// Função para buscar todos os administradores
function get_admins() {
    global $mysqli;
    $qry = "SELECT * FROM admin_users";
    $result = mysqli_query($mysqli, $qry);
    $admins = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $admins[] = $row;
    }
    return $admins;
}

// Função para atualizar os dados de um administrador (exceto 2FA)
function update_admin($data) {
    global $mysqli;
    if (!empty($data['senha'])) {
        $senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT, array("cost" => 10));
        $qry = $mysqli->prepare("UPDATE admin_users SET nome = ?, email = ?, contato = ?, nivel = ?, status = ?, avatar = ?, senha = ? WHERE id = ?");
        $qry->bind_param("sssisssi",
            $data['nome'],
            $data['email'],
            $data['contato'],
            $data['nivel'],
            $data['status'],
            $data['avatar'],
            $senha_hash,
            $data['id']
        );
    } else {
        $qry = $mysqli->prepare("UPDATE admin_users SET nome = ?, email = ?, contato = ?, nivel = ?, status = ?, avatar = ? WHERE id = ?");
        $qry->bind_param("sssissi",
            $data['nome'],
            $data['email'],
            $data['contato'],
            $data['nivel'],
            $data['status'],
            $data['avatar'],
            $data['id']
        );
    }
    return $qry->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_admin'])) {
    $data = [
        'id' => intval($_POST['id']),
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'contato' => $_POST['contato'],
        'senha' => $_POST['senha'], // Pode estar vazio
        'nivel' => intval($_POST['nivel']),
        'status' => intval($_POST['status']),
        'avatar' => $_POST['avatar']
    ];
    if (update_admin($data)) {
        $toastType = 'success';
        $toastMessage = 'Administrador atualizado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao atualizar o administrador.';
    }
}

function clear_history() {
    global $mysqli;
    $tables = ['historico_play', 'transacoes', 'usuarios', 'visita_site', 'bau', 'solicitacao_saques', 'logs', 'metodos_pagamentos', 'cupom_usados', 'historico_vip'];
    foreach ($tables as $table) {
        $mysqli->query("DELETE FROM $table");
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['limpar_historico'])) {
    $tables = ['historico_play', 'transacoes', 'usuarios', 'visita_site', 'bau', 'solicitacao_saques', 'logs', 'metodos_pagamentos', 'cupom_usados', 'historico_vip'];
    $errors = [];
    foreach ($tables as $table) {
        $query = "DELETE FROM $table";
        if (!$mysqli->query($query)) {
            $errors[] = "Erro ao limpar a tabela $table: " . $mysqli->error;
        }
    }
    if (empty($errors)) {
        $toastType = 'success';
        $toastMessage = 'Histórico limpo com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao limpar o histórico: ' . implode(', ', $errors);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
        '2fa' => $_POST['2fa'],
        'nivel' => 0,
        'status' => 1
    ];
    if (add_admin($data)) {
        $toastType = 'success';
        $toastMessage = 'Novo administrador adicionado com sucesso!';
    } else {
        $toastType = 'error';
        $toastMessage = 'Erro ao adicionar o administrador.';
    }
}

$toastType = isset($toastType) ? $toastType : null;
$toastMessage = isset($toastMessage) ? $toastMessage : '';

$admins = get_admins();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php $title = "Gerenciamento de Administradores"; include 'partials/title-meta.php'; ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php'; ?>
</head>
<body>
    <?php include 'partials/topbar.php'; ?>
    <?php include 'partials/startbar.php'; ?>

    <?php if (!isset($_SESSION['2fa_validado']) || $_SESSION['2fa_validado'] !== true): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('modal2FA'));
            modal.show();
        });
    </script>
    <?php endif; ?>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gerenciamento de Administradores</h4>
                                <button class="btn btn-success float-end" data-bs-toggle="modal" style="margin-top: 10px;" data-bs-target="#addAdminModal">Novo Administrador</button>
                                <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#limparHistoricoModal" style="margin-top: 10px; margin-right: 10px;">Limpar Histórico</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>2FA</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <td><?= $admin['nome'] ?></td>
                                            <td><?= $admin['email'] ?></td>
                                            <td>
                                                <!-- Em vez de exibir o 2FA, mostramos o botão para redefinir -->
                                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalRedefinir2fa<?= $admin['id'] ?>">Redefinir 2FA</button>
                                            </td>
                                            <td><?= $admin['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAdminModal<?= $admin['id'] ?>">Editar</button>
                                            </td>
                                        </tr>

                                        <!-- Modal de Edição do Administrador (exceto 2FA) -->
                                        <div class="modal fade" id="editAdminModal<?= $admin['id'] ?>" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editAdminModalLabel">Editar Administrador</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nome" class="form-label">Nome</label>
                                                                <input type="text" name="nome" class="form-control" value="<?= $admin['nome'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" name="email" class="form-control" value="<?= $admin['email'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="senha" class="form-label">Senha</label>
                                                                <input type="password" name="senha" class="form-control" placeholder="Deixe em branco para manter a senha atual">
                                                            </div>
                                                            <!-- Removido o campo 2FA -->
                                                            <div class="mb-3">
                                                                <label for="contato" class="form-label">Contato</label>
                                                                <input type="text" name="contato" class="form-control" value="<?= $admin['contato'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nivel" class="form-label">Nível</label>
                                                                <input type="number" name="nivel" class="form-control" value="<?= $admin['nivel'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1" <?= $admin['status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                                                    <option value="0" <?= $admin['status'] == 0 ? 'selected' : '' ?>>Inativo</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="avatar" class="form-label">Avatar</label>
                                                                <input type="text" name="avatar" class="form-control" value="<?= $admin['avatar'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_admin" class="btn btn-primary">Salvar Alterações</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para Redefinir 2FA do Administrador -->
                                        <div class="modal fade" id="modalRedefinir2fa<?= $admin['id'] ?>" tabindex="-1" aria-labelledby="modalRedefinir2faLabel<?= $admin['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalRedefinir2faLabel<?= $admin['id'] ?>">Redefinir 2FA</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="current2fa<?= $admin['id'] ?>" class="form-label">2FA Atual</label>
                                                                <input type="text" name="current2fa" id="current2fa<?= $admin['id'] ?>" class="form-control" placeholder="Digite o 2FA atual" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="new2fa<?= $admin['id'] ?>" class="form-label">Novo 2FA</label>
                                                                <input type="text" name="new2fa" id="new2fa<?= $admin['id'] ?>" class="form-control" placeholder="Digite o novo 2FA" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="confirm2fa<?= $admin['id'] ?>" class="form-label">Confirme o Novo 2FA</label>
                                                                <input type="text" name="confirm2fa" id="confirm2fa<?= $admin['id'] ?>" class="form-control" placeholder="Confirme o novo 2FA" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="redefinir_2fa" class="btn btn-success">Redefinir 2FA</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Modal de Limpar Histórico -->
                        <div class="modal fade" id="limparHistoricoModal" tabindex="-1" aria-labelledby="limparHistoricoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="limparHistoricoModalLabel">Limpar Histórico</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza de que deseja limpar todo o histórico? Esta ação é irreversível.
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" name="limpar_historico" class="btn btn-danger">Limpar Histórico</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Adição de Administrador -->
                        <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAdminModalLabel">Adicionar Novo Administrador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input type="text" name="nome" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="senha" class="form-label">Senha</label>
                                                <input type="password" name="senha" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="2fa" class="form-label">2FA</label>
                                                <input type="text" name="2fa" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" name="add_admin" class="btn btn-success">Adicionar Administrador</button>
                                        </div>
                                    </form>
                                </div>
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
