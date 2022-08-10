<?php
function getChecklistmodel($connect){
    $data = [];
    $query = "SELECT * FROM check_list";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
            foreach($result as $row){
                array_push($data,['id'=>$row['id'],'name'=>$row['check_name']]);
            }
    }
    return $data;
}
function getChecklistname($connect,$code){
    $query = "SELECT * FROM check_list WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['check_name'];
        }
    }else{
        return '';
    }

}
//function getProductcode($connect,$code){
//    $query = "SELECT * FROM product WHERE id='$code'";
//    $statement = $connect->prepare($query);
//    $statement->execute();
//    $result = $statement->fetchAll();
//    $filtered_rows = $statement->rowCount();
//    if($filtered_rows > 0){
//        foreach($result as $row){
//            return $row['code'];
//        }
//    }else{
//        return '';
//    }
//
//}
?>
