<?php

global $db, $action, $controller;

include 'mysql.php';
session_start();

if(!isset($_SESSION['user'])){
    require 'openid.php';
    try {
        # Change 'localhost' to your domain name.
        $openid = new LightOpenID('ingress.xs45.info');
        if(!$openid->mode) {
            if(isset($_GET['login'])) {
                $openid->identity = 'https://www.google.com/accounts/o8/id';
                $openid->required = array('contact/email');
                header('Location: ' . $openid->authUrl());
            }
    ?>
    <form action="?login" method="post">
        <button>Login with Google</button>
    </form>
    <?php
        } elseif($openid->mode == 'cancel') {
            echo 'User has canceled authentication!';
        } else {
            $valid = $openid->validate();
            if($valid){
                $identify = $openid->identity;
                $userinfo = $openid->getAttributes();
                $_SESSION['user'] = $userinfo['contact/email'];
                isEmailAproved($_SESSION['user']);
                header('Location: index.php');
            }
        }
    } catch(ErrorException $e) {
        echo $e->getMessage();
    }
    die();
} else {
    isEmailAproved($_SESSION['user']);
}
function isEmailAproved($email){
    global $db;
    $email = $db->real_escape_string($email);
    $res = $db->query("SELECT aproved, email FROM `users` WHERE `email` = '$email'");
    header("Content-Type: text/html; charset=utf-8");
    if(!$res->num_rows){
#       $stmt->free_result();
        $str = $db->prepare('INSERT INTO `users`(`email`) VALUES(?)');
        $str->bind_param("s",$email);
        $str->execute();
        echo 'Сообщите ваш емейл игроку Xsci. Я дам вам доступ. '.$email;
        die();
    } else {
        $user = $res->fetch_assoc();
        $aproved = $user['aproved'];
        if(!$aproved){
            echo 'Сообщите ваш емейл игроку Xsci. Я дам вам доступ. '.$email;
            die();
        }
    }
}
$action = isset($_GET['action'])?strtolower($_GET['action']):'list';
$controller = isset($_GET['controller'])?str_replace(array('.','/'), '', strtolower($_GET['controller'])):'player';
$init = false;
if (file_exists("controller/$controller.php")){
	include "controller/$controller.php";
	$http_call = $controller.'_'.$action;
	if(function_exists($http_call)){
		$init = true;
	}
}
if(!$init){
	header("Status: 404 Not Found");
	echo "Page not found ($controller, $action)";
	exit(0);
}

function template($template, $data = array()){
	$template = "template/$template.php";
	if(!file_exists($template)){
		header("Status: 404 Not Found");
		echo "Template $template not found";
		exit(0);
	}
	extract($data);
	include $template;
}

function getRequestFloat($name, $default = 0){
	return isset($_REQUEST[$name])?(floatval($_REQUEST[$name])):$default;
}

function getRequestInt($name, $default = 0){
	return isset($_REQUEST[$name])?(floatval($_REQUEST[$name])):$default;
}
