<?php
ob_start();
session_start();
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
if (isset($_POST['pin_pass'])) {
    $password = $_POST['pin_pass'];
}
if (isset($_POST['member_ref_id'])) {
    $parent_id = $_POST['member_ref_id'];
}
if (isset($_POST['url'])) {
    $url = $_POST['url'];
}




if($phone!="" && $email != ""){
     $duplicate_member = checkDuplicateMember($connect, $email,$phone);
    if($duplicate_member > 0){
        $_SESSION['msg_register_err'] = 'เบอร์โทรหรืออีเมล์มีในระบบแล้ว';
        header("location:loginpage.php");
    }else{

        // $parent_id = findParentForRegister($connect, $parent_id);
//    echo $phone;
        $bytes = openssl_random_pseudo_bytes(8);
        $member_url = 'https://www.imacplus.app/loginpage.php?ref='. bin2hex($bytes);
        $cdate = date("Y-m-d H:i:s");
        $ctimestamp = time();
        //echo bin2hex($bytes);
        $sql_member = "INSERT INTO member(phone_number,email,url,parent_id,agree_read,agree_date,created_at,member_type_id,status)VALUES('$phone','$email','$member_url','$parent_id',1,'$cdate','$ctimestamp',30,2)";
        if ($rest = $connect->query($sql_member)) {
            $newpass = md5($password);
            $maxid = getMaxid($connect);
            $sql = "INSERT INTO user (username,password,status,member_ref_id)
           VALUES ('$email','$newpass',1,'$maxid')";

            if ($connect->query($sql)) {
//                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
//                // header('location:registersuccess.php');
//                header('location:index.php');
                //$newpass = md5($newpass);
//                $query = "SELECT * FROM user WHERE username='$email' AND password='$newpass'";
//                $statement = $connect->prepare($query);
//                $statement->execute();
//                $result = $statement->fetchAll();
//                $filtered_rows = $statement->rowCount();
//                if ($filtered_rows > 0) {
//
//                    foreach ($result as $row) {
//                        $_SESSION['userid'] = $row['id'];
//                       // echo $_SESSION['userid'];return;
//                        if (!empty($_POST["remember"])) {
//                            setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
//                        } else {
//                            if (isset($_COOKIE["member_login"])) {
//                                setcookie("member_login", "");
//                            }
//                        }
//                    }
//                    // if(checktime($_SESSION['userid'] , $connect)){
//                    if(isset($_SESSION['userid'])){
//                       // echo "OKKsdsK".$_SESSION['userid'];return;
//                        header('location: profile.php');
//                    }else{
//                        header("location:loginpage.php");
//                    }
//
//                    // }else{
//                    //   $_SESSION['msg_err'] = 'ไม่ได้อยู่ในเวลาทำการ';
//                    //    header("location:loginpage.php");
//                    //}
//                } else {
//                    $_SESSION['msg_err'] = 'Usernam หรือ Password ไม่ถูกต้อง';
//                    header("location:loginpage.php");
//                }

                $query = "SELECT * FROM user WHERE member_ref_id='$maxid' AND password='$newpass'";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $filtered_rows = $statement->rowCount();
                if ($filtered_rows > 0) {
                    foreach ($result as $row) {
                        $_SESSION['userid'] = $row['id'];

                        if (!empty($_POST["remember"])) {
                            setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
                        } else {
                            if (isset($_COOKIE["member_login"])) {
                                setcookie("member_login", "");
                            }
                            $_SESSION['start'] = time();
                            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60); // expired after 30 minutes
                        }
                    }
                    // if(checktime($_SESSION['userid'] , $connect)){
                    header('location: profile.php');
                    // }else{
                    //   $_SESSION['msg_err'] = 'ไม่ได้อยู่ในเวลาทำการ';
                    //    header("location:loginpage.php");
                    //}
                } else {
                    //   echo "no";return;
                    $_SESSION['msg_err'] = 'เบอร์โทรศัพท์ หรือ Password ไม่ถูกต้อง';
                    header("location:loginpage.php");
                }
            } else {
                $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
                header('location:loginpage.php');
            }
        }
    }

}