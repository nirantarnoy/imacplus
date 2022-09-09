<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/WorkorderModel.php");
include("models/MemberModel.php");
//include("models/PointCalculator.php");
$check_list = [];
$customer_id = null;
$customer_name = '';
$order_date = date('Y-m-d');
$customer_phone = null;
$brand = null;
$phone_model = null;
$phone_color = null;
$phone_pass = null;
$estimate_price = 0;
$pre_pay = 0;
$status = -1;
$note = "";
$work_finish_date = '';
$center_id = 0;
$delivery_type_id = 0;
$device_type_id = -1;


$recid = 0;
$delete_id = '';
$action = null;
$userid = 0;
$member_id = 0;

if (isset($_POST['customer_id'])) {
    $customer_id = $_POST['customer_id'];
}

if (isset($_POST['workorder_date'])) {
    $order_date = $_POST['workorder_date'];
}

if (isset($_POST['customer_name'])) {
    $customer_name = $_POST['customer_name'];
}

if (isset($_POST['phone'])) {
    $customer_phone = $_POST['phone'];
}

if (isset($_POST['phone_brand'])) {
    $brand = $_POST['phone_brand'];
}
if (isset($_POST['device_type'])) {
    $device_type_id = $_POST['device_type'];
}

if (isset($_POST['phone_model'])) {
    $phone_model = $_POST['phone_model'];
}

if (isset($_POST['phone_color'])) {
    $phone_color = $_POST['phone_color'];
}

if (isset($_POST['customer_pass'])) {
    $phone_pass = $_POST['customer_pass'];
}

if (isset($_POST['estimate_price'])) {
    $estimate_price = $_POST['estimate_price'];
}

if (isset($_POST['pre_pay'])) {
    $pre_pay = $_POST['pre_pay'];
}

if (isset($_POST['update_status'])) {
    $status = $_POST['update_status'];
}
if (isset($_POST['note'])) {
    $note = $_POST['note'];
}

if (isset($_POST['check_list'])) {
    $check_list = $_POST['check_list'];
}

if (isset($_POST['work_finish_date'])) {
    $work_finish_date = $_POST['work_finish_date'];
}

if (isset($_POST['center_id'])) {
    $center_id = $_POST['center_id'];
}
if (isset($_POST['delivery_type_id'])) {
    $delivery_type_id = $_POST['delivery_type_id'];
}

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}
if (isset($_POST['action_type'])) {
    $action = $_POST['action_type'];
}

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

