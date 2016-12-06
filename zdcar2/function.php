<?php
ob_start();
session_start();
error_reporting(E_ERROR);  
ini_set("display_errors","On");  
require_once 'mysql.class.php';
require_once 'page.class.php';
require_once '../lib/fun.php';
//print_r($_SESSION);
$db1 = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db"); 	
define("HOST",$_SERVER['HTTP_HOST']);


//echo "\n获取到的会话变量：[".$_SESSION["company"]."]";

if(!isset($_SESSION["company"])){
	//header("Location: ../yunku/login.php");
	echo"<script>window.location.replace('../yunku/login.php');</script>";
}else{
	
	$cp=$_SESSION["company"];//公司id获取
	$company=SELECT("company","*","id=".$cp."");
	//print_r($company);
	//$db1->select("company","*","id=".$cp."");$company=$db1->fetchArray(MYSQL_ASSOC); 
	
	$cpname=$company[0]["name"];//公司名称获取
	//echo "[公司：$cp]";
	$username=$_SESSION["name"];//用户名获取
	
	$hd=$_SESSION["head"];//头像获取

	
	$USERID=$_SESSION['USERID'];
	echo "<input type='hidden' value='".$cp."' id='cp'>";
	echo "<input type='hidden' value='".$USERID."' id='u'>";
	$db1->select("user", "*", "id='".$USERID."'");$USERINFO = $db1->fetchArray(MYSQL_ASSOC);
	
	$db->select("company", "*", "id='".$cp."'");$COMPANYINFO = $db->fetchArray(MYSQL_ASSOC);
	if($COMPANYINFO[0]["admin"]==$USERID){$USERMODE="admin";}
	}
	
/*通用函数库*/
function btypet($a){
	switch($a){
		case "0":$b="未选择订单类型";break;
		case "1":$b="美容养护";break;
		case "2":$b="维修保养";break;
		case "3":$b="服务套餐";break;
		case "4":$b="其他";break;
	}	
	return $b;
}
function jsfst($a){
	switch($a){
		case "0":$b="未选择支付类型";break;
		case "1":$b="支付宝支付";break;
		case "2":$b="微信支付";break;
		case "3":$b="现金付款";break;
		case "0":$b="合作商付款";break;
	}	
	return $b;
}
function btype($a){
	//订单类型
	switch($a){
		case "0":
			$b="<option value='0' selected='selected'>选择订单类型</option>
				<option value='1'>美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>";
	    break;
		case "1":
			$b="<option value='0'>选择订单类型</option>
				<option value='1'  selected='selected'>美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>
			";break;
		case "2":
				$b="<option value='0'>选择订单类型</option>
				<option value='1'>美容养护</option>
				<option value='2' selected='selected'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>
			"; break;	
		case "3":	
				$b="<option value='0'>选择订单类型</option>
				<option value='1' >美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3' selected='selected'>服务套餐</option>
				<option value='4'>其他</option>
			"; break;	
		case "4":	
				$b="<option value='0'>选择订单类型</option>
				<option value='1' >美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'  selected='selected'>其他</option>
			"; break;		
	}
	return "<select  type='text' id='b_type' onchange='BtypeChange(this)' name='btype' class='form-control' style='overflow: hidden;width:auto;'>".$b."</select>";
}
function btype2($a){
	//订单类型
	switch($a){
		case "0":
			$b="<option value='0' selected='selected'>选择订单类型</option>
				<option value='1'>美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>";
	    break;
		case "1":
			$b="<option value='0'>选择订单类型</option>
				<option value='1'  selected='selected'>美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>
			";break;
		case "2":
				$b="<option value='0'>选择订单类型</option>
				<option value='1'>美容养护</option>
				<option value='2' selected='selected'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'>其他</option>
			"; break;	
		case "3":	
				$b="<option value='0'>选择订单类型</option>
				<option value='1' >美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3' selected='selected'>服务套餐</option>
				<option value='4'>其他</option>
			"; break;	
		case "4":	
				$b="<option value='0'>选择订单类型</option>
				<option value='1' >美容养护</option>
				<option value='2'>维修保养</option>
				<option value='3'>服务套餐</option>
				<option value='4'  selected='selected'>其他</option>
			"; break;		
	}
	return $b;
}
/*结算状态*/
function jszt($a){
	switch($a){
		case "0":$b="<option selected='selected'>未结算</option><option>已结算</option>";break;
		case "1":$b="<option>未结算</option><option selected='selected'>已结算</option>";break;	
	}
	return "<select class='text' id='jszt'>".$b."</select>";
}
/*业务状态*/
function ywzt($a){
	switch($a){
		case "1":$b="<option value='1' selected='selected'>已完成</option><option value='0' >进行中</option>";break;
		case "0":$b="<option value='1' >已完成</option><option selected='selected' value='0' >进行中</option>";break;	
	}
	return "<select class='btn btn-info btn-xs' id='ywzt'>".$b."</select>";
}
/*结算方式*/
function jsfs($a){
	switch($a){
		case "0":
			$b="<option value='0' selected='selected'>选择支付方式</option>
				<option value='1'>支付宝支付</option>
				<option value='2'>微信支付</option>
				<option value='3'>现金付款</option>
				<option value='4'>合作商付款</option>
			";break;
		case "1":
			$b="<option value='0'>选择支付方式</option>
				<option value='1' selected='selected'>支付宝支付</option>
				<option value='2'>微信支付</option>
				<option value='3'>现金付款</option>
				<option value='4'>合作商付款</option>
			";break;
		case "2":
			$b="<option value='0'>选择支付方式</option>
				<option value='1'>支付宝支付</option>
				<option value='2' selected='selected'>微信支付</option>
				<option value='3'>现金付款</option>
				<option value='4'>合作商付款</option>
			";break;
		case "3":	
			$b="<option value='0'>选择支付方式</option>
				<option value='1'>支付宝支付</option>
				<option value='2'>微信支付</option>
				<option value='3' selected='selected'>现金付款</option>
				<option value='4'>合作商付款</option>
			";break;
		case "4":	
			$b="<option value='0'>选择支付方式</option>
				<option value='1'>支付宝支付</option>
				<option value='2'>微信支付</option>
				<option value='3'>现金付款</option>
				<option value='4' selected='selected'>合作商付款</option>
			";break;	
	}
	return "<select class='text' id='jsfs'>".$b."</select>";
}

	
function qrpng($data){
		
}
function QR3(){
	
}



