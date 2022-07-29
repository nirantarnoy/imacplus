<?php
include("common/dbcon.php");
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

function getSaleDataupdate($id, $connect)
{
    $data = [];
    $query = "SELECT * FROM orders WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data, [
            'id' => $row['id'],
            'order_no' => $row['order_no'],
            'order_date' => $row['order_date'],
            'customer_id' => $row['customer_id'],
            'status' => $row['status'],
            'emp_person' => $row['emp_person'],
            'emp_helper' => $row['emp_helper'],
        ]);
    }

    return $data;
}

function getSaleDataupdateline($id, $connect)
{
    $data = [];
    $query = "SELECT * FROM order_line WHERE order_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data, [
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'qty' => $row['qty'],
            'price' => $row['price'],
            'line_total' => $row['line_total'],
            'disc_per' => $row['disc_per'],
            'disc_amount' => $row['disc_amount'],
            'promotion_id' => $row['promotion_id'],
//            'status' => $row['status'],


        ]);
    }

    return $data;
}

?>
