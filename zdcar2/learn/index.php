<!DOCTYPE html>
<?php
   	require_once '../function.php';
	require_once '../page.class.php';
	//require_once '../../function/fun.php';
 ?>
<html>
	<head>
		<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width,initial-scale1=1" />
			<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/index.css">
            <script src="js/khjl.js"></script>
            
           
			
	<style>
.container {
	margin-top: 5px;
}

#bg,
#bg1,
#bg2,
#bg3,
#bg4,
#bg5,
#bg6,
#bg7{
	display: none;
	position: absolute;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;
	background-color: black;
	z-index: 1001;
	-moz-opacity: 0.7;
	opacity: .70;
	filter: alpha(opacity=70);
}

#show,
#show1,
#show2,
#show3,
#show4,
#show5,
#show6,
#show7{
	display: none;
	position: absolute;
	top: 25%;
	left: 22%;
	width: 53%;
	height: 49%;
	padding: 8px;
	border: 8px solid #E8E9F7;
	background-color: white;
	z-index: 1002;
	overflow: auto;
}
#back{
	display: none;
	top: 0px;
	left: 0px;
	margin: 0px;
	padding: 0px;
	width: 100%;
	height: 500%;
	position: absolute;
	z-index: 998;
	background: rgba(200, 200, 200, 0.5);		
}
	</style>
	<script>
		function show(obj){
			document.getElementById(obj).style.display="block"
			document.getElementById("back").style.display="block"		
		}
		function hide(obj){
			document.getElementById(obj).style.display="none"
			document.getElementById("back").style.display="none"	
		}
	</script>
		<title>要修改的表格2</title>
		
	</head>
	<body>
 
    <input type="hidden" id="cp" value="<?php echo $cp; ?>" >
<div class="container">
	<table class="table table-bordered table-condensed table-hover table-striped">
		<thead>
			<tr>
			<th>会员卡号</th>
			<th>客户名称</th>
			<th>手机号码</th>
			<th>会员余额</th>
			<th>用户积分</th>
			<th>创建时间</th>
			<th>会员等级</th>
			<th colspan="3" style="text-align:center;">操作</th>
			</tr>
		</thead>
		<tbody>
        <?php
			isset($_GET["page"])?$pg=$_GET["page"]:$pg=1;
			$db->select("kehu","count(*) as ct","company=".$cp." and del");$kehus=$db->fetchArray(MYSQL_ASSOC);
			$zdt=$kehus[0]["ct"];
			$page=new Page($zdt,10);
			$db->select("kehu","*","company=".$cp." and del ".$page->limit1()."");$kehu=$db->fetchArray(MYSQL_ASSOC);
			$i=0;
			echo "<input type='hidden' id='cp' value='".$cp."' >";
			foreach($kehu as $row){
				$i++;
				echo "<tr>
						<td>".$row["vip"]."</td>
						<td>".$row["name"]."</td>
						<td>".$row["phone"]."</td>
						<td>".($row["money"]*1)."</td>
						<td>".($row["jf"]*1)."</td>
						<td>".$row["intime"]."</td>
						<td>".$row["vipdj"]."</td>
						<td><a data-toggle='modal' href='#czjl' onclick='czjl(".$row["id"].")'>充值记录</a></td>
						<td><a  data-toggle='modal' href='#xfjlbox' onclick='xfjla(".$row["id"].")'>消费记录</a></td>
						<td><a data-toggle='modal' href='#clxx' onclick='car(".$row["id"].")'>车辆信息</a></td>						
					</tr>";	
			}		
			echo "<tr><td colspan='10'>".$page->showpage()."</td></tr></tbody></table>	";

		 ?>	
		
</div>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<div class="bg" id="back"></div>
    
    
  
 <!--充值记录弹窗 -->  
<div id="czjl" class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">充值记录</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered" style="text-align:center;">
					<thead>
						<tr>
						<th>充值时间</th>
						<th>充值金额</th>
						<th>支付类型</th>
						<th>充值编号</th>
                        <th>充值地点</th>
						</tr>
					</thead>
					<tbody id="czbody"></tbody>
				</table>
			</div>
			<div class="modal-footer" id="cz1" style="display:none;">
            	                	选择充值面值：
                    <select class="text" id="je">
                    	    <option value="50">50元</option>
                            <option value="100">100元</option>
                            <option value="200">200元</option>
                            <option value="500">500元</option>
                    </select>
                    <?php echo jsfs(0); ?>
                    <input type="text" style="width:400px;" class="text">
				<button type="button" class="btn btn-group-xs"  onClick="$('#cz1').toggle(500)">取消</button>
				<button type="button" class="btn btn-group-xs" onClick="subcz()">提交</button>
			</div>
		</div>
	</div>
</div>
 <!--车辆信息 -->  
