<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
ini_set('display_errors','On'); 
	require_once '../lib/fun.php';
	$kehuCollect=SELECT("kehu_collect","*","1=1");
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>意向客户信息收集表</title>
    <meta charset="utf-8" />
   
    <script src="../zdcar2/js/js.js"></script>
    <script src="js/jquery-1.10.2.js"></script>

	<!-- bt框架-->
		<link href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
	<!-- bt框架End-->
	<style>
		.mian1{
			width:100px;
			margin: 0;
			background: url(img/bg.jpg);
			repeat:repeat;
			color: #797979;
			repeat-y=none;
		}
		.in{
			width:200px;
		}
		.font-yahei{
			font-family: Microsoft YaHei,'宋体' , Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;
		}
	</style>
</head>

<body >



  <table class="table table-bordered table-condensed table-hover table-striped font-yahei ">
		<tr align="center"><td colspan=7><h3 class='font-yahei'>意向客户信息收集表</h3></td></tr>
		<tr>
			<td>序号</td>
			<td>姓名</td>
			<td>公司名</td>
			<td>联系电话</td>
			<td>提交时间</td>
			<td>备注信息</td>
			<td>操作</td>
		</tr>
		<?php
			$i=0;
			foreach($kehuCollect as $row){
				echo "<tr>
						   <td>".++$i."</td>
						   <td>".$row["name"]."</td>
						   <td>".$row["companyName"]."</td>
						   <td>".$row["phone"]."</td>
						   <td class='in'>".$row["date"]."</td>
						   <td style='width:500px;'><input onchange='updateKHCInfo(".$row["id"].",this)' style='border:0px;' type='text' value='".$row["tips"]."' class='form-control ' /></td>
						   <td style='width:30px;'><input onclick='delKHC(".$row["id"].")' class='btn btn-danger btn-sm' value='删除' /></td>
					  
					  </tr>";
			}
		
		?>
  </table>
	
</div>
<script>
	function updateKHCInfo(id,e){
		UPDATE("kehu_collect","tips",e.value,"id="+id,true);
	}
	function delKHC(id){
		if(confirm("确认删除?")){
			DELETE("kehu_collect","id="+id);
			location.reload();
		}
	}
</script>
</body>
</html>