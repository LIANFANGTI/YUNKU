<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../main/css/weui.min.css" rel="stylesheet" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="../main/css/bootstrap.min.css" rel="stylesheet" />
<link href="../main/css/bding.css" rel="stylesheet" />
<title>微信绑定</title>
</head>

<body>
<?php 
require_once '../../lib/mysql.class.php';
require_once '../../lib/fun.php';
$db = new mysql('121.196.226.94','admin','xwq198291',"zckj_db","utf8",true);



#==============================================PageConfig=========================================#
$appid="wx9c3164046547198a";
$secret="0ea115a00b20fb338aa0bce190e61c24";

$code=$_GET["code"];
$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
$bcode=curl($url);//AccessToken接口中获取AccessToken+OpenId
$getuserinfo_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$bcode["access_token"]."&openid=".$bcode["openid"]."&lang=zh_CN";
$userinfo=curl($getuserinfo_url);
//print_a($userinfo);
echo $_GET["a"];
if(!empty($userinfo["openid"])){
	 $wxkh=array('name'=>$userinfo["nickname"],'openid'=>$userinfo["openid"],'head'=>$userinfo["headimgurl"],'addr'=>$userinfo["country"].$userinfo["province"].$userinfo["city"]);
	 $db->select("kehu","*","wx_openid='".$userinfo["openid"]."'");$kh=$db->fetchArray(MYSQL_ASSOC);
	$click='re("功能开发中")';
	if(!empty($kh)){//$数据表中存在该openid
		echo "<br><br></br><br><br></br><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'>
			  <i id='icon' class='weui_icon_safe weui_icon_safe_warn'></i><br><br>
			  <p class='weui_msg_desc' id='msgbox'>绑定失败!该微信号已绑定其他账号</p>
			  <br><br></br><br><br></br>
			  <input type='button' class='btn btn-danger' value='解除绑定' onclick=".$click."/>
			  </div> ";
	  	
		 //login($kh,"../main/index1.php");
	 }else{##如果不存在
		$db->select("kehu_wx","*","openid='".$userinfo["openid"]."'");$kh_wx=$db->fetchArray(MYSQL_ASSOC);
		if(!empty($kh_wx)){
			header('Location:../main/bding.php?openid='.$userinfo["openid"]);
		}else{
		    echo"数据表中不存在该OPENID";
		    $db->insert('kehu_wx',$wxkh);
			header('Location:../main/bding.php?openid='.$userinfo["openid"]);
		     //echo $db->printMessage(); 
		}
		
		
	 }
}else{
	echo "信息获取错误";
	print_a($userinfo);	
}





?>
</body>
<script>
	function re(openid){ 
		alert(openid)
		
	}
</script>
</html>
