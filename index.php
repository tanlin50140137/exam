<?php
/**
 * 手机入口文件
 * */
require 'public_include.php';
require 'system/index_module.php';

define(LIST_ID, $_GET['id']);

load_theme( getThemeDir() );