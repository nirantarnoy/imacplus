<?php
ob_start();
session_start();
include("common/dbcon.php");

$member_id = $_SESSION['userid'];
$wallet_pay = 0;
$slip = 0;


$recid = 0;


//if (isset($_POST['member_id'])) {
//    $member_id = $_POST['member_id'];
//}
if (isset($_POST['wallet_pay'])) {
    $wallet_pay = $_POST['wallet_pay'];
}


if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


if ($member_id != null && $wallet_pay != '') {

    $slip_doc = '';
    if (isset($_FILES['file_slip'])) {
        $errors = array();
        $file_name = $_FILES['file_slip']['name'];
        $file_tmp = $_FILES['file_slip']['tmp_name'];
        //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
        $slip_doc = $file_name;
        move_uploaded_file($file_tmp, "uploads/wallet_slip/" . $slip_doc);
    }
    $c_date = date('Y-m-d H:i:s');
    $created_at = time();
    $sql = "INSERT INTO wallet_trans (trans_no,trans_date,member_id,wallet_in_amount,transfer_doc,created_at,created_by,status)
           VALUES ('001','$c_date','$member_id','$wallet_pay','$slip_doc','$created_at','$member_id', 0)";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:walletlist.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:walletlist.php');
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
