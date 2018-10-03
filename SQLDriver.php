<?php
require("config.php.example");

function getPDO(){
    global $pdo_dsn,$pdo_user,$pdo_pass;
    try {
        return new PDO($pdo_dsn, $pdo_user, $pdo_pass);
    } catch (PDOException $e) {
        return null;
    }

}

