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
		if(!isset($_GET["bid"])){die("参数错误");}
		$bid=$_GET["bid"];
		$db->select("bill","*","id=$bid");
		$bill=$db->fetchArray(MYSQL_ASSOC);
		//print_r($bill);
		
		
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
					<h3>您在自点车坊进行了一笔消费</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>订单号:
						<b style='color:#881;  '><?php echo $bill[0]["bid"];?></b>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
					<h4>消费类型:<?php  echo btypete($bill[0]["btype"]) ;?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
					<h4>维修车辆:[<?php  echo $bill[0]["carid"] ;?>]</h4> 
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>消费时间:<?php  echo $bill[0]["date"];?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>消费金额:<?php  echo ($bill[0]["money"]*1);?>元</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
					<h4>消费项目:
						<?php
							$db->select("aitem","*","bid=$bid");
							$aitem=$db->fetchArray(MYSQL_ASSOC);
							if(!empty($aitem)){
								foreach($aitem as $row){
									echo selecta("item","id",$row["iid"],"itemname")."(".$row["gs"]."元);";
							}
							}else{
								echo "无";
							}
						?>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<h4>所用商品:
						<?php
							$db->select("ashop","*","bid=$bid");
							$ashop=$db->fetchArray(MYSQL_ASSOC);
							if(!empty($aitem)){
								foreach($ashop as $row){
									echo selecta("shop","sid",$row["sid"],"sname")."(".$row["money"]."元);";
							}
							}else{
								echo "无";
							}
						?>					
					</h4>
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
		<input type="submit" class="btn btn-info btn-md center-block" value="立即评价">	
	</body>
</html>
