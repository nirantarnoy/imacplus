<?php
ob_start();
if (!session_id()) {
    session_start();
}

if (isset($_SESSION['userid'])) {
    header("location:profile.php");
}

require_once __DIR__ . '/vendor/php-graph-sdk-5.x/src/Facebook/autoload.php';

include("common/dbcon.php");
include("models/MemberModel.php");

$mes_error = '';
if (isset($_SESSION['msg_err'])) {
    $mes_error = $_SESSION['msg_err'];
    unset($_SESSION['msg_err']);
}
$mes_register_error = '';
if (isset($_SESSION['msg_register_err'])) {
    if($_SESSION['msg_register_err'] != '' || $_SESSION['msg_register_err'] != null){
        $mes_register_error = $_SESSION['msg_register_err'];
        unset($_SESSION['msg_register_err']);
    }

}

//echo "has error". $mes_register_error;

$member_ref_id = null;
if (isset($_GET['ref'])) {
////    $xdata = explode('=',$_GET['ref']);
////    if(count($xdata)>0){
////        $member_ref_id = $xdata[1];
////    }
//    echo $_GET['ref'];return;
    $member_ref_id = $_GET['ref'];
}


$parent_member_id = findParentForRegister($connect, $member_ref_id);
$_SESSION['parent_member_id'] = $parent_member_id;
//echo $member_ref_id;return;

