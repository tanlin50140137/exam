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
#后台框架
function adminfrom()
{
	session_start();
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	if( !isset( $_SESSION['usersname'] ) || $_SESSION['usersname']==null )
	{
		header('location:'.apth_url(''));exit;
	}	
	$usersname = $_SESSION['usersname'];
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
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#获取KEY
function getkey()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	#获取数据
	$flRows1 = GetFenLai(0,2);
	$flRows2 = GetFenLai2(0,2);
	$TotalRows = count($flRows2);
	$TotalShow = 10;
	$TotalPage = ceil($TotalRows/$TotalShow);
	$page = $_GET['page']==null?1:$_GET['page'];
	if( $page >= $TotalPage ){ $page=$TotalPage; }
	if( $page<=1 || !is_numeric( $page ) ){ $page=1; }
	$offset = ($page-1)*$TotalShow;
	$rows = array_slice($flRows2, $offset, $TotalShow);
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#无限级别分类
function GetFenLai($pid,$multiplier=0)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$multiplier = $rows==null?0:$multiplier+2;
	$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify where pid={$pid} and state=0";
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
function GetFenLai2($pid,$multiplier=0)
{
	static $rows;	
	
	$int = db()->select('*')->from(PRE."classify")->get()->array_nums();
	
	$sql = "select id,pid,title,sort,descri,publitime,state from ".PRE."classify where pid={$pid} and state=0";
	$rs = mysql_query($sql);
	while ($array = mysql_fetch_assoc($rs))
	{
		$rows[] = $array;
		GetFenLai2($array['id'],$multiplier);//递归
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
			$str = '隐藏';
		break;
	}
	return $str;
}
#记录显示条数
function SetShwoTotal()
{
	$spot = SPOT;
	$c = $_POST['c'];//记录总数
	
	echo base_url();
	
}
#绑定域名
function geturl()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#添值服务
function getpay()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
#帮助中心
function gethelp()
{
	#公共文件内容
	include 'subject/'.getThemeDir().'/common.php';
	
	require 'subject/'.getThemeDir().'/template/'.__FUNCTION__.'.html';
}
###############################################################################################
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
	#记录数据
	$int = db()->insert(PRE.'classify',$data);
	if( $int )
	{
		#获取数据
		$rows = db()->select('id,pid,title,sort,descri,publitime,state')->from(PRE.'classify')->order_by('sort desc')->limit('0,30')->get()->array_rows();
		$html = '';
		$html .= '<table class="key_tablebox">';
		$html .= '<tr>';
		$html .= '<td>序号</td>';
		$html .= '<td>PID</td>';
		$html .= '<td>分类名称</td>';
		$html .= '<td>排序</td>';
		$html .= '<td>创间时间</td>';
		$html .= '<td>状态</td>';
		$html .= '<td>操作</td>';
		$html .= '</tr>';
		if( !empty( $rows ) )
		{
			foreach( $rows as $k => $v )
			{
				$html .= '<tr>';
				$html .= '<td>'.($k+1).'</td>';
				$html .= '<td>'.$v['pid'].'</td>';
				$html .= '<td>'.$v['title'].'</td>';
				$html .= '<td>'.$v['sort'].'</td>';
				$html .= '<td>'.date('Y.m.d H:i:s',$v['publitime']).'</td>';
				$html .= '<td>'.GetState($v['state']).'</td>';
				$html .= '<td><a href="">修改</a> | <a href="">删除</a></td>';
				$html .= '</tr>';
			}
		}
		$html .= '</table>';
		
		echo json_encode(array("error"=>0,'txt'=>$html));
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