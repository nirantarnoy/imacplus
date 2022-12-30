<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$now = time(); // Checking the time now when home page starts.

if ($now > $_SESSION['expire']) {
    header("location:logout.php");
} else {
    $_SESSION['expire'] = $now + (30 * 60);
}
include("common/dbcon.php");
include("models/UserModel.php");
include("models/MemberModel.php");

$member_id = getMemberFromUser($_SESSION['userid'], $connect);
$isadmin = checkUserAdmin($connect, $_SESSION['userid']);

//echo $_SESSION['userid'];

$is_verified = getMemberverifiedstatus($connect, $member_id);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="widts=device-width, height=device-height, initial-scale=1">
    <!--        <base href="./" />-->

    <title>iMac Plus</title>

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
    <link rel="stylesheet" type="text/css" href="views/pages/form-basic/@page-style.css">


    <style>
        /*@font-face {*/
        /*    font-family: 'SukhumvitSet-Medium';*/
        /*    src: url('dist/font/SukhumvitSet-Medium.ttf') format('truetype');*/
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
            font-size: 16px;
        }

        @media print {
            body {
                font-size: 10pt;
                font-family: "Prompt-Regular";
            }
        }

        @media screen {
            body {
                font-size: 13px;
                font-family: "Prompt-Regular";
            }
        }

        @media screen, print {
            body {
                line-height: 1.2;
                font-family: "Prompt-Regular";
            }
        }
    </style>
</head>

<body>
<div class="body-container">
    <nav class="navbar navbar-expand-lg navbar-fixed" style="background-color: #363636">
        <div class="navbar-inner">

            <div class="navbar-intro justify-content-xl-between">

                <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none"
                        data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar"
                        aria-expanded="false" aria-label="Toggle sidebar">
                    <span class="bars"></span>
                </button><!-- mobile sidebar toggler button -->

                <a class="navbar-brand text-white" href="#">
                    <!--                    <i class="fa fa-backward"></i>-->

                    <img src="uploads/logo/imaclogonew.png" style="width: 30%" alt="">
                    <span>iMac</span>
                    <span>Plus</span>
                </a><!-- /.navbar-brand -->

                <button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar"
                        data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
                    <span class="bars"></span>
                </button><!-- sidebar toggler button -->

            </div><!-- /.navbar-intro -->


            <div class="navbar-content">
                <button class="navbar-toggler py-2" type="button" data-toggle="collapse" data-target="#navbarSearch"
                        aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
                    <i class="fa fa-search text-white text-90 py-1"></i>
                </button><!-- mobile #navbarSearch toggler -->

                <div class="collapse navbar-collapse navbar-backdrop" id="navbarSearch">
                    <form class="d-flex align-items-center ml-lg-4 py-1" data-submit="dismiss">
                        <i class="fa fa-search text-white d-none d-lg-block pos-rel"></i>
                        <input type="text"
                               class="navbar-input mx-3 flex-grow-1 mx-md-auto pr-1 pl-lg-4 ml-lg-n3 py-2 autofocus"
                               placeholder="SEARCH ..." aria-label="Search"/>
                    </form>
                </div>
            </div><!-- .navbar-content -->


            <!-- mobile #navbarMenu toggler button -->
            <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu"
                    aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
            <span class="pos-rel">
                  <img class="border-2 brc-white-tp1 radius-round" width="36"
                       src="uploads/member_photo/<?= getMemberPhoto($connect, $member_id) == '' ? 'demo.png' : getMemberPhoto($connect, $member_id) ?>"
                       alt="Jason's Photo">
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
            </span>
            </button>


            <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">

                <div class="navbar-nav">
                    <ul class="nav">

                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" href="membernotification.php"
                               role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell text-110 text-white icon-animated-bell mr-lg-2"></i>

                                <span class="d-inline-block d-lg-none ml-2">Notifications</span>

                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                <div class="dropdown-caret brc-white"></div>
                            </a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" href="#"
                               role="button" aria-haspopup="true" aria-expanded="false">
                                <!--                                <i class="fa fa-money-check text-110 text-white mr-lg-2"></i>-->
<!--                                <span><img src="assets/iCOn/iCOn/wallet.png" style="width: 20px;" alt=""> </span>-->
                                <span style="color: yellow;padding-left: 10px;"> <span style="color: white;">mPoint</span> <br><?= number_format(getMemberPoint($connect, $member_id),2) ?></span>
                                <span class="d-inline-block d-lg-none ml-2">Notifications</span>

                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                <div class="dropdown-caret brc-white"></div>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" href="#"
                               role="button" aria-haspopup="true" aria-expanded="false">
                                <!--                                <i class="fa fa-money-check text-110 text-white mr-lg-2"></i>-->
