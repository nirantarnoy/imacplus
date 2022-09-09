<?php
ob_start();
session_start();

//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";
include("models/StatusModel.php");
include("models/ChecklistModel.php");
include("models/ItembrandModel.php");
include("models/ProvinceModel.php");
include("models/work_delivery_type.php");
include("models/WorkorderStatus.php");
include("models/WorkorderModel.php");
include("models/CenterModel.php");


//$position_data = getPositionmodel($connect);
//$per_check = checkPer($user_position,"is_product_cat", $connect);
//if(!$per_check){
//    header("location:errorpage.php");
//}

$checklist_data = getChecklistmodel($connect);
$item_brand_data = getItembrandData($connect);
$item_model_data = getItemModelData($connect);
$item_type_data = getDeviceTypeData($connect);
$item_center_data = getMemberCenterData($connect);
$provice_data = getProvincemodel($connect);
$delivery_type_data = getDeliveryTypeData($connect);


$col_1 = [];
$col_2 = [];
$col_3 = [];
$col_4 = [];

$item_nums = 0;

$workorder_data = [];
$work_checklist = [];
$work_photo = [];
$work_video = [];
$edit_id = 0;
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];

    $workorder_data = getOrderIdById($connect, $edit_id);
    $work_photo = getWorkorderPhoto($connect, $edit_id);
    $work_video = getWorkorderVideo($connect, $edit_id);
}

$workorder_id = 0;
$workorder_no = '';
$work_date = null;
$customer_name = '';
$customer_phone = '';
$device_type = -1;
$item_model = -1;
$item_brand = -1;
$item_color = '';
$estimate_price = 0;
$customer_pass = '';
$prepay = 0;
$estimate_finish = null;
$status = -1;
$center_id = 0;
$delivery_type = -1;

if (count($workorder_data) > 0) {
    for ($i = 0; $i <= count($workorder_data) - 1; $i++) {
        $workorder_id = $workorder_data[$i]['id'];
        $workorder_no = $workorder_data[$i]['work_no'];
        $work_date = $workorder_data[$i]['work_date'];
        $customer_name = $workorder_data[$i]['customer_name'];
        $customer_phone = $workorder_data[$i]['phone'];
        $device_type = $workorder_data[$i]['device_type'];
        $item_model = $workorder_data[$i]['models'];
        $item_brand = $workorder_data[$i]['brand'];
        $item_color = $workorder_data[$i]['phone_color'];
        $estimate_price = $workorder_data[$i]['estimate_price'];
        $customer_pass = $workorder_data[$i]['customer_pass'];
        $prepay = $workorder_data[$i]['pre_pay'];
        $status = $workorder_data[$i]['status'];
        $estimate_finish = $workorder_data[$i]['finish_date'];
        $center_id = $workorder_data[$i]['center_id'];
        $delivery_type = $workorder_data[$i]['delivery_type_id'];
        $work_checklist = $workorder_data[$i]['check_list'];
    }
}


//echo $edit_id;


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


