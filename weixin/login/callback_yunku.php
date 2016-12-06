<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录成功</title>
</head>

<body>
<?php 
require_once '../../lib/mysql.class.php';
require_once '../../lib/fun.php';
$db = new mysql('121.196.226.94','admin','xwq198291',"zckj_db","utf8",true);
echo $code=$_GET["code"];

#==============================================PageConfig=========================================#
$appid="wx1d9ed53d0115cb28";
$secret="d4dea7c385a527f45074533cb7a9d581";
$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
$url2="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

#=================================================================================================#
//echo "登录成功".$code;



$bcode=curl($url);//AccessToken接口中获取AccessToken+OpenId

print_r($becode);
/*根据AccessToken跟Openid获取用户信息*/
$getuserinfo_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$bcode["access_token"]."&openid=".$bcode["openid"]."&lang=zh_CN";
//echo "<script>prompt('调试功能:access_token获取','".$bcode["access_token"]."');</script>";
$userinfo=curl($getuserinfo_url);
echo "<img width=300 height=300 src='".$userinfo["headimgurl"]."';/>";
if(!empty($userinfo["openid"])){
	 $wxkh=array('name'=>$userinfo["nickname"],'openid'=>$userinfo["openid"],'head'=>$userinfo["headimgurl"],'addr'=>$userinfo["country"].$userinfo["province"].$userinfo["city"]);
	 //print_a($userinfo);	
	 $db->select("kehu_wx","*","openid='".$userinfo["openid"]."'");$kh=$db->fetchArray(MYSQL_ASSOC);
	echo "<br><br>".$db->printMessage()."<br><br>";
	//echo print_r($kh);
	
	 if(!empty($kh)){//$数据表中存在该openid
	  	echo "数据表中存在该openid";
		print_a($wxkh);
		 login($kh,"../main/index.php");
		//header('Location:../main/bding.php');
	 }else{##如果不存在
		echo"数据表中不存在该OPENID";
		print_a($wxkh);
		$db->insert('kehu_wx',$wxkh);
		echo $db->printMessage();
		header('Location:index.php?openid='.$userinfo["openid"]);
		//header('Location:../main/bding.php?hd='.$userinfo['headimgurl'].'&openid='.$userinfo["openid"]);	 
	 }
}else{
	echo "信息获取错误";
	print_a($userinfo);	
}













/*
=============================
获取acce_token
/*https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code*/


/*https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET

拉取用户信息：
https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN

=============================*/



?>
</body>
</html>
