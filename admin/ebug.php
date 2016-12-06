<!DOCTYPE html>
<?php 
	ini_set('display_errors','On');
	require_once '../lib/fun.php';
 ?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BUG详情</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="../zdcar2/js/jquery-1.10.2.js"></script>
        <script src="../zdcar2/js/js.js?v=<?php echo time();?>"></script>
		<!-- bt框架-->
		<script src="../zdcar2/js/bootstrap.min.js"></script>
		<link href="../zdcar2/css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		<style>
			.title{
				height:85px;
				width:100%;
				text-align:center;
				margin:25px 0px;
				padding-left:37%;
			}
			.h1{
				font-size:30px;
				width:100px;
				height:50px;
				margin:0px;
				float:left;
				padding-top:5px;
			}
			.status span{
				margin:5px 2.5%;
			}
			.one{
				width:100%;
				height:auto;
				background:#fff; 
				color:#444;
				margin-left:20px;
				
			}
			.otitle{
				cursor:pointer;	
			}
			#body{
				text-align:center;
				margin:0px;
				padding:0px;
			}
			.body{
				width:100%;
				background:#f1f1f1;
				height:auto;
				line-height:auto;
				float:left;

				-moz-border-radius: 15px;
				-webkit-border-radius: 15px;
				-webkit-box-pack:center; 
				-moz-box-pack:center; 
				-webkit-box-align:center; 
				-moz-box-align:center; 
				cursor:pointer;
				box-shadow: 10px 10px 5px #888888;
				
			}
			.oneline:hover{
				width:98%;
				background:#ddd;
				height:auto;
				line-height:auto;
				float:left;
				padding:8px;
				-moz-border-radius: 15px;
				-webkit-border-radius: 15px;
				-webkit-box-pack:center; 
				-moz-box-pack:center; 
				-webkit-box-align:center; 
				-moz-box-align:center;
				
			}
			.onecol{
				float:left;
				margin:0px 10px;
				margin-right:40px;
				overflow:hidden;   
			}
			.xhbox{
				 float:left;
				 width:85px;
				 height:85px;
				 border-radius:160px;
				 padding:0px;
				 margin:10px;
				 
			}
			.xuhao{
				height:85px;
				 padding:0px;
				display:block; 
				color:#FFF; 
				text-align:center;
				margin:20% 20%;
				font-size:40px;
			}
			.xhbox2{
				 width:20px;
				 height:20px;
				 background-color:#555; 
				 border-radius:25px;
				 padding:0px;
				 margin:10px;
			}
			.xhbox2:hover{
				 width:20px;
				 height:20px;
				 background-color:#ed4a4b; 
				 border-radius:25px;
				 padding:0px;
				 margin:10px;
			}
			.xh2{
				height:20px;
				 padding:0px;
				display:block; 
				color:#FFF; 
				text-align:center;
				margin:20% 20%;
				font-size:8px;
			}
			.xftrue{
				background:#75c758;
			}
			.xffalse{
				background:#bc2f2e;
			}
			.otitle{
				float:left;
			}
			.leftfo{
				float:none;
			}
			.center{
				text-align:center;
			}
			.yuanjiao{
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				width:90%;
				height:120px;
				margin:20px 0px; 
				background:#000;
				padding:20px;
				text-size:28px;
				color:#fff;
				
			}
			.hide{
				display:none;
			}
			.xl{
				border:0px;
				width:80px;
				background:#f1f1f1;
			}
			.hover{
				background:#828a7f;
			}
			.datetime{
				border:0px;
				background:rgba(255, 255, 255, 0);
			}
		
		</style>
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
	</head>
	<body onload="" id="body">
		<div class="body">
		<?php
			$bid=isset($_GET["bid"])?$_GET["bid"]:0;
			$bug=SELECT("bug","*","id=$bid");
			$state=$bug[0]["state"]?"xftrue":"xffalse";
			//print_r($bug);
		?>
			
			<div class="title">
					<div class='h1'></div>
					<div class='xhbox onecol <?php echo $state;?>' id="BUGID" onclick="" onmouseover="hover(this,1)" onmouseout="hover(this,0)" >
						<span class='xuhao' onclick="to('bug.php?bid=<?php echo $bug[0]["id"];?>')"><?php echo $bug[0]["id"];?></span>
					</div>
					
			</div>
			<div class='status'>
			   <span><b>创建时间:</b><?php echo $bug[0]["date"];?> </span>
			   <?php 
				$datetime=date('Y-m-d\TH:i:s',strtotime($bug[0]["edate"]));
				?>
			   <span><b>完成时间:</b><span id="edate"><input id="edatetime" class='datetime' type='datetime-local' value="<?php echo $datetime; ?>"/></span></span>
			   <span>
					<b>BUG类型:</b>
					<select class='xl' id="type" onchange="updateBugInfo(this)">
						<?php
							if($bug[0]["type"]=="程序漏洞"){
								echo "<option value='程序漏洞' selected>程序漏洞</option>
									  <option value='功能完善'>功能完善</option>
									  <option value='其它'>其它</option>";
							}else if($bug[0]["type"]=="功能完善"){
								echo " <option value='功能完善'>功能完善</option>
									   <option value='程序漏洞'>程序漏洞</option>
									   <option value='其它'>其它</option> ";
							}else{
								echo " <option value='其它'>其它</option>
									   <option value='功能完善'>功能完善</option>
									   <option value='程序漏洞'>程序漏洞</option> ";
							}
						?>
					</select>
			   </span>
			   <span>
					 <b>修复状态:</b>
					 <select class='xl' id="state" onchange="updateBugInfo(this)">
						<?php
							if($bug[0]["state"]){
								echo "<option value='1'>已修复</option>
									  <option value='0'>未修复</option>";
							}else{
								echo "<option value='0'>未修复</option>
									  <option value='1'>已修复</option>";
							}
						?>
					</select>
				</span>
			</div>
			<textarea class='yuanjiao' id="info" onchange="updateBugInfo(this)" style="height:250px;" ><?php echo $bug[0]["info"];?></textarea>
			<textarea class='yuanjiao' id="tips" onchange="updateBugInfo(this)" style="margin:0px 0px 50px 0%;height:150px;"><?php echo $bug[0]["tips"];?></textarea>
			
		</div>
			
	</body>
	<script>
	BUGID=document.getElementById("BUGID");
		function updateBugInfo(e){
			bid=<?php echo $bid;?>;
			var COL=e.id;
			var VAL=e.value;
			if(COL=="state"){
				
				if(VAL=='1'){
					BUGID.className="xhbox onecol xftrue";
				
					document.getElementById("edate").innerHTML=DATE("T"); 
					UPDATE("bug","edate",DATE(),"id="+bid);
				}else if(VAL=='0'){
					BUGID.className="xhbox onecol xffalse";   
					document.getElementById("edatetime").value="0000-00-00T00:00:00";  
					UPDATE("bug","edate",null,"id="+bid); 
				}
			}
			
			UPDATE("bug",COL,VAL,"id="+bid,true);
		}
		function hover(e,s){
			if(s){
				e.class="xhbox onecol hover";
			}else{
				e.class="xhbox onecol xftrue";
			}
			
		}
		
	</script>

</html>