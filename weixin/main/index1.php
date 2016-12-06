<!DOCTYPE html>
<html lang="en">
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
	//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
	//isset($_GET["openid"])?$openid=$_GET["openid"]:$openid=0;
	
	if(isset($_GET["openid"])){
		$OPENID=$_GET["openid"];
		$COMPANY_ID=$_GET["c"];
		$KEHU_WX=SELECT("kehu_wx","*","openid='$OPENID' AND company=$COMPANY_ID");
		print_r($KEHU_WX);
		if(!empty($KEHU_WX)){
			login($KEHU_WX,'index1.php');	
		}else{
			echo $db->printMessage();
			die("openid参数错误无权访问");
		}
	}else{
		@session_start();
		if(isset($_SESSION["openid"])){
			$user=$_SESSION["user"];
			$OPENID=$_SESSION["openid"];
			$name=$_SESSION["name"];
			$COMPANY_ID=$_SESSION["company"];
			$COMPANY_NAME= selecta("company","id",$COMPANY_ID,"name");
			$head=$_SESSION["head"];
			/*echo  "<hr>调试信息:<br>";
			echo  "<br>openid:".$OPENID;
			echo  "<br>name:".$name;
			echo  "<br>company:".$COMPANY_ID;
			echo  "<br>head:".$head;
			echo  "<hr>";*/
			$KEHU_WX=SELECT("kehu_wx","*","openid='$OPENID' AND company=$COMPANY_ID");
			
			$KEHU_INFO=SELECT("kehu","*","wx_openid='$OPENID' AND company=$COMPANY_ID");
			
			if(!empty($KEHU_INFO)){  //是否绑定
				$url="http://weixin.checar.cn/weixin/checar/checarAction!aliapi?app_id=2014101600013717&source=alipay_wallet&alipay_token=&scope=auth_userinfo&userOutputs=basicInfo&auth_code=743ceaee777440779d84aacd99c7VX14";
				$word="违章查询";
				$name="".$KEHU_INFO[0]["name"]."";
				$money=$KEHU_INFO[0]["money"]*1.00;//余额
				$jf=$KEHU_INFO[0]["jf"]*1;//积分
				$KEHU_VIP=$KEHU_INFO[0]["vip"];
			}else{
				$url="bding.php?openid=$OPENID&c=$COMPANY_ID&hd=$head";
				$name=$KEHU_WX[0]["name"];
				$jf=0;
				$word="绑定".$COMPANY_NAME."账号";
				$KEHU_VIP="VIP00000000";
				$money=$jf=0;
			}			
		}else{
			echo "未登陆 你妈死了";
			//$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9c3164046547198a&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php&response_type=code&scope=snsapi_userinfo&state=$COMPANY_ID#wechat_redirect";
	        //header('Location: '.$url.'');	
		}
	}
	
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        <?php echo SELECTA("company","id",$COMPANY_ID,"name"); ?>-个人中心
    </title>
    <style>
        body {
            font-family: "黑体";
        }
        p{
          color: black;
        }
        a:active{
          text-decoration: none;
        }
        img {
            width: 100%;
            display: block;
        }

        .userhead {
            height: 100px;
            width: 100px;
            margin-top: -140px;
            margin-left: 10%;
        }

        .username {
            margin-top: -70px;
            margin-left: 150px;
        }

        .username p {
            color: white;
            font-size: 18px;
        }

        .userlv {
            height: 20px;
            width: 20px;
            margin-top: -40px;
            margin-left: 210px;
        }

        .vipnum {
            margin-top: 1px;
            margin-left: 150px;
        }

        .vipnum p {
            color: white;
            font-size: 14px;
        }

        .container {
            margin-top: 400px;
        }
        /*list里面的img格式都整合一块*/

        .list1 img,
        .list2 img,
        .list3 img,
        .list4 img,
        .list5 img,
        .list6 img {
            width: 30px;
            height: 30px;
            margin-left: 20px;
        }

        .list1 img {
            margin-top: 80px;
        }
        /*list里面的P都整合在一块*/

        .list1 p,
        .list2 p,
        .list3 p,
        .list4 p,
        .list5 p,
        .list6 p {
            margin-top: -27px;
            margin-left: 80px;
            font-size: 14px;
            font-family: "微软雅黑";
        }
        /*后四个list的箭头大小规格整合在一起*/

        .list3 span img,
        .list4 span img,
        .list5 span img,
        .list6 span img {
            width: 15px;
            height: 15px;
        }

        .list1 span,.list2 span,.list3 span,.list4 span,.list5 span,.list6 span{
            float: left;
            margin-top: -40px;
            margin-left: 85%
        }
    </style>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <img src="img/bg.jpg" alt="背景" />
    <div class="userhead" style=";">
        <img  class="img-circle" src="<?php echo $head;?>" class="img-responsive" alt="用户头像" />
    </div>
    <div class="username">
        <p>
            <?php echo $name; ?>
        </p>
    </div>
    <div class="userlv">
        <img src="img/userlv.png" alt="用户等级" />
    </div>
    <div class="vipnum">
        <p>
           <?php echo $KEHU_VIP; ?>
        </p>
    </div>
    <div class="list1">
        <img src="img/usermoney.png" alt="余额" />
        <p>
            账户余额
        </p>
        <span><?php echo $money;?>元</span>
    </div>
    <hr>
    <div class="list2">
        <img src="img/userjifen.png" alt="积分" />
        <p>
            用户积分
        </p>
        <span><?php echo $jf;?></span>
    </div>
    <hr>
  <a href="xiaofeijilu.php?id=<?php echo $id;?>"> <div class="list3">
        <img src="img/userxiaofei.png" alt="消费记录" />
        <p>
            消费记录
        </p>
        <span><img src="img/jiantou.png" alt="箭头" /></span>

    </div>
    </a>
    <hr>
    <a href="chongzhi.php"><div class="list4">
        <img src="img/chongzhi.png" alt="充值记录" />
        <p>
            充值记录
        </p>
        <span><img src="img/jiantou.png" alt="箭头" /></span>
    </div>
    </a>
    <hr>
  <a href="car.php"> <div class="list5">
        <img src="img/mycar.png" alt="车辆" />
        <p>
            我的车辆
        </p>
        <span><img src="img/jiantou.png" alt="箭头" /></span>
    </div>
    </a>
    <hr>
    <a href=<?php echo $url;?> ><div class="list6">
        <img src="img/tongbu.png" alt="同步用户数据" />
        <p>
            <?php echo $word;?>
        </p>
        <span><img src="img/jiantou.png" alt="箭头" /></span>
    </div>
    </a>
    <hr>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
</body>

</html>
