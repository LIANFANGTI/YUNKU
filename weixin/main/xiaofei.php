<!DOCTYPE html>
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
		@session_start();
		if(logincheck()){
			$openid=$_SESSION["openid"];
			$db->select("kehu","*","wx_openid='".$openid."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			if(!empty($kehu)){
				$db->select("bill","*","kehu=".$kehu[0]["id"]." order by date desc");$bill=$db->fetchArray(MYSQL_ASSOC);
			}else{
				//die("您未同步，暂无数据");
			}	
		}else{
			die("您未登录 无权访问");
		}	
?>
<html>
	<head>
		<meta charset="UTF-8">
			<meta name="viewport" content="width=620px,initial-scale=1,target-densitydpi=device-dpi,minimum-scale=1,maximum-scale=1,user-scalable=1" />  
			<link  href="http://www.zduber.com/weixin/main/css/bootstrap.min.css" rel="stylesheet" />
			<link  href="http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
			<link  href="http://www.zduber.com/weixin/main/css/xiaofei.css" rel="stylesheet" />
		<title>我的消费</title>
	</head>
	<body>
		
		<div class="container-fluid">
			<!--<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-calendar"> 日期</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-medkit"> 项目</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-cog"> 材料</span></div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center"><span class="fa fa-money">金额</span></div>
			</div>-->
			<div class="row">
			<center>
				<table class="table table-striped table-bordered text-center">
					<!-- <th><span class="fa fa-calendar">序号</span></th>
					<th><span class="fa fa-calendar"> 日期</span></th>
					<th><span class="fa fa-medkit"> 项目</span></th>
					<th><span class="fa fa-cog"> 材料</span></th>
					<th><span class="fa fa-money">金额</span></th>
					<th><span class="fa fa-money">状态</span></th> -->
					<th><span>序号</span></th>
					<th><span>日期</span></th>
					<th><span>项目</span></th>
					<th><span>材料</span></th>
					<th><span>金额</span></th>
					<th><span>状态</span></th>
					<tbody>
                     <?php
					 $i=0;
					 if(!empty($bill)){
		   				foreach($bill as $row){
							if(!$row["zt"]){
								$JiesuanButton="<input type='button' class='btn btn-danger btn-xs'  value='未结算'/>";
							}else{
								$JiesuanButton="<input type='button' class='btn btn-success btn-xs' value='已结算'/>";
							}
							$db->select("aitem","*","bid=".$row["id"]);$aitem=$db->fetchArray(MYSQL_ASSOC);
							$db->select("ashop","*","bid=".$row["id"]);$ashop=$db->fetchArray(MYSQL_ASSOC);
							$aitem1=$ashop1="";
							if(!empty($aitem)){foreach($aitem as $row1){$aitem1.="<b class='btn btn-info btn-xs'>".iname($row1["iid"])."(".$row1["gs"]."元)</b>";}}else{$aitem1="<b class='btn btn-warnig btn-xs'>无</b>";}
							if(!empty($ashop)){foreach($ashop as $row2){$ashop1.="<b class='btn btn-info btn-xs'>".sname($row2["sid"])."(".$row2["money"]."元)</b>";}}else{$ashop1="<b class='btn btn-warnig btn-xs'>无</b>";}
               				echo"<tr>
									<td>".(++$i)."</td>
									<td>".$row["date"]."</td>
									<td>$aitem1</td>
									<td>$ashop1</td>
									<td>￥".($row["zje"]*1.00)."</td>
									<td>$JiesuanButton</td>
								</tr>";
					    }
					 }else{
						 echo"<tr><td colspan='6'>暂无消费记录</td></tr>";
						 
					 }
		   ?>

					</tbody>
				</table>
				</center>
			</div>
		</div>

	</body>
</html>