//echo $userid;return;
if ($userid != null || $userid > 0) {
    $member_id = getMemberIDFromUser($connect, $userid);
    if (count($check_list)) {
        if ($action == 'create') {
            $finish_date = date('Y-m-d');
            $xdate = explode('-', $work_finish_date);
            if (count($xdate) > 0) {
                $t = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
                $finish_date = date('Y-m-d', strtotime($t));
            }
            $created_at = time();
            $created_by = $member_id;
            $new_no = getOrderLastNo($connect);
            $new_order_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO workorders(work_no,work_date,customer_name,device_type,phone,brand_id,phone_model_id,phone_color_id,estimate_price,customer_pass,pre_pay,status,note,created_at,created_by,estimate_finish,center_id,delivery_type_id)
            VALUES('$new_no','$new_order_date','$customer_name','$device_type_id','$customer_phone','$brand','$phone_model','$phone_color','$estimate_price','$phone_pass','$pre_pay','$status','$note','$created_at','$created_by','$finish_date','$center_id','$delivery_type_id')";
//            echo $sql;
            if ($result = $connect->query($sql)) {
                $maxid = getOrderMaxid($connect, $member_id);

                for ($i = 0; $i <= count($check_list) - 1; $i++) {
                    $sql_line = "INSERT INTO workorder_line(workorder_id,check_list_id,is_checked)VALUES('$maxid','$check_list[$i]',1)";
                    if ($result_line = $connect->query($sql_line)) {
                    }
                }

                if (isset($_FILES['upload_file'])) {
//                $errors = array();
//                $file_name = $_FILES['file_product']['name'];
//                $file_tmp =$_FILES['file_product']['tmp_name'];
//                //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
//                $card_photo = $file_name;
//                move_uploaded_file($file_tmp,"uploads/workorder/".$card_photo);
                    // echo count($_FILES['upload_file']['name']);return;

                    $countfiles = count($_FILES['upload_file']['name']);
                    for ($x = 0; $x <= $countfiles - 1; $x++) {
                        $filename = time() + ($x + 1) . ".jpg";//$_FILES['upload_file']['name'][$x];
                        //echo $filename; return;
                        $file_tmp = $_FILES['upload_file']['tmp_name'][$x];
                        $sql_photo = "INSERT INTO workorder_photo(workorder_id,photo) VALUES ('$maxid','$filename')";
                        if ($connect->query($sql_photo)) {
                            move_uploaded_file($file_tmp, "uploads/workorder/" . $filename);
                        }
                    }
                }

                $sql_trans = "INSERT INTO transactions (trans_date,trans_type,trans_ref_id,qty,amount,status,created_at,created_by)
                      VALUES ('$new_order_date',4,'$maxid',1,'$pre_pay',1,'$created_at','$created_by')";
                if ($result_trans = $connect->query($sql_trans)) {

                }

                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                header('location:workorder.php');
            }
        }
        if ($action == 'update') {

            $finish_date = date('Y-m-d');
            //   echo $work_finish_date;return;
            $xdate = explode('-', $work_finish_date);
            if (count($xdate) > 0) {
                $t = $xdate[2] . '/' . $xdate[1] . '/' . $xdate[0];
                $finish_date = date('Y-m-d', strtotime($t));
            }
            $created_at = time();
            $created_by = $member_id;
            $new_order_date = date('Y-m-d H:i:s');
            $sql = "UPDATE workorders SET customer_name='$customer_name',
                      phone='$customer_phone',
                      device_type='$device_type_id',
                      brand_id='$brand',
                      phone_model_id='$phone_model',
                      phone_color_id='$phone_color',
                      estimate_price='$estimate_price',
                      customer_pass='$phone_pass',
                      pre_pay='$pre_pay',
                      status='$status',
                      note='$note',
                      updated_at='$created_at',
                      updated_by='$created_by',
                      estimate_finish='$finish_date' ,
                      center_id ='$center_id' ,
                      delivery_type_id='$delivery_type_id' 

                      WHERE id='$recid'";

            if ($result = $connect->query($sql)) {
                // $maxid = getMaxid($connect);
                $sql3 = "DELETE FROM workorder_line WHERE workorder_id='$recid'";
                if ($result3 = $connect->query($sql3)) {
                    for ($i = 0; $i <= count($check_list) - 1; $i++) {
                        $sql_line = "INSERT INTO workorder_line(workorder_id,check_list_id,is_checked)VALUES('$recid','$check_list[$i]',1)";
                        if ($result_line = $connect->query($sql_line)) {}
                    }
                }


                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                header('location:workorder.php');
            }
        }

    }
    if ($action == 'delete') {

        if ($delete_id > 0) {
            $sql3 = "DELETE FROM workorders WHERE id='$delete_id'";
            if ($result3 = $connect->query($sql3)) {
                $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
                header('location:workorder.php');
            } else {
                echo "no";
                return;
            }
        }
    }
    if ($action == 'complete') {
//echo "ok complete".$recid;
        if ($recid > 0) {
            $sql3 = "UPDATE workorders SET status=6 WHERE id='$recid'";
            if ($result3 = $connect->query($sql3)) {
                $cal_res = calmpoint($connect, $recid);
               // echo $cal_res;return;
                if($cal_res){
                    $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                    header('location:workorder.php');
                }

            } else {
                echo "no";
                return;
            }
        }
    }
}

?>

