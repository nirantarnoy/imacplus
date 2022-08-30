<?php
include("common/dbcon.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM sparepart WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data,['id'=>$row['id'],'code'=>$row['part_no'],'name'=>$row['part_name'],'description'=>$row['description'],'cost_price'=>$row['cost_price'],'status'=>$row['status']]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}


?>
