
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>云库登陆</title>
<link href="./login/style_log.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="./login/style.css">
<link rel="stylesheet" type="text/css" href="./login/userpanel.css">
<link rel="stylesheet" type="text/css" href="./login/jquery.ui.all.css">
<link rel="icon" href="images/favicon.ico" type="images/x-icon" id="page_favicon" />
<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script src="http://www.zduber.com/zdcar2/js/jquery-1.10.2.js"></script>

<script src="js/login.js?v=4"></script>  
<script src="../zdcar2/js/js.js?v=1"></script>

<meta property="qc:admins" content="1443161027622123326375731765060454" />
<style>

</style>
</head>

<body class="login" mycollectionplug="bind" style="background-color: #e0e7e9;">
	<div class="login_m">
		<div class="login_logo"><img src="./login/logo.png" width="196" height="46"></div>
		
		<script>
			function QieHuan(){
				$("#yun").fadeToggle();
				$("#login_wx").fadeToggle();
				obj=$("#LoginType").html(ToggleText("LoginType","微信登录","云库登录"))
				ToggleText("LoginType",1,2)
//$("#LoginType").html("123");
			}
			function ToggleText(str,a,b){
				var obj=$("#"+str).html()
				if(obj==a){return b;}else{return a};
				//$("#LoginType").html("123");
			}
		
		</script>
		<div class="login_boder" style="text-align:center;height:80%;">
			<div class="login_padding" id="login_model" style="display:;">
				<div id="yun" >
					<h2>账号：</h2>
					<label>
						<input type="text" id="user" class="txt_input txt_input2"  onfocus="cls()" onblur="check(this)" placeholder="输入您的用户名" value="">
					</label>
					<h2>密码：</h2>
					<label>
						<input type="password" name="pwd" id="pwd" class="txt_input" onfocus="cls()"  onkeypress='enter()' placeholder="请输入您的密码"  value="">
					</label>
					<p class="forgot">
						<a id="iforget" href="signup.php"><b>注册账号</b></a>  
						<a id="iforget" href="http://www.zduber.com/zdcar2/test.php">无法登陆?</b></a>
					</p>
					<div class="rem_sub">
						<div class="rem_sub_l">
							<input type="checkbox" name="checkbox" id="save_me">
							<label for="checkbox">记住账号</label>
						</div>
					</div>   
				</div>
			</div>
			<div id="login_wx" style="display:none;" >
				<div id="WxLoginQrcede">
						
				</div>
			</div>
			<script>
				 var obj = new WxLogin({
				  id:"WxLoginQrcede", 
				  appid: "wx8bd4bd5942cbab45", 
				  scope: "snsapi_login", 
				  redirect_uri: "http://www.zduber.com/weixin/login/WxLogin.php",
				  state: "",
				  style: "black",
				  href: ""
				});
			</script>
			<b style="color:red; " id="msg"></b>
			<div id="forget_model" class="login_padding" style="display:none">
				<br>
				<h1>忘记密码</h1>
				<br>
				<div class="forget_model_h2">(请输入您的注册邮箱，系统会自动重置用户密码，并将其发送给用户的注册邮箱地址.)</div>
				<label><input type="text" id="usrmail" class="txt_input txt_input2"></label>
				<div class="rem_sub">
					<div class="rem_sub_l"></div>
					<label>
						<input type="submit" class="sub_buttons" name="button" id="Retrievenow" value="Retrieve now" style="opacity: 0.7;">
						<input type="submit" class="sub_button" name="button" id="denglou" value="Return" style="opacity: 0.7;">　　
					</label>
				</div>
	  
			</div>
		</div>
		<div class="login-option-bt">
			<div class="login-op-lable-2" onclick="login()">登录</div>
			<div class="login-op-lable-2" onclick="yunku()">返回</div>
		</div>
	</div>
 <br> <br>
 <p style="text-align: center;margin-top:120px;">Copyright © 杭州交赞科技有限公司 All Rights Reserved. <a href="http://www.miitbeian.gov.cn/">浙ICP备15038930号-3</a></p>
 		 	<div style="width:300px;margin:0 auto; padding:20px 0;">
		 		<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=33010302002431" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;"><img src="http://i2.buimg.com/567571/a46fc5b15b3363ff.png" />浙公网安备 33010302002431号</p></a>
		 	</div>
		 
</body></html>