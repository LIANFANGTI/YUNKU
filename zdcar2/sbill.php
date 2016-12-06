<!DOCTYPE html>
<?php
	$bid=$_GET["bid"];
	ini_set('display_errors','On');
	require_once 'function.php';
   // $db->select("kehu", "*", "user = 'admin'");
	$kehu = select("kehu", "*", "company=".$cp );//客户表读取
	$item = select("item", "*", "company=".$cp );//项目表读取
	$shop = select("shop", "*", "del and company=".$cp );//商品表读取
    $bill = select("bill", "*", "id=".$bid." and company=".$cp );//订单信息读取
	$ashop = select("ashop", "*", "bid=".$bid." and del and sl");//已添加商品表读取
	$aitem = select("aitem", "*", "bid=".$bid."");//已添加项目表读取
	$kehu1 = select("kehu", "*", "id=".$bill[0]["kehu"]." and company=".$cp);//订单里客户id对应的客户信息读取
	
	
	$rq=date('Ymd');
	$bm="XM".$rq;
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>订单详情</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
        <script src="js/js.js"></script>
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/ebill.js?val=<?php echo time();?>"></script> 
		<!-- bt框架-->
			<script src="js/bootstrap.min.js"></script>
			<link href="css/bootstrap.min.css" rel="stylesheet" />
				<link href="css/bootstrap.min.css" rel="stylesheet" />
			<link href="http//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- bt框架End-->
	</head>

	<body onload='jisuan()'>
		<?php
		   
			$company=$bill[0]["company"];
			$date=date('Ymd',strtotime($bill[0]["date"]));
			$abm =select("bill", "count(*) as c", "date='".$bill[0]["date"]."' and company=".$company."");
			$count=fz($abm[0]["c"]);
			$bm="KD".fz($company).$date.$count;
			echo " <input type='hidden' value='".$bid."' id='bid'>";
			if(!$bill[0]["zt"]){
				$bill_zt="结算订单";
				$lock="";
			}else{
				$bill_zt="已结算";
				$lock="disabled";
			}
			$bid=$bill[0]["id"];$bbm=$bill[0]["bid"];$bkh=$kehu1[0]["name"];$khid=$kehu1[0]["id"];$tel=$kehu1[0]["phone"];$bgz=$bill[0]["btype"];$bps=$bill[0]["tips"];
			
		?>
		<div class="back" id="back" ></div>
		
		<div id="main">
			<div class="box">
				<div class="box_title">
					<h4 class="caption">订单编号:</h4>;
					<h4 class="caption"><?php echo $bill[0]["bid"]; ?></h4>
					<h4 class="caption">订单类型:<b ><?php echo btypet($bill[0]["btype"]); ?></b></h4>
					<?php 
						$yhVal=$bill[0]["yhval"];
						if($yhVal!=""){
							$yhtype=$bill[0]["yhtype"];
							if($yhtype==0){
								$yhInfo="减免".$yhVal."元";
							}else{
								$yhInfo=($yhVal*1/10)."折";
							}
						}else{
							$yhInfo="无";
						} 
						/*if(bill[0]["yhtype"]){
							
						}*/
					?>
					<h4 class="caption">优惠信息:<?php echo $yhInfo;?></h4>
					<div class="pull-right">
						
					</div>
				</div>
				<div class="box_content">
			<table class="table  table-hover " style="width:100%;">
				<tr>
					<td>客户:</td>
					<td><?php echo $bkh; ?> </td>
					<td>客户电话:</td>
					<td><?php echo $tel; ?></td>
					<td>维修车辆：</td>
					<td><?php echo $billCarid=SELECTA("bill","id",$bid,"carid");?></td>
				</tr>
				<tr>
				<?php
					$carInfo=SELECT("car2","*","carid='$billCarid'");
					 $new_km=SELECTA("bill","id",$bid,"carkm");
				?>
					<td>保险到期日:</td><td><?php echo $carInfo[0]["date_bx"];?></td>
					<td>年检到期日:</td><td><?php echo $carInfo[0]["date_nj"];?></td>
					<td>行驶证到期日</td><td><?php echo $carInfo[0]["date_xsz"];?></td>
				</tr>
				<tr>
					<td>最新公里数:</td>
					<td><?php echo $new_km==""?0:$new_km;?>km</td>
					<td>订单类型</td>
					<td ><?php echo getBtypeList($bill[0]["btype"],"text");?></td>
					<td>订单备注:</td>
					<td><?php echo $bill[0]["tips"];?></td>
					
				</tr>
			</table>
			
				</div>
				<div class="boxbt" style="margin:0px;">
					<table class="table table-striped table-bordered table-hover" id="itemtb">
						<tr style="background:#555;color:#fff;" onClick="$('#weixiuc').toggle(500)"; ><td colspan=8>订单项目</td></tr>
							<tbody id='weixiuc'>
								<tr>
									<td> 序号 </td>
									<td>项目编码</td>
									<td>项目名称</td>
									<td>工时（时）</td>
									<td>开始时间</td>
									<td>完工时间</td>
									<td>施工人员</td>
									<td>备注</td>
								</tr>
								<?php
									function fz($a){$re=$a;if($a<1000) $re="0".$a;if($a<100) $re="00".$a;if($a<10) $re="000".$a;return $re;	}
									if(empty($aitem)){
										echo"<tr><td colspan='14'>暂无项目请添加</td></tr>";
									}else{
										$c=0;
										$money=0;
										foreach($aitem as $row){
											$c++;
											$db->select("item", "*", "id=".$row["iid"]."");$iitem = $db->fetchArray(MYSQL_ASSOC);
											$money+=$row["gs"];
											$bm=$iitem[0]["itemid"];
											echo"<tr id='aiid".$c."' class='".$row["id"]."'>
													<td>".$c."</td>
													<td>".$bm."</td>
													<td>".$iitem[0]["itemname"]."</td>
													<td><input type='text' id='gs".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].");jisuan()' value='".$row["gs"]."' name='gs'></td>
													<td><input type='date' id='st".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].")' value='".$row["stime"]."'/></td>
													<td><input type='date' id='et".$row["id"]."' class='input_td' onChange='cgxm(".$row["id"].")' value='".$row["etime"]."'/></td>
													<td>".$row["gr"]."</td>
													<td>".$row["tips"]."</td>
												</tr>";
													
										}	
									}
								?> 
								<tr>
									<td colspan=8><h4 class="mny" id="itemrmb"><?php echo "总计:$money 元";?></h4></td>           
								</tr>
						</tbody>
							</div>
					</table>
									
					<!--项目栏结束-->

					<!--商品栏开始-->
					<table class="table table-striped table-bordered table-hover" id="shoptb">
						<tr style="background:#555;color:#fff;" onClick="$('#weixiuc').toggle(500)"; ><td colspan=12>零配件</td></tr>
						<tr>
							<td> 序号 </td>
							<td>商品编码</td>
							<td>商品名称</td>
							<td>品牌</td>
							<td>规格</td>
							<td>适用车型</td>
							<td>单位</td>
							<td>销售价格</td>
							<td>数量</td>
							<td>金额</td>
							<td>领料人员</td>
							<td>商品备注</td>
						</tr>
						<?php
							$srmb=0;
							if(empty($ashop)){
								echo"<tr><td colspan='14'>尚未添加</td></tr>";
							}else{
								$c=$srmb=$money=0;
								foreach($ashop as $row){
									$c++;
									$db->select("shop", "*", "sid=".$row["sid"]."");$sshop= $db->fetchArray(MYSQL_ASSOC);
									$smoney=($sshop[0]["sdj"]*$row["sl"]);
									$srmb+=$smoney;
									$bm="SP".fz($sshop[0]["company"]).fz($row["id"]);
									echo" <input type='hidden' id='sid+".$c."' value='".$row["sid"]."'>";
									echo"<tr id='asid".$c."' class='".$row["id"]."'>
											<td>".$c."</td>
											<td>".$bm."</td>
											<td id='sp".$c."'>".$sshop[0]["sname"]."</td>
											<td>".$sshop[0]["spp"]."</td>
											<td>".$sshop[0]["tips"]."</td>
											<td>".$sshop[0]["scar"]."</td>
											<td>".$sshop[0]["sdw"]."</td>
											<td><input onClick='ChangeShopMoney(".$row["id"].",this,".$row["money"].")' type='text' name='sdj'  id='smoney".$c."' style='width:25px;' class='btn btn-warning btn-xs' value='".$row["money"]."' />元</td>";
											$slid="sl".$c;
											$id=$row["id"];
											$onClickD="downsl($id,'$slid')";
											$onClickU="upsl($id,'$slid')";
										echo"<td>
												<input type='button' onclick=$onClickD class='btn btn-info btn-xs' value='-' />
												<input type='text' name='ssl' onChange='crm(".$c.",\"ashop\")' id='sl".$c."' style='width:30px;cursor:pointer;' class='input_td' value='".$row["sl"]."' />
												<input type='button' onclick=$onClickU  class='btn btn-info btn-xs' value='+' />
											</td>
											<td id='srmb".$row["id"]."' title=''>
												".($row["money"]*$row["sl"]*1)."元
											</td>
											<td>".$row["gr"]."</td>
											<td>".$row["tips"]."</td>
										</tr>";
								}
							}
						?>
						</tbody>
					</table>
					<div class="boxbt"><h3 class="mny" id="shoprmb">总计:<?php echo $srmb; ?>元</h3><input type="hidden" id="spje" value=<?php echo $srmb; ?> /></div>
				</div>  
			</div>
								
								
						</div>
					<!--商品栏结束-->
			    </div>
			</div> 
			<?php
				if($bill[0]["yhval"]==0||$bill[0]["yhval"]==""){
					$MoneyMsg="订单总额:".$bill[0]["money"]."元";
				}else{
					if($bill[0]["yhtype"]){
						$MoneyMsg="订单总额:".$bill[0]["money"]*($bill[0]["yhval"]/100)."元(".$bill[0]["money"]."x".$bill[0]["yhval"]."%)";
					}else{
						$MoneyMsg="订单总额:".($bill[0]["money"]*1-$bill[0]["yhval"]*1)."元(".$bill[0]["money"]."-".$bill[0]["yhval"].")";
					}
				}
			?>
			<fieldset style="border:0px"><h1 style="margin:20px 40px; float:right;color:#f9af02;" id="rmbs"><?php echo $MoneyMsg; ?></h1></fieldset>
			</div>          	
					
				
