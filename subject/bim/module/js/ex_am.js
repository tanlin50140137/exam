/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function ExamObj()
{	
    var exam  =  new Object(); 
    exam.Answer = 0;
    exam.SetHosturl=function(url){
    	exam.hosturl = url;
    }
    exam.IEVersion=function() {
        var userAgent = navigator.userAgent;
        var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1;
        var isEdge = userAgent.indexOf("Edge") > -1 && !isIE;
        var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
        if(isIE) {
            var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
            reIE.test(userAgent);
            var fIEVersion = parseFloat(RegExp["$1"]);
            if(fIEVersion == 7) {
                return 7;
            } else if(fIEVersion == 8) {
                return 8;
            } else if(fIEVersion == 9) {
                return 9;
            } else if(fIEVersion == 10) {
                return 10;
            } else {
                return 6;
            }   
        } else if(isEdge) {
            return 'edge';
        } else if(isIE11) {
            return 11; 
        }else{
            return -1;
        }
    }
    exam.CreateHTML1=function()
    { 	
    	var tFlag = true;
    	if( this.setting != undefined )
    	{
	    	if( this.setting.title != undefined )
	    	{
	    		tFlag = this.setting.title;
	    	}
    	}
    	   	
    	var limit='',len='',url='',target='';
    	if( this.setting != undefined )
    	{
    		limit = this.setting.limit;
    		len = this.setting.len;
    		url = this.setting.url;
    		target = this.setting.target;
    	}
    	var iconimg1 = 'data:image/png;base64,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';
    	var div0 = $('<div class="exam_boxsdi0"></div>');  		
    	var div1 = $('<div class="exam_boxsdi1"><img src="'+iconimg1+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'信息公布栏':this.setting.title)+'</div>');
    	var ul0 = $('<ul class="exam_boxsul0"></ul>');   	
    	$.post(this.hosturl,{'act':'GetInfoBar','limit':limit,'len':len,'url':url,'target':target},function(data){  		
    		var objs = eval("("+data+")");
    		if( objs.error == 0 )
    		{
    			ul0.append( objs.txt );
    			
    			if( exam.func != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func( data );
    	    	}
    			
    			exam.CreateCss1();
    		}	
    		else
    		{
    			ul0.append( '<li style="margin:0px 0px 0.8rem;padding:0px;border:none;list-style-type:none;color: #999999;text-align: center;height: 4rem;line-height: 4rem;">'+objs.txt+'</li>' );
    			if( exam.func != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func( data );
    	    	}
    			
    			exam.CreateCss1();
    		}	
    	});   	
    	if( tFlag )
        {	
    		div0.append( div1 );
        }
    	div0.append( ul0 );   	    	
    	return div0;
    }  
    exam.CreateCss1=function()
    {    	
    	if( this.setting != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting.w)?'100%':this.setting.w;
    		var height = exam.isEmptyObject(this.setting.h)?'100%':this.setting.h;
    		var bgcs = exam.isEmptyObject(this.setting.bgc)?'#fbf6f4':this.setting.bgc;
    		var colors = exam.isEmptyObject(this.setting.color)?'#666666':this.setting.color;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var bgcs = '#fbf6f4';
    		var colors = '#666666';
    	}	
        $('.exam_boxsdi0').css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height,"overflow":"hidden"}); 
        $('.exam_boxsdi1').css({"margin":"0","padding":"0","border-bottom":"1px solid #d8cdcd","height":"3.3rem","line-height":"3.3rem","padding":"0 1.8rem","font-family":"Microsoft YaHei","background":bgcs,"color":colors});
        $('.exam_boxsul0').css({"margin":"0","padding":"0","padding":"0.8rem 1.8rem"});
        $('.exam_boxsli0').css({"margin":"0","padding":"0","border-bottom":"1px solid #d8cdcd","list-style-type":"none","margin-bottom":"0.8rem"});
        var li_len0 = $('.exam_boxsli0').length-1;
        $('.exam_boxsli0:eq('+li_len0+')').css({"border":"none"});       
        $('.exam_boxsp0').css({"margin":"0","padding":"0","line-height":"1.2rem","height":"1.2rem","overflow":"hidden","font-family":"Microsoft YaHei","color":"#414a4a","word-wrap":"break-word","margin-bottom":"0.4rem"});
        $('.exam_boxsp1').css({"margin":"0","padding":"0","margin-top":"0.1rem","font-family":"Microsoft YaHei","padding-bottom":"1rem","color":"#756f6d","overflow":"hidden","word-wrap":"break-word"});
        $('.exam_boxsp0 a').hover(function(){
        	$(this).css({"color":"red"});
        },function(){
        	$(this).css({"color":"#3e3c3c"});
        });
    }   
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{w:'100%',h:'100%',bgc:'#FFFFFF'.....}
     * 设置参数说明:
     * w,宽
     * h,高
     * bgc,标题背景
     * color,标题字体颜色
     * url,链接
     * target,打开方式
     * limit,获取数量
     * len,描述截取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * */
    exam.InfoBar=function(hobj,Sett,func)
    {     	  	
    	this.htmlobj = hobj;
    	this.setting = (Sett==undefined)?{}:Sett;
    	exam.func = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML1();   	
    	   
    	$( this.htmlobj ).empty();
    	$( this.htmlobj ).append( html );
    	
    	exam.CreateCss1();
    }
    exam.isEmptyObject = function(obj)
    {   
    	for (var key in obj)
    	{
    	　　return false;
    	}　　
    	return true;
    }
    
    /*##################################################################################*/
    
    exam.CreateHTML2=function()
    { 
    	var tFlag = true;
    	if( this.setting2 != undefined )
    	{
	    	if( this.setting2.title != undefined )
	    	{
	    		tFlag = this.setting2.title;
	    	}
    	}
    	var limit='',len='',url='',target='';
    	if( this.setting2 != undefined )
    	{
    		limit = this.setting2.limit==undefined?'':this.setting2.limit;
    		len = this.setting2.len==undefined?'':this.setting2.len;
    		url = this.setting2.url==undefined?'':this.setting2.url;
    		target = this.setting2.target==undefined?'':this.setting2.target;
    	} 	
    	   	   	
    	var iconimg1 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABTElEQVQ4T91TsXHCQBDc+8GQPlSAZ5BSqwRKoARSS4GhA3VgO5BI1YFVgkqQU4kZXIH41Lbmz3Oy8cgPDMT+cP9+/253j3RSLYloCfcwDH8MOpyGbQaCPiphzmicVuU+9AP3Uoj7mIn8zK2RtzRO62IfevMjgk09VxYdbhUKc+8VxwR18T8IqpLfb+ZmfWv6M06SOrZEpWCKOWgiL+7f68edplGbk06qgECxaxMxisMjIWP6FvT3iM3gmHS6XRD4wVWYgLIJvfUBlx8xau8AmoLtq4n8rrvzLkgOSBkTzvKuS0JGTLmMpWAXYGWaaLa6aKOMIYFxdZKgKdD0IoGESALliijtj5M6v4oAlqcno3wdwSBT/Bk3of9nNzobh60s05ld6Ik4SbZPFnZnIv9ZWv/JwAszryUHJ9eZwG/9X3VarwhYgNEFTjIgVn4BdOjyftNipIwAAAAASUVORK5CYII=';
    	var divf0 = $('<div class="exam_boxsdif0"></div>');		
    	var divf1 = $('<div class="exam_boxsdif1"><img src="'+iconimg1+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'考试科目':this.setting2.title)+'</div>');
    	var ulf0 = $('<ul class="exam_ulf0list"></ul>');
    	   	
    	$.post(this.hosturl,{'act':'GetFamily','limit':limit,'len':len,'url':url,'target':target},function(data){
    		var objs = eval("("+data+")");
    		if( objs.error == 0 )
    		{
    			ulf0.append( objs.txt );
    			
    			if( exam.func2 != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func2( data );
    	    	}
    			
    			exam.CreateCss2();
    		}	
    		else
    		{
    			ulf0.append( '<li style="margin:0px 0px 0.8rem;padding:0px;border:none;list-style-type:none;color: #999999;text-align: center;height: 4rem;line-height: 4rem;">'+objs.txt+'</li>' );
    			
    			if( exam.func2 != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func2( data );
    	    	}
    			
    			exam.CreateCss2();
    		}	
    	});
    	
    	if( tFlag )
        {
    		divf0.append( divf1 ); 
        }    		
    	divf0.append( ulf0 );    	
    	
    	return divf0;   
    }
    exam.CreateCss2=function()
    { 
    	if( this.setting2 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting2.w)?'100%':this.setting2.w;
    		var height = exam.isEmptyObject(this.setting2.h)?'100%':this.setting2.h;
    		var bgcs = exam.isEmptyObject(this.setting2.bgc)?'#fbf6f4':this.setting2.bgc;
    		var colors = exam.isEmptyObject(this.setting2.color)?'#666666':this.setting2.color;
    		var li = exam.isEmptyObject(this.setting2.li)?'30%':this.setting2.li;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var bgcs = '#fbf6f4';
    		var colors = '#666666';
    		var li = '30%';
    	}
    	$('.exam_boxsdif0').css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height,"overflow":"hidden"}); 
        $('.exam_boxsdif1').css({"margin":"0","padding":"0","border-bottom":"1px solid #d8cdcd","height":"3.3rem","line-height":"3.3rem","padding":"0 1.8rem","font-family":"Microsoft YaHei","background":bgcs,"color":colors});
        $('.exam_ulf0list').css({"margin":"0","padding":"0","padding":"0.8rem 1.8rem"});
        $('.exam_lif0list').css({"border":"1px solid #d6c2c2","margin":"0","padding":"0","list-style-type":"none","float":"left","height":"2rem","width":li,"margin-right":"0.5rem","padding":"0.5rem","margin-bottom":"0.5rem","line-height":"2rem","text-align":"center","overflow":"hidden","border-radius":"0.2rem"});
        $('.exam_lif0list a').css({"text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei","display":"block"});
        $('.exam_lif0list a').hover(function(){
        	$(this).css({"color":"red","background":"beige"});
        },function(){
        	$(this).css({"color":"#3e3c3c","background":"#FFFFFF"});
        });
    }
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{li:'31%',w:'100%',h:'100%',bgc:'#FFFFFF'.....}
     * 设置参数说明:
     * w,宽
     * h,高
     * li,li框的宽度,默认'33%'
     * bgc,标题背景
     * color,标题字体颜色
     * url,链接
     * target,打开方式
     * limit,获取数量
     * len,描述截取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * 
     * */
    exam.family=function(hobj,Sett,func)
    { 	   	   	
    	this.htmlobj2 = hobj;
    	this.setting2 = (Sett==undefined)?{}:Sett;
    	exam.func2 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML2();   	
 	   
    	$( this.htmlobj2 ).empty();
    	$( this.htmlobj2 ).append( html );
    	
    	exam.CreateCss2();
    }
    
    /*##################################################################################*/
    
    exam.CreateHTML3=function()
    {    	
    	var tFlag = true;
    	if( this.setting3 != undefined )
    	{
	    	if( this.setting3.title != undefined )
	    	{
	    		tFlag = this.setting3.title;
	    	}
    	}
    	var limit='',len='',url='',target='';
    	if( this.setting3 != undefined )
    	{
    		limit = this.setting3.limit;
    		len = this.setting3.len;
    		url = this.setting3.url;
    		target = this.setting3.target;
    	} 	
    	
    	var iconimg1 = 'data:image/png;base64,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';
    	var div0 = $('<div class="exam_newsbox"></div>');
    	var divh10 = $('<div class="exam_divh10"><img src="'+iconimg1+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'考试资讯':this.setting3.title)+'</div>');
    	var div1 = $('<div class="exam_newsbox1"></div>');
    	var div2 = $('<div class="exam_newsbox1"></div>');
    	var div3 = $('<div style="clear:both;"></div>');    	
    	var ul0 = $('<ul class="exam_newsulli0"></ul>');
    	var ul1 = $('<ul class="exam_newsulli1"></ul>');
    	    	
    	$.post(this.hosturl,{'act':'GetJSNews','limit':limit,'len':len,'url':url,'target':target},function(data){
        	var objs = eval("("+data+")");
        	if( objs.error == 0 )
        	{
        		ul0.append(objs.txt1);
        		ul1.append(objs.txt2);
        			
        		if( exam.func3 != undefined )
        	    {
        			var data = data;
        			exam.func3( data );
        	    }
        			
        		exam.CreateCss3();
        	}	
        	else
        	{
        		ul0.append('<li style="margin:0px 0px 0.8rem;padding:0px;border:none;list-style-type:none;color: #999999;text-align: center;height: 4rem;line-height: 4rem;">'+objs.txt+'</li>');
        		
        		if( exam.func3 != undefined )
        	    {
        			var data = data;
        			exam.func3( data );
        	    }
        			
        		exam.CreateCss3();
        	}	
        });	
    		
    	if( tFlag )
        {	
    		div0.append(divh10);
        }
    	div0.append(div1);
    	div1.append(ul0); 	
    	div0.append(div2);
    	div2.append(ul1);   	
    	div0.append(div3);
    	
    	return div0;
    }
    exam.CreateCss3=function()
    {
    	if( this.setting3 != undefined )
    	{
    		var tw = exam.isEmptyObject(this.setting3.tw)?'10rem':this.setting3.tw;
    		var th = exam.isEmptyObject(this.setting3.th)?'2.5rem':this.setting3.th;
    		var width = exam.isEmptyObject(this.setting3.w)?'100%':this.setting3.w;
    		var height = exam.isEmptyObject(this.setting3.h)?'100%':this.setting3.h;
    		var bgcs = exam.isEmptyObject(this.setting3.bgc)?'#FFFFFF':this.setting3.bgc;
    		var colors = exam.isEmptyObject(this.setting3.color)?'#666666':this.setting3.color;
    	}
    	else
    	{
    		var tw = '10rem';
    		var th = '2.5rem';
    		var width = '100%';
    		var height = '100%';
    		var bgcs = '#fbf6f4';
    		var colors = '#666666';
    	}
    	
    	$(".exam_newsbox").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height,"overflow":"hidden","padding-bottom":"1.5rem"});
    	$(".exam_divh10").css({"margin":"0","padding":"0","background":bgcs,"color":colors,"border-bottom":"1px solid #d8cdcd","width":tw,"text-align":"center","height":th,"line-height":th,"font-family":"Microsoft YaHei","margin":"auto"});
    	$(".exam_newsbox1:eq(0)").css({"margin":"0","padding":"0","border-right":"1px solid #d8cdcd","margin-top":"20px","float":"left","width":"50%"});
    	$(".exam_newsbox1:eq(1)").css({"margin":"0","padding":"0","margin-top":"20px","float":"right","width":"49%"});
    	$(".exam_newsulli0").css({"margin":"0","padding":"0"});
    	$(".exam_newsulli0 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei"});
    	$(".exam_newsulli1").css({"margin":"0","padding":"0"});
    	$(".exam_newsulli1 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei"});
    	$(".exam_newsullis0").css({"margin":"0","padding":"0","list-style-type":"none","padding":"0 1.5rem","margin-bottom":"1.4rem"});
    	$(".exam_newsullis1").css({"margin":"0","padding":"0","list-style-type":"none","padding":"0 1.5rem","margin-bottom":"1.4rem"});
    	$(".exam_newsullidiv0").css({"margin":"0","padding":"0","float":"left","height":"4.5rem","overflow":"hidden"});
    	$(".exam_newsullidiv0_1").css({"margin":"0","padding":"0","width":"7.1rem","border":"1px solid #eae6e6","border-radius":"0.3rem"});
    	$(".exam_newsullidiv0_2").css({"margin":"0","padding":"0","margin-left":"1rem","width":"25.4rem"});
    	$(".exam_newsullidivp").css({"margin":"0","padding":"0","font-family":"Microsoft YaHei","font-size":"13px","color":"#232222","height":"1.2rem","overflow":"hidden"});
    	$(".exam_newsullidivp2").css({"margin":"0","padding":"0","font-family":"Microsoft YaHei","font-size":"13px","margin-top":"0.7rem","color":"#716e6e"});
    	
    	$(".exam_newsulli0 a").hover(function(){
    		$(this).css({"color":"red"});
    	},function(){
    		$(this).css({"color":"#3e3c3c"});
    	});
    	$(".exam_newsulli1 a").hover(function(){
    		$(this).css({"color":"red"});
    	},function(){
    		$(this).css({"color":"#3e3c3c"});
    	});
    }
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{li:'31%',w:'100%',h:'100%',bgc:'#FFFFFF'.....}
     * 设置参数说明:
     * w,宽
     * h,高
     * tw,标题宽
     * th,标题高
     * bgc,标题背景
     * color,标题字体颜色
     * url,链接
     * target,打开方式
     * limit,获取数量
     * len,描述截取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * 
     * */
    exam.news=function(hobj,Sett,func)
    {
    	this.htmlobj3 = hobj;
    	this.setting3 = (Sett==undefined)?{}:Sett;
    	exam.func3 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML3();   	
 	   
    	$( this.htmlobj3 ).empty();
    	$( this.htmlobj3 ).append( html );
    	
    	exam.CreateCss3();
    }
       
    /*##########################################################################*/
    
    exam.sendpays=function(str)
    {
    	var d = $('#'+str).serialize();
    	    	
    	if( !$("[name='vip']").is(":checked") )
    	{
    		var arr = new Array();
    			arr[0] = '请选择VIP充值套餐';
    			arr[1] = '需要选择一个选项否则无法购买';
    			arr[2] = '没有选择任何一个选项';
    			arr[3] = '明确一个选项';
    			arr[4] = '检查到你没有选择任何选项，请选择';
    			arr[5] = '你需要选择一个选项';
    			arr[6] = '没有看到你选择';
    			arr[7] = '选择上面列表任意一个选项';
    			arr[8] = '对不起还没有检查到任何一个选项';
    			arr[9] = '不选择以上选面无法购买';
    			arr[10] = '你需要明确以上的选项';
    			
    		var i = Math.floor( Math.random()*10 );	
    			
    		$(".tollbox_all2").html('<font color="red">'+arr[i]+'</font>');return false;
    	}
    	
    	var payimg1 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAEyklEQVR4Xu2bXVLjRhCAu2VL7EMg7Fuqgl3wkMR+ivcEmBPEe4KYEyw5QcgJAifAN1hzAsQJQp7sTR4gNqnat5VNHjYapE6NZCour6T5lXGtTZVf8Mz09Nc93T0/RljzP1xz/WEDYOMBa07g2ZbA7S7sPn5R/Z7zr/7z+PtBAMFz2KJ0AFzRf7crhwhOhwD2AaEFgLvZylIABDcIcEcQ97ceouuywZQCgCsd7rg/EEEXENtGliXyEaHnTdllGTCsAkgV994Q0Em+lXVxUICAZ940PLcJwhqAYd19AwCn9hVfBEY8Vpw2RuxcF+V8P2MAg69gHz33LQC2bExIegwinxg7br6HO+k+GQ2NALyrVTqEzkX5Vs9TkQKk+Pi7cdTXhaANYFBzu4h4oSvYZj8iOm6OWU9nTC0A72ruBSF2dQSW1YcAfmmOwlPV8ZUBrJLlPwmPGp6gBCBd85W3qpSX2R4peq0SE6QBzKL9b88X8GQxUkAheyWbHaQBDOsuV365qU5W50/Xgt8YsyOZ7lIAhnWXV3a/ygy4Om3op8aInYnmIwSQbGZ23Fsbrk9E14jQdyLwv/2b3cxP7o+v3VZcgTYRdBDxUDRx8fcUbE3ZgahsFgIY1L1TBPhZLLCgBcElsfBEdl3yeAOu2zMFIZMaCwGYW58mSHFXJSrPY5xVmj0A/FLPAGIvKARgkvMJ4K9KRJ1FV1dVZLY0fF0IoiqxEMCw5l7p7edp4kTQNlX+CZYRBKLCjJALIHV/74OqxXh71WJERoZJEbY1DV/mBcNcANoCCS4b47Ajo5Rqm0HN9XUCY5FBcgEMakkU/lF1khSGB7LRXnXstBr1blX7QUznjXt2ktWvCIAybZ7nm2NmdgYo0E7HC4rmlQtgWHc/qBc/ctWXsgXnOuhVpRQ0RuylkgcM6x6pTtSJ6JWtyJ8ne7BXbaPjXKnOrTEKM42d+U/dDJAnRHWyovY6xlECYJuySCHV73UAUBwfNe8f/UVZmR6w9gDWfglwN9Fxs88mCKYA3EB9A7KyaXDSGLHMC9lNIZSbb9e9FNbfDBVvP1VT3nx73e251mZINxN8NtthrojOxiO1GAVOBEe2yuLZgciV+t6ET6V4e17akZgtCEbKc/0F12Uyh6J36unwaeWaXV+bX7/TZGvK9ouOxpd0LK72mCE5+HDdC73zyP/DpvGxOB9qdjRu4AVzcZzIB4R+Jaabb+4fr+cj/J971cPIwRYQdEwVn8UhofWTgC2TlvQOIWRGLq+NaO0/SZYCYJYRylMyb2SVozl5AOljqBv9gLgsEDShkLVkD2alAfDpa1eHy9Jd405CCcBsKazM46hFrrLrfr6fMoAEgo0bY8teIZPyskRqAVg1T9CxvHIWyKJnfn1t6gZm1+/SdUDRNG09ZlBFwVMdMNaVjfZ542svgcUB02IpeSyt+ZhBFgFNZo+lhe9/ZEa0BuCpbP64451g+lzeMgiaEODZi2l4Jnr3I6O4lRiQJ4jvHz5uu/yKnKdMowdPiasD9F48sL5NxUsFMA8m+RHFdqVN5LQJoYXpT2ZyvIMmxH8ywz8Y+95D5JehtHEdoOJihQF0r5pcpWddWdmSIRrHagwQCVvF7zcAVtEqy5zTxgOWSXsVZf0HCVeEXzyELycAAAAASUVORK5CYII=';
    	
    	if( !$("[name='pay']").is(":checked") )
    	{
    		$("#pay_errortxt").html('<img src="'+payimg1+'" width="14" height="14" align="absmiddle"/>请选择支付方式');return false;
    	}	
    	else
    	{
    		$("#pay_errortxt").html('');
    	}	
    	
    	$.ajax({
    		url:exam.hosturl,
    		type:'post',
    		data:'act=send_pays&'+d,
    		success:function(data){
    			var obj = eval("("+data+")");
    			if( obj.error == 0 )
    			{
    				exam.closeImg();
    				if( obj.txt == '1' )
    				{
    					location.href = exam.hosturl+'/payments'; 
    				}	
    				else if( obj.txt == '2' )
    				{
    					var html = '<iframe src="'+exam.hosturl+'/payments" width="500" height="400" frameborder="0" scrolling="no"></iframe>';
    					exam.TollBox({content:html});
    				}
    			}	
    			else
    			{
    				$(".tollbox_all2").html('<font color="red">'+obj.txt+'</font>');
    			}	
    		}
    	});
    }
    exam.TollBoxShows=function(t)
    {
    	var flagid = $(t).attr('flagid');

    	$.post(this.hosturl,{'act':'tollbox_ps','flagid':flagid},function(data){

    		var obj = eval( "("+data+")" );
    		if( obj.error == 0 )
    		{	
    			exam.TollBox({content:obj.txt});
    		}
    		else
    		{
    			alert( obj.txt );
    		}	
    	});
    }   
    exam.LabelRadio=function(t)
    {
    	var val = $(t).find('span').html();
    	$('.tollbox_all2').html( val );
    }
    exam.closeImg=function()
    {
    	exam.tollbox_sugarcane.hide();
    	exam.tollbox_sugarcane.remove();
    	
    	exam.tollbox_ins.hide();
    	exam.tollbox_ins.remove();
    }
    exam.close=function(obj)
    {
    	exam.tollbox_sugarcane.hide();
    	exam.tollbox_sugarcane.remove();
    	
    	$(obj).hide();
    	$(obj).remove();
    }
    /*
     * Sett = 设置参数,{content:'html内容',w:'100%',h:'100%',bgc:'#FFFFFF'.....}
     * 设置参数说明:
     * content,设置内容
     * bgc,内容框背景
     * sha,遮照层背景
     * border,内容框边框颜色
     * radius,内容框边框圆角
     * z_index,遮照层与内容框层高度
     * time,设置回调时间
     * opacity,设置透明背景
     * rmsha,去除遮照层
     * 
     * func = 回调方法,function(obj){ ..... }
     * 
     * */
    exam.TollBox=function(Sett,func)
    {
    	exam.tb_parameter = (Sett==undefined)?{}:Sett;
    	exam.tb_function = (func==undefined)?function(){}:func;
     	
        var content = exam.tb_parameter.content==undefined?'HTML内容......':exam.tb_parameter.content;  	   	
    	var bgc = exam.tb_parameter.bgc==undefined?'#fdfbfb':exam.tb_parameter.bgc;
    	var sha = exam.tb_parameter.sha==undefined?'#000000':exam.tb_parameter.sha;
    	var rmsha = exam.tb_parameter.rmsha==undefined?true:exam.tb_parameter.rmsha;
    	var border = exam.tb_parameter.border==undefined?'#ece5e5':exam.tb_parameter.border;
    	var radius = exam.tb_parameter.radius==undefined?'0.2rem':exam.tb_parameter.radius;
    	var z_index = exam.tb_parameter.z_index==undefined?'99999999':exam.tb_parameter.z_index;
    	var time = exam.tb_parameter.time==undefined?'1000':exam.tb_parameter.time;
    	var opacity = exam.tb_parameter.opacity==undefined?'0.2':exam.tb_parameter.opacity;
    	var clearTimes = '';
    	
    	$("html,body").css({"height":"100%"});
    	
    	var body = $('body');
    	var div0 = $('<div class="tollbox_sugarcane" style="margin:0;padding:0;position:fixed;top:0;left:0;width:'+$('body').width()+'px;height:'+$('body').height()+'px;background:'+sha+';filter:alpha(opacity='+(opacity*100)+');opacity:'+opacity+';z-index:'+(z_index-2000)+'"></div><div class="tollbox_ins" style="border:1px solid '+border+';border-radius:'+radius+';margin:0;padding:0;position:absolute;background:'+bgc+';z-index:'+z_index+';">'+content+'</div>');
    	
    	if( $(".tollbox_ins").length == 0 )
    	{	
    		body.append( div0 );
    	}
    	
    	var w = ( $(window).width() - $(".tollbox_ins").width() ) / 2;
    	var h = ( $(window).height() - $(".tollbox_ins").height() ) / 2;    	
    	$(".tollbox_ins").css({"left":w+"px"});
    	$(".tollbox_ins").css({"top":h+"px"});
    	   	
    	exam.tollbox_sugarcane = $(".tollbox_sugarcane");  
    	exam.tollbox_ins = $(".tollbox_ins"); 
    	
    	if( rmsha )
    	{	    	  	
	    	$(".tollbox_sugarcane").click(function(){
	    		exam.close( exam.tollbox_ins );
	    	});
    	}
    	else
    	{
    		exam.tollbox_sugarcane.hide();
    	}	
    	   
    	$(".tollbox_ins ul li").hover(function(){
    		$(this).css({"color":"#1296db"});
    	},function(){
    		$(this).css({"color":"#676464"});
    	});

    	var i = time/1000;
    	function SetTimes()
    	{    		
    		if( i == 0 )
    		{   			
    			window.clearInterval( clearTimes );   			    			
    			if( exam.tb_function != undefined )
        	    {
    				var obj = $(".tollbox_ins");
    				exam.tb_function(obj);
        	    }  			
    		}
    		
    		i--;
    		
    		if( i >= 0 )
    		{
    			clearTimes=setTimeout(SetTimes,1000);
    		}
    	}
    	clearTimes=setTimeout(SetTimes,1000);
    	
    	return exam.tollbox_ins;
    }
    exam.CreateHTML4=function()
    {
    	var tFlag = true;
    	if( this.setting4 != undefined )
    	{
	    	if( this.setting4.title != undefined )
	    	{
	    		tFlag = this.setting4.title;
	    	}
    	}
    	var len='',url='',target='',id='';
    	if( this.setting4 != undefined )
    	{
    		len = this.setting4.len;
    		url = this.setting4.url;
    		target = this.setting4.target;
    		id = this.setting4.id;
    	} 	
    	
    	var examImg1 = 'data:image/png;base64,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';
    	var examImg2 = 'data:image/png;base64,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';
    	
    	var div0 = $('<div class="exam_minationdiv0"></div>');
    	var div1 = $('<div class="exam_minationdiv1">首页  〉考试分类</div>');   	
    	var fieldset1 = $('<fieldset class="exam_fieldset1"><legend><img src="'+examImg1+'" width="21" height="21" align="absmiddle"/>进入考场</legend></fieldset>');
    	var fieldset2 = $('<fieldset class="exam_fieldset2"><legend><img src="'+examImg2+'" width="21" height="21" align="absmiddle"/>子分类</legend></fieldset>');    	
    	var ul0 = $('<ul class="exam_minationul0"></ul>');	    	
	    var ul1 = $('<ul class="exam_minationul1"></ul>');
		    	
		$.post(this.hosturl,{'act':'GetExamination','len':len,'url':url,'target':target,'id':id},function(data){
		        var obj = eval("("+data+")");
		        if( obj.error == 0 )
		        {
		        	div1.html( obj.txt1 );
		        	if( obj.txt2 != null )
		        	{	
		        		ul0.append( obj.txt2 );
		        	}
		        	else
		        	{		        		
		        		ul0.append( '<li class="exam_minationli0" style="width:94%;color:#a99e9e;">未创建考场</li>' );
		        	}	
		        	if( obj.txt3 != null )
		        	{
		        		ul1.append( obj.txt3 );
		        	}
		        	else
		        	{
		        		ul1.append( '<li class="exam_minationli1" style="width:94%;color:#a99e9e;">未创建子分类</li>' );
		        	}	
		        	
		        	if( exam.func4 != undefined )
	        	    {
	        			var data = data;
	        			exam.func4( data );
	        	    }
		        }
		        else
		        {
		        	ul0.append( obj.txt );
		        	ul1.append( obj.txt );
		        	
		        	if( exam.func4 != undefined )
	        	    {
	        			var data = data;
	        			exam.func4( data );
	        	    }
		        }	
		        
		        exam.CreateCss4();
		        if( obj.txt2 != null && obj.txt3 == null )
	        	{
		        	fieldset2.hide();
	        	}
		        else if( obj.txt2 == null && obj.txt3 != null )
		        {
		        	fieldset1.hide();
		        }
		        else if( obj.txt2 == null && obj.txt3 == null )
		        {
		        	fieldset2.hide();
		        }		        
		});			   	
    	
    	if( tFlag )
        {
    		div0.append( div1 );
        }
    	
    	div0.append( fieldset1 );
    	div0.append( fieldset2 );
    	
    	fieldset1.append( ul0 );
    	fieldset2.append( ul1 );
    	   	
    	return div0;
    }
    exam.CreateCss4=function()
    {
    	if( this.setting4 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting4.w)?'100%':this.setting4.w;
    		var height = exam.isEmptyObject(this.setting4.h)?'100%':this.setting4.h;
    		var bgcs = exam.isEmptyObject(this.setting4.bgc)?'#fbf6f4':this.setting4.bgc;
    		var colors = exam.isEmptyObject(this.setting4.color)?'#666666':this.setting4.color;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var bgcs = '#fbf6f4';
    		var colors = '#666666';
    	}
    	
    	$(".exam_minationdiv0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height});
    	$(".exam_minationdiv1").css({"margin":"0","padding":"0","padding":"0px 1.8rem","border-bottom":"1px solid #d8cdcd","height":"3.3rem","line-height":"3.3rem","font-family":"Microsoft YaHei","background":bgcs,"color":colors});   	
    	$(".exam_minationdiv1 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei"});
    	$(".exam_fieldset1").css({"margin":"0","padding":"0","margin":"0.8rem 1.8rem","border":"1px solid #ece5e5"});
    	$(".exam_fieldset1 legend").css({"margin":"0","padding":"0","margin":"0.8rem 1.8rem","padding":"0 0.5rem","font-family":"Microsoft YaHei","color":"#666666"});
    	$(".exam_fieldset2").css({"margin":"0","padding":"0","margin":"0.8rem 1.8rem 1.8rem 1.8rem","border":"1px solid #ece5e5"});
    	$(".exam_fieldset2 legend").css({"margin":"0","padding":"0","margin":"0.8rem 1.8rem","padding":"0 0.5rem","font-family":"Microsoft YaHei","color":"#666666"});  	
    	$(".exam_minationul0").css({"margin":"0","padding":"0","padding":"0.6rem 0 0 1.8rem"});
    	$(".exam_minationli0").css({"margin":"0","padding":"0","border":"1px solid #ded5d5","list-style-type":"none","height":"6rem","text-align":"center","line-height":"6rem","float":"left","padding":"1rem 1rem","margin-right":"1.6rem","margin-bottom":"1.4rem","border-radius":"0.2rem","position":"relative","left":"0"});
    	$(".exam_minationli0 p").css({"margin":"0","padding":"0","position":"absolute","top":"-1px","left":"-1px","line-height":"0"});
    	$(".exam_minationli0 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei","display":"block","padding":"0 1.5rem","border-radius":"0.2rem"});  	
    	$(".exam_minationul1").css({"margin":"0","padding":"0","padding":"0.6rem 0 0 1.8rem"});
    	$(".exam_minationli1").css({"margin":"0","padding":"0","border":"1px solid #ded5d5","list-style-type":"none","text-align":"center","float":"left","padding":"1rem 1rem","margin-right":"1.6rem","margin-bottom":"1.4rem","border-radius":"0.4rem"});
    	$(".exam_minationli1 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei","display":"block","border-radius":"0.2rem","padding":"0.6rem 1.5rem"});
    	
    	$(".exam_minationdiv1 a").hover(function(){
    		$(this).css({"color":"red","text-decoration":"underline"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","text-decoration":"none"});
    	});    	
    	$(".exam_minationli0 a").hover(function(){
    		$(this).css({"background":"#74c29a","color":"#FFFFFF"});
    	},function(){
    		$(this).css({"background":"#FFFFFF","color":"#3e3c3c"});
    	});
    	
    	$(".exam_minationli1 a").hover(function(){
    		$(this).css({"background":"#f5f3f3","color":"red"});
    	},function(){
    		$(this).css({"background":"#FFFFFF","color":"#3e3c3c"});
    	});
    	
    }
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{li:'31%',w:'100%',h:'100%',bgc:'#FFFFFF'.....}
     * 设置参数说明:
     * w,宽
     * h,高
     * bgc,标题背景
     * color,标题字体颜色
     * url,链接
     * target,打开方式
     * len,描述截取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * 
     * */
    exam.Examination=function(hobj,Sett,func)
    {
    	this.htmlobj4 = hobj;
    	this.setting4 = (Sett==undefined)?{}:Sett;
    	exam.func4 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML4();   	
 	   
    	$( this.htmlobj4 ).empty();
    	$( this.htmlobj4 ).append( html );
    	
    	exam.CreateCss4();
    }
    
    /*###############################################################################*/
    
    exam.CreateHTML5=function()
    {
    	var tFlag = true;
    	if( this.setting5 != undefined )
    	{
	    	if( this.setting5.title != undefined )
	    	{
	    		tFlag = this.setting5.title;
	    	}
    	}
    	var len='',target='',limit='';
    	if( this.setting5 != undefined )
    	{
    		len = this.setting5.len;
    		target = this.setting5.target;
    		limit = this.setting5.limit;
    	} 
    	
    	var hotImg = 'data:image/png;base64,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';   	
    	var div0 = $('<div class="exam_hottestdiv0"></div>');
    	var div1 = $('<div class="exam_hottestdiv1"><img src="'+hotImg+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'最热门':this.setting5.title)+'</div>');    	
    	var ul0 = $('<ul class="exam_hottestul0"></ul>');
    	
    	var id = '';
    	if( exam.setting4 != undefined )
    	{
    		if( this.setting4.id != undefined ) id = this.setting4.id;
    	}
	    $.post(this.hosturl,{'act':'GetHottest','len':len,'target':target,'limit':limit,'id':id},function(data){
	    	 	var obj = eval("("+data+")");
	    	 	
	    	 	if( obj.error == 0 )
	    	 	{
	    	 		ul0.append( obj.txt );
	    	 		
	    	 		if( exam.func5 != undefined )
	        	    {
	        			var data = obj.txt;
	        			exam.func5( data );
	        	    }
	    	 	}	
	    	 	else
	    	 	{
	    	 		ul0.append( '<li class="exam_hottestli0" style="width:92%;color:#a99e9e;">'+obj.txt+'</li><div style="clear:both;"></div>' );
	    	 		
	    	 		if( exam.func5 != undefined )
	        	    {
	        			var data = obj.txt;
	        			exam.func5( data );
	        	    }
	    	 	}
	    	 	
	    	 	exam.CreateCss5();
		});    
	    	    	
	    if( tFlag )
	    {
	    	div0.append(div1);
	    }
	    
    	div0.append(ul0);  	    	
    	
    	return div0;
    }
    exam.CreateCss5=function()
    {
    	if( this.setting5 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting5.w)?'100%':this.setting5.w;
    		var height = exam.isEmptyObject(this.setting5.h)?'100%':this.setting5.h;
    		var colors = exam.isEmptyObject(this.setting5.color)?'#666666':this.setting5.color;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var colors = '#666666';
    	}
    	
    	$(".exam_hottestdiv0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height});
    	$(".exam_hottestdiv1").css({"margin":"0","padding":"0","border-bottom":"1px solid #ece5e5","margin":"0 1.8rem","height":"2.6rem","line-height":"2.6rem","color":colors,"font-family":"Microsoft YaHei"});
    	$(".exam_hottestul0").css({"margin":"0","padding":"0","margin":"1.2rem 0 0 1.8rem"});
    	$(".exam_hottestli0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","list-style-type":"none","text-align":"center","float":"left","padding":"1rem 1.85rem","margin-right":"1.4rem","margin-bottom":"1.4rem","border-radius":"0.2rem","font-family":"Microsoft YaHei","position":"relative","left":"0"});
    	$(".exam_hottestli0 a").css({"margin":"0","padding":"0","display":"block","padding":"2rem","text-decoration":"none","color":"#3e3c3c","border-radius":"0.2rem"});
    	$(".exam_hottestlip0").css({"margin":"0","padding":"0","position":"absolute","top":"-1px","left":"-1px"});
    	
    	$(".exam_hottestli0 a").hover(function(){
    		$(this).css({"color":"#FFFFFF","background":"#74c29a"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","background":"#FFFFFF"});
    	});
    }
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{li:'31%',w:'100%',h:'100%'......}
     * 设置参数说明:
     * w,宽
     * h,高
     * title,设置标题
     * color,标题字体颜色
     * target,打开方式
     * len,描述截取数量
     * limit,获取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * 
     * */
    exam.Hottest=function(hobj,Sett,func)
    {
    	this.htmlobj5 = hobj;
    	this.setting5 = (Sett==undefined)?{}:Sett;
    	exam.func5 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML5();   	
 	   
    	$( this.htmlobj5 ).empty();
    	$( this.htmlobj5 ).append( html );
    	
    	exam.CreateCss5();
    }
    
    /*#################################################################################*/
    
    exam.CreateHTML6=function()
    {
    	var tFlag = true;
    	if( this.setting6 != undefined )
    	{
	    	if( this.setting6.title != undefined )
	    	{
	    		tFlag = this.setting6.title;
	    	}
    	}
    	var len='',target='',limit='';
    	if( this.setting6 != undefined )
    	{
    		len = this.setting6.len;
    		target = this.setting6.target;
    		limit = this.setting6.limit;
    	} 
    	
    	var hotImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAQYElEQVR4Xu2dP2wUxxfH3559B64CtBQ/IihtJSlCGZMq6WKX0ABJGaSsJWgiQRyQqJA8kaBMAk1ScumS6mcooYgjUhKFX+GU2FSG85/96Z33yHHc+Xb3dua9t/sdyRLYuzNvvzOfnfdmZmciQoICUGCkAhG0gQJQYLQCAAStAwocoAAAQfOAAgAEbQAKFFMAPUgx3XBXTRQAIDWpaDxmMQUASDHdcFdNFAAgNaloPGYxBQBIMd1wV00UACA1qWg8ZjEFAEgx3XBXTRQAIDWpaDxmMQUASDHdcFdNFAAgNaloPGYxBQBIMd1wV00UACA1qWg8ZjEFAEgx3XLd1Ynj96MoeoeS5ExCdISI3h/IgP/Pvx9MqwO/WIuINimKVpMkedFybi2XIbg4twIAJLdkB9+wvbQ0n4JwJm30gzCUXCIxJJsR0SqD01xZeVB2AXXOD4BMWPsDQDAUGtIqgCmnGgBIAR13lpY+20uSBSLin2GuUYFcvd2ySUTtRhS1p1dWfvFWSkUzBiAZK5bjCCI6nxAtREQnMt6m7TKG5S4R3UP8kq1qAMgBOiVxfGQ7is4nSRIbhmLoEyZEz6Iocs0kuRc5x+AgDVEAgAwRhcHYIfoqIYoNuFCTNmwO8N000XcA5W0pAUifJkkcn9jZd6PqAMZga+i6X819UJ5NSl1V7gcgRNR1pYi+oX0wkPZBWUKPQlR7QDpLS+cpSVwNXKm84POE5HJrZeW7vDdW6fraApKOSq0QkZa5C63timfvl5rODc7qa7W3VLtqBwjcqcLtp5ZuV60A2Y5jXgt1H+5UYUh4xGuxTr1JbQDZjuNvEqLlwk0DN75WICJabjr3bR0kqTwgqUvFvQZijXJb9GqTaLHqI12VBgQuVblEDMlts0F0cdq5tveShAqoLCCdOL5ARD8K6Vq3Yi+2nOM1XpVLlQSkE8cMBgOCFE6Buy3nLoYrLkxJlQMEcIRpOCNKqRwklQGEg/EO0Y/R/jcaSHIKVCp4rwQg6UjVf4d86y3XTOpd8lqT6OMqjHCZBwRwqCWxEpCYB+RVHN+HW6UTkoSofci5RZ3WZbPKNCAIyLNVsvBVpgN3s4AADuFmn694s5CYBASTgPlap5KrTU4mmgMkXT7CI1ZIxhSIiD62thLYFCDpiNXfWK5ujIx/zd1sEr1rafjXFCCdOOaeA6tyzfLRNXy15dzHVh7BDCCv4ng52t9YAcm4AgnRt4ecM/FtjglA0u/HfzfeLmB+nwJW4hH1gKRrrH73tbNhY3aWouPHgzbe5Plz2vvzT6KtrdLL7T7L4cPUOHXqzby3tmhvfZ1oY4O4fOnEOzu2iD7QHo+oB6QTx7wlz1dlVyg3oMbZsxQdO1Z21tny29qi3Xab9h49ynb9AVd1IZ+bo8bcHNHMzNj8kvV1Sp486ULK/xZM37WcU70XmWpAfLlW/JadvnxZsF38W/Tuzz8XhqTx4YfU+PTTiSBPnj4ltkGwV/lA80ba2gHxMmo1ffXqRI2qVLK2tmj7xo1c7la391tYKNU15J6MezQfbt8YvVSPaqkFxNdsuabeo9dw8vQijdOnaers2VIZ7WXG7la3NwnvdqmdZVcJiM8JQZ8NrGir3X34kPbu88YrBycGg+33mjg2YrfvyROvxQxkrnYCUSUgPuc82Gef+uSTkJU/tqzkr79o5/btA68LAkefBbt37tDe06djbS/rAq1zI+oA8dl7cGVaBGRqfr4bcwRNW1u0c+dOSHdLZS+iDhCfvYdFQDggn/ryy6Bs9MckDEmowF1jL6IKEN+9h0VApEfcdn/7jfZ+/TUUoOp6EVWAdOKYJ434SAJvyZKLpcXWnRs3gs2TaOtFVAHyKo7/9rWkpEeclkbX/wYYGqTPzFDz6tVMM+Pe3iZpxnuPH9PuTz/5LqabPy9BOeTcu0EKy1CIGkB8zXsMamAFEJHA/IAGs/3118FiESJSMy+iCRBerctnkXtNVgCZvnSJopMnvWqRJ/M8k5l58h1x7VrLuQ9KyGfiLFQAwqfLbhPxl4LekwlA2L26edO7FnkK4IWNu99/n+eWia5NvzwUP21XBSAhgnNLMYjG2X7Wb3tpaaJGn+dmLcG6CkBCBOemAFE428/6BR7NUhGsiwPia0n7qLeVBRersbhIUx99lOeFG+Ta0MtPiEh8KbwGQLx8EGUZEG0Bek/L3R9+CL2IUfyDKnFAQrpXXNEWehC1gISdVefq2mw5dzRI9ziiEFFAQo5eWYpB1AISvgfhahN1s0QBCTU52P9yQA9S/H0sEIOwsUst59gNF0nSgPDBj+dDPrkFQDTa2B3FunUr5PL3brNIiH455Fzgtf7/tkhRQELHH1ZiEMyDvPHKFI1DxACRiD+sAMJbEfEyd00p9Ez6wLOLxSFigEjEH1YAYTunr12j6KjoAM4bbTTwWqzBd4NYHCIJSPD4wxIgNV/NOwjIvZZzIufeSwKySkTzod0IjQHwyO9Brl3rbiMqnUJ+DzLiWR+0nBPZ1V8SkA2Jcz7MAKJoUjPkGqwRgIgF6pKAJBJvRkuA8D67TeFeJPA36SObRMs5kbYqUqjkMWqmAOFeZG6Opj7/XOJdQsk//+zv1+VhF/q8DyR1XIIIIDtxvLBHNH4rwbwqZrjeGiDdgQWJ1b0vX3bhENiGdFQtinyGKwKI772vDuJE8o08yq4sbszUuXPEu7mHSkLLSkY+ntQHVLUDROMkXNY5hiCQvHzZ3cEk8N68Y7mvGyDtiOizsap4ukDTatlkY4N2rl/P/KQ+XUS2hb87V+RW9esiMtQr0oN04lhkDuS12jMzNH3livxMdUE/v3s+yLlzpdrfnevgHeYVBOSa5kLqCQjXwMwMTS0uBvXr+yueJwe5QU7ytu72JvPzE00mlmFH5u5vsgvRg0ymX8G7Z2aoIXCIZ2lHnrH9c3P7ZxTOzmYSgYdv+WiD5NGjiQDNVFh5FwGQ8rSsb07sfvEpWkl6mCcPSryGkaF4/jzYPrsl10KtABFZZlJyhSG7wApIzKZLxSBrRPReYH1RnGEFEqL/HXLuROhHkAJEdhQrtMoorwwFauVi6QCEA9zZ2fBHQvNBmY8f5xtSFbCV4xX+klDJ0C8AKeM1kzWP7pITPk45DWaz3lfadQxJu018Pvm4xEE3L1jkgDt4ymGnZ9tqBUjQ3RQHK07y3L9BW8YtM+me685nFEqBnBossKvioFQiXxWKxCCSixVZdelz/96o+a0t2r5xY6Qbw3BEp055fjmPz57dLf5wSirVbS3WckT0jYTYmnqP3vPvtdu0++DBW3JoW1gpucIXgASiRdtmCPzYuw8f0h6vgxpI2mDOsizfVzXWChB8MPVmMxq6aQN/KCV4Rvqwhi4JiNS5hSIxCD65BSB5e5pafXKbxPGRbSJebhI8+fyeoujDoAcZr1yT6Gjk3Ob4K8u9QqQH4Ud4FcfPIqL/lPs443MDIOM1GnWFlIsltcyEdZAEROSrQgBiEhCxHd4lAREZ6gUgJgH59pBzy8UtL36nGCBSgToAKd5YpFwsqQBd1MWSCtQBiD1ApAJ0UUCkAnUAYgsQyQBdAyDBA3UAYg4QsQBdHJBOHMdEtFK8yvLfCUDya9a7QygGETs8RxwQiWPYAIgtQJpE70bOPStu9WR3io1i9czuxHHQ79MBSPEGI9CD/NFy7v3iFk9+pwZAgrpZAKR4oxEARNS9Enex2IDQbhYAsQOItHulAhA2IuRevQDEDCDi7pUmQPgE0x+LV132OwFIdq0GrwzsYom7V2oACTmrDkBsAKLBvVIDSDqrHmTSEIDoByQhEp0c7FdIfBSrZ0yoxYsARD8gUp/XDlNGDSBpsO59TgSA6AZEeu3VoDraAPEerAMQ3YBo6j1UxSC9avP9KS4A0QuItt5DJSCdOPbaiwAQvYBo6z1UApKOaHnb0AGA6AREY++hFhCfvQgA0QmIxt5DLSA+e5HG6dP7xx4oSqNmqLXtrDhqD+FJpdTae6gGxNf2pN3jBC5fnrROS71/5BEIMzPUvHmz1LImyWzn1i0vp+I2iBannWtPYpuve1UN8w4+5Ks49jK7Pn3pEkUnT/rSNFe+ycYG7Vy/PvKeqXPnxM5y7zdq1O6PuR52yMWaZs2HPYtqQNI1Wvw12TuTVsQb9/Ob+do1osOHS802d2YvX9LO7dsHv5VnZmj6yhWKjh7NnX1pN2Sxs1hhL5pEJyS2FM1qrmpA+CF8uVp8YlP37Tw7m1WrUq/jN/Lu/fvZXBaG5IsvRHq9XHbmVEiza9V7FPWAsKG+XK1uEHbsWPCz//i0Jv7Jm7q2Hj9OxD++0/p618Zkfd1LSdpdK1OAeHO1vFQ9Ms2ggHrXyhQgXl2tDLWJS8pVwIJrZQ4Q365WuU0AuY1SwIprZRKQ1NVaJaL30ARNKvBHk+iM5lGrQVVNBOn9RnfimPdJYkjKHfo12d5MGf2CiM60nONvfswkc4CwsoDETPvqGWoSDjbeJCApJF6XxZtrgroNvthy7q5uE4dbZxYQQGKmuZmFw3QP0msenTjmN9N5M82lXobeaznHPb3ZZLoHASSq2515OCrRgwASlZDcaxLFloZzR6lYiR6kDxJHRF+pbDL1MaoSPUevuioFCAJ3cQpNB+TD1KscIPyQ6RJ5Dt4xmRiGGZ7niK0O5R4kUSUBSXsSzLiHg8PcDHlWaSoLCAuQHs7D3zpj7VbWFpHvuj+I6IK15SN5HrHSgKSQHOkQ3Y2IPssjDK49WAFeldsiulCFkapauliDD424pDTkXzSILmjdhaS0p0wzqnwP0i8YL5dHb1K8CdWl1+hXqFaA9B4cvUluSGrVa9QeEMQm2QGpY68BQPoUSE+2Wiai+ezNphZXPoiIlpvO8cdptU21dLGG1TZAea0KwOhrIABkgJYagwIwhrw5AcgI56FGoACMAxxIADLGu2ZQ9njpdsUmGjn4bhC5uscY44IrADJOofTv6ZZDCwnRglVYGIqIqN0kald9BjxjtY69DICMlejtCyzBAigKVDCC9MlE67+7Bwvv+UREvIJYemEkLyDkvadW0VNMXs/oQSbX8K0c0gCfYen9+IKmB8NaRLSGeKL8ygQg5Ws6NEfe7C4iOsJ/3Nvvbbop/R2DNCytJUSbvT809neU7CbAEKbiAEgYnVGKUQUAiNGKg9lhFAAgYXRGKUYVACBGKw5mh1EAgITRGaUYVQCAGK04mB1GAQASRmeUYlQBAGK04mB2GAUASBidUYpRBQCI0YqD2WEUACBhdEYpRhUAIEYrDmaHUQCAhNEZpRhVAIAYrTiYHUYBABJGZ5RiVAEAYrTiYHYYBQBIGJ1RilEFAIjRioPZYRQAIGF0RilGFQAgRisOZodRAICE0RmlGFUAgBitOJgdRgEAEkZnlGJUAQBitOJgdhgFAEgYnVGKUQUAiNGKg9lhFAAgYXRGKUYVACBGKw5mh1EAgITRGaUYVQCAGK04mB1GAQASRmeUYlQBAGK04mB2GAUASBidUYpRBQCI0YqD2WEUACBhdEYpRhUAIEYrDmaHUQCAhNEZpRhVAIAYrTiYHUYBABJGZ5RiVAEAYrTiYHYYBQBIGJ1RilEF/g+wCFsyvGmCoQAAAABJRU5ErkJggg==';   	
    	var div0 = $('<div class="exam_OtherIficdiv0"></div>');
    	var div1 = $('<div class="exam_OtherIficdiv1"><img src="'+hotImg+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'其它分类':this.setting6.title)+'</div>');   	
    	var ul0 = $('<ul class="exam_OtherIficul0"></ul>');

    	var id = '';
    	if( exam.setting4 != undefined )
    	{
    		if( exam.setting4.id != undefined ) id = exam.setting4.id;	
    	}      
	    $.post(this.hosturl,{'act':'GetOtherIfic','len':len,'target':target,'limit':limit,'id':id},function(data){	    		    	
	    	 	var obj = eval("("+data+")");
	    	 	if( obj.error == 0 )
	    	 	{
	    	 		ul0.append(obj.txt);
	    	 		
	    	 		if( exam.func6 != undefined )
	        	    {
	        			var data = obj.txt;
	        			exam.func6( data );
	        	    }
	    	 	}	
	    	 	else
	    	 	{
	    	 		ul0.append( '<li class="exam_OtherIficli0" style="width:92.5%;color:#a99e9e;">'+obj.txt+'</li><div style="clear:both;"></div>');
	    	 		
	    	 		if( exam.func6 != undefined )
	        	    {
	        			var data = obj.txt;
	        			exam.func6( data );
	        	    }
	    	 	}	
	    	 	exam.CreateCss6();
		});    
    	
	    if( tFlag )
	    {
	    	div0.append(div1);
	    }
	    
    	div0.append(ul0);  	    	   	
    	
    	return div0;
    }
    exam.CreateCss6=function()
    {
    	if( this.setting6 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting6.w)?'100%':this.setting6.w;
    		var height = exam.isEmptyObject(this.setting6.h)?'100%':this.setting6.h;
    		var colors = exam.isEmptyObject(this.setting6.color)?'#666666':this.setting6.color;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var colors = '#666666';
    	}
    	
    	$(".exam_OtherIficdiv0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","width":width,"height":height});
    	$(".exam_OtherIficdiv1").css({"margin":"0","padding":"0","border-bottom":"1px solid #ece5e5","margin":"0 1.8rem","height":"2.6rem","line-height":"2.6rem","color":colors,"font-family":"Microsoft YaHei"});
    	$(".exam_OtherIficul0").css({"margin":"0","padding":"0","margin":"1.2rem 0 0 1.8rem"});
    	$(".exam_OtherIficli0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","list-style-type":"none","text-align":"center","float":"left","padding":"0.6rem 1.85rem","margin-right":"1.4rem","margin-bottom":"1.4rem","border-radius":"0.2rem","font-family":"Microsoft YaHei"});
    	$(".exam_OtherIficli0 a").css({"margin":"0","padding":"0","display":"block","padding":"0.6rem 1.8rem","text-decoration":"none","color":"#3e3c3c","border-radius":"0.2rem"});
    	
    	$(".exam_OtherIficli0 a").hover(function(){
    		$(this).css({"color":"red","background":"#f5f3f3"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","background":"#FFFFFF"});
    	});
    }
    /*
     * hobj = #id 或 .class
     * 
     * Sett = 设置参数,{li:'31%',w:'100%',h:'100%'......}
     * 设置参数说明:
     * w,宽
     * h,高
     * title,设置标题
     * color,标题字体颜色
     * target,打开方式
     * len,描述截取数量
     * limit,获取数量
     * 
     * func = 回调方法,function(data){ ..... }
     * 
     * */
    exam.OtherIfic=function(hobj,Sett,func)
    {
    	this.htmlobj6 = hobj;
    	this.setting6 = (Sett==undefined)?{}:Sett;
    	exam.func6 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML6();   	
 	   
    	$( this.htmlobj6 ).empty();
    	$( this.htmlobj6 ).append( html );
    	
    	exam.CreateCss6();
    }
    
    /*########################################################################################*/
    
    exam.Setcookie=function(name, value)
    { 
        var expdate = new Date(); 
        expdate.setTime( expdate.getTime() + (60*60*2) ); 
        document.cookie = name+"="+value+";expires="+expdate.toGMTString()+";path=/";
    }
    exam.getCookie=function(c_name)
    {
    	if (document.cookie.length>0)
      	{
     		c_start=document.cookie.indexOf(c_name + "=");
      		if (c_start!=-1)
        	{ 
    		    c_start=c_start + c_name.length+1; 
    		    c_end=document.cookie.indexOf(";",c_start);
    		    if (c_end==-1) c_end=document.cookie.length;
    		    return unescape(document.cookie.substring(c_start,c_end));
    	    } 
       }
    	return "";
    } 
    
    /*##############################################################################################*/
    exam.SetEndTime=function()
    {
    	$.post(this.hosturl,{'act':'SetEndTime','id':this.setting7.id,'bel':exam.bel},function(data){});
    }
    exam.SingleChoiceQuestion=function(n,m)
    {		    
    		exam.type=n;
	    	var shuiji = {};
				shuiji[1] = 30;
				shuiji[2] = 30;
				shuiji[3] = 30;
							
			$.post(this.hosturl,{'act':'FreePractice','id':this.setting7.id,'type':exam.type,'shows':shuiji[exam.type],'tb':m,'bel':exam.bel},function(data){

					var obj = eval( "("+data+")" );
					
					$('.exam_freesiondiv2').empty();
					
					if( obj.error == 0 )
					{	
						$('.exam_freesiondiv2').append( obj.txt );
					}
					else
					{
						$('.exam_freesiondiv2').append( obj.txt );
					}	
					exam.CreateCss7();	
					
					exam.Answer = obj.f;
			});	
    }
    
    exam.NextQuestion=function(t,obj1,obj2,id,n)
    {
    	if( exam.Answer == 1 )
    	{	
	    	var num = parseInt( $('.'+n).find('span').html() );
	      	
	    	var shuiji = {};
				shuiji[1] = 30
				shuiji[2] = 30
				shuiji[3] = 30
	    						
	    	if( num == $(".exam_countall").html() )
	    	{
	    		num = 0;
	    		exam.type++
	    		if( exam.type > 3 )
	    		{    			
	    			$('.exam_freesiondiv2').empty();   
		    			
	    			var html = '<iframe src="'+this.hosturl+'/exanalysis/'+this.setting7.id+'/'+(exam.type-1)+'/'+shuiji[exam.type-1]+'/'+exam.bel+'" width="100%" height="790" frameborder="0"></iframe>';
	    			
	    			$('.exam_freesiondiv2').append( html );
	    			
	    			exam.CreateCss7();	
	    			
	    			return false;
	    		}
	    	}
	    								
			$.post(this.hosturl,{'act':'FreePractice','id':this.setting7.id,'type':exam.type,'shows':shuiji[exam.type],'tb':num,'bel':exam.bel},function(data){

					var obj = eval( "("+data+")" );
					
					$('.exam_freesiondiv2').empty();
					
					if( obj.error == 0 )
					{	
						$('.exam_freesiondiv2').append( obj.txt );
					}
					else
					{
						$('.exam_freesiondiv2').append( obj.txt );
					}	
					exam.CreateCss7();
					
					exam.Answer = obj.f;
					
			});
			$(".ExambtnNext").css({"border":"1px solid #ded7d7"});	
    	}	
    	else
    	{
    		$(".ExambtnNext1").css({"border":"1px solid #0c7fda"});
    	}	
    }
    exam.give_up=function(t,obj1,obj2,id,n)
    {
    	var num = parseInt( $('.'+n).find('span').html() );
    	
    	if( num == $(".exam_countall").html() )
    	{
    		num = 0;
    		if( exam.type >= 3 )
    		{
    			$(".ExambtnNext").val('练习完毕,点击查看分析');
    			this.SetEndTime();
    		}
    	}
    	
    	if( exam.Answer != 1 )
    	{
    		$.ajax({
	    		url:this.hosturl,
	    		type:'post',
	    		data:'act=give_up&id='+id+'&n='+num+'&type='+exam.type+'&ify='+exam.ifyId+'&bel='+exam.bel,
	    		success:function(data){
	    			var obj = eval("("+data+")");
	    			if( obj.error == 0 )
	    			{
	    				$( '.'+obj2 ).html(obj.txt);
	    			}	
	    			else
	    			{
	    				$( '.'+obj2 ).html(obj.txt);
	    			}	
	    			exam.Answer = 1;
	    			if( exam.Answer == 1 ){ $(".ExambtnNext").css({"border":"1px solid #0c7fda"}); }
	    		}
	    	}); 
    		$(".ExambtnNext1").css({"border":"1px solid #ded7d7"});
    	}
    	else
    	{
    		if( num == $(".exam_countall").html() )
	    	{    		
	    		if( exam.type >= 3 )
	    		{	    			
	    			$(".ExambtnNext").val('练习完毕,点击查看分析');	    			
	    		}
	    	}
    		$(".ExambtnNext").css({"border":"1px solid #0c7fda"});
    	}	
    }
    exam.Arraysplit=function(value)
    {
    	if( value != '' )
    	{	
	    	var strArr='';
			var valArr = value.split('&');	    		
			var len = valArr.length;
			for(var i=0;i<len;i++)
			{
				var valArr2 = valArr[i].split('=');
				strArr += valArr2[1];
			}
			return 'rightkey='+strArr;
    	}
    	else
    	{
    		return '';
    	}	
    }
    exam.Determine=function(t,obj1,obj2,id,n)
    {
    	var num = parseInt( $('.'+n).find('span').html() );
    	
    	if( exam.Answer != 1 )
    	{	
	    	var value = $( '#'+obj1 ).serialize();	   
	    		   	    	
	    	if( exam.type == 2 )
	    	{	
	    		value = exam.Arraysplit(value);
	    	}
	    		    		    	
	    	if( value == '' )
	    	{
	    		var arr = new Array();
				arr[0] = '请选择一个答案';
				arr[1] = '你还没有选择答案';
				arr[2] = '你需要选择一个答案';
				arr[3] = '明确一个答案';
				arr[4] = '检查到你还没有选择任何答案，请选择';
				arr[5] = '请慎重选择一个答案';
				arr[6] = '请认真选择答案或者放弃';
				arr[7] = '选择以上答案';
				arr[8] = '请思考一个答案';
				arr[9] = '同学你还没有选择答案';
				arr[10] = '老兄你需要提供一个答案';
				
				var i = Math.floor( Math.random()*10 );
				
				var errorts = 'data:image/png;base64,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';
				
	    		$( '.'+obj2 ).html('<img src="'+errorts+'" width="20" height="20" align="absmiddle"/> <font color="red">'+arr[i]+'</font>');return false;
	    	}	
	    		    	
	    	if( num == $(".exam_countall").html() )
	    	{
	    		num = 0;	    		
	    		if( exam.type >= 3 )
	    		{
	    			$(".ExambtnNext").val('练习完毕,点击查看分析');
	    			this.SetEndTime();
	    		}
	    	}
	    	
	    	$.ajax({
	    		url:this.hosturl,
	    		type:'post',
	    		data:'act=EDetermine&id='+id+'&'+value+'&n='+num+'&type='+exam.type+'&ify='+exam.ifyId+'&bel='+exam.bel,
	    		success:function(data){	    			
	    			var obj = eval("("+data+")");
	    			if( obj.error == 0 )
	    			{
	    				$( '.'+obj2 ).html(obj.txt);
	    			}	
	    			else
	    			{
	    				$( '.'+obj2 ).html(obj.txt);
	    			}	
	    			exam.Answer = 1;
	    			if( exam.Answer == 1 ){ $(".ExambtnNext").css({"border":"1px solid #0c7fda"}); }
	    		}
	    	});	  
	    	$(".ExambtnNext1").css({"border":"1px solid #ded7d7"});
    	}
    	else
    	{
    		if( num == $(".exam_countall").html() )
	    	{    		
	    		if( exam.type >= 3 )
	    		{
	    			$(".ExambtnNext").val('练习完毕,点击查看分析');
	    		}
	    	}
    		$(".ExambtnNext").css({"border":"1px solid #0c7fda"});
    	}
    }
    exam.CreateHTML7=function()
    {
    	var tFlag = true;
    	if( this.setting7 != undefined )
    	{
	    	if( this.setting7.title != undefined )
	    	{
	    		tFlag = this.setting7.title;
	    	}
    	}
 	   	
    	if( this.setting7 != undefined )
    	{
    		exam.ifyId = this.setting7.id;
    		exam.tb = this.setting7.tb==undefined?'':this.setting7.tb;
    		exam.type = this.setting7.type==''?1:this.setting7.type;
    		exam.bel = this.setting7.bel==''?'':this.setting7.bel;
    		
    		if( exam.tb == $(".exam_countall").html() )
	    	{
    			exam.tb = 0;
	    	}
    	}   	
    	
    	var div0 = $('<div class="exam_freesiondiv0"></div>');
    	var div1 = $('<div class="exam_freesiondiv1">'+(typeof tFlag=='boolean'?'首页 &gt; 分类':this.setting7.title)+'</div>');  
    	var div2 = $('<div class="exam_freesiondiv2"></div>');
    	  	
    	var shuiji = {};
    		shuiji[1] = 30
    		shuiji[2] = 30
    		shuiji[3] = 30
    	    	   		
    	$.post(this.hosturl,{'act':'FreePractice','id':exam.ifyId,'type':exam.type,'shows':shuiji[exam.type],'tb':exam.tb,'bel':exam.bel},function(data){
   		   		
    			var obj = eval( "("+data+")" );
    			   			
    			if( obj.error == 0 )
    			{	
    				div2.append( obj.txt );
    			}
    			else
    			{
    				div2.append( obj.txt );
    			}	
    			exam.CreateCss7();
    			exam.Answer = obj.f;
    			if( obj.f == 1 ){ $(".ExambtnNext").focus(); }  			
    	});
    	
    	if( tFlag )
    	{
    		div0.append(div1);
    	}
    	div0.append(div2);
    	   	
    	return div0;
    }
    exam.CreateCss7=function()
    {
    	if( this.setting7 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting7.w)?'100%':this.setting7.w;
    		var height = exam.isEmptyObject(this.setting7.h)?'100%':this.setting7.h;
    		var colors = exam.isEmptyObject(this.setting7.color)?'#666666':this.setting7.color;
    		var bgcs = exam.isEmptyObject(this.setting7.bgcs)?'#fbf6f4':this.setting7.bgcs;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var colors = '#666666';
    		var bgcs = '#fbf6f4';
    	}
    	$(".exam_freesiondiv0").css({"border":"1px solid #d8cdcd","margin":"0","padding":"0","width":width,"height":height});
    	$(".exam_freesiondiv1").css({"margin":"0","padding":"0","padding":"0px 1.8rem","border-bottom":"1px solid #d8cdcd","height":"3.3rem","line-height":"3.3rem","font-family":"Microsoft YaHei","background":bgcs,"color":colors});  
    	$(".exam_freesiondiv1 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei"});
    	$(".exam_freesiondiv2").css({"margin":"0","padding":"0px 1.8rem","position":"relative","top":"0","left":"0"});
    	$(".exam_freesionp0").css({"margin":"0","padding":"0","font-family":"Microsoft YaHei","line-height":"4rem","color":"#3a3838","height":"3rem","font-size":"15px"});
    	$(".exam_freesionp1").css({"border-bottom":"1px solid #e8e0e0","margin":"0.6rem 0 0 0","padding":"0 0 1rem 0","font-family":"Microsoft YaHei","line-height":"2rem","font-size":"1.3rem","color":"#3a3838"});
    	$(".exam_freesionp2").css({"margin":"0","padding":"0","font-family":"Microsoft YaHei","line-height":"4rem","color":"#3a3838","height":"3rem","font-size":"13px"});   	
    	$(".exam_freesionul0").css({"margin":"0.6rem 0 0 0","padding":"0","font-family":"Microsoft YaHei"});
    	$(".exam_freesionli0").css({"margin":"0","padding":"0","font-family":"Microsoft YaHei","list-style-type":"none","line-height":"3rem","font-size":"13px","color":"#3a3838"});
    	$(".exam_freesionp3").css({"margin":"1rem 0 0 0","padding":"0","font-family":"Microsoft YaHei","color":"#1296db"});
    	$(".exam_freesiondiv3").css({"margin":"1.2rem 0 1rem 0","padding":"1rem 0","text-align":"center","font-family":"Microsoft YaHei"});
    	$(".exam_freesionbtn0").css({"margin":"0 1rem 0 0","padding":"0px 1rem","border":"1px solid #ded7d7","height":"2.3rem","border-radius":"0.2rem","font-size":"14px","color":"#3a3838","cursor":"pointer","font-family":"Microsoft YaHei","outline":"none"});
    	$(".exam_freesiondiv4").css({"margin":"0","padding":"0","position":"absolute","top":"1rem","right":"2rem","font-family":"Microsoft YaHei","font-size":"13px","color":"#7d7676"});
    	$(".exam_freesiondiv1 a").hover(function(){
    		$(this).css({"color":"red","text-decoration":"underline"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","text-decoration":"none"});
    	});
    }
    exam.FreeSion=function(hobj,Sett,func)
    {
    	this.htmlobj7 = hobj;
    	this.setting7 = (Sett==undefined)?{}:Sett;
    	exam.func7 = (func==undefined)?function(){}:func;
    	   	
    	var html = this.CreateHTML7();   	
 	   
    	$( this.htmlobj7 ).empty();
    	$( this.htmlobj7 ).append( html );
    	
    	exam.CreateCss7();
    }
    
    /*##########################################################################*/
    
    exam.Tips=function(Sett,func)
    {
    	exam.tb_parameter2 = (Sett==undefined)?{}:Sett;
    	exam.tb_function2 = (func==undefined)?function(){}:func;
     	
    	var title = exam.tb_parameter2.title==undefined?'':exam.tb_parameter2.title; 
    	
    	var html = '<div style="background:#333030;border-radius:4px;padding:20px 30px;color:#e4d8d8;font-family:Microsoft YaHei;">'+(title==''?'玩命提示......':title)+'</div>';
    	
        var content = exam.tb_parameter2.content==undefined?html:exam.tb_parameter2.content;  	   	
    	var bgc = exam.tb_parameter2.bgc==undefined?'#fdfbfb':exam.tb_parameter2.bgc;
    	var sha = exam.tb_parameter2.sha==undefined?'#000000':exam.tb_parameter2.sha;
    	var rmsha = exam.tb_parameter2.rmsha==undefined?false:exam.tb_parameter2.rmsha;
    	var border = exam.tb_parameter2.border==undefined?'#ece5e5':exam.tb_parameter2.border;
    	var radius = exam.tb_parameter2.radius==undefined?'0.2rem':exam.tb_parameter2.radius;
    	var z_index = exam.tb_parameter2.z_index==undefined?'99999999':exam.tb_parameter2.z_index;
    	var time = exam.tb_parameter2.time==undefined?'5000':exam.tb_parameter2.time;
    	var opacity = exam.tb_parameter2.opacity==undefined?'0.2':exam.tb_parameter2.opacity;
    	var clearTimes = '';
    	
    	$("html,body").css({"height":"100%"});
    	
    	var body = $('body');
    	var div0 = $('<div class="tollbox_sugarcane2" style="margin:0;padding:0;position:fixed;top:0;left:0;width:'+$('body').width()+'px;height:'+$('body').height()+'px;background:'+sha+';filter:alpha(opacity='+(opacity*100)+');opacity:'+opacity+';z-index:'+(z_index-2000)+'"></div><div class="tollbox_ins2" style="border:1px solid '+border+';border-radius:'+radius+';margin:0;padding:0;position:absolute;background:'+bgc+';z-index:'+z_index+';">'+content+'</div>');
    	
    	if( $(".tollbox_ins2").length == 0 )
    	{	
    		body.append( div0 );
    	}
    	
    	var w = ( $(window).width() - $(".tollbox_ins2").width() ) / 2;
    	var h = ( $(window).height() - $(".tollbox_ins2").height() ) / 2;    	
    	$(".tollbox_ins2").css({"left":w+"px"});
    	$(".tollbox_ins2").css({"top":h+"px"});
    	   	
    	exam.tollbox_sugarcane = $(".tollbox_sugarcane2");  
    	exam.tollbox_ins = $(".tollbox_ins2"); 
    	
    	if( rmsha )
    	{	    	  	
	    	$(".tollbox_sugarcane2").click(function(){
	    		exam.close( exam.tollbox_ins );
	    	});
    	}
    	else
    	{
    		exam.tollbox_sugarcane.hide();
    	}	
    	   
    	$(".tollbox_ins2 ul li").hover(function(){
    		$(this).css({"color":"#1296db"});
    	},function(){
    		$(this).css({"color":"#676464"});
    	});

    	var i = time/1000;   	
    	function SetTimes2()
    	{    		
    		if( i == 0 )
    		{   			
    			window.clearInterval( clearTimes );   			    			
    			if( exam.tb_function2 != undefined )
        	    {
    				var obj = $(".tollbox_ins2");
    				$(obj).hide();
    				exam.tb_function2(obj);
        	    }  
    			
    		}

    		i--;
    		
    		if( i >= 0 )
    		{
    			clearTimes=setTimeout(SetTimes2,1000);
    		}
    	}
    	clearTimes=setTimeout(SetTimes2,1000);
    	
    	return exam.tollbox_ins;
    }
    
    if( exam.IEVersion() < 9 && exam.IEVersion() != -1 )
	{
    	$(function(){ exam.Tips({title:"您的浏览器版本过低，请升级浏览器，获得更好体验！"}); });
	}
    
    /*##################################################################################################*/
    exam.OnSubmitSend = function()
    {
    	var vals = $(this.htmlobj8).serialize();
    	/*	
    	if( exam.power[0] == 0 ){
    		alert(exam.dir[0]+' 权限不足，需要读写权限，值=0777');
    		$(".exam_insenablediv2").focus();
    		return false;
    	}*/
    	if( exam.power[1] == 0 ){
    		alert(exam.dir[1]+' 权限不足，需要读写权限，值=0777');
    		$(".exam_insenablediv2").focus();
    		return false;
    	}	
    	if( $("[name='hostid']").val() == '' ){
    		alert('HOST ID 不能留空');
    		$("[name='hostid']").focus();
    		return false;
    	}
    	if( $("[name='basname']").val() == '' ){
    		alert('请设置 DBName');
    		$("[name='basname']").focus();
    		return false;
    	}   	
    	if( $("[name='sign']").val() == '' ){
    		alert('Sign in 不能留空');
    		$("[name='sign']").focus();
    		return false;
    	}
    	if( $("[name='password']").val() == '' ){
    		alert('请设置 password');
    		$("[name='password']").focus();
    		return false;
    	}
    	if( $("[name='admin']").val() == '' ){
    		alert('请设置管理员帐号');
    		$("[name='admin']").focus();
    		return false;
    	}
    	if( $("[name='pwd']").val() == '' ){
    		alert('请设置密 码');
    		$("[name='pwd']").focus();
    		return false;
    	}    	
    	$.ajax({
    		url:this.hosturl,
    		type:'post',
    		data:'act=OnSubmitSend&'+vals,
    		success:function(d){
    			var obj = eval("("+d+")");
    			if( obj.error == 0 ){
    				location.href=obj.txt;
    			}else{
    				alert(obj.txt);
    			}
    		}
    	});
    }
    exam.CreateHTML8=function()
    {
    	var tFlag = true;
    	if( this.setting8 != undefined )
    	{
	    	if( this.setting8.title != undefined )
	    	{
	    		tFlag = this.setting8.title;
	    	}
    	}	   	
    	if( this.setting8 != undefined )
    	{
    		exam.dir = this.setting8.dir==undefined?'':this.setting8.dir;
    		exam.power = this.setting8.power==undefined?'0':this.setting8.power;
    		exam.perms = this.setting8.perms==''?1:this.setting8.perms;
    	} 
    	
    	var picImg = 'data:image/png;base64,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';
    	var suImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAASE0lEQVR4Xu2dT3YTuRPHq/pnht9unFxgkvewt+M5AeEEE05AWGIvCCcgnABY2CyTOQGZExBOgGdr814yF4h7loCna546MYTgdktqlVrqLm8tqaVv1aclVesPgvxEAVGgUAEUbUQBUaBYAQFEvEMU2KCAACLuIQoIIPo+0B3PBoD4s06OdNh7r5Ouaprum/MdoOUvQDRIEuxWLa+p+bOMUkCcAnb+Tp/sXrhoZ+t6kJWzJQh7QNAlgAEQDBDB2PEuhz1W/bbfzJ8T0QEC7rgwdpvKIKIpAZyko/7rKu1mNXCVirnK23153oU7y/tJAntEtIeIA1dlcwGiejFEeCtgVLcUAV0QwcN01J/alNZYQLqTj48QaB8B9m2E0cnDAUh3PDtIEI91ni9p9BQggpSAnqWj/olejm+pGgWIevMmAE8JcN9myGQqnmtA8vojfjCth6QvV+AakgemPUkjAOm+me8hwXME2CuXyl0K14BsTWbnMqxyZ5/bJanh1mLY3zV5QtSA1AXGSmCXgMjQysRt7dNmRI9NhlpRAlI3GByAbI1nH1wGEOxdqNk5VXRrMer/ptvKqABREank7vI5ABzqNpAznaseRIWeE1qec9ZVyv6mQIadXd3vJNEA0p183EfIXoY0RncHyHwvIXgnTuxHgQzhQfqkd6bztOAByXuNn768BMQDnQb5TOMMEAnt+jQbNAaQ/IMZwHGoY3NXgGyP50eAoIaO8vOgQCMAyYdURMc+vmfY2kQAsVWu3nzRA6LWIAHBUb0ylj9dACnXKMQUUQOyPZ4dhzjfWGdoASRE9y+vU7SAxASHMoMAUu6MIaaIEpDY4BBAQnR9vTpFB0iMcAgges4YYqqoAIk5xClDrBDdv7xO0QAS+wI9AaTcGUNMEQUgasFh7MsrBJAQ3b+8TsEDopaP4E/L85A/ApbLHEcUiwj+JKAj041COu3nSnO9WvsIAe5zPCN4QLYm83e+NzdxCB16D5IBPEuHvVccbfdRJtf8NGhAupP5YQLw0ofAOs8ggr8BYIoA0wzoAhK8Oi4mo9TXW5fDEQjg/WLY87rDUkdv0zRbk/mZ654kWEBC2XOtnIcAToHozBcEmxyDAxATJzB1Wp/p1Zq8BOity2eaaON1uXudu+YI4B8keJUlnRPdzTIujeIbEFfDP18abNRnMieX9QgSkLqGVl/B+Nx5lT7bTV0K7aosjh5EACm2TnCA1Ba1IniRBQzGyoQCyOZXzXbTe5Dt8cdXgPTU1Ru3rBwC+osIDkKYX5TVVf0vgLQYEO8HEhC+vhzdC+JQBx04BJBylRrdg2xPZicA+KhchuopTM88qv5ENyVID9LSHsRX76Em4upg6liGVLfdQQBpKSA+eo/Y4ZAhVnkv3Mghlq/IVUb0W6w9h0SxyuHIXyBNjGJxDBtuyxnrnEOGWHpgfH2BNBEQ9pPKCV5cjnrBn3yi4wocLxP5UBjwh0LuNVfqO8di2Hd2U5SOE3OmEUBaNknn/DCYT8qxMwhtPVUVgASQlgHCObyKfY/DOlcQQFoECOfwSu3dWIx6jbvxVQBpESAcxl7JZ7IKs8qQx3deDs1kkh7oJJ1jB5hqatMm5jfNJ4C0qQdxHLP+2nsY3i3nuxeo8jwBpCWAcB3l09S5h3xJ13utNOZLOsebMJcwwiXseqa/SsWhm8xBApyDbI3np4jwu4lz6KQ1uXRRp7zQ0gggLRlicRzK0OTJuQyx9F5VzRlicUzQGz68kiFWOSSNAIRrc1QG+DAd3jstlzHeFDLEasEQiyuClX3qbIV6XI8rJAWQNgDCcKSoWpi4GPa6rhwx1HIEkBYAwmHkppwvWwYmh3YS5g0szMth5KZ//5AoVtmr4/o7kePgj8maPmdn8/IA0pxdg5tcgUM76UFa0YMIIHrv2B9TCSCBAcLxFb2Jm6PWmU16kIAn6Wp7LCH9avum+pqPYOD6SjUimgKi9YnsBPg6hm8oAkjAgOTnV939coaA1SGpTJnLAuiPy2H/wGWJXGUJIAEDoqqmtskiorrq6mcuJ/BZbmzrtwSQwAHJIWnAtcyqHfnVB5/u7MX09V0AiQCQ657kIEE89vm2d/msWM/p5QCkCUeyrkY3CeIHl35S6TsI55lWLhu5rqxYnYIDkKZ8ZOU4AL0SIMrxOCrlAY7H6ah/wv0cjvJZAFE3WSM8SJ/0zjjq7KNMjhtuVb1NdFn7JT26yFbk5/RyAZI7A9FhOuq/9uHQLp+x/Wb+HAhYzl6uDEg+9lPh35+WU0T4xWXD3ZcVTzi3qO2cgOSBC4IUEKbutecpEQH2eEq+KtUJIKsJUsjh39jCuXUBwulsMZbtDJAckkDDvzGGcwWQMHByCsh1TxJU+DfWcK4A0lBA8siW57vON0kZazhXAGkwIDkkHq90LpKyKdeu3Wwf9yQ9DLcMpxbOh1irptUe/o08nCs9SBiQsAGSz0dqC//GH84VQFoASB3h36aEcwWQlgDiM/zbpHCuANIiQHyEf5sWzi1yjy7DmWJhuGKYtWCdg9xuMmf4t2nh3EJAAv0YG6Z7V6+VV0C4wr9NDOcWAjKeDVzveajuRs0tweTF6+RcLOfh34aGcze53NZ4fhH+wtD4oTG9rcwJIG7Dv80N525yL86havxu7bAFhi9fZ4C4CP82PZy7ycxXvfDyoikHZzh0aWdF5UGfT50dk/MKnAJSJfyruj763BmYVN6ZcoEU1B3PgloUGogszqphM691DohN+Lct4VwdS4ew3k2nntGlsbypjAWQPLJlsPrXJOwWnWEsKizfRSxE25DFpudYFccGiG74t0rl3coYVmnqSjuk5QkC3A+rZvHUhgj+pKRzmD7ZvbCtNSsgpeFfy27PtrEx5lOgQPZlLwHcIYABIDT+xi1rOxGkCDDNgC7g851TF/NZVkC+hn/XRmfaGc61Nr5krEUBdkDWhX/bsACxFmvKQ50r4AWQHJLJx/0E6K2Ec53bUApkVMAbIKvwLwBM01E/mjOaGLWXoiNQwCsgEeghVRQFvlNAABGHEAU2KCCAiHuIAgKI+IAoYKeA9CB2ukmuligggLTE0NJMOwUEEDvdJFdLFBBAWmJoaaadAgKInW6SqyUKCCAtMbQ0004BAcRON8nVEgUEkJYYWpppp4AAYqeb5GqJAgJISwwtzbRTQACx001y1aCA2sIN/18O0ie9M1+PF0B8KS3PqaTA1cVNX95BvjefHvjaUySAVDKbZPalwPZ4dgyIB+p5RJDS586ui0MZyuovgJQpJP/XrsC6M9aIaEqf7zzghsQYkPwYGvr3foK0QwQDtd28dgXDrUCKCNOM8ALwf++rnM8UbhN5a7bpOFYCOF0Mew85a6ANyPVBZscIsMdZoSaXTQBnhJ3HAoqelbs6FwsRnVyO+o/1SjRPpQVIdzx7miC+Mi9ecqxTICM6TEf916JOsQLd8WyAgO9Q46A8ztM5SwG5OTkSgzpUQE6VLBTz+kTODwi4o6t4BvgwHd471U2vm24jIHIcv66Mduk433x2Nao/1yqci4hqfqv9yyNbDOHfQkCuKro81+nitFshCb9TwGe4Mhbpq4xYOPQsBGR7PD8ChOexCBttPQ2vBIu2nRoVN7kyo6g41+HfQkC2JrNzkzGgRvslyRoFCOhiMezvtl0cl8N5l+HftYCoCIJcS+zPZU2uJfZXK39P0grnmlbHURBkPSA68WfTCkv6QgXafMOWSTjX1IVcBEHWAzKZHyYAL00rJOntFHBhSLsn15vLJpxrWuOqL5+1gMgE3dQMFdO3cKJuG841Vbpq+FcAMVWcI30LAakSzjU1gQqE0Kc7v9ksbBRATNXmSN8yQFyEc03NYBv+FUBMleZI3yJAXIZzjU1hsbBRADFWmSFDSwBhCeeamsMw/CuAmArMkb4FgHCGc01NYhI1FEBM1eVI33BAfIRzTc2iG/4VQEyV5UjfYEB8hXNNzaIb/hVATJXlSN9gQHyGc01NoxP+rQUQAvhHXQdt2qAa0w8Q4Ge25zcUkDrCuaY2Kgv/egckA3iWDnvRbd9lXV3QQEBqDeeaU1K4r90rILoTI9P2+UrPFqZsGCBRrgYvCP96BIT+uBz284O/Yv5tT2YnAPjIaRsaBEhI4VxTG60L/3oDpCl7Hljejg0BJNSIlQkot0c53gC5HPZKT1AxaUidabcnc3L6/IYAsjWefTA9bMGpjg4Kux3+FUAsRBVAfhQt5HCuqYlvhn8FEFP1AEAA+V401gifhX1cZFmFfwUQCzUFkG+iRRXONbU10YkAYiqa9CAWihVn6TJs7yaCPxej3r6LigogFipKD2IhWkEWluGZw6CHAGJhawHEQjQBZLNoEubdoI/DN5471/VTEst6LYd6Sg9i4QfSg1iIVpBlazI/Q4D77kpUd7TBi8tR78hFmQKIhYoCiIVohYC4P+LW5YJYAcTC1gKIhWhrsqilKcnd5cJNad9KcbkoVgCxsI4AYiHaOkAmH/cToLduSrsJSGfX1TV3AoiFdQQQC9HWZGGZoAOAy4CQAGJhawHEQrQ1WTgWNxLQX4th3+h2qk2tEUAsbC2AWIh2K4u6NTmh5Xn1kr4vgQDeL4Y9ZzcxCyAWFhJALES7DQjDEpP8EQ5DvKo4AcTC1gKIhWi3snDdYOYygiWAWNpZALEU7job295+xxN0AcTSzgKIpXDX2bYm83cI4GyesKqN6/mHAGJpZwHEUjgA4Ow9XM8/BBBLOwsglsIBAFfvoWrkev4hgFjaWQCxE45z96E6rXMx7HXtalacS6JYFooKIOaiXR0JtDxHBOdOfFUbnnPXBBBzW8uhDRaabU3mbxHAyTbYdY/nOndNALEwtvQgZqJx7Du/WQMi+Hsx6u2Y1UovtQCip9N3qQQQfdFYTqK8/XjDa9X0ay9f0k20+ppWANGTzdc5vRm6W95+u2XSg+jZWnoQQ518wcE1OV81VwAxNLxKLj3IZtH8waG+ffD1HqqVAogAYqFAcRb1pRwzeMsXzv32bJcHxBW1SACxcA/pQdaL1h3PniaI3m4P4/hyLnMQCyBuZxFAvlfk6prn5THnd44fzcbzYVAAEUAcKPCtCNVrIOCRjyHV6qlqWQlhZ+DqYIZNgsgQy8JdpAcB6E4+PkLKDmu5MMfxrkEBxAKCTVnaCogaSsHdf39HyI4QkOXLdZmpOL+ar3u2tx4kA3yYDu+dlgkQ+v9djrOcPL4RTfXNobizvJ8g7RPgvs+h1Lq6+piY33yuN0AI4Gwx7D0wNVBo6Vn2MwQCyFUPsfwVAHcSpB0i2OPY+WdtU8YlJbWHefMKIBxdPum9sBao5ozbb+bPgcDJocjfNYUZEOdDwhrs4Pq8K90meOtBbkQgzgjgKB323utWsu503cn8PgIcsb1NBZCNJvYZtaotzFu3kwf9fAFko3kyosfpqH9Shw299yB1NDL4ZwoghSZyeZWBjR8IIDaquc4jgBQo6udr+SZzCiCund2mPAHkB9V8LETUMZUAoqMSdxoB5FZQj/6iT3f20me7Kbf0ZeULIGUK+fhfAPmqsuo56HPnIAQ4VKUEEB8AlD1DALlWqP45h4R5y5y1jv8FELZzraqaU3qQqgq6yN9yQOoO5UoUy4UTc5bRUkDyL+REe+moP+WUt0rZa3sQlhWrVWrZ8LzcK51DXIulriqgT539UCbjRS62HpA3872E4F3D/TKY5nEv4Q4JkLzXuFqL523vehVDFwDCc8FilYo2OS/30TWhAJL3Gtg58LFV1pW/rAVEFb41mU0R8FdXD5Jy1ivgYxl33YCoXYCEeBjjhrlCQDjvchBYvingY6VqXYDkYAAd1bUS14WfFQKS9yLj+QUi/OLiQVLGjwr42l/tG5AmgLGy1kZAvJzM3VJyfIY4fQGSzzGITmLuMW6740ZAVGIZarkn+BqOQ1+OxAmI6i0Q4CRLOicxTb51rVoKyDUkAwQ8leGWrqzF6a6HH/s+P465BETBDQRnhHAGRGc+21FdffMStABZFbs9nh8R0r5Et8yFVtEqAjypI/5vC0gOA8AUCacZ0gUgTNMnvTPz1sebwwiQVTO7b853AJY7QDBIiOtSxnhFXdU8Q0iVUwF0LuocfqgX2yY1M6ALSPDiZpq2gVCkjxUg8buutEAU0FNAANHTSVK1VAEBpKWGl2brKSCA6OkkqVqqwH+LqVscGA7ZeQAAAABJRU5ErkJggg==';
    	var prImg = 'data:image/png;base64,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';
    	var dirImg = 'data:image/png;base64,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';
    	var urlImg = 'data:image/png;base64,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';
    	var noImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAASjElEQVR4Xu2dj9UVNROHZytQK0AqECoQKhAqUCsQK0AqECpQKhAqUCoQKhArUCrY7/zeneVbL/e+NzOTySazk3Pu8ci7m81O8uz8ySSZKEszCcxEXxPRl/y7R0Sf88PXf9u25T0R4YfyLxG95f9/PxG9adbogz9oOvj7u73+vAz+b4joAf8AQc0CeP7g3+tpgShLZQkkIBUFOi/a4VsiekRE0BAtCzTMKyJ6Of1f87R8fshnJSDGbt1oiu9YUxhrrHI7NMuvRJSaxSjOBEQpQAbjByJ6svEllLW53Qaz6zkRvUgTTCfjBEQoNzajnrIZtTrZwlqaXw5QoFEAyur4N2/EiA9MQAp7baMxfiq8pdfL0P7UKIW9k4AUCGpeIlG/cHi24I7uL4EW+X5aomBZbpFAAnKLcFhrAAxEpSIWRL0ASoaIL/RuAnJBMKw1fuvYAa8FLOB4nNrkvDgTkDNymYnghI/ua0gB+mkieia9Kfr1Ccimh9mkgtaAz3HEAp8E2iRNLu79BIQFwXD83ngGfM2p2uZdrWBu87MwK/9ZI2IxI/8wIVmknYAQ0bykhcAZ90wPAQxr7tRbzQBkvwhtXPO7vKABJHDe8d9Dl8MDwnBAc3hM+r3GBN205EhVL9x2pLggynan8gNgZkGTHBqSQwPiBMffnN4BMJrZ8qxdkPaCDOJa5fCQHBYQB58DYCAShJSO3QqnwiACh6ziGuXQPskhAakMxwcGA0mB3RQGBbBikZa1HBaSowICn6NGKBc+xnctTSnpSJ8X/wSgWB36Pyaih9Lnj3794QCZlwlATARaCrQGwHBxvi0NO3cva0y01apNnk0Hm0A9FCDsyEJ7WMo7RI1GTBufl7UrP1teniNbh0lyPAwg/BX9yxjOfYkFUj2bVNcGfwWTC5GtuyPL4JqMtn8/EiBIIbFk5WKtN+Ychi8c3oYW0Polryaix8MLouAFDgFIBdMqDBzrmKgACSYRw5ta4QFh0+pPw2KncHBUggT7c90t+AgPfckRALFErbAriMUs635wsE8C81NTwke1QgPCk2VwzDUF0aoHR3BGjdEtOOxhN4KIDggmyDQpF5jnAByHSdSbF39CM0+CDSAQPg5ZwgJiDOsi1XvXnKrWo43lBU0gjWyFDvtGBkTre4T3Oy7BZ/BHwvoiIQExaA+YVvci29TXNJPS1AqrRaICggk9rBCUlrBfwlJBGAIbIc3SqIBosnX/npbd2Q9f5sX/kgY3Qmb7hgMkv4B2vg0yDBfyjQiIxjn/MPmsSbeP1p1qmJdUfuny3XAmakRAkFYi3Z0kXMdauVLmr2G3lvvWZ/d0fyhAOHr1j0LA4UwDhQw+uWVeZsilu6V8ESn7IBogmujVYec9rkE0L4fv4JAgScHOjEOstCx5qWiAaKIvIcOTJZ1/7RpOiYfJKimhsp+jAYLERGmoNpRJIBnJJdfOy95ekvSTUGnw0QCZSzp9c82bqc7uJsLHjnO5Jpo1BdrSNgwgyqhLRq+usKpMhQ+z2jASIBoHPUxHeukk5YcnjF8XCRDNBGGGdwvImm82wBeVMJo5EiDimd9ItrJo+AovVjjqYULnkQCRrohLB70QFEUKfBjZJiCFg+TIlyUgAXp/JpLOgYSa0PLsQkX6e5icrEga5LCOpCccqFuz4XcU/y4B8R5dAepPQGJ0YmoQp35MQJwE27LaI8fqveWcgHhLuEH9CYifkBMQP9k2qzkB8RN1AuIn22Y1JyB+ok5A/GTbrOYExE/UCYifbJvVnID4iToB8ZNts5oTED9RJyB+sm1WcwLiJ+oExE+2zWpOQPxEnYD4ybZZzQmIn6gTED/ZNqs5AfETdQLiJ9tmNScgfqJOQPxk26zmBMRP1AmIn2yb1ZyA+Ik6AfGTbbOaExA/UScgfrJtVnMC4ifqBMRPts1qTkD8RJ2A+Mn2Y818rJf0rAlJy7Dtj6RgJ/hDnYUuEc7Jtdi1Ej9JeSC5WHgtzpPE2SXuxX1NOm9d+ZRyk2j3zjzYA/BBxA6O0g+jSEyugMxEPxPRE1GL8uKUgEwCrvsAuwGisVtlcsmrUwIfJXB/InrrIQ8XQAzHCHu8Y9YZXwIvJidLxQsQzU7r8bsx39BLAm57AXsBIt1I2ktwWe8xJDCcBklAjjEwe3lLt/NIUoP00sXZDosEEhCL9PLe8BJIQMJ3cb6gRQIJiEV6eW94CSQg4bs4X9AigcMA8tAipbw3lASeE9FXhW90DECinEpU2Kl52S0SEJ6LmIDkaDqWBBKQM/2dGuRYENz2tglIApI0pIklGwOpQWTyinx1apDUIJHHt/ndEpAExDyIIleQgCQgkce3+d0SkATEPIgiV5CAJCCRx7f53RKQBMQ8iCJXkIAkIJHHt/ndEpAExDyIIleQgCQgkce3+d0SkATEPIgiV5CAJCA0E33Oax6+JCL8tuVfWnYLbLZRc0/AJSAHBIR3nPyGN/LG7ucApLRgKyX8Xntts1nakBbXJSAHAmQm+paPD6h1JAC2/n9FRNgwrckxAC2g2D4jATkAIDPRD7y7/an5VHO84YwTgOKyeXPNhkrqSkACA8Jnovxyxq+QjBHptQDlx4kIvsvwJQEJCAg73QDj0U4jFHDgvAyYX0OXBCQYIDPRPSL6rbHWuATB84nox5EJSUACATIv5/fhNC1JVMp7/CLi9XhUkysBCQIIwwGzqscCx/3hiJAkIAEA6RyOVcJDQpKADA4IR6p+71FtnGnTq4no8SBtvWlmAjIwIDwj/mdnPse18e+2++C1B2v+noCMDQjgQNRqtOJ2GmxtQSQggwLicLz1a86xgq/w7zojznMqgBCRMaSoYG7ljnEgvp2I7hvraHJ7AjIgIBVNqw9EhN3LMV9RPPPNfg9OEP7aMEoxkYhZ965LAjImIBhYSDy0lGdSME4fxqBIjgfYVvF+IrpreYEW9yYggwHC2uMvw+CA1ng0LSnr5sImGCDRANu9FklAxgMEgxHZuZoCOB54ZNzOi7kkheSPiajrw4oSkPEA+ccQ1nWNHs1LciIWYknK3Z7XkiQgAwEyLxEkJCJqivv8A5tbWDj1maCBSI2HVuyyJCBjAaIxY/CGWE/uuVjqoxQVaS9YurtXWv5VKBOQsQCBc64Z6E2d4XlZfls8V9LzeSwJyCCAsPkC/0NTvpDMc2gesL1nXkwmSSChWz8kARkHEMxia5ISm5swvGgLaTClBanwVcLOpQ8svS4BGQcQLIbSrPdwd87PDbb5JhG2uDQ1AYtbldm850XVo01syL3aZfAJ/ZBdIC4BJTXIOBoEuU9PSzr15JpdzJdeBpZCXv+5pZf3mKwvckHNw64VJ9QF0yB7ASKZ0EwNcgWABOSKgAwmFjZMaLr9jmJCMwFJQGw6UjEBtz6w+eBT5GXt4ieV9EiaWOP4INow75tpWejUpPB8DSY0JVsP7WIGlggkARkHEMyga9Pcm00UKjVdThSmiVXyvbr9mnlZ9SdJBFwrbGbCzAvEknSYD5NM29gFKaghNcggGgTNFHbW9s2arLtQBhKaz/QL+JDK3M3fyyhWQa/NRE94a9GCqz+5xNXO5/QSpMJIfA80MtPdC3ozASkQknG5LTJssWCqeHOGgibdXMKOOeDQbEHUrf+h0NqpQUoHjdd183JAzVfK+n+diL5X3nv2NiMc7yYdVDVf4da6hGZtAtKsZy48SBkl2tZWzWE3woE2VWuLV78kIAM56RtzRrqs9fQtzed28HmHWPch9TnWtmADiS89TL6asCQggwHCkGgTF/8T2WIHWXym4Lyk3SP93lLczBFLo07vTUAGBIQhES1rvTBo4LDDcS8+obYSHM3WyFthSUDGBUSbenL6xi+nQm1gDDNvn+sacrZCsb0/ARkUENYi0rXf58YONqr+omRQKWbJz1WLo6IxnzNESUAGBoQhsYR9b96+dP2LcBntOQC6D+umD1Lw3SodMAVVuV/CoVYsDNPOjbQC5B1ve1p9otJTyKlBBtcgrEUsmb7FX3XjJGXXM+aXIEtAYgCi3fEEb1/sEyj2u9pKt/tJwXOQJCAxAFGtvSciTNbdKw3zci4YfB5Nyn3XWbupQQSG6kg+CJtYkg0STF91Q6pLcbRM0FXul6YGGVyDGLYkLZ7/OBPZ0W6i3WxlYy1yEpDxAdFMGJryoAxQDjNBuA6LBOSYgKi1x2bgaLRIAqJUbblgSik4PkhTuqm1ea8sxd5XeMMERNnPXoBos15djypTyujsbUpAzAN1r+fWlF1JXcLsAbNcL7WpN0DcXrSkUyTXKAeqeR24MnFxGLluTEnJLvVu79cbIGYTRDLILdcqHea9fJCholgK2Q4HiHaGeYjFPMqvHG4zzUkod08szvmyfDBq3qvQzm7pNF4aRBMChYzNX9iaHXWtLmEocq1O/RFQ7n/VdAvUazIr+bt0UtRzgtkFEAhB6GStchuqM5UDFlm1MAlES24N+18V53yVDN4W1wjl6jpmPAFRbdfp+TWo3bmKMwHXJoggMcBxhBCva66ZJyDaRD43h6s2IKwptWvUAQlWJuILf3atBvscOLUWKwE1u5gMswZ92zdC60NtspaMB09AtMtSXV+4RCiSa4TmwLmqAQcO2oHJtZpd2CkRv0dKMMz+jkQGNa9VOOiukU9PQNC5vymE93Yiuq+4b5db+Ctv3S/Lq+1DhXdZI0s/rK7v6AaIwVHHrW5hO4+RWEGLeDRrOOecx4zkGAdXBx3t8QZE64eYZ5w9RtylOlmLwDy60/K5tzzrb16QNdo6dJiVfwpk6G6OewOizckaysziL5927kcwHoovHSrQsb6VYmmx+3t6AyL9ImxHgPvLFw+3wgs7MbXcv6qF4hBdpsgSaHJClisg/GXV7h811Kz65iuoWa8hGky3XDykzHicSA8pauJjtQBE+uLb/h/KWd8ZkmHhUDjnuKXJ0ogWgGCCC5sbaMqwnd7Y3BoqqHE6EKS5V0TUbALUHRD+OmAi7BsNIa2+FMq23XobT3rB5PKKbiFa9d1EhGjhkIV9D0SuJCf0NvsgtALEEuFpclKs1+jiAYBoHlJGahVs/oAJNRzIM1Qo94z2kE4Mmja+kHZAE0BYi2jnRHD7kLsDbjuDN3/DOhn8tBoFGgMaaXgweExoopxNo3QtAbFoEfGBM9IvRcvreeMFyAMD5Osrz35Diwn1Spoi3/KdNM+al0lByQm9TbUH3qkZIBW0yHCTh6WDhs2w04GC9x3afLrt/RWTgqiuqfbYAxCLFkF7m8S+Swd2XqeTgHLrItF+xrqWfXpXUw3CWsQS0Qrhj9TqvBHrMSz+aha52sp1D0AwL2JNDx8uDWXEwVy7zYp0krUJxWep1G5zc0BYi1hm11GFaMlqbaFlfXIJMBzYiVLilK8P2u2DuAsgDIk2R2sVWkIiH6e73GGEY1e/c09AMHOqPRRmCwlsU8wNZOlQAuxzYGWpZKb8o2m19/mKuwHCWkS7LPd0KDyZiF50OD4O3SROtQEcmg0nELV6sPfcz66AMCTSVINLgw7RMcy4h507GIm2megpESHFRlu6yJ7YHZBK/sjaCYiOYZcL0aZs2h7M+z6VAKfU/IKvv0E+3WRx9wIIVLDpzPGTzoBWwqxrahPDKJXeylpDu4fXR79j0kW6pM0tur4LQFiL1Jgf2b404IBv8rJIEnmRWgLsa0BraBzx7XPf7e2UnwqhG0AYEsTIoUk0xx1f6mCYXT8lKOrxf/FGBgO+hsWc+qg5eoMDDesKEEdIUPW61SfsW0CTRSEBntPA4jc44FaNsbagi4jVOXF0B4gzJKsM4MRj7gQbHycsV0DZQIGwPH41C8yqR732Q5eAbHySmo77bSYYnoPf+4kI6y8OXXhyD4u6YDqt61Y8ZNKdz9G1D3LaOP5ytYDk9NEwx9ZQMTRMZC2D4MiaHwWTqZbZdA0ofIigObqONHarQbbSVS6uudZB+ff9JNB84ZP2VYcAhE0uqHrMlteMcGnllvfpJABnHFpjmF1YhgFk45cAkmvruHXdl3d5SmAIk2ooH+RSb/FGY5gtT23iOaTr1A2tgXko9NdwZSgNcuKXwLmsvd/UcB3YeYORxYBshq4d8dtkOCwg60txSBJfpzS7+qEF4VuAMYyvcUl0wwOyAQVOPDZl+7afcXK4lsDPgDk1PBhrz4UBZAMK4vgwvRKUdnyGAyMsIBtQ4KMgLQJaJc2v+rBgG1REFLENatiJ1HAa5Nw44EU8ax5RwqKHBVDAfPo1khkV2knX9DWnaa95RgnMZSEiRHuzLzD+G1lThHfSNaCc+C3wXQDNNjcJl+DftbuxW5rV4l5ohK15dJOwyb/QewOXCvd/GFTcFLZy7QoAAAAASUVORK5CYII=';
    	var okImg = 'data:image/png;base64,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';
    	var dbImg = 'data:image/png;base64,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';
    	var usrImg = 'data:image/png;base64,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';
    	
    	var div0 = $('<div class="exam_insenablediv0"></div>');
    	var div1 = $('<div class="exam_insenablediv1"><img src="'+suImg+'" width="25" height="25" align="absmiddle"/>EXAM v1.0 - <img src="'+picImg+'" width="26" height="26" align="absmiddle"/>TanLin <span>考试系统安装程序（Install step）</span></div>');
   	
    	var div2 = $('<div class="exam_insenablediv2"><img src="'+prImg+'" width="21" height="21" align="absmiddle"/>检测目录权限</div>');
    	/*
    	var div3 = $('<div class="exam_insenablediv3"><img src="'+dirImg+'" width="21" height="21" align="absmiddle"/>'+exam.dir[0]+'<span>'+exam.perms[0]+' &nbsp;  &nbsp;  &nbsp;'+(exam.power[0]=='0'?'<img src="'+noImg+'" width="19" height="19" align="absmiddle"/>权限不足':'<img src="'+okImg+'" width="18" height="18" align="absmiddle"/>')+'</span></div>');
    	*/
    	var div3_1 = $('<div class="exam_insenablediv3_1"><img src="'+dirImg+'" width="21" height="21" align="absmiddle"/>'+exam.dir[1]+'<span>'+exam.perms[1]+' &nbsp;  &nbsp;  &nbsp;'+(exam.power[1]=='0'?'<img src="'+noImg+'" width="19" height="19" align="absmiddle"/>权限不足':'<img src="'+okImg+'" width="18" height="18" align="absmiddle"/>')+'</span></div>');
    	
    	var div6 = $('<div class="exam_insenablediv6"><img src="'+dbImg+'" width="21" height="21" align="absmiddle"/>MYSQL数据库设置</div>');
    	var div7 = $('<div class="exam_insenablediv7"></div>');
   	
    	var li0  = '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">HOST ID：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="hostid" value="localhost"/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">DBName：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="basname" value=""/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">Sign in：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="sign" value="root"/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">password：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="password" value=""/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">Table Prefix：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="prefix" value="exam_"/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">Commonly used engines：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2" style="line-height: 2.9rem;"><label><input type="radio" name="engine" checked="checked" value="MyISAM"/>MyISAM</label> &nbsp; <label><input type="radio" name="engine" value="InnoDB"/>InnoDB(支持事务)</label></li>'; 		
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">Commonly used start-up：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2" style="line-height: 2.9rem;"><label><input type="radio" name="start" checked="checked" value="1"/>mysql（常用经济型－低耗）</label> &nbsp; <label><input type="radio" name="start" value="2"/>PDO（对像重量型－高耗）</label> &nbsp; <label><input type="radio" name="start" value="2"/>mysqli（对像新能型－高耗）</label></li>'; 				
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    		
    		li0 += '<ul class="exam_insenableul0">';
    		li0 += '<li class="exam_insenableli0 exam_insenableins1">Coding format：</li>';
    		li0 += '<li class="exam_insenableli0 exam_insenableins2" style="line-height: 2.9rem;"><label><input type="radio" name="coding" checked="checked" value="utf8"/>UTF-8</label> &nbsp; <label><input type="radio" name="coding" value="gbk"/>GBK</label></li>'; 				
    		li0 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
    		li0 += '</ul>';
    	
    	var div8 = $('<div class="exam_insenablediv8"><img src="'+usrImg+'" width="21" height="21" align="absmiddle"/>设置后台帐号</div>');
        var div9 = $('<div class="exam_insenablediv9"></div>');	
    		
        var li1  = '<ul class="exam_insenableul0">';
			li1 += '<li class="exam_insenableli0 exam_insenableins1">管理员帐号：</li>';
			li1 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="admin" value=""/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
			li1 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
			li1 += '</ul>';
			
			li1 += '<ul class="exam_insenableul0">';
			li1 += '<li class="exam_insenableli0 exam_insenableins1"> 密 码 ：</li>';
			li1 += '<li class="exam_insenableli0 exam_insenableins2"><input type="text" class="exam_insenableinps" name="pwd" value=""/> &nbsp; <font style="color:#e83232;">*</font></li>'; 		
			li1 += '<li style="clear:both;margin:0;padding:0;list-style-type:none;"></li>';
			li1 += '</ul>';
			
		var div10 = $('<div class="exam_insenablediv10"><input type="button" value="提交" onclick="exam.OnSubmitSend();"/></div>');		
    		
    	div0.append(div1);
    	
    	div0.append(div2);
    	/*
    	div0.append(div3);
    	*/
    	div0.append(div3_1);
    	
    	div0.append(div6);
    	div0.append(div7);
    	
    	div7.append(li0);
    	
    	div0.append(div8);
    	div0.append(div9);
    	
    	div9.append(li1);
    	
    	div0.append(div10);
    	
    	return div0;
    }
    exam.CreateCss8=function()
    {
    	if( this.setting8 != undefined )
    	{
    		var width = exam.isEmptyObject(this.setting8.w)?'100%':this.setting8.w;
    		var height = exam.isEmptyObject(this.setting8.h)?'100%':this.setting8.h;
    		var power = exam.isEmptyObject(this.setting8.power)?'0':this.setting8.power;
    	}
    	else
    	{
    		var width = '100%';
    		var height = '100%';
    		var power = '0';
    	}
    	
    	$(".exam_insenablediv0").css({"border":"1px solid #eae7e7","margin":"0","padding":"0","width":width,"height":height});
    	$(".exam_insenablediv1").css({"border-bottom":"1px solid #eae7e7","margin":"0","padding":"2rem","font-family":"Microsoft YaHei","font-size":"2rem","color":"#1296db","background":"#f3f4f7"});
    	$(".exam_insenablediv1 span").css({"float":"right","font-size":"1.5rem"});
    	$(".exam_insenablediv2").css({"border-bottom":"1px solid #eae7e7","margin":"1.6rem 1.6rem 0 1.6rem","padding":"1rem 0","color":"#695f5f","font-family":"Microsoft YaHei"});
    	$(".exam_insenablediv3").css({"margin":"0 1.6rem","padding":"1rem 0","color":"#655e5e","font-family":"Microsoft YaHei"});    
    	$(".exam_insenablediv3_1").css({"margin":"0 1.6rem","padding":"1rem 0","color":"#655e5e","font-family":"Microsoft YaHei"}); 
    	$(".exam_insenablediv6").css({"border-bottom":"1px solid #e57cb0","margin":"1.6rem 1.6rem 0 1.6rem","padding":"1rem 0","color":"#e57cb0","font-family":"Microsoft YaHei"});
    	$(".exam_insenablediv7").css({"margin":"0 1.6rem","padding":"1rem 0","color":"#655e5e","font-family":"Microsoft YaHei"});   	
    	/*
    	if( power[0] == '0' )
    	{	
    		$(".exam_insenablediv3 span").css({"float":"right","font-family":"Microsoft YaHei","color":"red"});
    	}
    	else
    	{	
    		$(".exam_insenablediv3 span").css({"float":"right","font-family":"Microsoft YaHei","color":"#38c10c"});
    	} 
    	*/
    	if( power[1] == '0' )
    	{	
    		$(".exam_insenablediv3_1 span").css({"float":"right","font-family":"Microsoft YaHei","color":"red"});
    	}
    	else
    	{	
    		$(".exam_insenablediv3_1 span").css({"float":"right","font-family":"Microsoft YaHei","color":"#38c10c"});
    	} 
    	$(".exam_insenableul0").css({"margin":"0","padding":"0"});
    	$(".exam_insenableli0").css({"margin":"0","padding":"0","list-style-type":"none","float":"left","padding":"10px 0"});
    	$(".exam_insenableins1").css({"width":"240px","padding":"20px 10px","text-align":"right","color":"#bbb5b5"});
    	$(".exam_insenableinps").css({"border":"1px solid #eae7e7","width":"32rem","border-radius":"0.3rem","outline":"none","color":"#5d5555","padding":"8px 10px","font-family":"Microsoft YaHei","font-size":"17px"});    	
    	$(".exam_insenablediv8").css({"border-bottom":"1px solid #eae7e7","margin":"1.6rem 1.6rem 0 1.6rem","padding":"1rem 0","color":"#695f5f","font-family":"Microsoft YaHei"});
    	$(".exam_insenablediv9").css({"margin":"0 1.6rem","padding":"1rem 0","color":"#695f5f","font-family":"Microsoft YaHei"});
    	$(".exam_insenablediv10").css({"margin":"0","padding":"0 20px 40px 20px","text-align":"center"});
    	$(".exam_insenablediv10 input").css({"margin":"0","padding":"14px 80px","border":"1px solid #dddddd","border-radius":"4px","background":"#289fde","font-size":"25px","color":"#fdfcfc","font-family":"Microsoft YaHei","cursor":"pointer"});
    	$(".exam_insenablediv10 input").hover(function(){
    		$(this).css({"background":"#ec2a0b"});
    	},function(){
    		$(this).css({"background":"#289fde"});
    	});
    }
    exam.InstallEnable=function(hobj,Sett,func)
    {
    	this.htmlobj8 = hobj;
    	this.setting8 = (Sett==undefined)?{}:Sett;
    	exam.func8 = (func==undefined)?function(){}:func;
   	
    	var html = this.CreateHTML8();   	
    	
    	$( this.htmlobj8 ).empty();
    	$( this.htmlobj8 ).append( html );
    	
    	exam.CreateCss8();
    }
    
    return exam;  
}
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
var exam  =  ExamObj();