<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
$userid = 0;
$id = 0;
$fname = '';
$lname = '';
$address = '';
$street = '';
$province = '';
$city = '';
$district = '';
$zipcode = '';
$bank_id = '';
$account_no = '';
$account_name = '';

if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}
if (isset($_POST['member_fname'])) {
    $fname = $_POST['member_fname'];
}
if (isset($_POST['member_lname'])) {
    $lname = $_POST['member_lname'];
}
if (isset($_POST['address'])) {
    $address = $_POST['address'];
}
if (isset($_POST['street'])) {
    $street = $_POST['street'];
}
if (isset($_POST['province_id'])) {
    $province = $_POST['province_id'];
}
if (isset($_POST['city_id'])) {
    $city = $_POST['city_id'];
}
if (isset($_POST['district_id'])) {
    $district = $_POST['district_id'];
}
if (isset($_POST['zipcode'])) {
    $zipcode = $_POST['zipcode'];
}
if (isset($_POST['member_account_bank_id'])) {
    $bank_id = $_POST['member_account_bank_id'];
}
if (isset($_POST['member_account_no'])) {
    $account_no = $_POST['member_account_no'];
}
if (isset($_POST['member_account_name'])) {
    $account_name = $_POST['member_account_name'];
}


//print_r($action);return;

if ($id != null || $id != '') {
    $res = 0;
    if ($fname != '' && $lname != '') {
        $created_at = time();
        $created_by = $userid;
        $sql = "UPDATE member set first_name='$fname', last_name='$lname' WHERE id='$id', is_verified=1";
        if ($result = $connect->query($sql)) {
            $res += 1;
        }
    }
    if ($bank_id != '' && $account_no != '' && $account_name != '') {
        $query = "SELECT * FROM member_account WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $id;
            $sql = "UPDATE member_account set bank_id='$bank_id', account_no='$account_no',account_name='$account_name' WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $id;
            $sql = "INSERT INTO member_account(member_id,bank_id,account_no,account_name,created_at,created_by)VALUES('$id','$bank_id','$account_no','$account_name','$created_at','$created_by')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }

    }

    if ($address != '' && $zipcode != '') {
        $query = "SELECT * FROM member_address WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $userid;
            $sql = "UPDATE member_address set address='$address', street='$street',province_id='$province',city_id='$city',district_id='$district',zipcode='$zipcode', status=1 WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $userid;
            $sql = "INSERT INTO member_address(member_id,address,street,province_id,city_id,district_id,zipcode)VALUES('$id','$address','$street','$province','$city','$district','$zipcode')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }

    }

    $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
    header('location:profile.php');
}else{
    echo "no";
}


?>
