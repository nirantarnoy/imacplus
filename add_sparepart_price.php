<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

$code = '';
$name = '';
$active_date = null;
$contact_name = '';
$address = '';
$phone = '';
$email = '';
$line_id = '';
$facebook = '';
$recid = 0;
$note = '';


if (isset($_POST['cust_code'])) {
    $code = $_POST['cust_code'];
}
if (isset($_POST['cust_name'])) {
    $name = $_POST['cust_name'];
}
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['line_id'])) {
    $line_id = $_POST['line_id'];
}
if (isset($_POST['facebook'])) {
    $facebook = $_POST['facebook'];
}

if (isset($_POST['cust_address'])) {
    $address = $_POST['cust_address'];
}
if (isset($_POST['cust_note'])) {
    $note = $_POST['cust_note'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

$line_id = str_replace("'","/",$line_id);
$facebook = str_replace("'","/",$facebook);
$note = str_replace("'","/",$note);
$address = str_replace("'","/",$address);

$c_timestamp = time();
$c_user = 1;
if ($recid <= 0) {
    if ($code != '' && $name != '') {
        //echo "ok";return;
        $a_date = date('Y-m-d',strtotime($active_date));
        //echo $a_date;return;

        $sql = "INSERT INTO customer (code,name,address,phone,email,created_at,created_by,line_id,facebook,note)
           VALUES ('$code','$name','$address','$phone','$email','$c_timestamp','$c_user','$line_id','$facebook','$note')";

        //echo $sql;return;
        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:customer.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:customer.php');
        }
    }

} else {
    $sql = "UPDATE customer SET code='$code',name='$name',phone='$phone',email='$email',address='$address',updated_at='$c_timestamp',updated_by='$c_user',line_id='$line_id',facebook='$facebook',note='$note'";
    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:customer.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:customer.php');
    }
}

?>
