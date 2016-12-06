<title>消息发送</title>
<?php
require_once '../lib/mysql.class.php';
require_once '../lib/fun.php';
$db = new mysql('121.196.226.94','admin','xwq198291',"zckj_db","utf8",true);
$appid="wx9c3164046547198a";
$secret="0ea115a00b20fb338aa0bce190e61c24";
$GetAccessTokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
$bcode=curl($GetAccessTokenUrl);
//print_r($bcode);
 $ACCESS_TOKEN=$bcode["access_token"];
$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
$openid=$_GET["openid"];
$SendMode=$_GET["SendMode"];
$UserName=$_GET["name"];
$Time=date("Y年m月d日 G时i分");
$Money=$_GET["money"];
$Money2=$_GET["money2"];
$JiFen=($Money*0.66);
echo "发送模式:".$SendMode.";<br>";
if(isset($_GET["SendMode"])){
	switch($SendMode){
		case "XiaoFei":
			$data='{
					"touser":"'.$openid.'",
					"template_id":"_DOqYfEO7Do8qOWWOnbTTCg0B4OBx-HiSYsiNS5h6oo",
					"url":"http://www.zduber.com/weixin/sendmsg.php",
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
			break;
			case"VipCard":
			
				$url="https://api.weixin.qq.com/card/create?access_token=$ACCESS_TOKEN";
				$data='{
					   "card": {
						   "card_type": "MEMBER_CARD",
						   "member_card": {
						   "background_pic_url":"https://mmbiz.qlogo.cn/mmbiz/",
							   "base_info": {
								   "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0",
								   "brand_name": "海底捞",
								   "code_type": "CODE_TYPE_TEXT",
								   "title": "海底捞会员卡",
								   "color": "Color010",
								   "notice": "使用时向服务员出示此券",
								   "service_phone": "020-88888888",
								   "description": "不可与其他优惠同享",
								   "date_info": {
									   "type": "DATE_TYPE_PERMANENT"
								   },
								   "sku": {
									   "quantity": 50000000
								   },
								   "get_limit": 3,
								   "use_custom_code": false,
								   "can_give_friend": true,
								   "location_id_list": [
									   123,
									   12321
								   ],
								   "custom_url_name": "立即使用",
								   "custom_url": "http://weixin.qq.com",
								   "custom_url_sub_title": "6个汉字tips",
								   "promotion_url_name": "营销入口1",
								   "promotion_url": "http://www.qq.com",
								   "need_push_on_view": true
							   },
							   "supply_bonus": true,
							   "supply_balance": false,
							   "prerogative": "test_prerogative",
							   "auto_activate": true,
							   "custom_field1": {
								   "name_type": "FIELD_NAME_TYPE_LEVEL",
								   "url": "http://www.qq.com"
							   },
							   "activate_url": "http://www.qq.com",
							   "custom_cell1": {
								   "name": "使用入口2",
								   "tips": "激活后显示",
								   "url": "http://www.xxx.com"
							   },
							   "bonus_rule": {
								  "cost_money_unit": 100,
								  "increase_bonus": 1,
								  "max_increase_bonus": 200,
								  "init_increase_bonus": 10,
								  "cost_bonus_unit": 5,          
								  "reduce_money":  100,            
								  "least_money_to_use_bonus": 1000, 
								  "max_reduce_bonus": 50
							   },
							   "discount": 10
						   }
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
