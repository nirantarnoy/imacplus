<?php
date_default_timezone_set('Asia/Bangkok');

include("common/dbcon.php");
include("models/ProdModel.php");
include("models/CustomerModel.php");
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

$trans_no = '';
$trans_data = [];
$pay_amount = 0;
$customer_name = '';
$customer_address = '';

$query = "SELECT * FROM workorder WHERE id =1";
//$query .= ' GROUP BY product_picking.tracking_no';
$query .= ' ORDER BY id ASC ';

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
//$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
//    $trans_no = $row['trans_no'];
    array_push($trans_data, [
        'customer_id' => $row['customer_id'],
        'loan_no' => $row['loan_no'],
        'interest_amount' => $row['interest_amount'],
        'balance_amount' => $row['balance_amount'],
    ]);
}

$query2 = "SELECT * FROM workorder WHERE id =1";
//$query .= ' GROUP BY product_picking.tracking_no';
$query2 .= ' ORDER BY id ASC ';

$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
foreach ($result2 as $row2) {
//    $trans_no = $row['trans_no'];

    $pay_amount = $row2['pay_amount'];

}

$customer_name = $trans_data[0]['customer_id'] ? getCustomername($connect, $trans_data[0]['customer_id']) : $trans_data[0]['customer_name'];
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
<img src="" alt="">
<table class="table-header" style="width: 100%;" border="0">

    <tr>
        <td colspan="3">
            วันที่ <small> <?= date('d/m/Y H:i:s'); ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ใบเสร็จรับเงิน <small> <?php //echo?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ผู้รับเงิน <small> <?php //echo ?></small>
        </td>
    </tr>

    <tr>
        <td colspan="3" style="border-top: 1px solid black;">

        </td>
    </tr>
    <tr>

    </tr>
</table>
<table class="table-header">
    <tr>
        <td colspan="3">
            ยอดรวม <small> <?php //echo ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ยอดรวมส่วนลด <small> <?php //echo ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ยอดเงิน <small> <?php //echo ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            รับ <small> <?php //echo ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            เงินทอน <small> <?php //echo ?></small>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            คะแนนสะสม <small> <?php //echo ?></small>
        </td>
    </tr>

</table>
<br>
<table class="table-header">
    <tr>
        <td width="100%">
            โอนพร้อมเพย์ 0635897999
        </td>
    </tr>
</table>

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




