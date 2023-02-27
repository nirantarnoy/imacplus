<?php
include("header.php");
include("models/MemberTypeModel.php");

$package_data = getMemberTypeData($connect);
$parent_member_id = findCurrentParentId($connect, $member_id);
?>
<style>
    .error-form-validate {
        color: red;
        /*background-color: #acf;*/
    }
</style>
<div class="mt-5">

    <?php for ($i = 0; $i <= count($package_data) - 1; $i++): ?>
        <?php if ($package_data[$i]['is_vipshop']): ?>
            <div class="d-style bgc-white btn btn-outline-lightgrey btn-h-outline-green btn-a-outline-green w-100 my-2 py-3 shadow-sm border-2">
                <!-- Pro Plan -->
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="hidden" class="line-upgrade-id" value="<?= $package_data[$i]['id'] ?>">
                        <h4 class="pt-3 text-170 text-600 text-green-d1 letter-spacing">
                            <?= $package_data[$i]['name'] ?>
                        </h4>

                        <div class="text-secondary-d2 text-120">
                            <!--                    <div class="text-danger-m3 text-90 mr-1 ml-n4 pos-rel d-inline-block">-->
                            <!--                        $<span class="text-150">30</span>-->
                            <!--                        <span>-->
                            <!--                            <span class="d-block rotate-45 position-l mt-n475 ml-35 fa-2x text-400 border-l-2 h-5 brc-dark-m1"></span>-->
                            <!--                        </span>-->
                            <!--                    </div>-->
                            <span class="align-text-bottom"></span><span
                                    class="text-180"><?= number_format($package_data[$i]['update_price']) ?></span> บาท
                        </div>
                    </div>

                    <ul class="list-unstyled mb-0 col-12 col-md-4 text-dark-l1 text-90 text-left my-4 my-md-0">
                        <li>
                            <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>
                            <span>
                        <span class="text-110">ระบบรับซ่อมออนไลน์</span>
                      </span>
                        </li>

                        <li class="mt-25">
                            <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>
                            <span class="text-110">
                        ป้ายธงจุด Drop Off ขนาด 50 x  160 cm
                    </span>
                        </li>

                        <!--                <li class="mt-25">-->
                        <!--                    <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>-->
                        <!--                    <span class="text-110">-->
                        <!--                        Tortor mauris-->
                        <!--                    </span>-->
                        <!--                </li>-->
                    </ul>
                    <?php  if (getMemberTypeVIP($connect, $member_id) == 0): ?>
                    <div class="col-12 col-md-4 text-center">
                        <a href="#" class="f-n-hover btn btn-grey btn-raised px-4 py-25 w-75 text-600"
                           data-var="<?= $package_data[$i]['id'] ?>"
                           onclick="choosepackage($(this))">เลือกแพ็คเก็จ</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endfor; ?>


    <!--    <div class="d-style btn border-2 bgc-white btn-outline-lightgrey btn-h-outline-purple btn-a-outline-purple w-100 my-2 py-3 shadow-sm">-->
    <!--      -->
    <!--        <div class="row align-items-center">-->
    <!--            <div class="col-12 col-md-4">-->
    <!--                <h4 class="pt-3 text-170 text-600 text-purple-d1 letter-spacing">-->
    <!--                    Premium Plan-->
    <!--                </h4>-->
    <!---->
    <!--                <div class="text-secondary-d1 text-120">-->
    <!--                    <span class="ml-n15 align-text-bottom">$</span><span class="text-180">50</span> / month-->
    <!--                </div>-->
    <!--            </div>-->
    <!---->
    <!--            <ul class="list-unstyled mb-0 col-12 col-md-4 text-dark-l1 text-90 text-left my-4 my-md-0">-->
    <!--                <li>-->
    <!--                    <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>-->
    <!--                    <span>-->
    <!--                        <span class="text-110">Everything in Pro...</span>-->
    <!--                      </span>-->
    <!--                </li>-->
    <!---->
    <!--                <li class="mt-25">-->
    <!--                    <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>-->
    <!--                    <span class="text-110">-->
    <!--                        Placerat duis-->
    <!--                    </span>-->
    <!--                </li>-->
    <!---->
    <!--                <li class="mt-25">-->
    <!--                    <i class="fa fa-check text-success-m2 text-110 mr-2 mt-1"></i>-->
    <!--                    <span class="text-110">-->
    <!--                        Molestie nunc non-->
    <!--                    </span>-->
    <!--                </li>-->
    <!--            </ul>-->
    <!---->
    <!--            <div class="col-12 col-md-4 text-center">-->
    <!--                <a href="#" class="f-n-hover btn btn-purple btn-raised px-4 py-25 w-75 text-600">Get Started</a>-->
    <!--            </div>-->
    <!--        </div>-->
    <!---->
    <!--    </div>-->
