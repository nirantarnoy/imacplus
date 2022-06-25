<?php
include("common/dbcon.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM customer WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//       array_push($data,['id'=>$row['id'],'display_name'=>$row['display_name'],'username'=>$row['username'],'status'=>$row['status'],'use_start'=>$row['use_start'],'use_end'=>$row['use_end'],
//           'branch_price'=>$row['branch_price'],'is_dash'=>$row['is_dashboard'],'is_prod'=>$row['is_product']
//           ,'is_return'=>$row['is_return'],'is_history'=>$row['is_history'],'is_customer'=>$row['is_customer']
//           ,'is_tool'=>$row['is_tool'],'is_user'=>$row['is_user'],'is_all'=>$row['is_all']]);
//    }
    foreach ($result as $row) {
        array_push($data,
            [
                'id'=>$row['id'],
                'code'=>$row['code'],
                'name'=>$row['name'],
                'phone'=>$row['phone'],
                'email'=>$row['email'],
                'status'=>$row['status'],
                'customer_group_id'=>$row['customer_group_id'],
                'line_id'=> str_replace("/","'",$row['line_id']),
                'facebook'=>str_replace("/","'",$row['facebook']),
                'description'=>str_replace("/","'",$row['description']),
                'note'=>str_replace("/","'",$row['note']),
                'address'=> str_replace("/","'",$row['address']),
            ]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}


?>
