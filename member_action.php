<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$id = 0;
$fname = '';
$lname = '';
$zone_id = '';
$parent_id = '';
$member_type_id = '';
$phone = '';
$email = '';
$line_id = '';
$url = '';
$point = '';
$is_center = 0;
$is_vipshop = 0;

$status = '';
$recid = 0;
$delete_id = '';
$action = null;
$userid = 0;

$address = '';
$street = '';
$province = '';
$city = '';
$district = '';
$zipcode = '';
$contact_phone = '';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

if (isset($_POST['f_name'])) {
    $fname = $_POST['f_name'];
}
if (isset($_POST['l_name'])) {
    $lname = $_POST['l_name'];
}
if (isset($_POST['zone_id'])) {
    $zone_id = $_POST['zone_id'];
}
if (isset($_POST['parent_id'])) {
    $parent_id = $_POST['parent_id'];
}
if (isset($_POST['member_type_id'])) {
    $member_type_id = $_POST['member_type_id'];
}
if (isset($_POST['phone_number'])) {
    $phone = $_POST['phone_number'];
}
if (isset($_POST['member_email'])) {
    $email = $_POST['member_email'];
}
if (isset($_POST['line_id'])) {
    $line_id = $_POST['line_id'];
}
if (isset($_POST['member_url'])) {
    $url = $_POST['member_url'];
}
if (isset($_POST['member_point'])) {
    $point = $_POST['member_point'];
}

if (isset($_POST['status'])) {
    $status = $_POST['status'];
}
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
}

if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}

if (isset($_POST['is_center'])) {
    $is_center = $_POST['is_center'];
}
if (isset($_POST['is_vipshop'])) {
    $is_vipshop = $_POST['is_vipshop'];
}

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
if (isset($_POST['center_phone'])) {
    $contact_phone = $_POST['center_phone'];
}
//print_r($action);return;

if ($action == 'create') {
    $created_at = time();
    $created_by = $userid;
    $sql = "INSERT INTO member(first_name,last_name,zone_id,parent_id,member_type_id,phone_number,email,line_id,url,point,status,created_at,created_by)
            VALUES('$fode','$lname','$zone_id','$parent_id','$member_type_id','$phone','$email','$line_id','$point','$status','$created_at','$created_by')";
    if ($result = $connect->query($sql)) {
        $res = 0;
        if ($address != '' && $zipcode != '') {
            $query = "SELECT * FROM center_address WHERE member_id='$id'";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $filtered_rows = $statement->rowCount();
            if ($filtered_rows > 0) {
                $created_at = time();
                $created_by = $userid;
                $sql = "UPDATE center_address set address='$address', street='$street',province_id='$province',city_id='$city',district_id='$district',zipcode='$zipcode',phone='$contact_phone', status=1 WHERE member_id='$id'";
                if ($result = $connect->query($sql)) {
                    $res += 1;
                }
            } else {
                $created_at = time();
                $created_by = $userid;
                $sql = "INSERT INTO center_address(member_id,address,street,province_id,city_id,district_id,zipcode,phone)VALUES('$id','$address','$street','$province','$city','$district','$zipcode','$contact_phone')";
                if ($result = $connect->query($sql)) {
                    $res += 1;
                }
            }

        }


        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:member.php');
    }
}

if ($action == 'update') {
    $created_at = time();
    $created_by = $userid;
    if ($id > 0) {

        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE member SET first_name='$fname',last_name='$lname',zone_id='$zone_id',parent_id='$parent_id',member_type_id='$member_type_id',phone_number='$phone',email='$email',line_id='$line_id',url='$url',point='$point',status='$status',updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";
        if ($result2 = $connect->query($sql2)) {
            $line_user_id = getUserIdfromMember($connect, $line_id);

            $sql_user = "UPDATE user set username='$email' WHERE id='$line_user_id'";
            if ($result_user = $connect->query($sql_user)) {

            }

            $res = 0;
            if ($address != '' && $zipcode != '') {
                //echo "has address";return;
                $query = "SELECT * FROM center_address WHERE member_id='$id'";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $filtered_rows = $statement->rowCount();
                if ($filtered_rows > 0) {

                    $created_at = time();
                    $created_by = $userid;
                    $sql = "UPDATE center_address set address='$address', street='$street',province_id='$province',city_id='$city',district_id='$district',zipcode='$zipcode', status=1,phone='$contact_phone' WHERE member_id='$id'";
                    if ($result2 = $connect->query($sql)) {
                        $res += 1;
                         // echo "update ok";return;
                    } else {
                         // echo "not update";return;
                    }
                } else {
                    //echo "not ok";return;
                    $created_at = time();
                    $created_by = $userid;
                    $sql2 = "INSERT INTO center_address(member_id,address,street,province_id,city_id,district_id,zipcode,phone)VALUES('$id','$address','$street','$province','$city','$district','$zipcode','$contact_phone')";
                    if ($result3 = $connect->query($sql2)) {
                        $res += 1;
                       // echo "create address ok";return;
                    }else{
                       // echo "not created ".$sql2;return;
                    }
                }

            }
            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:member.php');
        } else {
            echo "no";
            return;
        }
    }
}

if ($action == 'delete') {
    if ($delete_id > 0) {
        $sql3 = "DELETE FROM member WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:member.php');
        } else {
            echo "no";
            return;
        }
    }
}

function getUserIdfromMember($connect, $member_id)
{
    $user_id = 0;
    $query = "SELECT * FROM user WHERE member_ref_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $user_id = $row['id'];
        }
    }
    return $user_id;
}

//} else {
//    $_SESSION['msg-error'] = 'Save data error';
//    header('location:productcat.php');
//    $sql = "UPDATE product_group SET code='$code',name='$name',description='$description'";
//    $sql.=" WHERE id='$recid'";
//
//    if ($result = $connect->query($sql)) {
//        $_SESSION['msg-success'] = 'Saved data successfully';
//        header('location:productcat.php');
//    } else {
//        $_SESSION['msg-error'] = 'Save data error';
//        header('location:productcat.php');
//    }
//}

?>
