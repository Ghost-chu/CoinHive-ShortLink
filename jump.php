<?php
require ("verifyCoinHive.php");
require("config.php");
require ("linkManager.php");
$token = $_POST['token'];
$linkid = $_POST['linkid'];

global $ch_secret_key, $ch_hasehs;

$verifyed = verify( $token, $linkid);
if(!$verifyed){
    jump("failed.html");
}else{
    $url = getLink($linkid);
    if(url==-1) {
        http_response_code(404);
        exit("404 not found");
    }
    jump( base64_decode($url));
    exit();
}
function jump($url){
    $result = array('url'=>$url);
    exit($result);
}