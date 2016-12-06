
<?php 
	$kid=$_GET["kid"];
	require_once 'mysql.class.php';
	require_once 'function.php';
	$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3"></div>
		<div class="span2"></div>
		<div class="span1"></div>
		<div class="span6"></div>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<img alt="140x140" src="img/a.jpg" class="img-circle" /> <span class="label badge-success">练方梯</span> <span class="badge badge-warning">1250</span>
		</div>
		<div class="span1">
		</div>
		<div class="span4">
			<form class="form-inline">
				<fieldset>
					<legend>客户个人信息管理</legend>
					<p>客户姓名:<input type="text" /></p>
					<p>客户电话:<input type="text" /></p>
					<p>客户地址:<input type="text" /></p>
					<br />
					<button class="btn btn-danger" type="submit">提交</button>
				</fieldset>
			</form>
		</div>
		<button class="btn btn-success" type="button">绑定微信</button>
		<!--<img alt="140x140" src="img/a1.jpg" width=140 height=140 class="img-polaroid" />-->
		
		<?php 
			//echo  "二维码地址：[<img src='".QR("www.baidu.com")."' />]";
			echo "二维码生成：".QR("1")."";
		?>
		
		<div class="span5">
			<table class="table">
				<thead>
					<tr>
						<th>
							序号
						</th>
						<th>
							编号
						</th>
						<th>
							金额
						</th>
						<th>
							时间
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							1
						</td>
						<td>
							TB - Monthly
						</td>
						<td>
							01/04/2012
						</td>
						<td>
							Default
						</td>
					</tr>
					<tr class="success">
						<td>
							1
						</td>
						<td>
							TB - Monthly
						</td>
						<td>
							01/04/2012
						</td>
						<td>
							Approved
						</td>
					</tr>
					<tr class="error">
						<td>
							2
						</td>
						<td>
							TB - Monthly
						</td>
						<td>
							02/04/2012
						</td>
						<td>
							Declined
						</td>
					</tr>
					<tr class="warning">
						<td>
							3
						</td>
						<td>
							TB - Monthly
						</td>
						<td>
							03/04/2012
						</td>
						<td>
							Pending
						</td>
					</tr>
					<tr class="info">
						<td>
							4
						</td>
						<td>
							TB - Monthly
						</td>
						<td>
							04/04/2012
						</td>
						<td>
							Call in to confirm
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>

</body>
</html>