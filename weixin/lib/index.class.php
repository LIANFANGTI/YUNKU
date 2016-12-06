<?PHP 
class index{
	public function __construct(){
		echo "类调用成功";
	}
	public function checkSignature()
	{
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce = $_GET["nonce"];	
					
		$token = 'zckj';
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		echo $tmpStr;
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
		
	}
	
}

?>