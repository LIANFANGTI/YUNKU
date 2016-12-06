<!DOCTYPE html>
<html>
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
	//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
	isset($_GET["openid"])?$openid=$_GET["openid"]:$openid=0;
	
	if($openid){
		$db->select("kehu_wx","*","openid='$openid'");$wxkh=$db->fetchArray(MYSQL_ASSOC);
		print_r($wxkh);
		if(!empty($wxkh)){
			login($wxkh,'index.php');	
		}else{
			echo $db->printMessage();
			die("openid参数错误无权访问");
		}
	}else{
		@session_start();
		
		if(isset($_SESSION["openid"])){
			$user=$_SESSION["user"];
			$openid=$_SESSION["openid"];
			
			$name=$_SESSION["name"];
			$company=$_SESSION["company"];
			$head=$_SESSION["head"];
			$db->select("kehu_wx","*","openid='$openid'");$kehu_wx=$db->fetchArray(MYSQL_ASSOC);
			$db->select("kehu","*","wx_openid='".$kehu_wx[0]["openid"]."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			echo $db->printMessage();
			if(!empty($kehu)){
				$url="xiaofeijilu.php";
				$word="消费记录2";
				$name="(".$kehu[0]["name"].")";
				$money=$kehu[0]["money"]*1.00;//余额
				$jf=$kehu[0]["jf"]*1;//积分			
			}else{
				$url="bding.php?openid=".$kehu_wx[0]["openid"];
				$word="激活云库账号";
				$money=$jf=0;
			}			
		}else{
			die("您未登陆 无权访问");
		}
	}
	
?>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/Bcenter.css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<title><?php echo $name;?>-个人中心</title>
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
	<div class="modal-header">
	<div class="round" >
    	<a href="index.php">
			
        	<img src="<?php echo $head; ?>" width="80px" height="80px" style="z-index:1001;" ;>	
    	</a>
    </div>
		<b style="color:#FFF;margin:40px 0px 0px 120px;font-size:20px;"><?php echo $kehu[0]["name"]; ?></b><b class='btn btn-warning btn-xs' style='margin-left:20px;'>V<?php echo ($kehu[0]["vipdj"]*1); ?></b>
		<b style="color:#FFF;margin:40px 0px 0px 120px;font-size:16px;"><?php echo $kehu[0]["vip"]; ?></b>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center "><b>余额:</b><?php echo $money;?>元<span></span></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center "><b>积分:</b><?php echo $jf;?><span></span></div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<a href="xiaofei.php?id=<?php echo $id;?>"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center ">消费记录</div></a>
			<a href="chongzhi.php"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center ">充值记录</div></a>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<a href="car.php"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left "><span class="fa fa-cab"> 我的车辆</span></div></a>
			<a href="car.php"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right "><b>></b></div></a>
		</div>
		
	</div>
	<div class="container-fluid">
		<div class="row">
			<a href=<?php echo $url;?> class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left ">
                	<span class="fa fa-info"><?php echo $word;?></span>
            </a>
			<a  href="<?php echo $url;?>" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right ">
            <b>></b>
           </a>
		</div>
	</div>

	<body>
	</body>

</html>