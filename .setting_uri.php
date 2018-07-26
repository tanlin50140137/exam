<?php
/**
 * @author TanLin Tel:18677197764 Email:50140137@qq.com
 * */
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
$SET_PHP();