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
    			exam.CreateCss1();
    			if( exam.func != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func( data );
    	    	}
    		}	
    		else
    		{
    			ul0.append( objs.txt );
    			exam.CreateCss1();
    			if( exam.func != undefined )
    	    	{
    				var data = objs.txt;
    				exam.func( data );
    	    	}
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
        $('.exam_boxsp0').css({"margin":"0","padding":"0","line-height":"2rem","font-family":"Microsoft YaHei","color":"#414a4a"});
        $('.exam_boxsp1').css({"margin":"0","padding":"0","margin-top":"0.1rem","font-family":"Microsoft YaHei","padding-bottom":"1rem","color":"#756f6d","overflow":"hidden"});
    }   
    exam.InfoBar=function(hobj,Sett,func)
    {   	  	
    	this.htmlobj = hobj;
    	this.setting = Sett;
    	exam.func = func;
    	
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