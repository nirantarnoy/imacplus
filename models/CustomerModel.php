<?php
    function getCustomermodel($connect){
        $data = [];
        $query = "SELECT * FROM customer";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if($filtered_rows > 0){
            foreach($result as $row){
                array_push($data,['id'=>$row['id'],'name'=>$row['name']]);
            }
        }

        return $data;
    }

function getCustomername($connect, $code)
{
    $query = "SELECT * FROM customer WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['name'];
        }
    } else {
        return '';
    }

}
function getCustomeraddress($connect,$code){
    $query = "SELECT * FROM customer WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['address'];
        }
    }else{
        return '';
    }

}
function getCustomerDataupdate($id,$connect){
    $data = [];
    $query = "SELECT * FROM customer WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        array_push($data,[
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

    return $data;
}
?>
