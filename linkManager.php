<?php
require('config.php');
//require('database_engine.php');

if($type!=null){
    try {
        $pdo = new PDO($pdo_dsn, $pdo_user, $pdo_pass);
    } catch (PDOException $e) {
        $pdo = null;
        die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
    }
    if ($pdo == null) {
        die('Could not connect to the database:<br/>Please contact server administrators.<br/>' . $e);
    }
}else{
    $pdo=null;
    exit("API error.");
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
function getID($link, $pdo)
{
    global $pdo_table;
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

/**
 * @param $link //Must base64 strings
 * @param $pdo
 * @param $pdo_table
 */
function addNewLink($link, $pdo)
{
    global $pdo_table;
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
        exit(getID($arg, $pdo));
    case 'id2link':
        exit(getLink($arg, $pdo));
    case 'addlink':
        //Check is or not based64?
        if(is_base64($arg)){
            exit(addNewLink($arg, $pdo));
        }else{
            exit("Not a base64 link\n");
        }
    default:
        exit("What? Why you not give me a type arg?\n");
}


