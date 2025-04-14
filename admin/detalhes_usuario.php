<?php include 'partials/html.php' ?>

<head>
    <?php $title = "Configurações do Fiverscan e PGClone"; ?>
    <?php include 'partials/title-meta.php' ?>
    <?php include 'partials/head-css.php' ?>
    <?php include 'services/afiliadoController.php' ?>
</head>

<body>
    
    
    <!-- Top Bar Start -->
    <?php include 'partials/topbar.php' ?>
    <!-- Top Bar End -->
    <!-- leftbar-tab-menu -->
    <?php include 'partials/startbar.php' ?>
    <!-- end leftbar-tab-menu-->
    <!-- decodificar slug usuario -->
    <?php
    // Definir o badge com base no status do usuário
    function getStatusBadge($status)
    {
        switch ($status) {
            case 'pago':
                return "<span class='badge bg-success'>Pago</span>";
            case 'processamento':
                return "<span class='badge bg-warning'>Pendente</span>";
            case 'expirado':
                return "<span class='badge bg-danger'>Expirado</span>";
            default:
                return "<span class='badge bg-secondary'>Indefinido</span>";
        }
    }
    if (isset($_REQUEST['slug'])) {
        $id_user = decodeAll($_REQUEST['slug']);
        $qry = "SELECT * FROM usuarios WHERE id='" . intval($id_user) . "'";
        $res = mysqli_query($mysqli, $qry);
        $data = mysqli_fetch_assoc($res);
        $saldo_user = saldo_user($data['id']);
    }

    // Atualizar os dados do usuário
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
        $real_name = $_POST['real_name'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $statusaff = $_POST['statusaff'];
        $tipo_pagamento = $_POST['tipo_pagamento'];
        $invite = $_POST['invite'];
        $senha_saque = $_POST['senhaparasacar'];
        
        $pass = $password;
        
        if (strlen($password) <20) {
            $pass =  password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));
        }
        
        // Atualizar no banco de dados
        $update_query = "UPDATE usuarios SET mobile='$real_name', token='$token', password='$pass', statusaff='$statusaff', invite_code='$invite', senhaparasacar='$senha_saque', tipo_pagamento = '$tipo_pagamento' WHERE id='" . intval($id_user) . "'";
        $update_res = mysqli_query($mysqli, $update_query);

        if ($update_res) {
            echo "<script>window.addEventListener('DOMContentLoaded', function() { showToast('success', 'Dados do usuário atualizados com sucesso!'); });</script>";
        } else {
            echo "<script>window.addEventListener('DOMContentLoaded', function() { showToast('danger', 'Erro ao atualizar os dados do usuário.'); });</script>";
        }
    }

    if ($data['statusaff'] == 2 || $data['statusaff'] == 1) {
        $view_status = '<span class="label label-success">Afiliado</span>';
    } else {
        $view_status = '<span class="label label-warning">Usuário</span>';
    }
    ?>


    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">

                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                        <div class="d-flex align-items-center flex-row flex-wrap">
                                            <div class="">
                                                <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0 text-center">
                                                    <img src="/uploads/<?= $dataconfig['avatar'] ?>" alt="" height="120" class="rounded-circle">
                                                    <h5 class="fw-semibold fs-22 mb-1"><?= $data['real_name']; ?></h5>
                                                    <h5 class="fw-semibold fs-20 mb-1"><span class="badge bg-success"><?= $view_status; ?></span></h5>
                                                </div>
                                                <br>
                                                <!-- <h6 class="fw-semibold fs-15 mb-1">Nível:</h6> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <style>
                                        @media screen and (max-width: 600px) {
                                            .expfygaming {
                                                flex-wrap: wrap;
                                            }
                                        }
                                    </style>

                                    <div class="col-lg-5 ms-auto align-self-center">
                                        <div class="d-flex expfygaming justify-content-center">
                                            <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                                <h5 class="fw-semibold fs-22 mb-1">R$<?= Reais2(total_dep_pagos_id($data['id'])); ?></h5>
                                                <p class="text-muted mb-0 fw-medium">Total Depósitos</p>
                                            </div>
                                            <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                                <h5 class="fw-semibold fs-22 mb-1">R$<?= Reais2(total_saques_id($data['id'])); ?></h5>
                                                <p class="text-muted mb-0 fw-medium">Total Sacado</p>
                                            </div>
                                            <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
                                                <h5 class="fw-semibold fs-22 mb-1">R$<?= Reais2($saldo_user['saldo']); ?></h5>
                                                <p class="text-muted mb-0 fw-medium">Saldo Jogador</p>
                                            </div>
                                            <div class="border-dashed rounded border-theme-color p-2 me-2 flex-grow-1 flex-basis-0">
    <h5 class="fw-semibold fs-22 mb-1">R$<?= Reais2($saldo_user['saldo_afiliado']); ?></h5>
    <p class="text-muted mb-0 fw-medium">Saldo de Afiliado</p>
