<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

$username = '';
$password = '';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}


if ($username != '' && $password != '') {
    $newpass = md5($password);
    $memeber_id = checkPhone($connect, $username); // send phone check user
  //  echo $memeber_id;return;
    if($memeber_id){
      //  $query = "SELECT * FROM user WHERE username='$username' AND password='$newpass'";
        $query = "SELECT * FROM user WHERE member_ref_id='$memeber_id' AND password='$newpass'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $_SESSION['userid'] = $row['id'];

               // echo $_SESSION['userid'];return;

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
    }else {
        //   echo "no";return;
        $_SESSION['msg_err'] = 'เบอร์โทรศัพท์ หรือ Password ไม่ถูกต้อง';
        header("location:loginpage.php");
    }


} else {

    $_SESSION['msg_err'] = 'กรุณากรอกข้อมูลให้ครบ';
    header("location:loginpage.php");
}

function checkPhone($connect, $phone)
{
    $member_id = 0;
    $query = "SELECT * FROM member WHERE phone_number='$phone'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $member_id = $row['id'];
        }
    }
    //return $query;
    return $member_id;
}

function checktime($uid, $connect)
{

    $query = "SELECT * FROM user WHERE id='$uid'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $c_time = date('H:i');
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $start = $row['use_start'];
            $end = $row['use_end'];

            if (($c_time >= $start) && ($c_time <= $end)) {
                return true;
            } else {
                return false;
            }

        }
    } else {
        return false;
    }
}

?>
