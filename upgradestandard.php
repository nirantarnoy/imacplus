<?php
//session_start();
include "header.php";
//if (!isset($_SESSION['userid'])) {
//    header("location:loginpage.php");
//}

$noti_ok = '';
$noti_error = '';
$workorder_id = 0;
if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}

if (isset($_POST['ref_id'])) {
    $workorder_id = $_POST['ref_id'];
}


include("get_position_update.php");
include("models/StatusModel.php");
//include("models/ItemModel.php");
include("models/SparepartModel.php");
include("models/MemberTypeModel.php");
include("models/UpgradestandardModel.php");


$sale_data = null;
$update_id = 1;
$action_type = "create";
$rec_id = '';
$sale_data_line = null;
$member_type_data = getMemberTypeData($connect);
//if (isset($_GET['update_id'])) {
//    $update_id = $_GET['update_id'];
//    $action_type = "update";
//}
if ($update_id) {
    $action_type = 'update';
    $sale_data_line = getUpgradeStandardModel($connect, $update_id);
    $rec_id = $update_id;
//    print_r($sale_data_line);
}


//$query = "SELECT * FROM upgrade_standard ";
//$statement = $connect->prepare($query);
//$statement->execute();
//$result = $statement->fetchAll();
//$filtered_rows = $statement->rowCount();
//$data = [];
//if($filtered_rows > 0) {
//    foreach ($result as $row) {
//        array_push($data, [
//            'id' => $row['id'],
//            'member_type_id' => $row['member_type_id'],
//            'parent_1' => $row['parent_1'],
//            'parent_1_rate' => $row['parent_1_rate'],
//            'parent_2' => $row['parent_2'],
//            'parent_2_rate' => $row['parent_2_rate'],
//        ]);
//    }
//}


