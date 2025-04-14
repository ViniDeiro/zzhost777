<?php
session_start();
include_once("admin/services/database.php");
include_once("admin/services/funcao.php");
include_once("admin/services/crud.php");
include_once("admin/services/CSRF_Protect.php");
include_once("admin/services/pega-ip.php");
include_once("admin/services/ip-crawler.php");
include_once("admin/modulos/track_online.php");

$csrf = new CSRF_Protect();

if (isset($_GET['utm_ads']) && !empty($_GET['utm_ads'])) {
    $ads_tipo = PHP_SEGURO($_GET['utm_ads']);
} else {
    $ads_tipo = null;
}

$inviter = '';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $inviter = PHP_SEGURO($_GET['id']);
}

$url_atual = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$data_hoje = date("Y-m-d");
$hora_hoje = date("H:i:s");

if (isset($_SERVER['HTTP_REFERER'])) {
    $ref = $_SERVER['HTTP_REFERER'];
} else {
    $ref = $url_atual;
}

$data_us = ip_F($ip);

if ($browser != "Unknown Browser" && $os != "Unknown OS Platform" && $data_us['pais'] == "Brazil") {
    $id_user_ret = "1";

    $sql0 = $mysqli->prepare("SELECT ip_visita FROM visita_site WHERE data_cad=? AND ip_visita=?");
    $sql0->bind_param("ss", $data_hoje, $ip);
    $sql0->execute();
    $sql0->store_result();

    if ($sql0->num_rows) {
    } else {
        $sql = $mysqli->prepare(
            "INSERT INTO visita_site
                (nav_os, mac_os, ip_visita, refer_visita, data_cad, hora_cad, id_user, pais, cidade, estado, ads_tipo, inviter)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?)"
        );

        $sql->bind_param(
            "ssssssssssss",
            $browser,
            $os,
            $ip,
            $ref,
            $data_hoje,
            $hora_hoje,
            $id_user_ret,
            $data_us['pais'],
            $data_us['cidade'],
            $data_us['regiao'],
            $ads_tipo,
            $inviter
        );

        $sql->execute();
    }
}

$query = "SELECT nome, favicon, facebookads, mostrar_barra_topo, mostrar_barra_inferior, mostrar_modal_download FROM config WHERE id = 1";
$result = $mysqli->query($query);

$nome = "EXPFY";
$favicon = "/uploads/default-favicon.png";
$facebookads = "";
$mostrar_barra_topo = 1;
$mostrar_barra_inferior = 1;
$mostrar_modal_download = 1;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $favicon = $row['favicon'] ?: $favicon;
    $facebookads = $row['facebookads'] ?: $facebookads;
    $mostrar_barra_topo = $row['mostrar_barra_topo'];
    $mostrar_barra_inferior = $row['mostrar_barra_inferior'];
    $mostrar_modal_download = $row['mostrar_modal_download'];
}

