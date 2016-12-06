<!DOCTYPE html>
<?php 
	ini_set('display_errors','On');
	require_once '../../lib/mysql.class.php';
	require_once '../../lib/fun.php';
	@session_start();
	$COMPANY_ID=$_SESSION["company"];	
?>
<html lang="en">

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

	<body>

		<table class="table table-hover table-striped table-bordered">
			<thead>
				<th>序</th>
				<th>日期</th>
				<th>金额</th>
				<th>状态</th>
			</thead>

			<tbody>
			   <?php
			        @session_start(); 
					if(logincheck()){
						$openid=$_SESSION["openid"];
						$kehu=SELECT("kehu","*","wx_openid='".$openid."'");
						//echo $openid;
						//echo "<br>".$kehu[0]["id"];
						if(!empty($kehu)){
							$bill=SELECT("bill","*","kehu=".$kehu[0]["id"]." order by date desc");
						}else{
							die("您未同步，暂无数据");
						}	
					}else{
						$url=SELECTA("company","id",$COMPANY_ID,"LOGIN_API");
						//header('Location: '.$url.'');	
					}	
			         $i=0;
					 if(!empty($bill)){
		   				foreach($bill as $row){
							if(!$row["zt"]){
								$JiesuanButton="<input type='button' class='btn btn-danger btn-sm'  value='未结算'/>";
							}else{
								$JiesuanButton="<input type='button' class='btn btn-success btn-sm' value='已结算'/>";
							}
							$URL='xiaofeijilu_sub.php?bid='.$row["id"].'';
						    echo "<tr>
									<td><a href=$URL>".++$i."</a></td>
									<td><a href=$URL>".$row["date"]."</a></td>
									<td><a href=$URL>￥".($row["zje"]*1.00)."</a></td>
									<td><a href=$URL>$JiesuanButton</a></td>
								  </tr>";
					    }
					 }else{
						 echo"<tr><td colspan='6'>暂无消费记录</td></tr>";
						 
					 }
			   
			   
			   ?>
				
			</tbody>

		</table>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
	</body>

</html>