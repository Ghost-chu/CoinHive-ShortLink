<?php
require("config.php");
require("verifyCoinHive.php");
require("hashCalc.php");
require("linkManager.php");
$token=$_POST['coinhive-captcha-token'];
$linkid=$_POST['linkid'];

global $ch_secret_key, $ch_hashes;

$verify_stats = verify($ch_secret_key, $token, $xh_hashes, $linkid);

if($verify_stats){
$time=time();
setcookie("time", $time);
setcookie("hash", hashCalc($time));
try {
    $pdo = new PDO($pdo_dsn, $pdo_user, $pdo_pass);
} catch (PDOException $e) {
    $pdo = null;
    die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
}
if ($pdo == null) {
    die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
}
global $pdo_table;
header(getLink($id, $pdo, $pdo_table));
}




