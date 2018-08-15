<?php
/**
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 */
$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
$URI = substr($SCRIPT_NAME, 0,strrpos($SCRIPT_NAME, '/') );
define("SITE_URL", $sys_protocal.$_SERVER['HTTP_HOST'].$URI);
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].$URI);
define("BOOLS", true);
define("OFFICEXLS","xls");
define("OFFICEXLSX","xlsx");
define("OFFICECSV","csv");
define("PHPEXCELXLS", "Excel5");
define("PHPEXCELXLSX", "Excel2007");
define("PHPEXCELCSV", "CSV");
define("ALL_ROOTS", $_SERVER['DOCUMENT_ROOT']);
$apth = str_replace(array('\\',$_SERVER['DOCUMENT_ROOT']), array('/',$sys_protocal.$_SERVER['HTTP_HOST']),dirname(dirname(dirname(__FILE__))));
define("APTH_URL", $apth);
define("DIR_URL", $_SERVER['DOCUMENT_ROOT'].str_replace($sys_protocal.$_SERVER['HTTP_HOST'], '', APTH_URL));
date_default_timezone_set('PRC');
set_ini_error('ON');
ini_set('session.gc_maxlifetime', 3600*4);
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */