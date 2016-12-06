
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/Bcenter.css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<title>POST数据请求测试页面</title>
                    <style>
						.round{
							/*text-align:center;*/
							height:80px;
							width:80px;
							overflow:hidden;
							border:4px solid white;
							border-radius:100px;
						}
				</style>
	</head>
    <body>
<?php 
	$post_data = array(  
	  'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',  
	  'sign' => 'C380BEC2BFD727A4B6845133519F3AD6',
	  'mch_billno' => '10000098201411111234567890',
	  'mch_id' => '10000098', 
	  'wxappid' => '', 
	  'send_name' => '', 
	  're_openid' => '', 
	  'total_amount' => '', 
	  'total_num' => '',
	  'wishing' => '',
	  'act_name' => '',
	  'remark' => ''
	  
	);  
	echo "Back:".send_post('https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack', $post_data);  
	function send_post($url, $post_data) {  
	  $postdata = http_build_query($post_data);  
	  $options = array(  
		'http' => array(  
		  'method' => 'POST',  
		  'header' => 'Content-type:application/x-www-form-urlencoded',  
		  'content' => $postdata,  
		  'timeout' => 15 * 60 // 超时时间（单位:s）  
		)  
	  );  
	  $context = stream_context_create($options);  
	  $result = file_get_contents($url, false, $context);
	  return $result;  
	}   
?>
	</body>
</html>