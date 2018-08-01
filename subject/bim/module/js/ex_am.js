/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
function ExamObj(){
	
    var exam  =  new Object();   	
    exam.hosturl = window.location.protocol+'//'+window.location.host+'/exam/index.php';
    exam.htmlobj = '';
    exam.setting = '';
    exam.func = '';
    exam.htmlobj2 = '';
    exam.setting2 = '';
    exam.func2 = '';
    exam.htmlobj3 = '';
    exam.setting3 = '';
    exam.func3 = '';
    exam.htmlobj4 = '';
    exam.setting4 = '';
    exam.func4 = '';
    
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
    			ul0.append( objs.txt );
    			
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
    			ulf0.append( objs.txt );
    			
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
        		ul0.append(objs.txt);
        			
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
    exam.CreateCss3=function(){
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
    	$(".exam_minationul0").css({"margin":"0","padding":"0","padding":"1.6rem 0 0 1.8rem"});
    	$(".exam_minationli0").css({"margin":"0","padding":"0","border":"1px solid #ded5d5","list-style-type":"none","height":"6rem","text-align":"center","line-height":"6rem","float":"left","padding":"1rem 1rem","margin-right":"1.6rem","margin-bottom":"1.4rem","border-radius":"0.2rem","position":"relative","left":"0"});
    	$(".exam_minationli0 p").css({"margin":"0","padding":"0","position":"absolute","top":"-1px","left":"-1px","line-height":"0"});
    	$(".exam_minationli0 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei","display":"block","padding":"0 1.5rem","border-radius":"0.2rem"});  	
    	$(".exam_minationul1").css({"margin":"0","padding":"0","padding":"1.6rem 0 0 1.8rem"});
    	$(".exam_minationli1").css({"margin":"0","padding":"0","border":"1px solid #ded5d5","list-style-type":"none","height":"2rem","text-align":"center","line-height":"2rem","float":"left","padding":"1rem 1rem","margin-right":"1.6rem","margin-bottom":"1.4rem","border-radius":"0.4rem"});
    	$(".exam_minationli1 a").css({"margin":"0","padding":"0","text-decoration":"none","color":"#3e3c3c","font-family":"Microsoft YaHei","display":"block","border-radius":"0.2rem","padding":"0 1.5rem"});
    	
    	$(".exam_minationdiv1 a").hover(function(){
    		$(this).css({"color":"red","text-decoration":"underline"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","text-decoration":"none"});
    	});    	
    	$(".exam_minationli0 a").hover(function(){
    		$(this).css({"background":"#74c29a","color":"#e4f3eb"});
    	},function(){
    		$(this).css({"background":"#FFFFFF","color":"#3e3c3c"});
    	});
    	
    	$(".exam_minationli1 a").hover(function(){
    		$(this).css({"background":"#f7e9e9","color":"red"});
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
    	var hotImg = 'data:image/png;base64,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';
    	
    	var div0 = $('<div class="exam_hottestdiv0"></div>');
    	var div1 = $('<div class="exam_hottestdiv1"><img src="'+hotImg+'" width="21" height="21" align="absmiddle"/>最热门</div>');
    	
    	var ul0 = $('<ul class="exam_hottestul0"></ul>');
    	var li0  = '<li class="exam_hottestli0"><a href="" target="_blank">工程咨询类</a></li>';
	    	li0 += '<li class="exam_hottestli0"><a href="" target="_blank">工程咨询类</a></li>';
	    	li0 += '<li class="exam_hottestli0"><a href="" target="_blank">工程咨询类</a></li>';
	    	li0 += '<li class="exam_hottestli0"><a href="" target="_blank">工程咨询类</a></li>';
	    	li0 += '<div style="clear:both;"></div>';
    	
    	div0.append(div1);
    	div0.append(ul0);
    	
    	ul0.append(li0);
    	
    	return div0;
    }
    exam.CreateCss5=function()
    {
    	$(".exam_hottestdiv0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd"});
    	$(".exam_hottestdiv1").css({"margin":"0","padding":"0","border-bottom":"1px solid #ece5e5","margin":"0 1.8rem","height":"2.6rem","line-height":"2.6rem","color":"#3e3c3c","font-family":"Microsoft YaHei"});
    	$(".exam_hottestul0").css({"margin":"0","padding":"0","margin":"1.2rem 1.8rem"});
    	$(".exam_hottestli0").css({"margin":"0","padding":"0","border":"1px solid #d8cdcd","list-style-type":"none","text-align":"center","float":"left","padding":"0.8rem","margin-right":"1.4rem","border-radius":"0.2rem","font-family":"Microsoft YaHei"});
    	$(".exam_hottestli0 a").css({"margin":"0","padding":"0","display":"block","padding":"1rem","text-decoration":"none","color":"#3e3c3c"});
    	$(".exam_hottestli0 a").hover(function(){
    		$(this).css({"color":"red","background":"#f5f3f3"});
    	},function(){
    		$(this).css({"color":"#3e3c3c","background":"#FFFFFF"});
    	});
    }
    exam.Hottest=function(hobj,Sett,func){
    	this.htmlobj5 = hobj;
    	this.setting5 = (Sett==undefined)?{}:Sett;
    	exam.func5 = (func==undefined)?function(){}:func;
    	
    	var html = this.CreateHTML5();   	
 	   
    	$( this.htmlobj5 ).empty();
    	$( this.htmlobj5 ).append( html );
    	
    	exam.CreateCss5();
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