<?php
define(DIRECTORY, $dir);
$act = $_REQUEST['act']==''?'index':$_REQUEST['act'];

define(ACT, $act);

if( $act!=null && function_exists( $act ) )
{
	$act();
}
else 
{
	header("content-type:text/html;charset=utf-8");
	echo '加载失败：模块不存在!';
}