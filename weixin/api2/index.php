<?php
include_once './auth.class.php';

$options = array(
        'component_appid' => 'wxfe2c93abdd3c84d4',
        'component_appsecret' => 'e33633f8aaf12c0624b64c62fcca29b7',
        'component_verify_ticket'=>''
);

$weObj = new Auth($options);

$auth_code = $_GET['auth_code'];
if(empty($auth_code)){
	//此外示例代授权发起

	echo $url;
	//header("Location:$url");die;
}else{
	//此外示例代授权回调后获取公众号信息

}

?>