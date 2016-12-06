<!DOCTYPE html>
<?php
ini_set('display_errors','On');
	require_once 'function.php';
	$kehu =select("kehu","*","company=".$cp." and del");//客户表读取
	$item = select("item","*","company=".$cp." ");//项目表读取
	$khid=isset($_GET["khid"])?$_GET["khid"]:0;
	function kh($ID,$C){return SELECTA("kehu","id",$ID,$C);}
	if($khid){
		$khname=kh($khid,"name");//客户姓名获取
		$khphone=kh($khid,"phone");	//客户电话获取
		$cartb=select("car2","*","kh=".$khid);//获取用户所有车辆
	}else{
		$khname="请选择客户";
		$khphone="";		
	}
?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>开单-云库</title>
		<link rel="stylesheet" href="css/index.css?v=9" type="text/css" />
		<script src="js/jquery-1.10.2.js"></script>
		<?php $time=time();?>
        <script src="js/js.js?v=<?php echo time();?>"></script> 
		<script charset="gb2312" src="js/1-1a.js?v=<?php echo $time;?>"></script>
		
		<!-- bt框架-->
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
		<!-- bt框架End-->
        <!-- <script src="js/khinfo.js"></script> -->
		 <OBJECT id="WebBrowser" height="0" width="0" classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"VIEWASTEXT></OBJECT>
		 <style>
			.inp{
				width:200px;
			}
		 </style>
	</head>
	<body onLoad="onload('page')">
    <input type="hidden" value="<?php echo $USERID; ?>" id="USERID">
   	<input type="hidden" value="<?php echo $cp; ?>" id="cp"/>
	<input type="hidden" value="<?php echo selecta("company","id",$cp,"name"); ?>" id="CpName"/>
	<div class="back" id="back" ></div>
	<div id="main">
	<table calss="table table-hover" style="margin-left:5%;">
		<tr>
			<td>单号:</td><td><input type="text"  id="billbm" class="text" style="border:0px;"  value="未生成"  /></td>
			<td>时间:</td><td><input type="text"  id="billTime" class="text" style="border:0px;width:250px;"  value="<?php echo date("Y年m月d日H时i分");?>"  /></td>
		</tr>
	</table>
 	<div class="box">
        <div class="box_title">
			<h4 class="caption">开单信息</h4>
            <div class="pull-right"><input type="button" class="btn btn-warning btn-xs" value="生成订单" onClick="SaveBill2()" id="save_bill"/> 	
			</div>
        </div>
        <div class="box_content">
			<table class="table  table-hover " style="width:100%;">
				<tr>
					<td>客户:</td>
					<td>
						<input type="hidden" id="khid" value="<?php echo $khid;?>" />
						<input type="text"  id="khname" class="text" onClick="$('#ChoseKehuButton').click();$('#tj').focus();" style="border:0px;"  value="<?php echo $khname;?>"  data-toggle="modal" onClick="" /> 
					    <a href="#ChoseKehu"  id="ChoseKehuButton" onClick="GetkehuList('',1)" class="btn btn-success btn-xs" data-toggle="modal">选择</a>
					</td>
					<td>客户电话:</td>
					<td  colspan=>
						<input type="text" id="khtel"  value="<?php echo $khphone;?>"  class="form-control inp" />
					</td>
					<td>选择车辆：</td>
					<td>
						<select  type="text" id="carid"  class="form-control inp" onchange="QaddCar(this)">
							<option value='0'>未选择车辆</option>
								<?php 
									$kehucar=SELECT("kehu","*","id=".$_GET["khid"]);
									if(!empty($kehu_c)){
										$defultCar=$kehucar[0]["carid"];
										if($defultCar!=""){
											if(empty($cartb))echo "<option value='-1'>无车辆信息</option><option value=-1>添加车辆</option>";
											foreach($cartb as $row){
												if($row["carid"]==$kehucar[0]["carid"]){
													
													$Selected="selected='selected'";
													$defult='[默认]';
												}else{
													$Selected="";
													$defult='';
												}
												echo "<option value='".$row["carid"]."' $Selected >".$row["carid"]."  ".$defult."</option>";
											}
										}else{
											foreach($cartb as $row){
												echo "<option value='".$row["carid"]."'>".$row["carid"]."</option>";
											}
										}
									}
									
									
								?>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>保险到期日:</td>
					<td><input type="date" id="date_bx"  onchange="updateCarInfo(this)" value="<?php echo $khphone;?>"  class="form-control inp" /></td>
					<td>年检到期日:</td>
					<td><input type="date" id="date_nj"  onchange="updateCarInfo(this)"  value="<?php echo $khphone;?>"  class="form-control inp" /></td>
					<td>行驶证到期日</td>
					<td><input type="date" id="date_xsz" onchange="updateCarInfo(this)"  value="<?php echo $khphone;?>"  class="form-control inp" /></td>
				</tr>
				<tr>
					<td>最新公里数:</td>
					<td><input type="text" id="new_km"  value="<?php echo $khphone;?>"  class="form-control inp" /></td>
					<td>最近公里数:</td>
					<td><input type="text" id="near_km" disabled  value="<?php echo $khphone;?>"  class="form-control inp" /></td>
					<td>订单类型</td>
					<td colspan=><?php echo btype(0); ?></td>
				</tr>
			</table>
			<div class="box" >
				<div class="box_title" onclick="$('#weixiuc').toggle(500);">
					<h4 class="caption">项目</h4>
                	<div class="close">
                	</div>
                </div>
				<div class="box_content" id="weixiuc">
                    <div class="table1">
                        <table class="table table-bordered table-condensed table-hover table-striped" id="itemtb">
                            <tr>
                                <td> 序号 </td>
                                <td>项目名称</td>
                                <td>工时费</td>
                              
                                <td>备注</td>
                                <td>操作</td> 
                            </tr>
                            <tr>
                                <td colspan="13">暂无项目请添加</td>
                            </tr>
                            <tr>
                               <td colspan="13"><a class="btn btn-info btn-xs" data-toggle="modal" href="#addxm" onClick='AddItemButton()'>添加项目</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="boxbt"><h3 class="mny" id="itemrmb"></h3></div>
                </div>
            </div>
            <fieldset style="border:0px">
                <h1 style="margin:20px 40px; float:right;color:#f9af02;" id="rmbs">总价：0元</h1>
            </fieldset>					
