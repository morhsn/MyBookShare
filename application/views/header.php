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
                        <li><a href="index.html">
                                <div>Home</div>
                            </a>
                        </li>
                        <li><a href="page/Newsfeed">
                                <div>News feed</div>
                            </a>
                        </li>
                        <li><a href="page/MyBookshelf">
                                <div>My Bookshelf</div>
                            </a>
                        </li>
                        <li><a href="page/FindBooksPage">
                                <div>Find Books</div>
                            </a>
                        </li>
                        <li><a href="page/LoansCP">
                                <div>Loans Control Panel</div>
                            </a>
                        </li>
                    </ul>

                    <div>
                        <?php if ($loggedIn): ?>

                            <ul class="nav navbar-nav navbar-right">

                                <li class="dropdown">

                                    <a href="#" class="dropdown-toggle"
                                       data-toggle="dropdown">Hello <?php echo $username; ?> <b class="caret"></b></a>

                                    <ul class="dropdown-menu">

                                        <li><a href="<?php echo $fbLogin; ?>">Logout</a></li>


                                    </ul>

                                </li>

                            </ul>

                        <?php else: ?>

                            <ul class="nav navbar-nav navbar-right">

                                <li class="active">

                                    <a href="<?php echo $fbLogin; ?>">Login</a>

                                </li>

                            </ul>

                        <?php endif ?>
                    </div>

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->