?>
<!-- Page Heading -->
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">จัดการ Upgrade Standard</h1>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="upgradestandard_action.php" id="form-position" method="post" enctype="multipart/form-data">
            <input type="hidden" class="remove-line-list" name="remove_line_list" value="">
            <input type="hidden" class="action-type" value="<?= $action_type ?>" name="action_type">
            <input type="hidden" class="recid" value="<?= $rec_id ?>" name="recid">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped" id="table-list" style="width: 100%">
                        <thead>
                        <tr>
                            <td style="width: 20%">ประเภทสมาชิก</td>
                            <td style="width: 20%">ระดับ1</td>
                            <td style="width: 10%">ระดับ1 Mpoint</td>
                            <td style="width: 20%">ระดับ2</td>
                            <td style="width: 10%">ระดับ2 Mpoint</td>
                            <td style="width: 5%">-</td>
                        </tr>
                        </thead>
                        <tbody>

                            <?php if (count($sale_data_line)): ?>
                                <?php for ($i = 0; $i <= count($sale_data_line) - 1; $i++): ?>
                                    <tr data-var="<?= $sale_data_line[$i]['id'] ?>">
                                    <td>
                                        <input type="hidden" class="form-control line-id" name="line_id[]" value="">
                                        <select name="line_to_member_type[]" class="form-control line-to-member-type"
                                                id="">

                                            <option value="">--เลือก--</option>
                                            <?php for ($x = 0; $x <= count($member_type_data) - 1; $x++): ?>
                                                <?php
                                                $selected = '';
                                                if ($member_type_data[$x]['id'] == $sale_data_line[$i]['member_type_id']) {
                                                    $selected = "selected";
                                                }
                                                ?>
                                                <option value="<?= $member_type_data[$x]['id'] ?>" <?= $selected ?>><?= $member_type_data[$x]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="line_parent_1_member_type[]"
                                                class="form-control line-parent-1-member-type" id="">
                                            <option value="">--เลือก--</option>
                                            <?php for ($x = 0; $x <= count($member_type_data) - 1; $x++): ?>
                                                <?php
                                                $selected = '';
                                                if ($member_type_data[$x]['id'] == $sale_data_line[$i]['parent_1']) {
                                                    $selected = "selected";
                                                }
                                                ?>
                                                <option value="<?= $member_type_data[$x]['id'] ?>" <?=$selected?>><?= $member_type_data[$x]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="number"
                                               class="form-control line-parent-1-rate"
                                               name="line_parent_1_rate[]"
                                               value="<?= $sale_data_line[$i]['parent_1_rate'] ?>"
                                               onchange="calTotal($(this))">
                                    </td>
                                    <td>
                                        <select name="line_parent_2_member_type[]"
                                                class="form-control line-parent-2-member-type" id="">
                                            <option value="">--เลือก--</option>
                                            <?php for ($x = 0; $x <= count($member_type_data) - 1; $x++): ?>
                                                <?php
                                                $selected = '';
                                                if ($member_type_data[$x]['id'] == $sale_data_line[$i]['parent_2']) {
                                                    $selected = "selected";
                                                }
                                                ?>
                                                <option value="<?= $member_type_data[$x]['id'] ?>" <?=$selected?>><?= $member_type_data[$x]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="number"
                                               class="form-control line-parent-2-rate"
                                               name="line_parent_2_rate[]"
                                               value="<?= $sale_data_line[$i]['parent_2_rate'] ?>"
                                               onchange="calTotal($(this))">
                                    </td>
                                    <td>
                                        <div class="btn btn-danger" onclick="removeline($(this))">ลบ</div>
                                    </td>
                                <?php endfor; ?>
                            <?php else: ?>
                                <tr data-var="">
                                    <td>
                                        <input type="hidden" class="form-control line-id" name="line_id[]" value="">
                                        <select name="line_to_member_type[]" class="form-control line-to-member-type"
                                                id="">

                                            <option value="">--เลือก--</option>
                                            <?php for ($i = 0; $i <= count($member_type_data) - 1; $i++): ?>
                                                <option value="<?= $member_type_data[$i]['id'] ?>"><?= $member_type_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="line_parent_1_member_type[]"
                                                class="form-control line-parent-1-member-type" id="">
                                            <option value="">--เลือก--</option>
                                            <?php for ($i = 0; $i <= count($member_type_data) - 1; $i++): ?>
                                                <option value="<?= $member_type_data[$i]['id'] ?>"><?= $member_type_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="number"
                                               class="form-control line-parent-1-rate"
                                               name="line_parent_1_rate[]" value="" onchange="calTotal($(this))">
                                    </td>
                                    <td>
                                        <select name="line_parent_2_member_type[]"
                                                class="form-control line-parent-2-member-type" id="">
                                            <option value="">--เลือก--</option>
                                            <?php for ($i = 0; $i <= count($member_type_data) - 1; $i++): ?>
                                                <option value="<?= $member_type_data[$i]['id'] ?>"><?= $member_type_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="text-align: right" type="number"
                                               class="form-control line-parent-2-rate"
                                               name="line_parent_2_rate[]" value="" onchange="calTotal($(this))">
                                    </td>
                                    <td>
                                        <div class="btn btn-danger" onclick="removeline($(this))">ลบ</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <div class="btn btn-primary btn-add-row" onclick="showfind($(this))">
                                    <i class="fa fa-plus-circle"></i>
                                </div>
                            </td>

                            <td></td>
                            <td style="text-align: right;vertical-align: middle;"></td>
                            <td>
                            </td>

                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!--            <div class="footer">-->
            <!--                <input type="submit" class="btn btn-success btn-save" data-dismiss="modal" value="ตกลง">-->
            <!--            </div>-->

            <div class="btn-group">
                <input type="submit" class="btn btn-success btn-save" value="บันทึก">
                <!--                <div class="btn btn-warning">ตรวจสอบโปรโมชั่น</div>-->
                <!--                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"-->
                <!--                   onclick="showpositionmodal($(this))"> บันทึก </a>-->
                <!--                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-upload"><i class="fas fa-upload fa-sm text-white-50"></i> Import Data</a>-->
            </div>

            <!--            <div class="btn btn-primary btn-add-promotion" style="display: none;" onclick="showpromotion($(this))">-->
            <!--                โปรโมชั่น-->
            <!--            </div>-->

        </form>
    </div>
