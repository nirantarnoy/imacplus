<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//echo date('H:i');return;
include "header.php";
include("models/CustomerModel.php");
include("models/CustomergroupModel.php");

//$position_data = getPositionmodel($connect);
//$per_check = checkPer($user_position,"is_customer", $connect);
//if(!$per_check){
//    header("location:errorpage.php");
//}

$noti_ok = '';
$noti_error = '';
$status_data = [['id'=>1,'name'=>'Active'],['id'=>0,'name'=>'Inactive']];

if(isset($_SESSION['msg-success'])){
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if(isset($_SESSION['msg-error'])){
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}
$cusgroup_data = getCusgroupData($connect);


?>
<input type="hidden" class="msg-ok" value="<?=$noti_ok?>">
<input type="hidden" class="msg-error" value="<?=$noti_error?>">

<div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
        ลูกค้า
<!--        <small class="page-info text-secondary-d2 text-nowrap">-->
<!--            <i class="fa fa-angle-double-right text-80"></i>-->
<!--            overview &amp; stats-->
<!--        </small>-->
    </h1>

    <div class="page-tools d-inline-flex">
        <button type="button"
                class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90" onclick="showaddcustomer($(this))">
                  <span class="d-none d-sm-inline mr-1">
                สร้างใหม่
            </span>
            <i class="fa fa-save text-110 w-2 h-2"></i>
        </button>

<!--        <button type="button"-->
<!--                class="mx-2px btn btn-light-purple btn-h-purple btn-a-purple border-0 radius-3 py-2 text-90">-->
<!--            <i class="fa fa-undo text-110 w-2 h-2"></i>-->
<!--        </button>-->
<!---->
<!--        <div class="btn-group dropdown dd-backdrop dd-backdrop-none-md">-->
<!--            <button type="button"-->
<!--                    class="btn btn-light-primary btn-h-primary btn-a-primary border-0 radius-3 py-2 text-90 dropdown-toggle"-->
<!--                    data-display="static" data-toggle="dropdown" aria-haspopup="true"-->
<!--                    aria-expanded="false">-->
<!--                <i class="fa fa-search text-110 w-2 h-2"></i>-->
<!--            </button>-->
<!---->
<!--            <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated animated-2 dd-slide-up dd-slide-none-md">-->
<!--                <div class="dropdown-inner">-->
<!--                    <a class="dropdown-item" href="#">Action</a>-->
<!--                    <a class="dropdown-item" href="#">Another action</a>-->
<!--                    <a class="dropdown-item" href="#">Something else here</a>-->
<!--                    <div class="dropdown-divider"></div>-->
<!--                    <a class="dropdown-item" href="#">Separated link</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
<br />

<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="customer_action.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
            <input type="hidden" name="action_type" value="delete">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รหัส</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เบอร์โทร</th>
                        <th>อีเมล์</th>
                        <th>Social info</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="customer_action.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a"><i class="fa fa-pencil"></i> เพิ่มข้อมูลลูกค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">รหัสลูกค้า <span style="color: red"><b>*</b></span></label>
                            <input type="text" class="form-control cust-code" name="cust_code" value=""
                                   placeholder="รหัส" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="">กลุ่มลูกค้า <span style="color: red"><b>*</b></span></label>
<!--                            <input type="text" class="form-control cust-group-id" name="cust_group_id" value=""-->
<!--                                   placeholder="กลุ่มลูกค้า" required>-->
                            <select name="customer_group_id" class="form-control customer-group-id" id="">
                                <?php for ($i = 0; $i <= count($cusgroup_data) - 1; $i++): ?>
<!--                                    --><?php //$selected = '';
//                                    if ( == $cusgroup_data[$i]['id']) {
//                                        $selected = "selected";
//                                    }
//                                    ?>
                                    <option value="<?= $cusgroup_data[$i]['id'] ?>"><?= $cusgroup_data[$i]['group_name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control cust-name" name="cust_name" value=""
                                   placeholder="ชื่อ-นามสกุล">
                        </div>
                        <div class="col-lg-3">
                            <label for="">เบอร์โทร</label>
                            <input type="text" class="form-control phone" name="phone" value=""
                                   placeholder="เบอร์">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control email" name="email" value=""
                                   placeholder="Email">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Line Id</label>
                            <input type="text" class="form-control line-id" name="line_id" value=""
                                   placeholder="Line ID">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Facebook</label>
                            <input type="text" class="form-control facebook" name="facebook" value=""
                                   placeholder="facebook">
                        </div>
                        <div class="col-lg-3">
                            <label for="">ที่อยู่</label>
                            <textarea class="form-control cust-address" name="cust_address"
                                      placeholder="Address"> </textarea>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Description</label>
                            <textarea class="form-control cust-description" name="cust_description"
                                      placeholder="Description"> </textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Note</label>
                            <textarea class="form-control cust-note" name="cust_note"
                                      placeholder="Note"> </textarea>
                        </div>
                        <div class="col-lg-4">
                                <label for="">สถานะ</label>
                                <select name="status" id="" class="form-control status">
                                    <?php for ($i = 0; $i <= count($status_data) - 1; $i++): ?>
                                        <option value="<?= $status_data[$i]['id'] ?>"><?= $status_data[$i]['name'] ?></option>
                                    <?php endfor; ?>
                                </select>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i class="fa fa-save"></i> Save </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
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

    // $("#service-type").select2({
    //     multiple: true,
    //     width: '100%',
    //     height: '30px',
    //     placeholder: "-- Select --",
    //     allowClear: true,
    // });

    function showaddcustomer(e) {
        $(".user-recid").val('');
        $(".cust-code").val('');
        $(".cust-name").val('');
        $(".phone").val('');
        $(".email").val('');
        $(".line-id").val('');
        $(".facebook").val('');
        $(".cust-address").val('');
        $(".cust-note").val('');

        $(".modal-title").html('บันทึกข้อมูลลูกค้า');

        $("#myModal").modal("show");
    }

    $("#dataTable").DataTable({
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
            url: "customer_fetch.php",
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
            var address = '';
            var phone = '';
            var email = '';
            var line_id = '';
            var facebook = '';
            var note = '';
            var description = '';
            var cus_group_id = '';
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_customer_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        name = data[0]['name'];
                        code = data[0]['code'];
                        phone = data[0]['phone'];
                        email = data[0]['email'];
                        line_id = data[0]['line_id'];
                        facebook = data[0]['facebook'];
                        address = data[0]['address'];
                        note = data[0]['note'];
                        description = data[0]['description'];
                        cus_group_id = data[0]['customer_group_id'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".cust-code").val(code);
            $(".cust-name").val(name);
            $(".phone").val(phone);
            $(".email").val(email);
            $(".line-id").val(line_id);
            $(".facebook").val(facebook);
            $(".cust-note").val(note);
            $(".cust-address").val(address);
            $(".cust-description").val(description);
            $(".cust-group-id").val(cus_group_id);


            $(".modal-title").html('แก้ไขข้อมูลลูกค้า');
            $(".action-type").val('update');
            $("#myModal").modal("show");
        }
    }

    // function recDelete(e) {
    //     //e.preventDefault();
    //     var recid = e.attr('data-id');
    //     $(".delete-id").val(recid);
    //     swal({
    //         title: "Are you sure to delete?",
    //         text: "",
    //         type: "warning",
    //         showCancelButton: true,
    //         closeOnConfirm: false,
    //         showLoaderOnConfirm: true
    //     }, function () {
    //
    //         $("#form-delete").submit();
    //         // e.attr("href",url);
    //         // e.trigger("click");
    //     });
    // }
    // function notify() {
    //     // $.toast({
    //     //     title: 'Message Notify',
    //     //     subtitle: '',
    //     //     content: 'eror',
    //     //     type: 'success',
    //     //     delay: 3000,
    //     //     // img: {
    //     //     //     src: 'image.png',
    //     //     //     class: 'rounded',
    //     //     //     title: 'แจ้งการทำงาน',
    //     //     //     alt: 'Alternative'
    //     //     // },
    //     //     pause_on_hover: false
    //     // });
    //     var msg_ok = $(".msg-ok").val();
    //     var msg_error = $(".msg-error").val();
    //     if(msg_ok != ''){
    //         $.toast({
    //             title: 'แจ้งเตือนการทำงาน',
    //             subtitle: '',
    //             content: msg_ok,
    //             type: 'success',
    //             delay: 3000,
    //             // img: {
    //             //     src: 'image.png',
    //             //     class: 'rounded',
    //             //     title: 'แจ้งการทำงาน',
    //             //     alt: 'Alternative'
    //             // },
    //             pause_on_hover: false
    //         });
    //     }
    //     if(msg_error != ''){
    //         $.toast({
    //             title: 'แจ้งเตือนการทำงาน',
    //             subtitle: '',
    //             content: msg_error,
    //             type: 'danger',
    //             delay: 3000,
    //             // img: {
    //             //     src: 'image.png',
    //             //     class: 'rounded',
    //             //     title: 'แจ้งการทำงาน',
    //             //     alt: 'Alternative'
    //             // },
    //             pause_on_hover: false
    //         });
    //     }
    //
    // }

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
        }).then(function(result) {
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
        if(msg_ok != ''){
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
        if(msg_error != ''){
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
