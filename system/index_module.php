<?php
header('content-type:text/html;charset=utf-8');
/**
 * 所有模块必须写在函数里
 * */
#主页面 , Ready to start work (准备开始工作)
function index()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#注册
function reset_u()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#获取用户名
function GetUsersName()
{
	session_start();
	if( !isset( $_SESSION['usersname'] ) || $_SESSION['usersname']==null )
	{
		header('location:'.apth_url(''));exit;
	}		
	$usersname = $_SESSION['usersname'];
	return $usersname;
}
#获取用户身份
function GetUserp()
{
	$usersname = GetUsersName();
	$row = db()->select('power')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_row();
	return $row['power'];
}
#后台框架
function adminfrom()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
		
	$usersname = GetUsersName();
	
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_nums();
	if( $num == 0 )
	{
		header('location:'.apth_url(''));exit;
	}
	
	$row = db()->select('*')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_row();
		
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#菜单栏
function menu()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#后台首页面
function adminindex()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#无限级别分类
	$wxfl = GetFenLai2(0);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#获取KEY
function getkey()
{	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	#获取数据
	$flRows1 = GetFenLai(0,2);
	$flRows2 = GetFenLai2(0,2,$id);
	$TotalRows = count($flRows2);
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if( $page >= $TotalPage ){ $page=$TotalPage; }
	if( $page<=1 || !is_numeric( $page ) ){ $page=1; }
	$offset = ($page-1)*$TotalShow;
	if( !empty( $flRows2 ) )
	{
		$rows = array_slice($flRows2, $offset, $TotalShow);
	}
	$flag = GetFilePath2();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#无限级别分类
function GetFenLai($pid,$multiplier=0)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$multiplier = $rows==null?0:$multiplier+2;
	$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify where pid={$pid}";
	$rs = mysql_query($sql);
	while ($array = mysql_fetch_assoc($rs))
	{
		$array['title'] = str_repeat('&nbsp;', $multiplier).'|－'.$array['title'];
		$rows[] = $array;
		GetFenLai($array['id'],$multiplier);//递归
	}
	return $rows;
}
#无限级别分类
function GetFenLai3($pid,$multiplier=0)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$multiplier = $rows==null?0:$multiplier+2;
	$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."fileclass where pid={$pid}";
	$rs = mysql_query($sql);
	while ($array = mysql_fetch_assoc($rs))
	{
		$array['title'] = str_repeat('&nbsp;', $multiplier).'|－'.$array['title'];
		$rows[] = $array;
		GetFenLai3($array['id'],$multiplier);//递归
	}
	return $rows;
}
#无限级别分类
function GetFenLai2($pid,$multiplier=0,$id=null)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$where = $id==null?'':" where id='{$id}' ";
	if( $where == null )
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify where pid={$pid} ";
		$rs = mysql_query($sql);
		while ($array = mysql_fetch_assoc($rs))
		{
			$rows[] = $array;
			GetFenLai2($array['id'],$multiplier);//递归
		}
	}
	else
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify {$where} ";
		$rows = db()->query($sql)->array_rows();
	}
	return $rows;
}
#无限级别分类
function GetFenLai4($pid,$multiplier=0,$id=null)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."fileclass")->get()->array_nums();
	
	$where = $id==null?'':" where id='{$id}' ";
	if( $where == null )
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."fileclass where pid={$pid} ";
		$rs = mysql_query($sql);
		while ($array = mysql_fetch_assoc($rs))
		{
			$rows[] = $array;
			GetFenLai4($array['id'],$multiplier);//递归
		}
	}
	else
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."fileclass {$where} ";
		$rows = db()->query($sql)->array_rows();
	}
	return $rows;
}
#状态
function GetState( $int )
{
	switch ( $int )
	{
		case 0:
			$str = '显示';
		break;
		case 1:
			$str = '<font color="red">隐藏</font>';
		break;
	}
	return $str;
}
function GetState2( $int , $id, $page)
{
	switch ( $int )
	{
		case 0:
			$str = '发布';
		break;
		case 1:
			$str = '<a href="'.apth_url('?act=conent_update&id='.$id.'&page='.$page).'">[草稿箱]</a>';
		break;
	}
	return $str;
}
#记录显示条数
function SetShwoTotal()
{
	$spot = SPOT;
	
	$c = $_POST['c'];//记录总数
	
	$path = base_url($spot.'settings/'.$spot.'org'.$spot.'nums');
	
	file_put_contents( $path, $c );	
}
#绑定域名
function geturl()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	#获取用户列表
	$sql  = ' select * from '.PRE.'admin ';
	if( $s!=null )
	{
		$sql .= ' where (users like "%'.$s.'%" or tel like "%'.$s.'%" or email like "%'.$s.'%") ';
	}
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by publitime desc limit '.$offset.','.$TotalShow.' ';	
	$rows = db()->query($sql)->array_rows();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#获取权限
