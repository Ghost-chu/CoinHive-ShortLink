<?php
require("config.php");
function verify ($token,$linkid)
{
    global $ch_hasehs,$ch_secret_key;
    $post_data = [
        'secret' => $ch_secret_key, // <- Your secret key
        'token' => $token, //$_POST['coinhive-captcha-token']
        'hashes' => $ch_hasehs //int
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
        return true;
    }
        return false;
}


