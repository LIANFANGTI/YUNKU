<!DOCTYPE html>
<html>
<?php
   	require_once 'function.php';
 ?>
	<head>
		<meta charset="utf-8" />
		<title>库存预警</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
	</head>

	<body>
		<div class="main">
			<div class="box">
				<div class="box_title"><h4 class="caption" >库存预警</h4></div>
				     <table class="table1">
                    	<tr><td>
                        	 <input type="search"  class="input_td" onKeyUp="tjcx()" id="tj" placeholder="输入姓名或会员卡号或车牌号等信息进行查询"/>
                        </td></tr>
                    </table>

						<table class="table1">
							<tr>
								<td>序号</td>
								<td>商品编码</td>
								<td>商品名称</td>
								<td>当前库存</td>
								<td>安全库存</td>
								<td>单位</td>
								<td>规格</td>
								<td>适用车型</td>
							</tr>
                            <?php 
							$i=1;$zje=0;$zsl=0;
							$db->select("shop", "*", "company=".$cp." and del and skc<akc");
							$shop = $db->fetchArray(MYSQL_ASSOC);
							foreach($shop as $row){
								$zsl+=$row["skc"];
								$zje+=($row["skc"]*$row["sdj"]);
								$row["akc"]==0?$akc="未设置":$akc=$row["akc"]*1;
								echo"<tr>
										<td>".$i++."</td>
										<td>".$row["sid"]."</td>
										<td>".$row["sname"]."</td>
										<td>".$row["skc"].$row["sdw"]."</td>
										<td>".$akc.$row["sdw"]."</td>
										<td>".$row["sdw"]."</td>
										<td>".$row["sgg"]."</td>
										<td>".$row["scar"]."</td>
									</tr>";
									
							}
							?>

							<tr>
								<td>合计</td>
								<td colspan="7"><?php echo "共<b style='color:red;'>".($i-1)."</b>种商品库存不足，总价值为<b style='color:red;'>".$zje."</b>元，总数量为<b style='color:red;'>".$zsl."</b>"; ?></td>
							</tr>

						</table>

					</div>
			</div>
		</div>
	</body>

</html>