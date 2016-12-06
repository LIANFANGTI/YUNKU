<?php 
	$post_string = "nonce_str=5K8264ILTKCH16CQ2502SI8ZNMTM67VS&version=beta";  
	echo "·µ»ØÊý¾Ý".request_by_curl('https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack', $post_string);   
function request_by_curl($remote_server, $post_string) {  
  $ch = curl_init();  
  curl_setopt($ch, CURLOPT_URL, $remote_server);  
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
  curl_setopt($ch, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta");  
  $data = curl_exec($ch);  
  curl_close($ch);  
  
  return $data;  
} 
?>