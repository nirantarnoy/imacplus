<?php
ob_start();
session_start();
include "common/dbcon.php";
include "models/UserModel.php";
include "models/MemberModel.php";

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
        $member_id = getMemberFromUpgradeId($id, $connect);
        $parent_id = findCurrentParentId($connect, $member_id);

        $old_point = getOldParentPoint($connect, $parent_id);

        $new_point = ($old_point + 500);
        //  echo $new_wallet_amount;return;
//        if (updateMemberPoint($connect, $member_id, $new_point)) {
//            if (updateMemberUpgradeStatus($connect, $id)) {
//                $res += 1;
//            }
//        }
        //echo $member_id;return;
        if (updateMemberType($connect, $member_id)) {
            if (updateMemberUpgradeStatus($connect, $id)) {
                if (updateParentMemberPoint($connect, $parent_id, $new_point)) {
                    $res += 1;
                }
            }
        }


        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:memberupgradepage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:memberupgradepage.php');
        }
    } else if ($action == 'decline') {
        $res = 0;
        if (declineWallet($connect, $id)) {

            $res += 1;

        }

        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:memberupgradepage.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:memberupgradepage.php');
        }
    }
}
function getMemberFromUpgradeId($id, $connect){
    $member_id = 0;

    if ($id > 0) {
        $query = "SELECT * FROM member_upgrade WHERE id='$id'";
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
function getMemberUpgradeAmount($id, $connect){
    $amount = 0;

    if ($id > 0) {
        $query = "SELECT * FROM member_upgrade WHERE id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $amount = $row['upgrade_amount'];
            }
        }
    }
    return $amount;
}
function getOldParentPoint($connect, $parent_id)
{
    $point = 0;

    if ($parent_id > 0) {
        $query = "SELECT * FROM member WHERE id='$parent_id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $point = $row['point'];
            }
        }
    }
    return $point;
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

function updateParentMemberPoint($connect, $parentid, $new_point)
{
    $sql = "UPDATE member SET point='$new_point' WHERE id='$parentid'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function updateMemberType($connect, $member_id)
{
    $sql = "UPDATE member SET member_type_id=28 WHERE id='$member_id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function updateMemberUpgradeStatus($connect, $id)
{
    $sql = "UPDATE member_upgrade SET status=1 WHERE id='$id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

function declineWallet($connect, $id)
{
    $sql = "UPDATE member_upgrade SET status=2 WHERE id='$id'";
    if ($connect->query($sql)) {
        return 1;
    } else {
        return 0;
    }

}

?>