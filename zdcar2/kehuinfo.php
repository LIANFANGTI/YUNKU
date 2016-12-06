
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="js/jquery-1.10.2.js"></script>


<link type="text/css"  rel="stylesheet" href="../yunku/css/signupstyle.css" />
            <style>
            	.head{
					/*text-align:center;*/
					height:100px;
					width:100px;
					overflow:hidden;
					border:4px solid white;
					border-radius:100px;
				}
				body{
					background:url(../yunku/images/bg_kehu.jpg);
					background-size:100% auto;background-repeat: no-repeat;
					font-size:40px;
					text-align:center;					
				}
				.input-khinfo{
					width:96%;
					font-size:35px;
					line-height:100px;
					background:rgba(255,255,255,0.5);
					border:0px;
					padding:20px;
					margin:20px 0px;
					border-radius:20px
				}
				.main{
					text-align:center;
					margin-top:20px;
					background:rgba(255,255,255,0.5);
					height:100%;
					width:90%;
				}
            
            </style>

<title>云库科技-客户信息填写</title>
</head>

<body onLoad="echoto('<?php echo $_GET["key"]; ?>')">
	<div class="main" style="">
				 <!-----start-main---->
				<h1 style="text-align:center; font-family:'微软雅黑'; font-size:80px;color:#FFF;">客户信息填写</h1>
               <div style="text-align:center; margin:15px 41.5% 15px 41.5%; "  > <div class="head"><img src="../yunku/images/f1.png" width="100px" height="100px" ;></div></div>

				 <form>
					<input type="hidden" value="<?php echo $_GET["key"]; ?>" id="key" />
                    <input type="hidden" value="<?php echo $_GET["cp"]; ?>" id="cp" />
                    <script src="js/khinfo.js"></script>
                    <input type="text" class="input-khinfo" onFocus="cls()" placeholder="您的姓名"  onBlur="check(this)" id="name" >                   <input type="text" class="input-khinfo" onFocus="cls()" placeholder="您的车牌号" onBlur="check(this)" id="carid">
                    <input type="text" class="input-khinfo" onFocus="cls()" placeholder="您的手机号码"  onBlur="checkphone(this);ckuser()" id="tel" value="">
                    <input type="text" class="input-khinfo" onFocus="cls()" placeholder="所在城市" onBlur="check(this)" id="pwd">
                    <input type="text" class="input-khinfo" onFocus="cls()" placeholder="详细地址" onBlur="checkpwd()" id="pwd1">
				  </form>
							
                             <h3 id="print" style="color:#F33; display:none;">&nbsp;</h3>
							
								 
									<input type="button" class="button-submit" onclick="khinfo()" value="提交" />
                              
									<div class="clear"> </div>
							 </form>
		<!-----//end-main---->
		</div>
		 <!-----start-copyright---->
   					<div class="copy-right">
   						<p></p>
					</div>
				<!-----//end-copyright---->
	 
</body>
</html>