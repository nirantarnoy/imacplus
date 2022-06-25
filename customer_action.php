<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$id = 0;
$cus_code = '';
$cus_name = '';
$phone = '';
$email = '';
$line_id = '';
$facebook = '';
$cus_address = '';
$cus_description = '';
$cus_note = '';
$cus_group_id = '';

$status = '';
$recid = 0;
$delete_id = '';
$action = null;
$userid = 0;

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

if (isset($_POST['cust_code'])) {
    $cus_code = $_POST['cust_code'];
}
if (isset($_POST['cust_name'])) {
    $cus_name = $_POST['cust_name'];
}
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['line_id'])) {
    $line_id = $_POST['line_id'];
}
if (isset($_POST['facebook'])) {
    $facebook = $_POST['facebook'];
}
if (isset($_POST['cust_address'])) {
    $cus_address = $_POST['cust_address'];
}
if (isset($_POST['cust_description'])) {
    $cus_description = $_POST['cust_description'];
}
if (isset($_POST['cust_note'])) {
    $cus_note = $_POST['cust_note'];
}
if (isset($_POST['customer_group_id'])) {
    $cus_group_id = $_POST['customer_group_id'];
}

if (isset($_POST['status'])) {
    $status = $_POST['status'];
}
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
}

if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}
//print_r($action);return;

if ($action == 'create') {
    $created_at = time();
    $created_by = $userid;
    $sql = "INSERT INTO customer(code,name,phone,email,line_id,facebook,address,description,note,customer_group_id,status,created_at,created_by)
            VALUES('$cus_code','$cus_name','$phone','$email','$line_id','$facebook','$cus_address','$cus_description','$cus_note','$cus_group_id','$status','$created_at','$created_by')";
    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:customer.php');
    }
}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if($id > 0){
//        echo $status;return;
        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE customer SET code='$cus_code',name='$cus_name',phone='$phone',email='$email',line_id='$line_id',facebook='$facebook',address='$cus_address',description='$cus_description',note='$cus_note',customer_group_id='$cus_group_id',status='$status',updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";
        if ($result2 = $connect->query($sql2)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:customer.php');
        }else{
            echo "no";return;
        }
    }
}

if($action == 'delete'){
    if($delete_id > 0){
        $sql3 = "DELETE FROM customer WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:customer.php');
        }else{
            echo "no";return;
        }
    }
}
//} else {
//    $_SESSION['msg-error'] = 'Save data error';
//    header('location:productcat.php');
//    $sql = "UPDATE product_group SET code='$code',name='$name',description='$description'";
//    $sql.=" WHERE id='$recid'";
//
//    if ($result = $connect->query($sql)) {
//        $_SESSION['msg-success'] = 'Saved data successfully';
//        header('location:productcat.php');
//    } else {
//        $_SESSION['msg-error'] = 'Save data error';
//        header('location:productcat.php');
//    }
//}

?>
