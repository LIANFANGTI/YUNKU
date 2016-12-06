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
			$LOGS=SELECT("log2","DATE_FORMAT(date,'%Y%m%d') DAYDATE","C=$cp  GROUP BY DAYDATE order by date desc");
			foreach($LOGS as $ROW){
				echo "<hr style='margin:15px 0px 0px 0px;'><h3 style='margin:15px 0px 0px 0px;'>".$ROW["DAYDATE"]."</h3>";
				$LOGI=SELECT("log2","DATE_FORMAT(date,'%H:%i:%s') HMS,U,STRING,JSON","DATE_FORMAT(date,'%Y%m%d')=".$ROW["DAYDATE"]." AND C=$cp order by date desc");
			
				foreach($LOGI as $row){
					//echo $row["STRING"]."<br>";
					$MUBAN=array();
					$MUBAN=SELECT("logstr","STRING","name='".$row["STRING"]."'");//SELECTA("logstr","STRING","name",$row["STRING"]);
					$String=$MUBAN[0]["STRING"]; 
					
					$json=json_decode($row["JSON"]);
					$String=str_replace_once("%u",SELECTA("user","id",$row["U"],"name"),$String);
					 foreach($json as $a){
						$String=str_replace_once("%v",is_array($a)?SELECT_C($a):$a,$String);
					 }
						
					 echo $row["HMS"]."--".($String);
					 echo"<hr>";
					 //print_r($json);	
				}
				//echo str_replace_once("world","Shanghai","Hello world world!");
				//print_r($LOGI);
					
				
			}
			
			
			//print_r($LOGS);
			//%H%i%s
		?>	
	</body>
</html>
