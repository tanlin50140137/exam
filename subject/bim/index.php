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
	echo ERRORTISHIZH_CN_3;
}