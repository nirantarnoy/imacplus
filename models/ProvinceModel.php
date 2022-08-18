<?php
function getProvincemodel($connect){
    $data = [];
    $query = "SELECT * FROM province";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['PROVINCE_ID'],'name'=>$row['PROVINCE_NAME']]);
        }
    }

    return $data;
}
function getProvincename($connect,$code){
    $query = "SELECT * FROM province WHERE PROVINCE_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['PROVINCE_NAME'];
        }
    }

}
?>
