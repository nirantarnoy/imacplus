<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$id = 0;
$userid = 0;
$to_member_type = 0;
$member_type_1 = 0;
$member_type_1_rate = 0;
$member_type_2 = 0;
$member_type_2_rate = 0;

$recid = 0;
$delete_id = '';
$remove_line = '';
$action = null;
$userid = 0;

//print_r($_POST);

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

if (isset($_POST['line_to_member_type'])) {
    $to_member_type = $_POST['line_to_member_type'];
}
if (isset($_POST['line_parent_1_member_type'])) {
    $member_type_1 = $_POST['line_parent_1_member_type'];
}
if (isset($_POST['line_parent_1_rate'])) {
    $member_type_1_rate = $_POST['line_parent_1_rate'];
}
if (isset($_POST['line_parent_2_member_type'])) {
    $member_type_2 = $_POST['line_parent_2_member_type'];
}
if (isset($_POST['line_parent_2_rate'])) {
    $member_type_2_rate = $_POST['line_parent_2_rate'];
}
if (isset($_POST['line_id'])) {
    $line_id = $_POST['line_id'];
}
//echo $to_member_type[0];return;

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
if (isset($_POST['remove_line_list'])) {
    $remove_line = $_POST['remove_line_list'];
}
//print_r($to_member_type);return;

if ($action == 'create') {
//    $created_at = time();
//    $created_by = $userid;
    if (count($to_member_type)) {
        for ($i = 0; $i <= count($to_member_type) - 1; $i++) {
            $sql = "INSERT INTO point_cal_standard(member_type_id,parent_type_id,parent_type_2_id)
            VALUES('$to_member_type[$i]','$member_type_1[$i]','$member_type_2[$i]')";
            if ($result = $connect->query($sql)) {
                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                header('location:pointstandard.php');
            }
        }
    }

}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if ($id > 0) {
        $sql3 = "DELETE FROM point_cal_standard";
        if ($result3 = $connect->query($sql3)) {
            if ($to_member_type != null) {
                for ($i = 0; $i <= count($to_member_type) - 1; $i++) {
                    $sql = "INSERT INTO point_cal_standard(member_type_id,parent_type_id,parent_type_2_id)
            VALUES('$to_member_type[$i]','$member_type_1[$i]','$member_type_2[$i]')";
                    if ($result = $connect->query($sql)) {
                        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                        header('location:pointstandard.php');
                    }
                }
            }
        }
    }
}

if ($action == 'delete') {
    $remove = explode(',',$remove_line);

    if ($remove_line != null) {
        $res = 0;
        for($i=0;$i<=count($remove)-1;$i++){
            $sql3 = "DELETE FROM point_cal_standard WHERE id='$remove[$i]'";
            if($result3 = $connect->query($sql3)){
                $res +=1;
            }
        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:pointstandard.php');
        } else {
            echo "no";
            return;
        }
    }
}


?>
