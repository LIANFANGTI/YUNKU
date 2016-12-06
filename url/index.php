<!DOCTYPE html>
<?php ini_set('display_errors','On');
require_once '../lib/mysql.class.php';
require_once '../lib/fun.php'; ?>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>云库短网址</title>

		<!-- Bootstrap -->
		<link href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
		<style>
			th,
			td {
				text-align: center;
			}
			
			td a {
				color: black;
			}
			
			td a:hover {
				text-decoration: none;
			}
		</style>
	</head>

	<body >

		<table class="table table-hover table-striped table-bordered" style="width:50%;margin-left:20%;">
			<tr>
				<td colspan=3>云库短网址生成器</td>
			</td>
			</tr>
			<tr>
				<td>原网址</td>
				<td><input id="url" class="form-control input-xs" type="text" placeholder="请输入要转换的网址"  onchange=""></td>
			    <td><input type="button" class="btn btn-success btn-sm" value="转换" onclick="change()"></td>
			</tr>
			<tr>
				<td>新网址</td>
				<td><input id="url2" class="form-control input-xs" type="text" placeholder="请输入要转换的网址"  onchange=""></td>
			    <td><input type="button" class="btn btn-success btn-sm" value="复制" onclick=""></td>
			</tr>
			   <?php
			      
			   
			   ?>
				
			

		</table>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
		<script src="../zdcar2/js/js.js"></script>
		<script>
			function change(){
			    url1=document.getElementById("url").value;
				url2=document.getElementById("url2");
				//alert(url1)
				//alert(Ajax2({atype:"URL",URL:"'"+url1+"'"}));
				//url2.value=Ajax3({atype:"URL",URL:"'"+url1+"'"});
				url2.value=Ajax3({atype:"URL",URL:"'"+url1+"'"});
			}
		
		</script>
	</body>

</html>