<?php
ob_start();
session_start();
include("common/dbcon.php");

$name = '';
$description = '';
$recid = 0;


if (isset($_POST['unit_name'])) {
    $name = $_POST['unit_name'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


if ($recid <= 0) {
    if ($name != '') {
        $sql = "INSERT INTO unit (name,description)
           VALUES ('$name','$description')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:unit.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:unit.php');
        }
    }

} else {
    $sql = "UPDATE unit SET name='$name',description='$description'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:unit.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:unit.php');
    }
}

?>
