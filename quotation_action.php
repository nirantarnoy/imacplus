<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
include("common/dbcon.php");
//include("models/SaleModel.php");
//include("common/order_lastno.php");
include("models/QuotationModel.php");
include("models/ItemModel.php");

$id = 0;
$delete_id = 0;
$selected = null;
$userid = 0;

$customer_id = 0;
$customer_name = '';
$quotation_no = '';
$quotation_date = '';
$emp_person = '';
$emp_helper = '';
$order_status = '';

$line_item_id = '';
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

$quotation_confirm_id = 1;

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if (isset($_POST['selected_item'])) {
    $selected = $_POST['selected_item'];
}
if(isset($_POST['customer_id'])){
    $customer_id = $_POST['customer_id'];
}
if(isset($_POST['customer_name'])){
    $customer_name = $_POST['customer_name'];
}
if(isset($_POST['quotation_no'])){
    $quotation_no = $_POST['quotation_no'];
}
if(isset($_POST['quotation_date'])){
    $quotation_date = $_POST['quotation_date'];
}
//if(isset($_POST['emp_person'])){
//    $emp_person = $_POST['emp_person'];
//}
//if(isset($_POST['emp_helper'])){
//    $emp_helper = $_POST['emp_helper'];
//}
if(isset($_POST['status'])){
    $status = $_POST['status'];
}

if(isset($_POST['line_product_id'])){
    $line_item_id = $_POST['line_product_id'];
}
if(isset($_POST['line_qty'])){
    $line_qty = $_POST['line_qty'];
}
if(isset($_POST['line_price'])){
    $line_price = $_POST['line_price'];
}

if(isset($_POST['quotation_confirm_id'])){
    $quotation_confirm_id = $_POST['quotation_confirm_id'];
}
//if(isset($_POST['line_promotion_id'])){
//    $line_promotion_id = $_POST['line_promotion_id'];
//}
//if(isset($_POST['line_dis_amount'])){
//    $line_discount_amount = $_POST['line_dis_amount'];
//}
//if(isset($_POST['line_dis_per'])){
//    $line_discount_per = $_POST['line_dis_per'];
//}



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
//print_r($line_rec_id);return;
//echo $status; return;


if($action == 'create'){
    $created_at = time();
    $created_by = $userid;
    $quotation_no = getOuotationLastNo($connect);
//    echo $last_no; return;
    $new_quotation_date = date('Y-m-d');
    $sql = "INSERT INTO quotation(quotation_no,quotation_date,customer_id,status,created_at,created_by,customer_name)
    VALUES('$quotation_no','$new_quotation_date','$customer_id','$status','$created_at','$created_by','$customer_name')";

    if ($result = $connect->query($sql)) {
        $max_id = getMaxidQuotation($connect);
        if($max_id){
//            print_r($line_item_id);return;
            if(count($line_item_id)){
//                print_r($line_item_id);return;
                for($i=0;$i<=count($line_item_id)-1;$i++){
                    $line_total = $line_price[$i] * $line_qty[$i];
                    $item_name = getItemName($line_item_id[$i],$connect);
                    $sql4 = "INSERT INTO quotation_line(quotation_id,item_id,item_name,qty,price,line_total,status)";
                    $sql4 .= " VALUES('$max_id','$line_item_id[$i]','$item_name','$line_qty[$i]','$line_price[$i]','$line_total',$status)";
                    if ($result4 = $connect->query($sql4)) {
                        echo 'hello';
                    }
                }
            }
        }
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:quotation.php');
    }
}