<div id="clxx" class="modal" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">车辆信息</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered" style="text-align:center;">
					<thead>
						<tr>
                        <th>序号</th>
						<th>品牌</th>
						<th>车型</th>
						<th>车牌</th>
						<th>购车日期</th>
                        <th>车辆识别号</th>
						</tr>
					</thead>
					<tbody id="carbody"></tbody>
				</table>
			</div>
			<div class="modal-footer" id="addcar" style="display:none;">
           	  <table class="table table-striped table-bordered">
              <tr>
				<td><input type="text" class="input_td" id="pp" placeholder="品牌"></td>
                <td><input type="text" class="input_td" id="car" placeholder="车型"></td>
                <td><input type="text" class="input_td" id="carid" placeholder="车牌号"></td>
                <td><input type="date" class="input_td" id="bdate" title="购车日期"></td>
                <td><input type="text" class="input_td" id="vin" placeholder="车辆识别码(VIN)"></td>
 			  </tr>
              <tr> 
				<td colspan="5"><button type="button" class="btn btn-group-xs"  onClick="$('#cz1').toggle(500)">取消</button>
				<button type="button" class="btn btn-group-xs" onClick="addcar()">提交</button>  </td>
              </tr>
              </table>    
			</div>
		</div>
	</div>
</div>
<!--消费记录 -->  
<div id="xfjlbox" class="modal" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
    	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">消费记录<input type="button" class="btn btn-info btn-sm" onClick="$('#addxf').toggle(200);location.hash='addxf1'"  value="添加"/></h4>
                
 			</div>
           
			<div class="modal-body">
				<table class="table table-striped table-bordered" style="text-align:center;">
					<thead>
						<tr>
							<th>消费时间</th>
							<th>消费金额</th>
							<th>消费类型</th>           
							<th>消费编号</th>             
							<th>消费地点</th>
						</tr>	
					</thead>
					<tbody id="xfjltb"></tbody>
                    <tr>
                    	<td colspan="5">
                        	<input type="button" class="btn btn-info btn-sm" onClick="$('#addxf').toggle(200);location.hash='addxf1'"  value="添加"/>
                        </td>
                    </tr>
				</table>
			</div>
			<div class="modal-footer" id="addxf" style="display:none;" >
           
           	  <table class="table table-striped table-bordered">
              <tbody id="itemr">
              <tr>
				<td rowspan="2" id="date"><input type="date"class="input_td" id="xdate" placeholder="时间"></td>
                <td rowspan="2" id="type"><?php echo btype(0);$type=btype(0);?></td>
                <td><input type="text" class="input_td" id="xfje" name="xfje"  onChange="zje()" placeholder="金额"></td>
                
               		
                <td><select class="input_td" id="item" name="item" placeholder="项目选择">
                	<option value="0">请选择项目</option>
                	<?php 
						$item=select("item","company",$cp);
						$items="";
						foreach($item as $row){
							echo "<option value=".$row["id"].">".$row["itemname"]."</option>";	
							$items.="<option value=".$row["id"].">".$row["itemname"]."</option>";	
						}
					 ?>
                </select></td>
                <td><input type="text"  class="input_td" id="tips" name="tips" placeholder="备注"></td>
               
 			  </tr>
              
              <tr align="center"><td colspan="4">
              		<input type="button" class="btn btn-info btn-sm" onClick="addtr()"  value="添加项目"/>
              </td></tr>
              </tbody>
              <tr> 
              	<td colspan="2" align="center"><h4 style=" color:red;" id="zje">总金额：0元</h4>
				<td colspan="3" align="center"><button type="button" class="btn btn-group-xs"  onClick="$('#addxf').toggle(500)">取消</button>
				<button type="button" class="btn btn-group-xs" onClick="addxfjl()">提交</button>  </td>
              </tr>
              <tr><td colspan="5"></td></tr>
              </table>  
                
			</div>
		</div>
         <a name="addxf1"></a>
	</div>
</div>

<script type="text/jscript">
	function addtr(){
	var c=document.getElementById("itemr").rows.length
	//alert(c)
	td1=" <td><input type='text' class='input_td' id='xfje"+c+"' name='xfje' placeholder='金额' onChange='zje()'></td>"
	
	td3="<td><select class='input_td' id='item' name='item' placeholder='项目选择'><?php echo $items;?></select></td>"
	td4="<td><input type='text'  class='input_td' id='tips' name='tips' placeholder='备注'></td>"
	content=td1+td3+td4
	document.getElementById("date").rowSpan=c+1;
	document.getElementById("type").rowSpan=c+1;
	$('<tr>'+content+'</tr>').insertAfter($('#itemr tr:eq('+(c-2)+')'));
	}
</script>
		
	</body>
</html>
