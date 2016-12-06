//alert(1);
//alert();  
Reload($_GET["cid"]);
	 
function AddUser(e){
	if(e.value=="添加"){
	var Contents=document.getElementById("CONTENT");
	var CountUser=document.getElementsByName("User").length
	var AddUserButton=document.getElementById("AddUserButton")
	var UserType="<select class='input_td' id='UserType' >"+
				  "<option>普通</option>"+ 
				  "<option>管理员</option>"+
				  "</select>";
	var TrContent="<tr><td>"+(CountUser+1)+"</td>"+
				"<td name='User'><input type='text' placeholder='账号' class='input_td' id='UserName'/></td>"+
				"<td><input type='txt' class='input_td' placeholder='输入密码' id='UserPwd'/></td>"+
				"<td>"+UserType+"</td>"+
				"<td><input type='txt' class='input_td' placeholder='输入手机号' id='UserPhone'/></td>"+
				"<td colspan='5'><input type='button' class='btn btn-sm btn-warning'  value='取消' onclick='Cancel(this)'></td></tr>";
		Contents.innerHTML+=TrContent; 
	AddUserButton.value="保存"; 
	}else{
		var UserName=document.getElementById("UserName").value
		var UserPwd=document.getElementById("UserPwd").value	
		var UserType=document.getElementById("UserType").value	
		var UserPhone=document.getElementById("UserPhone").value
		var CompanyID=document.getElementById("cp").value
		var Error=0;ErrorMsg="";
		if(UserName==""){Error++;ErrorMsg+="\n请输入用户名";}
		if(UserPwd==""){Error++;ErrorMsg+="\n请设置用户密码";}
		if(UserPhone==""){Error++;ErrorMsg+="\n请输入手机号";}
		if(Error==0){
			var AddUserInfo=Ajax(AjaxPath,"post",{UserName:UserName,UserPwd:UserPwd,UserType:UserType,UserPhone:UserPhone,CompanyID:CompanyID,atype:"AddUser"});
			if(AddUserInfo.indexOf("成功")!=-1){ 
				Reload();
				alert("添加成功");
				document.getElementById("AddUserButton").value="添加"; 
			}else{
				alert(AddUserInfo);
			}
		}else{
			alert(ErrorMsg);
		}
		
	}
}


function Cancel(obj){
	document.getElementById("AddUserButton").value="添加"; 
	Reload();
}
function showpwd(obj){
	obj.type='text';
}
function hidepwd(obj){
	obj.type='password';
}


function EditUser(){
	
}
function DeleteUser(USERID){
	var DelUserMsg=Ajax(AjaxPath,"post",{USERID:USERID,atype:"DeleteUser"},true);
	Reload();
}


function Reload(CompanyID){
	var Contents=document.getElementById("CONTENT");
	//var CompanyID=document.getElementById("cp").value;
	var ReloadMsg=Ajax2({CompanyID:CompanyID,atype:"ReloadUserList"});
	printr(CompanyID);
	printr(ReloadMsg);
	//printr(ReloadMsg);
	Contents.innerHTML=(cut(ReloadMsg,"[UserList]","[/UserList]"));
	//alert(cut(ReloadMsg,"[UserList]","[/UserList]"))
	
}
/*密码更新*/
function CPWD(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","password",VAL,"id="+KID);
	printr(MSG);
}
/*密码更新*/
function CPHO(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","phone",VAL,"id="+KID);
	printr(MSG);
}
/*密码更新*/
function CTYP(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","type",VAL,"id="+KID);
	printr(MSG);
	Reload();
}



