<?php
function getItemName($id,$connect){
    $query = "SELECT * FROM item WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'];
        }
    }
}
function getItemData($connect){

    $query = "SELECT * FROM item WHERE id>0";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
        array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'cal_price'=>$row['sale_price']]);
    }
    return $cus_data;

}

function getSparepartItemData($connect){

    $query = "SELECT * FROM sparepart_type WHERE id>0 ORDER BY id";
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
function getDeviceTypeDataModel($connect){
    $cus_data = array();
    $query = "SELECT * FROM device_type";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($cus_data,['id'=>$row['id'],'name'=>$row['name']]);
        }
    }
    return  $cus_data ;
}
function getDeviceTypeName($id,$connect){
    $query = "SELECT * FROM device_type WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'];
        }
    }
}

function getItemBrandName($id,$connect){
    $query = "SELECT * FROM item_brand WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'];
        }
    }
}
?>
