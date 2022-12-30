<?php
include('common/dbcon.php');
include('models/ItemModel.php');
include("models/ChecklistModel.php");

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$work_data = [];
$work_no = '';
$work_date = '';
$customer_id = '';
$customer_name = '';
$customer_phone = '';
$customer_pass = '';
$created_by = '';
$item_id = '';
$item_type_id = '';
$item_name = '';
$item_color = '';
$estimate_price = '';
$prepay = '';
$brand_id = 0;

if ($id > 0) {
    $query = "SELECT * FROM workorders WHERE id ='$id'";

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
        $customer_pass = $row['customer_pass'];
        $brand_id = $row['brand_id'];
        $customer_phone = $row['phone'];
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

//    $query2 = "SELECT * FROM workorder_line WHERE workorder_id ='$id'";
////$query .= ' GROUP BY product_picking.tracking_no';
//    $query2 .= ' ORDER BY id ASC ';
//
//    $statement2 = $connect->prepare($query2);
//    $statement2->execute();
//    $result2 = $statement2->fetchAll();
//    $data = array();
////$filtered_rows = $statement->rowCount();
//    foreach ($result2 as $row) {
//        array_push($problem_list,['name'=>getChecklistname($connect,$row['check_list_id'])]);
//    }
}
$checklist_data = getChecklistmodel($connect);
$col_1 = [];
$col_2 = [];
$col_3 = [];
$col_4 = [];

$item_nums = 0;


if (count($checklist_data) > 0) {

    for ($x = 0; $x <= count($checklist_data) - 1; $x++) {
        if ($item_nums <= 7) {
            array_push($col_1, ['id' => $checklist_data[$x]['id'], 'name' => $checklist_data[$x]['name']]);
        }
        if ($item_nums > 7 && $item_nums <= 15) {
            array_push($col_2, ['id' => $checklist_data[$x]['id'], 'name' => $checklist_data[$x]['name']]);
        }
        if ($item_nums > 15 && $item_nums <= 22) {
            array_push($col_3, ['id' => $checklist_data[$x]['id'], 'name' => $checklist_data[$x]['name']]);
        }
        if ($item_nums > 22 && $item_nums <= 30) {
            array_push($col_4, ['id' => $checklist_data[$x]['id'], 'name' => $checklist_data[$x]['name']]);
        }
        $item_nums += 1;
    }
}

?>
<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

include("common/dbcon.php");
include("models/UserModel.php");
include("models/MemberModel.php");

$member_id = getMemberFromUser($_SESSION['userid'], $connect);
$isadmin = checkUserAdmin($connect, $_SESSION['userid']);

