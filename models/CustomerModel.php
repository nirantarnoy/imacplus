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
?>
