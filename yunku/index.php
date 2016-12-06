<!DOCTYPE HTML>
<html>
<head>

<?php 

require_once '../zdcar2/mysql.class.php';
$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
@session_start();
if(isset($_SESSION["user"])){
	$db->select("company","*","id=".$_SESSION["company"]."");
	$company=$db->fetchArray(MYSQL_ASSOC);
	$cpname=$company[0]["name"];//公司名称获取
	$info="<li title='我的云库'><a href='../zdcar2/index.php'>".$cpname."</a></li>
		<li><a href='logout.php'>退出</a></li>";
}else{
	$info="<a href='#'>登录</a>";
}
?>
<title>云库汽车维修软件, 好用的汽车维修软件, 简单实用的汽车维修软件, 云库汽车美容软件, 云库汽车收银软件, 杭州交赞科技有限公司, 汽车修理厂解决方案, 库存管理软件</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css?v=2" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="qc:admins" content="1443161027622123326375731765060454" />
<meta name="keywords" content="汽车维修软件, 汽车美容软件, 汽车收银软件, 好用的汽车维修软件, 简单实用的汽车维修软件, 杭州交赞科技有限公司, 云库科技, 微信对接, 微信运营, 汽车修理厂解决方案, 库存管理软件" />
<meta name="Description" content="杭州交赞科技有限公司是一家致力于提供汽车后市场解决方案的一家专业企业, www.hzuber.com,提供好用的汽车维修软件,简单实用的汽车维修软件,汽车维修软件,汽车美容软件,汽车收银软件, 提供汽车解决方案,库存管理" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, 
false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--webfont-->
<!-- <link href='http://fonts.useso.com/css?family=Source+Sans+Pro:200,300,400,600,700,900' rel='stylesheet' type='text/css'> -->
	<!--
    	作者：1003316758@qq.com
    	时间：2016-01-27
    	描述：字体设置
    -->
<!-- <link href='http://fonts.useso.com/css?family=Raleway:400,800,300,100,500,700,600,900' rel='stylesheet' type='text/css'> -->
	<!--
    	作者：1003316758@qq.com
    	时间：2016-01-27
    	描述：字体设置
    -->
<!--animated-css-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
	<link rel="icon" href="images/favicon.ico" type="images/x-icon" id="page_favicon" />
<script src="js/wow.min.js"></script>
<script src="../zdcar2/js/js.js"></script>
<script>
 new WOW().init();
</script>
<!--/animated-css-->
<!--script-->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<!--/script-->
<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
<style type="text/css">
	.qq{
		margin-top: 25%;
		position:fixed;
		right: 1px;
		z-index: 1000;
	}
	.fuck
	{
		width: 100px;
		height: 100px;
		
	}
</style>
<meta name="baidu_union_verify" content="9c9aba5b773637bd96083d09b90cf180">
</head>
<body>
<!---->
<div class="qq">
		<img src="images/yunku.jpg" class="fuck" alt="云库二维码">
		<br>

	<a target="_blank" href="http://sighttp.qq.com/authd?IDKEY=4101f9072c9096dace68048c5551fadad07315d5e5033681"><img border="0" src="http://wpa.qq.com/imgd?IDKEY=4101f9072c9096dace68048c5551fadad07315d5e5033681&pic=51" alt="点击这里给我发消息" title="点击这里给我发消息"></a>
	<br>	<br>	
	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1003316758&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:1003316758:51" alt="点我咨询哦" title="点我咨询哦"/></a>
