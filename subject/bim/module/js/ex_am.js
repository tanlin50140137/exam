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
    exam.Answer = 0;
       
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
    	var iconimg1 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAKyElEQVR4Xu2dQXIbtxJAGyzGyi6kL/CtqlDbyCeIcoLIJ7CyNLmwdALLJ5CyIL2MfQLJJ7D+CeJsRVdJuYA42cUOP/FrGLnKZYsmGiQGAPG8FTDoft3PQ84MMUb4BwEILCRgYAMBCCwmgCB0BwS+QgBBaA8IIAg9AAE/ApxB/LgxqxACCFJIoUnTjwCC+HFjViEEEKSQQpOmHwEE8ePGrEIIIEghhSZNPwII4seNWYUQQJBCCk2afgQQxI8bswohgCCFFJo0/QggiB83ZhVCAEEKKTRp+hFAED9uzCqEAIIUUmjS9COAIH7cmFUIAQQppNCk6UcAQfy4MasQAghSSKFJ048AgvhxY1YhBBCkkEKTph8BBPHjxqxCCCBIIYUmTT8CCOLHjVmFEECQQgpNmn4EEMSPG7MKIYAghRSaNP0IIIgfN2YVQgBBCik0afoRQBA/bswqhACCFFJo0vQjgCB+3JhVCAEEKaTQpOlHIAlBOqPxj37hM2uTCVT93n9j5xdFkM7wcrdlzGMrdt+IeRAbAuunS8CKvTZizmfWvqoGO2+bjrRRQTovxnvGyjMjstd0oqyXPwErcmGNPK+e9C6ayqYxQe6PxicicthUYqyz0QROb/q9oyYyDC5I5+SqY7amvxmR/SYSYo0yCFiRc/u+/Ut1tF2FzDi4IN3R+Aw5Qpaw3GPXkkz6vUchCQQV5P7w3akY+zRkAhy7cALW/Hoz+D7YR/dggtRfyFtW3hRePtJvgMDM2oehrnAFE6Q7Gr/halUD3cESUl/dmvR7P4VAEUSQ2/scv4cImGNC4C4Coc4iQQThuwdN3DiBQN9FggjSHV1ecYe88RYpesH6jvukv7O9bghBBLk/Gtt1B8rxILCMwE2/t/Z+XvsBuXq1rIz8PRSBmZGf1v0YCoKEqhbHbZwAgjSOnAVzIoAgOVWLWBsngCCNI2fBnAggSE7VItbGCSBI48hZMCcCCJJTtYi1cQII0jhyFsyJAILkVC1ibZwAgjSOnAVzIoAgOVWLWBsngCCNI2fBnAggSE7VItbGCSBI48hZMCcCCJJTtYi1cQII0jhyFsyJAILkVC1ibZwAgjSOnAVzIoAgOVWLWBsngCCNI2fBnAhstCBWJPrbhHJqhk2P1Yio3zq2kYJYsX9Y881+9WT7etOLTn7uBDovrh6Y2fTCGPmP66yNFGQm5lHV//7cFQLjyiHQGb3bb4k9c814IwUJsdmXK1DGpU9AswkhgqRfTyJcMwEECbBd5JprxOEiEkAQBInYfukvjSAIkn6XRowQQRAkYvulvzSCIEj6XRoxQgRBkIjtl/7SCIIg6XdpxAgRRClIfXfVyOxk0Sve6ldxWSvPq8HOS01dOydXndbW9Jm1cmCMdDRzGbucwLwu0jrSPjWBIApBNG+v0t5V5cWjy5t8HSPUdVG8zk97bJd8or9hSvOoia6J7aub/s6BC4R6THc4nnDmcKW1wjjl22g5gyjOIN3R+ML1Mej68flJv7fnWkpNIVyPybgvCYSsS/FnEATJXzkEeTHea1l541pKzUcsBHGlmu44BEGQdLszgcgQBEESaMN0Q0CQkIIMx+fGyM8u5bdWXk8GvX2XsfUYvqS7klptXMi6FP8lvTMaH7ZETlxKNBM5qvq9U5ext5d5neVzPSbjviSgrYvmP67iBXFtZO3/UvVxO8PLXSOmlsR5kwAE0BLQ3ZvSntkR5LYedTNLy9z9OMjMVtVg5622dHNJTq468u1012cuc5YQ8KwLZxDFjUKasDwCCIIg5XW9ImMEQRBFu5Q3FEEQpLyuV2SMIAiiaJfyhiIIgpTX9YqMEQRBFO1S3lAEQZDyul6RMYIgiKJdyhuKIAhSXtcrMkYQD0Hmj5oY892dnK39a6VHTbamPyjqx1BXAp51QRClIN3R+MyIfPUxdityPun3HrnWbv4cVv2wopGzRdsJaY7F2AUErH15M9j5RcMHQRSC8Li7prXSHMvj7vxgKs3OTCYq3SPvnEEUZxA2bUimy70D4Se3Ic8g7Ivl3ZipTEQQBEmlF5OMA0EQJMnGTCUoBEGQVHoxyTgQJKAgQTevHo0rI3L3zcckWy3ToNi8OtzWo7z+IFMpPglbu/MIl3kVl3nnd7zrF+hYe7poex5r5U9rzKH2RS3zF+jc+9+xNfaAM8n6RfStC4IoBVl/6ThiygQQBEFS7s/osSEIgkRvwpQDQBAESbk/o8eGIAgSvQlTDgBBECTl/oweG4IgSPQmTDkABEGQlPszemwIgiDRmzDlABAEQVLuz+ixIQiCRG/ClANAEKUg82emvp0+tVb27iqsMXIxk/ar6sn2tbbw84chZ/axNeaBdi7jv05gXpe/279WR9uVhhWCKASp5TD3plfGyN2vX7slb61UttV+qJGkM7w8aBnzm6Z4jNURmNflQ3tbIwmCKAS5Pxwfi5FnTmWx8vxm0Dt2Gisi3dHlFXtiudJaYZyyLgiiEIRdTVZozESm8ovCgL8oRJBEunyFMBAEQVZon82fiiAIsvldvkKGCIIgK7TP5k9FEATZ/C5fIUMECShI0Mu8w/H1oo0gVugHpn5OgMu8Abf9qW8Ubk2vl+06YkX+su/bDzQ3pOrdUlpiz+jocAR86sJ9EMV9kLp0/27PMz20ZsGjJlYuZh/apxo5PrbEv4+amH1r7G64NinzyMazLgiiFKTM9io3awRBkHK73yFzBEEQhzYpdwiCIEi53e+QOYIgiEOblDsEQRCk3O53yBxBEMShTcodgiAIUm73O2RevCCz9+2uz009B7YMyZzA/Kbw1nTimob25TwuxzUugzRjNG+Bqo87Ezmq+r1TzRqMLYNAZzQ+bImcuGabhSB1MprT4vyH/GKP5cM3rziTuLbCZo+rzxxy75/HRszxsg06PiVxE+Dj+trPIHXAXZ6M3ewOTjC7+hVvk0Fv7ds1BRFE9zbaBGkTUn4ElG/PdU0wiCCd4eVuy5jfXYNgHARWJTCz9mE12Hm76nE+nx9EkPnHrNH4woj8uO6AOR4EPieg/ZWihmAwQbRXszRBMxYCnxIIdfao1wgmyPxq1vDdqRj7lHJCIBgB5U94tXEEFeT2ita5MfKzNjDGQ2AZAWvl9WTQ2182bpW/BxfkdsPpl0iySpmY+8X3Diuv7Yf2Qeh7Z8EF+ZgYH7do8rURCPyx6tM4GxOkXrT+4m6sHHN1a22tUtSB6qtV1trDEJdzF4FsVJCPQczvk0jrwIrdZy+qonpcnWx9h9yIOZ/J7GWTYnwMNIogn1OqzyxqckzYeALVk95F7CSTECQ2BNaHQFIfsSgHBHIhwBkkl0oRZxQCCBIFO4vmQgBBcqkUcUYhgCBRsLNoLgQQJJdKEWcUAggSBTuL5kIAQXKpFHFGIYAgUbCzaC4EECSXShFnFAIIEgU7i+ZCAEFyqRRxRiGAIFGws2guBBAkl0oRZxQCCBIFO4vmQgBBcqkUcUYhgCBRsLNoLgQQJJdKEWcUAggSBTuL5kIAQXKpFHFGIYAgUbCzaC4EECSXShFnFAIIEgU7i+ZCAEFyqRRxRiGAIFGws2guBBAkl0oRZxQCCBIFO4vmQgBBcqkUcUYhgCBRsLNoLgQQJJdKEWcUAggSBTuL5kIAQXKpFHFGIYAgUbCzaC4EECSXShFnFAIIEgU7i+ZCAEFyqRRxRiHwf4dB1CNL09L7AAAAAElFTkSuQmCC';
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
    
    exam.sendpays=function(str)
    {
    	var d = $('#'+str).serialize();
    	
    	if( d == '' )
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
    	
    	$.ajax({
    		url:exam.hosturl,
    		type:'post',
    		data:'act=send_pays&'+d,
    		success:function(data){
    			var obj = eval("("+data+")");
    			if( obj.error == 0 )
    			{
    				location.href = exam.hosturl+'/payments';
  
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
    	
    	var hotImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAQ/UlEQVR4Xu2dS3YbNxaG72Ukp2ehvIGWzjE5jbSCyCuIvIIoQ5MDyyuIvAIrA9JDyysQvQIrK7AyFX2OlA2I7Fnr0YU+KJIyVaxiAagqVAH4OSWe/71f4Q0w4QcFoECmAgxtoAAUyFYAgMA7oMAaBQAI3AMKABD4ABQwUwAtiJluiBWIAgAkEEOjmmYKABAz3RArEAUASCCGRjXNFAAgZrohViAKAJBADI1qmikAQMx0Q6xAFAAggRga1TRTAICY6YZYgSgAQAIxNKpppgAAMdMNsQJRAIAEYmhU00wBAGKmG2IFogAACcTQqKaZAgDETDfECkQBABKIoVFNMwUAiJluiBWIAgAkEEOjmmYKABAz3RArEAUAiGeGbn8Y77eIfokEX9PtD5+nb3emnlXRanUAiFW5q83s+XD8noiOFrkIIS4m/e5etbn6nToA8cC+7Q9X2xzdnzHzbrI6kRC/T/vdUw+qWUsVAEgtspeXqexScURnzNROTVXQu5t+57i8HMNKCYA4bO/24PKwxfxxbRUASCELA5BC8tUXOTneyCwJAClkJABSSL56Ij8fXH4k5kOV3CPiV9Pei5FKWIRZVQCAOOYVOnDIqkVML6evO+eOVbMxxQUgjTFFfkF04YgBwSxWvrBrQgCQQvLZi9wejo9aRHKdQ++HMYieXonQAKSQfHYiK81WZRUFgBQyEgApJF/1kduDy90W81fjnACIsXQyIgApJF+1kdvvr9r87OEqcxFQJXvBf970XzxuP1GJgjDfFQAgDfaGreH4CxPtFymiIPpr0usUSqNI/q7HBSANtaDxoDxRHwBSzMAApJh+lcQuPO5IlOqm14GdDS0F4QyFqzLa1uDya9rOXNM8AYipchikmytXUczng/ExMf1RZvJYTTdXEy2IuXalx5yd63j4WmjWKqVUEdHbaa9zUnqBA0gQgDTIyFvD8RkTHZReJEz1GksKQIylKzdifJZc0JdyU52lhpksc1UBiLl2pcYse2CeLBwG6mbmAiBmupUaqz38dtAicVZqoonEMFA3UxeAmOlWaqwyVsxzC4Q9WbkSpQUAIEaylRepyrHHcimFoM+Tfqf8CYDypGhkSgCkRLPIaVr6L011Lmuz0nrM64hxiL6xAYi+Zisx5NYQJvq4tPp9ctPrvM1L2lbrsSgHzqfnWWT1fwCir9mTGDM4+EtycU/lqOvz4eUpEf9WsAjq0bEeoq7VPCQA0Zbse4QsOOIQOYPiUs56aJZdkLie9Lo7mtGCDg5ADM2/Fg4VQFQufTMs27pokRB70373ooKkvUwSgBiYVemMeE4LYnNw/rSK4tNNr6t0p5aBNN5FASCaJlWCI+e6HTnb1RIPV5pZlxJcCJpO+p2tUhILIBEAomFkVThkkutWrqvY0q5RDcJslrpaAERRK91TfusAqXrfVV6VsGiYp9D3/wGIgla5A/KUNLIAqbN7tVzMiDd2pq93rhWqH3QQAJJjfhM41nWxdLpplXom9mYpyQtA1shkCsc6QLYG4xEz/apknQoDYbCuJi4AydApXsj78f4rE2+rSfk0VFYXa2swnpR9pNakfDHEuNg6VzoAkiLRbJX7/kuRm0XSALG99yrP+lhZz1MIt5qkKlTG2fC0qdS6p3fTKotWZD0kaEES+pi8wZEqccoguCnjj+XyohUBIPnt6DxEqTNMaYAML69MxzTKlTAIiFYkWzS0IAs4Sr5VJHmTSFPWP9JcAa0IAFn7Xa1i67kQ4mLS7+4tMrZxMYNB4/EYBa1IunpoQYioqp21y0dcmzhAfzIWETQVdxs7OseFiwDpStzgAXk++HZCLN5UYbDlqd6t4ficiX6pIp/S0sTq+oqUQQNSdbdn+U7crYYO0JMegT1aTxUJFpAqxh1JZ1veNft8OBalfekrTEgQjSa9zqsKs3Aq6WABKWMxUMXSchzS5BmstDrgvMh3VYIEpNT1jhxK5OwQtfi6qoupVSDVDSM3MmLAPlMtOECqeoMjywllN0uQGLWYP+o6ap3h0dUKFJCqpnTXO7P4ZPX+q5LIQlcrsBak6lmrkvyyMcmgqxUQIEXPdzTGay0XJPSuVjBjkCoXBC37rPXsQn7jMAhAXJtmtU6AQoahPsATBCC21jwU/MzZIKGOR7wHpGnHXJ0lZPYY6Pmk13npch10y+49IPVM6+qawaHwgW1o9BoQtB7VgBfS+ojXgKD1qAaQeDzS2tgL4WZGbwFB61ENHItUkycmq82tvtS9BQSthwWnCuBJNy8B0b2J3YIreZuF7+sjXgJi/XFMb90/v2K+d7W8A8TGScF8twkshMdTv/4BUtPjmIEhsVJdXx8H9Q6Qul9vChUUX1fZvQIEmxLrxdPHAbtXgDT9crZ63bf63H1sRbwCxJW7p6p31fpy8G0bijeAYO2jPiiWc/Zt2tcbQNC9agYgshQ+jUW8AcSJu2+b48MVl0R8uul1DyvOxEryXgAiFwdbPz5MrCiGTJQU8OWOXz8AGX47aJE4U7IcAtlRwJPVdS8AwY0ldnxeJxdfXq3yAhCMP3Rc115YH7afeAFIkacFBIm/SfA1Ee0y079N3EcI+oeILojFNhP/bJKGj3F8uE/LeUCKrH8k3+Uz2yb/dMbG5s3xTYfKhzUR9wEZjo9aRO91nUW2HJNedzcZb2s4njLRT6rpRbcbW8l3/UzeQ5etEBOPIoou5HMJy/m3ItoXsxbu17xyCaL/CKJjYrrIC6v6Pws6Nn0+Lk0f1XybEM55QIwXCDOOi+qMZ5JPPS8MqlMmmYZgOp6+7pznOYSczqYfHw6ZYodNhbiqRbqt4eWFSffR9a0nzgOi49BPHDBjGlInvSKALL70017nJA+M5P/xGyfi4TT5VZet0KTf2dZNTyW8cdfR8XPrHgByecXE+k5RIyAxHELsT/vdQt2g5JipyqlVU0CyPiIqUDYhjPOAGM9g1QRIWXA8dueGl6fLj/NU18Uaf2GifROnXX4v3iR+nXGcBqTQAamaACm7Tz4/g3+xmKKOL3VjPiL+4S+di93aw3HmG+7zMY8RHNK5Xd524jgg433jxzFrAGT5Wei0r6LsxjDRG2Z+nF2TDs8kRlFr812Ww+u8nJXVwhi3xAqf96paNYWsCwcBIAkJqxykZ31JZ69fPZyt68LELQOJl1njFtVy1wII0VuTyYjC3l1CAm4DUuQGE+stSPYWcNUp1HWQqA6i6wCEHN646DQgOusNKx8Ty4BkOuZgLBf1/lD92K1bnd4ajK/ztsvUAUhe11K17nWEAyAWulhy5mrS67RX1jMMz7FkDfRVVvBrAYTor0mvYzzIrwOMRZ4AxAYggj5P+p2DFUBMt8kUSA+A6OEGQBJ6xX15xYXHiMT1tN89TUq+0vUroTu3nIcci0z6na3VFfb8WT0AAkDUFKhw4JgEJMspdTdGLlcs7ayFyroQAFFzD3SxGgBIkbUHU0c3jafnVk9Du7zdBF2sIpbPiKvSgqh87dcVzdTRTeMVkQmAFFGvQNwqpnkLFOcxqhog+eMFAFKGNYql4XQL0jacBYol87CLpXL9UR0tCJG792S5DciHAl/hDEDkDSmChdK5chb8903/xVHeLFYVTpl2Uk/l4dIqypL7ja7wY5Sbd8EAAMTCOkjy7PsiS9UtJkkbZx2MUtm0CED0iHEbEMOV6HVdLNVNf7NeWvoK8erYKL2LYXyfV8YpPZX06gCk7C3+ei5eLLTTgMiqG0+VlrB4pwpI1kk/05msrF3BKnDXAgjTS5Uz98VcuZrYzgOi4hSp0lkEROaf5dQqX/0n5c9oPVRhqwMQnCisBl6lVM3ussqexdIBTrUFmVUkvZs1Owtyf65yY4i8qkjcbu4nrxmKW9LBtxNi8SZPNNuAVHmRRF5dy/jf+RbEeC3EcgsSn+W429hJc+75ganRurun4uuBbjcOMuM/e7hippUdw0knqQGQ1I2aZTivjTScB8T4ZkXLgMwaEf4zbVp4YejZkVuWu37ja1AXV5oKEqO0TZGLeKqtx6yrlz4eMB7L5Xip69ePOg+ItI/Rpr86AJEOSvxq2nsxKuvrp7L2sZyXdUCE2Ct6vVFZWpmk4wcgg/FI5VrOp4NdenfT7xwnRatuDDIfieScLdcxomw9mfiLStdqka5NQLIOiunUse6wXgBitOWkphYk7mmVAIkJHLa7WC4ftV2A6Qcgg8vdFvNXva9N+qySVgsixMWk391L5qsycTCH5Hja7/6pV26i9uDyDRMf67Qcjy1Ixg0jVYxBXB9/SM28AGQ2DtG7XFku3onbzb3lWSGVzX6rs0IbO8n7qnTea5eXMAhundDtD5/TZqgeB/DxxdX/+5VFdLR8b5YuXIJoNOl1Xi3H0x3HqObp+s3uXgFi0s2SziJuN36XjhlfCB3dn+k6X+zgRL/LgWgM2LP798Rs9MKrLA/Pny2IBF+3WMR3DgtBu0y0cqZd1VFXwglxGt1tvp3Ve7zPEZ2ZtEbr8vehe+UXIB+utlvi4crYaRCxVAWyNmiWmomFxLzpYsXdLJPZLAsih5aFD7NXXg3SH/vpRW5aDM2LK62vuwekkrJ41YLMW5Hc2wUr9Q0k7vRt7t4DonpHLfy4KgX8aT28GqQvm1vljtqq3CP0dF1+CyTNdt51sWQl0YrUhalfrYe3LQjGIvUA4lvr4TUgVa0O1+N6DuTq8M0l69T1sou1qDDWReyAJc+tiLuN3XVbZeyUpPxcvAZk/p74BRP9VL50SHGhgMtvEOZZ0WtA4gF7kdsX89TD/3KfmNNHavNM6D0g8wG7/oGqPOXwv4TD267VwrxBAJJ8Sxy+XY4CaW+UlJNyc1IJApD52ojBoarmGKppJfHhMJSKpsEAMofksMX8UUUYhFmngH8Lglm1DQoQKYLxRXMgJlZAXl436XV3Q5EjOEAAiblrr7vZ0TzVZscMEhDMbOk7ZYhwSJWCBUTluk99N/IzRjydS+LA5QvgTC0TLCALwTAmWe86obYcQa2D5H09AEm6QqHDEXQXK+kS2JKSVER8im43j3zcgJj3wVz+P/gu1rIY8R1RguQzBEFvbgxlEVAFFACSUCnkwXvIg3EsFKp8LpbCqNyvq5lko4PLXbnibuMw9C5V0khoQda4bXyDOvPJupefGu31CoWLWw3mozLfLFHI1pkgAETBVHIAz0TH3o1NBL2L7jZO0GpkOwEAUQBEBpnd/H5/QsS/KUZpbLD4vUMhjkJc+NM1CgDRVCx+bjl6OBRMslVxbLZLfIp48zj5XIOmBEEFByCG5p49dfBw5AYoAMPQzOHuxTIVLC1ee/jtoEXRQZO6X/Nu1CndbY4wxjC3NloQc+1WYspWhZ7dH8RPOTPt2+6CxVAQjYg3RuhGlWNYAFKOjqmpyGliYpagzN4+L3nMIoFgQedRi86nrzvnFVYl2KQBiEXTxy3Mvx52KRLbLeJtwbT/NHvRZuKf5doEMV0v/8eCLyIW1xQ/0bZxjRbCjuEAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCgAQRw2HYttRAIDY0Rm5OKoAAHHUcCi2HQUAiB2dkYujCvwfIIfoQXAzyyMAAAAASUVORK5CYII=';   	
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
    	
    	var hotImg = 'data:image/png;base64,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';   	
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
				shuiji[1] = 30
				shuiji[2] = 30
				shuiji[3] = 30
							
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