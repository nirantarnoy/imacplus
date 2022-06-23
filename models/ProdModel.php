<?php
function getProdmodel($code ,$connect){
    $query = "SELECT * FROM product WHERE prod_code='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['model'];
        }
    }
}
function getProductname($connect,$code){
    $query = "SELECT * FROM product WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['name'];
        }
    }else{
        return '';
    }

}
function getProductcode($connect,$code){
    $query = "SELECT * FROM product WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['code'];
        }
    }else{
        return '';
    }

}
?>