</div>

<form action="quotation_action.php" method="post" id="form-delete">
    <input type="hidden" name="action_type" value="delete">
    <input type="hidden" class="delete-id" name="delete_id" value="">
</form>

<div id="findModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="row" style="width: 100%">
                    <div class="col-lg-11">
                        <div class="input-group">
                            <input type="text" class="form-control search-item" placeholder="ค้นหาสินค้า">
                            <span class="input-group-addon">
                                        <button type="submit" class="btn btn-primary btn-search-submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>

            </div>
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto">-->
            <!--            <div class="modal-body" style="white-space:nowrap;overflow-y: auto;scrollbar-x-position: top">-->

            <div class="modal-body">

                <input type="hidden" name="line_qc_product" class="line_qc_product" value="">
                <table class="table table-bordered table-striped table-find-list" width="100%">
                    <thead>
                    <tr>
                        <th style="text-align: center">เลือก</th>
                        <th>อะไหล่</th>
                        <th>รายละเอียด</th>
                        <th>ประเภท</th>
                        <th>คลัง</th>
                        <th>ราคา</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-success btn-product-selected" data-dismiss="modalx" disabled><i
                            class="fa fa-check"></i> ตกลง
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class="fa fa-close text-danger"></i> ปิดหน้าต่าง
                </button>
            </div>
        </div>

    </div>
</div>


