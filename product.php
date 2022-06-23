<?php
ob_start();
//session_start();
//date_default_timezone_set('Asia/Yangon');
//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}
//echo date('H:i');return;
include "header.php";
include("models/ProductTypeModel.php");
include("models/UnitModel.php");

$position_data = getPositionmodel($connect);
$per_check = checkPer($user_position, "is_product", $connect);
if (!$per_check) {
    header("location:errorpage.php");
}


$prod_type_data = getTypemodel($connect);
$unit_data = getUnitmodel($connect);
$noti_ok = '';
$noti_error = '';

if (!empty($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

//echo date('Y-d-m H:m:i',strtotime("-30 minutes"));
?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">สินค้า/บริการ</h1>
    <div class="btn-group">
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"
           onclick="showaddproduct($(this))"><i
                    class="fas fa-plus-circle fa-sm text-white-50"></i> สร้างใหม่</a>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="delete_product.php" id="form-delete" method="post">
            <input type="hidden" name="delete_id" class="delete-id" value="">
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ประเภท</th>
                    <th>หน่วยนับ</th>
<!--                    <th>Stock</th>-->
                    <th>-</th>
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
            <form action="add_product_data.php" id="form-user" method="post" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a">เพิ่มรหัสสินค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">รหัสสินค้า</label>
                            <input type="text" class="form-control sku" name="sku" value=""
                                   placeholder="Sku">
                        </div>
                        <div class="col-lg-4">
                            <label for="">ชื่อสินค้า</label>
                            <input type="text" class="form-control product-name" name="product_name" value=""
                                   placeholder="Name">
                        </div>
                        <div class="col-lg-4">
                            <label for="">ประเภท</label>
                            <select name="product_type_id" id="" class="form-control product-type-id">
                                <option value="0">--Select Type --</option>
                                <?php for ($i = 0; $i <= count($prod_type_data) - 1; $i++): ?>
                                    <option value="<?= $prod_type_data[$i]['id'] ?>"><?= $prod_type_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">หน่วยนับ</label>
                            <select name="product_unit_id" id="" class="form-control product-unit-id">
                                <option value="0">--Select Unit --</option>
                                <?php for ($i = 0; $i <= count($unit_data) - 1; $i++): ?>
                                    <option value="<?= $unit_data[$i]['id'] ?>"><?= $unit_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">ต้นทุน</label>
                            <input type="text" class="form-control cost" name="cost" value="0">
                        </div>
                        <div class="col-lg-3">
                            <label for="">ราคาขาย</label>
                            <input type="text" class="form-control price" name="price" value="0">
                        </div>
                        <div class="col-lg-3">
                            <label for="">คงเหลือ</label>
                            <input type="text" class="form-control stock-qty" name="" value="0" readonly>
                        </div>
                        <!--                        <div class="col-lg-4">-->
                        <!--                            <label for="">Status</label>-->
                        <!--                            <input type="text" class="form-control status" readonly>-->
                        <!--                        </div>-->
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <label for="">รูปสินค้า</label>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="photo-empty"
                                         style="width: 100%;height: 50px;border: 1px dashed red"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="show-card-photo" style="border: 1px dashed red">
                                        <img src="" class="product-photo" width="100%" alt="">
                                    </div>
                                    <br/>
                                    <div class="btn btn-danger btn-delete-card-photo" style="display: ">Delete photo
                                    </div>
                                    <div class="btn-add-card-photo">
                                        <input type="file" name="file_product">
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-2"></div>
                        <!--                        <div class="col-lg-6">-->
                        <!--                            <label for="">Bank Account Picture</label>-->
                        <!--                            <div class="row">-->
                        <!--                                <div class="col-lg-12">-->
                        <!---->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                            <div class="row">-->
                        <!--                                <div class="col-lg-12">-->
                        <!--                                    <div class="show-bank-photo">-->
                        <!--                                        <img src="" class="bank-photo" width="100%" alt="">-->
                        <!--                                    </div>-->
                        <!--                                    <br />-->
                        <!--                                    <div class="btn btn-danger btn-delete-bank-photo" style="display: ">Delete bank photo</div>-->
                        <!--                                    <div class="btn-add-bank-photo">-->
                        <!--                                        <input type="file" name="file_bank">-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!---->
                        <!--                        </div>-->
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
<form action="delete_product_photo.php" method="post" id="form-delete-photo">
    <input type="hidden" class="delete-photo-id" name="delete_photo_id" value="">
    <input type="hidden" class="delete-photo" name="delete_photo" value="">
</form>
<?php
include "footer.php";
?>

<script>
    notify();

    $(".member-dob").datepicker({
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        autoclose: true
    });

    function showaddproduct(e) {
        $(".user-recid").val();
        $(".sku").val('');
        $(".product-name").val('');
        $(".product-type-id").val(0).change();
        $(".product-unit-id").val(0).change();
        $(".product-w").val(0);
        $(".product-h").val(0);
        $(".product-l").val(0);
        $(".product-cmb").val(0);
        $(".product-photo").attr('src', '');


        $(".btn-delete-card-photo").hide();
        $(".btn-delete-bank-photo").hide();

        $("div.btn-add-card-photo").show();
        $("div.btn-add-bank-photo").show();

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
            url: "product_fetch.php",
            type: "POST"
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false,
            },
            // {
            //     "targets": [6],
            //     "class": 'text-right',
            // },

        ],
    });

    $(".btn-delete-card-photo").click(function () {
        if (confirm('Are you sure for delete?')) {
            //$("form#form-delete-photo").submit();
            var recid = $(".delete-photo-id").val();
            var photo = $(".delete-photo").val();
            var prod_id = $(".user-recid").val();
            $.ajax({
                'type': 'post',
                'dataType': 'html',
                'async': false,
                'url': 'delete_product_photo.php',
                'data': {'delete_photo_id': recid, 'delete_photo': photo},
                'success': function (data) {
                    if (data == 0) {
                        $("div.photo-empty").show();
                        $("div.btn-add-card-photo").show();
                        $(".btn-delete-card-photo").hide();
                        $(".show-card-photo").hide();

                        $(".delete-photo").val('');
                        $(".product-photo").attr("src", "");

                    } else {
                        $(".product-photo").attr("src", "");

                        $("div.photo-empty").hide();
                        $("div.btn-add-card-photo").show();
                        $(".btn-delete-card-photo").hide();
                        $(".show-card-photo").show();

                        $.toast({
                            title: 'Message notify',
                            subtitle: '',
                            content: 'Delete photo successfully',
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
                }
            });
        }
    })

    function showupdate(e) {
        var recid = e.attr("data-id");
        if (recid != '') {
            var code = '';
            var name = '';
            var type_id = 0;
            var unit_id = 0;
            var prod_photo = '';
            var stock_qty = 0;
            var cost = 0;
            var price = 0;

            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_product_update.php',
                'data': {'id': recid},
                'success': function (data) {
                    if (data.length > 0) {
                        // alert(data[0]['display_name']);
                        code = data[0]['code'];
                        name = data[0]['name'];
                        type_id = data[0]['product_type'];
                        unit_id = data[0]['unit_id'];
                        prod_photo = data[0]['photo'];
                        stock_qty = data[0]['stock_qty'];
                        cost = data[0]['cost'];
                        price = data[0]['price'];
                    }
                }
            });

            $(".user-recid").val(recid);
            $(".sku").val(code);
            $(".product-name").val(name);
            $(".product-type-id").val(type_id).change();
            $(".product-unit-id").val(unit_id).change();
            $(".stock-qty").val(stock_qty);
            $(".cost").val(cost);
            $(".price").val(price);

            $(".delete-photo-id").val(recid);

            $(".product-photo").attr("src", "uploads/product_photo/" + prod_photo);
            if (prod_photo != '') {
                $("div.photo-empty").hide();
                $("div.btn-add-card-photo").hide();
                $(".btn-delete-card-photo").show();
                $(".show-card-photo").show();

                $(".delete-photo").val(prod_photo);

            } else {
                $("div.photo-empty").show();
                $("div.btn-add-card-photo").show();
                $(".btn-delete-card-photo").hide();
                $(".show-card-photo").hide();

                $(".delete-photo").val('');
            }


            $(".modal-title").html('แก้ไขรหัสสินค้า');

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
        if (msg_ok != '') {
            $.toast({
                title: 'Message notify',
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
        if (msg_error != '') {
            $.toast({
                title: 'Message notify',
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

    function calCmb(e) {
        var l = $(".product-l").val();
        var w = $(".product-w").val();
        var h = $(".product-h").val();

        var total = parseFloat((l * w * h) / 1000000);

        $(".product-cmb").val(total);

    }
</script>
