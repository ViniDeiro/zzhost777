function detectDevToolsAndBlock() {
  function redirectToTelegram() {
    window.location.href = "https://t.me/apioneplays";
  }

  function checkDebugger() {
    const startTime = performance.now();
    debugger;
    const elapsedTime = performance.now() - startTime;
    return elapsedTime > 50; // 0x32 em decimal
  }

  // Previne clique direito
  document.addEventListener('contextmenu', function(event) {
    event.preventDefault();
    redirectToTelegram();
  });

  // Monitor de teclas
  document.addEventListener("keydown", function(event) {
    // Ctrl + U (View Source)
    if (event.ctrlKey && (event.key === 'u' || event.key === 'U')) {
      event.preventDefault();
      redirectToTelegram();
    }

    // Ctrl + Shift + I (Developer Tools)
    if (event.ctrlKey && event.shiftKey && (event.key === 'i' || event.key === 'I')) {
      event.preventDefault();
      redirectToTelegram();
    }

    // Ctrl + Shift + J (Developer Tools)
    if (event.ctrlKey && event.shiftKey && (event.key === 'j' || event.key === 'J')) {
      event.preventDefault();
      redirectToTelegram();
    }

    // Ctrl + Shift + C (Inspect Element)
    if (event.ctrlKey && event.shiftKey && (event.key === 'c' || event.key === 'C')) {
      event.preventDefault();
      redirectToTelegram();
    }

    // Ctrl + S (Save Page)
    if (event.ctrlKey && (event.key === 's' || event.key === 'S')) {
      event.preventDefault();
      redirectToTelegram();
    }

    // F12 key (0x7b = 123 = F12 keyCode)
    if (event.keyCode === 123) {
      event.preventDefault();
      redirectToTelegram();
    }
  });

  // Verifica a presença do debugger a cada 1000ms (0x3e8)
  setInterval(function() {
    if (checkDebugger()) {
      redirectToTelegram();
    }
  }, 1000);
}