</div>
<div class="banner">
	 <div class="container">
		 <div class="header">	 
		 	 <div class="logo wow fadeInLeft" data-wow-delay="0.5s">
			 <a href="index.php"><img src="images/3347542_161350276000_2.png" alt="点击此处可登陆哦"/></a>
			 </div>	
			 <div class="top-menu">
				 <span class="menu"></span> 
				 <ul>
					 <li><a class="scroll" href="#home">主页</a></li>
					 <li><a class="scroll" href="#brief">摘要</a></li>
					 <li><a class="scroll" href="#features">产品特点</a></li>
					 <li><a class="scroll" href="#pricing">产品入手</a></li>
					 <li><a class="scroll" href="#screenshots">展示</a></li>
					 <!-- <li><a class="scroll" href="#contact">联系我们</a></li> 
					 <li><?php echo $info; ?></li>-->
				 </ul>
			 </div>
			 <div class="clearfix"></div>
			 <!-- script-for-menu -->
		 <script>					
					$("span.menu").click(function(){
						$(".top-menu ul").slideToggle("slow" , function(){
						});
					});
		 </script>
		 <!-- script-for-menu -->			 
		 </div>
		 </div>	
		 <div class="banner-text wow fadeInUp" data-wow-delay="0.5s">
			 <h1>为你得到最好的 <span>解决方案</span> <label></label></h1>
			 <h2>你最好的汽车服务管家</h2>
		 </div>
		 <div class="banner-form">
			 <form method="post">
				 <input class="wow fadeInRight" data-wow-delay="0.5s" type="text" onfocus="this.style.borderColor='#0199e6'" placeholder="公司名称" id="companyName" id="cp"/>
				 <input class="wow fadeInRight" data-wow-delay="0.5s" type="text" onfocus="this.style.borderColor='#0199e6'" placeholder="姓名" id="kehuName"/>
				 <input class="wow fadeInLeft" data-wow-delay="0.5s" type="text"  onfocus="this.style.borderColor='#0199e6'" placeholder="电话" id="Phone"/>
				 <input class="wow fadeInLeft submitButton" data-wow-delay="0.5s" type="button"  onclick="submitKehuInfo()" value="我要使用"/>
			 </form>
			 <script>
				function submitKehuInfo(){
					var companyName=document.getElementById("companyName");
					var kehuName=document.getElementById("kehuName");
					var Phone=document.getElementById("Phone");
					if(companyName.value!=""&&kehuName.value!=""&&Phone.value.length==11){
						a=INSERT("kehu_collect",{companyName:companyName.value,name:kehuName.value,phone:Phone.value,date:DATE()},true)
						if(a.state){
							alert("信息提交成功 我们将会联系您，请您保持电话畅通");
						}
					}else{
						if(companyName.value=="")companyName.style.borderColor="red";
						if(kehuName.value=="")kehuName.style.borderColor="red";
						if(Phone.value.length!=11)Phone.style.borderColor="red";
					}
				}
			 
			 
			 </script>
			 <div class="register">
			 <span></span>	 
			 <h3 class="wow bounceInRight" data-wow-delay="0.5s">现在注册并获得使用</h3>		 
		     </div>	
			 <div class="clearfix"></div>
		 </div>		 
	 </div>
</div>
<!---->
<div id="brief" class="brief">
	 <div class="container">
		 <div class="col-md-6 brief-grids wow fadeInLeft" data-wow-delay="0.5s">
			 <img src="images/browse.jpg" alt=""/>
			 <div class="brief-grid">
				 <div class="brief-grid-text">
					 <h3>探索精彩</h3>
					 <p>云库五位一体系统，专为中小型汽修厂准备。</p>
				 </div>
				 <div class="brief-grid-content1">
					 <h3>会员升级</h3>
					 <p>为每一位建立档案，让会员掌上实时查看自己消费动态。</p>
				 </div>
				 <div class="brief-grid-content2">
					 <h3>微信助手</h3>
					 <p>微信端查看企业明细，做到“足不出户，静观企业事”。</p>
				 </div>
			 </div>
		 </div>
		 <div class="col-md-6 brief-grids wow fadeInRight" data-wow-delay="0.5s">
			 <img src="images/browse2.jpg" alt=""/>
			 <div class="brief-grid">
				 <div class="brief-grid-text">
					 <h3>了解更多产品</h3>
					 <br>
					 <p>敬请期待.</p>
				 </div>
				 <div class="brief-grid-content1 good">
					 <h3>追求完美</h3>
					 <p>您的满意，是我们的最大动力.</p>
				 </div>
				 <div class="brief-grid-content2 video-bac">
					 <h3>微信公众号</h3>
					 <p>yunkukj</p>
				 </div>
			 </div>
		 </div>
		 <div class="clearfix"></div>		 
	 </div>
