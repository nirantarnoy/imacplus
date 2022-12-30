<?php
//include("common/dbcon.php");
//include("models/WorkorderModel.php");

$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

//if ($id) {
//    $query = "SELECT * FROM positions WHERE id='$id' ";
//    $statement = $connect->prepare($query);
//    $statement->execute();
//    $result = $statement->fetchAll();
//
//    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//        array_push($data,['id'=>$row['id'],'name'=>$row['name'],'description'=>$row['description'], 'status'=>$row['status']]);
//    }
//
//    echo json_encode($data);
//}else{
//    echo json_encode($data);
//}

function getQuotationDataupdate($id, $connect)
{
    $data = [];
    $query = "SELECT * FROM quotation WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data, [
            'id' => $row['id'],
            'quotation_no' => $row['quotation_no'],
            'quotation_date' => $row['quotation_date'],
            'customer_id' => $row['customer_id'],
            'customer_name' => $row['customer_name'],
            'status' => $row['status'],
            'workorder_id' => $row['workorder_id'],
//            'workorder_no' =>getOrderNobyId($connect,$row['workorder_id']),
        ]);
    }

    return $data;
}

function getQuotationDataupdateline($id, $connect)
{
    $data = [];
    $query = "SELECT * FROM quotation_line WHERE quotation_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data, [
            'id' => $row['id'],
            'quotation_id' => $row['quotation_id'],
            'item_id' => $row['item_id'],
            'item_name' => $row['item_name'],
            'qty' => $row['qty'],
            'price' => $row['price'],
            'line_total' => $row['line_total'],
            'item_type_name' => findTypedata($connect, $row['item_id']),
//            'status' => $row['status'],
        ]);
    }

    return $data;
}

function findTypedata($connect, $id)
{
    $name = '';
    $query = "SELECT * FROM sparepart WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $name = findtypeName($connect, $row['part_type_id']);
        }
    }
    return $name;
}

function findtypeName($connect, $id)
{
    $name = '';
    $query = "SELECT * FROM sparepart_type WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $name = $row['name'];
        }
    }
    return $name;
}

?>
