<?php  ?>
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
echo "CODE:".$code=$_GET["code"];
echo "<br>";
echo "COMPANY_ID:".$COMPANY_ID=$_GET["state"];
echo "<br>";
#==============================================PageConfig=========================================#
echo "APPID:".$appid=SELECTA("company","id",$COMPANY_ID,"APPID");
echo "<br>";
echo "SECRET:".$secret=SELECTA("company","id",$COMPANY_ID,"SECRET");
echo "<br>";
$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
$url2="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

#=================================================================================================#
//echo "登录成功".$code;



$bcode=curl($url);//AccessToken接口中获取AccessToken+OpenId
echo "OPENID:".$bcode["openid"];
echo "<br>";
/*根据AccessToken跟Openid获取用户信息*/
$getuserinfo_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$bcode["access_token"]."&openid=".$bcode["openid"]."&lang=zh_CN";
//echo "<script>prompt('调试功能:access_token获取','".$bcode["access_token"]."');</script>";
$userinfo=curl($getuserinfo_url);
//print_r($userinfo);
echo "<br><img width=100 height=100 src='".$userinfo["headimgurl"]."';/><br>";

if(!empty($userinfo["openid"])){
	$OPENID=$userinfo["openid"];                                               //获取OPENID
	$WX_NAME=$userinfo["nickname"];                                            //获取用户微信名
	$WX_HEAD=$userinfo["headimgurl"];                                          //获取微信头像
	$WX_ADDRESS=$userinfo["country"].$userinfo["province"].$userinfo["city"];  //获取用户地址  国家.省份.市
	$WX_INFO=array('name'=>$WX_NAME,'openid'=>$OPENID,'head'=>$WX_HEAD,'addr'=>$WX_ADDRESS,'company'=>$COMPANY_ID);  //将所需用户信息放入数组	
	
    $KEHU_WX=SELECT("kehu_wx","*","openid='$OPENID' AND company=$COMPANY_ID");
	echo "信息：";
	print_r($KEHU_WX);
	echo "<br>";
	 if(!empty($KEHU_WX)){                                                     //$数据表中存在该openid
	  	echo "数据表中存在该openid";
		print_a($KEHU_WX); 
		login($KEHU_WX,"../main/index1.php");
	 }else{                                                                    //如果不存在
		echo"<br><br>用户未注册数据表中不存在该OPENID";
		//print_a($WX_INFO);
		$db->insert('kehu_wx',$WX_INFO);
		$JUMP_URL='index1.php?openid=$OPENID&c=$COMPANY_ID';
		//echo $db->printMessage(); 
		login($WX_INFO,'index.php');	
		//header('Location: $JUMP_URL');
		//header('Location:../main/bding.php?hd='.$userinfo['headimgurl'].'&openid='.$userinfo["openid"]);	 
	 }
}else{
	echo "信息获取错误";
	print_a($userinfo);	
}













/*API
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
