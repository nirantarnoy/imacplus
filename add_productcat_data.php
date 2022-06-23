<?php
ob_start();
session_start();
include("common/dbcon.php");

$code = '';
$name = '';
$description = '';
$recid = 0;

if (isset($_POST['cat_code'])) {
    $code = $_POST['cat_code'];
}
if (isset($_POST['cat_name'])) {
    $name = $_POST['cat_name'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

if ($recid <= 0) {
    if ($name != '') {
        $sql = "INSERT INTO product_group (code,name,description)
           VALUES ('$code','$name','$description')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:productcat.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:productcat.php');
        }
    }

} else {
    $_SESSION['msg-error'] = 'Save data error';
    header('location:productcat.php');
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
}

?>
