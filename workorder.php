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

//$position_data = getPositionmodel($connect);
//$per_check = checkPer($user_position,"is_product_cat", $connect);
//if(!$per_check){
//    header("location:errorpage.php");
//}

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


$noti_ok = '';
$noti_error = '';
$status_data = [['id' => 1, 'name' => 'Active'], ['id' => 0, 'name' => 'Inactive']];

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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">คำสั่งซ่อม</h1>
    <div class="btn-group">
        <a href="#" class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90"
           onclick="showaddbank($(this))">
                  <span class="d-none d-sm-inline mr-1">
                    สร้าง
                  </span>
            <i class="fa fa-save text-110 w-2 h-2"></i>
        </a>

        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showaddbank($(this))"><i-->
        <!--                class="fas fa-plus-circle fa-sm text-white-50"></i> สร้างใหม่</a>-->
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="unit_action.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
            <input type="hidden" name="action_type" value="delete">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>เลขที่ใบสั่งซ่อม</th>
                    <th>วันที่</th>
                    <th>ลูกค้า</th>
                    <th>สถานะ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="workorder_action.php" id="form-workorder" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">สร้างคำสั่งซ่อม</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">เลขที่ใบสั่งซ่อม</label>
                            <input type="text" class="form-control workorder-no" name="workorder_no" value=""
                                   placeholder="เลขที่">
                        </div>
                        <div class="col-lg-3">
                            <label for="">วันที่</label>
                            <input type="text" class="form-control workorder-date" name="workorder_date" value=""
                                   placeholder="วันที่">
                        </div>
                        <div class="col-lg-3">
                            <label for="">ลูกค้า</label>
                            <select class="form-control customer-id" name="customer_id" id="">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">เบอร์โทร</label>
                            <input type="text" class="form-control phone" name="phone" value=""
                                   placeholder="เบอร์โทร">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">รับซ่อมโทรศัพท์มือถือยี่ห้อ</label>
                            <select name="phone_brand" class="form-control phone-brand" id="">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">รุ่น</label>
                            <select name="phone_model" class="form-control phone-model" id="">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">สี</label>
                            <input type="text" class="form-control phone-color" name="phone_color" value=""
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
                                    <?php $check_id = 'check'.$col_1[$i]['id'] ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_list[]" id="<?=$check_id?>" style="border-radius: 10px;"
                                                       value="<?= $col_1[$i]['id'] ?>" onclick="checkselected($(this))"><span> <?= $col_1[$i]['name'] ?></span>
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
                                        <?php $check_id = 'check'.$col_1[$i]['id'] ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_list[]" id="<?=$check_id?>" style="border-radius: 10px;"
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
                                        <?php $check_id = 'check'.$col_1[$i]['id'] ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_list[]" id="<?=$check_id?>" style="border-radius: 10px;"
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
                                        <?php $check_id = 'check'.$col_1[$i]['id'] ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_list[]" id="<?=$check_id?>" style="border-radius: 10px;"
                                                       value="<?= $col_4[$i]['id'] ?>"><span> <?= $col_4[$i]['name'] ?></span>
                                            </td>
                                        </tr>

                                    <?php endfor; ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">รหัสเข้าเครื่อง</label>
                            <input type="text" class="form-control customer-pass" name="customer_pass" value="">
                        </div>
                        <div class="col-lg-3">
                            <label for="">ราคาประเมิณการซ่อม</label>
                            <input type="text" class="form-control estimate-price" name="estimate_price" value="">
                        </div>
                        <div class="col-lg-3">
                            <label for="">มัดจำ</label>
                            <input type="text" class="form-control pre-pay" name="pre_pay" value="">
                        </div>
                        <div class="col-lg-3">
                            <label for="">สถานะ</label>
                            <select name="status" id="" class="form-control status">
                                <?php for ($i = 0; $i <= count($status_data) - 1; $i++): ?>
                                    <option value="<?= $status_data[$i]['id'] ?>"><?= $status_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <br>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i
                                class="fa fa-save"></i> Save
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    notify();
    function checkselected(e){
        // var c_value = e.attr('checked');
        // alert(c_value);
    }
    function showaddbank(e) {
        $(".user-recid").val(0);
        $(".bank-name").val('');
        $(".description").val('');
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
            url: "unit_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });

    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var code = '';
            var name = '';
            var description = '';
            var status = '';
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_unit_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        code = data[0]['code'];
                        name = data[0]['name'];
                        description = data[0]['description'];
                        status = data[0]['status'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".status").val(status);
            $(".unit-code").val(code);
            $(".unit-name").val(name);
            $(".description").val(description);

            $(".modal-title").html('แก้ไขข้อมูลยหน่วยนับ');
            $(".action-type").val('update');
            $("#myModal").modal("show");
        }
    }

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
</script>