<!--                                <span><img src="assets/iCOn/iCOn/wallet.png" style="width: 20px;" alt=""> </span>-->
                                <span style="color: yellow;padding-left: 10px;"> <span style="color: white;">Wallet</span> <br><?= number_format(getMemberWallerAmount($connect, $member_id),2) ?></span>
                                <span class="d-inline-block d-lg-none ml-2">Notifications</span>

                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                <div class="dropdown-caret brc-white"></div>
                            </a>

                        </li>


                        <li class="nav-item dropdown order-first order-lg-last">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <img id="id-navbar-user-image"
                                     class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"
                                     src="uploads/member_photo/<?= getMemberPhoto($connect, $member_id) == '' ? 'demo.png' : getMemberPhoto($connect, $member_id) ?>"
                                     alt="Admin 's photo">
                                <span class="d-inline-block d-lg-none d-xl-inline-block">
                              <span class="text-90 text-white" id="id-user-welcome">Welcome,</span>
                    <span class="nav-user-name text-white"><?= getUserDisplayname($_SESSION['userid'], $connect) ?></span>
                    </span>

                                <i class="caret fa fa-angle-down text-white d-none d-xl-block"></i>
                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                            </a>

                            <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">
                                <div class="d-none d-lg-block d-xl-none">
                                    <div class="dropdown-header">
                                        Welcome, <?php //echo$_SESSION['userid']?>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                </div>


                                <a class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary"
                                   href="profile.php">
                                    <i class="fa fa-user text-primary-m1 text-105 mr-1"></i>
                                    Profile
                                </a>

                                <a class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary"
                                   href="changepassword.php">
                                    <i class="fa fa-key text-primary-m1 text-105 mr-1"></i>
                                    Change password
                                </a>

                                <div class="dropdown-divider brc-primary-l2"></div>

                                <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary"
                                   href="logout.php">
                                    <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>


        </div><!-- /.navbar-inner -->
    </nav>
    <div class="main-container bgc-white">

        <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
            <div class="sidebar-inner">

                <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">

                    <!--                    <div class="sidebar-section my-2">-->
                    <!-- the shortcut buttons -->
                    <!--                        <div class="sidebar-section-item fadeable-left">-->
                    <!--                            <div class="fadeinable sidebar-shortcuts-mini">-->
                    <!-- show this small buttons when collapsed -->
                    <!--                                <span class="btn btn-success p-0 opacity-1"></span>-->
                    <!--                                <span class="btn btn-info p-0 opacity-1"></span>-->
                    <!--                                <span class="btn btn-orange p-0 opacity-1"></span>-->
                    <!--                                <span class="btn btn-danger p-0 opacity-1"></span>-->
                    <!--                            </div>-->
                    <!---->
                    <!--                            <div class="fadeable">-->
                    <!-- show this small buttons when not collapsed -->
                    <!--                                <div class="sub-arrow"></div>-->
                    <!--                                <div>-->
                    <!--                                    <button class="btn px-25 py-2 text-95 btn-success opacity-1">-->
                    <!--                                        <i class="fa fa-signal f-n-hover"></i>-->
                    <!--                                    </button>-->
                    <!---->
                    <!--                                    <button class="btn px-25 py-2 text-95 btn-info opacity-1">-->
                    <!--                                        <i class="fa fa-edit f-n-hover"></i>-->
                    <!--                                    </button>-->
                    <!---->
                    <!--                                    <button class="btn px-25 py-2 text-95 btn-orange opacity-1">-->
                    <!--                                        <i class="fa fa-users f-n-hover"></i>-->
                    <!--                                    </button>-->
                    <!---->
                    <!--                                    <button class="btn px-25 py-2 text-95 btn-danger opacity-1">-->
                    <!--                                        <i class="fa fa-cogs f-n-hover"></i>-->
                    <!--                                    </button>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!---->
                    <!---->
                    <!-- the search box -->
                    <!--                    </div>-->

                    <?php
                    $is_active = null;
                    $is_show = null;
                    function url_origin($s, $use_forwarded_host = false)
                    {
                        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
                        $sp = strtolower($s['SERVER_PROTOCOL']);
                        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
                        $port = $s['SERVER_PORT'];
                        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
                        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
                        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
                        return $protocol . '://' . $host;
                    }

                    function full_url($s, $use_forwarded_host = false)
                    {
                        return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
                    }

                    $absolute_url = full_url($_SERVER);

                    $current_url = explode('/', $absolute_url);
                    // print_r($current_url[4]);
                    function checkActiveMenu($obj, $menu)
                    {
                        if ($obj == $menu) {
                            $is_active = 'active';
                        } else {
                            $is_active = '';
                        }
                        return $is_active;
                    }

                    function checkShowMenu($obj, $menu)
                    {
                        if ($obj == $menu) {
                            $is_show = 'show';
                        } else {
                            $is_show = '';
                        }
                        return $is_show;
                    }

                    ?>

                    <ul class="nav has-active-border active-on-right">


                        <li class="nav-item-caption">
                            <span class="fadeable pl-3">MAIN</span>
                            <span class="fadeinable mt-n2 text-125">&hellip;</span>
                            <!--
                                     OR something like the following (with `.hideable` text)
                                 -->
                            <!--
                                     <div class="hideable">
                                         <span class="pl-3">MAIN</span>
                                     </div>
                                     <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                 -->
                        </li>


                        <!--                        <li class="nav-item  -->
                        <? //=checkActiveMenu($current_url[4],'index.php')?><!--">-->
                        <!--                            <a href="profile.php" class="nav-link">-->
                        <!--                                <i class="nav-icon fa fa-tachometer-alt"></i>-->
                        <!--                                <span class="nav-text fadeable">-->
                        <!--                                  <span>Dashboard</span>-->
                        <!--                                </span>-->
                        <!--                            </a>-->
                        <!--                            <b class="sub-arrow"></b>-->
                        <!--                        </li>-->
                        <?php if ($isadmin != 1): ?>
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? 'profile.php' : '#';
                                ?>
                                <a href="<?= $url ?>" class="nav-link">
                                    <img src="assets/iCOn/iCOn/home.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">

                                  <span>หน้าหลัก</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? 'member_teamlist.php' : '#';
                                ?>
                                <a href="<?= $url ?>" class="nav-link">
                                    <img src="assets/iCOn/iCOn/member.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>ทีมงานของฉัน</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? 'workorder.php' : '#';
                                ?>
                                <a href="<?= $url ?>" class="nav-link">
                                    <img src="assets/iCOn/iCOn/work_photo.png" class="nav-icon" style="width: 10%"
                                         alt="">
                                    <span class="nav-text fadeable">
                                  <span>ข้อมูลการซ่อม</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
