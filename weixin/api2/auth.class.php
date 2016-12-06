<?php
class Auth {
	const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
	const API_COMPONENT_TOKEN_URL = '/component/api_component_token';
	const API_CREATE_PREAUTHCODE_URL = '/component/api_create_preauthcode?component_access_token=';
	const API_QUERY_AUTH_URL = '/component/api_query_auth?component_access_token=';
	const API_AUTHORIZER_TOKEN_URL = '/component/api_authorizer_token?component_access_token=';
	const API_GET_AUTHORIZER_INFO_URL = '/component/api_get_authorizer_info?component_access_token=';
	const API_GET_AUTHORIZER_OPTION_URL = '/component/api_get_authorizer_option?component_access_token=';
	const API_SET_AUTHORIZER_OPTION_URL = '/component/api_set_authorizer_option?component_access_token=';
	const API_REDIRECT = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?';
	const USER_GET_URL='/user/get?';
	private $appid;
	private $options;
	private $appsecret;
	private $component_verify_ticket;
	private $_funcflag = false;
	public $debug = true;
	public $errCode = 40001;
	public $errMsg = "no access";
	private $pre_auth_code;
	private $component_access_token;
	private $authorizer_access_token;
	private $next_openid;
	public function __construct($options) {
		$this -> options = $options;
		$this -> appid = isset($options['component_appid']) ? $options['component_appid'] : '';
		$this -> appsecret = isset($options['component_appsecret']) ? $options['component_appsecret'] : '';
		$this -> component_verify_ticket = isset($options['component_verify_ticket']) ? $options['component_verify_ticket'] : '';
	}

	//测试函数
	/*
	 * 微信对话框模块出故障时，可以将调试信息写入文件，从而分析问题
	 * 对应写入信息页面，还应该有一个可查询文件的页面，目前我都是直接在服务器上看文件的
	 *
	 */
	public function debug_info_write($info) {
		$filename = './a.txt';
		$fp = fopen($filename, 'w+');
		fwrite($fp, $info . "\n");
		fclose($fp);
	}

	/**
	 * 读取调试页面
	 */
	public function debug_info_read() {
		header("Content-Type: text/html; charset=utf-8");
		$filename = './a.txt';
		$fp = fopen($filename, "r");
		$contents = fread($fp, filesize($filename));
		fclose($fp);
		dump($contents);
	}

