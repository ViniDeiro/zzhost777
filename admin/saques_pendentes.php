<?php include 'partials/html.php'; ?>

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
                                    <div class="col" style="display: flex; align-items: center;">
                                        <div class="tag" style="background: yellow !important;"></div>
                                        <h4 class="card-title">Saques Pendentes</h4>
                                    </div><!--end col-->
                                </div> <!--end row-->
                            </div><!--end card-header-->
                            
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Id</th>
                                                <th>Usuário</th> <!-- Nova coluna para exibir o "mobile" e WhatsApp -->
                                                <th>Transação ID</th>
                                                <th>Valor</th>
                                                <th>Data/Hora</th>
                                                <th>Chave Pix</th>
                                                <th>Status</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            global $mysqli;

                                            // Consulta dos saques pendentes (status 0 e tipo_saque 0) com JOIN em usuários
                                            $query_usuarios = "
                                                SELECT
                                                    s.*,
                                                    u.mobile AS user_mobile,
                                                    u.telefone AS user_telefone
                                                FROM solicitacao_saques s
                                                LEFT JOIN usuarios u ON s.id_user = u.id
                                                WHERE s.status = '0'
                                                  AND s.tipo_saque = '0'
                                                ORDER BY s.id DESC
                                            ";
                                            $result_usuarios = mysqli_query($mysqli, $query_usuarios);

                                            if ($result_usuarios && mysqli_num_rows($result_usuarios) > 0) {
                                                while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
                                                    // Badge para o status
                                                    $cargo_badge = ($usuario['status'] == '0')
                                                        ? "<span class='badge bg-danger'>Em Análise</span>"
                                                        : "<span class='badge bg-secondary'>Usuário</span>";

                                                    // Função do seu sistema que retorna a chave Pix
                                                    $chaveatt = localizarchavepix($usuario['tipo']);
                                                    ?>
                                                    <tr>
                                                        <!-- Mostrando o ID do registro de saque (s.id) -->
                                                        <td><?= $usuario['id']; ?></td>

                                                        <!-- Nova coluna exibindo nome/telefone do usuário + ícone WhatsApp -->
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
                                                        <td><?= $usuario['data_cad']; ?> : <?= $usuario['data_hora']; ?></td>
                                                        <td>
                                                            <span><?= $chaveatt; ?></span>
                                                            <button type="button" class="btn btn-primary btn-clipboard ms-2"
                                                                    data-clipboard-text="<?= $chaveatt; ?>">
                                                                <i class="far fa-copy"></i>
                                                            </button>
                                                        </td>
                                                        <td><?= $cargo_badge; ?></td>
                                                        <td>
                                                            <button class="btn btn-warning btn-edit-saque"
                                                                    data-id="<?= $usuario['id']; ?>"
                                                                    data-transacao="<?= $usuario['transacao_id']; ?>"
                                                                    data-valor="<?= number_format($usuario['valor'], 2, ',', '.'); ?>"
                                                                    data-chave="<?= $chaveatt; ?>"
                                                                    data-status="<?= $usuario['status']; ?>">
                                                                Editar
                                                            </button>
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
                                </div><!-- end table-responsive -->
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    
                    <?php include 'partials/endbar.php'; ?>
                    <?php include 'partials/footer.php'; ?>
                    
                </div><!-- end row -->
            </div><!-- end container-xxl -->
        </div><!-- end page-content -->

        <!-- Modal Editar Saque -->
        <div class="modal fade" id="modalEditarSaque" tabindex="-1" aria-labelledby="modalEditarSaqueLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarSaqueLabel">Editar Saque</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarSaque">
                            <input type="hidden" id="saqueId" name="saqueId">
                            <input type="hidden" id="_csrf" name="_csrf" value="<?= md5(uniqid()) ?>">
                            <!-- CSRF token -->
                            <div class="mb-3">
                                <label for="transacaoId" class="form-label">Transação ID</label>
                                <input type="text" class="form-control" id="transacaoId" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="valorSaque" class="form-label">Valor</label>
                                <input type="text" class="form-control" id="valorSaque" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="chavePix" class="form-label">Chave Pix</label>
                                <input type="text" class="form-control" id="chavePix" readonly>
                            </div>
                            <!-- Novo campo para digitar o PIN do administrador -->
                            <div class="mb-3">
                                <label for="adminPin" class="form-label">Digite seu PIN</label>
                                <input type="password" class="form-control" id="adminPin" name="adminPin"
                                       placeholder="Digite seu PIN para confirmar a ação" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnAprovarSaque">Aprovar</button>
                        <button type="button" class="btn btn-danger" id="btnRecusarSaque">Recusar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal -->

        <!-- Scripts -->
        <?php include 'partials/vendorjs.php'; ?>
        <script src="assets/js/app.js"></script>
        <script src="assets/libs/clipboard/clipboard.min.js"></script>
        <script src="assets/js/pages/clipboard.init.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Função para validar o PIN do administrador via endpoint
                function validarAdminPin(pin, callback) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/validar_pin.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            callback(response);
                        }
                    };
                    xhr.send("pin=" + encodeURIComponent(pin));
                }

                // Evento para abrir o modal e preencher as informações do saque
                const btnsEdit = document.querySelectorAll('.btn-edit-saque');
                btnsEdit.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const saqueId = this.getAttribute('data-id');
                        const transacaoId = this.getAttribute('data-transacao');
                        const valor = this.getAttribute('data-valor');
                        const chavePix = this.getAttribute('data-chave');

                        // Preenche os campos do modal
                        document.getElementById('saqueId').value = saqueId;
                        document.getElementById('transacaoId').value = transacaoId;
                        document.getElementById('valorSaque').value = valor;
                        document.getElementById('chavePix').value = chavePix;
                        // Limpa o campo do PIN para que o admin sempre o digite
                        document.getElementById('adminPin').value = '';

                        // Exibe o modal
                        const modal = new bootstrap.Modal(document.getElementById('modalEditarSaque'));
                        modal.show();
                    });
                });

                // Evento para aprovar saque
                document.getElementById('btnAprovarSaque').addEventListener('click', function () {
                    const transacaoId = document.getElementById('transacaoId').value;
                    const adminPin = document.getElementById('adminPin').value;

                    // Ao clicar, altera o botão para "Processando..." e desabilita-o
                    const btnAprovar = this;
                    btnAprovar.disabled = true;
                    btnAprovar.innerText = 'Processando...';
                    btnAprovar.classList.remove('btn-success');
                    btnAprovar.classList.add('btn-primary');

                    // Valida o PIN antes de prosseguir
                    validarAdminPin(adminPin, function(response) {
                        if (response.success) {
                            // Se o PIN for válido, prossegue com a aprovação
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "services-gateway/payment_manual.php?id=" + encodeURIComponent(transacaoId), true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4) {
                                    if (xhr.status === 200) {
                                        var resp = JSON.parse(xhr.responseText);
                                        if (resp.success) {
                                            showToast('success', resp.message || 'Saque aprovado com sucesso!');
                                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarSaque'));
                                            modal.hide();
                                            setTimeout(function () {
                                                window.location.reload();
                                            }, 2000);
                                        } else {
                                            showToast('danger', resp.message || 'Erro ao aprovar o saque.');
                                            btnAprovar.disabled = false;
                                            btnAprovar.innerText = 'Aprovar';
                                            btnAprovar.classList.remove('btn-primary');
                                            btnAprovar.classList.add('btn-success');
                                        }
                                    } else {
                                        showToast('danger', 'Erro ao aprovar o saque.');
                                        btnAprovar.disabled = false;
                                        btnAprovar.innerText = 'Aprovar';
                                        btnAprovar.classList.remove('btn-primary');
                                        btnAprovar.classList.add('btn-success');
                                    }
                                }
                            };
                            xhr.send(); // Envia o request (a resposta será ignorada)
                        } else {
                            showToast('danger', response.message);
                            btnAprovar.disabled = false;
                            btnAprovar.innerText = 'Aprovar';
                            btnAprovar.classList.remove('btn-primary');
                            btnAprovar.classList.add('btn-success');
                        }
                    });
                });

                // Evento para recusar saque sem aguardar resposta do AJAX
                document.getElementById('btnRecusarSaque').addEventListener('click', function () {
                    const btnRecusar = this;
                    btnRecusar.disabled = true;
                    btnRecusar.innerText = 'Processando...';

                    const saqueId = document.getElementById('saqueId').value;
                    const _csrf = document.getElementById('_csrf').value;
                    const email_reprovado = document.getElementById('chavePix').value;
                    const valor_reprovado = document.getElementById('valorSaque').value;
                    const adminPin = document.getElementById('adminPin').value;

                    // Valida o PIN (a resposta será ignorada)
                    validarAdminPin(adminPin, function(response) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "ajax/recusar_saque.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("att-pay=1&_csrf=" + encodeURIComponent(_csrf) +
                                 "&id_pay=" + encodeURIComponent(saqueId) +
                                 "&email_reprovado=" + encodeURIComponent(email_reprovado) +
                                 "&valor_reprovado=" + encodeURIComponent(valor_reprovado));

                        // Após 500ms, exibe a notificação e atualiza a página
                        setTimeout(function () {
                            showToast('success', 'Saque recusado com sucesso');
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarSaque'));
                            modal.hide();
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }, 500);
                    });
                });

                // Função para exibir toast com o estilo fornecido
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
            });
        </script>

        <!-- Elemento para posicionamento do Toast -->
        <div id="toastPlacement" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>
    </div><!-- end page-wrapper -->
</body>
</html>
