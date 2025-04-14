<?php
session_start();

// Se já estiver logado, redireciona para o painel
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Incluir a conexão com o banco de dados
include '../admin/services/database.php';

$error = '';

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera e sanitiza os dados do formulário
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($mobile) || empty($password)) {
        $error = "Por favor, preencha todos os campos.";
    } else {
        // Prepara a consulta para evitar SQL Injection
        $stmt = $mysqli->prepare("SELECT id, password, statusaff FROM usuarios WHERE mobile = ?");
        if (!$stmt) {
            $error = "Erro na preparação da consulta: " . $mysqli->error;
        } else {
            $stmt->bind_param("s", $mobile);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se o usuário foi encontrado
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Verifica a senha utilizando password_verify (assumindo que a senha foi hashada)
                if (password_verify($password, $user['password'])) {
                    // Autenticação bem-sucedida
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['statusaff'] = $user['statusaff'];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Senha incorreta.";
                }
            } else {
                $error = "Usuário não encontrado.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel de Afiliados</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Painel de Afiliado</h1>
                <p>Faça login para acessar sua conta</p>
            </div>
            <?php if (!empty($error)): ?>
                <div style="color:red; text-align:center; margin-bottom:10px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form class="auth-form" method="post" action="login.php">
                <div class="form-group">
                    <label for="mobile">Nome de Usuário</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="mobile" name="mobile" required placeholder="Seu nome de usuário" value="<?php echo isset($mobile) ? htmlspecialchars($mobile) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Sua senha">
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Manter conectado
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Entrar
                </button>
            </form>

            
        </div>
    </div>
</body>
</html>
