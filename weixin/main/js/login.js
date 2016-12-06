// JavaScript Document
function login(){
	var user=document.getElementById("user").value	
	var pwd =document.getElementById("pwd").value
	if(user!=""&&pwd!=""){
		$.post("../zdcar2/ajax.php",{user:user,pwd:pwd,atype:"login"},function(data,aaa){
			alert(data)
			if(data.indexOf("成功")!=-1){location.replace("index.php");};	
			if(data.indexOf("不正确")!=-1)document.getElementById("msg").innerHTML="用户名或密码不正确"
			if(data.indexOf("不存在")!=-1)	document.getElementById("msg").innerHTML="用户名不存在"
		});}
	else {
		alert("请输入用户名或密码");	
	}
}

function cls(){
 document.getElementById("msg").innerHTML="&nbsp;";	
}