<?php
/**
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * @abstract 自主开发框架，本框架已经实现低冗余、高性能、高可用性，问题少，逻辑强、高稳定。
 */
$SET_PHP = 'SET_URI';
require '.setting_uri.php';
require 'public_include.php';
require 'system/index_module.php';
define(LIST_ID, $_GET['id']);
load_theme( getThemeDir() );