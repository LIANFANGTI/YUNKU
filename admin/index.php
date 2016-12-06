<!DOCTYPE html>
<?php 
	ini_set('display_errors','On');
	require_once '../lib/fun.php';
	$BUG=SELECT("bug","count(1)c","1");$total=$BUG[0]["c"];
	$BUG=SELECT("bug","count(1)c","state");$ywc=$BUG[0]["c"];
	$percent=round(($ywc/$total*100),1)."%";
	?>
<html> 
	<head>
		<meta charset="utf-8" /> 
		<title>管理</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="js/jquery-1.10.2.js"></script>
        <script src="js/js.js"></script>
		
		<!-- bt框架-->
		<script src="js/bootstrap.min.js"></script>
		<link href="../css/bootstrap.min.css" rel="stylesheet" /> 
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
	</head>
	<body>
		<a class="btn btn-info" target="window1" href="admin-user.php">公司账号管理</a>
		<a class="btn btn-info" target="window1" href="kehuCollect.php" style='z-index:900;'>意向客户收集</a>
		<a class="btn btn-info" target="window1" href="bug.php" style='z-index:900;'>BUG修复进度(<?php echo $percent; ?>)</a>
		<!--<a class="btn btn-info" target="window1" href="admin-recharge.php">充值记录管理</a>
		<a class="btn btn-info" target="window1" href="admin-consume.php">消费记录管理</a>
		<a class="btn btn-info" target="window1" href="admin-trash.php">回收站记录管理</a>-->
		<iframe id="window" name="window1" src="admin-user.php" style="width:100%;height:1000px;">
			<!--框架内容-->
		</iframe>
	</body>
</html>