if($action == 'update'){
    if($id > 0){
        //  echo $id;return;
        $created_at = time();
        $created_by = $userid;
        $sql2 = "UPDATE quotation SET customer_id='$customer_id',status='$status', customer_name='$customer_name', updated_at='$created_at' WHERE id='$id'";

//        echo $sql2;return;
        if ($result2 = $connect->query($sql2)) {
            if(count($line_item_id)){
                for($i=0;$i<=count($line_item_id)-1;$i++){
                    $line_total = $line_qty[$i]*$line_price[$i];
//                    echo checkQuotationHasrecord($line_rec_id[$i],$connect); return;
                    if(checkQuotationHasrecord($line_rec_id[$i],$connect)==1){
                        $sql6 = "UPDATE quotation_line SET qty='$line_qty[$i]',price='$line_price[$i]',line_total='$line_total' WHERE id='$line_rec_id[$i]' ";
                        if ($result6 = $connect->query($sql6)) {}
//                        echo $sql6; return;
                    }else{
                        $item_name = getItemName($line_item_id[$i],$connect);
                        $sql5 = "INSERT INTO quotation_line(quotation_id,item_id,item_name,qty,price,line_total)";
                        $sql5 .= " VALUES('$id','$line_item_id[$i]','$item_name','$line_qty[$i]','$line_price[$i]','$line_total') ";
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
                    $sql7 = "DELETE FROM quotation_line WHERE id='$delete_rec[$m]' ";
                    if ($result7 = $connect->query($sql7)) {}
                }
            }



            $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            header('location:quotation.php');
        }else{
            echo "no";return;
        }
    }

}
if($action == 'delete'){
    if($delete_id > 0){
        $sql3 = "DELETE FROM quotation WHERE id='$delete_id'";
        if ($result3 = $connect->query($sql3)) {
            $sql8 = "DELETE FROM quotation_line WHERE quotation_id='$delete_id]' ";
            if ($result8 = $connect->query($sql8)) {}
            $_SESSION['msg-success'] = 'ลบข้อมูลเรียบร้อยแล้ว';
            header('location:quotation.php');
        }else{
            echo "no";return;
        }
    }
}
if($action == 'confirm') {
    if ($quotation_confirm_id > 0) {
        $sql_confirm = "UPDATE quotation SET status=1 WHERE id='$quotation_confirm_id' ";
        if ($result_confirm = $connect->query($sql_confirm)) {
            if(deductStock($connect, $quotation_confirm_id)){
                updateWorkorder($connect, $quotation_confirm_id);
            }
            $_SESSION['msg-success'] = 'ทำรายการสำเร็จ';
            header('location:quotation.php');
        }
    }

}

function deductStock($connect,$quotation_id){
    $res = 0;
    if($quotation_id){
        $query = "SELECT * FROM quotation_line WHERE quotation_id='$quotation_id'";
            if ($result2 = $connect->query($query)) {
                foreach ($result2 as $row) {
                    $res = deductStockItem($connect,$row['item_id'],$row['qty']);
                }
            }
    }
    return $res;
}
function deductStockItem($connect,$item_id,$qty){
    if($item_id){
        $old_qty = getSparepartOldQty($connect,$item_id);
        $new_qty = ($old_qty - $qty);
        $sql_confirm = "UPDATE sparepart_stock SET qty='$new_qty' WHERE sparepart_id='$item_id' ";
        if ($connect->query($sql_confirm)) {
         return 1;
        }
    }else{
        return 0;
    }
}

function getSparepartOldQty($connect,$item_id){
    if($item_id){
        $query = "SELECT * FROM sparepart_stock WHERE sparepart_id='$item_id'";
        if ($result2 = $connect->query($query)) {
            foreach ($result2 as $row) {
               return $row['qty'];
            }
        }
    }
}

function updateWorkorder($connect, $quotation_id){
    if($quotation_id){
        $query = "SELECT * FROM quotation WHERE id='$quotation_id'";
        if ($result2 = $connect->query($query)) {
            foreach ($result2 as $row) {
                $work_id = $row['workorder_id'];
                if($work_id != null){
                    $sql_confirm = "UPDATE workorders SET status=3 WHERE id='$work_id' ";
                    if ($connect->query($sql_confirm)) {
                        return 1;
                    }
                }
            }
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