?>
<!doctype html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" name="viewport" />
    <title><?php echo htmlspecialchars($nome); ?></title>
    <link rel="icon" href="uploads/<?php echo htmlspecialchars($favicon); ?>" type="image/png">
    <script src="/xxxx/prod/config.js?v=2024_8_30_15_11"></script>
    <script src="/ssss/theme.php"></script>
    <link rel="apple-touch-icon" href="uploads/<?php echo htmlspecialchars($favicon); ?>" />
    <meta property="og:title" content="<?php echo htmlspecialchars($nome); ?> | Jogos Slots e Apostas" />
    <meta property="og:description" content="Se você é um entusiasta em busca de emoção, camaradagem e a possibilidade de ganhar, não hesite - mergulhe nesse universo fascinante." />
    <meta property="og:image" content="uploads/<?php echo htmlspecialchars($favicon); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://<?php echo htmlspecialchars($nome); ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="600" />
    <meta property="og:updated_time" content="<?php echo time(); ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($nome); ?> | Apostas slots confiaveis e originais , aproveite e lucre de forma rapida " />
    <meta name="twitter:description" content="Se você é um entusiasta em busca de emoção, camaradagem e a possibilidade de ganhar, não hesite - mergulhe nesse universo fascinante." />
    <meta name="twitter:image" content="uploads/<?php echo htmlspecialchars($favicon); ?>" />
    <meta name="twitter:url" content="https://<?php echo htmlspecialchars($nome); ?>" />
    <meta property="insta:title" content="<?php echo htmlspecialchars($nome); ?> | Jogos Slots e Apostas" />
    <meta property="insta:description" content="Descubra o mundo dos melhores jogos de slots, tigrinhos e muito mais." />
    <meta property="insta:image" content="uploads/<?php echo htmlspecialchars($favicon); ?>" />
    <meta property="insta:type" content="website" />
    <meta name="telegram:title" content="<?php echo htmlspecialchars($nome); ?> | Jogos Slots e Apostas" />
    <meta name="telegram:description" content="Entre no universo de apostas, slots e muita diversão com <?php echo htmlspecialchars($nome); ?>!" />
    <meta name="telegram:image" content="uploads/<?php echo htmlspecialchars($favicon); ?>" />
    <meta name="telegram:url" content="https://<?php echo htmlspecialchars($nome); ?>" />
    <meta name="description" content="Entre no universo de apostas, jogue slots, tigrinhos e descubra a emoção de ganhar no <?php echo htmlspecialchars($nome); ?>." />
    <meta name="keywords" content="cassino, apostas online, slots, tigrinho, jogos de apostas, diversão" />
    <meta name="author" content="<?php echo htmlspecialchars($nome); ?>" />
    <meta name="robots" content="index, follow" />
    <meta property="description" content="Se você é um entusiasta em busca de emoção, camaradagem e a possibilidade de ganhar, não hesite - mergulhe nesse universo fascinante." />
    <script src="https://accounts.google.com/gsi/client" async defer="defer"></script>
    <script src="https://apis.google.com/js/platform.js?onload=init" async defer="defer"></script>
    <script>function init() { gapi.load('auth2', function () { console.log('22222222222222222222') });}</script>
    <script async defer="defer" crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v20.0" nonce="s2QYaSCr"></script>
    <script type="text/javascript"> (function () { setTimeout(function () { var temp = '<script type="module" crossorigin src="/yq-br-prod/web1/assets/index-CKtHrVPI-2024_9_14_11_28.js">____script><link rel="stylesheet" crossorigin href="/yq-br-prod/web1/assets/index-DQZyYQwA-2024_9_14_11_28.css"><script type="module">import.meta.url;import("_").catch(()=>1);(async function*(){})().next();if(location.protocol!="file:"){window.__vite_is_modern_browser=true}____script><script type="module">!function(){if(window.__vite_is_modern_browser)return;console.warn("vite: loading legacy chunks, syntax error above and the same error below should be ignored");var e=document.getElementById("vite-legacy-polyfill"),n=document.createElement("script");n.src=e.src,n.onload=function(){System.import(document.getElementById("vite-legacy-entry").getAttribute("data-src"))},document.body.appendChild(n)}();____script>'; var div = document.createElement('div'); div.style.width = '0px'; div.style.height = '0px'; div.style.display = 'none'; document.body.appendChild(div); var range = document.createRange(); range.selectNode(div); var doc = range.createContextualFragment(temp.replace(/____/g, '</')); div.appendChild(doc); }, 0); })() 
    </script>
    <style>
        <?php if ($mostrar_barra_topo == 0): ?>
            ._download_15jvu_1714 {
                display: none !important;
            }
        <?php endif; ?>
        <?php if ($mostrar_barra_inferior == 0): ?>
            ._download_app_1umbr_55 {
                display: none !important;
            }
        <?php endif; ?>
    </style>
    <script>
    <?php if ($mostrar_modal_download == 0): ?>
    <!-- Script de rastreamento do modal: fecha automaticamente -->
    
      document.addEventListener('DOMContentLoaded', function() {
        var interval = setInterval(function() {
          var modal = document.querySelector('div._modalBox_1vj4v_55');
          var closeButton = document.querySelector('div._clsoeBtn_ufb2o_170');
          if (modal && modal.style.display === 'block' && closeButton) {
            closeButton.click();
            console.log('Botão de fechar clicado automaticamente.');
            clearInterval(interval);
          }
        }, 500);
      });
   
    <?php endif; ?> </script>

