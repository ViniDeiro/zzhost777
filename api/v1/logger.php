<?php
/**
 * Grava logs em logs/saque.log
 */
function logSaque($mensagem) {
    // Caminho absoluto para o arquivo de log
    // Use __DIR__ se este arquivo (logger.php) estiver na mesma pasta que a pasta logs
    // Ajuste conforme sua estrutura de diretórios
    $arquivoLog = __DIR__ . '/logs/saque.log';

    // Monta a string com data/hora e a mensagem
    $linha = '[' . date('Y-m-d H:i:s') . '] ' . $mensagem . PHP_EOL;

    // Usa file_put_contents em modo APPEND para não sobrescrever o arquivo
    file_put_contents($arquivoLog, $linha, FILE_APPEND);
}