<!-----------------------------------------------------------------------弹窗区----------------------------------------------------------------------->			

	<!--项目选择弹窗-->
		<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="chosexm" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content text-center">
					<div class="modal-header">
						<button type="button" class="pull-right" data-dismiss="modal">
							<span class="fa fa-times fa-lg"></span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">项目选择</h4>
					</div>
					<div class="modal-body text-center">
						<div class="row">
							<table class="table table-striped table-bordered table-hover">
								<tr>
									<td>序号</td>
									<td>项目编码</td>
									<td>项目名称</td>
									<td>单价</td>
									<td>项目分类</td>
									<td>备注</td>
									<td>操作</td>
								</tr>
							 <?php 
								$i=0;
									foreach($item as $row){
										echo "<tr class=a".$i.">";
											echo"<td>".($i+1)."</td>";
											echo"<td>".$row["itemid"]."</td>";
											echo"<td id='iid".($i+1)."' class='".$row["id"]."'>".$row["itemname"]."</td>";
											echo"<td>".$row["money"]."</td>";
											echo"<td>".$row["item_type"]."</td>";
											echo"<td>".$row["tips"]."</td>";
											echo"<td><button data-dismiss='modal' class='btn btn-success btn-xs' onclick='acitem(\"aitemtb\",".($i+1).",".$row["id"].")'>选择</button></td>";
										echo"</tr>";
										$i++;
									}
								?>							 <?php 
								$i=0;
									foreach($item as $row){
										echo "<tr class=a".$i.">";
											echo"<td>".($i+1)."</td>";
											echo"<td>".$row["itemid"]."</td>";
											echo"<td id='iid".($i+1)."' class='".$row["id"]."'>".$row["itemname"]."</td>";
											echo"<td>".$row["money"]."</td>";
											echo"<td>".$row["item_type"]."</td>";
											echo"<td>".$row["tips"]."</td>";
											echo"<td><button data-dismiss='modal' class='btn btn-success btn-xs' onclick='acitem(\"aitemtb\",".($i+1).",".$row["id"].")'>选择</button></td>";
										echo"</tr>";
										$i++;
									}
								?>
								<tr>
									<td colspan="13"><a href="#addxm" data-toggle="modal" class="btn btn-success btn-sm" >新建项目</a></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="modal-footer text-center">
						<!--底部内容-->
					</div>
				</div>
			</div>
		</div>
	<!--/项目选择弹窗-->

	<!--商品选择弹窗开始-->
			<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="chosesp" >
				<div class="modal-dialog modal-lg">
					<div class="modal-content text-center">
						<div class="modal-header">
							<button type="button" class="pull-right" data-dismiss="modal">
								<span class="fa fa-times fa-lg"></span>
								<span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title">零件选择</h4>
						</div>
						<div class="modal-body text-center">
							<div class="row">
								<table class="table table-bordered table-condensed table-hover table-striped">
									<tbody>
										<tr><td colspan="8"><input type="search" class="input_td" onkeyup="SearchShop(this.value,1)" id="tj" placeholder="输入商品信息查询"></td></tr>
									</tbody>
								</table>
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<td> 序号 </td>
										<td>商品编码</td>
										<td>商品名称</td>
										<td>品牌</td>
										<td>单位</td>
										<td>型号</td>
										<td>库存</td>
										<td>适用车型</td>
										<td>销售价格</td>
										<td>操作</td>
									</tr>
									<tbody id="ShopTab">
								<?php 
									  $i=0;
									  foreach($shop as $row){
										 echo "<tr id='sid".$i."' class='".$row["sid"]."'>";
										 echo"<td>".($i+1)."</td>";
										 echo"<td>SP00".$row["sid"]."</td>";
										 echo"<td>".$row["sname"]."</td>";
										 echo"<td>".$row["spp"]."</td>";
										 echo"<td>".$row["sdw"]."</td>";
										 echo"<td>".$row["skc"]."</td>";
										 echo"<td>".$row["scar"]."</td>";
										 echo"<td>".$row["sdj"]."</td>";
										 
										 
										 echo"</tr>";
										 $i++;
									   }
									    if(empty($shop)){
										   echo "<tr><td colspan=9>您的仓库尚未添加商品信息，请到
										   <a href='3-1.php'>商品管理</a>
										   页面进行管理</td>";
										}
								?>  
								</tbody>
							</table>
							</div>
						</div>
						<div class="modal-footer text-center">
							<!--底部内容-->
						</div>
					</div>
				</div>
			</div>
	<!--商品选择弹窗结束-->

	<!--商品新建弹窗开始-->                
		<div class="toolbox" >
			<div class="box_title">
				<h4 class="caption">新建商品</h4>
				<div class="pull-right" onClick="closeb('addsp')">×</div>
			</div>
			<div class="box_content">
				<form>
						<div class="items">
							 <div class="item"><span class="item_name">商品名称：</span><input type="text" class="text" id="sname"/></div>
							 <div class="item"><span class="item_name">单位:</span><input type="text" class="text" id="sdw" /> </div>
						 </div>
						 <div class="items">
							<div class="item"><span class="item_name">期初成本：</span><input type="text" class="text" id="scb"/></div>
							 <div class="item"><span class="item_name">期初库存：</span><input type="text" class="text" id="skc"/></div> 
							  <div class="item"><span class="item_name">品牌:</span><input type="text" class="text" id="spp"/></div>
						 </div>
						 <div class="items">
							<div class="item"><span class="item_name">销售单价：</span><input type="text" class="text" id="sdj"/></div>
							<div class="item"><span class="item_name">适用车型：</span><input type="text" class="text" id="scar"/></div>
						 </div>
						  
								</form>
					</div>
					<div class="boxbt"> <input type="button" value="保存" class="botton" onClick="s_shop()" /></div>
		</div>
	<!--商品新建弹窗结束-->
	  
	<!--商品退货弹窗开始--> 
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="spth" tabindex="-1">
			<div class="modal-dialog modal-xs">
				<div class="modal-content">
					<div class="modal-header">
						<button class="pull-right" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
						<h4 class="modal-title">商品退</h4>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"   >商品名称</span>
										<input type="text" class="form-control" id="spname" />
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn btn-info" type="button" onClick="down()">-</button>
										</span>
										<input type="text" class="form-control text-center" id="thsl" placeholder="输入退货数量">
										<span class="input-group-btn">
											<button class="btn btn-info" type="button" onClick="up()">+</button>
										</span>
									</div>
									<!-- /input-group -->
								</div>
								<!-- /.col-lg-6 -->
							</div>
							<br>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
										退货原因
									<textarea class="form-control" rows="3" id="thyy"></textarea>
								</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
									<button class="btn btn-primary" onClick="subth()" data-dismiss="modal">提交</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="addxm" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
					<h4 class="modal-title">添加项目</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="input-group">
										<span class="input-group-addon">项目名称</span>
										<input type="text"   id="itemname" class="form-control" placeholder='项目名称' onfocus='Namefocus(this)' onkeypress="AddItemKeydown(this)" />
									</div>
							</div> 
						</div>
					</div>
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary" data-dismiss="modal" onClick="AddItem()" id="SaveItemButton">保存</button>
								<button class="btn btn-primary" onClick="AddItemButton()" id="TestButton">测试</button>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="BILLYH" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" id="yhclose"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
					<h4 class="modal-title">优惠设置</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="input-group">
										<span class="input-group-addon">优惠类型</span>
										<select class="form-control" id='YHTYPE' onChange='yhchange(this.value)'>  
											<?php
												if($bill[0]["yhtype"]){
													echo"<option value=0>金额减免</option>
													     <option value=1 selected>折扣优惠</option>";
												}else{
													echo"<option value=0 selected>金额减免</option>
													     <option value=1>折扣优惠</option>";
												}
											?>
										</select>
									</div>
							</div> 
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="input-group">
										<span class="input-group-addon" id='YhTitle'>输入减免金额(元)</span>
										<input type="text"   id="yhvalue" class="form-control" placeholder='' onfocus='Namefocus(this)' value='<?php echo $bill[0]["yhval"] ?>' onchange="yhchange();isNum(this)" />
									</div>
							</div> 
						</div>
						<div class="row">
						<div class="input-group"></div>
							<div class="input-group">
								<h3 class='mny' id='yhmsg'>金额=原价-减免=100-10=90元</h3> 
							</div>
							<div class="input-group">
									<span class="input-group-addon" id=''>优惠备注</span>
									<input type="text"   id="yhtips" class="form-control" placeholder='' value="<?php echo $bill[0]["yhtips"];?>" onfocus='Namefocus(this)' onchange="yhchange();isNum(this)" />
								</div>
							<div class="input-group">
								
							</div>
						</div>
					</div>
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary"  onClick="yhsave()"  id="SaveItemButton">保存</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!----------------------------------------------------------------------
		<div class="toolbox" id="th" style="width:500px;">
			<div class="box_title">
				<h4 class="caption">商品退货</h4>
				<h4 class="pull-right" onClick="closeb('th')">×</h4>
				
			</div>
		  
			<div class="box_content">
				<fieldset class="group" style="text-align:left; border-radius:10px;">
				<legend>信息填写</legend>
				<ul class="ul_br">
					<li>商品名称：<input type="text" class="text" id="spname"></li>
					<li>退货数量：<input type="button" class="button-yuan" onClick="down()"  value="-">
								<input type="text" value="0" class="text" onKeyUp="cg()"id="thsl">
								<input type="button" class="button-yuan"onClick="up()"  value="+">
					</li>
					<li><label id="min">0</label>
					<input type="range" min="0" id="range" onChange="range()" title="1" value="0"/>
					<label id="max">0</label>
					</li>
					 <br>
					
					<li>退货原因：<input type="text" id="thyy" class="text" style="width:55%;"></li>
					</ul>
				</fieldset>
				<input type="button" class="botton" onClick="subth()" value="提交">
			</div>
		</div>-->
	<!--商品退货弹窗结束--> 

	<!--新建项目弹窗开始-->
