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

$requestMethod = $_SERVER["REQUEST_METHOD"];
//
////ตรวจสอบหากใช้ Method GET
//if($requestMethod == 'GET'){
//    //ตรวจสอบการส่งค่า id
//    if(isset($_GET['id']) && !empty($_GET['id'])){
//
//        $id = $_GET['id'];
//
//        //คำสั่ง SQL กรณี มีการส่งค่า id มาให้แสดงเฉพาะข้อมูลของ id นั้น
//        $sql = "SELECT * FROM employees WHERE id = $id";
//
//    }else{
//        //คำสั่ง SQL แสดงข้อมูลทั้งหมด
//        $sql = "SELECT * FROM employees";
//    }
//
//    $result = mysqli_query($link, $sql);
//
//    //สร้างตัวแปร array สำหรับเก็บข้อมูลที่ได้
//    $arr = array();
//
//    while ($row = mysqli_fetch_assoc($result)) {
//
//        $arr[] = $row;
//    }
//
//    echo json_encode($arr);
//}

if($requestMethod == 'POST'){
    $user_data = [];

    $member_id = '';

    $jsonReqUrl  = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];


    if($member_id != ''){

            array_push($user_data, [
                'member_id' => $member_id,
                'member_name' => getMembername($connect, $member_id),
                'member_type_name' => getMemberTypeName($member_id, $connect),
                'point' => getMemberPoint($connect, $member_id),
                'wallet_amount' => getMemberWalletAmount($connect, $member_id),
                'member_count' => getMemberChildCount($connect, $member_id),
                'member_url' => getMemberurl($connect, $member_id),
                'member_phone' => getMemberPhone($connect, $member_id),
                'member_email' => getMemberEmail($connect, $member_id),
                'bank_id' => getMemberBankId($connect, $member_id),
                'account_no' => getMemberAccountNo($connect, $member_id),
                'account_name' => getMemberAccountName($connect, $member_id),
            ]);


        // echo json_encode($user_data);
    }
    echo json_encode($user_data);
}
