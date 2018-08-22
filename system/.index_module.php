<?php
/**
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 */
header('content-type:text/html;charset=utf-8');
function index()
{
	include( getThemeDir3() );
	
	require( base_url_name( SHOWINDEX_1 ) );
}
function reset_u()
{
	include( getThemeDir3() );
	
	require( base_url_name( SHOWRESET_1 ) );
}
function GetUsersName()
{
	session_start();
	if( !isset( $_SESSION['usersname'] ) || $_SESSION['usersname']==null )
	{
		echo '<script>open("'.apth_url('').'","_parent");</script>';exit;
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
		echo '<script>open("'.apth_url('').'","_parent");</script>';exit;
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
		$objPHPExcel->getActiveSheet()->setCellValue($code[3].$i, $v['options']);
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
		$data['options'] = trim($options);
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
			$data['options'] = trim($options);
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
		
		$d = 'data:image/'.$ext.';base64,';		
		$str1 = file_get_contents( $file['tmp_name'] );
		$str2 = base64_encode( $str1 );	
			
		$data['covers'] = $d.$str2;

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
		
		$d = 'data:image/'.$ext.';base64,';		
		$str1 = file_get_contents( $file['tmp_name'] );
		$str2 = base64_encode( $str1 );	
			
		$data['covers'] = $d.$str2;

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
			$TypeName = 'data:image/png;base64,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';
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
		
		$voidArr = array('E','C');
		$pcArr = array('P','J');
			
		if( !empty( $searchkc ) )
		{
			foreach( $searchkc as $k => $v )
			{
				$mishu = $v['title'];
				if( mb_strlen($v['title'],'utf-8') > $contlen )
				{
					$mishu = mb_substr($v['title'], 0,$contlen ,'utf-8').'......';
				}
				
				$bel = $voidArr[$v['tariff']].$pcArr[$v['roomsets']];
				
				if( $v['tariff'] == 1 )
				{
					$li1 .='<li class="exam_minationli0"><a href="javascript:void(0);" flagid="1" onclick="exam.TollBoxShows(this);">'.$mishu.'</a><p><img src="'.$examImg3.'" width="100" height="35" align="absmiddle"/><img src="'.$examImg5.'" width="40" height="35" align="absmiddle"/></p></li>';
				}
				else 
				{
					$li1 .='<li class="exam_minationli0"><a href="'.apth_url('index.php/free_sion/'.$v['id'].'/'.$bel).'" target="'.$target.'">'.$mishu.'</a><p><img src="'.$examImg3.'" width="100" height="35" align="absmiddle"/><img src="'.$examImg4.'" width="40" height="35" align="absmiddle"/></p></li>';
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
	if( $pid !== null )
	{
		$ify = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->where(array('id'=>$pid))->get()->array_rows();
	}
	if( !empty( $ify ) )
	{
		foreach( $ify as $k => $v )
		{
			$rows[] = array('id'=>$v['id'],'title'=>$v['title']);
			UpwardsLookup3($v['pid']);
		}
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
	
	$voidArr = array('E','C');
	$pcArr = array('P','J');
	
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
			
			$bel = $voidArr[$v['tariff']].$pcArr[$v['roomsets']];
			
			if( $id != $v['pid'] )
			{
				if( $v['tariff'] == 1 )
				{
					$li0 .= '<li class="exam_hottestli0"><a href="javascript:void(0);" flagID="'.$v['id'].'" onclick="exam.TollBoxShows(this);">'.$mishu.'</a><p class="exam_hottestlip0"><img src="'.$hotImg2.'" width="100" height="35" align="absmiddle"/><img src="'.$hotImg5.'" width="40" height="35" align="absmiddle"/></p></li>';
				}
				else 
				{
					$li0 .= '<li class="exam_hottestli0"><a href="'.apth_url('index.php/free_sion/'.$v['id'].'/'.$bel).'" target="'.$target.'">'.$mishu.'</a><p class="exam_hottestlip0"><img src="'.$hotImg2.'" width="100" height="35" align="absmiddle"/><img src="'.$hotImg4.'" width="40" height="35" align="absmiddle"/></p></li>';
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
		if( !empty( $toprows ) )
		{	
			$topId = $toprows[0]['id'];
		}
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
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('id'=>htmlspecialchars($_POST['flagid'],ENT_QUOTES)))->get()->array_row();
	if( !empty( $row ) )
	{
		if( $row['tariff'] == 1 )
		{
			$rule1 = unserialize($row['rule1']);
		}
	}
	
	$vipImg = 'data:image/png;base64,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';
    $closeImg = 'data:image/png;base64,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';
    $showImg = 'data:image/png;base64,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';
    $bottonImg = 'data:image/png;base64,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';

    $html = '';
    
	if( !empty( $rule1['r_name'] ) )
	{
		$html .= '<div style="margin:0;padding:0;width:800px;height:500px;">';
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
		$html .= '</ul>';
	    $html .= '<div style="margin:1rem;line-height:2rem;padding:0 0.8rem;font-family:Microsoft Yahei,monospace;color:#1b9adc;"><img src="'.$showImg.'" width="21" height="21" align="absmiddle"/><span class="tollbox_all2">'.SHUTIANYK_PAGE_3.'</span></div>';
		$html .= '<div style="margin:1rem;padding:0 0.8rem;text-align:left;">';
		$html .= '<label><input type="radio" name="pay" value="1"/><img width="100" height="35" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAToAAABzCAYAAAAIYs5MAAAACXBIWXMAAA9hAAAPYQGoP6dpAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAGT/SURBVHja7F13fBzF9f/OzO5ek3Tqkqtc5W7ccAPcwDa2McUUE3rvDoRAAj9CKCGFkEIJxKE5gMFgY9w72MYVF9x7kXtXL1e2zPz+2N3T3UmyJfskl+h9PveR9sru7OzMm/e+8973ESEE6qVe6qVeLmWh9V1QL/VSL5e6SLE+4U4gIwCk+oAGPiAtACRzDnABJgQkQqD/L3UwIWGrCoXBAM0NnHIDJzzAQQZobYAT9UOxXurlIlF0K44VDtx15Nj1B08UPJOvqijRdGgC0HUAhFaY+JeYSrP+lkMB0bAAIQSSZMBDKeIlinS3B1lNMv5PbZz5Tac4R079cKyXeqml2XkuGN3PQM/DwJXfb/E/vHVPbrNjPsOZX1KCYlWACwbBKECJdSEKSikMoVvHljIguEiPqXXMKxwTQgBOoj63FB/hEEJAGDo8jCI+zolMp2w0So4vHdQhdW6XhvgmDVjTHjhcPzzrpV7Os6Lbqekp01ZuHvfjzkMjD6kKigJOBJ1eQJahSy4ISDAIwCFAKYUwUGHiX6qKrvJj294zQCkFhYCka+BGEM5AGZxCRQPqQ4skguv7dHzh5laN36wfnvVSL+dJ0S0Frlt5GI9NXLTj2r2lOgtIDGAeCKKAW4aMEAKwJjqsiQ5BzfdDFl604mPWsVHF8ZkUSU2/H9vfM+vYsCw2Clbh+0IIEGreOLW+T61uElwHNQSglyCVBNCjVUbhHVc1/Gd7BeM7AvVubb3UyzlIjXZddwW1xO8Xb/rNN99MGVFYWMgYY5AkyXTVLEzKVpz2XxIGypFLF6CLXD2s+wzvl+j7t/uKcw7DMEzlSCkURQEAbN68OfHzz+e8tnPvsVvrh2m91EsdWHR7gfhtAvd8NO/gn5bsPJ4g4jMRJBQGGAwSrStti01EuHqhCR7lCtZUzvfvz9yh5l9Oq75OuGVLrf7i3MT2CCGgXIARFa5gMTzCj/v7d15xUzvlyW7AhvohWy/1UksWXYlfb/Ttt0v/tWXLlgSPxwPOOarr8tqWy/+KNXemvghZdlFWcLT1J4QAY6b7O3PmzL6r1+0aUz9c66VeasmiWwzc9N6c3R/P312cjIQG8FsRKRwXZkZFtMKo5Bu22qnUwovedIi9RGN8UdcTBFQAgggwAQA6FKhI8hXgySHd5t7YGg+3u8h2ZBfNn3O/oiglnHNmPRuZEKLZ/8uyXNKn38Bp9dOxXmpLzhhH98Pizc9t2bIn2ZPcDkW6DmFZGbhADbRLNaWNUop58+Zd2z2ux4B2DVLGXwxt3rBhQ9vnn3tmQ+7xEw4bj6SUVopZXjlg4O5/vf/v7Aul7Xt270z88ccf39QNQyKElC+PwmBmu6nBOWeeuITjd9111wv/64pk7L/e+2LRokXDZZkJQojg3IyvCuHVggrDMAhRJOOOO+54Y8R11793QSi63UDK7JzA+5/sCPQtTe6CIHNAFwwckW5oVRZQbWNh0bufZ7KgYO2C4gyW6OmwtViiBdHXIeUmndnHIDCI+X0/nDjpklDkU/DmkoMfSaNTgoOASRf64J84fvzXK5YscTRITYeu6yCElCs5+24pAaUUn/xnbOshA69+8fpbbvnzhdD2t//21obJkydnORyKuVFkxUHaY58TAsMw8Iu779lcF4pu4pefvxUGa0iEEF0IIXFwKSMjY+PVQ0Z8fD776/s5825YsGBBvMMpmXizgBU3y8E5hyRJEEIgqGto06LVLy4YRefXkLJ48eLRnCdF7KbWY211536HW6kCJmZ39OhR59LlnicGXZF9wSu6vLy85KSkpBDWWBmAwAngcDjAGEVJSUn6hdDuTRs2Zi9btizLVmyEkJCis5+PwTkURcFbf/tH59puz22jbipY9/OaRLst4WIIAy6XC6++5ku/5bZb/3S++iwuLi6QnJwcL8nECq8ikQaP1e6grsHlcpXUuUdUlTX3+fq8iSsDmSh0ZyIouaETCaAVO1qQyvEsImrTKjItOSJo6PrR12PCflEwQUFggMAAJQKUiND3K744iODWVIy9Uq+qvaalKSq434QwEMKgExkB2YtDzpaYvDvQf2YpnrzgcRFChVB1a/MKsG9LCAED5kvAALeyZSilF0Qe9PjPPpl66ugxxDmcYBxgHKACYCAhxWcYBm65+fYtddGedT+vSdRK/dDLAtB8fqhlPgRLy6CW+aAG/CjIy8X2HZuHn88+M4hBdS0IQ9MhDA7dUKEbKrhugOsGdC0IQ1ehaUEYPOC5IBRdqd+fuW3btsvskIfTxcZdTBidfS8XOo4XHW8XsuqEgCRJKCoqIqtWrbrjQld0QlRcAivr/7DnIp3vNm/ftqn18uXL24S3y44yCI82oJTikUceuaYu2iTLMuyYVUmSIMsyZFmGJEmh9ymlxvnuO0ppaOxSaqZ82v0YHlsqSZJ63hXdAYDN3J7/zvqAG2XOJKiCgUd97fwqikhLy7aMQpYSNcCEDllokIUGBvPl4AYUQ4dDmC+F6JAhIEGACV7BUgy3sGJriVbf0o1YUAiBToGg7EKekoZluY7uc4J44IJXdsR+CQhSvlDa/UAFA+EUVACg5LxbdN9N+nbc3l27qdvtBuccIDyUzUIIgUQZikpLMOq2W3e3at+2zlhnDGIuEIJzCM7L56FRnmVzPkVVgxJg5nKDcAhOzJe9CQUGCgbGKfzFvvg69y6i39AMuPfv3391IAAwL7NWtciV9wK3IiCEGYALmGC3+b4FJlPrOwQQggCMRiiVC+X+otthHpv9L8syTp065Ni+/fiIYV0yP71QnwXnnEZbpwQV8Ufbc9B13Xk+27tnz67EhQsXXh7tsRBCQmseIQSyLOOuu+569HyNi4hNnbPwrhYuXHjLv9979yOXy6UKYVAhBKnIvVPBJhLm9YmglHIhDGZe32zPzp07vSYWKypdrO32MsawYMGCbgeOHjkSCAQchFqrSDkJBhFCgFnvc84JpVQYvFz/2OdkjOnFZaWu66+//qv7H3joiRopug2FGLOzNB6q2w0DkqkMCA8piwuBq9PsNPuGrd1XcMiGjmRRgBT4kaSXQrLAMMrDBojFLqITApU4cIR7UUgS4WeSeb9Vjht+Om//LC3T8qFVIZ4vKuOEgoED4KAQDhdySrzYeirYYxeQkg3kXYiKzu1xBoQAKLcVBal0IpmYF0eKN+Ho+WzvvJkzPtm8aaOS6ImHYdgsFDS00EuShIKiQtz6izv3X96z76K6hDJYaHCYfUgIMRdzykO7wtWVLRt+vmvq1GmJjTLSEAwGrPFFQgZA+DikErPYeKz5Y12PgEUEuzsVByRJKo/KsL9PEHF+Kks4dOQwzTmwt6G5ycMiFvXw+cc5B+dmaiRsw8VuHzgYYyj1lSFOlkfXWNEdPHiqe0FBAaT4BBiVYlwXFoZlH1NCYagGklKSMKJvl58bytjDOIIgABMwCDFvh1txJhrg1iiU+duCQ1dsP+oGw0UjQggoioKCgoKmJWXpTeBxnbOi+9e7731ZWFiYIckm1hNtjdkTiROAEMKFEDTcqrDfs465oQY9mzdvbirLsuUCnsYtMwzEx8dj8uTJz2zetWMQ55wxMCNsoY+4fvixoJHXtf8HAF3XlaZZWevuvff+X1WnD2bPnj28qvFl97vD4cDNN9/88vnGnUML91lYdU6ns8ThkODxeCDLUuW7pNYlA2oQuq6Xfy5EpW3y+/2W4rW+Z1gxk2Hns1MfCSGgrNyaj+rs0L2Zu/GS9XtRqaITBHC73YEau64Hy7Q2R3QJnDmgCYCbvp5p1BFyAQQKWzeM0B2DCA0SoSDBIJpTP67OyPr7YIoJ1Tlbblxw9XpednmQMzPup0r4MjaWXPmDF1XcnQXaRtk+5SudGaOky27s8xk4UMSv6e45txzYDz8c+8nvXnz+DsbNRxw+iA3rthmvys41ByUj1ATrw1Zwt9sNRXFETI7KJqVhGPC63Fgwa3b69OnTrhFCAFxUuD4hJJSRY8cdiijAk9tuDYBgMIjm2a369ezW/YN2nTrvPl0ffPnfjz9Ys2KlMyU5GbquV1AqkiShoKAAI0bdcHLQkKF1HrBNhfkySCSExEFrDLdwDkDVwXUDhmbGN1Zm1HDO0feqqwqTkpJKggGNUUoFqCBCCAhKIixJIQSllPJyJVhxaRJCEBKG05r8jOU0QGY7BCilQgto8vZNW9JPnjgKWZbBUW5hmyfg9mJWrfuvoOh8Pp8ncsKbCu5iCJ+zHw6tgU5SVdVh7wpdLDkVdh5saWkRiouLG6Hhue3Wl5SUpCiKglRvEnRdi8BCzqToQgqY274OCR3bg9DMhuCVPq/QhOUcHo8HbplFnC9a0RmCW64MKig6IQS49SxtRSdJEgoLC1sDOK2imzx58j0h6zOqbfa4cjgcuP766/99oeG3llutns18CY39iJAmy+qiFM8///yo7r2vWFTX93hoX47y4nO/OXbo4L5kh8MB3dCrtFzDrfhqKbqtOhoXaSJOk1zgjAGaCN/ftDRwdS2WqE6NdQ6paXoAnIBahjWFDlkIuAROVdfyVMCDkgieBkmzsIEYWXRV7biW949t/VRu2YX6mcrIVzlKgsFzDrKllBqGYcDv94ewKfs5Wa4qGKcWhmNjoia2wqnFusJFxPclYU8YAaOKQRqBzVCCoK7B0FVLOTIToyE2fx+JOH/49UwLztrhCztWVRWGzqEokv909z9r2nfPLVq0yJORnApVVSu0lTGG/MICDBk8LP+mW37xavTv//6XP87bvWNnB1mWdcPKeaEiGt4nluK2QHlu34+oFLNlvHy+aIEABDOND9uS5da4lKwohHkzZg44nLNvv06AQCDg6Naz1+Inn/rlL86oMIltI9NKXfX4pMQd50OZN2neQpUVxjkxACZAuWRhg3bbqWndCRrq02orOl033Lqup9orbLRWM62e82v3hNyf8F0nEf0dnJWLbT7gC9+uC1lbhoFgMHjOwZeDBg16adfWLZcXnspLkCTJEEJQixmaGzCxOEmYU08QK3lNmG4Kp/bEjsTwoOls165d3tzcXBOktnZWKzxHU9EiGAigTZs2emajhsWGYTBixXSEKzrbZbKvRwjhhuXLMJj4XJii46qqStnt2+3p3uv0Gwf//e9/f+d0Oss3IKIsOl3X4XK5MHz48AlV/H5IUX6BaflFKeaaKjq7i6hRbiFXmlkSpowIIcjJyZH27t2bJSSGQCCAfYcOj3ryqV/W2DIMPychBJqmeQEcO9+Wa2UWZ00kUtEZcAcMAsKkiHCG8N2TM1lwVbGAxMySo8JSttQcFVasE8KwCoOgxmEKTAAq5wBlUZhZbHeZq7ZsyemxO1KOFXIBGISCElKOWZyDXHZZ1x3//nhc01gP1CcfeXD/t99OyooPI2et8DhBITMZRwuP45ExT/391l/UbYL80sULRi9asMCbnOS1LE8aMbGImZqGHlf09d350INPVXaOYDAArhsRiqzcAo08tj8XvPLPyzFo24IWFvV+pMVPohSSYRgWtihgGAa0QJAe2LvHndWyla/CWGcETJbAZAkGTGzaSk4xY1HDFAkDOX+ByFTRCZPBIMHam7LXV1CrBo0kSZCFbNRI0QkhWDi7RPjKcYGaNlViPmfpwoHj4hJCyAXbZF3XJXvSRFt00Ss1pRSqqtZ5atD7778/1u12R1hz4WIYZi7p0KFD51Z1jk6dOpUeP3TUzRijuhW+ZFug3Iozs4+rsuiiFR0RVr+B49ixYxEeTDh2aI/2xMREeL1eGJQgGAyKtm3bnqhMyVk4vDeo6igqKkJQ9VnYPrXGf/nzMMM7+HmLRygrK3MWFZWAcZRDKpaig0EgSRJKykpRVlbmqpGioyCaTjggCAhkAMYZi8VUhTnZK0O0MqqI4ZU/4Mp35XiVllH4gxYANGqa+kRAr77rSiG4ZDGFxFQFRboudsBjlWkR4rTH4T8LWcmchcJlLkRhQuaMl0+aylwvTs2XAVHnG/o/r1x55dIflyQ6mYzyeMzy3qeUotRfhjbZ7fVfPv3rm6s6z+Tps+PXrl7TU5KkMhDOhBAyAQsIIRgIl60ZqgkhKAhnkYGv1uegWoSjK8xjgwcT7rrrrqXBwhLT8rIWDG79nsNMIh4wZPDuhx9+fERAVROEEKxHz8tXV9Xedp06T7l22IiBHo8nYAhVsmqccAuDpWb7CE9ISPC379x1x/kaP1ddddUiVQ0MiY+P9+u6Tm1TzsbqGGPcVxZQ+g0cMLtGii7GlsYZravorIvY4Vdng83VDo4W7l7EGuOklOJCl+pa2efDc3jnnXcmn64PbWvujjvu+PZM5zqdYolFH0bXIYnur0aNGh3ocNnpQ2hsGTLk2nFDhlw77kIfO7987tlRv3zu2ZicS4qytijjFrUGrDy/0BhlVVhulfPClZvXVvUrK2CF8cgqWXY8DOdmchANQQI0ypLkEYaOADVT6wAwTsGEASIi81aric3pDAYkroMLgDACCKl8coZVMTNX/Mhd2AoWani6pihvJye0wu7WuShQ+/8L2aIziEYrBIVarp2NUREzX8+kQarDtm1ev7b7qpXL083smfBHRkKLpRACHsWFglMnsj7+17sTdF1XqOIoeeSJJ++ry36UQBAU3JxL0f6O1fagrimol7q16CqrgRC+OplxUCGiKnP6k0hFEgLny39oKUQrjsr+JCyHjodbiaTm7bWJAkn4ihlaOe32RB5H/YmoBVHZynuuOOLFxAcoy7IejvdERtWTCn3icDiK6qpt77333jS/3w/Z2tEMJwS1d98ppQgGgxg3blwfzTD6CCHgTvCiV69e713WvcfPF0o/19dkOQdFJwhAebk+EiGQlEdZXKwCtmSzU5hfMC00j14Gh+aHSy+DIgxQ6JViUFXF4ZXvOlaMO6ICYMSA4StDUoKMeAOHqms4edVTpxqW7UeCmgeDSACpWaR5xfZGKmydMfioAr/sRYC6oUkCEOwcdqF56DkQk1cm5rtiKxYvvuHrr8a/QwgRnFT+RBgIOOckPCVLCAEwAkKI4JrB1q1b18jhcIRKOpoYU2RoAAGgaxq88fEY/+m4Z5cuWXK7YRiSpQAF4ZE9pQseEYFPqRlxTw0BWZZ1g1Ce3qjBgf976eXBVd3ftk0bW6/9aVUjYggQFumxkNCuZ7kS0TQNjDHohgFGAUFY4Hwos8oUG7VyiGuS67rx53Wd33j9tSWnTp1yKw4mOOeEWfngnFnEEWDC2jwxea4tcNkeD8zaRRHWsZWTGhov5d836boYiPmcqPmXWJ/b57fPx83UMCIRJqw4yojzCZOUg1BBBCEEKjdIgwYNSr6aODnlvGB00XgZYwxNGzRFVrIHRA3kU+jCGqShJGBbcQghCI2mpTy9ohOMGAaCAWQnBNbJMvzVbWOjRo02d+vmbl9E3fGcytTMRSbnpOgIIQLCACFEqIRIfuZI/nn3Efg1cc4ZGHWxen/yyScfzJoxraHD4YARZWGH7rKK3NPwXUTGGGgU40RlsXR2Dun69etdazduaBlS6ZxDsqEPO4wCkdkKIS/BsFhdCgrxf6+8vO909/fpp59OOXHiBJySUoFvsbK+ZcxMbLf/ni+ss6r/a+ohHD58uP/q1au9qqqCWLuYdoCybu0S27vC4eEyZhyj1Sc8MgXPboI9XmzEJzyAO9wQsgNmonehzxSeYx/b5yeyhJ07dybv2bU7vlV265KYK7roSP7wiWBGXBOTkRUc4BrSeTHu6NQc1zTS23iZZ2+z8xmfEyZ3tEz43R0tE35XW+ffIXhGriDHn91Xim0+GZC9UfvI0awopyfMCUECJqBZKxhdIOhzOtwumLuR5c/XnFS8gqKPWKioPdAjMUxL8YewzdCwsXMmuUlUUJ7LGrkpYE9mKQzrA6Ug9u0zsx1JyQm48cYbq8TQdm/fkrVy6ZJ24AKEUXDBI5VuKHmdV1qCUggOkKpDLmZM/+65pYsWP+CNiy/knFMDghFCDDtzw6cG3YMGDfpg8LDrxlbb7SKncU94zXerDcOQDVWD0A0IyepbXl7LhBACGHa8X+gyEceGHT7DbCzTWWVgcziBL6ECqqpCt3JshZ3qZytKUY5IhS9stsbUYHoGzK69outWqiFh582iC7kXoQh4QGKS3qwW3K0LFqci1McIKsUrz1UqMD/ESJxOp3ry5Ek4qBSh6Crb0a4QfmTT+HAaEWhOYFLugNAIaCM8V9b+vq04bRogp9NpxogZRqX1NCw8ELm5uXj0qSc2t23XocpI/q+++uqbnJwc6nG5K7Xk7AlZWbUyuz1CCLmq82/dunXo+++/3y7ZmwjDMCIsXkopArqGGTNm/Hty8xbT2rRtf6wm86gqC66m46phw4Y/9e7du6S0tFQhssn/Rg1i0ZfZFp3VL4wKzjmpsDDBfJ8zgFIqjh864igqKqpgsdu72uE5zY0aNRJpqRlBXddp+PMOv76V+SLsADfbtdUtsISacYbCgCBxcXFq6zatCmuk6IywgctJZXaFvVJHRvKHIraFCdgL61yUMHDDQDHzYFcQSAae3qiiTKEoDR/ozKInMKzt2OhjChhClFsvhEQeU8BQOEozCNZcLqPaW/1bDTQ+quOqUoYGJgYEJ6mkDkZVGGJV7Tfj/GAECbylAigm8eCSYSknWqE/z8aipiBmyGOM5e4HHn4sLjHpr5RSwy7vR4WkmQtrZMqXxTbBzUwxQUB0mRBi2EsZtydGlAtrY3rciiujghqma2SDvuYxYwSH9u1vuOLHpV6Xy1VOqMojQy50biAhNQ0jR91WJS/ZwT173EuXLOkqDB7B0hJezpBzIyLsSRATnzYDeKll2VatWIYMGfza9O++G3Rk/0Hqtoq9h1s3CVIcjuzbj60bNzzZpm37ankS3MoCEuE+IsLbBwhafQ+pR+9eK76dNTMhlmPm6Sce3TN10uSWksQiNnUEDBBKQASFYRiQHA7cc+/90x//1XM3XhCbEbHGF3Rdx+rV23B0U/EvFVUDs1wDK6cSROeVrihCMnfsGLHzJSsGFnPOIVFA+FV0THfOTxly5cgWEq0Wm8PmzXse+mHznlfKJJdlkZAoTBAhvi7OOQgrd71sokJCCIhu7gZrsNk1zDaqlCAoueDzucGY+6IwZQcMGDBtwIABF0xB6b/+8fWFi+Z/P9DtdleKU0mShFN5uXj48Sc39u7de1mVbuWMGeO2bt2qJCYmgnMjosYBbBLJKsYvQQTTSpUWXbfuvZe1a9fu5K6t2zPtjZhoiYuLw/Tp0x8eNfqO31Vz/kRsU1dmcQohzmuYkcPhUKNd1QgsNux/t9tdWNftkyo1FUwAyHKUoyLaERlXVlU913IIgUBQBwoYQ0Gpik3FLILyR0AyB5zQrLJ+iFgReIUVzHKJhBFqD+OATAVQWgq/EhxyNaU9WgArqmXRlSqD55/yIN+VDB20Qm5rKDSiGnVqbcVtu2ZmnJu5k0XkOABSJXkeZ8dcXFX1tUtNFn0/5/53//nPgYmJXnBuIDqDhkoMvoAfzVq2ELf94vYHqzrPgf05ytSpU2/0+32QJAah8whw287gkCQpCnHmlltj04QLEMK007W5V+8r5v3www/36roeUkjl2SwcTocDP36/MH3X1k2tsztUI8iXmCx7NuVEtPtq9cd5XUOpISIYh0XUhpPBeeg9ndQ9cUadWHS26yLJMljYDo+p2MwmMLsSVAgKIBUgeZOh1KZeZhazsAA1BBQGCE2DLHNwDrm6ekOSJFVRFLPSEpXKA4HPkLpW5W4dJRXAdp0IqBz1chbyySefvKXrOogzcpc1YvMkEMAtt9yyolv3y6uMbdu5c+edDodDHzp0qN8wDEatCHROzJQiJ5ONEydOePbv3y9VI6PntIrukSeevG/8F/+9a++OXcztdldQSowxlBWXYOHChW9kd+g8ujoe0YUuVeUxE0oqzJfzcT8Rio4TKHbRUTNGi4e5WjxS8VTBvlFVjqZBGAwwAJLJyBCl1amQABIZrhDOZMpAyj+PujYjgAwDhBMEQKExVLvKUBCKy88cCBAnDDCTUTnsdjgpZ0uIvm+BcBfatDR1q8cosTj1bYugyp2z6Pert9rVdt3cC0EmT5jw6oJ581MS4xPKWX/DMlUYYygqLkanbl20F3//+pWnO9eQocPGDRk67LRpTxM+++yt3738f89BMyBZLhgXLCJHmXABwqvejLClXfsOx3fv2NUoNLnDMnwMIeCOd+Lbbybe9NiYZ2KiZAg/v66rQSgnURuftjXLOQdjtuFiwC6sU6cW5/nW/uGrXbRvX1VeX2XnsTMbzma1qAxHqc55TvedsB26Si3Ei0XeeffvkxtnponuHdqJy9q0Fh3btBSd2rYSndq0EZe1ayfatWouBl3VV924cWN2rK/9xhtv/N7hcFTKLGJxpSEhIQEPP/zw+7G4XkJCwpHq5GdXR0aOHPl2YmJiBVr2cKtux44d8prVKwZWB6O72MZP+NiPzic+H/V7Kyq6s3T1RWVuJsrZKcq/wUG5ASfXEceDSCBBJPIAErgfSURFnFGKOKMUSTyAJB5AovAhUfiQIAKI5354eRm8vAyJogxeXho69vIAPMIPl6FB4SipNojKg/54BBAvyuCFH/GiFHGGD/HcjwQRCL281isBPiTAV34cevkQz8vggW5lfphcZqAshCvGdCDVEUY36sabfnFZt66+/Tn7UFJUjOK8AhTl5qMo7xQKTp1AsLQMm9etl//x5h+Xx/K6jz90/8FTx44ShURWibJZZQUxC7cMGnbtodvvvO9XsbimqmtxZpyggA4Bw6pHy1G+APMwr+N0ct2NN/8tOT1DDxhaZG6ysGIJDQIK4Nuvv3nvjIquGqGS59u5FTBoONMQJQIQlSxQQgGE7LtkMLrTTWxCCDRVg6YHwYVuAsHW9w276AW3I6ejkupt4kLBQ2EAkiDQiIDw+aCqoqBGg1tVnT6fDz7DAU4suqYwL0DYkdrc5gezNkHszRhE1ptUqQQiO0AkucI9X4xWXZOmLdTnn3/+gTE793xdXFyMcCZe+56Sk5Mxffr01FdefPGn1/78597nes2vvhr/l5kzZzZRFCUC4A7vy6CqonXr1vw/H34aM8LQ0z2fs3l2AwcO3HDo4L4e4e3ngkeMl3nz5nV48xLA6Oy85vK+qjoLyOVyFZ9XRUcFVHOSm/HIkSsXjcDqKtRSiAosC4+rC2FpwmQnoVoZeiT60THBQDL3gRoidL7TkTRWIB20ttk555ApheErW5KVnrShN8OP1e2A/mnG+55sXqyR0iFAKC6sAvBddcpTOLIm4YDTi+1FGrYUcBiyAo0Ikw2lFpiK6wqjGzBw8DdPPfvcsD/8/tV77aDd8Imv6zrSk1Lx0b8/6NWyZcsP7nno9DU2Tydbt6xv++fXX/0t0Q1QhVVMyyJmqTLZ6cRvX37tybqAVM5Wbrvt9vu+/OrzLYaqhyL5JcpCm26UUpQUFmL6lIm/u/6m296oumFn3smqaWvnzZw2pqSkpBGTpADnXEJk0LRuu5jWHNPt/6PnAwAwxgJ7d+3KIoyExc+xCh6eGY2gY93KFTemJCceKC0tzaSU6qd5Hrqw2hGi0iDlpBCEEF0TXEpISDh87bCRY8+LRVelr2wxQnTo0AHXdZSfSgfWy0AROb1ZbpMSVgkCM8DvAIpa17CY85AOrcY369Bqjgp4BSCJKq5DAY0AugG47OuZitE8JoCmAYk7gRtPLjr2on6qBMzhrNR8vxjl0SefuG/nlm19v57weWs7ni180bHrKrz22muPpzXM3DRsePVTnMLlxRdfXJuXlwd3WJnEcCxVcUgoKirCs795YdGIkWd3jbqSzt26bm3durW6Y/NWhTEagV3ZubuqqmLixInPnE7RxdqimzVrxmP33333uyUlJaCMmYQLYdXAKmMeCv/M3hwM/zw+Pg4ulytC41ZWXYxzji+//LLZBx9/9E97syL63OXV/ExaKs45WAjni6rBYdZ1xZrV6z9v2bqVL+aKrjwpIdpyiz4u3401CCAJDgfXoJQeRzqarL+8mvFutSlWpfuYVLvfXoRbtm3fBaejGXw6IJhi1Z69+JXdP/79r+w9B3aXrVu9xu1UlIgcRtu61lQ/Xnru1/9OjE842OeqfrNrcv6Xnn/+57U/rfZ4FFcooDd8o0hRFOQXFOL6UaOO/ual3w+qTQA9VnLLzbdO/MOmrXfRqPCpUKFnIbBt4+aUIwdylEZZLdS6eI5MAJlp6UhPSQ1ZSCElU0lNkwgFyCuGXZlQgt/MOQ3DUisLvxIAkpKTkSFnVOiP8HZUbfSUe5KEELN6XEA/Y8B0nVt0hBAQSiHL8llX67qQ5fjxkmxVVUGcpMqqVxezvPPOO83vHH37sSOHDlE7uDZ8MkiShJMnT+LZZ5+d/u677w6+vE/fatUEHffpxx989tln3cxxUXGnmjGG4uJi9OnTx//JZ+Mb1cU4jYXSGzFixIN/eeOPd1WVnyrLMoqKivDdd99NHFOHaVF5eXkoKysDY1E1YqJTHaOtrUro0zjniE/wQJbPGHUDIYRZqyIQiAwsJtV8Jtz0dAmVQtCRQ3GfMWD6HBSdqOH3TE2sgUIoCViZ74Y4iP9MJfDLBgJU2BTEkbAEp2BCmJvBlMLQAcV6IEYEdBhmPwoBsDDiAItMxe6YCM3PBRilMKgBQwgr3I0ATh1lyXrpwauauV5u42TVsvY2cmQv3FN4dcDZBEGLXoiG6uFeGhq9eeu2J98ZO7b//Xfds7S0sAiSRCJTfLiAy+HEgT072G+f/eWCf773rwGX9ag6LQsAfpg39/6/vPbq44xwKEyx4tcE7JBJSin8wSAat2guXnvzzd61eX8ixqtvo6wW6oBB1xz9Ye7shvbmij3wCCFglKGkpARLFi66esyvnqsT1/Xa60aOnTB56uGSkpLGkkx1zrl0JgyahkgbiC6EkKyke50TLjHG9E8//OitlUuWJdouergihFWSVAgBKkm45777to+44cbfl5SUNCAS0wghOuFmyAm3amwQTjSzfKQNTZnXta9v44iccykxMTHndG7rebHoOOdQZBn79u1Dwd7SjooIQjbCk7xDN2YC3XZBX7tcHCmvkmR2ZKTPTqMCjstzYy0mWWq7J+W7ppxzSHZoDzFAqAFFDaKZm+CyUVf8F86kaik6n09tsHfv3jjmalSONYhLL6r38p69l40dO/bWh+67f5LfXwpFUSDCXEzOOTweD3bu3MnGjBmz+G9vvzugZ68+lSq7devWdn/uuec+8fl8iK6tKoQAowyqqiI5ORl//etfH+zatfumWlRytTIfbr311r/MnDL5XafTGeqncJdflmXk5OTErVq+YmCvKypawLWxY99vQP+ZsTzfD/PmP7MSyxIrLBphsbA2DNGxY8elVw0c9G1djtkaP9jq5HxGY3MIM724IAhSCaekFOSJFIBYfFgkMlk+GgMIrWw88ny2IrPbRUN8YlVRmNu4EomwNEMgKwGY0OHk+chMkgC3q1r9shPImJ9T9upJyQuVOaETa/UmFQvlXApy5aBB3747duyDTz756Ceqzw9FMutshKpUGYDbFYe9u/awpx97bMnf33n3ur79+kdgdkf271V+86tnVpw6coS43S4YugFCymuKUEoRMDS44tx45Y9/eWHg4Nov6CJqAU8ZdsMN7zVq3uzd4ryC0EIMlGcOOJ1OHD16FAvmzPxzryv69q4Lq64WDBjKOTfziKPKMYZcVEogKKAamqOu21fnmRHh1dntnSdKaaXH0e+HML6wV/R7EVhg1PvhmRNVncfGgzjnSE1N3evxOI9W5740A57169cPiGaVqOz8l4oMGT7s07Fjxz6ckJCAQCAQ6t9w7jGXy4XDhw+Txx9/fObs6dPGhP/+6aefPrV161bFpl8K7zdKKTRNg9PpxBtvvPG3Ubfc/ObF3FfXX3/92qKiIsiyHBrX9r0yZiqHDRs2dKhizlwUbkG4lVoZHnk+40hrrOiqjt8yERUKm1TRgF0XNnoHBwAMwaCBQSMOqFCgQYZOFGg08qUTB3TiCH2uSg6oTIFGJehMhsoUqNT8LPz3OpGgEwkaLX+phIWd2zxWJQdUyQGNKuBEgQ4KCAlysAxNkz172xMcrk6/rCnC0+t98Sh1xENnUui+w3MdL8Xc1KuHDv/47bFjb09v3Ej4AgEwWTJDFWy81DDgVBQU554iv3zs0Xe/+PSjDwDg4bvvPLZ84Y8J8Q4nBDfKrV1BwaiMgKrC5fHg9T+/+cfb7rz3+bq4l5BnQMkZLD5Drum5Bw8b/gpVHCgsKUFRaSmKS0tRUlaGkrIyFJeWQuMG1q5fFzd1yuTnam6BXgAiKC/3skgFfWG/zGpvrM5jrqTaGCxnwugqq4xVXUsQUUwQCAM7q19Ltmq2VkopuGHA4/EgOTnpSHXve/XqbcNDpJB2u/5H5OqrB3/zn//85+QLzz0/b/PmTXJkEj6xkrpNq+WFF154fPLkyfesXbXaExcXh4g+g7kL6fP5kJyaij/96U//N+LmW/98Sbj6V/Wf/d5777155NCB7rIs+4UQjHMu2QGz3Ny9lJo2bbroTG7r+WYCuRjlnBVddPxcOYZn89WFOJnMh0Ls71pMpCIKy4uqowqLEYeB2XVMIz8PsyiFCKtiH/X8aVSNlwr1WYUBKggUIiAFCtE9VUfH5ODXwJnhhMUcN608xlvkS8nQiSsC+wMq5+271KRH7ysWffDhJ03+8IdXtsyZMTM1yeuN5CezJqZbVrB25U+ecLZge8JKkoT8kiK0aN6a/+Vvfx898Oq6BaxrW0bfffcL5wr5hC8KpgUsLgg+OkROrwphI+U2PgByCbGXRNdFPRMYX5P3K4vYjkX7bAkGg2jYsOE2b7xjf3XO9fPP2+72+XyURdUI/V+T7PbtTnwxYWLak08+ua64uLjS52UxzFZIsWOMIT8/H7179/Z/9NFHPc+HkjsfrBrVdqkrGVNRWQwM9VL7rmsFCwrcrAVruaqKMMCEDqrroFyYXL4cAFHBwskpbHuImFgZpxycSiBgMIgUCrbjFiOxQYnFlGDt6tq6W0QSaNq8dkTYzMXWOsPLCxczGFC0MjRxBXBVI2l8J2DXGa054KbZOcFhR4kHuuyyri8QXcqh+rvVF7+89uZb3Vt1aPfeH1559alAwA+FsHLIQghww4ig1rbj5O6466797/zno+bnW6lcaLADpTREVyMsqv7oxf6CUcpVeXxWEw2I8zIHYr6Che+8kLD8Oc45wA1wrkOCVTZPEIDwkPIJTwnhBIDg4ODQuQ5ipZAZtutrndvOiQMqt+zCU08qy+GL/m4wGESTZk2KW7VsPL0697t7T/GQgoICJ2MNoUVhhv/Lcvc9D4xp2rDRqgceuP8L6LzS6l32zqNhGEhMTMSoUaNeP+9K7gKXymjULyTXtSYueFXy8MMP7t+wfn0Th8PB7d14O65WUIFgMMgeeOChL594cszddaDoogN2OZgAiNDhEBwyNEiBMjg0PxJQhkRWjESiolFKIpqnp6FhUjKSEjzweBxQGCAzc8td5wY0lcOvcRSW+lHsK0NhqQ/5BUU4VlCIU75SBAwnfIYTAepBiSDwUwWcytCZC1ySIJgMAQmaMAN2DSKF5WfQSIVHLIuT63CpfjTFEQxtnja9C7D1TD2wAegwe0/R7TvVVBher0ktRc6EZf5vyPxZ08f87c9v/l2oOkgY8WL4gsPDsKagP4DHHnn00zvuvfvhl1//Y98LW9mdvmZEzC06gUqjF8LxT8MwlAvS7SaR2B0VZ8arU7yJhTvWb8hKSkqiupXyZWeSEAkoLi7G3JnTb64jRVe1mW2oGgwtgFSXExkpXqN764b7u2crC5p4sMYDnHQBJ51ArgyUWY3whTOUCAAG4NaR5NEBlwHIOuAOAsk+IL1IQ+PDp9DlcD5a7z2R32T/qYKEgC5IqUZQqqoIqjoETF44yszAUw5RZeCubRWqqopGjRsVd+7Q4Jvq3OvefSevO3jwYKKipMAXOqewuWT+Jy25n39e0/29f749c97c2ZkKYRUCSG1mYDun1f7MMAxomob333+/z9y5c40XXnz51yNvuvHtenTpzArZMAwcP3680aVyb9dee+2fP/n3v792u93QDC3CUCCSuTO/e/du1/yZMx8bcl31GGwq1IwgwtwvNCjOUGbaTn4zIMGAAoF4tRSS/wRaOHR0aejC0I7NH27XLGVcc0mpiVkdsP5WzRIsA2hovTomA0jG+uJAhwPH8wfvPnTqnwdyS3HcryM/QHCyFCjSZeiKE1DiwBUnNOaELkwFZ+/7OdViNCUFuO+yFn/qB5wxPeYnoP+Mvf4x28pcYEkJ0AWzsDlUS8mdsW6sXQy+Eo+EQb/gBuf6NT9dOWnC12O//HJ8B13X4XE4IyalJElQVRWlQT/S0tKQe+IUPB4PZCZZaV8ClBLEOZw4sv8AffDeu/458tuRLz706COP9Ok3cFodKQ8pOui8suDXunZxI7w9WnlyPSGyeiEoXyGi4ujs6AZR/ZCYAdcM/qZrzx6f79yyTVEU2RwfthemAYrkwLHDR7F29U/3nJWiq+7NmGBo+WCghEJXg9B1HZ3atfMNvyxzdvdMfNYQ+LE56qaUadcE51ZPQsPjLbMbzi4Fmp7iaL//JPruOaF1PpTvb3Cy1Oc5nl8qnywuRQAaqGxW/pKs1CUjaKBdu3bHs1ukT6nO9Q4d9V2xZ8+eRh5PY/g4B6xc2ouVSfhs5fvv59+1YM7c30ya9E2nkoJCJCZ6TRYLLkK1EQghKCgoQHJyMm667ZbdgwYNGjd31pzH586d28R+XwgOwzBCuZ+JTidmzZqVPv+H76eOHj1618ibRr3Uf8ClFW5SMwVy4dceic5Oquqz6txD//7916xZ8dMVmZkZFcKQAMDpdGL9+vWdzsp1ZRwBQcyYE8Yr11Ah1w8GmADcwg9v2Uk0Y/m4uWfbr4d3TXqwlYRKmQS2A41Lgab5QNvcUrQq8SMzqMNtGFCEABQFfpeC4iQ39ic5kBMPHHEDx13A0Rblll6VEsYrtwsU3yMT7yJTBiBje6mSse8kH3nghP+jwyV+5JzMRU5eCfL9JmNupzgNT/W87Pbq7LRuADrMzdEeXR9MgpHkgsYZODXdVVLhIVZet/WMmN1psGUDknVeet4G9dfjP3tr0YLv7/jhh+8b5ufnIzU5BUleLwzdCC2GsiyjyFcKwzAwcOi1+XffffcfrrvxprcB4Lqbbv3zlEkTf/fVV+OfW7posZdSivj4eBiGDoNzEI0jIS4OhAr89+MPs6dPmTLpuuuu2zt42LB/DRtZey6tEIaZdy2idjZx/jZjSVgFuVAuOIkkohRCO78YHeFWzYjoXFfLM7FqcZj/nzkzosfll3/jjvNcEc1obeGRiHO7sW7t2ri5c2Y8diZ24XPC6ExLjkAP6khMTBS3Dev7Rc9U/KcVKldySw7nDd+87+jogwV59+QFCfLKOMqCOlQjUlu7HRLiFSDRSZDsZEiLi0PjpMSXTjRIXt4gOXFZM+nsLMR2cc4TjriG47NaNFxYBLQ4FkD3/QXodawQLQ8fPtzgmpbJ3ybG073VsuaO5A9Yv35TU7c7E8X2ZBCXPja3cf2GtnPnzX5nxYoVvdeu+ikhUFoGrzcBqamp4Hp5GhdjJuNIUVERLuvRTbv//vs/vvO+ivTqN9162xs33XrbGxM//+8/x48f/+iKFStcHo8bDocDXDdMl8XMOYamGxg3blzLGXPm/LP3V1+9dGX/AbMefeyJ+/4XLDpFUTgAerpY1PO963omtzQ8GqM6Fl27du0+6dGjx5trV692VVYbV5ZlnDhxAj///PMvaqzoBKmeicCgw2noSAgUoh05iueG9nvw2lREMEvsBeJPAr2WH8SYHzYfvfpQQYn7cDGIT/cCzA1CJbNTZIvFgZhsssIwQEo5SLEBoQUgUYJkt/7HZE8e0twl/sapKfmXt3T/0C4DM1OAbS7geHY12YEtqzAHQA6c+B4NADQA0K5xtR/oT0D/KdsKfrvf8MCQ4s2FChSUEAhe2QOklWNwVdBMkWoqSlGHESyTvvjsrQULFtyxdevWzJycvdQwDMR74hCXnAzDMGBoOgACShlUXYWvxIcW2W35Qw899MXDj59ZGd12z32/uu2e+3719VcTXv/o4//8Zt2qNY54lxOKokDnHEIzQEGQnpoGzR/A7KnTUpctXHTvd19+ecdlXbvuGz58+FsDrh3+cWzullaSdVOxyl1dSkFBviSBgBg8rGkX1oLKGOVAmBKzohnAy1labH45qRqhzU1btPb16tVrw4+LFveJj08A55EQpGEYiIuLw6olS3vWCkZHwiY05xy3jB4xrlEaKpS6O5FX3OPrhesWrDtWgiOaB5rDA9nhRZzTCQMOcGGXj7Mi5EPMIgSyTEG4AckpA9yAqqo4WVaCAtXnOrKXNjq4Qb8nzRm8p0OmF1d063gbTfHOaiXTOimhduhQ4RXr1q1r4k5qj0LDAC7RbIjly5cOmfrt5H+sWLGsbf7JUywvLw+SJMHtdpsD1yjH1Ow4Sb/fj5atW/JHHnnkv3c//NiDNb3m7Xf84ve33/GL38+YPPm5zz75+NWVK1d6mGwVyKEslDObmpoKXdexadMmedOWLdnz5s37KKPBX//Vs2fPrYOGDv7roKsHf3O2932hPce//vn1hfn5+VAYq1TBhcer1kR27dyeXlRUlE0Z8wMmvboQQo4m2owWbtKmaZxzmVKqCSFkSZJ8p06dSgmPmw3F94FVyII5ePBgh51bt2SVlJQ0IRLTCSFaGHTgMgxDToxPyPF4PAUpKSlQVRWMUdhurK3oXC4XVq1a5Vyy8Idb+g26+ttqKzqDwsnO8JwZ1+DiGhJL9uKuXm1+eiwND4R/vgnIXrRfvP7xjwdv21eWBuHOgs5cMCzGXduisa9jhPjHzDxYAWqCcdRWgACRCYBUSFaAcY4WBFQNCw7q+Pjo8YkN407o/bq03nRFW/ZlOrApBVifHaMaEBUGyKb1A5KFH8x3GIx6EWQMmpIAgzkQBIVOAQhmZnZEDMtoyy6Sebk8R5BWacGFziQAIjgIOCSOmMV07d66tcG0Kd9+OWvWrKuOHz8u+Xw+aEEViqKYeBkhIepsg3Poug4imeE7l3XrXvbwww+/OvKmUX8713aMvPnmv428+ea//bRiZf+PP/nwi0WLFjXhfj8CgQAYM7E/RikS4uNhcI7C/Hzknjzp2Ll1c7dvJ379dUJCwoQu3bsdvfLKK2f1veKql1u1bXey2gt5GMtMpJtosfMIAiq4HOtxNXvO9DFH9h/s6XI7SzRfIP7gkSOtf1q6vOuunTsUiVCrLh/CqLdNpcIIhU45NKP6kZoL58+767lnnv4iEAgAzOJhtDScYZf3jMpBD/dAQvMV5VTqXDdCxA1mb7GKuD4hgM7x1Wdf9Pr2q6/3c84hKImYF9wqk0hhKjZmFe8JbUhY909BwSiFrutYvmLJmBopuppIUlISunfPmhr9/qathx6YumDt6GKWAcWVBjWU8VB1NkLlq2pkNSK7+C+IWRFIUhRQnUNVAzh1qliaM2dPt7Xzg936d2yFfh1bjJKSXbNaSFLMt9xHjhj4VKu+uH3Rtvx71h4saJYfCLAClSOoB8FlB6gkma4PoRfFTpktTz35+K5vJ3zT2qmUp2sxxqB4PKHnoOs6AmrQrBEQn4AGDRqIHr16Hrjvvvse6N77ikWxblPvvn1+7N23T1MAeOsPry2cO3fuVUePHpGKi4shdAOKokBxOOBwOKBYxXr8fj98Ph+ZM2dOo6lTpz7SrHnLhyZNmhSf1bKV70Lu/+++++63UydNbhQX7wE0A5wQEJ1DthYSbltuoSIyNMRgres6mjVrtrO61/L7/alFRUXWQkVrrOgqg2IYoREuamX4nC2apiFo8RfyqNRIm9qMCBIag+Z5rQyokEtsnjMhIQFz587t++LvXqu+68q4aUxVFjtECIcEAicMOIuP4c7+jaZ3Ywit3nuA+KUn8MZbK0+NOezqAM3hgS4oOCUQglZgOTFIuKkSWejW7CgWaRERDp2YulwnFKqg8MlOQNGRL1IhhIF9guOn3WUYu33Hdz3bNS8a0iV1WrtkzGwArGyH6vHKnUk6A7s6J+H10Vckv76np9d94GTxiOVb90zcdSIfx0qBwyUGSkgcuBwPw+GFKjFoXIYBHlHlndi7ejTS8rOrL1Ra+jecjsrqOp0iJtbFiQOHM/SgCiXOG1J0hBAENBWqqiIYVOH1etGsVSvepEmT4mtHXDfh/gfOvn5rTeX5l18Z9PzLr2DevDn3T/9uyu+3bt3c+OTRY9LJkydAKYXb6YLD4TD3ozkHCAdXBSjh1KgBnmWTh1LrZWdvUGqOU0IAQmKfGcE4IBMKSRAYXJhZRoQiwHUIQ5i1jwkJBb4DZuB10OC47LLL9N+88NvrqnstSZICusZRVuYHVSzFGTIU7U2FyF3dclIh+/tW/WMiogzNqORWRCpO+3P7WFArZC30eaTrHP39CseUYMvmrdKuHTtTstu2yauRRUfOwDjidDrRsmXzFc1Y+Q5oYVkwe8GCZb8sLZUhJyQhyHmEVVPbQikFDA5ZliETGZs2bfIeXld4zxXZDe7p167x/8lN0t9p5XTEdFVvJTMfGiXNTWp0eddCoPW247hxzb78/vvyAmmHT5UoJ0p80BUZTJFhMpuYlm0EfVGlykxUBSCd0Ro+W3E4HLrNfhsIBODz+aBpGtIyM9C6dWstK6tZXq9evRZfM3jwsy3btD92viyfoUOHjRs6dNg4AJj69VdvLFu29Lbdu3c3PrBvv+vw4cMhdhSnSzEVn1R9p0XTNEcwGITiZOA2zhS1YxgMBmEYRsxdV8aYLssyFEUBUxxgVDJdQcW0lBRiWjagppXDmKQnJCSojZs1P/bEE08Mq8m12rVr9+lTTz11S15eXiZzmBgR4XbNlhA/WgRfGrX41gQl4JxTZn/OzGP7c/v3hJjnFYJH/N7+nFnYVLSiNGB/bl8PEYrNAA/9nhDCVW5I6enpR06n5CpVdEZYbhrh5UwOlBAogoKUFaBvE8/JDsT3MeAO/W5KDv/XrNx48OSGUA0JekT1KwFRw0lZke2jKl43CbpVV0JjMghxwk8TwJQ05HMD2w8XY+K+Q3+6qr3z10Nap04a1Jj8qqV05pi8ais7M4NjA4ANgzIxCZnJ2B0Mxu/ep43edMR30668guGbj+xEbpBAc6VCeBLgJy7oIFCpFSsjpLD7Myx1SCvtByEEBLVYnM2VPyZpEqVBv3KqqBCcCTRr1ow3b96ysG3btjvbd+o4v0uXLh9kt6k+zlVXcuPtd/zuxtvv+B0AzJkz66EtGzbeunPHto45OTlpe3bnyMdO5MEZnwTChYIqwp7CJaNBo5+bZjUTZWVlRKKyaRlapgUjEoLBILKaNwt6vd6cWN/L7Xfd/fSVAwb2cShKqSzLpUySArIsBx2KUsIY8zHGdEmSfJIk+RljZYzK/g6dOh44m2s1bdFSff73L1+D/yGRarL7RAiBYRjIzMw82SbBHdKg20tKM5YtW9nN7W6AIsOAECzELiJQGbAbeynPY+UQAuCCh2oWOJmK9evXpxSuL3gscUD2oZY9u/6pNju1tcNR0rpt1scN22at7GRgWttjuH7PiUCHrYfyG+04fEwu4xyyyw0qm5XIBSeh1BkueKWWnP15bWVeDBw48IfOnTtndu162dysrKzvu/Xss+xiGsjDho34eNiwER8DwI7NG9ruyzkweMeOHYMLi4vSm7fOLqzOOQYPHTI+Nfmj/UVFRc0kKgfMzTMzF4+CGbquO9MzM1a1bNM25kq/X78B0wBMQ73UjaILMUvY+emWEqEQoITC5T+JhgmtQyvaXiB+eS5/ZWvQo6jeBAQJA0DLQUUbcyIRiFv4FaPAyEiws2L8WfTvy3Pp7L8GIeDUAU4EVARBmBupLhnxroSC5s2z5tVV53YBtnZh2DqiMT5EYyc2tUpsfSBfH7LzWPG/ftqxC7uPlKLU4YXqTIEmOeBnHnBCYYCBEwIDZvFak8fNqo1p7+Zau20ciAnh4tO/rrviybUtbTt12dG2U5cdw2644b2a/rbr5b2XAVhWrxoucUUXTehXboSJUHK20+ksDbm6AsqePXsel2UZwSjSwrokBLQtHUorhmfoug5FUcQttwwc2yMRP5+vzu7sde92eZvmZzbH+lY9OvY+UICeGw4Frvhp24HGx4tKoSsOEEm2kbxQX4YvGOGWcX29gHqpl3NwXaPTLWyMjnABj0zglFiIJzsgkLIn3w+fnA6dSmGKJ3IjonwvJtoks4KP7clbBVYXbQGKyENQUMttFWBCBwGHy+Dw6EVo6DuA52/s/uroRLx+vju8tRnft+JyBSuQASDDiS3ts7L25xUNW7Fl/7/X7j2IPN2BEupFCU2AIclQFTc4kaAagEHMjBKJcAjOwYTQ64dxvdTLOWJ0Ubz0Nk4U0jOcQy4rK6vSwqorKWdVicS4OOcYOXLk4uwWmF6T820vKMlolxR/oi7a3tHtPMDczpkpTTL2XIleLTYfxfVLNx3rt+NYSbyfC5QEg2Y1OaZEWKz/q7Up6qVezknREQHORKSiimCDpQx+XSCoCU+4gcUkAmJooLADGWko/qicsSCqklEU5kYQeRxtyYWO7doDFXYjdTBBAKEhjhhwBYqR6T+Kh65u8dkTrXFfdTtkNdB38tpT737746bunTt3LryqS9qidsmY2ZBh1WXVYB0+W7Hi/A4DwPCG+PC3DRtgqz+58cbdhx9bsePgS/sKgzgWYDimuiDLMhwOB0qZAAtLn6mXeqmXGlp0Faw7S7GoqgpVVd32TxmDlpycDHK8PANCCA4RUpSIKZ4UcZ4wi4ZSCnCL4NHvh5sQDB8+7KfL2+LDmpx/w9Yj9y5evKK709UQW7duTdyz/tRN3Run3jSgc8u3jQzvuG5p3k119XA6uByHWeeW7zXv3HLxEQ09V+3ht6w/WNQ2Ly/PUVBQQIuLi8F5en31p3qpl5ooOpu9hBACAg5dUFNhQZi7sESgVEnGMZ/Wwv6NE8jrmZmAxTnHwT0KgpIMAjmsNoCtjOzYYruea+VYXbklFxVZbYcvknCWDwICAcYBiWiI535Ivnw0NXLx6DUd376vLX5V3Y7YBjReehyvvLUq96Fcb1cEJDNGUKKtsbukDN/8kPdM+wztl92y3Qe7NZYXdU7HxExgecvTMSHHQNoCJwCcgIzvb2lH/4R2SVhxAgO35gRu27at9LFsKfhD/TCul3qpoUVXFe5j5poKyJKE3NzctBzVrbRQZFUCylq2bPkgWXniEzvOixs8lNoUfd6aGHbhFuGZhFKKoD+I5IQEjB7S+9vLMvBZTTriyInAVTNmLHkooHkB2VNOK8PNbAuXHI/c3Fy64MDOZvsSyP0HslLv794k8SWjXbMPsiW5sC4fWt+MpEUpGUnb+vbp+JY7IA6czwG0e9e2Bl9++eVkXQMRQpAmTRvteOzxJ++r7ev+5U9/npOfn5/RJKvxzjFjnv5FbV9v6+YtWRMmTPiaC11q27btsnvuvf9XsTr3v//9/n9LiovTQql9QljF5AhkWQ54vd4TDRs2XDc0ZlRUVcuqn1YMnDZt2l8lSdIMw5CvvKr/v4cNG/ZprM7/wm+f/1mSJI1SykePHn1vh46dd1fndwf25yjjx4+fW1pUnJySknJk5E033t+mTU3IGsIU2xqf0fOVBXtXLTuiQvOkQxVGRNKtTChkrRitlCD+eX2HUQMTSYh2/Nnvt276bv3hTqUprVAmnKEdWB6Fsdl/Kbdz1ey4ucqZeCsTE0fkkLkOGSqS1GK4yo6id6M4PHhN16FXpiXMr24H7AAyNvrw6DvTd7+8MV+XdHc8dDBwYVPf8NA1qQAYE6BqEMFAKRq4GFo2SA52a+zd2b+T65MmFEsSgL21beVdSPLqKy+t+NPrf+qT4HJA13VIioy5PywY2qPXlfNr65rzZ8966I7bf/FRcUkJmmY1xjfffDOoe6++i2rzPj/+8KN/P/7oI485FIYOHTqIVes2xoTe+avPx/3z6Sefeibo85nwC6Mhj8ZMaqdwu91ISUlF06ZN/b369ln3f6+8fmVt3eeo60eUzJ4xOy7O5UQgEEDTZlnYlrM/ZnFMmYkJQtM0lPgCeOjBBw988PHHzarzu+eeemLX2LFjW6uGQIsWWZg1b35Sy1bVCwSvVKucjgHUMAxIkoSTJ08iNze3XfhnvXp1+DYtLc3Qdf00jCRnL9HspPbuI+ccmqahf//+e2+9tf+jDdISVtbkvLlFvssmT/7htaNHj0qKooRwwKowRZsTLS4uDoZhYNeuXY7Fixd3/uyzOe/MXrBy/ZFTeVf9ryi5/Tn72Jw5c3o1btwA6enpyMzMhMfjwddff/1ebV6XEIKMjAxkpKcjNTW1TnafZVkOxHvi0ahRI8THx8dsA+jo0aPt4+Li0LhxY6Snp8PtdsPlcpkZPU4nZFmGruvIy8vDypUrXe++++4VQwb2C65bt65zrO9x7U+r+i5dujSuRfMspKSkICsrC3l5eZgy6etXY7Ywvvrqd4qioFXLlpgxY0bWwu9/uPVMv9m4cWP2woULW6elpaFx4wa46667VtZEyVVQdIKAhmoVEA4ICmK9TOuLIEhklDjTMXV/6ZilQIgxYXQ8Xn+xb8YLnf27kO47AK9RAJkHQYkKalZTNWszCm5ab8QAiBE6Dr+OOZitotTQAKJDIhqchoo44YdXy0d62VG0KtqKoWwPPrih+dNjL49rNVzCh9W1prYBjSeW4fcvzT86Y1ZxBo4ntUQpc0MDAxcU0VUCDEKhUQqVyCihDhTDjVNyOgrT2mJbfAfMCrTCP/Yk4oGZebOum3WweGw+Pl0M3LQR6HCpKrotG9b/aufWrVQSZlC2Wc0LWDB7bnZtXlcIAU0PQtUCqGphjTnGYxgy11RomgrD0GNWrMPF5CARQFFxCVq1zsa0WXOwYvVa/LhyNRYt/wlTZs/Bq3/+C9p06Ainw414txsb161TfvXUYzEPfJ8za+ZfBTfArWfp9/vhdDoxacLXT8fqGo898+zNTZu14GrABzXgw6Svx//9TL/5ZOz7806cOA5d15CUnCx+99obNa77S6taMauyxjjncDgc2LRpU+aJU2pEFZ622Y2+vummkd96PB6haVoI57Ktr7MZkLZ1RalV4FrXQ7jZgAEDtj/0wLAHW2WlzazpeQ8eKxo8ceL3rx06dEixLbmaWJ/2d+z7VBQzxq2srAx79uyJ/+KL6fd/NG76dxu3Hbpviy+QdSkqumnTpj3jdDoRDAZx9913o23btvD7/SgpKcH4z7/466V0r0IIWkvnDXlLLpcLbdu2RfNWrZCdnY22bduid+/eeOTRRzFt2jTce++9KC4uRkpKCjZu3Ci9+Yc/LIhlWyZPntyXMYZmzZrhlltugddrUnatWLEicc+u3fGxus7DDz/8RV5eHlJTUzF58uQmK5csuqGq765ZvWLgihUrsmxuujvvvHPO2Vwz4uExjgAzZAgOCEigFjZnsokymNUiHCiRPdjvaoUvfj7129VASLu2Bw7/qilufX9Yi5tu855A19JNaJy7FYklR5CknoKXlyHOCMDFdchCmC8ISIJDEjpkGJBFEE4jCKfhQ6JRikS9BOnFx5Cetx+ti7dgoLEDjzbOw4RbW17xbjdn+2uBTzuYdSCqJWuAvu8ex9e//f7QJ7ODjXE4qRVKlASoRIZBKABqco6FKnrRiG4KMdBSAp0COpGgMifKqBP5SiJyExriQFJbrIm/DNOD7TBmSe5zoyft3verLXzzBD9eXw5cuxPIuNgn/u5d2xos+H5eI8YYmme3wqNjfonGLVqCcwHD4JgyedIjtXd1LtX1/dr2PRVV04yfjahMMIOazNuG4PCrfkAQ6FyAg0CAgnPAFZ+AX/7617hywAAUFhYhNSkZkyd9fXXMrLkpk5/LPXmcqAEfWma3wBPPPIPMpk0RCJhEP99MmBAzwoGHnnjivt49e6olRUVwSBI+Gju2yk2WyV9NeP9ATg6RZRmZmZni2d+8OOKcFV1NViFJkrB9+3bvrr1Hr4/+vHFm3MJ77rhm5PXXj5ybnZ1dlpSUBM45ysrKoKpqyMWxtbQkSaH6n5SaRXJUVYXf70cwGITH40HTpk213r17773//pEvjbqu3xVpia51NW33Po2ztRv3PfTNN9NHFxUVEVmWY4IfRmN49v1JkgRZluHz+cjcuXM7fvDBdy/P+2H9nL0HT43c4VfTL2ZFN3fu3H8Fg0H4fD707t0b6ZmZ6Nu3L9LS0qDrOnbu3OndsWXzJWnJ1oliDcsztz2ZtMxMDB06FCUlJVAUBfv37yc7d21tEIvrTZgw4QVJkhAXF4cOHTqgaVYWOnbsGKJHnzlzZr9Y3t/tt98+IRAIwOPxYM6cOakrl68YGP2d1StW9v/+++/buVwuaJqGMWPGfHTW0EPVH+morJKluWsqo0yKgx7XHH9advQ3yGxI+3rwe7v2aiugpBUw86oWmPlCi+ZYdrRgyNa9hbfuyy976FipiuN+A8WlBnxBAz4tCAhTySmUwemQ4HVQJHsIGngYGiS40blp6qNtmqeNb6UoZ0WcuR1ovEPDbd+tLfr13J9zGwbiOyFIJBhEggCNCmPhFh5JI45t/FBU4X3b8X2CUHBiusIllADEgVIpBcTVGEe5gbU7ihC/bf9Hl7dp9c+erZW1nRtiRlMHliUDm5ojdjx5tS1TJn1zvSxTuONS0LvPlQABhgy7Fh9+8C8UFhaguKgAkyZ+PeHljp36xl4LCPnSUWjUiJxn1MLHzf85jBChA4RASnoaXHEecG5Si+fl5XUFcE5EqIf25SirVq1KCQQCyG7fAYMGDwcIw7XDr8PCuXNw/Phx5J88xubPnvHYkOFnLi1YHbn38Sfvmzpz9s0rlv0Y53a78fbf3vquzxVTksK/M2Pa1L/t3bsXqampyGzcWL/zwUcerQVFV/VKI3h5nE9ZWRmZOXPF8+1HdB2POFelWQNXNkyan94w6eeuwLhTGjoeLsHlecXIKio1kv266jZ0MEIIXLJS5nHT0hQPDmUkYmcjF1bHAzkJwN5mwFnXrdy25+id363Z/ZcVh4vhSMyCvwqWlZrE7Z2mgyowAQshILjJj+d2u+HUgS1btsQd3Jg/YGeDhAHdmiWjR4tmNzZv6L0o+Mh+WrZ0yO7duyW/348re1yOfv36gXOOjMxM9OjRAwcOHIDP58Py5cu71dtm1cPoqvqMUGKGxVsktnYBZ0KIzcpTfK5t+Prrr2domgbDMNC+fXu0bd8emqahb9++yMrKwuHDh+H3+zFx4sSXY6XoAODGG2/8Yt3aVY9TSrF8+fLElT/+OLxP//6zTWzupyunT5/eIyUlBcXFxfjrs8/+8VyuJZ3eqzVCHMdEmF8V4NAFNzuduaC7mmFufiHKlp5c+tDgrJc7SBjXqpKdT6sq1wrIWIFkfIhkWLifq1YG0GYge6+O62asLX56wZbCpnnBZJC01ggQQHBWqWVml1u0sbjTe/eRmRshbn09jNufEgjBTJuQMmgUKANHseQGS0vBSZ6FPT4/pq0rQdODeVM7Nxa5fVsn/tClAb5JBTbWBHusS/lq/JcfUGqyInfu0hXJaRkIBgJwOCTcPHo05syZC8PgOHrosGP6tCnPXH/DTW/H8voGIZpdaZUTAU5oref71n5dV/sK3JoXRjkPIWBS8RPg2OEjUP0BAARutwc9uvc+Z+68ObNnDvQFA0hOS8WAAQNMf07X4XK50LvfVdiwaRMCgQC2bNjY4NDBHKVJ0xYxKTp178MPPzFt5pS7ly5cHBcfH4933/77V336908EgMXz5v7x8MF9SEhKxOW9+vpuuvX2V8/lWmeF0ZXXYEUIi9q5c2fC5Mkr3jmeV9LnfE/EXbqRuHLt9l9/9dX3f1++fHlTTdPgcrnMAtm1HHMVzot3umvZJdxkWUZcXBzy8/OxevXq1ClT5owe/833361ev/vpParuvhAV3ZIlS1oEg0E0bdoUAwYMgOAckiRBCIE+ffqgQYMGkGUZx44dw/z5859AvZyTpWeX/Ttx4gRmzZqFxMRE+P1+9OzZs/Rcr7N40YLRR48elTVNQ0ZGBq677jpACDidTgAI7b4SQpCbm0umTJkyIZb3ecstt/w3KSkJqqri559/9u7YvjlrX86uxAkTJvRLSkpCaWkpnnzyyRfO9ToVFR3hABEgwmQZtriFrVg4HjahGQxCESBOFEmpOJDQDtMLEvHQnMPz/nQY85cA1+UAzroYFDmAcxOQvQC45/e7sfzeqUdO/X4tf2RaaVPsT+mIPFcaCkg8gkQGoQpAzfqk5mLJAXAIYr5qugKXn8e0BjkjocpGtmUY/hJg0AmDAQUacaGUuJBPvCiIa4jjqZ2wQs7G53np+O1a7Ze3f7u/+NGfS/Z+Z+C3PwH966o/Tyefj/vwP6XFBUQPqmjWuDmu6jcAhgCoJEEQCuZw49rrbggtgNs2bWy2d0dsAHNbGC/f/aSI7S5oNZaySrHrs56AUbu4koXvSkyC6bRySIxADZbhr398HZvXb0BcXByKSspwx133/P1crz9pwoS3SkqK4XQ60KN7T8QlJkHjAqAEhuBokd0ardu1hUQZSoqKsXzh4pjWmrjj7gfGdLisa7GmaQgEAnj/H//cv2bZ8oL9+w8gGFRxzbXDc8+GKTomFl0Id4qyWGRZRlFREb79dubgb6f9OCO3oKxLXQy9kqDWdMWq7TvHfjTzs9mz5/c9cuSIJKxVKbqdIasunDIqllZe1Lmr24d2tXtJkuByuSCEwKlTp9jy5ctbfPDBtL9MnbVy8ZETxQP2asHzquwmTZp0t9/vR1xcHK666qqQJWfDkwBw661msLvb7cb27dvlRYsWXVIxdbH2AML/qqoKQ1UR8PuhaxpOnjyJadOmYdSoUZg4cSKcTidyc3Nx2223HRp1+7m5cwCwcePGRsFgEAkJCRg1alSlLN2jRo0yq+vJMnbv3p2w4jRxb2cjDz744CuJiYkQQmDevHn429/+Bq/XC0op7rnnnpdjcQ2pouYjEAYHZQA0Ghq9RlRlebMcKwHhlk1EJeQjDizOhVw9HbtOqJgyccfK3u2a5Q3uljKlSRzWZAKr3cCxNiYjR41lG9DYDzTMA9rmaWiVk4veq3cU9fx591GvjwN+2g4iToJgMgwCGDoBo+b2eDQmR7gov2Ny9gBMdL3a6JoWFa4b2lOhofq1hnVsEEADRQAKqIOgWE7BMajYqwWx6rCOzw/undO2SUZgWPeG8ztlYlpjgsUd6xDHW79mde9DOftduq4jrUETXDtyJMwC6hw6t1PzgKbNm6J7z8uxYc3P0Hx+rFmx8pqHHn8qdspBUL0yFuyL1UXlnMPtdGP71u0YenV/U9EIZlKiaQFomhYKTPczA8OuG5H7n3Hjmp7rtT/5z9hPjh85ShUmISW1Aa7sPwC6oVlkFrA2PgSuvW4k/vja6+AQOHjkEL5fMP/Fvv0Gxmzj7Lobb3r7008//sOq5SvidF1Hfn4+SkpKcOuttx4ZNvy6sTFXdJLEfGb9UasIMMrj2mry4CilYGAQmsC6detSdq0sfKhjo7iH+rRuhuaZGY8WuZVN8U66r128+7QKb19AZxo34n1BLbMsYDTODRjt95049s72o3nYdugEclUZQUcquJIESiVIkgSDUOhWPU5KWZ0zHcdq8Ftq06RNlyTIICBqEPv27XN+sW3V9e1S5euv7dr63Y5d2zxdV+2aOnXq2/n5+ZAkCR07dkS7Dh0Aao6REJEqBIhMcd999+Gxpcvh9XqxevXqzKVLFt5yVb9B38baErpUxK6nezL3pFlAHKalTJlpGScnJyMzM1O78eZRM5585tc3x+KaixYtur6goABerxe33XYbQAgkZm06hpFaJCYmYuTIkfjqq6/AGMOaNWtinmf73HPP3fXApnunBgJ+CCGQnp6OW2+99Y1YnT9C0bmYcTJe1iGJYIh2xBBmmE/0LmTF6lzUsvwkcCqjhMrwUTfgzIBDUOzx+TF9TQC6sfc/qfFxaJqeqqXEwR/vYb44l+JTGFEpBdcFJE2F4g/qSlFZIK6wLJiQX1yG4/l58KscXJEBKR00PgucSjCIsHZRzYFhs6FAmCzEHDzCQSfnXedFowXRrC2mhSkAaAQAFGhUASECJQ4PiMuA7GmMY4YfP83c/UshCH2gW/aYumj5qmUrugT9ASQkJKBTx7bYt2cHdEOEgr05N3OYKaVITU2By2Umpe/btw/rVq++P1aKThCzxgi3diVJncbVxXb/lROzKLRm6EhKSUa/awblOhwO1QARlFI4nc5Aw4YND3bq1Gl6LHevVy1fMnzPju0pLpcLjDFkZ7fAvr07Q0ZNeEwBpRSXXdYZ48d/gTiXG1s3bXZN/uarN24ebdbUjYX07TdwWus2Hcq2bPrZU1JSgn6Drjk+KEbWXGUWXcDlcuUYRn4LYs82IcJA2OpbJAhjFjZ0AzJjcDidEKDQNA379u2TD+qaDO5LIFwD4eZ2OifUXM0Ig2AKOHOAUxmKQ4HkkKFSAoMwGChnNLavSc7FB70IrLzw+xRCIC0tDQkJCUfrBJub8NUbBw8edNgTY/bs2Vi8eDEMHhWHSE2qe0PTERcXB5/PB4/Hgx9++GHg08+9ELP2XEoWHSEEfr8PPXr0KPtiwsS0urjmwoULf5uTk0MSEuLBGMPbb78d6fnYfIw2ZmfG7IExhuPHj2PlypWjYqnoACA9Pb2IUuqx4k2DsTx3hKJrAQQynOxYEve1KIQGRiQIlIOlQogz1nQImbyCQocAEQS6BASEQCkhINBBZAKimB1IYE4MIqIL8ZDQeU2FZoZrGCTaMuIQECDEVHok1DALC6udXOxYDO9KLTy7n8stZWJ9i5l3Khg0UDCjBIlxCpIS3XvqorUrliy+8+SpY0hKSkZBURGOHDtmKjRqpfMJFolVckBRFMTFeeCJj8OqVatc38+e/dA1w2NBHsmlWOecVt8C4+A12p0/4xLGADNQPZasKGfGW9d0E8LMrsjNzcXBI0ciCqSzqPKanHM4nU4keb3wxidg5dKlbbZu3NC2w2VddsSqTYahUWFwUxcYnNaaogOAzMzMPV7vsStydR2CstBmREgJnQHvCl9pq/rfZlA1sQge6QqHlJ0Vh0bt8obif2J1D+3EVnFPhJgbLIZhIDExMT8pKWF3bbdp+/atDTZt2tRYURTouo7Ro0cfaNas2W7OOROSAOecUUiq2T6Ac84UJmuFhYWps2fP6pqfn080TcOiRYsej4WiE6LcVa2vhFZzmT5tyjNr166N83q9MAwDY8aMWRfn9eZybioXIQRjFl+bEIJZ7Dz+kydPNhn/+eedPB4Ptm/fTteuXfvLDpd1eSLW498a57xWFV2XdOOz7Dj/vYdzCwBPGgxCI9wlkOozAVeG5QnrktFrV8iio9VTWuWbDFYOqjCs90hIUYbg8VikdtUK1hONhpjHxKqha/ab/ZeACpOJWTZUJAZz0cobn9ONYUNtt3Tpwh/+sX3rNsnj8YC5HXj3w+qxwgIAp2TNB+++1yM9ORWzpk3t9siTjytZzc4tsp4Q5i+vN1xZreBafGqEQhB6USu61SuW31dYWAiv14tufXoVv/Lnv3av7m83b9tatnndBrdTcWLJ99/ffO+DD8VM0RHChB3jymPsilU4WbxbOZKWlrY31hZTdVbe6PidSi2dKs53uur1l4LFF7bSQdd1JCYmomXL5mvr4tqrVq0aoOs6NE3Dtddeu7cmvx0wYMAHNlffkSNHsHz58tdjMylIaMwwxrSL/bnWlezcsSXrxx9/7Oj1elFaWopRo0bVqB7EDTfcMKmoqAhJSUlYsGBB+ppVq3vXEm4ZU4uugmbpBOwa3DLxo1ZyCRxaCRRiVr0vzwCo6QpobYASEnlsMwtDB4FersyquI6NH4T44CKwLtuCo7AzHSItpwvPvYm+z/Ljqtpr3pfCg3D7DqOLtxD9M/G72m7niiWLbli1YmVmQqIXATWI62+86dWa/H7QkGHjeve9sri4uBhxcXGY8e2kx2IyEexME50j6Auk1HY/GNZMYdx8xXBCn7Z8Qaxl07p1T23atJHJTgeSUlPQq2/f12ry+8v79P5HaoMMGILDF/Bj8cL5f4id0jdIuC9Qq64rALRsnjkzI6PopZ3HtPiwJ3JGfK5eamG1j8I5uWEyPHfs2Hq6g6GwDqy5Rw4fPozMzAy0atWKD7p66PianqN///6Lfvzh+xsSExOxdOlS756dW7Jatel44FyUAyEEiqKgrKwMb7755pfeDz8uMgxDKt+hMAtkUgqUlZW5unTvseb/Xnp58FlbBJQa1MrxZoyJGCo6gzEGxhgorf3tlfnz598RHx9vB+Tub9WiTY3GUOfLum8aPHjwgW+/mZiVlJSEadOmDXz+xdist4wxbvdxrL2wShVdF2DrnV0bvp13eOnLuwMcPikRmgAMEh43d+5YR7hRSUIrtb1csijsCiGsKvJ9cSYj9QKTSH678oyKyPuyM09Cg0BwOLmKxMAJ9E4RuCE79d6sc6Cuqo4czNnHZkyfPtiTEI8jx4/j3gceOCumjB49Lx/XoFGDGwoLC6ELjvGff/Htq3988/KzbZcuuJTvLwXXNWiFBVi2bKlHCOGJ6OWQa0sQCARwMCfn6huvHdG5ffduZ1WAPKCpbl8wgHjDQInPF7Oi4cGg6goGVQQ1Dl9Aq9XBu/an5QNnz53T0K04cPz4cQweOOSsiCyvvKr/pC/++9lzXq8XGzduZHNmTH1m2Mgb3z7X9vn9fkdQ1+BXgwhoQbnWFR0AtGwWP7ddu3b37dhV2MT+FrGKWddL3Uh0VofN7DxoUM9xMq19ks7i4uKWfr+fNWzYEI0bNxYjRoz47dmc54r+A6aNHDly+4wZM9rJTgcOHz7c+Fza1bZt28/79Onz5smjxzyKlcoTzRbDQ7VGCEpLS0X3Ll2Pnq2SA4CMjIzNzZs3h9OlIDs7Oz9Wfdy0adMNjRs3vrq4qJS0aNHiRG0+z/z8/DYejweJnnjRo0eP4h49erx5Nufp06fPKyNGjHh4x44d3maeZti3b18fAOes6Fq3br1n565tyR6Ph2RlZcW0XjE5HTawtiTQ/fcTl6/dEoxHkSMFfqpApxQQ0oWgBqqw6Gq2K3yhtZ8QEdpNNh0kHTI34OE+JOYfxB19kpa+1u/yfnXVynU/r+leXFzcPCO9wfJ2HdqfE5Pt0h+XDAfhcnp6+uo2bc/tXACwcf2GtpRFBlGHHNcwa1jXdU/Xbj3OuWrWqp9WDAwEgwlNmjRZ0KJFK1+s+njl8hUDVVVNyMrKmtmsRfNatdKXL186RNO0hAEDzi1LZd/eHOXQoUNDQAnv16/f7Fi1b9myJcM553K/fgOm1Zmi2wPEzzuOf/11ypp7CpXkekVXx+23FZ2TAKQ0F/2bJBX/+oam9w0AptTbu/VSLzFwXQGr9kMm7o0fkHry7VkbnjsV1wIlkgt+6oFOpHIsqVIMztak1cOszpwDeiZszr4ureZ1z7dU1UAKYnAQokEWHE4RQHLpEVyepOJXA9oM7Qn8VD9s66VeaibVMns6t2v+35EjRy6tCYtJvZy9WDtwIIRA0zRkZmZqo0YNfSnF69xa3zv1Ui8xdl2j5cuth/40bvGGF3O0BJQ5UuBX4hGkBBwM3DIO7eiX6F3Ec5dzdUnP9+8jsSRq5xJacZFMcIsxV4OLq3BqZUgsOYJ+rRQ8OPiKXpfHe1bXD9d6qZdatOhs6dKhycd33jny3aZNmwY559A0LVSLtbK4l/Bo/nqJzN6obIGxM0NUVQVjDFdeeeX+20YNuS053rO9vvfqpV7qyKKzZbumZUxfsfWT5buOjdhRLFAip4A6PAjKLuggEFSGZggYtNyeo3ZOqm0ZRYN4pzk2Syyi2t+P9e9jdf5wsgIJHJRrYBRwQIUIBuD0nUKqEsRlaW7ceHnbp29o2fDd+iFaL/VynhQdAPwM9NxdhuvmbS66f/ORkgZHTxWwU34NktMFIjnAZAc4M/msIlzZWlA0F9IxsQvj2DRTdoCwHRhNTGp36CqgB2HoKiTDj/REL9qkuct6ZDfYNKAlfa8JsPBsKefrpV7qJUaKLlw2FvizN+QceDQnr/TZgwU+HCjwo7DUh+KglSMowuuoRmNdkceEiNN+DnAL62LWXxE6rs75z/XY5iKj4vTfF4KE2mcLE4AQHDJl8HoUNHQ7kJXuQJMEJ9o0TntqZKum79cPyXqplwtU0QHATiCjCGh5XEWPo6XoUlSG9OIgUjTAYehmhTpTkV3cHcYt04wK1GgLmhBwJmAwBl0i0JLicSJdwZ5GiViTBGxLAPa2QO1nO9RLvdQrunqpl3qpl0tQaH0X1Eu91Eu9oquXeqmXernI5f8HABe0i1c5OI8nAAAAAElFTkSuQmCC" align="absmiddle"></label> &nbsp; &nbsp; ';
		$html .= ' <label><input type="radio" name="pay" value="2"/><img width="110" height="35" src="data:image/png;base64,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" align="absmiddle"></label>';
		$html .= '</div></form>';
	    $html .= '<div style="margin:1rem;padding:0 0.8rem;text-align:right;"><span id="pay_errortxt" style="float:left;color:#e80f59;line-height:40px;font-family:Microsoft Yahei,monospace;"></span><input type="image" src="'.$bottonImg.'" width="70" onclick="exam.sendpays(\'FrmListID\');"/></div>';
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
		
		$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('id'=>$arr[0]))->get()->array_row();
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
					$days = $rule1['r_day'][$arr[1]];
					break;
				}
				else
				{
					$pay = $rule1['r_fra'][$arr[1]];
					$days = $rule1['r_day'][$arr[1]];
					break;
				}
			}
						
		}
		
	}
	
	if( $pay != 0 )
	{
		session_start();
		$_SESSION['exam_pays'] = $pay;
		$_SESSION['exam_centreno'] = $row['centreno'];
		$_SESSION['exam_infoify_id'] = $row['pid'];
		$_SESSION['exam_infoify_flagpay'] = $_POST['pay'];
		$_SESSION['exam_infoify_days'] = $days;
		$_SESSION['exam_infoify_string'] = $string;
		
		echo json_encode(array("error"=>0,'txt'=>$_POST['pay']));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWINFO_ON_1));
	}
	
}
function payments()
{
	session_start();
	
	$t = time();
	
	$centreno = $_REQUEST['exam_centreno']==null?$_SESSION['exam_centreno']:htmlspecialchars($_REQUEST['exam_centreno'],ENT_QUOTES);
	
	$data['centreno'] = $centreno;
	$data['price'] = $_SESSION['exam_pays'];
		
	if( isset( $_SESSION['log_on_user'] ) )
	{
		$data['username'] = $_SESSION['log_on_user'];
	}
	elseif( isset($_COOKIE['log_on_user']) )
	{
		$data['username'] = $_COOKIE['log_on_user'];
	}
	else 
	{
		echo '<script>alert("'.SHOWCENTRENO_23.'");location.href="'.apth_url('index.php/exhibition/'.$_SESSION['exam_infoify_id']).'";</script>';exit;
	}
	
	$data['commodityname'] = SHOWCENTRENO_22;
	$data['ordernumber'] = $t.mt_rand(100000, 999999);
	$data['ordertime'] = $t;	
	$data['paymenttime'] = 0;
	$data['state'] = 0;
	$data['methods'] = $_SESSION['exam_infoify_flagpay'];
	$data['daystime'] = time()+(60*60*24*$_SESSION['exam_infoify_days']);
	$data['meals'] = $_SESSION['exam_infoify_string'];
	
	if( $data['username'] != '' )
	{
		$row = db()->select('id,centreno,commodityname,price,ordernumber,ordertime,username,paymenttime,state')->from(PRE.'paymentform')->where(array('username'=>$data['username'],'centreno'=>$data['centreno']))->get()->array_row();
		if( !empty( $row ) )
		{
			db()->update(PRE.'paymentform', array('meals'=>$data['meals'],'price'=>$_SESSION['exam_pays'],'methods'=>$data['methods'],'daystime'=>$data['daystime']), array('username'=>$data['username'],'centreno'=>$data['centreno']));
			$ordersn = $row['ordernumber'];
		}
		else 
		{
			db()->insert(PRE.'paymentform',$data);
			$ordersn = $data['ordernumber'];
		}
			
		switch ( $data['methods'] )
		{
			case '1':
				echo '支付宝支付<br/>';
				//print_r($data);
				echo '<a href="'.apth_url('index.php/callback_result/'.$ordersn).'">支付成功后</a>';
			break;
			case '2':
				echo '微信支付<br/>';
				echo '<a href="'.apth_url('index.php/callback_result/'.$ordersn).' target="_top">支付成功后</a>';
			break;
		}
					
	}
	else
	{
		echo '<script>alert("'.SHOWCENTRENO_23.'");location.href="'.apth_url('index.php/exhibition/'.$_SESSION['exam_infoify_id']).'";</script>';
	}
}
function callback_result()
{	
	$paystate = 1;
	
	if( $paystate )
	{
		header('location:'.apth_url('index.php/payment_results/'.GetIndexValue(1)));
	}
	else 
	{
		
	}
}
function payment_results()
{	
	include( getThemeDir3() );
		
	require( base_url_name( SHOWPHPEXCELS_7 ) );
}
function rembershiproom()
{
	include( getThemeDir3() );
	
	$username = GetUserName_index();	
	$ordersn = GetIndexValue(1)==null?'1534758108946827':GetIndexValue(1);
	
	$flagstate = 0;/*0=未支付；1=已支付*/	
	$where = ' ordernumber="'.$ordersn.'" and username="'.$username.'" and state='.$flagstate.' and FROM_UNIXTIME(daystime,"%Y-%m-%d %H:%i:%s")>="'.time().'" ';
	$row1 = db()->select('*')->from(PRE.'paymentform')->where($where)->get()->array_row();
	if( empty( $row1 ) )
	{
		echo '<script>alert("'.SHOWCENTRENO_24.'");location.href="'.apth_url('index.php/index_e').'";</script>';exit;
	}
	
	$centreno = $row1['centreno'];
		
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('centreno'=>$centreno))->get()->array_row();
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
				$html .= ($html==null?'<a href="'.apth_url('index.php/index_e').'">'.HOME_PAGE_1.'</a> &gt; ':' &gt; ').'<a href="'.apth_url('index.php/exhibition/'.$v['id']).'">'.$v['title'].'</a>';
			}
		}
	}

	$bread = $html==null?'<a href="'.apth_url('index.php/index_e').'">'.HOME_PAGE_1.'</a> &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>':$html.' &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>';
			
	require( base_url_name( SHOWPHPEXCELS_8 ) );
}
function GetKaoShiVipModule()
{	
	session_start();
	
	$ordersn = htmlspecialchars($_POST['ordersn'],ENT_QUOTES);
	$username = htmlspecialchars($_POST['user'],ENT_QUOTES);	
	$type = htmlspecialchars($_POST['type'],ENT_QUOTES);
		
	if( $ordersn!=null && $username!=null ) 
	{
		$flagstate = 0;/*0=未支付；1=已支付*/	
		$where = ' ordernumber="'.$ordersn.'" and username="'.$username.'" and state='.$flagstate.' and FROM_UNIXTIME(daystime,"%Y-%m-%d %H:%i:%s")>="'.time().'" ';
		$row1 = db()->select('*')->from(PRE.'paymentform')->where($where)->get()->array_row();
		if( empty( $row1 ) )
		{
			echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_24));exit;
		}
		
		$centreno = $row1['centreno'];
		$meals = explode('-', $row1['meals']);
		
		$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('centreno'=>$centreno))->get()->array_row();
		if(  empty( $row )  )
		{
			echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_26));exit;
		}
		
		$rule2 = unserialize($row['rule2']);
	
		if( $row['roomsets'] != 1 )
		{
			echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_26));exit;			
		}
		
		$totalexam = $rule2['totalexam'];
		$totalscore = $rule2['totalscore'];
		$passscore = $rule2['passscore'];
		$times = intval($rule2['times']);	
		$solve = $row['solve'];
		
		$voidArr = array('E','C');
		$pcArr = array('P','J');
		
		$bel = $voidArr[$row['tariff']].$pcArr[$row['roomsets']];
		
		$xb = md5($row['pid'].$type.$solve);
		
		if( !isset( $_SESSION['VIPKAOTIALLINFOINTHS_1'][$xb][$bel] ) || empty($_SESSION['VIPKAOTIALLINFOINTHS_1'][$xb][$bel]) )
		{		
			if( $solve == 0 )
			{									
				switch ( $rule2['chouti'] )
				{
					case 0:
						if( $row['roomsets'] == 1 )
						{
							foreach( $rule2['typeofs'] as $k => $v )
							{
								$sql  = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$v.' and pid in('.$row['pid'].') ';							
								$sql .= ' order by rand()*10000000 limit '.$rule2['extracts'][$k].' ';							
								$rows = db()->query($sql)->array_rows();
								if( !empty( $rows ) )
								{
									$timu['kaoti'][$v] = $rows;
									$timu['count'] += count( $rows );
								}
							}																		
						}
					break;
					case 1:
						if( $row['roomsets'] == 1 )
						{
							foreach( $rule2['typeofs'] as $k => $v )
							{
								$sql  = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$v.' and pid in('.$row['pid'].') ';							
								$sql .= ' order by id asc limit 0,'.$rule2['extracts'][$k].' ';							
								$rows = db()->query($sql)->array_rows();
								if( !empty( $rows ) )
								{
									$timu['kaoti'][$v] = $rows;
									$timu['count'] += count( $rows );
								}
							}						
						}
					break;
				}						
				
			}
			elseif( $solve == 1 )
			{
				if( $row['roomsets'] == 1 )
				{					
					$All = UpwardsLookup5($row['pid']);					
									
					if( !empty( $All ) )
					{
						foreach( $All as $k => $v )
						{
							$tmp .= ($tmp==''?'':',').$v['id'];
						}							 					 	
					}
					else
					{
							$tmp = $row['pid'];
					}
				}		
				switch ( $rule2['chouti'] )
				{
					case 0:
						if( $row['roomsets'] == 1 )
						{							
							foreach( $rule2['typeofs'] as $k => $v )
							{						
								$sql = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$v.' and pid in('.$tmp.') ';	
								$sql .= ' order by rand()*10000000 limit '.$rule2['extracts'][$k].' ';	
								$rows = db()->query($sql)->array_rows();
								if( !empty( $rows ) )
								{
									$timu['kaoti'][$v] = $rows;
									$timu['count'] += count( $rows );
								}
							}												
						}
					break;
					case 1:
						if( $row['roomsets'] == 1 )
						{							
							foreach( $rule2['typeofs'] as $k => $v )
							{						
								$sql = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$v.' and pid in('.$tmp.') ';	
								$sql .= ' order by id asc limit 0,'.$rule2['extracts'][$k].' ';							
								$rows = db()->query($sql)->array_rows();
								if( !empty( $rows ) )
								{
									$timu['kaoti'][$v] = $rows;
									$timu['count'] += count( $rows );
								}
							}					
						}
					break;
				}			
			}		
			$_SESSION['VIPKAOTIALLINFOINTHS_1'][$xb][$bel] = $timu;			
		}
		
		$timus = $_SESSION['VIPKAOTIALLINFOINTHS_1'][$xb][$bel];		
		$tb = $_POST['tb']==null?'0':$_POST['tb'];
		$count = count($timus['kaoti'][$type]);
		
		if( !isset( $_SESSION['SETTIMESCHASHU_1'][$xb][$row['pid']] ) || empty($_SESSION['SETTIMESCHASHU_1'][$xb][$row['pid']]) )
		{
			$_SESSION['SETTIMESCHASHU_1'][$xb][$row['pid']] = date('Y/m/d H:i:s',time()+(60*60*$times));
		}
		
		$his = strtotime($_SESSION['SETTIMESCHASHU_1'][$xb][$row['pid']])-time();
		
		if( !empty( $timus ) )
		{
			$daojiImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAE8klEQVR4Xu1aTVoiSRB9geDW7hNMzwlaFxbLSU4gMzBr6ROoN7BPoJ6gcd3FNJ6AdEm5kD5BMycY2bZIzJf1o1V8hVT+AM5QtdGPyqyMfPEiMiIjCFv+0JbvHyUAJQO2HIHSBLacAKUTLE1gHSYQ/Cn2McMJCB8KrccYo4Ir76scFRpvMWgtDAha4hJEJ1pyMl95PXmqNcdg8FoAGLZEk4i6APYKyjhh5k69J/sFxxsPWwsAedLdtYVg0EC9I3Dj0JfSeBcWE0sALMAznnrfFO8ed3AMosutYMB9U3yYVnHMgABjH0Tv0uj9b01g2BLHRDgFaP9VuhAf5B15IVNq9LH2yN8P+vIh35c0jqpTvl30fhlNV+IDIgeHiwUbv2Vw6PBohjF2MFp03g/bok+gI2YeAzibPxWClvgCog7A0vNlY9lm8947BSC27YtIqNTDfM1AX/dYC9oNBdRvz19i7taecKa0/bJ5gBl/13uDYkHWHArOAAg3X8Ugo3Xm69oTzg/6UmlQ+1Hf/FlFV7HgZTKPmDEmomb82wTEwjRqdAKACnV5hm9EFGpBaYQq3DQVah6pVwIpq81HJ5DlE9P+R+LZmfF994mFqVNaJE4eG1ycHtYABG2haC9CwZmvvZ7M2r8lwPPTs3mFufNLvmsFQFqYVWk+D7/kdAgxB3+u+/LcFGdjAFRw81ilH4kjqk1539TZ6QofmsMOSSJ8jOzYPJcwBiBoiS6IjkPhZ/zJ+0uqbE/rGbbFeQXgQ19+1poIIDp1SJ0ue2uPA9KZHIBbzx9EPkDjcZENppVgygIjBrhY2AkA6qaJ6T72BTd1XyaxQWFVmALwjzr2bCIwFwCoXaajRc8faO9He0KG/hbXVs4A+EN0UKEvps5QG4DMObwgiyvCP2cApMwABgrRByCVoJhQLgHHFQCxGXD8XW2HbAyAjf0rYf+7ALRE6ABNj78VMSBKm5kfvJ58X8QEjUPhoN0wpltaMMcMeL430DVLExNwAkASzipQbLNHm6PQBAB1N6fCz5HnywMduq1qbNAW9/FFzMTzB5kL12VrmgBgTLdlwpi+tzFLfQBSSVBtyr+uKwNcBE4mKzW4j9AHIBt5nR36MixubOq5a4tTBl2E6xtkpdoAzN0DaAceroFKO0ATRmoDoDYwbDVGyWWEyaKuQEgrQ91I1XuD1wswOQsbARCkzGAd94CLAHNxKWMEQMyCMRF+Uf9vggVh10lyF7CJwkiGBRalKVNzyNxGGzg/41A4LXCmdMXc9Xryk+mGdOaly2K2OYmxCSiBYyekGpmi1hcLTRQFIMs8TGxvo60AiHxB2P/z7XkDzKdeT14V3ZDOuKAlTpKmCjWPmX/XLbjOr2cNgPrgnFaUZE7NIbfq7IhtTgDIA2FRTV9H4wnDAFwkhVfXpuYMACVYnOOr1rZUOxxLAl0e+oMbnc3ftRtHDFbdJemaw4TATZcdZU4BiB1jTk0/NNgHBlQm2aeKqujwJCmfh2c6aI9nrMrrTVK9RHN9RAy+2Z2i47rq7ByARMsxG1TR8qXDQ4cCL2NvCXzuUutpMVYGQLJI3CfcYVAziRyX4RA2WID7qKDrqsli0ZorByC9sIobfu6oNjkkSUvyN2qKZox2nzBa5x3DWgFYpvlNvC8B2ATqb2nNkgFvSRubkKVkwCZQf0trlgx4S9rYhCz/AmhewV8tCM+5AAAAAElFTkSuQmCC';
	    	$lenImg = 'data:image/png;base64,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';
	    	$vipImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAEaklEQVR4Xu1ZTVYTQRD+Kj4f7oQTGE4AnsB4AuEE4EaSlXgC5QTCKsENcAL1BMIJhBMIJzDZ6fO9lK9r/npmunpmMAMO6VkmPT3dX3311VfdhCV/aMn3jwBAYMCSIxBSYMkJEEQwpEBIgSVHIKTAkhMgVIGQAiEFlhyBNAX4GO+bYEF7OEjG8xgD9PBCfX8OQg/cZH7McUMjnPIYu+jhWaN3zWDGFD1c0htc+N7NAJg0WyANMwHlMT6AmgFYuSHGBY0w4DHOQR5wKyeSAadgHNAI18XhGQBj9NHDFhgfADx1zssS9XM8wSW9xtRiQB9AH4QtAG+td2cgAedcfmP0Mce+Z0MzMA7tb/AJVvELmwAGIOx71nYjG83WUd4D47Vhlb23UhXgY+yD8bEEQByRKsA5Y9IMPQzoDS7td2RDvyUSrgWaKJkAuPHXmTbDCvpJUOJvGNA3HPvIgVAGIFrgT8cKrmmIdR8AbFhE+BFH+4xG2HWNV2nNeEmjmC2OF0VrCN8cfx3RUNiRPvwJm5jju2PsFCtYT8By+gDPAtddeWSlwi4IJzEA6mYWDkCU3yXmeL6TskADwC1qjhzKoT7BFwCvAMxoiFUPld3CdlsG6ABo4vyVhqJXbius0oeh09pOHc840UJN2RcPQMbIXKSiCqMCIIuciMoXhUrVAT6WCvJZvkPYpj1hgyZmd8UAt2aweAxTufRmiMc4BWHHoaJOHbDH2x7hTkRQTwENgBoMMA4sETR7F4R3tCe1OvfwRCqHyfs0v/4DBmgakFYNtRvMlbT8TkobzNG/QijvVAMmUjIl1/PRysqttx3miZiYopmY0hBrOU2x02UFa7ZLvK8UUD1DwdBVAWCoblvbaD89PLcdHk/E/PRR1y22XAX4GDuxpS6W4pI79QNgK3u+jKTGI1cyFX0oMXDRAECsddLomL6h7EEYN3iEraI1rzwRsrx9tg8r0jwRQYxYwvA6xWSChfsATW2jNZl2+LTYBCWvVAOgRCspdSn9gSsaStdW+SwcAMZZ3Anmvu3rK+oDoHWHhG0QrtOGQ6nF9yWClVGIB1QzQO+qjuI5IvoXhNHLykVrQAPwi+uqBEDSyG2LTYk0YmPUP7WWdZBvIQW85wi+NdUDQLPF2cylfvxhMUCzxams+w8yWi+DraeAfkpk9ubt/TsvgmmQ3bbY1Fn1jEBLg85pQCyEbltc0fs/HAYoB5JVvf+DASBmQfF2p7L3LwlgpCemeXL59dsei1/SEM/rlOBb+QBLB5JDz+inGr2/DDOb/oMNzGXT5vRWt8zZRcrMNC7SbJmjOcYALEff2mGruQc4RA9TPMZVVUte2wrbiJUuTWr0/gKAfp6vB+1frsYqDlftj9YyQikDzMUH0suOa63DctR9+726TJX55XLUuM1mj+n+SveArikaAdBsDd0YHQDoRpzaW2VgQHvYdmPmwIBuxKm9VQYGtIdtN2YODOhGnNpbZWBAe9h2Y+bAgG7Eqb1VBga0h203Zv4LX6FRX9/U+xAAAAAASUVORK5CYII=';
	    	$seImg = 'data:image/png;base64,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';
	    			
			$kaotimodule  = '<div class="exam_rembershdiv4"><img src="'.$lenImg.'" width="12" height="12" align="absmiddle"/>时长'.$times.'小时</div>'; 
	    	$kaotimodule .= '<div class="exam_rembershdiv4-1"><b><img src="'.$daojiImg.'" width="16" height="16" align="absmiddle"/>计时考试：<span class="exam_lentime_dao">'.formatSeconds($his).'</span></b></div>'; 
	    	$kaotimodule .= '<p class="exam_rembershp0">总共：'.$timus['count'].' 题 &nbsp; 全部答对满分（'.$totalscore.'）</p>';
	    		
	    	$kaotimodule .= '<dl class="exam_rembershdl5">';	    	
	    	for($i=1;$i<=$timus['count'];$i++)
	    	{
	    		$kaotimodule .= '<dd class="exam_rembershdd6">'.$i.'</dd>';
	    	}
	    	$kaotimodule .= '<dd style="clear:both;"></dd>';
	    	$kaotimodule .= '</dl>';
	    		  		
	    	$kaotimodule .= '<p class="exam_rembershp0">题型：<b>单选题</b> &nbsp; （ 共 <span class="exam_countall">'.$count.'</span> 题 ）<span class="exam_rembershpspan0">考场编号（'.$centreno.'）&nbsp; '.$row['title'].' &nbsp; <img src="'.$vipImg.'" width="21" height="21" align="absmiddle"/></span></p>';
	    	$kaotimodule .= '<p class="exam_rembershp1"><span class="exam_descrort">'.($tb+1).'.</span> '.$timus['kaoti'][$type][$tb]['dry'].'</p>';
	    	$kaotimodule .= '<p class="exam_rembershp2">请选择答案：</p>';
	    		
	    	$kaotimodule .= '<form id="exam_rembershform0">';
	    	$kaotimodule .= '<ul class="exam_rembershul0" style="margin: 0.6rem 0px 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;;">';
	    	
	    	$optionsArr = explode('&', $timus['kaoti'][$type][$tb]['options']);	    	
	    	if( !empty( $optionsArr ) )
	    	{
	    		foreach( $optionsArr as $k => $v )
	    		{
	    			$ds = mb_substr($v, 0, 1,'utf-8');
			    	$kaotimodule .= '<li class="exam_rembershli0" style="margin: 0px; padding: 0px; font-family: &quot;Microsoft YaHei&quot;; list-style-type: none; line-height: 3rem; font-size: 13px; color: rgb(58, 56, 56);">';
			    	$kaotimodule .= '<label><input type="radio" name="rightkey" value="'.$ds.'">'.$v.'</label>';
			    	$kaotimodule .= '</li>';
	    		}
	    	}
	    	$kaotimodule .= '</ul></form>';    		    		
	    	$kaotimodule .= '<p class="exam_rembershp3"><img src="'.$seImg.'" width="20" height="20" align="absmiddle"> <font color="#00ce6d">请选择答案</font></p>';   		
	    	$kaotimodule .= '<div class="exam_rembershdiv3" style="margin: 1.2rem 0px 1rem; padding: 1rem 0px; text-align: center; font-family: &quot;Microsoft YaHei&quot;;">';
	    	$kaotimodule .= '<input type="button" class="exam_rembershbtn0" value="确定" onclick="exam.ChargeEditionVIP();"/>'; 
	    	$kaotimodule .= '<input type="button" class="exam_rembershbtn0" value="放弃" />';
	    	$kaotimodule .= '<input type="button" class="exam_rembershbtn0" value="上一题" />';
	    	$kaotimodule .= '<input type="button" class="exam_rembershbtn0" value="下一题" />';
	    	$kaotimodule .= '<input type="button" class="exam_rembershbtn0" value="交卷" />';
	    	$kaotimodule .= '</div>';
		}
    	
		echo json_encode(array("error"=>0,'txt'=>$kaotimodule,'danticount'=>$count,'time'=>$_SESSION['SETTIMESCHASHU_1'][$xb][$row['pid']]));
	}
	else
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_25));
	}
}
function ChargeEditionVIP()
{
	session_start();
	
	$ordersn = $_POST['ordersn'];
    $username = $_POST['user'];
    
    $type = $_POST['type'];
    $tb = $_POST['tb'];
    
	$flagstate = 0;/*0=未支付；1=已支付*/	
	$where = ' ordernumber="'.$ordersn.'" and username="'.$username.'" and state='.$flagstate.' and FROM_UNIXTIME(daystime,"%Y-%m-%d %H:%i:%s")>="'.time().'" ';
	$row1 = db()->select('*')->from(PRE.'paymentform')->where($where)->get()->array_row();
	if( empty( $row1 ) )
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_24));exit;
	}
		
	$centreno = $row1['centreno'];
		
	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('centreno'=>$centreno))->get()->array_row();
	if(  empty( $row )  )
	{
		echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_26));exit;
	}
    	
    $rightkey = strtolower($_POST['rightkey']);   
	if( $rightkey == null )
    {
    	echo json_encode(array("error"=>1,'txt'=>SHOWCENTRENO_6));exit;
    }
    	
	$voidArr = array('E','C');
	$pcArr = array('P','J');
	$solve = $row['solve'];	
	$bel = $voidArr[$row['tariff']].$pcArr[$row['roomsets']];
	
	$xb = md5($row['pid'].$type.$solve);
	
	$_SESSION['ChARGEEDITIONVIPS_1'][$xb][$bel][$row['pid']][$type][$tb-1] = $rightkey;	
	$_SESSION['ChARGEEDITIONVIPS_2'][$xb][$bel][$row['pid']] = $type;	
	$_SESSION['ChARGEEDITIONVIPS_3'][$xb][$bel][$row['pid']] = $tb-1;
 
}
function GetUserName_index()
{
	session_start();
	
	$username = '';
	
	if( isset( $_SESSION['log_on_user'] ) )
	{
		$username = $_SESSION['log_on_user'];
	}
	elseif( isset($_COOKIE['log_on_user']) )
	{
		$username = $_COOKIE['log_on_user'];
	}
	
	return $username;
}
function free_sion()
{		
	session_start();
	
	include( getThemeDir3() );

	$flagId = htmlspecialchars(GetIndexValue(1),ENT_QUOTES);
	$bel = htmlspecialchars(GetIndexValue(2),ENT_QUOTES);
	
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
				$html .= ($html==null?'<a href="'.apth_url('index.php/index_e').'">'.HOME_PAGE_1.'</a> &gt; ':' &gt; ').'<a href="'.apth_url('index.php/exhibition/'.$v['id']).'">'.$v['title'].'</a>';
			}
		}
	}

	$bread = $html==null?'<a href="'.apth_url('index.php/index_e').'">'.HOME_PAGE_1.'</a> &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>':$html.' &gt; <a href="'.apth_url('index.php/exhibition/'.$ify['id']).'">'.$ify['title'].'</a>';
		
	$num = $_SESSION['CHOOSEANSWER2'][$flagId][$bel];
	$type = $_SESSION['CHOOSEANSWER3'][$flagId][$bel];
	
	if( !isset( $_SESSION['GETSTARTANDENDS'][$flagId][$bel]['start'] ) )
	{
		$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['start'] = time();
	}
	
	require( base_url_name( SHOWFREETEMPLATES_1 ) );
}
function FreePractice()
{
	session_start();
	
	$flagtype = htmlspecialchars($_POST['type'],ENT_QUOTES);
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$bel = htmlspecialchars($_POST['bel'],ENT_QUOTES);
	
	$_SESSION['CHOOSEANSWER3'][$flagId][$bel] = $flagtype;
	
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
				}
			break;
			case 1:
				if( $row['roomsets'] == 0 )
				{					
					$All = UpwardsLookup5($id);					
					
					if( !empty( $All ) )
					{
					 	foreach( $All as $k => $v )
					 	{
					 		$tmp .= ($tmp==''?'':',').$v['id'];
					 	}							 					 	
					}
					else
					{
						$tmp = $id;
					}
					
					$sql = 'select id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state from '.PRE.'examination where typeofs='.$flagtype.' and pid in('.$tmp.') ';	
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
		
		$xb = md5($flagId.$flagtype.$solve);
				
		if( !isset( $_SESSION[$xb][$flagtype][$bel] ) || empty($_SESSION[$xb][$flagtype][$bel]) )
		{
			$row2 = db()->query($sql)->array_rows();
			$_SESSION[$xb][$flagtype][$bel] = $row2;			
		}
		
		$rows = $_SESSION[$xb][$flagtype][$bel];
		$count = count( $rows );
				
		$tb = $_POST['tb']==null?'0':$_POST['tb'];
		
		$_SESSION['CHOOSEANSWER2'][$flagId][$bel] = $tb;
		$BBID = $_SESSION['CHOOSEANSWER'][$flagId][$bel][$rows[$tb]['id']]['k'];
		
		$number = $tb==0?'1':$tb+1;
		
		$mixin = '';
		$lxImg = 'data:image/png;base64,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';    	
		
		if( !empty( $rows ) )
		{
			$mixin .= '<div class="exam_freesiondiv4"><span>'.SHOWCENTRENO_1.'（'.$row['centreno'].'）</span> &nbsp; <span>'.$row['title'].'</span> &nbsp; <span>'.($row['roomsets']==0?SHOWCENTRENO_2:SHOWCENTRENO_3).'</span> <img src="'.$lxImg.'" width="30" height="30" align="absmiddle"/></div>';
    		$mixin .= '<p class="exam_freesionp0">'.TYPEOFS.'：<b>'.GetFourTypes2($flagtype).'</b> &nbsp; （ '.SHOWCENTRENO_4.' <span class="exam_countall">'.$count.'</span> '.SHOWCENTRENO_5.' ）</p>';
    		$mixin .= '<p class="exam_freesionp1"><span>'.$number.'.</span> '.$rows[$tb]['dry'].'</p>';
    		$mixin .= '<p class="exam_freesionp2">'.SHOWCENTRENO_6.'：</p>';
    		$mixin .= '<form id="exam_freesionform0">';   		
	    	if( $flagtype == 1 )
	    	{    	
	    		$daanArr = explode('&', $rows[$tb]['options']);
	    		
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
	    		$daanArr = explode('&', $rows[$tb]['options']);
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
	    		$daanArr = explode('&', $rows[$tb]['options']);
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
	    		$xxgg = array('×'=>SHOWCENTRENO_7,'√'=>SHOWCENTRENO_8);
	    		if( $BBID == $zqda || $BBID == $xxgg[$zqda] )
				{
	    			$mixin .= '<p class="exam_freesionp3">'.SHOWCENTRENO_9.'（'.strtoupper($BBID).'），'.SHOWCENTRENO_10.'<img src="'.$okImg.'" width="20" height="20" align="absmiddle"/></p>'; 	
				}
				else
				{
					$mixin .= '<p class="exam_freesionp3"><font color="red">'.SHOWCENTRENO_9.'（'.strtoupper($BBID).'），'.SHOWCENTRENO_15.'<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">'.SHOWCENTRENO_11.'：'.strtoupper($zqda).'</font></font></p>'; 
				}
				$flag = 1;
	    	}
	    	else 
	    	{
	    		$flag = 0;
	    		$SelImg = 'data:image/png;base64,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';				
	    		$mixin .= '<p class="exam_freesionp3"><img src="'.$SelImg.'" width="20" height="20" align="absmiddle"/> <font color="#00ce6d">'.SHOWCENTRENO_6.'</font></p>'; 
	    	}
	    	$mixin .= '<div class="exam_freesiondiv3">';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0 ExambtnNext1" onclick="exam.Determine(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\')" value="'.SHOWCENTRENO_12.'"/> ';
	    	$mixin .= ' <input type="button" class="exam_freesionbtn0" onclick="exam.give_up(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\');" value="'.SHOWCENTRENO_13.'"/> ';
	    	
	    	if( $tb == ($count-1) && $flagtype == 3 )
	    	{
	    		$mixin .= ' <input type="button" class="exam_freesionbtn0 ExambtnNext" value="'.SHOWCENTRENO_17.'" onclick="exam.NextQuestion(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\')"/> ';
	    		if( $flag == 1 )
	    		{
	    			$mixin .= ' <input type="button" class="exam_freesionbtn0" value="'.DANXUANTI_1.'" onclick="exam.SingleChoiceQuestion(1,0)"/> ';
	    			$mixin .= ' <input type="button" class="exam_freesionbtn0" value="'.DANXUANTI_2.'" onclick="exam.SingleChoiceQuestion(2,0)"/> ';
	    			$mixin .= ' <input type="button" class="exam_freesionbtn0" value="'.DANXUANTI_3.'" onclick="exam.SingleChoiceQuestion(3,0)"/> ';
	    		}
	    	}
	    	else
	    	{	    		
	    		$mixin .= ' <input type="button" class="exam_freesionbtn0 ExambtnNext" value="'.SHOWCENTRENO_14.'" onclick="exam.NextQuestion(this,\'exam_freesionform0\',\'exam_freesionp3\',\''.$rows[$tb]['id'].'\',\'exam_freesionp1\')"/> ';
	    	}
	    		    		    	
	    	$mixin .= '</div>';	    		    	
		}
		if( $mixin != '' )
		{
			echo json_encode( array( 'error'=>0,'txt'=>$mixin,'f'=>$flag,'count'=>$count ) );
		}
		else
		{
			echo json_encode( array( 'error'=>1,'txt'=>'<div style="margin:50px;text-align:center;color:#a2a1a0;font-family:Microsoft YaHei;">'.SHOWCENTRENO_21.'</div>') );
		}
	}
	else
	{
		echo json_encode( array( 'error'=>1,'txt'=>SHOWINFO_ON_1,'f'=>0 ) );
	}
}
function EDetermine()
{
	session_start();
	
	$okImg = 'data:image/png;base64,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';
	$noImg = 'data:image/png;base64,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';
	
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$rightkey = $_POST['rightkey'];
	$rightkey2 = strtolower($rightkey);
	
	$num = $_POST['n'];
	$type = $_POST['type'];
	$ify = $_POST['ify'];
	$bel = $_POST['bel'];
	
	$_SESSION['CHOOSEANSWER'][$ify][$bel][$flagId] = array('n'=>$num,'k'=>$rightkey2,'id'=>$flagId);
	$_SESSION['CHOOSEANSWER2'][$ify][$bel] = $num;
	$_SESSION['CHOOSEANSWER3'][$ify][$bel] = $type;
	
	$row = db()->select('id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state')->from(PRE.'examination')->where(array('id'=>$flagId))->get()->array_row();
	if( !empty( $row ) )
	{
		$zqda = strtolower( $row['answers'] );
		
		if( $rightkey2 == $zqda )
		{
			echo json_encode( array( 'error'=>0,'txt'=>SHOWCENTRENO_9.'（'.strtoupper($rightkey2).'），'.SHOWCENTRENO_10.'<img src="'.$okImg.'" width="20" height="20" align="absmiddle"/> ' ) );
		}
		else
		{
			echo json_encode( array( 'error'=>0,'txt'=>'<font color="red">'.SHOWCENTRENO_9.'（'.strtoupper($rightkey2).'），'.SHOWCENTRENO_15.'<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">'.SHOWCENTRENO_11.'：'.strtoupper($zqda).'</font></font> ' ) );
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
	$ify = $_POST['ify'];
	$bel = $_POST['bel'];
	
	$row = db()->select('id,pid,typeofs,dry,options,numbers,answers,analysis,years,booknames,subtitles,chapters,hats,publitime,state')->from(PRE.'examination')->where(array('id'=>$flagId))->get()->array_row();
	if( !empty( $row ) )
	{
		$zqda = strtolower( $row['answers'] );
		
		$_SESSION['CHOOSEANSWER'][$ify][$bel][$flagId] = array('n'=>$num,'k'=>SHOWCENTRENO_16,'id'=>$flagId);
		$_SESSION['CHOOSEANSWER2'][$ify][$bel] = $num;
		$_SESSION['CHOOSEANSWER3'][$ify][$bel] = $type;
		
		echo json_encode( array( 'error'=>0,'txt'=>'<font color="red">'.SHOWCENTRENO_9.' （'.SHOWCENTRENO_16.'），'.SHOWCENTRENO_15.'<img src="'.$noImg.'" width="20" height="20" align="absmiddle"/>，<font color="#1296db">'.SHOWCENTRENO_11.'：'.strtoupper($zqda).'</font></font> ' ) );
	}
	else
	{
		echo json_encode( array( 'error'=>1,'txt'=>SHOWINFO_ON_1 ) );
	}
}
function ComprehensiveAnswer($id,$type,$bel)
{
	session_start();
	
	$row = db()->select('solve')->from(PRE.'createroom')->where(array('id'=>$id))->get()->array_row();
	
	$xb = md5($id.$type.$row['solve']);
	$rows = $_SESSION[$xb][$type][$bel];	
	$an = $_SESSION['CHOOSEANSWER'][$id][$bel];
	
	if( !empty( $rows ) )
	{
		$z=0;$c=0;
		foreach( $rows as $k => $v )
		{
			$a = strtolower($v['answers']);
			$b = $an[$v['id']]['k'];
			
			if( $a == $b )
			{
				$z += 1;
			}
			else
			{
				$c += 1;
			}
		}
	}
	
	return array('z'=>$z,'c'=>$c,'count'=>count($rows));
}
function exanalysis()
{
	session_start();
	
	include( getThemeDir3() );
	
	$flagId = GetIndexValue(1);
	$flagtype = GetIndexValue(2);
	$bel = GetIndexValue(4);

	$row = db()->select('id,pid,reluser,title,centreno,solve,sort,tariff,descri,roomsets,typeofs,rule1,rule2,publitime,counts,state')->from(PRE.'createroom')->where(array('id'=>$flagId))->get()->array_row();
	
	if( empty($row) )
	{
		header('location:'.apth_url('index.php/index_e'));exit;
	}
	
	$xb = md5($flagId.$flagtype.$row['solve']);
		
	$rows = $_SESSION[$xb][$flagtype][$bel];
	$count = count( $rows );	
	
	$tb = $count-1;

	$daxiang = ComprehensiveAnswer($flagId,1,$bel);
	$doxiang = ComprehensiveAnswer($flagId,2,$bel);
	$paxiang = ComprehensiveAnswer($flagId,3,$bel);
	
	$allcount = $daxiang['count']+$doxiang['count']+$paxiang['count'];	
	$rate = round((($daxiang['z']+$doxiang['z']+$paxiang['z'])/$allcount)*100,2);
	$error = round((($daxiang['c']+$doxiang['c']+$paxiang['c'])/$allcount)*100,2);
	
	$diff = $_SESSION['GETSTARTANDENDS'][$flagId][$bel]['diff'];	
	$TimeOf = TimeConversion( $diff );
	$Average = TimeConversion( $diff/$allcount );
	$master = Proficiency($rate,$error,$Average,$allcount,$diff);	
	$getAR = AcquisitionRime($diff);
	
	require( base_url_name( SHOWPHPEXCELS_4 ) );
}
function SetEndTime()
{
	session_start();
	
	$flagId = htmlspecialchars($_POST['id'],ENT_QUOTES);
	$bel = $_POST['bel'];
	
	if( !isset( $_SESSION['GETSTARTANDENDS'][$flagId][$bel]['end'] ) )
	{
		$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['end'] = time();
	}
	
	$start = $_SESSION['GETSTARTANDENDS'][$flagId][$bel]['start'];
	$end = $_SESSION['GETSTARTANDENDS'][$flagId][$bel]['end'];
	
	$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['diff'] = $end-$start;	
}
function Proficiency($r,$e,$v,$a,$d)
{
	$l = $r+$v;
	$b = $a+$d;
	
	if( ($r-$e) >= 0 )
	{
		return 100 - round(($l/$b)*100,2).'%';
	}
	elseif( ($r-$e) < 0 )
	{
		return 100-(100-round(($l/$b)*100,2)).'%';
	}	
}
function AcquisitionRime($diff)
{
	if( $diff < 600)
	{
		$d = $diff;
	}
	else
	{
		$d = 600;
	}
	return $d;
}
function re_doing()
{
	session_start();
	
	$flagId = $_POST['id'];
	$bel = $_POST['bel'];
	
	$row = db()->select('solve')->from(PRE.'createroom')->where(array('id'=>$flagId))->get()->array_row();
	
	$xb1 = md5($flagId.'1'.$row['solve']);	
	$xb2 = md5($flagId.'2'.$row['solve']);
	$xb3 = md5($flagId.'3'.$row['solve']);
	
	$_SESSION[$xb1][1][$bel] = null;
	unset($_SESSION[$xb1][1][$bel]);
	$_SESSION[$xb2][2][$bel] = null;
	unset($_SESSION[$xb2][2][$bel]);
	$_SESSION[$xb3][3][$bel] = null;	
	unset($_SESSION[$xb3][3][$bel]);
	$_SESSION['CHOOSEANSWER'][$flagId][$bel] = null;
	unset($_SESSION['CHOOSEANSWER'][$flagId][$bel]);
	$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['start'] = null;
	unset($_SESSION['GETSTARTANDENDS'][$flagId][$bel]['start']);
	$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['end'] = null;
	unset($_SESSION['GETSTARTANDENDS'][$flagId][$bel]['end']);	
	$_SESSION['CHOOSEANSWER2'][$flagId][$bel] = null;
	unset($_SESSION['CHOOSEANSWER2'][$flagId][$bel]);
	$_SESSION['CHOOSEANSWER3'][$flagId][$bel] = null;
	unset($_SESSION['CHOOSEANSWER3'][$flagId][$bel]);
	$_SESSION['GETSTARTANDENDS'][$flagId][$bel]['diff'] = null;
	unset($_SESSION['GETSTARTANDENDS'][$flagId][$bel]['diff']);
	
	echo 'success';
}
function InstallEnable()
{	
	$bools = is_file(dirname(__FILE__).'/config/config.php');	
	if( $bools ) header( 'location:'.apth_url() );
	
	$p1 = dirname(__FILE__);
	
	$arr[0] = getpermstools($p1);
	$arr[1] = getpermstools($p1.'/config');
	
	require( base_url_name( SHOWPHPEXCELS_5 ) );
}
function getpermstools($apth)
{
	$ps = intval(perms_all($apth,1));	
		
	$psFlag = 0;
	if( $ps >= 777 ) $psFlag = 1;	
	
	$strps = perms_all($apth);
	$sys = str_replace('\\', '/', $apth);
	
	return array('dirurl'=>$sys,'perms'=>$psFlag,'strps'=>$strps);
}
function OnSubmitSend()
{			
	if( $_POST['start'] == 1 )
    {
	    $link = @mysql_connect(strtolower(trim($_POST['hostid'])),strtolower(trim($_POST['sign'])),trim($_POST['password'])) or exit(SHOWCENTRENO_7.mysql_errno().'-'.mysql_error().' '.SHOWCENTRENO_18);	    
	    if( mysql_select_db(strtolower(trim($_POST['basname']))) == false )
	    {
	    	mysql_query(create_db($_POST));
	    	mysql_select_db(strtolower(trim($_POST['basname'])));
	    }    
	    mysql_query('set names utf8');

	    $tableArr =  table_data($_POST);
	    if(!empty($tableArr))
	    {
		    foreach($tableArr as $k=>$v)
		    {
		    	$int = mysql_query($v) or exit(SHOWCENTRENO_19.mysql_errno()."  <br/>\n\n  ".mysql_error()." <br/>\n\n ".$v);
		    }
	    }
	    else 
	    {
	    	echo json_encode(array('error'=>'1','txt'=>SHOWCENTRENO_20));exit;
	    }	
		mysql_close($link);
	    if($int)
		{
	   		file_put_contents(DIR_URL.'/system/config/config.php', system_config($_POST));
	    	file_put_contents(DIR_URL.'/system/'.SPOT.'dvsd.php', system_config($_POST));
			echo json_encode(array('error'=>'0','txt'=>apth_url()));
		}
	}
	elseif( $_POST['start'] == 3 )
	{
		$mysqli = @new mysqli(strtolower(trim($_POST['hostid'])),strtolower(trim($_POST['sign'])),trim($_POST['password']));

		$dbint = $mysqli->select_db(strtolower(trim($_POST['basname'])));
		if( $dbint == false )
		{
			$mysqli->query(create_db($_POST));
			
			$mysqli->select_db(strtolower(trim($_POST['basname'])));
		}
		
		$result = $mysqli->query("set names utf8");

	    $tableArr =  table_data($_POST);
		if(!empty($tableArr))
	    {
		    foreach($tableArr as $k=>$v)
		    {
		    	$int = $mysqli->query($v) or exit(SHOWCENTRENO_19.mysqli_errno()."  <br/>\n\n  ".mysqli_error()." <br/>\n\n ".$v);
		    }
	    }
	    else 
	    {
	    	echo json_encode(array('error'=>'1','txt'=>SHOWCENTRENO_20));exit;
	    }	
		$mysqli->close();
		if($int)
		{
	   		file_put_contents(DIR_URL.'/system/config/config.php', system_config($_POST));
	    	file_put_contents(DIR_URL.'/system/'.SPOT.'dvsd.php', system_config($_POST));
			echo json_encode(array('error'=>'0','txt'=>apth_url()));
		}
	}
	elseif( $_POST['start'] == 2 )
	{
		$dbms='mysql'; 
		$host=strtolower(trim($_POST['hostid'])); 
		$dbName=strtolower(trim($_POST['basname']));
		$user=strtolower(trim($_POST['sign']));
		$pass=trim($_POST['password']); 
		$dsn1="$dbms:host=$host;dbname=$dbName";
		$dsn2="$dbms:host=$host;";
		try 
		{
		    $dbh = new PDO($dsn1, $user, $pass);    
		    $dbh->exec("set names utf8");

	   		$tableArr =  table_data($_POST);
		    if(!empty($tableArr))
		    {
			    foreach($tableArr as $k=>$v)
			    {
			    	$dbh->exec($v);
			    }
		    }
		    else 
		    {
		    	echo json_encode(array('error'=>'1','txt'=>SHOWCENTRENO_20));exit;
		    }

		   	file_put_contents(DIR_URL.'/system/config/config.php', system_config($_POST));
		    file_put_contents(DIR_URL.'/system/'.SPOT.'dvsd.php', system_config($_POST));
			echo json_encode(array('error'=>'0','txt'=>apth_url()));
		} 
		catch (PDOException $e) 
		{			
			$dbh = new PDO($dsn2, $user, $pass);
			$dbin = $dbh->exec(create_db($_POST));
	
			$dbh2 = new PDO($dsn1, $user, $pass);
			$dbh2->exec("set names utf8");

	    	$tableArr =  table_data($_POST);
			if(!empty($tableArr))
		    {
			    foreach($tableArr as $k=>$v)
			    {
			    	$dbh2->exec($v);
			    }
		    }
		    else 
		    {
		    	echo json_encode(array('error'=>'1','txt'=>SHOWCENTRENO_20));exit;
		    }

		   	file_put_contents(DIR_URL.'/system/config/config.php', system_config($_POST));
		    file_put_contents(DIR_URL.'/system/'.SPOT.'dvsd.php', system_config($_POST));
			echo json_encode(array('error'=>'0','txt'=>apth_url()));
		}
	}
}
function system_config($data)
{	
	$string = '<?php'."\n\n";
	$string .= 'define("SERVERS", "'.strtolower(trim($_POST['hostid'])).'");'."\n\n";
	$string .= 'define("USERNAMES", "'.strtolower(trim($_POST['sign'])).'");'."\n\n";
	$string .= 'define("PASSWORDS", "'.trim($_POST['password']).'");'."\n\n";
	$string .= 'define("BASENAMES", "'.strtolower(trim($_POST['basname'])).'");'."\n\n";
	$string .= 'define("BASS", "mysql");'."\n\n";
	$string .= 'define("PRE", "'.strtolower(trim($_POST['prefix'])).'");';
	
	return $string;
}
function create_db($data)
{
	return "create database if not exists ".strtolower(trim($_POST['basname']))." default character set '".trim($data['coding'])."';";
}
function table_data($data)
{
	$prefix = strtolower(trim($data['prefix']));
	$engine = trim($data['engine']);
	$coding = trim($data['coding']);	
	$admin = trim($data['admin']);
	$pwd = mb_substr(md5(md5(base64_decode(trim($data['pwd'])))),0,10,'utf-8');
	
	$apthInstall = DIR_URL.'/system/data/'.SPOT.'install';

	if( is_file( $apthInstall ) )
	{
		$subject = file_get_contents( $apthInstall );
		$string = str_replace(array('%1001%','%1002%','%1003%','%100T1%','%100T2%','%100T3%'),array($prefix,$engine,$coding,$admin,$pwd,time()), $subject);
		
		$a = explode('#775#', $string);
		
		return $a;
	}
	else
	{
		return null;
	}
}
function index_e()
{
	include( getThemeDir3() );
		
	require( base_url_name( SHOWPHPEXCELS_6 ) );
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */