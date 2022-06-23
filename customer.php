<?php
ob_start();
session_start();

//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";


//$position_data = getPositionmodel($connect);
//$per_check = checkPer($user_position,"is_customer", $connect);
//if(!$per_check){
//    header("location:errorpage.php");
//}

$noti_ok = '';
$noti_error = '';

if(isset($_SESSION['msg-success'])){
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if(isset($_SESSION['msg-error'])){
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}


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
                class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90">
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

<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_customer.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เบอร์โทร</th>
                    <th>อีเมล์</th>
                    <th>Social info</th>
                    <th style="width: 25%">-</th>
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
            <form action="add_customer_data.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a"><i class="fa fa-pencil"></i> เพิ่มข้อมูลลูกค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">รหัสลูกค้า <span style="color: red"><b>*</b></span></label>
                            <input type="text" class="form-control cust-code" name="cust_code" value=""
                                   placeholder="รหัส" required>
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
                        <div class="col-lg-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control email" name="email" value=""
                                   placeholder="Email">
                        </div>
                    </div>
                    <br>
                    <div class="row">
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
                        <div class="col-lg-4">
                            <label for="">ที่อยู่</label>
                            <textarea class="form-control cust-address" name="cust_address"
                                      placeholder="Address"> </textarea>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Note</label>
                            <textarea class="form-control cust-note" name="cust_note"
                                      placeholder="Note"> </textarea>
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
    $(".active-date").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });

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


            $(".modal-title").html('แก้ไขข้อมูลลูกค้า');

            $("#myModal").modal("show");
        }
    }

    function recDelete(e) {
        //e.preventDefault();
        var recid = e.attr('data-id');
        $(".delete-id").val(recid);
        swal({
            title: "Are you sure to delete?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {

            $("#form-delete").submit();
            // e.attr("href",url);
            // e.trigger("click");
        });
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
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_ok,
                type: 'success',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }
        if(msg_error != ''){
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_error,
                type: 'danger',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }

    }
</script>
