<!DOCTYPE html>
<?php 
	ini_set('display_errors','On');
	require_once '../lib/fun.php';
	$BUG=SELECT("bug","count(1)c","1");$total=$BUG[0]["c"];
	$BUG=SELECT("bug","count(1)c","state");$ywc=$BUG[0]["c"];
	$percent=round(($ywc/$total*100),1)."%";
//	Ali();
	//$percent=round(($ywc/$total)*100,2)*100)."%";
	
	// print_r(aliRobot("你好啊")->result->content);
	//echo $A->result->$content;
	//print_r(aliRobot("浙江天气"));
	
 ?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>BUG管理-<?php echo $percent;?></title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="../zdcar2/js/jquery-1.10.2.js"></script>
        <script src="../zdcar2/js/js.js?v=15"></script>
		<!-- bt框架-->
		<script src="../zdcar2/js/bootstrap.min.js"></script>
		<link href="../zdcar2/css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		<style>
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
			.oneline{
				width:98%;
				background:#eee;
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
				cursor:pointer;
				margin:3px; auto;
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
				 width:40px;
				 height:40px;
				 border-radius:25px;
				 padding:0px;
				 margin-buttom:
				 
			}
			.xuhao{
				height:40px;
				 padding:0px;
				display:block; 
				color:#FFF; 
				text-align:center;
				margin:20% 20%;
				font-size:18px;
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
				 padding-top:10%;
				display:block; 
				color:#FFF; 
				text-align:center;
				margin:0px;
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
			body{
				padding-bottom:50px;
			}
			#seachInput{
				background:#FFF;
			}
			.oneline span {
				float: left;
			}
			#bugBox {
				width: 100%;
				height:500px;
				border:0px;
			}
			
		
		</style>
		
	</head>
	<body onload="" id="body">
	<?php 

	//echo "[atype]".json_decode(Robot("你好")).text."[/atype]";
		if(isset($_GET["MOD"])){
			switch($_GET["MOD"]){
				case "edit":
					$mode1="blcok";
					$mode2="none";
				break;
				case"show":
					$mode2="blcok";
					$mode1="none";
				break;
				default:
					$mode2="blcok";
					$mode1="none";
				break;
			}
		}else{
			$mode2="blcok";
			$mode1="none";
		}
		$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	?>
	<input type="text" class="form-control  oneline" id="seachInput"  value="<?php echo $keyWord;?>" onkeyup="Seach(this.value)" placeholder="当前模式:搜索模式   输入关键字进行查询  输入添加/add 进入添加模式"/>
	<div id="board" style="display:<?php echo $mode2; ?>;position:relative;width:100%;min-height:100%; "> 
		<div class='oneline center' onclick=" $('#obodylog').fadeToggle(500)" id='state".$dcount."'>展开/收起修复记录</div>
			<div id="obodylog" style="display:none;">
			<?php
			$BugNear=SELECT("bug","*","1 order by edate desc");   //修复记录
			foreach($BugNear as $row){
				echo "<div class='oneline' style='margin-left:20px;padding-left:20px;' onclick='info2(".$row["id"].")'>
						<span><b>练方梯于</b></span>
						<span>".$row["edate"]."修复了</span>
						<span class='xhbox2 onecol xffalse' style='margin:0px;'><b class='xh2'>".$row["id"]."</b></span>
						<span>号"."BUG:".mb_substr($row["info"],0,70,"utf-8")."...</span>
					</div>";
					}
				echo "</div>";
					$CONDITION="(info LIKE '%$keyWord%' OR tips LIKE '%$keyWord%' OR type='$keyWord' )";
					$bugListDate=SELECT("bug","DATE_FORMAT(date, '%Y-%m-%d') dateo"," $CONDITION GROUP BY dateo  ORDER BY date desc,state");
					$allBug=SELECT("bug","id,DATE_FORMAT(date, '%Y-%m-%d') dateo"," $CONDITION "); 
					
					$zbcount=$zyxf=$dcount=$ZBCOUNT=$ZGCOUNT=0;
					$bid=isset($_GET["bid"])?$_GET["bid"]:0;
				if($keyWord==""){
					foreach($bugListDate as $row){
						$bugInfos=SELECT("bug","id,info,date,state,DATE_FORMAT(date,'%h:%m:%s')time","DATE_FORMAT(date, '%Y-%m-%d')='".$row["dateo"]."'ORDER BY state,date desc");
						$dis="none";
						foreach($bugInfos as $a){
							if($a["id"]==$bid){
								$dis="block";
							}
						}
						echo "<div class='one' >";
							echo "<div class='otitle' >
									<h1>".$row["dateo"]."</h1>
								  </div>  ";
							echo "<div class='oneline center' onclick='hide(".++$dcount.",0)' id='state".$dcount."'>展开</div>"; 
							
							echo "<div id='obody".$dcount."' style='display:$dis ;'>";
								$bugInfos=SELECT("bug","id,info,date,type,state,DATE_FORMAT(date,'%h:%m:%s')time","DATE_FORMAT(date, '%Y-%m-%d')='".$row["dateo"]."'ORDER BY state,date desc");
								$dyxf=$count=$BCOUNT=$GCOUNT=0;
								//print_r($bugInfos); 
								foreach($bugInfos as $row1){
									$dcount++;
									$state=$row1["state"]?"xftrue":"xffalse";
									if($row1["state"]){$dyxf++;}//当天已修复统计
									if($row1["type"]=="功能完善"){
										$GCOUNT++;
									}else{
										$BCOUNT++;
									}
									++$count;
									echo "<div name='bug".$row1["id"]."' class='oneline' id='line".$row1["id"]."' onclick='info(".$row1["id"].")' title='".$row1["type"]."'>
											 <div class='xhbox onecol $state' ><span class='xuhao'>".$row1["id"]."</span></div>
											 <div class='onecol'><h4>"."【".$row1["type"]."】".$row1["info"]."...<h4></div>
											 <div class='xhbox2 onecol ' style='float:right;z-index:999;' onclick='hide(".$row1["id"].",1)'><h4 class='xh2'>X</h4></div>
											 <div class='onecol' style='float:right;' ><h4>".$row1["time"]."</h4></div>
										  </div>";
								}
								$zbcount+=$count;
								$zyxf+=$dyxf;
								$ZGCOUNT+=$GCOUNT;
								$ZBCOUNT+=$BCOUNT;
								
								echo"</div>"; 
							    echo "<div class='oneline center' >共<b> $count </b>个Bug<b style='color:#75c758;'> $dyxf </b>个已修复<b style='color:#bc2f2e;'> ".($count-$dyxf)." </b>个未修复,$GCOUNT 个功能改进 $BCOUNT 个程序漏洞<b></b></div>";
							
						echo "</div>";
					}
					$BugjdInfo= "共$zbcount 个Bug $zyxf 个已修复".($zbcount-$zyxf)." 个 未修复,$ZGCOUNT 个功能改进 $ZBCOUNT 个程序漏洞"; 
					
				}else{ //搜索模式下显示的数据
					$bugInfos=SELECT("bug","id,info,date,type,state,DATE_FORMAT(date,'%h:%m:%s')time","$CONDITION ORDER BY state,date desc");
					$count=0;
					if(!empty($bugInfos)){
						foreach($bugInfos as $row1){
							
							$state=$row1["state"]?"xftrue":"xffalse";   
							echo "<div name='bug".$row1["id"]."' class='oneline' id='line".$row1["id"]."' onclick='info(".$row1["id"].")' title='".$row1["type"]."'>
									 <div class='xhbox onecol $state' ><span class='xuhao'>".$row1["id"]."</span></div> 
									 <div class='onecol'><h4>".$row1["info"]."...<h4></div>
									 <div class='xhbox2 onecol ' style='float:right;z-index:999;' onclick='hide(".$row1["id"].",1,this,event)'><h4 class='xh2'>X</h4></div>
									 <div class='onecol' style='float:right;' ><h4>".$row1["time"]."</h4></div>
								 </div>"; 
							
						}
					}else{
						echo "<div class='oneline center' id='Msgbox'>暂无匹配数据哦:)</div>"; 
					}
				}
				?>
				
				<div class="progress progress-striped active" style="width:96%; margin-left:2%;height:25px;position:fixed;bottom:0px;left:0px; ">
					<div  class="progress-bar progress-bar-success"   title="<?php echo $BugjdInfo;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent;?>;cursor:pointer;">
						<span class="sr-only"></span>
						<?php
							echo "($ywc/$total)".$percent;
						?>
					</div>
				</div>
			</div>
			<div id="newBugBoard">
				<!--<div name='' class='oneline' id='' onclick='info()' title=''>
					<div class='xhbox onecol xffalse' ><span class='xuhao'>1</span></div>
					<div class='onecol'><h4>This Is Bug Information Click Me Check More<h4></div>
					<div class='xhbox2 onecol ' style='float:right;z-index:999;' onclick='hide()'><h4 class='xh2'>X</h4></div>
					<div class='onecol' style='float:right;' ><h4>2016-11-25 21:20</h4></div>
				</div>-->
			</div>
			<div class="oneline center" id="Msgbox1"></div>
		
			
	</body>
	<script>
		addBugCount=0;
		seachInput=document.getElementById("seachInput");
		Msgbox=document.getElementById("Msgbox1");
		Board=document.getElementById("board");
		seachInput.focus();seachInput.select();//获取焦点并且选中文本;
		function Seach(value){
			printr(event.keyCode);
			MOD=document.title;
			if(event.keyCode==13){
				switch(MOD){
					case "添加":
						save(value);
					break;
					default:
						switch(value){
							case "add":
								$("#board").fadeToggle(500);
								document.title="添加";
								seachInput.value="";
								Msgbox.innerHTML="请输入Bug信息 按回车保存 按Esc退出";
							break;
							default:
								to("bug.php?keyWord="+value);
							break;
						}
					break;
				}	
			}else if(event.keyCode==27){ 				 //ESC事件
				switch(MOD){
					case"添加":          				//添加模式下的ESC事件
						$("#board").fadeToggle(500);
						document.title="BugList";
						seachInput.value="";
					break;
					default:
					
					break;
					
				}
			}
		}
		
		function addOneLine(Id,Info,Time){
			var content="<div name='' class='oneline' id='' onclick='info("+Id+")' title=''>"+
					"<div class='xhbox onecol xffalse' ><span class='xuhao'>"+Id+"</span></div>"+
					"<div class='onecol'><h4>"+Info+"<h4></div>"+
					"<div class='xhbox2 onecol ' style='float:right;z-index:999;' onclick='hide()'><h4 class='xh2'>X</h4></div>"+
					"<div class='onecol' style='float:right;' ><h4>"+Time+"</h4></div>"+
				"</div>";
				newBugBoard=document.getElementById("newBugBoard");
			    newBugBoard.innerHTML=content+newBugBoard.innerHTML;
		}
		
		function info(id){
			to("ebug.php?bid="+id);
		}

		 function hide(id,m,ob,ev){
			 /*消除冒泡事件阻止父元素响应子元素事件*/
			 var e=(ev)?evt:window.event;
			 if (window.event)e.cancelBubble=true; else e.stopPropagation(); 
			 o=m?"line":"obody";
			 if(document.all) { 
					//event.cancelBubble = true;
			 }
			/// alert("操作对象:#"+o+id+"模式:"+m)
			 if(m){
				 if(DELBUG(id)){
					 $("#"+o+id).fadeToggle(500); 
				 }
			 }else{
				
				  state=$("#state"+id+"").html()
				  if(state=="展开"){
					   document.getElementById("state"+id).innerHTML="收起";
				  }else{
					 document.getElementById("state"+id).innerHTML="展开";
				  }
				  $("#"+o+""+id).toggle(100);
			 }
			
		 }

		function save(info){
		    if(info!=""){
				 var r=INSERT("bug",{info:info,type:-1,date:DATE(),state:0},true);
				 if(r.state){
					 printr(r);
					 seachInput.value="";
					 addOneLine(r.newid,info,DATE());
					// alert("添加成功");
				 }else{
					 alert("添加失败错误信息\n"+r.info);
				 }
			}
		}

		function FINISH(ID){
			if(confirm("确认修复成功？")){
				UPDATE("bug","state",1,"id="+ID);
				UPDATE("bug","edate",DATE(),"id="+ID);
				loadData();
			}
			
		}
		function DELBUG(ID){
			if(confirm("确认删除?")){
				var r=DELETE("bug","id="+ID,true);
				printr(r);
				if(r.state){
					return true; 
				}else{ 
					printr(r.info);
					return false;
				}
			}else{
				return false;
			}
			
		}
		function info2(id){
			var content="<iframe id='bugBox' src='ebug.php?bid="+id+"'></iframe>";
				MSGBOX(content,"",id+"号BUG","","",1100);
		}
		
		
		

	

		

    //S document.onkeydown = keyDown;  
			
	</script>

</html>