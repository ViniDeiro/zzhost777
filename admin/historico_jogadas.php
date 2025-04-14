<?php include 'partials/html.php'; ?>

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

/**
 * Retorna os registros do histórico de jogadas, com paginação e filtros.
 *
 * @param int    $limit         Quantidade de registros por página
 * @param int    $offset        Offset para paginação
 * @param string $search_query  Filtro de busca para o ID do usuário
 * @param string $start_date    Data inicial do filtro
 * @param string $end_date      Data final do filtro
 * @return array
 */
function get_historico_play($limit, $offset, $search_query = '', $start_date = '', $end_date = '')
{
    global $mysqli;

    // Monta a consulta inicial
    $qry = "SELECT * FROM historico_play WHERE 1=1";

    // Filtro por ID de usuário (parcial)
    if (!empty($search_query)) {
        $qry .= " AND id_user LIKE '%$search_query%'";
    }

    // Filtro por data (entre start_date e end_date)
    if (!empty($start_date) && !empty($end_date)) {
        // Ajusta para considerar o dia completo na data final
        $end_date .= ' 23:59:59';
        $start_date .= ' 00:00:00';
        $qry .= " AND (created_at BETWEEN '$start_date' AND '$end_date')";
    } 
    // Caso o usuário informe apenas data inicial
    elseif (!empty($start_date)) {
        $start_date .= ' 00:00:00';
        $qry .= " AND created_at >= '$start_date'";
    }
    // Caso o usuário informe apenas data final
    elseif (!empty($end_date)) {
        $end_date .= ' 23:59:59';
        $qry .= " AND created_at <= '$end_date'";
    }

    // Ordena pela data e limita de acordo com a paginação
    $qry .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

    $result = mysqli_query($mysqli, $qry);
    $historico = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $historico[] = $row;
    }

    return $historico;
}

/**
 * Conta o total de registros para montar a paginação,
 * também com possibilidade de filtrar por ID de usuário e data.
 *
 * @param string $search_query  Filtro do ID usuário
 * @param string $start_date    Data inicial
 * @param string $end_date      Data final
 * @return int
 */
function count_historico_play($search_query = '', $start_date = '', $end_date = '')
{
    global $mysqli;

    // Monta a consulta inicial
    $qry = "SELECT COUNT(*) as total FROM historico_play WHERE 1=1";

    // Filtro por ID de usuário
    if (!empty($search_query)) {
        $qry .= " AND id_user LIKE '%$search_query%'";
    }

    // Filtro por data
    if (!empty($start_date) && !empty($end_date)) {
        $end_date .= ' 23:59:59';
        $start_date .= ' 00:00:00';
        $qry .= " AND (created_at BETWEEN '$start_date' AND '$end_date')";
    } 
    elseif (!empty($start_date)) {
        $start_date .= ' 00:00:00';
        $qry .= " AND created_at >= '$start_date'";
    } 
    elseif (!empty($end_date)) {
        $end_date .= ' 23:59:59';
        $qry .= " AND created_at <= '$end_date'";
    }

    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

/**
 * Captura a string de busca (ID do usuário), se houver.
 */
$search_query = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($mysqli, $_GET['search']);
}

/**
 * Captura as datas enviadas pelo filtro.
 */
$start_date = '';
$end_date   = '';
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $start_date = mysqli_real_escape_string($mysqli, $_GET['start_date']);
}
if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $end_date = mysqli_real_escape_string($mysqli, $_GET['end_date']);
}

/**
 * Configuração de paginação.
 */
$limit = 10;
$page  = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

/**
 * Conta o total de registros filtrados (ou não) e calcula
 * o total de páginas a serem exibidas.
 */
$total_historico = count_historico_play($search_query, $start_date, $end_date);
$total_pages = ($total_historico > 0) ? ceil($total_historico / $limit) : 1;

/**
 * Busca os registros para a página atual, de acordo com os filtros.
 */
$historico_play = get_historico_play($limit, $offset, $search_query, $start_date, $end_date);

?>

