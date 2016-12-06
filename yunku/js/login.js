// JavaScript Document
function login(){
	var user=document.getElementById("user").value	
	var pwd =document.getElementById("pwd").value
	if(user!=""&&pwd!=""){
		loginInfo=Ajax2({atype:"login",user:user,pwd:pwd});
		var url=Cut2(loginInfo,"url");
		if(loginInfo.indexOf("成功")!=-1)location.replace(url);
		if(loginInfo.indexOf("不正确")!=-1)document.getElementById("msg").innerHTML="用户名或密码不正确";
		if(loginInfo.indexOf("不存在")!=-1)	document.getElementById("msg").innerHTML="用户名不存在";
	}else{
		alert("请输入用户名或密码");
	}
}
function cls(){
 document.getElementById("msg").innerHTML="&nbsp;";	 
}


function enter(obj){
	  event = event || window.event;
	  if(event.keyCode==13){
		  login();
      } 
}
