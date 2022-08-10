<?php
//session_start();
include "header.php";
//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}

$noti_ok = '';
$noti_error = '';
$status_data = [['id' => 1, 'name' => 'Active'], ['id' => 2, 'name' => 'Inactive']];
if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}


?>
<!-- Page Heading -->
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">ใบเสนอราคา</h1>
    <div class="btn-group">
        <a href="quotation_create.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> สร้าง</a>
        <!--                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-upload"><i class="fas fa-upload fa-sm text-white-50"></i> Import Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control search-name" id="search-name" name="search_name"
                           placeholder="เลขทีเสนอราคา , ชื่อลูกค้า">
                    <!--                    <input type="text" class="form-control search-email" id="search-email" name="search_email"-->
                    <!--                           placeholder="email-โทรศัพท์">-->
                    <!--                    <input type="text" class="form-control search-index" id="search-index" name="search_index" placeholder="index">-->
                    <!--                    <input type="text" class="form-control search-plate" id="search-prod" name="search_prod" placeholder="สินค้า">-->
                </div>

            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>เลขที่</th>
                    <th>วันที่</th>
                    <th>ลูกค้า</th>
                    <th>สถานะ</th>
                    <th>ผู้บันทึก</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form action="quotation_action.php" method="post" id="form-delete">
    <input type="hidden" name="action_type" value="delete">
    <input type="hidden" class="delete-id" name="delete_id" value="">
</form>

<?php
include "footer.php";
?>
<script>
    notify();
    // $(".btn-upload").click(function () {
    //     $("#myModal").modal("show");
    // });
    var dataTablex = $("#dataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[0, "asc"]],
        "pageLength": 100,
        "filter": false,
        "ajax": {
            url: "quotation_fetch.php",
            type: "POST",
            data: function (data) {
                // Read values
                var name = $('#search-name').val();
                // var email = $('#search-email').val();
                // var prod = $('#search-prod').val();
                // var index = $('#search-index').val();
                // // Append to data
                data.searchByName = name;
                // data.searchByEmail = email;
                // data.searchByProd = prod;
                // data.searchByIndex = index;
            }
        },
        "columnDefs": [
            {
                //  "targets": [7],
                //  "orderable": false,
            },

        ],
    });

    $('#search-name').change(function () {
        dataTablex.draw();
    });

    // $('#search-email').change(function () {
    //     dataTablex.draw();
    // });

    // $('#search-prod').change(function(){
    //     dataTablex.draw();
    // });
    // $('#search-index').change(function(){
    //     dataTablex.draw();
    // });

    $(".btn-import").click(function () {
        $("#form-import").submit();
    });
    $(".btn-save").click(function () {
        $("#form-position").submit();
    });

    function showpositionmodal(e) {
        $("#positionModal").modal("show");
    }

    function showupdate(e) {
        var recid = e.attr("data-id");
        // alert(recid);
        if (recid != '') {
            var name = '';
            var description = '';
            var status = '';


            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_quotation_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        //  alert(data[0]['prefix']);
                        name = data[0]['name'];
                        description = data[0]['description'];
                        status = data[0]['status'];
                        //  gender = data[0]['gender'];
                        //   emp_start_date = data[0]['emp_start_date'];

                    }
                },
                'error': function () {
                    alert("err");
                }
            });

            $(".recid").val(recid);
            // $(".prefix").val(prefix).change();
            $(".name").val(name);
            $(".description").val(description);
            $(".status").val(status);

            $(".title").html('แก้ไขใบเสนอราคา');
            $(".action-type").val('update');
            $("#positionModal").modal("show");
        }
    }

    // function recDelete(e) {
    //     //e.preventDefault();
    //     var recid = e.attr('data-id');
    //     $(".delete-id").val(recid);
    //     swal({
    //         title: "ต้องการลบรายการนี้ใช่หรือไม่",
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
    //     var msg_ok = $(".msg-ok").val();
    //     var msg_error = $(".msg-error").val();
    //     if (msg_ok != '') {
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
    //     if (msg_error != '') {
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
