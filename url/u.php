<?php 
ini_set('display_errors','On');
require_once '../lib/fun.php'; 

if(isset($_GET["p"])){
	/*正则测试*/
	/*$STR="一zoom二zone三四zo五ABN420122(电话：123455)";
    echo "原字符串:".$STR."<br>";	
	echo "正则表达式:".$_GET["p"]."<br>";	
	preg_match_all($_GET["p"],$STR,$ARR);
    echo "匹配结果:".$ARR[0][0]."<br>";		
	
	print_r($ARR);*/
	$url=$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	//echo selecta("shorturl","surl","'".$url."'","url");
	if(EXISTA("shorturl","surl",$url)){
		//echo selecta("shorturl","p","'".$_GET["p"]."'","url");
		$GOTOURL=selecta("shorturl","surl","'".$url."'","url");
		echo "跳转至<a href='$GOTOURL'>$GOTOURL</a>";
		header("Location: $GOTOURL");
	}else{
		echo "404 链接不存在";
	}
	
}else{
	echo "参数错误";
}
?>