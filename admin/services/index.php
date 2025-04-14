<?php include 'partials/html.php' ?>

<?php
#======================================#
ini_set('display_errors', 0);
error_reporting(E_ALL);
#======================================#
session_start();
include_once "services/database.php";
include_once 'logs/registrar_logs.php';
include_once "services/funcao.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "services/CSRF_Protect.php";
$csrf = new CSRF_Protect();
#======================================#
#expulsa user
checa_login_adm();
#======================================#
//inicio do scriot expulsa usuario bloqueado
if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}

// Pegar os dados para os gráficos de PHP
$depositos_dias = depositos_por_dia();
$saques_dias = saques_por_dia();

// Formatar os dados para uso em JavaScript
$labels_depositos = json_encode(array_column($depositos_dias, 'dia'));
$dados_depositos = json_encode(array_column($depositos_dias, 'total'));

$labels_saques = json_encode(array_column($saques_dias, 'dia'));
$dados_saques = json_encode(array_column($saques_dias, 'total'));
/// final do script --#
?>

<head>
    <?php $title = "expfygaming";
    include 'partials/title-meta.php' ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php' ?>
</head>


<body>

    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php' ?>
    <!-- Top Bar End -->
    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php' ?>
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Estatística de Cadastros</h5>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Total cadastros</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= qtd_usuarios(); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-group h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Novos cadastros total: <span class="text-success"><?= percentual_usuarios_90d(); ?>%</span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Cadastros hoje</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= qtd_usuarios_diarios(); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Novos cadastros: <span class="text-success"><?= percentual_usuarios_diarios(); ?>%</span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Cadastros 90D</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= qtd_usuarios_90d(); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Novos cadastros: <span class="text-success"><?= percentual_usuarios_90d(); ?>%</span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-database-monitor h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Estatística Financeira</h5>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Total de Jogadas</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= total_jogadas(); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-piggy-bank h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <?php
                                    $jogo_popular = jogo_mais_jogado();
                                    $jogo_color_class = ($jogo_popular === 'Nenhum jogo encontrado') ? 'text-danger' : 'text-success';
                                ?>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Jogo popular: <span class="<?= $jogo_color_class ?>"><?= $jogo_popular; ?></span>
                                </p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                    
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Lucro</p>
                                        <h3 class="mt-2 mb-0 fw-bold">R$<?= Reais2(saldo_cassino()); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-up h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <?php
                                    $percentual_lucro = percentual_lucro();
                                    $color_class = '';
                                    if ($percentual_lucro > 0) {
                                        $color_class = 'text-success'; // Verde para lucro positivo
                                    } elseif ($percentual_lucro < 0) {
                                        $color_class = 'text-danger'; // Vermelho para lucro negativo
                                    } else {
                                        $color_class = 'text-warning'; // Amarelo para lucro neutro
                                    }
                                ?>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Percentual de Lucro: <span class="<?= $color_class ?>"><?= $percentual_lucro; ?>%</span>
                                </p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Depósitos total</p>
                                        <h3 class="mt-2 mb-0 fw-bold">R$<?= Reais2(depositos_total()); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-up h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">Depósitos
                                        pendentes: <span class="text-success">R$<?= Reais2(depositos_pendentes()); ?></span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Depósitos Diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold">R$<?= Reais2(depositos_diarios()); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-hand-cash h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">Depósitos pagos
                                        <strong>(hoje)</strong>: <span class="text-success">R$<?= Reais2(depositos_diarios_pagos()); ?></span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saques total</p>
                                        <h3 class="mt-2 mb-0 fw-bold">R$<?= Reais2(saques_total()); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-down h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Saques pagos: <span class="text-danger"><?= count_saques_total(); ?></span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saques Diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold">R$<?= Reais2(saques_diarios_pagos()); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-hand-cash h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <p class="mb-0 text-truncate text-muted mt-3">Saques pagos
                                        <strong>(hoje)</strong>: <span class="text-danger">R$<?= Reais2(saques_diarios_pagos()); ?></span></p>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-database-monitor h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Estatística Visitas</h5>
                    </div>
                    
                    <!--end col-->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos total</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= visitas_count('total'); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= visitas_count('diario'); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos 90D</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= visitas_count('90d'); ?></h3>
                                    </div>
                                    <!--end col-->
                                    <div class="col-3 align-self-center">
                                        <div
                                            class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                </div>

                <div class="row mt-4">
                    
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> Saques Diários</h5>
                                <div id="chart-saques"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> Depósitos Diários</h5>
                                <div id="chart-depositos"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--end row-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-h-100">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Saques Aprovados</h4>
                                        <p class="fs-11 fst-bold text-muted">Últimos 5 Saques Aprovados.<a href="#!"
                                                class="link-danger ms-1"><i
                                                    class="align-middle iconoir-refresh"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive browser_users">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-top-0">Id</th>
                                                <th class="border-top-0">Usuário</th>
                                                <th class="border-top-0">Data/Hora</th>
                                                <th class="border-top-0">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            session_start();
                                            include_once '../services/database.php';
                                            include_once '../services/funcao.php';
                                            include_once '../services/crud.php';
                                            include_once '../services/crud-adm.php';
                                            include_once '../services/checa_login_adm.php';
                                            checa_login_adm();

                                            global $mysqli;
                                            $pagina = 1; // Página atual
                                            $qnt_result_pg = 5; // Quantidade de resultados por página
                                            $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

                                            // Consultar saques aprovados no banco de dados
                                            $result_usuario = "SELECT * FROM solicitacao_saques WHERE status = '1' ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";
                                            $resultado_usuario = mysqli_query($mysqli, $result_usuario);

                                            if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
                                                while ($data = mysqli_fetch_assoc($resultado_usuario)) {
                                                    $data_return = data_user_id($data['id_user']);
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['id']; ?></td>
                                                        <td><?= $data_return['mobile']; ?></td>
                                                        <td><?= ver_data($data['data_hora']); ?></td>
                                                        <td>R$ <?= Reais2($data['valor']); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>Sem dados disponíveis!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-h-100">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Depósitos Pagos</h4>
                                        <p class="fs-11 fst-bold text-muted">Últimos 5 Depósitos Pagos.<a href="#!"
                                                class="link-danger ms-1"><i
                                                    class="align-middle iconoir-refresh"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-top-0">Id</th>
                                                <th class="border-top-0">Usuário</th>
                                                <th class="border-top-0">Data/Hora</th>
                                                <th class="border-top-0">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Consultar total de visitas por canal no banco de dados
                                            $result_visitas = "SELECT * FROM transacoes WHERE status = 'pago' ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";
                                            $resultado_visitas = mysqli_query($mysqli, $result_visitas);

                                            if ($resultado_visitas && mysqli_num_rows($resultado_visitas) > 0) {
                                                while ($visit = mysqli_fetch_assoc($resultado_visitas)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $visit['id']; ?></td>
                                                        <td><?= $visit['usuario']; ?></td>
                                                        <td><?= $visit['data_hora']; ?></td>
                                                        <td><?= $visit['valor']; ?> <i
                                                                class="fas <?= $change_icon; ?> font-16"></i>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>Sem dados disponíveis!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end row-->
            </div><!-- container -->

            <!--Start Rightbar-->
            <?php include 'partials/endbar.php' ?>
            <!--end Rightbar-->
            <!--Start Footer-->
            <?php include 'partials/footer.php' ?>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->
    <!-- vendor js -->
    <?php include 'partials/vendorjs.php' ?>

    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/data/stock-prices.js"></script>
    <script src="assets/libs/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world.js"></script>
    <script src="assets/js/pages/index.init.js"></script>
    <script src="assets/js/app.js"></script>


    <script>
        // Usar as variáveis PHP para passar os dados diretamente para o JavaScript
        var labelsDepositos = <?= $labels_depositos; ?>;
        var depositosData = <?= $dados_depositos; ?>;

        var labelsSaques = <?= $labels_saques; ?>;
        var saquesData = <?= $dados_saques; ?>;

        // Gráfico de Depósitos
        var optionsDepositos = {
            series: [{
                name: 'Depósitos',
                data: depositosData
            }],
            chart: {
                type: 'line',
                height: 350
            },
            xaxis: {
                categories: labelsDepositos
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                align: 'left'
            }
        };

        var chartDepositos = new ApexCharts(document.querySelector("#chart-depositos"), optionsDepositos);
        chartDepositos.render();

        // Gráfico de Saques
        var optionsSaques = {
            series: [{
                name: 'Saques',
                data: saquesData
            }],
            chart: {
                type: 'line',
                height: 350
            },
            xaxis: {
                categories: labelsSaques
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                align: 'left'
            }
        };

        var chartSaques = new ApexCharts(document.querySelector("#chart-saques"), optionsSaques);
        chartSaques.render();
    </script>


</body>
<!--end body-->

</html>