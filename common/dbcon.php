<?php
//$HOST_NAME = "163.44.198.63";
//$DB_NAME = "cp090394_csw";
//$CHAR_SET = "charset=utf8";
//$USERNAME = "cp090394_root";
//$PASSWORD = "Cswyy6688";

$HOST_NAME = "localhost";
$DB_NAME = "db_all";
$CHAR_SET = "charset=utf8";
$USERNAME = "root";
$PASSWORD = "";

$connect = null;

try {
    $connect = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);
    //session_start();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>
