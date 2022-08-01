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
            <h3 class="h3 mb-0 text-gray-800">อัพเกรดสมาชิก</h3>

        </div>
    </div>
    <div class="col-lg-2" style="text-align: right;">

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
                    <th>สมาชิก</th>
                    <th>อัพเกรด</th>
                    <th>จำนวนเงิน</th>
                    <th>เอกสารอ้างอิง</th>
                    <th>สถานะ</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<form action="upgrade_action.php" id="form-accept" method="post">
    <input type="hidden" name="delete_id" class="delete-id" value="">
    <input type="hidden" name="action_type" value="accept">
</form>
<form action="wallet_action.php" id="form-decline" method="post">
    <input type="hidden" name="delete_id" class="delete-id" value="">
    <input type="hidden" name="action_type" value="decline">
</form>
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
            url: "memberupgrade_page_fetch.php",
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
    function recAccept(e) {
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
            text: "คุณต้องการอนุมัติข้อมูลใช่หรือไม่!",
            type: 'warning',
            showCancelButton: true,
            scrollbarPadding: false,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $("#form-accept").submit();
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
    function recDecline(e) {
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
            text: "คุณต้องการปฏิเสธข้อมูลใช่หรือไม่!",
            type: 'warning',
            showCancelButton: true,
            scrollbarPadding: false,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $("#form-decline").submit();
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
</script>
