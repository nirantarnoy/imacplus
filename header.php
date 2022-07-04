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


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">


    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="dist/css/ace.css">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="assets/favicon.png"/>

    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <link rel="stylesheet" type="text/css" href="views/pages/dashboard/@page-style.css">
</head>

<body>
<?php include "common/dbcon.php" ?>
<div class="body-container">
    <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner">

            <div class="navbar-intro justify-content-xl-between">

                <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none"
                        data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar"
                        aria-expanded="false" aria-label="Toggle sidebar">
                    <span class="bars"></span>
                </button><!-- mobile sidebar toggler button -->

                <a class="navbar-brand text-white" href="#">
                    <i class="fa fa-backward"></i>
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
                  <img class="border-2 brc-white-tp1 radius-round" width="36" src="assets/image/avatar/avatar6.jpg"
                       alt="Jason's Photo">
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
            </span>
            </button>


            <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">

                <div class="navbar-nav">
                    <ul class="nav">


                        <li class="nav-item dropdown dropdown-mega">
                            <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#"
                               role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell text-110 icon-animated-bell mr-lg-2"></i>

                                <span class="d-inline-block d-lg-none ml-2">Notifications</span>
                                <!-- show only on mobile -->
                                <span id="id-navbar-badge1"
                                      class="badge badge-sm bgc-warning-d2 text-white radius-round text-85 border-1 brc-white-tp5">3</span>

                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                <div class="dropdown-caret brc-white"></div>
                            </a>
                            <div class="dropdown-menu dropdown-sm dropdown-animated p-0 bgc-white brc-primary-m3 border-b-2 shadow">
                                <ul class="nav nav-tabs nav-tabs-simple w-100 nav-justified dropdown-clickable border-b-1 brc-secondary-l2"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="d-style px-0 mx-0 py-3 nav-link active text-600 brc-blue-m1 text-dark-tp5 bgc-h-blue-l4"
                                           data-toggle="tab" href="#navbar-notif-tab-1" role="tab">
                                            <span class="d-active text-blue-d1 text-105">Notifications</span>
                                            <span class="d-n-active">Notifications</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="d-style px-0 mx-0 py-3 nav-link text-600 brc-purple-m1 text-dark-tp5 bgc-h-purple-l4"
                                           data-toggle="tab" href="#navbar-notif-tab-2" role="tab">
                                            <span class="d-active text-purple-d1 text-105">Messages</span>
                                            <span class="d-n-active">Messages</span>
                                        </a>
                                    </li>
                                </ul><!-- .nav-tabs -->


                                <div class="tab-content tab-sliding p-0">

                                    <div class="tab-pane mh-none show active px-md-1 pt-1" id="navbar-notif-tab-1"
                                         role="tabpanel">

                                        <a href="#"
                                           class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                            <i class="fab fa-twitter bgc-blue-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                                            <span class="text-muted">Followers</span>
                                            <span class="float-right badge badge-danger radius-round text-80">- 4</span>
                                        </a>
                                        <a href="#"
                                           class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                            <i class="fa fa-comment bgc-pink-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                                            <span class="text-muted">New Comments</span>
                                            <span class="float-right badge badge-info radius-round text-80">+12</span>
                                        </a>
                                        <a href="#"
                                           class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                            <i class="fa fa-shopping-cart bgc-success-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                                            <span class="text-muted">New Orders</span>
                                            <span class="float-right badge badge-success radius-round text-80">+8</span>
                                        </a>
                                        <a href="#"
                                           class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                            <i class="far fa-clock bgc-purple-tp1 text-white text-110 mr-15 p-2 radius-1"></i>
                                            <span class="text-muted">Finished processing data!</span>
                                        </a>

                                        <hr class="mt-1 mb-1px brc-secondary-l2"/>
                                        <a href="#"
                                           class="mb-0 py-3 border-0 list-group-item text-blue text-uppercase text-center text-85 font-bolder">
                                            See All Notifications
                                            <i class="ml-2 fa fa-arrow-right text-muted"></i>
                                        </a>

                                    </div><!-- .tab-pane : notifications -->


                                    <div class="tab-pane mh-none pl-md-2" id="navbar-notif-tab-2" role="tabpanel">
                                        <div data-ace-scroll='{"ignore": "mobile", "height": 300, "smooth":true}'>
                                            <a href="#"
                                               class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                                <img alt="Alex's avatar" src="assets/image/avatar/avatar.png" width="48"
                                                     class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round"/>
                                                <div>
                                                    <span class="text-primary-m1 font-bolder">Alex:</span>
                                                    <span class="text-grey text-90">Ciao sociis natoque penatibus et auctor ...</span>
                                                    <br/>
                                                    <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  a moment ago
                                              </span>
                                                </div>
                                            </a>
                                            <hr class="my-1px brc-grey-l3"/>
                                            <a href="#"
                                               class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                                <img alt="Susan's avatar" src="assets/image/avatar/avatar3.png"
                                                     width="48"
                                                     class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round"/>
                                                <div>
                                                    <span class="text-primary-m1 font-bolder">Susan:</span>
                                                    <span class="text-grey text-90">Vestibulum id ligula porta felis euismod ...</span>
                                                    <br/>
                                                    <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  20 minutes ago
                                              </span>
                                                </div>
                                            </a>
                                            <hr class="my-1px brc-grey-l3"/>
                                            <a href="#"
                                               class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                                <img alt="Bob's avatar" src="assets/image/avatar/avatar4.png" width="48"
                                                     class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round"/>
                                                <div>
                                                    <span class="text-primary-m1 font-bolder">Bob:</span>
                                                    <span class="text-grey text-90">Nullam quis risus eget urna mollis ornare ...</span>
                                                    <br/>
                                                    <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  3:15 pm
                                              </span>
                                                </div>
                                            </a>
                                            <hr class="my-1px brc-grey-l3"/>
                                            <a href="#"
                                               class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                                <img alt="Kate's avatar" src="assets/image/avatar/avatar2.png"
                                                     width="48"
                                                     class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round"/>
                                                <div>
                                                    <span class="text-primary-m1 font-bolder">Kate:</span>
                                                    <span class="text-grey text-90">Ciao sociis natoque eget urna mollis ornare ...</span>
                                                    <br/>
                                                    <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  1:33 pm
                                              </span>
                                                </div>
                                            </a>
                                            <hr class="my-1px brc-grey-l3"/>
                                            <a href="#"
                                               class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
                                                <img alt="Fred's avatar" src="assets/image/avatar/avatar5.png"
                                                     width="48"
                                                     class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round"/>
                                                <div>
                                                    <span class="text-primary-m1 font-bolder">Fred:</span>
                                                    <span class="text-grey text-90">Vestibulum id penatibus et auctor  ...</span>
                                                    <br/>
                                                    <span class="text-grey-m1 text-85">
                                                  <i class="far fa-clock"></i>
                                                  10:09 am
                                              </span>
                                                </div>
                                            </a>

                                        </div><!-- ace-scroll -->

                                        <hr class="my-1px brc-secondary-l2 border-double"/>
                                        <a href="html/page-inbox.html"
                                           class="mb-0 py-3 border-0 list-group-item text-purple text-uppercase text-center text-85 font-bolder">
                                            See All Messages
                                            <i class="ml-2 fa fa-arrow-right text-muted"></i>
                                        </a>
                                    </div><!-- .tab-pane : messages -->

                                </div>
                            </div>
                        </li>


                        <li class="nav-item dd-backdrop dropdown dropdown-mega">
                            <a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#"
                               role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-flask text-110 icon-animated-vertical mr-lg-1"></i>

                                <span class="d-inline-block d-lg-none ml-2">Tasks</span><!-- show only on mobile -->
                                <span id="id-navbar-badge2" class="badge badge-sm text-95 text-yellow-l4">+2</span>

                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                                <div class="dropdown-caret brc-warning-l2"></div>
                            </a>
                            <div class="dropdown-menu dropdown-xs dropdown-animated animated-1 p-0 bgc-white brc-warning-l1 shadow">
                                <div class="bgc-orange-l2 py-25 px-4 border-b-1 brc-orange-l2">
                      <span class="text-dark-tp4 text-600 text-90 text-uppercase">
                              <i class="fa fa-check mr-2px text-warning-d2 text-120"></i>
                              4 Tasks to complete
                            </span>
                                </div>


                                <div class="px-4 py-2">
                                    <div class="text-95">
                                        <span class="text-grey-d1">Software update</span>
                                    </div>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bgc-info" role="progressbar" style="width: 60%;"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-1 mx-4"/>
                                <div class="px-4 py-2">
                                    <div class="text-95">
                                        <span class="text-grey-d1">Hardware upgrade</span>
                                    </div>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bgc-warning" role="progressbar" style="width: 40%;"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">40%
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-1 mx-4"/>
                                <div class="px-4 py-2">
                                    <div class="text-95">
                                        <span class="text-grey-d1">Customer support</span>
                                    </div>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bgc-danger" role="progressbar" style="width: 30%;"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">30%
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-1 mx-4"/>
                                <div class="px-4 py-2">
                                    <div class="text-95">
                                        <span class="text-grey-d1">Fixing bugs</span>
                                    </div>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bgc-success progress-bar-striped progress-bar-animated"
                                             role="progressbar" style="width: 85%;" aria-valuenow="60" aria-valuemin="0"
                                             aria-valuemax="100">85%
                                        </div>
                                    </div>
                                </div>


                                <hr class="my-1px mx-2 brc-info-l2 "/>
                                <a href="#" class="d-block bgc-h-primary-l4 py-3 border-0 text-center text-blue-m2">
                                    <span class="text-85 text-600 text-uppercase">See All Tasks</span>
                                    <i class="ml-2 fa fa-arrow-right text-muted"></i>
                                </a>
                            </div>
                        </li>


                        <li class="nav-item dropdown order-first order-lg-last">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <img id="id-navbar-user-image"
                                     class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"
                                     src="assets/image/avatar/admin.jpg" alt="Admin 's photo">
                                <span class="d-inline-block d-lg-none d-xl-inline-block">
                              <span class="text-90" id="id-user-welcome">Welcome,</span>
                    <span class="nav-user-name">Admin</span>
                    </span>

                                <i class="caret fa fa-angle-down d-none d-xl-block"></i>
                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                            </a>

                            <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">
                                <div class="d-none d-lg-block d-xl-none">
                                    <div class="dropdown-header">
                                        Welcome, Admin
                                    </div>
                                    <div class="dropdown-divider"></div>
                                </div>


                                <a class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary"
                                   href="changepassword.php">
                                    <i class="fa fa-user text-primary-m1 text-105 mr-1"></i>
                                    Change password
                                </a>

                                <div class="dropdown-divider brc-primary-l2"></div>

                                <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary"
                                   href="loginpage.php">
                                    <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                                    Logout
                                </a>
                            </div>
                        </li><!-- /.nav-item:last -->

                    </ul><!-- /.navbar-nav menu -->
                </div><!-- /.navbar-nav -->

            </div><!-- /#navbarMenu -->


        </div><!-- /.navbar-inner -->
    </nav>
    <div class="main-container bgc-white">

        <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
            <div class="sidebar-inner">

                <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">

                    <div class="sidebar-section my-2">
                        <!-- the shortcut buttons -->
                        <div class="sidebar-section-item fadeable-left">
                            <div class="fadeinable sidebar-shortcuts-mini">
                                <!-- show this small buttons when collapsed -->
                                <span class="btn btn-success p-0 opacity-1"></span>
                                <span class="btn btn-info p-0 opacity-1"></span>
                                <span class="btn btn-orange p-0 opacity-1"></span>
                                <span class="btn btn-danger p-0 opacity-1"></span>
                            </div>

                            <div class="fadeable">
                                <!-- show this small buttons when not collapsed -->
                                <div class="sub-arrow"></div>
                                <div>
                                    <button class="btn px-25 py-2 text-95 btn-success opacity-1">
                                        <i class="fa fa-signal f-n-hover"></i>
                                    </button>

                                    <button class="btn px-25 py-2 text-95 btn-info opacity-1">
                                        <i class="fa fa-edit f-n-hover"></i>
                                    </button>

                                    <button class="btn px-25 py-2 text-95 btn-orange opacity-1">
                                        <i class="fa fa-users f-n-hover"></i>
                                    </button>

                                    <button class="btn px-25 py-2 text-95 btn-danger opacity-1">
                                        <i class="fa fa-cogs f-n-hover"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- the search box -->
                    </div>

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


                        <li class="nav-item  <?=checkActiveMenu($current_url[4],'index.php')?>">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fa fa-tachometer-alt"></i>
                                <span class="nav-text fadeable">
                                  <span>Dashboard</span>
                                </span>
                            </a>
                            <b class="sub-arrow"></b>
                        </li>
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
                            <div class="hideable submenu collapse <?=checkShowMenu($current_url[4],'productcat.php')?>">
                                <ul class="submenu-inner">
                                    <li class="nav-item <?=checkActiveMenu($current_url[4],'itembrand.php')?>">
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
                                        <a href="unit.php" class="nav-link">
                                          <span class="nav-text">
                                              <span>หน่วยนับ</span>
                                          </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <b class="sub-arrow"></b>
                        </li>
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


                        <!--                        <li class="nav-item">-->
                        <!---->
                        <!--                            <a href="html/cards.html" class="nav-link">-->
                        <!--                                <i class="nav-icon far fa-window-restore"></i>-->
                        <!--                                <span class="nav-text fadeable">-->
                        <!--               	  <span>สินค้า</span>-->
                        <!--                    </span>-->
                        <!---->
                        <!---->
                        <!--                            </a>-->
                        <!---->
                        <!--                            <b class="sub-arrow"></b>-->
                        <!---->
                        <!--                        </li>-->


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
                                        <a href="#" class="nav-link">
                                          <span class="nav-text">
                                              <span>Point</span>
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
                    </ul>
                </div><!-- /.sidebar scroll -->

                <!--                -->

            </div>
        </div>

        <div role="main" class="main-content">

            <div class="page-content container container-plus">
                <!-- page header and toolbox -->



