<?php
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */