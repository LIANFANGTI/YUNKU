<!DOCTYPE html>
<?php 
ini_set('display_errors','On');
require_once '../../lib/fun.php';
$loginInfo=loginChecks();
if($loginInfo){
	$cp=$loginInfo["COMPANYID"];
	$USERID=$loginInfo["USERID"];
	$companyName=$loginInfo["COMPANYINFO"]["name"];
}else{
	die("未登录");
};

?>


<html>
	<head>
		<meta charset="utf-8" /> 
		<title>用户管理</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="../js/jquery-1.10.2.js"></script>
        <script src="../js/js.js?v=10"></script>
		<!-- <script charset="gb2312" src="js/admin.js?v=10"></script>
		<!-- bt框架-->
		<script src="../js/bootstrap.min.js"></script>
		<link href="../css/bootstrap.min.css" rel="stylesheet" />	
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
	</head>
	<body onload='Reload(<?php echo $cp;?>)'>
		<div>
		
		</div>
		<table class="table table-striped table-bordered table-hover text-center">
			<tr><td colspan="10"><h1><?php echo $companyName."员工管理系统"; ?></h1></td></tr>   
			<tr >
				<td>序号</td>
				<td>用户名</td>
				<td>密码</td> 
				<td>用户类型</td>
				<td>手机号</td>
				<td>开单数</td>
				<td>收入</td>
				<td>充值量</td>
				<td>充值金额</td>
				<td>操作</td> 
			</tr>
			<tbody id="CONTENT">
		   </tbody>
			<tr>
				<td colspan="10"><input type="button" class="btn btn-info" value="添加" onclick="AddUser(this)" id="AddUserButton"/></td>
				
			
			</tr>
		</table>
	</body>
	<script>
		 CompanyID=<?php echo $cp;?>;
		 USERID=<?php echo $USERID;?>;
		 AddUserButton=document.getElementById("AddUserButton");
		function Reload(CompanyID){
			var Contents=document.getElementById("CONTENT");
			var ReloadMsg=Ajax2({CompanyID:CompanyID,atype:"ReloadUserList"});
			//printr(CompanyID);
			//printr(ReloadMsg);
			Contents.innerHTML=(cut(ReloadMsg,"[UserList]","[/UserList]"));
		}
		function AddUser(e){
			if(e.value=="添加"){
			var Contents=document.getElementById("CONTENT");
			var CountUser=document.getElementsByName("User").length
			
			var UserType="<select class='input_td' id='UserType' >"+
						  "<option>普通</option>"+ 
						  "<option>管理员</option>"+
						  "</select>";
			var TrContent="<tr><td>"+(CountUser+1)+"</td>"+
						"<td name='User'><input type='text' placeholder='账号' class='input_td' id='UserName'/></td>"+
						"<td><input type='txt' class='input_td' placeholder='输入密码' id='UserPwd'/></td>"+
						"<td>"+UserType+"</td>"+
						"<td><input type='txt' class='input_td' placeholder='输入手机号' id='UserPhone'/></td>"+
						"<td colspan='5'><input type='button' class='btn btn-sm btn-info'  value='保存' onclick='save()'></td></tr>";
				Contents.innerHTML+=TrContent; 
			AddUserButton.value="取消";
			AddUserButton.className="btn btn-sm btn-warning";
			}else{
				Reload(CompanyID);
				e.className="btn btn-info";
				e.value="添加";
			}
		}
		function save(){
			AddUserButton.value="添加";
			AddUserButtonclassName="btn btn-info";
			
			var UserName=document.getElementById("UserName").value
			var UserPwd=document.getElementById("UserPwd").value	
			var UserType=document.getElementById("UserType").value	
			var UserPhone=document.getElementById("UserPhone").value
			if(!EXISTS("user","company="+CompanyID+" AND name='"+UserName+"'")){
				var Error=0;ErrorMsg="";
				if(UserName==""){Error++;ErrorMsg+="\n请输入用户名";}
				if(UserPwd==""){Error++;ErrorMsg+="\n请设置用户密码";}
				if(UserPhone==""){Error++;ErrorMsg+="\n请输入手机号";}
				if(Error==0){
					var r=INSERT("user",{"user":UserName,name:UserName,password:UserPwd,type:UserType,phone:UserPhone,company:CompanyID,del:1},true);
					if(r.state){
						logInfo=LOGS(USERID,"添加","子账户",r.newid,UserName,CompanyID);
						printr(logInfo);
						Reload(CompanyID);
						
					}
					//var AddUserInfo=Ajax(AjaxPath,"post",{UserName:UserName,UserPwd:UserPwd,UserType:UserType,UserPhone:UserPhone,CompanyID:CompanyID,atype:"AddUser"});
					/*	if(AddUserInfo.indexOf("成功")!=-1){ 
							Reload();
							alert("添加成功");
							document.getElementById("AddUserButton").value="添加"; 
						}else{
							alert(AddUserInfo);
						}
					}else{
						alert(ErrorMsg);
					}*/
				}
			}else{
				alert("该用户已存在");
			}
		}
		function DeleteUser(UID){
			if(confirm("该操作无法撤销 是否删除用户")){
				var USERNAME=SELECTA("user","id",UID,"name"); 
				var r=DELETE("user","id="+UID);
				if(r.state){
					//LOGS(U,T,O,V1,V2,C){
					printr(LOGS(USERID,"删除","账户",UID,USERNAME,CompanyID));
					Reload(CompanyID);
				}
					
			}
			
		}
	</script>
</html>