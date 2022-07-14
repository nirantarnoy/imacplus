<?php
function getMemberCountAll($connect){
    $query = "SELECT * FROM member";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountAll($connect){
    $query = "SELECT * FROM workorders";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountComplete($connect){
    $query = "SELECT * FROM workorders WHERE status = 100";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
?>
