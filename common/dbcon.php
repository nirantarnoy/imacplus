<?php
date_default_timezone_set('Asia/Bangkok');

$HOST_NAME = "localhost";
$DB_NAME = "db_all";
$CHAR_SET = "charset=utf8";
$USERNAME = "root";
$PASSWORD = "";

//$HOST_NAME = "localhost";
//$DB_NAME = "imacplus_dball";
//$CHAR_SET = "charset=utf8";
//$USERNAME = "imacplus";
//$PASSWORD = "Em1bKhkjnX";

$connect = null;

try {
    //$connect = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);
    $connect = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET, $USERNAME, $PASSWORD);
    $connect->exec("set names utf8");

    //session_start();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>
