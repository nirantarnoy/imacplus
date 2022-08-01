<?php
function getTranstypeName($id,$connect){
    $query = "SELECT * FROM trans_type WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['trans_name'];
        }
    }
}

function getTransTypeData($connect){

    $query = "SELECT * FROM trans_type WHERE id>0";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
        array_push($cus_data,['id'=>$row['id'],'name'=>$row['name']]);
    }
    return $cus_data;

}

function getTransactionNo($connect, $trans_ref_id, $trans_type_id, $member_id){
    $trans_no = '';
    $query = "";
    if($trans_type_id == 1){
       $query = "SELECT * FROM member_upgrade WHERE id = '$trans_ref_id' and member_id='$member_id'";
    }else if($trans_type_id == 2){
        $query = "SELECT * FROM wallet_trans WHERE id = '$trans_ref_id' and member_id='$member_id'";
    }else if($trans_type_id == 3){
        $query = "SELECT * FROM witdraw_trans WHERE id = '$trans_ref_id' and member_id='$member_id'";
    } else if($trans_type_id == 4){
        $query = "SELECT work_no as trans_no FROM workorders WHERE id = '$trans_ref_id' and created_by='$member_id'";
    }



    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
       $trans_no = $row['trans_no'];
    }
    return $trans_no;

}

?>
