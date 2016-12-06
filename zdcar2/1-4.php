<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>销售退货单管理</title>
		<link rel="stylesheet" href="css/index.css" />
	</head>
<?php
 	require_once 'function.php';
	//require_once '../function/fun.php';
	echo $cp;
	$db->select("tuihuo", "*", "cp=".$cp );$tuihuo = $db->fetchArray(MYSQL_ASSOC);//退货表读取
 ?>
	<body>
		<div class="main">
			<div class="box" >
          		<div class="box_title">
                	<h4 class="caption">退货单管理</h4>
                </div>
				<div class="box_content">
					<table class="table1" cellspacing="0">
						<tr>
							<td>序号</td>
							<td>退货单号</td>
							<td>订单单号</td>
							<td>退货日期</td>
							<td>客户名称</td>
							<td>联系手机</td>
							<td>车牌号</td>
							<td>经手人</td>
                            <td>商品名称</td>
                            <td>商品单价</td>
                            <td>退货数量</td>
							<td>退款金额</td>
							<td>结算日期</td>
							<td>结算方式</td>
							<td>结算状态</td>
							<td>退货原因</td>

						</tr>
                        <?php 
						$i=0;
							foreach($tuihuo as $row){
								
								echo"<tr>
									<td>".++$i."</td>
									<td>".$row["id"]."</td>
									<td><a href='ebill.php?bid=".$row["bid"]."'>".bl($row["bid"],"bid")."</a></td>
									<td>".$row["date"]."</td>
									<td>".kh($row["khid"],"name")."</td>
									<td>".kh($row["khid"],"phone")."</td>
									<td>".kh($row["khid"],"carid")."</td>
									<td>".$row["jsr"]."</td>
									<td>".sp($row["sp"],"sname")."</td>
									<td>".sp($row["sp"],"sdj")."元</td>
									<td>".($row["sl"]*1).sp($row["sp"],"sdw")."</td>
									<td>".($row["sl"]*1)*sp($row["sp"],"sdj")."元</td>
									<td>".$row["jsdate"]."</td>
									<td>".jsfs($row["jsfs"])."</td>
									<td>".jszt($row["jszt"])."</td>
									<td>".$row["tips"]."</td>
								</tr>";	
							}
						?>
						<tr>
							<td colspan="15">暂无数据</td>
						
						</tr>
						<tr>
							<td>合计：</td>
							<td colspan="14">0.00</td>

						</tr>
					</table>
				</div>
			</div>

			</div>
			
		</div>

	</body>

</html>