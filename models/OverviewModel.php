<?php
function getMemberCountAll($connect, $member_id){
    $query = "SELECT * FROM member WHERE parent_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountAll($connect, $member_id){
    $query = "SELECT * FROM workorders WHERE created_by='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountComplete($connect, $member_id){
    $query = "SELECT * FROM workorders WHERE created_by='$member_id' AND status = 100";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}

function getMemberCountAllAdmin($connect){
    $query = "SELECT * FROM member";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountAllAdmin($connect){
    $query = "SELECT * FROM workorders";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
function getWorkCountCompleteAdmin($connect){
    $query = "SELECT * FROM workorders WHERE status = 100";
    $statement = $connect->prepare($query);
    $statement->execute();
    $filtered_rows = $statement->rowCount();


    return $filtered_rows;
}
?>