</div>
<!---->
<div id="features" class="features">
	 <div class="container">
		 <div class="feature-text text-center">
			 <h3>特性</h3>
			 <p>云库的产品特性.</p>
		 </div>
		 <div class="features-section">
			 <div class="col-md-6 feature-grid text-center">
			 <i class="f1 wow bounceIn" data-wow-delay="0.5s"></i>
			  <h3>得力助手</h3>
			 <p>无论您身在何处，只要打开微信，企业的运营动态就会出现在你的眼前。云库通过折线图，统计图，表格等形式让您能一目了然的知道企业当天营销额度、项目详细收入以及月总收入。您可以根据需要随时随地的调整或修改运营记录，做到“足不出户，静观企业事”。</p>
			 </div>
			 <div class="col-md-6 feature-grid text-center">
			 <i class="f2 wow bounceIn" data-wow-delay="0.5s"></i>
			 <h3>会员升级</h3>
			 <p>云库改变过去会员系统与维修系统不相通的弊端，将会员系统与维修系统合二为一。云库回味每一位维修客户建立档案成为普通会员，会员可以通过充值消费不断提高会员等级，享受更多的服务和优惠。云库将会详细的保存会员车辆的维修情况，消费记录，让会员的车辆信息能够一目了然，提高企业工作效率，增加客户粘度。</p>
			 </div>
			 <div class="clearfix"></div>
			 <div class="col-md-6 feature-grid text-center">
			 <i class="f3 wow bounceIn" data-wow-delay="0.5s"></i>
			 <h3>云库微营</h3>
			 <p>企业可以通过云库及时的给客户推送新的服务项目，并且在第一时间将近期的优惠活动与客户分享，增加了企业与客户之间的互动，让消费者及时浏览企业的最新消息，根据自己的需求选择消费，更便捷的深入到消费者群体中，挖掘潜在意向客户并吸引更多的消费者。</p>
			 </div>
			 <div class="col-md-6 feature-grid text-center">
			 <i class="f4 wow bounceIn" data-wow-delay="0.5s"></i>
			 <h3>配件流通</h3>
			 <p>云库将会为您周期性检查配件库存。如果有长期未消化的配件，云库将会发出预警，您可以利用云库商城出售富余配件，减少配件闲置带来的损失；同时当库存不足时，云库也会发出预警，这时您可以通过云库商城低价淘得所需配件，减少配件购置成本。</p>
			 </div>
		 </div>
	 </div>
