
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/Bcenter.css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<title>POST DATA</title>
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
		require_once 'WGate/wgate.class.php';
		$options = array(
			"key"=>'zidianchefang', // ΢��֮�������ɵ�KEY
			"secret"=>'zidianchefang', // ��Ӧ��secret
			"appid"=>'wx9c3164046547198a',  // ���ںŵ�APPID
			"weixin_account_id"=>'477' // ΢��֮���й��ںŶ�Ӧ��ID
		);
		  $wgate = new WGate($options);
		  echo $wgate->errMsg;
	?>
	</body>
</html>