<!DOCTYPE html>
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
		@session_start();
		if(logincheck()){
			$openid=$_SESSION["openid"];
			$db->select("kehu","*","wx_openid='".$openid."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			if(!empty($kehu)){
				$db->select("czjl","*","kh=".$kehu[0]["id"]." order by date desc");$czjl=$db->fetchArray(MYSQL_ASSOC);
			}else{
				//die("您未同步，暂无数据");
			}	
		}else{
			$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9c3164046547198a&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
	        header('Location: '.$url.'');	
		}	
?>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>充值记录</title>

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
<div class="container-fluid">
    <div class="row">
        <table class="table table-hover table-striped table-bordered">
            <tbody>
            <tr>
				<td><span>序号</span></td>
                <td><span>时间</span></td>
                <td><span>金额</span></td>
            </tr>
			<?php
				if(!empty($czjl)){
				$i=0;
				foreach($czjl as $row){
					echo "<tr>
							<td>".++$i."</td>
							<td>".$row["date"]."</td>
						    <td>￥".$row["je"]."</td>
					     </tr>";
				}
				}else{
					echo"<tr><td colspan='5'>暂无充值记录</td></tr>";
				}
				
				function jsfst($a){
					switch($a){
						case "0":$b="未选择支付类型";break;
						case "1":$b="支付宝支付";break;
						case "2":$b="微信支付";break;
						case "3":$b="现金付款";break;
						case "4":$b="合作商付款";break;
					}	
					return $b;
				}
				
			?>
            </tbody>



        </table>
    </div>




</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
</body>
</html>