<?php

include "header.php";

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//include "models/MemberModel.php";
//include "models/UserModel.php";
include "models/MemberTypeModel.php";
include "models/WorkorderModel.php";

$noti_ok = '';
$noti_error = '';

if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}

if (isset($_SESSION['msg-error'])) {
    $noti_error = $_SESSION['msg-error'];
    unset($_SESSION['msg-error']);
}
//echo date('d:m:Y H:i');return;
$member_id = getMemberFromUser($_SESSION['userid'], $connect);

$onlineran = mt_rand(1000, 3000);
$onlineuser = mt_rand($onlineran + 1, 3000);

$is_verified = getMemberverifiedstatus($connect, $member_id);
$is_center = findIsCenter($connect, $member_id);
?>

<div class="row">

    <input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
    <input type="hidden" class="msg-error" value="<?= $noti_error ?>">
    <!-- the left side profile picture and other info -->
    <div class="col-lg-9">
        <?php if ($is_verified): ?>
            <div class="row">
                <div class="col-lg-12"
                     style="text-align: center;background-color: #DBF9DB;border-color: #99C68E;width: 100%;border-width: 2px;border-radius: 5px;margin: 5px;">
                    <br/>
                    <div class="row">
                        <div class="col-lg-6 d-flex flex-column py-3 px-lg-5 justify-content-lg-between align-items-lg-end"
                             style="text-align: right">
                            <div style=" width: 20%;height: 20%;">
                                <img alt="Profile image"
                                     src="assets/iCOn/iCOn/success_logo.png" style="width: 90%;"/>
                            </div>
                        </div>
                        <div class="col-lg-6 " style="text-align: left;margin-top: 5px">
                            <br/>
                            <h4 style="color: #5bb15b">ยืนยันตัวตนสำเร็จ</h4>
                            <h6 style="color: black">คุณสามารถถอน mPoint และส่งซ่อมได้แล้ว</h6>
                        </div>
                    </div>
                    <br/>
                    <!--                <div style="text-align: center;width: 5%;height: 5%;margin-top: 5px;">-->
                    <!--                    <img alt="Profile image"-->
                    <!--                         src="assets/iCOn/iCOn/wallet.png" style="width: 70%;"/>-->
                    <!--                </div>-->
                    <!--                <h4 style="color: #5bb15b">ยืนยันตัวตนสำเร็จ</h4>-->
                    <!--                <h6 style="color: black">คุณสามารถถอน mPoint และส่งซ่อมได้แล้ว</h6>-->
                </div>
            </div>

            <br/>
        <?php else: ?>
            <div class="row" style="">
                <div class="col-lg-12 bg-danger"
                     style="text-align: center;border-color: #99C68E;width: 100%;border-width: 2px;border-radius: 5px;margin: 5px;">
                    <br/>
                    <div class="row">
                        <div class="col-lg-6 d-flex flex-column py-3 px-lg-5 justify-content-lg-between align-items-lg-end"
                             style="text-align: right">
                            <div style=" width: 20%;height: 20%;">
                                <img alt="Profile image"
                                     src="assets/iCOn/iCOn/unsuccess_logo.png" style="width: 90%;"/>
                            </div>
                        </div>
                        <div class="col-lg-6 " style="text-align: left;margin-top: 5px">
                            <br/>
                            <h4 style="color: white">ยืนยันตัวตนไม่สำเร็จ</h4>
                            <h6 style="color: white">คุณไม่สามารถถอน mPoint และไม่สามารคส่งซ่อมได้</h6>
                        </div>
                    </div>
                    <br/>
                    <!--                <div style="text-align: center;width: 5%;height: 5%;margin-top: 5px;">-->
                    <!--                    <img alt="Profile image"-->
                    <!--                         src="assets/iCOn/iCOn/wallet.png" style="width: 70%;"/>-->
                    <!--                </div>-->
                    <!--                <h4 style="color: #5bb15b">ยืนยันตัวตนสำเร็จ</h4>-->
                    <!--                <h6 style="color: black">คุณสามารถถอน mPoint และส่งซ่อมได้แล้ว</h6>-->
                </div>
            </div>
        <?php endif; ?>
        <br/>

        <div class="card" style="border-color: #66CC00;border-width: 3px;background-color: #f0efef">
            <div class="card-body">
                    <span class="d-none position-tl mt-2 pt-3px">
                    <span class="text-white bgc-blue-d1 ml-2 radius-b-1 py-2 px-2">
                        <i class="fa fa-star"></i>
                    </span>
                    </span>
                <div class="row">
                    <div class="col-lg-6">
                        <div style="border-width: 3px;border-color: #5bb15b;background-color: white;padding: 10px;border-radius: 10px;width: 100%">
                            <div class="mx-auto mt-25 text-right">
                                <div class="btn btn-secondary btn-xs btn-edit-profile" style="font-size: 10px;">
                                    แก้ไขรูปโปรไฟล์
                                </div>
                                <a href="profile_edit_page.php?refid=<?= $member_id ?>"
                                   class="btn btn-info btn-xs btn-edit-data"
                                   style="font-size: 10px;">แก้ไขข้อมูลส่วนตัว</a>
                            </div>
                            <div class="d-flex flex-column py-3 px-lg-5 justify-content-center align-items-center">
                                <div class="pos-rel">
                                    <img alt="Profile image"
                                         src="uploads/member_photo/<?= getMemberPhoto($connect, $member_id) == '' ? 'demo.png' : getMemberPhoto($connect, $member_id) ?>"
                                         class="radius-round bord1er-2 brc-warning-m1"
                                         style="width: 64px;height: 65px;"/>

                                    <span class="position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
                                    <!--                                                <span class="position-tr bgc-success p-1 radius-round border-2 brc-white mt-3px mr-3px"><i class="fa fa-edit"></i></span>-->

                                </div>

                                <div class="text-center mt-2">
                                    <h3 class="text-130 text-dark-m3">
                                        <?= getUserDisplayname($_SESSION['userid'], $connect) ?>
                                    </h3>

                                    <span class="text-100 text-600"
                                          style="background-color: #5bb15b;color: white;border-radius: 10px;padding: 5px;">
                            <?php //echo getMemberType($connect, $member_id)?>
                                        <?= getMembertypeName(getMemberType($connect, $member_id), $connect) ?> <br/>

                        </span>
                                    <br/>
                                    <span class="d-none badge bgc-orange-l3 text-orange-d3 pt-2px pb-1 text-85 radius-round px-25 border-1 brc-orange-m3">
                        </span>
                                    <div class="mt-12">
                                        <!--                            <a href="#" class="btn btn-white btn-text-green btn-h-green btn-a-green radius-1 py-2 px-1 shadow-sm">-->
                                        <!--                                <i class="fa fa-link w-4 text-120"></i>-->
                                        <!--                            </a>-->
                                        <input type="hidden" id="member-url"
                                               value="<?= $is_center == 1?'':getMemberurl($connect, $member_id) ?>">
                                        <span>แนะนำเพื่อน </span>
                                        <a href="#"
                                           class="btn btn-white btn-text-info btn-h-info btn-a-info radius-1 py-2 px-1 shadow-sm"
                                           onclick="copyclipboard()">
                                            <i class="fa fa-copy w-4 text-120"></i>
                                        </a>
                                        <span> กดคัดลอก </span>
                                    </div>

                                </div>


                            </div>
                            <div class="row" style="padding-left: 10px;padding-right: 10px;">
                                <div class="col-lg-12">
                                    <div class="row"
                                         style="background-color: lightgrey;border-radius: 10px;padding: 2px;">
                                        <?php if($is_center==0):?>
                                        <div class="col-lg-12" style="text-align: left">
                                            <b>Link:</b> <span> </span> <?= getMemberurl($connect, $member_id) ?>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div style="height: 10px;"></div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <a href="upgraderequest.php">
                                    <span class="text-100 text-600"
                                          style="background-color: #e0a800;color: white;border-radius: 5px;padding-left: 20px;padding-right: 20px;">
                                        STATUS
                                    </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $url = $is_verified ? 'workorder.php?element=1' : '#';
                                ?>
                                <a class="btn" href="<?= $url ?>"
                                   style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/work_photo.png"
                                                     style="width: 100%;height: auto"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>สร้างรายการ</b>
                                            <h3>ซ่อม</h3>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-lg-6">
                                <?php
                                $url = $is_verified ? 'dropoff.php?element=1' : '#';
                                ?>
                                <a class="btn" href="<?= $url ?>"
                                   style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/DropOff.png" style="width: 100%"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>รับ</b>
                                            <h3>Drop Off</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $url = $is_verified ? 'walletlist.php?element=1' : '#';
                                ?>
                                <a class="btn" href="<?=$url?>"
                                   style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/wallet.png" style="width: 100%;"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>เติม</b>
                                            <h3>Wallet</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <?php
                                $url = $is_verified ? 'witdrawlist.php?element=1' : '#';
                                ?>
                                <a class="btn" href="<?=$url?>"
                                   style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/mPoint.png" style="width: 100%"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>My</b>
                                            <h3>Point</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="btn"
                                     style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/Market.png" style="width: 100%;"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>Plus</b>
                                            <h3>Market</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php
                                $url = $is_verified ? 'member_teamlist.php?element=1' : '#';
                                ?>
                                <a class="btn" href="<?=$url?>"
                                   style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div style="width: 100%;height: 100%;margin-top: 5px;">
                                                <img alt="Profile image"
                                                     src="assets/iCOn/iCOn/member.png" style="width: 100%"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-8" style="text-align: center;">
                                            <b>ทีมงาน</b>
                                            <h3>ของฉัน</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div style="width: 100%;border-radius: 10px;background-color: #66CC00;padding: 10px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <h4><b>รายได้สะสมทั้งหมด</b></h4>
                                </div>
                            </div>
                            <div style="height: 10px;"></div>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;color: white">
                                    <h1><?= number_format(getPointall($connect, $member_id)) ?></h1>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <div class="row">
                    <div class="col-lg-3">
                        <a class="btn" href="#"
                           style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <b>รายได้วันนี้ <?= date('d-m-Y'); ?></b>
                                    <h2><?= number_format(getPointtoday($connect, $member_id)) ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a class="btn" href="#"
                           style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <b>รายได้ 7 วันที่ผ่านมา</b>
                                    <h2><?= number_format(getPointsevenday($connect, $member_id)) ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a class="btn" href="#"
                           style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <b>รายได้สะสมเดือนนี้</b>
                                    <h2><?= number_format(getPointthismonth($connect, $member_id)) ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a class="btn" href="#"
                           style="background-color: white;border-color: #66CC00;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;">
                                    <b>รายได้สะสมคงเหลือ</b>
                                    <h2><?= number_format(getCurrentPoint($connect, $member_id)) ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <br/>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <h4><b>รีวิวผู้ใช้งาน ImacPlus</b></h4>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-4" style="margin-top: 5px;">
                        <img alt="review image"
                             src="assets/image/review/review.jpg" style="width: 100%"/>
                    </div>
                    <div class="col-lg-4" style="margin-top: 5px;">
                        <img alt="review image"
                             src="assets/image/review/review.jpg" style="width: 100%"/>
                    </div>
                    <div class="col-lg-4" style="margin-top: 5px;">
                        <img alt="review image"
                             src="assets/image/review/review.jpg" style="width: 100%"/>
                    </div>
                </div>
                <br/>
                <div style="height: 20px;"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <a class="btn" href="#"
                           style="background-color: #66CC00;border-color: #5bb15b;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;color: black;">
                                    <b>จำนวนผู้ใช้งานออนไลน์ขณะนี้</b>
                                    <h2><?= number_format($onlineuser) ?></h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a class="btn" href="#"
                           style="background-color: #66CC00;border-color: #5bb15b;width: 100%;border-width: 2px;border-radius: 10px;margin: 5px;">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center;color: black;">
                                    <b>ส่งซ่อมเสร็จแล้ว</b>
                                    <h2>0</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>

    <div class="col-lg-3">
        <div class="row">
            <div class="col-lg-12" style="margin-top: 10px;">
                <a href="worktrackinglist.php" class="btn"
                   style="border-radius: 10px;background-color: #66CC00;width: 100%">
                    <table style="width: 100%">
                        <tr>
                            <td style="text-align: center">
                                <img src="assets/iCOn/iCOn/tracking.png" style="width: 20%;"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;color: white;">สถานะงานซ่อม</td>
                        </tr>
                    </table>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <img src="assets/iCOn/iCOn/banner.jpg" style="width: 100%;margin-top: 10px;"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <img src="assets/iCOn/iCOn/banner.jpg" style="width: 100%;margin-top: 10px;"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <img src="assets/iCOn/iCOn/banner.jpg" style="width: 100%;margin-top: 10px;"/>
            </div>
        </div>

    </div>


