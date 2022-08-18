<?php

include "header.php";

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
//include "models/MemberModel.php";
//include "models/UserModel.php";
include "models/MemberTypeModel.php";

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

$member_id = getMemberFromUser($_SESSION['userid'], $connect);
?>

<div class="row">

    <input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
    <input type="hidden" class="msg-error" value="<?= $noti_error ?>">
    <!-- the left side profile picture and other info -->
    <div class="col-12 col-12">
        <div class="card acard">
            <div class="card-body">
                    <span class="d-none position-tl mt-2 pt-3px">
                    <span class="text-white bgc-blue-d1 ml-2 radius-b-1 py-2 px-2">
                        <i class="fa fa-star"></i>
                    </span>
                    </span>


                <div class="d-flex flex-column py-3 px-lg-3 justify-content-center align-items-center">

                    <div class="pos-rel">
                        <img alt="Profile image" src="uploads/member_photo/<?=getMemberPhoto($connect, $member_id)==''?'demo.png':getMemberPhoto($connect, $member_id)?>"
                             class="radius-round bord1er-2 brc-warning-m1" style="width: 64px;height: 65px;"/>

                                                <span class="position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
<!--                                                <span class="position-tr bgc-success p-1 radius-round border-2 brc-white mt-3px mr-3px"><i class="fa fa-edit"></i></span>-->

                    </div>

                    <div class="text-center mt-2">
                        <h3 class="text-130 text-dark-m3">
                            <?= getUserDisplayname($_SESSION['userid'], $connect) ?>
                        </h3>

                        <span class="text-100 text-primary text-600">
                            <?php //echo getMemberType($connect, $member_id)?>
                            <?= getMembertypeName(getMemberType($connect, $member_id), $connect) ?> <br/>

                        </span>

                        <span class="d-none badge bgc-orange-l3 text-orange-d3 pt-2px pb-1 text-85 radius-round px-25 border-1 brc-orange-m3">
                        </span>
                    </div>

                    <div class="mx-auto mt-25 text-center">
                        <div class="btn btn-secondary btn-edit-profile">แก้ไขรูปโปรไฟล์</div>
                        <a href="profile_editpage.php?refid=<?=$member_id?>" class="btn btn-info btn-edit-data">แก้ไขข้อมูลส่วนตัว</a>
                    </div>

                    <hr class="w-90 mx-auto brc-secondary-l3"/>

                    <!--                        <div class="text-center">-->
                    <!--                            <button type="button" class="btn btn-blue pos-rel px-5 px-md-4 px-lg-5">-->
                    <!--                                <i class="far fa-external-link-alt mr-15 text-110"></i>-->
                    <!--                               ส่งลิงค์-->
                    <!--                            </button>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                        <hr class="w-90 mx-auto mb-1 brc-secondary-l3" />-->

                    <div class="mt-12">
                        <!--                            <a href="#" class="btn btn-white btn-text-green btn-h-green btn-a-green radius-1 py-2 px-1 shadow-sm">-->
                        <!--                                <i class="fa fa-link w-4 text-120"></i>-->
                        <!--                            </a>-->
                        <input type="hidden" id="member-url" value="<?= getMemberurl($connect, $member_id) ?>">
                        <a href="#"
                           class="btn btn-white btn-text-info btn-h-info btn-a-info radius-1 py-2 px-1 shadow-sm"
                           onclick="copyclipboard()">
                            <i class="fa fa-copy w-4 text-120"></i>
                        </a>

                    </div>
                    <div class="mt-12">
                        <br/>
                        <p>กดปุ่มเพื่อแนะนำเพื่อน</p>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <b>Link:</b> <span> </span> <?= getMemberurl($connect, $member_id) ?>
                        </div>
                    </div>

                    <hr class="w-90 mx-auto mb-1 brc-secondary-l3"/>

                    <div class="row w-100 text-center">
                        <div class="col-4">
                            <div class="px-1 pt-2">
                                <span class="text-140 text-primary-m3"><b><?= number_format(getMemberPoint($connect, $member_id), 0) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>คะแนน mPoint</b></span>
                            </div>

                            <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>

                        </div>

                        <div class="col-4">
                            <div class="px-1 pt-2">
                                <span class="text-140 text-primary-m3"><b><?= number_format(getMemberWalletAmount($connect, $member_id), 0) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>จำนวนวอลเล็ท</b></span>
                            </div>

                            <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>
                        </div>

                        <div class="col-4">
                            <div class="px-1 pt-2">
                                <span class="text-140 text-primary-m3"><b><?= number_format(getMemberChildCount($connect, $member_id)) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>สมาชิกแนะนำ</b></span>
                            </div>


                        </div>


                    </div>


                    <hr class="w-90 mx-auto mb-1 border-dotted"/>
                    <br/>

                    <div class="row w-100">
                        <div class="col-lg-6">
                            <a href="workorder.php?element=1" role="button" class="d-style btn btn-lighter-secondary btn-h-outline-purple btn-a-outline-purple btn-a-bgc-white w-100 border-t-3 my-1 py-3">
                                <input type="radio" name="transportation" value="train" class="invisible pos-abs" />

                                <div class="d-flex flex-column align-items-center">

                                    <div class="position-tr m-1 mr-2">
                                <span class="d-active">
										<i class="fa fa-check text-success-m1 text-125"></i>
									</span>
                                    </div>

                                    <div class="mb-2">
                                        <i class="v-n-active fas fa-wrench text-160 text-grey-m3 mr-n35"></i>
                                        <i class="v-active fas fa-wrench text-200 text-purple ml-n2"></i>
                                    </div>

                                    <div class="font-bolder text-150 text-secondary flex-grow-1">
                                        แจ้งซ่อม
                                        <div class="text-grey-d2 font-light">
                                        </div>
                                    </div>

                                </div>

                            </a>
                        </div>
                        <div class="col-lg-6">

                            <a href="dropoff.php?element=1" role="button" class="d-style btn btn-lighter-secondary btn-h-outline-purple btn-a-outline-purple btn-a-bgc-white w-100 border-t-3 my-1 py-3">
                                <input type="radio" name="transportation" value="train" class="invisible pos-abs" />

                                <div class="d-flex flex-column align-items-center">

                                    <div class="position-tr m-1 mr-2">
                                <span class="d-active">
										<i class="fa fa-check text-success-m1 text-125"></i>
									</span>
                                    </div>

                                    <div class="mb-2">
                                        <i class="v-n-active fas fa-box-open text-160 text-grey-m3 mr-n35"></i>
                                        <i class="v-active fas fa-wrench text-200 text-purple ml-n2"></i>
                                    </div>

                                    <div class="font-bolder text-150 text-secondary flex-grow-1">
                                        Drop Off
                                        <div class="text-grey-d2 font-light">
                                        </div>
                                    </div>

                                </div>

                            </a>
                        </div>

                    </div>
                    <br/>

                    <div class="row w-100">
                        <div class="col-lg-4">
