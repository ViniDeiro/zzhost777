<style>
  .startbar {
    background-color: #0e161e;
  }
</style>
<div class="startbar d-print-none">
  <div class=""><br>
    <a href="index.php" class="logo">
      <span>
        <center><img src="../uploads/<?= $dataconfig['logo'] ?>" alt="logo-small" class="logo-sm" width="50px"></center>
      </span>
    </a>
    <a href="online-agora" class="mb-2 d-block text-center">
      <div class="mt-2">
        <?php
        $query_jogadores_online = "SELECT COUNT(*) as total_online FROM usuarios_online WHERE ultima_acao >= (NOW() - INTERVAL 5 MINUTE)";
        $result_jogadores_online = mysqli_query($mysqli, $query_jogadores_online);
        if ($result_jogadores_online) {
          $row_jogadores_online = mysqli_fetch_assoc($result_jogadores_online);
          $total_jogadores_online = $row_jogadores_online['total_online'];
        } else {
          $total_jogadores_online = 0;
          error_log("Erro ao consultar jogadores online: " . mysqli_error($mysqli));
        }
        ?>
        <span class="badge bg-success" style="border-radius: 8px; margin:5px; padding:8px">
          <i class="fa fa-user" aria-hidden="true"></i> <?= htmlspecialchars($total_jogadores_online) ?>
        </span>
      </div>
    </a>
  </div>
  <div class="startbar-menu">
    <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
      <div class="d-flex align-items-start flex-column w-100">
        <ul class="navbar-nav mb-auto w-100">
          <li class="menu-label pt-0 mt-0">
            <span style="color: white;">RELATÓRIOS</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#sidebarDashboards" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
              <i class="iconoir-home-simple menu-icon"></i>
              <span>Dashboard</span>
            </a>
            <div class="collapse" id="sidebarDashboards">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="dashboard">Relatórios </a>
                </li>
              </ul>
            </div>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">FINANCEIRO</span>
          </li>
          <?php
          $query_depositos_processamento = "SELECT COUNT(*) as total_processamento FROM transacoes WHERE status = 'processamento'";
          $result_depositos_processamento = mysqli_query($mysqli, $query_depositos_processamento);
          $row_depositos_processamento = mysqli_fetch_assoc($result_depositos_processamento);
          $total_depositos_processamento = $row_depositos_processamento['total_processamento'];
          $query_depositos_aprovados = "SELECT COUNT(*) as total_aprovados FROM transacoes WHERE status = 'pago'";
          $result_depositos_aprovados = mysqli_query($mysqli, $query_depositos_aprovados);
          $row_depositos_aprovados = mysqli_fetch_assoc($result_depositos_aprovados);
          $total_depositos_aprovados = $row_depositos_aprovados['total_aprovados'];
          $query_depositos_recusados = "SELECT COUNT(*) as total_recusados FROM transacoes WHERE status = 'expirado'";
          $result_depositos_recusados = mysqli_query($mysqli, $query_depositos_recusados);
          $row_depositos_recusados = mysqli_fetch_assoc($result_depositos_recusados);
          $total_depositos_recusados = $row_depositos_recusados['total_recusados'];
          $total_depositos = $total_depositos_processamento + $total_depositos_aprovados + $total_depositos_recusados;
          ?>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#sidebarElements" role="button" aria-expanded="false" aria-controls="sidebarElements">
              <i class="iconoir-receive-dollars menu-icon"></i>
              <span>Depósitos</span><span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_depositos; ?></span>
            </a>
            <div class="collapse" id="sidebarElements">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="depositos_pagos">Aprovados <span class="badge rounded text-success bg-success-subtle ms-1"><?= $total_depositos_aprovados; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="depositos_pendentes">Pendentes <span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_depositos_processamento; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="depositos_expirados">Expirados <span class="badge rounded text-danger bg-danger-subtle ms-1"><?= $total_depositos_recusados; ?></span></a>
                </li>
              </ul>
            </div>
          </li>
          <?php
          $query_saques_pendentes = "SELECT COUNT(*) as total_pendentes FROM solicitacao_saques WHERE status = '0' AND tipo_saque = '0'";
          $result_saques_pendentes = mysqli_query($mysqli, $query_saques_pendentes);
          $row_saques_pendentes = mysqli_fetch_assoc($result_saques_pendentes);
          $total_saques_pendentes = $row_saques_pendentes['total_pendentes'];
          $query_saques_aprovados = "SELECT COUNT(*) as total_aprovados FROM solicitacao_saques WHERE status = '1' AND tipo_saque = '0'";
          $result_saques_aprovados = mysqli_query($mysqli, $query_saques_aprovados);
          $row_saques_aprovados = mysqli_fetch_assoc($result_saques_aprovados);
          $total_saques_aprovados = $row_saques_aprovados['total_aprovados'];
          $query_saques_recusados = "SELECT COUNT(*) as total_recusados FROM solicitacao_saques WHERE status = '2' AND tipo_saque = '0'";
          $result_saques_recusados = mysqli_query($mysqli, $query_saques_recusados);
          $row_saques_recusados = mysqli_fetch_assoc($result_saques_recusados);
          $total_saques_recusados = $row_saques_recusados['total_recusados'];
          $total_saques = $total_saques_pendentes + $total_saques_aprovados + $total_saques_recusados;
          ?>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#sidebarAdvancedUI" role="button" aria-expanded="false" aria-controls="sidebarAdvancedUI">
              <i class="iconoir-send-dollars menu-icon"></i>
              <span>Saques</span>
              <span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_saques; ?></span>
            </a>
            <div class="collapse" id="sidebarAdvancedUI">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="saques_aprovados">Aprovados <span class="badge rounded text-success bg-success-subtle ms-1"><?= $total_saques_aprovados; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="saques_pendentes">Pendentes <span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_saques_pendentes; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="saques_recusados">Recusados <span class="badge rounded text-danger bg-danger-subtle ms-1"><?= $total_saques_recusados; ?></span></a>
                </li>
              </ul>
            </div>
          </li>
          <?php
          $query_saques_afiliados_pendentes = "SELECT COUNT(*) as total_pendentes FROM solicitacao_saques WHERE status = '0' AND tipo_saque = '1'";
          $result_saques_afiliados_pendentes = mysqli_query($mysqli, $query_saques_afiliados_pendentes);
          $row_saques_afiliados_pendentes = mysqli_fetch_assoc($result_saques_afiliados_pendentes);
          $total_saques_afiliados_pendentes = $row_saques_afiliados_pendentes['total_pendentes'];
          $query_saques_afiliados_aprovados = "SELECT COUNT(*) as total_aprovados FROM solicitacao_saques WHERE status = '1' AND tipo_saque = '1'";
          $result_saques_afiliados_aprovados = mysqli_query($mysqli, $query_saques_afiliados_aprovados);
          $row_saques_afiliados_aprovados = mysqli_fetch_assoc($result_saques_afiliados_aprovados);
          $total_saques_afiliados_aprovados = $row_saques_afiliados_aprovados['total_aprovados'];
          $query_saques_afiliados_recusados = "SELECT COUNT(*) as total_recusados FROM solicitacao_saques WHERE status = '2' AND tipo_saque = '1'";
          $result_saques_afiliados_recusados = mysqli_query($mysqli, $query_saques_afiliados_recusados);
          $row_saques_afiliados_recusados = mysqli_fetch_assoc($result_saques_afiliados_recusados);
          $total_saques_afiliados_recusados = $row_saques_afiliados_recusados['total_recusados'];
          $total_saques_afiliados = $total_saques_afiliados_pendentes + $total_saques_afiliados_aprovados + $total_saques_afiliados_recusados;
          ?>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#sidebarIcons" role="button" aria-expanded="false" aria-controls="sidebarIcons">
              <i class="iconoir-send-dollars menu-icon"></i>
              <span>Saques Afiliados</span><span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_saques_afiliados; ?></span>
            </a>
            <div class="collapse" id="sidebarIcons">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="saques_afiliados_aprovados">Aprovados <span class="badge rounded text-success bg-success-subtle ms-1"><?= $total_saques_afiliados_aprovados; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="saques_afiliados_pendentes">Pendentes <span class="badge rounded text-warning bg-warning-subtle ms-1"><?= $total_saques_afiliados_pendentes; ?></span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="saques_afiliados_recusados">Recusados <span class="badge rounded text-danger bg-danger-subtle ms-1"><?= $total_saques_afiliados_recusados; ?></span></a>
                </li>
              </ul>
            </div>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">USUÁRIOS</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="usuarios" role="button" aria-expanded="false" aria-controls="sidebarForms">
              <i class="iconoir-community menu-icon"></i>
              <span>Usuários</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="afiliados" role="button" aria-expanded="false" aria-controls="sidebarForms2">
              <i class="iconoir-community menu-icon"></i>
              <span>Afiliados</span>
            </a>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">Jogos da Plataforma</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="jogos" role="button" aria-expanded="false" aria-controls="jogosapi">
              <i class="iconoir-spades menu-icon"></i>
              <span>Gerenciar Jogos</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="provedoresapi" role="button" aria-expanded="false" aria-controls="provedoresapi">
              <i class="iconoir-server menu-icon"></i>
              <span>Provedores</span>
            </a>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">CONFIGURAÇÕES GERAIS</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#sidebarMaps" role="button" aria-expanded="false" aria-controls="sidebarMaps">
              <i class="iconoir-html5 menu-icon"></i>
              <span>Plataforma</span>
            </a>
            <div class="collapse" id="sidebarMaps">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="configuracoes">Saques e Depósitos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gerenciamento-nomes">Nomes e Slide</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pixel">Config Pixel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="identidade-visual">Logotipo e Favicon</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cupons">Bônus de Depósito</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#afiliados" role="button" aria-expanded="false" aria-controls="afiliados">
              <i class="iconoir-media-image-folder menu-icon"></i>
              <span> Opções Afiliados</span>
            </a>
            <div class="collapse" id="afiliados">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="gerenciamento-afiliados">Configurações</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="baus">Gerenciar Baús</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#banners" role="button" aria-expanded="false" aria-controls="banners">
              <i class="iconoir-media-image-folder menu-icon"></i>
              <span>Banners</span>
            </a>
            <div class="collapse" id="banners">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="banners">Slide Banners</a>
                </li>
              </ul>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="promocoes">Promoções</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#popups" role="button" aria-expanded="false" aria-controls="popups">
              <i class="iconoir-message-alert menu-icon"></i>
              <span>Pop-ups</span>
            </a>
            <div class="collapse" id="popups">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="popups">Imagens Pop-up</a>
                </li>
              </ul>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="baixarpop">Gerenciar App</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="niveis" role="button" aria-expanded="false" aria-controls="vips">
              <i class="iconoir-trophy menu-icon"></i>
              <span>Níveis VIP</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#temas" role="button" aria-expanded="false" aria-controls="temas">
              <i class="iconoir-design-pencil menu-icon"></i>
              <span>Personalização</span><span class="badge rounded text-success bg-success-subtle ms-1">41</span>
            </a>
            <div class="collapse" id="temas">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="temas">Temas <span class="badge rounded text-success bg-success-subtle ms-1">29</span></a>
                </li>
              </ul>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="iconesfloat">Icones Float <span class="badge rounded text-success bg-success-subtle ms-1">3</span></a>
                </li>
              </ul>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="jackpot">Jackpot <span class="badge rounded text-success bg-success-subtle ms-1">4</span></a>
                </li>
              </ul>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="numeros-jackpot">Estilo de Números <span class="badge rounded text-success bg-success-subtle ms-1">5</span></a>
                </li>
              </ul>
            </div>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">HISTÓRICOS</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="historicosplay" aria-controls="historicosForms">
              <i class="iconoir-gamepad menu-icon"></i>
              <span>Histórico de Jogadas</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="logsbonus" role="button" aria-expanded="false" aria-controls="historicosForms2">
              <i class="iconoir-gift menu-icon"></i>
              <span>Histórico de Bônus</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="niveislogs" role="button" aria-expanded="false" aria-controls="historicosForms3">
              <i class="iconoir-trophy menu-icon"></i>
              <span>Usuários VIP</span>
            </a>
          </li>
          <div class="border-dashed-bottom pb-2"></div>
          <li class="menu-label mt-2">
            <small class="label-border">
              <div class="border_left hidden-xs"></div>
              <div class="border_right"></div>
            </small>
            <span style="color: white;">Integrações</span>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="gateway" role="button" aria-expanded="false" aria-controls="gateway">
              <i class="iconoir-fingerprint-lock-circle menu-icon"></i>
              <span>Gateway de Pagamentos</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="api" role="button" aria-expanded="false" aria-controls="chavesapi">
              <i class="iconoir-key-plus menu-icon"></i>
              <span>Chaves de API Jogos</span>
            </a>
          </li>
          <li class="nav-item" style="background-color: rgba(255, 255, 255, 0.04); border-radius: 8px; margin:2px;">
            <a class="nav-link" href="webhooks" role="button" aria-expanded="false" aria-controls="webhooks">
              <i class="iconoir-bell menu-icon"></i>
              <span>Notificações Telegram</span>
            </a>
          </li>
        </ul>
        <div class="update-msg text-center">
          <div class="d-flex justify-content-center align-items-center thumb-lg update-icon-box rounded-circle mx-auto">
            <i class="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>
          </div>
          <h5 class="mt-3">Precisa de ajuda?</h5>
          <p class="mb-3 text-muted">Contate-nos para esclarecer suas duvidas!</p>
          <a href="https://wa.me/553184915035" target="_blank" class="btn text-primary shadow-sm rounded-pill">Suporte</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="startbar-overlay d-print-none"></div>

<script>
  document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(toggler) {
    toggler.addEventListener('click', function() {
      var targetEl = document.querySelector(toggler.getAttribute('data-bs-target'));
      var bsCollapse = bootstrap.Collapse.getOrCreateInstance(targetEl);
      bsCollapse.toggle();
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
