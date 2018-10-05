<?php
require 'vendor/autoload.php';

use InstaSave\InstaSave;
use InstaSave\URL\URL;

$url = new URL('https://www.instagram.com/arash.taheri.24/');
$instaSave = new InstaSave($url);

$response = $instaSave->fetch();

header('Content-type: application\json');
echo json_encode($response);