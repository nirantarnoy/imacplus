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
include("../models/MemberUpgradeModel.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'POST'){
    $user_data = [];

    $member_id = '';
    $amount = '';
    $slip = '';


    $jsonReqUrl  = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];
    $amount = $reqjsonDecode['amount'];
    $slip = $reqjsonDecode['slip'];
    //  echo  $reqjsonDecode['username'];
//   print_r($reqjsonDecode);


    if($member_id != '' && $slip != ''){

//        $sql2 = "UPDATE member SET member_type_id=5,check_name='$chk_name',description='$description',status='$status',updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";
//        if ($result2 = $connect->query($sql2)) {
//            array_push($user_data,[
//                'status'=>'success',
//                'new_member_type_id'=>1,
//                'new_member_type_name'=>'',
//                ]);
//        }

        $newfile = time() . ".jpg";
        $outputfile = '../uploads/memberupgrade/' . $newfile;          //save as image.jpg in uploads/ folder

        $filehandler = fopen($outputfile, 'wb');
        //file open with "w" mode treat as text file
        //file open with "wb" mode treat as binary file

        fwrite($filehandler, base64_decode(trim($slip)));
        // we could add validation here with ensuring count($data)>1

        // clean up the file resource
        fclose($filehandler);
        // file_put_contents($newfile,base64_decode($base64_string));
        // $newfile = base64_decode($base64_string);

        $c_date = date('Y-m-d H:i:s');
        $created_at = time();
        $get_lastno = getMemberUpgradeLastNo($connect);
        $sql = "INSERT INTO member_upgrade (trans_no,trans_date,member_id,upgrade_amount,upgrade_to_type,transfer_doc,created_at,created_by,status)
           VALUES ('$get_lastno','$c_date','$member_id','$amount',0,'$newfile','$created_at','$member_id', 0)";

        if ($result = $connect->query($sql)) {
            $maxid = getMemberUpgradeMaxId($connect,$member_id);
            $sql_trans = "INSERT INTO transactions (trans_date,trans_type,trans_ref_id,qty,amount,status,created_at,created_by)
                      VALUES ('$c_date',1,'$maxid',1,'$amount',1,'$created_at','$member_id')";
            if ($result = $connect->query($sql_trans)) {
                array_push($user_data,['status'=>'success']);
            }
        } else {
            array_push($user_data,['status'=>'fail']);
        }

    }
    echo json_encode($user_data);
}
