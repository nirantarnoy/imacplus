<?php
ob_start();
session_start();

date_default_timezone_set('Asia/Bangkok');

//$host = "localhost";
//$username = "root";
//$password = "";
//$database_name = "csw";

$host = "localhost";
$username = "cp090394_root";
$password = "Cswyy6688";
$database_name = "cp090394_csw";

$date_string = time();

$cmd = '';

$os = php_uname();
if (strpos($os, 'ndow') > 0) {
    $cmd = 'D:/xampp/mysql/bin/';
    $cmd .= "mysqldump -h {$host} -u {$username} {$database_name} > " . 'uploads/db_backup/' . "pc_{$date_string}_{$database_name}.sql";

} else {
    //    $cmd ='/usr/bin/';
    $cmd = "/usr/bin/mysqldump -u {$username} -p{$password} {$database_name} > " . 'uploads/db_backup/' . "web_{$date_string}_{$database_name}.sql";
}

if (exec($cmd)) {
    $_SESSION['msg-success'] = 'สำรองข้อมูลเรียบร้อยแล้ว';
    header('location:backuplist.php');
} else {
    $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
    header('location:backuplist.php');
}


?>
