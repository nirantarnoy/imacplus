<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/SaleModel.php");
include("common/order_lastno.php");

$id = 0;
$delete_id = 0;
$selected = null;
$userid = 0;

$customer_id = '';
$order_date = '';
$emp_person = '';
$emp_helper = '';
$order_status = '';

$line_product_id = '';
$line_qty = 0;
$line_price = 0;
$line_total = 0;
$line_promotion_id = 0;
$line_discount_amount = 0;
$line_discount_per = 0;

$line_rec_id = null;
$remove_list = null;
$status = '';
$action = '';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if (isset($_POST['selected_item'])) {
    $selected = $_POST['selected_item'];
}
if(isset($_POST['customer_id'])){
    $customer_id = $_POST['customer_id'];
}
if(isset($_POST['order_date'])){
    $order_date = $_POST['order_date'];
}
if(isset($_POST['emp_person'])){
    $emp_person = $_POST['emp_person'];
}
if(isset($_POST['emp_helper'])){
    $emp_helper = $_POST['emp_helper'];
}
if(isset($_POST['status'])){
    $status = $_POST['status'];
}

if(isset($_POST['line_product_id'])){
    $line_product_id = $_POST['line_product_id'];
}
if(isset($_POST['line_qty'])){
    $line_qty = $_POST['line_qty'];
}
if(isset($_POST['line_price'])){
    $line_price = $_POST['line_price'];
}
//if(isset($_POST['line_total'])){
//    $line_total = $_POST['line_total'];
//}
if(isset($_POST['line_promotion_id'])){
    $line_promotion_id = $_POST['line_promotion_id'];
}
if(isset($_POST['line_dis_amount'])){
    $line_discount_amount = $_POST['line_dis_amount'];
}
if(isset($_POST['line_dis_per'])){
    $line_discount_per = $_POST['line_dis_per'];
}



if(isset($_POST['line_rec_id'])){
    $line_rec_id = $_POST['line_rec_id'];
}
if(isset($_POST['remove_line_list'])){
    $remove_list = $_POST['remove_line_list'];
}

if(isset($_POST['action_type'])){
    $action = $_POST['action_type'];
}
if(isset($_POST['recid'])){
    $id = $_POST['recid'];
}
if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
}
//print_r($line_discount_per);return;
//echo $status; return;


if($action == 'create'){
    $created_at = time();
    $created_by = $userid;
    $last_no = getOrderLastNo($connect);
//    echo $last_no; return;
    $new_order_date = date('Y-m-d');
    $sql = "INSERT INTO orders(order_no,order_date,customer_id,emp_person,emp_helper,status,created_at,created_by)
    VALUES('$last_no','$new_order_date','$customer_id','$emp_person','$emp_helper','$status','$created_at','$created_by')";

    if ($result = $connect->query($sql)) {
        $max_id = getMaxidSale($connect);
        if($max_id){
            if(count($line_product_id)){
                for($i=0;$i<=count($line_product_id)-1;$i++){
                    $line_total = $line_price[$i] * $line_qty[$i];
                    $sql4 = "INSERT INTO order_line(order_id,product_id,qty,price,line_total,disc_per,disc_amount,promotion_id,created_at)";
                    $sql4 .= " VALUES('$max_id','$line_product_id[$i]','$line_qty[$i]','$line_price[$i]','$line_total','$line_discount_per[$i]','$line_discount_amount[$i]','$line_promotion_id[$i]','$created_at')";
                    if ($result4 = $connect->query($sql4)) {
                    }
                }
            }
        }
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:sale.php');
    }
}

if($action == 'update'){
    if($id > 0){
        //  echo $id;return;
        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE orders SET emp_person='$emp_person',emp_helper='$emp_helper',status='$status', updated_at='$created_at',updated_by='$created_by' WHERE id='$id'";

//        echo $sql2;return;
        if ($result2 = $connect->query($sql2)) {
            if(count($line_product_id)){
                for($i=0;$i<=count($line_product_id)-1;$i++){
                    $line_total = $line_qty[$i]*$line_price[$i];
//                    echo checkSaleHadrecord($line_rec_id[$i],$connect); return;
                    if(checkSaleHadrecord($line_rec_id[$i],$connect)==1){
                        $sql6 = "UPDATE order_line SET qty='$line_qty[$i]',price='$line_price[$i]',line_total='$line_total',disc_per='$line_discount_per[$i]',disc_amount='$line_discount_amount[$i]',promotion_id='$line_promotion_id[$i]', updated_at='$created_at' WHERE id='$line_rec_id[$i]'";
                        if ($result6 = $connect->query($sql6)) {}
//                        echo $sql6; return;
                    }else{
                        $sql5 = "INSERT INTO order_line(order_id,product_id,qty,price,line_total,disc_per,disc_amount,promotion_id,created_at)";
                        $sql5 .= " VALUES('$id','$line_product_id[$i]','$line_qty[$i]','$line_price[$i]','$line_total','$line_discount_per[$i],'$line_discount_amount[$i],'$line_promotion_id[$i],'$created_at') ";
                        if ($result5 = $connect->query($sql5)) {
//                            echo $sql5; return;
                        }
                    }
                }
            }
            // removelist
            $delete_rec = explode(',',$remove_list);
            if(count($delete_rec)){
                for($m=0;$m <= count($delete_rec)-1;$m++){
                    $sql7 = "DELETE FROM order_line WHERE id='$delete_rec[$m]' ";
                    if ($result7 = $connect->query($sql7)) {}
                }
            }



            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:sale.php');
        }else{
            echo "no";return;
        }
    }

}
if($action == 'delete'){
    if($delete_id > 0){
        $sql3 = "DELETE FROM orders WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $sql8 = "DELETE FROM order_line WHERE order_id='$delete_id]' ";
            if ($result8 = $connect->query($sql8)) {}
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:sale.php');
        }else{
            echo "no";return;
        }
    }
}

//if ($id) {
//    for ($i = 0; $i <= count($id) - 1; $i++) {
//        $recid = $id[$i];
//        //echo $recid;
//        $cdate = date('Y/m/d H:m:s');
//        $sql = "UPDATE product_stock SET issue_by='$userid',issue_date='$cdate',issue_status = 1 WHERE id='$recid'";
//        $res = 0;
//        if ($result = $connect->query($sql)) {
//            $res += 1;
//
//            $query = "SELECT * FROM product_stock WHERE id='$recid'";
//            if ($result2 = $connect->query($query)) {
//                foreach ($result2 as $row) {
//                    $prod_code = $row['prod_code'];
//                    $prod_name = $row['prod_name'];
//                    $prod_year = $row['year'];
//                    $prod_promotion = $row['promotion'];
//                    $prod_branch = $row['branch'];
//                    $prod_model = getProdmodel($row['prod_code'],$connect);
//                    $sql2 = "INSERT INTO transaction(trans_date,prod_code,prod_name,branch,year,promotion,stock_type,user_id,prod_model)VALUES('$cdate','$prod_code','$prod_name','$prod_branch','$prod_year','$prod_promotion',1,'$userid','$prod_model')";
//                    if ($result3 = $connect->query($sql2)) {
//                        $res += 1;
//                    }
//                }
//            }
//
//        }
//        if ($res > 0) {
//            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
//            header('location:products.php');
//        } else {
//            $_SESSION['msg-error'] = 'พบข้อผิดำพลาด';
//            header('location:products.php');
//        }
//    }
//    //  return;
//} else {
//    $_SESSION['msg-error'] = 'พบข้อผิดำพลาด';
//    header('location:products.php');
//
//}

?>
