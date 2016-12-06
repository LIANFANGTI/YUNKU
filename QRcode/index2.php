<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php  
	require_once "phpqrcode.php";
	vendor("phpqrcode.phpqrcode");
    $data = 'http://www.baidu.com';
	$level = 'L';
    // 点的大小：1到10,用于手机端4就可以了
    $size = 4;
    // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
    //$path = "images/";
    // 生成的文件名
    //$fileName = $path.$size.'.png';
    QRcode::png($data, false, $level, $size);
?>
</body>
</html>