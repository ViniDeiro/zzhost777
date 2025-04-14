<?php include 'partials/html.php' ?>

<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
include_once "services/database.php";
include_once "services/funcao.php";
include_once "services/afiliadoController.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "services/CSRF_Protect.php";
$csrf = new CSRF_Protect();

checa_login_adm();

if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}

if (!isset($_SESSION['2fa_verified']) || $_SESSION['2fa_verified'] !== true) {
    echo "<script>setTimeout(function() { 
        var modal = new bootstrap.Modal(document.getElementById('modal2FA'));
        modal.show();
    }, 500);</script>";
}

/**
 * Função para obter o saldo da iGameWin a partir das credenciais armazenadas no banco.
 */
function get_api_balance_igamewin() {
    global $mysqli;
    // Consulta para recuperar as credenciais da iGameWin
    $qry = "SELECT url, agent_code, agent_token FROM igamewin WHERE ativo = 1 LIMIT 1";
    $result = $mysqli->query($qry);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        error_log("Credenciais da iGameWin não encontradas ou inativas.");
        return 0;
    }
    
    $url = $row['url'];
    $agent_code = $row['agent_code'];
    $agent_token = $row['agent_token'];

    // Monta o payload da requisição
    $payload = [
        "method"      => "money_info",
        "agent_code"  => $agent_code,
        "agent_token" => $agent_token
    ];
    
    $jsonData = json_encode($payload);

    // Inicializa e configura o cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        error_log("Erro no cURL: " . curl_error($ch));
        curl_close($ch);
        return 0;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    // Ajusta para retornar o saldo contido em agent.balance
    return isset($result['agent']['balance']) ? $result['agent']['balance'] : 0;
}

// Recupera o saldo da iGameWin
$api_balance = get_api_balance_igamewin();

// Outras funções e chamadas para estatísticas
$depositos_dias = depositos_por_dia();
$saques_dias = saques_por_dia();
$data = qtd_usuarios();
$labels_depositos = json_encode(array_column($depositos_dias, 'dia'));
$dados_depositos = json_encode(array_column($depositos_dias, 'total'));
$labels_saques = json_encode(array_column($saques_dias, 'dia'));
$dados_saques = json_encode(array_column($saques_dias, 'total'));
?>

<head>
    <?php $title = "expfygaming"; include 'partials/title-meta.php' ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <?php include 'partials/head-css.php' ?>
</head>

