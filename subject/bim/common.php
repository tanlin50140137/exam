<?php
###################################################################################################
###################################################################################################
##																							     ##
## @author TanLin Email:50140137@qq.com Tel:18677197764 V.0725 自主开发框架，稳定无问题，逻辑性强。 ##
## 																								 ##
###################################################################################################
###################################################################################################
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */

$bools = is_file(DIR_URL.'/system/config/config.php');

if( !$bools ) header( 'location:'.apth_url('index.php/InstallEnable') );