<!--                            <a href="upgraderequest.php?element=1" class="btn btn-warning btn-lg" style="width: 100%">อัพเกรดสมาชิก</a>-->
                            <a href="upgraderequest.php?element=1" class="btn btn-warning radius-3 border-b-8 py-25 btn-bold btn-text-slide-x mb-2"
                                    style="width: 100%;">
                                <!-- width should be fixed -->
                                  <span class="btn-text-2 move-right">
                                    <span class="d-inline-block bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-1 border-1">
                                        <i class="fa fa-arrow-right text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                  </span><span style="font-size: 18px;">อัพเกรดสมาชิก</span>
                                <!-- there should be no `space` between text and icon , for better results -->
                            </a>
                        </div>
                        <div class="col-lg-4">
<!--                            <a href="walletlist.php?element=1" class="btn btn-primary btn-lg" style="width: 100%">เติมวอลเล็ท</a>-->
                            <a href="walletlist.php?element=1" class="btn btn-primary radius-3 border-b-8 py-25 btn-bold btn-text-slide-x mb-2"
                               style="width: 100%;">
                                <!-- width should be fixed -->
                                <span class="btn-text-2 move-right">
                                    <span class="d-inline-block bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-1 border-1">
                                        <i class="fa fa-arrow-right text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                  </span><span style="font-size: 18px;">เติมวอลเล็ท</span>
                                <!-- there should be no `space` between text and icon , for better results -->
                            </a>
                        </div>
                        <div class="col-lg-4">
<!--                            <a href="witdrawlist.php?element=1" class="btn btn-info btn-lg" style="width: 100%">ถอน-->
<!--                                mPoint</a>-->
                            <a href="witdrawlist.php?element=1" class="btn btn-info radius-3 border-b-8 py-25 btn-bold btn-text-slide-x mb-2"
                               style="width: 100%;">
                                <!-- width should be fixed -->
                                <span class="btn-text-2 move-right">
                                    <span class="d-inline-block bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-1 border-1">
                                        <i class="fa fa-arrow-right text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                  </span><span style="font-size: 18px;">ถอน mPoint</span>
                                <!-- there should be no `space` between text and icon , for better results -->
                            </a>
                        </div>
                    </div>
                    <br>



                    <div class="mt-2 w-100 text-90 text-secondary radius-1 px-25 py-3">


                    </div>

                </div><!-- /.d-flex -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->


    </div><!-- .col -->


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
                    <input type="hidden" name="recid" class="user-recid" value="<?=$member_id?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">อัพโหลดรูปโปรไฟล์</label>
                            <input type="file" name="photo_profile" accept="image/png, image/gif, image/jpeg" >
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
    $(".btn-edit-profile").click(function(){
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