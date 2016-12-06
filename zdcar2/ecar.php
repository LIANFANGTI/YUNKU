<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
	$kid=$_GET["kid"];
	require_once 'mysql.class.php';
	$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>车辆信息修改</title>
    <meta charset="utf-8" />
   
    <script src="js/js.js"></script>
	<script src="js/eshop.js"></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/ekehu.js"></script>
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
	</style>
</head>

<body onbeforeunload="alert('保存成功')">



    <?php 
			$carid=$_GET["cid"];
			$db->select("car2", "*", "carid='".$carid."'");$cartb = $db->fetchArray(MYSQL_ASSOC);
			echo $db->printMessage();
			$carid=$cartb[0]["carid"];
			$car=$cartb[0]["car"];
			$pp=$cartb[0]["pp"];
			$buydate=$cartb[0]["buydate"];
			$vin=$cartb[0]["vin"];
			$km=$cartb[0]["km"];	
			$tips=$cartb[0]["tips"];	
	 //echo $sname; 


	
	?>

<div style='margin:100px;width:50%;' class='text-center'>
  <table class="table table-striped table-bordered table-hover">
	<tr>
		<td>车牌号:</td>
		<td><input id='carid' class="form-control in"   type='text' placeholder='车牌号'   value='<?php echo $_GET["cid"]; ?>'    onchange="UDATECAR('carid',this)" /></td>
	</tr>
	<tr>
		<td>VIN码:</td>
		<td><input id='car'   class="form-control in"  type='text' placeholder='车架号(VIN)'   value='<?php echo $cartb[0]["vin"]; ?>'    onchange="UDATECAR('vin',this)"/></td>
	</tr>
   <tr>
	<td>最新公里数:</td>
	<td><input id='pp'     class="form-control in"  type='text' placeholder='最新公里数'   value='<?php echo $cartb[0]["km"]; ?>'      onchange="UDATECAR('km',this)"/></td>
   </tr>
   <tr>
	<td>保险到期日</td>
	<td><input id='buydate'   class="form-control in"   type='date' title='<?php echo $_GET["date_bx"]; ?>'   value='<?php echo $cartb[0]["date_bx"]; ?>'     onchange="UDATECAR('date_bx',this)"/></td>
   </tr>
   <tr>
	<td>年检到期日</td>
	<td><input id='vin'    class="form-control in"   type='date'  title='<?php  echo $_GET["date_nj"]; ?>'       value='<?php  echo$cartb[0]["date_nj"]; ?>'      onchange="UDATECAR('date_nj',this)"/></td>
   </tr>
   <tr>
	   <td>备注信息:</td>
	   <td><input id='tips'class="form-control in"   type='text' placeholder='备注信息'       value='<?php echo $tips; ?>' onchange="UDATECAR('tips',this)"/></td>
  </tr>
  <tr class='text-center'>
	 <td colspan=7 ><input type='button' class='btn btn-success btn-xs' value='保存' onclick="ok()"/></td>
	 
  </tr>
 
  
  </table>
	
</div>
<script>
	function save(){
			/*	carid='<?php echo $carid;?>';
				//alert(carid)
				CARID=document.getElementById("carid").value,
				car=document.getElementById("car").value,
				pp=document.getElementById("pp").value,
				buydate=document.getElementById("buydate").value,
				vin=document.getElementById("vin").value,
				km=document.getElementById("km").value,
				tips=document.getElementById("tips").value,
		$.post("http://"+window.location.host+"/zdcar2/ajax.php",{carid:carid,carid2:carid2,car:car,pp:pp,buydate:buydate,vin:vin,km:km,tips:tips,atype:"ecar"},function(data,aaa){
				//alert(data);
			})*/
	}
	function UDATECAR(COL,E){
		var VAL=E.value;
		//alert(COL)
		CARID_V=document.getElementById("carid").value;
		
	    R=UPDATE("car2",COL,VAL,"carid="+CARID_V);
		//prompt(1,Cut2(R,"sql"));
		//alert(R);
	}
	function ok(){
		alert('保存成功','','保存车辆')
		self.location.href="shouyin.php";
	}
	

</script>
</body>
</html>