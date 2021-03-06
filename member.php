<?php
ob_start();
session_start();

//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";
include("models/StatusModel.php");

//$position_data = getPositionmodel($connect);
//$per_check = checkPer($user_position,"is_product_cat", $connect);
//if(!$per_check){
//    header("location:errorpage.php");
//}

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
    <h1 class="h3 mb-0 text-gray-800">Members</h1>
    <!--    <div class="btn-group">-->
    <!--        <a href="#" class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90" onclick="showaddbank($(this))">-->
    <!--                  <span class="d-none d-sm-inline mr-1">-->
    <!--                    สร้าง-->
    <!--                  </span>-->
    <!--                <i class="fa fa-save text-110 w-2 h-2"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="showaddbank($(this))"><i-->
    <!--                class="fas fa-plus-circle fa-sm text-white-50"></i> สร้างใหม่</a>-->
    <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    <!--    </div>-->

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="member_action.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
            <input type="hidden" name="action_type" value="delete">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Zone</th>
                    <th>Parent</th>
                    <th>ประเภทสมาชิก</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Line id</th>
                    <th>Point</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="member_action.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">เพิ่มข้อมูลยี่ห้อสินค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">ชื่อ</label>
                            <input type="text" class="form-control f-name" name="f_name" value=""
                                   placeholder="First Name">
                        </div>
                        <div class="col-lg-6">
                            <label for="">สกุล</label>
                            <input type="text" class="form-control l-name" name="l_name" value=""
                                   placeholder="Last Name">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Zone</label>
                            <input type="text" name="zone_id" class="form-control zone-id" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Parent</label>
                            <input type="text" name="parent_id" class="form-control parent-id" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">ประเภทสมาชิก</label>
                            <input type="text" name="member_type_id" class="form-control member-type-id" value="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control phone-number" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Email</label>
                            <input type="text" name="member_email" class="form-control member-email" value="">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Line ID</label>
                            <input type="text" name="line_id" class="form-control line-id" value="">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">URL</label>
                            <input type="text" name="member_url" class="form-control member-url" value="">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Point</label>
                            <input type="text" name="member_point" class="form-control member-point" value="">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-12">
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

    // function showaddbank(e) {
    //     $(".user-recid").val(0);
    //     $(".bank-name").val('');
    //     $(".description").val('');
    //     $("#myModal").modal("show");
    // }

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
            url: "member_fetch.php",
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
            var fname = '';
            var lname = '';
            var zone_id = '';
            var parent_id = '';
            var member_type_id = '';
            var phone = '';
            var email = '';
            var line_id = '';
            var url = '';
            var point = '';
            var status = '';
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_member_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['fname']);
                        fname = data[0]['fname'];
                        lname = data[0]['lname'];
                        zone_id = data[0]['zone_id'];
                        parent_id = data[0]['parent_id'];
                        member_type_id = data[0]['member_type_id'];
                        phone = data[0]['phone'];
                        email = data[0]['email'];
                        line_id = data[0]['line_id'];
                        url = data[0]['url'];
                        point = data[0]['point'];
                        status = data[0]['status'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".status").val(status);
            $(".f-name").val(fname);
            $(".l-name").val(lname);
            $(".zone-id").val(zone_id);
            $(".parent-id").val(parent_id);
            $(".member-type-id").val(member_type_id);
            $(".phone-number").val(phone);
            $(".member-email").val(email);
            $(".line-id").val(line_id);
            $(".member-url").val(url);
            $(".member-point").val(point);


            $(".modal-title").html('แก้ไขข้อมูลยี่ห้อสินค้า');
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
