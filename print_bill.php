<?php
date_default_timezone_set('Asia/Bangkok');

include("common/dbcon.php");
include("models/ProdModel.php");
include("models/CustomerModel.php");
include("models/MemberModel.php");
include("models/ChecklistModel.php");
include("models/ItemModel.php");
//include("vendor/mpdf/mpdf/src/Mpdf.php");
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
//require_once 'vendor/autoload.php';
// เพิ่ม Font ให้กับ mPDF
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
//$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
$mpdf = new \Mpdf\Mpdf([
    'tempDir' => '/tmp',
    'mode' => 'utf-8', 'format' => [77, 120],
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' => 'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

//$mpdf->SetMargins(-10, 1, 1);
//$mpdf->SetDisplayMode('fullpage');
$mpdf->AddPageByArray([
    'margin-left' => 0,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 1,
]);
ob_start(); // Start get HTML code
session_start();
//include("pdf_header.php");
$id = 0;
$trans_id = 0;
//$trans_id = [];
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if (isset($_GET["trans_id"])) {
    $trans_id = $_GET["trans_id"];
}

$work_no = '';
$work_date = '';
$customer_id = '';
$customer_name = '';
$created_by = 0;
$item_id = 0;
$item_type_id = 0;
$item_name = "";
$item_color = '';
$estimate_price = 0;
$prepay = 0;

$problem_list = [];


$query = "SELECT * FROM workorders WHERE id ='$id'";
//$query .= ' GROUP BY product_picking.tracking_no';
$query .= ' ORDER BY id ASC ';

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
//$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $work_no = $row['work_no'];
    $work_date = $row['work_date'];
    $customer_id = $row['customer_id'];
    $customer_name = $row['customer_name'];
    $created_by = $row['created_by'];
    $item_id = $row['phone_model_id'];
    $item_type_id = $row['device_type'];
    $item_name = getItemName($row['phone_model_id'], $connect);
    $item_color = $row['phone_color_id'];
    $estimate_price = $row['estimate_price'];
    $prepay = $row['pre_pay'];
//    array_push($trans_data, [
//        'customer_id' => $row['customer_id'],
//        'loan_no' => $row['loan_no'],
//        'interest_amount' => $row['interest_amount'],
//        'balance_amount' => $row['balance_amount'],
//    ]);
}

$query2 = "SELECT * FROM workorder_line WHERE workorder_id ='$id'";
//$query .= ' GROUP BY product_picking.tracking_no';
$query2 .= ' ORDER BY id ASC ';

$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
$data = array();
//$filtered_rows = $statement->rowCount();
foreach ($result2 as $row) {
    array_push($problem_list,['name'=>getChecklistname($connect,$row['check_list_id'])]);
}

$total = 0;
$total_discount = 0;
$total_all = 0;

?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: sarabun;
            font-size: 12px;
        }

        table.table-header {
            border: 0px;
        }

        table.table-header td, th {
            border: 0px solid #dddddd;
            text-align: left;
            padding-left: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding-left: 10px;
        }

        tr:nth-child(even) {
            /*background-color: #dddddd;*/
        }
    </style>
    <!--    <script src="vendor/jquery/jquery.min.js"></script>-->
    <!--    <script type="text/javascript" src="js/ThaiBath-master/thaibath.js"></script>-->
</head>
<body>

<table class="table-header" style="width: 100%;" border="0">
    <tr>
        <td colspan="3" style="text-align: center"><img src="uploads/logo/imaclogo.jpg" style="width: 30%" alt=""></td>
    </tr>
    <tr>
        <td colspan="3">
            วันที่ <small> <?= date('d/m/Y H:i:s', strtotime($work_date)); ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            เลขที่สั่งซ่อม <small> <?= $work_no ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ผู้รับเงิน <small> <?= getMembername($connect, $created_by) ?></small>
        </td>
    </tr>

    <tr>
        <td colspan="3" style="border-top: 1px solid grey;">

        </td>
    </tr>
    <tr>

    </tr>
</table>
<br />
<table class="table-header" style="width: 100%">
    <tr>
        <td>
            <b>รายการบริการซ่อม</b>
        </td>
    </tr>
    <tr>
        <td>
            <?=$item_name. ' '.$item_color?>
        </td>
    </tr>
    <tr>
        <td>
            <b>อาการเบื้องต้น</b>
        </td>
    </tr>
    <tr>
        <td>
           <?php
           $problem_text = '';
           for($i =0 ;$i <=count($problem_list)-1;$i++){
               if($i< count($problem_list) -1){
                   $problem_text = $problem_text . $problem_list[$i]['name'].',';
               }else{
                   $problem_text = $problem_text . $problem_list[$i]['name'];
               }
           }

           ?>
            <p><?=$problem_text?></p>
        </td>
    </tr>
</table>
<br />
<table class="table-header" style="width: 100%">
    <tr>
        <td colspan="2">
            <b>ยอดรวม</b>
        </td>
        <td style="text-align: right;padding-right: 10px;">
            <?php echo number_format($estimate_price,2) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>ยอดรวมส่วนลด</b>
        </td>
        <td style="text-align: right;padding-right: 10px;">
          <?php echo number_format(0) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <b>ยอดเงิน</b>
        </td>
        <td style="text-align: right;padding-right: 10px;border-bottom: 1px solid black;">
            <?php echo number_format($estimate_price,2) ?>
        </td>
    </tr>
<!--    <tr>-->
<!--        <td colspan="3">-->
<!--            รับ <small> --><?php //echo number_format($estimate_price,2)?><!--</small>-->
<!--        </td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td colspan="3">-->
<!--            เงินทอน <small> --><?php //number_format($estimate_price,2) ?><!--</small>-->
<!--        </td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td colspan="3">-->
<!--            คะแนนสะสม <small> --><?php ////echo ?><!--</small>-->
<!--        </td>-->
<!--    </tr>-->

</table>
<br>
<!--<table class="table-header">-->
<!--    <tr>-->
<!--        <td width="100%">-->
<!--            โอนพร้อมเพย์ 0635897999-->
<!--        </td>-->
<!--    </tr>-->
<!--</table>-->

<script>
    // $(function(){
    //    alert('');
    // });
</script>
</body>
</html>
<?php
//include("pdf_footer.php");
?>
<?php

$html = ob_get_contents(); // ทำการเก็บค่า HTML จากคำสั่ง ob_start()
$mpdf->WriteHTML($html); // ทำการสร้าง PDF ไฟล์
//$mpdf->Output( 'Packing02.pdf','F'); // ให้ทำการบันทึกโค้ด HTML เป็น PDF โดยบันทึกเป็นไฟล์ชื่อ MyPDF.pdf
ob_clean();
$mpdf->SetJS('alert("ok");');
$mpdf->Output('transaction.pdf', 'I');
ob_end_flush();

//header("location: system_stock/report_pdf/Packing.pdf");

?>

<!--ดาวโหลดรายงานในรูปแบบ PDF <a class="btn-export-pdf" href="MyPDF.pdf">คลิกที่นี้</a>-->




