<?php
session_start();

error_log("=== Iniciando verificação de autenticação e afiliação ===");


if (!isset($_SESSION['user_id'])) {
    error_log("Sessão sem user_id. Redirecionando para login.");
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
error_log("User ID da sessão: " . $user_id);



include '../admin/services/database.php';
include '../admin/services/crud.php';
include '../admin/services/afiliadoController.php';

$stats = getUserStats($user_id);
$performanceData = getPerformanceData($user_id, 7);

$query = "SELECT * FROM usuarios WHERE id = $user_id LIMIT 1";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    error_log("Erro na consulta ao banco: " . mysqli_error($mysqli));
    session_destroy();
    header("Location: login.php");
    exit();
}

if (mysqli_num_rows($result) === 0) {
    error_log("Nenhum registro encontrado para o user_id: " . $user_id);
    session_destroy();
    header("Location: login.php");
    exit();
}

$user = mysqli_fetch_assoc($result);
error_log("Dados do usuário recuperados: " . print_r($user, true));

$statusaff = (int)$user['statusaff'];
error_log("Valor de statusaff convertido para inteiro: " . $statusaff);


if ($statusaff !== 1) {
    error_log("Usuário não possui afiliação ativa. Valor de statusaff: " . $statusaff);
    echo "Você não possui uma afiliação ativa para acessar este conteúdo.";
    exit();
}


error_log("Usuário autenticado e com afiliação ativa. Acesso permitido.");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Afiliados - iGaming</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="user-info">
                    <img src="https://p2.trrsf.com/image/fget/cf/1200/1600/middle/images.terra.com/2024/09/10/nft_6633-qhq3yanf8ab8.PNG" alt="Perfil" class="profile-img">
                    <div>
                        <span class="user-role">Afiliate Pro</span>
                    </div>
                </div>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="index.php?page=dashboard">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?page=links">
                        <i class="fas fa-link"></i>
                        Meus Links
                    </a>
                </li>
                <li>
                    <a href="index.php?page=referrals">
                        <i class="fas fa-users"></i>
                        Indicações
                    </a>
                </li>
                <li>
                    <a href="index.php?page=stats">
                        <i class="fas fa-chart-bar"></i>
                        Estatísticas
                    </a>
                </li>
                <li>
                    <a href="index.php?page=commissions">
                        <i class="fas fa-dollar-sign"></i>
                        Comissões
                    </a>
                </li>
                <li>
                    <a href="index.php?page=withdrawals">
                        <i class="fas fa-money-bill-wave"></i>
                        Saques
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-headset"></i>
                        Suporte
                    </a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <div class="page-content">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                $allowed_pages = ['dashboard', 'links', 'referrals', 'stats', 'commissions', 'withdrawals', 'materials', 'support', 'profile'];
                
                if (in_array($page, $allowed_pages)) {
                    include "pages/{$page}.php";
                } else {
                    include "pages/dashboard.php";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = '<?php echo $page; ?>';
        document.querySelectorAll('.list-unstyled li').forEach(item => {
            const link = item.querySelector('a');
            const href = link.getAttribute('href');
            if (href.includes(currentPage)) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    });
    </script>
</body>
</html>