<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$id = 0;
$code = '';
$name = '';
$description = '';
$status = '';
$cost_price = 0;
$recid = 0;
$delete_id = '';
$action = null;
$userid = 0;

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if (isset($_POST['sparepart_code'])) {
    $code = $_POST['sparepart_code'];
}
if (isset($_POST['sparepart_name'])) {
    $name = $_POST['sparepart_name'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}
if (isset($_POST['status'])) {
    $status = $_POST['status'];
}
if (isset($_POST['cost_price'])) {
    $cost_price = $_POST['cost_price'];
}
if (isset($_POST['delete_id'])) {
    $cost_price = $_POST['delete_id'];
}

if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}
//print_r($userid);return;

if ($action == 'create') {
    $created_at = time();
    $created_by = $userid;
    $sql = "INSERT INTO sparepart(part_no,part_name,description,cost_price,status,created_at,created_by)
            VALUES('$code','$name','$description','$cost_price','$status','$created_at','$created_by')";
    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:sparepart.php');
    }
}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if ($id > 0) {
//        echo $status;return;
        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE sparepart SET part_no='$code', part_name='$name',description='$description',cost_price='$cost_price',status='$status',updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";
        if ($result2 = $connect->query($sql2)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:sparepart.php');
        } else {
            echo "no";
            return;
        }
    }
}

if ($action == 'delete') {
    if ($delete_id > 0) {
        $sql3 = "DELETE FROM sparepart WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:sparepart.php');
        } else {
            echo "no";
            return;
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
