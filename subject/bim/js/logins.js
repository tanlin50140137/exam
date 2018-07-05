/**
 * @TanLin
 * @logins-vi2017-7-3
 */
var strArr = new Array();
	strArr[0] = '*请输入帐号*';
	strArr[1] = '*请输入密码*';
	strArr[2] = '*请输入手机*';
	strArr[3] = '*请输入邮箱*';
	strArr[4] = '*手机号错误*';
	strArr[5] = '*邮箱不正确*';
	
var relphone =/^0?(13|14|15|17|18)[0-9]{9}$/;
var relemail =/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/;
var flag_users_name=false,flag_txt='';

function Logins(m){
	var u = $("[name='users1']").val();
	var p = $("[name='pwd']").val();
	var url = $(m).attr('set-url');
	if( u == '' )
	{
		$(".tishiinfo:eq(0)").text(strArr[0]);
		$("[name='users']").focus();
		return false;
	}
	if( flag_users_name )
	{
		$(".tishiinfo:eq(0)").text(flag_txt);
		$("[name='users']").focus();
		return false;
	}
	if( p == '' )
	{
		$(".tishiinfo:eq(1)").text(strArr[1]);
		$("[name='pwd']").focus();
		return false;
	}	
	//验证帐号密码	
	$.post(url,{"act":"form_logins","u":u,"p":p},function(data){
		var obj = eval("("+data+")");
		if( obj.error == 0 )
		{//注册成功
			layer.msg(obj.txt,{time:2000},function(){
				location.href = url+"?act=adminfrom";
			});
		}	
		else
		{//错误提示
			$(".tishiinfo:eq("+obj.f+")").text(obj.txt);
		}	
	});
}
$(function(){
	$("[name='users1']").blur(function(){
		var u = $("[name='users1']").val();
		if( $("[name='users1']").val() != '' )
		{	
			$(".tishiinfo:eq(0)").text('');
		}
		var url = $(".btn_login").attr('set-url');
		$.post(url,{"act":"checked_selects","u":u},function(data){
			var obj = eval("("+data+")");
			if( obj.error == 0 )
			{//未注册
				flag_users_name = true;
				flag_txt = obj.txt;
				$(".tishiinfo:eq(0)").text(obj.txt);
			}
			else
			{
				flag_users_name = false;
				flag_txt = '';
			}
		});
	});
	$("[name='users']").blur(function(){
		var u = $("[name='users']").val();
		if( $("[name='users']").val() != '' )
		{	
			$(".tishiinfo:eq(0)").text('');
		}
		var url = $(".btn_login").attr('set-url');
		$.post(url,{"act":"checked_selects","u":u},function(data){
			var obj = eval("("+data+")");
			if( obj.error == 1 )
			{//被占用
				flag_users_name = true;
				flag_txt = obj.txt;
				$(".tishiinfo:eq(0)").text(obj.txt);
			}
			else
			{
				flag_users_name = false;
				flag_txt = '';
			}
		});
	});
	$("[name='pwd']").blur(function(){
		if( $("[name='pwd']").val() != '' )
		{
			$(".tishiinfo:eq(1)").text('');
		}
	});
});
function reset_s(m)
{
	var u = $("[name='users']").val();
	var p = $("[name='pwd']").val();
	var t = $("[name='tel']").val();
	var e = $("[name='email']").val();
	var url = $(m).attr('set-url');
	if( u == '' )
	{
		$(".tishiinfo:eq(0)").text(strArr[0]);
		$("[name='users']").focus();
		return false;
	}	
	if( flag_users_name == true )
	{
		$(".tishiinfo:eq(0)").text(flag_txt);
		$("[name='users']").focus();
		return false;
	}
	if( p == '' )
	{
		$(".tishiinfo:eq(1)").text(strArr[1]);
		$("[name='pwd']").focus();
		return false;
	}
	if( t == '' )
	{
		$(".tishiinfo:eq(2)").text(strArr[2]);
		$("[name='tel']").focus();
		return false;
	}
	if(!relphone.test(t))
	{
		$(".tishiinfo:eq(2)").text(strArr[4]);
		$("[name='tel']").focus();
		return false;
	}
	if( e == '' )
	{
		$(".tishiinfo:eq(3)").text(strArr[3]);
		$("[name='email']").focus();
		return false;
	}
	if(!relemail.test(e))
	{
		$(".tishiinfo:eq(3)").text(strArr[5]);
		$("[name='email']").focus();
		return false;
	}
	//验证帐号密码
	$.post(url,{"act":"form_resets","u":u,"p":p,"t":t,"e":e},function(data){
		var obj = eval("("+data+")");
		if( obj.error == 0 )
		{//注册成功
			layer.msg(obj.txt,{time:2000},function(){
				location.href = url+"?act=index";
			});
		}	
		else
		{//错误提示
			$(".tishiinfo:eq("+obj.f+")").text(obj.txt);
		}	
	});
}
$(function(){
	$("[name='tel']").blur(function(){
		if( $("[name='tel']").val() != '' )
		{	
			$(".tishiinfo:eq(2)").text('');
		}
	});
	$("[name='email']").blur(function(){
		if( $("[name='email']").val() != '' )
		{
			$(".tishiinfo:eq(3)").text('');
		}
	});
});