echo $_SESSION['userid'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <!--        <base href="./" />-->

    <title>iMacPlus</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">

    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">


    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->


    <link rel="stylesheet" type="text/css" href="node_modules/tiny-date-picker/tiny-date-picker.css">
    <link rel="stylesheet" type="text/css" href="node_modules/tiny-date-picker/date-range-picker.css">

    <link rel="stylesheet" type="text/css"
          href="node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css">

    <!-- include vendor stylesheets used in "Wizard & Validation" page. see "/views//pages/partials/form-wizard/@vendor-stylesheets.hbs" -->
    <link rel="stylesheet" type="text/css" href="node_modules/smartwizard/dist/css/smart_wizard.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/smartwizard/dist/css/smart_wizard_theme_circles.min.css">

    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">


    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="uploads/icon/imaclogonew.ico"/>

    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/dashboard/@page-style.css">
    <link rel="stylesheet" type="text/css" href="views/pages/page-profile/@page-style.css">


    <style>
        @font-face {
            font-family: 'SukhumvitSet-Medium';
            src: url('dist/font/SukhumvitSet-Medium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'SukhumvitSet-Bold';
            src: url('dist/font/SukhumvitSet-Bold.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "SukhumvitSet-Medium";
            font-size: 16px;
        }

        @media print {
            body {
                font-size: 10pt;
                font-family: "SukhumvitSet-Medium";
            }
        }

        @media screen {
            body {
                font-size: 13px;
                font-family: "SukhumvitSet-Medium";
            }
        }

        @media screen, print {
            body {
                line-height: 1.2;
                font-family: "SukhumvitSet-Medium";
            }
        }
    </style>
</head>

<body>
<div class="body-container">

    <div class="main-container bgc-white">


        <div role="main" class="main-content">

            <!--            <div class="page-content container container-plus">-->
            <div class="page-content">
                <!-- page header and toolbox -->


                <div id="print-area">

                    <input type="hidden" id="rec-id" value="<?= $id ?>">
                    <table style="width: 100%;border: none;">
                        <tr>
                            <td colspan="2" style="text-align: center;font-family: 'SukhumvitSet-Medium'"><h3>
                                    ใบรับเครื่องซ่อม</h3></td>

                        </tr>
                        <tr>
                            <td style="text-align: left;">เลขที่ &nbsp; &nbsp; <b><?= $work_no ?></b></td>
                            <td style="text-align: right;">วันที่ &nbsp; &nbsp;
                                <b><?= date('d-m-Y', strtotime($work_date)) ?></b></td>
                        </tr>


                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 50%">ชื่อลูกค้า &nbsp; &nbsp; <b><?= $customer_name ?></b></td>

                            <td style="width: 50%">โทรศัพท์ติดต่อ &nbsp; &nbsp; <b><?= $customer_phone ?></b></td>

                        </tr>
                    </table>
                    <table style="width: 100%;border: none;">
                        <tr>
                            <td style="width: 25%;">รับซ่อมอุปกรณ์ <span> </span>&nbsp; &nbsp;
                                <b><?= getDeviceTypeName($item_type_id, $connect) ?></b></td>
                            <td style="width: 25%;">ยี่ห้อ <span> </span>&nbsp; &nbsp;
                                <b><?= getItemBrandName($brand_id, $connect) ?></b></td>
                            <td style="width: 25%;">รุ่น <span> </span>&nbsp; &nbsp; <b><?= $item_name ?></b></td>

                            <td style="width: 25%;">สี <span> </span> &nbsp; &nbsp; <b><?= $item_color ?></b></td>

                        </tr>
                    </table>
                    <br/>
                    <table style="width: 100%;border: none;">
                        <tr>
                            <td><b>อาการเสียที่แจ้งซ่อม</b></td>

                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td style="vertical-align: top;">
                                <table>
                                    <?php if (count($col_1) > 0): ?>
                                        <?php for ($i = 0; $i <= count($col_1) - 1; $i++): ?>
                                            <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-lg fa-circle checklist" style="color: lightgrey;"
                                                       data-value="<?= $col_1[$i]['id'] ?>"></i><span> <?= $col_1[$i]['name'] ?></span>
                                                </td>
                                            </tr>

                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </table>
                            </td>
                            <td style="vertical-align: top;">
                                <table>
                                    <?php if (count($col_2) > 0): ?>
                                        <?php for ($i = 0; $i <= count($col_2) - 1; $i++): ?>
                                            <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-lg fa-circle checklist" style="color: lightgrey;"
                                                       data-value="<?= $col_2[$i]['id'] ?>"></i><span> <?= $col_2[$i]['name'] ?></span>
                                                </td>
                                            </tr>

                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </table>
                            </td>
                            <td style="vertical-align: top;">
                                <table>
                                    <?php if (count($col_3) > 0): ?>
                                        <?php for ($i = 0; $i <= count($col_3) - 1; $i++): ?>
                                            <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-lg fa-circle checklist" style="color: lightgrey;"
                                                       data-value="<?= $col_3[$i]['id'] ?>"></i><span> <?= $col_3[$i]['name'] ?></span>

                                                </td>
                                            </tr>

                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </table>
                            </td>
                            <td style="vertical-align: top;">
                                <table>
                                    <?php if (count($col_4) > 0): ?>
                                        <?php for ($i = 0; $i <= count($col_4) - 1; $i++): ?>
                                            <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                            <tr>
                                                <td>
                                                    <i class="fa fa-lg fa-circle checklist" style="color: lightgrey;"
                                                       data-value="<?= $col_4[$i]['id'] ?>"></i> <?= $col_4[$i]['name'] ?>
                                                </td>
                                            </tr>

                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <br/>
                    <table style="width: 100%;border: none;">
                        <tr>
                            <td colspan="2"><b>ลูกค้ารับทราบเงื่อนไขที่ทางร้านกำหนด
                                    และตกลงปฏิบัติตามเงื่อนไขต่อไปนี้</b></td>

                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 14px;">1.
                                    ลูกค้าต้องนำใบรับเครื่องนี้มาแสดงทุกครั้งที่มารับเครื่อง</p>
                                <p style="font-size: 14px;margin-top: -10px;">2. ลูกค้าจะต้องมารับเครื่องคืน
                                    และชำระค่าบริการภายใน 30 วันนับตั้งแต่วันส่งซ่อม หรือภายในเวลาที่ทางร้านแจ้งให้ทราบ
                                    <br> หากพ้นกำหนด 1 เดือนและไม่มารับ คิดค่าดูแลรักษาเครื่องวันละ 20
                                    บาทนับจากวันพ้นกำหนด</p>
                                <p style="font-size: 14px;margin-top: -10px;">3. หากลูกค้าไม่มารับเครื่องจนพ้นกำหนด
                                    เดือนนับตั้งแต่วันส่งซ่อม
                                    ลูกค้ายินยอมให้ทางร้านนำเครื่องไปบริจาคตามที่ทางร้านเห็นสมควรโดยไม่ติดใจเรียกร้องใดๆทั้งสิ้น</p>
                                <p style="font-size: 14px;margin-top: -10px;">4.
                                    ทางร้านรับประกันเฉพาะค่าแรงในอาการเดิมภายในระยะเวลา 1 เดือน
                                    (ซ่อมเครื่องตกน้ำและเครื่องตกจากที่สูงไม่รับประกัน
                                    เนื่องจากเครื่องบางรุ่นอาจจะมีอาการรวนได้)</p>
                                <p style="font-size: 14px;margin-top: -10px;">5. เครื่องที่โดนน้ำ หรือตกน้ำมา
                                    แล้วลูกค้าปิดเป็นความลับไม่บอกเจ้าหน้าที่
                                    หรือลูกค้าไม่รู้ตัวว่าไปโดนน้ำมาก่อนหน้านี้ เมื่อส่งเครื่องมาให้ที่ร้านอาจยังเปิดติด
                                    <br>แต่มีปัญหาในด้านอื่นๆ จังนำมาซ่อม
                                    เมื่ออยู่ที่ร้านเครื่องอาจมีอาการดับไปเองได้ทุกเมื่อจากการช๊อตคราบน้ำ
                                    ทางร้านไม่ขอรับผิดชอบในกรณีดังกล่าวทั้งสิ้น</p>
                                <p style="font-size: 14px;margin-top: -10px;">6. กรณีเครื่องใส่หรือเคยใส่ iCloud ไว้
                                    ถ้าทางร้านแจ้งลูกค้าแล้ว ถ้าติด iCloud ขึ้นมา ทางร้านจะไม่รับผิดชอบใดๆทั้งสิ้น</p>
                            </td>
                            <td style="vertical-align: top;">
                                <table style="width: 100%">
                                    <tr>
                                        <td colspan="2"><b>หมายเหตุ:</b><small>ร้านจะไม่รับซิมและ Memory ไว้</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>รหัสเข้าเครื่อง(ถ้ามี)</td>
                                        <td style="text-align: right;"><b><?= $customer_pass ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>ประเมินราคาซ่อม</td>
                                        <td style="text-align: right;border-bottom: 1px solid grey;">
                                            <b><?= number_format($estimate_price, 0) ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>มัดจำ</td>
                                        <td style="text-align: right;border-bottom: 1px solid grey;">
                                            <b><?= number_format($prepay, 0) ?></b></td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                    <br/>
                    <table style="width: 100%;border: none;">
                        <tr>
                            <td><b>ยินยอมให้ซ่อมตามเงื่อนไข</b></td>
                            <td>ผู้ส่งเครื่อง __________________________</td>
                            <td>ผู้รับเครื่องกลับ __________________________</td>
                            <td>วันที่รับ __________________________</td>
                        </tr>
                    </table>
                    <br/>
                    <br/>
                    <hr>
                    <br/>
                    <br/>

                    <div class="print-copy" style="display: ;">
                        <table style="width: 100%;border: none;">
                            <tr>
                                <td colspan="2" style="text-align: center;"><h3>ใบรับเครื่องซ่อม</h3></td>

                            </tr>
                            <tr>
                                <td style="text-align: left;">เลขที่ &nbsp; &nbsp; <b><?= $work_no ?></b></td>
                                <td style="text-align: right;">วันที่ &nbsp; &nbsp;
                                    <b><?= date('d-m-Y', strtotime($work_date)) ?></b></td>
                            </tr>


                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 50%">ชื่อลูกค้า &nbsp; &nbsp; <b><?= $customer_name ?></b></td>

                                <td style="width: 50%">โทรศัพท์ติดต่อ &nbsp; &nbsp; <b><?= $customer_phone ?></b></td>

                            </tr>
                        </table>
                        <table style="width: 100%;border: none;">
                            <tr>
                                <td style="width: 25%;">รับซ่อมอุปกรณ์ <span> </span>&nbsp; &nbsp;
                                    <b><?= getDeviceTypeName($item_type_id, $connect) ?></b></td>
                                <td style="width: 25%;">ยี่ห้อ <span> </span>&nbsp; &nbsp;
                                    <b><?= getItemBrandName($brand_id, $connect) ?></b></td>
                                <td style="width: 25%;">รุ่น <span> </span>&nbsp; &nbsp; <b><?= $item_name ?></b></td>

                                <td style="width: 25%;">สี <span> </span> &nbsp; &nbsp; <b><?= $item_color ?></b></td>

                            </tr>
                        </table>
                        <br/>
                        <table style="width: 100%;border: none;">
                            <tr>
                                <td><b>อาการเสียที่แจ้งซ่อม</b></td>

                            </tr>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="vertical-align: top;">
                                    <table>
                                        <?php if (count($col_1) > 0): ?>
                                            <?php for ($i = 0; $i <= count($col_1) - 1; $i++): ?>
                                                <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-lg fa-circle checklist"
                                                           style="color: lightgrey;"
                                                           data-value="<?= $col_1[$i]['id'] ?>"></i><span> <?= $col_1[$i]['name'] ?></span>
                                                    </td>
                                                </tr>

                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table>
                                        <?php if (count($col_2) > 0): ?>
                                            <?php for ($i = 0; $i <= count($col_2) - 1; $i++): ?>
                                                <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-lg fa-circle checklist"
                                                           style="color: lightgrey;"
                                                           data-value="<?= $col_2[$i]['id'] ?>"></i><span> <?= $col_2[$i]['name'] ?></span>
                                                    </td>
                                                </tr>

                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table>
                                        <?php if (count($col_3) > 0): ?>
                                            <?php for ($i = 0; $i <= count($col_3) - 1; $i++): ?>
                                                <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-lg fa-circle checklist"
                                                           style="color: lightgrey;"
                                                           data-value="<?= $col_3[$i]['id'] ?>"></i><span> <?= $col_3[$i]['name'] ?></span>

                                                    </td>
                                                </tr>

                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table>
                                        <?php if (count($col_4) > 0): ?>
                                            <?php for ($i = 0; $i <= count($col_4) - 1; $i++): ?>
                                                <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-lg fa-circle checklist"
                                                           style="color: lightgrey;"
                                                           data-value="<?= $col_4[$i]['id'] ?>"></i> <?= $col_4[$i]['name'] ?>
                                                    </td>
                                                </tr>

                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <br/>
                        <table style="width: 100%;border: none;">
                            <tr>
                                <td colspan="2"><b>ลูกค้ารับทราบเงื่อนไขที่ทางร้านกำหนด
                                        และตกลงปฏิบัติตามเงื่อนไขต่อไปนี้</b></td>

                            </tr>
                            <tr>
                                <td>
                                    <p style="font-size: 14px;">1.
                                        ลูกค้าต้องนำใบรับเครื่องนี้มาแสดงทุกครั้งที่มารับเครื่อง</p>
                                    <p style="font-size: 14px;margin-top: -10px;">2. ลูกค้าจะต้องมารับเครื่องคืน
                                        และชำระค่าบริการภายใน 30 วันนับตั้งแต่วันส่งซ่อม
                                        หรือภายในเวลาที่ทางร้านแจ้งให้ทราบ
                                        <br> หากพ้นกำหนด 1 เดือนและไม่มารับ คิดค่าดูแลรักษาเครื่องวันละ 20
                                        บาทนับจากวันพ้นกำหนด</p>
                                    <p style="font-size: 14px;margin-top: -10px;">3. หากลูกค้าไม่มารับเครื่องจนพ้นกำหนด
                                        เดือนนับตั้งแต่วันส่งซ่อม
                                        ลูกค้ายินยอมให้ทางร้านนำเครื่องไปบริจาคตามที่ทางร้านเห็นสมควรโดยไม่ติดใจเรียกร้องใดๆทั้งสิ้น</p>
                                    <p style="font-size: 14px;margin-top: -10px;">4.
                                        ทางร้านรับประกันเฉพาะค่าแรงในอาการเดิมภายในระยะเวลา 1 เดือน
                                        (ซ่อมเครื่องตกน้ำและเครื่องตกจากที่สูงไม่รับประกัน
                                        เนื่องจากเครื่องบางรุ่นอาจจะมีอาการรวนได้)</p>
                                    <p style="font-size: 14px;margin-top: -10px;">5. เครื่องที่โดนน้ำ หรือตกน้ำมา
                                        แล้วลูกค้าปิดเป็นความลับไม่บอกเจ้าหน้าที่
                                        หรือลูกค้าไม่รู้ตัวว่าไปโดนน้ำมาก่อนหน้านี้
                                        เมื่อส่งเครื่องมาให้ที่ร้านอาจยังเปิดติด
                                        <br>แต่มีปัญหาในด้านอื่นๆ จังนำมาซ่อม
                                        เมื่ออยู่ที่ร้านเครื่องอาจมีอาการดับไปเองได้ทุกเมื่อจากการช๊อตคราบน้ำ
                                        ทางร้านไม่ขอรับผิดชอบในกรณีดังกล่าวทั้งสิ้น</p>
                                    <p style="font-size: 14px;margin-top: -10px;">6. กรณีเครื่องใส่หรือเคยใส่ iCloud ไว้
                                        ถ้าทางร้านแจ้งลูกค้าแล้ว ถ้าติด iCloud ขึ้นมา
                                        ทางร้านจะไม่รับผิดชอบใดๆทั้งสิ้น</p>
                                </td>
                                <td style="vertical-align: top;">
                                    <table style="width: 100%">
                                        <tr>
                                            <td colspan="2"><b>หมายเหตุ:</b><small>ร้านจะไม่รับซิมและ Memory ไว้</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>รหัสเข้าเครื่อง(ถ้ามี)</td>
                                            <td style="text-align: right;"><b><?= $customer_pass ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>ประเมินราคาซ่อม</td>
                                            <td style="text-align: right;border-bottom: 1px solid grey;">
                                                <b><?= number_format($estimate_price, 0) ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>มัดจำ</td>
                                            <td style="text-align: right;border-bottom: 1px solid grey;">
                                                <b><?= number_format($prepay, 0) ?></b></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                        <br/>
                        <table style="width: 100%;border: none;">
                            <tr>
                                <td><b>ยินยอมให้ซ่อมตามเงื่อนไข</b></td>
                                <td>ผู้ส่งเครื่อง __________________________</td>
                                <td>ผู้รับเครื่องกลับ __________________________</td>
                                <td>วันที่รับ __________________________</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn btn-info" onclick="printContent('print-area')">พิมพ์</div>
                        <!--        <div class="btn btn-info" onclick="printPage('print_work_doc.php')">พิมพ์</div>-->
                    </div>
                </div>
                <footer class="footer d-none d-sm-block">
                    <div class="footer-inner bgc-white-tp1">
                        <div class="pt-3 border-none border-t-3 brc-grey-l2">
                            <span class="text-secondary-m1 font-bolder text-120">iMac Plus</span>
                            <span class="text-grey">Application &copy; <?= date('Y') ?></span>

                            <span class="mx-3 action-buttons">
<!--                      <a href="#" class="text-blue-m2 text-150"><i class="fab fa-twitter-square"></i></a>-->
                      <a href="#" class="text-blue-d2 text-150"><i class="fab fa-facebook"></i></a>
                      <a href="#" class="text-orange-d1 text-150"><i class="fa fa-rss-square"></i></a>
                   </span>
                        </div>
                    </div><!-- .footer-inner -->

                    <!-- `scroll to top` button inside footer (for example when in boxed layout) -->
                    <div class="footer-tools">
                        <a href="#" class="btn-scroll-up btn btn-dark mb-2 mr-2">
                            <i class="fa fa-angle-double-up mx-2px text-95"></i>
                        </a>
                    </div>
                </footer>


                <!-- footer toolbox for mobile view -->
                <footer class="d-sm-none footer footer-sm footer-fixed">
                    <div class="footer-inner">
                        <div class="btn-group d-flex h-100 mx-2 border-x-1 border-t-2 brc-primary-m3 bgc-white-tp1 radius-t-1 shadow">
                            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0"
                                    data-toggle="modal" data-target="#id-ace-settings-modal">
                                <i class="fas fa-sliders-h text-blue-m1 text-120"></i>
                            </button>

                            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                                <i class="fa fa-plus-circle text-green-m1 text-120"></i>
                            </button>

                            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0"
                                    data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch"
                                    aria-expanded="false" aria-label="Toggle navbar search">
                                <i class="fa fa-search text-orange text-120"></i>
                            </button>

                            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 mr-0">
                  <span class="pos-rel">
                      <i class="fa fa-bell text-purple-m1 text-120"></i>
                      <span class="badge badge-dot bgc-red position-tr mt-n1 mr-n2px"></span>
                  </span>
                            </button>
                        </div>
                    </div>
                </footer>
            </div>


        </div>
    </div>

    <!-- include common vendor scripts used in demo pages -->
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

    <script src="./node_modules/tiny-date-picker/dist/date-range-picker.js"></script>
    <script src="./node_modules/moment/moment.js"></script>
    <script src="./node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

    <!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->
    <!--<script src="node_modules/chart.js/dist/Chart.js"></script>-->


    <script src="node_modules/sortablejs/dist/sortable.umd.js"></script>


    <!-- include ace.js -->
    <script src="dist/js/ace.js"></script>


    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="app/browser/demo.js"></script>

    <script src="node_modules/datatables/media/js/jquery.dataTables.js"></script>
    <script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
    <script src="node_modules/datatables.net-select/js/dataTables.select.js"></script>


    <!--alert-->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="node_modules/interactjs/dist/interact.js"></script>

    <!-- include vendor scripts used in "Wizard & Validation" page. see "/views//pages/partials/form-wizard/@vendor-scripts.hbs" -->
    <script src="node_modules/smartwizard/dist/js/jquery.smartWizard.js"></script>


    <script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>

    <script src="node_modules/inputmask/dist/jquery.inputmask.js"></script>


    <!-- Cookie Consent by https://www.cookiewow.com -->
    <script type="text/javascript" src="https://cookiecdn.com/cwc.js"></script>
    <script id="cookieWow" type="text/javascript" src="https://cookiecdn.com/configs/Jym9Mew5dSqHUru8AVmSbTHX"
            data-cwcid="Jym9Mew5dSqHUru8AVmSbTHX"></script>

    <!-- "Dashboard" page script to enable its demo functionality -->
    <!--<script src="views/pages/dashboard/@page-script.js"></script>-->
    <script src="views/pages/page-profile/@page-script.js"></script>
    <script src="views/pages/form-wizard/@page-script.js"></script>
</body>

</html>
<script>
    calcheck();

    function calcheck() {
        var recid = $("#rec-id").val();
        var checklist = null;
        // alert(recid);
        if (recid > 0) {
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_workorder_update.php',
                'data': {'id': recid},
                'success': function (data) {

                    if (data.length > 0) {
                        checklist = data[0]['check_list'];
                    }
                },
                'error': function (err) {
                    alert('ee');
                }
            });
            if (checklist.length > 0) {
                $(".checklist").each(function () {

                    var id_value = $(this).attr("data-value");
                    for (var x = 0; x <= checklist.length - 1; x++) {
                        if (id_value == checklist[x]['check_list_id']) {
                            //   alert();
                            $(this).removeClass("fa-circle");
                            $(this).addClass("fa-check-circle");
                            $(this).addClass("text-dark");
                        }
                    }
                    // console.log('xx');
                });

            }
        }

    }

    function closePrint() {
        document.body.removeChild(this.__container__);
    }

    function setPrint() {
        this.contentWindow.__container__ = this;
        this.contentWindow.onbeforeunload = closePrint;
        this.contentWindow.onafterprint = closePrint;
        this.contentWindow.focus(); // Required for IE
        this.contentWindow.print();
    }

    function printPage(sURL) {
        $(".print-copy").show();
        const hideFrame = document.createElement("iframe");
        hideFrame.onload = setPrint;
        hideFrame.style.position = "fixed";
        hideFrame.style.right = "0";
        hideFrame.style.bottom = "0";
        hideFrame.style.width = "0";
        hideFrame.style.height = "0";
        hideFrame.style.border = "0";
        hideFrame.src = sURL;
        document.body.appendChild(hideFrame);
    }

    function printContent(el) {
        $(".print-copy").show();
        // var css= '<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">';
        // document.head.innerHTML = css;
        //  var restorepage = document.body.innerHTML;
        //  var printcontent = document.getElementById(el).innerHTML;
        //  document.body.innerHTML = printcontent;
        //  window.print();
        //  document.body.innerHTML = restorepage;


        // var css= '<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">';
        // var printContent = document.getElementById(el);
        //
        // var WinPrint = window.open('', '', 'width=900,height=900');
        // WinPrint.document.write(printContent.innerHTML);
        // WinPrint.document.head.innerHTML = css;
        // WinPrint.document.close();
        // WinPrint.focus();
        // WinPrint.print();
        // WinPrint.close();

        var contents = $("#print-area").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        //  frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>DIV Contents</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.


        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="dist/css/ace.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="mycss.css">');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


    }
</script>
