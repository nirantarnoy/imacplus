<?php
//include("models/ProvinceModel.php");
//include("models/CityModel.php");
//include("models/DistrictModel.php");

function getCenterName($id,$connect){
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['first_name']. ' '.$row['last_name'];
        }
    }
}

function findcenteraddress($connect, $id)
{
    $address = '';
    $query = "SELECT t1.address,t1.street,t1.district_id,t1.city_id,t1.province_id,t1.zipcode FROM center_address as t1 WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $district_name = getCenterDistrictname($connect,$row['district_id']);
            $city_name = getCenterCityname($connect,$row['city_id']);
            $province_name = getCenterProvincename($connect,$row['province_id']);
            $address = $row['address'].' '.$row['street'].' อ.'.$district_name.' อ.'.$city_name.' จ.'.$province_name.' '.$row['zipcode'];
        }

    }
    return $address;
}

function getCenterDistrictname($connect,$code){
    $query = "SELECT * FROM district WHERE DISTRICT_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['DISTRICT_NAME'];
        }
    }

}
function getCenterCityname($connect,$code){
    $query = "SELECT * FROM amphur WHERE AMPHUR_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['AMPHUR_NAME'];
        }
    }

}
function getCenterProvincename($connect,$code){
    $query = "SELECT * FROM province WHERE PROVINCE_ID='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['PROVINCE_NAME'];
        }
    }

}
?>
