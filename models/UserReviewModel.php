<?php
function getUserReviewmodel($connect){
    $data = [];
    $query = "SELECT * FROM user_review";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],'name'=>$row['name'],'photo'=>$row['photo']]);
        }
    }

    return $data;
}

?>
