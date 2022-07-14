<?php
include "header.php";
include "models/ItemModel.php";
include "models/MemberTypeModel.php";

$models_sparepart_data = getSparepartItemData($connect);
$models_data = getItemData($connect);
$models_member_type_offline_data = getMemberTypeByTypeId($connect, 0);
$models_member_type_online_data = getMemberTypeByTypeId($connect, 1);

$sparpart_type = 0;
if(isset($_GET['type'])){
    $sparpart_type = $_GET['type'];
}

?>


<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="h3 mb-0 text-gray-800">มาตรฐานราคา</h3>

</div>
<!--<div class="card shadow" style="padding-top: 5px;">-->
<form id="form-standard" action="add_standard_price.php" method="post">
    <input type="hidden" class="item-type-id" value="<?=$sparpart_type?>">
    <div class="row">
        <div class="col-lg-10">
            <div class="btn-group">
                <?php foreach ($models_sparepart_data as $keys => $val):?>
                <?php $btn_active = 'btn-secondary';
                if($sparpart_type == $keys){
                    $btn_active = 'btn-primary';
                }
                ?>
                <a href="standardprice.php?type=<?=$keys?>" class="btn <?=$btn_active?>" data-var="<?=$keys?>"><?=$val['name']?></a>
                <?php endforeach;?>
            </div>
        </div>
        <div class="col-lg-2" style="text-align: right;">
            <div class="btn btn-success">บันทึก</div>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">

            <table class="table table-bordered table-striped">
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
                    <tr>
                        <td>
                            <input type="hidden" class="line-item-id" name="line_item_id[]"
                                   value="<?= $models_data[$i]['id'] ?>">
                            <p><?= $models_data[$i]['name'] ?></p>
                        </td>
                        <td>
                            <input type="text" class="form-control line-item-price" name="line_item_pirce[]" value=""
                                   onchange="calline($(this))" autocomplete="off">
                        </td>
                        <td>
                            <input type="text" class="form-control line-item-price-vat" name="line_item_price_vat[]"
                                   readonly
                                   value="">
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
include "footer.php";
?>
<script>
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
</script>