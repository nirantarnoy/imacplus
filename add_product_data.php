<?php
ob_start();
session_start();
include("common/dbcon.php");

$sku = '';
$name = '';
$description = '';
$prod_type =0;
$unit_id = 0;
$customer_id = 0;
$cost = 0;
$price = 0;


$recid = 0;


if (isset($_POST['sku'])) {
    $sku = $_POST['sku'];
}
if (isset($_POST['product_name'])) {
    $name = $_POST['product_name'];
}
if (isset($_POST['product_type_id'])) {
    $prod_type = $_POST['product_type_id'];
}
if (isset($_POST['product_unit_id'])) {
    $unit_id = $_POST['product_unit_id'];
}
if (isset($_POST['cost'])) {
    $cost = $_POST['cost'];
}
if (isset($_POST['price'])) {
    $price = $_POST['price'];
}

if (isset($_POST['recid'])) {
    $recid = $_POST['recid'];
}

$customer_id = getCustomerproduct($connect, $prod_type);

if ($recid <= 0) {
    if ($name != '' && $sku != '') {

        if(isset($_FILES['file_product'])){
            $errors = array();
            $file_name = $_FILES['file_product']['name'];
            $file_tmp =$_FILES['file_product']['tmp_name'];
            //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
            $card_photo = $file_name;
            move_uploaded_file($file_tmp,"uploads/product_photo/".$card_photo);
        }

        $sql = "INSERT INTO product (code,name,cat_id,unit_id,photo,cost,price_1)
           VALUES ('$sku','$name','$prod_type','$unit_id','$card_photo','$cost','$price')";

        if ($result = $connect->query($sql)) {
            $_SESSION['msg-success'] = 'Saved data successfully';
            header('location:product.php');
        } else {
            $_SESSION['msg-error'] = 'Save data error';
            header('location:product.php');
        }
    }

} else {
    //echo $sku;return;
    $sql = "UPDATE product SET name='$name',code='$sku',cat_id='$prod_type',unit_id='$unit_id',cost='$cost',price_1='$price'";

    if(isset($_FILES['file_product'])){
        $errors = array();
        $file_name = $_FILES['file_product']['name'];
        $file_tmp =$_FILES['file_product']['tmp_name'];
        //   $file_ext=strtolower(end(explode('.',$_FILES['file_card']['name'])));
        $card_photo = $file_name;
        move_uploaded_file($file_tmp,"uploads/product_photo/".$card_photo);
    }
    if($card_photo != ''){
        $sql.=",photo='$card_photo'";
    }

    $sql.=" WHERE id='$recid'";

    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'Saved data successfully';
        header('location:product.php');
    } else {
        $_SESSION['msg-error'] = 'Save data error';
        header('location:product.php');
    }
}


function getCustomerproduct($connect, $prod_type){
    $customer_id = 0;
    if($prod_type != ''){
        $query = "SELECT * FROM product_type WHERE id='$prod_type' ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
           $customer_id = $row['customer_id'];
        }
    }
    return $customer_id;
}

?>
