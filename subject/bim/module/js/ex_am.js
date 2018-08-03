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
    exam.hosturl = window.location.protocol+'//'+window.location.host+'/exam/index.php';
       
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
    		limit = this.setting2.limit;
    		len = this.setting2.len;
    		url = this.setting2.url;
    		target = this.setting2.target;
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
    	
    	var vipImg = 'data:image/png;base64,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';
    	var closeImg = 'data:image/png;base64,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';
    	var showImg = 'data:image/png;base64,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';
    	var bottonImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXcAAADICAYAAAATK6HqAAAcLElEQVR4Xu2dT1YcR/LHI6pBWhqB98JvQO+3Mz6B0AmMTyC8M2hhdAKjExgt1GgnOIHwCYRPILybp+55wns3YnYjQVf8XhbdqP9kVlVWZlVlFV8288aqzIz6RPa3syMjI5kK/i0dnC8tLF4/lkg2RGiTiVaFaLVgd2gGAiAAAneeABOdC9E5M51yzGfXVwt/Xu6tXhYBw7aNll73NyOhpySybdsWz4MACIAACFgSYD6KmY4vf1k7tWmZW9wTUY/lNyLatBkAz4IACIAACHghcBpH/CKvyGeKuwq/RPevf8dK3Ytz0AkIgAAIuBFQK/nPC8+zwjWp4r706sNGh/ktYuluvkBrEAABEPBJQMXmhyI/XT57dGbq1yju33b7W8LyRoSWfBqFvkAABEAABNwJMNPlkPknU5hGK+5K2GOSt+7DowcQAAEQAIEyCcQRP9EJ/Jy4J6GYiN9hxV6mO9A3CIAACPghkKzgY3kyG6KZEne1edq5d/UeMXY/0NELCIAACFRBIInBf1n8YXKTdUrcl7u9IyJ6WoUxGAMEQAAEQMArgeOL3fXb80e34j7KY3/ndSh0BgIgAAIgUBmByfj7rbgvd3tK2HFAqTI3YCAQAAEQ8E7g9GJ3/YnqNRF3rNq9A0aHIAACIFALgfHqPRF3xNpr8QEGBQEQAIEyCCSxd07KC9y7+lTGCOgTBEAABECgWgIqNXKws/6AcWCpWvAYDQRAAATKJqBCM7zc7e8TJdUe8QcCIAACINAKAvyCVw77pyLyuBXvg5cAARAAARAgZv6TV7q9jziRitkAAiAAAu0hwMxnvNztSXteCW8CAiAAAiCgCEDcMQ9AAARAoIUEIO4tdCpeCQRAAAQg7pgDIAACINBCAhD3FjoVrwQCIAACEHfMARAAARBoIQGIewudilcCARAAAYg75gAIgAAItJAAxL2FTsUrgQAIgADEHXMABEAABFpIAOLeQqfilUAABEAA4o45AAIgAAItJABxb6FT8UogAAIgAHHHHAABEACBFhKAuLfQqXglEAABEIC4Yw6AAAiAQAsJQNxb6FS8EgiAAAhA3DEHQAAEQKCFBCDuLXQqXgkEQAAEIO6YAyAAAiDQQgIQ9xY6Fa8EAiAAAhB3zAEQAAEQaCEBiHsLnYpXAgEQAAGIO+YACIAACLSQAMS9hU7FK4EACIAAxB1zAARAAARaSADi3kKn4pVAAARAAOKOOQACIAACLSQAcW+hU/FKIAACIABxxxwAARAAgRYSgLi30Kl4JRAAARCAuGMOgAAIgEALCUDcW+hUvBIIgAAIQNwxB0AABECghQQg7i10Kl4JBEAABCDumAMgAAIg0EICEPcWOhWvBAIgAAIQd8wBEAABEGghAYh7C51a5ysx0X+J6VKEHtZpB8YGgbtOAOJ+12eA7/dnfnmxs7a39Prfq51htCnMm8y0CbH3DRr9gUA6AYg7ZohXAizy8+DZo6PZTpdefdiImN97HQydgQAIGAlA3DE55ggw09/qPxZZbcciP1w+e3Q22+nKYW9PhH4HbhAAgWoIQNyr4ew0CjP/OdhZ25zsRK2EqRMtOXU8bjyML2cFebnbU6vvp7b9X+yus67NymH/vYhs2PaH50EABIoRgLgX41ZpK524l23AymH/VEQe24zDxH8NdtfmBFzF36O489GmrxCeVdxJaElIvg/BnpBsUL4Gl5A8Mm8LxD1s/yTWNUXcabSZOot0udvfJ5LfGoB6ysTZXyFefy01DcbY3v8tnF3urV6q/7t82D8gkV+b+ipttxvi3gAPM9PlYGf9QZWmFlm5R8Q//bO7djJrZ1NDMqYQU5V+CH2souG70N+rDfZB3BvixaqFxlbcVX77YHd9bg+gqSEZNS2qZt6QqThnJgQ+TM9B3MP0y5xVOqFZefVhW5itNz2nOmf+S+Wla1bbtjH3Py5217fm+2lulgzEPd+HY+ngfCm6d/Up39N4qioCEPeqSDuOoxMaH7FsUzzfeuVuyG9vakgGK/f8E9bHPMw/Gp7MSwDinpdUzc+FLu7xl8UH4422Maomh2TyiPuDbs8qm6jmKeQ0vETDvy9/+b9zXScr3d5HIVp1GgCNvROAuHtHWk6HgYv78cXu+vbsmzd+Rcd8RCJj0Zo6Z1COl8Pt1bRZvvS6vxnF8i5cy++uZRD3hvg+ZHE3ZslgRdeQ2ZVupjqxPNhZ167MsZkarosh7uH6ZsqyUMXd9MFPCofJwlyNmSpwi8g5EZ8TJatutw3nKgwOfQzD+QVl9sph75MI+TkpHTqHhtkHcW+Iw/KK+03JXZ6r7aJeU3fi1H1DlV9c7K7th4gRIQM/Xomj4Xe6ePsoW+uNn1HQi28CEHffREvqL7e4M58NdtZ+0Jmx3O3J7H93FXfTB78kDFbdQnyscGkfTjsdvdztqVj7nd6LcCdcXg8Q9/LYeu05r7irQU352SWIu3Yj1euLO3RW+YYu80tlLotsC9E3DqanNT2+CTnp/vyHoeKIn1z+snY6O1rTM6FK8k1Q3ULcg3KH2RhXcTeFKFxW7iGv2hXJKsV9luO33f5WTKIyiH70OcVMYlvG+6au2lFXxqdbS+kL4l4KVv+d2oi7TnRLEPegV+1liJ3Jq2pTefh5cWM2z189f3N683qPWbaL1MefH9O8x+H7y8x48crB+VLn/tVHbKT6/5z77BHi7pNmiX3Zifv8T2nf4m5atdcRhzWtMH2Lncm9pgtKZp9XewAURdu2pZSn+knJXFnu9lTRNi+/FNJj7c2s8lnixzPIriHuQbpl3qjAxF27aq8rO6VOcWem54Od9QObaaQ4dYT2i4h8mujaloxIszkt/IMTqTberu9ZiHt97K1GDkXcVarlMBpu6FLj6li1K4g1i/ulCB/FEh/rrhdMc/Loy1DF5XPn4lck7saQGzKQrD62tT4Mca8Vf/7BgxF3w0q1rlV73eI+6UFW5wtEjoZfFo918XeTt0eZJ2r1nxlSSRV3DyeC0768lf1Ytef/zNb9JMS9bg/kHD8EcQ845zm82jbMRzFfvzAV29K5PQnXxHSQdn1dhg/mzjHknF63j6WFmXDJuS3Nep+HuNfLP/foIYi7aeOw/p/q+gySqjZUM5x4Gkf8Qpcrbmp3s/HK+7rsmrRbuXTnGHJPsIzrHFXWDzJkbGjW/yzEvX4f5LKgfnHXC2jyob939b7ekq9Bi3viXxWyGTI9zyvyN7V5Ou916YY2h9RyTa7RQ2lZP4F8Udq8zp1/FuLekClQp7irm+4Hu2sbOlRpH3qVLkm0sNoR2RChTWZS//vQP3KDuId50CbXSt7ENd0X8+UlbFnr9g1wGtWWYhjPQ9zD8EOmFXWJe7LB9mVxVXtA59WHjU7E70yHWXQ2p61IMyEYH9CLu8/UwOK2GVsaRX7p1YeNiPm9rmXZMffxmCr8k2QBfVl4Ed2/ekNCc1colsAEXXokAHH3CLPMruoS97Sf6mlX6JlEqJxVYCPF/Wa6qI3XzwvPJ78801JKqxL3W5EnOq835Fbmp6rdfUPcG+LfOsSd4vho8OyRtiZ7jhhshRdmN1jcE32nSxLaH+yuv8zKSKla3Bvy8YCZGgIQ94ZMi+rFvbdnOnmZFjb4irNKwa1uLHVyszOMV4VZhSky89JtplcS7yZZTavZYvxFlBLKsbEBz7aHAMS9Ib6sWtxVnRIWOZldud+kxF2/ExHtBusYp+nqPdd0Pb27qhH32RzwhMXil60yhN40Lc3hLtxl2pCPcmVmQtwrQ+02UNXifrsZyXx0sbP289j65cP+G5KklG3qn66w2KgM7tustvb/Xr64p4VDlL2jPPBtEt5OO4Rk/27TLSDurgTvTnuIe0N8XZu4Kz4jgc+KB49Rmu5VXS4pNdF0qtJXtkxaxpBu+ozCVntMtFXCpR3avYw6yz805CN058yEuDfE5bWKeyLwdGKRDmfYTO2/zwrnFHGHqYKhL3E3hZiybPVfyz1xhPbO2vpPCWfRwL9XTQDiXjXxguPVLu4WdutW0uWkQN4YVba4c5IOyCdFKj+OsSUlBTjacw/ZhH8a12Kq4NESCUDcS4Trs+smibsuN77MlaVZ3HuffN8W5Cr0LrXcb+YTxN3n56rNfUHcG+Ldpoi7ik8PdteXZrEud3sqXz533XIbt5jEvZzMnK+W3aQu8sHwc+cPmxK/qoeiIm+6+i7HuQMbpHi2BQQg7g1xYlPEnYhMh5eyVtHHccRHUSzvbF1Sl7iP7UyO6quwTRy/LHJhR1aZ30keZYegbNnj+XAJQNzD9c2UZU0Rd2283XDARq3yhfggjq6PxnXPi6zw6xb3mSmUqzDYuI1tVU2Ie0M+sAGYCXEPwAl5TGiKuOvy200plLoQQ5GN17JK4Obxi+kZFZsnjvYHO/86TuvHNj3U9K64IcnFW+1sC3FviF+bIO6m/HZTSqISwMHu+neu8Xlt9clAjuOniXyR3PQQv8ga8hG6c2ZC3Bvi8iaIOxHNXXd3k+t99cmEWRdmyFe75muP+tLCYR3HVyLPxM//2V07STZUC1xyYqrlnsW4IVMcZnomAHH3DLSs7pog7rrDPjlKDpxe7K4/meVmcwCpCeI+8X5JTD5S9dFFfrWZLyg9YEMLz0LcGzIHbMRdJ7KmEIBJMGzEdYww/rL4YDYlMM8GqW71nuNLIRnWlHpZJOQR/FRgfnmxs7Y3a2deVsG/Hwz0SgDi7hVneZ3ZiLvuoIvpEJFHcS+aAqmgGVbvvfOsa/lM9rdT8HCAqbxPWPt6hrg3xKeu4m68k5P5z8HO2qZLWCRZQTM9n63/biOwulOteQ7mmMQ9T9uGuP7WTGPKZ0kF2ZrGB/ZOE4C4N2RGhC7uuhRIqzQ/Tcghz0bhnRJ3kR90h6SKhNAaMu1hpgMBiLsDvCqb2oi7bhVd5srdlMVhk3utTnkOdtYfzDLNEbPXhoNytJtzn/qiGN2E9LBK3+YdK+Qcd5UGS8KX7oXR8tLAc1kEIO5ZhAL5dxtx1/18L1PcSbfqLpBnrj/UlJXS6O+ijlnGKiWTOtFcnZy6psTlL2unurHV5nEINrVyE7susB7Ghbh7gFhFFyGLuz5eXqhQmGlTNmVjtTxxr8KvbRoD4h6WNyHuYfnDaI2duA+/G9dqGXdY1srdfCq1WLld+9i9Qdy7vY9CtGrjXlPYw6aPu/wsxD0s70Pcw/KHF3HXiZSxBIBztsy8uLrUbtfm6KeEeHxexA1xd/swQNzd+PluDXH3TbSk/mxW7lWKu3al3e2pI/Y/ZqFQq34RUjXRz+KITk0xZdXPSrd/ptus81kREuKe5bH0f4e4u/Hz3Rri7ptoSf3lFXdj5sqh/v5Sp0NMuo3U1/9ejeLOx1kMahwROWems6G65OJ/C2c2F1yYKktqa9MYbMhyDcQ9ixDE3Y1Qta0h7tXyLjxaXnHXFe9Sg5puJSoq7sZ26q7QKNoWodOI6Ow6uj6bjf8XgWAqBawreVB0BclM+0K8SiLjWH1tWSiTjHS/jpJfM4e9PRH6vQhPH21urhyk85u++IyYlkhk20ff6MOdAMTdnWElPeQVd+1lGSmVGW3FfXzBxsXu2n4lLz4xiC4007CiYUWQzVXaHHdic46gyMBo02wCEPeG+C+vuOvDFCm54oZiVKYN2LJDFw+6vccR0+bw8+LL+SJk/X0i+W3sMlPRsLpXtD6nlGnVblsW2adN6KsZBCDuDfCTKY6uS2/Ubqa++rAtzG/0r2oqRqXfFNXltBdFqEItC8OF72OmTSLZIFL/O/qRL/Lz4Nkjdan27d+soLW/9IDeNwpIkRO4Rf2Eds0kAHFvgN/yipjNl8DX17arNKg7RZoHoRLmBYoeSiQbIrTJTOp/005/asMRK4dfK0WaueTL1sljd13PqEyi4efFDd2mc5GrCOt6D4xbHwGIe33sc4/MzGexyFwdbxW+EKHJ2LdBEPunIvJYOyDzkYhMrZDVc8y8rd8cM68mVTslPBx3Hia2EW0w8apIsiq3+st3BZ+/06lWxlXwcNovpNlVuwpPEdNlVnnkCszGEAERgLgH5AxXU0wHelYOi50W1dkzuVpWVRv53tX3oy+ZPKtxq1fUxZunywibxN3f+1oZ7OnhtF9HulX7+PlRlpDKVnnqyRR002ACEPcGO2/SdOONRAUKeKUhUdUbhfiERdTK3Op4vy3qWZFLhE0Wfhv/ovB5gMnWttKeN2xwj8db7vbeTe1NaE4YJ/ez3r9SIq9SJYOscFkaP3R8SwDi3p7JYIpRz+VCq9j8UOLtTsQqrFNbnnQO9Mk7zYr6uJ2Py7Vz2FDlI8a0R2WErqyDKZtmbDRW81W6L6yxIO5h+aOwNeaQzGy8fTqUEfJFD8khGaYzUpdJa/7alOOuO58w+cpqQ7oT8bvpTej0/Y+p9slZh+s9JtkTom8KTzQ0bAwBiHtjXJVuqP6k5tdSAEn2RSxbszf5JD/h712pk4aN+sAbq1Gmpn2G52wVThtGvJVWV2fko/ezYbCsVbvpbdUvAOJoDxdrhDcffFoEcfdJs7a+jBuLUyEZU4za5q7T2l5xZuC86aGh2Guw44/4y+J2Wo2dm/j59TtjxhHTSRTz0T/P1v6wfddRyEZlYWUWebPtG8/XTwDiXr8PnCxIy4eePZ6uNkOHnxe/04mJ1X2nThb7amw8fKXSOoPOFlFfTEOm/bTVuqKUKewTKFUIi5iOdCd7s4iPMnD2mWirab/gst7tLv87xL3h3jetxo011ZlOLnbWf9K9tqmsboiITOmCQe8h5BR1W2Gf8w/zUcx0nPXlMdvu5kJyxOVDnO9FbIK4F6EWThvttXTKvNmUuUmTTZt3yaYd82kTVm8plRI/ZZx8rdx7eVfqY8NGfnjrmmqqDr8R8cFg51/HNi8NkbehFe6zEPdwfZNqWZLO+GVhUxdiyYqhp4ZnutPFuULEY9pMHX2pSUA2H8ciB7Ob2Gn2rXR7vwrRgc93SEI2RAfDL4vHNjX0kS/v0wvV9wVxr56584g3GRbDDV2d9NEH8mPm6rXZ4RltPnjROu7ODpnoILldivgk5usDmzr2o7i3Ku5WWg159aWeiLym4mYWgyTDJuJ9HIrKIhXOv0Pcw/FFbktS644c9t6a8sJnBzDlxodeTtZ8b2o9vzpuatzTie0qfeyPlcOeKmOsMpvSCqnlnh+5Hkzi8tcvbL6AVL8Q+Vx0g3gI4h6EG/IZkRSIEtmbLYU7bp0VjpkdxVScKwlvHPYPSOTXfJZV95SpzEIiPIarBMuwbiTopxHx0T+7a+rOWOu/lcP/PCWJ911j69YDTzYoKPKq3DQORDmRL70xxL10xH4GSEIxIpum+K3+BGOesfUphaPwzpmvn+Fqj0BVLiShJZfDM8ZfGwXvTc1DSD0zvsybmU6HsZzaxNFnx1Dho04sb2oV9blvevuVPDZe886eep6DuNfD3WpU0+nScSc2+dDzn2lz7rvPGPbsrwQVYyZaWO0M41XhaKIAmWww81x4Qt3JGkfXR6Ywgs/LK8ZfRGpMlvh82IlPbcMXc4KeHEYa/lj7Sj1r5hVYyScif/96P8Rfelmv2+Z/h7iH793MU4xpaY85X89YsGq56+/iC5+3OE2+l+vlFeqLZxjxz0TX564iPr9KVyUgFn5lFnVpeHUx9ZyONz5WRORvfj2pTB+ceHXl76E9xN0DxDK6UGEYJt7OiucuH/bf+Lhx3lQ7XVje+BOl/IWubJh6+HJTYZfng511bymIKp4uFG/l3dy2ed+qni2SXePDF1W9X9vHgbiH6eHM1boy25ewjxDcrt5HP7N/9/GlMYnXVA/GxQW6e2SL9meK5+ft79tX/R/jiLaYZMvfF2Le0ct7LhF5of3B7vrLtFHadDF5eTSr6xniXh3r3CMlYQKRn9I27TwLe2KbWr0ncfCSNvvUicnBztoPuUFkPJisjiWeuyKwaP9ph7tMfSaCzupO2IaFXQpAGoevdGUNVGisI533bfpSK4AoqCYQ96Dc8dUYJTQs/PNsWOYmQ+HqbRmHXZT4Frnv1AahjA7pyJfFv2xOS47HuMnBj54mq+MyboLKuAlpVBrgsVBSY760A0c2TGt49jQWeT65+EA4pgYvZAwJcQ/PJ1MWTRYGCzKFzhO/0ReLOkGZ9leJmI73H6buiE0u+04uJG/Opqgn3xi7UZuunxeeq2JjRKIOYuEvIAIQ94CcoTMlCRXE8qQT8Y8itB+4ua0wLym4JbJUyi+DVhCa/oWJL7wwnQpxD9MvsAoEQAAEnAhA3J3woTEIgAAIhEkA4h6mX2AVCIAACDgRgLg74UNjEAABEAiTAMQ9TL/AKhAAARBwIgBxd8KHxiAAAiAQJgGIe5h+gVUgAAIg4EQA4u6ED41BAARAIEwCEPcw/QKrQAAEQMCJAMTdCR8agwAIgECYBCDuYfoFVoEACICAEwGIuxM+NAYBEACBMAlA3MP0C6wCARAAAScCEHcnfGgMAiAAAmESgLiH6RdYBQIgAAJOBCDuTvjQGARAAATCJABxD9MvsAoEQAAEnAhA3J3woTEIgAAIhEkA4h6mX2AVCIAACDgRgLg74UNjEAABEAiTAMQ9TL/AKhAAARBwIgBxd8KHxiAAAiAQJgGIe5h+gVUgAAIg4EQA4u6ED41BAARAIEwCEPcw/QKrQAAEQMCJAMTdCR8agwAIgECYBCDuYfoFVoEACICAEwGIuxM+NAYBEACBMAlA3MP0C6wCARAAAScCEHcnfGgMAiAAAmESgLiH6RdYBQIgAAJOBCDuTvjQGARAAATCJABxD9MvsAoEQAAEnAhA3J3woTEIgAAIhEkA4h6mX2AVCIAACDgRgLg74UNjEAABEAiTAMQ9TL/AKhAAARBwIgBxd8KHxiAAAiAQJgGIe5h+gVUgAAIg4EQA4u6ED41BAARAIEwCvHLYOxehh2GaB6tAAARAAARsCTDxX7xy2D8Vkce2jfE8CIAACIBAmASY+U9e7vb3ieS3ME2EVSAAAiAAAvYE+AV/2+1vxSRv7RujBQiAAAiAQIgE4oif8NLB+VJ07+pTiAbCJhAAARAAATsCTPTfwe76Eqtmy93eERE9tesCT4MACIAACARI4Phid307Efel1/3NKJZ3ARoJk0AABEAABCwIqJDM5S9rp4m4qz9kzVjQw6MgAAIgECABlSUz2FnbVKbdijtW7wF6CiaBAAiAgAWB8ap9StzV/0Hs3YIiHgUBEACBsAgksfaxSbcrd/UfVOZM5/7VGU6shuUxWAMCIAACaQSY6e/h58WNy73VS624JwL/6sNGh/lUiL4BThAAARAAgbAJqNTHocjm5bNHZ5OWTq3cx/+A+HvYzoR1IAACIDAmMBlnzxT3ZAX/ur/ZieUEK3hMIhAAARAIj0CyYo94S6U96qzTrtxvV/AqRBPxCWLw4TkWFoEACNxdAkmMPZat2VBMrpX7rcDflCc4wAnWuzuR8OYgAAJBETiOvyzuTW6eWq/cJxskYRqhfZQHDsrJMAYEQOCOEFAHlIZM+6YwzCyG1LCMjtlos1XlUqIWzR2ZVHhNEACBegiouLoQncQRH+UV9bGl1uI++Yo35YJpg5k2iWQVsfl6JgBGBQEQaAcBFUsnYnU73mlEdPbP7tpJ0Tf7f38Vg9IeLB9kAAAAAElFTkSuQmCC';
    	
    	var html  = '<div style="margin:0;padding:0;width:800px;height:450px;">';
    		html += '<div style="margin:0;padding:0;height:50px;border-bottom:1px solid #e8e2e2;color:#676464;padding:0 1rem;line-height:50px;font-family:monospace;font-size:15px;background:#fbf7f7;"><img src="'+vipImg+'" width="21" height="21" align="absmiddle"/>收费模式<p onclick="exam.closeImg();" style="margin:0;padding:0;float:right;cursor:pointer;" title="关闭"><img src="'+closeImg+'" width="35" height="35" align="absmiddle"/></p></div>';
    		html += '<ul style="margin:0;padding:0;border:1px solid #e8e2e2;margin:1rem;height:15.5rem;overflow-y:auto;border-radius:0.2rem;background:#FFFFFF;">';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="1"/><span class="tollbox_all">1个月 可用天数30天 <s>原价&yen;30元</s> 折后价&yen;15元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="2"/><span class="tollbox_all">2个月 可用天数60天 <s>原价&yen;60元</s> 折后价&yen;30元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="3"/><span class="tollbox_all">3个月 可用天数90天 <s>原价&yen;90元</s> 折后价&yen;45元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="4"/><span class="tollbox_all">4个月 可用天数30天 <s>原价&yen;30元</s> 折后价&yen;15元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="5"/><span class="tollbox_all">5个月 可用天数60天 <s>原价&yen;60元</s> 折后价&yen;30元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="6"/><span class="tollbox_all">6个月 可用天数90天 <s>原价&yen;90元</s> 折后价&yen;45元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="7"/><span class="tollbox_all">7个月 可用天数30天 <s>原价&yen;30元</s> 折后价&yen;15元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="8"/><span class="tollbox_all">8个月 可用天数60天 <s>原价&yen;60元</s> 折后价&yen;30元</span></label></li>';
    		html += '<li style="margin:0;padding:0;list-style-type:none;line-height:2.5rem;padding:0 0.5rem;font-family:Microsoft Yahei,monospace;font-size:15px;color:#676464;cursor:pointer;"><label onclick="exam.LabelRadio(this);" ><input type="radio" name="vip" value="9"/><span class="tollbox_all">9个月 可用天数90天 <s>原价&yen;90元</s> 折后价&yen;45元</span></label></li>';
    		html += '</ul>';
    		html += '<div style="margin:1rem;line-height:2rem;padding:0 0.8rem;font-family:Microsoft Yahei,monospace;color:#ff5722;"><img src="'+showImg+'" width="21" height="21" align="absmiddle"/><span class="tollbox_all2">请选择</span></div>';
    		html += '<div style="margin:1rem;padding:0 0.8rem;text-align:right;"><input type="image" src="'+bottonImg+'" width="70"/></div>';
    		html += '</div>';
    	
    	
    	var content = exam.tb_parameter.content==undefined?html:exam.tb_parameter.content;
    	var bgc = exam.tb_parameter.bgc==undefined?'#fdfbfb':exam.tb_parameter.bgc;
    	var sha = exam.tb_parameter.sha==undefined?'#000000':exam.tb_parameter.sha;
    	var rmsha = exam.tb_parameter.rmsha==undefined?true:exam.tb_parameter.rmsha;
    	var border = exam.tb_parameter.border==undefined?'#ece5e5':exam.tb_parameter.border;
    	var radius = exam.tb_parameter.radius==undefined?'0.2rem':exam.tb_parameter.radius;
    	var z_index = exam.tb_parameter.z_index==undefined?'99999999':exam.tb_parameter.z_index;
    	var time = exam.tb_parameter.time==undefined?'1000':exam.tb_parameter.time;
    	var opacity = exam.tb_parameter.opacity==undefined?'0.2':exam.tb_parameter.opacity;
    	var clearTimes = '';
    	
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
    			clearTimes=setTimeout(SetTimes,time);
    		}
    	}
    	clearTimes=setTimeout(SetTimes,time);
    	
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
    	if( this.setting4.id != undefined ) id = this.setting4.id;
    	
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
    	
    	var hotImg = 'data:image/png;base64,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';   	
    	var div0 = $('<div class="exam_OtherIficdiv0"></div>');
    	var div1 = $('<div class="exam_OtherIficdiv1"><img src="'+hotImg+'" width="21" height="21" align="absmiddle"/>'+(typeof tFlag=='boolean'?'其它分类':this.setting6.title)+'</div>');   	
    	var ul0 = $('<ul class="exam_OtherIficul0"></ul>');

    	var id = '';
        if( this.setting4.id != undefined ) id = this.setting4.id;	
    		      
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