<!--                            <li class="nav-item">-->
<!--                                --><?php
//                                $url = $is_verified ? 'dropoff.php' : '#';
//                                ?>
<!--                                <a href="--><?//= $url ?><!--" class="nav-link">-->
<!--                                    <img src="assets/iCOn/iCOn/DropOff.png" class="nav-icon" style="width: 10%" alt="">-->
<!--                                    <span class="nav-text fadeable">-->
<!--                                  <span>Drop Off</span>-->
<!--                                </span>-->
<!--                                </a>-->
<!--                                <b class="sub-arrow"></b>-->
<!--                            </li>-->
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? 'walletlist.php' : '#';
                                ?>
                                <a href="<?= $url ?>" class="nav-link">
                                    <img src="assets/iCOn/iCOn/wallet.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>My Wallet</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? 'witdrawlist.php' : '#';
                                ?>
                                <a href="<?= $url ?>" class="nav-link">
                                    <img src="assets/iCOn/iCOn/mPoint.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>My mPoint</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <?php
                                $url = $is_verified ? '#' : '#';
                                ?>
                                <a href="#" class="nav-link">
                                    <img src="assets/iCOn/iCOn/review.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>รีวิวผู้ใช้งาน</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <img src="assets/iCOn/iCOn/knowledge.png" class="nav-icon" style="width: 10%"
                                         alt="">
                                    <span class="nav-text fadeable">
                                  <span>แหล่งเรียนรู้</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <img src="assets/iCOn/iCOn/Market.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>Market</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
