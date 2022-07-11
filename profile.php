<?php
include "header.php";
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
                            <img alt="Profile image" src="assets/image/avatar/avatar1.jpg" class="radius-round bord1er-2 brc-warning-m1" />
                            <span class=" position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
                        </div>

                        <div class="text-center mt-2">
                            <h3 class="text-130 text-dark-m3">
                                ทดสอบ ระบบ
                            </h3>

                            <span class="text-100 text-primary text-600">
                            VIP SHOP
                        </span>

                            <span class="d-none badge bgc-orange-l3 text-orange-d3 pt-2px pb-1 text-85 radius-round px-25 border-1 brc-orange-m3">
                            pro
                        </span>
                        </div>

                        <div class="mx-auto mt-25 text-center">
                           <i class="fa fa-trophy" style="size: 25px;color: #e0a800;"></i>
                        </div>

                        <hr class="w-90 mx-auto brc-secondary-l3" />

<!--                        <div class="text-center">-->
<!--                            <button type="button" class="btn btn-blue pos-rel px-5 px-md-4 px-lg-5">-->
<!--                                <i class="far fa-external-link-alt mr-15 text-110"></i>-->
<!--                               ส่งลิงค์-->
<!--                            </button>-->
<!--                        </div>-->
<!---->
<!--                        <hr class="w-90 mx-auto mb-1 brc-secondary-l3" />-->

                        <div class="mt-3">
                            <a href="#" class="btn btn-white btn-text-green btn-h-green btn-a-green radius-1 py-2 px-1 shadow-sm">
                                <i class="fa fa-link w-4 text-120"></i>
                            </a>

                            <a href="#" class="btn btn-white btn-text-info btn-h-info btn-a-info radius-1 py-2 px-1 shadow-sm">
                                <i class="fa fa-copy w-4 text-120"></i>
                            </a>

                        </div>

                        <hr class="w-90 mx-auto mb-1 brc-secondary-l3" />

                        <div class="row w-100 text-center">
                            <div class="col-4">
                                <div class="px-1 pt-2">
                                    <span class="text-150 text-primary-m3"><b>50.00</b></span>
                                    <br />
                                    <span class="text-grey-m1 text-90"><b>คะแนน mPoint</b></span>
                                </div>

                                <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>
                            </div>

                            <div class="col-4">
                                <div class="px-1 pt-2">
                                    <span class="text-150 text-primary-m3"><b>100.00</b></span>
                                    <br />
                                    <span class="text-grey-m1 text-90"><b>จำนวนวอลเล็ท</b></span>
                                </div>

                                <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>
                            </div>

                            <div class="col-4">
                                <div class="px-1 pt-2">
                                    <span class="text-150 text-primary-m3"><b>5</b></span>
                                    <br />
                                    <span class="text-grey-m1 text-90"><b>สมาชิกแนะนำ</b></span>
                                </div>

                                <div class="position-rc h-75 border-l-1 brc-secondary-l3"></div>
                            </div>


                        </div>


                        <hr class="w-90 mx-auto mb-1 border-dotted" />
                        <br />

                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <div class="btn btn-primary btn-lg" style="width: 100%">เติมวอลเล็ท</div>
                            </div>
                            <div class="col-lg-2"></div>
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
                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i class="fa fa-save"></i> Save </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
