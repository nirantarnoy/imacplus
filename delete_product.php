<?php
ob_start();
session_start();
include("common/dbcon.php");

$id = 0;

if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
}

if($id > 0){
    $sql = "DELETE FROM product WHERE id=".$id;
    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Deleted data successfully';
        header('location:product.php');
    } else {
        $_SESSION['msg-error'] = 'Delete data error';
        header('location:product.php');
    }
}else{
    echo $id;return;
    $_SESSION['msg-error'] = 'Delete data error';
    header('location:product.php');
}


?>
