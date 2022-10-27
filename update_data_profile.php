<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
$userid = 0;
$id = 0;
$fname = '';
$lname = '';
$address = '';
$street = '';
$province = '';
$city = '';
$district = '';
$zipcode = '';
$bank_id = '';
$account_no = '';
$account_name = '';



$nation_type = '';
$id_verify = '';
$engname = '';
$engsurname = '';
$gender = '';
$dob = '';
$otp_number = '';
$income_list = '';
$is_agree = 0;
$upload_photo = null;

$address_current_type = '';

$address_current = '';
$street_current = '';
$province_current_id = '';
$city_current_id = '';
$district_current_id = '';
$zipcode_current = '';

$verify_member_status = 0;


if(isset($_POST['action_name'])){
    $verify_member_status = $_POST['action_name'];
}

if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}
if (isset($_POST['thai_person'])) {
    $nation_type = $_POST['thai_person'];
}
if (isset($_POST['member_fname'])) {
    $fname = $_POST['member_fname'];
}
if (isset($_POST['member_lname'])) {
    $lname = $_POST['member_lname'];
}
if (isset($_POST['member_engname'])) {
    $engname = $_POST['member_engname'];
}
if (isset($_POST['member_engsurname'])) {
    $engsurname = $_POST['member_engsurname'];
}
if (isset($_POST['gender'])) {
    $gender = $_POST['gender'];
}
if (isset($_POST['dob'])) {
    $dob = $_POST['dob'];
}
if (isset($_POST['otp_number'])) {
    $otp_number = $_POST['otp_number'];
}
if (isset($_POST['income_selected'])) {
    $income_list = $_POST['income_selected'];
}
if (isset($_POST['is_agree'])) {
    $is_agree = $_POST['is_agree'];
    if($is_agree == 'on'){
        $is_agree = 1;
    }
}

//print_r($income_list);return;
//if(isset($_POST['income_selected'])){
//    $income_list =
//}


//if (isset($_POST['upload_photo'])) {
//    $upload_photo = $_POST['upload_photo'];
//}

if (isset($_POST['address'])) {
    $address = $_POST['address'];
}
if (isset($_POST['street'])) {
    $street = $_POST['street'];
}
if (isset($_POST['province_id'])) {
    $province = $_POST['province_id'];
}
if (isset($_POST['city_id'])) {
    $city = $_POST['city_id'];
}
if (isset($_POST['district_id'])) {
    $district = $_POST['district_id'];
}
if (isset($_POST['zipcode'])) {
    $zipcode = $_POST['zipcode'];
}


if (isset($_POST['address_current_type'])) {
    $address_current_type = $_POST['address_current_type'];
}

if (isset($_POST['address_current'])) {
    $address_current = $_POST['address_current'];
}
if (isset($_POST['street_current'])) {
    $street_current = $_POST['street_current'];
}
if (isset($_POST['province_curren_id'])) {
    $province_current_id = $_POST['province_current_id'];
}
if (isset($_POST['city_current_id'])) {
    $city_current_id = $_POST['city_current_id'];
}
if (isset($_POST['district_current_id'])) {
    $district_current_id = $_POST['district_current_id'];
}
if (isset($_POST['zipcode_current'])) {
    $zipcode_current = $_POST['zipcode_current'];
}


if (isset($_POST['member_account_bank_id'])) {
    $bank_id = $_POST['member_account_bank_id'];
}
if (isset($_POST['member_account_no'])) {
    $account_no = $_POST['member_account_no'];
}
if (isset($_POST['member_account_name'])) {
    $account_name = $_POST['member_account_name'];
}


//print_r($_POST);return;


//print_r($_POST);return;
//echo $id;return;

//print_r($action);return;

if($verify_member_status == 1){
    $res = 0;
    $sql = "UPDATE member set is_verified='$verify_member_status', status=1 WHERE id='$id'";
    if ($result = $connect->query($sql)) {
        $res += 1;
    }
    $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
    header('location:member.php');
}

