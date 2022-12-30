<?php
include("header.php");
include("models/BankModel.php");
include("models/ProvinceModel.php");
include("models/CityModel.php");
include("models/DistrictModel.php");
include("models/MemberTypeModel.php");

$bank_data = getBankmodel($connect);
$province_data = getProvincemodel($connect);
$city_data = getCitymodel($connect);
$district_data = getDistrictmodel($connect);

$member_id = 0;
if (isset($_GET['id'])) {
    $member_id = $_GET['id'];
}

$is_admin = checkUserAdmin($connect, $_SESSION['userid']);

$fname = '';
$lname = '';
$engname = '';
$engsurname = '';
$gender = 1;
$nation_type = 1;
$phone = '';
$dob = '';
$is_verified = 0;
$member_income_list = [];
$address_current_type = 0;
$agree_verified = 0;
$verify_photo = '';
$verify_photo_2 = '';
$member_data = getMemberProfileData($connect, $member_id);
if ($member_data != null) {
    $fname = $member_data[0]['fname'];
    $lname = $member_data[0]['lname'];
    $engname = $member_data[0]['engname'];
    $engsurname = $member_data[0]['engsurname'];
    $gender = $member_data[0]['gender'];
    $nation_type = $member_data[0]['nation_type'];
    $dob = $member_data[0]['dob'];
    $is_verified = $member_data[0]['is_verified'];
    $address_current_type = $member_data[0]['address_current_type'];
    $agree_verified = $member_data[0]['agree_verified'];
    $phone = $member_data[0]['phone'];
    $verify_photo = $member_data[0]['verify_photo'];
    $verify_photo_2 = $member_data[0]['verify_photo_2'];
}

//print_r($member_data);return;

$member_income_type_data = getMemberIncomeData($connect, $member_id);
//if($member_income_type_data != null){
//    for($x=0;$x<=count($member_income_type_data)-1;$x++){
//        array_push($member_income_list,$member_income_type_data[$x]['income_type_id']);
//    }
//
//}
//print_r($member_income_type_data[0]['income_type_id']);

$income_data = getIncomeTypeData($connect);

