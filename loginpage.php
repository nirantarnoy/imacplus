<?php
ob_start();
session_start();

$mes_error = '';
if (isset($_SESSION['msg_err'])) {
    $mes_error = $_SESSION['msg_err'];
    unset($_SESSION['msg_err']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <!--    <base href="../" />-->

    <title>Login - Ace Admin</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">


    <!-- include vendor stylesheets used in "Login" page. see "/views//pages/partials/page-login/@vendor-stylesheets.hbs" -->


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">


    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="assets/favicon.png"/>

    <!-- "Login" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/page-login/@page-style.css">
</head>

<body>
<div class="body-container">

    <div class="main-container container bgc-transparent">

        <div class="main-content minh-100 justify-content-center">
            <div class="p-2 p-md-4">
                <div class="row" id="row-1">
                    <div class="col-12 col-xl-10 offset-xl-1 bgc-white shadow radius-1 overflow-hidden">

                        <div class="row" id="row-2">

                            <div id="id-col-intro" class="col-lg-5 d-none d-lg-flex border-r-1 brc-default-l3 px-0">
                                <!-- the left side section is carousel in this demo, to show some example variations -->

                                <div id="loginBgCarousel" class="carousel slide minw-100 h-100">
                                    <ol class="d-none carousel-indicators">
                                        <li data-target="#loginBgCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#loginBgCarousel" data-slide-to="1"></li>
                                        <li data-target="#loginBgCarousel" data-slide-to="2"></li>
                                        <li data-target="#loginBgCarousel" data-slide-to="3"></li>
                                    </ol>

                                    <div class="carousel-inner minw-100 h-100">
                                        <div class="carousel-item active minw-100 h-100">
                                            <!-- default carousel section that you see when you open login page -->
                                            <div style="background-image: url(assets/image/login-bg-1.svg);"
                                                 class="px-3 bgc-blue-l4 d-flex flex-column align-items-center justify-content-center">
                                                <a class="mt-5 mb-2" href="loginpage.php">
                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>
                                                </a>

                                                <h2 class="text-primary-d1">
                                                    iMac Plus <span class="text-80 text-dark-l1"></span>
                                                </h2>

                                                <div class="mt-5 mx-4 text-dark-tp3">
                                                    <!--                              <span class="text-120">-->
                                                    <!--                           Join our community to make friends,<br /> meet experts &amp; receive exclusive offers!-->
                                                    <!--                       </span>-->
                                                    <hr class="mb-1 brc-black-tp10"/>
                                                    <div>
                                                        <!--                                                        <a id="id-start-carousel" href="#" class="text-95 text-dark-l2 d-inline-block mt-3">-->
                                                        <!--                                                            <i class="far fa-image text-110 text-purple-m1 mr-1 w-2"></i>-->
                                                        <!--                                                            Change background image-->
                                                        <!--                                                        </a>-->
                                                        <!--                                                        <br />-->
                                                        <a id="id-remove-carousel" href="#"
                                                           class="text-md text-dark-l2 d-inline-block mt-3">
                                                            <i class="far fa-trash-alt text-110 text-orange-d1 mr-1 w-2"></i>
                                                            Remove this section
                                                        </a>
                                                        <br/>
                                                        <a id="id-fullscreen" href="#"
                                                           class="text-md text-dark-l2 d-inline-block mt-3">
                                                            <i class="fa fa-expand text-110 text-green-m1 mr-1 w-2"></i>
                                                            Make full-size
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="mt-auto mb-4 text-dark-tp2">
                                                    iMac Plus &copy; <?= date('Y') ?>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="carousel-item minw-100 h-100">
                                            <!-- the second carousel item with dark background -->
                                            <div style="background-image: url(assets/image/login-bg-2.svg);"
                                                 class="d-flex flex-column align-items-center justify-content-start">
                                                <a class="mt-5 mb-2" href="html/dashboard.html">
                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>
                                                </a>

                                                <h2 class="text-blue-l1">
                                                    iMac Plus <span class="text-80 text-dark-l1"></span>
                                                </h2>
                                            </div>
                                        </div>


                                        <div class="carousel-item minw-100 h-100">
                                            <div style="background-image: url(assets/image/login-bg-3.jpg);"
                                                 class="d-flex flex-column align-items-center justify-content-start">
                                                <div class="bgc-black-tp4 radius-1 p-3 w-90 text-center my-3 h-100">
                                                    <a class="mt-5 mb-2" href="html/dashboard.html">
                                                        <i class="fa fa-backward text-secondary-m2 fa-3x"></i>
                                                    </a>

                                                    <h2 class="text-blue-l1">
                                                        iMac Plus <span class="text-80 text-dark-l1"></span>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="carousel-item minw-100 h-100">
                                            <div style="background-image: url(assets/image/login-bg-4.jpg);"
                                                 class="d-flex flex-column align-items-center justify-content-start">
                                                <a class="mt-5 mb-2" href="html/dashboard.html">
                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>
                                                </a>

                                                <h2 class="text-blue-d1">
                                                    iMac Plus <span class="text-80 text-dark-l1"></span>
                                                </h2>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div id="id-col-main" class="col-12 col-lg-7 py-lg-5 bgc-white px-0">
                                <!-- you can also use these tab links -->
                                <ul class="d-none mt-n4 mb-4 nav nav-tabs nav-tabs-simple justify-content-end bgc-black-tp11"
                                    role="tablist">
                                    <li class="nav-item mx-2">
                                        <a class="nav-link active px-2" data-toggle="tab" href="#id-tab-login"
                                           role="tab" aria-controls="id-tab-login" aria-selected="true">
                                            ลงชื่อเข้าใช้งาน
                                        </a>
                                    </li>
                                    <li class="nav-item mx-2">
                                        <a class="nav-link px-2" data-toggle="tab" href="#id-tab-signup" role="tab"
                                           aria-controls="id-tab-signup" aria-selected="false">
                                            สมัครสมาชิก
                                        </a>
                                    </li>
                                </ul>


                                <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                                    <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">
                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                                                <i class="fa fa-coffee text-orange-m1 mr-1"></i>
                                                Welcome Back
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <a href="html/dashboard.html">
                                                <i class="fa fa-backward text-secondary-m2 text-200 mb-4"></i>
                                            </a>
                                            <h1 class="text-170">
                            <span class="text-blue-d1">
                                iMac <span class="text-80 text-dark-tp3">Plus</span>
                            </span>
                                            </h1>

                                            Welcome back
                                        </div>

                                        <input type="hidden" class="message" value="<?= $mes_error ?>">
                                        <div class="alert alert-danger alert-msg"
                                             style="display: none;text-align: center;"><?= $mes_error ?></div>
                                        <form id="form-login" autocomplete="off" class="form-row mt-4" method="post"
                                              action="login_action.php">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input type="text"
                                                           class="form-control form-control-lg pr-4 shadow-none username"
                                                           id="id-login-username" name="username" value=""/>
                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3"
                                                           for="id-login-username">
                                                        Username
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input type="password"
                                                           class="form-control form-control-lg pr-4 shadow-none password"
                                                           id="id-login-password" name="password"/>
                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3"
                                                           for="id-login-password">
                                                        Password
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-right text-md-right mt-n2 mb-2">
                                                <a href="#" class="text-primary-m1 text-95" data-toggle="tab"
                                                   data-target="#id-tab-forgot">
                                                    Forgot Password?
                                                </a>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <label class="d-inline-block mt-3 mb-0 text-dark-l1">
                                                    <input type="checkbox" class="mr-1" id="id-remember-me"
                                                           name="rememberme" value=""/>
                                                    Remember me
                                                </label>

                                                <button type="button"
                                                        class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4 btn-submit">
                                                    Sign In
                                                </button>
                                                <!--                                                <input type="submit" value="Sign In" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4 btn-submit">-->
                                            </div>
                                        </form>


                                        <div class="form-row">
                                            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100"/>

                                                <div class="p-0 px-md-2 text-dark-tp3 my-3">
                                                    ยังไม่เป็นสมาชิกกับทางเราหรือเปล่า?
                                                    <a class="text-success-m1 text-600 mx-1" data-toggle="tab"
                                                       data-target="#id-tab-signup" href="#">
                                                        สมัครตอนนี้
                                                    </a>
                                                </div>

                                                <hr class="brc-default-l2 w-100 mb-2"/>
                                                <div class="mt-n4 bgc-white-tp2 px-3 py-1 text-secondary-d3 text-90">
                                                    หรือเข้าใช้งานผ่าน
                                                </div>

                                                <div class="my-2">
                                                    <button type="button"
                                                            class="btn btn-bgc-white btn-lighter-primary btn-h-primary btn-a-primary border-2 radius-round btn-lg mx-1">
                                                        <i class="fab fa-facebook-f text-110"></i>
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-bgc-white btn-lighter-red btn-h-red btn-a-red border-2 radius-round btn-lg px-25 mx-1">
                                                        <i class="fab fa-google text-110"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-signup"
                                         data-swipe-prev="#id-tab-login">
                                        <div class="position-tl ml-3 mt-3 mt-lg-0">
                                            <a href="#"
                                               class="btn btn-light-default btn-h-light-default btn-a-light-default btn-bgc-tp"
                                               data-toggle="tab" data-target="#id-tab-login">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        </div>

                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-grey-l1 pb-1 text-130">
                                                <i class="fa fa-user text-purple mr-1"></i>
                                                Create an Account
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <i class="fa fa-backward text-secondary-m2 text-200 mb-4"></i>
                                            <h1 class="text-170">
                                                <span class="text-blue-d1">iMac <span
                                                            class="text-80 text-dark-tp4">Plus</span></span>
                                            </h1>

                                            Create an Account
                                        </div>
                                        <input type="hidden" class="message2" value="<?= $mes_error ?>">
                                        <div class="alert alert-danger alert-msg2"
                                             style="display: none;text-align: center;"><?= $mes_error ?></div>

                                        <form id="form-register" autocomplete="off" class="form-row mt-4"
                                              action="register_action.php" method="post">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text"
                                                           class="form-control form-control-lg pr-4 shadow-none phone-regis"
                                                           id="id-signup-email" name="phone" value=""/>
                                                    <i class="fa fa-mobile text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-email">
                                                        เบอร์โทร
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="email"
                                                           class="form-control form-control-lg pr-4 shadow-none email-regis"
                                                           id="id-signup-email" name="email" value=""/>
                                                    <i class="fa fa-envelope text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-email">
                                                        อีเมล์
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text"
                                                           class="form-control form-control-lg pr-4 shadow-none username-regis"
                                                           id="id-signup-username" name="username" value=""/>
                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-username">
                                                        Username
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="password"
                                                           class="form-control form-control-lg pr-4 shadow-none password-regis"
                                                           id="id-signup-password" name="password" value=""/>
                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-password">
                                                        Password
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="password"
                                                           class="form-control form-control-lg pr-4 shadow-none confirm-password"
                                                           id="id-signup-password2" name="confirmpassword" value=""/>
                                                    <i class="fas fa-sync-alt text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-password2">
                                                        Confirm Password
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2">
                                                <label class="d-inline-block mt-3 mb-0 text-secondary-d2">
                                                    <input type="checkbox" class="mr-1" id="id-agree"/>
                                                    <span class="text-dark-m3">ฉันอ่านและยอมรับ <a href="#"
                                                                                                   class="text-blue-d2">ข้อตกลงการใช้งาน</a></span>
                                                </label>

                                                <button type="button"
                                                        class="btn btn-success btn-block px-4 btn-bold mt-2 mb-3 btn-register-submit">
                                                    สมัครสมาชิก
                                                </button>
                                                <!--                                                <input type="submit" class="btn btn-success btn-block px-4 btn-bold mt-2 mb-3" value="สมัครสมาชิก">-->
                                            </div>
                                        </form>


                                        <div class="form-row w-100">
                                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100"/>

                                                <div class="p-0 px-md-2 text-dark-tp4 my-3">
                                                    คุณเป็นสมาชิกหรือเปล่า?
                                                    <a class="text-blue-d1 text-600 mx-1" data-toggle="tab"
                                                       data-target="#id-tab-login" href="#">
                                                        เข้าระบบที่นี่
                                                    </a>
                                                </div>

                                                <hr class="brc-default-l2 w-100 mb-2"/>
                                                <div class="mt-n4 bgc-white-tp2 px-3 py-1 text-secondary-d3 text-90">
                                                    หรือลงทะเบียนสมาชิกผ่าน
                                                </div>

                                                <div class="mt-2 mb-3">
                                                    <button type="button"
                                                            class="btn btn-primary border-2 radius-round btn-lg mx-1">
                                                        <i class="fab fa-facebook-f text-110"></i>
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-danger border-2 radius-round btn-lg px-25 mx-1">
                                                        <i class="fab fa-google text-110"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-forgot"
                                         data-swipe-prev="#id-tab-login">
                                        <div class="position-tl ml-3 mt-2">
                                            <a href="#"
                                               class="btn btn-light-default btn-h-light-default btn-a-light-default btn-bgc-tp"
                                               data-toggle="tab" data-target="#id-tab-login">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        </div>


                                        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-5 px-0">
                                            <h4 class="pt-4 pt-md-0 text-dark-tp4 border-b-1 brc-grey-l2 pb-1 text-130">
                                                <i class="fa fa-key text-brown-m1 mr-1"></i>
                                                Recover Password
                                            </h4>
                                        </div>


                                        <form autocomplete="off" class="form-row mt-4">
                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <label class="text-secondary-d3 mb-3">
                                                    Enter your email address and we'll send you the instructions:
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <input type="email"
                                                           class="form-control form-control-lg pr-4 shadow-none"
                                                           id="id-recover-email" placeholder="Email"/>
                                                    <i class="fa fa-envelope text-grey-m2 ml-n4"></i>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">
                                                <button type="button"
                                                        class="btn btn-orange btn-block px-4 btn-bold mt-2 mb-4">
                                                    Continue
                                                </button>
                                            </div>
                                        </form>


                                        <div class="form-row w-100">
                                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100"/>

                                                <div class="p-0 px-md-2 text-dark-tp4 my-3">
                                                    <a class="text-blue-d1 text-600 btn-text-slide-x" data-toggle="tab"
                                                       data-target="#id-tab-login" href="#">
                                                        <i class="btn-text-2 fa fa-arrow-left text-110 align-text-bottom mr-2"></i>Back
                                                        to Login
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div><!-- .tab-content -->
                            </div>

                        </div><!-- /.row -->

                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="d-lg-none my-3 text-white-tp1 text-center">
                    <i class="fa fa-backward text-secondary-l3 mr-1 text-110"></i> iMac Plus &copy; <?= date('Y') ?>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>


<!-- include vendor scripts used in "Login" page. see "/views//pages/partials/page-login/@vendor-scripts.hbs" -->


<!-- include ace.js -->
<script src="dist/js/ace.js"></script>


<!-- demo.js is only for Ace's demo and you shouldn't use it -->
<script src="app/browser/demo.js"></script>


<!-- "Login" page script to enable its demo functionality -->
<script src="views/pages/page-login/@page-script.js"></script>

<script>
    $(function () {
        err_message();
        $(".btn-submit").click(function (e) {

            e.preventDefault();
            var username = $(".username").val();
            var pwd = $(".password").val();

            if (username == '') {
                $(".message").val("กรุณากรอกข้อมูล Username");
                $(".username").focus();
                err_message();
                return false;
            }
            if (pwd == '') {
                $(".message").val("กรุณากรอกข้อมูล Password");
                $(".password").focus();
                err_message();
                return false;
            }
            $("form#form-login").submit();
        });

        $(".btn-register-submit").click(function (e) {

            e.preventDefault();
            var username = $(".username-regis").val();
            var pwd = $(".password-regis").val();
            var confirm_pwd = $(".confirm-password").val();
            var phone = $(".phone-regis").val();
            var email = $(".email-regis").val();

            if (phone == '') {
                $(".message2").val("กรุณากรอกข้อมูล Phone");
                $(".phone-regis").focus();
                err_message2();
                return false;
            }
            if (email == '') {
                $(".message2").val("กรุณากรอกข้อมูล Email");
                $(".email-regis").focus();
                err_message2();
                return false;
            }
            if (username == '') {

                $(".message2").val("กรุณากรอกข้อมูล Username");
                $(".username-regist").focus();
                err_message2();
                return false;
            }
            if (pwd == '') {
                $(".message2").val("กรุณากรอกข้อมูล Password");
                $(".password-regis").focus();
                err_message2();
                return false;
            }
            if (confirm_pwd == '') {
                $(".message2").val("กรุณากรอกข้อมูล Confirm Password");
                $(".confirm-password").focus();
                err_message2();
                return false;
            }

            $("form#form-register").submit();
        });

        function err_message() {
            var e_msg = $(".message").val();
            if (e_msg != '') {
                $(".alert-msg").html(e_msg).show();
            } else {
                $(".alert-msg").hide();
            }

        }
        function err_message2() {
            var e_msg = $(".message2").val();
            if (e_msg != '') {
                $(".alert-msg2").html(e_msg).show();
            } else {
                $(".alert-msg2").hide();
            }

        }


    });
</script>
</body>

</html>