<?php
require("config.php");
function verify($secret_key, $token, $need_hashes, $linkid)
{
    $post_data = [
        'secret' => $secret_key, // <- Your secret key
        'token' => $token, //$_POST['coinhive-captcha-token']
        'hashes' => $need_hashes //int
    ];

    $post_context = stream_context_create([
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($post_data)
        ]
    ]);

    $url = 'https://api.coinhive.com/token/verify';
    $response = json_decode(file_get_contents($url, false, $post_context));

    if ($response && $response->success) {
        // All good. Token verified!
        addstats($linkid);
        return true;
    } else {
        return false;
    }
}

function addstats($linkid)
{
    global $pdo_stats_table;
    $pdo = getPDO();
    if ($pdo == null) {
        return true;
    }
    $sql = 'INSERT INTO ' . $pdo_stats_table . ' (linkid, total) VALUES (:linkid, 1) ON DUPLICATE KEY UPDATE total = total + 1;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("linkid", $linkid);
    $stmt->execute();
    return true;
}

