<?php
ob_start();
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}
include "header.php";
include "models/MemberModel.php";
//include "models/UserModel.php";
include "models/MemberTypeModel.php";

$member_id = getMemberFromUser($_SESSION['userid'], $connect);
?>

<div class="row">

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
                        <img alt="Profile image" src="assets/image/avatar/avatar1.jpg"
                             class="radius-round bord1er-2 brc-warning-m1"/>
                        <span class=" position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
                    </div>

                    <div class="text-center mt-2">
                        <h3 class="text-130 text-dark-m3">
                            <?= getUserDisplayname($_SESSION['userid'], $connect) ?>
                        </h3>

                        <span class="text-100 text-primary text-600">
                            <?= getMembertypeName(getMemberType($connect, $member_id), $connect) ?> <br/>

                        </span>

                        <span class="d-none badge bgc-orange-l3 text-orange-d3 pt-2px pb-1 text-85 radius-round px-25 border-1 brc-orange-m3">
                        </span>
                    </div>

                    <div class="mx-auto mt-25 text-center">
                        <i class="fa fa-trophy" style="size: 25px;color: #e0a800;"></i>
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
                                <span class="text-170 text-primary-m3"><b><?= number_format(getMemberPoint($connect, $member_id), 2) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>คะแนน mPoint</b></span>
                            </div>

                            <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>

                        </div>

                        <div class="col-4">
                            <div class="px-1 pt-2">
                                <span class="text-170 text-primary-m3"><b><?= number_format(getMemberWalletAmount($connect, $member_id), 2) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>จำนวนวอลเล็ท</b></span>
                            </div>

                            <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>
                        </div>

                        <div class="col-4">
                            <div class="px-1 pt-2">
                                <span class="text-170 text-primary-m3"><b><?= number_format(getMemberChildCount($connect, $member_id)) ?></b></span>
                                <br/>
                                <span class="text-grey-m1 text-90"><b>สมาชิกแนะนำ</b></span>
                            </div>


                        </div>


                    </div>


                    <hr class="w-90 mx-auto mb-1 border-dotted"/>
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

                    <div class="row w-100">
                        <div class="col-lg-6">
<!--                            <a href="workorder.php?element=1" class="btn btn-default btn-lg" style="width: 100%">แจ้งซ่อม</a>-->
                            <a href="workorder.php?element=1" class="btn btn-info radius-3 border-b-8 py-25 btn-bold btn-text-slide-x mb-2"
                               style="width: 100%;">
                                <!-- width should be fixed -->
                                <span class="btn-text-2 move-right">
                                    <span class="d-inline-block bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-1 border-1">
                                        <i class="fa fa-arrow-right text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                  </span><span style="font-size: 18px;">แจ้งซ่อม</span>
                                <!-- there should be no `space` between text and icon , for better results -->
                            </a>
                        </div>
                        <div class="col-lg-6">
<!--                            <a href="dropoff.php?element=1" class="btn btn-success btn-lg" style="width: 100%">Drop-->
<!--                                Off</a>-->
                            <a href="dropoff.php?element=1" class="btn btn-success radius-3 border-b-8 py-25 btn-bold btn-text-slide-x mb-2"
                               style="width: 100%;">
                                <!-- width should be fixed -->
                                <span class="btn-text-2 move-right">
                                    <span class="d-inline-block bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-1 border-1">
                                        <i class="fa fa-arrow-right text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                  </span><span style="font-size: 18px;">Drop off</span>
                                <!-- there should be no `space` between text and icon , for better results -->
                            </a>
                        </div>

                    </div>


                    <div class="mt-2 w-100 text-90 text-secondary radius-1 px-25 py-3">


                    </div>

                </div><!-- /.d-flex -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->


    </div><!-- .col -->


</div>
<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="customer_action.php" id="form-user" method="post">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #1c606a"><i class="fa fa-pencil"></i> เพิ่มข้อมูลลูกค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">รหัสลูกค้า <span style="color: red"><b>*</b></span></label>
                            <input type="text" class="form-control cust-code" name="cust_code" value=""
                                   placeholder="รหัส" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="">กลุ่มลูกค้า <span style="color: red"><b>*</b></span></label>
                            <!--                            <input type="text" class="form-control cust-group-id" name="cust_group_id" value=""-->
                            <!--                                   placeholder="กลุ่มลูกค้า" required>-->
                            <select name="customer_group_id" class="form-control customer-group-id" id="">
                                <?php for ($i = 0; $i <= count($cusgroup_data) - 1; $i++): ?>
                                    <!--                                    --><?php //$selected = '';
//                                    if ( == $cusgroup_data[$i]['id']) {
//                                        $selected = "selected";
//                                    }
//                                    ?>
                                    <option value="<?= $cusgroup_data[$i]['id'] ?>"><?= $cusgroup_data[$i]['group_name'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control cust-name" name="cust_name" value=""
                                   placeholder="ชื่อ-นามสกุล">
                        </div>
                        <div class="col-lg-3">
                            <label for="">เบอร์โทร</label>
                            <input type="text" class="form-control phone" name="phone" value=""
                                   placeholder="เบอร์">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control email" name="email" value=""
                                   placeholder="Email">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Line Id</label>
                            <input type="text" class="form-control line-id" name="line_id" value=""
                                   placeholder="Line ID">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Facebook</label>
                            <input type="text" class="form-control facebook" name="facebook" value=""
                                   placeholder="facebook">
                        </div>
                        <div class="col-lg-3">
                            <label for="">ที่อยู่</label>
                            <textarea class="form-control cust-address" name="cust_address"
                                      placeholder="Address"> </textarea>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Description</label>
                            <textarea class="form-control cust-description" name="cust_description"
                                      placeholder="Description"> </textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Note</label>
                            <textarea class="form-control cust-note" name="cust_note"
                                      placeholder="Note"> </textarea>
                        </div>
                        <div class="col-lg-4">
                            <label for="">สถานะ</label>
                            <select name="status" id="" class="form-control status">
                                <?php for ($i = 0; $i <= count($status_data) - 1; $i++): ?>
                                    <option value="<?= $status_data[$i]['id'] ?>"><?= $status_data[$i]['name'] ?></option>
                                <?php endfor; ?>
                            </select>
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
</script>