<!--                            <li class="nav-item">-->
<!--                                <a href="#" class="nav-link">-->
<!--                                    <img src="assets/iCOn/iCOn/return.png" class="nav-icon" style="width: 10%" alt="">-->
<!--                                    <span class="nav-text fadeable">-->
<!--                                  <span>คืนเงิน/คืนสินค้า</span>-->
<!--                                </span>-->
<!--                                </a>-->
<!--                                <b class="sub-arrow"></b>-->
<!--                            </li>-->
                            <li class="nav-item">
                                <a href="qandapage.php" class="nav-link">
                                    <img src="assets/iCOn/iCOn/qa.png" class="nav-icon" style="width: 10%" alt="">
                                    <span class="nav-text fadeable">
                                  <span>คำถามที่พบบ่อย</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>
                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-cube"></i>
                                    <span class="nav-text fadeable">
                                  <span>สินค้า</span>
                                </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>

                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>
                                <div class="hideable submenu collapse <?= checkShowMenu($current_url[4], 'productcat.php') ?>">
                                    <ul class="submenu-inner">
                                        <li class="nav-item <?= checkActiveMenu($current_url[4], 'device_type.php') ?>">
                                            <a href="device_type.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ประเภทอุปกรณ์</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?= checkActiveMenu($current_url[4], 'itembrand.php') ?>">
                                            <a href="itembrand.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ยี่ห้อ</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="item.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>Models</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="standardprice.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>มาตรฐานราคา</span>
                                          </span>
                                            </a>
                                        </li>
                                        <!--                                    <li class="nav-item">-->
                                        <!--                                        <a href="unit.php" class="nav-link">-->
                                        <!--                                          <span class="nav-text">-->
                                        <!--                                              <span>หน่วยนับ</span>-->
                                        <!--                                          </span>-->
                                        <!--                                        </a>-->
                                        <!--                                    </li>-->
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-user-cog"></i>
                                    <span class="nav-text fadeable">
                                  <span>สมาชิก</span>
                                </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>
                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>
                                <div class="hideable submenu collapse">
                                    <ul class="submenu-inner">

                                        <li class="nav-item">

                                            <a href="member_type.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ประเภทสมาชิก</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="member.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>สมาชิก</span>
                                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1 ): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-wrench"></i>
                                    <span class="nav-text fadeable">
                                      <span>ข้อมูลการซ่อม</span>
                                        </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>

                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>

                                <div class="hideable submenu collapse">
                                    <ul class="submenu-inner">
                                        <li class="nav-item">
                                            <a href="check_list.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>Check List</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="quotation.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>เสนอราคา</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="workorder.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>คำสั่งซ่อม</span>
                                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="memberupgradepage.php" class="nav-link">
                                    <i class="nav-icon fa fa-wallet"></i>
                                    <span class="nav-text fadeable">
                                  <span>อัพเกรดสมาชิก</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="walletpage.php" class="nav-link">
                                    <i class="nav-icon fa fa-wallet"></i>
                                    <span class="nav-text fadeable">
                                  <span>เติม Wallet</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="witdrawpage.php" class="nav-link">
                                    <i class="nav-icon fa fa-wallet"></i>
                                    <span class="nav-text fadeable">
                                  <span>ถอน mPoint</span>
                                </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item-caption">
                                <span class="fadeable pl-3">ตั้งค่าคะแนน Point</span>
                                <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                <!--
                                         OR something like the following (with `.hideable` text)
                                     -->
                                <!--
                                         <div class="hideable">
                                             <span class="pl-3">OTHER</span>
                                         </div>
                                         <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                     -->
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-trophy"></i>
                                    <span class="nav-text fadeable">
                                  <span>ข้อมูลคะแนน</span>
                                </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>
                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>

                                <div class="hideable submenu collapse">
                                    <ul class="submenu-inner">
                                        <li class="nav-item">
                                            <a href="upgradestandard.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ตั้งค่าอัพเกรด mPoint</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pointstandard.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ตั้งค่าคำนวน mPoint</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="sparepart_type.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>ประเภทอะไหล่</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="sparepart.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>อะไหล่</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="shop_type.php" class="nav-link">
                                              <span class="nav-text">
                                                  <span>ประเภทร้าน</span>
                                              </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                          <span class="nav-text">
                                              <span>Point</span>
                                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>
                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-images"></i>
                                    <span class="nav-text fadeable">
                                  <span>จัดการแบนเนอร์</span>
                                </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>
                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>
                                <div class="hideable submenu collapse">
                                    <ul class="submenu-inner">

                                        <li class="nav-item">

                                            <a href="banner.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>แบนเนอร์</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="user_review.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>รีวิวลูกค้า</span>
                                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>
                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item-caption">
                                <span class="fadeable pl-3">สิทธิ์การใช้งาน</span>
                                <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                <!--
                                         OR something like the following (with `.hideable` text)
                                     -->
                                <!--
                                         <div class="hideable">
                                             <span class="pl-3">OTHER</span>
                                         </div>
                                         <span class="fadeinable mt-n2 text-125">&hellip;</span>
                                     -->
                            </li>
                        <?php endif; ?>

                        <?php if ($isadmin == 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-toggle collapsed">
                                    <i class="nav-icon fa fa-lock-open"></i>
                                    <span class="nav-text fadeable">
                                  <span>ผู้ดูแลระบบ</span>
                                </span>
                                    <b class="caret fa fa-angle-left rt-n90"></b>
                                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                    <!--
                                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                                    -->
                                </a>

                                <div class="hideable submenu collapse">
                                    <ul class="submenu-inner">
                                        <li class="nav-item">
                                            <a href="user_group.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>กลุ่มผู้ใช้งาน</span>
                                          </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="user.php" class="nav-link">
                                              <span class="nav-text">
                                                  <span>ผู้ใช้งาน</span>
                                              </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                          <span class="nav-text">
                                              <span>สิทธิ์การเข้าถึง</span>
                                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <b class="sub-arrow"></b>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.sidebar scroll -->

                <!--                -->

            </div>
        </div>

        <div role="main" class="main-content">

            <!--            <div class="page-content container container-plus">-->
            <div class="page-content">
                <!-- page header and toolbox -->



