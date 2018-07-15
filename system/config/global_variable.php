<?php
/**
 * @author Tanlin
 * */
$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
################################################################################################
$arr = explode('/', $_SERVER['REQUEST_URI']);
if(!empty($arr))
{
	array_pop($arr);
	$site_url = join('/',$arr);
}
define("SITE_URL", $sys_protocal.$_SERVER['HTTP_HOST'].$site_url);
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].$site_url);
define("SPOT", ".");
define("OFFICEXLS", "xls");
define("OFFICEXLSX", "xlsx");
define("OFFICECSV", "csv");
define("PHPEXCELXLS", "Excel5");
define("PHPEXCELXLSX", "Excel2007");
define("PHPEXCELCSV", "CSV");
define("APTH_URL", 'http://127.0.0.1/exam');
define("DIR_URL", $_SERVER['DOCUMENT_ROOT'].str_replace($sys_protocal.$_SERVER['HTTP_HOST'], '', APTH_URL));
################################################################################################
date_default_timezone_set('PRC');
set_ini_error('ON');
################################################################################################
################################################################################################