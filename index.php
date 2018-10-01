<?php
require 'vendor/autoload.php';

use InstaSave\InstaSave;
use InstaSave\Providers\URL;

$url = new URL('https://www.instagram.com/tv/BkQjCfsBIzi/');
$instaSave = new InstaSave($url);

var_dump($instaSave->fetch());