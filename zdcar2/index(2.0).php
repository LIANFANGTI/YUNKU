<!DOCTYPE html>
<?php require_once 'function.php'; ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>云库汽车管理系统</title>
    <style>
    body{
      margin: 0;
      padding: 0;
    }
    .container-fluid{
      margin-top:-20px;
    }
    ul>li>img{
      width:100px;
      height: 100px;
      margin-top: -35px;
    }

    li{
      float:left;
      list-style: none;
      margin-left: 40px;
      margin-top: 15px;
      height: 30px;
      width: 70px;
    }
    li:first-child{
      margin-left: -30px;
      margin-right: 50px;
    }
    li:nth-child(6),li:nth-child(7),li:nth-child(8){
      float: right;
    }
    li:nth-child(7){
      margin-left: -20px;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    li:nth-child(6) img{
      width:30px;
      height: 30px;
      margin-top: -5px;
    }
    li>i{
      color:white;
      margin-top: -5px;
    }
    li>a{
      color: white;
      font-size: 14px;
      font-family: "微软雅黑";
      padding-bottom:5px;
    }
    li>a:hover{
      color:white;
      text-decoration:none;

      border-bottom:2px solid white;

    }
    li>a:visited{
      color:white;
    }

    .navbg{
      width: 100%;
      height: 50px;
      color: #74c9b9;
      background-color:#74c9b9;
    }
    .row>img{
      float: right;
      width:100px;
      height:100px;
      display: none;
    }
    ul li>ul li{
      width: 80px;
      height: 30px;
      border: 1px solid red;
    }
	#main #window{
		width:100%;
		height:1000px;
		border:0px;
		margin:0px;
		padding-top:20px;
	}


    </style>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.2/css/bootstrap.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style='zoom: 1;'>
    <div class="container-fluid">
      <div class="row">
        <div class="navbg">
            <ul>
				<li><img src="img/logo.png" alt="logo" /></li>
				<li><a href="1-1a.php" target="window">开单</a></li>
				<li><a href="shouyin.php" target="window">工作台</a></li>
				<li><a href="3-1.php?" target="window">仓库</a></li>
				<li><a href="5-1.php" target="window">统计</a></li> 
				<li id="erweima"><a href="#"><img src="img/erweima.png"  alt="云库公众号" /></a></li>
				<li><a href="../yunku/logout.php" title="<?php echo ($username);?>"><?php echo $cpname; ?></a> 
				</li>
				<li><i class="fa fa-user fa-2x"></i></li> 
				<?php if($USERMODE=="admin")echo"<li><a href='./admin/index.php' target='window'>管理</a></li>"; ?>  
			</ul> 
        </div>
          <img src="img/yunku.jpg" id="yunkuerweima" alt="云库二维码" />
      </div>
	  <?php 
		
		
	  ?> 
		<div id="main">
		<iframe id="window" name="window" src="shouyin.php">
			<!--框架内容-->
		</iframe>

		</div>
	
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $("#erweima").mouseover(function(){
        $("#yunkuerweima").css("display","block");
      });
      $("#erweima").mouseout(function(){
        $("#yunkuerweima").css("display","none");
      });
    </script>


  </body>
</html>
