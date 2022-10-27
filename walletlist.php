<?php
ob_start();
session_start();
include "header.php";

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


<div class="row">
    <div class="col-lg-10">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="h3 mb-0 text-gray-800">รายการเติม Wallet</h3>

        </div>
    </div>
    <div class="col-lg-2" style="text-align: right;">
        <div class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90"
             onclick="showaddWallet($(this))">
                  <span class="d-none d-sm-inline mr-1">
                สร้างรายการเติม Wallet
            </span>

        </div>
    </div>
</div>
<br/>
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
                    <td>#</td>

                    <th>เลขที่รายการ</th>
                    <th>วันที่ทำรายการ</th>
                    <th>จำนวนเงินเติม</th>
                    <th>สถานะ</th>

                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="add_member_wallet.php" id="form-user" method="post" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">สร้างรายการเติม Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="member_id" class="user-recid" value="5">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><i class="fa fa-edit"></i> <span> <b>วิธีเติมวอลเล็ท</b></span></label>
                            <p style="color: blue;font-size: 14px;">
                                โอนเงินเข้าบัญชี ไทยพาณิชย์ 426-128-677-8 <br>
                                ชื่อบัญชี บริษัท ไทยออล จำกัด
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><b>เลือกจำนวนที่ต้องการเติม</b></label>
                            <div class="row" style="padding: 10px;">
                                <div class="col-lg-3" style="padding: 2px;">
                                    <div class="btn btn-secondary" style="width: 100%;" data-value="300"
                                         onclick="fillamount($(this))">
                                        <b>300</b>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding: 2px;">
                                    <div class="btn btn-secondary" style="width: 100%;" data-value="500"
                                         onclick="fillamount($(this))">
                                        <b>500</b>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding: 2px;">
                                    <div class="btn btn-secondary" style="width: 100%;" data-value="1000"
                                         onclick="fillamount($(this))">
                                        <b>1,000</b>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding: 2px;">
                                    <div class="btn btn-secondary" style="width: 100%;" data-value="1500"
                                         onclick="fillamount($(this))">
                                        <b>1,500</b>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><b>จำนวนที่ต้องการเติม</b></label>
                            <input type="text" class="form-control wallet-pay" style="font-size: 25px;text-align: right;"
                                   name="wallet_pay" value=""
                                   placeholder="จำนวนเงิน" onchange="fillamount2($(this))" required>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><b>ค่าบริการหักภาษี ณ ที่จ่าย 3%</b></label>
                            <input type="text" class="form-control wallet-pay-vat" style="font-size: 25px;text-align: right;"
                                   name="wallet_pay_vat" value=""
                                   placeholder="" readonly>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><b>จำนวนเงินเข้าระบบ</b></label>
                            <input type="text" class="form-control wallet-pay-total" style="font-size: 25px;text-align: right;"
                                   name="wallet_pay_total" value=""
                                   placeholder="" readonly>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for=""><b>แนบหลักฐาน</b></label>
                            <input type="file" class="form-control" name="file_slip" required>
                        </div>
                    </div>
                    <div style="height: 10px;"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p style="color: red;font-size: 14px;">*ต้องทำการแนบหลักฐานการโอนเงินทุกครั้ง</p>
                        </div>
                    </div>

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
            url: "wallet_list_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },

        ],
    });

    function showaddWallet(e) {
        $("#myModal").modal("show");
    }

    function fillamount(e) {
        var click_amount = e.attr("data-value");
        var vat_rate = 3;
        if (parseFloat(click_amount) > 0) {
            // var vat3 = (click_amount * 3)/100;
            // var total = (click_amount - vat3);
            $(".wallet-pay").val(click_amount);
            cal_amount();
            // $(".wallet-pay-vat").val(vat3);
            // $(".wallet-pay-total").val(total);

        } else {
            $(".wallet-pay").val(0);
        }
    }

    function fillamount2(e) {
        cal_amount();
    }

    function cal_amount() {
        var click_amount = $(".wallet-pay").val();
        var vat_rate = 3;
        if (parseFloat(click_amount) > 0) {
            var vat3 = (click_amount * 3) / 100;
            var total = (click_amount - vat3);
            $(".wallet-pay").val(click_amount);
            $(".wallet-pay-vat").val(vat3);
            $(".wallet-pay-total").val(total);

        } else {
            $(".wallet-pay").val(0);
        }
    }

    function notify() {
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

        }

    }
</script>
