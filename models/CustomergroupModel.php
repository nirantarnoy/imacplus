<?php
function getCustomergroupName($id,$connect){
    $query = "SELECT * FROM customer_group WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['group_name'];
        }
    }
}
function getCusgroupData($connect){

    $query = "SELECT * FROM customer_group WHERE id>0";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
        array_push($cus_data,['id'=>$row['id'],'code'=>$row['code'],'group_name'=>$row['group_name']]);
    }
    return $cus_data;

}
?>