function get_power($int)
{
	switch ( $int )
	{
		case 0:
			$str = '<font color="#FF0000">普通管理员</font>';
		break;
		case 1:
			$str = '<font color="#377d02">网站编辑员</font>';
		break;
		case 2:
			$str = '<font color="#0000FF">超级管理员</font>';
		break;
	}
	return $str;
}
function get_power2($int)
{
	switch ( $int )
	{
		case 0:
			$str = '普通管理员';
		break;
		case 1:
			$str = '网站编辑员';
		break;
		case 2:
			$str = '超级管理员';
		break;
	}
	return $str;
}
#考题管理
function examqm()
{
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#获取考场
	$sql = ' select a.id,a.pid,a.title,a.sort,a.tariff,a.setting,a.descri,a.rule,a.publitime,a.state,b.title as ify from '.PRE.'createroom as a,'.PRE.'classify as b where a.pid=b.id ';
	if( $id != '' )
	{
		$sql .= ' and b.id='.$id.' ';
	}
	if( $s!=null )
	{
		$sql .= ' and (a.title like "%'.$s.'%" or b.title like "%'.$s.'%") ';
	}
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by a.publitime desc limit '.$offset.','.$TotalShow.' ';	
	$rows = db()->query($sql)->array_rows();
	
	#获取数据
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#规则
function e_zfms($int)
{
	switch ($int)
	{
		case 0:
			$str = '<font color="#69b530">免费</font>';
		break;
		case 1:
			$str = '<font color="#ff9800">收费</font>';
		break;
	}
	return $str;
}
function e_exam($int)
{
	switch ($int)
	{
		case 0:
			$str = '<font color="#69b530">练习</font>';
		break;
		case 1:
			$str = '<font color="#cb10ea">历年真考</font>';
		break;
		case 2:
			$str = '<font color="#232222">随机模拟 </font>';
		break;
		case 3:
			$str = '<font color="#e94111">专家模拟</font>';
		break;
	}
	return $str;
}
#添值服务
function getpay()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	$sql  = ' select a.id,a.pid,a.title,a.titleas,a.tags,a.static_n,a.covers,a.publitime,a.timing,a.state,b.title as ify from '.PRE.'createdts as a,'.PRE.'fileclass as b where a.pid=b.id ';
	
	if( $id != 0 )
	{
		$sql  .= ' and  b.id='.$id.' ';
	}
	
	if( $s != '' )
	{
		$sql  .= ' and  (a.title like "%'.$s.'%" or b.title like "%'.$s.'%") ';
	}
	
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by publitime desc limit '.$offset.','.$TotalShow.' ';
	$rows = db()->query($sql)->array_rows();
	
	#分类
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#帮助中心
function gethelp()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#分类管理修改分类
function getkey_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#添加用户
function addusers()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#修改用户信息
function geturl_update()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'admin')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#创建文档分类
function file_classify()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#显示文档分类
function show_classify()
{
	$power = GetUserp();
	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$flRows1 = GetFenLai3(0,2);
	$flRows2 = GetFenLai4(0,0,$id);	
	$TotalRows = count($flRows2);
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	if( !empty( $flRows2 ) )
	{
		$rows = array_slice($flRows2, $offset, $TotalShow);
	}
	$flag = GetFilePath2();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#修改文档分类
function classify_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'fileclass')->where(array('id'=>$id))->get()->array_row();	
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#创建文档
function create_dts()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#修改文档
function conent_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	#分类
	$flRows1 = GetFenLai3(0,2);
	#获取信息
	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#创建考场
