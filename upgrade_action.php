<?php
ob_start();
session_start();
include "common/dbcon.php";
include "models/UserModel.php";
include "models/MemberModel.php";

$id = 0;
$action = "";
$upgrade_to_member_type = 28;

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}
//if (isset($_POST['member_type_id'])) {
//    $upgrade_to_member_type = $_POST['member_type_id'];
//}
if ($id > 0) {
    if ($action == 'accept') {
        $res = 0;
        $member_id = getMemberFromUpgradeId($id, $connect);
        $upgrade_to_member_type = getMemberUpgradetotypeId($id, $connect);

        // find parent
        $parent_id = findParent($connect, $member_id); // parent level1
        $parent_2_id = findParent($connect, $parent_id); // parent level2


//        echo 'member is '.$member_id.'<br />';
//        echo 'parent1 is '.$parent_id.'<br />';
//        echo 'update to '.$upgrade_to_member_type.'<br />';
//        $parent_rate_amount = getParentMemberTypeRate($connect,$upgrade_to_member_type,$parent_id);
//        echo 'rate for parent is '.$parent_rate_amount;
//        return;

        if (updateMemberType($connect, $member_id, $upgrade_to_member_type)) { // change to new member type
            if (updateMemberUpgradeStatus($connect, $id)) { // update member upgrade request to complete

                if ($parent_id > 0 && $parent_2_id > 0) { // cal 2 level
                    $parent_rate_amount = getParentMemberTypeRate($connect, $upgrade_to_member_type, $parent_id); // find parent rate from upgrade standard
                    if ($parent_rate_amount) {
                        if (updateParentMemberPoint($connect, $parent_id, $parent_rate_amount)) { // add mpoint for parent level 1
                            $res += 1;
                        }
                    }
                    $parent_rate_amount2 = getParentMemberTypeRate2($connect, $upgrade_to_member_type, $parent_id, $parent_2_id); // find parent rate from upgrade standard
                    if ($parent_rate_amount2) {
                        if (updateParentMemberPoint($connect, $parent_2_id, $parent_rate_amount2)) { // add mpoint for parent level 2
                            $res += 1;
                        }
                    }
                } else if ($parent_id > 0 && $parent_2_id <= 0) { // cal 1 level
                    $parent_rate_amount = getParentMemberTypeRate($connect, $upgrade_to_member_type, $parent_id); // find parent rate from upgrade standard
                    if ($parent_rate_amount) {
                        if (updateParentMemberPoint($connect, $parent_id, $parent_rate_amount)) { // add mpoint for parent
                            $res += 1;
                        }
                    }
                }
                $res += 1;
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
function getMemberFromUpgradeId($id, $connect)
{
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

function getMemberUpgradetotypeId($id, $connect)
{
    $to_type = 0;

    if ($id > 0) {
        $query = "SELECT * FROM member_upgrade WHERE id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $to_type = $row['upgrade_to_type'];
            }
        }
    }
    return $to_type;
}

function getMemberUpgradeAmount($id, $connect)
{
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

function getOldParentAllPoint($connect, $parent_id)
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
                $point = $row['all_point'];
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
    $old_point = getOldParentPoint($connect, $parentid); // balance point
    $old_all_point = getOldParentAllPoint($connect, $parentid); // all point
    $update_new_point = ($new_point + $old_point); // new balance point
    $new_all_point = ($update_new_point + $old_all_point); //new all point

    $sql = "UPDATE member SET point='$update_new_point',all_point='$new_all_point' WHERE id='$parentid'";
    if ($connect->query($sql)) {
        if(createMpointTrans($connect,$parentid,$new_point,1)){
            return 1;
        }

    } else {
        return 0;
    }

}

function createMpointTrans($connect, $parent_id, $new_point, $cal_from_type)
{
    $cdate = date('Y-m-d H:i:s');
    $res = 0;
    //cal_from_type
    // 1 = upgrade member type
    // 2 = point from workorder complete
    // 3 = member withdraw point


    $sql = "INSERT INTO point_trans(member_id,trans_date,trans_point,cal_from_type,activity_type,status)
    VALUES('$parent_id','$cdate','$new_point','$cal_from_type',1,1)";

    if ($connect->query($sql)) {
        $res += 1;
    }
    return $res;
}

function updateMemberType($connect, $member_id, $upgrade_to_member_type)
{
    $sql = "UPDATE member SET member_type_id='$upgrade_to_member_type' WHERE id='$member_id'";
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


/// upgrade cal
function findParent($connect, $member_id)
{
    $parent_id = 0;
    if ($member_id) {
        $query = "SELECT * FROM member WHERE id='$member_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $parent_id = $row['parent_id'];
        }

    }
    return $parent_id;
}

function findIntroducePercent($connect, $member_id, $member_type_id)
{
    $per = 0;
    $member_type = getMemberType($connect, $member_id);
    $query = "SELECT * FROM member_type WHERE id = '$member_type'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    //$cus_data = array();
    //$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        if ($member_type_id == $member_type)
            $per = $row['introduce_percent'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $per;
}

function getParentMemberTypeRate($connect, $member_type_id, $parent_id)
{
    $rate_amount = 0;
    $parent_type = getMemberType($connect, $parent_id);
    $query = "SELECT * FROM upgrade_standard WHERE member_type_id = '$member_type_id' and parent_1 ='$parent_type'"; // check member type and parent level 1
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    //$cus_data = array();
    //$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $rate_amount = $row['parent_1_rate'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $rate_amount;
//    return $parent_type;
}

function getParentMemberTypeRate2($connect, $member_type_id, $parent_id, $parent_2_id)
{
    $rate_amount = 0;
    $parent_type = getMemberType($connect, $parent_id);
    $parent_type_2 = getMemberType($connect, $parent_2_id);
    $query = "SELECT * FROM upgrade_standard WHERE member_type_id = '$member_type_id' and parent_1 ='$parent_type' and parent_2='$parent_type_2'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    //$cus_data = array();
    //$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $rate_amount = $row['parent_2_rate'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $rate_amount;
}

?>