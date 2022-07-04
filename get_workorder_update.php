<?php
include("common/dbcon.php");
$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM workorders WHERE id='$id' ";
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
        array_push($data,['id'=>$row['id'],
            'work_no'=>$row['work_no'],
            'work_date'=>$row['work_date'],
            'customer_name'=>$row['customer_name'],
            'phone'=>$row['phone'],
            'brand'=>$row['brand_id'],
            'models'=>$row['phone_model_id'],
            'phone_color'=>$row['phone_color_id'],
            'customer_pass'=>$row['customer_pass'],
            'estimate_price'=>$row['estimate_price'],
            'pre_pay'=>$row['pre_pay'],
            'note'=>$row['note'],
            'status'=>$row['status'],
            'check_list'=> findchecklist($row['id'],$connect),
        ]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}


function findchecklist($id, $connect){
 $data = [];
    $query = "SELECT * FROM workorder_line WHERE workorder_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data,
            ['id'=>$row['id'],
            'check_list_id'=>$row['check_list_id'],
        ]);
    }
 return $data;
}

?>
