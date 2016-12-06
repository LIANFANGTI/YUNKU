<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<?php
require_once 'Connect2.1/Api/qqConnectAPI.php';
require_once '../../zdcar2/mysql.class.php';
//echo $_GET["code"];
//请求accesstoken
$oa= new Oauth();
$actk=$oa->qq_callback(); //accesstoken获取
$openid=$oa->get_openid();
echo "openid:".$openid;
$qc=new QC($actk,$openid);
$userinfo=$qc->get_user_info();
$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
$db->select("user","*","openid='".$openid."'");$user=$db->fetchArray(MYSQL_ASSOC);
if(empty($user)){
	header('Location:userinfo.php?openid='.$openid.'&hd='.$userinfo["figureurl_qq_2"]);
	print_r($user);
}else{
	@session_start();
	echo $_SESSION['user']=$user[0]["user"];
	echo $_SESSION['name']=$user[0]["name"];
	echo $_SESSION['company']=$user[0]["company"];
	echo $_SESSION['head']=$user[0]["head"];
	header('Location:../../zdcar2/index.php');
}
//$uinfo=array('openid'=>$openid,'qqname'=>$userinfo["nickname"])
//header('Location:../index.php');
/*

	echo "返回码：:".$userinfo["ret"]."<br>";	//返回码
	echo "错误信息:".$userinfo["msg"]."<br>";	//如果ret<0，会有相应的错误信息提示，返回数据全部用UTF-8编码。
	echo "空间昵称:".$userinfo["nickname"]."<br>";	//用户在QQ空间的昵称。
	echo "空间头像:".$userinfo["figureurl"]."<br>";	//大小为30×30像素的QQ空间头像URL。
	echo "空间头像:".$userinfo["figureurl_1"]."<br>";	//大小为50×50像素的QQ空间头像URL。
	echo "空间头像:<img src='".$userinfo["figureurl_2"]."'/><br>";	//大小为100×100像素的QQ空间头像URL。
	echo "QQ头像:".$userinfo["figureurl_qq_1"]."<br>";	//大小为40×40像素的QQ头像URL。
	echo "QQ头像:".$userinfo["figureurl_qq_2"]."<br>";//大小为100×100像素的QQ头像URL。需要注意，不是所有的用户都拥有QQ的100x100的头像，但40x40像素则是一定会有。
	echo "性别:".$userinfo["gender"]."<br>";	//性别。 如果获取不到则默认返回"男"
	echo "黄钻：:".$userinfo["is_yellow_vip"]."<br>";	//标识用户是否为黄钻用户（0：不是；1：是）。
	echo "会员:".$userinfo["vip"];	//标识用户是否为黄钻用户（0：不是；1：是）
	echo "黄钻等级:".$userinfo["yellow_vip_level"]."<br>";	//黄钻等级
	echo "等级:".$userinfo["level"]."<br>";	//黄钻等级
	echo "年费黄钻:".$userinfo["is_yellow_year_vip"]."<br>"; //年费黄钻*/
	
	

print_r($userinfo);



?>


<body>
</body>
</html>