if (($id != null || $id != '') && $verify_member_status == 0) {
    $res = 0;

 //  echo $fname.' = '.$lname;return;
    if ($fname != '' && $lname != '') {
        $created_at = time();
        $created_by = $userid;

        $slip_doc = '';
        if (isset($_FILE['photo_verify'])) {
          //  echo "ok has photo";return;
            $errors = array();
            $file_name = $_FILES['photo_verify']['name'];
            $file_tmp = $_FILES['photo_verify']['tmp_name'];
            //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
            $slip_doc = $file_name;
            move_uploaded_file($file_tmp, "uploads/member_verify/" . $slip_doc);
        }

        $fulldate = explode('/',$dob);
        $dob_new = date('Y-m-d');
        if(count($fulldate)>1){
            $dob_new = date('Y-m-d',strtotime($fulldate[2].'/'.$fulldate[1].'/'.$fulldate[0]));
        }

        $sql = "UPDATE member set first_name='$fname', last_name='$lname' ,engname='$engname',engsurname='$engsurname',nation_type='$nation_type',gender='$gender',dob='$dob_new',verify_photo='$slip_doc',address_current_type='$address_current_type',agree_verified='$is_agree' WHERE id='$id'";
//        $sql = "UPDATE member set first_name='$fname', last_name='$lname' ,engname='$engname',engsurename='$engsurname',nation_type='$nation_type',id_verify='$id_verify',gender='$gender','dob'='$dob',verify_photo='$slip_doc' WHERE id='$id', is_verified=1";
        //echo $sql;return;
        if ($connect->query($sql)) {
            $res += 1;
        }
    }
    if ($bank_id != '' && $account_no != '' && $account_name != '') {
        $query = "SELECT * FROM member_account WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $id;
            $sql = "UPDATE member_account set bank_id='$bank_id', account_no='$account_no',account_name='$account_name' WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $id;
            $sql = "INSERT INTO member_account(member_id,bank_id,account_no,account_name,created_at,created_by)VALUES('$id','$bank_id','$account_no','$account_name','$created_at','$created_by')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }

    }

    if ($address != '' && $zipcode != '') {
        $query = "SELECT * FROM member_address WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $userid;
            $sql = "UPDATE member_address set address='$address', street='$street',province_id='$province',city_id='$city',district_id='$district',zipcode='$zipcode', status=1 WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $userid;
            $sql = "INSERT INTO member_address(member_id,address,street,province_id,city_id,district_id,zipcode)VALUES('$id','$address','$street','$province','$city','$district','$zipcode')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }

    }

    if($address_current_type == 1){
        $query = "SELECT * FROM member_address_current WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $userid;
            $sql = "UPDATE member_address_current set address='$address', street='$street',province_id='$province',city_id='$city',district_id='$district',zipcode='$zipcode' WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $userid;
            $sql = "INSERT INTO member_address_current(member_id,address,street,province_id,city_id,district_id,zipcode)VALUES('$id','$address','$street','$province','$city','$district','$zipcode')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }
    }else if($address_current_type == 2){
        $query = "SELECT * FROM member_address_current WHERE member_id='$id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            $created_at = time();
            $created_by = $userid;
            $sql = "UPDATE member_address_current set address='$address_current', street='$street_current',province_id='$province_current_id',city_id='$city_current_id',district_id='$district_current_id',zipcode='$zipcode_current' WHERE member_id='$id'";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        } else {
            $created_at = time();
            $created_by = $userid;
            $sql = "INSERT INTO member_address_current(member_id,address,street,province_id,city_id,district_id,zipcode)VALUES('$id','$address_current','$street_current','$province_current_id','$city_current_id','$district_current_id','$zipcode_current')";
            if ($result = $connect->query($sql)) {
                $res += 1;
            }
        }
    }

    if($income_list != ""){
        $xlist = explode(",",$income_list);
        if(count($xlist)>0){
          //  echo $xlist[1];return;
            for($x=0;$x<=count($xlist)-1;$x++){
                $sql = "INSERT INTO member_income_type(member_id,income_type_id,status)VALUES('$id','$xlist[$x]',1)";
                if ($connect->query($sql)) {

                }
            }
        }

    }

    $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
    header('location:profile.php');
}else{
    echo "no";
}


?>
