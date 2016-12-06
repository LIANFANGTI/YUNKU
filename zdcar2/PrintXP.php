<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	require_once 'function.php';  
	$bid=$_GET["bid"];
	$db->select("bill","*","id=".$bid);$BillInfo = $db->fetchArray(MYSQL_ASSOC);
	$db->select("aitem","*","bid=".$bid);$BillItemInfo = $db->fetchArray(MYSQL_ASSOC);
	$db->select("ashop","*","del and bid=".$bid);$BillShopInfo = $db->fetchArray(MYSQL_ASSOC);
	//echo "$bid";
 ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $BillInfo[0]["bid"]; ?></title>
<style type="text/css">
.line {
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000;
	height:15px;
}
td {
	margin-top:100px;

}
h5{
	margin:5px auto;
}
</style>
</head>

<body style="width:220px;" onload="window.print()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><h4 align="center" ><strong>自点车坊欢迎您的光临</strong></h4>
    <hr /></td>
  </tr>
  <tr class="line">
    <td width="52%" align="right" height=1><h5><strong>订单编号：</strong></h5></td>
    <td width="48%" height=1><h5 ><?php echo $BillInfo[0]["bid"]; ?></h5></td>
  </tr>
  <tr class="line">
    <td align="right"><h5>客户姓名：</h5></td>
    <td><h5><?php echo  selecta("kehu","id",$BillInfo[0]["kehu"],"name"); ?></h5></td>
  </tr>
  <tr class="line" class="line">
    <td align="right"><h5>客户电话：</h5></td> 
    <td><h5><?php echo  selecta("kehu","id",$BillInfo[0]["kehu"],"phone"); ?></h5></td>
  </tr>
  <tr class="line" class="line">
    <td align="right"><h5>维修车辆：</h5></td>
    <td><h5><?php echo $BillInfo[0]["carid"]; ?></h5></td>
  </tr>
  <tr> <td colspan="2"><hr /></td> </tr>
  
  <tr>
    <td align="center"><h5><strong>项目</strong></h5></td>
    <td align="center"><h5><strong>金额</strong></h5></td>
  </tr>
   <tr> <td colspan="2"><hr /></td> </tr>
   <?php 
		foreach($BillItemInfo as $row){
			$ItemName=selecta("item","id",$row["iid"],"itemname");
			echo " <tr>
					<td align='center'><h5>$ItemName</h5></td>
					<td align='center'><h5>".$row["gs"]."元</h5></td>
				</tr>";
		} 
		
		foreach($BillShopInfo as $row){
			$ShopName=selecta("shop","sid",$row["sid"],"sname");
			echo " <tr>
					<td align='center'><h5>$ShopName</h5></td>
					<td align='center'><h5>".$row["money"]."元</h5></td>
				</tr>";
		} 
   ?>
   <tr> <td colspan="2"><hr /></td> </tr>
  <tr>
    <td align="right"><h5>合计金额：</h5></td>
    <td><h5><?php echo $BillInfo[0]["money"]; ?>元</h5></td>
  </tr>

   <tr>
    <td align="right"><h5>支付方式：</h5></td>
    <td><h5><?php echo $BillInfo[0]["jsfs"]; ?></h5></td>
  </tr>
   <tr>
    <td colspan="2"><h6>结算时间:<?php echo date("Y-m-d H:i"); ?></h6></td>
  </tr>
    <tr>
    <td colspan="2">谢谢惠顾，欢迎再次光临！</td>
  </tr>
</table>
</body>
</html>
