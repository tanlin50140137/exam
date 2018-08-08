<?php
/**
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 */
header('content-type:text/html;charset=utf-8');
function index()
{
	$int = array( GetIndexValue(1) ,SHOWINDEX_2);
	
	$s = sh_source( SHOWINDEX_1, BOOLS, $int );
	
	print( $s );
}
function reset_u()
{
	$int = array( GetIndexValue(1) ,SHOWRESET_2);
	
	$s = sh_source( SHOWRESET_1, BOOLS, $int );
	
	print( $s );
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
	include( getThemeDir3() );
		
	$usersname = GetUsersName();
	
	$num = db()->select('*')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_nums();
	if( $num == 0 )
	{
		header('location:'.apth_url(''));exit;
	}
	
	$row = db()->select('*')->from(PRE.'admin')->where(array('users'=>$usersname))->get()->array_row();		

	require( base_url_name( SHOWADMINFROM_1 ) );
}
function menu()
{
	include( getThemeDir3() );
	
	$power = GetUserp();
	
	require( base_url_name( SHOWMENU_1 ) );
}
function adminindex()
{
	include( getThemeDir3() );
	
	$wxfl = GetFenLai2_index(0);
	
	$totalfl = db()->select('*')->from(PRE.'classify')->get()->array_nums();
	$totalpfl = db()->select('*')->from(PRE.'classify')->where(array('pid'=>0))->get()->array_nums();
	$totalzfl = GetAllPfl();
	
	$totaltiku = db()->select('*')->from(PRE.'examination')->get()->array_nums();
	
	$totalkaoc = db()->select('*')->from(PRE.'createroom')->get()->array_nums();
	
	$totalzxfl = db()->select('*')->from(PRE.'fileclass')->get()->array_nums();
	$totalzxsl = db()->select('*')->from(PRE.'createdts')->get()->array_nums();
	
	$totalpu = db()->select('*')->from(PRE.'admin')->where(array('power'=>0))->get()->array_nums();
	$totalbu = db()->select('*')->from(PRE.'admin')->where(array('power'=>1))->get()->array_nums();
	
	require( base_url_name( SHOWADMININDEX_1 ) );
}
function GetAllPfl()
{
	$totalpfl = db()->select('*')->from(PRE.'classify')->where(array('pid'=>0))->get()->array_rows();
	foreach( $totalpfl as $k => $v )
	{
		$int = GetZiShenNums($v['id']);
	}
	return $int;
}
function GetZiShenNums($pid)
{
	static $count;
	$sql = 'select * from '.PRE.'classify where pid='.$pid;
	$rows1 = db()->query($sql)->array_rows();
	$count += count($rows1);
	foreach( $rows1 as $k => $v )
	{
		$sql = 'select * from '.PRE.'classify where pid='.$v['id'];
		$rows2 = db()->query($sql)->array_rows();
		$count += count($rows2);
		foreach( $rows2 as $k2 => $v2 )
		{
			GetZiShenNums($v2['id']);
		}
	}
	return $count;
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function getkey()
{	
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWGETKEY_1 ) );
}
function GetFenLai($pid,$multiplier=0)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$multiplier = $rows==null?0:$multiplier+2;
	$sql = "select id,pid,title,sort,descri,publitime,state,(select count(*) from ".PRE."createdts as b where b.pid=a.id) as c from ".PRE."classify as a where pid={$pid}";
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
function GetFenLai2_index($pid,$multiplier=0,$id=null)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$where = $id==null?'':" where id='{$id}' ";
	if( $where == null )
	{
		$sql = "select id,pid,title,sort,descri,publitime,state,(select count(*) from ".PRE."examination as b where b.pid=a.id) as exa from ".PRE."classify as a where pid={$pid} ";
		$rs = mysql_query($sql);
		while ($array = mysql_fetch_assoc($rs))
		{
			$rows[] = $array;
			GetFenLai2_index($array['id'],$multiplier);
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
		$sql = "select id,pid,title,sort,descri,publitime,state,(select count(*) from ".PRE."createdts as b where b.pid=a.id) as c from ".PRE."fileclass as a where pid={$pid} ";
		$rs = mysql_query($sql);
		while ($array = mysql_fetch_assoc($rs))
		{
			$rows[] = $array;
			GetFenLai4($array['id'],$multiplier);
		}
	}
	else
	{
		$sql = "select id,pid,title,sort,descri,publitime,state,(select count(*) from ".PRE."createdts as b where b.pid=a.id) as c from ".PRE."fileclass {$where} ";
		$rows = db()->query($sql)->array_rows();
	}
	return $rows;
}
function GetState( $int )
{
	switch ( $int )
	{
		case 0:
			$str = SHOWZH_CN_1;
		break;
		case 1:
			$str = '<font color="red">'.SHOWZH_CN_2.'</font>';
		break;
	}
	return $str;
}
function GetState2( $int , $id, $page)
{
	switch ( $int )
	{
		case 0:
			$str = SHOWZH_CN_3;
		break;
		case 1:
			$str = '<a href="'.apth_url('?act=conent_update&id='.$id.'&page='.$page).'">'.SHOWZH_CN_4.'</a>';
		break;
	}
	return $str;
}
function GetState3( $int , $id, $page)
{
	switch ( $int )
	{
		case 0:
			$str = SHOWZH_CN_3;
		break;
		case 1:
			$str = '<a href="'.apth_url('?act=notice_update&id='.$id.'&page='.$page).'">'.SHOWZH_CN_4.'</a>';
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
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWGETURL_1 ) );
}
function get_power($int)
{
	switch ( $int )
	{
		case 0:
			$str = '<font color="#FF0000">'.USERPRONAME_1.'</font>';
		break;
		case 1:
			$str = '<font color="#377d02">'.USERPRONAME_2.'</font>';
		break;
		case 2:
			$str = '<font color="#0000FF">'.USERPRONAME_3.'</font>';
		break;
	}
	return $str;
}
function get_power2($int)
{
	switch ( $int )
	{
		case 0:
			$str = USERPRONAME_1;
		break;
		case 1:
			$str = USERPRONAME_2;
		break;
		case 2:
			$str = USERPRONAME_3;
		break;
	}
	return $str;
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function e_xamqm()
{
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	include( getThemeDir3() );
	
	$sql = ' select a.id,a.pid,a.title,a.centreno,a.sort,a.tariff,a.roomsets,a.descri,a.rule1,a.rule2,a.publitime,a.state,b.title as ify from '.PRE.'createroom as a,'.PRE.'classify as b where a.pid=b.id ';
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
	
	require( base_url_name( SHOWEXAMQM_1 ) );
}
function e_zfms($int)
{
	switch ($int)
	{
		case 0:
			$str = '<font color="#69b530">'.MIANFEI_E_1.'</font>';
		break;
		case 1:
			$str = '<font color="#ff9800">'.MIANFEI_E_2.'</font>';
		break;
	}
	return $str;
}
function e_exam($int)
{
	switch ($int)
	{
		case 0:
			$str = '<font color="#69b530">'.MIANFEI_B_1.'</font>';
		break;
		case 1:
			$str = '<font color="#cb10ea">'.MIANFEI_B_2.'</font>';
		break;
	}
	return $str;
}
function getpay()
{
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWGETPAY_1 ) );
}
function notice_list()
{
	include( getThemeDir3() );
	
	$power = GetUserp();
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	$s = $_GET['s']==null?null:htmlspecialchars($_GET['s'],ENT_QUOTES);
	
	$sql  = ' select id,centreno,title,content,static_n,publitime,state from '.PRE.'notice';
	
	if( $id != 0 )
	{
		$sql  .= ' where  centreno="'.$id.'" ';
	}
	
	if( $s != '' )
	{
		$sql  .= ' where  (title like "%'.$s.'%") ';
	}
	
	$TotalRows = db()->query($sql)->array_nums();
	$TotalShow = GetFilePath();
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if($page>=$TotalPage){$page=$TotalPage;}
	if($page<=1||!is_numeric($page)){$page=1;}
	$offset = ($page-1)*$TotalShow;
	
	$sql .= ' order by publitime desc limit '.$offset.','.$TotalShow.' ';
	$rows = db()->query( $sql )->array_rows();
	
	$flRows1 = db()->select('*')->from(PRE.'createroom')->get()->array_rows();
	
	require( base_url_name( SHOWNOTICES_1 ) );
}
function notice_update()
{
	include( getThemeDir3() );
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$sql = 'select id,title,centreno from '.PRE.'createroom';	
	$flRows = db()->query($sql)->array_rows();
	
	$row = db()->select('id,centreno,title,content,static_n,publitime,state')->from(PRE.'notice')->where(array('id'=>$id))->get()->array_row();
	
	require( base_url_name( SHOWNOTICEU_1 ) );
}
function gethelp()
{
	include( getThemeDir3() );
	
	$power = GetUserp();
	
	$zipArr = array('zip','rar','rar5');
	$imgArr = array('jpeg','jpg','png','gif');
	$vodeArr = array('mp4','flv','swf','ts','m3u8');
	$officeArr = array('xls','xlsx','pdf','csv','odp');
	
	$path2 = urldecode($_GET['path']);
	$filename = $_GET['path']==null?ALL_ROOTS:$path2; 
	
	if($_GET['path']!=null )
	{
		$upApth = mb_substr($filename, 0, mb_strrpos($filename, '/') );
	}
	else
	{
		$upApth = '';
	}
	
	$is_files = iconv('utf-8','gbk', $filename);

	if( is_dir($is_files) )
	{
		$files = reader_file( $filename );
	}
	if( is_file($is_files) )
	{
		$extArr = explode('.', $is_files);
		$ext = strtolower( end( $extArr ) );	
		if( $ext == 'zip' )
		{
			$strs = ReadingZIP( $filename );		
		}
		else 
		{
			$strs = file_get_contents($is_files);
		}	
	}
		
	require( base_url_name( SHOWGETHELP_1 ) );
}
function getkey_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include( getThemeDir3() );
	
	$flRows1 = GetFenLai(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$id))->get()->array_row();
	
	require( base_url_name( SHOWGETKEYU_1 ) );
}
function addusers()
{
	include( getThemeDir3() );
	
	$power = GetUserp();
	
	require( base_url_name( SHOWADDUSERS_1 ) );
}
function geturl_update()
{
	include( getThemeDir3() );
	
	$power = GetUserp();
	
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'admin')->where(array('id'=>$id))->get()->array_row();
	
	require( base_url_name( SHOWGETURLU_1 ) );
}
function file_classify()
{
	include( getThemeDir3() );
	
	$flRows1 = GetFenLai3(0,2);
	
	require( base_url_name( SHOWFILECLASSIFY ) );
}
function show_classify()
{
	$power = GetUserp();
	
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWSHOWCLASSIFY ) );
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function classify_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include( getThemeDir3() );
	
	$flRows1 = GetFenLai3(0,2);
	
	$row = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'fileclass')->where(array('id'=>$id))->get()->array_row();	
	
	require( base_url_name( SHOWIFYUPD ) );
}
function create_dts()
{
	include( getThemeDir3() );
	
	$flRows1 = GetFenLai3(0,2);
	
	require( base_url_name( SHOWCREATEDTS ) );
}
function announcements()
{
	include( getThemeDir3() );
	
	$sql = 'select id,title,centreno from '.PRE.'createroom';	
	$flRows = db()->query($sql)->array_rows();
	
	require( base_url_name( SHOWANNCEMTS ) );
}
function UpwardsLookup2($flRows1)
{
	$rows = UpwardsLookup($flRows1);	
	$h = array_reverse($flRows1);	
	foreach( $h as $k => $v )
	{
		$lenth = array_search($v['title'], $rows);
		$index[$k] = $lenth;
		if( $k == 0 )
		{
			$rs[] = array_slice($rows, 0, $lenth+1);
		}
		else 
		{
			$rs[] = array_slice($rows, $index[$k-1]+1, ($lenth-$index[$k-1])<=0?null:$lenth-$index[$k-1]);
		}
	}
	
	$h2 = array_reverse($rs);
	
	foreach( $flRows1 as $ks => $vs )
	{
		$flRows1[$ks]['ifl'] = $h2[$ks];
	}
	
	return $flRows1;
}
function UpwardsLookup($array)
{
	static $rows;
	foreach( $array as $k => $v )
	{
		$rows[] = $v['title'];
		$rs1 = db()->select('id,pid,title')->from(PRE.'classify')->where(array('id'=>$v['pid']))->get()->array_rows();
		UpwardsLookup($rs1);
	}
	$r = array_reverse($rows);
	return $r;
}
function conent_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);

	include( getThemeDir3() );

	$flRows1 = GetFenLai3(0,2);

	$row = db()->select('*')->from(PRE.'createdts')->where(array('id'=>$id))->get()->array_row();
	
	require( base_url_name( SHOWCONENTUPD ) );
}
function create_room()
{
	include( getThemeDir3() );
	
	$usersname = GetUsersName();
	
	$flRows1 = GetFenLai(0,2);
	
	require( base_url_name( SHOWCREATEROOM ) );
}
function e_xamqm_update()
{
	$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	include( getThemeDir3() );
	
	$row = db()->select('id,pid,title,sort,tariff,descri,roomsets,solve,typeofs,rule1,rule2,publitime,state')->from(PRE.'createroom')->where(array('id'=>$id))->get()->array_row();

	if( $row['rule1'] != null )
	{
		$rule = mb_unserialize($row['rule1']);
	}
	
	if( $row['rule2'] != null )
	{
		$rule2 = unserialize($row['rule2']);
	}
	
	$flRows1 = GetFenLai(0,2);
	
	require( base_url_name( SHOWEXAMQMUPD ) );
}
function mb_unserialize($serial_str) 
{
    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
    $serial_str= str_replace("\r", "", $serial_str);
    return unserialize($serial_str);
}
function gettiku()
{
	include( getThemeDir3() );
	
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
		
	require( base_url_name( SHOWGETTIKU ) );
}
function import_tiku()
{
	include( getThemeDir3() );
	
	$flRows1 = GetFenLai(0,2);
	
	require( base_url_name( SHOWIMPORTTIKU ) );
}
function modify_import()
{
	include( getThemeDir3() );
	
	require( base_url_name( SHOWMODIFYIMPORT ) );
}
function gettiku_update()
{
	include( getThemeDir3() );
	
	$id = $_GET['id']==null?null:htmlspecialchars($_GET['id'],ENT_QUOTES);
	
	$row = db()->select('*')->from(PRE.'examination')->where(array('id'=>$id))->get()->array_row();
	
	$flRows1 = GetFenLai(0,2);
	
	require( base_url_name( SHOWGETTIKUUPDDATE ) );
}
function batch_modification()
{
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWBATCHMODIF ) );
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function batch_deleting()
{
	include( getThemeDir3() );
	
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
	
	require( base_url_name( SHOWBATCHDELETE ) );
}
function iframe_bianji()
{
	include( getThemeDir3() );
	
	$path2 = urldecode($_GET['path']);
	$filename = $_GET['path']==null?ALL_ROOTS:$path2; 
	
	if($_GET['path']!=null )
	{
		$upApth = mb_substr($filename, 0, mb_strrpos($filename, '/') );
	}
	else
	{
		$upApth = '';
	}
	
	$is_files = iconv('utf-8','gbk', $filename);

	if( is_file( $is_files ) )
	{
		$strs = file_get_contents($is_files);	
	}
	
	require( base_url_name( SHOWIFRAMEBIANJI ) );
}
function adduserspic()
{
	include( getThemeDir3() );	
	require( base_url_name( SHOWADDUSERSPIC ) );
}
function exhibition()
{
	include( getThemeDir3() );
	
	$id = GetIndexValue(1);
				
	require( base_url_name( SHOWEXHIBTROOM_1 ) );
}
function tools()
{
	include( getThemeDir3() );
	require( base_url_name( SHOWTOOLS ) );
}
function CreateDirectory()
{
	$f = $_POST['f'];
	$n = $_POST['n'];
	$p = urldecode( $_POST['p'] );
	
	$filename = iconv('utf-8','gbk', $p);
		
	switch ( $f )
	{
		case 1:
			if( is_dir( $filename ) ){ if( mkdir( $filename.'/'.$n ,0777 ) ){ $flag = 'OK'; } else { $flag = 'no'; } }
		break;
		case 2:
			if( !is_file( $filename.'/'.$n ) ){ if( touch( $filename.'/'.$n ) ){ $flag = 'OK'; } else { $flag = 'no'; }  }
		break;
	}
	
	echo $flag;
	
}
function up_bianjis()
{
	$filename = $_POST['apth'];
	$data = $_POST['txt'];	
	file_put_contents($filename, $data);
	echo 'OK';
}
function delete_files()
{
	$filename = urldecode( $_POST['apth'] );
	$is_files = iconv('utf-8','gbk', $filename);
	
	if( is_dir( $is_files ) )
	{
		if( delete_dir( $is_files ) )
		{
			echo 'OK';
		}
	}
	
	if( is_file( $is_files ) )
	{
		if( unlink( $is_files ) )
		{
			echo 'OK';
		}
	}
}
function notice_dtsend()
{
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_1.'");location.href="'.apth_url('?act=announcements').'";</script>';exit;
	}
	$data['centreno'] = $_POST['centreno'];
	if( $data['centreno'] == 0 )
	{
		echo '<script>alert("'.PERLISTFENLAI_6.'");location.href="'.apth_url('?act=announcements').'";</script>';exit;
	}
	$data['content'] = $_POST['content'];
	if( $data['content'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_2.'");location.href="'.apth_url('?act=announcements').'";</script>';exit;
	}
	$data['state'] = $_POST['state'];
	$data['static_n'] = mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999);
	$data['publitime'] = time();
	
	$int = db()->insert(PRE.'notice', $data);
	if( $int )
	{
		header('location:'.apth_url('?act=notice_list'));
	}
	else 
	{
		echo '<script>alert("'.ADDONOK.'");location.href="'.apth_url('?act=announcements').'";</script>';exit;
	}
}
function notice_upinfo()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$data['title'] = $_POST['title'];
	if( $data['title'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_1.'");location.href="'.apth_url('?act=notice_update&page='.$_POST['page'].'&id='.$id).'";</script>';exit;
	}
	$data['centreno'] = $_POST['centreno'];
	if( $data['centreno'] == 0 )
	{
		echo '<script>alert("'.PERLISTFENLAI_6.'");location.href="'.apth_url('?act=notice_update&page='.$_POST['page'].'&id='.$id).'";</script>';exit;
	}
	$data['content'] = $_POST['content'];
	if( $data['content'] == '' )
	{
		echo '<script>alert("'.PERLISTINPUTTILE_2.'");location.href="'.apth_url('?act=notice_update&page='.$_POST['page'].'&id='.$id).'";</script>';exit;
	}
	$data['state'] = $_POST['state'];
	$data['static_n'] = mt_rand(10000,99999).mt_rand(10000,99999).mt_rand(100000,999999);
	$data['publitime'] = time();
	
	$int = db()->update(PRE.'notice', $data, array('id'=>$id));
	if( $int )
	{
		header('location:'.apth_url('?act=notice_list&page='.$_POST['page']));
	}
	else 
	{
		echo '<script>alert("'.QUDATEONOK.'");location.href="'.apth_url('?act=notice_update&page='.$_POST['page'].'&id='.$id).'";</script>';exit;
	}
}
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
function delete_notice()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'notice',array('id'=>$id));
	if( $int )
	{
		echo json_encode(array("error"=>0,'txt'=>DELETEYESOK));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>DELETEONOK));
	}
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
	require( base_url( base_url_name( SHOWPHPEXCELS_1 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_2 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_3 ) ) );
	
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
	
	require( base_url( base_url_name( SHOWPHPEXCELS_1 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_2 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_3 ) ) );
	
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
		if( !is_numeric( $id ) )
		{
			echo '<script>alert("'.MODILEERRORZH_CN_1.'");location.href="'.apth_url('?act=modify_import').'";</script>';exit;
		}	
		$data['typeofs'] = GetFourTypes(trim($objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue()));	
		$data['dry'] = trim($objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue());
		$options = trim($objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue());		
		$data['options'] = str_replace(array('&'),array('-'), trim($options));
		$data['numbers'] = trim($objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue());
		$data['answers'] = trim($objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue());
		$data['analysis'] = trim($objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue());
		$data['years'] = trim($objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue());
		$data['booknames'] = trim($objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue());
		$data['subtitles'] = trim($objPHPExcel->getActiveSheet()->getCell("J".$j)->getValue());
		$data['chapters'] = trim($objPHPExcel->getActiveSheet()->getCell("K".$j)->getValue());
		$data['hats'] = trim($objPHPExcel->getActiveSheet()->getCell("L".$j)->getValue());
		$data['publitime'] = time();
		
		$i = db()->update(PRE.'examination',$data,array('id'=>$id));
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
	
	require( base_url( base_url_name( SHOWPHPEXCELS_1 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_2 ) ) );
	require( base_url( base_url_name( SHOWPHPEXCELS_3 ) ) );
	
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
		$typeofs = trim($objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue());
		if( is_numeric( $typeofs ) )
		{
			echo '<script>alert("'.MODILEERRORZH_CN_2.'");location.href="'.apth_url('?act=import_tiku').'";</script>';exit;
		}	
		$data['typeofs'] = GetFourTypes($typeofs);
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function GetFourTypes($str)
{
	$strArr = array(DANXUANTI_1=>1,DANXUANTI_2=>2,DANXUANTI_3=>3,DANXUANTI_4=>4);
	return $strArr[$str];
}
function GetFourTypes2($str)
{
	$strArr = array('1'=>DANXUANTI_1,'2'=>DANXUANTI_2,'3'=>DANXUANTI_3,'4'=>DANXUANTI_4);
	return $strArr[$str];
}
function delete_exam()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$int = db()->delete(PRE.'createroom',array('id'=>$id));
	if( $int )
	{
		db()->delete(PRE.'notice', array('pid'=>$id));
		
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
	if( $data['pid'] == 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAI_1));exit;
	}
	$data['solve'] = $_POST['solve'];
	$data['descri'] = $_POST['descri']==''?'':$_POST['descri'];
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
	if( $data['pid'] == 0 )
	{
		echo json_encode(array("error"=>1,'txt'=>PERLISTFENLAI_1));exit;
	}	
	$data['centreno'] = mt_rand(100000,999999).mt_rand(100000,999999);
	$data['reluser'] = $_POST['reluser']==''?'':$_POST['reluser'];
	$data['solve'] = $_POST['solve'];
	$data['descri'] = $_POST['descri']==''?'':$_POST['descri'];
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
function reader_file( $filename )
{
	if( file_exists( $filename ) )
	{
		$handle = opendir( $filename );
		
		while ( ($item = readdir($handle)) !== false )
		{
			if( $item != '.' && $item != '..' )
			{
				$files[] = iconv('gbk','utf-8',$item);				
			}
		}
		
		closedir( $handle );
		
	}
	
	return $files;
	
}
function delete_dir( $filename )
{
	if( is_dir( $filename ) )
	{
		$path = $filename;
		$handle = opendir($path);
		
		while ( ($item = readdir( $handle )) !== false )
		{
			if( $item != '.' && $item != '..' )
			{
				if( is_file( $filename.'/'.$item ) )
				{
					unlink( $filename.'/'.$item );
				}
				
				if( is_dir( $filename.'/'.$item ) )
				{
					delete_dir( $filename.'/'.$item );
				}
			}
		}
		
		closedir( $handle );
		
		if( rmdir( $filename ) ) 
		{
			return true;
		}		
	}
}
function getBtSize( $filename )
{
	$fs = iconv('utf-8','gbk', $filename);
	
	$size = filesize( $fs );
	
	$array = array('KB','MB','GB','TB');
	
	$i = 0;
	
	while ( $size > 1024 )
	{
		$size /= 1024;
	}
	
	$b = round($size,2);
	
	return $b.' '.$array[$i];
}
function getFilecTIME( $filename )
{
	$fs = iconv('utf-8','gbk', $filename);
	
	$format = filectime( $fs );
	
	return date('Y-m-d H:i:s',$format);
}
function getFilesType( $filename )
{
	$fs = iconv('utf-8','gbk', $filename);
	
	$ImgName = array('css','csv','html','img','js','txt','xls','xlsx','zip','dir','file','ini','log','flv','mp4','swf','xml','ts');
	$ExtImg = array('png','jpg','jpeg','gif');
	
	if( is_dir( $fs ) )
	{
		$TypeName = 'data:image/png;base64,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';
	}
	
	if( is_file( $fs ) )
	{
		$extArr = explode( '.', $fs );
		$ext = strtolower( end( $extArr ) );
		
		if( $ext == $ImgName[0] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[1] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[2] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( in_array($ext, $ExtImg) )
		{
			$TypeName = 'data:image/png;base64,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';			
		}
		elseif( $ext == $ImgName[4] )
		{
			$TypeName = 'data:image/png;base64,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';			
		}
		elseif( $ext == $ImgName[5] )
		{
			$TypeName = 'data:image/png;base64,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';			
		}
		elseif( $ext == $ImgName[6] )
		{
			$TypeName = 'data:image/png;base64,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';			
		}
		elseif( $ext == $ImgName[7] )
		{
			$TypeName = 'data:image/png;base64,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';			
		}
		elseif( $ext == $ImgName[8] )
		{
			$TypeName = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28AAgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaOWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHiwmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryMAgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0lYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHiNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYAQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6cwR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBiewhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1cQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqOY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hMWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgohJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSUEko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/pdLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Yb1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7OUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsbdi97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxrPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H08PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+Hvqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsGLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjgR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4qriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWYEpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1IreZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/PbFWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYji1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVkVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0IbwDa0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vzDoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+yCW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawto22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtdUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3rO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv9563Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+UPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAIoSURBVHjavJNNSJRRFIafT3TUkMhcmCujH2ehDeRAiLmYMAy0xBYuktq2tFWLQCmCEFcStXTVorT8Ddw4RrVwTGMsaQoGkUwch1GzzPm+mbnfz2nhZBNoSkgHDu/lwj2c9znnaiLCfkQ2QPOhY5Kfo3Dh7PpAkYWZH+HJgmiZ91kAjQ/vkXBsCly5eO9GaX0RxdMepcCVSyFF5FkHt7SYQoo23DQXlfxhRftlLfAmKF0NFyn77qW4awSfD8bHIXajjhwnH0MsDmjZGGKRSw5GXoy5vM88+xrVtgoNDD6XhkuNfAh9orO2lrpkPS6XC6XUjmo6NusqztzhAN0rS5omIrjdbunp7cPjOcXkVJDXZzu4ZffBy3WI6PAjtZmGCZYDGwo9YRBP6Nwcvc6jlUUtG6Ct/Q6Vpz2EZ+eprvLy9EiQQKCU4Pmav4I3SbHhRH5P7drVK9rxE2XiPnmU8Ow8a8rE74/w3nm89/mLCP0Dw5I0Rd6++yjl5eUC7DlFBBFhW0bnumOkuusZjkA8BXEFutpe+29fRoKD2zNS93sIBEppetCZbtsEsdMebHBU+uzA9NDOjNC/4PcvwOKr3dlUNv0HRjVjHThtfYwZC8yoVZYsnVUniSkOMdtg2U6wnNbCllbWJmWTUTgc1ioqKmRgaITqKi/SqzM6qnFhpgUcZ6dxo1kW36Yyfj9AKBTaKkZCMTEBJdO771HyTMYeZabP5/t3RvsRPwcA8lmFSh+JKmcAAAAASUVORK5CYII=';			
		}
		elseif( $ext == $ImgName[11] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[12] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[13] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[14] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[15] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[16] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		elseif( $ext == $ImgName[17] )
		{
			$TypeName = 'data:image/png;base64,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';
		}
		else 
		{
			$TypeName = 'data:image/png;base64,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';
		}
	}
	return $TypeName;
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function ReadingZIP( $filename )
{
	$fs = iconv('utf-8','gbk', $filename);
	
	$zip = zip_open( $fs );
	
	while( ($h = zip_read( $zip )) !== false )
	{
		$str .= zip_entry_name( $h )."\n";
	}
	
	zip_close( $zip );
	
	return $str;
}
function External()
{
	$picture = $_FILES['picture'];	
	if( $picture['error'] == 0 )
	{
		$extArr = explode('.', $picture['name']);
		$ext = end( $extArr );
		
		$d = 'data:image/'.$ext.';base64,';
		
		$str1 = file_get_contents( $picture['tmp_name'] );
		$str2 = base64_encode( $str1 );
		
		$data = $d.$str2;
		
		$int = db()->insert(PRE.'apack',array('picname'=>$data));
		if( $int )
		{
			echo json_encode(array("error"=>0,'txt'=>ADDYESOK));
		}
		else 
		{
			echo json_encode(array("error"=>1,'txt'=>ADDONOK));
		}
	}
}
function TOIMG()
{
	$picture = $_FILES['picture'];	
	if( $picture['error'] == 0 )
	{
		$extArr = explode('.', $picture['name']);
		$ext = end( $extArr );
		
		$d = 'data:image/'.$ext.';base64,';
		
		$str1 = file_get_contents( $picture['tmp_name'] );
		$str2 = base64_encode( $str1 );
		
		$data = $d.$str2;
		
		if( $str1 != '' )
		{
			echo json_encode(array("error"=>0,'txt'=>$data));
		}
		else
		{
			echo json_encode(array("error"=>1,'txt'=>KCONETINFO_ON_1));
		}
	}
}
function TOIMG2($apth)
{
	$extArr = explode('.', $apth);
	$ext = end( $extArr );
		
	$d = 'data:image/'.$ext.';base64,';
		
	$str1 = file_get_contents( $apth );
	$str2 = base64_encode( $str1 );
		
	$data = $d.$str2;
		
	if( $str1 != '' )
	{
		return $data;
	}
	else
	{
		return KCONETINFO_ON_1;
	}
}
function TOText()
{
	$str3 = file_get_contents( trim( $_POST['t'] ) );
	$str2 = str_replace(array("\n"), array(""), $str3);
	if( $str2 != '' )
	{
		$str1 = base64_encode( $str2 );	
		$data = $str1;
		
		echo json_encode(array("error"=>0,'txt'=>$data));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>KCONETINFO_ON_1));
	}
}
function TOCSS_BA()
{
	$str1 = base64_encode( trim( $_POST['t'] ) );
	
	$d = 'data:text/css,';
	
	$data = $d.$str1;
	
	if( $str1 != '' )
	{
		echo json_encode(array("error"=>0,'txt'=>$data));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>KCONETINFO_ON_1));
	}
}
function TOJAVASCRIPT_BA()
{
	$str1 = base64_encode( trim( $_POST['t'] ) );
	
	$d = 'data:text/javascript,';
	
	$data = $d.$str1;
	
	if( $str1 != '' )
	{
		echo json_encode(array("error"=>0,'txt'=>$data));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>KCONETINFO_ON_1));
	}
}
function GetInfoBar()
{
	$limit = $_POST['limit']==null?5:$_POST['limit'];
	$contlen = $_POST['len']==null?200:$_POST['len'];
	$url = $_POST['url']==null?'javascript:void(0);':$_POST['url'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql  = 'select id,centreno,title,content,static_n,publitime,state from '.PRE.'notice where state=0 order by id desc ';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
		
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query( $sql )->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
		
	if( !empty( $rows ) )
	{
		foreach( $rows as $k => $v )
		{
			$str = strip_tags( $v['content'] );
			$content = $str;
			if( mb_strlen($str,'utf-8') > $contlen )
			{
				$content = mb_substr($str, 0, $contlen,'utf-8').'......';
			}			
			$html .= '<li class="exam_boxsli0"><p class="exam_boxsp0"><a href="'.$url.'" target="'.$target.'" style="color:#3e3c3c;text-decoration:none;">'.$v['title'].'</a></p><p class="exam_boxsp1"><a href="'.$url.'" target="'.$target.'" style="color:#888888;text-decoration:none;">'.$content.'</a></p></li>';
		}
		echo json_encode(array("error"=>0,'txt'=>$html));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetInfoBar2()
{
	$limit = $_POST['limit']==null?5:$_POST['limit'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql  = 'select id,centreno,title,content,static_n,publitime,state from '.PRE.'notice where state=0 order by id desc ';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
		
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query( $sql )->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
		
	if( !empty( $rows ) )
	{
		echo json_encode(array("error"=>0,'txt'=>$rows));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetFamily()
{
	$limit = $_POST['limit']==null?5:$_POST['limit'];
	$contlen = $_POST['len']==null?200:$_POST['len'];
	$url = $_POST['url']==null?apth_url('index.php/exhibition/'):$_POST['url'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,title,sort,descri,publitime,state from '.PRE.'classify where pid=0 and state=0 order by sort desc';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
		
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query( $sql )->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
		
	if( !empty( $rows ) )
	{
		foreach( $rows as $k => $v )
		{
			$content = $v['title'];
			if( mb_strlen($v['title'],'utf-8') > $contlen )
			{
				$content = mb_substr($v['title'], 0, $contlen,'utf-8').'......';
			}	
			$html .= '<li class="exam_lif0list"><a href="'.($_POST['url']==null?$url.$v['id']:$url).'" target="'.$target.'">'.$content.'</a></li>';
		}
		$html .= '<div style="clear:both;"></div>';
		
		echo json_encode(array("error"=>0,'txt'=>$html));
	}
	else 
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetFamily2()
{
	$limit = $_POST['limit']==null?5:$_POST['limit'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,title,sort,descri,publitime,state from '.PRE.'classify where pid=0 and state=0 order by sort desc';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
		
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query( $sql )->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
		
	if( !empty( $rows ) )
	{		
		echo json_encode(array("error"=>0,'txt'=>$rows));
	}
	else 
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetJSNews()
{
	$limit = $_POST['limit']==null?10:$_POST['limit'];
	$contlen = $_POST['len']==null?60:$_POST['len'];
	$url = $_POST['url']==null?'javascript:void(0);':$_POST['url'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,title,depict,content,tags,covers,static_n,publitime,timing,state from '.PRE.'createdts where FROM_UNIXTIME(timing,"%Y-%m-%d %H:%i:%s")<="'.date('Y-m-d H:i:s').'" and state=0 order by id desc';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
	
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query($sql)->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
	
	if( !empty( $rows ) )
	{		
		$a1='';$a2='';
		if( count($rows) > 5 )
		{
			$a1=array_slice($rows,0,5);
			$a2=array_slice($rows,5,5);
		}
		else
		{
			$a1=$rows;
		}
		
		$defaultImg = 'data:image/png;base64,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';
		
		if( !empty( $a1 ) )
		{
			foreach( $a1 as $k => $v )
			{
				if( $v['covers'] != '' )
				{
					$defaultImg = $v['covers'];
				}
				
				$mishu = $v['depict'];
				if( mb_strlen($v['depict'],'utf-8') > $contlen )
				{
					$mishu = mb_substr($v['depict'], 0,$contlen ,'utf-8').'......';
				}
				$html1 .= '<li class="exam_newsullis0"><div class="exam_newsullidiv0 exam_newsullidiv0_1"><a href="'.($_POST['url']==null?$url:$url.'&id='.$v['id']).'" target="'.$target.'"><img width="113px" height="72px" src="'.$defaultImg.'" alt="'.$v['titleas'].'"/></a></div><div class="exam_newsullidiv0 exam_newsullidiv0_2"><p class="exam_newsullidivp"><a href="'.($_POST['url']==null?$url:$url.'&id='.$v['id']).'" target="'.$target.'">'.$v['title'].'</a></p><p class="exam_newsullidivp2">'.$mishu.'</p></div><div style="clear:both;"></div></li>';   		
			}
		}
		
		if( !empty( $a2 ) )
		{
			foreach( $a2 as $ks => $vs )
			{
				if( $vs['covers'] != '' )
				{
					$defaultImg = $vs['covers'];
				}
				
				$mishu = $vs['depict'];
				if( mb_strlen($vs['depict'],'utf-8') > $contlen )
				{
					$mishu = mb_substr($vs['depict'], 0,$contlen ,'utf-8').'......';
				}
				$html2 .= '<li class="exam_newsullis1"><div class="exam_newsullidiv0 exam_newsullidiv0_1"><a href="'.($_POST['url']==null?$url:$url.'&id='.$vs['id']).'" target="'.$target.'"><img width="113px" height="72px" src="'.$defaultImg.'" alt="'.$vs['titleas'].'"/></a></div><div class="exam_newsullidiv0 exam_newsullidiv0_2"><p class="exam_newsullidivp"><a href="'.($_POST['url']==null?$url:$url.'&id='.$vs['id']).'" target="'.$target.'">'.$vs['title'].'</a></p><p class="exam_newsullidivp2">'.$mishu.'</p></div><div style="clear:both;"></div></li>'; 			
			}
		}
		
		echo json_encode(array("error"=>0,'txt1'=>$html1,'txt2'=>$html2));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetJSNews2()
{
	$limit = $_POST['limit']==null?10:$_POST['limit'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,title,depict,content,tags,covers,static_n,publitime,timing,state from '.PRE.'createdts where FROM_UNIXTIME(timing,"%Y-%m-%d %H:%i:%s")<="'.date('Y-m-d H:i:s').'" and state=0 order by id desc';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
	
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query($sql)->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
	
	if( !empty( $rows ) )
	{		
		$a1='';$a2='';
		if( count($rows) > 5 )
		{
			$a1=array_slice($rows,0,5);
			$a2=array_slice($rows,5,5);
		}
		else
		{
			$a1=$rows;
		}
		
		$defaultImg = 'data:image/png;base64,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';
			
		echo json_encode(array("error"=>0,'txt1'=>$a1,'txt2'=>$a2,'defaultImg'=>$defaultImg));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetExamination()
{
	$id = htmlspecialchars($_POST['id'],ENT_QUOTES);	
	
	$contlen = $_POST['len']==null?60:$_POST['len'];
	$url = $_POST['url']==null?'javascript:void(0);':$_POST['url'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$id))->get()->array_row();
	
	if( !empty( $ify ) )
	{
		$ifyArr = UpwardsLookup3( $ify['pid'] );
		
		if( !empty( $ifyArr ) )
		{
			foreach( $ifyArr as $k => $v )
			{
				$html .= ($html==null?'<a href="'.$url.'">'.HOME_PAGE_1.'</a> &gt; ':' &gt; ').'<a href="'.apth_url('index.php/exhibition/'.$v['id']).'">'.$v['title'].'</a>';
			}
		}
		
		$bread = $html==null?'<a href="'.$url.'">'.HOME_PAGE_1.'</a> &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>':$html.' &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>';
	    
		$examImg3 = 'data:image/png;base64,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';
		$examImg4 = 'data:image/png;base64,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';
		$examImg5 = 'data:image/png;base64,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';
		
		$searchkc = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,state')->from(PRE.'createroom')->where(array('pid'=>$id,'state'=>0))->get()->array_rows();
		
		if( !empty( $searchkc ) )
		{
			foreach( $searchkc as $k => $v )
			{
				$mishu = $v['title'];
				if( mb_strlen($v['title'],'utf-8') > $contlen )
				{
					$mishu = mb_substr($v['title'], 0,$contlen ,'utf-8').'......';
				}
				if( $v['tariff'] == 1 )
				{
					$li1 .='<li class="exam_minationli0"><a href="javascript:void(0);" flagid="1" onclick="exam.TollBoxShows(this);">'.$mishu.'</a><p><img src="'.$examImg3.'" width="100" height="35" align="absmiddle"/><img src="'.$examImg5.'" width="40" height="35" align="absmiddle"/></p></li>';
				}
				else 
				{
					$li1 .='<li class="exam_minationli0"><a href="'.apth_url('index.php/free_sion/'.$v['id']).'" target="'.$target.'">'.$mishu.'</a><p><img src="'.$examImg3.'" width="100" height="35" align="absmiddle"/><img src="'.$examImg4.'" width="40" height="35" align="absmiddle"/></p></li>';
				}				
			}
				$li1 .= '<div style="clear:both;"></div>';
		}
		
		$scif = UpwardsLookup4($id);
		
		if( !empty( $scif ) )
		{
			foreach( $scif as $ks => $vs )
			{
				$mishu = $vs['title'];
				if( mb_strlen($vs['title'],'utf-8') > $contlen )
				{
					$mishu = mb_substr($vs['title'], 0,$contlen ,'utf-8').'......';
				}
				$li2 .= '<li class="exam_minationli1"><a href="'.apth_url('index.php/exhibition/'.$vs['id']).'" target="'.$target.'">'.$mishu.'</a></li>';
			}
				$li2 .= '<div style="clear:both;"></div>';
		}
		
		echo json_encode(array("error"=>0,'txt1'=>$bread,'txt2'=>$li1,'txt3'=>$li2));
	
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function UpwardsLookup3($pid)
{
	static $rows;
	$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$pid))->get()->array_rows();
	foreach( $ify as $k => $v )
	{
		$rows[] = array('id'=>$v['id'],'title'=>$v['title']);
		UpwardsLookup3($v['pid']);
	}
	
	$array = '';
	if( !empty( $rows ) )
	{
		$array = array_reverse( $rows );
	}
	return $array;
}
function UpwardsLookup4($id)
{
	$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('pid'=>$id))->get()->array_rows();
	if( !empty( $ify ) )
	{
		foreach( $ify as $k => $v )
		{
			$rows[] = array('id'=>$v['id'],'title'=>$v['title']);
		}
	}
	return $rows;
}
function UpwardsLookup5($id)
{
	static $rows;
	
	$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('pid'=>$id))->get()->array_rows();
	if( !empty( $ify ) )
	{
		foreach( $ify as $k => $v )
		{
			$rows[] = array('id'=>$v['id'],'title'=>$v['title']);
			UpwardsLookup5($v['id']);
		}
	}

	return $rows;
}
function GetHottest()
{
	$id = $_POST['id']==null?10:htmlspecialchars($_POST['id'],ENT_QUOTES);
	$limit = $_POST['limit']==null?10:$_POST['limit'];
	$contlen = $_POST['len']==null?60:$_POST['len'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state from '.PRE.'createroom where state=0 order by counts desc ';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
	
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query($sql)->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}	
	
	$hotImg2 = 'data:image/png;base64,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';
	$hotImg4 = 'data:image/png;base64,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';
	$hotImg5 = 'data:image/png;base64,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';	
	
	if( !empty( $rows ) )
	{
		foreach( $rows as $k => $v )
		{
			$mishu = $v['title'];
			if( mb_strlen($v['title'],'utf-8') > $contlen )
			{
				$mishu = mb_substr($v['title'], 0,$contlen ,'utf-8').'......';
			}
			if( $id != $v['pid'] )
			{
				if( $v['tariff'] == 1 )
				{
					$li0 .= '<li class="exam_hottestli0"><a href="javascript:void(0);" flagID="'.$v['id'].'" onclick="exam.TollBoxShows(this);">'.$mishu.'</a><p class="exam_hottestlip0"><img src="'.$hotImg2.'" width="100" height="35" align="absmiddle"/><img src="'.$hotImg5.'" width="40" height="35" align="absmiddle"/></p></li>';
				}
				else 
				{
					$li0 .= '<li class="exam_hottestli0"><a href="'.apth_url('index.php/free_sion/'.$v['id']).'" target="'.$target.'">'.$mishu.'</a><p class="exam_hottestlip0"><img src="'.$hotImg2.'" width="100" height="35" align="absmiddle"/><img src="'.$hotImg4.'" width="40" height="35" align="absmiddle"/></p></li>';
				}
			}
		}
		$li0 .= '<div style="clear:both;"></div>';
		echo json_encode(array("error"=>0,'txt'=>$li0));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetHottest2()
{
	$limit = $_POST['limit']==null?10:$_POST['limit'];
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state from '.PRE.'createroom where state=0 order by counts desc ';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
	
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query($sql)->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}	
		
	if( !empty( $rows ) )
	{
		echo json_encode(array("error"=>0,'txt'=>$rows));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function GetOtherIfic()
{
	$id = $_POST['id']==null?10:htmlspecialchars($_POST['id'],ENT_QUOTES);
	$limit = $_POST['limit']==null?10:$_POST['limit'];
	$contlen = $_POST['len']==null?60:$_POST['len'];
	$target = $_POST['target']==null?'_self':$_POST['target'];
	
	$topId = '';
	if( $id != null )
	{
		$toprows = UpwardsLookup3( $id );
		$topId = $toprows[0]['id'];
	}
	
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211);
	
	$sql = 'select id,pid,title,sort,descri,publitime,state from '.PRE.'classify where pid=0 ';
	if( $limit != null )
	{
		$sql .= ' limit 0,'.$limit.' ';
	}
	
	$key = md5( $sql );		
	if( !$mem->get( $key ) )
	{
		$data = db()->query($sql)->array_rows();
		$mem->set($key, $data, 0, 30);   	
    	$rows = $mem->get( $key );
	}
	else	
	{
		$rows = $mem->get( $key );
	}
	
	if( !empty( $rows ) )
	{
		foreach( $rows as $k => $v )
		{
			$mishu = $v['title'];
			if( mb_strlen($v['title'],'utf-8') > $contlen )
			{
				$mishu = mb_substr($v['title'], 0,$contlen ,'utf-8').'......';
			}
			if( $v['id'] != $topId )
			{				
				$li0 .= '<li class="exam_OtherIficli0"><a href="'.apth_url('index.php/exhibition/'.$v['id']).'" target="'.$target.'">'.$mishu.'</a></li>';
			}		
		}
			$li0 .= '<div style="clear:both;"></div>';
		
		echo json_encode(array("error"=>0,'txt'=>$li0));
	}
	else 
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function tollbox_ps()
{
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('pid'=>htmlspecialchars($_POST['flagid'],ENT_QUOTES)))->get()->array_row();
	if( !empty( $row ) )
	{
		if( $row['tariff'] == 1 )
		{
			$rule1 = unserialize($row['rule1']);
		}
	}
	
	$vipImg = 'data:image/png;base64,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';
    $closeImg = 'data:image/png;base64,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';
    $showImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAS90lEQVR4Xu2dS1YbyRJAI+rJds9aYgPG51hMW16B8QpMr8B4aGlgeQXGKwAPpB4CKzC9AugVWJ4inwPeAJJnjVFXvJMlCYTQJ6vyU/kJTd5zk9+IuBX5jUTgn3YJVPcvqvBk9Me4YNxMkDbF/yOCBgBUbyskaCDO/HuuJUTUA8Th9D8jQA8Qsn+n/0EPEhgC0c9ha6unvRNc4Fh7LIf8Eqj+dbEJNHp6a/wpbRLiJgBtIoj/tf8jgiEgCFCGiNBLCS8B6BKuK9+GH57dQma/ZX7XyIAs0d+dFxh7ACLYBqIqIgov4N2PAM6Q6BISvEwJzgArP4bvnl161xHLDWZAxJin238JRI0EcZMAGrBm6GNZR8aqm3odRDjLhmz/q3xjaO6LO3pANrr9fQBoG7NCjwomoEtCfDt8Vz/zqNlGmxotIGIIhY9vTn0dMpm0ipTo7bC1dWSyDl/KjhaQWrd/igDbvijKdjtThFfsSSJdxRKrUAmNLmwbnU/1iUn9oFl/5VObTbQ1Sg+y0envAcJHEwINqcyrZj1K+5jVYZQCYEDkME6vK7XY91CiBKTa/b6TAH2RM5M4UxHBj0GrXsqmp0sSjxOQzvlugnjokiJca4vYIxm06jXX2mW7PVECIoRc6/RPEOG1bYF7Ux/h56vW8+j3h6IFJNsHeXJzhoCTQ4XemK7xhhLQt0Fzy8sjNbqFEy0gQpBiuRdp1EOA33UL1tfyCOAnXVc2Y5+cT/UXNSBjSPrbCcGprwatu90p0Qs+Pn8n1egBySDp9tsJgDiTFfUvBfgwbNYPohbCXOcZkIlAeNJOx1fNrV2G474EGJCJPGKetItJOV0/2uZ5x8PPAwMyI5Nq57yBiGcxTdqzSTlWGnwPZLHvZEDm5BLbLjuf2l09qGRAFsgnmrNaBJ+uWvU9nncslwADskQ2tW5fDLVehmo8RPD3oFXfCbV/uvrFgCyR5PjG4aiHCE91CduVcnhSLq8JBmSFrEKctGeTcqJt3gyUg4QBWSOnamAnf1PAP4fN5ydy5sGpGBAJG9jofD8ApPcSSd1Owid0c+uHAZEUWa173vP55C8B/DNo1jlIhaS+p8kYEEmBjXfaR5c+biKK24H0q9LgnXJJZc8kY0ByyExM2hPErzmylJ6UJ+VqKmBA1OTHuQOXAAMSuIK5e2oSYEDU5Me5A5cAAxK4grl7ahJgQNTkx7kDlwADEriCuXtqEmBA1OTHuQOXAAMSuIK5e2oSYEDU5Me5A5cAAxK4grl7ahJgQArI7/476AUKKCMLv6deSOoMSA6xZVEYU3oDiF7Gj8oe6SQ4gF+PjvngopziGZA1csq8xeObN4jQRsBw3ssgOkoTPOZ3CFcbAAOyRD7ZO4bpzUdfvYXc9xEg8yqQ7A2bz49l88SUjgGZ03YsYMwbOYOyGHsGZCKXWMFgUHiItVICYo6RPL7ZD30olXdYxB5lLLGoPUi1c/4eAfcQoZrXgGJJL95LJ6IPsYYJihKQSbyrfQTgIAbypB+k15VPsS0PRwVINpx6MvoIANE/TinPxV1K8fItIbZjWvGKBhARtR2JDnk4VQSN+3myYRdW3sbwZELwgLDXUAdiUQkTb/I29CiNQQOSzTUADhGRnzQ2wwmA2JH/9ehDqHOTYAHhFSpTRDwsl4h6BPA2xJWu4ACZREA8RAB++8IeI1lNKVF72Nr6bLlao9UFBQgPqYzailzhREdXra23condTxUMIOIoOqbwhVepyje6bMj169GrEOYlQQAS2hse5Zu4egtCmZd4D8hGt7/PG3/qBm2ihGwpOIE/fb5z4i0gfMjQhEmbKTMlEitcR2ZKN1uql4CMH9i8OeX9DbPGobN0XyHxDhCGQ6fZ2i3LR0i8AoThsGvQJmrzDRJvAGE4TJhrSWUi7F29q38qqfZc1XoBCMORS6d+JCb4dNWq77neWOcBYThcN6Hi7fNhuOU8ILVu/wufqypuhK7ndB0SpwHZ6JwfcjAF101cvX0p0QtXTwI7C8hG5/sBIL1XFz+X4LoEsh13oFcuQuIkIHy2ynWT1t++8bGUygvXrvE6B0gWIJrgVL8KuETXJeDiKWCnABHRDTEdfeUj666bssH2OXafxBlAeDnXoNF5VrRLK1vOAMIrVp5ZseHmurKy5QQg1W6/nQCIex38YwlkEsgm7b8qz8q+lVg6IOIeeYL4le2CJTAvARGgbtCsvypTMqUCMo5AcvM1qJebytRmgHWnAB+GzfpBWV0rFRDeDCxL7X7VW+Z8pDRARKzcBOiLX6q631oi+AEIl5g9Y4abCPCy7P4QwE8kPEoTOoGUhpBgFVLaRMAdRHhddvuK1C/2RwatrRdF8qrmKQWQ8ZLu6MLf/Q46TgkO5o9GjJ9VgCME/ENVMUXyE9A3un60vWxiW3b7ivTpNk9Jx+NLAcTXE7rCYxDQzqozQ5N51ZltSNbBMWucG93zIwB8o2SwJWQuY6hlHRBfh1Z5DNA2JGJYRUTbeQ771br9MxeGhHk4K2OoZRUQn4dWeb9etiApAocwykkM40sE+D2PkZae1vJQyyogG53+HiCIF578+hVUimlIisIxFb6P3tz2BqI1QLJnlml04RcZ49am15Va0R1dU5CowjHVQ63Tv0SEp37phY6vmlu7NtpsDZBat3/q46OZBPDPoFlXeuzTBCQpwisdIT193YvS1f91kFkBxOc7HjoAuRvz32hZ3dJ52tXXYa+tYyhWAKl1zy98PU5CBH8PWnUtj/Ho8CQ64RDg+qwb3bJY5E2MA+LrF2oqLAK6HDS3nq1zxbJ/V4FEt0H4fopat25KAcTnL9RUYLoPzBWBRDscgZyi1i2XeUiMepCQgi/k3QdZ51FyQUL4+ar1vL2uTNm/j5+qw1N/j/rc9dS0FzEKSAje43aoZSA0jRwkepc0Q4Lj1sMbfH/EGCAheY/yIGE4ZLyiSS9iDJCQvMeskkwEOVvsSRgOGThMexEjgIToPWxConNpOduDCWjOsQwaU17ECCCheg8bkCRPbg7S60ftokdb5g0oBjjuVhvxz2Hz+Ukez7MurXZAfN41Xyes+b+bGG7lbcOq9DHBIeSg2/OKMrUD4utlnKKG6SokscFx60Ww8kxnfF+tgGRPMz8ZDYoam6/5XIMkVjgy+yl4NWGZ7ekFJOIAcK5AEnsIV92Tda2AxDA5X+XlyoYkdjhMTNa1AcIREsfqKQsShuPu06Vzsq4NEF8v3piY99iGhOF4qEWVW6CzpWkDJPbhVVlLwAzH4k9cCnr2RLQAwsOrxUoy7UkYjpUzQi331rUAwsOr5YoyBQnDsXpwLOQ+aNVrqkNoLYDw8Gq9snQ+UMlwyJm9jmGWMiA+h/ORE7OeVLomjaI12XGeFIpFWkHadCXQth7Jmh1mqQMSweagiGxCREcA0MsT3tO8AajVIO6kI8Ced9EVJbutY9NQGZBap3/ia1j9dXKeBGdrD1tbAo4gf9nLwnRzYjvYti1hpopns3QAMgjhbvMihem+h27LKPLW422cXomOqgZ1UAIk5OVd3ZFMJHRZahIf4/RKCUwx4IUqILsJ4qFUQz1KJN4BGbTqmx41WUtTa93zXmhDLdUnE5QACfbuh+Yj01qs10Ihoe5nqawgKgFS65x/RcSGBd1ZrcJWYGSrnZKoLNRYAir6VAJko9snCbl7l0RFoN51dqbBvociXSp7hRFBYUBCvnseKyChDrEAiodQKg5IAM84L//i6A316YtXCfXIkMoTFoUB8T1q+yqjtf3MlwsAhTr/ELJVObhYHBBPnxKWNkbF9XPpehxImO2mp6OvoW74ChFfNeuFbL1QJlGhj88I57VF1V3YvPWVkX4cAQUOQ1yNnJVn0XllcUA6/WCPmMwZ6kF6XfmkK9JhGRAsqjML0fTb6D2l0A7Zc0z7bh2QUJd4FxmTGMMi0ElKeAIJDAsb+XXlmw7QxJAIaDT3Mi1uJkgrd/+J7o7I+/igamG5ZxMR+HTVqu/lLaOwB4kJkLxCXZa+6FdsvryQF0h0yfpBOTYBiTWCoqryGBBVCSrktwqIuNFGcKrQ3CizMiAlqp0BKVH4klUzIJKCMpCsaDC5QnOQkI+ZGNDNbZEMiEnpri676G46A2JRZwyIRWHPVcWAlCd76ZoZEGlRaU/IgGgX6V2B4oYhAp6kCak97/VvpadtHwRGSjcekxR3CGk31Igm8+bAgJgCpODqh6nm6Cx3vFx/cwCAb3SW62JZDIgBrcRwFkuILdiLUjM2wYDoBiRgz7FIVCHHNxP9ZUA0AiLmHPSr0tAxX9DYLKNFBR9CtuD1hULLvEJTQZ/FKihMoxZsofCgvUjBEQEDssDwdC3HWrBprVUEfQiSAdFnK7ECEmx0xfEkxO5x91q3Pwx1DT1WQEL2IEVDyRYeYgV95ZbnIPrcsSMlFf3oMSALFKjjXQlH7EK6GeNXq0YXoV6/tQ5IyO44s6qCY1Zpi3QsYa3b/4IAO441S1tzrEc1CR4QANDxxp02DRssKOSYWFOxWQckljshKZF4YeqzQfssrejJ1emPANAurREWKiagb4PmVqEg64XnILEAMh5t0SURHABiDzRFJrFgFwurmEZESQB2CGgHAZVOBZfVjzz1Fj1mIuooDEjwu+l5NCCZtuhEcb74GIa3kiKVS6awKqkESIgvEslJvFgqBqSY3FRzqZzKVgIk3HD5qipZnJ8BMSPXdaWqPMaqBEgMqx/rhJ/n7wxIHmnpSSue8h4069WipakC0kgQvxatPLZ8DIh9jatM0JUn6aKAkM9k6VYnA6JbohLlKW74KnmQCSBnCPBSoqnRJ2FA7JuA6mavMiAx3GfWpVYGRJck5ctReQJayxAr+Kua8rpYm5IBWSsirQmKhhudbYSyBxkPs857CPiH1t4FWJjKevysOHijUM44dMhbCyA8zJJTmK4Twrz/JCdv1eGVliGWKISHWXIK0+HyJx77IoYzVHJSXZxKl6y1eBAeZsmrUvWrFtMhUXmpPkypY3ilzYNkXqTbbycA+yqdiiKvwsG58Yeofxrd+4IFDEP1QzStUpsHya5sPhldhhrIoYCOlmYpejaIj/bIaoGOr5pbu7KpV6XTBoiohCePcioRr+YS0Ktha6snl0N46O87CdAX2fQxp0ux8mz47tmlDhloBYQn6/IqmUCyJ3NbceOv/kcgyP2EsXxrwkmpevZqXhJaAcm8SPf8KIZw+rpM6va2YvLo79mvXnbzL715jQhtXrGSl7auzVjtc5BpgexF5JXJKfVKQLf30LqKNdtV9iJ6Fc+lyUlAt/cwBojwIkijHq9oySmWU6lLQNfGoPE5yO1Qi/dF1LXOJUhJQNwaJKw0dK1czVaqfZI+W3jQ8XulVMeJbEigaGBqmbYZBaTaOecruTJa4DSFJWBiYm7Ng2TLvp3+HiCI6H38Ywlol4DOTcFFjTPqQaYV8n0R7XbBBYrYyURvh62tI5PCsALIJLR+DxGemuwMlx2TBPSdt1olNSuAiAaI+QgiigAPv8ekRu6rfgmYWtItbYg1rZjvMug3lthKFJHa6frRtq0nuq15kFtIOue7CeJhbIrl/qpLwOR+x7LWWQdkMtxiSNTtJaoSMjiItvNcEdAhoFIAYUh0qC6eMrJhFcGubTiEhEsDJIOk+30HgY544h6Pseftqe05x3z7SgWEV7fymktc6cVqFf2q7NqakJe+irVMveMlYDji4HNxAbC6t3b2OdZJvHQPcru6tX9RTR7/twdI79c1mv8ergSyyTjg7rD5/MSFXjoDyC0of/W3MYUj3nV3wTzstsGFIZVzc5BFKpgcTRGQvLarIq6tDAmMvQbsDZv1gzLqX1Wncx5ktrHZKhfRAXsT18xGX3vEcXXCyq6Jy046Wuk0ILfDrs75LiIe8HKwDpW7UcYYDNgbvqufudGixa3wApBsOTibxI/alIXB4QOPLhvVqrZl+xqIbdfBmPbBG0Dur3YxKL4BQgQ/CEgEyjN6f0O3XLwDZBYUeHyzMwmsxo/36LYMbeXRcYp45IvH8GIVK69uxnffoU2AOzz8yis9/ekzb4FwANeVozJ3wXX0zFsPsmx5mL2KDrPIX4ZYqkWgE5+9xaJeBwXIvSXi/YuqgCVB2GbPkt/gZXIIT4GAJ2lCJ74Oodb1M1hA5jue3WZMcYcw3eYzX+vMYvnfs91uhDPAyomrexfFe/cwZzSAPPAuv40aSQrbhLANAA2euzw0jsxDIJ2lgD1A6IXqJVYBFSUgC+cv4rkB+q+REDVihEbAAAAinnIvTeAM/q30fJ9g6/AkDMgaKYoVMkiwKrwNAFYJqQFAVR+HaWL3GgiGGQQIQ+EVACqXMQyVisLCgBSV3GR3H34bNW6LIGgkBNXs30ibBLg5WzwCvFSobqYa+Cm+9vfKJuwB0FD8txToEhIcP0GW0rCMq6o6+ulCGQyIC1rgNjgrAQbEWdVww1yQAAPigha4Dc5KgAFxVjXcMBck8H8+v5JQfLjJpQAAAABJRU5ErkJggg==';
    $bottonImg = 'data:image/png;base64,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';

    $html = '';
    
	if( !empty( $rule1['r_name'] ) )
	{
		$html .= '<div style="margin:0;padding:0;width:800px;height:450px;">';
   		$html .= '<div style="margin:0;padding:0;height:50px;border-bottom:1px solid #e8e2e2;color:#676464;padding:0 1rem;line-height:50px;font-family:monospace;font-size:15px;background:#fbf7f7;"><img src="'.$vipImg.'" width="21" height="21" align="absmiddle"/>'.FAMODLES_PAGE_1.'<p onclick="exam.closeImg();" style="margin:0;padding:0;float:right;cursor:pointer;" title="'.CLOSES_PAGE_1.'"><img src="'.$closeImg.'" width="35" height="35" align="absmiddle"/></p></div>';
    	$html .= '<form id="FrmListID"><ul style="margin:0;padding:0;border:1px solid #e8e2e2;margin:1rem;height:15.5rem;overflow-y:auto;border-radius:0.2rem;background:#FFFFFF;">';
		foreach( $rule1['r_name']  as $k => $v )
		{
			if( $rule1['r_on'][$k] == 'on' ) 
			{
				$html .= '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="'.$row['id'].'-'.$k.'"/><span class="tollbox_all">'.$v.' '.SHUTIANYK_PAGE_1.$rule1['r_day'][$k].YENS_PAGE_4.'  ';
				if( $rule1['r_radio'.($k+1)] == 3 )
				{
					$html .= ' <s>'.YENS_PAGE_2.'&yen;'.$rule1['r_srcpay'][$k].YENS_PAGE_1.'</s> ';				
					$html .= ' '.YENS_PAGE_3.'&yen;'.$rule1['r_fra'][$k].YENS_PAGE_1.' ';
				}
				else 
				{
					if( $rule1['r_radio'.($k+1)] == 1 )
					{
						$html .= ' '.YENS_PAGE_2.'&yen;'.$rule1['r_srcpay'][$k].YENS_PAGE_1.' ';	
					}
					elseif( $rule1['r_radio'.($k+1)] == 2 )
					{		
						$html .= ' '.YENS_PAGE_3.'&yen;'.$rule1['r_fra'][$k].YENS_PAGE_1.' ';
					}					
				}
				$html .= ' </span></label></li>';
			}
		}
		$html .= '</ul></form>';
	    $html .= '<div style="margin:1rem;line-height:2rem;padding:0 0.8rem;font-family:Microsoft Yahei,monospace;color:#1b9adc;"><img src="'.$showImg.'" width="21" height="21" align="absmiddle"/><span class="tollbox_all2">'.SHUTIANYK_PAGE_3.'</span></div>';
	    $html .= '<div style="margin:1rem;padding:0 0.8rem;text-align:right;"><input type="image" src="'.$bottonImg.'" width="70" onclick="exam.sendpays(\'FrmListID\');"/></div>';
	    $html .= '</div>';	
	}
	
	if( $html != null )
	{
		echo json_encode(array("error"=>0,'txt'=>$html));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
}
function send_pays()
{
	$string = htmlspecialchars($_POST['vip'],ENT_QUOTES);
	
	$pay = 0;
	
	if( $string != null )
	{
		$arr = explode('-', $string);
		
		$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('pid'=>$arr[0]))->get()->array_row();
		if( !empty( $row ) )
		{
			if( $row['tariff'] == 1 )
			{
				$rule1 = unserialize($row['rule1']);
			}
		}
						
		if( !empty( $rule1 ) )
		{
			foreach( $rule1['r_name'] as $k => $v )
			{
				if( $rule1['r_radio'.($k+1)] == 1 )
				{
					$pay = $rule1['r_srcpay'][$arr[1]];
					break;
				}
				else
				{
					$pay = $rule1['r_fra'][$arr[1]];
					break;
				}
			}
						
		}
		
	}
	
	if( $pay != 0 )
	{
		session_start();
		$_SESSION['exam_pays'] = $pay;
		
		echo json_encode(array("error"=>0,'txt'=>$pay));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
	
}
function payments()
{
	session_start();
	
	$pay = $_SESSION['exam_pays'];
	
	print_r( $pay );
}
function free_sion()
{		
	session_start();
	
	include( getThemeDir3() );

	$flagId = htmlspecialchars(GetIndexValue(1),ENT_QUOTES);
	
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('id'=>$flagId))->get()->array_row();
	
	if( !empty( $row ) )
	{
		$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$row['pid']))->get()->array_row();
	}
	if( !empty( $ify ) )
	{
		$ifyArr = UpwardsLookup3( $ify['pid'] );
		if( !empty( $ifyArr ) )
		{
			foreach( $ifyArr as $k => $v )
			{
				$html .= ($html==null?'<a href="'.apth_url('subject/bim/module/exam.html').'">'.HOME_PAGE_1.'</a> &gt; ':' &gt; ').'<a href="'.apth_url('index.php/exhibition/'.$v['id']).'">'.$v['title'].'</a>';
			}
		}
	}
			
	$bread = $html==null?'<a href="'.apth_url('subject/bim/module/exam.html').'">'.HOME_PAGE_1.'</a> &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>':$html.' &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>';
		
	$num = $_SESSION['CHOOSEANSWER2'];
	$type = $_SESSION['CHOOSEANSWER3'];
	
	require( base_url_name( SHOWFREETEMPLATES_1 ) );
}
function FreePractice()
{
	session_start();
	
	$flagtype = htmlspecialchars($_POST['type'],ENT_QUOTES);
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('id'=>$flagId))->get()->array_row();
	
	if( !empty( $row ) )
	{
		$solve = $row['solve'];
		$id = $row['pid'];
		
		switch ( $solve )
		{
			case 0:
				if( $row['roomsets'] == 0 )
				{
					$sql = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$flagtype.' and pid in('.$id.') ';
					/*$sql = 'SELECT id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state FROM '.PRE.'examination WHERE typeofs='.$flagtype.' and pid in('.$id.') and  id >= ( ( ( SELECT MAX(id) FROM '.PRE.'examination ) - ( SELECT MIN(id) FROM '.PRE.'examination ) ) * RAND() + ( SELECT MIN(id) FROM '.PRE.'examination ) ) ';*/
				}
			break;
			case 1:
				if( $row['roomsets'] == 0 )
				{
					$All = UpwardsLookup5($id);
					$tmp = '';
					if( !empty( $All ) )
					{
					 	foreach( $All as $k => $v )
					 	{
					 		$tmp .= ($tmp==''?'':',').$v['id'];
					 	}
					 	
					 	$sql = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$flagtype.' and pid in('.$tmp.') ';					 	
						/*$sql = 'SELECT id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state FROM '.PRE.'examination WHERE typeofs='.$flagtype.' and pid in('.$id.') and id >= ( ( ( SELECT MAX(id) FROM '.PRE.'examination ) - ( SELECT MIN(id) '.PRE.'examination ) ) * RAND() + ( SELECT MIN(id) FROM '.PRE.'examination ) ) ';*/
					}
				}
			break;
		}
		
		$TotalRows = db()->query($sql)->array_nums();
		$TotalShow = $_POST['shows']==null?1:$_POST['shows'];
		$TotalPage = ceil($TotalRows/$TotalShow);
		$page = $_POST['page']==null?1:$_POST['page'];		
		if($page>=$TotalPage){$page=$TotalPage;}
		if($page<1 || !is_numeric($page)){$page=1;}
		$offset = ($page-1)*$TotalShow;
		
		if( $row['roomsets'] == 0 )
		{
			$sql .= ' order by rand()*10000000 limit '.$offset.','.$TotalShow.' ';			
		}

		$xb = md5($flagId.$flagtype);
		
		if( !isset( $_SESSION[$xb][$flagtype] ) )
		{
			$row2 = db()->query($sql)->array_rows();
			$_SESSION[$xb][$flagtype] = $row2;
		}
		
		$rows = $_SESSION[$xb][$flagtype];
		$count = count( $rows );
		
		$tb = $_POST['tb']==null?'0':$_POST['tb'];
		
		$BBID = $_SESSION['CHOOSEANSWER'][$rows[$tb]['id']]['k'];
		
		$number = $tb==0?'1':$tb+1;
		
		$mixin = '';
		$lxImg = 'data:image/png;base64,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';    	
		
		if( !empty( $rows ) )
		{
			$mixin .= '<div class="exam_freesiondiv4"><span>考场编号（'.$row['centreno'].'）</span> &nbsp; <span>'.$row['title'].'</span> &nbsp; <span>'.($row['roomsets']==0?'练习':'正式').'</span> <img src="'.$lxImg.'" width="30" height="30" align="absmiddle"/></div>';
    		$mixin .= '<p class="exam_freesionp0">题型：<b>'.GetFourTypes2($flagtype).'</b> &nbsp; （ 共 <span class="exam_countall">'.$count.'</span> 题 ）</p>';
    		$mixin .= '<p class="exam_freesionp1"><span>'.$number.'.</span> '.$rows[$tb]['dry'].'</p>';
    		$mixin .= '<p class="exam_freesionp2">请选择答案：</p>';
    		$mixin .= '<form id="exam_freesionform0">';   		
	    	if( $flagtype == 1 )
	    	{    	
	    		$daanArr = explode('-', $rows[$tb]['options']);
	    		
		    	$mixin .= '<ul class="exam_freesionul0">';
		    	if( !empty( $daanArr ) )
		    	{
		    		foreach($daanArr as $k => $v )
		    		{
		    			$ds = mb_substr($v, 0, 1,'utf-8');
		    			if( strtolower($ds) == $BBID )
		    			{
		    				$mixin .= '<li class="exam_freesionli0"><label><input type="radio" name="rightkey" checked="checked" value="'.$ds.'"/>'.$v.'</label></li>';
		    			}
		    			else
		    			{
		    				$mixin .= '<li class="exam_freesionli0"><label><input type="radio" name="rightkey" value="'.$ds.'"/>'.$v.'</label></li>';
		    			}
		    		}
		    	}
		    	$mixin .= '</ul>';
	    	}
	    	elseif( $flagtype == 2 )
	    	{
	    		$daanArr = explode('-', $rows[$tb]['options']);
	    		$mixin .= '<ul class="exam_freesionul0">';
	    		if( !empty( $daanArr ) )
		    	{
		    		foreach($daanArr as $k => $v )
		    		{
		    			$ds = strtolower( mb_substr($v, 0, 1,'utf-8') );
		    			if( strstr($BBID, $ds) )
		    			{
		    				$mixin .= '<li class="exam_freesionli0"><label><input type="checkbox" name="rightkey'.$k.'" checked="checked" value="'.$ds.'"/>'.$v.'</label></li>';	
		    			}
		    			else 
		    			{
		    				$mixin .= '<li class="exam_freesionli0"><label><input type="checkbox" name="rightkey'.$k.'" value="'.$ds.'"/>'.$v.'</label></li>';
		    			}
		    		}
		    	}
		    	$mixin .= '</ul>';		    	
	    	}
	    	elseif( $flagtype == 3 )
	    	{
	    		$daanArr = explode('-', $rows[$tb]['options']);
	    		$mixin .= '<ul class="exam_freesionul0">';
	    		if( !empty( $daanArr ) )
		    	{
		    		foreach($daanArr as $k => $v )
		    		{			
		    			if( $v == $BBID )
		    			{    			    			
	    					$mixin .= '<li class="exam_freesionli0"><label><input type="radio" name="rightkey" checked="checked" value="'.$v.'"/>'.$v.'</label></li>';	
		    			}											
		    			else
		    			{
		    				$mixin .= '<li class="exam_freesionli0"><label><input type="radio" name="rightkey" value="'.$v.'"/>'.$v.'</label></li>';	
		    			}
		    		}
		    	}
				$mixin .= '</ul>';	
	    	}  
	    	$mixin .= '</form>';  	
	    	
	    	$okImg = 'data:image/png;base64,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';
			$noImg = 'data:image/png;base64,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';
	
	    	$zqda = strtolower( $rows[$tb]['answers'] );
	    	if( $BBID != null )
	    	{
	    		$xxgg = array('×'=>'错误','√'=>'正确');
	    		if( $BBID == $zqda || $BBID == $xxgg[$zqda] )
				{
	    			$mixin .= '<p class="exam_freesionp3">你选择（'.strtoupper($BBID).'），答案正确<img src="'.$okImg.'" width="20" height="20" align="absmiddle"/></p>'; 	
				}
				else
				{
					$mixin .= '<p class="exam_freesionp3"><font color="red">你选择（'.strtoupper($BBID).'），答案错误<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">正确答案是：'.strtoupper($zqda).'</font></font></p>'; 
				}
				$flag = 1;
	    	}
	    	else 
	    	{
	    		$flag = 0;
	    		$SelImg = 'data:image/png;base64,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';				
	    		$mixin .= '<p class="exam_freesionp3"><img src="'.$SelImg.'" width="20" height="20" align="absmiddle"/> <font color="#00ce6d">请选择答案</font></p>'; 
	    	}
	    	$mixin .= '<div class="exam_freesiondiv3">';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0 ExambtnNext1" onclick="exam.Determine(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\')" value="确定"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0" onclick="exam.give_up(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\');" value="放弃"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0 ExambtnNext" value="下一题" onclick="exam.NextQuestion(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\')"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0" value="单选题"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0" value="多选题"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0" value="判断题"/> ';
	    	$mixin .= '</div>';	    		    	
		}
		
		echo json_encode( array( 'error'=>0,'txt'=>$mixin,'f'=>$flag,'count'=>$count ) );
	}
	else
	{
		echo json_encode( array( 'error'=>1,'txt'=>SHOWINFO_ON_1,'f'=>0 ) );
	}
}
function EDetermine()
{
	session_start();
	
	$okImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAANm0lEQVR4Xu2dTVZbORbHr9yQ9KwNG2g4JzBtagVFVtD0CooMA4NQKwi9AlwDO0NSKwi9glArSHqKcw6pDYB7mOBj9dEzJo6D/SQ96ele6c8w1uf/6hfpXn08RfiDAlBgqQIK2kABKLBcAQCC0QEFVigAQDA8oAAAwRiAAn4KYAbx0w25ClEAgBRiaHTTTwEA4qcbchWiAAApxNDopp8CAMRPN+QqRAEAUoih0U0/BQCIn27IVYgCAKQQQ5fezW7/am90vPvRVQcA4qoY0otTYPPN8DVpOr052nEe784ZxKmDBhergJk1FNG5UmrPiABAih0K6PiiAt3+1auOUr35fwcgGCfFK9B9c72l9PhcEe0vigFAih8eZQvQHXw6UFqfK0Xdx5QAIGWPj6J7vzkYnhHRySoRAEjRQ6TMzldLqsndu5kjDkDKHAfo9SMK1C2p4INg2BSrgM2SCoAUOzzK7Xj37Lqrno7fPRalqlMFPkidQvhdtALVxp+id4rUlk9HAIiPasgjQoFu/+pQkTpbFsK16QQAsVEJacQp4ONvYB9EnJnRYFcF7v0Nsyt+4JoXgIRQDGWwVaCC48nde5v9DdtOYIllqxTSsVZgegpXvW/ib2AGYW1iNM5XAdfNP5d6MIO4qIW07BQwkaqOUuexGgZAYimLcqMrECpStaqhACS6GVFBDAU2+1fnpNRhjLLnywQgsRVG+cEVaAsO03AAEtx8KDCWAjHCuHVtBSB1CuF3FgqkgAMzCAvToxF1CqSCA4DUWQa/J1cgJRwAJLn50YBVCqSGA4BgfLJVwOXeeMxOwEmPqS7K9lIg1rkqn8YAEB/VkCeaAhyWVfOdAyDRTI2CXRXgBgd8EFcLIn00BTjCAUCimRsFuyjAFQ4A4mJFpI2iAGc4AEgUk6NQWwW4wwFAbC2JdFEUaPNUrm8HEMXyVQ75GikgAQ7MII1MjMy+CkiBA4D4Whj5vBWIfYfcu2FLMmKJFVpRlLdUAWlwYAbBYG5NAXO+qqPUh9YqDFQRZpBAQqKY5QpwOnzoaicA4qoY0jspMH0r9+6D7+cHnCqLkBiARBAVRU4VkLARWGcrAFKnEH73VkBSOHdZJwGIt/mRcZUCm/3hKSl6LV0lACLdggzbLzGcixmE4UDKsUmSI1aP2QMzSI6jNFGfpk75+Dr0NzoSdaeqFoCkVD+zujf6Vx9Cft2JgzwAhIMVMmhDDhErLLEyGIgcu5CTU76oL2YQjiNOUJuknrGylRiA2CqFdD8okKNTjhkEAz2YAjk65QAk2PAou6DN/qceKf0qdxWwxMrdwhH6Zz673CH9LkLR7IoEIOxMwrtB01fXxx9y2gxcpTgA4T0e2bWuBL9jXnQAwm4I8m1QKX4HAOE7Btm2rCS/A4CwHYY8G1bCfscy5bHE4jkmWbVqYzB8r4j2WTWqpcYAkJaEllpNLjcDffUHIL7KFZAv93NWNiYEIDYqFZhG+nM9oUwGQEIpmVk5JYZ0F02oNf15e7yz5Wpa5ZoB6WUpUGpI11hJE/1Pkb6YaOqNjnc/+lgOgPioJiRPqSHdCgxNvcnXtd7o1+1RE3MBkCbqMc+7MRi+U0QHzJsZrHkhwZg1CoAEMw+vgspbWunfJ1/WT5rOGItWBCC8xnWQ1pR0Stc437pDh6OXO5dBxFsoBIDEUDVxmcXslmv6983xzmlMuQFITHUTlN0dDE86RGcJqm6tSk36v1rToW9kyqWhAMRFLeZpi1haafXb5OtfTkP7GstMC0CYD3qX5uUctTIRKk3qcHT07MJFk6ZpAUhTBZnkzzlqpYn+0F/WDtqaNeZNCkCYDPAmzch6Q7AFR3yV9gCkychkkjfHpVWqJRX2QZgM6lDN6L4Z7nc0vQ9VHodyqiiVWj8Yvdz+nLo9mEFSW6BB/XkeY4+zI+4rMwDxVY5BvuxuCCb2Nx4zKQBhMNB9mpDTDUEu/gYA8RmJTPPkcpykgkPr/TZ2xX1MiRnER7XEeXL5yE3ljH9Z30+xv2FrQgBiqxSTdPnsefByxpeZF4AwGfi2zcjjfrn+/eZo99C2zynTAZCU6jvWnYNjPiH6dXS003PserLk2QHSHXz6RenJiSZ6wdXx87W2dMd8orWxyVvf/qfIlw0gZkdZaXo9e1ZTaxpp0s9zgUSyY15FqhQdxLr1FxMc8YAYp7Xz5O6MlPphTatJf9Zf1n/iHCWxMa7kHXPuYdw6/UUDsvlm+FpP6GTVF5K01h/11/XnkiGRumMuHQ4Dj0hAzN0HRZMzRcrqpTzJkJhbgh09vq77n47b7xL2OGw0EwWIieIopc58nu+XConEo+y5wCFmBlnlZ9j8LzBLo4kub492nrvkSZlW4lH2nOAQAYiNn+E0iLV+e3O8+8IpT6LE0sK6ucHBGhBXP8NpDAuARFpYN0c4WAJSPV2jx+c+fkYukMgL68o4V+U0Pu4Ts3HSKz/j6fg1EZ34dMQrD8MLOqYfssK6cs5V+YwRFoB0+1evFKnTVfsZPp2zycPt+IOs07p5w5F8iTU9HqLPbfczbAa8TxpOkMiZPfKHIxkgrfkZDrRwgETOpmAZcLQOSBI/wwUSUv9q+2nL+eZtDq7eEqlfHJqcIGk5cLQKyPQYuu6l8DNsR1HKE8ASZg8Tyr092t2z1TOHdNGd9MrPmOgzpZQIYVNBwn32yHWfow7iaIDc+xnm3JS4b+S1DQn32aNUOKIssSo/46/jV6Qp6pd/6shv+nubkHA+UlIyHMEBkeBnuIDTxglgzgcSS4cjGCDS/AxOkHCdPaqPY35d25N80czFzsvSNvJBJPsZLuLFmkm4zh453AR0se+qtF6AzPyMuuuuoRrJoZwYkHCcPQDH96PND5D+1aFSqqeI/sZh8LbWhoDH5DnOHoDjx5HkBcisGHNn4f6Q4d9bG6SpKwoEyUZ/eKEU/TN1d+br53DchpMe4Zz00kBpCAnHfQ/A8TiajWaQxSKLmlEaQMJt11zac6BtzjJBAflu6VWAj+IzsPjNHmUdPnSFKwogphHTl0jGJ1rRSc7OvOvShNfsATjqgIkGyMNsUl2lvevxP8ZdJ9Xy320huT/uf+tfU7ic2CW30zI6IHPLLvPomwkN/2zXNFmpbCDhclsQcNiPrdYAeQDFPBs6vReSXWh4ovVPy16T53LXHHsd9nAEC/O6VfnNPyFF5hWTbP5WnQDm8s7VKoizMUTAjrQ+g8y3/f4s19ucll3LINkYXF3jcYqAI7elopIC8m3ZNTSRrtNcol2LkLA4VsL0DbCWxrl3NSwAmYWF1ZPxW27HL3yVrSD5urZtjounP1aCcK6vHdkA8p0TT9osu8QfhKxOABO96Cj1wddATfMhYtVMQXaA5DibNDORf+4qYvVlbav0S0/+CjL/wtT0hfc8ZpMmRvLJi3Cuj2o/5mE5g+Qe6QpjutWl2GxcttEO6XWwB2Q+0tUhOpMueCvt1+q3m+Nn7b2S30qn0lQiBpDKNzHfKCRlLhpltwsfyvxa039uj3fEvUUWqv+hyxEFCBz41eZHxCo0Hsyd9FXd7Q6GJ1hyfVMITnl4OEyJ4maQ7xx4LLke5Jgkfpk+zvBMX6poQB6WXE/HFzmd53IeFnDKnSWzzSAekFlHN/ufeqT0K9uO55JOE/1xe7Szn0t/uPUjG0Duo1xFvdeFnfL4OGUFyEMoWKnLHM5y1ZkfdzvqFGr+e3aAVJBU31q/u1Ck/tFcIp4l+LyowrMnvFuVJSC5O+/YDGwPqmwBeXDeRXwY097g+CyBvVYhUmYPiBEppwgX/I4Qw96+jCIAmUW4Okqd20vDLyX8jvZtUgwg0iHBfkf7cJgaiwJEKiTY70gDR5GAVJAIu6k4UfR89HLnMt0wKbfm4maQmamruyUSNhRxziopncUCcr/cYg2Jud9xe7S7l3SEFF550YDMIEn5LM+q8YeQbno6iweEq+OOkG56OIp10h+Tnsvj0qZtCOnygAOALNiBAyRVSFet7Y1ebn/mM0zKbQmWWAu2T/2RGyyteMEIQB6xR6rvCGJpxQsOLLFW2KPtF9mxW84PDgCywibVJ9Oe3l22dekKr5IAEJ4K1EIy/hz7+i4uQPEdGvBBamwT+0gKolZ84cASy9I2McO/iFpZGiFRMswglsLHuJWIqJWl+AmTARAH8TcGVx9DOu0TtbaNDUEHAyRICkAcRJ9GtgI57fjqrIPy6ZICEEftQ3zS2bxMcnu8s+VYNZInUACAeIje9DgKbgh6iJ4oCwDxFN7XH8Geh6fgibIBEE/hp8+bjj+6bCLiOImn2AmzAZAG4rt+5Qp7Hg3ETpQVgDQUfmMwNC/J/1xXDBzzOoV4/g5AGtrFdqkFx7yh0ImyA5AAwtctteCYBxA5UREAJJDwq5Za2DEPJHKCYgBIINHNqd9Hnw/CjnkghdMUA0AC6r64gYiwbkBxExUFQAIKv3hWC2HdgOImKgqABBZ+dncEYd3AwiYqDoBEEN447JpUb3T07CJC8SiyRQUASASxzd4I7nlEEDZBkQAkgeioUo4CAESOrdDSBAoAkASio0o5CgAQObZCSxMoAEASiI4q5SgAQOTYCi1NoAAASSA6qpSjAACRYyu0NIECACSB6KhSjgIARI6t0NIECgCQBKKjSjkKABA5tkJLEyjwf1ytMiOR/0xKAAAAAElFTkSuQmCC';
	$noImg = 'data:image/png;base64,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';
	
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$rightkey = $_POST['rightkey'];
	$rightkey2 = strtolower($rightkey);
	
	$num = $_POST['n'];
	$type = $_POST['type'];
	
	$_SESSION['CHOOSEANSWER'][$flagId] = array('n'=>$num,'k'=>$rightkey2,'id'=>$flagId);
	$_SESSION['CHOOSEANSWER2'] = $num;
	$_SESSION['CHOOSEANSWER3'] = $type;
	
	$row = db()->select('id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state')->from(PRE.'examination')->where(array('id'=>$flagId))->get()->array_row();
	if( !empty( $row ) )
	{
		$zqda = strtolower( $row['answers'] );
		
		if( $rightkey2 == $zqda )
		{
			echo json_encode( array( 'error'=>0,'txt'=>'你选择'.strtoupper($rightkey2).'，答案正确<img src="'.$okImg.'" width="20" height="20" align="absmiddle"/> ' ) );
		}
		else
		{
			echo json_encode( array( 'error'=>0,'txt'=>'<font color="red">你选择'.strtoupper($rightkey2).'，答案错误<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">正确答案是：'.strtoupper($zqda).'</font></font> ' ) );
		}
	}
	else
	{
		echo json_encode( array( 'error'=>1,'txt'=>SHOWINFO_ON_1 ) );
	}
}
function give_up()
{
	session_start();
	
	$noImg = 'data:image/png;base64,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';
	
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$num = $_POST['n'];
	$type = $_POST['type'];
	
	$row = db()->select('id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state')->from(PRE.'examination')->where(array('id'=>$flagId))->get()->array_row();
	if( !empty( $row ) )
	{
		$zqda = strtolower( $row['answers'] );
		
		$_SESSION['CHOOSEANSWER'][$flagId] = array('n'=>$num,'k'=>'放弃','id'=>$flagId);
		$_SESSION['CHOOSEANSWER2'] = $num;
		$_SESSION['CHOOSEANSWER3'] = $type;
		
		echo json_encode( array( 'error'=>0,'txt'=>'<font color="red">你选择 (放弃)，答案错误<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">正确答案是：'.strtoupper($zqda).'</font></font> ' ) );
	}
	else
	{
		echo json_encode( array( 'error'=>1,'txt'=>SHOWINFO_ON_1 ) );
	}
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */