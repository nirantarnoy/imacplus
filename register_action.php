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
$username = $phone;
$password = $phone;
//if (isset($_POST['username'])) {
//    $username = $_POST['username'];
//}
//if (isset($_POST['password'])) {
//    $password = $_POST['password'];
//}
if (isset($_POST['member_ref_id'])) {
    $parent_id = $_POST['member_ref_id'];
}
if (isset($_POST['url'])) {
    $url = $_POST['url'];
}


if($phone!="" && $email != ""){


    $parent_id = findParentForRegister($connect, $parent_id);
//    echo $phone;
    $bytes = openssl_random_pseudo_bytes(8);
    $member_url = 'https://www.imacplus.app/register.php?ref='. bin2hex($bytes);
    $cdate = date("Y-m-d H:i:s");
    $ctimestamp = time();
    //echo bin2hex($bytes);
    $sql_member = "INSERT INTO member(phone_number,email,url,parent_id,agree_read,agree_date,created_at)VALUES('$phone','$email','$member_url','$parent_id',1,'$cdate','$ctimestamp')";
    if ($rest = $connect->query($sql_member)) {
        $newpass = md5($email);
        $maxid = getMaxid($connect);
        $sql = "INSERT INTO user (username,password,status,member_ref_id)
           VALUES ('$email','$newpass',1,'$maxid')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
           // header('location:registersuccess.php');
            header('location:index.php');
        } else {
            $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
            header('location:loginpage.php');
        }
    }
}