//alert(1);
//alert();  
Reload($_GET["cid"]);
	 
function AddUser(e){
	if(e.value=="���"){
	var Contents=document.getElementById("CONTENT");
	var CountUser=document.getElementsByName("User").length
	var AddUserButton=document.getElementById("AddUserButton")
	var UserType="<select class='input_td' id='UserType' >"+
				  "<option>��ͨ</option>"+ 
				  "<option>����Ա</option>"+
				  "</select>";
	var TrContent="<tr><td>"+(CountUser+1)+"</td>"+
				"<td name='User'><input type='text' placeholder='�˺�' class='input_td' id='UserName'/></td>"+
				"<td><input type='txt' class='input_td' placeholder='��������' id='UserPwd'/></td>"+
				"<td>"+UserType+"</td>"+
				"<td><input type='txt' class='input_td' placeholder='�����ֻ���' id='UserPhone'/></td>"+
				"<td colspan='5'><input type='button' class='btn btn-sm btn-warning'  value='ȡ��' onclick='Cancel(this)'></td></tr>";
		Contents.innerHTML+=TrContent; 
	AddUserButton.value="����"; 
	}else{
		var UserName=document.getElementById("UserName").value
		var UserPwd=document.getElementById("UserPwd").value	
		var UserType=document.getElementById("UserType").value	
		var UserPhone=document.getElementById("UserPhone").value
		var CompanyID=document.getElementById("cp").value
		var Error=0;ErrorMsg="";
		if(UserName==""){Error++;ErrorMsg+="\n�������û���";}
		if(UserPwd==""){Error++;ErrorMsg+="\n�������û�����";}
		if(UserPhone==""){Error++;ErrorMsg+="\n�������ֻ���";}
		if(Error==0){
			var AddUserInfo=Ajax(AjaxPath,"post",{UserName:UserName,UserPwd:UserPwd,UserType:UserType,UserPhone:UserPhone,CompanyID:CompanyID,atype:"AddUser"});
			if(AddUserInfo.indexOf("�ɹ�")!=-1){ 
				Reload();
				alert("��ӳɹ�");
				document.getElementById("AddUserButton").value="���"; 
			}else{
				alert(AddUserInfo);
			}
		}else{
			alert(ErrorMsg);
		}
		
	}
}


function Cancel(obj){
	document.getElementById("AddUserButton").value="���"; 
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
/*�������*/
function CPWD(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","password",VAL,"id="+KID);
	printr(MSG);
}
/*�������*/
function CPHO(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","phone",VAL,"id="+KID);
	printr(MSG);
}
/*�������*/
function CTYP(O,KID){
	var VAL=O.value;
	var MSG=UPDATE("user","type",VAL,"id="+KID);
	printr(MSG);
	Reload();
}



