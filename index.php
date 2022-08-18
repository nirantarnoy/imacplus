<?php
include "header.php";
include "models/OverviewModel.php";

$member_id = getMemberIDFromUser($connect, $_SESSION['userid']);
//$bytes = random_bytes(16);
//echo bin2hex($bytes);


?>
<div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
        Dashboard
        <small class="page-info text-secondary-d2 text-nowrap">
            <i class="fa fa-angle-double-right text-80"></i>
            overview &amp; stats
        </small>
    </h1>

    <div class="page-tools d-inline-flex">
<!--        <button type="button" class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90">-->
<!--                  <span class="d-none d-sm-inline mr-1">-->
<!--                Save-->
<!--            </span>-->
<!--            <i class="fa fa-save text-110 w-2 h-2"></i>-->
<!--        </button>-->

<!--        <button type="button" class="mx-2px btn btn-light-purple btn-h-purple btn-a-purple border-0 radius-3 py-2 text-90">-->
<!--            <i class="fa fa-undo text-110 w-2 h-2"></i>-->
<!--        </button>-->
<!---->
<!--        <div class="btn-group dropdown dd-backdrop dd-backdrop-none-md">-->
<!--            <button type="button" class="btn btn-light-primary btn-h-primary btn-a-primary border-0 radius-3 py-2 text-90 dropdown-toggle" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                <i class="fa fa-search text-110 w-2 h-2"></i>-->
<!--            </button>-->
<!---->
<!--            <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated animated-2 dd-slide-up dd-slide-none-md">-->
<!--                <div class="dropdown-inner">-->
<!--                    <a class="dropdown-item" href="#">Action</a>-->
<!--                    <a class="dropdown-item" href="#">Another action</a>-->
<!--                    <a class="dropdown-item" href="#">Something else here</a>-->
<!--                    <div class="dropdown-divider"></div>-->
<!--                    <a class="dropdown-item" href="#">Separated link</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>


<div class="row mt-3">
    <div class="col-xl-12">
        <div class="row px-3 px-lg-4">
            <div class="col-12">
<?//=$_SESSION['userid'];?>
            </div>

            <div class="col-12 mt-35">
                <div class="row h-100 mx-n425">

                    <a href="member.php" class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">
                                  <?php if($_SESSION['userid'] != 1):?>
                					<?=getMemberCountAll($connect, $member_id)?>
                					<?php else:?>
                                      <?=getMemberCountAllAdmin($connect)?>
                					<?php endif;?>
                				</span>
                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    สมาชิกทั้งหมด
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fa fa-users text-purple opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </a><!-- /.col -->



                    <a href="workorder.php" class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">

                                    <?php if($_SESSION['userid'] != 1):?>
                                        <?=getWorkCountAll($connect, $member_id)?>
                                    <?php else:?>
                                        <?=getWorkCountAllAdmin($connect)?>
                                    <?php endif;?>
                				</span>

                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    คำสั่งซ่อมใหม่
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fa fa-wrench text-blue opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </a><!-- /.col -->



                    <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">
                                    <?php if($_SESSION['userid'] != 1):?>
                                        <?=getWorkCountComplete($connect, $member_id)?>
                                    <?php else:?>
                                        <?=getWorkCountCompleteAdmin($connect)?>
                                    <?php endif;?>
                				</span>


                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    คำสั่งซ่อมเสร็จแล้ว
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fa fa-check-circle text-green-d1 opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </div><!-- /.col -->


                </div>
            </div>
        </div><!-- /.row -->
    </div>


</div>

<!--<div class="row pt-3 mt-1 mt-lg-3">-->
<!--    <div class="col-lg-5 order-last order-lg-first mt-lg-3">-->
<!--        <div class="card border-0">-->
<!--            <div class="card-header bg-transparent border-0 pl-1">-->
<!--                <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">-->
<!--                    <i class="fa fa-star mr-1 text-orange text-90"></i>-->
<!--                    รายการอะไหล่-->
<!--                </h5>-->
<!---->
<!--                <div class="card-toolbar align-self-center">-->
<!--                    <a href="#" data-action="toggle" class="card-toolbar-btn text-grey text-110">-->
<!--                        <i class="fa fa-chevron-up"></i>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="card-body p-0 ccard overflow-hidden">-->
<!--                <table class="table brc-black-tp11">-->
<!--                    <thead class="border-0">-->
<!--                    <tr class="border-0 bgc-dark-l5 text-dark-tp5">-->
<!--                        <th class="border-0 pl-4">-->
<!--                            name-->
<!--                        </th>-->
<!--                        <th class="border-0">-->
<!--                            ยอดรวม-->
<!--                        </th>-->
<!--                        <th class="border-0">-->
<!--                            status-->
<!--                        </th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!---->
<!--                    <tbody>-->
<!--                    <tr class="bgc-h-secondary-l4">-->
<!--                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">-->
<!--                            Hoverboard-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <small><s class="text-danger-m1">$229.99</s></small>-->
<!--                            <span class="text-success-m1 font-bolder text-95">-->
<!--        							$119.99-->
<!--        						</span>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-info-d2 text-white">on sale</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="bgc-h-secondary-l4">-->
<!--                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">-->
<!--                            Hiking Shoe-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="text-info-d2 text-95 font-bolder">-->
<!--        							$46.45-->
<!--        						</span>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-success text-white">approved</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="bgc-h-secondary-l4">-->
<!--                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">-->
<!--                            Gaming Console-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="text-info-d2 text-95 font-bolder">-->
<!--        							$355.00-->
<!--        						</span>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-danger text-white">pending</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="bgc-h-secondary-l4">-->
<!--                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">-->
<!--                            Digital Camera-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <small><s class="text-danger-m1">$324.99</s></small>-->
<!--                            <span class="text-success-m1 font-bolder text-95">-->
<!--        							$219.95-->
<!--        						</span>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="bgc-h-secondary-l4">-->
<!--                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">-->
<!--                            Laptop-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="text-info-d2 text-95 font-bolder">-->
<!--        							$899.00-->
<!--        						</span>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-orange text-white">SOLD</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="col-lg-7 mb-4 mb-lg-0 mt-3">-->
<!--        <div class="card border-0 h-100">-->
<!--            <div class="card-header border-0 bgc-transparent pl-1">-->
<!--                <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">-->
<!--                    <i class="fas fa-chart-line text-primary-m2 mr-1 text-105"></i>-->
<!--                    Sale Stats-->
<!--                </h5>-->
<!---->
<!--                <div class="card-toolbar no-border dd-backdrop dd-backdrop-none-md">-->
<!--                    <a href="#" class="btn btn-xs btn-light-secondary border-1 text-600 px-4 radius-round dropdown-toggle" role="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">-->
<!--                        2020-->
<!--                    </a>-->
<!---->
<!--                    <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated dd-appear-center dd-slide-none-md mw-auto">-->
<!--                        <div class="dropdown-inner">-->
<!--                            <a class="dropdown-item active" href="#">2020</a>-->
<!--                            <a class="dropdown-item" href="#">2019</a>-->
<!--                            <a class="dropdown-item" href="#">2018</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="card-toolbar align-self-center">-->
<!--                    <a href="#" data-action="reload" class="card-toolbar-btn text-success-m2 text-100">-->
<!--                        <i class="fas fa-sync-alt"></i>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="card-body p-0 ccard px-1 mx-n1 mx-md-0 h-100 d-flex align-items-center">-->
<!--                <div class="mx-n2 px-0 mx-md-0 my-2 w-100">-->
<!--                    <canvas id="saleschart" height="105"></canvas>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php
include "footer.php";
?>
