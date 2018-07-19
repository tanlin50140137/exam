<?php
header('content-type:text/html;charset=utf-8');

function index()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function reset_u()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
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
function GetUserp()
{
	$usersname = GetUsersName();
	$row = db()->select('power')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_row();
	return $row['power'];
}
function adminfrom()
{
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
function menu()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function adminindex()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$wxfl = GetFenLai2(0);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function getkey()
{	
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
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
		GetFenLai($array['id'],$multiplier);
	}
	return $rows;
}
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
		GetFenLai3($array['id'],$multiplier);
	}
	return $rows;
}
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
			GetFenLai2($array['id'],$multiplier);
		}
	}
	else
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify {$where} ";
		$rows = db()->query($sql)->array_rows();
	}
	return $rows;
}
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
			GetFenLai4($array['id'],$multiplier);
		}
	}
	else
	{
		$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."fileclass {$where} ";
		$rows = db()->query($sql)->array_rows();
	}
	return $rows;
}
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
function SetShwoTotal()
{
	$spot = SPOT;
	
	$c = $_POST['c'];
	
	$path = base_url($spot.'settings/'.$spot.'org'.$spot.'nums');
	
	file_put_contents( $path, $c );	
}
function geturl()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
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
function examqm()
{
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	include 'subject/'.getThemeDir().'/common.php';
	
	$sql = ' select a.id,a.pid,a.title,a.sort,a.tariff,a.roomsets,a.descri,a.rule1,a.rule2,a.publitime,a.state,b.title as ify from '.PRE.'createroom as a,'.PRE.'classify as b where a.pid=b.id ';
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
	
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
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
			$str = '<font color="#cb10ea">正式考</font>';
		break;
	}
	return $str;
}
function getpay()
{
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
	
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function gethelp()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function getkey_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function addusers()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function geturl_update()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$power = GetUserp();
	
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'admin')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function file_classify()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function show_classify()
{
	$power = GetUserp();
	
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
function classify_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'fileclass')->where(array('id'=>$id))->get()->array_row();	
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function create_dts()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai3(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function conent_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);

	include 'subject/'.getThemeDir().'/common.php';

	$flRows1 = GetFenLai3(0,2);

	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function create_room()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function examqm_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include 'subject/'.getThemeDir().'/common.php';
	
	$row = db()->select('id,pid,title,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,state')->from(PRE.'createroom')->where(array('id'=>$id))->get()->array_row();

	if( $row['rule1'] != null )
	{
		$rule = unserialize($row['rule1']);
	}
	if( $row['rule2'] != null )
	{
		$rule2 = unserialize($row['rule2']);
	}
		
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function gettiku()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	$t = $_GET['t']==null?null:htmlspecialchars($_GET['t'],ENT_QUOTES);
	
	$power = GetUserp();

	$flRows1 = GetFenLai(0,2);
	
	$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
	if( $id != null )
	{
		$sql .= ' and b.id='.$id.' ';
	}
	if( $s != null )
	{
		$sql .= ' and (a.dry like "%'.$s.'%" or a.years like "%'.$s.'%" or a.booknames like "%'.$s.'%") ';
	}
	if( $t != null )
	{
		$sql .= ' and a.typeofs='.$t.' ';
	}
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by a.id desc limit '.$offset.','.$TotalShow.' ';
	$rows = db()->query($sql)->array_rows();
		
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function import_tiku()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function modify_import()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function gettiku_update()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'examination')->where(array('id'=>$id))->get()->array_row();
	
	$flRows1 = GetFenLai(0,2);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function batch_modification()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$exportflag = htmlspecialchars($_GET['exportflag'],ENT_QUOTES);
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	$t = $_GET['s']==null?null:htmlspecialchars($_GET['t'],ENT_QUOTES);
	
	$as = $_GET['a']==null?null:htmlspecialchars($_GET['a'],ENT_QUOTES);
	$bs = $_GET['b']==null?null:htmlspecialchars($_GET['b'],ENT_QUOTES);
	$values = array(strtotime($as),strtotime($bs));
	$a = min($values);
	$b = max($values);
	
	$power = GetUserp();
	$flRows1 = GetFenLai(0,2);
	
	if( $id != '' || $s!='' || ($a!=''&&$b!='') )
	{	
		
		$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
		if( $id != null )
		{
			$sql .= ' and b.id='.$id.' ';
		}
		if( $s != null )
		{
			$sql .= ' and (a.dry like "%'.$s.'%" or a.years like "%'.$s.'%" or a.booknames like "%'.$s.'%") ';
		}
		if( $t != null )
		{
			$sql .= ' and a.typeofs='.$t.' ';
		}
		if( $a!=''&&$b!='' )
		{
			$sql .= ' and a.publitime between '.$a.' and '.$b.' ';
		}
		$TotalRows = db()->query($sql)->array_nums();
		$TotalShow = GetFilePath();
		$TotalPage = ceil($TotalRows/$TotalShow);
		$page = $_GET['page']==null?1:$_GET['page'];
		if($page>=$TotalPage){$page=$TotalPage;}
		if($page<=1||!is_numeric($page)){$page=1;}
		$offset = ($page-1)*$TotalShow;
		
		$sql .= ' order by a.id desc limit '.$offset.','.$TotalShow.' ';
		$rows = db()->query($sql)->array_rows();
		
	}	
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
function batch_deleting()
{
	include 'subject/'.getThemeDir().'/common.php';
	
	$exportflag = htmlspecialchars($_GET['exportflag'],ENT_QUOTES);
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	$t = $_GET['s']==null?null:htmlspecialchars($_GET['t'],ENT_QUOTES);
	
	$as = $_GET['a']==null?null:htmlspecialchars($_GET['a'],ENT_QUOTES);
	$bs = $_GET['b']==null?null:htmlspecialchars($_GET['b'],ENT_QUOTES);
	$values = array(strtotime($as),strtotime($bs));
	$a = min($values);
	$b = max($values);
	
	$power = GetUserp();
	$flRows1 = GetFenLai(0,2);
	
	if( $id != '' || $s!='' || ($a!=''&&$b!='') )
	{	
		
		$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
		if( $id != null )
		{
			$sql .= ' and b.id='.$id.' ';
		}
		if( $s != null )
		{
			$sql .= ' and (a.dry like "%'.$s.'%" or a.years like "%'.$s.'%" or a.booknames like "%'.$s.'%") ';
		}
		if( $t != null )
		{
			$sql .= ' and a.typeofs='.$t.' ';
		}
		if( $a!=''&&$b!='' )
		{
			$sql .= ' and a.publitime between '.$a.' and '.$b.' ';
		}
		$TotalRows = db()->query($sql)->array_nums();
		$TotalShow = GetFilePath();
		$TotalPage = ceil($TotalRows/$TotalShow);
		$page = $_GET['page']==null?1:$_GET['page'];
		if($page>=$TotalPage){$page=$TotalPage;}
		if($page<=1||!is_numeric($page)){$page=1;}
		$offset = ($page-1)*$TotalShow;
		
		$sql .= ' order by a.id desc limit '.$offset.','.$TotalShow.' ';
		$rows = db()->query($sql)->array_rows();
		
	}
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
###############################################################################################
function BatchDeletingAll()
{
	$exportflag = htmlspecialchars($_GET['flag'],ENT_QUOTES);
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	$as = $_GET['a']==null?null:htmlspecialchars($_GET['a'],ENT_QUOTES);
	$bs = $_GET['b']==null?null:htmlspecialchars($_GET['b'],ENT_QUOTES);
	$values = array(strtotime($as),strtotime($bs));
	$a = min($values);
	$b = max($values);
		
	switch ( $exportflag )
	{
		case 1:
			db()->delete(PRE.'examination',array('pid'=>$id));
		break;
		case 2:
			db()->delete(PRE.'examination','(dry like "%'.$s.'%" or years like "%'.$s.'%" or booknames like "%'.$s.'%")');
		break;
		case 3:
			db()->delete(PRE.'examination','publitime between '.$a.' and '.$b.' ');
		break;
	}
	
	header('location:'.apth_url('?act=batch_deleting'));
}
function delete_batch()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'examination',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function DifferentiatedType()
{
	$haystack = array(OFFICEXLS,OFFICEXLSX,OFFICECSV);	
	$ext = $haystack[$_GET['ext']];
	
	if( $ext == OFFICEXLS || $ext == OFFICEXLSX )
	{
		BatchExport2();
	}
	else 
	{
		BatchExport();
	}
}
function BatchExport()
{	
	$haystack = array(OFFICEXLS,OFFICEXLSX,OFFICECSV);	
	$ext = $haystack[$_GET['ext']];
	
	ob_end_clean();
	
	Header( "Content-type: application/octet-stream "); 
	Header( "Accept-Ranges: bytes "); 
	if( $ext == OFFICEXLS || $ext == OFFICECSV )
	{
		Header( "Content-type:application/vnd.ms-excel "); 
	}
	elseif( $ext == OFFICEXLSX )
	{
		Header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	Header( "Content-Disposition:attachment;filename=".date('Y-m-ds').'.'.$ext); 
	
	$exportflag = htmlspecialchars($_GET['flag'],ENT_QUOTES);
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	$as = $_GET['a']==null?null:htmlspecialchars($_GET['a'],ENT_QUOTES);
	$bs = $_GET['b']==null?null:htmlspecialchars($_GET['b'],ENT_QUOTES);
	$values = array(strtotime($as),strtotime($bs));
	$a = min($values);
	$b = max($values);
		
	switch ( $exportflag )
	{
		case 1:
			$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
			if( $id != null )
			{
				$sql .= ' and b.id='.$id.' order by a.id asc ';
			}
			$rows = db()->query($sql)->array_rows();
		break;
		case 2:
			$rows = db()->select('*')->from(PRE.'examination')->where('(dry like "%'.$s.'%" or years like "%'.$s.'%" or booknames like "%'.$s.'%")')->order_by('id asc')->get()->array_rows();
		break;
		case 3:
			$rows = db()->select('*')->from(PRE.'examination')->where('publitime')->between(array($a,$b))->order_by('id asc')->get()->array_rows();
		break;
	}
	
	if(!empty($rows))
	{
		if( $ext != OFFICECSV )
		{	
			echo iconv("utf-8", "gbk", IDOFS)."\t".iconv("utf-8", "gbk", TYPEOFS)."\t".iconv("utf-8", "gbk", DRYS)."\t".iconv("utf-8", "gbk", OPTIONS)."\t".iconv("utf-8", "gbk", NUMBERS)."\t".iconv("utf-8", "gbk", ANSWERS)."\t".iconv("utf-8", "gbk", ANALYSIS)."\t".iconv("utf-8", "gbk", YEARS)."\t".iconv("utf-8", "gbk", BOOKNAMES)."\t".iconv("utf-8", "gbk", SUBTILES)."\t".iconv("utf-8", "gbk", CHAPTERS)."\t".iconv("utf-8", "gbk", HATS);
			foreach($rows as $k=>$v)
			{
				echo "\n";
	 			echo iconv("utf-8", "gbk",$v['id'])."\t".iconv("utf-8", "gbk",GetFourTypes2($v['typeofs']))."\t".iconv("utf-8", "gbk",$v['dry'])."\t".iconv("utf-8", "gbk",$v['options'])."\t".iconv("utf-8", "gbk",$v['numbers'])."\t".iconv("utf-8", "gbk",$v['answers'])."\t".iconv("utf-8", "gbk",str_replace(array(" ","　","\t","\n","\r",",","\b","\f","\t","\v","\s"),array('','','','','','','','','','',''),$v['analysis']))."\t".iconv("utf-8", "gbk",$v['years'])."\t".iconv("utf-8", "gbk",$v['booknames'])."\t".iconv("utf-8", "gbk",$v['subtitles'])."\t".iconv("utf-8", "gbk",$v['chapters'])."\t".iconv("utf-8", "gbk",$v['hats']);
			}
		}
		else
		{
			header('Content-Type:text/csv');
			
			echo iconv("utf-8", "gbk", IDOFS).",".iconv("utf-8", "gbk", TYPEOFS).",".iconv("utf-8", "gbk", DRYS).",".iconv("utf-8", "gbk", OPTIONS).",".iconv("utf-8", "gbk", NUMBERS).",".iconv("utf-8", "gbk", ANSWERS).",".iconv("utf-8", "gbk", ANALYSIS).",".iconv("utf-8", "gbk", YEARS).",".iconv("utf-8", "gbk", BOOKNAMES).",".iconv("utf-8", "gbk", SUBTILES).",".iconv("utf-8", "gbk", CHAPTERS).",".iconv("utf-8", "gbk", HATS);
			foreach($rows as $k=>$v)
			{
				echo "\n";
	 			echo iconv("utf-8", "gbk",$v['id']).",".iconv("utf-8", "gbk",GetFourTypes2($v['typeofs'])).",".iconv("utf-8", "gbk",$v['dry']).",".iconv("utf-8", "gbk",$v['options']).",".iconv("utf-8", "gbk",$v['numbers']).",".iconv("utf-8", "gbk",$v['answers']).",".iconv("utf-8", "gbk",str_replace(array(" ","　","\t","\n","\r",",","\b","\f","\t","\v","\s"),array('','','','','','','','','','',''),$v['analysis'])).",".iconv("utf-8", "gbk",$v['years']).",".iconv("utf-8", "gbk",$v['booknames']).",".iconv("utf-8", "gbk",$v['subtitles']).",".iconv("utf-8", "gbk",$v['chapters']).",".iconv("utf-8", "gbk",$v['hats']);
			}
			
		}
	}
	else
	{
		echo iconv("utf-8", "gbk", ONCHECKEDDATA);
	}     
}
function BatchExport2()
{
	require base_url('system/Classes/PHPExcel.php');
	require base_url('system/Classes/PHPExcel/IOFactory.php');
	require base_url('system/Classes/PHPExcel/Reader/Excel5.php');
	
	$haystack = array(OFFICEXLS,OFFICEXLSX,OFFICECSV);	
	$ext = $haystack[$_GET['ext']];
	
	$objPHPExcel = new PHPExcel();
	
	$filename = date('Ymdhs');
	ob_end_clean();
	
	if( $ext == $haystack[0] ){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.'.$ext.'"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');
	}elseif( $ext == $haystack[1] ){
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'.'.$ext.'"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');
	}elseif( $ext == $haystack[2] ){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.'.$ext.'"');
		header('Cache-Control: max-age=0');
	}
	
	$exportflag = htmlspecialchars($_GET['flag'],ENT_QUOTES);	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);	
	$as = $_GET['a']==null?null:htmlspecialchars($_GET['a'],ENT_QUOTES);
	$bs = $_GET['b']==null?null:htmlspecialchars($_GET['b'],ENT_QUOTES);
	$values = array(strtotime($as),strtotime($bs));
	$a = min($values);
	$b = max($values);
	
	switch ( $exportflag )
	{
		case 1:
			$sql = 'select b.title,a.id,a.pid,a.typeofs,a.dry,a.options,a.numbers,a.answers,a.analysis,a.years,a.booknames,a.subtitles,a.chapters,a.hats,a.publitime,a.state from '.PRE.'examination as a,'.PRE.'classify as b where a.pid=b.id';
			if( $id != null )
			{
				$sql .= ' and b.id='.$id.' order by a.id asc ';
			}
			$rows = db()->query($sql)->array_rows();
		break;
		case 2:
			$rows = db()->select('*')->from(PRE.'examination')->where('(dry like "%'.$s.'%" or years like "%'.$s.'%" or booknames like "%'.$s.'%")')->order_by('id asc')->get()->array_rows();
		break;
		case 3:
			$rows = db()->select('*')->from(PRE.'examination')->where('publitime')->between(array($a,$b))->order_by('id asc')->get()->array_rows();
		break;
	}
	
	$code = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','S','Y','Z');
	$i = 2;
	
	$objPHPExcel->getActiveSheet()->setTitle(PILIANGXIUGAIBIAO);	
	$objPHPExcel->getActiveSheet()->setCellValue($code[0].'1', IDOFS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[1].'1', TYPEOFS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[2].'1', DRYS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[3].'1', OPTIONS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[4].'1', NUMBERS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[5].'1', ANSWERS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[6].'1', ANALYSIS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[7].'1', YEARS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[8].'1', BOOKNAMES);
	$objPHPExcel->getActiveSheet()->setCellValue($code[9].'1', SUBTILES);
	$objPHPExcel->getActiveSheet()->setCellValue($code[10].'1', CHAPTERS);
	$objPHPExcel->getActiveSheet()->setCellValue($code[11].'1', HATS);
	
	foreach( $rows as $k => $v )
	{	
		$objPHPExcel->getActiveSheet()->setCellValue($code[0].$i, $v['id']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[1].$i, GetFourTypes2($v['typeofs']));
		$objPHPExcel->getActiveSheet()->setCellValue($code[2].$i, $v['dry']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[3].$i, str_replace('-','&', $v['options']));
		$objPHPExcel->getActiveSheet()->setCellValue($code[4].$i, $v['numbers']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[5].$i, $v['answers']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[6].$i, str_replace(array(" ","　","\t","\n","\r",",","\b","\f","\t","\v","\s"),array('','','','','','','','','','',''),$v['analysis']));
		$objPHPExcel->getActiveSheet()->setCellValue($code[7].$i, $v['years']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[8].$i, $v['booknames']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[9].$i, $v['subtitles']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[10].$i, $v['chapters']);
		$objPHPExcel->getActiveSheet()->setCellValue($code[11].$i, $v['hats']);
		
		$i++;
	}
	
	if( $ext == $haystack[0] )
	{
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,PHPEXCELXLS);
	}
	elseif( $ext == $haystack[1] )
	{
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,PHPEXCELXLSX);
	}
	elseif( $ext == $haystack[2] )
	{
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,PHPEXCELCSV);		
	}
	
	$objWriter->save('php://output');
		
}

