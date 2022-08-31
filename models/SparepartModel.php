<?php
function getSparepartTypemodel($connect){
    $data = [];
    $query = "SELECT * FROM sparepart";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],'name'=>$row['name'].' '.$row['description']]);
        }
    }

    return $data;
}
function getSparepartname($connect,$code){
    $query = "SELECT * FROM sparepart WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['part_name'];
        }
    }

}

function getSparepartData($connect){
    $data = [];
    $query = "SELECT * FROM sparepart";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],'name'=>$row['name']]);
        }
    }

    return $data;
}

?>
