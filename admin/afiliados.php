<?php include 'partials/html.php' ?>

<head>
    <?php $title = "expfygaming"; ?>
    <?php include 'partials/title-meta.php' ?>
    <?php include 'partials/head-css.php' ?>
</head>

<?
include_once "validar_2fa.php";
?>

<body>
    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php' ?>
    <!-- Top Bar End -->
    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php' ?>
    <!-- end leftbar-tab-menu-->

    <?php
    // Capturar os parâmetros de busca e filtro
    $search_query = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_query = mysqli_real_escape_string($mysqli, $_GET['search']);
    }

    // Configuração da paginação
    $limit = 50; // Limite de 50 usuários por página
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Consulta para contar o total de afiliados
    $query_total_afiliados = "SELECT COUNT(*) AS total_afiliados FROM usuarios WHERE statusaff = 1";
    if (!empty($search_query)) {
        $query_total_afiliados .= " AND (id LIKE '%$search_query%' OR mobile LIKE '%$search_query%')";
    }
    $result_total_afiliados = mysqli_query($mysqli, $query_total_afiliados);
    $total_afiliados = mysqli_fetch_assoc($result_total_afiliados)['total_afiliados'];

    // Cálculo do total de páginas
    $total_pages = ceil($total_afiliados / $limit);

    // Consulta para exibir os afiliados com paginação e filtro
    $query_afiliados = "SELECT * FROM usuarios WHERE statusaff = 1";
    
    // Filtrar por busca (ID ou nome de afiliado)
    if (!empty($search_query)) {
        $query_afiliados .= " AND (id LIKE '%$search_query%' OR mobile LIKE '%$search_query%')";
    }

    // Ordenar e paginar
    $query_afiliados .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $result_afiliados = mysqli_query($mysqli, $query_afiliados);
    ?>

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Todos Afiliados (<?= $total_afiliados; ?> no total)</h4>
                                    </div>
                                    <div class="col text-end">
                                        <a href="export/exportar_usuarios.php" class="btn btn-primary">Exportar Dados</a>
                                    </div>
                                </div>
                            </div><!--end card-header-->

                            <!-- Filtros e Busca -->
                            <div class="card-body pt-0">
                                <form method="GET" action="">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Buscar por ID ou Nome do Afiliado"
                                                value="<?= htmlspecialchars($search_query) ?>">
                                        </div>
                                        <div class="col-md-4 text-start">
                                            <button type="submit" class="btn btn-success mt-2">Filtrar</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Id</th>
                                                <th>Usuário</th>
                                                <th>Saldo</th>
                                                <th>Depositado</th>
                                                <th>Sacado</th>
                                                <th>Cargo</th>
                                                <th class="text-end">Detalhes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result_afiliados && mysqli_num_rows($result_afiliados) > 0) {
                                                while ($afiliado = mysqli_fetch_assoc($result_afiliados)) {
                                                    // Consultar total sacado e depositado
                                                    $query_sacado = "SELECT SUM(valor) AS total_sacado FROM solicitacao_saques WHERE id_user IN (SELECT id FROM usuarios WHERE invitation_code = '{$afiliado['invite_code']}') AND status = 1";
                                                    $result_sacado = mysqli_query($mysqli, $query_sacado);
                                                    $sacado = ($result_sacado && mysqli_num_rows($result_sacado) > 0) ? mysqli_fetch_assoc($result_sacado)['total_sacado'] : 0;

                                                    $query_depositado = "SELECT SUM(valor) AS total_depositado FROM transacoes WHERE usuario IN (SELECT id FROM usuarios WHERE invitation_code = '{$afiliado['invite_code']}') AND status = 'pago'";
                                                    $result_depositado = mysqli_query($mysqli, $query_depositado);
                                                    $depositado = ($result_depositado && mysqli_num_rows($result_depositado) > 0) ? mysqli_fetch_assoc($result_depositado)['total_depositado'] : 0;

                                                    $cargo_badge = "<span class='badge bg-danger'>Afiliado</span>";
                                                    ?>
                                                    <tr>
                                                        <td><?= $afiliado['id']; ?></td>
                                                        <td><?= $afiliado['mobile']; ?></td>
                                                        <td>R$ <?= number_format($afiliado['saldo'], 2, ',', '.'); ?></td>
                                                        <td>R$ <?= number_format($depositado, 2, ',', '.'); ?></td>
                                                        <td>R$ <?= number_format($sacado, 2, ',', '.'); ?></td>
                                                        <td><?= $cargo_badge; ?></td>
                                                        <td class="text-end">
                                                            <div class="dropdown d-inline-block">
                                                                <a class="dropdown-toggle arrow-none" id="dLabel11"
                                                                    data-bs-toggle="dropdown" href="#" role="button"
                                                                    aria-haspopup="false" aria-expanded="false">
                                                                    <i class="las la-ellipsis-v fs-20 text-muted"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item text-success"
                                                                        href="<?= $painel_adm_ver_usuarios . encodeAll($afiliado['id']); ?>">
                                                                        <i class="las la-info-circle"></i> Detalhes
                                                                    </a>
                                                                    <a class="dropdown-item text-danger" href="#">
                                                                        <i class="las la-ban"></i> Deletar Afiliado
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Sem dados disponíveis!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table><!--end /table-->
                                </div><!--end /tableresponsive-->

                                <!-- Paginação -->
                                <?php if ($total_pages > 1): ?>
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Anterior">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($page < $total_pages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Próximo">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                <?php endif; ?>
                            </div><!--end card-body-->
                        </div>

                        <!-- Resumo Financeiro Afiliados -->
                        <div class="row mt-4">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Trazido pelos Afiliados</h5>
                                        <p class="text-muted mb-0">R$
                                            <?= number_format(total_trazido_afiliados(), 2, ',', '.'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total de Pessoas Trazidas</h5>
                                        <p class="text-muted mb-0"><?= total_pessoas_afiliados(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Sacado pelos Usuários dos Afiliados</h5>
                                        <p class="text-muted mb-0">R$
                                            <?= number_format(total_saques_afiliados(), 2, ',', '.'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!-- container -->

            <!--Start Rightbar-->
            <?php include 'partials/endbar.php' ?>
            <!--end Rightbar-->
            <!--Start Footer-->
            <?php include 'partials/footer.php' ?>
            <!--end footer-->
        </div><!-- end page content -->
    </div><!-- end page-wrapper -->

    <!-- Javascript  -->
    <?php include 'partials/vendorjs.php' ?>
    <script src="assets/js/app.js"></script>
</body>

</html>

<?php
// Funções de totalização para afiliados
function total_trazido_afiliados() {
    global $mysqli;
    $qry = "SELECT SUM(valor) as total_trazido FROM transacoes WHERE usuario IN (SELECT id FROM usuarios WHERE invitation_code IS NOT NULL) AND status = 'pago'";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total_trazido'] ?? 0;
}

function total_pessoas_afiliados() {
    global $mysqli;
    $qry = "SELECT COUNT(*) as total_pessoas FROM usuarios WHERE invitation_code IS NOT NULL";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total_pessoas'] ?? 0;
}

function total_saques_afiliados() {
    global $mysqli;
    $qry = "SELECT SUM(valor) as total_saques FROM solicitacao_saques WHERE id_user IN (SELECT id FROM usuarios WHERE invitation_code IS NOT NULL) AND status = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total_saques'] ?? 0;
}
?>