</div>
<!---->
<div id="pricing" class="pricing">
	 <div class="container">
		 <div class="pricing-text text-center">
			 <h3>价格和计划</h3>
			<!--  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
		 </div>
		 <div class="pricing-section">
			 <div class="col-md-4 pricing-grid wow fadeInUp" data-wow-delay="0.5s">
				 <div class="pricing-top text-center">
					 <h3>基础版</h3>
					 <p><span>498</span>一年，<span>1980</span>终生</p>
				 </div>
				 <div class="pricing-offer">
					 <ul>
						<li class="whyt"><a href="#">掌上企业</a></li>
						<li class="whyt"><a href="#">会员升级</a></li>
						<li class="whyt"><a href="#">云库微营</a></li>
						<li class="whyt"><a href="#">技术共享</a></li>
						<li class="whyt"><a href="#">配件共享</a></li>
				     </ul>
					 <div class="sign text-center">
						 <a href="#">入手</a>
					 </div>
				 </div>
			 </div>

			 <div class="col-md-4 pricing-grid wow fadeInDown" data-wow-delay="0.5s">
				 <div class="pricing-top text-center">
					 <h3>商务版</h3>
					 <p>只要 <span>1980</span>一年</p>
				 </div>
				 <div class="pricing-offer">
					 <ul>
						<li class="whyt"><a href="#">掌上企业</a></li>
						<li class="whyt"><a href="#">会员升级</a></li>
						<li class="whyt"><a href="#">云库微营</a></li>
						<li class="whyt"><a href="#">技术共享</a></li>
						<li class="whyt"><a href="#">配件共享</a></li>
						<li class="whyt"><a href="#">微官网</a></li>
						<li class="whyt"><a href="#">后续技术支持</a></li>
				     </ul>
					 <div class="sign text-center">
						 <a href="#">入手</a>
					 </div>
				 </div>
			 </div>
			 <div class="col-md-4 pricing-grid wow fadeInUp" data-wow-delay="0.5s">
				 <div class="pricing-top text-center">
					 <h3>旗舰版</h3>
					 <p><span>请咨询客服</span></p>
				 </div>
				 <div class="pricing-offer">
					 <ul>
						<li class="whyt"><a href="#">掌上企业</a></li>
						<li class="whyt"><a href="#">会员升级</a></li>
						<li class="whyt"><a href="#">云库微营</a></li>
						<li class="whyt"><a href="#">技术共享</a></li>
						<li class="whyt"><a href="#">配件共享</a></li>
						<li class="whyt"><a href="#">微官网</a></li>
						<li class="whyt"><a href="#">技术共享</a></li>
						<li class="whyt"><a href="#">后续技术支持</a></li>
				     </ul>
					 <div class="sign text-center">
						 <a href="#">入手</a>
					 </div>
				 </div>
			 </div>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>
<!---->
<!--<div class="video">
	 <div class="container">
		 <div class="video-text text-center">
			 <h3>观看视频</h3>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
		 </div>
		 <div class="video-play ">
			 <div class="playing">				
				 
			 </div>
			 <h4 class="wow fadeInLeft" data-wow-delay="0.5s"><a href="#" class="p1">Trusted by 100+ users</a></h4>
			 <h4 class="wow fadeInUp" data-wow-delay="0.5s"><a href="#" class="p2">Video Documentation</a></h4>
			 <h4 class="wow fadeInRight" data-wow-delay="0.5s"><a href="#" class="p3">24/7 Chat Support</a></h4>			 
		 </div>
	 </div>
</div>-->
<!---->
<div id="screenshots" class="screenshots">
	 <div class="container">
		 <div class="screen-text text-center">
			 <h3>图片展示</h3>
			<p>一些产品介绍.</p>
		 </div>
		 <!-- requried-jsfiles-for owl -->
				<link href="css/owl.carousel.css" rel="stylesheet">
							    <script src="js/owl.carousel.js"></script>
							        <script>
							    $(document).ready(function() {
							      $("#owl-demo").owlCarousel({
							        items : 1,
							        lazyLoad : true,
							        autoPlay : true,
							        navigation : false,
							        navigationText :  false,
							        pagination : true,
							      });
							    });
							    </script>
			<!-- //requried-jsfiles-for owl -->
		  <div id="owl-demo" class="owl-carousel">
			  <div class="item text-center guide-sliders">
				 <div class="col-md-4 image-grid">
					 <img src="images/sc1.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc2.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc3.JPG">					 
				 </div>				   
			  </div>			  
			  <div class="item text-center guide-sliders">
				 <div class="col-md-4 image-grid">
					 <img src="images/sc4.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc5.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc1.JPG">					 
				 </div>						
			  </div>
			  <div class="item text-center guide-sliders">
				 <div class="col-md-4 image-grid">
					 <img src="images/sc5.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc4.JPG">					 
				 </div>
				 <div class="col-md-4 image-grid">
					 <img src="images/sc2.JPG">					 
				 </div>						
			  </div>
			  
		  </div>
	 </div>