$fb = new \Facebook\Facebook([
    'app_id' => '5164069763715357', //828260794001696
    'app_secret' => '0d7b1e93385cd8f48a98385217983bf2', //5dd3b30d1b7da7738bf8f6f38a440da2
    'default_graph_version' => 'v2.10',
    'persistent_data_handler' => 'session',
    'default_access_token' => 'EABJYsaZCckR0BAFR1unZBz3JXeTHL24XV4ds6iJyqzs36RChA9S0KMkr5IsYk6Pm1ScNHDU4W3ZBueYn9oFGwMmEdvkisvkiPu80pPl2GmkAzxKJzMXubo4jXqIaIZAP9j4caQnKtm7afbhEw4OoBGdjwmF8tncy1XHbZBDASDZBCsVcrCP3KVcbHDMV0ZAnqbhi6Chh3TQG8YaeUr3MCYf', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();
$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('https://www.imacplus.app/login-callback.php', $permissions);
$registerUrl = $helper->getLoginUrl('https://www.imacplus.app/register-callback.php', $permissions);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <!--    <base href="../" />-->

    <title>Login - iMac Plus</title>

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
    <!--    <link rel="icon" type="image/png" href="assets/favicon.png"/>-->
    <link rel="icon" type="image/png" href="uploads/icon/imaclogonew.ico"/>
    <!-- "Login" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/page-login/@page-style.css">

    <style>
        /*@font-face {*/
        /*    font-family: 'SukhumvitSet-Light';*/
        /*    src: url('dist/font/SukhumvitSet-Light.ttf') format('truetype');*/
        /*    font-weight: normal;*/
        /*    font-style: normal;*/
        /*}*/

        /*@font-face {*/
        /*    font-family: 'SukhumvitSet-Bold';*/
        /*    src: url('dist/font/SukhumvitSet-Bold.ttf') format('truetype');*/
        /*    font-weight: normal;*/
        /*    font-style: normal;*/
        /*}*/
        @font-face {
            font-family: 'THSarabunNew';
            src: url('dist/font/THSarabunNew/THSarabunNew.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Prompt-Regular';
            src: url('dist/font/Prompt/Prompt-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Prompt-Italic';
            src: url('dist/font/Prompt/Prompt-Italic.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            /*font-family: "SukhumvitSet-Medium";*/
            font-family: "Prompt-Regular";
            font-size: 14px;
        }

        .dot {
            margin: 5px;
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-login {
            margin: 5px;
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-button {
            margin: 10px;
            height: 75px;
            width: 75px;
            background-color: dimgrey;
            border-radius: 50%;
            text-align: center;
            display: inline-block;
            line-height: 75px;
            color: #ffffff;
        }

        .dot-active {
            margin: 5px;
            height: 25px;
            width: 25px;
            background-color: #0e0f10;
            border-radius: 50%;
            display: inline-block;
        }

        /*.dot-button {*/
        /*    width: 100px;*/
        /*    height: 100px;*/
        /*    !*line-height: 100px;*!*/
        /*    border-radius: 50%;*/
        /*    font-size: 20px;*/
        /*    color: #fff;*/
        /*    text-align: center;*/
        /*    background: #000*/
        /*}*/
    </style>
</head>

<body>
<div class="body-container" style="background-color: white;">

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
                                                <a class="mt-5 mb-2" href="loginpage.php" style="text-align: center;">
                                                    <!--                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>-->
                                                    <img src="uploads/logo/imaclogonew.png" style="width: 25%" alt="">
                                                </a>

                                                <h2 class="text-secondary-d1">
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
                                                <a class="mt-5 mb-2" href="#">
                                                    <!--                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>-->
                                                    <img src="uploads/logo/imaclogonew.png" style="width: 25%" alt="">
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
                                                    <a class="mt-5 mb-2" href="#">
                                                        <!--                                                        <i class="fa fa-backward text-secondary-m2 fa-3x"></i>-->
                                                        <img src="uploads/logo/imaclogonew.png" style="width: 25%"
                                                             alt="">
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
                                                <a class="mt-5 mb-2" href="#">
                                                    <!--                                                    <i class="fa fa-backward text-secondary-m2 fa-3x"></i>-->
                                                    <img src="uploads/logo/imaclogonew.png" style="width: 25%" alt="">
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
                                                <!--                                                <i class="fa fa-coffee text-orange-m1 mr-1"></i>-->
                                                ลงชื่อเข้าใช้งานระบบ
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <a href="#">
                                                <!--                                                <i class="fa fa-backward text-secondary-m2 text-200 mb-4"></i>-->
                                                <img src="uploads/logo/imaclogonew.png" style="width: 25%" alt="">
                                            </a>
                                            <h1 class="text-170">
                            <span class="text-secondary-d1">
                                iMac <span class="text-80 text-dark-tp3">Plus</span>
                            </span>
                                            </h1>

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
                                            <input type="hidden" class="password" name="password" value="">


<!--                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">-->
<!--                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">-->
<!--                                                    <input type="password"-->
<!--                                                           class="form-control form-control-lg pr-4 shadow-none password"-->
<!--                                                           id="id-login-password" name="password"/>-->
<!--                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>-->
<!--                                                    <label class="floating-label text-grey-l1 ml-n3"-->
<!--                                                           for="id-login-password">-->
<!--                                                        Password-->
<!--                                                    </label>-->
<!--                                                </div>-->
<!--                                            </div>-->


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
                                                        class="btn btn-dark btn-block px-4 btn-bold mt-2 mb-4 btn-submit">
                                                    Sign In
                                                </button>
                                                <!--                                                <input type="submit" value="Sign In" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4 btn-submit">-->
                                            </div>
                                        </form>


                                        <div class="form-row">
                                            <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">

                                                <hr class="brc-default-l2 mt-0 mb-2 w-100"/>

                                                <div class="p-0 px-md-2 text-dark-tp3 my-3">
                                                    ยังไม่เป็นสมาชิกหรือเปล่า?
                                                    <a class="text-success-m1 text-600 mx-1 btn-to-register"
                                                       data-toggle="tab"
                                                       data-target="#id-tab-signup" href="#">
                                                        สมัครตอนนี้
                                                    </a>
                                                </div>

                                                <hr class="brc-default-l2 w-100 mb-2"/>
                                                <div class="mt-n4 bgc-white-tp2 px-3 py-1 text-secondary-d3 text-90">
                                                    หรือเข้าใช้งานผ่าน
                                                </div>

                                                <div class="my-2">
                                                    <a href="<?= $loginUrl ?>"
                                                       class="btn btn-bgc-white btn-lighter-primary btn-h-primary btn-a-primary border-2 radius-round btn-lg mx-1">
                                                        <i class="fab fa-facebook-f text-110"></i>
                                                    </a>


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

                                        <!-- show this in mobile device -->
                                        <form id="form-register" autocomplete="off" class="form-row mt-4"
                                              action="register_action.php" method="post">
                                            <input type="hidden" class="pin-pass" name="pin_pass" value="">
                                            <input type="hidden" class="member-ref-id" name="member_ref_id"
                                                   value="<?= $parent_member_id ?>">
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
                                                             src="uploads/member_photo/<?= $member_data[0]['photo'] == ''?'demo.png':$member_data[0]['photo'] ?>"
                                                             alt="Member 's photo">

                                                    <?php else: ?>
                                                        <i class="fa fa-user-circle fa-5x text-info"></i>
                                                    <?php endif; ?>
                                                    <p><b><?= $member_data[0]['name'].' '.$member_data[0]['lname'] ?></b></p>
                                                </div>
                                                <br>
                                            <?php endif; ?>
                                            <!-- show this in desktop -->

                                            <div class="d-none d-lg-block col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-lg-4 px-0">
                                                <h4 class="text-dark-tp4 border-b-1 brc-grey-l1 pb-1 text-130">
                                                    <!--                                                <i class="fa fa-user text-purple mr-1"></i>-->
                                                    สมัครสมาชิก
                                                </h4>
                                            </div>

                                            <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                                <!--                                                <i class="fa fa-backward text-secondary-m2 text-200 mb-4"></i>-->
                                                <h1 class="text-170">
                                                <span class="text-blue-d1">iMac <span
                                                            class="text-80 text-dark-tp4">Plus</span></span>
                                                </h1>

                                                สมัครสมาชิก
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <input type="hidden" class="message2"
                                                       value="<?= $mes_register_error ?>">
                                                <div class="alert alert-danger alert-msg2"
                                                     style="display: none;text-align: center;"><?= $mes_register_error ?></div>

                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="text"
                                                           class="form-control form-control-lg pr-4 shadow-none phone-regis"
                                                           id="id-signup-phone" name="phone" value=""/>
                                                    <i class="fa fa-mobile text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-phone">
                                                        เบอร์โทร
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">
                                                    <input type="email"
                                                           class="form-control form-control-lg pr-4 shadow-none email-regis"
                                                           id="id-signup-email" name="email" value=""
                                                           pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}"/>
                                                    <i class="fa fa-envelope text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"
                                                           for="id-signup-email">
                                                        อีเมล์
                                                    </label>
                                                </div>
                                            </div>


                                            <!--                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">-->
                                            <!--                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">-->
                                            <!--                                                    <input type="text"-->
                                            <!--                                                           class="form-control form-control-lg pr-4 shadow-none username-regis"-->
                                            <!--                                                           id="id-signup-username" name="username" value=""/>-->
                                            <!--                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>-->
                                            <!--                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"-->
                                            <!--                                                           for="id-signup-username">-->
                                            <!--                                                        Username-->
                                            <!--                                                    </label>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <!---->
                                            <!---->
                                            <!--                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">-->
                                            <!--                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">-->
                                            <!--                                                    <input type="password"-->
                                            <!--                                                           class="form-control form-control-lg pr-4 shadow-none password-regis"-->
                                            <!--                                                           id="id-signup-password" name="password" value=""/>-->
                                            <!--                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>-->
                                            <!--                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"-->
                                            <!--                                                           for="id-signup-password">-->
                                            <!--                                                        Password-->
                                            <!--                                                    </label>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <!---->
                                            <!---->
                                            <!--                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-1">-->
                                            <!--                                                <div class="d-flex align-items-center input-floating-label text-success brc-success-m2">-->
                                            <!--                                                    <input type="password"-->
                                            <!--                                                           class="form-control form-control-lg pr-4 shadow-none confirm-password"-->
                                            <!--                                                           id="id-signup-password2" name="confirmpassword" value=""/>-->
                                            <!--                                                    <i class="fas fa-sync-alt text-grey-m2 ml-n4"></i>-->
                                            <!--                                                    <label class="floating-label text-grey-l1 text-100 ml-n3"-->
                                            <!--                                                           for="id-signup-password2">-->
                                            <!--                                                        Confirm Password-->
                                            <!--                                                    </label>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2">
                                                <label class="d-inline-block mt-3 mb-0 text-secondary-d2">
                                                    <input type="checkbox" name="check_read_ok" class="mr-1"
                                                           id="id-agree" onclick="readok($(this))"/>
                                                    <span class="text-dark-m3">ฉันอ่านและยอมรับ <a href="#"
                                                                                                   class="text-blue-d2"
                                                                                                   onclick="showcondition()">ข้อตกลงการใช้งาน</a></span>
                                                </label>

                                                <label class="d-inline-block mt-3 mb-0 text-secondary-d2">
                                                    <input type="checkbox" name="check_pdpa_ok" class="mr-1"
                                                           id="id-pdpa-agree" onclick="readpdpaok($(this))"/>
                                                    <span class="text-dark-m3">ฉันอ่านและยินยอม <a href="#"
                                                                                                   class="text-blue-d2"
                                                                                                   onclick="showPdpa()">ข้อมูลส่วนบุคคล (PDPA)</a></span>
                                                </label>

                                                <button type="button"
                                                        class="btn btn-success btn-block px-4 btn-bold mt-2 mb-3 btn-register-submit"
                                                        disabled>
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
                                                    <a href="<?= $registerUrl ?>"
                                                       class="btn btn-bgc-white btn-lighter-primary btn-h-primary btn-a-primary border-2 radius-round btn-lg mx-1"
                                                       disabled>
                                                        <i class="fab fa-facebook-f text-110"></i>
                                                    </a>

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
                    iMac Plus &copy; <?= date('Y') ?>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-xl" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="item_action.php" id="form-user" method="post">
                <!-- Modal Header -->
                <!--                <div class="modal-header">-->
                <!--                    <h4 class="modal-title" style="color: #1c606a">เพิ่มข้อมูล Item</h4>-->
                <!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                </div>-->

                <!-- Modal body -->
                <div class="modal-body" style="font-family: 'THSarabunNew';font-size: 20px;color: black;">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-12" style="padding: 30px;">
                            <table style="width: 100%">
                                <tr>
                                    <td style="text-align: center;">
                                        <h3>โปรดอ่านข้อตกลงและเงื่อนไขการให้บริการ</h3><br/>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td style="text-align: left;">
                                        <p style="text-indent: 10px;">กรุณาอ่านข้อตกลงและเงื่อนไขการให้บริการ
                                            (“ข้อตกลงและเงื่อนไข”)
                                            โดยละเอียดก่อนรับบริการซ่อมหรือบริการอื่นที่เกี่ยวข้อง
                                            ข้อตกลงและเงื่อนไขฉบับนี้เป็นข้อตกลงที่มีผลผูกพันตามกฎหมายระหว่างผู้ขอรับบริการ
                                            (“ลูกค้า”) กับบริษัท ไทยออล จำกัด (“ไทยออล”) ซึ่งเป็นผู้ให้บริการแพลตฟอร์ม
                                            iMac Plus (“ไอแมค พลัส” ) รวมเรียกว่า (“ศูนย์บริการ” )
                                            การให้บริการซ่อมหรือบริการอื่นที่เกี่ยวข้องสำหรับอุปกรณ์
                                            หรือการอัพเกรดซอฟต์แวร์ที่ดำเนินการผ่าน แพลตฟอร์ม iMac Plus
                                            หรือศูนย์บริการที่ได้รับอนุญาต (รวมเรียก “บริการ”)</p>
                                    </td>
                                </tr>
                            </table>


                            1) ศูนย์บริการจะคืนเครื่องให้แก่ลูกค้าที่ลงนามในเอกสารขอรับบริการฉบับนี้ (เอกสารฯ)
                            และนำเอกสารฯ มาแสดง ณ วันขอรับเครื่องคืนเท่านั้น
                            ศูนย์บริการขอสงวนสิทธิไม่คืนเครื่องให้ในกรณีที่ลูกค้าไม่สามารถแสดงเอกสารฯ แก่ศูนย์บริการได้
                            หากเอกสารฯ
                            สูญหายลูกค้าต้องนำหลักฐานการแจ้งความต่อเจ้าหน้าที่ตำรวจพร้อมบัตรประชาชนมาแสดงเพื่อรับเครื่องคืน
                            ในกรณีมอบหมายให้ผู้อื่นมารับเครื่องแทนจะต้องมีหนังสือมอบอำนาจและสำเนาบัตรประชาชนของลูกค้าพร้อมลงนาม
                            เว้นแต่ในกรณีที่มีการใช้งานออนไลน์
                            ทางศูนย์บริการจะจัดส่งและมีการเซ็นต์รับเรียบร้อยให้ถือว่าลูกค้าได้รับเรียบร้อยแล้ว
                            <br/><br/>

                            2) ลูกค้าจะต้องชำระสินค้าและบริการทั้งหมด ภายใน 3 วัน และรับเครื่องภายใน 7 วัน
                            นับจากวันที่ศูนย์บริการได้กำหนดว่าเครื่องจะซ่อมเสร็จ
                            เว้นแต่กรณีที่ศูนย์บริการจะแจ้งกำหนดเวลาไว้เป็นอย่างอื่น
                            หากลูกค้าไม่มารับเครื่องคืนภายในกำหนดเวลาดังกล่าว ศูนย์บริการจะไม่รับผิดชอบต่อความเสียหายใด
                            ๆ และให้เครื่องหรืออุปกรณ์ตกเป็นกรรมสิทธิ์บริษัทโดยทันที <br/><br/>

                            3) ศูนย์บริการรับประกันงานซ่อมภายใน 30 วัน
                            หรือตามที่บริษัทกำหนดไว้บนผลิตภัณฑ์หรืออุปกรณ์นั้น
                            วันนับจากวันที่ลูกค้าหรือผู้รับมอบอำนาจจากลูกค้าได้รับเครื่องคืน
                            หากเครื่องขัดข้องในเวลาดังกล่าวลูกค้าสามารถนำเครื่องมาขอรับบริการโดยศูนย์บริการจะไม่คิดค่าบริการเพิ่มเติม
                            เว้นแต่หากมีการเปลี่ยนอะไหล่อื่นเพิ่มเติมที่ไม่เกี่ยวข้องกับงานซ่อมเดิม
                            ลูกค้าจะต้องชำระค่าอะไหล่ดังกล่าว <br/><br/>


                            4) ลูกค้ายอมรับเงื่อนไขเกี่ยวกับการสำรองและการลบข้อมูล ดังนี้ <br/>

                            4.1) ลูกค้ามีหน้าที่ต้องทำการโอนย้ายหรือสำรองข้อมูล ซอฟต์แวร์ โปรแกรม
                            และทำการลบข้อมูลทั้งหมดที่บันทึกอยู่ในเครื่องของลูกค้าทุกครั้งก่อนการเข้ารับบริการ
                            ศูนย์บริการจะไม่รับผิดชอบในกรณีที่ข้อมูลเสียหาย ข้อมูลถูกกู้คืน ข้อมูลถูกละเมิด
                            หรือการทำงานของเครื่องได้รับผลกระทบจากการสูญหายของข้อมูล
                            อันเนื่องมาจากการให้บริการโดยศูนย์บริการ
                            นอกจากนี้ลูกค้ารับรองว่าเครื่องของลูกค้าไม่มีข้อมูลใด ๆ ที่ไม่ชอบด้วยกฎหมาย <br/>

                            4.2) การตั้งค่าของเครื่องอาจจะกลับไปเป็นการตั้งค่าจากโรงงานหลังการให้บริการ
                            ในการให้บริการศูนย์บริการอาจจำเป็นต้องลบข้อมูลบนเครื่องของลูกค้า
                            ศูนย์บริการแนะนำให้ลูกค้าทำการโอนย้ายและสำรองข้อมูลในเครื่องของลูกค้าไว้ที่หน่วยความจำอื่นนอกตัวเครื่อง
                            รวมถึงข้อมูลที่เกี่ยวกับข้อมูลรายชื่อผู้ติดต่อ รูปภาพ ข้อความ เพลง เสียงเรียกเข้า
                            หรือแอพพลิเคชัน
                            และทำการลบข้อมูลส่วนบุคคลของลูกค้าออกจากตัวเครื่องของลูกค้าทั้งหมดก่อนเริ่มการเข้ารับบริการ
                            ในระหว่างการรับบริการข้อมูลในเครื่องของลูกค้าอาจสูญหาย เสียหาย หรือได้รับผลกระทบ
                            ในกรณีดังกล่าวศูนย์บริการจะไม่รับผิดชอบต่อความเสียหาย สูญหายใด ๆ ที่อาจเกิดขึ้นกับข้อมูล
                            ซอฟต์แวร์ โปรแกรมใด ๆ ที่บันทึกอยู่ในตัวเครื่องของลูกค้า <br/>

                            4.3)
                            ลูกค้ายินยอมให้เจ้าหน้าที่เทคนิคของศูนย์บริการตรวจสอบและเข้าถึงตัวเครื่องของท่านเพื่อวัตถุประสงค์ในการให้บริการ
                            โดยในระหว่างการให้บริการนั้นเจ้าหน้าที่เทคนิคอาจเข้าถึงข้อมูลส่วนบุคคลของลูกค้าที่เก็บไว้ในตัวเครื่องโดยบังเอิญ
                            หรือต้องเข้าตรวจสอบในบางส่วนของตัวเครื่องที่มีข้อมูลจัดเก็บอยู่เพื่อทดสอบประสิทธิภาพของการให้บริการ
                            ศูนย์บริการจะไม่ทำการเปิดเผยข้อมูลของลูกค้าที่บันทึกไว้ในตัวเครื่อง
                            ยกเว้นกรณีที่มีกฎหมายหรือกฎระเบียบที่เกี่ยวข้องกำหนด
                            หากลูกค้าไม่ประสงค์ให้ศูนย์บริการสามารถเข้าถึงข้อมูลของท่าน
                            ลูกค้าจะต้องทำการลบข้อมูลดังกล่าวหรือทำการรีเซ็ทตัวเครื่องของท่านก่อนเข้ารับบริการ
                            ทั้งนี้ในขั้นตอนการทดสอบประสิทธิภาพของการให้บริการ
                            ศูนย์บริการอาจจำเป็นต้องใช้เครื่องของท่านถ่ายภาพ
                            ซึ่งอาจส่งผลให้ภาพดังกล่าวยังคงอยู่ในเครื่องของท่านหลังการให้บริการ <br/><br/>

                            5) ศูนย์บริการจะถ่ายรูปหรือวีดีโอให้ลูกค้าเมื่อสินค้าเสร็จสิ้นแล้ว พร้อมทั้งถ่ายรูปสินค้า
                            ตอนจัดส่งสินค้าให้ลูกค้าด้วย <br/>

                            6) ก่อนการส่งซ่อมสินค้าในรูปแบบออนไลน์
                            ลูกค้าต้องถ่ายรูปตัวเครื่องของลูกค้าเพื่ออัพโหลดเข้าในระบบตามที่บริษัทกำหนด <br/>
                            7) ลูกค้าต้องชำระค่าบริการ 50% ก่อนตกลงใช้บริการหรือตามที่ศูนย์บริการกำหนดเบื้องต้น <br/>
                            เว้นแต่ว่ามีบริการใส่ส่วนอื่นเพิ่มเติมหลังจากศูนย์บริการแจ้งลูกค้าภายหลัง <br />
                            8) ความรับผิดในค่าเสียหายพื้นฐานของเราที่เกิดขึ้นกับสินค้าใด ๆ
                            นั้นจะจำกัดเพียงการสูญเสียและความเสียหายโดยตรงและรวมมูลค่าสูงสุดไม่เกิน 1,000 บาทต่อ 1
                            ใบนำส่งสินค้า
                            เว้นเสียแต่ว่ามีการระบุไว้เป็นอย่างอื่นในข้อตกลงร่วมกันเป็นลายลักษณ์อักษรระหว่างบริษัทผู้ส่งสินค้าและลูกค้า <br/>
                            9) ข้อตกลงและเงื่อนไขจะอยู่ภายใต้กฎหมายแห่งราชอาณาจักรไทยและคู่สัญญาทั้งสองฝ่ายอยู่ใต้เขตอำนาจศาลแห่งราชอาณาจักรไทยโดยไม่อาจเพิกถอนได้
                            <br/>
                            10) ค่าบริการตรวจเช็ค 150 – 500 บาท หรือตามที่บริษัทกำหนด <br/>
                            11) ลูกค้ายินยอมให้ บริษัท ไทยออล จำกัด และศูนย์บริการในเครือเก็บ รวบรวม ใช้
                            ข้อมูลของท่านที่เกี่ยวข้องกับการเข้ารับบริการเพื่อวัตถุประสงค์ที่ระบุไว้ในนโยบายความเป็นส่วนตัวของศูนย์บริการ
                            <br/>
                            <table style="width: 100%">
                                <tr>
                                    <td style="text-align: center;">
                                        ลูกค้าได้อ่านและยอมรับนโยบายความเป็นส่วนตัวของบริษัทที่ระบุไว้
                                    </td>
                                </tr>
                            </table>


                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i-->
                    <!--                                class="fa fa-save"></i> ยอมรับ-->
                    <!--                    </button>-->
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="myModalPass">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <!--                    <h4 class="modal-title" style="color: #1c606a">เพิ่มข้อมูลประเภทร้านค้า</h4>-->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" style="text-align: center">
                        <img src="uploads/logo/imaclogonew.png" style="width: 15%" alt="">
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center">
                        <h5>ใช้รหัสผ่านเพื่อเข้าสู่ระบบ</h5>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot" data-var=""></span>
                        <span class="dot" data-var=""></span>
                        <span class="dot" data-var=""></span>
                        <span class="dot" data-var=""></span>
                        <span class="dot" data-var=""></span>
                        <span class="dot" data-var=""></span>
                    </div>
                </div>

                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="1" onclick="keypin($(this))"><b>1</b></span>
                        <span class="dot-button" data-var="2" onclick="keypin($(this))"><b>2</b></span>
                        <span class="dot-button" data-var="3" onclick="keypin($(this))"><b>3</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="4" onclick="keypin($(this))"><b>4</b></span>
                        <span class="dot-button" data-var="5" onclick="keypin($(this))"><b>5</b></span>
                        <span class="dot-button" data-var="6" onclick="keypin($(this))"><b>6</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="7" onclick="keypin($(this))"><b>7</b></span>
                        <span class="dot-button" data-var="8" onclick="keypin($(this))"><b>8</b></span>
                        <span class="dot-button" data-var="9" onclick="keypin($(this))"><b>9</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="clear" onclick="keypinclear($(this))"><i
                                    class="fa fa-trash"></i></span>
                        <span class="dot-button" data-var="0" onclick="keypin($(this))"><b>0</b></span>
                        <span class="dot-button" data-var="delete" onclick="keypindelete($(this))"><i
                                    class="fa fa-arrow-left"></i></span>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="btn btn-success btn-pin-save" style="display: none" data-dismiss="modalx">ดำเนินการต่อ</div>
                <!--                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>-->
            </div>

        </div>
    </div>
