<?php if( !defined( 'SPOT' ) ){ define('SPOT', '.'); define('DVSD', 'dvsd'); }
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function SET_URI()
{
	$URI = $_SERVER['REQUEST_URI'];
	if( !preg_match("/\?/", $URI) )
	{
		$NAME = $_SERVER['SCRIPT_NAME'];
		$N_ARR = explode('/', $NAME);
		array_shift($N_ARR);
		
		for($i=0;$i<count($N_ARR)-1;$i++)
		{
			$replace[$i] = '';
		}
		
		$URIRilter = str_replace($N_ARR, $replace, $URI);
		$I_ARR = explode('/', $URIRilter);
			
		foreach( $I_ARR as $v )
		{
			if( empty( $v ) ){ continue; }
			$URI_ARR[] = $v;
		}
			
		if( !empty( $URI_ARR ) )
		{
			foreach( $URI_ARR as $ks=>$vs )
			{
				if( !preg_match("/&/", $vs ) )
				{
					if( $ks == 0 )
					{
						$_REQUEST['act'] = $vs;
						$_REQUEST[$ks] = $vs;					
						$_GET['act'] = $vs;
						$_GET[$ks] = $vs;
					}
					else 
					{
						$_REQUEST[$ks] = $vs;					
						$_GET[$ks] = $vs;
					}
				}
				else
				{
					if( $ks == 0 )
					{
						$val = explode( '&', $vs );
						foreach( $val as $vk=>$vl)
						{						
							if( !preg_match("/=/", $vl ) )
							{
								$_REQUEST['act'] = $vl;
								$_REQUEST[$ks] = $vl;					
								$_GET['act'] = $vl;
								$_GET[$ks] = $vl;
							}
							else
							{
								$vals = explode( '=', $vl );
								$_REQUEST[$vals[0]] = $vals[1];					
								$_GET[$vals[0]] = $vals[1];
								$_REQUEST[$vk] = $vals[1];					
								$_GET[$vk] = $vals[1];
							}
						}
					}
					else 
					{
						$val = explode( '&', $vs );
						foreach( $val as $vk=>$vl)
						{						
							if( !preg_match("/=/", $vl ) )
							{
								$_REQUEST['act'] = $vl;
								$_REQUEST[$ks] = $vl;					
								$_GET['act'] = $vl;
								$_GET[$ks] = $vl;
							}
							else
							{
								$vals = explode( '=', $vl );
								$_REQUEST[$vals[0]] = $vals[1];					
								$_GET[$vals[0]] = $vals[1];
								$_REQUEST[$vk] = $vals[1];					
								$_GET[$vk] = $vals[1];
							}
						}
					}
				}
			}
		}	
	}	
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function GetIndexValue($mix)
{
	if( is_numeric( $mix ) )
	{
		$val = $_REQUEST[$mix];
	}
	else
	{
		$val = $_REQUEST[$mix];
	}
	return $val;
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
$SET_PHP();