<body>

    <?php include 'partials/topbar.php' ?>
    <?php include 'partials/startbar.php' ?>

    <!-- Modal 2FA -->
    <div class="modal fade" id="modal2FA" tabindex="-1" aria-labelledby="modal2FALabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2FALabel">Autenticação de 2 Fatores</h5>
                </div>
                <div class="modal-body">
                    <p>Por favor, insira o código de autenticação 2FA para continuar.</p>
                    <input type="text" id="token2fa" class="form-control" placeholder="Token 2FA" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit-2fa">Validar Token</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('btn-submit-2fa').addEventListener('click', function() {
        var token2fa = document.getElementById('token2fa').value.trim();

        if (token2fa === '') {
            alert('Por favor, insira o token 2FA!');
            return;
        }

        fetch('validar_2fa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'token=' + encodeURIComponent(token2fa)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.php';
                } else {
                    alert('Token inválido. Tente novamente!');
                }
            });
    });
    </script>

    <!-- Removida a classe justify-content-center para alinhar os cards à esquerda -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <!-- Bloco de Cadastros -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Cadastros</h5>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Total cadastros</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? qtd_usuarios() : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-group h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Depositantes totais: <span class="text-success"><?= $_SESSION['2fa_verified'] == true ? qtd_usuarios_depositantes() : "Token não informado." ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Cadastros hoje</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? qtd_usuarios_diarios() : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Depositantes diários: <span class="text-success"><?= $_SESSION['2fa_verified'] == true ? qtd_usuarios_depositantes_diarios() : "Token não informado." ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Cadastros 90D</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? qtd_usuarios_90d() : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-user-plus h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Depositantes 90 dias: <span class="text-success"><?= $_SESSION['2fa_verified'] == true ? qtd_primeiro_deposito_usuarios_90d() : "Token não informado." ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Financeiro -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-database-monitor h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Financeiro</h5>
                    </div>
                    
                    
                    <!-- Novo Bloco: Saldo na iGameWin -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saldo API Jogos</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= "R$ " . Reais2($api_balance); ?></h3>
                                        
                                        
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-wallet h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div><p class="mb-0 text-truncate text-muted mt-3">
                                    Saldo atual na iGameWin</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saldo Afiliados</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= "R$ " . Reais2(getTotalSaldoAfiliados()); ?></h3>
                                        
                                        
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-wallet h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div><p class="mb-0 text-truncate text-muted mt-3">
                                    Saldo disponível para saque</span>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Total de Spins</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? total_jogadas() : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-piggy-bank h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $jogo_popular = jogo_mais_jogado();
                                    $jogo_color_class = ($jogo_popular === 'Nenhum jogo encontrado') ? 'text-danger' : 'text-success';
                                ?>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Jogo popular: <span class="<?= $_SESSION['2fa_verified'] == true ? $jogo_color_class : "Token não informado." ?>"><?= $_SESSION['2fa_verified'] == true ? $jogo_popular : "Token não informado." ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Bloco de Lucro -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Lucro</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(saldo_cassino()) : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-up h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $percentual_lucro = percentual_lucro();
                                    $color_class = '';
                                    if ($percentual_lucro > 0) {
                                        $color_class = 'text-success';
                                    } elseif ($percentual_lucro < 0) {
                                        $color_class = 'text-danger';
                                    } else {
                                        $color_class = 'text-warning';
                                    }
                                ?>
                                <p class="mb-0 text-truncate text-muted mt-3">
                                    Percentual de Lucro: <span class="<?= $color_class ?>"><?= $_SESSION['2fa_verified'] == true ? $percentual_lucro . " %" : "Token não informado." ?></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Depósitos Total -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Depósitos total</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(depositos_total()) : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-up h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">Depósitos pendentes: <span class="text-warning"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(depositos_pendentes()) : "Token não informado." ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Depósitos Diários -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Depósitos Diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(depositos_diarios_pagos()) : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-hand-cash h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">Depósitos pendentes <strong>(hoje)</strong>: <span class="text-warning"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(depositos_diarios()) : "Token não informado." ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Saques Total -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saques total</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(saques_total()) : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-graph-down h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">Saques pagos: <span class="text-danger"><?= $_SESSION['2fa_verified'] == true ? count_saques_total() : "Token não informado." ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Saques Diários -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Saques Diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(saques_diarios_pagos()) : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-hand-cash h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 text-truncate text-muted mt-3">Saques pendentes <strong>(hoje)</strong>: <span class="text-warning"><?= $_SESSION['2fa_verified'] == true ? "R$ ". Reais2(saques_diarios_pagos()) : "Token não informado." ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloco de Estatísticas -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle">
                            <i class="iconoir-database-monitor h1 align-self-center mb-0 text-secondary"></i>
                        </div>
                        <h5 class="mb-0 ms-1">Estatísticas</h5>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos total</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? visitas_count('total') : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos diários</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? visitas_count('diario') : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                                    <div class="col-9">
                                        <p class="text-dark mb-0 fw-semibold fs-14">Acessos 90D</p>
                                        <h3 class="mt-2 mb-0 fw-bold"><?= $_SESSION['2fa_verified'] == true ? visitas_count('90d') : "Token não informado." ?></h3>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                            <i class="iconoir-server-connection h1 align-self-center mb-0 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Gráficos de Saques e Depósitos -->
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

                <!-- Últimos Saques Aprovados e Depósitos Pagos -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-h-100">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Saques Aprovados</h4>
                                        <p class="fs-11 fst-bold text-muted">Últimos 5 Saques Aprovados.<a href="#!"
                                                class="link-danger ms-1"><i class="align-middle iconoir-refresh"></i></a></p>
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
                                            checa_login_adm();

                                            global $mysqli;
                                            $pagina = 1; // Página atual
                                            $qnt_result_pg = 5; // Quantidade de resultados por página
                                            $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

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
                                                class="link-danger ms-1"><i class="align-middle iconoir-refresh"></i></a></p>
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
                                            $result_visitas = "SELECT * FROM transacoes WHERE status = 'pago' ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";
                                            $resultado_visitas = mysqli_query($mysqli, $result_visitas);

                                            if ($resultado_visitas && mysqli_num_rows($resultado_visitas) > 0) {
                                                while ($visit = mysqli_fetch_assoc($resultado_visitas)) {
                                                    ?>
                                            <tr>
                                                <td><?= $visit['id']; ?></td>
                                                <td><?= $visit['usuario']; ?></td>
                                                <td><?= $visit['data_hora']; ?></td>
                                                <td><?= $visit['valor']; ?></td>
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

            </div>

            <?php include 'partials/endbar.php' ?>
            <?php include 'partials/footer.php' ?>
        </div>
    </div>
    <?php include 'partials/vendorjs.php' ?>

    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/data/stock-prices.js"></script>
    <script src="assets/libs/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world.js"></script>
    <script src="assets/js/pages/index.init.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
    var labelsDepositos = <?= $labels_depositos; ?>;
    var depositosData = <?= $dados_depositos; ?>;

    var labelsSaques = <?= $labels_saques; ?>;
    var saquesData = <?= $dados_saques; ?>;

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
            text: 'Depósitos Diários',
            align: 'left'
        }
    };

    var chartDepositos = new ApexCharts(document.querySelector("#chart-depositos"), optionsDepositos);
    chartDepositos.render();

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
            text: 'Saques Diários',
            align: 'left'
        }
    };

    var chartSaques = new ApexCharts(document.querySelector("#chart-saques"), optionsSaques);
    chartSaques.render();
    </script>

</body>

</html>
