<?php
header('content-type:text/html;charset=utf-8');
/**
 * 自定义方法
*/
#实例化一个db对像
function db()
{
	return new This_Linked();
}
#处理xml
function xml_str($array)
{
	$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$xml .= '<box>'."\n";
	foreach($array as $key=>$val)
	{
		$xml .= '<'.$key.'>'.$val.'</'.$key.'>'."\n";
	}
	$xml .= '</box>';
	return $xml;
}
#处理xml
function xml_str2($array)
{
	$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$xml .= '<box>'."\n";
	foreach($array as $key=>$val)
	{
		$xml .= '<'.$key.'>'.urlencode($val).'</'.$key.'>'."\n";
	}
	$xml .= '</box>';
	return $xml;
}
#加载主题
function load_theme($dir='default')
{
	$dir = $dir==''?'404':$dir;
	if(is_file(BASE_URL.'/subject/'.$dir.'/index.php'))
	{
		require BASE_URL.'/subject/'.$dir.'/index.php';
	}
	else 
	{
		header("content-type:text/html;charset=utf-8");
		echo '加载失败：主题首页不存在 或 未启用主题 !';
	}
}
#根目录url
function apth_url($url='')
{
	return APTH_URL.($url==''?'':'/'.$url);
}
#路由url
function site_url($url='')
{
	return SITE_URL.'/'.$url;
}
#路由dir
function base_url($dir='')
{
	return BASE_URL.'/'.$dir;
}
#路由dir
function dir_url($dir='')
{
	return DIR_URL.($dir==''?'':'/'.$dir);
}
#截取字符串
function subString($string,$len)
{
	if(mb_strlen($string,'utf-8')>=$len)
	{
		$string = mb_substr($string, 0,$len,'utf-8').'...';
	}
	return $string;
}
#屏蔽错误提示
function set_ini_error($flag)
{
	if($flag['development'] == "ON")
	{
		ini_set('display_errors', 'Off');
	}
}
#关闭网站
function CloseSite()
{
	$review = db()->select('closesite')->from(PRE.'review_up')->get()->array_row();
	if( $review['closesite'] == "ON" )
	{
		header("content-type:text/html;charset=utf-8");
		echo '网站已经关闭，无法访问';exit;
	}
}
#获取主题目录
function getThemeDir()
{
	return 'bim';
}
#获取版本号
function get_version()
{
	$filename = dir_url('subject/version.txt');
	$string = file_get_contents($filename);
	$version = explode('/', str_replace("\n", '', $string));
	if(!empty($version))
	{
		return $version;
	}
	else 
	{
		return '';
	}
}
#curl
function vcurl($url, $post = '', $cookie = '', $cookiejar = '', $referer = '') {
	$tmpInfo = '';
	$cookiepath = getcwd () . '. / ' . $cookiejar;
	$curl = curl_init ();
	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt ( $curl, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] );
	if ($referer) {
		curl_setopt ( $curl, CURLOPT_REFERER, $referer );
	} else {
		curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 );
	}
	if ($post) {
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
	}
	if ($cookie) {
		curl_setopt ( $curl, CURLOPT_COOKIE, $cookie );
	}
	if ($cookiejar) {
		curl_setopt ( $curl, CURLOPT_COOKIEJAR, $cookiepath );
		curl_setopt ( $curl, CURLOPT_COOKIEFILE, $cookiepath );
	}
	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 100 );
	curl_setopt ( $curl, CURLOPT_HEADER, 0 );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	$tmpInfo = curl_exec ( $curl );
	if (curl_errno ( $curl )) {
		// echo ' < pre > < b > 错误: < /b><br / > ' . curl_error ( $curl );
	}
	curl_close ( $curl );
	return $tmpInfo;
}
#解析JSON格式,返回数组
function ParsingJson($json)
{
	$rows = array();
	if( $json != '' )
	{
		$rows = json_decode($json,true);
	}
	return $rows;
}
#改变图片像素
function get_pixels($dir,$x,$y)
{
	return apth_url("system/img_pixels.php?dir=$dir&x=$x&y=$y");
}
#转换时间
function get_day_formt($t)
{
	$int = time()-$t;
	if( $int < 86400 )
	{#秒->分->时 换算
		$i = 0;
		while ( $int >= 60 )
		{
			$int /= 60;
			$i++;
		}
		$ext = array('秒前','分钟前','小时前');
	}
	
	if( $int >= 86400 && $int < 2592000)
	{#时->天 换算
		$i = 0;
		while ( $int >= 86400 )
		{
			$int /= 86400;
			$i++;
		}
		$ext = array('小时前','天前');
	}
	if( $int >= 2592000 && $int < 31104000)
	{#天->月 换算
		$i = 0;
		while ( $int >= 2592000 )
		{
			$int /= 2592000;
			$i++;
		}
		$ext = array('天前','个月前');
	}
	if( $int >= 31104000 )
	{#月->年 换算
		$i = 0;
		while ( $int >= 31104000 )
		{
			$int /= 31104000;
			$i++;
		}
		$ext = array('个月前','年前');
	}
	return floor($int).$ext[$i];
}
#截取手机号码
function substr_tel($tel)
{
	$str1 = substr($tel,0,3);
	$str2 = substr($tel,-3);
	return $str1.'***'.$str2;
}