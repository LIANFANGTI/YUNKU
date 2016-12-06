<?php
/**
 * 微站导航管理
 * [WDL] Copyright (c) 2013 B2CTUI.COM
 */
defined('IN_IA') or exit('拒绝访问');

$content = file_get_contents("php://input");
//记录日志
file_put_contents("./appid.txt", "\r\n" . $content . $_GET['timestamp'] . '******' . $_GET['nonce'] . "******" . $_GET['msg_signature'], FILE_APPEND);

//cache_write('ComponentVerifyTicket', $obj->ComponentVerifyTicket);//写入缓存

require IA_ROOT . 'wxBizMsgCrypt.php';
// 第三方发送消息给公众平台

$encodingAesKey = $_W['component_encodingAesKey'];
$token = $_W['component_token'];
//$appId = "wx1f618e6dfa5af40a";
$appId = $_W['component_appid'];
$timeStamp = $_GET['timestamp'];
$nonce = $_GET['nonce'];
$msg_sign = $_GET['msg_signature'];
$encryptMsg = $content;
$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);

$xml_tree = new DOMDocument();
$xml_tree -> loadXML($encryptMsg);
$array_e = $xml_tree -> getElementsByTagName('Encrypt');
$encrypt = $array_e -> item(0) -> nodeValue;

$format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
$from_xml = sprintf($format, $encrypt);

// 第三方收到公众号平台发送的消息
$msg = '';
$errCode = $pc -> decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
if ($errCode == 0) {
	//print("解密后: " . $msg . "\n");
	$xml = new DOMDocument();
	$xml -> loadXML($msg);

	$array_e = $xml -> getElementsByTagName('ComponentVerifyTicket');
	$component_verify_ticket = $array_e -> item(0) -> nodeValue;
	$array_b = $xml->getElementsByTagName('InfoType');
	$infotype = $array_b->item(0)->nodeValue;
	$array_c = $xml->getElementsByTagName('AuthorizerAppid');
	$authorizerappid = $array_c->item(0)->nodeValue;
	//记录解密的xml数据
  file_put_contents("./get.txt", "\r\n". $msg."\r\n" .$infotype."\r\n".$authorizerappid, FILE_APPEND);
  
  if($infotype=='unauthorized'){//取消授权做判断处理
      pdo_update('wechats', array('bind_status'=>0), array('type'=>1,'key'=>$authorizerappid));
      echo 'success';
  }
  
    if($component_verify_ticket){
    	file_write('cache/component_verify_ticket.json', json_encode(array('component_verify_ticket' => $component_verify_ticket)));
		echo 'success';
    }
} else {

}
die();