<!--新建项目弹窗Start-->
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="addxm" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="pull-right" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
					<h4 class="modal-title">添加项目</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">项目名称</span>
									<input type="text" class="form-control"  id="itemname" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" id="itemtype" >项目类型</span>
									<select class="form-control">
										<option>未选择</option>
										<option>洗车</option>
										<option>美容</option>
										<option>保养</option>
										<option>改装</option>
									</select>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">工时</span>
									<input type="text" class="form-control" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">故障类型</span>
									<select class="form-control" id="error">
										<option>未选择</option>
										<option>车胎故障</option>
										<option>车身刮伤</option>
										<option>其他故障</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary" data-dismiss="modal" onClick="sitem()">保存</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--新建商品弹窗开始-->
	<div class="modal fade" data-target="modal"  id="addsp" tabindex="-1" style="z-index:9999;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="pull-right" data-dismiss="modal">
						<span class="fa fa-times fa-lg"></span>
						<span class="sr-only"></span>
					</button>
					<h4 class="modal-title">新建商品</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">名称</span>
									<input type="text" placeholder="必填" class="form-control" id="Sname"/>
								</div>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" >数量</span>
									<input type="text" placeholder="必填" class="form-control" id="ssl" />
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">成本</span>
									<input type="text" placeholder="必填" class="form-control" id="Scb" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">售价</span>
									<input type="text" placeholder="必填" class="form-control" id="Sdj"/>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">品牌</span>
									<input type="text" class="form-control" id="spp"/>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">型号</span>
									<input type="text" class="form-control" id="xinghao" />
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">到期时间</span>
									<input type="date" class="form-control" id="etime" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">预警数量</span>
									<input type="text" class="form-control" id="akc" />
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">适用车型</span>
									<input type="text" class="form-control" id="car"/>
								</div>
							</div>
						</div>
						<br>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary"  data-dismiss="modal" onclick="sshop()">保存</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--新建商品弹窗结束-->
