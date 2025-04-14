<?php
session_start();

// Verificar se o usuário é administrador
//if (!isset($_SESSION['id_user']) || $_SESSION['nivel'] != 'admin') {
   // http_response_code(403);
    //echo json_encode(['error' => 'Acesso negado. Sessão inválida.']);
    //exit;
//}

require_once __DIR__ . '/services/database.php';

header('Content-Type: application/json');

try {
    // Buscar usuários ativos nos últimos 5 minutos
    $stmt = $pdo->prepare("SELECT ip_visita, pais, cidade, estado, refer_visita, nav_os, pagina_atual, ultima_acao 
                           FROM usuarios_online 
                           WHERE ultima_acao >= (NOW() - INTERVAL 5 MINUTE)");
    $stmt->execute();
    $usuarios_online = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Certifique-se de retornar um JSON válido
    echo json_encode($usuarios_online);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar usuários online: ' . $e->getMessage()]);
    exit;
}
