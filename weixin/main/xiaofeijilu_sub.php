<!DOCTYPE html>
<?php ini_set('display_errors','On');require_once '../../lib/mysql.class.php';require_once '../../lib/fun.php'; ?>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>

		<!-- Bootstrap -->
		<link href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>

	<body>
		<?php 
		   //echo $_GET["bid"];
		   $BILL=SELECT("bill","*","id=".$_GET["bid"]);
		   //print_r($BILL);
		   $AITEM=SELECT("aitem","*","bid=".$BILL[0]["id"]);
		   $ASHOP=SELECT("ashop","*","bid=".$BILL[0]["id"]);
		   //print_r($AITEM); 
		   //print_r($BILL);
	     ?>
		<table class="table table-striped">
			<tbody>

				<tr>
					<td>
						订单编号
					</td>
					<td>
						<?php echo $BILL[0]["bid"]; ?>
					</td>
				</tr>
				<tr>
					<td>
						订单类型
					</td>
					<td>
						<?php echo SELECTA("bill_type","id",$BILL[0]["btype"],"NAME"); ?> 
					</td>
				</tr>
				<tr>
					<td>
						订单状态
					</td>
					<td>
						<?php
						if(!$BILL[0]["zt"]){
								$JiesuanButton="<input type='button' class='btn btn-danger btn-sm'  value='未结算'/>";
							}else{
								$JiesuanButton="<input type='button' class='btn btn-success btn-sm' value='已结算'/>";
							}
							echo $JiesuanButton; 
						?>
					</td>
				</tr>
				<tr>
					<td>
						优惠
					</td>
					<td>
						<?php
							if($BILL[0]["yhtype"]!=""){
							 	if($BILL[0]["yhtype"]==0){
									echo "减免".$BILL[0]["yhval"]."元";
									$YHMONEY=($BILL[0]["money"]*1)-$BILL[0]["yhval"];
								}else{
									echo "折扣<b class='btn btn-warning btn-sm'>".$BILL[0]["yhval"]."%</b>";
									$YHMONEY=($BILL[0]["money"]*1)*$BILL[0]["yhval"]/100;
								}
								
							}else{
								echo "无"; 
								$YHMONEY=$BILL[0]["money"]*1;
							}
						//echo $BILL[0]["type"]; 
						?> 
					</td>
				</tr>
				<tr>
					<td colspan=2>
						消费的项目
					</td>
				</tr>
				<?php 
				  foreach($AITEM as $ROW){
					  echo"<tr><td>".SELECTA("item","id",$ROW["iid"],"itemname")."</td><td>".$ROW["gs"]."元</td></tr>";
				  }  
				  if(empty($AITEM))echo"<tr><td colspan=2>无</td></tr>";
				?>
				<tr>
					<td colspan=2>
						使用零件
					</td>
				</tr>
				
				<?php 
				  foreach($ASHOP as $ROW){
					  echo"<tr><td>".SELECTA("shop","sid",$ROW["sid"],"sname")."</td><td>".$ROW["money"]."元</td></tr>";
				  }  
				  if(empty($ASHOP))echo"<tr><td colspan=2>无</td></tr>";
				?>
				
				
				
				
				<tr>
					<td>
						总金额
					</td>
					<td>
						<?php echo $BILL[0]["money"]; ?>元
					</td>
				</tr>
				<tr>
					<td>
						实付金额
					</td>
					<td>
						<?php echo $YHMONEY; ?>元
					</td>
				</tr>

			</tbody>
		</table>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
	</body>

</html>