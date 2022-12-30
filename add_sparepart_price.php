<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/ItemModel.php");

$item_id = '';
$price = '';
$price_vat = null;
$cal_price = null;
$cost_price = null;
$sparepart_type = '';

$recid = 0;


if (isset($_POST['line_item_id'])) {
    $item_id = $_POST['line_item_id'];
}
if (isset($_POST['line_item_pirce'])) {
    $price = $_POST['line_item_pirce'];
}
if (isset($_POST['line_item_price_vat'])) {
    $price_vat = $_POST['line_item_price_vat'];
}
if (isset($_POST['item_sparepart_type'])) {
    $sparepart_type = $_POST['item_sparepart_type'];
}
if (isset($_POST['line_item_cal_price'])) {
    $cal_price = $_POST['line_item_cal_price'];
}
if (isset($_POST['line_item_cost_price'])) {
    $cost_price = $_POST['line_item_cost_price'];
}

//print_r($cost_price);return;
if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}


$c_timestamp = time();
$c_user = 1;
if (1 > 0) {
    if ($item_id != '' && $price != '' && $price_vat != '' && $sparepart_type != '') {
        $a_date = date('Y-m-d');
        $res = 0;

        for ($i = 0; $i <= count($item_id) - 1; $i++) {
            $new_price = 0;
            $new_price_vat = 0;
            if ($price[$i] == null) {
                $new_price = 0;
                $new_price_vat = 0;
            } else {
                $new_price = $price[$i];
                $new_price_vat = $price_vat[$i];
            }


            $sql_check = "SELECT * FROM standard_part_price WHERE phone_model_id='$item_id[$i]' AND part_type_id='$sparepart_type'";
            $statement = $connect->prepare($sql_check);

            $statement->execute();
            if ($statement->rowCount() > 0) {
                $sql = "UPDATE standard_part_price SET platform_price='$new_price',platform_price_include_vat='$new_price_vat',updated_at='$c_timestamp',updated_by='$c_user',cost='$cost_price[$i]',last_price='$cal_price[$i]' WHERE phone_model_id='$item_id[$i]' AND part_type_id='$sparepart_type'";

                if ($connect->query($sql)) {
                    $res += 1;
                }
            } else {
                $sql = "INSERT INTO standard_part_price (phone_model_id,platform_price,platform_price_include_vat,part_type_id,status,created_at,created_by,cost,last_price)
           VALUES ('$item_id[$i]','$new_price','$new_price_vat','$sparepart_type',1,'$c_timestamp','$c_user','$cost_price[$i]','$cal_price[$i]')";

                if ($result = $connect->query($sql)) {
                    $res += 1;
                }
            }


            // create sparepart

            $sql_check_ref_id = "SELECT * FROM sparepart WHERE item_ref_id='$item_id[$i]' AND part_type_id='$sparepart_type'";
            $statement2 = $connect->prepare($sql_check_ref_id);

            $statement2->execute();
            if ($statement2->rowCount() > 0) { // update
                $sql = "UPDATE sparepart SET cost_price='$cost_price[$i]',cal_price='$cal_price[$i]',sale_price='$new_price_vat' WHERE item_ref_id='$item_id[$i]' AND part_type_id='$sparepart_type'";

                if ($connect->query($sql)) {
                    $res += 1;
                }
              //  echo $sql;return;
            } else { // create new

                $item_name = getItemName($item_id[$i], $connect);
//                echo $item_name;return;
                $sql = "INSERT INTO sparepart (part_type_id,part_name,description,cost_price,cal_price,sale_price,item_ref_id,status,created_at,created_by)
           VALUES ('$sparepart_type','$item_name','$item_name','$cost_price[$i]','$cal_price[$i]','$new_price_vat','$item_id[$i]',1,'$c_timestamp','$c_user')";

                if ($result = $connect->query($sql)) {
                    $res += 1;
                }
            }

        }


        if ($res > 0) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:standardprice.php?type=' . $sparepart_type);
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:standardprice.php?type=' . $sparepart_type);
        }
    } else {
        echo 'nodd';
    }

} else {
//    echo "no";
//    return;
//    $sql = "UPDATE customer SET code='$code',name='$name',phone='$phone',email='$email',address='$address',updated_at='$c_timestamp',updated_by='$c_user',line_id='$line_id',facebook='$facebook',note='$note'";
//    $sql .= " WHERE id='$recid'";

//    if ($result = $connect->query($sql)) {
//        $_SESSION['msg-success'] = 'Saved data successfully';
//        header('location:standardprice.php');
//    } else {
//        $_SESSION['msg-error'] = 'Save data error';
//        header('location:standardprice.php');
//    }
}

?>
