<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/tjcar.css" rel="stylesheet" />
		<link href="css/weui.min.css" rel="stylesheet" />
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <script src="js/tjcar.js?v=2"></script>
		<script src="../../zdcar2/js/js.js?v=2"></script>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-datetimepicker.min.js"></script>
		<title>添加车辆</title>
	</head>
<?php 
	require_once '../../lib/mysql.class.php';
    require_once '../../lib/fun.php';
	//$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
		@session_start();
		if(logincheck()){
			$openid=$_SESSION["openid"];
			$db->select("kehu","*","wx_openid='".$openid."'");$kehu=$db->fetchArray(MYSQL_ASSOC);
			
			$URL="bding.php?openid=".$openid;
				$PAGE="<div class='weui_msg'>
						<div class='weui_icon_area'><i class='weui_icon_msg weui_icon_warn '></i></div>
						<div class='weui_text_area'>
							<h2 class='weui_msg_title'>添加失败</h2>
							<p class='weui_msg_desc'>您尚未激活云库账号,请先激活账号。</p>
						</div>
						<div class='weui_opr_area'>
							<p class='weui_btn_area'>
								<a href='".$URL."' class='weui_btn weui_btn_primary'>激活</a>
								<a href='#' class='weui_btn weui_btn_default'>取消</a>
							</p>
						</div>
						<div class='weui_extra_area'>
							
						</div>
					</div>";
			if(empty($kehu)){die($PAGE);}
			$db->select("cartype","*","");$cartype=$db->fetchArray(MYSQL_ASSOC);
			echo $db->printMessage();		
		}else{
			$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9c3164046547198a&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
	        header('Location: '.$url.'');	
		}

	
?>


	<body>
    <input type="hidden" id="khid" value="<?PHP echo $kehu[0]["id"];?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<div class="input-group">
						<span class="input-group-addon">车牌</span>
						<input class="form-control" type="text" id="carid">
					</div>
				</div>
			</div>

		</div>
		

		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group">
						<span class="input-group-addon">VIN码</span>
						<input class="form-control" type="text" id="vin"  placeholder="单位:千米">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group">
						<span class="input-group-addon">当前里程</span>
						<input class="form-control" type="text" id="km"  placeholder="单位:千米">
					</div>
				</div>
			</div>
		
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group">
							<span class="input-group-addon">保险到期日</span>
							<input  class=" form-control" type="date" id="date_bx" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group">
							<span class="input-group-addon">年检到期日</span>
							<input  class=" form-control" type="date" id="date_nj" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group">
						<span class="input-group-addon">备注</span>
						<input class="form-control" type="text" id="tips">
					</div>
				</div>
				</div>
				</div>
				
				
			</div>
		</div>
		<div class="container-fluid">
			<input type="button" class="weui_btn weui_btn_primary" value="保存"  onClick="save()"/>
		</div>
		


	</body>

</html>