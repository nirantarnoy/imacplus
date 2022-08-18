<?php
include("common/dbcon.php");
$newpwd = md5('vrsak17@gmail.com');
$sql = "UPDATE user set password='$newpwd' WHERE username='vrsak17@gmail.com'";
if ($result = $connect->query($sql)) {
 echo 'Ok';
}
?>