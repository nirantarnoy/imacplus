<?php
function getDistrictmodel($connect){
    $data = [];
    $query = "SELECT * FROM district";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['DISTRICT_ID'],'name'=>$row['DISTRICT_NAME']]);
        }
    }

    return $data;
}
function getDistrictname($connect,$code){
    $query = "SELECT * FROM district WHERE DISTRICT_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['DISTRICT_NAME'];
        }
    }

}
?>
