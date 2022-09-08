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
$member_type_2_rate =  0;

$recid = 0;
$delete_id = '';
$remove_line = '';
$action = null;
$userid = 0;

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
//if (isset($_POST['facebook'])) {
//    $facebook = $_POST['facebook'];
//}
//if (isset($_POST['cust_address'])) {
//    $cus_address = $_POST['cust_address'];
//}
//if (isset($_POST['cust_description'])) {
//    $cus_description = $_POST['cust_description'];
//}
//if (isset($_POST['cust_note'])) {
//    $cus_note = $_POST['cust_note'];
//}
//if (isset($_POST['customer_group_id'])) {
//    $cus_group_id = $_POST['customer_group_id'];
//}


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
    if(count($to_member_type)){
        for($i=0;$i<=count($to_member_type)-1;$i++){
            $sql = "INSERT INTO upgrade_standard(member_type_id,parent_1,parent_1_rate,parent_2,parent_2_rate)
            VALUES('$to_member_type[$i]','$member_type_1[$i]','$member_type_1_rate[$i]','$member_type_2[$i]','$member_type_2_rate[$i]')";
            if ($result = $connect->query($sql)) {
                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                header('location:upgradestandard.php');
            }
        }
    }
//    $sql = "INSERT INTO upgrade_standard(member_type_id,parent_1,parent_1_rate,parent_2,parent_2_rate)
//            VALUES('$to_member_type','$member_type_1','$member_type_1_rate','$member_type_2','$member_type_2_rate')";
//    if ($result = $connect->query($sql)) {
//        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
//        header('location:upgradestandard.php');
//    }
}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if($id > 0){
//        echo $status;return;
//        $created_at = time();
//        $created_by = $userid;
        if(count($to_member_type)){
            for($i=0;$i<=count($to_member_type)-1;$i++){
                $sql2 = "UPDATE upgrade_standard SET member_type_id='$to_member_type[$i]',parent_1='$member_type_1[$i]',parent_1_rate='$member_type_1_rate[$i]',parent_2='$member_type_2[$i]',parent_2_rate='$member_type_2_rate[$i]' WHERE id='$id'";
                if ($result2 = $connect->query($sql2)) {
                    $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                    header('location:upgradestandard.php');
                }else{
                    echo "no";return;
                }
            }
        }
//        $sql2 = "UPDATE upgrade_standard SET member_type_id='$to_member_type[$i]',parent_1='$member_type_1[$i]',parent_1_rate='$member_type_1_rate[$i]',parent_2='$member_type_2[$i]',parent_2_rate='$member_type_2_rate[$i]' WHERE id='$id'";
//        if ($result2 = $connect->query($sql2)) {
//            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
//            header('location:upgradestandard.php');
//        }else{
//            echo "no";return;
//        }
    }
}

if($action == 'delete'){
    if($remove_line > 0){
        $sql3 = "DELETE FROM upgrade_standard WHERE id='$remove_line'";
        if ($result3 = $connect->query($sql3)) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:upgradestandard.php');
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