</div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-3 col-md-6 col-sm-12 align-self-center mt-3 mt-lg-0">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-sm-center">
                                            <?php if ($data['banido'] == 1): ?>
                                                <!-- Botão de Desbanir -->
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#desbanirUsuarioModal">
                                                    Desbanir Usuário
                                                </button>
                                            <?php else: ?>
                                                <!-- Botão de Banir -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#banirUsuarioModal">
                                                    Banir Usuário
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarSaldoModal">Editar Saldo</button>
                                        </div>
                                    </div>

                                    <!-- Modal de Confirmação -->
                                    <div class="modal fade" id="banirUsuarioModal" tabindex="-1" aria-labelledby="banirUsuarioLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="banirUsuarioLabel">Confirmar Banimento</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Você tem certeza que deseja banir este usuário?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-danger" id="confirmarBanimento">Sim, tenho certeza</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal de Confirmação de Desbanir -->
                                    <div class="modal fade" id="desbanirUsuarioModal" tabindex="-1" aria-labelledby="desbanirUsuarioLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="desbanirUsuarioLabel">Confirmar Desbanimento</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Você tem certeza que deseja desbanir este usuário?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-success" id="confirmarDesbanimento">Sim, tenho certeza</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal de Editar Saldo -->
                                    <div class="modal fade" id="editarSaldoModal" tabindex="-1" aria-labelledby="editarSaldoLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarSaldoLabel">Editar Saldo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="saldoAtual" class="form-label">Saldo Jogador</label>
                                                        <input type="text" class="form-control" id="saldoAtual" value="R$<?= Reais2($saldo_user['saldo']); ?>" disabled>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="adicionarSaldo" class="form-label">Adicionar Saldo</label>
                                                        <input type="number" class="form-control" id="adicionarSaldo" placeholder="Insira o valor para adicionar" step="0.01">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="removerSaldo" class="form-label">Remover Saldo</label>
                                                        <input type="number" class="form-control" id="removerSaldo" placeholder="Insira o valor para remover" step="0.01">
                                                    </div>

                                                    <div class="mt-3">
                                                        <h6>Saldo Final Estimado: <span id="saldoFinal">R$<?= Reais2($saldo_user['saldo']); ?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-primary" id="confirmarEdicaoSaldo">Salvar Alterações</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#afiliado" role="tab" aria-selected="true">Informações de afiliado</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#usersafiliados" role="tab" aria-selected="false">Indicados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#depositos" role="tab" aria-selected="false">Registros de depósitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#partidas" role="tab" aria-selected="false">Registros de partidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#saques" role="tab" aria-selected="false">Registros de retiradas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" data-bs-toggle="tab" href="#editar" role="tab" aria-selected="false">Editar usuário</a>
                    </li>
                    <?php if ($data['tipo_pagamento'] == 3): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" data-bs-toggle="tab" href="#novaAba" role="tab" aria-selected="false">Percentual</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Aba de edição do usuário -->
                    <div class="tab-pane p-3" id="editar" role="tabpanel">
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="real_name" class="form-label">Nome de usuario</label>
                                    <input type="text" class="form-control" name="real_name" id="real_name" value="<?= $data['mobile']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="token" class="form-label">Token</label>
                                    <input type="text" class="form-control" name="token" id="token" value="<?= $data['token']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control" name="password" id="password" value="<?= $data['password']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="invite" class="form-label">Código De Convite</label>
                                    <input type="invite" class="form-control" name="invite" id="invite" value="<?= $data['invite_code']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="senhaparasacar" class="form-label">Senha De Saque</label>
                                    <input type="senhaparasacar" class="form-control" name="senhaparasacar" id="senhaparasacar" placeholder="Senha Para Sacar" value="<?= $data['senhaparasacar']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="statusaff" class="form-label">Status de Afiliado</label>
                                    <select class="form-select" name="statusaff" id="statusaff">
                                        <option value="1" <?= $data['statusaff'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="0" <?= $data['statusaff'] == 0 ? 'selected' : ''; ?>>Inativo</option>
                                        <option value="2" <?= $data['statusaff'] == 2 ? 'selected' : ''; ?>>Bloqueado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipo_pagamento" class="form-label">Tipo De Pagamento Do Afiliado</label>
                                    <select class="form-select" name="tipo_pagamento" id="tipo_pagamento">
                                        <option value="3" <?= $data['tipo_pagamento'] == 3 ? 'selected' : ''; ?>>Percentual</option> 
                                        <option value="1" <?= $data['tipo_pagamento'] == 1 ? 'selected' : ''; ?>>Cpa</option>
                                        <option value="0" <?= $data['tipo_pagamento'] == 0 ? 'selected' : ''; ?>>Cpa + Rev</option>
                                        <option value="2" <?= $data['tipo_pagamento'] == 2 ? 'selected' : ''; ?>>Rev</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="update_user" class="btn btn-primary">Atualizar Usuário</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Aba Informações de afiliado -->
                    <div class="tab-pane active" id="afiliado" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Referências diretas</p>
                                                <h3 class="my-2 fs-24 fw-bold"><?= count_refer_direto($data['invite_code']); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-eye fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Numero De Depositantes</p>
                                                <h3 class="my-2 fs-24 fw-bold"><?= numero_total_dep($data['invite_code']); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-piggy-bank fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <!-- Mais cards de informações -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Total ganho: Cpa</p>
                                                <h3 class="my-2 fs-24 fw-bold">R$<?= Reais2(total_CPA_id($data['id'])); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-receive-dollars fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Total ganho: Rev</p>
                                                <h3 class="my-2 fs-24 fw-bold">R$<?= Reais2(total_REV_id($data['id'])); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-receive-dollars fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Depósitos dos indicados</p>
                                                <h3 class="my-2 fs-24 fw-bold">R$<?= Reais2(total_dep_afiliado($data['invite_code'])); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-send-dollars fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Saldo de afiliado</p>
                                                <h3 class="my-2 fs-24 fw-bold">R$<?= Reais2($saldo_user['saldo_afiliado']); ?></h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-dollar-circle fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        $afiliador = dados_afiliador($data['invitation_code']);
                                        ?>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 fw-semibold">Afiliação:</p>
                                                <h3 class="my-2 fs-24 fw-bold"><?= $afiliador ? $afiliador['mobile'] : 'Sem afiliação'; ?></h3>
                                                <?php if ($afiliador): ?>
                                                    <div class="d-flex gap-2 mt-2">
                                                        <a href="detalhes_usuario.php?slug=<?= encodeAll($afiliador['id']); ?>" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removerAfiliação(<?= $id_user; ?>)">
                                                            <i class="fas fa-user-slash"></i> Remover Afiliação
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                    <i class="iconoir-group fs-30 align-self-center text-muted"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                        </div>
                        <!--end row-->
                    </div>

                    <!-- Aba Indicados -->
                    <div class="tab-pane p-3" id="usersafiliados" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Depositou</th>
                                        <th>Data de Cadastro</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Supondo que o ID do usuário atual está disponível em $id_user
                                    $id_user = decodeAll($_REQUEST['slug']); // Captura o ID do usuário da requisição

                                    // Primeiro, pegue o código de convite do usuário atual
                                    $query_codigo_afiliado = "SELECT invite_code FROM usuarios WHERE id = '$id_user'";
                                    $result_codigo_afiliado = mysqli_query($mysqli, $query_codigo_afiliado);

                                    if ($result_codigo_afiliado && mysqli_num_rows($result_codigo_afiliado) > 0) {
                                        $usuario_atual = mysqli_fetch_assoc($result_codigo_afiliado);
                                        $meu_codigo = $usuario_atual['invite_code'];

                                        // Buscar usuários que se cadastraram usando esse código
                                        $query_usuarios_afiliado = "
                                            SELECT u.*, 
                                                (SELECT t.valor 
                                                 FROM transacoes t 
                                                 WHERE t.usuario = u.id AND t.status = 'pago' 
                                                 ORDER BY t.id ASC LIMIT 1) AS primeiro_deposito 
                                            FROM usuarios u 
                                            WHERE u.invitation_code = '$meu_codigo'
                                            ORDER BY u.id DESC
                                        ";

                                        $result_usuarios_afiliado = mysqli_query($mysqli, $query_usuarios_afiliado);

                                        if (!$result_usuarios_afiliado) {
                                            echo "<tr><td colspan='5' class='text-center'>Erro na consulta: " . mysqli_error($mysqli) . "</td></tr>";
                                        } else {
                                            if (mysqli_num_rows($result_usuarios_afiliado) > 0) {
                                                while ($usuario_afiliado = mysqli_fetch_assoc($result_usuarios_afiliado)) {
                                    ?>
                                                    <tr>
                                                        <td><?= $usuario_afiliado['id']; ?></td>
                                                        <td><?= $usuario_afiliado['mobile']; ?></td>
                                                        <td><?= $usuario_afiliado['primeiro_deposito'] ? $usuario_afiliado['primeiro_deposito'] : 'Nenhum depósito'; ?></td>
                                                        <td><?= $usuario_afiliado['data_cad']; ?></td>
                                                        <td>
                                                            <a href="detalhes_usuario.php?slug=<?= encodeAll($usuario_afiliado['id']); ?>" class="btn btn-primary btn-sm me-1">
                                                                <i class="fas fa-eye"></i> Ver
                                                            </a>
                                                            <button class="btn btn-danger btn-sm" onclick="excluirIndicado(<?= $usuario_afiliado['id']; ?>)">Excluir</button>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Nenhum usuário afiliado encontrado!</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Erro: Não foi possível encontrar o código de convite do usuário.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Aba Registros de partidas -->
                    <div class="tab-pane p-3" id="partidas" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Game</th>
                                        <th>Aposta</th>
                                        <th>Ganho</th>
                                        <th>Data/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_historico_play = "SELECT * FROM historico_play WHERE id_user = '" . intval($id_user) . "' ORDER BY id DESC";
                                    $result_historico_play = mysqli_query($mysqli, $query_historico_play);

                                    if ($result_historico_play && mysqli_num_rows($result_historico_play) > 0) {
                                        while ($historico_play = mysqli_fetch_assoc($result_historico_play)) {
                                            $status_historico_play = $historico_play['status'] == 1 ? "Aprovado" : "Em Análise";
                                    ?>
                                            <tr>
                                                <td><?= $historico_play['id']; ?></td>
                                                <td><?= $historico_play['nome_game']; ?></td>
                                                <td>R$ <?= number_format($historico_play['bet_money'], 2, ',', '.'); ?></td>
                                                <td>R$ <?= number_format($historico_play['win_money'], 2, ',', '.'); ?></td>
                                                <td><?= $historico_play['created_at']; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>Sem registros de partidas disponíveis!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Aba Registros de Depósitos -->
                    <div class="tab-pane p-3" id="depositos" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Transação ID</th>
                                        <th>Valor</th>
                                        <th>Data/Hora</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_depositos = "SELECT * FROM transacoes WHERE usuario = '" . intval($id_user) . "' ORDER BY id DESC";
                                    $result_depositos = mysqli_query($mysqli, $query_depositos);

                                    if ($result_depositos && mysqli_num_rows($result_depositos) > 0) {
                                        while ($deposito = mysqli_fetch_assoc($result_depositos)) {
                                            $cargo_badge = ($deposito['status'] == 'pago') ? "<span class='badge bg-success'>Pago</span>" : "<span class='badge bg-warning'>Pendente</span>";
                                    ?>
                                            <tr>
                                                <td><?= $deposito['id']; ?></td>
                                                <td><?= $deposito['transacao_id']; ?></td>
                                                <td>R$ <?= number_format($deposito['valor'], 2, ',', '.'); ?></td>
                                                <td><?= $deposito['data_hora']; ?></td>
                                                <td><?= getStatusBadge($deposito['status']); ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Sem depósitos disponíveis!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Aba Registros de Saques -->
                    <div class="tab-pane p-3" id="saques" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Valor</th>
                                        <th>Data/Hora</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_saques = "SELECT * FROM solicitacao_saques WHERE id_user = '" . intval($id_user) . "' ORDER BY id DESC";
                                    $result_saques = mysqli_query($mysqli, $query_saques);

                                    if ($result_saques && mysqli_num_rows($result_saques) > 0) {
                                        while ($saque = mysqli_fetch_assoc($result_saques)) {
                                            $status_saque = $saque['status'] == 1 ? "Aprovado" : "Em Análise";
                                    ?>
                                            <tr>
                                                <td><?= $saque['id']; ?></td>
                                                <td>R$ <?= number_format($saque['valor'], 2, ',', '.'); ?></td>
                                                <td><?= $saque['data_hora']; ?></td>
                                                <td><span class="badge bg-<?= $saque['status'] == 1 ? 'success' : 'warning' ?>"><?= $status_saque; ?></span></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>Sem registros de saques disponíveis!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                   <?php if ($data['tipo_pagamento'] == 3): ?>
    <div class="tab-pane p-3" id="novaAba" role="tabpanel">
        <!-- Nova Seção: Estatísticas do Afiliado -->
        <h4>Estatísticas do Afiliado</h4>
        <div class="row">
            <!-- Comissão Disponível -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Comissão Disponível</h6>
                        <p class="card-text">R$<?= number_format(getAvailableCommission($data['id']), 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <!-- Total Sacado -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Total Sacado</h6>
                        <p class="card-text">R$<?= number_format(getTotalSacado($data['id']), 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <!-- Indicações Diretas -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Indicações Diretas</h6>
                        <p class="card-text"><?= count_refer_direto($data['invite_code']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Depósitos (quantidade) -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Depósitos</h6>
                        <?php 
                            $queryQtdDepositos = "SELECT COUNT(*) AS qtd_depositos 
                                FROM transacoes t 
                                JOIN usuarios u ON t.usuario = u.id 
                                WHERE u.invitation_code = '".$data['invite_code']."'
                                  AND t.status = 'pago'
                                  AND t.tipo = 'deposito'";
                            $resultQtdDepositos = mysqli_query($mysqli, $queryQtdDepositos) or die("Erro na query de depósitos: " . mysqli_error($mysqli));
                            $rowQtdDepositos = mysqli_fetch_assoc($resultQtdDepositos);
                            $qtdDepositos = $rowQtdDepositos['qtd_depositos'] ?? 0;
                        ?>
                        <p class="card-text"><?= $qtdDepositos; ?></p>
                    </div>
                </div>
            </div>
            <!-- Valor Depositado -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Valor Depositado</h6>
                        <p class="card-text">R$<?= number_format(total_dep_afiliado($data['invite_code']), 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <!-- Desempenho -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Desempenho</h6>
                        <?php 
                            $totalIndicacoes = count_refer_direto($data['invite_code']);
                            $desempenho = ($totalIndicacoes > 0) ? ($qtdDepositos / $totalIndicacoes) * 100 : 0;
                        ?>
                        <p class="card-text"><?= number_format($desempenho, 1, ',', '.'); ?>%</p>
                    </div>
                </div>
            </div>
            <!-- Visitas Únicas -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Visitas Únicas</h6>
                        <p class="card-text"><?= getVisitorCount($data['id']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Primeiros Depósitos -->
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Primeiros Depósitos</h6>
                        <p class="card-text"><?= numero_total_dep($data['invite_code']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <!-- Seção existente: Configurações de Comissão e Saque -->
        <h4>Configurações de Comissão e Saque</h4>
        <form id="configForm">
            <div class="mb-3">
                <label for="comissao_percentual" class="form-label">Comissão Percentual (%)</label>
                <input type="number" class="form-control" id="comissao_percentual" name="comissao_percentual" min="0" max="100" step="0.1" value="<?= isset($data['comissao_percentual']) ? $data['comissao_percentual'] : 0; ?>">
            </div>
            <div class="mb-3">
                <label for="saque_minimo" class="form-label">Saque Mínimo (R$)</label>
                <input type="number" class="form-control" id="saque_minimo" name="saque_minimo" step="0.01" value="<?= isset($data['saque_minimo']) ? $data['saque_minimo'] : 0; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Saldo de Afiliado:</label>
                <p><strong>R$<?= Reais2($saldo_user['saldo_afiliado']); ?></strong></p>
                <button type="button" class="btn btn-secondary" id="btnConverterSaldo">Converter Saldo</button>
            </div>
            <button type="button" class="btn btn-primary" id="btnSalvarConfig">Salvar Configurações</button>
        </form>
        <hr>
<!-- Seção existente: Próximo Salário -->
<h4>Próximo Salário</h4>
<form id="proximoSalarioForm">
    <div class="mb-3">
        <label for="prox_salario_valor" class="form-label">Valor do Próximo Salário (R$)</label>
        <input type="number" class="form-control" id="prox_salario_valor" name="prox_salario_valor" step="0.01" value="<?= isset($data['prox_salario_valor']) ? $data['prox_salario_valor'] : 0; ?>">
    </div>
    <div class="mb-3">
        <label for="prox_salario" class="form-label">Data do Próximo Salário</label>
        <input type="date" class="form-control" id="prox_salario" name="prox_salario" value="<?= isset($data['prox_salario']) ? $data['prox_salario'] : ''; ?>">
    </div>
    <button type="button" class="btn btn-primary" id="btnSalvarProximoSalario">Salvar Próximo Salário</button>
    <!-- Novo Botão: Aprovar Salário Definido -->
    <button type="button" class="btn btn-success" id="btnAprovarSalario">Aprovar salário definido</button>
</form>
<?php endif; ?>

                </div>
                <!--end tab-content-->

                <!--end col-->
            </div>
            <!--end row-->

                </div><!-- container -->
                <!--Start Rightbar-->
                <?php include 'partials/endbar.php' ?>
                <!--end Rightbar-->
                <!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- Toast Container -->
        <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

        <!-- Javascript  -->
        <?php include 'partials/vendorjs.php' ?>
        <script src="assets/js/app.js"></script>

        <script>
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

                setTimeout(function() {
                    bootstrapToast.hide();
                    setTimeout(() => toast.remove(), 500);
                }, 3000);

                setTimeout(function() {
                    window.location.href = window.location.href.split("?")[0] + "?ykn=" +
                        encodeURIComponent(new URLSearchParams(window.location.search).get('ykn'));
                }, 3000);
            }
        </script>

        <script>
            function excluirIndicado(usuarioId) {
                fetch('fetch/excluir_indicado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ usuario_id: usuarioId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Usuário excluído com sucesso.');
                        // Opcional: Atualizar a tabela ou recarregar a página
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else {
                        showToast('danger', 'Erro ao excluir usuário: ' + data.message);
                    }
                })
                .catch((error) => {
                    showToast('danger', 'Erro ao excluir usuário: ' + error);
                });
            }
        </script>
        
        <script>
            function removerAfiliação(userId) {
                fetch('fetch/remover_afiliacao.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ user_id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        showToast('danger', data.message);
                    }
                })
                .catch(error => {
                    showToast('danger', 'Erro na solicitação.');
                });
            }
        </script>

        <script>
            document.getElementById('confirmarBanimento').addEventListener('click', function() {
                modificarUsuario(<?= $id_user; ?>, 'banir');
            });

            document.getElementById('confirmarDesbanimento').addEventListener('click', function() {
                modificarUsuario(<?= $id_user; ?>, 'desbanir');
            });

            function modificarUsuario(userId, action) {
                fetch('fetch/banir_usuario.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            action: action
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            showToast('danger', 'Erro: ' + data.message);
                        }
                    })
                    .catch(error => {
                        showToast('danger', 'Erro ao processar a solicitação.');
                    });
            }
        </script>

        <script>
            document.getElementById('adicionarSaldo').addEventListener('input', atualizarSaldoFinal);
            document.getElementById('removerSaldo').addEventListener('input', atualizarSaldoFinal);

            function atualizarSaldoFinal() {
                var saldoAtual = parseFloat(<?= $saldo_user['saldo']; ?>);
                var adicionarSaldo = parseFloat(document.getElementById('adicionarSaldo').value) || 0;
                var removerSaldo = parseFloat(document.getElementById('removerSaldo').value) || 0;

                var saldoFinal = saldoAtual + adicionarSaldo - removerSaldo;

                document.getElementById('saldoFinal').textContent = 'R$' + saldoFinal.toFixed(2).replace('.', ',');
            }

            document.getElementById('confirmarEdicaoSaldo').addEventListener('click', function() {
                var adicionarSaldo = parseFloat(document.getElementById('adicionarSaldo').value) || 0;
                var removerSaldo = parseFloat(document.getElementById('removerSaldo').value) || 0;

                editarSaldoUsuario(<?= $id_user; ?>, adicionarSaldo, removerSaldo);
            });

            function editarSaldoUsuario(userId, adicionar, remover) {
                fetch('fetch/editar_saldo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            adicionar: adicionar,
                            remover: remover
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', 'Saldo atualizado com sucesso!');
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        } else {
                            showToast('danger', 'Erro: ' + data.message);
                        }
                    })
                    .catch(error => {
                        showToast('danger', 'Erro ao atualizar o saldo.');
                    });
            }
        </script>
        
        <script>
    // Salvar Configurações de Comissão e Saque
    document.getElementById('btnSalvarConfig').addEventListener('click', function(){
        let comissao = document.getElementById('comissao_percentual').value;
        let saqueMinimo = document.getElementById('saque_minimo').value;
        fetch('fetch/update_config.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                user_id: <?= $id_user; ?>,
                comissao_percentual: comissao,
                saque_minimo: saqueMinimo
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                showToast('success', 'Configurações atualizadas com sucesso!');
            } else {
                showToast('danger', 'Erro: ' + data.message);
            }
        })
        .catch(error => {
            showToast('danger', 'Erro ao atualizar as configurações.');
        });
    });

    // Converter Saldo de Afiliado para Saldo Principal
    document.getElementById('btnConverterSaldo').addEventListener('click', function(){
        fetch('fetch/converter_saldo.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ user_id: <?= $id_user; ?> })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                showToast('success', data.message);
                // Opcional: recarregar a página para atualizar os valores exibidos
                setTimeout(() => location.reload(), 2000);
            } else {
                showToast('danger', 'Erro: ' + data.message);
            }
        })
        .catch(error => {
            showToast('danger', 'Erro ao converter saldo.');
        });
    });

    // Salvar Próximo Salário
    document.getElementById('btnSalvarProximoSalario').addEventListener('click', function(){
        let valor = document.getElementById('prox_salario_valor').value;
        let dataSalario = document.getElementById('prox_salario').value;
        fetch('fetch/update_proximo_salario.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                user_id: <?= $id_user; ?>,
                prox_salario_valor: valor,
                prox_salario: dataSalario
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                showToast('success', 'Próximo salário atualizado com sucesso!');
            } else {
                showToast('danger', 'Erro: ' + data.message);
            }
        })
        .catch(error => {
            showToast('danger', 'Erro ao atualizar o próximo salário.');
        });
    });
</script>
        
        <script>
            
            document.getElementById('btnAprovarSalario').addEventListener('click', function(){
    let valor = document.getElementById('prox_salario_valor').value;
    let dataSalario = document.getElementById('prox_salario').value;
    fetch('fetch/aprovar_salario.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            user_id: <?= $id_user; ?>,
            prox_salario_valor: valor,
            prox_salario: dataSalario
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            showToast('success', 'Salário aprovado com sucesso!');
            // Opcional: recarregar a página ou atualizar algum valor na interface
            setTimeout(() => location.reload(), 3000);
        } else {
            showToast('danger', 'Erro: ' + data.message);
        }
    })
    .catch(error => {
        showToast('danger', 'Erro ao aprovar o salário.');
    });
});

            
        </script>
        
</body>

</html>
