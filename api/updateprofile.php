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
include("../models/WitdrawModel.php");


$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    $user_data = [];

    $member_id = '';
    $phone = '';
    $email = '';


    $jsonReqUrl = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];
    $phone = $reqjsonDecode['phone'];
    $email = $reqjsonDecode['email'];
    //  echo  $reqjsonDecode['username'];
//   print_r($reqjsonDecode);


    if ($member_id != '') {

//        $sql2 = "UPDATE member SET member_type_id=5,check_name='$chk_name',description='$description',status='$status',updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";
//        if ($result2 = $connect->query($sql2)) {
//            array_push($user_data,[
//                'status'=>'success',
//                'new_member_type_id'=>1,
//                'new_member_type_name'=>'',
//                ]);
//        }
        $c_date = date('Y-m-d H:i:s');
        $created_at = time();
        $sql = "UPDATE member SET phone_number='$phone', email='$email' WHERE id='$member_id'";

        if ($result = $connect->query($sql)) {

            array_push($user_data, ['status' => 'success']);

        } else {
            array_push($user_data, ['status' => 'fail']);
        }

    }
    echo json_encode($user_data);
}
