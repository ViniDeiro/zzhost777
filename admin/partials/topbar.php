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

// Consulta o banco para verificar se o iGameWin está ativo e para recuperar o valor atual de RTP
$igamewin_active = false;
$igamewin_url    = "";
$agent_code      = "";
$agent_token     = "";
$rtp_db_value    = 50; // valor padrão

$query  = "SELECT * FROM igamewin WHERE ativo = 1 LIMIT 1";
$result = mysqli_query($mysqli, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row            = mysqli_fetch_assoc($result);
    $igamewin_active = true;
    $igamewin_url    = $row['url'];
    $agent_code      = $row['agent_code'];
    $agent_token     = $row['agent_token'];
    if(isset($row['rtp'])){
        $rtp_db_value = (int)$row['rtp'];
    }
}
#======================================#
#expulsa user
checa_login_adm();
#======================================#
//inicio do scriot expulsa usuario bloqueado
if ($_SESSION['data_adm']['status'] != '1') {
    echo "<script>setTimeout(function() { window.location.href = 'bloqueado.php'; }, 0);</script>";
    exit();
}
/// final do script --#
?>

<audio id="background-music" preload="auto">
    Seu navegador não suporta o elemento de áudio.
</audio>
<link href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <style>
    
    .btn.apoiar-btn {
        font-size: 12px;
        padding: 0.5rem 1.5rem;
        border-radius: 30px;
        border: none;
        background-color: #0e161e;
        color: #ffffff;
    }
    @media (max-width: 767.98px) {
        .btn.apoiar-btn {
            padding: 0.5rem 0.5rem; 
        }
    }
    
        .tag {
            width: 16px;
            height: 32px;
            border-radius: 4px;
            background: #22c55e;
            margin-right: 10px;
        }
        /* Estilo para o controle de RTP */
        .rtp-control {
            margin-right: 10px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .rtp-control label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .rtp-control input[type="range"] {
            width: 100px;
        }
        /* Toast container */
        .toast-container {
            z-index: 1055;
        }
    </style>
<div class="topbar d-print-none">
    <div class="container-xxl">
        <nav class="topbar-custom d-flex justify-content-between align-items-center" id="topbar-custom">    
        
            <!-- Bloco esquerdo -->
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">                        
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu-scale"></i>
                    </button>
                </li> 
                <li class="mx-3 welcome-text">
                    <h3 class="mb-0 fw-bold text-truncate">Boas-vindas, <?=$_SESSION['data_adm']['nome'];?>.</h3>
                    <h6 class="mb-0 fw-normal text-muted text-truncate fs-14" style="margin-top: 4px;">Plataforma: <?=$dataconfig['nome'];?></h6>
                </li>                   
            </ul>
            
<div class="d-flex justify-content-center align-items-center flex-fill">
    <a class="btn apoiar-btn" href="https://apoiar.expfy.online/" target="_blank">
        <i class="fa fa-coffee me-md-2"></i>
        <span class="d-none d-md-inline">Apoie o Projeto</span>
    </a>
</div>

            
            <!-- Bloco direito -->
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <!-- Exibe o controle de RTP apenas se o iGameWin estiver ativo -->
                <?php if ($igamewin_active): ?>
                <li class="rtp-control" title="RTP Geral">
                    <label for="rtpSlider">RTP Geral: <span id="rtpValueDisplay"><?php echo $rtp_db_value; ?>%</span></label>
                    <input type="range" id="rtpSlider" min="10" max="90" step="5" value="<?php echo $rtp_db_value; ?>">
                </li>
                <?php endif; ?>
                <li class="music-toggle" id="musicToggle" title="Ativar/desativar música">
                    <a class="nav-link nav-icon" href="javascript:void(0);" id="toggleMusic">
                        <i class="fa-solid fa-music" id="musicIcon"></i>
                    </a>
                </li>
                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <img src="assets/images/users/F.png" alt="" class="thumb-lg rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="assets/images/users/F.png" alt="" class="thumb-md rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-medium text-dark fs-13"><?=$_SESSION['data_adm']['nome'];?></h6>
                                <small class="text-muted mb-0">Plataforma: <?=$dataconfig['nome'];?></small>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <small class="text-muted px-2 pb-1 d-block">Configurações</small>
                        <a class="dropdown-item" href="administradores"><i class="las la-user fs-18 me-1 align-text-bottom"></i> Operadores</a>
                        <a class="dropdown-item text-danger" href="sair"><i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Sair</a>
                    </div>
                </li>
            </ul><!--end topbar-nav-->
        </nav>
        <!-- end navbar-->
    </div>
</div>


<script>
    // Lista de músicas disponíveis
    const musicFiles = [
        './bom_dia_magnata.mp3',
        './bom_dia_chefe.mp3',
        './conquistar_grandes_sonhos.mp3'
    ];

    let isMusicOn = localStorage.getItem('isMusicOn') === 'true'; // Converte o valor armazenado em booleano
    const musicElement = document.getElementById('background-music');
    let lastMusic = ''; // Armazena o último arquivo de música reproduzido

    // Função para escolher uma música aleatória diferente da última
    function getRandomMusic() {
        let newMusic;
        do {
            newMusic = musicFiles[Math.floor(Math.random() * musicFiles.length)];
        } while (newMusic === lastMusic); // Repete até que a nova música seja diferente da última
        lastMusic = newMusic; // Atualiza a última música reproduzida
        return newMusic;
    }

    // Define a música inicial ao carregar a página
    musicElement.src = getRandomMusic();

    document.getElementById('musicToggle').addEventListener('click', function() {
        isMusicOn = !isMusicOn; // Alterna o estado da música
        localStorage.setItem('isMusicOn', isMusicOn); // Salva o estado no Local Storage
        const musicIcon = document.getElementById('musicIcon');

        if (isMusicOn) {
            musicIcon.classList.remove('fa-microphone-slash'); // Remove ícone de microfone silenciado
            musicIcon.classList.add('fa-music'); // Ícone de música
            musicElement.play(); // Reproduz a música
        } else {
            musicIcon.classList.remove('fa-music'); // Remove ícone de música
            musicIcon.classList.add('fa-microphone-slash'); // Ícone de microfone silenciado
            musicElement.pause(); // Pausa a música
        }
    });

    window.addEventListener('load', () => {
        musicElement.volume = 0.2;

        if (isMusicOn) {
            musicElement.play().catch(error => {
                console.log('A reprodução automática foi bloqueada pelo navegador.');
            });
            const musicIcon = document.getElementById('musicIcon');
            musicIcon.classList.remove('fa-microphone-slash'); 
            musicIcon.classList.add('fa-music'); 
        } else {
            const musicIcon = document.getElementById('musicIcon');
            musicIcon.classList.remove('fa-music'); 
            musicIcon.classList.add('fa-microphone-slash'); 
        }
    });

    // Reproduz uma nova música aleatória após o término da atual
    musicElement.addEventListener('ended', function() {
        musicElement.src = getRandomMusic(); // Escolhe uma nova música aleatória diferente da última
        if (isMusicOn) {
            musicElement.play();
        }
    });
    
            // --- Código para o controlador de RTP ---
        <?php if ($igamewin_active): ?>
        const apiURL = "<?php echo $igamewin_url; ?>";
        const agentCode = "<?php echo $agent_code; ?>";
        const agentToken = "<?php echo $agent_token; ?>";
        const rtpSlider = document.getElementById('rtpSlider');

        if (rtpSlider) {
            // Atualiza o display do valor enquanto o usuário move o slider
            rtpSlider.addEventListener('input', function() {
                const rtpValue = parseInt(this.value);
                document.getElementById('rtpValueDisplay').textContent = rtpValue + '%';
            });

            // Ao finalizar o ajuste, envia os dados para a API iGameWin e atualiza o valor no banco de dados
            rtpSlider.addEventListener('change', function() {
                const rtpValue = parseInt(this.value);
                const data = {
                    method: "control_rtp",
                    agent_code: agentCode,
                    agent_token: agentToken,
                    rtp: rtpValue
                };

                

                // Envia o valor para atualizar no banco de dados (arquivo updateRtp.php)
                fetch('partials/updateRtp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ rtp: rtpValue })
                })
                .then(response => response.json())
                .then(json => {
                    console.log('Valor atualizado no banco:', json);
                    if(json.success){
                        showToast('success', 'RTP alterado com sucesso!');
                    } else {
                        showToast('danger', 'Erro ao alterar RTP: ' + json.message);
                    }
                })
                .catch(error => {
                    console.error('Erro ao atualizar o banco de dados:', error);
                    showToast('danger', 'Erro ao atualizar o banco de dados.');
                });
            });
        }
        <?php endif; ?>
    
</script>