
<?php
require_once '../lib/mysql.class.php';
require_once '../lib/fun.php';
require_once 'lib/config.php';
$db = new mysql($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_DATABASE,"utf8",true);
$appid=$WX_APPID;
$secret=$WX_SECERT;

//获取ACCESS_TOKEN
$GetAccessTokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
$bcode=curl($GetAccessTokenUrl);$ACCESS_TOKEN=$bcode["access_token"]; 

$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";


$SendMode=$_GET["SendMode"];
$openid=$_GET["openid"];
echo "发送模式:".$SendMode.";<br>";
if(isset($_GET["SendMode"])){
	switch($SendMode){
		case "XiaoFei":
		echo"<title>消费推送</title>";
			$bid=$_GET["bid"];
			$UserName=$_GET["name"];
			$Time=date("Y年m月d日 G时i分");
			$Money=$_GET["money"];
			$Money2=$_GET["money2"];
			$JiFen=($Money*0.66);
			$data='{
					"touser":"'.$openid.'",
					"template_id":"_DOqYfEO7Do8qOWWOnbTTCg0B4OBx-HiSYsiNS5h6oo",
					"url":"http://www.zduber.com/weixin/payinfo/index.php?bid='.$bid.'",
					"topcolor":"#FF0000",
					"data":{
							"account": {"value":"'.$UserName.'","color":"#173177"},
							"time":{"value":"'.$Time.'","color":"#173177"},
							"CardNumber":{"value":"0426","color":"#173177"},
							"Type":{"value":"消费","color":"#173177"},
							"amount":{"value":"'.$Money.'元","color":"#f67a00"},
							"remark":{"value":"\n\n亲爱的'.$UserName.'：\n您于'.$Time.'在自点车坊成功消费了'.$Money.'元,获得了'.$JiFen.'积分。","color":"#a64d4d"},
							"accountbalance":{"value":"'.$Money2.'元","color":"#1c603c"}
						   }
					}';
			print_r($data);
		break;
		case "CZ":
			echo"<title>充值推送</title>";
			echo "<br>".$openid;
			$AMOUNT=$_GET["amount"];
			$TYPE=$_GET["type"];
			isset($_GET["url"])?$U=$_GET["url"]:$U="#";
			echo "$U";
			switch($TYPE){
				case 1:$WAY="支付宝";break;
				case 2:$WAY="微信";break;
				case 3:$WAY="现金";break;
				case 4:$WAY="银联卡";break;
			}
			$USER=$_GET["user"];
			$BALANCE=$_GET["balance"];
			$TIME=date("Y年m月d日 H:i:s ");
			$data='{
					"touser":"'.$openid.'",
					"template_id":"-e_4MA6pQBIRpNED0kis7yLnaTei8nTH5kWxlVvFZo8",
					"url":"'.$U.'",
					"topcolor":"#FF0000",
					"data":{
							"keyword1":{"value":"'.$AMOUNT.'元","color":"#173177"},
						    "keyword2": {"value":"'.$TIME.'","color":"#459ae9"},
					        "keyword3":{"value":"'.$WAY.'","color":"#44b549"},
							"remark":{"value":"亲爱的'.$USER.'\n您于'.$TIME.'在自点车坊成功充值了'.$AMOUNT.'元\n当前账户余额：'.$BALANCE.'元。","color":"#a64d4d"}
						  } 
				     }';

		break;
	}
	echo getshort($data,$url);
}else{
	echo "参数错误";
}


//print_r($data);
	function getshort($data,$url){
		$json =curl_init();
		curl_setopt($json, CURLOPT_URL, $url);
		curl_setopt($json,CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($json, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($json, CURLOPT_USERAGENT, 'Mozilla/5.0(compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($json,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($json,CURLOPT_AUTOREFERER, 1);
		curl_setopt($json,CURLOPT_POSTFIELDS, $data);
		curl_setopt($json,CURLOPT_RETURNTRANSFER,true);
		$tmpinfo = curl_exec($json);
		if(curl_error($json)){
			return curl_error($json);
		}
		curl_close($json);
		return $tmpinfo;
	}
?>
