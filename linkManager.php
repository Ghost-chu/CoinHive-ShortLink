<?php

//shortLink system core
require('config.php');
require ("SQLDriver.php");
//require('database_engine.php');

$pdo = getPDO();
if($pdo == null){
    die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
}

//Success to connect database

//Type should is: link2id id2link or addlink
$type = $_POST['type'];
$arg = $_POST['arg'];//ADD:add new shorturl GET:get xxx from xxx

//debuging

//BASE64ED

/**
 * @param $link //Must base64 strings
 * @param $pdo
 * @param $pdo_table
 * @return int
 */
function getID($link)
{
    global $pdo_table, $pdo;
    //Check exist
    $sql = 'select * from ' . $pdo_table . ' where `link`=:link';
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam("link", $link);

    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (count($row) != 0) {
        return $row[0];
    } else {
        return -1;
        //No result , Return -1
    }
}

/**
 * @param $id
 * @param $pdo
 * @param $pdo_table
 * @return int
 */
function getLink($id)
{
    global $pdo_table, $pdo;
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

/**
 * @param $link //Must base64 strings
 * @param $pdo
 * @param $pdo_table
 */
function addNewLink($link)
{
    global $pdo_table, $pdo;
    //Check exist
    $idnum = getID($link, $pdo, $pdo_table);
    if ($idnum != -1) {
        //Already exist
        exit($idnum);
    }
    //Not exist
    $sql = 'INSERT INTO `' . $pdo_table . '` (`link`,`time`) VALUES (:link,:time);';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("link", $link);
    $stmt->bindParam("time", time());
    $stmt->execute();
    $insertid = $pdo->lastInsertId();
    return $insertid;

}
function is_base64($str){
    if($str==base64_encode(base64_decode($str))){
        return true;
    }else{
        return false;
    }
}
switch ($type) {
    case 'link2id':
        exit(getID($arg));
    case 'id2link':
        exit(getLink($arg));
    case 'addlink':
        //Check is or not based64?
        if(is_base64($arg)){
            exit(addNewLink($arg));
        }else{
            exit("Not a base64 link\n");
        }
    default:

}


