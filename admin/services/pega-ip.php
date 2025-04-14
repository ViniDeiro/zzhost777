<?php
/**
 * Função que tenta determinar o IP real do usuário,
 * mesmo que ele esteja atrás de proxies.
 */
function pegaIP() {
    // Verifique se há IP compartilhado da Internet
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validar_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // Verifique se há endereços IP passando por proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Verifique se existem vários endereços IP em var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $lista_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($lista_ip as $ip) {
                if (validar_ip($ip)) {
                    return $ip;
                }
            }
        } else {
            if (validar_ip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validar_ip($_SERVER['HTTP_X_FORWARDED'])) {
        return $_SERVER['HTTP_X_FORWARDED'];
    }

    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validar_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validar_ip($_SERVER['HTTP_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_FORWARDED_FOR'];
    }

    if (!empty($_SERVER['HTTP_FORWARDED']) && validar_ip($_SERVER['HTTP_FORWARDED'])) {
        return $_SERVER['HTTP_FORWARDED'];
    }

    // Se chegou até aqui, retorna REMOTE_ADDR (não confiável, mas é o que resta)
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Verifica se um IP é válido e não está em faixas privadas/reservadas.
 */
function validar_ip($ip) {
    if (strtolower($ip) === 'unknown') {
        return false;
    }

    // Faz parse do IP p/ número inteiro (ipv4)
    $ipLong = ip2long($ip);

    // Se for falso ou -1, não é válido
    if ($ipLong === false || $ipLong === -1) {
        return false;
    }

    // Força número não assinado
    $ipLong = sprintf('%u', $ipLong);

    // Verificações de faixas privadas
    // 0.0.0.0 => 2.255.255.255
    if ($ipLong >= 0 && $ipLong <= 50331647) {
        return false;
    }
    // 10.0.0.0 => 10.255.255.255
    if ($ipLong >= 167772160 && $ipLong <= 184549375) {
        return false;
    }
    // 127.0.0.0 => 127.255.255.255
    if ($ipLong >= 2130706432 && $ipLong <= 2147483647) {
        return false;
    }
    // 169.254.0.0 => 169.254.255.255
    if ($ipLong >= 2851995648 && $ipLong <= 2852061183) {
        return false;
    }
    // 172.16.0.0 => 172.31.255.255
    if ($ipLong >= 2886729728 && $ipLong <= 2887778303) {
        return false;
    }
    // 192.0.2.0 => 192.0.2.255
    if ($ipLong >= 3221225984 && $ipLong <= 3221226239) {
        return false;
    }
    // 192.168.0.0 => 192.168.255.255
    if ($ipLong >= 3232235520 && $ipLong <= 3232301055) {
        return false;
    }
    // 255.255.255.0 => 255.255.255.255
    if ($ipLong >= 4294967040) {
        return false;
    }

    return true;
}

// Tenta obter user_agent; se não existir, define string vazia
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? "";

/**
 * Retorna uma string com o nome do sistema operacional, baseado em user agent
 */
function getOS($user_agent) {
    $os_platform = "Unknown OS Platform";

    // Se user_agent vazio, retorna de cara
    if (!$user_agent) {
        return $os_platform;
    }

    $os_array = [
        '/windows nt 10/i'     => 'Windows 10',
        '/windows nt 6.3/i'    => 'Windows 8.1',
        '/windows nt 6.2/i'    => 'Windows 8',
        '/windows nt 6.1/i'    => 'Windows 7',
        '/windows nt 6.0/i'    => 'Windows Vista',
        '/windows nt 5.2/i'    => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'    => 'Windows XP',
        '/windows xp/i'        => 'Windows XP',
        '/windows nt 5.0/i'    => 'Windows 2000',
        '/windows me/i'        => 'Windows ME',
        '/win98/i'             => 'Windows 98',
        '/win95/i'             => 'Windows 95',
        '/win16/i'             => 'Windows 3.11',
        '/macintosh|mac os x/i'=> 'Mac OS X',
        '/mac_powerpc/i'       => 'Mac OS 9',
        '/linux/i'             => 'Linux',
        '/ubuntu/i'            => 'Ubuntu',
        '/iphone/i'            => 'iPhone',
        '/ipod/i'              => 'iPod',
        '/ipad/i'              => 'iPad',
        '/android/i'           => 'Android',
        '/blackberry/i'        => 'BlackBerry',
        '/webos/i'             => 'Mobile'
    ];

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
            break;
        }
    }
    return $os_platform;
}

/**
 * Retorna uma string com o nome do navegador, baseado em user agent
 */
function getBrowser($user_agent) {
    $browser = "Unknown Browser";

    if (!$user_agent) {
        return $browser;
    }

    $browser_array = [
        '/msie/i'       => 'Internet Explorer',
        '/firefox/i'    => 'Firefox',
        '/safari/i'     => 'Safari',
        '/chrome/i'     => 'Chrome',
        '/edge/i'       => 'Edge',
        '/opera/i'      => 'Opera',
        '/netscape/i'   => 'Netscape',
        '/maxthon/i'    => 'Maxthon',
        '/konqueror/i'  => 'Konqueror',
        '/mobile/i'     => 'Handheld Browser'
    ];

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
            break;
        }
    }
    return $browser;
}

// Agora que temos as funções definidas, podemos obter OS, Browser, IP
$os      = getOS($user_agent);
$browser = getBrowser($user_agent);
$ip      = pegaIP();
?>