$bank_id = -1;
$account_no = '';
$account_name = '';
$member_data_account = getMemberBankaccount($connect, $member_id);
if ($member_data_account != null) {
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
if ($member_address != null) {
    $address = $member_address[0]['address'];
    $street = $member_address[0]['street'];
    $province_id = $member_address[0]['province_id'];
    $city_id = $member_address[0]['city_id'];
    $district_id = $member_address[0]['district_id'];
    $zipcode = $member_address[0]['zipcode'];
}

$province_id_c = -1;
$city_id_c = -1;
$district_id_c = -1;
$zipcode_c = '';
$address_c = '';
$street_c = '';

$member_address_c = getMemberCurrentAddress($connect, $member_id);
if ($member_address != null) {
    $address_c = $member_address_c[0]['address'];
    $street_c = $member_address_c[0]['street'];
    $province_id_c = $member_address_c[0]['province_id'];
    $city_id_c = $member_address_c[0]['city_id'];
    $district_id_c = $member_address_c[0]['district_id'];
    $zipcode_c = $member_address_c[0]['zipcode'];
}

?>
<!--<form action="update_data_profile.php" id="form-x" method="post"></form>-->
<!--<form id="form-update" method="post" action="update_data_profile.php" enctype="multipart/form-data">-->
<!--<form id="validation-form" method="post" action="update_data_profile.php" enctype="multipart/form-data">-->
<!--    <input type="hidden" class="recid" name="recid" value="--><? // //= $member_id ?><!--">-->
<!--    <div class="row">-->
<!--        <div class="col-lg-6">-->
<!--            <br/>-->
<!---->
<!--            <div class="row">-->
<!--                <div class="col-lg-3">-->
<!---->
<!--                    <input class="btn btn-success" type="submit" value="บันทึก">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-lg-6">-->
<!---->
<!--        </div>-->
<!--    </div>-->

<div class="page-content container container-plus">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form id="approve-form" method="post" action="update_data_profile.php">
                        <input type="hidden" class="recid" name="recid" value="<?= $member_id ?>">
                        <input type="hidden" class="action-type" name="action_name" value="1">
                        <div class="px-2 py-2 mb-4">
                            <div id="step-1">
                                <div class="row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                    </div>
                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1">
                                        <?php if($is_verified == 1):?>
                                            <h4><span class="text-success"><i class="fa fa-check-circle text-success"></i> ยืนยันตัวตนแล้ว</span></h4>
                                        <?php else:?>
                                            <h4><span class="text-danger"><i class="fa fa-check-circle text-danger"></i> ยังไม่ยืนยันตัวตน</span></h4>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                    </div>
                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1">
                                        <h4>ข้อมูลการยืนยันตัวตน (KYC)</h4>
                                    </div>
                                </div>
                                <!--                                <form id="validation-form" method="post" action="update_data_profile.php"-->
                                <!--                                      enctype="multipart/form-data">-->
                                <!--                                    <input type="hidden" class="recid" name="recid" value="-->
                                <? //= $member_id ?><!--">-->


                                <!-- if "Input Validation" is selected, we should validate this form before going to next step -->
                                <!--                                    <form id="validation-form" class="d-none mt-4 text-dark-m1">-->

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        สัญชาติ:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1">
                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-5" name="thai_person"
                                                       value="1" <?= $nation_type == 1 ? 'checked' : '' ?>
                                                       class="mr-1 align-sub"/>
                                                บุคคลสัญชาติไทย
                                            </label>
                                        </div>

                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-6"
                                                       name="thai_person" <?= $nation_type == 2 ? 'checked' : '' ?>
                                                       value="2"
                                                       class="mr-1 align-sub"/>
                                                บุคคลต่างชาติ
                                            </label>
                                        </div>
                                    </div>
                                </div>

<!--                                <div class="form-group row">-->
<!--                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">-->
<!--                                        IDENTITY VERIFICATION:-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="col-sm-9 pr-0 pr-sm-3">-->
<!--                                        <input required type="text" name="id_verify"-->
<!--                                               class="form-control col-11 col-sm-8 col-md-3" id="id-verify"-->
<!--                                               placeholder=""/>-->
<!--                                    </div>-->
<!--                                </div>-->
                                IDENTITY VERIFICATION:
                                <div class="form-group row mt-2">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ชื่อ:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_fname"
                                               class="form-control col-11 col-sm-8 col-md-6" placeholder=""
                                               value="<?= $fname ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        นามสกุล:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_lname"
                                               class="form-control col-11 col-sm-8 col-md-6" placeholder=""
                                               value="<?= $lname ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ชื่อ(ภาษาอังกฤษ):
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_engname"
                                               class="form-control col-11 col-sm-8 col-md-6" placeholder=""
                                               value="<?= $engname ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        นามสกุล(ภาษาอังกฤษ):
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_engsurname"
                                               class="form-control col-11 col-sm-8 col-md-6" placeholder=""
                                               value="<?= $engsurname ?>"/>
                                    </div>
                                </div>

                                <hr/>


                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ชื่อธนาคาร:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <select name="member_account_bank_id"
                                                class="form-control col-11 col-sm-4 member-fname member-account-bank-id"
                                                id="" required>
                                            <option value="-1">--เลือกธนาคาร--</option>
                                            <?php for ($i = 0; $i <= count($bank_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($bank_id == $bank_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $bank_data[$i]['id'] ?>" <?= $selected; ?>><?= $bank_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        เลขที่บัญชี:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_account_no"
                                               class="form-control col-11 col-sm-8 col-md-5"
                                               placeholder="" value="<?= $account_no ?>"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ชื่อบัญชี:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="member_account_name"
                                               class="form-control col-11 col-sm-8 col-md-5"
                                               placeholder="" value="<?= $account_name ?>"/>
                                    </div>
                                </div>


                                <hr/>

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        เพศ:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1">
                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-2" name="gender"
                                                       value="1" <?= $gender == 1 ? 'checked' : '' ?>
                                                       class="mr-1 align-sub"/>
                                                ชาย
                                            </label>
                                        </div>

                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-3" name="gender"
                                                       value="2" <?= $gender == 2 ? 'checked' : '' ?>
                                                       class="mr-1 align-sub"/>
                                                หญิง
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        วันเดือนปีเกิด (อายุมากกว่า 18 ปี):
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input required type="text" name="dob"
                                               id="form-field-mask-1"
                                               class="form-control col-11 col-sm-8 col-md-5"
                                               placeholder="" value="<?=$dob?>"/>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        เบอร์โทรศัพท์(รับ OTP):
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <input id="otp-phone-number" required type="text" name="otp_phone_no"
                                               class="form-control col-11 col-sm-8 col-md-5"
                                               placeholder="" value="<?=$phone?>"/>
                                    </div>
                                </div>


                                <!--                                    </form>-->
                            </div>


                            <div id="step-2">

                                <b>ที่อยู่ตามบัตรประชาชน</b>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ที่อยู่:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input required type="text" name="address"
                                               class="form-control col-11 col-sm-8 col-md-5 address"
                                               placeholder="" value="<?= $address ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ถนน:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input type="text" name="street"
                                               class="form-control col-11 col-sm-8 col-md-5 street"
                                               placeholder="" value="<?= $street ?>"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        จังหวัด:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <select name="province_id"
                                                class="form-control col-11 col-sm-4 province-id" id=""
                                                onchange="getCity($(this))" required>
                                            <option value="-1">--เลือกจังหวัด--</option>
                                            <?php for ($i = 0; $i <= count($province_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($province_id == $province_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $province_data[$i]['id'] ?>" <?= $selected ?>><?= $province_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        อำเภอ:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <select name="city_id"
                                                class="form-control col-11 col-sm-4 city-id"
                                                id=""
                                                onchange="getDistrict($(this))" required>
                                            <option value="-1">--เลือกอำเภอ--</option>
                                            <?php for ($i = 0; $i <= count($city_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($city_id == $city_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $city_data[$i]['id'] ?>" <?= $selected ?>><?= $city_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ตำบล:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <select name="district_id"
                                                class="form-control col-11 col-sm-4 district-id" id=""
                                                required>
                                            <option value="-1">--เลือกตำบล--</option>
                                            <?php for ($i = 0; $i <= count($district_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($district_id == $district_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $district_data[$i]['id'] ?>" <?= $selected ?>><?= $district_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        รหัสไปรษณีย์:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input readonly type="text" name="zipcode"
                                               class="form-control col-11 col-sm-8 col-md-5 zipcode"
                                               placeholder="" value="<?= $zipcode ?>"/>
                                    </div>
                                </div>
                                <hr/>
                                <b>ที่อยู่ปัจจุบัน</b>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">

                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1">
                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-address-type"
                                                       name="address_current_type"
                                                       value="1" <?=$address_current_type==1?'checked':''?>
                                                       class="mr-1 align-sub"
                                                       onchange="copyaddress($(this))"/>
                                                ที่อยู่เดียวกับบัตรประชาชน
                                            </label>
                                        </div>

                                        <div>
                                            <label>
                                                <input type="radio" id="id-radio-address-type"
                                                       name="address_current_type"
                                                       value="2" <?=$address_current_type==2?'checked':''?>
                                                       class="mr-1 align-sub"
                                                       onchange="copyaddress($(this))"/>
                                                ที่อยู่ปัจจุบัน(กรุณากรอกข้อมูล)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ที่อยู่:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input type="text" name="address_current"
                                               class="form-control col-11 col-sm-8 col-md-5 address-current"
                                               placeholder="" value="<?= $address_c ?>" <?=$address_current_type==1?'disabled':''?> />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ถนน:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input type="text" name="street_current"
                                               class="form-control col-11 col-sm-8 col-md-5 street-current"
                                               placeholder="" value="<?= $street_c ?>" <?=$address_current_type==1?'disabled':''?> />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        จังหวัด:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <select name="province_current_id"
                                                class="form-control col-11 col-sm-4 province-current-id" <?=$address_current_type==1?'disabled':''?>
                                                id=""
                                                onchange="getCity2($(this))">
                                            <option value="-1">--เลือกจังหวัด--</option>
                                            <?php for ($i = 0; $i <= count($province_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($province_id_c == $province_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $province_data[$i]['id'] ?>" <?= $selected ?>><?= $province_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        อำเภอ:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <select name="city_current_id"
                                                class="form-control col-11 col-sm-4 city-current-id" <?=$address_current_type==1?'disabled':''?>
                                                id=""
                                                onchange="getDistrict2($(this))">
                                            <option value="-1">--เลือกอำเภอ--</option>
                                            <?php for ($i = 0; $i <= count($city_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($city_id_c == $city_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $city_data[$i]['id'] ?>" <?= $selected ?>><?= $city_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        ตำบล:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <select name="district_current_id"
                                                class="form-control col-11 col-sm-4 district-current-id" <?=$address_current_type==1?'disabled':''?>
                                                id="">
                                            <option value="-1">--เลือกตำบล--</option>
                                            <?php for ($i = 0; $i <= count($district_data) - 1; $i++): ?>
                                                <?php $selected = '';
                                                if ($district_id_c == $district_data[$i]['id']) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option value="<?= $district_data[$i]['id'] ?>" <?= $selected ?>><?= $district_data[$i]['name'] ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                        รหัสไปรษณีย์:
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">

                                        <input readonly type="text" name="zipcode_current"
                                               class="form-control col-11 col-sm-8 col-md-5 zipcode-current" <?=$address_current_type==1?'disabled':''?>
                                               placeholder="" value="<?= $zipcode_c ?>"/>
                                    </div>
                                </div>


                            </div>
                            <hr/>
                            <div id="step-3" class="text-left">
                                <!--                                    <form id="validation-form" class="mt-4 text-dark-m1">-->
                                <h3 class="font-light my-4">
                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                        ที่มาของรายได้
                                    </div>
                                </h3>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                    </div>

                                    <div class="col-sm-9 pr-0 pr-sm-3">
                                        <?php for ($x = 0; $x <= count($income_data) - 1; $x++): ?>
                                            <?php
                                            $checked = checkoptionselected($member_income_type_data, $income_data[$x]['id']);
                                            ?>
                                            <label>
                                                <input type="checkbox" class="input-lg bgc-blue" name="income"
                                                       data-var="<?= $income_data[$x]['id'] ?>"
                                                       onchange="checkaddlist($(this))" <?= $checked ?>/>
                                                <?= $income_data[$x]['name'] ?>
                                            </label><br/>
                                        <?php endfor; ?>
                                        <input type="hidden" class="income-selected" name="income_selected"
                                               value="">
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                        <?php if ($agree_verified == 0): ?>
                                            <label>
                                                <input required type="checkbox"
                                                       class="border-2 brc-success-m1 brc-on-checked input-lg text-dark-tp3 mr-1"
                                                       id="id-check-terms" name="agree"/>
                                                ข้าพเจ้ายืนยันว่าข้อมูลทั้งหมดที่ข้าพเจ้าได้ส่งให้ทาง iMacPlus
                                                เป็นความจริง และข้าพเจ้าตกลงให้ความยินยอม
                                                รวมถึงการอนุญาตตามเงื่อนไขของบริษัท และที่กฎหมายกำหนดไว้ ทั้งหมด
                                            </label>
                                        <?php else: ?>
                                            <input required type="checkbox"
                                                   class="border-2 brc-success-m1 brc-on-checked input-lg text-dark-tp3 mr-1 d-none"
                                                   id="id-check-terms" name="agree" checked/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <br/>
                                <?php if ($agree_verified == 0): ?>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <h3>
                                                ขั้นตอนสุดท้ายแล้วนะ

                                            </h3>
                                        </div>
                                        <br/>
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <p>
                                                ถ่ายรูปของท่านเพื่อยืนยันตัวตน <br/>
                                                1.หน้าบัตรประชาชน <br/>2.ถ่ายรูปคู่กับบัตรประชาชน
                                                (กรุณาอ่านตัวอย่าง)<br/>
                                            </p>
                                        </div>
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <h3>
                                                ตัวอย่างการถ่ายรูปยืนยันตัวตน
                                            </h3>
                                        </div>
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <p>
                                                - ถือบัตรประชาชนไม่ปิดบังใบหน้า <br/>
                                                - มองเห็นบัตรและ ID ชัดเจน <br/>
                                                - ถือกระดาษที่เขียนว่า imacplus.app พร้อมลงวันที่ <br/>
                                                - ถ่ายรูปท่านเอง พร้อมกับถือบัตรประชาชนและกระดาษที่เขียน <br/>
                                                - กรุณาถ่ายรูปในที่แสงสว่างเพียงพอ ไม่มืด<br/>
                                            </p>
                                        </div>
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <h3>
                                                แนบรูปภาพ
                                            </h3>
                                        </div>
                                        <br/>
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <input type="file" class="form-control" name="photo_verify">
                                        </div>
                                    </div>
                                <?php else:?>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">
                                            <h3>
                                                รูปยืนยันตัวตน
                                            </h3>
                                        </div>
                                        <br/>
                                    </div>
                                    <?php if ($verify_photo != ''): ?>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-3">
                                                <img src="uploads/member_verify/<?= $verify_photo ?>" width="80%"
                                                     alt="">
                                            </div>
                                            <div class="col-lg-3">
                                                <img src="uploads/member_verify/<?= $verify_photo_2 ?>" width="80%"
                                                     alt="">
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <!--                                            <div class="col-lg-4">-->
                                            <!--                                                <div class="col-sm-9 pr-0 pr-sm-3 pt-1 offset-sm-3">-->
                                            <!--                                                    <input type="file" class="form-control" name="photo_verify">-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                        </div>
                                    <?php else: ?>
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-4">
                                                <input type="file" class="form-control" name="photo_verify">

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <!--                                    </form>-->
                            </div>


                        </div>
                        <?php if($is_verified !=1):?>
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label text-sm-right pr-0">
                            </div>

                            <div class="col-sm-9 pr-0 pr-sm-3">
                                <!--                                <input class="btn btn-success" type="submit" value="บันทึก">-->
                                <div class="btn btn-primary" onclick="submitmyform()">ยืนยันการตรวจสอบ</div>
                            </div>
                        </div>

                        <?php endif;?>
                        <?php if($is_admin == 1):?>
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label text-sm-right pr-0">
                                </div>

                                <div class="col-sm-9 pr-0 pr-sm-3">
                                    <!--                                <input class="btn btn-success" type="submit" value="บันทึก">-->
                                    <div class="btn btn-primary" onclick="submitmyform()">บันทึกข้อมูล</div>
                                </div>
                            </div>
                        <?php endif;?>
                    </form>

                </div><!-- /.card-body -->
            </div><!-- .card -->

        </div>
    </div>
</div>
<?php
function checkoptionselected($member_income_listx, $id)
{
    $checked = '';
    if ($member_income_listx != null) {
        for ($x = 0; $x <= count($member_income_listx) - 1; $x++) {
            if ($id == $member_income_listx[$x]['income_type_id']) {
                $checked = 'checked';
                break;
            } else {
                $checked = '';
            }
        }
    }
    return $checked;
}

?>
<!--</form>-->

<?php
include("footer.php");
?>

<script>
    var income_selected = [];
    // $(function () {
    //     $('#id-validate').prop('checked', true);
    //     $("#id-validate").trigger('change');
    //     $('#id-validate').on("change", function () {
    //         $('form[novalidate]').addClass('d-none')
    //         $('#validation-form').removeClass('d-none')
    //     });
    //
    //
    $("#form-field-mask-1").inputmask("99/99/9999")
    $("#otp-phone-number").inputmask("999-9999999")
    //
    // });

    function copyaddress(e) {
        var val = e.val();

        if (val == 1) {

            $(".address-current").prop("disabled", "disabled").val('');
            $(".street-current").prop("disabled", "disabled").val('');
            $(".province-current-id").prop("disabled", "disabled").val(-1).change();
            $(".city-current-id").prop("disabled", "disabled").val(-1).change();
            $(".district-current-id").prop("disabled", "disabled").val(-1).change();
            $(".zipcode-current").prop("disabled", "disabled").val('');

            var address = $(".address").val();
            if (address == '' || address == null) {
                alert("กรุณากรอกข้อมูลที่อยู่ให้ครบถ้วน");

            } else {
                // $(".address-current").prop("disabled", "").val('');
                // $(".street-current").prop("disabled", "").val('');
                // $(".province-current-id").prop("disabled", "").val(-1).change();
                // $(".city-current-id").prop("disabled", "").val(-1).change();
                // $(".district-current-id").prop("disabled", "").val(-1).change();
                // $(".zipcode-current").prop("disabled", "").val('');
            }
        } else {
            $(".address-current").prop("disabled", "").val('');
            $(".street-current").prop("disabled", "").val('');
            $(".province-current-id").prop("disabled", "").val(-1).change();
            $(".city-current-id").prop("disabled", "").val(-1).change();
            $(".district-current-id").prop("disabled", "").val(-1).change();
            $(".zipcode-current").prop("disabled", "").val('');
        }
    }

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

    function getCity2(e) {
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
                    $(".city-current-id").html(data);
                }
            });
        }
    }

    function getDistrict2(e) {
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
                    $(".district-current-id").html(data);
                    getZipcode2(id);
                }
            });
        }
    }

    function getZipcode2(e) {
        if (e != '') {
            //alert(id);
            $.ajax({
                type: "post",
                dataType: "html",
                url: "models/getZipcode.php",
                async: false,
                data: {'city_id': e},
                success: function (data) {
                    $(".zipcode-current").val(data);
                }
            });
        }
    }

    function saveform() {
        //alert();
        //$("#form-x").submit();
        // $("#validation-form").submit();
        // alert('ss');
        var form = document.getElementById('validation-form');
        if (form.checkValidity() === false) {
            // event.preventDefault();
            // event.stopPropagation();
            alert('validate error');
            form.classList.add('was-validated');
            return false;
        } else {
            form.submit();
            //alert('ok');
        }
    }

    function checkaddlist(e) {
        var val = e.attr("data-var");
        // var obj = {};
        // obj['id'] = val;

        // selecteditem.push(obj);

        if (e.is(':checked')) {
            console.log('onnnnn');
            income_selected.push(val);
        } else {
            console.log('off');
            $.each(income_selected, function (i, el) {
                // console.log(el);
                if (el == val) {
                    income_selected.splice(i, 1);
                }
            });
        }

        $(".income-selected").val(income_selected);
        console.log(income_selected);
    }

    function everyvalidate(e) {
        //  if (document.getElementById('id-validate').checked && !$('#validation-form').valid()) return false;

        //  $('#validation-form').submit();
    }

    function submitmyform() {
       // if (!$('#validation-form').valid()) return false;
        //$(".action-type").val(0);
        document.getElementById('approve-form').submit();
    }
</script>