function QR2(){
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;//获取服务器存储目录
	echo $PNG_TEMP_DIR;
	$PNG_WEB_DIR = 'temp/';
	if (!file_exists($PNG_TEMP_DIR))mkdir($PNG_TEMP_DIR);//如果不存在目录 则创建
	$filename = $PNG_TEMP_DIR.'test.png';//设置临时文件文件名
	QRcode::png("text", $filename,"L",10, 2);  
	echo '<img  src="'.$PNG_WEB_DIR.basename($filename).'" />';
}
/*
function QR($DATA,$ECL,$SIZE){
		/*使用方法：
			QR(内容,容差率,尺寸)
			SRC路径：$PNG_WEB_DIR.basename($filename)
		
		 $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
		 $PNG_WEB_DIR = 'temp/';
		 if (!file_exists($PNG_TEMP_DIR))mkdir($PNG_TEMP_DIR);
		 $filename = $PNG_TEMP_DIR.'test.png';  
		 
		$errorCorrectionLevel = 'L';
		if (isset($ECL) && in_array($ECL, array('L','M','Q','H')))$errorCorrectionLevel = $ECL;  
	
		$matrixPointSize = 10;
		if (isset($SIZE))$matrixPointSize = min(max((int)$SIZE, 1), 10);
	     
		 
		 
		if (isset($DATA)) {
			if (trim($DATA) == '')die('data cannot be empty! <a href="?">back</a>');
			$filename = $PNG_TEMP_DIR.'QRcode.png';
			QRcode::png($DATA, $filename, $errorCorrectionLevel, 10, 2); 
			return '<img src="'.$PNG_WEB_DIR.basename($filename).'"/>';  
		} else {    
			QRcode::png('参数错误', $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
		}
		 
	}*/
function Kehuname($id){return selecta("kehu","id",$id,"name");}  //客户名称
function KehuPhone($id){return selecta("kehu","id",$id,"phone");}//客户电话
function Shopname($id){return selecta("shop","sid",$id,"sname");}//商品名称 
function ItemName($id){return selecta("item","id",$id,"itemname");}//项目名称
/*客户信息*/

/*商品信息*/
function sp($id,$col){
	global $db;
	$db->select("shop", "*", "sid=".$id );$shop = $db->fetchArray(MYSQL_ASSOC);
	return	$shop[0][$col];
}
/*订单信息*/
function bl($id,$col){
	global $db;
	$db->select("bill", "*", "id=".$id );$bill = $db->fetchArray(MYSQL_ASSOC);
	return	$bill[0][$col];
}
//通用查询 使用说明 select（表名，字段，值，要返回字段）返回单行值  多条结果取首条
/*function  SELECT($TAB,$COL,$CONDITION){
	global $db;
	$db->select($TAB," ".$COL."",$CONDITION); 
	return $db->fetchArray(MYSQL_ASSOC);
}//通用查询 使用说明：select2（表名，字段，值）返回数组*/
function select2($tab,$col,$val){
	global $db;
	$db->select($tab, "*", $col."=".$val);$array = $db->fetchArray(MYSQL_ASSOC);	
	return $array;
}
function car($id,$kh){
	global $db;
	$db->select("car","*","kh=$kh");$array = $db->fetchArray(MYSQL_ASSOC);
	$option="";
	foreach($array as $row){
		$option.="<option value='".$row["id"]."'>".$row["carid"]."</option>";
		if($row["id"]==$id)$option.="<option value='".$row["id"]."' selected='selected' >".$row["carid"]."</option>";
	}
	if(empty($array))$option="<option value='0' selected='selected' >暂无车辆信息</option>";
	return "<select  id='carinfo' class='input_td'>".$option."</select>";
	
}
//function selecta($tab,$col,$val,$bal){global $db;$db->select($tab, "*", $col."=".$val);$array = $db->fetchArray(MYSQL_ASSOC);if(!empty($array)){return $array[0][$bal];};}
 ?>