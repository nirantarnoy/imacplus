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
$model = '';
$brand_id = '';
$description = '';
$status = '';
$recid = 0;
$delete_id = '';
$action = null;
$userid = 0;

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}


if (isset($_POST['item_name'])) {
    $name = $_POST['item_name'];
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
    $filename = '';
    $file_tmp = null;
    if (isset($_FILES['upload_file'])) {

        $filename = time() + (0 + 1) . ".jpg";//$_FILES['upload_file']['name'][$x];
        //echo $filename; return;
        $file_tmp = $_FILES['upload_file']['tmp_name'];

    }
    $created_at = time();
    $created_by = $userid;
    $sql = "INSERT INTO banner(name,photo,status)
            VALUES('$name','$filename','$status')";
    if ($result = $connect->query($sql)) {
        if($filename != '' && $file_tmp != null){
            move_uploaded_file($file_tmp, "uploads/banner/" . $filename);
        }

        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:banner.php');
    }
}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if($id > 0){
//        echo $status;return;
        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE banner SET name='$name' WHERE id='$id'";
        if ($result2 = $connect->query($sql2)) {
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:banner.php');
        }else{
            echo "no";return;
        }
    }
}

if($action == 'delete'){
    if($delete_id > 0){
        $sql3 = "DELETE FROM banner WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:banner.php');
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
