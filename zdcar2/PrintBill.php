<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打印订单</title>
<!-- bt框架-->
	<script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
<!-- bt框架End-->
<style type="text/css">
.line {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000;
	height:15px;
}
td {
	margin-top:100px;

}
h5{
	margin:5px auto;
}
</style>
</head>
<?php
ini_set('display_errors','On');
	require_once 'function.php';  
	$bid=$_GET["bid"];
	if(!isset($_GET["bid"]))die("<h1>参数错误!</h1>");
	$db->select("bill","*","id=".$bid);$BillInfo = $db->fetchArray(MYSQL_ASSOC);
	$db->select("aitem","*","bid=".$bid);$BillItemInfo = $db->fetchArray(MYSQL_ASSOC);
	$db->select("ashop","*","del and bid=".$bid);$BillShopInfo = $db->fetchArray(MYSQL_ASSOC);
	//echo "$bid";
 ?>
<body onload="print()">
			<div class="container-fluid">
				<table class="table table-bordered  table-striped">
					<thead>
						<tr class="text-center">
							<td colspan="8" >
								<h4><b id="CompanyName">自点车坊开单表</b></h4>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr class="text-left">
							<td colspan="8">
								<h4 id="Sdate"><b>客户信息</b></h4>
							</td>
						</tr>
						<tr>
							<td colspan="2" id="KhName">顾客姓名:<?php echo Kehuname($BillInfo[0]["kehu"]); ?></td>
							<td colspan="2" id="Carid">车牌号:<?php echo $BillInfo[0]["carid"]; ?></td>
							<td colspan="4" id="phone" >顾客电话:<?php  echo Kehuphone($BillInfo[0]["kehu"]); ?></td>
						</tr>
						<tr class="text-left">
							<td colspan="8"><b>施工信息</b></td>
						</tr>
						<tr class="text-center">
							<td colspan="2"><b>项目</b></td>
							<td colspan="2"><b>金额</b></td>
							<td colspan="2"><b>施工人员</b></td>
							<td colspan="2"><b>备注</b></td>
						</tr>
						<tbody id="BillItemList">
							<?php
								$CAI=0;
								foreach($BillItemInfo as $row){
									$CAI++;
									echo "<tr><td colspan='2'>".  Itemname($row["iid"])."</td><td colspan='2'>".$row["gs"]."元</td><td colspan='2'>".$row["gr"]."</td><td colspan='2'>".$row["tips"]."</td></tr>";
								}
								$CAS=0;
								foreach($BillShopInfo as $row){
									$CAS++;
									
									echo "<tr><td colspan='2'>".Shopname($row["sid"])."</td><td colspan='2'>".($row["money"]*$row["sl"]*1)."元(".$row["sl"].")</td><td colspan='2'>".$row["gr"]."</td><td colspan='2'>".$row["tips"]."</td></tr>";
								}
								
								for($i=0;$i<(16-($CAI+$CAS));$i++) 
								echo "<tr><td colspan='2'>&nbsp;</td><td colspan='2'>&nbsp;</td><td colspan='2'>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";
							
							?>
						</tbody>
						<tr>
							<td colspan="2" class="text-right">合计：</td>
							<td colspan="6"><?php echo $BillInfo[0]["money"];?>元</td>
						</tr>
						<tr class="text-center">
							<td colspan="8">
								<span class="col-lg-4"><b>美容技师签字：</b></span>
								<span class="col-lg-4 "><b>质检签字：</b></span>
								<span class="col-lg-4"><b>顾客签字：</b></span>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="h6">注意：①此单据中预计费用是预估费用，实际费用以结算中最终费用为准。</p>
				<p class="h6">②将车辆教给我店检修时，已提示将车内贵重物品自行收起并妥善保管。如有遗失本店概不负责。</p>
			</div>
			
			<!--endprint-->
		</div>
</body>
</html>
