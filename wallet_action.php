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
       // $member_id = getMemberFromUser($_SESSION['userid'], $connect);
        $member_id = getMemberWalletId($id, $connect);
        $old_wallet_amount = getOldWallet($connect, $member_id);
        $accept_wallet_amount = getAcceptWallet($connect, $id);
        $new_wallet_amount = ($old_wallet_amount + $accept_wallet_amount);
      //  echo $new_wallet_amount;return;
        if (updateMemberWallet($connect, $member_id, $new_wallet_amount)) {
            if (updateWalletStatus($connect, $id)) {
                createMemberNotify($connect, $id, $member_id);
                $res += 1;
            }
        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:walletpage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:walletpage.php');
        }
    } else if ($action == 'decline') {
        $res = 0;
        if (declineWallet($connect, $id)) {

            $res += 1;

        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:walletpage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:walletpage.php');
        }
    }
}
function getMemberWalletId($id, $connect){
    $member_id = 0;

    if ($id > 0) {
        $query = "SELECT * FROM wallet_trans WHERE id='$id'";
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
function getOldWallet($connect, $member_id)
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
                $amount = $row['wallet_amount'];
            }
        }
    }
    return $amount;
}

function getAcceptWallet($connect, $id)
{
    $amount = 0;

    if ($id > 0) {
        $query = "SELECT * FROM wallet_trans WHERE id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $amount = $row['wallet_in_amount'];
            }
        }
    }
    return $amount;
}

function updateMemberWallet($connect, $member_id, $new_wallet_amount)
{
    $sql = "UPDATE member SET wallet_amount='$new_wallet_amount' WHERE id='$member_id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function updateWalletStatus($connect, $id)
{
    $sql = "UPDATE wallet_trans SET status=1 WHERE id='$id'";
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
    $title ="แจ้งยืนยันการเติมวอลเล็ท";
    $message = "ระบบได้ตรวจสอบยอดของคุณเรียบร้อยแล้ว";
    $sql = "INSERT INTO member_notify(trans_ref_id,member_id,message_type_id,title,detail,read_status,message_date,created_at,created_by)
            VALUES('$ref_id','$member_id',2,'$title','$message',0,'$c_date','$created_at',0)";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }
}

?>