<!--新建项目弹窗End-->
	<!------------
		<div class="toolbox" id="additem">
			<div class="box_title">
				<h4 class="caption">新建项目</h4>
				<div class="pull-right" onClick="closeb('additem')">&times;</div>
			</div>
			<div class="box_content">
				<div class="items">
					<div class="item"><span class="item_name">项目编码：</span>
						<input type="text" class="text" value="<?php echo $bm;  ?>"  id="itemid" onBlur="c(this,'save_item')" /></div>
						 <div class="item"><span class="item_name">项目名称：</span>
									<input type="text" class="text" id="itemname" onBlur="c(this,'save_item')" /></div>
							 <div class="item"><span class="item_name" >项目类型：</span>
								  <select class="text" id="itemtype" onBlur="c(this,'sava_item')">
									<option>洗车</option>
									<option>美容</option>
									<option>维修</option>
								 </select>
							 </div>
							</div>
							<div class="items">
							
							 <div class="item"><span class="item_name">单价：</span>
								<input type="text" class="text" id="money" onBlur="c(this,'save_item')" /></div>
						   
							 <div class="item"><span class="item_name">故障类型：</span>
								<select class="text2" id="error" onBlur="c(this,'save_item')">
									<option>车胎故障</option>
									<option>车身刮伤</option>
									<option>发动机故障</option>
									<option>其他</option>
								</select>
							 </div>
							</div>
						</div>
						<div class="boxbt">
							<input type="button" value="保存" class="botton"  id="save_item" onClick="s_item()" ></div>
		</div>-->
	<!--新建项目弹窗结束-->	
	</body>
</html>