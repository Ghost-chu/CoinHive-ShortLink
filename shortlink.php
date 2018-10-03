<?php
require('showCaptcha.php');
require('config.php');
$id = $_GET['id'];
$uuid = $_COOKIE['uuid'];
$time = $_COOKIE['time'];
$id = '1';
//First check user have uuid or timestamp
$showCaptcha=false;
if($uuid==null){
    $showCaptcha=true;
}
if($time==null){
    $showCaptcha=true;
}
try {
    $pdo = new PDO($pdo_dsn, $pdo_user, $pdo_pass);
} catch (PDOException $e) {
    die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
}
if ($pdo == null) {
    die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
}
function getLink($id, $pdo)
{
    global $pdo_table;
    $sql = 'select * from ' . $pdo_table . ' where `id`=:id';
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam("id", $id);

    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);

    if (count($row) != 0) {
        return $row[0];
    } else {
        return -1;
        //No result , Return -1
    }
}
if($showCaptcha) {
    showCaptcha($id);
    exit();
}
header(getLink($id, $pdo));

