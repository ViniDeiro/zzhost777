<!-- Spinner de carregamento -->
<div id="loadingSpinner"
    style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1051; background-color: rgb(39 42 39); width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column;">
   <!--- <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div> --->
    <!-- <p style="margin-top: 15px; font-size: 18px; font-weight: 500; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
        Carregando...
    </p> -->
</div>

<style>
    ::-webkit-scrollbar {
    width: 4px;
}

::-webkit-scrollbar-track {
    background-color: transparent;
    border-radius: 1.5px;
}

::-webkit-scrollbar-thumb {
    background-color: transparent;
    border-radius: 20px;
}
</style>

<!-- App css -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<script src="../../yq-br-prod/web1/assets/ActionBlockGame-Nhsadas_32_32.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var spinner = document.getElementById("loadingSpinner");

        // Ocultar o spinner após o carregamento completo da página, com um tempo mínimo de 1 segundo
        window.onload = function () {
            setTimeout(function () {
                spinner.style.display = 'none';
            }, 500); // Atraso de 1 segundo
        };
    });
</script>

<style>
        #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -1;
        top: 0;
        left: 0;
        opacity: 0.2;
    }
</style>

<div id="particles-js"></div>

<script>
    function clearImageCache() {
        const images = document.querySelectorAll('img'); // Seleciona todas as imagens na página

        images.forEach((img) => {
            const currentSrc = img.src;
            console.log('>>> CACHE DE IMAGENS LIMPO');
            const newSrc = currentSrc.split('?')[0] + '?t=' + new Date().getTime(); // Adiciona um timestamp para evitar cache
            img.src = newSrc;
        });
    }

    // Executa a função clearImageCache a cada 5 minutos (300000 milissegundos)
    setInterval(clearImageCache, 30000);

</script>