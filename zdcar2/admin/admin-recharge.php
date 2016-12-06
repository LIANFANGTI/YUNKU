<!DOCTYPE html>
<?php require_once '../function.php';
?>

<html>
	<head>
		<meta charset="utf-8" /> 
		<title>管理</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="../js/jquery-1.10.2.js"></script>
        <script src="../js/js.js"></script>
		<script charset="gb2312" src="js/admin.js"></script>
		<!-- bt框架-->
		<script src="../js/bootstrap.min.js"></script>
		<link href="../css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
	</head>
	<body>
		<div>
		
		</div>
		<table class="table table-striped table-bordered table-hover text-center">
			<tr><td colspan="7"><h1><?php echo $cpname."充值记录管理"; ?></h1></td></tr>   
			<tr >
				<td>序号</td>
				<td>充值时间</td>
				<td>充值金额</td> 
				<td>支付方式</td>
				<td>客户</td>
				<td>备注信息</td>
				<td>操作</td> 
			</tr>
			<tbody id="CONTENT">
			<?php 
				$i=1;
				$db->select("czjl","*","company=".$cp."");$USERS=$db->fetchArray(MYSQL_ASSOC);
				foreach($USERS as $ROW){
					echo "<tr><td>".$i++."</td>
						  <td name='User'>".$ROW["date"]."</td>
						  <td>".$ROW["je"]."</td>
						  <td>".$ROW["zf"]."</td>
						  <td>".$ROW["kh"]."</td>
						  <td>".$ROW["tips"]."</td>
						  <td>
							<input type='button' class='btn btn-sm btn-warring' onclick='EditUser()'  value='修改'/>
							<input type='button' class='btn btn-sm btn-danger' onclick='DeleteUser(".$ROW["id"].")'  value='删除'/> 
						  </td>
						  </tr>";
				}
			?> 
		   </tbody>
			<tr>
				<td colspan="7"><input type="button" class="btn btn-info" value="添加" onclick="AddUser(this)" id="AddUserButton"/></td>
				
			
			</tr>
		</table>
	</body>
</html>