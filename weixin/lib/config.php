<?PHP 

 $WX_APPID="wx9c3164046547198a";
 $WX_SECERT="0ea115a00b20fb338aa0bce190e61c24";
 //'121.196.226.94','admin','xwq198291',"zckj_db","utf8",true);
 $DB_HOST='121.196.226.94';
 $DB_USER='admin';
 $DB_PASSWORD='xwq198291';
 $DB_DATABASE='zckj_db';

 
 


/* $file=dir("../config.php");
 $file.read();
 
function getconfig($file, $ini, $type="string") { 
	if ($type=="int") { 
		$str = file_get_contents($file); 
		$config = preg_match("/" . $ini . "=(.*);/", $str, $res); 
		Return $res[1]; 
	}else{ 
		$str = file_get_contents($file); 
		$config = preg_match("/" . $ini . "=\"(.*)\";/", $str, $res); 
		if($res[1]==null) { 
			$config = preg_match("/" . $ini . "='(.*)';/", $str, $res); 
		} 
		Return $res[1]; 
	} 
} 


function updateconfig($file, $ini, $value,$type="string"){ 
	$str = file_get_contents($file); 
	$str2=""; 
	if($type=="int") { 
		$str2 = preg_replace("/" . $ini . "=(.*);/", $ini . "=" . $value . ";", $str); 
	}else{ 
		$str2 = preg_replace("/" . $ini . "=(.*);/", $ini . "=\"" . $value . "\";",$str); 
	} 
	file_put_contents($file, $str2); 
} 


//echo getconfig("./2.php", "bb", "string"); 
getconfig("./2.php", "bb");// 
updateconfig("./2.php", "kkk", "admin"); 
//echo "<br/>".getconfig("./2.php", "name","string"); */
 ?>