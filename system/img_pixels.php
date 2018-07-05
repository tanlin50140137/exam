<?php
require 'pixels.php';

$arr = explode('/', $_SERVER['REQUEST_URI']);
if(!empty($arr))
{
	array_pop($arr);
	$site_url = join('/',$arr);
}

$imgPath = $_REQUEST['dir'];
/*
$u = str_replace(array('/','.'), array('\/','\.'), 'http://'.$_SERVER['HTTP_HOST'].'/'.$arr[1]);

if(preg_match("/$u/i", $dir ))
{#绝对链接时
	$imgPath = str_replace(APTH_URL, DIR_URL, $dir);
}
else
{#相对链接时
	$imgPath = $_SERVER['DOCUMENT_ROOT'].$dir;
}	
*/
$width = $_REQUEST['x']==''?0:$_REQUEST['x'];
$height = $_REQUEST['y']==''?0:$_REQUEST['y'];

$img = new Imagecreate($imgPath,$width,$height);