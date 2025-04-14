<?php
$pixQr = $_GET['paymentCode'];
$pixValor = $_GET['valorPix'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagamento QR Code</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>
  <style>
    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }
    body {
      background-color: #f0f2f5;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
      color: #333;
    }
    .card {
      background: #fff;
      padding: 2rem;
      border-radius: 1rem;
      max-width: 600px;
      width: 100%;
      margin: 1rem;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .qr-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #fafafa;
      padding: 1.5rem;
      border-radius: 0.75rem;
      margin-bottom: 2rem;
    }
    #qrcode {
      padding: 1rem;
      background: #fff;
      border-radius: 0.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      margin-bottom: 1rem;
    }
    #qrcode img {
      width: 250px;
      height: 250px;
    }
    .scan-text {
      font-size: 0.9rem;
      color: #666;
      text-align: center;
    }
    .address-container {
      background: #fafafa;
      padding: 1rem;
      border-radius: 0.75rem;
      cursor: pointer;
      text-align: center;
      transition: background 0.3s ease;
      margin-bottom: 2rem;
    }
    .address-container:hover {
      background: #f0f0f0;
    }
    .address {
      font-family: monospace;
      font-size: 0.9rem;
      word-break: break-all;
      color: #444;
    }
    .copy-btn {
      margin-top: 1rem;
      width: 100%;
      padding: 0.75rem;
      background-color: #28a745;
      color: #fff;
      font-size: 0.9rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      transition: background-color 0.3s ease;
    }
    .copy-btn:hover {
      background-color: #218838;
    }
    .payment-details {
      animation: fadeIn 0.3s ease;
    }
    .payment-type {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      border-bottom: 2px solid #eee;
      padding-bottom: 1rem;
    }
    .detail-row {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 0;
      border-bottom: 1px solid #eee;
      font-size: 0.95rem;
    }
    .detail-row:last-child {
      border-bottom: none;
    }
    .status {
      background: #6c757d;
      color: #fff;
      padding: 0.75rem;
      border-radius: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-size: 0.95rem;
      margin-top: 1rem;
    }
    .spinner {
      width: 16px;
      height: 16px;
      border: 2px solid #fff;
      border-top: 2px solid transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    .toast {
      position: fixed;
      bottom: 1rem;
      right: 1rem;
      background: #28a745;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      display: none;
      animation: slideIn 0.3s ease;
      font-size: 0.95rem;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <main class="card">
    <section class="qr-container">
      <div id="qrcode"></div>
      <p class="scan-text">Escaneie o código QR com seu aplicativo de pagamento</p>
    </section>
    <section class="address-container" id="addressBox">
      <p class="address" id="addressText"></p>
      <button class="copy-btn" id="copyButton">
        Copiar código PIX
      </button>
    </section>
    <section class="payment-details" id="details"></section>
  </main>
  <div class="toast" id="toast">PIX copiado!</div>
  <script>
    const paymentData = {
      pix: {
        address: "<?= $pixQr ?>",
        details: {
          type: "PIX",
          minDeposit: "R$ <?= number_format($pixValor, 2, ",", ".") ?>",
          confirmations: "Instantâneo"
        }
      }
    };

    function generateQRCode(data) {
      const qr = qrcode(0, 'M');
      qr.addData(data);
      qr.make();
      return qr.createImgTag(6);
    }

    function updateUI(paymentType) {
      const { address, details } = paymentData[paymentType];
      document.getElementById('qrcode').innerHTML = generateQRCode(address);
      document.getElementById('addressText').textContent = address;
      const detailsContainer = document.getElementById('details');
      detailsContainer.innerHTML = `
        <div class="payment-type">
          <img src="https://i.pinimg.com/originals/46/11/a5/4611a564a1f84d6758472fe7e6483671.png" alt="${details.type}" width="24">
          <span>${details.type}</span>
        </div>
        <div class="detail-row">
          <span>Valor a ser depositado:</span>
          <span>${details.minDeposit}</span>
        </div>
        <div class="status">
          <div class="spinner"></div>
          Aguardando pagamento...
        </div>
      `;
    }

    document.getElementById('addressBox').addEventListener('click', async () => {
      const address = document.getElementById('addressText').textContent;
      try {
        await navigator.clipboard.writeText(address);
        const toast = document.getElementById('toast');
        toast.style.display = 'block';
        setTimeout(() => toast.style.display = 'none', 2000);
      } catch (error) {
        console.error("Erro ao copiar texto", error);
      }
    });

    updateUI('pix');

    const paymentCode = "<?= $pixQr ?>";
    async function verificarPagamento() {
      try {
        const response = await fetch(`verificar-pagamento.php?paymentCode=${encodeURIComponent(paymentCode)}`);
        const data = await response.json();
        if (data.status === 'pago') {
          window.location.href = "/";
        }
      } catch (error) {
        console.error("Erro ao verificar pagamento", error);
      }
    }
    setInterval(verificarPagamento, 5000);
  </script>
</body>
</html>