<!--弹窗部分代码-->
		<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="citem" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content text-center">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span class="fa fa-times fa-lg"></span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">项目选择</h4>
					</div>
					<div class="modal-body text-center">
						<div class="row">
							<table class="table table-striped table-bordered table-hover">
								<tr>
									<td> 序号 </td>
									<td>项目编码</td>
									<td>项目名称</td>
									<td>项目分类</td>
									<td>备注</td>
									<td>操作</td>
								</tr>
								<tbody id="itemstb">
							<?php 
								$i=0;
								foreach($item as $row){
									echo"<input type='hidden' name='ItemId' value='".$row["id"]."'/>";
									echo"<tr name='items'>";
									echo"<td>".($i+1)."</td>";
									echo"<td name='ItemBm'>".$row["itemid"]."</td>";
									echo"<td name='ItemName'>".$row["itemname"]."</td>";
									echo"<td name='ItemType'>".btypet($row["item_type"])."</td>";
									echo"<td name='ItemTips'>".$row["tips"]."</td>";
									echo"<td><button data-dismiss='modal' class='btn btn-success btn-xs' onclick='ChoseItem(".$i++.")'>选择</button></td>";
									echo"</tr>";
								}
							?>
							</table>
							<a href="#addxm" data-toggle="modal" class="btn btn-primary btn-sm" >新建项目</a>
						</div>

					</div>
					<div class="modal-footer text-center">
						<!--底部内容-->
					</div>
				</div>
			</div>
		</div>
