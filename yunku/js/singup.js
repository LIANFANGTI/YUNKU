// JavaScript Document
 print1=document.getElementById("print")

function onload(){
	 openid=document.getElementById("openid").value
	  aurl=document.getElementById("aurl")
	 if(openid!=""){aurl.value="../../zdcar2/ajax.php";burl="../login.php"}else{aurl.value="../zdcar2/ajax.php";burl="login.php"}
	
}
function check(obj){
	//var obj=document.getElementById("active")

	if(obj.value==""){
		obj.style.borderLeftColor="#FF4444"
		obj.style.borderLeftWidth="6px"
	}else{
		obj.style.borderLeftColor="#40A46F"
		obj.style.borderLeftWidth="6px"
	}
	
}

function checkpwd(){
	pwd=document.getElementById("pwd")
	pwd1=document.getElementById("pwd1")
	
	if(pwd1.value!==pwd.value){
		pwd1.style.borderLeftColor="#FF4444"
		pwd1.style.borderLeftWidth="6px"	
		pwd.style.borderLeftColor="#FF4444"
		pwd.style.borderLeftWidth="6px"
		document.getElementById("print").innerHTML="两次密码不一致,请重新设置！"
		return 0;	
	}else{
		pwd1.style.borderLeftColor="#40A46F"
		pwd1.style.borderLeftWidth="6px"
		return 1;	
	}	
}
function checkphone(){
	var tel=document.getElementById("tel")

	if(tel.value.length<11){
		tel.style.borderLeftColor="#FF4444"
		tel.style.borderLeftWidth="6px"	
		document.getElementById("print").innerHTML="手机号码不正确"	
		return 0;
	}else{
		tel.style.borderLeftColor="#40A46F"
		tel.style.borderLeftWidth="6px"	
		return 1;	
	}	
}
function singup(){
	var cp=document.getElementById("cp").value
	var name=document.getElementById("name").value
	var tel=document.getElementById("tel").value
	var pwd=document.getElementById("pwd").value
	var openid=document.getElementById("openid").value
	var hd=document.getElementById("hd").value

	if(cp!=""&&name!=""&&checkpwd()&&checkphone()&&ky.value){
		
		$.post(aurl.value,{name:name,cp:cp,tel:tel,pwd:pwd,openid:openid,hd:hd,atype:"singup"},function(data,aaa){
			alert("注册成功")
			if(data.indexOf("@QQ登录跳转@")!=-1){window.location.href="../index.php";}
			else if(data.indexOf("数据插入成功")!=-1){
			  alert("注册成功")
			  window.location.href=burl
			}
			
		})
		//alert(cp+name+tel+pwd)	
	}else{
		document.getElementById("print").innerHTML="信息填写不正确";	
	}
	
}
function cls(){
 document.getElementById("print").innerHTML="&nbsp;";	
}

function ckuser(){
	var user=document.getElementById("tel")
	if(user.value!=""){
		
		$.post(aurl.value,{user:user.value,atype:"ckuser"},function(data,aaa){
			if(data.indexOf("可用")!=-1){
				//alert("可用"+data)
				user.style.borderLeftColor="#40A46F"
				user.style.borderLeftWidth="6px"
				 	
				ky.value=1
				
			}else{
				//alert("已存在")
				user.style.borderLeftColor="#FF4444"
				user.style.borderLeftWidth="6px"	
				document.getElementById("print").innerHTML="改手机号已经被注册";
				ky.value=0	
			}
	   })
	}else{
		checkphone()	
	}			
}