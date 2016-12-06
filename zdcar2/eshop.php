<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
	$kid=$_GET["kid"];
	require_once 'mysql.class.php';
	$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商品信息修改</title>
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
			$sid=$_GET["sid"];
			$db->select("shop", "*", "sid=".$sid."");$shop = $db->fetchArray(MYSQL_ASSOC);
			$sname=$shop[0]["sname"];
			$spp=$shop[0]["spp"];
			$scar=$shop[0]["scar"];
			$xinghao=$shop[0]["xinghao"];
			$sdw=$shop[0]["sdw"];
			$sgg=$shop[0]["sgg"];
			$gys=$shop[0]["gys"];
			$gysphone=$shop[0]["gysphone"];
			$etime=$shop[0]["etime"];
			$akc=$shop[0]["akc"];
			$tips=$shop[0]["tips"];
			$sdj=$shop[0]["sdj"];
			$scb=$shop[0]["scb"];
			$sbm=$shop[0]["sbm"];
		
		
	 //echo $sname; 


	
	?>

<div style='margin:100px;'>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<td>商品名称:</td>
			<td><input id='sname'  class="form-control in"  type='text' placeholder='商品名称'   value='<?php echo $sname; ?>'    onchange='updateShopInfo(this)'/></td>
			<td>零件品牌:</td>
			<td><input id='spp'   class="form-control in"   type='text' placeholder='零件品牌'   value='<?php echo $spp; ?>'      onchange='updateShopInfo(this)'/></td>
		</tr>
		<tr>
			
			<td>适用车型:</td>
			<td><input id='scar'  class="form-control in"   type='text' placeholder='适用车型'   value='<?php echo $scar; ?>'     onchange='updateShopInfo(this)'/></td>
			<td>到期时间:</td>
			<td><input id='etime'  class="form-control in"  type='date' placeholder='到期时间'   value='<?php echo $etime; ?>'    onchange='updateShopInfo(this)'/></td>
		</tr>
		
		
		<tr>
			
		</tr>
		<tr>
			<td>安全库存:</td>
			<td><input id='akc'  class="form-control in"    type='text' placeholder='安全库存'   value='<?php echo $akc*1; ?>'      onchange='updateShopInfo(this)'/></td>
			<td>商品成本:</td>
			<td><input id='scb'  class="form-control in"    type='text' placeholder='商品成本'   value='<?php echo $scb; ?>'      onchange='updateShopInfo(this)' /></td>
		</tr>
		<tr>
			<td>商品单价:</td>
			<td><input id='sdj'  class="form-control in"    type='text' placeholder='商品单价'   value='<?php echo $sdj; ?>'      onchange='updateShopInfo(this)' /></td>
			<td>备注信息:</td>
			<td><input id='tips'  class="form-control in"   type='text' placeholder='备注信息'   value='<?php echo $tips; ?>'     onchange='updateShopInfo(this)'/></td>
		</tr>
		<tr>
			<td colspan=4><input type='button' class='btn btn-success btn-xs'  value='保存' onclick='pgclose()'/></td>
		</tr>
	</table>


	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
</div>
<script>
	function updateShopInfo(e){
		COL=e.id;
		VAL=e.value; 
		UPDATE("shop",COL,VAL,"sid=<?php echo $sid;?>",true);
	}
</script>
</body>
</html>