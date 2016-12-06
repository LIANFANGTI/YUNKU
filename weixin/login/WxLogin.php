<?php
	require_once '../../lib/mysql.class.php';
	require_once '../../lib/fun.php';
	$code=$_GET["code"];
	//echo $code;
	$appid="wx5f16b8499bb0405e";
	$secret="d2677e79f8f58139f1d9b9cae3524316";
	$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
	echo"Appid:<b>$appid</b><br>Secret:<b>$secret</b><br>Code:<b>$code</b>";
	//echo"<script>prompt('$url','$url')</script>";
	$bcode=curl($url);
	print_a($bcode);
?>