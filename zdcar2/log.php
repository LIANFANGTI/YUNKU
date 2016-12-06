<!DOCTYPE html>
<?php 
	require_once 'function.php';
?>
<html>

	<head>
		<meta charset="UTF-8">
		<title>操作记录</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/shouyin.css" rel="stylesheet" />
		<script src="js/js.js"></script>
		<script src="js/shouyin.js"></script>
		<script src="js/jquery-1.10.2.js"></script>
	</head>
	<body style='padding-left:50px;'>
		<?php
			$LOGS=SELECT("log","DATE_FORMAT(date,'%Y%m%d') DAYDATE","C=$cp  GROUP BY DAYDATE order by date desc");
			foreach($LOGS as $ROW){
				echo "<hr style='margin:15px 0px 0px 0px;'><h3 style='margin:15px 0px 0px 0px;'>".$ROW["DAYDATE"]."</h3>";
				$LOGI=SELECT("log","DATE_FORMAT(date,'%H:%i:%s') HMS,U,type,obj,value,value2","DATE_FORMAT(date,'%Y%m%d')=".$ROW["DAYDATE"]." AND C=$cp order by date desc");
				
				foreach($LOGI as $ROWI){
					echo "<h5>".$ROWI["HMS"]." ";
					switch($ROWI["type"]){
						case "使用":
							echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b>". 
								 $ROWI["type"]."了".
								 "<b style='color:#e9c341;'>".selecta("shop","sid",$ROWI["value"],"sname")."</b>".
								 "[".$ROWI["value2"]."]个</h5>";
						break;
						case "充值":
							echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b>".
								 "为<b style='color:#5cb85c;'>".selecta("kehu","id",$ROWI["obj"],"name")."</b>充值了".
								 $ROWI["value"].
								 "元，充值方式<b style='color:".selecta("zfmode","id",$ROWI["value2"],"color").";'> ".
								 selecta("zfmode","id",$ROWI["value2"],"name")."</b></h5>";
						break;
						case "上传":
							echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b>". 
								 $ROWI["type"]."了".
								 "<b style='color:#e9c341;'>".selecta("shop","sid",$ROWI["value"],"sname")."</b>".
								 "[".$ROWI["value2"]."]个</h5>";
						break;
						case "添加":
							switch($ROWI["obj"]){
								case"商品":
									echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b>". 
										  $ROWI["type"]."了".
										 "<b style='color:#e9c341;'>".selecta("shop","sid",$ROWI["value"],"sname")."</b>".
										 "[".$ROWI["value2"]."]个</h5>";
								break;
								case"子账户":
									echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b><b style='color:#4868e1;'>添加</b>了子账户<b>".$ROWI["value2"]."</b>";
								break;
							}
							
						break;
						case "删除":
							switch($ROWI["obj"]){
								case"账户":
									echo "<b style='color:#c43e97;'>".selecta("user","id",$ROWI["U"],"name")."</b><b style='color:#F00;'>删除</b>了子账户:<b>".$ROWI["value2"]."</b>";
								break;
							}
						break;
					}
				}
			}
			//print_r($LOGS);
			//%H%i%s
		?>	
	</body>
</html>
