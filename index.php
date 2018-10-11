<?php
require 'vendor/autoload.php';

use InstaSave\InstaSave;
use InstaSave\URL\URL;

$url = new URL('https://www.instagram.com/p/BojcMyygiT7/?explore=true');
$url = new URL('https://www.instagram.com/9gag/');
$instaSave = new InstaSave($url);

$response = $instaSave->fetch();

header('Content-type: application\json');
echo json_encode($response);