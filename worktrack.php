<?php
include "header.php";
include "models/WorkorderModel.php";

$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

//echo $_GET['id'];
$workorder_data = getWorkorder($connect,$id);
//print_r($workorder_data);

?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">


<div class="row">
    <div class="col-lg-10">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="h3 mb-0 text-gray-800">สถานะใบสั่งซ่อม</h3>

        </div>
    </div>
    <div class="col-lg-2" style="text-align: right;">
<!--        <div class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90"-->
<!--             onclick="showaddWallet($(this))">-->
<!--                  <span class="d-none d-sm-inline mr-1">-->
<!--                สร้างรายการเติม Wallet-->
<!--            </span>-->
<!---->
<!--        </div>-->
    </div>
</div>
<br/>
<div class="row">
    <div class="col-lg-12" style="text-align: center;"><h3>เลขที่ใบสั่งซ่อม <?= $workorder_data[0]['work_no'] ?></h3></div>
</div>
<div class="row">
    <div class="col-lg-12" style="text-align: center;"><h3 style="color: #0f64a9"><?= $workorder_data[0]['phone_model_id'] ?></h3></div>
</div>
<br />
<div id="smartwizard-1" class="d-none mx-n3 mx-sm-auto">
    <ul class="mx-auto">
        <li>
            <a href="#step-1">
                            <span class="step-title">
                                1
                            </span>

                <span class="step-title-done">
                                <i class="fa fa-check text-success"></i>
                            </span>
            </a>

            <span class="step-description">
                           รับคำสั่งซ่อม
                        </span>
        </li>

        <li>
            <a href="#step-2">
                            <span class="step-title">
                                2
                            </span>

                <span class="step-title-done">
                                <i class="fa fa-check text-success"></i>
                            </span>
            </a>

            <span class="step-description">
                            กำลังดำเนินการซ่อม
                        </span>
        </li>


        <li>
            <a href="#step-3">
                            <span class="step-title">
                                3
                            </span>

                <span class="step-title-done">
                                <i class="fa fa-check text-success"></i>
                            </span>
            </a>

            <span class="step-description">
                            ระหว่างส่งคืน
                        </span>
        </li>


        <li>
            <a href="#step-4">
                            <span class="step-title">
                                4
                            </span>

                <span class="step-title-done">
                                <i class="fa fa-check text-success"></i>
                            </span>
            </a>

            <span class="step-description">
                            คืนลูกค้าสำเร็จ
                        </span>
        </li>
    </ul>


<!--    <div class="px-2 py-2 mb-4">-->
<!--        <div id="step-1">-->
<!--          <div class="row">-->
<!---->
<!--              <div class="col-lg-12">-->
<!--                  <table style="border: 0px;width: 100%">-->
<!--                      <tr>-->
<!--                          <td style="width: 20%"></td>-->
<!--                          <td style="width: 20%;background-color: lightgrey;padding: 10px;">07/07/2022 18:26</td>-->
<!--                          <td style="width: 40%;background-color: lightgrey;padding: 10px;">รับเครื่อง Drop off</td>-->
<!--                          <td style="width: 20%"></td>-->
<!--                      </tr>-->
<!--                      <tr>-->
<!--                          <td style="width: 20%"></td>-->
<!--                          <td style="width: 20%;background-color: lightgrey;padding: 10px;">07/07/2022 18:50</td>-->
<!--                          <td style="width: 40%;background-color: lightgrey;padding: 10px;">ตรวจสอบพร้อมส่งต่อ Center</td>-->
<!--                          <td style="width: 20%"></td>-->
<!--                      </tr>-->
<!--                  </table>-->
<!--              </div>-->
<!--          </div>-->
<!--        </div>-->
<!---->
<!---->
<!--        <div id="step-2">-->
<!---->
<!--        </div>-->
<!---->
<!---->
<!--        <div id="step-3" class="text-center">-->
<!--            <h3 class="font-light text-primary my-4">-->
<!--                Select Payment Method-->
<!--            </h3>-->
<!--        </div>-->
<!---->
<!---->
<!--        <div id="step-4" class="text-center">-->
<!---->
<!--        </div>-->
<!--    </div>-->
</div>
<?php
include "footer.php";
?>
