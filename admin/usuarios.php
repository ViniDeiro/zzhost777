<?php include 'partials/html.php' ?>

<?php
include_once "validar_2fa.php";
?>

<head>
    <?php $title = "expfygaming"; ?>
    <?php include 'partials/title-meta.php' ?>
    <?php include 'partials/head-css.php' ?>
    <style>
        /* Estilo para o controle de RTP individual */
        .rtp-individual {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .rtp-individual label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .rtp-individual input[type="range"] {
            width: 100px;
        }
        /* Estilo para o switch de Modo Demo */
        .modo-demo-switch {
            width: 40px;
            height: 20px;
        }
        /* Estilo para o ícone de informação no cabeçalho */
        .info-icon {
            margin-left: 5px;
            cursor: pointer;
        }
    </style>
</head>

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

    $status_filter = '';
    if (isset($_GET['status']) && $_GET['status'] !== '') {
        $status_filter = (int) $_GET['status'];
    }

    // Configuração da paginação
    $limit = 50;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Consulta para contar o total de usuários
    $query_total_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios WHERE 1=1";
    if (!empty($search_query)) {
        $query_total_usuarios .= " AND (id LIKE '%$search_query%' OR mobile LIKE '%$search_query%')";
    }
    if ($status_filter !== '') {
        $query_total_usuarios .= " AND statusaff = $status_filter";
    }
    $result_total_usuarios = mysqli_query($mysqli, $query_total_usuarios);
    $total_usuarios = mysqli_fetch_assoc($result_total_usuarios)['total_usuarios'];

    // Cálculo do total de páginas
    $total_pages = ceil($total_usuarios / $limit);

    // Consulta para exibir os usuários com paginação e filtro
    $query_usuarios = "SELECT * FROM usuarios WHERE 1=1";
    if (!empty($search_query)) {
        $query_usuarios .= " AND (id LIKE '%$search_query%' OR mobile LIKE '%$search_query%')";
    }
    if ($status_filter !== '') {
        if ($status_filter == 2) {
            $query_usuarios .= " AND banido = 1";
        } else {
            $query_usuarios .= " AND statusaff = $status_filter";
        }
    }
    $query_usuarios .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $result_usuarios = mysqli_query($mysqli, $query_usuarios);
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
                                        <h4 class="card-title">Todos Usuários (<?= $total_usuarios; ?> no total)</h4>
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
                                                placeholder="Buscar por ID ou Nome do Usuário"
                                                value="<?= htmlspecialchars($search_query) ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <select name="status" class="form-select">
                                                <option value="">Filtrar por Status</option>
                                                <option value="2" <?= (isset($_GET['status']) && $_GET['status'] == '2') ? 'selected' : ''; ?>>Banido</option>
                                                <option value="1" <?= (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : ''; ?>>Afiliado</option>
                                                <option value="0" <?= (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : ''; ?>>Usuário</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="submit" class="btn btn-success mt-2 mb-2">Filtrar</button>
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
                                                <!-- Cabeçalho modificado para Modo Demo com tooltip -->
                                                <th>
                                                    Modo Demo
                                                    <i class="fa fa-info-circle text-info info-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Para ativar o modo demo, é necessário o usuário ter feito no mínimo 1 aposta via iGameWin"></i>
                                                </th>
                                                <th>RTP Individual</th>
                                                <th class="text-end">Detalhes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result_usuarios && mysqli_num_rows($result_usuarios) > 0) {
                                                while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                                                    $cargo_badge = ($usuario['statusaff'] == '1') ? "<span class='badge bg-danger'>Afiliado</span>" : "<span class='badge bg-secondary'>Usuário</span>";
                                                    
                                                    $query_sacado = "SELECT SUM(valor) AS total_sacado FROM solicitacao_saques WHERE id_user = {$usuario['id']} AND status = 1";
                                                    $result_sacado = mysqli_query($mysqli, $query_sacado);
                                                    $sacado = ($result_sacado && mysqli_num_rows($result_sacado) > 0) ? mysqli_fetch_assoc($result_sacado)['total_sacado'] : 0;

                                                    $query_depositado = "SELECT SUM(valor) AS total_depositado FROM transacoes WHERE usuario = {$usuario['id']} AND status = 'pago'";
                                                    $result_depositado = mysqli_query($mysqli, $query_depositado);
                                                    $depositado = ($result_depositado && mysqli_num_rows($result_depositado) > 0) ? mysqli_fetch_assoc($result_depositado)['total_depositado'] : 0;
                                                    ?>
                                                    <tr>
                                                        <td><?= $usuario['id']; ?></td>
                                                        <td>
                                                            <?= $usuario['mobile']; ?>
                                                            <?php if (!empty($usuario['telefone'])): ?>
                                                                <a href="https://wa.me/55<?= $usuario['telefone']; ?>" target="_blank" title="Enviar WhatsApp">
                                                                    <i class="lab la-whatsapp" style="color:#25D366; margin-left: 5px;"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>R$ <?= number_format((float)$usuario['saldo'], 2, ',', '.'); ?></td>
                                                        <td>R$ <?= number_format((float)$depositado, 2, ',', '.'); ?></td>
                                                        <td>R$ <?= number_format((float)$sacado, 2, ',', '.'); ?></td>
                                                        <!-- Controle de Modo Demo -->
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input modo-demo-switch" type="checkbox" id="modoDemo_<?= $usuario['id']; ?>" data-mobile="<?= $usuario['mobile']; ?>" <?= ($usuario['modo_demo'] == 1 ? 'checked' : ''); ?>>
                                                            </div>
                                                        </td>
                                                        <!-- Controle de RTP individual -->
                                                        <td>
                                                            <div class="rtp-individual">
                                                                <label for="rtpSlider_<?= $usuario['id']; ?>">RTP: <span id="rtpValueDisplay_<?= $usuario['id']; ?>"><?= isset($usuario['rtp']) ? $usuario['rtp'] : 50; ?>%</span></label>
                                                                <input type="range" id="rtpSlider_<?= $usuario['id']; ?>" class="rtp-slider" data-mobile="<?= $usuario['mobile']; ?>" min="10" max="90" step="5" value="<?= isset($usuario['rtp']) ? $usuario['rtp'] : 50; ?>">
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown d-inline-block">
                                                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                                    <i class="las la-ellipsis-v fs-20 text-muted"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item text-success" href="<?= $painel_adm_ver_usuarios . encodeAll($usuario['id']); ?>">
                                                                        <i class="las la-info-circle"></i> Detalhes
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>Sem dados disponíveis!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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

                        <!-- Resumo Financeiro -->
                        <div class="row mt-4">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Depositado</h5>
                                        <p class="text-muted mb-0">R$ <?= number_format(total_dep_pagos_usuarios(), 2, ',', '.'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Sacado</h5>
                                        <p class="text-muted mb-0">R$ <?= number_format(total_saques_usuarios(), 2, ',', '.'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Saldo Médio</h5>
                                        <p class="text-muted mb-0">R$ <?= number_format(media_saldo_usuarios(), 2, ',', '.'); ?></p>
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
            <!--end Footer-->
        </div><!-- end page content -->
    </div><!-- end page-wrapper -->

    <!-- Javascript  -->
    <?php include 'partials/vendorjs.php' ?>
    <script src="assets/js/app.js"></script>
    <script>
        // Inicialização dos tooltips do Bootstrap
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Função para exibir toast
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

        // Função para atualizar o RTP individual via AJAX
        function updateRtpIndividual(mobile, rtpValue) {
            fetch('partials/updateRtpIndividual.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ mobile: mobile, rtp: rtpValue })
            })
            .then(response => response.json())
            .then(json => {
                if (json.success) {
                    showToast('success', 'RTP individual atualizado com sucesso!');
                } else {
                    showToast('danger', 'Erro ao atualizar RTP: ' + json.message);
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar o banco de dados:', error);
                showToast('danger', 'Erro ao atualizar o banco de dados.');
            });
        }

        // Função para atualizar o Modo Demo via AJAX
        function updateModoDemo(mobile, modoDemoValue) {
            fetch('partials/updateModoDemo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ mobile: mobile, modo_demo: modoDemoValue })
            })
            .then(response => response.json())
            .then(json => {
                if (json.success) {
                    showToast('success', 'Modo Demo atualizado com sucesso!');
                } else {
                    showToast('danger', 'Erro ao atualizar Modo Demo: ' + json.message);
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar o banco de dados:', error);
                showToast('danger', 'Erro ao atualizar o banco de dados.');
            });
        }

        // Para cada slider de RTP individual, adiciona o evento de alteração
        document.querySelectorAll('.rtp-slider').forEach(function(slider) {
            slider.addEventListener('input', function() {
                var userId = this.id.replace('rtpSlider_', '');
                var rtpValue = parseInt(this.value);
                document.getElementById('rtpValueDisplay_' + userId).textContent = rtpValue + '%';
            });
            slider.addEventListener('change', function() {
                var userId = this.id.replace('rtpSlider_', '');
                var rtpValue = parseInt(this.value);
                var mobile = this.getAttribute('data-mobile');
                updateRtpIndividual(mobile, rtpValue);
            });
        });

        // Para cada switch de Modo Demo, adiciona o evento de alteração
        document.querySelectorAll('.modo-demo-switch').forEach(function(switchElem) {
            switchElem.addEventListener('change', function() {
                var mobile = this.getAttribute('data-mobile');
                var modoDemoValue = this.checked ? 1 : 0;
                updateModoDemo(mobile, modoDemoValue);
            });
        });
    </script>
    <div id="toastPlacement" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>
</body>

</html>

<?php
// Funções de totalização e média para o resumo financeiro
function total_dep_pagos_usuarios() {
    global $mysqli;
    $qry = "SELECT SUM(valor) as total_soma FROM transacoes WHERE status = 'pago' AND tipo = 'deposito'";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total_soma'] ?? 0;
}

function total_saques_usuarios() {
    global $mysqli;
    $qry = "SELECT SUM(valor) as total_soma FROM solicitacao_saques WHERE status = 1";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['total_soma'] ?? 0;
}

function media_saldo_usuarios() {
    global $mysqli;
    $qry = "SELECT AVG(saldo) as media_saldo FROM usuarios";
    $result = mysqli_query($mysqli, $qry);
    return mysqli_fetch_assoc($result)['media_saldo'] ?? 0;
}
?>