<head>
    <?php 
        $title = "Gerenciamento de Cupons";
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
                                <h4 class="card-title">Histórico de Jogadas</h4>
                            </div>
                            <div class="card-body pt-0">

                                <!-- Barra de filtros -->
                                <form method="GET" action="">
                                    <div class="row mb-3">
                                        
                                        <!-- Filtro por ID de usuário -->
                                        <div class="col-md-3">
                                            <label for="search" class="form-label">ID do Usuário</label>
                                            <input 
                                                type="text" 
                                                name="search" 
                                                id="search" 
                                                class="form-control"
                                                placeholder="Digite o ID"
                                                value="<?= htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                        </div>

                                        <!-- Filtro por data inicial -->
                                        <div class="col-md-3">
                                            <label for="start_date" class="form-label">Data Inicial</label>
                                            <input 
                                                type="date" 
                                                name="start_date" 
                                                id="start_date" 
                                                class="form-control"
                                                value="<?= htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                        </div>

                                        <!-- Filtro por data final -->
                                        <div class="col-md-3">
                                            <label for="end_date" class="form-label">Data Final</label>
                                            <input 
                                                type="date" 
                                                name="end_date" 
                                                id="end_date" 
                                                class="form-control"
                                                value="<?= htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end justify-content-end">
                                            <button 
                                                type="submit" 
                                                class="btn btn-success w-100"
                                                style="height: 38px;"
                                            >
                                                Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="card-body">
                                    <table class="table table-responsive table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID Usuário</th>
                                                <th>Jogo</th>
                                                <th>Valor Apostado</th>
                                                <th>Valor Ganhado</th>
                                                <th>ID Transação</th>
                                                <th>Data</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($historico_play)): ?>
                                                <?php foreach ($historico_play as $play): ?>
                                                    <tr>
                                                        <td><?= $play['id_user'] ?></td>
                                                        <td><?= $play['nome_game'] ?></td>
                                                        <td>R$ <?= number_format($play['bet_money'], 2, ',', '.') ?></td>
                                                        <td>R$ <?= number_format($play['win_money'], 2, ',', '.') ?></td>
                                                        <td><?= $play['txn_id'] ?></td>
                                                        <td><?= date('d/m/Y H:i:s', strtotime($play['created_at'])) ?></td>
                                                        <td><?= $play['status_play'] == 1 ? 'Concluído' : 'Em Andamento' ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        Nenhum registro encontrado.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <!-- Paginação -->
                                    <?php if ($total_historico > 0): ?>
                                        <nav aria-label="Page navigation" class="mt-3">
                                            <ul class="pagination justify-content-center">

                                                <!-- Primeira página -->
                                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                                    <a 
                                                        class="page-link" 
                                                        href="?page=1<?= $search_query ? '&search=' . urlencode($search_query) : '' ?><?= $start_date ? '&start_date=' . urlencode($start_date) : '' ?><?= $end_date ? '&end_date=' . urlencode($end_date) : '' ?>" 
                                                        aria-label="Primeira página"
                                                    >
                                                        &laquo;&laquo;
                                                    </a>
                                                </li>

                                                <!-- Página anterior -->
                                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                                    <a 
                                                        class="page-link" 
                                                        href="?page=<?= $page - 1 ?><?= $search_query ? '&search=' . urlencode($search_query) : '' ?><?= $start_date ? '&start_date=' . urlencode($start_date) : '' ?><?= $end_date ? '&end_date=' . urlencode($end_date) : '' ?>"
                                                        aria-label="Página anterior"
                                                    >
                                                        &laquo;
                                                    </a>
                                                </li>

                                                <?php
                                                    // Exibe até 2 links antes e 2 depois da página atual
                                                    $range = 2;
                                                    $start = max(1, $page - $range);
                                                    $end   = min($total_pages, $page + $range);
                                                ?>

                                                <?php for ($i = $start; $i <= $end; $i++): ?>
                                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                        <a 
                                                            class="page-link" 
                                                            href="?page=<?= $i ?><?= $search_query ? '&search=' . urlencode($search_query) : '' ?><?= $start_date ? '&start_date=' . urlencode($start_date) : '' ?><?= $end_date ? '&end_date=' . urlencode($end_date) : '' ?>"
                                                        >
                                                            <?= $i ?>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>

                                                <!-- Próxima página -->
                                                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                                    <a 
                                                        class="page-link" 
                                                        href="?page=<?= $page + 1 ?><?= $search_query ? '&search=' . urlencode($search_query) : '' ?><?= $start_date ? '&start_date=' . urlencode($start_date) : '' ?><?= $end_date ? '&end_date=' . urlencode($end_date) : '' ?>"
                                                        aria-label="Próxima página"
                                                    >
                                                        &raquo;
                                                    </a>
                                                </li>

                                                <!-- Última página -->
                                                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                                    <a 
                                                        class="page-link" 
                                                        href="?page=<?= $total_pages ?><?= $search_query ? '&search=' . urlencode($search_query) : '' ?><?= $start_date ? '&start_date=' . urlencode($start_date) : '' ?><?= $end_date ? '&end_date=' . urlencode($end_date) : '' ?>"
                                                        aria-label="Última página"
                                                    >
                                                        &raquo;&raquo;
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>
                                </div><!-- end card-body -->
                            </div><!-- end card-body pt-0 -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container-xxl -->

            <?php include 'partials/endbar.php'; ?>
            <?php include 'partials/footer.php'; ?>
        </div><!-- end page-content -->
    </div><!-- end page-wrapper -->

    <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>
    <?php include 'partials/vendorjs.php'; ?>
    <script src="assets/js/app.js"></script>

    <script>
        function showToast(type, message) {
            var toastPlacement = document.getElementById('toastPlacement');
            var toast = document.createElement('div');
            toast.className = 'toast align-items-center bg-light border-0 fade show';
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

    <?php
    // Caso tenha scripts para exibir notificações via toast, descomente e ajuste:
    /*
    if (isset($toastType, $toastMessage) && $toastType && $toastMessage) {
        echo "
            <script>
                showToast('{$toastType}', '{$toastMessage}');
            </script>
        ";
    }
    */
    ?>

</body>
</html>
