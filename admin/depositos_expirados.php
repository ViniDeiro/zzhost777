<?php include 'partials/html.php' ?>

<?php
include_once "validar_2fa.php";
?>

<head>
    <?php 
    $title = "expfygaming";
    include 'partials/title-meta.php'; 
    include 'partials/head-css.php'; 
    ?>
</head>

<body>
    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php'; ?>
    <!-- Top Bar End -->
    
    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php'; ?>
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">

                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col" style="display: flex; align-content: center; align-items: center;">
                                        <div class="tag"></div>
                                        <h4 class="card-title">Depósitos Expirados</h4>
                                    </div><!--end col-->
                                </div> <!--end row-->
                            </div><!--end card-header-->

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Id</th>
                                                <th>Usuário</th>
                                                <th>Transação ID</th>
                                                <th>Valor</th>
                                                <th>Data/Hora</th>
                                                <th>Copia E Cola</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            global $mysqli;
                                            // Consulta com JOIN para trazer info do usuário
                                            $query_usuarios = "
                                                SELECT 
                                                    t.*, 
                                                    u.mobile AS user_mobile, 
                                                    u.telefone AS user_telefone
                                                FROM transacoes t
                                                LEFT JOIN usuarios u ON t.usuario = u.id
                                                WHERE t.status = 'expirado'
                                                ORDER BY t.id DESC
                                            ";
                                            $result_usuarios = mysqli_query($mysqli, $query_usuarios);

                                            if ($result_usuarios && mysqli_num_rows($result_usuarios) > 0) {
                                                while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                                                    // Badge para exibir o status "Expirado"
                                                    $cargo_badge = ($usuario['status'] == 'expirado')
                                                        ? "<span class='badge bg-danger'>Expirado</span>"
                                                        : "<span class='badge bg-secondary'>Usuário</span>";
                                                    ?>
                                                    <tr>
                                                        <td><?= $usuario['id']; ?></td>

                                                        <!-- Coluna Usuário (mobile) + Ícone de WhatsApp -->
                                                        <td>
                                                            <?= $usuario['user_mobile']; ?>
                                                            <?php if (!empty($usuario['user_telefone'])): ?>
                                                                <a href="https://wa.me/55<?= $usuario['user_telefone']; ?>" 
                                                                   target="_blank"
                                                                   title="Enviar WhatsApp">
                                                                    <i class="lab la-whatsapp" 
                                                                       style="color:#25D366; margin-left: 5px;"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td><?= $usuario['transacao_id']; ?></td>
                                                        <td>R$ <?= number_format($usuario['valor'], 2, ',', '.'); ?></td>
                                                        <td><?= $usuario['data_hora']; ?></td>
                                                        <td>
                                                            <span><?= substr($usuario['code'], 0, 40); ?>...</span>
                                                            <button type="button" class="btn btn-primary btn-clipboard ms-2"
                                                                    data-clipboard-text="<?= $usuario['code']; ?>">
                                                                <i class="far fa-copy"></i>
                                                            </button>
                                                        </td>
                                                        <td><?= $cargo_badge; ?></td>
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
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-xxl-->

            <!--Start Rightbar-->
            <?php include 'partials/endbar.php'; ?>
            <!--end Rightbar-->
            <!--Start Footer-->
            <?php include 'partials/footer.php'; ?>
            <!--end footer-->
        </div><!-- end page-content -->
    </div><!-- end page-wrapper -->

    <!-- vendor js -->
    <?php include 'partials/vendorjs.php'; ?>
    <script src="assets/js/app.js"></script>
    <script src="assets/libs/clipboard/clipboard.min.js"></script>
    <script src="assets/js/pages/clipboard.init.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
