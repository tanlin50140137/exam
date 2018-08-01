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
	require( base_url('system/Classes/PHPExcel.php') );
	require( base_url('system/Classes/PHPExcel/IOFactory.php') );
	require( base_url('system/Classes/PHPExcel/Reader/Excel5.php') );
	
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
	
	require( base_url('system/Classes/PHPExcel.php') );
	require( base_url('system/Classes/PHPExcel/IOFactory.php') );
	require( base_url('system/Classes/PHPExcel/Reader/Excel5.php') );
	
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
	
	require( base_url('system/Classes/PHPExcel.php') );
	require( base_url('system/Classes/PHPExcel/IOFactory.php') );
	require( base_url('system/Classes/PHPExcel/Reader/Excel5.php') );
	
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
			$TypeName = 'data:image/png;base64,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';			
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
			$TypeName = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAASCAYAAACEnoQPAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28AAgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaOWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHiwmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryMAgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0lYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHiNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYAQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6cwR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBiewhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1cQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqOY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hMWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgohJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSUEko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/pdLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Yb1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7OUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsbdi97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxrPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H08PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+Hvqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsGLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjgR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4qriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWYEpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1IreZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/PbFWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYji1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVkVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0IbwDa0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vzDoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+yCW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawto22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtdUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3rO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv9563Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+UPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAJPSURBVHjapJRNSFRRFMd/b5xxnASl0TIhrbFmFwa2acpVtAiqRVSbEIogKJGoyY21qSBFSCERS6KBQDBo1SZKCJ1VzBS6skwFCbNFks2bj4e+ue+eFs+ZaTbRx11dzjn///n632uICP96vABTU1N/xBCJRPD7/UbRICJMTk6KyudFqbw4jhLHUaK1I1o7olRetHYkmUzKxMSEmGlTRAQRwVMgEATEvRdsAB6PBwDbtmlvbyeZSGKapgAuWGv9GwK3ylwuRzweRylFIpEo9SwiIEKhcQMQwDAMllM2918vc+3IYQLKxLZtPs3Pl8Baay5cvo5Gk0mnXQIDKr0+hkYfM7KwwfcmzdihHQB8nJujrOyHD/qp2dnMlisxQh1D1OyLEBsdJuAzOLe/nudLazydXS2bvgfAcRw6oz1kV1a4OvWMqvoKch/ecf5SJ99yCn86xb0WiL76QiG+LPPIQB97wmFuT79gpvciG1aOsdgjdtf6SEqG7kgTwfVqRAStdXnPXd03ERGC0XFObs1TufSG2Mu3OOGD1Pj8TH9Os2JZZWAPgFKK4YE+1oIhQr4UzQ0+BhdD3F3dS3TGws5W8dW0udNaDeLGl62q60YPdUD8VgcNZ04xHTyL8q7Dj3UW0mkaj9Zx7HQIQYo68AKYpsnIQC/G5m6NigrGn8zy3vGDCG3hKlobq4taME2zBM5kMq6joA7HYfD4LhZTNmlbc6KltpjNKMQXwNbmIAwMxHAl2rYtwIHtAbcSjF+kKliWVQJns1n6+vv/+j0b//MZ/BwAEbBVnBw348IAAAAASUVORK5CYII=';
		}
		elseif( $ext == $ImgName[14] )
		{
			$TypeName = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAASCAYAAACEnoQPAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28AAgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaOWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHiwmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryMAgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0lYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHiNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYAQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6cwR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBiewhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1cQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqOY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hMWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgohJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSUEko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/pdLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Yb1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7OUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsbdi97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxrPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H08PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+Hvqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsGLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjgR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4qriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWYEpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1IreZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/PbFWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYji1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVkVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0IbwDa0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vzDoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+yCW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawto22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtdUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3rO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv9563Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+UPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAJPSURBVHjapJRNSFRRFMd/b5xxnASl0TIhrbFmFwa2acpVtAiqRVSbEIogKJGoyY21qSBFSCERS6KBQDBo1SZKCJ1VzBS6skwFCbNFks2bj4e+ue+eFs+ZaTbRx11dzjn///n632uICP96vABTU1N/xBCJRPD7/UbRICJMTk6KyudFqbw4jhLHUaK1I1o7olRetHYkmUzKxMSEmGlTRAQRwVMgEATEvRdsAB6PBwDbtmlvbyeZSGKapgAuWGv9GwK3ylwuRzweRylFIpEo9SwiIEKhcQMQwDAMllM2918vc+3IYQLKxLZtPs3Pl8Baay5cvo5Gk0mnXQIDKr0+hkYfM7KwwfcmzdihHQB8nJujrOyHD/qp2dnMlisxQh1D1OyLEBsdJuAzOLe/nudLazydXS2bvgfAcRw6oz1kV1a4OvWMqvoKch/ecf5SJ99yCn86xb0WiL76QiG+LPPIQB97wmFuT79gpvciG1aOsdgjdtf6SEqG7kgTwfVqRAStdXnPXd03ERGC0XFObs1TufSG2Mu3OOGD1Pj8TH9Os2JZZWAPgFKK4YE+1oIhQr4UzQ0+BhdD3F3dS3TGws5W8dW0udNaDeLGl62q60YPdUD8VgcNZ04xHTyL8q7Dj3UW0mkaj9Zx7HQIQYo68AKYpsnIQC/G5m6NigrGn8zy3vGDCG3hKlobq4taME2zBM5kMq6joA7HYfD4LhZTNmlbc6KltpjNKMQXwNbmIAwMxHAl2rYtwIHtAbcSjF+kKliWVQJns1n6+vv/+j0b//MZ/BwAEbBVnBw348IAAAAASUVORK5CYII=';
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
			$TypeName = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAASCAYAAACEnoQPAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28AAgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0ST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaOWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHiwmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryMAgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0lYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHiNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYAQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6cwR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBiewhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1cQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqOY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hMWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgohJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSUEko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/pdLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Yb1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7OUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsbdi97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83MDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxrPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1U27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H08PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+Hvqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsGLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjgR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4qriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWYEpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1IreZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/PbFWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYji1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVkVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0IbwDa0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vzDoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+yCW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawto22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtdUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3rO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv9563Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+UPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAFESURBVHjapJRLTgJBEIa/IkY9gm7wGGpYyuEMV2ID7Bz1AnoA2eEwMAumun8X7bzCaHzUqlOp/9WVbpPEX+sEYLlc/ojh+uaW87NTaxqSWCwW8qqSe6UQXCG4YgyKMci9UoxBWZZpPp9rs91KEpIY1QRCoHSuewCj0QiAqqqYTCY8Zxmb962ABI4xfksAsN/vWa1WuDtPjw9tZkkgUY8aIMDMkISZMZ3esX5bczgceHl95UiZT3WJdO44kMTF5QXjqzExxla5AffKsBQEw5KdoVWFEJIaSpZr33UAA1OiMjNCCF8rdwm6PJbu89h2ytuMDtrHDKQ+2N2PMvdp+vndvb8qqdZtYUM+sHb/JwB5nqehAYIh+3met+CiKFLmby6pG6coihZcluWnbUPNdHdN/SBlWbbg3W7H/Wz26/ds//kMPgYAb9UVaHaTjmwAAAAASUVORK5CYII=';
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
				$html .= ($html==null?'<a href="'.$url.'">首页</a> &gt; ':' &gt; ').'<a href="'.apth_url('index.php/exhibition/'.$v['id']).'">'.$v['title'].'</a>';
			}
		}
		
		$bread = $html==null?'<a href="'.$url.'">首页</a> &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>':$html.' &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>';
	    
		$examImg3 = 'data:image/png;base64,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';
		
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
				$li1 .='<li class="exam_minationli0"><a href="#" target="'.$target.'">'.$mishu.'</a><p><img src="'.$examImg3.'" width="100" height="35" align="absmiddle"/></p></li>';
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
	static $rows;
	
	$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('pid'=>$id))->get()->array_rows();
	if( !empty( $ify ) )
	{
		foreach( $ify as $k => $v )
		{
			$rows[] = array('id'=>$v['id'],'title'=>$v['title']);
			UpwardsLookup3($v['id']);
		}
	}

	return $rows;
}

/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */