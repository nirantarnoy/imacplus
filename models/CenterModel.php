<?php
function getCenterName($id,$connect){
    $query = "SELECT * FROM member WHERE member_type_id=13";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['first_name']. ' '.$row['last_name'];
        }
    }
}
?>
