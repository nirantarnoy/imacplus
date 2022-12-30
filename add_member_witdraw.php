<?php
ob_start();
session_start();
include("common/dbcon.php");
include("models/WitdrawModel.php");
include("models/MemberModel.php");

$user_id = $_SESSION['userid'];
$witdraw_amount = 0;
$witdraw_vat_amount = 0;
$witdraw_total_amount = 0;
$slip = 0;


$recid = 0;


//if (isset($_POST['member_id'])) {
//    $member_id = $_POST['member_id'];
//}
if (isset($_POST['witdraw_amount'])) {
    $witdraw_amount = $_POST['witdraw_amount'];
}

if (isset($_POST['witdraw_vat_amount'])) {
    $witdraw_vat_amount = $_POST['witdraw_vat_amount'];
}

if (isset($_POST['witdraw_total_amount'])) {
    $witdraw_total_amount = $_POST['witdraw_total_amount'];
}


if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}
//echo $witdraw_amount;return;
$member_id = getMemberIDFromUser($connect, $user_id);

if ($member_id != null && $witdraw_amount != '') {

//    $slip_doc = '';
//    if (isset($_FILES['file_slip'])) {
//        $errors = array();
//        $file_name = $_FILES['file_slip']['name'];
//        $file_tmp = $_FILES['file_slip']['tmp_name'];
//        //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
//        $slip_doc = $file_name;
//        move_uploaded_file($file_tmp, "uploads/wallet_slip/" . $slip_doc);
//    }
    $c_date = date('Y-m-d H:i:s');
    $created_at = time();
    $get_lastno = getWitdrawLastNo($connect);
    $sql = "INSERT INTO witdraw_trans (trans_no,trans_date,member_id,witdraw_amount,witdraw_vat_amount,witdraw_total_amount,transfer_doc,created_at,created_by,status)
           VALUES ('$get_lastno','$c_date','$member_id','$witdraw_amount','$witdraw_vat_amount','$witdraw_total_amount','','$created_at','$member_id', 0)";

    if ($result = $connect->query($sql)) {
        $maxid = getWitdrawMaxId($connect, $member_id);
        $sql_trans = "INSERT INTO transactions (trans_date,trans_type,trans_ref_id,qty,amount,status,created_at,created_by)
                      VALUES ('$c_date',3,'$maxid',1,'$witdraw_total_amount',1,'$created_at','$member_id')";
        if ($result = $connect->query($sql_trans)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:witdrawlist.php');
        }
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:witdrawlist.php');
    }
}else{
    echo "EEE";
}

//
//function getCustomerproduct($connect, $prod_type)
//{
//    $customer_id = 0;
//    if ($prod_type != '') {
//        $query = "SELECT * FROM product_type WHERE id='$prod_type' ";
//        $statement = $connect->prepare($query);
//        $statement->execute();
//        $result = $statement->fetchAll();
//        foreach ($result as $row) {
//            $customer_id = $row['customer_id'];
//        }
//    }
//    return $customer_id;
//}

?>
