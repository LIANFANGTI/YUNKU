<!DOCTYPE html>
<html>
<?php
   	require_once 'function.php';
 ?>
	<head>
		<meta charset="utf-8" />
		<title>营业额统计</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<link rel="stylesheet" href="css/5-1.css" type="text/css" />
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/js.js"></script>
		
		<!-- bt框架-->
			<script src="js/bootstrap.min.js"></script>
			<link href="css/bootstrap.min.css" rel="stylesheet" />
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- bt框架End-->

	</head>

	<body>

		<div id="main">
			<input type='date' id='StartDate' class='form-control' style='width:200px;float:left;margin:0px 5px;'/>
			<input type='date' id='EndDate' class='form-control' style='width:200px;float:left;margin:0px 5px;'/>
			<input type='button' onclick='ShowChart()' class='btn btn-info btn-sm' value='查询'/>
			<input type='button' onclick='ShowMonthChart()' class='btn btn-info btn-sm' value='本月'/>
			<br>
			<br>
			<hr>
			<div id="Charts1" style="width:100%;height:400px;"></div>	
		</div>
			<script src="Chart/echarts.min.js"></script>
			<script src="js/5-1.js"></script>
		
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="45" colspan="5" align="center" valign="middle"></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
                  <?php
					   $i=0;$yye=0;$asp=0;$ait=0;
                       $db->select("bill","*","company=".$cp." and del");$bill=$db->fetchArray(MYSQL_ASSOC);
    				   $db->select("ashop","*","company=".$cp." ");$ashop=$db->fetchArray(MYSQL_ASSOC);
					   $db->select("aitem","*","company=".$cp."");$aitem=$db->fetchArray(MYSQL_ASSOC);
					   /*销售前十计算*/
	    			    $db->select("ashop","sid as sp,sum(sl) as sc ","company=".$cp." group by sid order by sc desc");
						$qashop=$db->fetchArray(MYSQL_ASSOC);
						$db->select("aitem","iid as it,sum(gs) as sc ","company=".$cp." group by iid order by sc desc");
						$qitem=$db->fetchArray(MYSQL_ASSOC);
						 //SELECT sid as sp, SUM(sl) as sc FROM `ashop`  GROUP BY sid ORDER BY  sc DESC;
						foreach($bill as $row){
							 $yye+=$row["zje"];
							  $i++;
						}	
						foreach($ashop as $row){
							$db->select("shop","*","sid=".$row["sid"]."");$shop=$db->fetchArray(MYSQL_ASSOC);
							$asp+=($row["sl"]*$shop[0]["sdj"]);
						}
						foreach($aitem as $row){
						   $db->select("item","*","id=".$row["iid"]."");$item=$db->fetchArray(MYSQL_ASSOC);
						    $ait+=($row["gs"]*$item[0]["money"]);
						}	
						?>
						<td width="20%" height="128" align="center" valign="middle">
							<table bordercolor="#EB1434" width="77%" border="1" cellspacing="0" cellpadding="0">
								<tr>
									<td height="103" align="center">
										<p><font color="#EB1434">营业金额</font></p>
										<p><font color="#EB1434"><?php echo $yye; ?>元</font></p>
									</td>
								</tr>
							</table>
						</td>
						<td width="20%" align="center" valign="middle">
							<table bordercolor="#CC9900" width="77%" border="1" cellspacing="0" cellpadding="0">
								<tr>
									<td height="103" align="center">
										<p><font color="#CC9900">销售商品</font></p>
										<p><font color="#CC9900"><?php echo $asp; ?>元</font></p>
									</td>
								</tr>
							</table>
						</td>
						<td width="20%" align="center" valign="middle">
							<table bordercolor="#00FF33" width="77%" border="1" cellspacing="0" cellpadding="0">
								  <tr>
									<td height="103" align="center">
												<p><font color="#00FF33">项目销售</font></p>
												<p><font color="#00FF33"><?php echo $ait; ?>元</font></p>
											</td>
										</tr>
									</table>
								</td>
								<td width="20%" align="center" valign="middle">
									<table bordercolor="#0099FF" width="77%" border="1" cellspacing="0" cellpadding="0">
										<tr>
											<td height="103" align="center">
												<p><font color="#0099FF">会员充值</font></p>
												<p><font color="#0099FF">0</font></p>
											</td>
										</tr>
									</table>
								</td>
								<td width="20%" align="center" valign="middle">
									<table bordercolor="#6666CC" width="77%" border="1" cellspacing="0" cellpadding="0">
										<tr>
											<td height="103" align="center">
												<p><font color="#6666CC">开单车辆</font></p>
												<p><font color="#6666CC"><?php echo $i; ?>辆</font></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="51%" align="center">
												<table width="92%" bordercolor="#CCCCCC" border="1" cellspacing="0" cellpadding="0">
													<tr>
														<td height="28" colspan="4">商品销售前十</td>
													</tr>
													<tr>
                                                    	<td>排名</td>
														<td height="36" align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">商品编码</td>
														<td align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">商品名称</td>
														<td align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">数量</td>
														<td align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">金额</td>
													</tr>
                                                    
											<?php
											$i=0; 
										     foreach($qashop as $row){
												 $i++;if($i>=10)break;
												$db->select("shop","*","sid=".$row["sp"]."");$shop=$db->fetchArray(MYSQL_ASSOC);
												echo "
													<tr style='text-align:center;'>
														<td>Top".$i."</td>
														<td>SP201234560".$shop[0]["sid"]."</td>
														<td>".$shop[0]["sname"]."</td>
														<td>".$row["sc"].$shop[0]["sdw"]."</td>
														<td>".$row["sc"]*$shop[0]["sdj"]."元</td>
													</tr>
												";	
											}
												?>
												</table>
											</td>
											<td width="49%" align="center" valign="top">
												<table width="92%" bordercolor="#CCCCCC" border="1" cellspacing="0" cellpadding="0">
													<tr>
														<td height="31" colspan="4">项目销售前十</td>
													</tr>
													<tr>
                                                    	<td>排名</td>
														<td width="32%" height="31" align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">项目编码</td>
														<td width="32%" align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">项目名称</td>
														<td width="22%" align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">数量</td>
														<td width="14%" align="center" onmouseover="this.style.backgroundColor='#2AAF59'" onmouseout="this.style.backgroundColor=''">金额</td>
													</tr>
										<?php
											$i=0; 
										     foreach($qitem as $row){
												 $i++;if($i>=10)break;
												$db->select("item","*","id=".$row["it"]."");$item=$db->fetchArray(MYSQL_ASSOC);
												echo "
													<tr style='text-align:center;'>
														<td>Top".$i."</td>
														<td>XM201234560".$item[0]["itemid"]."</td>
														<td>".$item[0]["itemname"]."</td>
														<td>".$row["sc"]."工时</td>
														<td>".$row["sc"]*$item[0]["money"]."元</td>
													</tr>
												";	
											}
												?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
				</table>
		</div>
					<div class="TabbedPanelsContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="66" align="center">统计日期
									<input type="date" height=25/>
									<input type="date" height=25/> &nbsp;&nbsp;汇总方式
									<input name="radio" type="radio" id="radio" value="radio" checked> 日
									<label for="radio"></label>
									<input type="radio" name="radio2" id="radio2" value="radio2">
									<label for="radio2">月
										<input type="submit" name="button4" id="button4" value="查询" class="botton">
									</label>
								</td>
							</tr>
							<tr>
								<td height="329" align="left" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center">营业额趋势图</td>
										</tr>
										<tr>
											<td align="center" valign="middle"><img src="4_wpsDCB7.tmp.jpg" alt="" width="545" height="295"></td>
										</tr>
									</table>
									<p>&nbsp;</p>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		
			

		</div>

	</body>

</html>