$noti_ok = '';
$noti_error = '';
$action_type = 'create';
if ($edit_id > 0) {
    $action_type = 'update';
}
//$status_data = [['id' => 0, 'name' => 'รับคำสั่งซ่อม'], ['id' => 1, 'name' => 'กำลังซ่อม'],['id'=>2,'name'=>'ซ่อมเสร็จ']];
$status_data = getWorkorderStatusData();
if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">
<div class="row">
    <div class="col-lg-12">
        <form action="workorder_action.php" id="form-workorder" method="post" enctype="multipart/form-data">
            <input type="hidden" class="update-status" name="update_status" value="0">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="color: #1c606a">สร้างคำสั่งซ่อม</h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="recid" class="user-recid" value="<?= $workorder_id ?>">
                <input type="hidden" name="action_type" class="action-type" value="<?= $action_type ?>">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">เลขที่ใบสั่งซ่อม</label>
                        <input type="text" class="form-control workorder-no" name="workorder_no"
                               value="<?= $workorder_no ?>"
                               placeholder="เลขที่" readonly>
                    </div>
                    <div class="col-lg-3">
                        <label for="">วันที่</label>
                        <!--                            <input type="text" class="form-control workorder-date" name="workorder_date" value=""-->
                        <!--                                   placeholder="วันที่">-->
                        <input type="text" class="form-control work-date" name="workorder_date"
                               value="<?= $workorder_id > 0 ? date('d/m/Y', strtotime($work_date)) : date('d/m/Y') ?>"
                               placeholder="วันที่" readonly>
                    </div>
                    <div class="col-lg-3">
                        <label for="">ลูกค้า</label>
                        <input type="text" class="form-control customer-name" name="customer_name"
                               value="<?= $customer_name ?>"
                               placeholder="ลูกค้า">

                    </div>
                    <div class="col-lg-3">
                        <label for="">เบอร์โทร</label>
                        <input type="text" class="form-control phone" name="phone" value="<?= $customer_phone ?>"
                               placeholder="เบอร์โทร">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">ประเภทอุปกรณ์</label>
                        <!--                            <select name="phone_brand" class="form-control phone-brand" id="" onchange="findbrandmodel($(this))">-->
                        <select name="device_type" class="form-control device-type" id="">
                            <option value="-1">--เลือกประเภทอุปกรณ์--</option>
                            <?php for ($i = 0; $i <= count($item_type_data) - 1; $i++): ?>
                                <?php
                                $selected = '';
                                if ($item_type_data[$i]['id'] == $device_type) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $item_type_data[$i]['id'] ?>" <?= $selected ?>><?= $item_type_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="">รับซ่อมโทรศัพท์มือถือยี่ห้อ</label>
                        <!--                            <select name="phone_brand" class="form-control phone-brand" id="" onchange="findbrandmodel($(this))">-->
                        <select name="phone_brand" class="form-control phone-brand" id="">
                            <option value="-1">--เลือกยี่ห้อ--</option>
                            <?php for ($i = 0; $i <= count($item_brand_data) - 1; $i++): ?>
                                <?php
                                $selected = '';
                                if ($item_brand_data[$i]['id'] == $item_brand) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $item_brand_data[$i]['id'] ?>" <?= $selected ?>><?= $item_brand_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="">รุ่น</label>
                        <select name="phone_model" class="form-control phone-model" id=""
                                onchange="findBrandid($(this))">
                            <option value="">--เลือกรุ่น--</option>
                            <?php for ($i = 0; $i <= count($item_model_data) - 1; $i++): ?>
                                <?php
                                $selected = '';
                                if ($item_model_data[$i]['id'] == $item_model) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $item_model_data[$i]['id'] ?>" <?= $selected ?>><?= $item_model_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="">สี</label>
                        <input type="text" class="form-control phone-color" name="phone_color"
                               value="<?= $item_color ?>"
                               placeholder="สี">
                    </div>
                </div>
                <br>
                <h3>อาการเสียที่แจ้งซ่อม</h3>
                <div class="row">
                    <div class="col-lg-3">
                        <table>
                            <?php if (count($col_1) > 0): ?>
                                <?php for ($i = 0; $i <= count($col_1) - 1; $i++): ?>
                                    <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                    <?php
                                    $ischecked = '';
                                    for ($m = 0; $m <= count($work_checklist) - 1; $m++) {
                                        if ($work_checklist[$m]['check_list_id'] == $col_1[$i]['id']) {
                                            $ischecked = 'checked';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]"
                                                   id="<?= $check_id ?>" <?= $ischecked ?>
                                                   style="border-radius: 10px;"
                                                   value="<?= $col_1[$i]['id'] ?>"
                                                   onclick="checkselected($(this))"><span> <?= $col_1[$i]['name'] ?></span>
                                        </td>
                                    </tr>

                                <?php endfor; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-lg-3">
                        <table>
                            <?php if (count($col_2) > 0): ?>
                                <?php for ($i = 0; $i <= count($col_2) - 1; $i++): ?>
                                    <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                    <?php
                                    $ischecked = '';
                                    for ($m = 0; $m <= count($work_checklist) - 1; $m++) {
                                        if ($work_checklist[$m]['check_list_id'] == $col_2[$i]['id']) {
                                            $ischecked = 'checked';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]"
                                                   id="<?= $check_id ?>" <?= $ischecked ?>
                                                   style="border-radius: 10px;"
                                                   value="<?= $col_2[$i]['id'] ?>"><span> <?= $col_2[$i]['name'] ?></span>
                                        </td>
                                    </tr>

                                <?php endfor; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-lg-3">
                        <table>
                            <?php if (count($col_3) > 0): ?>
                                <?php for ($i = 0; $i <= count($col_3) - 1; $i++): ?>
                                    <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                    <?php
                                    $ischecked = '';
                                    for ($m = 0; $m <= count($work_checklist) - 1; $m++) {
                                        if ($work_checklist[$m]['check_list_id'] == $col_3[$i]['id']) {
                                            $ischecked = 'checked';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]"
                                                   id="<?= $check_id ?>" <?= $ischecked ?>
                                                   style="border-radius: 10px;"
                                                   value="<?= $col_3[$i]['id'] ?>"><span> <?= $col_3[$i]['name'] ?></span>
                                        </td>
                                    </tr>

                                <?php endfor; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-lg-3">
                        <table>
                            <?php if (count($col_4) > 0): ?>
                                <?php for ($i = 0; $i <= count($col_4) - 1; $i++): ?>
                                    <?php $check_id = 'check' . $col_1[$i]['id'] ?>
                                    <?php
                                    $ischecked = '';
                                    for ($m = 0; $m <= count($work_checklist) - 1; $m++) {
                                        if ($work_checklist[$m]['check_list_id'] == $col_4[$i]['id']) {
                                            $ischecked = 'checked';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="check_list[]"
                                                   id="<?= $check_id ?>" <?= $ischecked ?>
                                                   style="border-radius: 10px;"
                                                   value="<?= $col_4[$i]['id'] ?>"><span> <?= $col_4[$i]['name'] ?></span>
                                        </td>
                                    </tr>

                                <?php endfor; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">รหัสเข้าเครื่อง</label>
                        <input type="text" class="form-control customer-pass" name="customer_pass"
                               value="<?= $customer_pass ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="">ราคาประเมิณการซ่อม</label>
                        <input type="number" autocomplete="off" class="form-control estimate-price"
                               name="estimate_price" value="<?= $estimate_price ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="">มัดจำ</label>
                        <input type="number" autocomplete="off" class="form-control pre-pay" name="pre_pay"
                               value="<?= $prepay ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="">สถานะ</label>
                        <select name="status" id="" class="form-control status" readonly>
                            <?php for ($i = 0; $i <= count($status_data) - 1; $i++): ?>
                                <?php
                                $selected = '';
                                if ($status_data[$i]['id'] == $status) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $status_data[$i]['id'] ?>" <?= $selected ?>><?= $status_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="">วันที่ซ่อมเสร็จโดยประมาณ</label>
                        <input type="text" class="form-control work-finish-date" name="work_finish_date"
                               value="<?= $workorder_id > 0 ? date('d-m-Y', strtotime($estimate_finish)) : date('d-m-Y') ?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="">Center</label>
                        <div class="input-group">
                            <input type="text" class="form-control center-name"
                                   value="<?= getCenterName($center_id, $connect) ?>" name="center_name">
                            <div class="btn btn-secondary" onclick="showfindcenter()">เลือก</div>
                        </div>

                        <input type="hidden" class="center-id" value="<?= $center_id ?>" name="center_id">
                    </div>
                    <div class="col-lg-3">
                        <label for="">ประเภทการส่งซ่อม</label>
                        <select name="delivery_type_id" id="" class="form-control delivery-type-id">
                            <?php for ($i = 0; $i <= count($delivery_type_data) - 1; $i++): ?>
                                <?php
                                $selected = '';
                                if ($delivery_type_data[$i]['id'] == $delivery_type) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?= $delivery_type_data[$i]['id'] ?>" <?= $selected ?>><?= $delivery_type_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <div style="height: 25px;"></div>
                        <?php $quotation_id = getQuotationId($connect, $workorder_id);?>
                        <?php if($quotation_id > 0):?>
                        <a href="print_quotation.php?id=<?=$quotation_id?>" class="btn btn-default text-white">ตรวจสอบใบเสนอราคา</a>
                        <?php endif;?>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6">
                        <input type="file" name="upload_file[]" multiple accept="image/jpeg">
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6">
                        <h6><b>รูปภาพก่อนซ่อม</b></h6>
                    </div>
                </div>
                <div class="row">
                    <?php for ($i = 0; $i <= count($work_photo) - 1; $i++): ?>
                        <div class="col-lg-3">
                            <img src="uploads/workorder/<?= $work_photo[$i]['photo'] ?>" alt="" style="width: 100%">
                        </div>
                    <?php endfor; ?>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6">
                        <h6><b>รูปภาพ/วีดีโอ หลังซ่อม</b></h6>
                    </div>
                </div>
                <div class="row">
                    <?php for ($i = 0; $i <= count($work_video) - 1; $i++): ?>
                        <div class="col-lg-3">
                            <img src="uploads/workorder/video/<?= $work_video[$i]['video'] ?>" alt=""
                                 style="width: 100%">
                        </div>
                    <?php endfor; ?>
                </div>
                <br/>
                <br/>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <?php if ($status == 1): ?>
                    <div class="btn btn-secondary btn-create-quotation" onclick="createQuotation($(this))">

                        <i
                                class="fa fa-check-circle"></i> เสนอราคา
                    </div>
                <?php endif; ?>
                <?php if ($status == 4): ?>
                    <div class="btn btn-primary btn-close-final" onclick="createworkfinal($(this))">

                        <i
                                class="fa fa-trophy"></i> ยืนยันการซ่อมสำเร็จ
                    </div>
                <?php endif; ?>
                <?php if ($status == 3): ?>
                    <div class="btn btn-secondary btn-close-work" onclick="closeworkorder($(this))">

                        <i
                                class="fa fa-check-circle"></i> ปิดใบแจ้งซ่อม
                    </div>
                <?php endif; ?>
                <?php if ($status == 0): ?>
                    <div class="btn btn-info btn-receive" data-dismiss="modalx"><i
                                class="fa fa-check-circle"></i> ตรวจรับเครื่อง
                    </div>
                <?php endif; ?>
                <?php if ($status < 6 || $status == -1): ?>
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i
                                class="fa fa-save"></i> บันทึก
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<form id="form-create-quotation" action="quotation_create.php?ref_id=<?=$workorder_id?>" method="post">
    <input type="hidden" class="user-recid" value="" name="ref_id">
</form>
<form id="form-close-work" action="workorderclose.php" method="post">
    <input type="hidden" class="user-recid" value="<?=$workorder_id?>" name="ref_id">
</form>
<form id="form-close-work-final" action="workorder_action.php" method="post">
    <input type="hidden" class="user-recid" value="<?=$workorder_id?>" name="recid">
    <input type="hidden" name="action_type" value="complete">
</form>
<div class="modal" id="findCenterModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div style="padding: 10px;">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="">เลือกจังหวัด</label>
                        <select name="province_id" id="" class="form-control province-id"
                                onchange="findCenterByProvince($(this))">
                            <?php for ($i = 0; $i <= count($provice_data) - 1; $i++): ?>
                                <option value="<?= $provice_data[$i]['id'] ?>"><?= $provice_data[$i]['name'] ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered" id="table-find-center">
                            <thead>
                            <tr>
                                <th>เลือก</th>
                                <th>ชื่อศูนย์บริการ</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> ยกเลิก
            </button>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    notify();
    $('.work-finish-date').datetimepicker({format: "DD-MM-yyyy"});
    //        var TinyDatePicker = DateRangePicker.TinyDatePicker;
    //        TinyDatePicker('.workorder-date', {
    //            dateFormat: 'dd-mm-yy',
    //            mode: 'dp-below',
    //        })
    //        .on('statechange', function(ev) {
    //
    //        })

    $(".btn-receive").click(function(){
        $(".update-status").val(1);
        $("form#form-workorder").submit();
    });

    $(".btn-close-final").click(function(){
        $(".update-status").val(4);
        $("form#form-workorder").submit();
    });

    function checkselected(e) {
        // var c_value = e.attr('checked');
        // alert(c_value);
    }

    function createQuotation(e) {
        //alert();
        $("#form-create-quotation").submit();
    }

    function closeworkorder(e) {
        //alert();
        $("#form-close-work").submit();
    }

    function createworkfinal(e) {
        //alert();
        $("#form-close-work-final").submit();
    }

    function showaddbank(e) {
        $(".user-recid").val(0);
        $(".workorder-no").val('');
        $(".work-date").val('');
        $(".customer-name").val('');
        $(".customer-pass").val('');
        $(".phone-brand").val(-1).change();
        $(".phone-color").val('');
        $(".phone-model").val(-1).change();
        $(".device-type").val(-1).change();
        $(".estimate-price").val('');
        $(".pre-pay").val('');
        $(".status").val(-1).change();

        $("input[type=checkbox]").each(function () {
            $(this).prop('checked', '');
        });

        $(".modal-title").html('สร้างข้อมูลใบสั่งซ่อม');
        $(".action-type").val('create');

        $("#myModal").modal("show");
    }

    $("#dataTable").dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[1, "asc"]],
        "language": {
            "sSearch": "ค้นหา",
            "sLengthMenu": "แสดง _MENU_ รายการ",
            "sInfo": "กำลังแสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "oPaginate": {
                "sNext": "ถัดไป",
                "sPrevious": "ก่อนหน้า",
                "sInfoFiltered": "( ค้นหาจาก _MAX_ รายการ )"
            }
        },
        "ajax": {
            url: "workorder_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });



    function recDelete(e) {
        var recid = e.attr('data-id');
        $(".delete-id").val(recid);
        var swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-2',
                cancelButton: 'btn btn-danger mx-2'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'ยืนยัน?',
            text: "คุณต้องการลบข้อมูลใช่หรือไม่!",
            type: 'warning',
            showCancelButton: true,
            scrollbarPadding: false,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $("#form-delete").submit();
            }
        })
        //e.preventDefault();
        // var recid = e.attr('data-id');
        // $(".delete-id").val(recid);
        // swal({
        //     title: "Are you sure to delete?",
        //     text: "",
        //     type: "warning",
        //     showCancelButton: true,
        //     closeOnConfirm: false,
        //     showLoaderOnConfirm: true
        // }, function () {
        //
        //     $("#form-delete").submit();
        //     // e.attr("href",url);
        //     // e.trigger("click");
        // });
    }

    function findbrandmodel(e) {
        var brand_id = e.val();
        if (brand_id != null) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_item_model.php',
                'data': {'id': brand_id},
                'success': function (data) {
                    if (data != "") {
                        $(".phone-model").html(data);
                    }

                }
            });
        }
    }

    function findBrandid(e) {
        var model_id = e.val();
        if (model_id != null) {
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'get_item_brand.php',
                'data': {'id': model_id},
                'success': function (data) {
                    if (data != "") {
                        $(".phone-brand").val(data).change();
                    }

                }
            });
        }
    }

    function showfindcenter() {
        // $.ajax({
        //     'type': 'post',
        //     'dataType': 'html',
        //     'async': false,
        //     'url': 'find_center_data.php',
        //     'data': {},
        //     'success': function (data) {
        //
        //     }
        // });
        $("#findCenterModal").modal("show");
    }

    function findCenterByProvince(e) {
        var id = e.val();
        if (id != '') {
            // alert(id);
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'find_center_data.php',
                'data': {'province_id': id},
                'success': function (data) {
                    $("#table-find-center tbody").html(data);
                }
            });
        }

    }

    function notify() {
        // $.toast({
        //     title: 'Message Notify',
        //     subtitle: '',
        //     content: 'eror',
        //     type: 'success',
        //     delay: 3000,
        //     // img: {
        //     //     src: 'image.png',
        //     //     class: 'rounded',
        //     //     title: 'แจ้งการทำงาน',
        //     //     alt: 'Alternative'
        //     // },
        //     pause_on_hover: false
        // });
        var msg_ok = $(".msg-ok").val();
        var msg_error = $(".msg-error").val();
        if (msg_ok != '') {
            $.aceToaster.add({
                placement: 'tr',
                body: "<p class='p-3 mb-0 text-center'>\
                        <span class='d-inline-block text-center mb-3 py-3 px-1 border-1 brc-success radius-round'>\
                            <i class='fa fa-check fa-2x w-6 text-success-m1 mx-2px'></i>\
                        </span><br />\
                        บันทึกข้อมูลสำเร็จ\
                    </p>\
                    <button data-dismiss='toast' class='btn btn-block btn-success radius-t-0 border-0'>OK</button></div>",

                width: 360,
                delay: 5000,

                close: false,

                className: 'bgc-white-tp1 shadow ',

                bodyClass: 'border-0 p-0 text-dark-tp2',
                headerClass: 'd-none',
            })
            // $.toast({
            //     title: 'แจ้งเตือนการทำงาน',
            //     subtitle: '',
            //     content: msg_ok,
            //     type: 'success',
            //     delay: 3000,
            //     // img: {
            //     //     src: 'image.png',
            //     //     class: 'rounded',
            //     //     title: 'แจ้งการทำงาน',
            //     //     alt: 'Alternative'
            //     // },
            //     pause_on_hover: false
            // });
        }
        if (msg_error != '') {
            $.aceToaster.add({
                placement: 'tr',
                body: "<div class='p-3 m-2 d-flex'>\
                     <span class='align-self-center text-center mr-3 py-2 px-1 border-1 bgc-danger radius-round'>\
                        <i class='fa fa-times text-180 w-4 text-white mx-2px'></i>\
                     </span>\
                     <div>\
                        <h4 class='text-dark-tp3'>มีบางอย่างผิดพลาด</h4>\
                        <span class='text-dark-tp3 text-110'>กรูณาติดต่อผู้ดูแลระบบ</span>\
                     </div>\
                    </div>\
                    <button data-dismiss='toast' class='btn text-grey btn-h-light-danger position-tr mr-1 mt-1'><i class='fa fa-times'></i></button></div>",

                width: 480,
                delay: 5000,

                close: false,

                className: 'shadow border-none radius-0 border-l-4 brc-danger',

                bodyClass: 'border-0 p-0',
                headerClass: 'd-none'
            })
            // $.toast({
            //     title: 'แจ้งเตือนการทำงาน',
            //     subtitle: '',
            //     content: msg_error,
            //     type: 'danger',
            //     delay: 3000,
            //     // img: {
            //     //     src: 'image.png',
            //     //     class: 'rounded',
            //     //     title: 'แจ้งการทำงาน',
            //     //     alt: 'Alternative'
            //     // },
            //     pause_on_hover: false
            // });
        }

    }

    function addselecteditem(e) {
        // alert('hi');return;
        var id = e.attr('data-var');
        var name = e.closest('tr').find('.line-find-name').val();

        if (id) {
            $(".center-id").val(id);
            $(".center-name").val(name);
        }

        $("#findCenterModal").modal("hide");
    }

    function disableselectitem() {
        if (selecteditem.length > 0) {
            $(".btn-product-selected").prop("disabled", "");
            $(".btn-product-selected").removeClass('btn-outline-success');
            $(".btn-product-selected").addClass('btn-success');
        } else {
            $(".btn-product-selected").prop("disabled", "disabled");
            $(".btn-product-selected").removeClass('btn-success');
            $(".btn-product-selected").addClass('btn-outline-success');
        }
    }
</script>