</div>
<div class="modal" id="myModalPassLogin">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <!--                    <h4 class="modal-title" style="color: #1c606a">เพิ่มข้อมูลประเภทร้านค้า</h4>-->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" style="text-align: center">
                        <img src="uploads/logo/imaclogonew.png" style="width: 15%" alt="">
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center">
                        <h5>ใช้รหัสผ่านเพื่อเข้าสู่ระบบ</h5>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-login" data-var=""></span>
                        <span class="dot-login" data-var=""></span>
                        <span class="dot-login" data-var=""></span>
                        <span class="dot-login" data-var=""></span>
                        <span class="dot-login" data-var=""></span>
                        <span class="dot-login" data-var=""></span>
                    </div>
                </div>

                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="1" onclick="keypinlogin($(this))"><b>1</b></span>
                        <span class="dot-button" data-var="2" onclick="keypinlogin($(this))"><b>2</b></span>
                        <span class="dot-button" data-var="3" onclick="keypinlogin($(this))"><b>3</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="4" onclick="keypinlogin($(this))"><b>4</b></span>
                        <span class="dot-button" data-var="5" onclick="keypinlogin($(this))"><b>5</b></span>
                        <span class="dot-button" data-var="6" onclick="keypinlogin($(this))"><b>6</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="7" onclick="keypinlogin($(this))"><b>7</b></span>
                        <span class="dot-button" data-var="8" onclick="keypinlogin($(this))"><b>8</b></span>
                        <span class="dot-button" data-var="9" onclick="keypinlogin($(this))"><b>9</b></span>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center;">
                        <span class="dot-button" data-var="clear" onclick="keypinclear($(this))"><i
                                    class="fa fa-trash"></i></span>
                        <span class="dot-button" data-var="0" onclick="keypinlogin($(this))"><b>0</b></span>
                        <span class="dot-button" data-var="delete" onclick="keypindelete($(this))"><i
                                    class="fa fa-arrow-left"></i></span>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="btn btn-success btn-pin-login-save" style="display: none" data-dismiss="modalx">ดำเนินการต่อ</div>
                <!--                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>-->
            </div>

        </div>
    </div>
