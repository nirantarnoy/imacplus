<?php
ob_start();
session_start();
include "common/dbcon.php";
include "models/UserModel.php";

$id = 0;
$action = "";

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}

if ($id > 0) {
    if ($action == 'accept') {
        $res = 0;
        $member_id = getMemberIdFromWitdraw($connect, $id);

        $old_point = getOldPoint($connect, $member_id);
        $member_witdraw_point = getWitdrawPoint($connect, $id);
        $new_point = ($old_point - $member_witdraw_point);
        //  echo $new_wallet_amount;return;
        if (updateMemberPoint($connect, $member_id, $new_point)) {
            if (updateWitdrawStatus($connect, $id)) {
                createMemberNotify($connect, $id, $member_id);
                $res += 1;
            }
        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:witdrawpage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:witdrawpage.php');
        }
    } else if ($action == 'decline') {
        $res = 0;
        if (declineWallet($connect, $id)) {

            $res += 1;

        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:witdrawpage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:witdrawpage.php');
        }
    }
}
function getOldPoint($connect, $member_id)
{
    $amount = 0;

    if ($member_id > 0) {
        $query = "SELECT * FROM member WHERE id='$member_id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $amount = $row['point'];
            }
        }
    }
    return $amount;
}
function getMemberIdFromWitdraw($connect, $id)
{
    $member_id = 0;

    if ($id > 0) {
        $query = "SELECT * FROM witdraw_trans WHERE id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $member_id = $row['member_id'];
            }
        }
    }
    return $member_id;
}
function getWitdrawPoint($connect, $id)
{
    $amount = 0;

    if ($id > 0) {
        $query = "SELECT * FROM witdraw_trans WHERE id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $amount = $row['witdraw_amount'];
            }
        }
    }
    return $amount;
}

function updateMemberPoint($connect, $member_id, $new_point)
{
    $sql = "UPDATE member SET point='$new_point' WHERE id='$member_id'";
    if ($connect->query($sql)) {
        if(createMpointOutTrans($connect,$member_id,$new_point, 3)){
            return 1;
        }

    } else {
        return 0;
    }

}
function createMpointOutTrans($connect, $parent_id, $new_point, $cal_from_type)
{
    $cdate = date('Y-m-d H:i:s');
    $res = 0;
    //cal_from_type
    // 1 = upgrade member type
    // 2 = point from workorder complete
    // 3 = member withdraw point

    $sql = "INSERT INTO point_trans(member_id,trans_date,trans_point,cal_from_type,activity_type,status)
    VALUES('$parent_id','$cdate','$new_point','$cal_from_type',2,1)";

    if ($connect->query($sql)) {
        $res += 1;
    }
    return $res;
}
function updateWitdrawStatus($connect, $id)
{
    $sql = "UPDATE witdraw_trans SET status=1 WHERE id='$id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function declineWallet($connect, $id)
{
    $sql = "UPDATE wallet_trans SET status=2 WHERE id='$id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function createMemberNotify($connect, $ref_id ,$member_id){
    $c_date = date('Y-m-d H:i:s');
    $created_at = time();
    $title ="แจ้งการโอนถอน mPoint";
    $message = "ระบบได้ทำการถอน mPoint ให้คุณเรียบร้อยแล้ว";
    $sql = "INSERT INTO member_notify(trans_ref_id,member_id,message_type_id,title,detail,read_status,message_date,created_at,created_by)
            VALUES('$ref_id','$member_id',3,'$title','$message',0,'$c_date','$created_at',0)";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }
}

?>