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
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
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
	<br>商品编码:<input id='sbm'      type='text' placeholder='商品名称'   value='<?php echo $sbm; ?>'    onchange='save()' disabled/>
	<br>商品名称:<input id='sname'    type='text' placeholder='商品名称'   value='<?php echo $sname; ?>'    onchange='save()'/>
	<br>零件品牌:<input id='spp'      type='text' placeholder='零件品牌'   value='<?php echo $spp; ?>'      onchange='save()'/>
	<br>适用车型:<input id='scar'     type='text' placeholder='适用车型'   value='<?php echo $scar; ?>'     onchange='save()'/>
	<br>零件型号:<input id='xinghao'  type='text' placeholder='型号'       value='<?php echo $xinghao; ?>'  onchange='save()'/>
	<br>零件单位:<input id='sdw'      type='text' placeholder='单位'       value='<?php echo $sdw; ?>'      onchange='save()'/>
	<br>零件规格:<input id='sgg'      type='text' placeholder='规格'       value='<?php echo $sgg; ?>'      onchange='save()'/>
	<br>供应厂商:<input id='gys'      type='text' placeholder='供应商'     value='<?php echo $gys; ?>'      onchange='save()'/>
	<br>供商号码:<input id='gysphone' type='text' placeholder='供应商号码' value='<?php echo $gysphone; ?>' onchange='save()'/>
	<br>到期时间:<input id='etime'    type='date' placeholder='到期时间'   value='<?php echo $etime; ?>'    onchange='save()'/>
	<br>安全库存:<input id='akc'      type='text' placeholder='安全库存'   value='<?php echo $akc; ?>'      onchange='save()'/>
	<br>商品成本:<input id='scb'      type='text' placeholder='商品成本'   value='<?php echo $scb; ?>'      onchange='save()' disabled/>
	<br>商品单价:<input id='sdj'      type='text' placeholder='商品单价'   value='<?php echo $sdj; ?>'      onchange='save()' disabled/>
	<br>备注信息:<input id='tips'     type='text' placeholder='备注信息'   value='<?php echo $tips; ?>'     onchange='save()'/>
	<br><input type='button' value='保存' onclick='pgclose()'/>
</div>
<script>
	function save(){
				sid=<?php echo $sid;?>;
				//alert(sid)
				vsname=document.getElementById("sname").value,
				vspp=document.getElementById("spp").value,
				vscar=document.getElementById("scar").value,
				vxinghao=document.getElementById("xinghao").value,
				vsdw=document.getElementById("sdw").value,
				vsgg=document.getElementById("sgg").value,
				vgys=document.getElementById("gys").value,
				vgysphone=document.getElementById("gysphone").value,
				vetime=document.getElementById("etime").value,
				vakc=document.getElementById("akc").value,
				vtips=document.getElementById("tips").value
		$.post("http://"+window.location.host+"/zdcar2/ajax.php",{sid:sid,vsname:vsname,vspp:vspp,vscar:vscar,vxinghao:vxinghao,vsdw:vsdw,vsgg:vsgg,vgys:vgys,vgysphone:vgysphone,vetime:vetime,vakc:vakc,vtips:vtips,atype:"eshop"},function(data,aaa){
				//alert(data);
			})
	}

</script>
</body>
</html>