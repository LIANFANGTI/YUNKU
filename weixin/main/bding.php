<!DOCTYPE html>
<?php
	//isset($_GET["openid"])?$openid=$_GET["openid"]:die("openid参数错误，拒绝访问");
	require_once '../../lib/fun.php';
	//print_r($_GET); 
	if(isset($_GET["k"])){
	 $KEHU_ID=$_GET["k"];
	 $COMPANY_ID=$_GET["c"];
	 if(EXISTS("kehu","company=$COMPANY_ID AND id=$KEHU_ID")){
		 @session_start();
		 $_SESSION['KEHU_ID']=$KEHU_ID;
		$KEHU_NAME=SELECTA("kehu","id",$KEHU_ID,"name");
	    $KEHU_PHONE=SELECTA("kehu","id",$KEHU_ID,"phone");
		
	 }else{
		 echo "公司$COMPANY_ID 中不存在 客户$KEHU_ID";
		$KEHU_NAME="";$KEHU_PHONE=""; 
	 }
	}else{
	    $KEHU_NAME="";$KEHU_PHONE="";
	}
	if(isset($_GET["openid"])&&isset($_GET["c"])){
		
		$COMPANY_ID=$_GET["c"];
		$openid=$_GET["openid"];
		
		WX_BD_ED($openid,$COMPANY_ID);
	}else{
		if(isset($_GET["c"])||isset($_GET["state"])){
			if(isset($_GET["c"])){
				$COMPANY_ID=$_GET["c"];
			}else{
				$COMPANY_ID=$_GET["state"];
			}
			
			$APPID=SELECTA("company","id",$COMPANY_ID,"APPID");
			$SECRET=SELECTA("company","id",$COMPANY_ID,"SECRET");
			
			if(isset($_GET["code"])){
				$CODE=$_GET["code"];
				
				$GET_OPENID_API="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$SECRET&code=$CODE&grant_type=authorization_code";
				$BACK_INFO=curl($GET_OPENID_API);
				
				//print_r($BACK_INFO);
				if(!isset($BACK_INFO["openid"])){
					//$URL="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2fmain%2fbding.php&response_type=code&scope=snsapi_userinfo&state=$COMPANY_ID#wechat_redirect";
					//header('Location:'.$URL); 
					$DEBUG="<hr>调试信息43:<br>CODE:$CODE<br>APPID:$APPID<br>OPENID:$OPENID<br>
							 SECRET:$SECRET<br>KEHU_ID:$KEHU_ID<br> COMPANY_ID:$COMPANY_ID<br></hr>";
							echo $DEBUG;
							print_r($BACK_INFO);
				   // die("回话过期".$DEBUG);
				}
				@session_start();
				$OPENID=$BACK_INFO["openid"];
				$KEHU_ID=$_SESSION["KEHU_ID"];
				$DEBUG="<hr>调试信息51:<br>CODE:$CODE<br>APPID:$APPID<br>OPENID:$OPENID<br>
							 SECRET:$SECRET<br>KEHU_ID:$KEHU_ID<br> COMPANY_ID:$COMPANY_ID<br></hr>";
			    echo $DEBUG;
				WX_BD_ED($OPENID,$COMPANY_ID);
				
				$URLA="http://www.zduber.com/weixin/main/bding.php?c=$COMPANY_ID&openid=$OPENID&k=$KEHU_ID";
				header('Location:'.$URLA); 
			}else{
				
				$URL="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2fmain%2fbding.php&response_type=code&scope=snsapi_userinfo&state=$COMPANY_ID#wechat_redirect";
				header('Location:'.$URL); 
			}
		}else{
			print_r($_GET);
			//die("参数错误，拒绝访问");
		}
	}
	
	
	
	function WX_BD_ED($OPENID,$COMPANY_ID){
		if(EXISTS("kehu","wx_openid='$OPENID' AND company=$COMPANY_ID")){
			$TITLE="<title>绑定信息-".SELECTA("company","id",$COMPANY_ID,"name")."</title>";
			$CSS="<link href='http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css' rel='stylesheet'>";
			$CSS.="<link href='css/weui.min.css' rel='stylesheet' />";
			$CSS.="<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
			$CSS.="<style>
						.font-yahei{
							font-family: Microsoft YaHei,'宋体' ,
							Tahoma, Helvetica, Arial, '\5b8b\4f53', sans-serif;
						}
					</style>";
			$SCRIPT="<script src='js/bding.js?v=10'></script>
					 <script src='http://www.zduber.com/lib/js/jquery-1.10.2.js'></script>
					 <script src='http://www.zduber.com/zdcar2/js/js.js?v=8'></script>";
			$HEAD_URL=SELECTA("kehu_wx","openid","'$OPENID'","head");
			$HEAD_IMG="<img src='$HEAD_URL' width='150' height='150' class='img-circle' >";
			
			$HEAD="<head>".$TITLE.$CSS.$SCRIPT."</head>";
			$KEHU_NAME=SELECTA("kehu","wx_openid","'$OPENID'","name");
			$UNBIDNG="javascript:UNBDING('$OPENID',$COMPANY_ID)";
			$BUTTON="<a href=$UNBIDNG class='weui_btn weui_btn_warn' style='margin-top:10%;width:50%;'>解除绑定</a>";
			$BODY="<body style='text-align: center;'>
						<div style='width:100%;margin-top:20%;' class='text-center'>
							<a href='index1.php?openid=$OPENID&c=$COMPANY_ID'>$HEAD_IMG</a>
							<h6 style='font-family: Microsoft YaHei;margin-top:30px;color:#383633;'>$KEHU_NAME</h6>
						    <h6 style='font-size:10px;color:#868686;margin-top:10%;'>错误:您的微信已经与账户<b>$KEHU_NAME</b>绑定</h6>
							$BUTTON
						</div>
				    </body>";
			
			$HTML="<html>
					      $HEAD 
						  $BODY
					</html>";
			
			ob_end_clean();
			die($HTML);
		}
	}
 ?>
