<?php
/**
 * @author Tanlin 
 * */
$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
$URI = substr($SCRIPT_NAME, 0,strrpos($SCRIPT_NAME, '/') );
define("SITE_URL", $sys_protocal.$_SERVER['HTTP_HOST'].$URI);
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].$URI);
define("SPOT", ".");
define("BOOLS", true);
define("OFFICEXLS","xls");
define("OFFICEXLSX","xlsx");
define("OFFICECSV","csv");
define("PHPEXCELXLS", "Excel5");
define("PHPEXCELXLSX", "Excel2007");
define("PHPEXCELCSV", "CSV");
define("ALL_ROOTS", $_SERVER['DOCUMENT_ROOT']);
define("APTH_URL", 'http://127.0.0.1/exam');
define("DIR_URL", $_SERVER['DOCUMENT_ROOT'].str_replace($sys_protocal.$_SERVER['HTTP_HOST'], '', APTH_URL));
date_default_timezone_set('PRC');
set_ini_error('ON');