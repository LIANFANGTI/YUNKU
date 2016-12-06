<!DOCTYPE html>
<?php require_once 'function.php'; ?>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>云库后台</title>
		<script type="text/javascript" src="js/js.js?v=1"></script> 
		<link href="css/navbar.css" rel="stylesheet" type="text/css" />
  <style>
    body{
      margin: 0;
      padding: 0;
    }
   
	#main #window{
		width:100%;
		height:1000px;
		border:0px;
		margin:0px;
		padding-top:60px;
	}


    </style>

	</head>

	<body>
		<!-- 代码 开始 -->
		<!--头部菜单-->
		<div class="top">
			<div class="w t_cen">
				<div class="t_c_logo"><img src="images/logo2.png">
				</div>
				<div class="t_c_lr t_c_left"></div>
				<div class="t_c_cen">
					<div class="t_c_top"></div>
					<div class="t_c_bottom">
						<ul>
							
							<li>
								<a href="1-1a.php" target="window"><em>开单</em><i></i></a>
							</li>
							<li>
								<a href="shouyin.php" target="window"><em>收银</em><i></i></a>

							</li>
							<li>
								<a href="3-1.php?" target="window"><em>仓库</em><i></i></a>

							</li>
							<li>
								<a href="5-1.php" target="window"><em>统计</em><i></i></a>

							</li>
							<?php if($USERMODE=="admin")echo"<li><a href='./admin/index.php' target='window'><em>管理</em></a></li>"; ?> 
							<li>
								<a href="javascript:alert('暂未开放 敬请期待')" target="window"><em>技术共享</em><i></i></a>

							</li>
							
							<li>
									<a href="javascript:alert('暂未开放 敬请期待')" title=""><em>配件商城</em><i></i></a>
							</li>
							<li>
								<a href="javascript:logout();" title="<?php echo ($username);?>"><em>注销</em><i></i></a>
								<a href="#"><em></em><i></i></a>

							</li>
							<li>

							</li>
						</ul>
						<div class="thisMenu" id="thisMenu"></div>
					</div>
				</div>
				<div class="t_c_lr t_c_right"></div>
			</div>
		</div>
		<div id="main">
		<iframe id="window" name="window" src="shouyin.php">
			<!--框架内容-->
		</iframe>
		</div>
		<!--/头部菜单-->

		<!--引用JQuery-->
		<script type="text/javascript" src="js/jquery.js"></script>
		
		<!--其他样式-->
		<script type="text/javascript" src="js/datouwang.js"></script>
		<!-- 代码 结束 -->

	</body>

</html>