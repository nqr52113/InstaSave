<?php
require 'vendor/autoload.php';

use InstaSave\InstaSave;
use InstaSave\URL\URL;

// try {
	$url = new URL('https://www.instagram.com/p/BojcMyygiT7/?explore=true');
	$url = new URL('https://www.instagram.com/9gag/');
	$url = new URL('https://www.instagram.com/9gasdasdasdasdasdasasdasdasdasdaajsldasag/');
	$instaSave = new InstaSave($url);

	$response = $instaSave->fetch();

	header('Content-type: application\json');
	echo json_encode($response);
// } catch (Exception $e) {
// 	var_dump($e->get);
// }