	public static function xmlSafeStr($str) {
		return '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $str) . ']]>';
	}

	/**
	 * 数据XML编码
	 * @param mixed $data 数据
	 * @return string
	 */
	public static function data_to_xml($data) {
		$xml = '';
		foreach ($data as $key => $val) {
			is_numeric($key) && $key = "item id=\"$key\"";
			$xml .= "<$key>";
			$xml .= (is_array($val) || is_object($val)) ? self::data_to_xml($val) : self::xmlSafeStr($val);
			list($key, ) = explode(' ', $key);
			$xml .= "</$key>";
		}
		return $xml;
	}

	/**
	 * XML编码
	 * @param mixed $data 数据
	 * @param string $root 根节点名
	 * @param string $item 数字索引的子节点名
	 * @param string $attr 根节点属性
	 * @param string $id   数字索引子节点key转换的属性名
	 * @param string $encoding 数据编码
	 * @return string
	 */
	public function xml_encode($data, $root = 'xml', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8') {
		if (is_array($attr)) {
			$_attr = array();
			foreach ($attr as $key => $value) {
				$_attr[] = "{$key}=\"{$value}\"";
			}
			$attr = implode(' ', $_attr);
		}
		$attr = trim($attr);
		$attr = empty($attr) ? '' : " {$attr}";
		$xml = "<{$root}{$attr}>";
		$xml .= self::data_to_xml($data, $item, $id);
		$xml .= "</{$root}>";
		return $xml;
	}

	/**
	 * GET 请求
	 * @param string $url
	 */
	private function http_get($url) {
		$oCurl = curl_init();
		if (stripos($url, "https://") !== FALSE) {
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if (intval($aStatus["http_code"]) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}

	/**
	 * POST 请求
	 * @param string $url
	 * @param array $param
	 * @return string content
	 */
	public function http_post($url, $param) {
		$oCurl = curl_init();
		if (stripos($url, "https://") !== FALSE) {
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
		}
		if (is_string($param)) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach ($param as $key => $val) {
				$aPOST[] = $key . "=" . urlencode($val);
			}
			$strPOST = join("&", $aPOST);
		}
        //file_put_contents('./mylog.txt',$url."\r\n".$strPOST."\r\n".date('Y-m-d H:i:s')."\r\n==============\r\n",FILE_APPEND);
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POST, true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if (intval($aStatus["http_code"]) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}

	/**
	 * 微信api不支持中文转义的json结构
	 * @param array $arr
	 */
	static function json_encode($arr) {
		$parts = array();
		$is_list = false;
		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr) - 1;
		if (($keys[0] === 0) && ($keys[$max_length] === $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for ($i = 0; $i < count($keys); $i++) {//See if each key correspondes to its position
				if ($i != $keys[$i]) {//A key fails at position check.
					$is_list = false;
					//It is an associative array.
					break;
				}
			}
		}
		foreach ($arr as $key => $value) {
			if (is_array($value)) {//Custom handling for arrays
				if ($is_list)
					$parts[] = self::json_encode($value);
				/* :RECURSION: */
				else
					$parts[] = '"' . $key . '":' . self::json_encode($value);
				/* :RECURSION: */
			} else {
				$str = '';
				if (!$is_list)
					$str = '"' . $key . '":';
				//Custom handling for multiple data types
				if (is_numeric($value) && $value < 2000000000)
					$str .= $value;
				//Numbers
				elseif ($value === false)
					$str .= 'false';
				//The booleans
				elseif ($value === true)
					$str .= 'true';
				else
					$str .= '"' . addslashes($value) . '"';
				//All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
				$parts[] = $str;
			}
		}
		$json = implode(',', $parts);
		if ($is_list)
			return '[' . $json . ']';
		//Return numerical JSON
		return '{' . $json . '}';
		//Return associative JSON

	}

	/**通用post提交数据
	 *
	 * */
	public function authpost($url, $data) {
		if (!$this -> access_token && !$this -> checkAuth())
			return false;
		// echo $this->access_token;
		$result = $this -> http_post($url . 'access_token=' . $this -> access_token, self::json_encode($data));
		dump($result);
		exit ;
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/*
	 * 获取第三方平台令牌（component_access_token）
	 * 数据实例
	 * {
	 "component_appid":"appid_value" ,
	 "component_appsecret": "appsecret_value",
	 "component_verify_ticket": "ticket_value"
	 }
	 * */
	public function get_access_token() {
        $cache = file_read('cache/component_access_token.json');
		//读取缓存
		$cache = json_decode($cache, true);
		if ($cache['expires_in'] > time()) {
			$this -> component_access_token = $cache['component_access_token'];
			return $cache['component_access_token'];
		}
        $result = $this -> http_post(self::API_URL_PREFIX . self::API_COMPONENT_TOKEN_URL, json_encode($this -> options));
        if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}
			$this -> component_access_token = $json['component_access_token'];
			//写入文件来设置缓存
			file_write('cache/component_access_token.json', json_encode(array('component_access_token' => $json['component_access_token'], 'expires_in' => time() + 7100)));
			return $this -> component_access_token;
		}
		return false;
	}

	/*
	 * 获取预授权码
	 * {
	 "component_appid":"appid_value"
	 * }
	 * */
	public function get_auth_code() {

		$component_access_token = $this -> getAccessToken();
		//$cache = file_read('cache/apre_auth_code.json');
		//读取缓存
		//$cache = json_decode($cache, true);
		//if ($cache['expires_in'] > time()) {

		//	return $cache['pre_auth_code'];
		//}
		$result = $this -> http_post(self::API_URL_PREFIX . self::API_CREATE_PREAUTHCODE_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid)));
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}

			//写入文件来设置缓存
			//file_write('cache/apre_auth_code.json', json_encode(array('pre_auth_code' => $json['pre_auth_code'], 'expires_in' => time() + 500)));
			return $json['pre_auth_code'];
		}
		return false;
	}

	/*
	 * 通过返回授权码换取公众号的授权信息
	 * $auth_code  授权返回
	 * */
	public function get_authorization_info($auth_code) {

		$component_access_token = $this -> getAccessToken();
		$result = $this -> http_post(self::API_URL_PREFIX . self::API_QUERY_AUTH_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid, 'authorization_code' => $auth_code)));
        if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}

			$json = $json['authorization_info'];
			file_write('cache/authorizer_access_token_' . $json['authorizer_appid'] . '.json', json_encode(array('authorizer_access_token' => $json['authorizer_access_token'], 'authorizer_refresh_token' => $json['authorizer_refresh_token'], 'expires_in' => time() + 7100)));
			return $json;
		}
		return false;
	}

    /*
         * 获取授权公众号的authorizer_access_token
         * */
    public function get_authorizer_access_token($authorizer_appid) {

        $cache = file_read('cache/authorizer_access_token_'.$authorizer_appid.'.json');
        //读取缓存
        $cache = json_decode($cache, true);
        if ($cache['expires_in'] > time()) {
            $authorizer_access_token = $cache['authorizer_access_token'];
        } else {
            $authorizer_refresh_token = $cache['authorizer_refresh_token'];
            $authorizer_access_token = $this -> get_refresh_token($authorizer_appid,$authorizer_refresh_token);
        }
        return $authorizer_access_token;
    }

	/*
	 * 获取（刷新）授权公众号的令牌
	 * 该API用于在授权方令牌（authorizer_access_token）失效时，可用刷新令牌（authorizer_refresh_token）获取新的令牌。
	 * */
	public function get_refresh_token($authorizer_appid, $authorizer_refresh_token) {

	
		$component_access_token = $this -> getAccessToken();
		$result = $this -> http_post(self::API_URL_PREFIX . self::API_AUTHORIZER_TOKEN_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid, 'authorizer_appid' => $authorizer_appid, 'authorizer_refresh_token' => $authorizer_refresh_token)));
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}
			$this -> authorizer_access_token = $json['authorizer_access_token'];
			file_write('cache/authorizer_access_token_' . $authorizer_appid . '.json', json_encode(array('authorizer_access_token' => $json['authorizer_access_token'], 'authorizer_refresh_token' => $json['authorizer_refresh_token'], 'expires_in' => time() + 7100)));
			return $this -> authorizer_access_token;
		}
		return false;
	}

	/*
	 * 获取授权方的账户信息
	 该API用于获取授权方的公众号基本信息，包括头像、昵称、帐号类型、认证类型、微信号、原始ID和二维码图片URL。
	 * */
	public function get_authorizer_info($authorizer_appid) {

		
		$component_access_token = $this -> getAccessToken();
		$result = $this -> http_post(self::API_URL_PREFIX . self::API_GET_AUTHORIZER_INFO_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid, 'authorizer_appid' => $authorizer_appid)));
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}

			return $json;
		}
		return false;
	}

	/*
	 * 获取授权方的选项设置信息
	 * */
	public function get_authorizer_option($authorizer_appid, $option_name) {

		$component_access_token = $this -> getAccessToken();
		$result = $this -> http_post(self::API_URL_PREFIX . self::API_GET_AUTHORIZER_OPTION_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid, 'authorizer_appid' => $authorizer_appid, 'option_name' => $option_name)));
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}

			return $json;
		}
		return false;
	}

	/*
	 * 获取授权方的选项设置信息
	 * */
	public function set_authorizer_option($authorizer_appid, $option_name, $option_value) {

		
		$component_access_token = $this -> getAccessToken();

		$result = $this -> http_post(self::API_URL_PREFIX . self::API_SET_AUTHORIZER_OPTION_URL . $component_access_token, json_encode(array('component_appid' => $this -> appid, 'authorizer_appid' => $authorizer_appid, 'option_name' => $option_name, 'option_value' => $option_value)));
		if ($result) {
			$json = json_decode($result, true);
			if (!$json || !empty($json['errcode'])) {
				$this -> errCode = $json['errcode'];
				$this -> errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}

	/*
	 * 获取跳转链接
	 * */
	public function getRedirect($callback, $pre_auth_code) {
		return self::API_REDIRECT . 'component_appid=' . $this -> appid . '&pre_auth_code=' . $pre_auth_code . '&redirect_uri=' . urlencode($callback);
	}

	/*
	 * 获取生成的token
	 * */
	public function getAccessToken() {

		$cache = file_read('cache/component_access_token.json');
		//读取缓存
		$cache = json_decode($cache, true);
		if ($cache['expires_in'] > time()) {
			$component_access_token = $cache['component_access_token'];
		} else {
			$component_access_token = $this -> get_access_token();
		}
		return $component_access_token;
	}
	
	
	/**
	 * 批量获取关注用户列表
	 * @param unknown $next_openid
	 */
	public function getUserList($authorizer_access_token='',$next_openid=''){
		
		if($next_openid){
			$result = $this->http_get(self::API_URL_PREFIX.self::USER_GET_URL.'access_token='.$authorizer_access_token.'&next_openid='.$next_openid);
		}else{
			$result = $this->http_get(self::API_URL_PREFIX.self::USER_GET_URL.'access_token='.$authorizer_access_token);
			
		}
		if ($result)
		{
			$json = json_decode($result,true);
			if (isset($json['errcode'])) {
				$this->errCode = $json['errcode'];
				$this->errMsg = $json['errmsg'];
				return false;
			}
			return $json;
		}
		return false;
	}
	

}
