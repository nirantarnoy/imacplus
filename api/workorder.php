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
include("../models/WorkorderModel.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == 'POST'){
    $user_data = [];

    $member_id = '';
    $work_date = '';
    $customer_id = 0;
    $customer_name = '';
    $device_type = '';
    $phone = '';
    $brand_id = 0;
    $phone_model_id = '';
    $phone_color_id = '';
    $estimate_price = '';
    $customer_pass = '';
    $pre_pay = '';
    $note = '';
    $work_finish_date = null;

    $problemlist='';
    $photolist ='';


    $jsonReqUrl  = "php://input";
    $reqjson = file_get_contents($jsonReqUrl);
    $reqjsonDecode = json_decode($reqjson, true);

    $member_id = $reqjsonDecode['member_id'];
    $work_date = $reqjsonDecode['work_date'];
    $customer_id = $reqjsonDecode['customer_id'];
    $customer_name = $reqjsonDecode['customer_name'];
    $phone = $reqjsonDecode['customer_tel'];
  //  $brand_id = $reqjsonDecode['brand_id'];
    $device_type = $reqjsonDecode['device_type'];
    $phone_model_id = $reqjsonDecode['device_model'];
    $phone_color_id = $reqjsonDecode['device_color'];
    $estimate_price = $reqjsonDecode['estimate_price'];
    $customer_pass = $reqjsonDecode['customer_pass'];
    $pre_pay = $reqjsonDecode['prepay'];
    $note = $reqjsonDecode['note'];
    $problemlist = $reqjsonDecode['probremlist'];
    $photolist = $reqjsonDecode['photo'];
    $work_finish_date = $reqjsonDecode['work_finish_date'];

    //  echo  $reqjsonDecode['username'];
//   print_r($reqjsonDecode);


    if($member_id != '' && $customer_name !=''){

        $finish_date = date('Y-m-d');
        $xdate = explode('-',$work_finish_date);
        if(count($xdate) > 0){
            $t = $xdate[2].'/'.$xdate[1].'/'.$xdate[0];
           $finish_date = date('Y-m-d', strtotime($t));
        }

        $c_date = date('Y-m-d H:i:s');
        $created_at = time();
        $get_lastno = getOrderLastNo($connect);
        $sql = "INSERT INTO workorders (work_no,work_date,customer_id,customer_name,device_type,phone,brand_id,phone_model_id,phone_color_id,estimate_price,customer_pass,pre_pay,note,created_at,created_by,status,estimate_finish)
           VALUES ('$get_lastno','$c_date','$customer_id','$customer_name','$device_type','$phone','$brand_id','$phone_model_id','$phone_color_id','$estimate_price','$customer_pass','$pre_pay','$note','$created_at','$member_id', 0,'$finish_date')";

        if ($result = $connect->query($sql)) {
            $maxid = getOrderMaxid($connect,$member_id);

            if(count($problemlist)){
                for($i=0;$i<=count($problemlist)-1;$i++){
                    $checklist_id = $problemlist[$i]['id'];
                    $query_save_checklist = "INSERT INTO workorder_line (workorder_id,check_list_id,is_checked)
                      VALUES ('$maxid','$checklist_id',1)";
                    $connect->query($query_save_checklist);
                }
            }

            if($photolist != ""){
                for($i=0;$i<=count($photolist)-1;$i++){
                    $loophoto = $photolist[$i];

                    $newfile = time().$i.".jpg";

                    $outputfile = '../uploads/workorder/' . $newfile;          //save as image.jpg in uploads/ folder

                    $filehandler = fopen($outputfile, 'wb');
                    //file open with "w" mode treat as text file
                    //file open with "wb" mode treat as binary file

                    fwrite($filehandler, base64_decode(trim($loophoto)));
                    // we could add validation here with ensuring count($data)>1

                    // clean up the file resource
                    fclose($filehandler);

                    $query_save_photo = "INSERT INTO workorder_photo (workorder_id,photo)
                      VALUES ('$maxid','$newfile')";
                    $connect->query($query_save_photo);
                }
            }


            $sql_trans = "INSERT INTO transactions (trans_date,trans_type,trans_ref_id,qty,amount,status,created_at,created_by)
                      VALUES ('$c_date',4,'$maxid',1,'$estimate_price',1,'$created_at','$member_id')";
            if ($result = $connect->query($sql_trans)) {
                array_push($user_data,['status'=>'success']);
            }
        } else {
            array_push($user_data,['status'=>'fail']);
        }

    }
    echo json_encode($user_data);
}