<body>
    <div id="root"></div>

    <div id="logRegBlock"></div>
    <script>
        function clearImageCache() {
            const images = document.querySelectorAll('img');

            images.forEach((img) => {
                const currentSrc = img.src;
                //console.log('>>> CACHE DE IMAGENS LIMPO');
                const newSrc = currentSrc.split('?')[0] + '?t=' + new Date().getTime();
                img.src = newSrc;
            });
        }
        setInterval(clearImageCache, 30000);
    </script>
   
    
    <script>
        const getCookie = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

            const atualizaSaldo = () => {
            const url = '/api/v1/ykn?expfygaming=attbalance';
            const token = getCookie('token_user');

            if (!token) {
             //   console.error('Token não encontrado no cookie.');
                return;
            }

            const data = {
                token: token
            };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                //    console.log('Saldo Atualizado:', data);
                    if (data.saldo !== undefined) {
                        localStorage.setItem('user_balance', data.saldo);
                    }
                })
                .catch((error) => {
                //    console.error('Error:', error);
                });
        };

        setInterval(atualizaSaldo, 8000);
    </script>
    
<!--   Modal Depósito Abrindo

<script>
    
        let hasClicked = false;
    
        function clickWhenLoaded() {
            if (hasClicked) return;
    
            const userBalance = localStorage.getItem("user_balance");
            if (userBalance && parseFloat(userBalance) > 0) {
                return;
            }
    
            const button = document.querySelector("._despositBtn_15jvu_1111");
            if (button) {
                button.click();
                hasClicked = true;
            }
        }
    
        const observer = new MutationObserver(() => {
            const button = document.querySelector("._despositBtn_15jvu_1111");
            if (button && !hasClicked) {
                clickWhenLoaded();
                observer.disconnect();
            }
        });
    
        observer.observe(document.body, { childList: true, subtree: true });
    </script>
    
    <script>
        const clickReloadButton = () => {
        const reloadButton = document.querySelector('._freshBox_1jnj8_60');
            if (reloadButton) {
                reloadButton.click();
            } else {
                //console.error('Elemento não encontrado');
            }
        };
        setInterval(clickReloadButton, 5000);
    </script>
    
    <script>
    document.querySelectorAll('.game-item').forEach(item => {
        item.addEventListener('click', function() {
            const gameUrl = item.getAttribute('data-url');
            if (gameUrl) {
                window.location.href = gameUrl;
            }
        });
    });
    </script>-->

    <script nomodule>
        !function () {
            var e = document, t = e.createElement("script");
            if (!("noModule" in t) && "onbeforeload" in t) {
                var n = !1;
                e.addEventListener("beforeload", function (e) {
                    if (e.target === t) n = !0;
                    else if (!e.target.hasAttribute("nomodule") || !n) return;
                    e.preventDefault();
                }, !0),
                    t.type = "module",
                    t.src = ".",
                    e.head.appendChild(t),
                    t.remove()
            }
        }();
    </script>
    
  
    <script>
        function checkAndClean() {
            const selector = "body > div._modalBox_1vj4v_55 > div > div > div > div:nth-child(3) > form > div:nth-child(2) > div > div._options_6yhmd_377._small_6yhmd_183";
            const targetElement = document.querySelector(selector);
    
            if (targetElement) {
                //console.log("Elemento encontrado:", targetElement);
                Array.from(targetElement.children).forEach(child => {
                    //console.log("Verificando elemento:", child.textContent.trim());
                    if (child.textContent.trim() !== "PIX-CPF") {
                        //console.log("Removendo elemento:", child);
                        child.remove();
                    }
                });
            }
            
            setTimeout(checkAndClean, 500);
        }
    
        checkAndClean();
    </script>
    


    
    <script>!function(f,b,e,v,n,t,s) {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0'; n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js'); fbq('init', '<?php echo $facebookads; ?>'); fbq('track', 'PageView');</script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $facebookads; ?>&ev=PageView&noscript=1"/></noscript>

    <script nomodule crossorigin id="vite-legacy-polyfill" src="https://" + window.location.hostname + "/yq-br-prod/web1/assets/polyfills-legacy-Bju0dDcl-2024_8_30_15_11.js"></script>
    <script nomodule crossorigin id="vite-legacy-entry" data-src="https://" + window.location.hostname + "/yq-br-prod/web1/assets/index-legacy-CsCDms-9-2024_8_30_15_11.js"> System.import(document.getElementById('vite-legacy-entry').getAttribute('data-src'))</script>
    
    <style>
    /* Report table title icon */
