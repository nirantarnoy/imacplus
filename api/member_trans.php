<?php
//กำหนดค่า Access-Control-Allow-Origin ให้ เครื่อง อื่น ๆ สามารถเรียกใช้งานหน้านี้ได้
header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

////ตั้งค่าการเชื่อมต่อฐานข้อมูล
//$link = mysqli_connect('localhost', 'root', '123456', 'users_database');
//
//mysqli_set_charset($link, 'utf8');
//
include("../common/dbcon.php");
include("../models/UserModel.php");
include("../models/MemberModel.php");
include("../models/MemberTypeModel.php");
include("../models/TransTypeModel.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'POST'){
    $trans_data = [];

    $member_id = '';

    $jsonReqUrl  = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];

    if($member_id != '' ){

        $query = "SELECT * FROM transactions WHERE created_by='$member_id' order by id desc ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if($filtered_rows > 0){
            foreach($result as $row){
               array_push($trans_data,[
                   'id'=> $row['id'],
                   'trans_date'=> date('Y-m-d H:i:s', strtotime($row['trans_date'])),
                   'trans_type'=> $row['trans_type'],
                   'trans_type_name'=> getTransTypeName($row['trans_type'], $connect),
                   'trans_ref_id'=> $row['trans_ref_id'],
                   'trans_ref_no'=> getTransactionNo($connect,$row['trans_ref_id'],$row['trans_type'],$row['created_by']),
                   'trans_amount'=> $row['amount'],
                   'trans_status'=> $row['status'],

               ]);
            }
        }
    }
    echo json_encode($trans_data);
}
