<?php
	require_once 'Connect2.1/Api/qqConnectAPI.php';
	//访问登录页面
	$oa=new Oauth();
	$oa->qq_login();
?>