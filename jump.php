<?php
require ("verifyCoinHive.php");
require("config.php");
require ("linkManager.php");
$token = $_POST['token'];
$linkid = $_POST['linkid'];
echo($_POST);
echo ("linkid:".$linkid."<br/>");

global $ch_secret_key, $ch_hasehs;

$verifyed = verify($ch_secret_key, $token, $ch_hashes, $linkid);

echo("Verify:".$verifyed."<br/>");

if(!$verifyed){
    exit ("Failed to verify");
}else{
    $url = getLink($linkid);
    if(url==-1) {
        http_response_code(404);
        exit("404 not found");
    }
    header(base64_decode($url)); //Decode
    exit();
}