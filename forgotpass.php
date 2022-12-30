<?php
ob_start();
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <!--        <base href="./" />-->

    <title>iMacPlus</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">

    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">


    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->


    <link rel="stylesheet" type="text/css" href="node_modules/tiny-date-picker/tiny-date-picker.css">
    <link rel="stylesheet" type="text/css" href="node_modules/tiny-date-picker/date-range-picker.css">

    <link rel="stylesheet" type="text/css"
          href="node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css">

    <!-- include vendor stylesheets used in "Wizard & Validation" page. see "/views//pages/partials/form-wizard/@vendor-stylesheets.hbs" -->
    <link rel="stylesheet" type="text/css" href="node_modules/smartwizard/dist/css/smart_wizard.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/smartwizard/dist/css/smart_wizard_theme_circles.min.css">

    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">


    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="uploads/icon/imaclogonew.ico"/>

    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/dashboard/@page-style.css">
    <link rel="stylesheet" type="text/css" href="views/pages/page-profile/@page-style.css">


    <style>
        @font-face {
            font-family: 'SukhumvitSet-Medium';
            src: url('dist/font/SukhumvitSet-Medium.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'SukhumvitSet-Bold';
            src: url('dist/font/SukhumvitSet-Bold.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "SukhumvitSet-Medium";
            font-size: 16px;
        }

        @media print {
            body {
                font-size: 10pt;
                font-family: "SukhumvitSet-Medium";
            }
        }

        @media screen {
            body {
                font-size: 13px;
                font-family: "SukhumvitSet-Medium";
            }
        }

        @media screen, print {
            body {
                line-height: 1.2;
                font-family: "SukhumvitSet-Medium";
            }
        }
    </style>
</head>

<body>
<div class="body-container">

    <div class="main-container bgc-white">


        <div role="main" class="main-content">

            <!--            <div class="page-content container container-plus">-->
            <div class="page-content">
                <!-- page header and toolbox -->

                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4" style="text-align: center;">
                        <img src="uploads/logo/imaclogonew.png" style="width: 25%" alt="">
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4" style="text-align: center;">
                        <h5>ลืมรหัสผ่าน ?</h5>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <br />
                <form action="#" method="post" id="form-forgot">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4" style="text-align: left;">
                            <h6>กรอกหมายเลขโทรศัพท์เพื่อรับรหัสยืนยันการเข้าใช้งาน</h6>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control number-forgot" name="number_forgot" value=""
                                   placeholder="หมายเลขโทรศัพท์" required>
                            <div style="height: 5px;"></div>
                            <span class="error-number-forgot" style="color: red;"></span>
                        </div>
                        <div class="col-lg-4">
                            <div class="btn btn-primary" onclick="submitmyform()">รับรหัสยืนยัน</div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-4"></div>
                    </div>

                </form>
                <br />
                <div class="row" id="forgot-verify" style="display: none;">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4" style="text-align: left;">
                                <h6>รหัสยืนยันที่ได้รับ</h6>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <table style="border: none;">
                                    <tr>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="1" maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="2" maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="3" maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="4" maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="5" maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                        <td style="padding: 5px;">
                                            <input type="text" class="form-control pin-input" data-var="6"  maxlength="1" style="text-align: center"
                                                   value="" onkeyup="findNext($(this))">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <div class="btn btn-success" onclick="submitfinal()">ตกลง</div>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
                <footer class="footer d-none d-sm-block">
                    <div class="footer-inner bgc-white-tp1">
                        <div class="pt-3 border-none border-t-3 brc-grey-l2">
                            <span class="text-secondary-m1 font-bolder text-120">iMac Plus</span>
                            <span class="text-grey">Application &copy; <?= date('Y') ?></span>

                            <span class="mx-3 action-buttons">
<!--                      <a href="#" class="text-blue-m2 text-150"><i class="fab fa-twitter-square"></i></a>-->
                      <a href="#" class="text-blue-d2 text-150"><i class="fab fa-facebook"></i></a>
                                <!--                      <a href="#" class="text-orange-d1 text-150"><i class="fa fa-rss-square"></i></a>-->
                   </span>
                        </div>
                    </div><!-- .footer-inner -->

                    <!-- `scroll to top` button inside footer (for example when in boxed layout) -->
                    <div class="footer-tools">
                        <a href="#" class="btn-scroll-up btn btn-dark mb-2 mr-2">
                            <i class="fa fa-angle-double-up mx-2px text-95"></i>
                        </a>
                    </div>
                </footer>


                <!-- footer toolbox for mobile view -->

            </div>


        </div>
        <div style="height: 100px;"></div>
        <footer class="d-sm-none footer footer-sm footer-fixed">
            <div class="footer-inner">
                <div class="btn-group d-flex h-100 mx-2 border-x-1 border-t-2 brc-primary-m3 bgc-white-tp1 radius-t-1 shadow">
                    <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0"
                            data-toggle="modal" data-target="#id-ace-settings-modal">
                        <i class="fas fa-sliders-h text-blue-m1 text-120"></i>
                    </button>

                    <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                        <i class="fa fa-plus-circle text-green-m1 text-120"></i>
                    </button>

                    <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0"
                            data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch"
                            aria-expanded="false" aria-label="Toggle navbar search">
                        <i class="fa fa-search text-orange text-120"></i>
                    </button>

                    <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 mr-0">
                  <span class="pos-rel">
                      <i class="fa fa-bell text-purple-m1 text-120"></i>
                      <span class="badge badge-dot bgc-red position-tr mt-n1 mr-n2px"></span>
                  </span>
                    </button>
                </div>
            </div>
        </footer>
    </div>

    <!-- include common vendor scripts used in demo pages -->
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

    <script src="./node_modules/tiny-date-picker/dist/date-range-picker.js"></script>
    <script src="./node_modules/moment/moment.js"></script>
    <script src="./node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

    <!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->
    <!--<script src="node_modules/chart.js/dist/Chart.js"></script>-->


    <script src="node_modules/sortablejs/dist/sortable.umd.js"></script>


    <!-- include ace.js -->
    <script src="dist/js/ace.js"></script>


    <!-- demo.js is only for Ace's demo and you shouldn't use it -->
    <script src="app/browser/demo.js"></script>

    <script src="node_modules/datatables/media/js/jquery.dataTables.js"></script>
    <script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
    <script src="node_modules/datatables.net-select/js/dataTables.select.js"></script>


    <!--alert-->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="node_modules/interactjs/dist/interact.js"></script>

    <!-- include vendor scripts used in "Wizard & Validation" page. see "/views//pages/partials/form-wizard/@vendor-scripts.hbs" -->
    <script src="node_modules/smartwizard/dist/js/jquery.smartWizard.js"></script>


    <script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>

    <script src="node_modules/inputmask/dist/jquery.inputmask.js"></script>


    <!-- Cookie Consent by https://www.cookiewow.com -->
    <script type="text/javascript" src="https://cookiecdn.com/cwc.js"></script>
    <script id="cookieWow" type="text/javascript" src="https://cookiecdn.com/configs/Jym9Mew5dSqHUru8AVmSbTHX"
            data-cwcid="Jym9Mew5dSqHUru8AVmSbTHX"></script>

    <!-- "Dashboard" page script to enable its demo functionality -->
    <!--<script src="views/pages/dashboard/@page-script.js"></script>-->
    <script src="views/pages/page-profile/@page-script.js"></script>
    <script src="views/pages/form-wizard/@page-script.js"></script>
</body>

</html>
<script>
    function findNext(e){

        var tag = e.attr("data-var");
        var new_tag = parseInt(tag) +1;

        e.closest("tr").find(".pin-input").each(function(){
            var x = $(this).attr("data-var");
            if(parseInt(x) == new_tag){
                //alert();
                $(this).focus();
            }
        });

    }
    function submitmyform() {
        var otp_number = $(".number-forgot").val();
        if(otp_number == ''){
            $(".error-number-forgot").html('กรุณากรอกข้อมูลเบอร์โทรศัพท์').show();
            $(".number-forgot").focus();
            return false;
        }else{
            $(".error-number-forgot").hide();
        }
        //  if (!$('#validation-form').valid()) return false;
        var verify_code = '123456';// $(".verify-code").val();
        //var otp_number = $(".phone-regis").val().replace('-','');

        // alert(otp_number);return;
        if (verify_code != '' && verify_code.length == 6 && otp_number != '') {
            // $.ajax({
            //     type: "post",
            //     dataType: "json",
            //     url: "models/smsforgot.php",
            //     async: false,
            //     data: {'otp_number': otp_number, 'verify_code': verify_code},
            //     success: function (data) {
            //         //alert(data[0]['success']);
            //         // if(data.length > 0){
            //         //$("#myModalVerify").modal("show");
            //        // verifycountdown();
            //         // }
            //     },
            //     error: function (err) {
            //         console.log(err);
            //     }
            // });

            // $("#forgot-verify").show();
            // $("#form-forgot").submit(false);
        }

        $("div#forgot-verify").show();
        $("form#form-forgot").submit(false);
        // document.getElementById('validation-form').submit();
    }
    function submitfinal(){

    }
</script>
