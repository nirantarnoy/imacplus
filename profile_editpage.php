<?php
include("header.php");
include("models/BankModel.php");
include("models/ProvinceModel.php");
include("models/CityModel.php");
include("models/DistrictModel.php");

$bank_data = getBankmodel($connect);
$province_data = getProvincemodel($connect);
$city_data = getCitymodel($connect);
$district_data = getDistrictmodel($connect);

$member_id = 0;
if(isset($_GET['refid'])){
    $member_id = $_GET['refid'];
}

$fname = '';
$lname = '';
$member_data = getMemberProfileData($connect, $member_id);
if($member_data != null){
    $fname = $member_data[0]['fname'];
    $lname = $member_data[0]['lname'];
}

$bank_id = -1;
$account_no = '';
$account_name = '';
$member_data_account = getMemberBankaccount($connect, $member_id);
if($member_data_account != null){
    $bank_id = $member_data_account[0]['bank_id'];
    $account_no = $member_data_account[0]['account_no'];
    $account_name = $member_data_account[0]['account_name'];
}
$province_id = -1;
$city_id = -1;
$district_id = -1;
$zipcode = '';
$address = '';
$street = '';

$member_address = getMemberBankAddress($connect, $member_id);
if($member_address != null){
    $address = $member_address[0]['address'];
    $street = $member_address[0]['street'];
    $province_id = $member_address[0]['province_id'];
    $city_id = $member_address[0]['city_id'];
    $district_id = $member_address[0]['district_id'];
    $zipcode = $member_address[0]['zipcode'];
}

?>
<form id="form-update" method="post" action="update_data_profile.php">
    <input type="hidden" class="recid" name="recid" value="<?=$member_id?>">
<div class="row">
    <div class="col-lg-6">
        <h5>แก้ไขข้อมูลส่วนตัว</h5>

        <div class="row">
            <div class="col-lg-12">
                <hr/>
                <table style="width: 100%;" id="table-edit-form">
                    <tr>
                        <td style="width: 20%">ชื่อ</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control member-fname" name="member_fname" value="<?=$fname?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">นามสกุล</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control member-lname" name="member_lname" value="<?=$lname?>">
                        </td>
                    </tr>


                </table>
            </div>
        </div>
        <br/>
        <h5>ที่อยู่</h5>

        <div class="row">
            <div class="col-lg-12">
                <hr/>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 20%">ที่อยู่</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control address" name="address" value="<?=$address?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">ถนน</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control street" name="street" value="<?=$street?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">จังหวัด</td>
                        <td style="padding: 5px;">
                            <select name="province_id" class="form-control province-id" id=""
                                    onchange="getCity($(this))">
                                <option value="-1">--เลือกจังหวัด--</option>
                                <?php for ($i = 0; $i <= count($province_data) - 1; $i++): ?>
                                    <?php $selected = '';
                                    if($province_id == $province_data[$i]['id']){
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $province_data[$i]['id'] ?>" <?=$selected?>><?= $province_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">อำเภอ</td>
                        <td style="padding: 5px;">
                            <select name="city_id" class="form-control city-id" id="" onchange="getDistrict($(this))">
                                <option value="-1">--เลือกอำเภอ--</option>
                                <?php for ($i = 0; $i <= count($city_data) - 1; $i++): ?>
                                    <?php $selected = '';
                                    if($city_id == $city_data[$i]['id']){
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $city_data[$i]['id'] ?>" <?=$selected?>><?= $city_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">ตำบล</td>
                        <td style="padding: 5px;">
                            <select name="district_id" class="form-control district-id" id="">
                                <option value="-1">--เลือกตำบล--</option>
                                <?php for ($i = 0; $i <= count($district_data) - 1; $i++): ?>
                                    <?php $selected = '';
                                    if($district_id == $district_data[$i]['id']){
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $district_data[$i]['id'] ?>" <?=$selected?>><?= $district_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">รหัสไปรษณีย์</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control zipcode" name="zipcode" value="<?=$zipcode?>" readonly>
                        </td>
                    </tr>


                </table>
            </div>
        </div>
        <br/>
        <h5>ข้อมูลธนาคาร/บัตร</h5>

        <div class="row">
            <div class="col-lg-12">
                <hr/>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 20%">ชื่อธนาคาร</td>
                        <td style="padding: 5px;">
                            <select name="member_account_bank_id" class="form-control member-account-bank-id" id="">
                                <option value="-1">--เลือกธนาคาร--</option>
                                <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                <?php $selected = '';
                                 if($bank_id == $bank_data[$i]['id']){
                                     $selected = 'selected';
                                 }
                                ?>
                                    <option value="<?= $bank_data[$i]['id'] ?>" <?=$selected;?>><?= $bank_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">เลขที่บัญชี</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control member-account-no" name="member_account_no" value="<?=$account_no?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">ชื่อบัญชี</td>
                        <td style="padding: 5px;">
                            <input type="text" class="form-control member-account-name" name="member_account_name"
                                   value="<?=$account_name?>">
                        </td>
                    </tr>


                </table>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-3">

                <input class="btn btn-success" type="submit" value="บันทึก">
            </div>
        </div>
    </div>
    <div class="col-lg-6">

    </div>
</div>
</form>

<?php
include("footer.php");
?>

<script>
    $(function () {

    });

    function getCity(e) {
        var id = e.val();
        if (id != '') {
            //alert(id);
            $.ajax({
                type: "post",
                dataType: "html",
                url: "models/getCityData.php",
                async: false,
                data: {'province_id': id},
                success: function (data) {
                    $(".city-id").html(data);
                }
            });
        }
    }

    function getDistrict(e) {
        var id = e.val();
        if (id != '') {
            //alert(id);
            $.ajax({
                type: "post",
                dataType: "html",
                url: "models/getDistrictData.php",
                async: false,
                data: {'city_id': id},
                success: function (data) {
                    $(".district-id").html(data);
                    getZipcode(id);
                }
            });
        }
    }

    function getZipcode(e) {
        if (e != '') {
            //alert(id);
            $.ajax({
                type: "post",
                dataType: "html",
                url: "models/getZipcode.php",
                async: false,
                data: {'city_id': e},
                success: function (data) {
                    $(".zipcode").val(data);
                }
            });
        }
    }
</script>