<!--弹窗End-->
<!--新建项目弹窗Start-->
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="addxm" tabindex="-1" style="margin-top:15%;">
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
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--新建项目弹窗End-->
<!--新客户选择弹窗Start-->
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="ChoseKehu" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
					<h4 class="modal-title">选择客户</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="table1">
							<table class="table table-bordered table-condensed table-hover table-striped">
								<tr><td colspan="8"><input type="search"  class="form-control" onKeyUp="GetkehuList(this.value,1)" id="tj" style="border-color:#e48d8b;" placeholder="输入客户信息查询"/></td></tr>
							</table>
							<table class="table table-bordered table-condensed table-hover table-striped" id="kehutb">
								<tr>
									<td>序号</td>
									<td>姓名</td>
									<td>联系电话</td>
									<td>车牌</td>
									<td>备注</td>
									<td>操作</td>
								</tr>
								<tbody id='KehuList'>
								<?php 
								$i=0;
								foreach($kehu as $row){
									echo "<tr class=a".$i.">";
									echo"<td>".($i+1)."</td>";
									echo"<td>".$row["name"]."</td>";
									echo"<td>".$row["phone"]."</td>";
									echo"<td>".$row["kehu_c"]."</td>";
									echo"<td>".$row["car_type"]."</td>";
									echo"<td>".$row["carid"]."</td>";
									echo"<td>".$row["tips"]."</td>";
									echo"<td><button class='btn btn-primary btn-xs' data-dismiss='modal' onclick='ckehu(\"kehutb\",".$i.",".$row["id"].")'>选择</button></td>";
									echo"</tr>";									$i++;
								}
								?>
								</tbody>
								<tr class="aa">
									<td colspan="8"><a href="#AddKehu" id="addkh"  type="button"  class="btn btn-info"  data-toggle="modal" onClick="">新建客户</a></td>
								</tr>
							</table>
						</div>
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<!--<button class="btn btn-primary" data-dismiss="modal" onClick="sitem()">保存</button>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--新客户选择弹窗End-->
<!--新建客户弹窗-->
	<div class="modal fade" data-target="modal"  id="AddKehu" tabindex="-1" style="z-index:9999;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					
					<button class="close" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
					<h4 class="modal-title">新建客户</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">客户姓名</span>
									<input type="text" name="KehuInfoInput(必填)"  class="form-control"  id="KehuName" onfocus='Namefocus(this)' />
								</div>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" >联系电话</span>
									<input type="text" name="KehuInfoInput" placeholder="必填" class="form-control" id="KehuPhone" onfocus='Namefocus(this)'/>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">车牌号</span>
									<input type="text" name="KehuInfoInput" placeholder="必填" class="form-control" id="KehuCarid" onfocus='Namefocus(this)'/>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">VIN码</span>
									<input type="text"  class="form-control" id="KehuCarvin"/>
								</div>
							</div>
						</div>
						</br>
						<div class="row">
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">公里数</span>
									<input type="text" class="form-control" id="KehuCarkm"/>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">备注</span>
									<input type="text"  class="form-control" id="KehuTips"/>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary"   onclick="SaveKehu()">保存</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- 客户选择 -->
		<div class="boxbt"> </div></div><!--商品添加  data-dismiss="modal"-->
			<div class="toolbox" id="ckehu" style="width:800px;"><div class="box_title" ><h4 class="caption">客户选择</h4> <div class="close" onClick="close2()">×</div></div>
				<div class="box_content" style="height:300px; overflow:auto; margin:0px;">
					<div class="table1">
						<table cellpadding="0" cellspacing="0">
							<tr><td colspan="8">
								<input type="search"  class="form-control" onKeyUp="tjcx()" id="tj" placeholder="输入客户信息查询"/>
							 </td></tr>
						</table>
						<table cellpadding="0" cellspacing="0" id="kehutb"> 
							<tr>
								<td>序号</td>
								<td>姓名</td>
								<td>联系电话</td>
								<td>通讯地址</td>
								<td>车牌</td>
								<td>备注</td>
								<td>操作</td>
							</tr>
							
							 <?php 
								$i=0;
								foreach($kehu as $row){
									echo "<tr class=a".$i.">";
									echo"<td>".($i+1)."</td>";
									echo"<td>".$row["name"]."</td>";
									echo"<td>".$row["phone"]."</td>";
									echo"<td>".$row["kehu_c"]."</td>";
									echo"<td>".$row["car_type"]."</td>";
									echo"<td>".$row["carid"]."</td>";
									echo"<td>".$row["tips"]."</td>";
									echo"<td><button class='toolbt' onclick='ckehu(\"kehutb\",".$i.",".$row["id"].")'>选择</button></td>";
									echo"</tr>";
									$i++;
								}
							?>
							
							<tr class="aa">
								<td colspan="8">
									<input id="addkh"  type="button"  class="btn btn-info" value="新建客户" onClick="addtr('kehutb')"/></td>
								</tr>
						 </table>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
		<div id="printBody" style="display:none;">
			<!--StartPrint-->
			<b id="DingDanBM"></b>
			<div class="container-fluid">
				<table class="table table-bordered  table-striped">
					<thead>
						<tr class="text-center">
							<td colspan="8" >
								<h4><b id="CompanyName">自点车坊开单表</b></h4>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr class="text-left">
							<td colspan="8">
								<h4 id="Sdate">客户信息:</h4>
							</td>
						</tr>
						<tr>
							<td colspan="2" id="KhName">顾客姓名:</td>
							<td colspan="2" id="Carid">车牌号:</td>
							<td colspan="4" id="phone" >顾客电话:</td>
						</tr>
						<tr class="text-left">
							<td colspan="8"><b>施工信息</b></td>
						</tr>
						<tr class="text-center">
							<td colspan="2"><b>项目</b></td>
							<td colspan="2"><b>金额</b></td>
							<td colspan="2"><b>施工人员</b></td>
							<td colspan="2"><b>备注</b></td>
						</tr>
						<tbody id="BillItemList">
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>
						
						</tbody>
						<tr>
							<td colspan="2" class="text-right">合计：</td>
							<td colspan="6"></td>
						</tr>
						<tr class="text-center">
							<td colspan="8">
								<span class="col-lg-4"><b>美容技师签字：</b></span>
								<span class="col-lg-4 "><b>质检签字：</b></span>
								<span class="col-lg-4"><b>顾客签字：</b></span>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="h6">注意：①此单据中预计费用是预估费用，实际费用以结算中最终费用为准。</p>
				<p class="h6">②将车辆教给我店检修时，已提示将车内贵重物品自行收起并妥善保管。如有遗失本店概不负责。</p>
			</div>
			
			<!--endprint-->
		</div>
	</body>

</html>