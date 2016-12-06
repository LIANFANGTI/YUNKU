
<?php
include_once('wxBizMsgCrypt.php');
//引用根目录的连接数据库文件
$filename = dirname($_SERVER['DOCUMENT_ROOT']);
require_once $filename."/fun/config.php";
$db = new PDO($dsn, $user, $pwd);
$db->exec("SET CHARACTER SET UTF8");
$res = $db->query("SELECT * FROM ywk_weixin_account WHERE type = 1 ",PDO::FETCH_ASSOC);
$wxData = $res->fetchAll();
$token = $wxData[0]['token'];
$date_time = time();
//第三方发送消息给公众平台
$encodingAesKey = $wxData[0]['encodingAesKey'];
$token = $wxData[0]['token'];
$appId = $wxData[0]['appid'];
$timeStamp  = empty($_GET['timestamp'])     ? ""    : trim($_GET['timestamp']) ;
$nonce      = empty($_GET['nonce'])     ? ""    : trim($_GET['nonce']) ;
$msg_sign   = empty($_GET['msg_signature']) ? ""    : trim($_GET['msg_signature']) ;
$encryptMsg = file_get_contents('php://input');
$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
$xml_tree = new DOMDocument();
$xml_tree->loadXML($encryptMsg);
$array_e = $xml_tree->getElementsByTagName_r('Encrypt');
$encrypt = $array_e->item(0)->nodeValue;
$format = "toUser%s";
$from_xml = sprintf($format, $encrypt);
//第三方收到公众号平台发送的消息
$msg = '';
$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
if ($errCode == 0) {
    print("解密后: " . $msg . "\n");
    $xml = new DOMDocument();
    $xml->loadXML($msg);
    $array_e = $xml->getElementsByTagName_r('ComponentVerifyTicket');
    $component_verify_ticket = $array_e->item(0)->nodeValue;
    echo '解密后的component_verify_ticket是：'.$component_verify_ticket;
    $dateline = time();

    $sql= "UPDATE ywk_weixin_account SET `component_verify_ticket` = '$component_verify_ticket',dateline='$dateline', date_time='$date_time' WHERE type = 1 LIMIT 1  " ;

    if($db->query($sql))
    {
        echo 'success';
    } 
} else {
    echo '解密后失败：'.$errCode;
    print($errCode . "\n");
}
die();
?>