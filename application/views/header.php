<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Mor"/>
    <base href="<?php echo base_url(); ?>">

    <!-- Stylesheets
    ============================================= -->
    <link
        href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
        rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="stylesheet" href="css/dark.css" type="text/css"/>
    <link rel="stylesheet" href="css/font-icons.css" type="text/css"/>
    <link rel="stylesheet" href="css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css"/>

    <link rel="stylesheet" href="css/responsive.css" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>

    <!-- Document Title
    ============================================= -->
    <title><?= $title ?></title>

</head>

<body class="stretched" data-animation-in="fadeIn" data-speed-in="500"
      data-animation-out="fadeOut" data-speed-out="200" data-loader-color="#1ABC9C" data-loader-timeout="1500">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Header
    ============================================= -->
    <header id="header" class="full-header">

        <div id="header-wrap">

            <div class="container clearfix">

                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    <a href="http://mybooksharing.tk" class="standard-logo" data-dark-logo="images/logo-dark.png"><img
                            src="images/logo.png" alt="Canvas Logo"></a>
                    <a href="http://mybooksharing.tk" class="retina-logo" data-dark-logo="images/logo-dark@2x.png"><img
                            src="images/logo@2x.png" alt="Canvas Logo"></a>
                </div><!-- #logo end -->

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu">

                    <ul>
                        <li><a href="http://mybooksharing.tk">
                                <div><i class="icon-home"></i>Home</div>
                            </a>
                        </li>
                        <li><a href="page/Newsfeed">
                                <div><i class="icon-star2"></i>News feed</div>
                            </a>
                        </li>
                        <li><a href="page/FindBooksPage">
                                <div><i class="icon-line-search"></i>Book Search</div>
                            </a>
                        </li>
                        <li><a href="page/BookManagement">
                                <div><i class="icon-line-book"></i>Book Management</div>
                            </a>
                        </li>
                        <li style="border-left: 1px solid #EEE;">

                            <?php if ($loggedIn): ?>
                                <a href="#">
                                    <div><i class="icon-angle-down"></i>Hello <?php echo $username; ?></div>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo $fbLogin; ?>">
                                    <img src="images/login-facebook.png"
                                         alt="Log In With Facebook" border="0"/>
                                </a>
                            <?php endif ?>
                            <?php if ($loggedIn): ?>
                                <ul>
                                    <li><a href="page/MyAccount">
                                            <div class="ls1"><i class="icon-line-head"></i>My Account</div>
                                        </a></li>
                                    <li><a href="page/MyBookshelf">
                                            <div class="ls1"><i class="icon-line-stack-2"></i>My Bookshelf</div>
                                        </a>
                                    </li>
                                    <li><a href="<?php echo $fbLogin; ?>">
                                            <div class="ls1"><i class="icon-line2-logout"></i>Log Out</div>
                                        </a></li>
                                </ul>
                            <?php endif ?>
                        </li>
                    </ul>

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->