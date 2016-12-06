<!DOCTYPE html>
<?php 
	ini_set('display_errors','On');
	require_once '../lib/fun.php';
	$BUG=SELECT("bug","count(1)c","1");$total=$BUG[0]["c"];
	$BUG=SELECT("bug","count(1)c","state");$ywc=$BUG[0]["c"];
	$percent=round(($ywc/$total*100),1)."%";
	?>
<html> 
	<head>
		<meta charset="utf-8" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>CMD</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
        <script src="../zdcar2/js/js.js?v=10"></script>
		<script src="../zdcar2/js/jquery-1.10.2.js"></script>
		<script src="../lib/js/jQuery.speech.js"></script> 
		
		<!-- bt框架-->
		<script src="../zdcar2/js/bootstrap.min.js"></script>
		<link href="../zdcar2/css/bootstrap.min.css" rel="stylesheet" /> 
		
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
		<style>
			body{
				background:url(http://img.hb.aicdn.com/6e7ae0af005c046813897d9f8ea88535028756d818c48-z1V3hD_fw658);
			}
			.window{
				width:100%;
				height:700px;
				background:030303;
				color:#FFF;
				padding:10px;
				border:0px;
			}
			.window:focus {outline: none;} 
			.line{
				height:auto;
				background:rgba(0,0,0,0.0); 
				padding:5px;
				width:100%;
				height:25px;
			}
			.scanf{
				background-color:rgba(0,0,0,.0); /*黑色*/
				border:0px;
				width:80%;
			}
			.imgbox{
				width:100%;
				
				margin:5px 0px 0px 25px;
			}
			.imgbox .img{
				width:100px;
				height:100px;
				border:1px solid;
				box-shadow: 1px 1px 0px #888888;
				
			}
			.boradbg {
				background: url(img/cmdbg.gif);
			}
			.board{
				background:rgba(0,0,0,0.9);
			}
			.line .col{
				margin:0px 10px;
				float:left;
				width:150px;
				height: 25px;
				overflow: hidden;
				border: 1px solid #FFF;
				text-align:center; 
			}
			
			.scanf:focus {outline: none;}
			.error{color:red;}
			.success{color:#6ef273;}
		</style>
	</head>
	<body style="background:#000;padding:0px;"> 
		<div class="window" id="window">
			<div class="boradbg">
				<div id="board" class="board "></div>
				<div id="comman" class="line board">
					<span id="runer">MYSQL</span>>
					<input type="text" class="scanf" id="scanf" onkeyup="key(this.value)">
					<!--<div class="imgbox">
						<img  class="img" src="http://img2.imgtn.bdimg.com/it/u=231680329,4061032957&fm=21&gp=0.jpg"/>
					</div>-->
				</div>
			</div>
	    </div>
		<div id="SpeakerContent" style='display:none;'></div>
	</body> 
	<script>
		board=document.getElementById("board");
		scanf=document.getElementById("scanf");
		window=document.getElementById("window");
		runer=document.getElementById("runer");
		runert=runer.innerHTML;
		SPEAKERON=1;
		code=[];
		enterCount=0;
		printr(code[0]);
		onload();
		window.onfocus=function(){
			scanf.focus(); 
		}
		window.onclick=function(){
			scanf.focus();
		}
		function onload(){
			scanf.focus(); 
			echo("Yunkukeji Command [版本 10.0.14393]");
			echo("(c) 2016 Microsoft Corporation。保留所有权利。");
		}
		function Line(str){
			return "<div class='line'>"+str+"</div>";
		}
		function key(value){
			if(event.keyCode==13){
				code[enterCount]=value;
				printr(code);
				enterCount++;
				scanf.value="";
				run(value);
			}
			if(event.keyCode==38){
				 if(enterCount>0)enterCount--;
				 scanf.value=code[enterCount];
			}
			if(event.keyCode==40){
				 enterCount++;
				 scanf.value=code[enterCount];
			}
			window.scrollTop=window.scrollHeight; 	 
		}
		function run(command){
			var R;
			switch(runer.innerHTML){
				case "USER":
					switch(command){
						case "root":
							runer.innerHTML="PASSWORD";
						break;
						default:
							echo(no("用户名不存在"),command);
						break;
					}
				break;
				case "PASSWORD":
					switch(command){
						case "123456":
							runer.innerHTML="ROOT";
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok("登陆成功"));
						break;
						default:
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(no("密码错误"));
						break;
					}
				break;
				case "Robot":
					printr(scanf.value)
					board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Robot(command)));
				break;
				case "SPEAKER":
					switch(command){
						case "停止模仿":case "停止":case"退出":
								mod("LFT");
								Text="退出成功";
								Speak(Text);
								board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
						default:
							Speak(command)
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(command));
						break;
					}
				break;
				case "ALICE":
					switch(command){
						case"退出":
							mod("LFT");
						break;
						default:
							Text=Robot(command,"阿里"); 
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
					}
				break;
				case"MYSQL":
					switch(command){
						case"退出":
							mod("LFT");
							echo(ok("Good Bye")); 
						break;
						default:
							var sqls=SQLtoString(command);
							var ARR=SELECT(sqls.TABLE,sqls.COL,sqls.CONDITION);
							var c="";
							for(var row in ARR){
								for(var col in ARR[row]){
									c+="<div class='col'>"+col+"</div>"; 
								}
								break;
							}
							echo ("",command)
							echo(c);	
							
									
									
									
							
							for(var row in ARR){
								var c="";	
								for(var col in ARR[row]){
									c+="<div class='col'>"+ARR[row][col]+"</div>";
								}
								echo(c)
								
							}
							printr(c);
				
							
						break;
					}
					
					
				break;
				case "JavaScript":
					switch(command){
						case"exit":case"退出":
							mod("LFT");
							Text="退出成功";
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok("退出成功"));	
						break;
						case "修复进度":
							Text= "总bug数18 程序漏洞 10 功能完善 5 已完成 15 未完成 3 完成进度 83.3%";
							echo(ok(Text),command);
						break;
						
						case "显示BUG列表":case "showbug":
							BUG=SELECT("bug","*","id<60");
							i=0;
							tbody="";
							for( row in BUG){
								tbody+="<tr>";
								for(col in BUG[row]){
									tbody+="<td>"+BUG[row][col]+"</td>";
								}
								tbody+="</tr>";
							}
							echo(ok("已经帮您显示"+10+"条记录"),command);
							echo(TABLE(tbody,"width:500px;"));
						break;
						case "修复记录":
							var c=("Text='已为您列出最近10条记录';echo(ok(Text),command);")
							var sc="echo(a('www.baidu.com',i+'、/修复记录:'+i))"
							c+="for(i=0;i<10;i++){"+sc+";}";
							/*echo(ok(Text),command);
							for(i=0;i<10;i++){
								echo(a("#",(i+1)+"、修复记录"+i+"----------------------- "+DATE()));
							}*/
							eval(c);
							
						break;
						default:
							try {  
								if (typeof (eval(command)) == "function") {  
									R=eval(command);
									if(R!=undefined){
										board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(R);
									}else{
										printr("节点1");
									}
								}else{
									R=eval(command);
									board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(R);
								}  
							} catch (e) { 
								board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(no("'"+command+"' IS NOT A FUNCTION"));	
							}  	
						break;
					}


				break;
				default:
					switch(command){
						case "hello":
							Text="你好啊。";
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
							Speak(Text);
						break;
						case "robot":
							runer.innerHTML="Robot";
						break;
						case "不要说话了":case "你好吵啊":case "嘘":case "保持安静哦":
							Text="好的 我把嘴巴闭上";
							SPEAKERON=0;
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
						case "说话":case "张嘴":case "可以说话了":case "听听的的声音":
							Text="总算可以说话了 可把我憋坏了呢";
							SPEAKERON=1;
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
						case"学我说话":case"模仿模式":
							mod("SPEAKER");
							Text="好的 你说一句我读一句哦";
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
						
						case "你妈死了":
							Text="你妈才死了";
							Speak(Text);
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
						break;
						case "ALICE":
							mod("ALICE");
							Text="你好啊 我是Alice";
							Speak(Text);
							echo(ok(Text),command);
						break;
						case"MYSQL":case"数据库":
							mod("MYSQL");
							Text="成功访问Mysq";
							echo(ok(Text),command);
						break;
						case "bug":
							runer.innerHTML="USER";
							printr(scanf.innerHTML);
						break;
						case"reload":case "f5":
							to("cmd.php");
						break;
						case "cls":
							board.innerHTML="";
							R= ok("");
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(R);
						break;
						case"js":case"JS":case"JAVASCRIPT":case "JavaScript":case"javascript":
							runer.innerHTML="JavaScript";
						break;
						case "img":
							show(command);
						break;
						default:
							R=no("'<b>"+command+"'<b> Is Not a Command</span>");
							Text=Robot(command,"图灵"); 
							board.innerHTML+=Line(runer.innerHTML+">"+command)+Line(ok(Text));
							Speak(Text);
						break;
					}
				break;
			}
			
			
		}
		function no(str){
			return "<span class='error'>ERROR: "+str+"</span>";
		}
		function ok(str){
			return "<span class='success'>SUCCESS:"+str+"</span>";
		}
		function a(href,Text){
			return "<a href="+href+">"+Text+"</a>";
		}
		
		function show(command){
			base64="data:image/jpg;base64,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";
			board.innerHTML+=Line(runer.innerHTML+">"+command)+Line("<img width=100 height=100 src="+base64+">");
		}
		function echo(a,c){
			if(c!=undefined){
				board.innerHTML+=Line(runer.innerHTML+">"+c)+Line(a);
			}else{
				board.innerHTML+=Line(a);
			}
		}
		function mod(m){
			runer.innerHTML=m;
		}
		function Speak(str){
			if(SPEAKERON){
				Speaker(str);
			}
		}
		function SQLtoString(str){
			str = str.replace(/\s+/g, ' ');//去除多余空格
			str=str.toUpperCase()//统一转大写
			sqls=str.split(" ");//切割 
			
			switch(sqls[0]){
				case "SELECT":
					return{TABLE:sqls[3],COL:sqls[1],CONDITION:""};
				break;
				default:
					return "暂不支持";
				break;
			}
		}
		

	</script>
</html>















