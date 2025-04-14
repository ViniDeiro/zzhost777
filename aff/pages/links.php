<?php
session_start();


$user_id = $_SESSION['user_id'] ?? 0;

$invite_code = getUserInviteCode($user_id);

$visitorCount = getVisitorCount($user_id);

$stats = getUserStats($user_id);
$cadastros = $stats['total_indications'] ?? 0;
$depositantes = $stats['total_depositantes'] ?? 0;

$conversaoPercent = 0;
if ($cadastros > 0) {
    $conversaoPercent = ($depositantes / $cadastros) * 100;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Meus Links</title>

</head>
<body>
<div class="dashboard">
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="page-title">Meus Links</h1>
        </div>
    </nav>

    <!-- Lista de Links -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Links Ativos</h3>
            <div class="flex gap-2">
                <button class="btn btn-outline">
                    <i class="fas fa-filter"></i>
                    Filtrar
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i>
                    Exportar
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Link</th>
                        <th>Cliques</th>
                        <th>Cadastros</th>
                        <th>Depositantes</th>
                        <th>Conversões</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="flex items-center gap-2">
                            <!-- Exibição do Link -->
                            <span id="currentLink" class="truncate max-w-[300px]"></span>
                            <button class="copy-btn btn btn-outline btn-sm">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                        <td><?php echo $visitorCount; ?></td>
                        <td><?php echo $cadastros; ?></td>
                        <td><?php echo $stats['qtd_depositos']; ?></td>
                        <td>
                            <?php echo number_format($stats['desempenho'], 1, ',', '.'); ?>%
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(() => {
        const icon = button.querySelector('i');
        icon.classList.remove('fa-copy');
        icon.classList.add('fa-check');
        button.classList.add('text-green-500');
        setTimeout(() => {
            icon.classList.remove('fa-check');
            icon.classList.add('fa-copy');
            button.classList.remove('text-green-500');
        }, 2000);
    }).catch(err => {
        console.error('Erro ao copiar:', err);
    });
}

document.addEventListener('DOMContentLoaded', function() {

    const domainAtual = window.location.origin;

    const inviteCodeFromPhp = '<?php echo $invite_code; ?>';

    const finalURL = `${domainAtual}/?id=${inviteCodeFromPhp}&currency=BRL&type=2`;


    const currentLinkEl = document.getElementById('currentLink');
    currentLinkEl.textContent = finalURL;

    const copyButton = document.querySelector('.copy-btn');
    copyButton.addEventListener('click', function() {
        copyToClipboard(finalURL, this);
    });
});


function generateQRCode(text) {
    const container = document.getElementById('qrCodeContainer');
    const qrcodeElement = document.getElementById('qrcode');

    qrcodeElement.innerHTML = '';
    QRCode.toCanvas(qrcodeElement, text, {
        width: 200,
        margin: 1,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    }, function (error) {
        if (error) console.error(error);
    });

    container.classList.remove('hidden');
}

function downloadQRCode() {
    const canvas = document.querySelector('#qrcode canvas');
    const link = document.createElement('a');
    link.download = 'qrcode.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}
</script>
</body>
</html>
