<!DOCTYPE html>
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
	//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
		@session_start();
		if(logincheck()){
			$openid=$_SESSION["openid"];
			$db->select("kehu","*","wx_openid='".$openid."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			//print_r($kehu);
			echo $db->printMessage();	
			if(!empty($kehu)){
				$db->select("car2","*","kh=".$kehu[0]["id"]);$car=$db->fetchArray(MYSQL_ASSOC);				
			}else{
				//die("您未同步数据");
			}
			//$db->select("kehu","*","wx_openid='".$kehu_wx[0]["openid"]."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			//echo $db->printMessage();		
		}else{
			$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9c3164046547198a&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
			header('Location: '.$url.'');	
		}

	
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/car.css"  rel="stylesheet"/>
		<link href="css/weui.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<title>我的车辆</title>
	</head>
	<body>
			<!-- <div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-money">车辆品牌</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-medkit">车型</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-cog"> 车牌号</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-calendar">购车日期</span></div>
			</div> -->
    				<table class="table table-striped table-bordered text-center">
					<tbody>
                    <th>
                        <td>车牌号</td>
						<td>VIN码</td>
						<td>最新公里数</td>
                        <td>保险到期</td>
						<td>年检到期</td>
                    </th>
                    <?php
						if(!empty($car)){
							$c=0;	 
							foreach($car as $row){
								echo"<tr><td>".++$c."</td>
										<td>".$row["carid"]."</td>
										<td>".$row["vin"]."</td>
										<td>".$row["km"]."KM</td>
										<td>".$row["date_bx"]."</td>
										<td>".$row["date_nj"]."</td>
									</tr>";
							}
						}else{
							echo"<tr><td colspan='5'>
									<div class='row'>
									<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'>
										<span class='fa fa-cab'>暂无车辆信息</span>	
									</div>
									</div></td></tr>";
						}
					?>
					</tbody>
				</table>
		<div class="container-fluid">
				<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center ">
					
				<a href="tjcar.php"><input class="weui_btn weui_btn_primary"  type="button" value="添加车辆"/></a>
					
				</div>
			</div>
		</div>
	</body>
</html>
