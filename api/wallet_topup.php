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
include("../models/WalletModel.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'POST'){
    $user_data = [];

    $member_id = '';
    $topup_amount = 0;
    $slip = '';


    $jsonReqUrl  = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];
    $topup_amount = $reqjsonDecode['topup_amount'];
    $slip = $reqjsonDecode['slip'];
    //  echo  $reqjsonDecode['username'];
//   print_r($reqjsonDecode);


    if($member_id != '' && $slip !=''){

//        $slip_doc = '';
//        if (isset($_FILES['file_slip'])) {
//            $errors = array();
//            $file_name = $_FILES['file_slip']['name'];
//            $file_tmp = $_FILES['file_slip']['tmp_name'];
//            //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
//            $slip_doc = $file_name;
//            move_uploaded_file($file_tmp, "uploads/wallet_slip/" . $slip_doc);
//        }

        $newfile = time() . ".jpg";
        $outputfile = '../uploads/wallet_slip/' . $newfile;          //save as image.jpg in uploads/ folder

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
        $get_lastno = getWalletLastNo($connect);
        $sql = "INSERT INTO wallet_trans (trans_no,trans_date,member_id,wallet_in_amount,transfer_doc,created_at,created_by,status)
           VALUES ('$get_lastno','$c_date','$member_id','$topup_amount','$newfile','$created_at','$member_id', 0)";

        if ($result = $connect->query($sql)) {
            $maxid = getWalletMaxId($connect);
            $sql_trans = "INSERT INTO transactions (trans_date,trans_type,trans_ref_id,qty,amount,status,created_at,created_by)
                      VALUES ('$c_date',2,'$maxid',1,'$topup_amount',1,'$created_at','$member_id')";
            if ($result = $connect->query($sql_trans)) {
              array_push($user_data,['status'=>'success']);
            }
        } else {
            array_push($user_data,['status'=>'fail']);
        }

    }
    echo json_encode($user_data);
}
