<?php
/**
 * @author Tanlin
 * 配置文件
 * */
$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
################################################################################################
#全局变量
$arr = explode('/', $_SERVER['REQUEST_URI']);
if(!empty($arr))
{
	array_pop($arr);
	$site_url = join('/',$arr);
}
#当前
define("SITE_URL", $sys_protocal.$_SERVER['HTTP_HOST'].$site_url);#绝对路径url
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].$site_url);#绝对路径dir
define("SPOT", ".");
#全局路径
define("APTH_URL", 'http://127.0.0.1/exam');#绝对路径url
define("DIR_URL", $_SERVER['DOCUMENT_ROOT'].str_replace($sys_protocal.$_SERVER['HTTP_HOST'], '', APTH_URL));#绝对路径dir
################################################################################################
#网站时区
date_default_timezone_set('PRC');
#屏蔽错误提示信息,默认false不开启，true时开启
set_ini_error('ON');
################################################################################################
#资料服务器链接 

################################################################################################