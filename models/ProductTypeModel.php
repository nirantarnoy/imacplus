<?php
function getTypemodel($connect){
    $data = [];
    $query = "SELECT * FROM product_cat";
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
function getTypename($connect,$code){
    $query = "SELECT * FROM product_cat WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'].' '.$row['description'];
        }
    }

}
?>