<html>
	<head>
		<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<link href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" rel="stylesheet">
			<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
			<link href="css/bding.css" rel="stylesheet" />
			<link href="css/weui.min.css" rel="stylesheet" />

		<title>绑定信息-<?php echo SELECTA("company","id",$COMPANY_ID,"name"); ?></title>
	</head>
	<body style="text-align:center;">
    
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<i id='icon' class="weui_icon_safe weui_icon_safe_warn"></i><br><br>
				<p class='weui_msg_desc' id="msgbox">请填写账户信息</p>
				<br><br>
				<input class="txt" value="<?php echo $KEHU_NAME; ?>" id="name" type="text" onchange='CheckName(this.value)' placeholder="输入您的姓名"/>
				<i class="weui_icon_info" id='NameMsg'></i>
				<br>
				<br>
				<input class="txt" value="<?php echo $KEHU_PHONE; ?>" id="phone" type="text" onkeyup='CheckPhone(this.value)'  placeholder="输入您的手机号"/>
				<i class="weui_icon_info" id='PhoneMsg'></i>
				<br>
				<br>
				<?php 
				
				    $num=rand(1000,9999);//验证码生成
					echo "<input type='hidden'  id='rand' value='".$num."' />";
				?>
                <input type="hidden" value="<?php echo $_GET["openid"] ?>" id="openid"/>
                <input type="hidden" value="<?php echo isset($_GET["hd"])?$_GET["hd"]:""; ?>" id="head"/>
                <input type="hidden" value="<?php echo $_GET["c"]; ?>" id="company"/> 
                <input type="hidden" value="<?php echo $_GET["openid"]; ?>" id="openid"/> 
				
                
             <script src="js/bding.js?v=8"></script>
            <script src="http://www.zduber.com/lib/js/jquery-1.10.2.js"></script>
            <script src="http://www.zduber.com/zdcar2/js/js.js?v=7"></script>
				</div>
			</div>
			<div class="row" style="margin-bottom:300px;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<input class="weui_btn weui_btn_primary" id="send" onClick="bding()"type="button" value="绑定" />
				</div>
			</div>
              
			</div>
		</div>
	</body>
</html>
