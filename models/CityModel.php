<?php
function getCitymodel($connect){
    $data = [];
    $query = "SELECT * FROM amphur";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['AMPHUR_ID'],'name'=>$row['AMPHUR_NAME']]);
        }
    }

    return $data;
}
function getCityname($connect,$code){
    $query = "SELECT * FROM amphur WHERE AMPHUR_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['AMPHUR_NAME'];
        }
    }

}
?>
