<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/WorkorderModel.php");
include("models/MemberModel.php");


$workorder_id = 0;
$upload_file = 0;

$userid = 0;
$member_id = 0;

if (isset($_POST['workorder_id'])) {
    $workorder_id = $_POST['workorder_id'];
}


if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

//echo $action;return;
if ($workorder_id > 0) {
    if (isset($_FILES['work_upload_file'])) {
        $name = $_FILES['work_upload_file']['name'];
        $ext = end(explode('.',$name));

        $file_tmp = $_FILES['work_upload_file']['tmp_name'];
        $filename = time()  . ".".$ext;//$_FILES['upload_file']['name'][$x];
        //echo $filename; return;
        $updated_at = time();
        $sql2 = "UPDATE workorders SET status=4 , updated_by='$userid', updated_at='$updated_at' WHERE id='$workorder_id'";
        if ($result2 = $connect->query($sql2)) {
            $sql_photo = "INSERT INTO workorder_video(workorder_id,video) VALUES ('$workorder_id','$filename')";
            if ($connect->query($sql_photo)) {
                move_uploaded_file($file_tmp, "uploads/workorder/video/" . $filename);
            }
        }
    }
}

?>

