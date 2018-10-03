<?php
require('config.php');

$lock = fopen("setup.lock", "r") or install();
fclose($lock);
exit ("Why you setup twice?");


function install()
{
    $lockf = fopen("setup.lock", "w") or install();
    global $pdo_table, $pdo_stats_table, $lock, $pdo_dsn, $pdo_user, $pdo_pass;
    try {
        $pdo = new PDO($pdo_dsn, $pdo_user, $pdo_pass);
    } catch (PDOException $e) {
        die('Could not connect to the database:<br/>Setup failed.<br/>' . $e);
    }
    $sql = "CREATE TABLE `" . $pdo_table . "`. ( `id` INT NOT NULL AUTO_INCREMENT , `link` TEXT(65535) NOT NULL , `time` INT NOT NULL , `ip` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
//$sql2 = "CREATE TABLE `".$pdo_cookies_table."`. ( `id` INT NOT NULL AUTO_INCREMENT , `cookies` TEXT(65535) NOT NULL , `time` INT NOT NULL , `ip` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    $sql2 = "CREATE TABLE `" . $pdo_stats_table . "`. ( `linkid` INT NOT NULL AUTO_INCREMENT , `total` BIGINT NOT NULL , PRIMARY KEY (`linkid`)) ENGINE = InnoDB;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stmt = $pdo->prepare($sql2);
    $stmt->execute();

    $stmt->
    fclose($lockf);
    exit ("Executed! Check your database to confirm install yes or not successfully");
}




