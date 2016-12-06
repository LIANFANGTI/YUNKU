<?php 
ob_start();
//require_once 'mysql.class.php';
require_once 'page.class.php';
require_once 'page.ajax.class.php';
require_once 'page.ajax2.class.php';
include "../lib/uploadFile.class.php";   
include "../lib/fun.php";   
//require_once '../function/fun.php';

define("HOST",$_SERVER['HTTP_HOST']);
define("PageSize",8);

//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");

$atype=$_POST["atype"];

echo "当前的请求模式为：".$atype."\n";
switch($atype){
	/*添加客户*/
	case "csession":
		echo "SESSION变量创建";
		session_start();
		$_SESSION["a"]="123";
		if(isset($_SESSION["a"])){echo "\n变量创建成功\n";}else{echo "\n变量创建失败\n";}
	break;
	case "dsession":
		
	break;
	case "addkh": 
		$pho=$_POST["khpho"];
		$name=$_POST["khname"];
		$add=$_POST["khadd"];
		$car=$_POST["khcar"];
		$carid=$_POST["khcarid"];
		$ps=$_POST["khps"];
		$cp=$_POST["cp"];
		isset($_POST["key"])?$key=$_POST["key"]:$key=0;
		echo "\nkey=".$key."\n";
		$userInfo = array('name'=>$name, 'phone' =>$pho, 'kehu_c' =>$add,'car_type' =>$car,'carid' =>$carid,'tips' =>$ps,'company'=>$cp,'intime'=>date("Ymd"),'khkey'=>$key);
		$db->insert("kehu", $userInfo);
		echo $db->printMessage();	
		/*****************************************以下是会员卡号生成部分 */
		//获取该公司最后一条记录的id
		$db->select("kehu", "id", "company=".$cp." order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
		echo "[newid]".$reid[0]["id"]."[/newid]";
		//获取该公司的会员数
		$db->select("kehu", "count(*) as ct", "company=".$cp."");$kehu = $db->fetchArray(MYSQL_ASSOC);$number=$kehu[0]["ct"];
		//根据该ID查询该条数据 获取公司 和 信息日期 
		$db->select("kehu", "*", "id=".$reid[0]["id"]."");$kehu = $db->fetchArray(MYSQL_ASSOC);
		//会员卡号生成  格式 VIP+公司+日期+第几位
		$vip="VIP".$kehu[0]["company"].date('Ymd',strtotime($kehu[0]["intime"])).fz($number);
		echo "\nVIP:".$vip."\n";
		$kehuInfo = array('vip'=>$vip);
		$db->update("kehu", $kehuInfo, "id = ".$reid[0]["id"]."");
		echo $db->printMessage();	
		
	break;
	/*添加客户2*/
	case "Addkehu":
		$CompanyID=$_POST["CompanyID"];
		$KehuName=$_POST["KehuName"];
		$KehuPhone=$_POST["KehuPhone"];
		$KehuTips=$_POST["KehuTips"];
		$KehuCarid=$_POST["KehuCarid"];
		echo $KehuCarid;
		$db->select("car2", "*", "carid='".$KehuCarid."'");$Car=$db->fetchArray(MYSQL_ASSOC);
		print_r($Car);
		if(0){
			echo "车辆存在";
		}else{
			echo "车辆不存在";
			$userInfo=array('name'=>$KehuName,'carid'=>$KehuCarid,'phone' =>$KehuPhone,'tips' =>$KehuTips,'company'=>$CompanyID,'intime'=>date("Ymd"));
			$db->insert("kehu", $userInfo);echo "\n插入客户信息:".$db->printMessage()."\n";
			
			$db->select("kehu", "id", "company=".$CompanyID." order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
			echo "[newid]".$reid[0]["id"]."[/newid]";
			$db->select("kehu", "count(*) as ct", "company=".$cp."");$kehu = $db->fetchArray(MYSQL_ASSOC);$number=$kehu[0]["ct"];
			$db->select("kehu", "*", "id=".$reid[0]["id"]."");$kehu = $db->fetchArray(MYSQL_ASSOC);
			$vip="VIP".$kehu[0]["company"].date('Ymd',strtotime($kehu[0]["intime"])).fz($number);
			$kehuInfo = array('vip'=>$vip);
			$db->update("kehu", $kehuInfo, "id = ".$reid[0]["id"]."");
			echo "\n更新会员卡号:".$db->printMessage()."\n";
		}	
		//echo $CompanyID.$KehuName.$KehuPhone.$KehuTips;*/
	
	break;
	/*用户车列表*/
	case "CarList":
		$kh=$_POST["khid"];
		$db->select("car2","*","kh=".$kh." order by date desc");$cartb=$db->fetchArray(MYSQL_ASSOC);
		$kehucar=SELECT("kehu","*","id=".$kh);
		$defultCar=$kehucar[0]["carid"];
		echo "默认车辆".$defultCar;
		if($defultCar!=""){
			if(empty($cartb))echo "<option value='-1'>无车辆信息</option>";
			foreach($cartb as $row){
				if($row["carid"]==$kehucar[0]["carid"]){
					$Selected="selected='selected'";
					$defult='[默认]';
				}else{
					$Selected="";
					$defult='';
				}
					echo "<option value='".$row["carid"]."' $Selected >".$row["carid"]."  ".$defult."</option>";
			}
		}else{
			foreach($cartb as $row){
				echo "<option value='".$row["carid"]."'>".$row["carid"]."</option>";
			}
		}
		echo"<option value=-1>添加车辆</option>";
	break;
	/*客户搜索*/
	case "tjcx":
		$cp=$_POST["cp"];
		$tj=$_POST["tj"];
		//SELECT * FROM kehu where company=13 and ((name LIKE '%户2%' )or(phone LIKE '%户2%'));
		$db->select("kehu", "*", " company=".$cp." and  (name like '%".$tj."%' or phone like '%".$tj."%')");
		$tjkh = $db->fetchArray(MYSQL_ASSOC);
		$i=0;
       		echo"<tr>
                 	<td>序号</td>
                    <td>姓名</td>
                    <td>联系电话</td>
                    <td>通讯地址</td>
                    <td>车型</td>
                    <td>车牌</td>
                    <td>备注</td>
                    <td>操作</td>
                </tr>";
		if(empty($tjkh)){
			echo "<tr><td colspan=8><b style='color:red;'> <h2>(ノдヽ)</h2></b>&nbsp;啊哦~未查找到匹配数据！</td></tr>";
		}else{
			foreach($tjkh as $row){
				if($tj==""&&$i>6);
				echo "<tr class=a".$i.">";
				echo"<td>".($i+1)."</td>";
				echo"<td>".$row["name"]."</td>";
				echo"<td>".$row["phone"]."</td>";
				echo"<td>".$row["kehu_c"]."</td>";
				echo"<td>".$row["car_type"]."</td>";
				echo"<td>".$row["carid"]."</td>";
				echo"<td>".$row["tips"]."</td>";
				echo"<td><button class='btn btn-info btn-xs' data-dismiss='modal' onclick='ckehu(\"kehutb\",".$i.",".$row["id"].")'>选择</button></td>";
				echo"</tr>";
				$i++;
			}
		}
		if($tj==""){
			echo"<tr>
                    <td colspan='8'>
                    	<input id='addkh'  type='button'  class='btn btn-info' value='新建客户' onClick='addtr(\"kehutb\")'/></td>
                    </tr>";
			}

	break;
	/*收银页面数据返回*/

	/*添加项目*/
	
	case "additem":
		$iname=$_POST["iname"];
		$itype=$_POST["itype"];
		$imoney=$_POST["imoney"];
		$ierror=$_POST["ierror"];
		$tips=$_POST["tips"];
		$cp=$_POST["cp"];
		$db->select("item","*","itemname='$iname'");$item = $db->fetchArray(MYSQL_ASSOC);
		print_r($item);
		if(!empty($item)){
			echo "项目[".$iname."]已存在(页面确) id为[".$item[0]["id"]."]";
			echo "[newid]".$item[0]["id"]."[/newid]";
			echo "[iname]".$item[0]["itemname"]."[/iname]";
			echo "[itype]".$item[0]["item_type"]."[/itype]";
			echo "[ibm]".$item[0]["itemid"]."[/ibm]";
		}else{
			$db->select("item","count(*) as ct","company =".$cp."");$item = $db->fetchArray(MYSQL_ASSOC);$ict=$item[0]["ct"];
			echo "\n查询结果(页面确认):".$db->printMessage;
			$iid="XM".fz($cp).date('Ymd').fz($ict);
			echo "\nBM:".$iid."\n";
			$itemInfo = array('itemid'=>$iid,'itemname' =>$iname, 'money' =>$imoney ,'error' =>$ierror,'item_type' =>$itype,'tips' =>$tips,'company'=>$cp,'adate'=>date('Ymd'));
			$db->insert("item", $itemInfo);
			echo "名字(页面确认)：".$iname;
			echo $db->printMessage();	
			$db->select("item", "id", "company=".$cp." order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
			echo "\n------------返回信息--------------\n";
			echo "[newid]".$reid[0]["id"]."[/newid]";
			echo "[iname]".$iname."[/iname]";
			echo "[itype]".$itype."[/itype]";
			echo "[ibm]".$iid."[/ibm]";
		}		
	break;
	/*添加商品*/
	case"addshop":
	//skc:ssl,sdj:sdj,scb:scb,xinghao:xinghao,etime:etime,akc:akc,
		$sname=$_POST["sname"];	//商品名称
		$sdw=$_POST["sdw"];		//商品单位
		$scb=$_POST["scb"];		//商品成本
		$skc=$_POST["skc"];		//添加数量
		$spp=$_POST["spp"];		//商品品牌
		$scar=$_POST["scar"];	//适用车型
		$sdj=$_POST["sdj"];		//商品单价
		$cp=$_POST["cp"];		//所属公司
		$guige=$_POST["guige"];//零件型号
		$etime=$_POST["etime"];	//保质期
		$akc=$_POST["akc"];		//安全库存
		$xinghao=$_POST["xinghao"];//型号
		$gys=$_POST["gys"];//供应商
		$gysphone=$_POST["gysphone"];//供应商联系方式
		$USERID=$_POST["USERID"];//操作者
		$db->select("shop","count(*) as ct","company =".$cp."");$shop = $db->fetchArray(MYSQL_ASSOC);$sct=$shop[0]["ct"];
		$bm="SP".fz($cp).date('Ymd').fz($sct);		
		$shopInfo = array('sname'=>$sname, 'spp' =>$spp,'sgg'=>$guige,'xinghao'=>$xinghao,'gys'=>$gys,'gysphone'=>$gysphone,'etime'=>$etime,'akc'=>$akc,'sdw' =>$sdw ,'scar' =>$scar,'sdj' =>$sdj,'scb' =>$scb,'skc' =>$skc,'company'=>$cp,'date'=>date('Ymd'),'sbm'=>$bm);
		$db->insert("shop", $shopInfo);
		//echo LOGS($USERID,"新建",$,);
		echo "名字：";
		echo $db->printMessage();		
	break;
	/*更新订单总额*/
	case "update-bill-zje":
		$bid=$_POST["bid"];
		$zje=$_POST["zje"];
		$bill=array("Money"=>$zje);
		$db->update("bill",$bill,"id=$bid");
		echo "UPDATA bill SET money= $zje WHERE id=$bid";
		echo $db->printMessage();
	break;
case "CheckUserName";
		$val=$_POST["val"];
		$db->select("kehu","name","name='$val'");$kehu = $db->fetchArray(MYSQL_ASSOC);
		if(empty($kehu)){
			echo "账户为空";
		}else{
			echo "账户存在";
		}
	break;
case "CheckUserPhone";
		$name=$_POST["name"];
		$phone=$_POST["phone"];
		$db->select("kehu","name,phone","name='$name'");$kehu = $db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		print_r($kehu);
		if(empty($kehu)){
			echo "账户为空";
		}else{
			echo "账户存在";
			echo "Debug:(".$phone;
			echo ":";
			echo $kehu[0]["phone"].")";
		
			if($phone==$kehu[0]["phone"]){
				echo "验证成功";
				echo "debug:".$kehu[0]["phone"];
			}else{
				echo "手机号与用户姓名不匹配";
				echo "debug:".$kehu[0]["phone"];
			}
		}
	break;
	/*订单结算*/
case "bill-js":
		$bid=$_POST["bid"];
		$kh=$_POST["kh"];
		echo "支付方式".$PayMode=$_POST["PayMode"];
		$yhval=selecta("bill","id",$bid,"yhval");
		$yhtype=selecta("bill","id",$bid,"yhtype");
		$je=selecta("bill","id",$bid,"money")*1;
		if($yhval!=0 and $yhval!=""){
			if($yhtype){
				$je=$je*($yhval/100);
			}else{
				$je=($je-$yhval);
			}
		}
		$je=$je*1-selecta("bill","id",$bid,"yjie")*1;
		
		
		$ye=selecta("kehu","id",$kh,"money")*1;
		$jf=selecta("kehu","id",$kh,"jf");
		$EXP=selecta("kehu","id",$kh,"exp");
		//$LV=selecta("kehu","id",$kh,"vipdj");
		$EXP=$EXP+($je*2.5);
		$JIFEN=$jf+($je*0.5*1);
		echo "订单金额:[$je]|客户余额:[$ye]\n 订单ID[$bid]|客户id[$kh]\n";
		if($ye>=$je){
			$kehu=array('money'=>($ye-$je),'jf'=>$JIFEN,'exp'=>$EXP);$db->update("kehu",$kehu,"id=$kh");
				echo "\n用户[余额][积分]更新".$db->printMessage();
			$bill=array('zt'=>1,'jsfs'=>$PayMode,'jsdate'=>date('y-m-d h:i:s',time()),'yjie'=>$je);$db->update("bill",$bill,"id=$bid");
				echo "\n订单[支付状态][结算方式][已结算金额]更新".$db->printMessage()."\n";
			if($bill){
				$db->select("kehu","*","id=$kh");$kehu= $db->fetchArray(MYSQL_ASSOC);
				echo "\n[微信消息推送前的用户openid读取]:".$db->printMessage();
				if($openid=$kehu[0]["wx_openid"]!=""){
					echo "该客户已绑定微信".$openid;
				    //header('Location:http://'.HOST.'/weixin/sendmsg.php?money='.($je*1).'&money2='.(($ye-$je)*1).'&name='.$kehu[0]["name"].'&openid='.$kehu[0]["wx_openid"].'&SendMode=XiaoFei&bid='.$bid);
					$url='http://'.HOST.'/weixin/sendmsg.php?money='.($je*1).'&money2='.(($ye-$je)*1).'&name='.$kehu[0]["name"].'&openid='.$kehu[0]["wx_openid"].'&SendMode=XiaoFei&bid='.$bid;
					echo file_get_contents($url);
				}else{echo "该客户未绑定微信";}
			
			}else{
				echo "结算失败";
			}
			
		}else{
			$yjie=(selecta("bill","id",$bid,"yjie")*1)+$ye;
			$bill=array('zje'=>($je-$ye),'yjie'=>$yjie);$db->update("bill",$bill,"id=$bid");
			$kehu=array('money'=>0,'jf'=>($jf+($ye*0.66)));$db->update("kehu",$kehu,"id=$kh");
			echo"[nomoney]
						  结算失败！您的账户余额不足，
						 账户余额：<b style='color:red;'>[$ye]</b>元
						 订单金额: <b style='color:red;'>[$je]</b>元
					     已从您的账户余额里扣除<b style='color:red;'>[".($ye*1)."]</b>元。还剩余<b style='color:red;'>[".($je-$ye)."]</b>元未结算,请选择结算方式。
				[/nomoney][REMAIN]".($je-$ye)."[/REMAIN]";
			echo "金额：$je\n余额:$ye"; 
		}
		
		//爱奇艺会员15990599742 q123456777
	break;
case "bill-js2":
		$bid=$_POST["bid"];
		$kh=$_POST["kh"];
		$je=selecta("bill","id",$bid,"money")*1-selecta("bill","id",$bid,"yjie")*1;
		$ye=selecta("kehu","id",$kh,"money")*1;
		$jf=selecta("kehu","id",$kh,"jf");
		$jsfs=$_POST["jsfs"];
		echo "结算方式:[$jsfs]";
			$bill=array('zt'=>1,'jsfs'=>$jsfs,'zje'=>0,'yjie'=>selecta("bill","id",$bid,"money")*1,'jsdate'=>date('y-m-d h:i:s',time()));$db->update("bill",$bill,"id=$bid");
				echo "DEBUG2".$db->printMessage();
			if($bill){
				$db->select("kehu","*","id=$kh");$kehu= $db->fetchArray(MYSQL_ASSOC);
				echo "DEBUG3".$db->printMessage();
				if($openid=$kehu[0]["wx_openid"]!=""){
					echo "该客户已绑定微信".$openid;
				    $url='Location:http://'.HOST.'/weixin/sendmsg.php?money='.($je*1).'&money2='.(($ye-$je)*1).'&name='.$kehu[0]["name"].'&openid='.$kehu[0]["wx_openid"].'&SendMode=XiaoFei&bid='.$bid;
					echo file_get_contents($url);
				}else{echo "该客户未绑定微信";}
			}
		
		//爱奇艺会员15990599742 q123456777
	break;
   /*存入订单已添加项目*/
   case"aitem":
		$iid=$_POST["iid"];//项目id
		$bid=$_POST["bid"];//订单id
		$gs=$_POST["gs"];//工时=价格
		$gr=$_POST["gr"];
		$tips=$_POST["tips"];//备注	
		$userInfo = array('iid'=>$iid, 'bid' =>$bid, 'gs' =>$gs ,'yh' =>$yh,'gr' =>$gr,'tips' =>$tips,);
		$db->insert("aitem", $userInfo);
        echo $db->printMessage();	
	break;
	case "AddItem":
		$ItemMoney=$_POST["ItemMoney"];
		$ItemTips=$_POST["ItemTips"];
		$ItemID=$_POST["ItemID"];
		$BillID=$_POST["BillID"];
		echo "[项目ID:".$ItemID."]";
		$ItemInfo = array('iid'=>$ItemID, 'bid' =>$BillID, 'gs' =>$ItemMoney ,'tips' =>$ItemTips);
		$db->insert("aitem",$ItemInfo);
        echo $db->printMessage();

		
	break;
	/*存入订单已添加商品*/
	case"ashop":
		$COMPANY=$_POST["COMPANY"];
		$khid=$_POST["khid"];//客户id（没用）
		$U=$_POST["USERID"];//当前操作用户
		$sid=$_POST["sid"];//商品id
		$bid=$_POST["bid"];//订单id
		$sl=$_POST["gs"];//数量
		$gr=$_POST["gr"];//工人（未用）
		$tips=$_POST["tips"];//备注
		$geti=$_POST["i"];//莫名其妙的i(我也忘了什么用的)
		$getcs=$_POST["cs"];//莫名其妙的CS（忘了干嘛）
		$je=sdbinfo("shop",$sid,"sdj")*$sl; //获取商品单价乘以数量
		$money=dbinfo("kehu",$khid,"money");//获取用户当前余额
		echo "\n##获取到余额".$money."##\n";  //输出余额
		if($geti>=$getcs)echo "添加结束跳转";	//检测是否已经添加成功
		##ashop记录插入
		$userInfo = array('sid'=>$sid,'money'=>sdbinfo("shop",$sid,"sdj"),'bid' =>$bid, 'sl' =>$sl,'gr' =>$gr,'tips' =>$tips,);
		$db->insert("ashop", $userInfo);
		echo LOGS($U,"使用","商品",$sid,$sl,$COMPANY);
	    echo $db->printMessage()."\n客户id为".$khid ."\n扣除金额：".$je."\n扣除前金额".$money;	
		##kehu表余额更新
		$money-=$je;$cmoney=array('money'=>$money);
		/*$db->update("kehu", $cmoney, "id = ".$khid."");*/
		##shop表库存更新
		$db->select("shop","*","sid=".$sid);$shop = $db->fetchArray(MYSQL_ASSOC);
		$skc=$shop[0]["skc"];
		echo "\n库存：".$skc."\n数量：".$sl."\n";
		$skc-=$sl;
		echo "剩余库存".$skc;
		$shopj = array('skc'=>$skc);
		echo "\nashop表新增信息".$db->printMessage();
        $db->update("shop", $shopj, "sid =".$sid);
		echo "\n库存更新：".$db->printMessage();		
	break;
	/*存入订单信息*/
   case"abill":
		$bid=0;
		$bkh=$_POST["bkh"];
		$ber=$_POST["ber"];
		$bps=$_POST["bps"];
		$zje=$_POST["zje"];
		$USERID=$_POST["USERID"];
		$carid=$_POST["carid"];		
		$company=$_POST["company"];
		$BillInfo = array('zje'=>$zje,'bid'=>$bid,'money'=>$zje,'kehu' =>$bkh, 'btype' =>$ber ,'carid'=>$carid,'tips' =>$bps,'date'=>date('Y-m-d H:i:s'),'U'=>$USERID,'company'=>$company);
		print_r($BillInfo);
		$db->insert("bill", $BillInfo);
		echo $db->printMessage();
 
        /*订单编号生成部分*/
		//首先获取刚刚插入的数据的id
		$db->select("bill", "id", "1=1 order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
		echo "[billid]".$reid[0]["id"]."[/billid]";
		//根据该ID查询该条数据 获取公司 和 日期 信息
		$db->select("bill", "*", "id=".$reid[0]["id"]."");$bill = $db->fetchArray(MYSQL_ASSOC);
		//赋值
		$company=$bill[0]["company"];
		//根据公司和日期 查询该记录是该公司这一天的记录数
		$db->select("bill", "count(*) as c", "date='".$bill[0]["date"]."' and company=".$company."");$abm = $db->fetchArray(MYSQL_ASSOC);
		//将得到的日期格式化为19700101格式
		$date=date('Ymd',strtotime($bill[0]["date"]));
		//编码生成 格式为： KD+公司+日期+订单数
		$bm="KD".fz($company).$date.fz($abm[0]["c"]);
		//更新刚刚插入记录的订单编码字段
		$billInfo = array('bid'=>$bm);
        $db->update("bill", $billInfo, "id =".$reid[0]["id"]);
		echo "[bm]".$bm."[/bm]";
		/**编码生成完成**/
		
		//echo $db->printMessage();		
	break;
	/*更新订单优惠信息*/
	case "setyh":
		$type=$_POST["type"];
		$val=$_POST["val"];
		echo $tips=$_POST["tips"];
		$bid=$_POST["bid"];
		$billInfo = array('yhtype'=>$type,"yhval"=>$val,"yhtips"=>$tips);
        $db->update("bill", $billInfo, "id =".$bid);
		echo $db->printMessage();
	break;
	case "AddBill":
		$BillKehuID=$_POST["BillKehuID"];
		$USERID=$_POST["USERID"];
		$BillType=$_POST["BillType"];
		$CompanyID=$_POST["CompanyID"];
		$BillCarid=$_POST["BillCarid"];
		$TotalMoney=$_POST["TotalMoney"];
		$BillInfo = array('zje'=>$TotalMoney,'U'=>$USERID,'bid'=>0,'money'=>$TotalMoney,'kehu' =>$_POST["BillKehuID"], 'btype' =>$BillType ,'carid'=>$BillCarid,'date'=>date('Y-m-d H:i:s'),'company'=>$CompanyID);
		print_r($BillInfo);
		$db->insert("bill", $BillInfo);
		echo $db->printMessage();
		$db->select("bill", "id", "1 order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);echo "[billid]".$reid[0]["id"]."[/billid]";
		$db->select("bill", "*", "id=".$reid[0]["id"]."");$bill = $db->fetchArray(MYSQL_ASSOC);$company=$bill[0]["company"];
		$db->select("bill", "count(1) as c", "company=".$company."");$abm = $db->fetchArray(MYSQL_ASSOC);
		$date=date('Ymd',strtotime($bill[0]["date"]));$bm="KD".fz($company).$date.fz($abm[0]["c"]);
		$billInfo = array('bid'=>$bm);$db->update("bill", $billInfo, "id =".$reid[0]["id"]);
		echo "[bm]".$bm."[/bm]";
	break;
	/*删除已选择的项目/商品*/
   case"del":
		$id=$_POST["id"];
		$bid=$_POST["bid"];
		$table=$_POST["table"];
        $db->delete($table, "id = ".$id."");
		$db->select("aitem", "*", "bid=".$bid."");$aitem = $db->fetchArray(MYSQL_ASSOC);//已添加项目表读取
		$db->select("ashop", "*", "bid=$bid and del and sl");$ashop = $db->fetchArray(MYSQL_ASSOC);//已添加项目表读取
		if($table=="aitem"){
		}else{
			
			if(empty($ashop)){
				echo"<tr><td colspan='14'>暂无商品请添加</td></tr>";
			}else{
				$c=$srmb=0;
				echo "[ashop]";
				foreach($ashop as $row){
					$c++;
					$db->select("shop", "*", "sid=".$row["sid"]."");$sshop= $db->fetchArray(MYSQL_ASSOC);
					$smoney=($sshop[0]["sdj"]*$row["sl"]);
					$srmb+=$smoney;
					$bm="SP".fz($sshop[0]["company"]).fz($row["id"]);
					echo" <input type='hidden' id='sid+".$c."' value='".$row["sid"]."'>";
					echo"<tr id='asid".$c."' class='".$row["id"]."'>";
					echo"
						<td>".$c."</td>
						<td>".$bm."</td>
						<td id='sp".$c."'>".$sshop[0]["sname"]."</td>
						<td>".$sshop[0]["spp"]."</td>
						<td>".$sshop[0]["tips"]."</td>
						<td>".$sshop[0]["scar"]."</td>
						<td>".$sshop[0]["sdw"]."</td>
						<td><input type='text' disabled id='smoney".$c."' style='width:25px;' class='input_td' value='".$sshop[0]["sdj"]."' />元</td>
						<td><input type='text' onChange='crm(".$c.",\"ashop\")' id='sl".$c."' style='width:30px;cursor:pointer;' class='input_td' value='".$row["sl"]."' /></td>
						<td id='srmb".$row["id"]."'>$smoney 元</td>
						<td>".$row["gr"]."</td>
						<td>".$row["tips"]."</td>
						<td><button class='btn btn-danger btn-xs'
							onclick='tuihuo(".$row["id"].",\"".$sshop[0]["sname"]."\",".$c.",".$sshop[0]["sid"].")'
						>退货</button></td>
						";
					echo"</tr>";	
				}
			echo "[/ashop]";				
			}
		}/**/
	break;
	
//删除已添加项目
	case"delxm":
		$aiid=$_POST["aiid"];
		$bid=$_POST["bid"];
		$db->delete("aitem", "id=".$aiid."");
		$db->select("aitem", "*", "bid=$bid");$aitem= $db->fetchArray(MYSQL_ASSOC);
		$money=0;
		$c=0;
		echo "[aitem]";
			foreach($aitem as $row){
				$c++;
				$db->select("item", "*", "id=".$row["iid"]."");$iitem = $db->fetchArray(MYSQL_ASSOC);
				$money+=$row["gs"];
				$bm=$iitem[0]["itemid"];
				echo"<tr id='aiid".$c."' class='".$row["id"]."'>";
				echo"
					<td>".$c."</td>
					<td>".$bm."</td>
					<td>".$iitem[0]["itemname"]."</td>
					<td><input type='text' id='gs".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].");jisuan()' value='".$row["gs"]."' name='gs'></td>
					<td><input type='date' id='st".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].")' value='".$row["stime"]."'/></td>
					<td><input type='date' id='et".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].")' value='".$row["etime"]."'/></td>
					<td>".$row["gr"]."</td>
					<td>项目分类</td>
					<td><input type='text' id='ps".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].")' value='".$row["tips"]."' /></td>
					<td><button class='btn btn-danger btn-xs' onclick='delxm(".$row["id"].",$bid)'>删除</button></td>";
				echo"</tr>";	
			}
		echo "[/aitem]";
	break;
	case "cgxm":
		$id=$_POST["id"];
		$gs=$_POST["gs"];
		$st=$_POST["st"];
		$et=$_POST["et"];
		$ps=$_POST["ps"];
		$aitemInfo = array('gs'=>$gs,'stime'=>$st,'etime'=>$et,'tips'=>$ps);
        $db->update("aitem", $aitemInfo, "id =$id");
		//echo $db->printMessage;
		//echo $db->printMessage;

	break;
/*更新订单信息*/
   case"upbill":
   		$id=$_POST["bid"];
		echo $id;
		$khname=$_POST["khid"];
		$btype=$_POST["btype"];
        $bps=$_POST["bps"];
		$zje=$_POST["zje"];
		
		$billInfo = array('kehu' => $khname,'btype'=>$btype,'tips'=>$bps,'zje'=>$zje);
        $db->update("bill", $billInfo, "id =".$id);
		echo $db->printMessage();		
	break;
 /*订单编辑 价格实时更新*/
   case"upais":
		$aisid=$_POST["id"];
		$table=$_POST["table"];
		$gsl=$_POST["gsl"];
		$isyh=$_POST["isyh"];
		if($table=="aitem")$upisInfo = array('gs' => $gsl,'yh'=>$isyh);else $upisInfo = array('sl' => $gsl,'yh'=>$isyh);
		$db->update($table, $upisInfo, "id = ".$aisid);
        echo $db->printMessage();	
	break;
/*订单条件查询*/
   case"cxbill":
		$bid=$_POST["bid"];
		$bkh=$_POST["bkh"];
		$sdate=$_POST["sdate"];
		$edate=$_POST["edate"];
		!$edate?$edate=date('Ymd'):$edate;
		$cp=$_POST["cp"];
		//从客户表中获取名字或电话中包含搜索条件$bkh 的记录
		$db->select("kehu", "*", "company =".$cp." and (name like '%".$bkh."%' or phone like '%".$bkh."%')");
		$tjkh = $db->fetchArray(MYSQL_ASSOC);
		//客户条件初始化
		$khtj="";
		//遍历获取答符合上方条件的记录中的id 并加入的 客户条件变量$khtj中
		foreach($tjkh as $row){
			$khtj.="kehu=".$row["id"]." or ";	
		}
		$khtj.="0";
		/*客户条件获取结束*/
		#查询符合条件为（bid 中包含搜索条件 $bid 且 日期值介于 $sdate-$edate之间 且 客户名称符合客户条件）的记录数的总和 赋值给总记录数$zjl
		//echo "<br>select * from bill where company=".$cp." and  bid like '%".$bid."%'  and (date between '".$sdate."' and '".$edate."') and (".$khtj.") <br>";
		$db->select("bill", "count(*) as ct", "company=".$cp." and bid like '%".$bid."%'  and (date between '".$sdate."' and '".$edate."') and (".$khtj.") ");$bills = $db->fetchArray(MYSQL_ASSOC);  //获取数据
		//print_r($bills);
		$zjl=$bills[0]["ct"];//总记录条数
		$page = new Page($zjl,8); //分页类构造初始化 每页显示8条
		#查询符合条件为（bid 中包含搜索条件 $bid 且 日期值介于 $sdate-$edate之间 且 客户名称符合客户条件）的所有记录 赋值给二维数组$bills
		$db->select("bill", "*", "bid like '%".$bid."%' and date between '".$sdate."' and '".$edate."' and (".$khtj.")".$page->limit1()."");
		$cxbill = $db->fetchArray(MYSQL_ASSOC);
        $c=0;
		//echo "<tr> <td colspan='17'>SELECT * FROM bill WHERE bid LIKE '%".$bid."%' AND date BETWEEN '".$sdate."' AND '".$edate."' AND (".$khtj.")</td></tr>";
		$jsfs="<select><option>支付宝付款</option><option>微信付款</option><option>现金付款</option>
				<option>合作商付款</option></select>";
		$ywzt="<select><option>完成中</option><option>已完成</option></select>";
		$ywlx="<select><option>美容</option><option>维修</option><option>保养</option>
				<option>改装</option></select>";
		echo "<tr><td>序号</td><td>单号</td><td>开单日期</td><td>客户名称</td><td>联系手机</td><td>车牌号</td>
				<td>接待人</td><td>应收金额</td><td>结算日期</td>
				<td>结算方式</td><td>业务状态</td><td>结算状态</td><td>业务类型</td><td>备注</td></tr>";
		if(empty($cxbill)){echo "<tr><td colspan='17'>啊哦~找不到匹配的订单信息!<b style='color:red;'>( ´･ ̮ ･` )</b></td></tr>";}else{
		foreach($cxbill as $row){
			$c++;
			$db->select("kehu", "*", "id=".$row["kehu"]."");$kehu = $db->fetchArray(MYSQL_ASSOC);
			echo"<tr>
			<td>".$c."</td>
			<td><a href='ebill.php?bid=".$row["id"]."'>".$row["bid"]."</a></td>
			<td>".$row["date"]."</td>
			<td>".$kehu[0]["name"]."</td>
			<td>".$kehu[0]["phone"]."</td>
			<td>".$kehu[0]["carid"]."</td>
			
			<td>员工一</td>
			<td><b style='color:#b67f00;'>".($row["zje"]*1)."￥</b></td>
	
			<td>未结</td>
			<td>".$jsfs."</td>
			<td>".$ywzt."</td>
			<td>".$row["zt"]."</td>
			<td>".$ywlx."</td>
			<td>".$row["tips"]."</td>
		</tr>";
		}
		 echo "<tr><td colspan='17'> <div class='page'>".$page->showpage()."</td></tr></div>"; 
	} 	
	break;

/*商品删除*/
	case "delsp":
		$sid=$_POST["sid"];
		$shopInfo = array('del' => 0);
		$db->update("shop", $shopInfo, "sid = ".$sid."");
		echo $db->printMessage();
	break;
	case "skh":
		$kid=$_POST["id"];
		$name=$_POST["name"];
		$tel=$_POST["tel"];
		$vip=$_POST["vip"];
		$carid=$_POST["carid"];
		$cart=$_POST["cart"];
		$color=$_POST["color"];
		$nkm=$_POST["nkm"];
		$nbkm=$_POST["nbkm"];
		$nbtime=$_POST["nbtime"];
		$nback=$_POST["nback"];
		$nbx=$_POST["nbx"];
		$bxcp=$_POST["bxcp"];
		$tips=$_POST["tips"];
		//$id.$name.$id.$name.$tel.$vip.$carid.$cart.$color.$nkm.$nbkm.$nbtime.$nback.$nbx.$bxcp.$tips
		$kehuInfo = array('name'=>$name,'phone'=>$tel,'vip'=>$vip,'carid'=>$carid,'car_type'=>$cart,'car_color'=>$color,'new_km'=>$nkm,'next_by_km'=>$nbkm,'next_by_time'=>$nbtime,'next_back'=>$nback,'next_bx'=>$nbx,'bx_company'=>$bxcp,'tips'=>$tips);
		echo "客户id=".$kid."\n";
		$db->update("kehu", $kehuInfo, "id = ".$kid."");
		echo $db->printMessage();		
        //echo $id.$name.$id.$name.$tel.$vip.$carid.$cart.$color.$nkm.$nbkm.$nbtime.$nback.$nbx.$bxcp.$tips;	
	break;
	case "akh":
		$cp=$_POST["cp"];
		$name=$_POST["name"];
		$tel=$_POST["tel"];
		$carid=$_POST["carid"];
		$cart=$_POST["cart"];
		$color=$_POST["color"];
		$nkm=$_POST["nkm"];
		$nbkm=$_POST["nbkm"];
		$nbtime=$_POST["nbtime"];
		$nback=$_POST["nback"];
		$nbx=$_POST["nbx"];
		$bxcp=$_POST["bxcp"];
		$tips=$_POST["tips"];
		echo "公司".$cp;
		  //echo $name.$tel.$carid.$cart.$color.$nkm.$nbkm.$nbtime.$nback.$nbx.$bxcp.$tips;	
		$kehuInfo = array('name'=>$name,'phone'=>$tel,'carid'=>$carid,'car_type'=>$cart,'car_color'=>$color,'new_km'=>$nkm,'next_by_km'=>$nbkm,'next_by_time'=>$nbtime,'next_back'=>$nback,'next_bx'=>$nbx,'bx_company'=>$bxcp,'tips'=>$tips,'company'=>$cp,'intime'=>date("Ymd"));
		$db->insert("kehu", $kehuInfo);
		/*****************************************以下是会员卡号生成部分 */
		//获取该公司最后一条记录的id
		$db->select("kehu", "id", "company=".$cp." order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
		//获取该公司的会员数
		$db->select("kehu", "count(*) as ct", "company=".$cp."");$kehu = $db->fetchArray(MYSQL_ASSOC);$number=$kehu[0]["ct"];
		//根据该ID查询该条数据 获取公司 和 信息日期 
		$db->select("kehu", "*", "id=".$reid[0]["id"]."");$kehu = $db->fetchArray(MYSQL_ASSOC);
		//会员卡号生成  格式 VIP+公司+日期+第几位
		$vip="VIP".$kehu[0]["company"].date('Ymd',strtotime($kehu[0]["intime"])).fz($number);
		echo "\nVIP:".$vip."\n";
		$kehuInfo = array('vip'=>$vip);
		$db->update("kehu", $kehuInfo, "id = ".$reid[0]["id"]."");
		echo $db->printMessage();	
	break;
	/*客户删除*/
	case "dkh":
		$kid=$_POST["kid"];
		echo "客户id".$kid."\n";
		$kehuInfo = array('del' => 0);
		$db->update("kehu", $kehuInfo, "id = ".$kid."");
		echo $db->printMessage();
	break;
	/*安全库存设置*/
	case "akc":
		$sid=$_POST["sid"];
		$akc=$_POST["akc"];
		echo "客户id".$kid."\n";
		$shopInfo = array('akc' => $akc);
		$db->update("shop", $shopInfo, "sid = ".$sid."");
		echo $db->printMessage();
	break;
	
	/***************************************************************************下面是yunku官网部分*/
	/*登录*/
	case "logout":
		session_start();
		@session_destroy();
	break;
	case "login":
		$user=$_POST["user"];
		$pwd=$_POST["pwd"];
		$users=SELECT("user","user,password,company,head,id,name","user='$user'");
		if(empty($users)){
			echo "用户不存在";	
		}else if($user==$users[0]["user"]&&$pwd==$users[0]["password"]){
			session_start();
			echo "\n".$_SESSION['user']=$users[0]["user"];
			echo "\n".$_SESSION['name']=$users[0]["name"];
			echo "\n".$_SESSION['company']=$users[0]["company"];
			echo "\n".$_SESSION['head']=$users[0]["head"]; 
			echo "\n".$_SESSION['USERID']=$users[0]["id"]; 
			echo "\n已经创建session变量user：".$_SESSION['user']."\ncompany：".$_SESSION['company'];	
			echo "\n登录成功\n[url]http://".HOST."/zdcar2/[/url]\n";
		}else{
			echo "用户名或密码不正确";	
		}
	break;
	case "lft":
		echo "我是练方梯";
	break;
	/*删除公司员工*/
	case "DeleteUser":
		$USERID=$_POST["USERID"];
		$UserInfo = array('del' => 0);
		$db->update("user", $UserInfo, "id = ".$USERID."");
		echo $db->printMessage();
		
	break;
	/*新增公司员工*/
	case "AddUser":
		echo $_POST["atype"];
		$UserName=$_POST["UserName"];
		$UserPwd=$_POST["UserPwd"];	
		$UserType=$_POST["UserType"];	
		$UserPhone=$_POST["UserPhone"];
		$CompanyID=$_POST["CompanyID"];
		$db->select("user","*","company=".$CompanyID." and user='".$UserName."'"); $User= $db->fetchArray(MYSQL_ASSOC);
		if(!empty($User)){
			die("该用户已存在");
		}else{
	      echo "用户不存在";
		};
		$UserInfo=array('name'=>$UserName,'user'=>$UserName,'phone'=>$UserPhone,'company'=>$CompanyID,'type'=>$UserType,'password'=>$UserPwd,'head'=>"",'openid'=>"",'del'=>1);//将id于用户信息存入user表
		print_r($UserInfo);
		$db->insert("user", $UserInfo); 
		echo $db->printMessage(); 
	break;
	
	/*刷新员工列表*/
	case "ReloadUserList":
		$CompanyID=$_POST["CompanyID"];
		$db->select("user","*","del and company=$CompanyID"); $USERS= $db->fetchArray(MYSQL_ASSOC);
		
		echo "[UserList]";
		$i=0;
		foreach($USERS as $ROW){
					/*处理订单数*/
					$db->select("bill","count(1) as CountBill","u=".$ROW["id"]);$CountBill=$db->fetchArray(MYSQL_ASSOC);
					$db->select("bill","sum(money) as Income","u=".$ROW["id"]);$Income=$db->fetchArray(MYSQL_ASSOC);
					$db->select("bill","bid,kehu,money","u=".$ROW["id"]." order by date desc limit 5");$BillInfo=$db->fetchArray(MYSQL_ASSOC);
					
					/*处理的充值数*/
					$db->select("czjl","count(1) as RCount","u=".$ROW["id"]);$RCount=$db->fetchArray(MYSQL_ASSOC);
					$db->select("czjl","sum(je) as Recharge","u=".$ROW["id"]);$Recharge=$db->fetchArray(MYSQL_ASSOC);
					
					$BInfo="";
					
					foreach($BillInfo as $R){
						$BInfo.=$R["bid"]."   ".selecta("kehu","id",$R["kehu"],"name")."   ".$R["money"]."元\n";
					}
					if($ROW["type"]=="管理员"){
						$DELBUTTON="";
					}else{
						$DELBUTTON="<input type='button' class='btn btn-sm btn-danger' onclick='DeleteUser(".$ROW["id"].")'  value='删除'/>";
					}  
					$OPTION="";
					$USERTYPE=SELECT("user_type","*","");
					
					foreach($USERTYPE as $UT){
						$SED="";
						if($ROW["type"]==$UT["NAME"])$SED="selected";
						$OPTION.="<option value='".$UT["NAME"]."' $SED >".$UT["NAME"]."</option>";
					}
				
					$TYPELIST="<select class='input_td' onChange='CTYP(this,".$ROW["id"].")'> 
									$OPTION
							   </select>";
					echo "<tr><td>".++$i."</td>
						  <td name='User'>".$ROW["user"]."</td>
						  <td><input type='password' class='input_td' value='".$ROW["password"]."' onfocus='showpwd(this)' onblur='hidepwd(this)' onChange='CPWD(this,".$ROW["id"].")' /></td> 
						  <td>".$TYPELIST."</td>
						  <td><input  class='input_td' value='".$ROW["phone"]."' onChange='CPHO(this,".$ROW["id"].")'/></td>
						  <td><a href='#' title='".$BInfo."....'>".$CountBill[0]["CountBill"]."</a></td>
						  <td>".$Income[0]["Income"]."元</td>
						  <td>".$RCount[0]["RCount"]."</td>
						  <td>".$Recharge[0]["Recharge"]."元</td>
						  <td>
							".$DELBUTTON."
						  </td>
						  </tr>";
				}
		echo "[/UserList]";
	break;	
	/*注册*/
	case "singup";
		//name:name,cp:cp,tel:tel,pwd:pwd 
		$name=$_POST["name"];
		$cp=$_POST["cp"];
		$tel=$_POST["tel"];
	    $pwd=$_POST["pwd"];
		$openid=$_POST["openid"];
		$head=$_POST["hd"];
		$cpInfo=array('name'=>$cp);
		$db->insert("company", $cpInfo);//先向公司表增加一条数据
		$db->select("company", "id", "1=1 order by id desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);	//返回新增的id
		$userInfo = array('name'=>$name,'user'=>$tel,'phone'=>$tel,'company'=>$reid[0]["id"],'password'=>$pwd,'head'=>$head,'openid'=>$openid);//将id于用户信息存入user表
		$db->insert("user", $userInfo);
		if($openid!=""){
			$db->select("user","*","openid='".$openid."'");$user=$db->fetchArray(MYSQL_ASSOC);
			@session_start();
			echo $_SESSION['user']=$user[0]["user"];
			echo $_SESSION['name']=$user[0]["name"];
			echo $_SESSION['company']=$user[0]["company"];
			echo $_SESSION['head']=$user[0]["head"];
			
			echo "@QQ登录跳转@";
		};
		echo $db->printMessage();
	break;
	/*检测用户名是否已存在*/
	case "ckuser":
	$user=$_POST["user"];
		$db->select("user","*","user='".$user."' or phone='".$user."'"); $user = $db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		if(empty($user))echo"可用";else echo"不可用";
	break;
	case "echoto":
		$value=$_POST["key"];
		$CacheInfo = array('value'=>$value);//将id于用户信息存入user表
			$db->insert("cache", $CacheInfo);
			echo $db->printMessage();	
		/*
			$userInfo = array('name'=>$name,'key'=>$key,'company'=>$cp);//将id于用户信息存入user表
		$db->select("kehu","*","us='".$user."' or phone='".$user."'"); $user = $db->fetchArray(MYSQL_ASSOC);
			echo $db->printMessage();
			if(empty($user))echo"可用";*/
	break;
	case "echoba":
		$value=$_POST["key"];
		$db->select("cache","*","value=".$value); $cache = $db->fetchArray(MYSQL_ASSOC);
		if(!empty($cache))echo"已被访问";else echo"未被访问";
	break;
	case "khinfoba":
		$key=$_POST["key"];
		echo "\nkey:".$key."\n";
		$db->select("kehu","*","khkey='".$key."'"); $kehu = $db->fetchArray(MYSQL_ASSOC);
		echo "SELECT　* FROM kehu WHERE khkey='".$key."'";
		if(!empty($kehu)){
			echo "{id}".$kehu[0]["id"]."{/id}";
			echo "{name}".$kehu[0]["name"]."{/name}";
			echo "{phone}".$kehu[0]["phone"]."{/phone}";				
		 }else{
			echo "未检测到数据";	 
		}
	break;
	/*订单删除*/
	case "dbill":
		$bid=$_POST["bid"];
		echo $bid;
		$bInfo = array('del' => 0);
		$db->update("bill", $bInfo, "id = ".$bid."");
		echo $db->printMessage();
		//echo ;		
	break;
	/*商品退货*/
	case "spth":
		$sid=$_POST["sid"];
		$khid=$_POST["khid"];
		$thsl=$_POST["thsl"];
		$thyy=$_POST["thyy"];
		$del=$_POST["del"];
		$asid=$_POST["asid"];
		$cp=$_POST["cp"];
		$bid=$_POST["bid"];
		//$del?$del=1:$del=0;
		$thInfo = array('khid'=>$khid,'jsr'=>1,'sl'=>$thsl,'sp'=>$sid,'tips'=>$thyy,'cp'=>$cp,'bid'=>$bid,'date'=>date("Ymd"));//退货表信息
		$db->insert("tuihuo", $thInfo);	
		echo "\n数据插入状态：".$db->printMessage()."\n";
		$bInfo = array('sl' => $del,'del'=>$del);
		$db->update("ashop", $bInfo, "id = ".$asid);
		echo "\n数据更新状态：".$db->printMessage()."\n";
		echo "商品id：".$sid."\n客户：id".$khid."\n退货数量：".$thsl."\n退货原因：".$thyy."\n删除状态：".$del."\n";
		$db->select("shop","*","sid=$sid"); $shops = $db->fetchArray(MYSQL_ASSOC);
		$shop=array("skc"=>($shops[0][skc]+$thsl));
		$db->update("shop",$shop,"sid=$sid");
		//sid:sid,khid:khid,thsl:thsl,thyy:thyy,del:del
	break;	
	/*商品重新加载*/
	case "reloadsp":
		$bid=$_POST["bid"];
		$db->select("ashop", "*", "bid=$bid and del and sl");$ashop = $db->fetchArray(MYSQL_ASSOC);//已添加项目表读取
		if(empty($ashop)){
			echo"<tr><td colspan='14'>暂无商品请添加</td></tr>";
		}else{
			$c=$srmb=0;
			echo "[ashop]";
			foreach($ashop as $row){
				$c++;
				$db->select("shop", "*", "sid=".$row["sid"]."");$sshop= $db->fetchArray(MYSQL_ASSOC);
				$smoney=($sshop[0]["sdj"]*$row["sl"]);
				$srmb+=$smoney;
				$bm="SP".fz($sshop[0]["company"]).fz($row["id"]);
				echo" <input type='hidden' id='sid+".$c."' value='".$row["sid"]."'>";
				echo"<tr id='asid".$c."' class='".$row["id"]."'>";
				echo"
					<td>".$c."</td>
					<td>".$bm."</td>
					<td id='sp".$c."'>".$sshop[0]["sname"]."</td>
					<td>".$sshop[0]["spp"]."</td>
					<td>".$sshop[0]["tips"]."</td>
					<td>".$sshop[0]["scar"]."</td>
					<td>".$sshop[0]["sdw"]."</td>
					<td><input type='text' disabled id='smoney".$c."' style='width:25px;' class='input_td' value='".$sshop[0]["sdj"]."' />元</td>
					<td><input type='text' onChange='crm(".$c.",\"ashop\")' id='sl".$c."' style='width:30px;cursor:pointer;' class='input_td' value='".$row["sl"]."' /></td>
					<td id='srmb".$row["id"]."'>$smoney 元</td>
					<td>".$row["gr"]."</td>
					<td>".$row["tips"]."</td>
					<td><a data-toggle='modal' href='#spth' class='btn btn-danger btn-xs' onclick='tuihuo(".$row["id"].",\"".$sshop[0]["sname"]."\",".$row["sl"].",".$sshop[0]["sid"].")' >退货</a></td>";
				echo"</tr>";	
			}
			echo "[/ashop]";
		}
	break;
	/*项目重新加载*/
	case "reloaditem":
		$cp=$_POST["cp"];
		$db->select("item", "*", "company=$cp");$item = $db->fetchArray(MYSQL_ASSOC);//已添加项目表读取
		if(empty($item)){
			echo"<tr><td colspan='14'>尚未添加维修项目</td></tr>";
		}else{
		//echo "[ashop]";
			$i=0;
			foreach($item as $row){
				echo"<input type='hidden' name='ItemId' value='".$row["id"]."'/>";
				echo"<tr name='items'>";
				echo"<td>".($i+1)."</td>";
				echo"<td name='ItemBm'>".$row["itemid"]."</td>";
				echo"<td name='ItemName'>".$row["itemname"]."</td>";
				echo"<td name='ItemType'>".btypet($row["item_type"])."</td>";
				echo"<td name='ItemTips'>".$row["tips"]."</td>";
				echo"<td><button data-dismiss='modal' class='btn btn-success btn-xs' onclick='ChoseItem(".$i++.")'>选择</button></td>";
				echo"</tr>";
			}
			//echo "[/ashop]";
		}
	break;
	/*分类下项目列表重新加载*/
	case "ReloadItemList":
		$cp=$_POST["cp"];
		$Btype=$_POST["Btype"];
		$db->select("item", "*", "company=$cp and item_type=$Btype");$item = $db->fetchArray(MYSQL_ASSOC);//已添加项目表读取
		if(empty($item)){
			echo"<tr><td colspan='14'>您尚未添加<b class='btn-warning btn-sm'>".btypet($Btype)."</b>分类下的项目</td></tr>";
		}else{
		//echo "[ashop]";
			$i=0;
			foreach($item as $row){
				echo"<input type='hidden' name='ItemId' value='".$row["id"]."'/>";
				echo"<tr name='items'>";
				echo"<td>".($i+1)."</td>";
				echo"<td name='ItemBm'>".$row["itemid"]."</td>";
				echo"<td name='ItemName'>".$row["itemname"]."</td>";
				echo"<td name='ItemType'>".btypet($row["item_type"])."</td>";
				echo"<td name='ItemTips'>".$row["tips"]."</td>";
				echo"<td><button data-dismiss='modal' class='btn btn-success btn-xs' onclick='ChoseItem(".$i++.")'>选择</button></td>";
				echo"</tr>";
			}
			//echo "[/ashop]";
		}
	break;	
	/*充值记录*/
	case "czjl":
		$kh=$_POST["kh"];
		//$cp=$_POST["cp"];
		$db->select("czjl","*","kh=".$kh." order by date desc"); $czjl = $db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		if(!empty($czjl)){
			foreach($czjl as $row){
				echo "<tr>
						<td>".$row["date"]."</td>
						<td>".$row["je"]."</td>	
						<td>".jsfst($row["zf"])."</td>	
						<td>".$row["bm"]."</td>	
						<td>".$row["tips"]."</td>	
					 </tr>";	
			}	
		}else{
			echo"<tr><td colspan='5' >暂无记录</td></tr>";	
		}
	    echo"<tr><td colspan='5' ><input type='button' value='充值' class='botton' onClick=\"$('#cz1').toggle(200)\"/></td></tr>";
		echo "<input type='hidden' value='".$kh."' id='khid'>";
	break;
	
	case "ShowCzjl":
		$kh=$_POST["kh"];
		//$cp=$_POST["cp"];
		$npage=$_POST["page"];
		$db->select("czjl","count(1) as ct","kh=".$kh); $czjl = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page3($czjl[0]["ct"],PageSize,$npage,$kh,"czjl");
		$db->select("czjl","*","kh=".$kh." order by date desc ".$page->limit1()); $czjl = $db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		echo "[czjl2]";
		//echo "kh=".$kh." order by date desc ".$page->limit1().$czjl[0]["ct"];
		if(!empty($czjl)){
			$i=0;
			foreach($czjl as $row){
				echo "<tr>
						<td>".(++$i)."</td>
						<td>".$row["date"]."</td>
						<td><b class='btn btn-success btn-xs'>".$row["je"]."￥</b></td>	
						<td>".jsfst($row["zf"])."</td>	
						<td>".$row["tips"]."</td>	
						<td name='edit' style='display:none;'><b class='btn btn-danger btn-xs' onClick='hide(this)'>X</b></td>
					 </tr>";	
			}	
		}else{
			echo"<tr><td colspan='6'>暂无记录</td></tr>";	
		}
		echo "<tr><td colspan='6' >".$page->showpage()."</td></tr>";
		echo "<input type='hidden' value='".$kh."' id='khid'>[/czjl2]";
		echo "[info]<b class='btn btn-info'>姓名:".selecta("kehu","id",$kh,"name")."</b>
					<b class='btn btn-danger'>当前余额:".(selecta("kehu","id",$kh,"money")*1)."元</b>[/info]";
	break;	
	
	/*刷新商品列表*/
	case "ReloadShop1":
		$cp=$_POST["cp"];
		$bid=$_POST["bid"];
		$db->select("shop", "*", "del and company=".$cp );$shop = $db->fetchArray(MYSQL_ASSOC);//商品表读取
		$i=0;
		echo"[ashop]";
		foreach($shop as $row){
			echo "<tr id='sid".$i."' class='".$row["sid"]."'>";
			echo"<td>".($i+1)."</td>";
			echo"<td>SP00".$row["sid"]."</td>";
			echo"<td>".$row["sname"]."</td>";
			echo"<td>".$row["spp"]."</td>";
			echo"<td>".$row["sdw"]."</td>";
			echo"<td>".$row["skc"]."</td>";
			echo"<td>".$row["scar"]."</td>";
			echo"<td>".$row["sdj"]."</td>";
			echo"<td><button class='btn btn-success btn-xs' data-dismiss='modal' onclick='acshop(".$row["sid"].",$bid,".$row["skc"].",\"".$row["sname"]."\")'>选择</button></td>";
			echo"</tr>";
			$i++;
		}
		if(empty($shop)){
			echo "<tr>
					<td colspan=9>您的仓库尚未添加商品信息，请到<a href='3-1.php'>商品管理</a>页面进行管理</td>";
		}
		echo"[/ashop]";
	break;
	case "SearchKehu":
		$npage=$_POST["page"];
		$val=$_POST["val"];
		$cp=$_POST["cp"];
		$db->select("kehu","count(1) as ct","company=$cp and (name like '%$val%' or phone like '%$val%' )");$kehu = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page2($kehu[0]["ct"],PageSize,$npage,$val);
		$db->select("kehu","*","company=$cp and (name like '%$val%' or phone like '%$val%' )".$page->limit1());$kehu = $db->fetchArray(MYSQL_ASSOC);
		echo "(((";
		foreach($kehu as $row){
			echo"<tr title='客户ID:".$row["id"]."'><td>".$row["vip"]."</td>".
				"<td style='width:100px;'>".$row["name"]."</td>".
				"<td>".$row["phone"]."</td>".
				"<td style='width:50px;'><b class='btn-success btn-xs'>".($row["money"]*1)."￥</b></td>".
				"<td style='width:50px;'>".($row["jf"]*1)."</td>".
				"<td>".$row["intime"]."</td>".
				"<td>".($row["vipdj"]*1)."</td>".
				"<td>
				    <!--<a class='btn btn-primary btn-xs' href='http://".HOST."/zdcar2/1-1a.php?khid=".$row["id"]."' target='_blank'>开单</a>-->
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='xfjl(".$row["id"].",1)' href='#kjxf'>快捷消费</a>
				</td>
				 <td>
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='xfjl(".$row["id"].",1)' href='#xfjl'>消费记录</a>
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='car(".$row["id"].",1)' href='#carinfo' >车辆信息</a>
				 <td>
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='czjl(".$row["id"].",1)' href='#cz'>充值</a>
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='czjl(".$row["id"].",1)' href='#addcz'>充值记录</a></td>
				</td>
				<td>
					<a class='btn btn-primary btn-xs' data-toggle='modal' onClick='khinfo(".$row["id"].")' href='#khinfo' >详情</a>
				</td>
				";
		}
		if(empty($kehu))echo"<tr><td colspan=11>呀！无匹配数据哎~</td></tr>";
		echo "<tr><td colspan=12>".$page->showpage()."</td></tr>";
		echo ")))";
		echo "[数据查询信息]".$db->printMessage()."[/数据查询信息]";
		//echo "(((".json_encode($kehu).")))";
	break;
	/*客户信息*/
	case "khinfo":
		echo $khid=$_POST["khid"];
		$db->select("kehu","*","id=".$khid);$kehu = $db->fetchArray(MYSQL_ASSOC);
		if($kehu[0]["wx_openid"]!=""){
			$db->select("kehu_wx","*","openid='".$kehu[0]["wx_openid"]."'");$kehu_wx = $db->fetchArray(MYSQL_ASSOC);
			print_r($kehu_wx);
			$head=$kehu_wx[0]["head"];
			$wxinfo=$kehu_wx[0]["name"];
			$COMPANY_ID=$kehu[0]["company"];
			$OPENID=$kehu[0]["wx_openid"];
			$QRURL="http://".HOST."/weixin/main/index1.php?c=$COMPANY_ID&openid=$OPENID";
			$QRIMG_S_URL="http://".toShortUrl($QRURL); 
			$QRIMG=QR($QRIMG_S_URL,"L",10);
		}else{
			$head="img/head.png";
			$wxinfo="未绑定";
			$COMPANY_ID=SELECTA("kehu","id",$khid,"company");
			$QRURL="http://".HOST."/weixin/main/bding.php?c=$COMPANY_ID&k=$khid";
			$QRIMG_S_URL="http://".toShortUrl($QRURL); 
			$QRIMG=QR($QRIMG_S_URL,"L",10);
		}
		echo "[khinfotab]<tr>
				<td>姓名</td><td><input  onChange='khinfosave()' id='khname' class='input_td' value='".$kehu[0]["name"]."'/></td></tr>
				<tr><td>手机</td><td><input onChange='khinfosave()' id='khphone' class='input_td' value='".$kehu[0]["phone"]."'/></td></tr>
				<tr><td>默认车辆</td><td>".$kehu[0]["carid"]."</td></tr>
				<tr><td>备注信息</td><td ><input onChange='khinfosave()' id='khtips' class='input_td' value='".$kehu[0]["tips"]."'/></td></tr>
				<tr><td>微信</td><td><a href='#' onClick='aaaa()'>".$wxinfo."</a></td><input type='hidden' value=".$khid." id='khid'/></tr>
				<tr><td>SAPI</td><td title='原链接:$QRURL'>$QRIMG_S_URL</td></tr>
				<!--<tr><td>LAPI</td><td>$QRURL</td></tr>-->
				[/khinfotab]";
		
		/*等级校准*/	
		$LV=0;
		$EXP=$kehu[0]["exp"]*1;
		while(1){
			$LV++;
			if((($LV*($LV+1)/2)*50)>$EXP)break;
		}
		if($EXP!=$kehu[0]["vipdj"]){
			$kehuinfo=array('vipdj'=>$LV);
			$db->update("kehu",$kehuinfo," id= ".$khid);
			echo $db->printMessage();
		}
		/*等级校准*/
		
		echo "[vip]".$kehu[0]["vip"]."[/vip]";
		echo "[khdj]".$LV."[/khdj]";
		echo "[khhead]".$head."[/khhead]";
		echo "[exp]".($kehu[0]["exp"]*1)."[/exp]";
		
		echo "[qrimg] $QRIMG [/qrimg]";
		echo "[qrimgurl] $QRIMG_S_URL [/qrimgurl]";
		
	break;
	case "khinfosave":
		$id=$_POST["khid"];
		$name=$_POST["khname"];
		$phone=$_POST["khphone"];
		$tips=$_POST["khtips"];
		$khinfo=array('name'=>$name,'phone'=>$phone,'tips'=>$tips);
		$db->update("kehu",$khinfo," id= ".$id);
		print_r($khinfo);
		echo $db->printMessage();
	break;
	case "KehuList":
		$npage=$_POST["page"];
		$val=$_POST["val"];
		$cp=$_POST["cp"];
		$db->select("kehu","count(1) as ct","company=$cp and (name like '%$val%' or phone like '%$val%' )");$kehu = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page3($kehu[0]["ct"],PageSize,$npage,$val,"GetkehuList");
		$db->select("kehu","*","company=$cp and (name like '%$val%' or phone like '%$val%' )".$page->limit1());$kehu = $db->fetchArray(MYSQL_ASSOC);
		echo "[kehulist]";
		$i=0;
		foreach($kehu as $row){
			echo"<tr><td>".++$i."</td>".
			    "<td name='KehuName'>".$row["name"]."</td>".
				"<td name='KehuPhone'>".$row["phone"]."</td>".
				"<td>".$row["carid"]."</td>".
				"<td>".$row["tips"]."</td>".
				"<td><button class='btn btn-primary btn-xs' data-dismiss='modal' onclick='ChoseKehu(".($i-1).",".$row["id"].")'>选择</button></td>";
		       
		}
		if(empty($kehu))echo"<tr><td colspan=11>呀！无匹配数据哎~</td></tr>";
		echo "<tr><td colspan='7'>".$page->showpage()."</td></tr>";
		echo "[/kehulist]";
		echo "[数据查询信息]".$db->printMessage()."[/数据查询信息]";
		//echo "(((".json_encode($kehu).")))";
	break;
	case "SearchBill":
		$val=$_POST["val"];
		$cp=$_POST["cp"];
		$npage=$_POST["page"];
		$db->select("kehu","*","name like '%$val%' or phone like '%$val%' ");$kehu = $db->fetchArray(MYSQL_ASSOC);
	
		$khtj="";
		foreach($kehu as $row){
			$khtj.="kehu=".$row["id"]." or ";	
		}
		$khtj.="0"; 
		$Condition="company=$cp and(bid like '%$val%' or kehu in(select id from kehu WHERE name like '%$val%' or phone like '%$val%') ) and del order by zt,date desc ";
		$db->select("bill", "count(1) as ct",$Condition );$bill = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page2($bill[0]["ct"],PageSize,$npage,$val);
		$db->select("bill", "*",$Condition.$page->limit1());$billa = $db->fetchArray(MYSQL_ASSOC);
		
		//echo "select * from bill where ".$Condition.$page->limit1(); 
		//print_r($billa);  
		$i=0;
		//echo "company='$cp' and(bid like '%$val%' or $khtj ) order by date desc".$page->limit1();
		echo "[searchbill]<tr>
					<td>序号</td>
					<td>单号</td>
					<td>客户</td>
					<td>电话</td>
					<td>日期</td>
					<td>总额</td>
					<td>未结</td>
					<td>结算</td>
					<td>详情</td>
					<td>操作</td>
				</tr>";
		foreach($billa as $row){
			$KehuName=selecta("kehu","id",$row["kehu"],"name");
			if($row["zt"]){
				$JiesuanButton="<input type='button' class='btn btn-success btn-xs' value='已结算'/>";
				$XianQingButton="<a href='sbill.php?bid=".$row["id"]."&khname=$KehuName' target='_blank' class='btn btn-info btn-xs'>详细信息</a>";
			}else{
				$JiesuanButton="<input type='button' class='btn btn-danger btn-xs'  onClick='BillPay(".$row["id"].",".$row["kehu"].",1,this)' value='结算'/>"; 	 
				$XianQingButton="<a href='ebill.php?bid=".$row["id"]."&khname=$KehuName' target='_blank' class='btn btn-warning btn-xs'>添加消费</a>";
			}
			if($row["yhval"]!=0 and $row["yhval"]!=""){
				 if($row["yhtype"]){
					$money=$row["money"]*($row["yhval"]/100);
					$moneyinfo=$money."元(".$row["money"]."x".($row["yhval"]/100)."%)"; 
				 }else{
					$money=$row["money"]-($row["yhval"]/1);
					$moneyinfo=$money."元(".$row["money"]."-".$row["yhval"].")";
				 }
			}else{
				$money=$row["money"];
				$moneyinfo=$money."元";
			}
			echo "
				<tr>
					<td>".++$i."</td>
					<td width=200>".$row["bid"]."</td>
					<td>".$KehuName."</td>
					<td>".selecta("kehu","id",$row["kehu"],"phone")."</td>
					<td>".$row["date"]."</td>
					<td>".$moneyinfo."</td>
					<td>".($money-$row["yjie"])."元</td>
					<td>".$JiesuanButton."</td>
					<td>".$XianQingButton."</td>
					<td>
						<input type='button' class='btn btn-warning btn-xs' value='打印' onclick='PrintBill(".$row["id"].")'/>
						<input type='button' class='btn btn-danger btn-xs' value='删除' onclick='DeleteBill(".$row["id"].")'/>
					</td>
				  </tr>";
		}
		if(empty($billa))echo "<tr><td colspan=9>哦哦~未找到匹配的订单~</td></tr>";
		echo "<tr><td colspan=10>".$page->showpage()."</td></tr>[/searchbill]";
		//print_r($billa);
		
	break;
	case "SearchItem":
		$cp=$_POST["cp"];
		$val=$_POST["val"];
		$npage=$_POST["page"];
		$condition=" (itemname like '%$val%' or itemid like '%$val%' or item_type like '%$val%' ) ";
		$db->select("item", "count(*) as ct", "del and company=".$cp." AND $condition ");$item = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page2($item[0]["ct"],PageSize,$npage,$val);
		//echo "setpage:".$page->setPage($npage);
		$db->select("item", "*", "del and company=".$cp." AND $condition order by item_type desc ".$page->limit1());$item = $db->fetchArray(MYSQL_ASSOC);//商品表读取
		//$db->select("shop", "*", "del and company=".$cp." and sname like '%$val%' ");$shop2 = $db->fetchArray(MYSQL_ASSOC);//商品表读取
			$i=0;
			echo"[aitem]";
				//echo "<b class='btn btn-info'>SELECT * FROM shop WHERE del AND company=".$cp." AND $condition ORDER BY spp DESC ".$page->limit1()." </b>";
				//echo "LIMIT".$page->limit1();
				//echo "<br>npage:".$npage;
			echo $db->printMessage();
			echo "<table class='table table-bordered table-hover table-striped'>";
			echo "
				<thead>
					<th>序号</th>
					<th>项目编码</th>
					<th>项目名称</th>
					<th>添加日期</th>
					<th>项目分类</th>
					<th>备注</th>
					<th>操作</th>
				</thead>
			";
			foreach($item as $row){
				echo "<tr id='iid".$i."' class='".$row["itemid"]."'>";
				echo"<td>".($i+1)."</td>";
				echo"<td>".$row["itemid"]."</td>";
				echo"<td>".$row["itemname"]."</td>";
				echo"<td>".$row["adate"]."</td>";
				
				echo"<td>".$row["item_type"]."</td>";
				
				echo"<td>".$row["tips"]."</td>";
				$eshourl="eitem.php?iid=".$row["id"];
				echo"<td>
						<a class='btn btn-danger btn-xs'  href='$eshourl'>详细</a>
						<button class='btn btn-success btn-xs' onclick=''>新增</button>
					</td>";
				echo"</tr>";
				$i++;
			}
			echo "</table>";
			if(empty($shop)){
				echo "<tr><td colspan=9>您未添加项目</td>";
			}
			echo $page->showpage();
			echo"[/aitem]";
		
	break;
	/*商品查询1 在shouyin.php中 商品管理用*/
	case "SearchShop":
		$cp=$_POST["cp"];
		$val=$_POST["val"];
		$npage=$_POST["page"];
		$condition=" del and company=$cp and (sname like '%$val%' or spp like '%$val%' or scar like '%$val%' or xinghao like '%$val%' or sbm like '%$val%') "; 
		$db->select("shop", "count(*) as ct", " $condition ");$shop = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page3($shop[0]["ct"],PageSize,$npage,$val,"SearchShop");
		//echo "setpage:".$page->setPage($npage);
		$db->select("shop", "*", " $condition order by spp desc ".$page->limit1()."");$shop = $db->fetchArray(MYSQL_ASSOC);//商品表读取
		//$db->select("shop", "*", "del and company=".$cp." and sname like '%$val%' ");$shop2 = $db->fetchArray(MYSQL_ASSOC);//商品表读取
			$i=0;
			echo "[sql]SELECT * FROM shop WHERE $condition [/sql]";
			echo"[ashop]";
				//echo "<b class='btn btn-info'>SELECT * FROM shop WHERE del AND company=".$cp." AND $condition ORDER BY spp DESC ".$page->limit1()." </b>";
				//echo "LIMIT".$page->limit1();
				//echo "<br>npage:".$npage;
			echo $db->printMessage();
			echo "<table class='table table-bordered table-hover table-striped'>";
			echo "
				<thead>
					<th>序号</th>
					<th>配件名称</th>
					<th>配件品牌</th>
					<th>库存</th>
					<th>上传</th>
					<th>单价</th>
					<th>适用车型</th>
					<th>备注</th>
					<th>操作</th>
				</thead>
			";
			/*
			<a class='btn btn-success btn-sm' data-toggle='modal' href='#addsp'>新建商品</a>
			*/
			foreach($shop as $row){
				$classkc="";
				if($row["skc"]<$row["akc"]){$classkc="btn btn-danger btn-xs";}else{$classkc="btn btn-success btn-xs";}
				echo "<tr id='sid".$i."' class='".$row["sid"]."'>";
				echo"<td>".($i+1)."</td>";
				echo"<td>".$row["sname"]."</td>";
				echo"<td>".$row["spp"]."</td>";
				echo"<td><b class='$classkc' title='安全库存:".($row["akc"]*1)."'>".$row["skc"]."</b></td>";
				echo"<td>".selecta("shop_u","sid",$row["sid"],"num")."</td>";
				echo"<td>".$row["sdj"]."元</td>";
				echo"<td>".$row["scar"]."</td>";
				echo"<td>".$row["tips"]."</td>";
				$eshourl="eshop.php?sid=".$row["sid"];
				echo"<td>
						
						<a class='btn btn-success btn-xs' href='#addsp' onclick='AddShop(".$row["sid"].",".$npage.")'>新增</a> 
						<a class='btn btn-success btn-xs' href='#addsp' onclick='ShopUpload(".$row["sid"].",".$row["skc"].",".$npage.")'>上传</a>
						<a class='btn btn-info btn-xs'  href='$eshourl'>详细</a>
						<a class='btn btn-danger btn-xs'  href='javascript:delShop(".$row["sid"].")'>删除</a>
						
					</td>";
				echo"</tr>";
				$i++;
			}
			echo "<tr><td colspan=12><a class='btn btn-success btn-sm' data-toggle='modal' href='#addsp'>新建商品</a></td></tr>";
			echo "</table>";
			if(empty($shop)){
				echo "<tr><td colspan='11'>您的仓库尚未添加商品信息</td></tr>";
			}
			echo "<tr><td colspan=13>".$page->showpage()."</td></tr>";
			echo"[/ashop]";
	break;
	/*商品查找类型2  在ebill.php 订单编辑页面商品选择时使用*/
	case "SearchShop2":
		$cp=$_POST["cp"];
		$val=$_POST["val"];
		$bid=$_POST["bid"];
		$npage=$_POST["page"];
		$condition=" (sname like '%$val%' or spp like '%$val%' or scar like '%$val%' or xinghao like '%$val%') ";
		$db->select("shop", "count(*) as ct", "del and company=".$cp." AND $condition ");$shop = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page3($shop[0]["ct"],PageSize,$npage,$val,"SearchShop");
		//echo "setpage:".$page->setPage($npage);
		$db->select("shop", "*", "del and company=".$cp." AND $condition order by spp desc ".$page->limit1()."");$shop = $db->fetchArray(MYSQL_ASSOC);//商品表读取
		//$db->select("shop", "*", "del and company=".$cp." and sname like '%$val%' ");$shop2 = $db->fetchArray(MYSQL_ASSOC);//商品表读取
			$i=0;
			echo"[ashop]";
				//echo "<b class='btn btn-info'>SELECT * FROM shop WHERE del AND company=".$cp." AND $condition ORDER BY spp DESC ".$page->limit1()." </b>";
				//echo "LIMIT".$page->limit1();
				//echo "<br>npage:".$npage;
			echo $db->printMessage();
			foreach($shop as $row){
				$classkc="";
				if($row["skc"]<$row["akc"]){$classkc="btn btn-danger btn-xs";}else{$classkc="btn btn-success btn-xs";}
				echo "<tr id='sid".$i."' class='".$row["sid"]."'>";
				echo"<td>".($i+1)."</td>";
				echo"<td>SP00".$row["sid"]."</td>";
				echo"<td>".$row["sname"]."</td>";
				echo"<td>".$row["spp"]."</td>";
				echo"<td>".$row["sgg"]."</td>";
				echo"<td>".$row["xinghao"]."</td>";
				echo"<td><b class='$classkc' title='安全库存:".($row["akc"]*1)."'>".$row["skc"]."</b></td>";
				echo"<td>".$row["scar"]."</td>";
				echo"<td>".$row["sdj"]."元</td>";
				$eshourl="eshop.php?sid=".$row["sid"];
				echo"<td><button class='btn btn-success btn-xs' data-dismiss='modal' onclick='acshop(".$row["sid"].",$bid,".$row["skc"].",\"".$row["sname"]."\")'>选择</button></td>";;
				echo"</tr>";
				$i++;
			}
			echo "<tr><td colspan=11><a class='btn btn-success btn-sm' data-toggle='modal' href='#addsp'>新建商品</a></td></tr>";
			if(empty($shop)){
				echo "<tr><td colspan='11'>您的仓库尚未添加商品信息</td></tr>";
			}
			echo "<tr><td colspan='11'>".$page->showpage()."</td></tr>";
			echo"[/ashop]";
	break;
	/*商品查找类型3 shouyin.php 快捷消费时 选择商品时使用*/
	case "SearchShop3":   
		$cp=$_POST["cp"];
		$val=$_POST["val"];
		$bid=$_POST["bid"];
		$npage=$_POST["page"];
		$condition=" (sname like '%$val%' or spp like '%$val%' or scar like '%$val%' or xinghao like '%$val%') ";
		$db->select("shop", "count(*) as ct", "del and company=".$cp." AND $condition ");$shop = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page3($shop[0]["ct"],PageSize,$npage,$val,"SearchShop");
		//echo "setpage:".$page->setPage($npage);
		$db->select("shop", "*", "del and company=".$cp." AND $condition order by spp desc ".$page->limit1()."");$shop = $db->fetchArray(MYSQL_ASSOC);//商品表读取
		//$db->select("shop", "*", "del and company=".$cp." and sname like '%$val%' ");$shop2 = $db->fetchArray(MYSQL_ASSOC);//商品表读取
			$i=0;
			echo"[ashop]";
				//echo "<b class='btn btn-info'>SELECT * FROM shop WHERE del AND company=".$cp." AND $condition ORDER BY spp DESC ".$page->limit1()." </b>";
				//echo "LIMIT".$page->limit1();
				//echo "<br>npage:".$npage;
			echo $db->printMessage();
			foreach($shop as $row){
				$classkc="";
				if($row["skc"]<$row["akc"]){$classkc="btn btn-danger btn-xs";}else{$classkc="btn btn-success btn-xs";}
				echo "<tr id='sid".$i."' class='".$row["sid"]."'>";
				echo"<td>".($i+1)."</td>";
				echo"<td>SP00".$row["sid"]."</td>";
				echo"<td>".$row["sname"]."</td>";
				echo"<td>".$row["spp"]."</td>";
				echo"<td>".$row["sgg"]."</td>";
				echo"<td>".$row["xinghao"]."</td>";
				echo"<td><b class='$classkc' title='安全库存:".($row["akc"]*1)."'>".$row["skc"]."</b></td>";
				echo"<td>".$row["scar"]."</td>";
				echo"<td>".$row["sdj"]."元</td>";
				$eshourl="eshop.php?sid=".$row["sid"];
				$ChoseShop="ChoseShop(".$row["sid"].",".$row["sdj"].",".$row["skc"].",'".$row["sname"]."')";
				echo"<td>
						<button class='btn btn-warning btn-xs' data-dismiss='modal' onclick=$ChoseShop >选择</button>
					</td>";;
				echo"</tr>";
				$i++;
			}
			echo "<tr><td colspan=11><a class='btn btn-success btn-sm' data-toggle='modal' href='#addsp'>新建商品</a></td></tr>";
			if(empty($shop)){
				echo "<tr><td colspan='11'>您的仓库尚未添加商品信息</td></tr>";
			}
			echo "<tr><td colspan='11'>".$page->showpage()."</td></tr>";  
			echo"[/ashop]";
	break;
case "SearchCar":    //搜索车辆
		$cp=$_POST["cp"];
		$val=$_POST["val"];
		$npage=$_POST["page"];
		$condition=" (carid like '%$val%' or carid like '%$val%' or carid like '%$val%' ) ";
		$db->select("car2", "count(*) as ct", "del AND $condition ");$item = $db->fetchArray(MYSQL_ASSOC);
		$page = new Page2($item[0]["ct"],PageSize,$npage,$val);
		$db->select("car", "*", "del AND $condition order by kh desc ".$page->limit1()."");$item = $db->fetchArray(MYSQL_ASSOC);//商品表读取
			$i=0;
			echo"[acar]";
			echo $db->printMessage();
			echo "<table class='table table-bordered table-hover table-striped'>";
			echo "
				<thead>
					<th>序号</th>
					<th>车牌号码</th>
					<th>车辆品牌</th>
					<th>购买日期</th>
					<th>所属客户</th>
					<th>备注</th>
					<th>操作</th>
				</thead>
			";
			foreach($item as $row){
				echo "<tr id='cid".$i."' class='".$row["itemid"]."'>";
				echo"<td>".($i+1)."</td>";
				echo"<td>".$row["carid"]."</td>";
				echo"<td>".$row["cpp"]."</td>";
				echo"<td>".$row["buydate"]."</td>";
				echo"<td>".$row["kh"]."</td>";
				echo"<td>".$row["tips"]."</td>";
				$eshourl="ecar.php?cid=".$row["id"];
				echo"<td>
						<a class='btn btn-danger btn-xs'  href='$eshourl'>详细</a>
					</td>";
				echo"</tr>";
				$i++;
			}
			echo "</table>";
			if(empty($shop)){
				echo "<tr><td colspan=9>您的还没有车辆记录</td>";
			}
			echo $page->showpage();
			echo"[/acar]";
		
	break;
	case "eshop":    //编辑商品信息
		$sid=$_POST["sid"];
		$sname=$_POST["vsname"];
		$spp=$_POST["vspp"];
		$scar=$_POST["vscar"];
		$xinghao=$_POST["vxinghao"];
		$sdw=$_POST["vsdw"];
		$sgg=$_POST["vsgg"];
		$gys=$_POST["vgys"];
		$gysphone=$_POST["vgysphone"];
		$etime=$_POST["vetime"];
		$akc=$_POST["vakc"];
		$tips=$_POST["vtips"];		
		$shopinfo=array('sname'=>$sname,'spp'=>$spp,'scar'=>$scar,'xinghao'=>$xinghao,'sdw'=>$sdw,'sgg'=>$sgg,'gys'=>$gys,'gysphone'=>$gysphone,'etime'=>$etime,'akc'=>$akc,'tips'=>$tips);
		$db->update("shop",$shopinfo,"sid=".$sid);
		echo $db->printMessage();
	break;
	case "ecar":  //编辑车辆信息
		$carid=$_POST["carid"];
		$carid2=$_POST["carid2"];
		$car=$_POST["car"];
		$pp=$_POST["pp"];
		$buydate=$_POST["buydate"];
		$vin=$_POST["vin"];
		$tips=$_POST["tips"];
		$km=$_POST["km"];
		$Carinfo=array('carid'=>$carid2,'car'=>$car,'pp'=>$pp,'buydate'=>$buydate,'vin'=>$vin,'tips'=>$tips,'km'=>$km);
		$db->update("car2",$Carinfo,"carid='".$carid."'");
		
		echo "/nUPDATE set 'carid'=$carid,'car'=$car,'pp'=$pp,'buydate'=$buydate,'vin'=$vin,'tips'=$tips,'km'=$km) WHERE carid=$carid /n";
		echo $db->printMessage();
	break;

	case "car":
		$kh=$_POST["kh"];
		$cp=$_POST["cp"];
		$db->select("car2","*","kh=".$kh); $car = $db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		if(!empty($car)){
			$c=0;
			foreach($car as $row){
				echo "<tr>
						<td>".$c++."</td>
						<td><input type='text' onChange='upcar(".$row["id"].")' class='input_td' id='pp' value='".$row["pp"]."'/></td>
						<td><input type='text' onChange='upcar(".$row["id"].")' class='input_td' id='car' value='".$row["car"]."'/></td>	
						<td><input type='text' onChange='upcar(".$row["id"].")' class='input_td' id='carid' value='".$row["carid"]."'/></td>	
						<td><input type='date' onChange='upcar(".$row["id"].")' class='input_td' id='bdate' value='".$row["buydate"]."'/></td>	
						<td><input type='text'onChange='upcar(".$row["id"].")'  class='input_td' id='vin' value='".$row["vin"]."'/></td>		
					 </tr>";	
			}	
		}else{
			echo"<tr><td colspan='6' >暂无记录</td></tr>";	
		}
	    echo"<tr><td colspan='6' ><input type='button' value='添加' class='botton' onClick=\"$('#addcar').toggle(200)\"/></td></tr>";
		echo "<input type='hidden' value='".$kh."' id='khid'>";
	break;
	/*默认车辆设置*/
	case "SetDefaultCar":  
		$kh=$_POST["kh"];
		$carid=$_POST["carid"];
		$kehuinfo=array("carid"=>$carid);
		$db->update("kehu",$kehuinfo,"id=$kh");
		echo $db->printMessage();
	break;
	case "car2":
		$kh=$_POST["kh"];
		$db->select("car2","*","kh=".$kh); $car = $db->fetchArray(MYSQL_ASSOC);echo $db->printMessage();
		$db->select("kehu","*","id=".$kh); $kehu = $db->fetchArray(MYSQL_ASSOC);
		echo "[$atype]";
		if(!empty($car)){
			$c=0;
			/*默认车辆设置*/
			//echo "用户默认车辆（".$kehu[0]["carid"].")";
			if($kehu[0]["carid"]==""){
				$kehuinfo=array("carid"=>$car[0]["carid"]);
				$db->update("kehu",$kehuinfo,"id=$kh");
				//echo $db->printMessage();
				$db->select("kehu","*","id=".$kh); $kehu = $db->fetchArray(MYSQL_ASSOC);
			}else{
				//echo "已设置默认车辆".$kehu[0]["carid"];
			}

			/*-------*/
			
			//print_r($car);
			foreach($car as $row){
				if($row["carid"]==$kehu[0]["carid"]){
					$DefaultCar="<b class='btn btn-info btn-xs'>默认车辆</b>";
				}else{
					$Carid=$row["carid"];
					$DefaultCar="<b class='btn btn-warning btn-xs' onclick='SetDefaultCar($kh,\"$Carid\")'>设为默认</b>";
				}
				$del="DelCar('".$row["carid"]."',".$kh.")";
				
				echo "<tr>
						<td>".++$c."</td>
						<td>".$row["carid"]."</td>
						<td>".$row["vin"]."</td>	
						<td>".$row["km"]."</td>	
						<td>".$row["date_bx"]."</td>	
						<td>".$row["date_nj"]."</td>
						<td>".$row["tips"]."</td>
						<td>
								$DefaultCar
								<a class='btn btn-success btn-xs' href='ecar.php?cid=".$row["carid"]."'>编辑</a>
								<button class='btn btn-danger btn-xs' onclick=".$del.">删除</button>
						</td>
					 </tr>";	
			}	
		}else{
			echo"<tr><td colspan='8' >暂无记录</td></tr>";	
		}
		echo "<input type='hidden' value='".$kh."' id='khid'>";
		echo "[/$atype]";
	break;
	
	
	case "delcar":   //删除车辆
		$carid=$_POST["carid"];
		$db->delete("car2", "carid='".$carid."'");
		echo $db->printMessage();
		
	break;
	//添加充值

	case "hycz":
		$kh=$_POST["kh"];
		$je=$_POST["je"];
		$zf=$_POST["zf"];
		$USERID=$_POST["USERID"];
		$tips=$_POST["tips"];
		$cp=$COMPANY=$_POST["COMPANY"];
		echo "【".$COMPANY."】";
		if($je>=0){
			$date=date('YmdHis');
			$db->select("czjl","count(*) as ct","kh=".$kh);$czjl = $db->fetchArray(MYSQL_ASSOC);
			$ct=$czjl[0]["ct"]+1;
			
			$bm="CZ".$cp.$date.fz($ct);
			echo $bm;
					
			$czjl=array('kh'=>$kh,'company'=>$cp,'je'=>$je,'U'=>$USERID,'zf'=>$zf,'date'=>$date,'bm'=>$bm,'tips'=>$tips);
			$db->insert("czjl",$czjl);
			echo $db->printMessage();
			
			$db->select("czjl", "id", "company=".$cp." order by id desc limit 1");
			$cid = $db->fetchArray(MYSQL_ASSOC);
			$cid=$cid[0]["id"];
			
			
			$db->select("kehu","money","id=".$kh);$kehu = $db->fetchArray(MYSQL_ASSOC);
			$money=$kehu[0]["money"];
			$money+=$je;
			echo "[Money]".$money."[/Money]";
			$kehuinfo=array("money"=>$money);
			$db->update("kehu",$kehuinfo,"id=".$kh);
			echo $db->printMessage();
		    $db->select("kehu","*","id=".$kh);$KHINFO=$db->fetchArray(MYSQL_ASSOC);
			
			echo LOGS($USERID,"充值",$kh,$je,$zf,$COMPANY);
			
			$url='http://'.HOST.'/weixin/czmsg.php?amount='.$je.'&type='.$zf.'&user='.$KHINFO[0]["name"].'&balance='.$money.'&openid='.$KHINFO[0]["wx_openid"].'&SendMode=CZ&url=www.zduber.com/weixin/payinfo/czinfo.php?cid='.$cid;
			echo "[url]".$url."[/url]";
			ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;)'); 
			echo file_get_contents($url);  
			//echo "充值后余额为:[$money]\n";
		}else{
			echo "[emsg]充值金额错误[/emsg]";
		}
	break;
	case "AddKehuCar":
		$CarId=$_POST["Carid"];
		$KehuCarvin=$_POST["KehuCarvin"];
		$KehuCarkm=$_POST["KehuCarkm"];
		$KehuID=$_POST["KehuID"];
		
		echo "[carid]".$KehuID."[carid]";
		$db->select("car2","*","carid='".$CarId."'");$car=$db->fetchArray(MYSQL_ASSOC);
		print_r($car);
		if($car){
			echo "[acarerror]添加失败，车辆[".$car[0]["carid"]."]已存在 车主为[".selecta("kehu","id",$car[0]["kh"],"name")."][/acarerror]"; 
		}else{
			$carinfo=array("kh"=>$KehuID,"km"=>$km,"carid"=>$CarId,"vin"=>$KehuCarvin,'date'=>$date=date('Y-m-d H:i:s'));
			$db->insert("car2",$carinfo);
			echo "\nSQLMSG:[".$db->printMessage()."]\n";
			
		}
	break;
	case "addcar":  //添加车辆
		$pp=$_POST["pp"];
		$kh=$_POST["kh"];
		isset($_POST["km"])?$km=$_POST["km"]:$km=0;
		$car=$_POST["car"];
		$carid=$_POST["carid"];
		isset($_POST["vin"])?$vin=$_POST["vin"]:$vin="";
		isset($_POST["tips"])?$tips=$_POST["tips"]:$tips="";
		echo "[carid]".$carid."[/carid]";
		$db->select("car2","*","carid='".$carid."'");
		$c=$db->fetchArray(MYSQL_ASSOC);
		if(!empty($c)){
			echo "[acarerror]添加失败，车辆[".$c[0]["carid"]."]已存在 车主为[".selecta("kehu","id",$c[0]["kh"],"name")."][/acarerror]"; 
		}else{
			echo "\n 备注".$tips."\n";
			//$bdate=$_POST["bdate"];
			$carinfo=array("pp"=>$pp,"kh"=>$kh,"car"=>$car,"km"=>$km,"tips"=>$tips,"carid"=>$carid,"vin"=>$vin,'buydate'=>$bdate,'date'=>$date=date('Y-m-d H:i:s'));
			$db->insert("car2",$carinfo);
			echo "\nSQLMSG:[".$db->printMessage()."]\n";
			//print_r($carinfo);
			/*
			$kehuinfo=array("carid"=>$carid);		
			$db->update("kehu",$kehuinfo,"id=".$kh);
			echo $db->printMessage();
			$db->select("car2", "carid", "kh=".$kh." order by carid desc limit 1");$reid = $db->fetchArray(MYSQL_ASSOC);
			echo "[newid]".$reid[0]["id"]."[/newid]";*/
		}
		
	break;
	case "upcar":
		$pp=$_POST["pp"];
		$kh=$_POST["kh"];
		$car=$_POST["car"];
		$carid=$_POST["carid"];
		$vin=$_POST["vin"];
		$bdate=$_POST["bdate"];
		$cid=$_POST["cid"];
		$carinfo=array("pp"=>$pp,"kh"=>$kh,"car"=>$car,"carid"=>$carid,"vin"=>$vin,'buydate'=>$bdate);
		$db->update("car",$carinfo,"id=".$cid);
		echo $db->printMessage();
	break;
	/*获取车辆列表*/
	case "GetCarList":
		$kh=$_POST["kh"];
		$db->select("car2","*","kh=".$kh." order by date desc");$cars=$db->fetchArray(MYSQL_ASSOC);
		echo $db->printMessage();
		$Dcar=selecta("kehu","id",$kh,"carid");
		//echo "|".$Dcar."|";
		echo"<option value=0>请选择车辆</option>";
		if(!empty($cars)){
			foreach($cars as $row){
				//echo "\n|".$row["carid"]."|=|".$Dcar."|\n";
				if($row["carid"]==$Dcar){
					echo "<option selected='selected' value='".$row["carid"]."'>".$row["carid"]."  [默认]</option>";
				}else{
					echo "<option value='".$row["carid"]."'>".$row["carid"]."</option>";
				}
			}
		}
			
				echo "<option value=-1>添加车辆</option>";
	break;
	
	/*shouyin.php 消费记录 Ajax消费记录*/
	case "xfjl":
		$kh=$_POST["kh"];
		$npage=$_POST["page"];
		$db->select("bill", "count(1) as ct", "del and kehu=".$kh);$bill = $db->fetchArray(MYSQL_ASSOC);
		//echo $bill[0]["ct"];
		$page = new Page3($bill[0]["ct"],PageSize,$npage,$kh,"xfjl");
		//echo $page->limit1();
		$db->select("bill","*","kehu=".$kh." and del order by date desc ".$page->limit1());$xfjl = $db->fetchArray(MYSQL_ASSOC);
		//print_r($xfjl);
		$AllBill=$JsedBill=$AllMoney=$YJS=$WJS=0;
		echo "[xfjl]";
		if(!empty($xfjl)){ 
			foreach($xfjl as $row){
				$AllBill++; 
				$JiesuanButton="";
				if($row["zt"]){
					$JiesuanButton="<input type='button' class='btn btn-success btn-xs' value='已结算'/>";
					$JsedBill++;
					$YJS+=$row["money"];
				}else{
					$JiesuanButton="<input type='button' class='btn btn-danger btn-xs' onClick='KJJieSuan(".$row["id"].",".$row["kehu"].",0	,this)' value='结算'/>";
					$WJS+=$row["money"];
				}
				$AllMoney+=$row["money"]; 
				echo "<tr>
						<td>".$row["date"]."</td>
						<td><b style='cursor:pointer'>".($row["money"]*1)."</b>元</td>
						<td>".($row["zje"]*1)."元</td>
						<td>".SELECTA("bill_type","id",$row["btype"],"NAME")."</td>           
						<td><a  target='_blank'  class='btn-info btn-xs' href='../zdcar2/ebill.php?bid=".$row["id"]."'>".$row["bid"]."</a></td>             
						<td>$JiesuanButton</td>
				</tr>";
			}
		}else{
			echo "<tr><td colspan=6>暂无记录</td></tr>"; 
		}
		echo "<tr><td colspan=6>".$page->showpage()."</td></tr>"; 
		echo"<tr>
				<td colspan=6>
						总订单数:<b class='btn-warning btn-xs'>$AllBill</b>,
						总金额：<b class='btn-warning btn-xs'>$AllMoney ￥</b>,
						其中已结算订单:<b class='btn-success btn-xs'>$JsedBill</b>,金额为：<b class='btn-success btn-xs'>$YJS ￥</b>,
						未结算订单:<b class='btn-danger btn-xs'>".($AllBill-$JsedBill)."</b>,金额为:<b class='btn-danger btn-xs'>$WJS ￥</b>
				</td>
			</tr>
			<input type='hidden' value='".$kh."' id='khid'> 
			<input type='hidden' value='".selecta("kehu","id",$kh,"name")."' id='khname'>";
		echo "[/xfjl]";
	break;
	case "bding":
		$openid=$_POST["openid"];
		$phone=$_POST["tel"];
		$head=$_POST["head"];
		$name=$_POST["name"];
		$kh=array('wx_openid'=>$openid,'head'=>$head);
		$db->update("kehu",$kh,"phone='$phone' and name='$name' ");
		echo $db->printMessage();
	break;
	/*商品数量减*/
	case "downsl":
		$ashopid=$_POST["ashopid"];
		$db->select("ashop","*","id=".$ashopid);$ashop = $db->fetchArray(MYSQL_ASSOC);
		$sl=$ashop[0]["sl"];
		$sid=$ashop[0]["sid"];
		$money=$ashop[0]["money"];
		$max=selecta("shop","sid",$sid,"skc");
		if($sl>0){
			$ashop=array("sl"=>($sl-1));
			echo "[sl]".($sl-1)."[/sl]";
			echo "[money1]".(($sl-1)*$money)."[/money1]";
			$shop=array("skc"=>($max+1));
			$db->update("ashop",$ashop,"id=".$ashopid);
			echo $db->printMessage();
			$db->update("shop",$shop,"sid=".$sid);
			echo $db->printMessage();
		}else{
			echo"[sl]0[/sl]";
			echo "[money1]0[/money1]";
		}
		
	break;
	case "upsl":
		$ashopid=$_POST["ashopid"];
		$db->select("ashop","*","id=".$ashopid);$ashop = $db->fetchArray(MYSQL_ASSOC);
		$sl=$ashop[0]["sl"];
		$money=$ashop[0]["money"];
		echo "库存:".$max=selecta("shop","sid",$ashop[0]["sid"],"skc");
		echo"|数量:$sl|ASID:$ashopid|商品ID:";
		echo $sid=$ashop[0]["sid"];
		echo "|\n";
		if($max>0){
			/*ASHOP表更新数量+1*/
			$ashop=array("sl"=>($sl+1));
			echo "[sl]".($sl+1)."[/sl]";
			echo "[money1]".(($sl+1)*$money)."[/money1]";
			$db->update("ashop",$ashop,"id=".$ashopid);
			echo $db->printMessage();
			/*SHOP表更新库存*-1*/
			$shop=array("skc"=>($max-1));
			$db->update("shop",$shop,"sid=".$sid);
			echo $db->printMessage();
		}else{
			echo "库存不足";
		}
	break;
	case "reloadsl":
		$bid=$_POST["bid"];
		$db->select("ashop","*","bid=".$bid);$ashop = $db->fetchArray(MYSQL_ASSOC);
		$sl=$ashop[0]["sl"];
		$money=$ashop[0]["money"];
		echo "库存:".$max=selecta("shop","sid",$ashop[0]["sid"],"skc");
		echo"|数量:$sl|ASID:$ashopid|商品ID:";
		echo $sid=$ashop[0]["sid"];
		echo "|\n";
		if($max>0){
			/*ASHOP表更新数量+1*/
			$ashop=array("sl"=>($sl+1));
			echo "[sl]".($sl+1)."[/sl]";
			echo "[money1]".(($sl+1)*$money)."[/money1]";
			$db->update("ashop",$ashop,"id=".$ashopid);
			echo $db->printMessage();
			/*SHOP表更新库存*-1*/
			$shop=array("skc"=>($max-1));
			$db->update("shop",$shop,"sid=".$sid);
			echo $db->printMessage();
		}else{
			echo "库存不足";
		}
	break;
	case "ChangeShopMoney":
		$ASPID=$_POST["ASPID"];
		$NewMoney=$_POST["NewMoney"];
		echo "|".$NewMoney."|";
		$ashop=array("money"=>$NewMoney);
		$db->update("ashop",$ashop,"id=".$ASPID);
		echo $db->printMessage();
	break;
	
	case "CHART":
		$company=$_POST["cp"]; 
		echo "[CompanyName]".selecta("company","id",$company,"name")."[/CompanyName]";
		if($_POST["Sdate"]==""){$Sdate="1997-01-01";}else{$Sdate=$_POST["Sdate"];};
		if($_POST["Edate"]==""){$Edate=date("Y-m-d");}else{$Edate=$_POST["Edate"];};
		if($_POST["Sdate"]==""&&$_POST["Edate"]==""){$DateQujian="总";}else{$DateQujian=$Sdate."到".$Edate;}
		echo "日期区间[date]".$DateQujian."[/date]";
		//$col="DATE_FORMAT(date,'%Y年%c月%e日') date1 ,sum(money) as yye,count(1) ct ";
		//$TiaoJian="company=".$company." and date between '".$Sdate."' AND '".$Edate."'   group by date1 order by date";
		switch($_POST["TYPE"]){
			case "pie":
				$table="bill";
				$col="jsfs PAYMODE,COUNT(1) NUM,SUM(Money) M";
				$TiaoJian=" company=1 and date between '".$Sdate."' AND '".$Edate."'  GROUP BY jsfs ";
			break;
			case "line":
				$table="czjl";
				$col="date_format(date,'%Y-%m-%d') dated,zf,sum(je) zje";
				$TiaoJian="company=".$company." and date between '".$Sdate."' AND '".$Edate."'  and not(tips='余额导出') group by zf,dated ORDER BY date";
			break;
		}	
		$db->select($table,$col,$TiaoJian);
		echo "\n[sql]SELECT  $col FROM bill WHERE $TiaoJian [/sql]\n";
		$ChartDate = $db->fetchArray(MYSQL_ASSOC);
		if(empty($ChartDate)){
			echo "[json][{'PAYMODE':0,'NUM':0,'M':0}][/json]查询结果为空 原因".$db->printMessage();
		}else{
			echo $db->printMessage();
			//print_r($ChartDate);
			echo "\n\n[JSON]";
			  print_r(json_encode($ChartDate));
			echo "[/JSON]\n\n";
		}
	break;
	case "PageData":
		if(!isset($_POST["cp"])){
			die("\nERROR:参数错误");
		}
		if($_POST["Sdate"]==""){$Sdate="1997-01-01";}else{$Sdate=$_POST["Sdate"];};
		if($_POST["Edate"]==""){$Edate=date("Y-m-d");}else{$Edate=$_POST["Edate"];};
		if($_POST["Sdate"]==""&&$_POST["Edate"]==""){$DateQujian="总";}else{$DateQujian=$Sdate."到".$Edate;}
		$company=$_POST["cp"];
		$dateCDT=" AND date between '".$Sdate."' AND '".$Edate."'";
		$ZJE=select("bill","SUM(money) s","company=".$company.$dateCDT);
		echo "\n[ZJE]".$ZJE[0]["s"]."[/ZJE]";
		$ZSP=select("ashop","SUM(money) s","bid in (SELECT id FROM bill WHERE company=".$company.$dateCDT.")");
		echo "\n[ZSP]".$ZSP[0]["s"]."[/ZSP]";
		$ZXM=select("aitem","SUM(gs) s","bid in (SELECT id FROM bill WHERE company=".$company.$dateCDT.")"); 
		echo "\n[ZXM]".$ZXM[0]["s"]."[/ZXM]";
		$ZCZ=select("czjl","SUM(je) s","company=".$company.$dateCDT); 
		echo "\n[ZCZ]".$ZCZ[0]["s"]."[/ZCZ]";
		
	break;
	case "AddShopNumber":
		$sid=$_POST["sid"];
		$Num=$_POST["Num"];
		$USERID=$_POST["USERID"];
		$COMPANY=$_POST["COMPANY"];
		LOGS($USERID,"添加","商品",$sid,$Num,$COMPANY);
		$shopInfo=array("skc"=>(selecta("shop","sid",$sid,"skc")+$Num));
		$db->update("shop",$shopInfo,"sid=".$sid);
		echo $db->printMessage();
	break;
	case "UploadShop":
		$sid=$_POST["sid"];
		$Num=$_POST["Num"];
		$USERID=$_POST["USERID"];
		$COMPANY=$_POST["COMPANY"];
	
		$db->select("shop_u","*","sid=".$sid);$shopU = $db->fetchArray(MYSQL_ASSOC);
		
		print_r($shopU);
		LOGS($USERID,"上传","商品",$sid,$Num,$COMPANY);
		if(empty($shopU)){
			$shopUinfo=array("sid"=>$sid,"num"=>$Num);
			$db->insert("shop_u",$shopUinfo);
			echo $db->printMessage(); 
			$shopinfo=array("skc"=>(selecta("shop","sid",$sid,"skc")-$Num));
			$db->update("shop",$shopinfo,"sid=".$sid);
			echo $db->printMessage();
		}else{
			$shopUinfo=array("num"=>($shopU[0]["num"]+$Num));
			$db->update("shop_u",$shopUinfo,"sid=".$sid);
			echo $db->printMessage();
			$shopinfo=array("skc"=>(selecta("shop","sid",$sid,"skc")-$Num));
			$db->update("shop",$shopinfo,"sid=".$sid);
			echo $db->printMessage();
		}
	break;
	case "buglist":
		$Word=$_POST["word"];
		
		$bugList=SELECT("bug","*","(info LIKE '%$Word%' OR tips LIKE '%$Word%' ) ORDER BY state,date desc");
	  
		$i=0;
		echo "[buglist]";
		$COUNT=$FCOUNT=0;
		foreach($bugList as $row){
			$COUNT++;
			$STIME=strtotime($row["date"]);
			$ETIME=strtotime($row["edate"]);
			if($row["state"]){
				$STATE="<b class='btn btn-xs btn-success'>已修复</b>";
				$FCOUNT++;
			}else{
				$STATE="<b class='btn btn-xs btn-danger'>未修复</b>";
				$ETIME=strtotime(GETDATETIME(1));
			}
			
			$CTIME=time2string($ETIME-$STIME);
			$E="";
			if($row["edate"]==""){$E="-";}else{$E=$row["edate"];}
			echo "<tr ondblclick='showBug(".$row["id"].")' style='cursor:pointer;'> 
					<td  style='width:3%;'>".++$i."</td>
					<td style='width:10%;'>".$row["type"]."</td>
					<td colspan=2 style='width:20%;' title='".$row["info"]."'><a href='javascript:showBug(".$row["id"].")'>".mb_substr($row["info"],0,30,'utf-8')."...</a></td>
					<td style='width:5%;'  title='".$row["tips"]."'>".mb_substr($row["tips"],0,5,'utf-8')."...</td>
					<td style='width:10%;'>".$row["date"]."</td>
					<td  style='width:10%;'>".$E."</td>
					<td  style='width:15%;' >".$CTIME."</td>
					<td style='width:4%;'>".$STATE."</td>
					<td  style='width:5%;'>
						<input type='button' class='btn btn-xs btn-danger' value='删除' onclick='DELBUG(".$row["id"].")'/>
					</td>
			     </tr>";
		}
		echo "<tr><td colspan='10'>共有<b style='color:#F00'>".$COUNT."</b>个BUG 已修复<b style='color:#0F0'> $FCOUNT </b> 个,剩余 <b>".($COUNT-$FCOUNT)."</b>个未修复 </td></tr>";
		if(empty($bugList))echo "<tr><td colspan='10'><h4>酷<b>╮(╯▽╰)╭</b> 没有Bug哦</h4></td></tr>";
		echo "[/buglist]";
	break;
	case "UPDATE":  //JS SQL UPDATE
		$TABLE=$_POST["TABLE"];
		$COL=$_POST["COL"];
		$VAL=$_POST["VAL"];
		$CONDITION=$_POST["CONDITION"];
		$CONDITION=CONDITION($CONDITION);
		//print_r($CDT);
		echo "\n".$CONDITION."\n";
		$ARR=array($COL=>"".$VAL."");
		$db->update($TABLE,$ARR," $CONDITION ");
		echo "[info]".$db->printMessage()."[/info]";
		echo "\n[sql]UPDATE $TABLE SET $COL=$VAL WHERE $CONDITION [/sql]\n";
	break;
	case "INSERT":   //JS SQL INSERT
		$TABLE=$_POST["TABLE"];
		$ARR=$_POST["ARR"];
		$db->insert($TABLE,$ARR);
		echo  "[$atype]".$db->printMessage()."[/$atype]";
		$NEWID=SELECT($TABLE,"id","1 order by id desc limit 1");
		print_r($NEWID);
		echo "[NEWID]".$NEWID[0]["id"]."[/NEWID]";
	break;
	case "DELETE":   //JS SQL DELETE
		$TABLE=$_POST["TABLE"];
		$CONDITION=$_POST["CONDITION"];
		$CDT= explode("=",$CONDITION);if(is_numeric($CDT[1])){$CONDITION=$CONDITION;}else{$CONDITION=$CDT[0]."='".$CDT[1]."'";}//判断条件是否为数字
		$db->delete($TABLE,$CONDITION);
		echo  "[MSG]".$db->printMessage()."[/MSG]";
	break;
	case "SELECTA":   //JS SQL SELECTA
		$TABLE=$_POST["TABLE"];
		$COL=$_POST["COL"];
		$VALUE=$_POST["VALUE"];
		$RETURN=$_POST["RETURN"];
		echo "[$RETURN]".selecta($TABLE,$COL,$VALUE,$RETURN)."[/$RETURN]";
	break;
	case "SELECTB":   //JS SQL SELECTB  
		$TABLE=$_POST["TABLE"];
		$COL=$_POST["COL"];
		$CONDITION=$_POST["CONDITION"];
		echo "\n格式化前条件:$CONDITION\n";
		$CONDITION=CONDITION($CONDITION);//格式化条件
		echo "\n格式化后条件:$CONDITION\n";
		$ARR=SELECT($TABLE,$COL,$CONDITION);
		if(!is_array($ARR)){
			echo "[$atype]$ARR [/$atype]";
		}else{
			echo "[$atype]".$ARR[0][$COL]."[/$atype]";
		}
		echo "\n[sql]SELECT $COL FROM $TABLE WHERE $CONDITION [/sql]\n";

	break;
	case"SELECT":
		$SQL=$_POST["SQL"];
		
		print_r($SQL);
		$A=SELECT($SQL["TABLE"],$SQL["COL"],$SQL["CONDITION"]);
		
		echo "[$atype]".json_encode($A)."[/$atype]";
		//echo "成功";
	break;
	
	
	case "GetDATE": //获取时间 
		 $MOD=isset($_POST["MOD"])?$_POST["MOD"]:0;
		echo "\nMOD:$MOD\n[$atype]".GETDATETIME($MOD)."[/$atype]";
	break;
	
	case "admin-user":
	  $USER_A=SELECT("user","*","id in (SELECT admin FROM company)");
	  $COMPANY_S=SELECT("company","*","not admin=''");
	  $A=$_POST["A"];
	  echo "[USERATAB]";
	  $i=0;
	  foreach( $COMPANY_S as $row){
		  if($row["id"]==$A){$DISPLAY="block";}else{$DISPLAY="none";}
		  echo "<div class='panel panel-default' >
					<div class='panel-heading' onClick='$(\"#CP".$row["id"]."\").toggle(250);'>
						<img  src='".$row["logo"]."' width=30 height=30 class='img-circle' onClick='UPDATE_LOGO(".$row["id"].")'>
						<h1 class='panel-title' style='float:right;'><a href='ecompany.php?cid=".$row["id"]."'><b>".$row["name"]."</b></a></h1>
					</div>
					<div class='panel-body' id='CP".$row["id"]."' style='display:$DISPLAY;'>
						<table class='table table-striped table-bordered table-hover text-center'>
							<tr><td>序号</td><td>用户名</td><td>密码</td><td>用户类型</td><td>手机号</td><td>操作</td></tr>
						";
					$USER_S=SELECT("user","*"," del AND company=".$row["id"]);
					$i=0;
					foreach($USER_S as $r){
						if($r["type"]=="管理员"){$BUT="<input type='button' disabled='true'  class='btn btn-danger btn-xs' value='删除'/>";}else{$BUT="<input type='button' class='btn btn-danger btn-xs' value='删除' onClick='USER_DEL(".$r["id"].",".$row["id"].")'/>";}
						echo "<tr>
								<td>".++$i."</td>
								<td>".$r["user"]."</td>
								<td>".$r["password"]."</td>
								<td>".$r["type"]."</td>
								<td>".$r["phone"]."</td>
								<td>$BUT</td>
							</tr>";
							
						
						
						
						
					}
					 
		   echo "
				<tr>
					<td colspan='6'><input type='button' class='btn btn-info btn-xs' value='添加子账号' onclick='ADD_SUB_ACCOUNT(".$row["id"].")' id='AddUserButton'/></td>
				</tr>
		   </table>
		   
     </div></div>";
			
			
		   
		   
		   
	  } 
	  echo "[/USERATAB]"; 
	break; 
	case "EXIST":
		$TABLE=$_POST["TABLE"];$COL=$_POST["COL"];$VALUE=$_POST["VALUE"];
		if(EXISTA($TABLE,$COL,$VALUE)){ 
			echo "表'$TABLE'中存在$COL=$VALUE 	的记录[code]YES[/code]";
		}else{
			echo "表'$TABLE'中不存在$COL=$VALUE 的记录[code]NO[/code]";
		}
	break;
	case "EXISTS":
		$TABLE=$_POST["TABLE"];
		$CONDITION=$_POST["CONDITION"];
		$CONDITION=CONDITION($CONDITION);
		if(EXISTS($TABLE,$CONDITION)){ 
			echo "表'$TABLE'中存在$CONDITION	的记录[code]YES[/code]";
		}else{
			echo "表'$TABLE'中不存在$CONDITION	的记录[code]NO[/code]";
		}
	break;
	case "URL":
	   $URL=$_POST["URL"];
	    $URL="".str_replace("\'","",$URL)."";
	    echo $URL;
	   echo"[URL]".toShortUrl($URL)."[/URL]";
	break;
	case "Robot":
		$Question=$_POST["Question"];
		$MOD=$_POST["mod"];
		$MOD=$MOD==""?"未指定":$MOD;
		switch($MOD){
			case "图灵":
				echo "[$atype]".json_decode(Robot($Question))->text."[/$atype]";
			break;
			case "阿里":
			print_r(aliRobot("你好啊")->result->content);
				echo "[$atype]".aliRobot($Question)->result->content."[/$atype]";
			break;
			default:
				echo "[$atype]没有名字为$MOD 的机器人哦[/$atype]";
			break;
			
		}
		
	break;
	case "LOG":
		echo "[$atype]".LOGS($_POST["U"],$_POST["TYPE"],$_POST["OBJ"],$_POST["V1"],$_POST["V2"],$_POST["C"])."[/$atype]";
	break;
	case "UPLOADFILE":
			$up = new fileupload;
			//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
			$up -> set("path", "./images/");
			$up -> set("maxsize", 2000000);
			$up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
			$up -> set("israndname", false);
			//使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名字 pic, 如果成功返回true, 失败返回false
			if($up -> upload("testFile")) {
				echo '<pre>';
				//获取上传后文件名字
				var_dump($up->getFileName());
				echo '</pre>';
		  
			} else {
				echo '<pre>';
				//获取上传失败以后的错误提示
				
				var_dump($up->getErrorMsg());
				echo '</pre>';
			}
	break;
	
	

	
	
	}
	
	
	
	
	
	
	
	
	
	
	/*以下为公用函数库*/
	
	
	
	function time2string($second){
		$day = floor($second/(3600*24));
		$second = $second%(3600*24);//除去整天之后剩余的时间
		$hour = floor($second/3600);
		$second = $second%3600;//除去整小时之后剩余的时间 
		$minute = floor($second/60);
		$second = $second%60;//除去整分钟之后剩余的时间 
		//返回字符串
		return $day.'天'.$hour.'小时'.$minute.'分'.$second.'秒';
	}
	
	
	function GETDATETIME($MOD=0){
		//echo "\n函数里的传参:".$MOD."\n";
		switch($MOD){
			case 0:
				return date('Y-m-d H:i:s',time());
			break;
			case 1:
				return date('YmdHis',time());
			break;
			case 2:
				return date('YmdHi',time());
			break;
			case "T":
				return date('Y-m-d/TH:i:s',time());
			break;
			default:
				return date($MOD,time());
			break;
			
		}
		
	}
	

	
	
	function fz($a){$re=0;if($a<1000) $re="0".$a;if($a<100) $re="00".$a;if($a<10) $re="000".$a;return $re;}
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
		case "4":$b="合作商付款";break;
	}	
	return $b;
}

function dbinfo($tab,$id,$col){
		global $db;
		$db->select($tab,$col,"id=".$id);$dbinfo=$db->fetchArray(MYSQL_ASSOC);
		return	$dbinfo[0][$col];
}
 
function sdbinfo($tab,$id,$col){
		global $db;
		$db->select($tab,$col,"sid=".$id);$dbinfo=$db->fetchArray(MYSQL_ASSOC);
		return	$dbinfo[0][$col];
}
//function selecta($tab,$col,$val,$bal){global $db;$db->select($tab, "*", $col."=".$val);$array = $db->fetchArray(MYSQL_ASSOC);return $array[0][$bal];}

/*检测数是否存在 exist(数据表，列名，值)*/
function exist($tab,$col,$val){
	global $db;
	$db->select($tab,"*",$col."=".$val);$array = $db->fetchArray(MYSQL_ASSOC);
	if(!empty($array)){return 1;}else{return 0;}
	
}
/*function  SELECT($TAB,$COL,$CONDITION){
	global $db;
	$db->select($TAB," ".$COL."",$CONDITION);
	return $db->fetchArray(MYSQL_ASSOC);
}*/
/*
function  INSERT($TABLE,$ARR){
	global $db;
	$db->insert($TABLE,$ARR);
	echo  $db->printMessage();
}*/
/*function  EXISTA($TABLE,$COL,$VALUE){
	global $db;
	$A=SELECT($TABLE,"*",$COL."='".$VALUE."'");
	if(empty($A)){
		return false;
	}else{
		return true;
	}
} */

/*
function  EXISTS($TABLE,$CONDITION){
	global $db;
	$A=SELECT($TABLE,"*"," $CONDITION ");
	if(empty($A)){
		return false;
	}else{
		return true;
	}
} */

/*
function toShortUrl($URL){
	 $SHORT_URL="www.zduber.com/url/u.php?p=".dechex(time());
	 if(EXISTA("shorturl","url",$URL)){
		return  SELECTA("shorturl","url","'".$URL."'","surl");
	 }else{
		INSERT("shorturl",array("url"=>$URL,"surl"=>$SHORT_URL));
		return $SHORT_URL;
	 }
	 
}*/



	
?>