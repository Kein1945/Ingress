<?php

global $db, $action, $controller;

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

include 'mysql.php';
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
