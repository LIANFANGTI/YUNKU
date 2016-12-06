<!DOCTYPE html>
<html>
<?php
   	require_once 'function.php';
	?>
	<head>
		<meta charset="utf-8" />
		<title>客户管理</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="js/js.js"></script>
        <script src="js/4-1.js"></script>
        <script src="js/jquery-1.10.2.js"></script>
		<!-- bt框架-->
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- bt框架End-->
	</head>

	<body>
		<div class="main">
			<div class="box">
				<div class="box_title">
					<h4 class="caption" >客户管理</h4>
					<div class="close"><input type="button" value="新增客户" class="botton" onclick="add('akehu')" /></div>
				</div>
				<div>
                	<table class="table table-bordered table-condensed table-hover table-striped">
                    	<tr><td>
                        	 <input type="search"  class="input_td" onKeyUp="tjcx()" id="tj" placeholder="输入姓名或会员卡号或车牌号等信息进行查询"/>
                        </td></tr>
                    </table>
                    
					<table class="table table-bordered table-condensed table-hover table-striped">
						<tr>
							<td>序号</td>
                            <td>客户名称</td>
							<td>车牌号</td>
							<td>车型</td>
							
							<td>会员卡号</td>
                            <td>客户余额</td>
							
							<td>联系手机</td>
							<td>最新里程</td>
							<td>下次保养里程</td>
							<td>下次保养时间</td>
							<td>下次回访时间</td>
							<td>消费记录</td>
							<td>客户备注</td>
							<td>操作</td>

						</tr>
     					<tbody id="khinfo"  style='text-align:center;'>
                         <?php 
						
						 isset($_GET["page"])?$pg=$_GET["page"]:$pg=1;
						 $db->select("kehu","count(*) as ct","company=".$cp." and del ");$kehus=$db->fetchArray(MYSQL_ASSOC);
						 $zdt=$kehus[0]["ct"];
						 $page=new Page($zdt,10);
						 $db->select("kehu","*","company=".$cp." and del ".$page->limit1()."");$kehus=$db->fetchArray(MYSQL_ASSOC);
						 $i=0;
						 
						  foreach($kehus as $row){
							 $xf=0;
							$db->select("bill","*","kehu=".$row["id"]."");$bill=$db->fetchArray(MYSQL_ASSOC);
							foreach($bill as $row1){$xf+=$row1["zje"];}
							$vip="VIP".$row["company"].date('Ymd',strtotime($row["intime"]));
						
							if(selecta("car","kh",$row["id"],"carid")!=""){
								$CC=selecta("car","kh",$row["id"],"carid");
							}else{$CC="暂无";}
						    echo "<tr class=a".$i."  style='text-align:center;'>";		
							echo"<td>".($i+1)."</td>
							<td>".$row["name"]."</td>
							<td>".$CC."</td>
							<td>".$row["car_type"]."</td>
							
							<td>".$row["vip"]."</td>
							<td><b class='btn btn-success btn-xs'>".($row["money"]*1)."￥</b></td>
							<td>".$row["phone"]."</td>
							<td>".$row["new_km"]."KM</td>
							<td>".($row["next_by_km"]*1)."KM</td>
							<td>".$row["next_by_time"]."</td>
							<td>".$row["next_back"]."</td>
							<td><a class='btn btn-info btn-xs' href='javascript:add(\"xfjl\");xfjla(".$row["id"].")'>查看</a></td>
							<td>".$row["tips"]."</td>
							<td><button class='btn btn-info btn-xs' onclick='add(\"ekehu\");ekehua.src=\"ekehu.php?kid=".$row["id"]."&pg=".$pg."\"'>编辑</button>
								&nbsp;<input type='button' class='btn btn-danger btn-xs' value='删除' onclick='delkh(".$row["id"].",".$pg.")'></td>";
							
									$i++;
								}
							echo "<tr><td colspan='15'>".$page->showpage()."</td></tr>";
							?>
                        </tbody>
					</table>

				</div>
     </div>
				 
<div class="back" id="back" ></div>
<div class="toolbox" id="akehu"  style="width:800px;">
      <div class="box_title">
          <h4 class="caption">新建项目</h4>
          <div class="close" onClick="closeb('akehu')">×</div>
          </div>
          <div class="box_content">
           	<fieldset class="group"><legend><h5>必填信息</h5></legend>
                <input type="hidden" value="" id="kid" />
                <input type="hidden" value="<?php echo $cp; ?>"  id="cp"/>
                客户姓名：<input id="name" type="text" class="text" value="" onBlur="c(this,'')" placeholder="必填"/>
                手机号码：<input id="tel" type="text" class="text" value="" onBlur="c(this,'')" placeholder="必填"/>
                车牌号:<input id="carid" type="text" class="text" value="" onBlur="c(this,'')" placeholder="必填"/>
            </fieldset>
            <fieldset class="group"><legend><h5>车辆信息</h5></legend>
               
                 车型:<input id="cart" type="text" class="text" value=""/>
              车身颜色：<input id="color" type="text" class="text" value=""/>
              最新里程：<input id="nkm" type="text" class="text" value=""/>
                 保险公司：<input id="bxcp" type="text" class="text" value=""/>
            </fieldset>
                    <fieldset class="group"><legend>其他信息</legend>
                下次保养里程：<input id="nbkm" type="text" class="text" value=""/>
                下次保养时间：<input id="nbtime" type="date" class="text" value=""/>
               下次回访时间：<input id="nback" type="date" class="text" value=""/>
                下次保险时间：<input id="nbx" type="date" class="text" value=""/>
                <div class="items">备注信息：<input type="text" class="input" id="tips" value=""/></div>
 		</fieldset>  			
          </div>
          <div class="boxbt">
             <input type="button" value="保存" class="botton"  id="skehu" onClick="akehu()" ></div>
          </div>
</div>
<div class="toolbox" id="xfjl" style="width:800px;"> 
	<div class="box_title">
    	<h4 class="caption">消费记录</h4>
        <h6 class="close" onClick="closeb('xfjl')">X</h6>
    </div>
    <div class="box_content">
    	<table class="table1">
        	<tr>
				<th>消费时间</th>
				<th>消费金额</th>
				<th>消费类型</th>           
				<th>消费编号</th>             
				<th>消费地点</th>
			</tr>
            <tbody id="xfjltb">
            	
            </tbody>
        </table>
    </div>
</div>
<div class="toolbox" id="ekehu" style="width:800px;">
    <div class="box_title">
        <h4 class="caption">客户编辑</h4>
        <h6 class="close" onClick="closeb('ekehu');history.go(0);">X</h6>
    </div>
 	<div class="box_content">
    	<iframe name="ekehu" id="ekehua" style="width:100%; height:300px; border:0px;" src="http:\\www.zduber.com">
        	
        </iframe>
    </div>
</div>

	</body>

</html>