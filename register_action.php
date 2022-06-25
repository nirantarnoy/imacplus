<?php
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/MemberModel.php");

$phone = "";
$email = "";
$username = "";
$password = "";
$parent_id = "";
$url = "";

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['parent_id'])) {
    $parent_id = $_POST['parent_id'];
}
if (isset($_POST['url'])) {
    $url = $_POST['url'];
}


if($phone!="" && $email != "" && $username !="" && $password != ""){

//    echo $phone;
    $sql_member = "INSERT INTO member(phone_number,email,url)VALUES('$phone','$email','$url')";
    if ($rest = $connect->query($sql_member)) {
        $newpass = md5($password);
        $maxid = getMaxid($connect);
        $sql = "INSERT INTO user (username,password,status,member_ref_id)
           VALUES ('$username','$newpass',1,'$maxid')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:registersuccess.php');
        } else {
            $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
            header('location:loginpage.php');
        }
    }
}