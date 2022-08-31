<?php
function calmpoint($connect, $work_id)
{
    $member_id = 0;
    if ($work_id) {

        $member_id = findMember($connect, $work_id);
        $percent_rate = findStandardPer($connect, $member_id);
        $totalamount = looptrans($connect, $work_id);
        $oldpoint = findMemberPoint($connect, $member_id);

        $new_point = 0;
        if($totalamount > 0 && $percent_rate > 0){
            $x = ($totalamount * $percent_rate)/100;
            $new_point = ($oldpoint + $x);
        }

       // return $new_point;//

        if($new_point > 0){
            $sql = "UPDATE member SET point='$new_point' WHERE id='$member_id'";
            if ($connect->query($sql)) {
                return 1;
            } else {
                return 0;
            }
        }else{
            return 0;
        }

    }else{
        return 0;
    }
}
function calmpointtrans($connect, $work_id)
{
    $member_id = 0;
    $point = 0;
    if ($work_id) {

        $member_id = findMember($connect, $work_id);
        $percent_rate = findStandardPer($connect, $member_id);
        $totalamount = looptrans($connect, $work_id);
       // $oldpoint = findMemberPoint($connect, $member_id);

        $new_point = 0;
        if($totalamount > 0 && $percent_rate > 0){
            $x = ($totalamount * $percent_rate)/100;
            $point = ($x);
        }

    }
    return $point;
}

function findMember($connect, $work_id)
{
    $member_id = 0;
    if ($work_id) {
        $query = "SELECT * FROM workorders WHERE id='$work_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $member_id = $row['created_by'];
        }

    }
    return $member_id;
}

function findMemberPoint($connect, $member_id)
{
    $point = 0;
    if ($member_id) {
        $query = "SELECT * FROM member WHERE id='$member_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $point = $row['point'];
        }

    }
    return $point;
}

function updateMemberPoint($connect, $member_id, $point)
{
    if ($member_id && $point > 0) {
        $sql = "UPDATE member SET point='$point' WHERE id='$member_id'";
        if ($connect->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function findStandardPer($connect, $member_id)
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
        $per = $row['percent_rate'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $per;
}

function looptrans($connect, $work_id)
{
    $amount_cal = 0;
    if ($work_id) {
        $query = "SELECT t2.item_id FROM quotation as t1 INNER JOIN quotation_line as t2 ON t1.id = t2.quotation_id WHERE t1.workorder_id = '$work_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
             $findcalprice = findItemSalePrice($connect,$row['item_id']);
             $amount_cal = ($amount_cal + $findcalprice);
        }
    }
    return $amount_cal;
}

function findItemSalePrice($connect, $itemid)
{
    $price = 0;
    if ($itemid) {
        $query = "SELECT * FROM item WHERE id='$itemid'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $price = $row['sale_price'];
        }

    }
    return $price;
}

?>