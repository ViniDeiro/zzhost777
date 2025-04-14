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

// Lógica para pegar a busca do usuário
$search_query = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($mysqli, $_GET['search']);
}

function get_cupons_usados($limit, $offset, $search_query = '')
{
    global $mysqli;
    $qry = "
        SELECT 
            cupom_usados.id_user,
            cupom_usados.id_cupom,
            cupom_usados.valor,
            cupom_usados.data_time,
            cupom.nome AS nome_cupom
        FROM 
            cupom_usados
        JOIN 
            cupom ON cupom_usados.id_cupom = cupom.id
    ";

    // Se houver um filtro de busca, modificamos a query
    if (!empty($search_query)) {
        $qry .= " WHERE cupom_usados.id_user LIKE '%$search_query%'";
    }

    $qry .= " ORDER BY cupom_usados.data_time DESC LIMIT $limit OFFSET $offset";

    $result = mysqli_query($mysqli, $qry);
    $cupons = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cupons[] = $row;
    }
    return $cupons;
}

function count_cupons_usados($search_query = '')
{
    global $mysqli;
    $qry = "SELECT COUNT(*) as total FROM cupom_usados";

    // Se houver um filtro de busca, modificamos a query
    if (!empty($search_query)) {
        $qry .= " WHERE id_user LIKE '%$search_query%'";
    }

    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total'];
}

$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total_cupons = count_cupons_usados($search_query);
$total_pages = ceil($total_cupons / $limit);

$cupons_usados = get_cupons_usados($limit, $offset, $search_query);
?>

<head>
    <?php $title = "Histórico de Bônus Usados";
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
                                <h4 class="card-title">Histórico de Bônus Usados</h4>
                            </div>
                            
                            <div class="card-body pt-0">
                                <form method="GET" action="">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Buscar por ID do usuário"
                                                value="<?= htmlspecialchars($search_query) ?>">
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="submit" class="btn btn-success mt-2 mb-2">Filtrar</button>
                                        </div>
                                    </div>
                                </form>
                            
                            <div class="card-body">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>ID Usuário</th>
                                            <th>Nome do Bônus</th>
                                            <th>Valor</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cupons_usados as $cupom): ?>
                                            <tr>
                                                <td><?= $cupom['id_user'] ?></td>
                                                <td><?= $cupom['nome_cupom'] ?></td>
                                                <td>R$ <?= number_format($cupom['valor'], 2, ',', '.') ?></td>
                                                <td><?= date('d/m/Y H:i:s', strtotime($cupom['data_time'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=1" aria-label="Primeira página">
                                                <span aria-hidden="true">&laquo;&laquo;</span>
                                            </a>
                                        </li>
                                
                                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Página anterior">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                
                                        <?php
                                        $range = 2;
                                        $start = max(1, $page - $range);
                                        $end = min($total_pages, $page + $range);
                                
                                        for ($i = $start; $i <= $end; $i++):
                                        ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                
                                        <?php if ($end < $total_pages): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        <?php endif; ?>
                                
                                        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Próxima página">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                
                                        <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= $total_pages ?>" aria-label="Última página">
                                                <span aria-hidden="true">&raquo;&raquo;</span>
                                            </a>
                                        </li>
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

</body>
</html>