.report_main .report_table .report_table_title_icon{
 display:none;
}

        .img_list_title {
            color: white !important;
        }
        ._gameBox_s_1mc6p_397 {
            display: none !important;
        }
        #label_Recente {
        display: none !important;
        }
        #label_Favoritos {
        display: none !important;
        }
        ._container_1pxds_55 ._header_1pxds_70 {
        display: none !important;
        }
        ._container_1pxds_55 .report {
         margin-top: 20px !important;
        }
        #tab_Income, #tab_Rebate, 
        #tab_Member, #tab_Transaction, 
        #tab_SubordinateIncome, #tab_DirectlyGet, 
        #tab_ReturnRate, #tab_AddSubordinate,
        ._share_box_1uihb_584 .chat-list .chat-app:last-child, 
        ._styl1Tips_1qgvj_997, ._depositImg_quzqg_578,
        ._threeLoginBox_16c0v_55, ._threeLoginBox_1uynm_55,
        ._game_recommend_1v8j8_286, ._discountedPrice_quzqg_512,
        ._btn_sbg1y_89 ._cz_sbg1y_95 ._showCz2_sbg1y_119 { 
        display: none !important;
        }
        #share-ins, #share-whatsapp, 
        #share-facebook, #share-telegram,
        #share-youtube, #share-twitter,
        #share-tiktok, #share-line {
        display: none !important;
        }
        ._inputContainer_dl4ah_55 ._input_dl4ah_55 ._content_dl4ah_258 ._enter_dl4ah_263 {
        height: 60px !important;   
        }
        
        ._gameStartBox_sbg1y_55 ._goHomeBox_sbg1y_68 ._showTx_sbg1y_110 {
          transform: translateY(100%) scale(1) !important;
          display: none !important;
        }
        
        ._gameStartBox_sbg1y_55 ._goHomeBox_sbg1y_68 ._btn_sbg1y_89._cz_sbg1y_95 {
          transform: translateX(0px) translateY(0) scale(0);
          display: none !important;
        }

       html[theme="whiteGreen"],
       html[theme="whiteRed"],
       html[theme="versaceYellow"],
       html[theme="lancomePeach"],
       html[theme="whiteYellow"],
       html[theme="whiteBlue"],
       html[theme="whitePink"],
       html[theme="whiteBrown"],
       html[theme="whitePurple"],
       html[theme="whiteDarkGreen"] {
           --icon-fill-color: black;
       }
    
       html[theme="black"],
       html[theme="purple"],
       html[theme="oilyGreen"],
       html[theme="sk2"],
       html[theme="hermesOrange"],
       html[theme="lightBrown"],
       html[theme="furlaBlue"],
       html[theme="bvGreen"],
       html[theme="AnnaSuiPurple"],
       html[theme="burgundyRed"],
       html[theme="greenGold"] {
           --icon-fill-color: white;
       }

       ._before_quzqg_448 .icon-personal, 
       ._before_quzqg_448 .icon-cpf {
           fill: var(--icon-fill-color) !important;
       }
    </style>

</body>
</html>