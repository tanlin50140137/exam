<?php
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */