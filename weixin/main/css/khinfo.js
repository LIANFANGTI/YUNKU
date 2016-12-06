function onload(page){
	if(page="fs")t1=self.setInterval("echoba()",800)
	
}
function khinfo(){
		var pho=document.getElementById("tel").value
		var add=0
		var car=0
		var carid=0
		var ps=0
		var name=document.getElementById("name").value
		var key=document.getElementById("key").value
		var cp=document.getElementById("cp").value
		$.post("ajax.php",{khname:name,khpho:pho,khadd:add,khcar:car,khcarid:carid,khps:ps,key:key,cp:cp,atype:"addkh"},function(data,aaa){
		if(data.indexOf("成功")!=-1){
		alert("提交成功");
		if(is_weixn()){
			//alert("是微信浏览器");
			WeixinJSBridge.call('closeWindow')}
		else{
			//alert("不是微信浏览器")
			location.replace("http://www.zduber.com")} 
		}else{
			alert("提交失败")	
		}
	})

}
function echoto(key){$.post("ajax.php",{key:key,atype:"echoto"},function(data,aaa){})}

a=0
function echoba(){
	var key=document.getElementById("key").value
	//alert(key)
	
	$.post("ajax.php",{key:key,atype:"echoba"},function(data,aaa){
		if(data.indexOf("已被访问")==-1){zt="未访问"}else{zt="已被访问";
			//document.getElementById("qrcode").style.display="none"
			
			document.getElementById("msg").style.display="block"
			closeb("qrbox")
			alert("扫描成功！请根据手机上的提示填写客户信息。")
			t2=self.setInterval("khinfoba()",1500)
			
			window.clearInterval(t1)
			
		}
		/*debug*/	
		//document.getElementById("debug").innerHTML=(zt+"DebugT:"+(a++)+"<br>")+document.getElementById("debug").innerHTML
	})
	
	}
	
function khinfoba(){
	var key=document.getElementById("key").value
	$.post("ajax.php",{key:key,atype:"khinfoba"},function(data,aaa){
		//alert(data)
		if(data.indexOf("未检测到数据")!=-1){zt="未提交"}else{zt="已提交";
			document.getElementById("khtel").value=cut(data,"{phone}","{/phone}")
			document.getElementById("khname").value=cut(data,"{name}","{/name}")
			document.getElementById("khid").value=cut(data,"{id}","{/id}")
			closeb("qrbox")
			window.clearInterval(t2)
			//document.getElementById("msg").innerHTML=data
			
		}	
		//document.getElementById("debug").innerHTML=(zt+"DebugT:"+(a++)+"<br>")+document.getElementById("debug").innerHTML
	})
}

function test(){
var a="key:1454628073 SELECT　* FROM kehu WHERE khkey='1454628073'{id}85{/id}{name}练有问题了{/name}{phone}0{/phone}"	
alert(cut(a,"{name}","{/name}"))
/*alert("起始位置："+a.indexOf("{id}")+"结尾位置："+a.indexOf("{/id}"))
alert(a.substring(a.indexOf("{id}")+4,a.indexOf("{/id}")))*/
}
/*字符剪切函数*/
function cut(str,left,right){
	var start=str.indexOf(left)+left.length
	var end=str.indexOf(right)
	return str.substring(start,end)
}
/*判断是否为微信浏览器*/
function is_weixn(){  
    var ua = navigator.userAgent.toLowerCase();  
    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
        return true;  
    } else {  
        return false;  
    }  
}  