function delete_tiku()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'examination',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function update_tiku()
{
	$id = $_POST['id']==null?null:htmlspecialchars($_POST['id'],ENT_QUOTES);
	$data['pid'] = $_POST['pid'];
	if( $data['pid'] == 0 )
	{
		echo '<script>alert("'.PERLISTFENLAI_1.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';exit;
	}
	$data['typeofs'] = $_POST['typeofs'];
	$data['dry'] = $_POST['dry'];
	if( $data['dry'] == '' )
	{
		echo '<script>alert("'.PERLISTFENLAI_2.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';exit;
	}
	$data['options'] = $_POST['options'];
	if( $data['options'] == '' )
	{
		echo '<script>alert("'.PERLISTFENLAI_3.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';exit;
	}
	$data['numbers'] = $_POST['numbers'];
	if( $data['numbers'] == '' )
	{
		echo '<script>alert("'.PERLISTFENLAI_4.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';exit;
	}
	$data['answers'] = $_POST['answers'];
	if( $data['answers'] == '' )
	{
		echo '<script>alert("'.PERLISTFENLAI_5.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';exit;
	}
	$data['analysis'] = $_POST['analysis'];
	$data['years'] = $_POST['years'];
	$data['booknames'] = $_POST['booknames'];
	$data['subtitles'] = $_POST['subtitles'];
	$data['chapters'] = $_POST['chapters'];
	$data['hats'] = $_POST['hats'];
	
	$int = db()->update(PRE.'examination', $data, array('id'=>$id) );
	if( $int )
	{
		header('location:'.apth_url('?act=gettiku'));
	}
	else 
	{
		echo '<script>alert("'.QUDATEONOK.'");location.href="'.apth_url('?act=gettiku_update&id='.$id.'&page='.$_POST['page']).'";</script>';
	}
}
function ImportExecution()
{
	$ExtFlag = $_POST['format'];
	$pid = $_POST['pid'];
	$file = $_FILES['file'];
	
	if( $file['error'] == 0 )
	{
		$extArr = explode('.', $file['name']);
		$ext = end( $extArr );
		$haystack = array(OFFICEXLS,OFFICEXLSX,OFFICECSV);
		if( !in_array($ext, $haystack) )
		{
			echo '<script>alert("'.FILEGESHIERROR_1.'");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
		}
		if( $haystack[$ExtFlag] != $ext )
		{
			echo '<script>alert("'.FILEGESHIERROR_2.'");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
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
		$id = trim($objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue());	
		$data['typeofs'] = GetFourTypes(trim($objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue()));	
		$data['dry'] = trim($objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue());
		$options = trim($objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue());		
		$data['options'] = str_replace(array(',','，','-','－',';','；','|','｜','#','&','!','！','*','$','%','^','@','?','？','~','+','*','/','.',' '),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'), trim($options));
		$data['numbers'] = trim($objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue());
		$data['answers'] = trim($objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue());
		$data['analysis'] = trim($objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue());
		$data['years'] = trim($objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue());
		$data['booknames'] = trim($objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue());
		$data['subtitles'] = trim($objPHPExcel->getActiveSheet()->getCell("J".$j)->getValue());
		$data['chapters'] = trim($objPHPExcel->getActiveSheet()->getCell("K".$j)->getValue());
		$data['hats'] = trim($objPHPExcel->getActiveSheet()->getCell("L".$j)->getValue());
		$data['publitime'] = time();
		
		$i = db()->update(PRE.'examination',$data,array('id'=>$id,'pid'=>$pid));
	}

	if( $i )
	{
		if(is_file($filename))
		{
			@unlink($filename);
		}
	}
	
	header('location:'.apth_url('?act=gettiku'));
}
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
			echo '<script>alert("'.FILEGESHIERROR_1.'");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
		}
		if( $haystack[$ExtFlag] != $ext )
		{
			echo '<script>alert("'.FILEGESHIERROR_2.'");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
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
		if( $options != '' )
		{
			$data['options'] = str_replace(array('&'),array('-'), trim($options));
		}
		else 
		{
			$data['options'] = '';
		}
		$data['numbers'] = trim($objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue());
		$data['answers'] = trim($objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue());
		$data['analysis'] = trim($objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue());
		$data['years'] = trim($objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue());
		$data['booknames'] = trim($objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue());
		$data['subtitles'] = trim($objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue());
		$data['chapters'] = trim($objPHPExcel->getActiveSheet()->getCell("J".$j)->getValue());
		$data['hats'] = trim($objPHPExcel->getActiveSheet()->getCell("K".$j)->getValue());
		$data['publitime'] = time();
		
		if( $data['typeofs'] != '' )
		{
			$int = db()->select('*')->from(PRE.'examination')->where(array('pid'=>$data['pid'],'typeofs'=>$data['typeofs'],'dry'=>$data['dry'],'options'=>$data['options'],'years'=>$data['years'],'booknames'=>$data['booknames']))->get()->array_nums();
				
			if( $int == 0 )
			{
				$i = db()->insert(PRE.'examination',$data);
			}
			else
			{
				$i = db()->update(PRE.'examination',$data,array('pid'=>$data['pid'],'typeofs'=>$data['typeofs'],'dry'=>$data['dry'],'options'=>$data['options'],'years'=>$data['years'],'booknames'=>$data['booknames']));
			}
		}
	}

	if( $i )
	{
		if(is_file($filename))
		{
			@unlink($filename);
		}
	}
	
	header('location:'.apth_url('?act=gettiku'));	
}
function GetFourTypes($str)
{
	$strArr = array('单选题'=>1,'多选题'=>2,'判断题'=>3,'问答题'=>4);
	return $strArr[$str];
}
function GetFourTypes2($str)
{
	$strArr = array('1'=>'单选题','2'=>'多选题','3'=>'判断题','4'=>'问答题');
	return $strArr[$str];
}
function delete_exam()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'createroom',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function update_room()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['tariff'] = $_POST['tariff'];
	if( $data['tariff'] == 1 )
	{
		$value = $_POST;
		$data['rule1'] = serialize($value);
	}
	else
	{
		$data['rule1'] = '';
	}
	
	$data['roomsets'] = $_POST['roomsets'];
	if( $data['roomsets'] == 1 )
	{
		$rule2['roomsets'] = $_POST['roomsets'];
		$rule2['times'] = $_POST['times'];
		$rule2['typeofs'] = $_POST['typeofs'];
		$rule2['extracts'] = $_POST['extracts'];
		$rule2['chouti'] = $_POST['chouti'];
		$rule2['totalexam'] = $_POST['totalexam'];
		$rule2['totalscore'] = $_POST['totalscore'];
		$rule2['passscore'] = $_POST['passscore'];
		$data['rule2'] = serialize($rule2);
	}
	else
	{
		$data['rule2'] = '';
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
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
		
	$int = db()->update(PRE.'createroom',$data,array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>QUDATEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>QUDATEONOK));
	}
}
function add_room()
{
	$data['tariff'] = $_POST['tariff'];
	if( $data['tariff'] == 1 )
	{
		$value = $_POST;
		$data['rule1'] = serialize($value);
	}
	else
	{
		$data['rule1'] = '';
	}
	
	$data['roomsets'] = $_POST['roomsets'];
	if( $data['roomsets'] == 1 )
	{
		$rule2['roomsets'] = $_POST['roomsets'];
		$rule2['times'] = $_POST['times'];
		$rule2['typeofs'] = $_POST['typeofs'];
		$rule2['extracts'] = $_POST['extracts'];
		$rule2['chouti'] = $_POST['chouti'];
		$rule2['totalexam'] = $_POST['totalexam'];
		$rule2['totalscore'] = $_POST['totalscore'];
		$rule2['passscore'] = $_POST['passscore'];
		$data['rule2'] = serialize($rule2);
	}
	else
	{
		$data['rule2'] = '';
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
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
		
	$int = db()->insert(PRE.'createroom',$data);
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>ADDYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>ADDONOK));
	}
}
function delete_conent()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	$int = db()->delete(PRE.'createdts',array('id'=>$id));
	if( $int )
	{
		if( is_file( $_SERVER['DOCUMENT_ROOT'].$row['covers'] ) )
		{
			unlink( $_SERVER['DOCUMENT_ROOT'].$row['covers'] );
		}		
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function update_dtsend()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$file = $_FILES['file'];
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_1.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['titleas'] = $_POST['titleas'];
	$data['pid'] = $_POST['ify'];
	if( $data['pid'] == '0' )
	{
		echo '<script>alert("'.PERLISTFENLAI_1.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
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
		echo '<script>alert("'.PERLISTINPUTTILE_2.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['state'] = $_POST['state'];
	
	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	$name = mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999);
	if( $file['error'] == 0 )
	{	
		$extArr = explode('.', $file['name']);
		$ext = end($extArr);
		$haystack = array('jpeg','jpg','png','gif','bmp');
		if( !in_array($ext, $haystack) )
		{
			echo '<script>alert("'.PERLISTINPUTTILE_3.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		if( $file['size'] > (1024*1024*2) )
		{
			echo '<script>alert("'.PERLISTINPUTTILE_4.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
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
	{
		$data['covers'] = $row['covers'];		
	}
	
	$int = db()->update(PRE.'createdts',$data,array('id'=>$id));
	if( $int )
	{
		header('location:'.apth_url('?act=getpay&page='.$_POST['page']));
	}
	else
	{
		echo '<script>alert("'.PERLISTINPUTTILE_5.'");location.href="'.apth_url('?act=create_dts').'";</script>';
	}
}
function create_dtsend()
{	
	$file = $_FILES['file'];
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_1.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
	}
	$data['titleas'] = $_POST['titleas'];
	$data['pid'] = $_POST['ify'];
	if( $data['pid'] == '0' )
	{
		echo '<script>alert("'.PERLISTFENLAI_1.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
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
		echo '<script>alert("'.PERLISTINPUTTILE_2.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
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
			echo '<script>alert("'.PERLISTINPUTTILE_3.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
		}
		if( $file['size'] > (1024*1024*2) )
		{
			echo '<script>alert("'.PERLISTINPUTTILE_4.'");location.href="'.apth_url('?act=create_dts').'";</script>';exit;
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
		echo '<script>alert("'.PERLISTINPUTTILE_5.'");location.href="'.apth_url('?act=create_dts').'";</script>';
	}
}
function RecordTreeDisplay()
{
	$spot = SPOT;
	$filename = base_url($spot.'settings/'.$spot.'org'.$spot.'shu');
	
	file_put_contents($filename, $_POST['flag']);
}
function delete_classify()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
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
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function dclaexe()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_1));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_3));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	$int = db()->update(PRE.'fileclass',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>QUDATEYESOK,'page'=>$_POST['page']));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>QUDATEONOK));
	}
}
function add_classify()
{
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_1));exit;
	}
	$int = db()->select('*')->from(PRE.'fileclass')->where(array('title'=>$data['title']))->get()->array_nums();
	if( $int > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_2));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_3));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
		
	$int = db()->insert(PRE.'fileclass',$data);
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>ADDYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>ADDONOK));
	}
}
function delete_geturl()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'admin',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function delete_info()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'classify',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
}
function sbm_update()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_1));exit;
	}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_3));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	$int = db()->update(PRE.'classify',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>QUDATEYESOK,'page'=>$_POST['page']));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>QUDATEONOK));
	}
}
function form_sbm()
{
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_1));exit;
	}
	//$int = db()->select('*')->from(PRE.'classify')->where(array('title'=>$data['title']))->get()->array_nums();
	//if( $int > 0 )
	//{
	//	echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_2));exit;
	//}
	$data['sort'] = $_POST['sort'];
	if( $data['sort'] === '' )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAIS_3));exit;
	}
	$data['pid'] = $_POST['pid'];
	$data['descri'] = $_POST['descri'];
	$data['state'] = $_POST['state'];
	$data['publitime'] = time();
	
	$int = db()->insert(PRE.'classify',$data);
	if( $int )
	{	
		echo json_encode(array("error"=>0,'txt'=>ADDYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>ADDONOK));
	}
}
function form_logins()
{
	session_start();
	
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>FROMRESETSUS_1));exit;
	}
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users']))->get()->array_nums();
	if( $num == 0 )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>USERISEXST_2));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>FROMRESETSUS_3));exit;
	}

	$int = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users'],'pwd'=>$data['pwd']))->get()->array_nums();
	if( $int )
	{	
		$_SESSION['usersname'] = $data['users'];
		
		echo json_encode(array('error'=>'0','txt'=>LOGINYESOK));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>LOGINONOK));
	}
}
function form_resets2()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>FROMRESETSUS_1));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>FROMRESETSUS_3));exit;
	}
	$data['tel'] = $_POST['t'];
	if( $data['tel'] == '' )
	{
		echo json_encode(array("error"=>1,f=>2,'txt'=>FROMRESETSUS_4));exit;
	}
	if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $data['tel']) )
	{
		echo json_encode(array("error"=>"1",f=>2,"txt"=>FROMRESETSUS_5));exit;
	}
	$data['email'] = $_POST['e'];
	if( $data['email'] == '' )
	{
		echo json_encode(array("error"=>1,f=>3,'txt'=>FROMRESETSUS_6));exit;
	}
	if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/",$data['email']) )
	{
		echo json_encode(array('error'=>'1',f=>3,'txt'=>FROMRESETSUS_7));exit;
	}
	$data['power'] = $_POST['power']==null?0:$_POST['power'];	

	$int = db()->update(PRE.'admin',$data,array('id'=>$id));
	if( $int )
	{	
		echo json_encode(array('error'=>'0','txt'=>QUDATEYESOK));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>QUDATEONOK));
	}
}
function form_resets()
{
	$data['users'] = htmlspecialchars($_POST['u'],ENT_QUOTES);
	if( $data['users'] == '' )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>USERISEXSTUS_1));exit;
	}
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$data['users']))->get()->array_nums();
	if( $num > 0 )
	{
		echo json_encode(array("error"=>1,f=>0,'txt'=>USERISEXSTUS_2));exit;
	}
	$data['pwd'] = mb_substr(md5(md5(base64_decode($_POST['p']))),0,10,'utf-8');
	if( $data['pwd'] == '' )
	{
		echo json_encode(array("error"=>1,f=>1,'txt'=>USERISEXSTUS_3));exit;
	}
	$data['tel'] = $_POST['t'];
	if( $data['tel'] == '' )
	{
		echo json_encode(array("error"=>1,f=>2,'txt'=>USERISEXSTUS_4));exit;
	}
	if(!preg_match("/^0?(13|14|15|17|18)[0-9]{9}$/", $data['tel']) )
	{
		echo json_encode(array("error"=>"1",f=>2,"txt"=>USERISEXSTUS_5));exit;
	}
	$data['email'] = $_POST['e'];
	if( $data['email'] == '' )
	{
		echo json_encode(array("error"=>1,f=>3,'txt'=>USERISEXSTUS_6));exit;
	}
	if( !preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/",$data['email']) )
	{
		echo json_encode(array('error'=>'1',f=>3,'txt'=>USERISEXSTUS_7));exit;
	}

	$sql = 'select picname from '.PRE.'apack order by rand() limit 0,1';
	$picrow = db()->query($sql)->array_row();
	$data['pic'] = $picrow['picname']==''?'':$picrow['picname'];
	$data['power'] = $_POST['power']==null?0:$_POST['power'];
	$data['publitime'] = time();	

	$int = db()->insert(PRE.'admin',$data);
	if( $int )
	{	
		echo json_encode(array('error'=>'0','txt'=>SETYESOK));
	}
	else
	{
		echo json_encode(array('error'=>'1','txt'=>SETONOK));
	}
}
function checked_selects()
{
	$u = htmlspecialchars($_POST['u'],ENT_QUOTES);
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$u))->get()->array_nums();
	if( $num > 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>USERISEXST_1));
	}
	else
	{
		echo json_encode(array("error"=>0,'txt'=>USERISEXST_2));
	}
}
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
function log_on()
{	
	session_start();
	$_SESSION['usersname'] = null;
	unset($_SESSION['usersname']);
	
	header("location:".apth_url(''));
}