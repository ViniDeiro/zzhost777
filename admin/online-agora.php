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
#======================================#
# Expulsa usuário não autenticado como administrador
checa_login_adm();
#======================================#

// Expulsa usuário bloqueado
if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}
?>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php
    $title = "Painel Administrativo - Jogadores Online";
    include 'partials/title-meta.php';
    ?>

    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php'; ?>

    <!-- Estilo para efeito pulsante -->
    <style>
        @keyframes pulsar {
            0% {
                color: #fff;
            }
            50% {
                color: #ccc;
            }
            100% {
                color: #fff;
            }
        }

        #atualizando {
            font-size: 14px;
            color: #ccc;
            animation: pulsar 2s infinite;
        }
    </style>
</head>

<body>

    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php'; ?>
    <!-- Top Bar End -->

    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php'; ?>
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <!-- espaço do conteúdo -->
                            <div class="card-header">
                                <h4 class="card-title">Jogadores Online</h4>
                                <p id="atualizando">Atualizando automaticamente</p>
                            </div>
                            <div class="card-body">
                                <!-- Exibição do Total de Jogadores Online -->
                                <div class="mb-3">
                                    <h5>Total de Jogadores Online: <span id="totalJogadoresOnline">0</span></h5>
                                </div>

                                <!-- Tabela para Exibir os Jogadores Online -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="usuariosOnlineTable">
                                        <thead>
                                            <tr>
                                                <th>IP</th>
                                                <th>País</th>
                                                <th>Cidade</th>
                                                <th>Estado</th>
                                                <th>Referência</th>
                                                <th>Sistema Operacional / Navegador</th>
                                                <th>Página Atual</th>
                                                <th>Última Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8" class="text-center">Carregando dados...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- fim espaço do conteúdo -->
                        </div>
                    </div>
                </div><!-- end row -->
            </div><!-- container -->
        </div><!-- page content -->
    </div><!-- page-wrapper -->

    <!-- Javascript -->
    <?php include 'partials/vendorjs.php'; ?>
    <script src="assets/js/app.js"></script>

    <!-- Atualização em Tempo Real via AJAX -->
    <script>
        function atualizarUsuarios() {
            $.ajax({
                url: 'fetch_online_users.php', // Verifique o caminho correto do arquivo
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tbody = $('#usuariosOnlineTable tbody');
                    tbody.empty();

                    if (Array.isArray(data) && data.length > 0) {
                        $('#totalJogadoresOnline').text(data.length);

                        data.forEach(function(usuario) {
                            var linha = `
                                <tr>
                                    <td>${usuario.ip_visita || 'N/A'}</td>
                                    <td>${usuario.pais || 'N/A'}</td>
                                    <td>${usuario.cidade || 'N/A'}</td>
                                    <td>${usuario.estado || 'N/A'}</td>
                                    <td>${usuario.refer_visita || 'N/A'}</td>
                                    <td>${usuario.nav_os || 'N/A'}</td>
                                    <td>${usuario.pagina_atual || 'N/A'}</td>
                                    <td>${usuario.ultima_acao || 'N/A'}</td>
                                </tr>
                            `;
                            tbody.append(linha);
                        });
                    } else {
                        $('#totalJogadoresOnline').text('0');
                        tbody.append('<tr><td colspan="8" class="text-center">Nenhum jogador online no momento.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar jogadores online:', error);

                    var tbody = $('#usuariosOnlineTable tbody');
                    tbody.empty();
                    tbody.append('<tr><td colspan="8" class="text-center text-danger">Erro ao carregar os dados.</td></tr>');
                }
            });
        }

        $(document).ready(function() {
            // Chamada inicial para preencher a tabela e o total
            atualizarUsuarios();

            // Atualizar a tabela e o total a cada 10 segundos
            setInterval(atualizarUsuarios, 10000);
        });
    </script>

</body>
</html>