</div>

<div class="modal modal-xl" id="myPdpaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="item_action.php" id="form-user" method="post">
                <!-- Modal Header -->
                <!--                <div class="modal-header">-->
                <!--                    <h4 class="modal-title" style="color: #1c606a">เพิ่มข้อมูล Item</h4>-->
                <!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                </div>-->

                <!-- Modal body -->
                <div class="modal-body" style="font-family: 'THSarabunNew';font-size: 20px;color: black;">
                    <input type="hidden" name="recid" class="user-recid" value="">
                    <input type="hidden" name="action_type" class="action-type" value="create">
                    <div class="row">
                        <div class="col-lg-12" style="padding: 30px;">
                            <table style="width: 100%">
                                <tr>
                                    <td style="text-align: center;">
                                        <h3>หนังสือให้ความยินยอม</h3><br/>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td style="text-align: left;">
                                        <p style="text-indent: 10px;">ตามที่บริษัทในกลุ่มบริษัท ไทยออล จํากัด หรือเรียกอีกชื่อหนึ่ง “iMacPlus”(ไอแมคพลัส) “iMacPost” (ไอแมคโพส) ได้มุ่งมั่น พัฒนาคุณภาพสินค้าและบริการ ตลอดจนสร้างประสบการณ์ใหม่ ๆ ให้ผู้ใช้บริการ และเพื่อให้ผู้ใช้บริการ ได้ใช้บริการที่ดีที่สุดและได้รับสิทธิประโยชน์ที่หลากหลายตรงต่อตามความต้องการมากที่สุด จึงได้ขอให้ ผู้ใช้บริการให้ความยินยอมในการเก็บ รวมรวม ประมวลผล ใช้ และเปิดเผยข้อมูลส่วนบุคคล ตาม พระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (“พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล”) โดยการ ดําเนินการดังกล่าวนั้น บริษัทในกลุ่มไทยออล ได้ให้ความสําคัญต่อความเป็นส่วนตัวของผู้ใช้บริการ และ จัดเก็บข้อมูลส่วนบุคคลของผู้ใช้บริการอย่างปลอดภัยและเป็นไปตามมาตรฐานที่กฎหมายกําหนด ดังนั้น ข้าพเจ้าในฐานะผู้ใช้บริการตกลงให้ความยินยอม ดังนี้</p>
                                    </td>
                                </tr>
                            </table>


                            <p style="text-indent: 10px;">ข้าพเจ้าตกลงและให้ความยินยอมแก่บริษัทในกลุ่มไทยออล (ดังรายชื่อที่ปรากฏท้ายหนังสือให้ความ ยินยอมนี้ และที่อาจเปลี่ยนแปลงในอนาคตซึ่งจะได้ประกาศในช่องทางอื่นของบริษัทต่อไป ซึ่งข้าพเจ้าได้ อ่านและเข้าใจดีแล้ว) ซึ่งข้าพเจ้าตกลงใช้บริการหรือผลิตภัณฑ์และบริษัทในกลุ่มไทยออลอื่น ๆ ณ วันที่ให้ ความยินยอมนี้และต่อเนื่องไปถึงวันและภายหลังวันที่ พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคลมีผลใช้บังคับต่อไป ด้วย ในการเก็บรวบรวม ประมวลผล ใช้ และ/หรือ เปิดเผยข้อมูลส่วนบุคคลที่อ่อนไหว (sensitive data) (เช่น เชื้อชาติ สัญชาติ ศาสนา กรุ๊ปเลือด เป็นต้น) ที่มีข้อมูลปรากฏอยู่บนเอกสารระบุตัวตนของข้าพเจ้า (เช่น บัตรประชาชน หนังสือเดินทาง หรือเอกสารอื่นใดที่ออกโดยหน่วยงานราชการ) รวมถึงข้อมูลชีวภาพ ของข้าพเจ้า (เช่น ข้อมูล จําลองลายนิ้วมือ ข้อมูลชีวมิติ ข้อมูลภาพถ่ายจําลองใบหน้า เป็นต้น) ตลอดจน ข้อมูลภาพหรือเสียงที่มีการบันทึก (ต่อไปนี้รวมเรียกว่า “ข้อมูลส่วนบุคคลของข้าพเจ้า”) เพื่อ วัตถุประสงค์ในการยืนยันและระบุตัวตนของข้าพเจ้าในการขอใช้บริการหรือผลิตภัณฑ์ขอดังกล่าว และ หรือ ตามที่กฎหมายกําหนด</p>
                            <br/><br/>

                            <p style="text-indent: 10px;">ข้าพเจ้าให้ความยินยอม ณ วันที่ให้ความยินยอมนี้ และให้การให้ความยินยอมนี้มีผลสมบูรณ์ทางกฎหมาย ต่อเนื่องไป ณ วันและภายหลังวันที่ พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคลมีผล </p><br/><br/>

                            <p style="text-indent: 10px;">ใช้บังคับด้วย แก่บริษัทในกลุ่ม ไทยออล ธุรกิจในเครือ และ/หรือ พันธมิตรทางธุรกิจ ดังปรากฏรายชื่อแนบท้ายนี้ และที่อาจเปลี่ยนแปลงในอนาคตซึ่งจะได้ ประกาศในช่องทางอื่นของบริษัทต่อไป ในการเก็บรวบรวม ประมวลผล ใช้ และ/หรือ เปิดเผยข้อมูลส่วน บุคคลของข้าพเจ้า และ/หรือ ข้อมูลใด ๆ เกี่ยวกับการใช้สินค้า และ/หรือ บริการของข้าพเจ้า เพื่อวัตถุประสงค์ทางการตลาด เพื่อนําเสนอสินค้าและบริการ สิทธิประโยชน์ รายการส่งเสริมการขาย และ ข้อเสนอต่าง ๆ ของบริษัทในกลุ่มไทยออล หรือพันธมิตรทางธุรกิจ เพื่อวัตถุประสงค์ในการวิเคราะห์ หรือคาดการณ์เกี่ยวกับความชื่นชอบหรือพฤติกรรมของข้าพเจ้า วิจัย พัฒนา ปรับปรุงผลิตภัณฑ์ และวางแผนการตลาด เพื่อให้ บริษัทในกลุ่มไทยออล และ/หรือ พันธมิตรทาง ธุรกิจ สามารถวิเคราะห์และคัดสรรสินค้าและบริการอย่างเหมาะสมกับข้าพเจ้า รวมถึงยินยอมให้มีการ เปิดเผยข้อมูลส่วนบุคคลของข้าพเจ้าระหว่าง และ/หรือให้แก่ บริษัทในกลุ่มไทยออล ธุรกิจในเครือ และ/หรือ พันธมิตรทางธุรกิจ เพื่อวัตถุประสงค์ดังกล่าวด้วย</p><br/><br/>


                            <p style="text-indent: 10px;">ทั้งนี้ ในกรณีที่ข้าพเจ้าเป็นผู้เยาว์ ข้าพเจ้ารับรองว่า ผู้ใช้อํานาจปกครองได้รับทราบและเข้าใจใน บริการและผลิตภัณฑ์ที่ข้าพเจ้าจะใช้ ตลอดจนหนังสือให้ความยินยอมนี้แล้ว และข้าพเจ้าและผู้ใช้อํานาจ ปกครองได้ให้ความยินยอมตามหนังสือให้ความยินยอมนี้แล้ว<br/>

                            ข้าพเจ้าได้อ่านและรับทราบนโยบายคุ้มครองข้อมูลส่วนบุคคลของบริษัทในกลุ่มไทยออลแล้วเป็น อย่างดีแล้วบนแพลตฟอร์ม/แอพพลิเคชั่น/ระบบการใช้งาน ทั้งหมด <br/>

                            ข้าพเจ้าให้ความยินยอม ด้วยความสมัครใจ ปราศจากการบังคับหรือชักจูง และข้าพเจ้าทราบว่า ข้าพเจ้าสามารถถอนความยินยอมนี้เสียเมื่อไรก็ได้ เว้นแต่ในกรณีที่มีข้อจํากัดสิทธิตามกฎหมาย หรือเป็น การรักษาสิทธิตามกฎหมายของข้าพเจ้ากับบริษัทฯ บริษัทในกลุ่มไทยออล หรือพันธมิตรทางธุรกิจแล้วแต่ กรณี ทั้งนี้การถอนความยินยอมดังกล่าวไม่กระทบต่อการใช้ เปิดเผย รวมถึงการประมวลผลข้อมูลที่ได้ ดําเนินการเสร็จสิ้นไปแล้ว โดยข้าพเจ้าสามารถขอถอนความยินยอมได้ตามช่องทางที่บริษัทระบุไว้  <br/>

                                การให้ความยินยอมนี้เป็นการให้ความยินยอมตามที่ระบุเอาไว้ใน สัญญาธุรกิจภายใต้บริษัทไทยออล ธุรกิจในเครือและ/หรือ พันธมิตรทางธุรกิจทั้งหหมด และ และขอเปิดใช้ระบบทั้งหมด ฉบับลงวันที่..........................................</p><br/><br/>

                            <u><b>การถอนความยินยอม</b></u><br/>

                            <p style="text-indent: 10px;">ท่านมีสิทธิขอถอนคํายินยอมเมื่อใดก็ได้ ผ่านบริษัทโดยตรงตาม Email ที่ได้ระบุไว้ และช่องทางที่กลุ่มบริษัทกําหนดในภายหน้า โดยสามารถดูรายละเอียดช่องทางการยกเลิกการ ให้คํายินยอมได้ที่ประกาศนโยบายความเป็นส่วนตัวของกลุ่มบริษัท ทั้งนี้ บริษัทจะพิจารณาดําเนินการ ภายใน 7 วัน นับแต่วันที่ได้รับการแจ้งถอนคํายินยอม </p> <br/>
                            <u><b>การสอบถามสิทธิอื่น ๆ ของข้อมูล </b></u> <br/><br/>
                            1. ผ่านบริษัทหรือติดต่อ Call Center และ Page Facebook เปิดให้บริการ 09.00-17.00 <br/>
                            2.ขอแบบฟอร์มคําขอใช้สิทธิ ของเจ้าของข้อมูลที่เกี่ยวกับข้อมูลส่วนบุคคลทาง กรอกรายละเอียดส่ง Email มาที่ thaiallofficial@gmail.com
                            <br/>
                            รายชื่อกลุ่มบริษัทในกลุ่มไทยออลและพันธมิตรทางธุรกิจ  <br/><br/>
                            (ก) บริษัทในกลุ่มไทยออล ได้แก่ (1) บริษัท ไทยออล จํากัด (ผู้ให้บริการแพลตฟอร์ม “ไอแมคพลัส” “ไอแมคโพส”) และพันธมิตรหรือบริษัทที่เกิดขึ้นในอนาคตหรือบริษัทที่เกิดขึ้นในอนาคต (ข) พันธมิตรทางธุรกิจ บริษัท  (1)บริษัท เดอะ เลตเตอร์ โพสต์ เซอร์วิส (2)บริษัท เอ็มพ้อยท์เอ็กซ์เพรส จํากัด และพันธมิตรหรือบริษัทที่เกิดขึ้นในอนาคต
                            <br/>


                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--                    <button type="submit" class="btn btn-success btn-save" data-dismiss="modalx"><i-->
                    <!--                                class="fa fa-save"></i> ยอมรับ-->
                    <!--                    </button>-->
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>


