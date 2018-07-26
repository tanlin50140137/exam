<?php
$SET_PHP = 'SET_URI';
require '.setting_uri.php';
require 'public_include.php';
require 'system/index_module.php';
define(LIST_ID, $_GET['id']);
load_theme( getThemeDir() );