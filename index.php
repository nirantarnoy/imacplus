<?php
include "header.php";
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
        <button type="button" class="btn btn-light-green btn-h-green btn-a-green border-0 radius-3 py-2 text-600 text-90">
                  <span class="d-none d-sm-inline mr-1">
                Save
            </span>
            <i class="fa fa-save text-110 w-2 h-2"></i>
        </button>

        <button type="button" class="mx-2px btn btn-light-purple btn-h-purple btn-a-purple border-0 radius-3 py-2 text-90">
            <i class="fa fa-undo text-110 w-2 h-2"></i>
        </button>

        <div class="btn-group dropdown dd-backdrop dd-backdrop-none-md">
            <button type="button" class="btn btn-light-primary btn-h-primary btn-a-primary border-0 radius-3 py-2 text-90 dropdown-toggle" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-search text-110 w-2 h-2"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated animated-2 dd-slide-up dd-slide-none-md">
                <div class="dropdown-inner">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-3">
    <div class="col-xl-8">
        <div class="row px-3 px-lg-4">
            <div class="col-12">
                <div class="row h-100 mx-n425">

                    <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                        <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 mb-3">
                                    <div class="text-nowrap text-100 text-dark-l2">
                                        Earnings
                                    </div>


                                    <div>
                                        <span class="text-150 text-secondary-d1 mr-n1">$</span>
                                        <span class="text-170 text-secondary-d4">
                						198,450
                					</span>

                                        <span class="text-blue text-nowrap ml-n1">
                						+5%
                						<i class="fa fa-caret-up"></i>
                					</span>
                                    </div>
                                </div>
                            </div>



                            <button type='button' class='btn btn-outline-blue radius-round btn-bold px-4 py-1 mt-3 mx-auto'>View Report</button>
                        </div><!-- /.ccard -->
                    </div><!-- /.col -->


                    <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                        <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 mb-3">
                                    <div class="text-nowrap text-100 text-dark-l2">
                                        Page views
                                    </div>


                                    <div>

                                <span class="text-170 text-secondary-d4">
                						729,351
                					</span>

                                        <span class="text-blue text-nowrap ml-n1">
                						+7.2%
                						<i class="fa fa-caret-up"></i>
                					</span>
                                    </div>
                                </div>
                            </div>


                            <div class="align-self-center w-95">
                                <canvas class="infobox-line-chart ml-n15 mt-n2" style="height: 64px; width: 100%;" data-values="[1000,800,1800,400,1500,1000,1050,1300,2100,1400,1500,1350]"></canvas>
                            </div>

                        </div><!-- /.ccard -->
                    </div><!-- /.col -->


                    <div class="col-12 col-sm-4 p-0 pos-rel mt-3 mt-sm-0 pt-0 pt-sm-0 text-center">
                        <div class="ccard h-100 d-flex flex-column mx-2 px-2 py-3">
                            <div class="d-flex text-center">
                                <div class="flex-grow-1 mb-3">
                                    <div class="text-nowrap text-100 text-dark-l2">
                                        Task progress
                                    </div>


                                </div>
                            </div>


                            <div class="align-self-center pos-rel text-blue">
                                <canvas class="infobox-progress-chart" style="width: 180px;" data-percent="58"></canvas>
                                <span class="position-center text-600 text-110 text-dark-tp4">
                				58%
                			</span>
                            </div>


                        </div><!-- /.ccard -->
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div>

            <div class="col-12 mt-35">
                <div class="row h-100 mx-n425">

                    <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-purple-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">
                					164
                				</span>



                                    <span class="text-md text-danger-m1 align-text-bottom text-nowrap">
                						(-2% <i class="ml-2px fa fa-caret-down"></i>)
                					</span>
                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    orders
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fa fa-shopping-cart text-purple opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </div><!-- /.col -->



                    <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-blue-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">
                					750
                				</span>

                                    <span class="text-md text-success-m1 align-text-bottom text-nowrap">
                						(+8% <i class="ml-2px fa fa-caret-up"></i>)
                					</span>


                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    new followers
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fab fa-twitter text-blue opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </div><!-- /.col -->



                    <div class="col-12 col-md-4 px-0 mb-2 mb-md-0">
                        <div class="ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden">
                            <!-- the colored circles on bottom right -->
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l3 opacity-3" style="width: 5.25rem; height: 5.25rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l2 opacity-5" style="width: 4.75rem; height: 4.75rem;"></div>
                            <div class="position-br	mb-n5 mr-n5 radius-round bgc-orange-l1 opacity-5" style="width: 4.25rem; height: 4.25rem;"></div>


                            <div class="flex-grow-1 pl-25 pos-rel d-flex flex-column">
                                <div class="text-secondary-d4">
                              <span class="text-200">
                					16
                				</span>



                                </div>

                                <div class="mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1">
                                    experiments
                                </div>
                            </div>


                            <div class="ml-auto pr-1 align-self-center pos-rel text-125">
                                <i class="fa fa-bolt text-orange opacity-1 fa-2x mr-25"></i>
                            </div>
                        </div><!-- /.ccard -->
                    </div><!-- /.col -->


                </div>
            </div>
        </div><!-- /.row -->
    </div>

    <div class="col-xl-4 mt-4 mt-xl-0">
        <div class="card ccard h-100 overflow-hidden">
            <div class="card-header border-0 bgc-white card-header-sm">
                <h6 class="card-title text-dark-m3 pl-25 pt-15 text-110">
                    Traffic Sources
                    <br />
                    <span class="text-85 text-dark-l2">
                        Last 7 days
                    </span>
                </h6>

                <div class="card-toolbar no-border align-self-start mt-15 mr-1">
                    <div class="dropdown dd-backdrop dd-backdrop-none-md">
                        <a class="btn btn-light-secondary border-0 btn-bold btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                            This Week
                            <i class="fa fa-caret-down ml-2"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated dd-slide-up dd-slide-none-md">
                            <div class="dropdown-inner">
                                <a class="dropdown-item active btn-a-bold m-1" href="#">This Week</a>
                                <a class="dropdown-item m-1" href="#">Last Week</a>
                                <a class="dropdown-item m-1" href="#">This Month</a>
                                <a class="dropdown-item m-1" href="#">Last Month</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0 bgc-whit flex-grow-1">
                <div class="d-flex align-items-center justify-content-center flex-wrap h-100">
                    <div class="pos-rel">
                        <div class="position-center text-center text-secondary-d3 mt-n3">
                          <span>
                                total
                            </span>

                            <div class="mt-n1 text-180 text-secondary-d4 text-600">
                                730k
                            </div>
                        </div>

                        <canvas id="traffic-source-chart" class="mb-3" style="height: 170px; width: 170px; max-height: 170px; max-width: 170px;"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- /.card -->
    </div>
