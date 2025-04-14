<?php
// track_online.php
session_start();

// Ajuste conforme sua estrutura; apontando para o arquivo database.php
require_once __DIR__ . "/../services/database.php";

// Inclui pega-ip.php e ip-crawler.php
include_once __DIR__ . "/../services/pega-ip.php";
include_once __DIR__ . "/../services/ip-crawler.php";

try {
    // Verificar se o objeto $pdo está definido
    if (!isset($pdo)) {
        throw new Exception("Objeto PDO (PDO $pdo) não está definido.");
    }

    // Capturar informações de sessão e servidor
    $session_id   = session_id();
    $id_user      = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    $ip_visita    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'; 
    $pagina_atual = $_SERVER['REQUEST_URI']   ?? '/';
    $refer_visita = $_SERVER['HTTP_REFERER']  ?? 'Direct';
    // Se não existir HTTP_USER_AGENT, define 'Unknown'
    $nav_os       = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

    // Chama ip_F($ip_visita) para geolocalização
    // (Função definida em ip-crawler.php, dependendo do seu projeto)
    $data_us = ip_F($ip_visita);

    $pais   = $data_us['pais']   ?? 'N/A';
    $cidade = $data_us['cidade'] ?? 'N/A';
    $estado = $data_us['regiao'] ?? 'N/A';

    // Verificar se a sessão já existe no BD
    $stmt = $pdo->prepare("SELECT id FROM usuarios_online WHERE session_id = :session_id");
    $stmt->execute(['session_id' => $session_id]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        // Atualiza a última ação
        $stmt = $pdo->prepare("
            UPDATE usuarios_online
            SET 
                id_user     = :id_user,
                ip_visita   = :ip_visita,
                ultima_acao = NOW(),
                pagina_atual= :pagina_atual,
                refer_visita= :refer_visita,
                nav_os      = :nav_os,
                pais        = :pais,
                cidade      = :cidade,
                estado      = :estado
            WHERE session_id = :session_id
        ");
        $stmt->execute([
            'id_user'      => $id_user,
            'ip_visita'    => $ip_visita,
            'pagina_atual' => $pagina_atual,
            'refer_visita' => $refer_visita,
            'nav_os'       => $nav_os,
            'pais'         => $pais,
            'cidade'       => $cidade,
            'estado'       => $estado,
            'session_id'   => $session_id
        ]);
    } else {
        // Insere novo registro
        $stmt = $pdo->prepare("
            INSERT INTO usuarios_online
                (session_id, id_user, ip_visita, pagina_atual, refer_visita, nav_os, pais, cidade, estado)
            VALUES
                (:session_id, :id_user, :ip_visita, :pagina_atual, :refer_visita, :nav_os, :pais, :cidade, :estado)
        ");
        $stmt->execute([
            'session_id'   => $session_id,
            'id_user'      => $id_user,
            'ip_visita'    => $ip_visita,
            'pagina_atual' => $pagina_atual,
            'refer_visita' => $refer_visita,
            'nav_os'       => $nav_os,
            'pais'         => $pais,
            'cidade'       => $cidade,
            'estado'       => $estado
        ]);
    }

    // Limpa usuários inativos há mais de 5 minutos
    $stmt = $pdo->prepare("DELETE FROM usuarios_online WHERE ultima_acao < (NOW() - INTERVAL 5 MINUTE)");
    $stmt->execute();

} catch (Exception $e) {
    // Se quiser, pode registrar em log
    // error_log("track_online.php exception: " . $e->getMessage());
}
