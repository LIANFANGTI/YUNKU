<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<title>登录</title>
</head>

<body>
<h1></h1>
<?php
require_once '../../lib/fun.php';
//require_once '../../lib/mysql.class.php';
//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
if(isset($_GET["openid"])){
	$openid=$_GET["openid"];
	$db->select("kehu","*","wx_openid='$openid'");
	$kehu=$db->fetchArray(MYSQL_ASSOC);
	echo $db->printMessage();
	login($kehu,"http://www.zduber.com/weixin/main");
}else{
$redirect_url="http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php";
$url=" https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5f16b8499bb0405e&redirect_uri=http://www.zduber.com/weixin/login/callback.php&response_type=code&scope=snsapi_userinfo&state=STATE&uin=ODI5NDE5NjAx&key=3ff2fe45b5ab73838124e68bb473576964fc9abf7b9a0c26f76a85421d650eaa46722c6aaad4e030c6c23f801a776a8a";
//header('Location:'.$url);
}
//echo "<h1><a href='".$url."'>".$url."</a></h1>";
?>

<div id="qrcode">


</div>
<script>

 var obj = new WxLogin({
     id:"qrcode", 
      appid: "wx8bd4bd5942cbab45", 
      scope: "snsapi_login", 
      redirect_uri: "http://www.zduber.com/weixin/login/callback.php",
      state: "",
      style: "",
       href: ""
  });*/

/*
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5f16b8499bb0405e&redirect_uri=http://www.zduber.com/weixin/login/callback.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
*/
</script>
</body>
</html>
