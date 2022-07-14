<?php
ob_start();
session_start();
include "header.php";
include "models/ItemModel.php";
include "models/MemberTypeModel.php";

$models_sparepart_data = getSparepartItemData($connect);
$models_data = getItemData($connect);
$models_member_type_offline_data = getMemberTypeByTypeId($connect, 0);
$models_member_type_online_data = getMemberTypeByTypeId($connect, 1);

$sparpart_type = 1;
if (isset($_GET['type'])) {
    $sparpart_type = $_GET['type'];
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
    <h3 class="h3 mb-0 text-gray-800">มาตรฐานราคา</h3>

</div>
<!--<div class="card shadow" style="padding-top: 5px;">-->
<form id="form-standard" action="add_sparepart_price.php" method="post">
    <input type="hidden" class="item-sparepart-type" name="item_sparepart_type" value="<?= $sparpart_type ?>">
    <div class="row">
        <div class="col-lg-10">
            <div class="btn-group">
                <?php foreach ($models_sparepart_data as $keys => $val): ?>
                    <?php $btn_active = 'btn-secondary';
                    if ($sparpart_type == $val['id']) {
                        $btn_active = 'btn-primary';
                    }
                    ?>
                    <a href="standardprice.php?type=<?= $val['id'] ?>" class="btn <?= $btn_active ?>"
                       data-var="<?= $val['id'] ?>"><?= $val['name'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-2" style="text-align: right;">
            <button type="submit" class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90">
                  <span class="d-none d-sm-inline mr-1">
                Save
            </span>
                <i class="fa fa-save text-110 w-2 h-2"></i>
            </button>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">

            <table class="table table-bordered table-striped" id="table-list">
                <thead>
                <tr>
                    <th rowspan="2"
                        style="width: 10%;vertical-align: middle;text-align: center;background-color: #f1b0b7">Model
                    </th>
                    <th rowspan="2"
                        style="width: 10%;vertical-align: middle;text-align: center;background-color: #f1b0b7">ราคาหน้า
                        Platform
                    </th>
                    <th rowspan="2"
                        style="width: 10%;vertical-align: middle;text-align: center;background-color: #f1b0b7">ราคา
                        Platform รวม Vat 7%
                    </th>
                    <th colspan="<?= count($models_member_type_offline_data) ?>"
                        style="text-align: center;background-color: lightgrey">หน้าร้าน Offline
                    </th>
                    <th colspan="<?= count($models_member_type_online_data) ?>"
                        style="text-align: center;background-color: lightgreen">SHOP Online
                    </th>
                </tr>
                <tr>
                    <?php for ($a = 0; $a <= count($models_member_type_offline_data) - 1; $a++): ?>
                        <th style="text-align: center;vertical-align: middle">
                            <?= $models_member_type_offline_data[$a]['name'] ?><span
                                    style="color: red;"> <?= $models_member_type_offline_data[$a]['percent_rate'] . "%" ?></span>
                        </th>
                    <?php endfor; ?>

                    <?php for ($a = 0; $a <= count($models_member_type_online_data) - 1; $a++): ?>
                        <th style="text-align: center;vertical-align: middle;">
                            <?= $models_member_type_online_data[$a]['name']; ?><span
                                    style="color: red;"> <?= $models_member_type_online_data[$a]['percent_rate'] . "%" ?></span>
                        </th>
                    <?php endfor; ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i <= count($models_data) - 1; $i++): ?>
                    <?php
                    $line_price = 0;
                    $line_price_vat = 0;

                    $line_data = getLineData($models_data[$i]['id'], $sparpart_type, $connect);
                    if ($line_data) {
                        $line_price = $line_data[0]['price'];
                        $line_price_vat = $line_data[0]['price_vat'];
                    }
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" name="recid[]" value="">
                            <input type="hidden" class="line-item-id" name="line_item_id[]"
                                   value="<?= $models_data[$i]['id'] ?>">
                            <p><?= $models_data[$i]['name'] ?></p>
                        </td>
                        <td>
                            <input type="text" class="form-control line-item-price" name="line_item_pirce[]"
                                   value="<?= $line_price ?>"
                                   onchange="calline($(this))" autocomplete="off">
                        </td>
                        <td>
                            <input type="text" class="form-control line-item-price-vat" name="line_item_price_vat[]"
                                   readonly
                                   value="<?= $line_price_vat ?>">
                        </td>
                        <?php for ($a = 0; $a <= count($models_member_type_offline_data) - 1; $a++): ?>
                            <td style="text-align: center;vertical-align: middle;">
                                <input type="hidden" class="line-item-percent-rate"
                                       value="<?= $models_member_type_offline_data[$a]['percent_rate'] ?>">
                            </td>
                        <?php endfor; ?>

                        <?php for ($a = 0; $a <= count($models_member_type_online_data) - 1; $a++): ?>
                            <td style="text-align: center;vertical-align: middle;">
                                <input type="hidden" class="line-item-percent-rate"
                                       value="<?= $models_member_type_online_data[$a]['percent_rate'] ?>">

                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<?php

function getLineData($item_id, $part_type, $connect)
{
    $data = [];
    if ($item_id != '' && $part_type != null) {
        $query = "SELECT * FROM standard_part_price WHERE phone_model_id='$item_id' AND part_type_id='$part_type'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'price' => $row['platform_price'], 'price_vat' => $row['platform_price_include_vat']]);
        }
    }
    return $data;
}

include "footer.php";
?>
<script>
    notify();
    refreshupdate();

    function calline(e) {
        var line_price = e.val();
        var line_price_vat = parseFloat(parseFloat(line_price) + parseFloat(line_price * 7) / 100).toFixed(1);
        var item_id = e.closest("tr").find(".line-item-id").val();
        //alert(item_id);
        var c_row = e.closest("tr").find(".line-item-percent-rate");
        c_row.each(function () {
            //  console.log($(this).val());
            var p_rate = $(this).val();
            var total = parseFloat(parseFloat(line_price) * parseFloat(p_rate) / 100).toFixed(1);
            $(this).parent().html(total);
        });
        e.closest("tr").find(".line-item-price-vat").val(line_price_vat);
    }

    function refreshupdate() {
        $("#table-list tbody tr").each(function () {
            if (parseFloat($(this).find(".line-item-price").val()) > 0) {
                $(this).find(".line-item-price").trigger("change");
            }
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