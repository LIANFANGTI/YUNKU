var openid=document.getElementById("openid").value
var head=document.getElementById("head").value
var COMPANY_ID=document.getElementById("company").value
CPhone=false;
CName=false;
function check(){
 var tel=document.getElementById("phone").value
 if(tel.length!=11){
		alert("请输入正确的手机号哦")	 
 }else{
	$.post("http://www.zduber.com/zdcar2/ajax.php",{user:tel,atype:"ckuser"},function(data,aaa){
		if(data.indexOf("不可用")!=-1){//数据库中已存在号码
			document.title="测试功能：您的验证码为"+document.getElementById("rand").value
			sendcode()
		}else{//数据库中不存在号码
				alert("您不是云库的客户")		//self.location='http://www.zduber.com/weixin/main/kehuinfo.php?tel='+tel+'&openid='+openid+'&head='+head;
		}
	})
	//alert("发送成功")	 
 }
}
function CheckName(val){
		if(EXISTS("kehu","name='"+val+"' AND company="+COMPANY_ID)){
			document.getElementById("NameMsg").className='weui_icon_success'
			document.getElementById("msgbox").innerHTML="用户名正确";
			CName=true;
			
		}else{
			document.getElementById("NameMsg").className='weui_icon_warn'
			document.getElementById("msgbox").innerHTML="该用户不存在";
			CName=false;
		}
}

function CheckPhone(phone){
	name=document.getElementById("name").value
	if(CName){
			CONDITION="name='"+name+"' AND phone="+phone+" AND company="+COMPANY_ID;
		if(EXISTS("kehu",CONDITION)){
			SUCCESS("匹配成功");
			
			CPhone=true;
		}else{
			WARNING("用户名与号码不匹配");
		}
	}else{
		CPhone=false;
		WARNING("未找到该用户名信息");
	}
}

function SUCCESS(MSG){
	document.getElementById("PhoneMsg").className='weui_icon_success'
	document.getElementById("msgbox").innerHTML=MSG;
	document.getElementById("icon").className='weui_icon_safe weui_icon_safe_success'
}

function FAILED(){
	
}

function WARNING(MSG){
	document.getElementById("PhoneMsg").className='weui_icon_warn'
	document.getElementById("msgbox").innerHTML=MSG;
	document.getElementById("icon").className='weui_icon_safe weui_icon_safe_warn'
}

function sendcode(){
	var time=30
	var send=document.getElementById("send")
	//alert(send.value)
	send.setAttribute("disabled", true);
	countdown()
	//val.removeAttribute("disabled");  
}
 count=30
function countdown(){
	count--
	var t=setTimeout("countdown()",1000)
	var send=document.getElementById("send")
	send.value="("+count+")秒后可重新获取"
	if(count<=0){ 
		clearTimeout(t)
		count=30;
		send.removeAttribute("disabled"); 
		send.value="获取验证码"
	}
	
}
function bding(){
		CheckName(document.getElementById("name").value);
		CheckPhone(document.getElementById("phone").value);
		if(CName){
			if(CPhone){
				if(confirm("确认绑定")){
				  printr(R1=UPDATE("kehu","wx_openid",openid,CONDITION))+"\n";
				  printr(R2=UPDATE("kehu","head",head,CONDITION));
				  if(R1.indexOf("成功")){
					  alert("绑定成功");
				      to("index1.php?openid="+openid+"&c="+COMPANY_ID);
				  }
				}
				
			}else{
				WARNING("号码不匹配");
			}
		}else{
			WARNING("用户不存在");
		}			
}

function UNBDING(OPENID,COMPANY_ID){
	if(confirm("解除绑定后您将无法接受该账户的推送消息,是否确认解除绑定")){
		R=UPDATE("kehu","wx_openid","","wx_openid="+OPENID);
		if(R.indexOf("成功")!=-1){
			to("bding.php?openid="+OPENID+"&c="+COMPANY_ID);
		}else{
			alert(R);
		}
	}
	
}