</div>


<div class="modal" id="myModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="update_photo_profile.php" id="form-user" method="post" enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a"><i class="fa fa-pencil"></i> แกไขรูปโปรไฟล์</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="<?= $member_id ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">อัพโหลดรูปโปรไฟล์</label>
                            <input type="file" name="photo_profile" accept="image/png, image/gif, image/jpeg">
                        </div>


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
<?php
include "footer.php";
?>
<script>
    notify();
    $(".btn-edit-profile").click(function () {
        $("#myModal").modal("show");
    });

    function copyclipboard() {
        var copyText = document.getElementById("member-url");

        /* Select the text field */
        // copyText.select();
        // copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        //alert("Copied the text: " + copyText.value);

        $.aceToaster.add({
            placement: 'tr',
            body: "<p class='p-3 mb-0 text-center'>\
                        <span class='d-inline-block text-center mb-3 py-3 px-1 border-1 brc-success radius-round'>\
                            <i class='fa fa-check fa-2x w-6 text-success-m1 mx-2px'></i>\
                        </span><br />\
                        Copy ข้อมูลแล้ว\
                    </p>",

            width: 360,
            delay: 2000,

            close: true,

            className: 'bgc-white-tp1 shadow ',

            bodyClass: 'border-0 p-0 text-dark-tp2',
            headerClass: 'd-none',
        })
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