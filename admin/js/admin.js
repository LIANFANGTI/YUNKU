//APPTH=location.href.substring(0,location.href.lastIndexOf('/'))+"/";
if($_GET["cid"]!=undefined){
	Reload($_GET["cid"]);
}else{
	Reload();
}

	
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


function Reload(A){
	var Contents=document.getElementById("CONTENT");
	var USERS=Ajax2({atype:"admin-user",A:A});
	var Main=document.getElementById("main");
	//printr(ReloadMsg);
	Main.innerHTML=(cut(USERS,"[USERATAB]","[/USERATAB]")); 
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

function UPDATE_LOGO(id){
	var SRC=prompt("请粘贴外链src链接",""); 
	if(SRC!=""&&SRC!=null){
	  UPDATE("company","logo",SRC,"id="+id);
	  alert("更新成功");
	  Reload();
	}
} 
MSG_COUNT=0;
function ADD_COMPANY(){
	MSG_COUNT++;
	CONTENT="<table class='table table-hover'><tr><td>公司名</td><td><input class='form-control inp input-sm' id='COMPANY_NAMAE"+MSG_COUNT+"'/></td><td>电话</td><td><input class='form-control inp input-sm' id='USER_PHONE"+MSG_COUNT+"' /></td></tr><tr><td>管理员</td><td><input class='form-control inp input-sm' id='USER_USER"+MSG_COUNT+"' /></td><td>密码</td><td><input class='form-control inp input-sm' id='USER_PASSWORD"+MSG_COUNT+"'  /></td></tr></table>"
	MSGBOX(CONTENT,"SAVE_COMPANY("+MSG_COUNT+")","Add　Company","ok");
}

function SAVE_COMPANY(C){
	var COMPANY_NAMAE=document.getElementById("COMPANY_NAMAE"+C).value;
	var USER_PHONE=document.getElementById("USER_PHONE"+C).value;
	var USER_USER=document.getElementById("USER_USER"+C).value;
	var USER_PASSWORD=document.getElementById("USER_PASSWORD"+C).value;
    if(COMPANY_NAMAE!=""&&USER_PHONE!=""&&USER_USER!=""&&USER_PASSWORD!=""){
	R=INSERT("company",{name:COMPANY_NAMAE,admin:0},true);
	printr("1、在公司表中添加新公司:\n"+R.newid);
	COMPANY_ID=R.newid;
	USER=INSERT("user",{name:USER_USER,user:USER_USER,password:USER_PASSWORD,type:"管理员",phone:USER_PHONE,company:COMPANY_ID,del:1},true);
	printr("2、将管理员添加至user表:\n"+USER);
	USER_ID=USER.newid;
	
	U=UPDATE("company","admin",USER_ID,"id="+COMPANY_ID);
	printr("3、更新company表中admin的值:\n"+U);
	Reload();
	}else{
		alert("请填写完整信息");
	}
	//alert(R)
}


function ADD_SUB_ACCOUNT(ID){
	MSG_COUNT=ID;
	CONTENT="<table class='table table-hover'><tr><td>用户名</td><td><input class='form-control inp input-sm' id='USER_NAME"+MSG_COUNT+"'/></td><td>密码</td><td><input class='form-control inp input-sm' id='USER_PASSWORD"+MSG_COUNT+"' /></td></tr><tr><td>手机号</td><td><input class='form-control inp input-sm' id='USER_PHONE"+MSG_COUNT+"' /></td><td>备注</td><td><input class='form-control inp input-sm' id='USER_TIPS"+MSG_COUNT+"'  /></td></tr></table>"
	MSGBOX(CONTENT,"SAVE_USER("+ID+")","Add　Sub Account","ok");
}
function SAVE_USER(C){
	
	var USER_NAMAE=document.getElementById("USER_NAME"+C).value;
	var USER_PHONE=document.getElementById("USER_PHONE"+C).value;
	var USER_TIPS=document.getElementById("USER_TIPS"+C).value;
	var USER_PASSWORD=document.getElementById("USER_PASSWORD"+C).value;
	
	
	if(USER_NAMAE!=""&&USER_PHONE!=""&&USER_PASSWORD!=""){
	USER=INSERT("user",{name:USER_NAMAE,user:USER_NAMAE,password:USER_PASSWORD,type:"子账户",phone:USER_PHONE,company:C,del:1});
		Reload(C);
	}else{
		alert("信息填写不正确");
	}
}

function USER_DEL(UID,CID){
	if(confirm("该操作无法撤销,是否确认删除")){
		I=DELETE("user","id="+UID);
		printr(I);
		Reload(CID);
	}
} 




