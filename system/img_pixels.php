<?php
require 'pixels.php';

$arr = explode('/', $_SERVER['REQUEST_URI']);
if(!empty($arr))
{
	array_pop($arr);
	$site_url = join('/',$arr);
}

$imgPath = $_REQUEST['dir'];

$width = $_REQUEST['x']==''?0:$_REQUEST['x'];
$height = $_REQUEST['y']==''?0:$_REQUEST['y'];

$img = new Imagecreate($imgPath,$width,$height);