<!-- include vendor scripts used in "Login" page. see "/views//pages/partials/page-login/@vendor-scripts.hbs" -->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<!-- include ace.js -->
<script src="dist/js/ace.js"></script>


<!-- demo.js is only for Ace's demo and you shouldn't use it -->
<script src="app/browser/demo.js"></script>


<!-- "Login" page script to enable its demo functionality -->
<script src="views/pages/page-login/@page-script.js"></script>

<script>
    function readok(e) {
        if ($('input[name=check_read_ok]').is(':checked') && $('input[name=check_pdpa_ok]').is(':checked')) {
            $(".btn-register-submit").prop("disabled", false);
        } else {

            $(".btn-register-submit").prop("disabled", true);
        }

    }
    function readpdpaok(e) {
        if ($('input[name=check_pdpa_ok]').is(':checked') && $('input[name=check_read_ok]').is(':checked')) {
            $(".btn-register-submit").prop("disabled", false);
        } else {

            $(".btn-register-submit").prop("disabled", true);
        }

    }

    function showcondition() {
        $("#myModal").modal("show");
    }
    function showPdpa() {
        $("#myPdpaModal").modal("show");
    }

    function keypin(e) {
        var data = e.attr("data-var");
        $(".dot").each(function () {
            if ($(this).hasClass("dot-active")) {
                checknumberOk();
            } else {
                $(this).addClass("dot-active");
                $(this).attr("data-var", data);
                checknumberOk();
                return false;
            }
        });
    }
    function keypinlogin(e) {
        var data = e.attr("data-var");
        $(".dot-login").each(function () {
            if ($(this).hasClass("dot-active")) {
                checknumberOk2();
            } else {
                $(this).addClass("dot-active");
                $(this).attr("data-var", data);
                checknumberOk2();
                return false;
            }
        });
    }

    function checknumberOk() {
        var pin_count = 0;
        $(".dot").each(function () {
            if ($(this).hasClass("dot-active")) {
                pin_count = parseFloat(pin_count) + 1;
            }
        });
        if (parseFloat(pin_count) == 6) {
            $(".btn-pin-save").show();
        } else {
            $(".btn-pin-save").hide();
        }
    }
    function checknumberOk2() {
        var pin_count = 0;
        $(".dot-login").each(function () {
            if ($(this).hasClass("dot-active")) {
                pin_count = parseFloat(pin_count) + 1;
            }
        });
        if (parseFloat(pin_count) == 6) {
            $(".btn-pin-login-save").show();
        } else {
            $(".btn-pin-login-save").hide();
        }
    }

    function keypindelete(e) {

        $(".dot-active:last").removeClass("dot-active");
        checknumberOk();
    }

    function keypinclear(e) {
        $(".dot").attr("data-var", "");
        $(".dot").removeClass("dot-active");
        checknumberOk();
        $(".dot-login").attr("data-var", "");
        $(".dot-login").removeClass("dot-active");
        checknumberOk2();
    }

    $(function () {
        var msg2 = $(".message2").val();
        if (msg2 != "") {
           // alert(msg2);
           $(".btn-to-register").trigger("click");
        }
        err_message();
        err_message2();
        if ($(".member-ref-id").val() > 0) {

            $(".btn-to-register").trigger("click");
        }
        $(".btn-submit").click(function (e) {

            e.preventDefault();
            var username = $(".username").val();
            if (username == '') {
                $(".message").val("กรุณากรอกข้อมูล Username");
                $(".username").focus();
                err_message();
                return false;
            }
            $("#myModalPassLogin").modal("show");
        });
        $(".btn-pin-login-save").click(function (e) {

            e.preventDefault();
            var username = $(".username").val();
            var pwd = '';
            $(".dot-login").each(function(){
                pwd = pwd + $(this).attr("data-var");
            });

           // alert(pwd);return;

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
            $(".password").val(pwd);
            $("form#form-login").submit();
        });

        $(".btn-register-submit").click(function (e) {

            $("form#form-register").validate({
                rules: {
                    field: {
                        required: true,
                        email: true
                    }
                }
            });
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
            $('#myModalPass').modal("show");
            // return false;
        });
        $(".btn-pin-save").click(function(){
            var xpass = '';
            $(".dot").each(function(){
                xpass = xpass + $(this).attr("data-var");
            });
            $(".pin-pass").val(xpass);
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