</div>

<div class="row pt-3 mt-1 mt-lg-3">
    <div class="col-lg-5 order-last order-lg-first mt-lg-3">
        <div class="card border-0">
            <div class="card-header bg-transparent border-0 pl-1">
                <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">
                    <i class="fa fa-star mr-1 text-orange text-90"></i>
                    Best Sellers
                </h5>

                <div class="card-toolbar align-self-center">
                    <a href="#" data-action="toggle" class="card-toolbar-btn text-grey text-110">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-0 ccard overflow-hidden">
                <table class="table brc-black-tp11">
                    <thead class="border-0">
                    <tr class="border-0 bgc-dark-l5 text-dark-tp5">
                        <th class="border-0 pl-4">
                            name
                        </th>
                        <th class="border-0">
                            price
                        </th>
                        <th class="border-0">
                            status
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr class="bgc-h-secondary-l4">
                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                            Hoverboard
                        </td>

                        <td>
                            <small><s class="text-danger-m1">$229.99</s></small>
                            <span class="text-success-m1 font-bolder text-95">
        							$119.99
        						</span>
                        </td>

                        <td>
                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-info-d2 text-white">on sale</span>
                        </td>
                    </tr>
                    <tr class="bgc-h-secondary-l4">
                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                            Hiking Shoe
                        </td>

                        <td>
                            <span class="text-info-d2 text-95 font-bolder">
        							$46.45
        						</span>
                        </td>

                        <td>
                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-success text-white">approved</span>
                        </td>
                    </tr>
                    <tr class="bgc-h-secondary-l4">
                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                            Gaming Console
                        </td>

                        <td>
                            <span class="text-info-d2 text-95 font-bolder">
        							$355.00
        						</span>
                        </td>

                        <td>
                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-danger text-white">pending</span>
                        </td>
                    </tr>
                    <tr class="bgc-h-secondary-l4">
                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                            Digital Camera
                        </td>

                        <td>
                            <small><s class="text-danger-m1">$324.99</s></small>
                            <span class="text-success-m1 font-bolder text-95">
        							$219.95
        						</span>
                        </td>

                        <td>
                            <span class="badge bgc-secondary-l1 text-dark-tp4 border-1 brc-black-tp10"><s>out of stock</s></span>
                        </td>
                    </tr>
                    <tr class="bgc-h-secondary-l4">
                        <td class="text-dark-tp3 opacity-1 text-95 text-600 pl-4">
                            Laptop
                        </td>

                        <td>
                            <span class="text-info-d2 text-95 font-bolder">
        							$899.00
        						</span>
                        </td>

                        <td>
                            <span class="badge text-75 border-l-3 brc-black-tp8 bgc-orange text-white">SOLD</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4 mb-lg-0 mt-3">
        <div class="card border-0 h-100">
            <div class="card-header border-0 bgc-transparent pl-1">
                <h5 class="card-title mb-2 mb-md-0 text-120 text-grey-d3">
                    <i class="fas fa-chart-line text-primary-m2 mr-1 text-105"></i>
                    Sale Stats
                </h5>

                <div class="card-toolbar no-border dd-backdrop dd-backdrop-none-md">
                    <a href="#" class="btn btn-xs btn-light-secondary border-1 text-600 px-4 radius-round dropdown-toggle" role="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                        2020
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-caret dropdown-animated dd-appear-center dd-slide-none-md mw-auto">
                        <div class="dropdown-inner">
                            <a class="dropdown-item active" href="#">2020</a>
                            <a class="dropdown-item" href="#">2019</a>
                            <a class="dropdown-item" href="#">2018</a>
                        </div>
                    </div>
                </div>

                <div class="card-toolbar align-self-center">
                    <a href="#" data-action="reload" class="card-toolbar-btn text-success-m2 text-100">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-0 ccard px-1 mx-n1 mx-md-0 h-100 d-flex align-items-center">
                <div class="mx-n2 px-0 mx-md-0 my-2 w-100">
                    <canvas id="saleschart" height="105"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