<?php
include "footer.php";
?>
<script>
    notify();
    alltotal();
    // $('.quotation-date').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('.quotation-date').datetimepicker({format: "DD-MM-yyyy"});
    $(".btn-upload").click(function () {
        $("#myModal").modal("show");
    });
    var removelist = [];
    var selecteditem = [];

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

    function showfind(e) {
        var tr = $("#table-list tbody tr:last");

        var clone = tr.clone();
        clone.find(".line-id").val("");
        clone.find(".line-to-member-type").val(-1);
        clone.find(".line-parent-1-member-type").val(-1);
        clone.find(".line-parent-1-rate").val(0);
        clone.find(".line-parent-2-member-type").val(-1);
        clone.find(".line-parent-2-rate").val(0);
        tr.after(clone);


    }


    function recDelete(e) {
        //e.preventDefault();
        var recid = e.attr('data-id');
        $(".delete-id").val(recid);
        swal({
            title: "ต้องการลบรายการนี้ใช่หรือไม่",
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
        var msg_ok = $(".msg-ok").val();
        var msg_error = $(".msg-error").val();
        if (msg_ok != '') {
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
        if (msg_error != '') {
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

    // function addRow(e){
    //     var tr = $("#table-list tbody tr:last");
    //     var clone = tr.clone();
    //     var num = clone.find('td:eq()').html();
    //     if(num==""){
    //         num = 1;
    //     }else{
    //         num = parseInt(num)+1;
    //     }
    //     clone.find(".line-rec-id").val('');
    //     clone.find(".line-from-amount").val('');
    //     clone.find(".line-to-amount").val('');
    //     clone.find('.line-per').val("");
    //     // clone.find('td:eq()').html(num);
    //     // alert(num);
    //     // $(.)
    //     tr.after(clone);
    // }
    function removeline(e) {
        // alert();
        if (confirm("ต้องการลบรายการนี้ใช่หรือไม่?")) {
            if (e.parent().parent().attr("data-var") != '') {
                removelist.push(e.parent().parent().attr("data-var"));
                $(".remove-line-list").val(removelist);
            }

            // alert(removelist);

            if ($("#table-list tbody tr").length == 1) {
                $("#table-list tbody tr").each(function () {
                    $(this).find(":text").val("");
                    $(this).find(':input[type="number"]').val("");
                    // $(this).find(".line-prod-photo").attr('src', '');
                    // $(this).find(".line-qty").val(1);
                    // cal_num();
                });
            } else {
                e.parent().parent().remove();
            }
            alltotal();
            // cal_linenum();
            // cal_all();
        }
        $(".action-type").val('delete');
    }


    function check_dup(product_id) {
        var _has = 0;
        $("#table-list tbody tr").each(function () {
            var p_id = $(this).closest('tr').find('.line-product-id').val();
            // alert(p_id);
            // alert(p_id + " = " + prod_id);
            if (p_id == product_id) {
                _has = 1;
            }
        });
        return _has;
    }

    function calTotal(e) {
        var qty = e.closest("tr").find(".line-qty").val();
        var price = e.closest("tr").find(".line-price").val();
        var total = parseFloat(qty) * parseFloat(price);
        e.closest("tr").find(".line-total-show").val(addCommas(parseFloat(total)));
        e.closest("tr").find(".line-total").val(total);

        alltotal();
    }


    function addselecteditem2(e) {
        // alert('hi');return;
        var id = e.attr('data-var');
        var name = e.closest('tr').find('.line-find-name').val();
        var discount_amount = e.closest('tr').find('.line-find-discount-amount').val();
        var discount_per = e.closest('tr').find('.line-find-discount-per').val();
        //alert(onhand);
        //  var qty = e.closest('tr').find('.line-qty').val();
        //  var total = e.closest('tr').find('.line-total').val();
        if (id) {
            if (e.hasClass('btn-outline-success')) {
                var obj = {};
                obj['id'] = id;
                obj['name'] = name;
                obj['discount_amount'] = discount_amount;
                obj['discount_per'] = discount_per;
                //  obj['total'] = total;
                selecteditem2.push(obj);

                e.removeClass('btn-outline-success');
                e.addClass('btn-success');
                disableselectitem2();
                console.log(selecteditem2);
            } else {
                //selecteditem.pop(id);
                $.each(selecteditem2, function (i, el) {
                    if (this.id == id) {
                        selecteditem2.splice(i, 1);
                    }
                });
                e.removeClass('btn-success');
                e.addClass('btn-outline-success');
                disableselectitem2();
                console.log(selecteditem2);
            }
        }
    }

    function disableselectitem2() {
        if (selecteditem2.length > 0) {
            $(".btn-product-selected2").prop("disabled", "");
            $(".btn-product-selected2").removeClass('btn-outline-success');
            $(".btn-product-selected2").addClass('btn-success');
        } else {
            $(".btn-product-selected2").prop("disabled", "disabled");
            $(".btn-product-selected2").removeClass('btn-success');
            $(".btn-product-selected2").addClass('btn-outline-success');
        }
    }

    $(".btn-product-selected2").click(function () {
        var linenum = 0;
        if (selecteditem2.length > 0) {
            var product_per = $('.product-per').val();

            var rowindex = $(".line-row-selected").val();

            // alert(product_per);
            for (var i = 0; i <= selecteditem2.length - 1; i++) {
                var line_promotion_id = selecteditem2[i]['id'];
                var line_promotion_name = selecteditem2[i]['name'];
                var line_discount_amount = selecteditem2[i]['discount_amount'];
                var line_discount_per = selecteditem2[i]['discount_per'];
                //  var line_qty = selecteditem[i]['qty'];
                //  var line_qty = selecteditem[i]['qty'];
                //  var line_total = selecteditem[i]['total'];
                // alert(line_product_id);

                $("table#table-list tbody tr").each(function () {
                    if ($(this).index() == rowindex) {
                        $(this).closest("tr").find(".line-promotion-id").val(line_promotion_id);
                        $(this).closest("tr").find(".line-promotion").val(line_promotion_name);
                        $(this).closest("tr").find(".line-dis-amount").val(line_discount_amount);
                        $(this).closest("tr").find(".line-dis-per").val(line_discount_per);

                        var line_total = $(this).closest("tr").find(".line-total").val();
                        if (line_discount_per > 0) {
                            var per = line_total * line_discount_per / 100;
                            line_total = line_total - per;
                        }
                        line_total = line_total - line_discount_amount;

                        $(this).closest("tr").find(".line-total").val(line_total);
                        $(this).closest("tr").find(".line-total-show").val(line_total);
                    }
                });
                alltotal();


                // var tr = $("#table-list tbody tr:last");
                //
                // if (tr.closest("tr").find(".line-promotion-id").val() == "") {
                //     tr.closest("tr").find(".line-promotion-id").val(line_promotion_id);
                //     tr.closest("tr").find(".line-promotion").val(line_promotion_name);
                //     tr.closest("tr").find(".line-dis-amount").val(line_discount_amount);
                //     tr.closest("tr").find(".line-dis-per").val(line_discount_per);
                //
                //     var line_total = tr.closest("tr").find(".line-total").val();
                //     if(line_discount_per > 0){
                //         var per = line_total * line_discount_per / 100;
                //         line_total = line_total-per;
                //     }
                //     line_total = line_total-line_discount_amount;
                //
                //     tr.closest("tr").find(".line-total").val(line_total);
                //     tr.closest("tr").find(".line-total-show").val(line_total);
                //     // alert('hello');
                //
                //         //cal_num();
                //    // console.log(line_promotion_id);
                // } else {
                //     // alert("dd");
                //     console.log(line_promotion_id);
                //     //tr.closest("tr").find(".line_code").css({'border-color': ''});
                //
                //     var clone = tr.clone();
                //     //clone.find(":text").val("");
                //     // clone.find("td:eq(1)").text("");
                //     clone.find(".line-promotion-id").val(line_promotion_id);
                //     clone.find(".line-promotion").val(line_promotion_name);
                //     clone.find(".line-dis-amount").val(line_discount_amount);
                //     clone.find(".line-dis-per").val(line_discount_per);
                //
                //     clone.attr("data-var", "");
                //     clone.find('.line-rec-id').val("");
                //
                //     // clone.find(".line-price").on("keypress", function (event) {
                //     //     $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
                //     //     if ((event.which != 46 || $(this).val().indexOf(".") != -1) && (event.which < 48 || event.which > 57)) {
                //     //         event.preventDefault();
                //     //     }
                //     // });
                //
                //     tr.after(clone);
                //
                //     // cal_num();
                // }
            }
            // cal_num();
        }
        // $("#table-list tbody tr").each(function () {
        //     linenum += 1;
        //     $(this).closest("tr").find("td:eq(0)").text(linenum);
        //     // $(this).closest("tr").find(".line-prod-code").val(line_prod_code);
        // });
        selecteditem2.length = 0;

        $("#table-find-list2 tbody tr").each(function () {
            $(this).closest("tr").find(".btn-line-select").removeClass('btn-success');
            $(this).closest("tr").find(".btn-line-select").addClass('btn-outline-success');
        });
        $(".btn-product-selected2").removeClass('btn-success');
        $(".btn-product-selected2").addClass('btn-outline-success');
        $("#findModal2").modal('hide');
    });

    function alltotal() {
        var total = 0;
        $("table#table-list tbody tr").each(function () {
            var line_total = $(this).closest('tr').find('.line-total').val();
            console.log(line_total);
            total = total + parseFloat(line_total);
        });

        $(".grand-total").val(addCommas(parseFloat(total)));
    }

    function check_dup2(promotion_id) {
        var _has = 0;
        $("#table-list tbody tr").each(function () {
            var p_id = $(this).closest('tr').find('.line-promotion-id').val();
            // alert(p_id);
            // alert(p_id + " = " + prod_id);
            if (p_id == promotion_id) {
                _has = 1;
            }
        });
        return _has;
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    // function calTotal(e){
    //     var qty = e.closest("tr").find(".line-qty").val();
    //     var price = e.closest("tr").find(".line-price").val();
    //     var total = parseFloat(qty) * parseFloat(price);
    //     e.closest("tr").find(".line-total").val(total);
    // }

</script>
