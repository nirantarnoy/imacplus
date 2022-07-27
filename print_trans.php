<?php
ob_start();
session_start();
//date_default_timezone_set('Asia/Yangon');
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
include "header.php";

$id = 0;
$trans_id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['trans_id'])) {
    $trans_id = $_GET['trans_id'];
}
?>
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-3" style="text-align: center;margin-top: 10px;">
        <a href="print_bill.php?id=<?=$id?>&trans_id=<?=$trans_id?>" class="btn btn-success">
            <i class="fa fa-print"></i>
            พิมพ์ตอนนี้
        </a>
    </div>
    <div class="col-lg-3" style="text-align: center;margin-top: 10px;">
        <a href="transaction.php" class="btn btn-secondary">
            <i class="fa fa-print"></i>
            พิมพ์ทีหลัง
        </a>
    </div>
    <div class="col-lg-3"></div>
</div>
<?php
include "footer.php";
?>