</div>
<!---->
<!-- <div id="testimonial" class="trusted">
	 <div class="container">
		 <div class="trusted-text text-center">
			 <h3>我们有成千上万的信任</h3>
			<!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
		<!--  </div>
		 <div class="sponcer">
			 <ul id="flexiselDemo1">
				<li>
					<div class="biseller-column">
					<img src="images/sld1.png" alt="">
					</div>
				</li> -->
				<!-- <li>
					<div class="biseller-column">
					<img src="images/sld2.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld3.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld4.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld1.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld3.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld4.png" alt="">
					</div>
				</li>
				<li>
					<div class="biseller-column">
					<img src="images/sld2.png" alt="">
					</div>
				</li>
			 </ul> -->
			 <script type="text/javascript">
			 $(window).load(function() {
				$("#flexiselDemo1").flexisel({
					visibleItems: 4,
					animationSpeed: 1000,
					autoPlay: true,
					autoPlaySpeed: 3000,    		
					pauseOnHover: true,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:480,
							visibleItems: 1
						}, 
						landscape: { 
							changePoint:640,
							visibleItems: 2
						},
						tablet: { 
							changePoint:768,
							visibleItems: 3
						}
					}
				});
				
			 });
			   </script>
			   <script type="text/javascript" src="js/jquery.flexisel.js"></script>	
	     </div>
		<!--   <div class="box-grids">
				 <div class="col-md-4 client wow fadeInLeft" data-wow-delay="0.5s">
					 <div class="box-grid">
					 <span></span>
					 <p>Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement A/B testing shrink a market venture capital pitch deck. 
					 Social bookmarking group buying crowded market pivot onboarding.</p>
					 <label></label>
					 </div>
					 <h4><a href="#">Market Diaz</a></h4>
					 <p class="ceo">Abz Network</p>
				 </div>
				 <div class="col-md-4 client wow fadeInUp" data-wow-delay="0.5s">
					 <div class="box-grid">
					 <span></span>
					 <p>Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement A/B testing shrink a market venture capital pitch deck. 
					 Social bookmarking group buying crowded market pivot onboarding.</p>
					 <label></label>
					 </div>
					 <h4><a href="#">Market Diaz</a></h4>
					 <p class="ceo">Abz Network</p>
				 </div>
				 <div class="col-md-4 client wow fadeInRight" data-wow-delay="0.5s">
					 <div class="box-grid">
					 <span></span>
					 <p>Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement A/B testing shrink a market venture capital pitch deck. 
					 Social bookmarking group buying crowded market pivot onboarding.</p>
					 <label></label>
					 </div>	
						<h4><a href="#">Market Diaz</a></h4>
					 <p class="ceo">Abz Network</p>
				 </div>
				 <div class="clearfix"></div>
		  </div> -->
	</div>
</div>
<!---->
<div class="get-started">
	 <div class="container">
		 <h4 class="wow bounceInLeft" data-wow-delay="0.5s"></h4>
		 <h3 class="wow bounceInRight" data-wow-delay="0.5s">为你的企业提供最好的解决方案</h3>
		 <h4 class="wow bounceInLeft" data-wow-delay="0.5s">联系电话:0571-88184006</h4>
		 <a href="#">让我们开始</a>
	 </div>
</div>
<!---->

<!---->
<div class="footer">
	 <div class="container">
		 <div class="ftr-logo">
			 <a class="wow bounceIn" data-wow-delay="0.5s" href="index.php"><img src="images/logo2.png" alt=""/></a>
		 </div>
		 <div class="copy-right wow bounceInUp" data-wow-delay="0.5s">
			 <p>Copyright © 杭州交赞科技有限公司 All Rights Reserved. 浙ICP备15038930号-3</p>
			 <div style="width:300px;margin:0 auto; padding:20px 0;">
		 		<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=33010302002430" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;"><img src="images/beian.png"></img>浙公网安备 33010302002430号</p></a>
		 	</div>
		 </div>

	 </div>
</div>
<!---->
<script type="text/javascript">
		$(document).ready(function() {
				/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
				*/
		$().UItoTop({ easingType: 'easeOutQuart' });
});
</script>
<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!----> 
		 	

 </body>
 </html>