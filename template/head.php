<?php
global $db, $action, $controller;
$menu = array(
    'Home' => array('','')
    , 'Players' => array('player', 'list')
);
include 'mysql.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Template &middot; Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 20px;
            padding-bottom: 60px;
        }
        .aliens{
            background-color: #a9dba9 !important;
        }
        .resistance {
            background-color: #339bb9 !important;
        }
            /* Custom container */
        .container {
            margin: 0 auto;
            max-width: 1000px;
        }
        .container > hr {
            margin: 60px 0;
        }

            /* Main marketing message and sign up button */
        .jumbotron {
            margin: 80px 0;
            text-align: center;
        }
        .jumbotron h1 {
            font-size: 100px;
            line-height: 1;
        }
        .jumbotron .lead {
            font-size: 24px;
            line-height: 1.25;
        }
        .jumbotron .btn {
            font-size: 21px;
            padding: 14px 24px;
        }

            /* Supporting marketing content */
        .marketing {
            margin: 60px 0;
        }
        .marketing p + h4 {
            margin-top: 28px;
        }


            /* Customize the navbar links to be fill the entire space of the .navbar */
        .navbar .navbar-inner {
            padding: 0;
        }
        .navbar .nav {
            margin: 0;
            display: table;
            width: 100%;
        }
        .navbar .nav li {
            display: table-cell;
            width: 1%;
            float: none;
        }
        .navbar .nav li a {
            font-weight: bold;
            text-align: center;
            border-left: 1px solid rgba(255,255,255,.75);
            border-right: 1px solid rgba(0,0,0,.1);
        }
        .navbar .nav li:first-child a {
            border-left: 0;
            border-radius: 3px 0 0 3px;
        }
        .navbar .nav li:last-child a {
            border-right: 0;
            border-radius: 0 3px 3px 0;
        }
        #map_canvas{
            height: 600px;
        }
    </style>
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="/favicon.ico">
    <script src="/js/jquery.min.js"></script>
</head>

<body>

<div class="container">

    <div class="masthead">
        <h3 class="muted">Ingress stat</h3>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                    <?php
    foreach($menu as $label=>$item_action){
        echo '<li'.(($controller == $item_action[0])?' class="active"':'')."><a
        href='?action=$item_action[1]&controller=$item_action[0]'>$label</a></li>";
    }
?>
                        <!--<li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Downloads</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>-->
                    </ul>
                </div>
            </div>
        </div><!-- /.navbar -->
    </div>
