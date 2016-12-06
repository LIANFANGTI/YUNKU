<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>消费详情</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<style>
			h1{
				font-weight: bold;
			}
			h4{
				color:gray;
			}
		</style>
	</head>
	<?php
		require_once '../../lib/mysql.class.php';
		 require_once '../../lib/fun.php';
		if(!isset($_GET["cid"])){die("参数错误");}
		$cid=$_GET["cid"];
		$db->select("czjl","*","id=$cid");
		$czjl=$db->fetchArray(MYSQL_ASSOC);
		//print_r($czjl);
		
		
	?>
		<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
					<img src="image/1.png"/>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
					<h3>您成功在自点车坊充值</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>充值流水号:
						<b style='color:#881;  '><?php echo $czjl[0]["bm"];?></b>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
					<h4>充值账户:<?php  echo selecta("kehu","id",$czjl[0]["kh"],"name");?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
					<h4>充值金额:<?php  echo $czjl[0]["je"] ;?>元</h4> 
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>支付方式:<?php  echo selecta("zfmode","id",$czjl[0]["zf"],"name");?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>充值时间:<?php  echo ($czjl[0]["date"]);?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h6>如有疑问:请咨询微信公众号在线客服</h6>
				</div>
			</div>
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h6>客服在线时间：上午9:00~下午17:00</h6>
				</div>
			</div>
			
		</div>		
	</body>
</html>
