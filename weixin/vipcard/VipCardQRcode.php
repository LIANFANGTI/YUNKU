<title>会员卡发放</title>
<?php

require_once '../../lib/mysql.class.php';
require_once '../../lib/fun.php';
$db = new mysql('121.196.226.94','admin','xwq198291',"zckj_db","utf8",true);
$appid="wx9c3164046547198a";
$secret="0ea115a00b20fb338aa0bce190e61c24";
$GetAccessTokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
$bcode=curl($GetAccessTokenUrl);
//print_r($bcode);
$ACCESS_TOKEN=$bcode["access_token"];
$CreateVipCardApi="https://api.weixin.qq.com/card/qrcode/create?access_token=$ACCESS_TOKEN";
				$data=' {
						"action_name": "QR_CARD", 
						"expire_seconds": 1800,
						"action_info": {
							"card": {
									"card_id": "pDOIst4j6K4G9yfhSUzlmYWWexQY", 
									"code": "198374613512",
									"openid": "oDOIst6a7MxTGzVWSb-QVysb-msI",
									"is_unique_code": false ,
									"outer_id" : 1,
									"outer_str":"12b"
									}
						  }
					   }';

//echo "请求接口<input type='text' style='width:100%' value='".$CreateVipCardApi."'/>";
$CardInfo=getshort($data,$CreateVipCardApi);
$CardInfo=json_decode($CreateInfo, true);
$PostQrcode=" https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$TOKENPOST";

//echo $CardInfo[]
//print_r($CreateInfo);

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