function create_room()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#获取数据
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#修改考场
function examqm_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#获取数据
	$row = db()->select('id,pid,title,sort,tariff,setting,descri,rule,publitime,state')->from(PRE.'createroom')->where(array('id'=>$id))->get()->array_row();
	#收费规则
	if( $row['rule'] != null )
	{
		$rule = unserialize($row['rule']);
	}
	#获取数据
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#题库管理
function gettiku()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$power = GetUserp();
	#获取数据
	$flRows1 = GetFenLai(0,2);
	
	$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
	
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by publitime desc limit '.$offset.','.$TotalShow.' ';
	$rows = db()->query($sql)->array_rows();
		
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#创建导入题库
function import_tiku()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#获取数据
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
###############################################################################################
#题库管理
function import_sends()
{
	$ExtFlag = $_POST['format'];
	$data['pid'] = $_POST['pid'];
	$file = $_FILES['file'];
	
	if( $file['error'] == 0 )
	{
		$extArr = explode('.', $file['name']);
		$ext = end( $extArr );
		$haystack = array(OFFICEXLS,OFFICEXLSX,OFFICECSV);
		if( !in_array($ext, $haystack) )
		{
			echo '<script>alert("文件格式有误");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
		}
		if( $haystack[$ExtFlag] != $ext )
		{
			echo '<script>alert("选择格式有误");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
		}
		$path = GetFilePath3();				
		if( !is_dir( $path ) )
		{
			mkdir($path,0777);
		}
		$destination = $path.'/'.SPOT.mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999).'.'.$ext;	
		move_uploaded_file($file['tmp_name'], $destination);
	}
	
	require base_url('system/Classes/PHPExcel.php');
	require base_url('system/Classes/PHPExcel/IOFactory.php');
	require base_url('system/Classes/PHPExcel/Reader/Excel5.php');
	
	$filename = $destination;
		
	if( $ExtFlag == 0 ){
		$objReader = PHPExcel_IOFactory::createReader(PHPEXCELXLS);
	}elseif( $ExtFlag == 1 ){
		$objReader = PHPExcel_IOFactory::createReader(PHPEXCELXLSX);
	}elseif( $ExtFlag == 2 ){
		$objReader = PHPExcel_IOFactory::createReader(PHPEXCELCSV)->setDelimiter(',')->setInputEncoding('GBK');
	}

	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($filename);
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow();

	for($j=2;$j<=$highestRow;$j++)
	{	
		$data['typeofs'] = GetFourTypes(trim($objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue()));	
		$data['dry'] = trim($objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue());
		$options = trim($objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue());		
		$data['options'] = str_replace(array(',','，','-','－',';','；','|','｜','#','&','!','！','*','$','%','^','@','?','？','~','+','*','/','.',' '),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'), trim($options));
		$data['numbers'] = trim($objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue());
		$data['answers'] = trim($objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue());
		$data['analysis'] = trim($objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue());
		$data['years'] = trim($objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue());
		$data['booknames'] = trim($objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue());
		$data['subtitles'] = trim($objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue());
		$data['chapters'] = trim($objPHPExcel->getActiveSheet()->getCell("J".$j)->getValue());
		$data['hats'] = trim($objPHPExcel->getActiveSheet()->getCell("K".$j)->getValue());
		$data['publitime'] = time();
		
		#检测是否存在
		$int = db()->select('*')->from(PRE.'examination')->where(array('pid'=>$data['pid'],'typeofs'=>$data['typeofs'],'dry'=>$data['dry'],'options'=>$data['options'],'years'=>$data['years'],'booknames'=>$data['booknames']))->get()->array_nums();
			
		if( $int == 0 )
		{#如何不存在添加
			db()->insert(PRE.'examination',$data);
		}
		else
		{#如何存在修改
			db()->update(PRE.'examination',$data,array('pid'=>$data['pid'],'typeofs'=>$data['typeofs'],'dry'=>$data['dry'],'options'=>$data['options'],'years'=>$data['years'],'booknames'=>$data['booknames']));
		}
	}
		
	#转入首页
	header('location:'.apth_url('?act=gettiku'));	
}
#获取四种题型
function GetFourTypes($str)
{
	$strArr = array('单选题'=>0,'多选题'=>1,'判断题'=>2,'问答题'=>3);
	return $strArr[$str];
}
#获取四种题型
function GetFourTypes2($str)
{
	$strArr = array('0'=>'单选题','1'=>'多选题','2'=>'判断题','3'=>'问答题');
	return $strArr[$str];
}
#删除考场
function delete_exam()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'createroom',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'删除成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'删除失败'));
	}
}
#修改考场
function update_room()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['tariff'] = $_POST['tariff'];
	if( $data['tariff'] == 1 )
	{#有设置规则
		$value = $_POST;
		$data['rule'] = serialize($value);//规则
	}
	else
	{#没有设置规则
		$data['rule'] = '';
	}
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$int = db()->select('*')->from(PRE.'fileclass')->where(array('title'=>$data['title']))->get()->array_nums();
	if( $int > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'分类名称已存在'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	if( $data['pid'] == 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'请选择分类'));exit;
	}
	$data['setting'] = $_POST['setting'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
		
	#记录数据
	$int = db()->update(PRE.'createroom',$data,array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'修改成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'修改失败'));
	}
}
#添加考场
function add_room()
{
	$data['tariff'] = $_POST['tariff'];
	if( $data['tariff'] == 1 )
	{#有设置规则
		$value = $_POST;
		$data['rule'] = serialize($value);//规则
	}
	else
	{#没有设置规则
		$data['rule'] = '';
	}
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$int = db()->select('*')->from(PRE.'fileclass')->where(array('title'=>$data['title']))->get()->array_nums();
	if( $int > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'分类名称已存在'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	if( $data['pid'] == 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'请选择分类'));exit;
	}
	$data['setting'] = $_POST['setting'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
		
	#记录数据
	$int = db()->insert(PRE.'createroom',$data);
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'添加成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'添加失败'));
	}
}
#删除文章
function delete_conent()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	#获取信息
	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	$int = db()->delete(PRE.'createdts',array('id'=>$id));
	if( $int )
	{
		if( is_file( $_SERVER['DOCUMENT_ROOT'].$row['covers'] ) )
		{
			unlink( $_SERVER['DOCUMENT_ROOT'].$row['covers'] );
		}		
		echo json_encode(array("error"=>0,'txt'=>'删除成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'删除失败'));
	}
}
#修改文章
function update_dtsend()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$file = $_FILES['file'];//封面
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("请输入标题");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['titleas'] = $_POST['titleas'];
	$data['pid'] = $_POST['ify'];
	if( $data['pid'] == '0' )
	{
		echo '<script>alert("请选择分类");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['depict'] = $_POST['depict'];
	$data['tags'] = $_POST['tags'];
	
	$timing = str_replace(array('－','：'),array('-',':'), $_POST['timing']);
	if( $timing != '' )
	{
		$data['timing'] = strtotime($timing); 
	}
	else
	{
		$data['timing'] = 0; 
	}
	$data['content'] = $_POST['content'];
	if( $data['content'] == '' )
	{
		echo '<script>alert("请选入内容");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['state'] = $_POST['state'];
	
	#获取信息
	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	$name = mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999);
	if( $file['error'] == 0 )
	{#有新图片上传	
		$extArr = explode('.', $file['name']);
		$ext = end($extArr);
		$haystack = array('jpeg','jpg','png','gif','bmp');
		if( !in_array($ext, $haystack) )
		{
			echo '<script>alert("封面格式不正确");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		if( $file['size'] > (1024*1024*2) )
		{
			echo '<script>alert("封面大小不能超出2M");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		
		$path = '/ueditor/php/upload/image/'.date('Ymd');				
		if( !is_dir( $_SERVER['DOCUMENT_ROOT'].$path ) )
		{
			mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777);
		}
				
		$destination = $path.'/'.$name.'.'.$ext;
		
		if( move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$destination) )
		{
			if( is_file( $_SERVER['DOCUMENT_ROOT'].$row['covers'] ) )
			{
				unlink( $_SERVER['DOCUMENT_ROOT'].$row['covers'] );
			}			
			$data['covers'] = $destination;
		}
		else
		{
			$data['covers'] = '';
		}
	}
	else
	{#没有图片上传
		$data['covers'] = $row['covers'];		
	}
	
	$int = db()->update(PRE.'createdts',$data,array('id'=>$id));
	if( $int )
	{
		header('location:'.apth_url('?act=getpay&page='.$_POST['page']));
	}
	else
	{
		echo '<script>alert("文档创建失败");location.href="'.apth_url('?act=create_dts').'";</script>';
	}
}
#创建文章
function create_dtsend()
{	
	$file = $_FILES['file'];//封面
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("请输入标题");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['titleas'] = $_POST['titleas'];
	$data['pid'] = $_POST['ify'];
	if( $data['pid'] == '0' )
	{
		echo '<script>alert("请选择分类");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['depict'] = $_POST['depict'];
	$data['tags'] = $_POST['tags'];
	
	$timing = str_replace(array('－','：'),array('-',':'), $_POST['timing']);
	if( $timing != '' )
	{
		$data['timing'] = strtotime($timing); 
	}
	else
	{
		$data['timing'] = 0; 
	}
	$data['content'] = $_POST['content'];
	if( $data['content'] == '' )
	{
		echo '<script>alert("请选入内容");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['state'] = $_POST['state'];
	
	$name = mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999);
	
	if( $file['error'] == 0 )
	{
		$extArr = explode('.', $file['name']);
		$ext = end($extArr);
		$haystack = array('jpeg','jpg','png','gif','bmp');
		if( !in_array($ext, $haystack) )
		{
			echo '<script>alert("封面格式不正确");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		if( $file['size'] > (1024*1024*2) )
		{
			echo '<script>alert("封面大小不能超出2M");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		
		$path = '/ueditor/php/upload/image/'.date('Ymd');				
		if( !is_dir( $_SERVER['DOCUMENT_ROOT'].$path ) )
		{
			mkdir($_SERVER['DOCUMENT_ROOT'].$path,0777);
		}
				
		$destination = $path.'/'.$name.'.'.$ext;
		
		if( move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$destination) )
		{
			$data['covers'] = $destination;
		}
		else
		{
			$data['covers'] = '';
		}
	}
	$data['static_n'] = $name;
	$data['publitime'] = time();
	
	$int = db()->insert(PRE.'createdts',$data);
	if( $int )
	{
		header('location:'.apth_url('?act=getpay'));
	}
	else
	{
		echo '<script>alert("文档创建失败");location.href="'.apth_url('?act=create_dts').'";</script>';
	}
}
#记录树型显示
function RecordTreeDisplay()
{
	$spot = SPOT;
	$filename = base_url($spot.'settings/'.$spot.'org'.$spot.'shu');
	
	file_put_contents($filename, $_POST['flag']);
}
#删除文档分类
function delete_classify()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	#获取信息
	$rows = db()->select('*')->from(PRE.'createdts')->where(array('pid'=>$id))->get()->array_rows();
	if( !empty( $rows ) )
	{
		foreach( $rows as $k => $v )
		{
			if( is_file( $_SERVER['DOCUMENT_ROOT'].$v['covers'] ) )
			{
				unlink( $_SERVER['DOCUMENT_ROOT'].$v['covers'] );
			}	
			
		}
	}
	
	$int = db()->delete(PRE.'fileclass',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'删除成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'删除失败'));
	}
}
#修改文档分类
function dclaexe()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	#修改数据
	$int = db()->update(PRE.'fileclass',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>'修改成功','page'=>$_POST['page']));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'修改失败'));
	}
}
#添加文档分类
function add_classify()
{
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$int = db()->select('*')->from(PRE.'fileclass')->where(array('title'=>$data['title']))->get()->array_nums();
	if( $int > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'分类名称已存在'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
		
	#记录数据
	$int = db()->insert(PRE.'fileclass',$data);
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'添加成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'添加失败'));
	}
}
#删除用户
function delete_geturl()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'admin',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'删除成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'删除失败'));
	}
}
#删除分类
function delete_info()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'classify',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>'删除成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'删除失败'));
	}
}
#修改分类
function sbm_update()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	#修改数据
	$int = db()->update(PRE.'classify',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>'修改成功','page'=>$_POST['page']));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'修改失败'));
	}
}
#添加分类
function form_sbm()
{
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类名称'));exit;
	}
	$int = db()->select('*')->from(PRE.'classify')->where(array('title'=>$data['title']))->get()->array_nums();
	if( $int > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>'分类名称已存在'));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>'请输入分类排序'));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	//print_r($data);exit;
	
	#记录数据
	$int = db()->insert(PRE.'classify',$data);
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>'添加成功'));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>'添加失败'));
	}
}
#用户登录
function form_logins()
{
	session_start();
	
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>'*请输入帐号*'));exit;
	}
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users']))->get()->array_nums();
	if( $num == 0 )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>'*帐号未注册*'));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>'*请输入密码*'));exit;
	}
	#会员登录 
	$int = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users'],'pwd'=>$data['pwd']))->get()->array_nums();
	if( $int )
	{	
		$_SESSION['usersname'] = $data['users'];
		
		echo json_encode(array('error'=>'0','txt'=>'登录成功'));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>'登录失败'));
	}
}
#用户修改用户信息
function form_resets2()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>'*请输入帐号*'));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>'*请输入密码*'));exit;
	}
	$data['tel'] = $_POST['t'];
	if( $data['tel'] == '' )
	{
		echo json_encode(array("error"=>1,f=>2,'txt'=>'*请输入手机*'));exit;
	}
	if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $data['tel']) )
	{
		echo json_encode(array("error"=>"1",f=>2,"txt"=>"*手机号错误*"));exit;
	}
	$data['email'] = $_POST['e'];
	if( $data['email'] == '' )
	{
		echo json_encode(array("error"=>1,f=>3,'txt'=>'*请输入邮箱*'));exit;
	}
	if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/",$data['email']) )
	{
		echo json_encode(array('error'=>'1',f=>3,'txt'=>'*邮箱不正确*'));exit;
	}
	$data['power'] = $_POST['power']==null?0:$_POST['power'];	
	//修改
	$int = db()->update(PRE.'admin',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array('error'=>'0','txt'=>'修改成功'));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>'修改失败'));
	}
}
#用户提交注册
function form_resets()
{
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>'*请输入帐号*'));exit;
	}
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users']))->get()->array_nums();
	if( $num > 0 )
	{#检测帐号
		echo json_encode(array("error"=>1,f=>0,'txt'=>'*帐号已存在*'));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>'*请输入密码*'));exit;
	}
	$data['tel'] = $_POST['t'];
	if( $data['tel'] == '' )
	{
		echo json_encode(array("error"=>1,f=>2,'txt'=>'*请输入手机*'));exit;
	}
	if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $data['tel']) )
	{
		echo json_encode(array("error"=>"1",f=>2,"txt"=>"*手机号错误*"));exit;
	}
	$data['email'] = $_POST['e'];
	if( $data['email'] == '' )
	{
		echo json_encode(array("error"=>1,f=>3,'txt'=>'*请输入邮箱*'));exit;
	}
	if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/",$data['email']) )
	{
		echo json_encode(array('error'=>'1',f=>3,'txt'=>'*邮箱不正确*'));exit;
	}
	#获取随机头像
	$sql = 'select picname from '.PRE.'apack order by rand() limit 0,1';
	$picrow = db()->query($sql)->array_row();
	$data['pic'] = $picrow['picname']==''?'':$picrow['picname'];
	$data['power'] = $_POST['power']==null?0:$_POST['power'];
	$data['publitime'] = time();	
	//注册
	$int = db()->insert(PRE.'admin',$data);
	if( $int )
	{	
		echo json_encode(array('error'=>'0','txt'=>'注册成功'));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>'注册失败'));
	}
}
function checked_selects()
{
	$u = htmlspecialchars($_POST['u'],ENT_QUOTES);
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$u))->get()->array_nums();
	if( $num > 0 )
	{#检测帐号
		echo json_encode(array("error"=>1,'txt'=>'*帐号已存在*'));
	}
	else
	{
		echo json_encode(array("error"=>0,'txt'=>'*帐号未注册*'));
	}
}
#获取key
function GetOpenId()
{
	$f = $_POST['flag'];
	switch ($f)
	{
		case 1:
			$keys = date('YmdHis').mt_rand(100000,999999);
		break;
		case 2:
			$keys = md5(uniqid('',microtime(true)));
		break;
	}
	echo $keys;
}
#注销用户
function log_on()
{
	#注销用户信息	
	session_start();
	$_SESSION['usersname'] = null;
	unset($_SESSION['usersname']);
	
	#返回用户登录
	header("location:".apth_url(''));
}