</div>
<!--<div class="row">-->
<!--    <div class="colo-lg-12">-->
<!--        <h1>อัพเกรดเป็นสมาชิก VIP SHOP</h1>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <h4>รายละเอียดแพ็คเก็จ</h4>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="row">-->
<!--    <div class="col-lg-12">-->
<!--        - ระบบรับซ่อมออนไลน์ <br />-->
<!--        - ป้ายธงจุด Drop Off ขนาด 50*160cm-->
<!--    </div>-->
<!--</div>-->
<br/>
<div class="payment" style="display: none;">
    <div class="row">
        <div class="col-lg-12">
            <h4>วิธีชำระเงิน</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            - โอนเงินเข้าบัญชี ไทยพาณิชย์ 426-128-677-8<br/>
            - แนบสลิปการชำระเงินและกดปุ่ม แจ้งอัพเกรดสมาชิก ข่างล่าง
        </div>
    </div>
    <br/><br/>
    <form id="form-upgrade" enctype="multipart/form-data" action="add_member_upgrade.php" method="post">
        <input type="hidden" name="package_amount" value="" class="package-selected-amount">
        <input type="hidden" name="package_name" value="" class="package-selected-name">
        <input type="hidden" name="package_id" value="" class="package-selected-id">
        <div class="row">
            <div class="col-lg-3">
                แนบสลิปหลักฐานการโอนเงิน<br/><br/>
                <input type="file" name="file_slip" required>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-3">
                <div class="btn btn-secondary" onclick="confirmupgrade()">แจ้งอัพเกรดสมาชิก</div>

            </div>
        </div>
    </form>
</div>


<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
                <!-- Modal Header -->
<!--                <div class="modal-header">-->
<!--                    <h4 class="modal-title" style="color: #1c606a">ยืนยันการขออัพเกรดสมาชิก</h4>-->
<!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--                </div>-->

                <!-- Modal body -->
                <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-12" style="text-align: center;">
                         <h5 style="color: #5bb15b"><b>คุณต้องการอัพเกรดสมาชิกด้วยผู้แนะนำนี้หรือไม่</b></h5>
                     </div>
                 </div>
                    <br />
                    <?php if ($parent_member_id != '' || $parent_member_id != null): ?>
                        <?php //if (1 > 0): ?>
                        <?php

                        $member_data = getMemberIntroduceData($connect, $parent_member_id);
                        ?>
                        <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3"
                             style="text-align: center;">
                            <p class="text-primary">สมาชิกแนะนำ</p>
                            <?php if ($member_data[0]['photo'] != null): ?>
                                <img id="id-navbar-user-image"
                                     class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"
                                     src="uploads/member_photo/<?= $member_data[0]['photo'] == '' ? 'demo.png' : $member_data[0]['photo'] ?>"
                                     alt="Member 's photo">

                            <?php else: ?>
                                <i class="fa fa-user-circle fa-5x text-info"></i>
                            <?php endif; ?>
                            <p>
                                <b><?= $member_data[0]['name'] . ' ' . $member_data[0]['lname'] ?></b>
                            </p>
                        </div>
                        <br>
                    <?php endif; ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-success btn-save" data-dismiss="modalx" onclick="acceptconfirmupgrade()"><i
                                class="fa fa-check-circle"></i> ยืนยันการอัพเกรด
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> ยกเลิก
                    </button>
                </div>

        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>
    function choosepackage(e) {
        var package_id = e.attr('data-var');
        if (package_id != null) {
            $(".package-selected-id").val(package_id);
        }
        if (e.hasClass("btn-grey")) {
            e.removeClass("btn-grey");
            e.addClass("btn-green");
            $(".payment").show();
        } else {
            e.removeClass("btn-green");
            e.addClass("btn-grey");
            $(".payment").hide();
        }
    }

    function confirmupgrade() {
        // var swalWithBootstrapButtons = Swal.mixin({
        //     customClass: {
        //         confirmButton: 'btn btn-success mx-2',
        //         cancelButton: 'btn btn-danger mx-2'
        //     },
        //     buttonsStyling: false
        // })
        // swalWithBootstrapButtons.fire({
        //     title: 'ยืนยัน?',
        //     text: "คุณต้องการทำรายการนี้ใช่หรือไม่!",
        //     type: 'warning',
        //     showCancelButton: true,
        //     scrollbarPadding: false,
        //     confirmButtonText: 'ใช่',
        //     cancelButtonText: 'ไม่ใช่',
        //     reverseButtons: true,
        //
        // }).then(function (result) {
        //     if (result.value) {
        //         $(".package-selected-amount").val(2500);
        //         $(".package-selected-name").val("VIP-SHOP");
        //         $("#form-upgrade").validate({errorClass: 'error-form-validate'});
        //         $("#form-upgrade").submit();
        //     }
        // })

        $("#myModal").modal("show");
    }



    function acceptconfirmupgrade(){
        $(".package-selected-amount").val(2500);
        $(".package-selected-name").val("VIP-SHOP");
        $("#form-upgrade").validate({errorClass: 'error-form-validate'});
        $("#form-upgrade").submit();
    }
</script>