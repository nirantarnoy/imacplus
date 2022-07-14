<?php
function getMembertypeName($id,$connect){
    $query = "SELECT * FROM member_type WHERE id='$id'";
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
function getMemberTypeData($connect){

    $query = "SELECT * FROM member_type WHERE id>0";
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
function getMemberTypeByTypeId($connect, $type_id){

    $query = "SELECT * FROM member_type WHERE platform_type_id = '$type_id'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
        array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $cus_data;

}

?>
