<?php
require ("verifyCoinHive.php");
require("config.php");
require ("linkManager.php");
$token = $_POST['token'];
$linkid = $_POST['linkid'];

global $ch_secret_key, $ch_hasehs;

$verifyed = verify( $token, $linkid);

if(!$verifyed){
    exit ("Failed to verify");
}else{
    $url = getLink($linkid);
    if(url==-1) {
        http_response_code(404);
        exit("404 not found");
    }
    header('location:'.base64_decode($url));
    exit();
}