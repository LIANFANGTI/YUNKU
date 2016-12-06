<!DOCTYPE html>
<html>
	<?php	require_once 'function.php';  ?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>收银</title>
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/shouyin.js?v=<?php echo time();?>"></script>  
		<script src="js/js.js?v=<?php echo time();?>"></script> 
		<script src="//cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/shouyin.css" rel="stylesheet" />
		<style>
			#noviptb,#viptb,#isnulltb{
				display:none;
			}
			.input_td{
				border:0px;
			
			}
			.round{
					/*text-align:center;*/
					height:80px;
					width:80px;
					overflow:hidden;
					border:4px solid white;
					border-radius:100px;
			}
			.expline{
				background:-webkit-gradient(linear, 0% 0%, 100% 0%, from(#62c788), to(#00a483));
				
				/*border-radius: 0.5em;*/
				width:100px;
				border-bottom: 7px solid #32bf25;
				margin:0px;
				margin-left:10%;
				padding:0px;float:left;
				cursor:pointer;
			}
			.expline2{
				background:-webkit-gradient(linear, 0% 0%, 100% 0%, from(#62c788), to(#00a483));
				
				/*border-radius: 0.5em;*/
				width:100px;
				border-bottom: 7px solid #dbdad6;
				margin:0px;
				padding:0px;float:left;
			}
		</style>
	</head>

	<body onload="pageload()">
	<?php 
	/*公司项目列表读取*/
		$db->select("item","*","company=".$cp);$item = $db->fetchArray(MYSQL_ASSOC);
		$items="";
		if(!empty($item)){
			foreach($item as $row){
				$items.="<option value='".$row["id"]."' >".$row["itemname"]."</option>";
			}
		}else{
			$items="<option value='0'>您尚未添加项目</option>";
		}
		/*客户车辆列表读取*/
		
		
	?>
	<input type="hidden" value="<?php echo $items; ?>" id="ItemList">
	<input type="hidden" value="<?php echo $cp; ?>" id="company">
	<input type="hidden" value="<?php echo $USERID; ?>" id="USERID">
	<script> 
		//alert(company.value)
	</script>

		<div class="container-fluid">
			<div class="input-group">
				<input type="search" placeholder="请输入手机号或姓名" id="SouSuo" onkeyup="enter(this.value)" class="form-control" />
				<span class="input-group-btn"><button class="btn btn-info" type="button" onclick='khcx(SouSuo.value,1)'>搜索</button></span>
			</div>
			<div class='radio'>
				<label><input type="radio" name="SearchMode" value="kehu" checked="checked" onclick='khcx(SouSuo.value,1)' >客户</label>&nbsp
				<label><input type="radio" name="SearchMode" value="bill" onclick='khcx(SouSuo.value,1)'>订单(增加消费)</label>
				<!--
				<label><input type="radio" name="SearchMode" value="shop" onclick='khcx(SouSuo.value,1)'>搜零件</label>
				<label><input type="radio" name="SearchMode" value="item" onclick='khcx(SouSuo.value,1)'>搜项目</label>
				<label><input type="radio" name="SearchMode" value="car" onclick='khcx(SouSuo.value,1)'>搜车辆</label>
				-->
			</div>
			
		</div>
		<!--
        	作者：1003316758@qq.com
        	时间：2016-03-14
        	描述：检索是会员
        -->
		<div class="container" id="viptb">
			<table class="table table-bordered table-condensed table-hover table-striped">
				<thead>
					<th>会员卡号</th>
					<th>客户名称</th>
					<th>手机号码</th>
					<th>余额</th>
					<th>积分</th>
					<th>创建时间</th>
					<th>会员等级</th>
					<th colspan="4">操作</th>
				</thead>
				<tbody id="viptba">
				
				</tbody>
				</table>
				</div>
				<!--      	作者：1003316758@qq.com  时间：2016-03-14    	描述：检索是非会员-->
				<div class="container" id="noviptb">
					<table class="table table-bordered table-condensed table-hover table-striped">
						<thead>
							<th>会员卡号</th>
							<th>客户名称</th>
							<th>手机号码</th>
							<th>余额</th>
							<th>积分</th>
							<th>创建时间</th>
							<th>会员等级</th>
							<th colspan="4">非会员，点击成为会员即可成为会员</th>
						</thead>
						<tbody  id="noviptba">
							<td>后台调取</td>
							<td>后台调取</td>
							<td>后台调取</td>
							<td>后台调取</td>
							<td>后台调取</td>
							<td>后台调取</td>
							<td>后台调取</td>
							<td><a class="btn btn-primary btn-xs" data-toggle="modal" href="#vip">成为会员</a></td>
							<td><a class="btn btn-primary btn-xs" data-toggle="modal" href="#addcz2">添加充值</a></td>
							<td><a class="btn btn-primary btn-xs" data-toggle="modal" href="#addxf2">添加消费</a></td>
							<td><a class="btn btn-primary btn-xs" data-toggle="modal" href="#addcar">添加车辆</a></td>
						</tbody>
						</table>
				</div>
						<!--第三部分：数据库不存在此人,所有选项不是必填项-->
						<div class="container" id="isnulltb" style="display:none;">
							
							<table class="table table-bordered table-condensed table-hover table-striped">
								<thead><th colspan=5>无匹配客户，请添加客户信息</td></thead>
								<div id="tbody1"> 
									<thead>
										<th>姓名</th>
										<th>手机号码</th>
										<th>车牌号</th>
										<th>操作</th>	
									</thead>
									<tbody>
										<td><input type="text" name='KehuInfoInput' placeholder="手动输入" onfocus='Namefocus(this)' id="KehuName" class="form-control btn-xs text-center"></input></td>
										<td><input type="text" name='KehuInfoInput' placeholder="手动输入" onfocus='Namefocus(this)' id="KehuPhone" class="form-control btn-xs text-center"></input></td>
										<td><input type="text" name='KehuInfoInput' placeholder="手动输入" onfocus='Namefocus(this)' id="KehuCarid" class="form-control btn-xs text-center"></input></td>
										<td style="vertical-align:middle;"><a class="btn btn-primary btn-xs" href="javascript:SaveKehu()">保 存</a></td>  
									</tbody>
								</div>
							</table>
						</div>
						<div class="container-fluaid" id="TableBody" style="display:none;">
						</div>
						<div class="container"><div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<table id='cxbill' class='table table-bordered table-hover table-striped'></table>
							</div>
						</div></div>
						
						<a href="#JieSuanMsgBox" class='btn btn-danger' data-toggle="modal" id="JiesuanTestButton" style="display:none;">结算失败（测试按钮)</a> 
						<script src="js/jquery.js"></script>
						<script src="js/bootstrap.min.js"></script> 
					    
				
 <!--#################################################弹窗区#################################################-->
 
 
<!-- 模态弹出窗内容>添加消费 -->
		<div class="modal dade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addxf">
			<div class="modal-dialog modal-lg">
				<div class="modal-content text-center">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
							<span class="fa fa-times fa-lg"></span></span><span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">快速添加消费</h4>
					</div>
					<div class="modal-body text-center">
						<div class="row">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th><span class="fa fa-calendar-times-o"> 日期</span></th>
										<th><span class="fa fa-wrench"> 项目</span></th>
										<th><span class="fa fa-money"> 金额</span></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type="date" class="form-control btn-xs"></td>
										<td><input type="text" class="form-control btn-xs"></td>
										<td><input type="text" class="form-control btn-xs"></td>
									</tr>
								</tbody>
							</table>
							<input type="button" class="btn btn-primary btn-sm" value="添加消费" />
						</div>

					</div>
					<div class="modal-footer text-center">
						<button type="button" class="btn btn-primary">保存</button>
					</div>
				</div>
			</div>
		</div>
			
		
<!-- 模态弹出窗内容>充值记录 -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addcz">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true"><span class="fa fa-times fa-lg">X</span></span></span>
							<span class="sr-only">X</span>
						</button>
						<h4 class="modal-title">充值记录</h4>
						
					</div>
					<div class="modal-body text-center">
						<div class="row">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<!--<tr>
										<td colspan=6><input type="search" class="form-control" placeholder="请输入交易号或日期查询"/></td>
									</tr>-->
									
									<tr>
										<th><span class="fa fa-money">序号</span></th>
										<th><span class="fa fa-calendar-times-o"> 时间</th>
										<th><span class="fa fa-money"> 金额</th>
										<th><span class="fa fa-credit-card"> 支付方式</th>
										<th><span class="fa fa-credit-card"> 备注</th>
										<th  name='edit' style='display:none;'><span class="fa fa-credit-card"> 操作</th>
									</tr>
								</thead>
								
								<tbody id="czjla">
								</tbody>
								
								<tr id="addcz1" style="display:none;">
									<td colspan=1>
										<input type='text' class="form-control btn-xs" id="money" onChange="isnum(this)" placeholder="请输入充值金额">
									</td>
									<td colspan=2>
										<select class="form-control btn-xs" id="czfs">
											<option value="0">选择支付方式</option>
											<option value="1">支付宝</option>
											<option value="2">微信</option>
											<option value="3">现金</option>
											<option value="4">银联卡</option>
											<option value="5">其他</option>
										</select>
									</td>
									<td><input type="text" class="form-control btn-xs" placeholder="备注信息" id="tips"></td>
									<td><input type="button" value="提交" class="btn btn-primary btn-sm" onclick="tjcz()" /></td>
								</tr>			
							</table>
							
						</div>
						
					</div>
					<div class="modal-footer">
						<b id="KehuInfo"></b>
					</div>
				</div>
			</div>
		</div>		

		
<!-- 模态弹出窗内容  消费记录 -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="xfjl">
		<div class="modal-dialog modal-lg"">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">
							<span class="fa fa-times fa-lg">X</span>
						</span>
						<span class="sr-only">X</span>
					</button>
					<h4 class="modal-title">消费记录</h4>
				</div>
				<div class="modal-body text-center">
					<div class="row">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><span class="fa fa-calendar-times-o">日期</span></th>
									<th><span class="fa fa-money">总额</span></th>
									<th><span class="fa fa-money">未结</span></th>
									<th><span class="fa fa-wrench">类型</span></th>
									<th><span class="fa fa-wrench">编码</span></th>
									<th><span class="fa fa-wrench">结算状态</span></th>
								</tr>
							</thead>
							<tbody id="xfjla">
								<tr>
									<td>后台调取</td>
									<td>后台调取</td>
									<td>后台调取</td>
								</tr>
								<tr>
									<td><input type="date" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs" /></td>
									<td><input type="text" class="form-control btn-xs"></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
			<div class="modal-footer">
				<div class="modal-footer" id="addxfa" style="display:none;" >
				</div>
			</div>
		</div>
		</div>
	</div>
	

<!-- 模态弹出窗内容 快捷消费 -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="kjxf">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">
							<span class="fa fa-times fa-lg" id="CloseButton">X</span>
						</span>
						<span class="sr-only">Close</span>
				    </button>
					<h4 class="modal-title">快捷消费</h4>
				</div>
				<div class="modal-body text-center">
					<div class="row">
						<table class="table table-striped table-bordered">
							<tr>
								<td colspan="3" id="date">
									<select name="CarList" class='input_td'  id="CarList" onchange="QaddCar(this)"></select>
								</td>
								<td colspan="3" id="type"><?php echo btype(3);$type=btype(0);?></td>
							</tr>
							<tr>
								<td colspan=6 style="background:#d9d9d9;"><h5 style="margin:0px;"><b>项目</b></h5></td>
							</tr>
							<tr>
								<th>序号</th>
								<th>工时</th>
								<th>项目名称</th>
								<th>备注</th>
								<th>金额</th>
								<th>操作</th>
							</tr>
							<tbody id="itemr">
								
							</tbody>  
							<tr>  
								<td colspan="6"><a href='#AddNewItem' class="btn btn-info btn-sm" data-toggle="modal" onClick="AddItemButton()">添加项目</a></td>
							</tr>	
							</table>
							<table class="table table-striped table-bordered">
								<tr>
									<td colspan=6 style="background:#d9d9d9;"><h5 style="margin:0px;"><b>零件</b></h5></td>
								</tr>
								<tr>
									<th>序号</th>
									<th>数量</th>
									<th>商品名称</th>
									<th>单价</th>
									<th>金额</th>
									<th>操作</th>
								</tr>
								<tbody id="shops"></tbody> 
								<tr>
									<td colspan="6">
									<a class="btn btn-warning btn-sm" data-toggle="modal" href="#chosesp" onclick="SearchShop('',1)">添加零件</a>
									</td>
								</tr>
							
							<tr> 
								<td colspan="2" align="center"><h4 style=" color:red;" id="zje">总金额：0元</h4>
								<td colspan="5" align="center"><button type="button" class="btn btn-group-xs"  onClick="Renew()">取消</button>
								<button type="button" class="btn btn-group-xs btn-info"  onClick="SubmitBill(0)">挂单</button>
								<button type="button" class="btn btn-group-xs btn-success" onClick="SubmitBill(1)" id="quickPayButton">结算</button>  </td>
							</tr>
							<tr><td colspan="6"></td></tr>
						</table>  
					</div>
				</div>
			</div>
		</div>
	</div>		
	
	
<!-- 模态弹出窗内容 车辆信息 -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="carinfo">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">
							<span class="fa fa-times fa-lg">X</span>
						</span>
						<span class="sr-only">X</span>
				    </button>
					<h4 class="modal-title">车辆信息</h4>
				</div>
				<div class="modal-body text-center">
					<div class="row">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><span class="fa fa-calendar-times-o">序号</span></th>
									<th><span class="fa fa-car">车牌</span></th>
									<th><span class="fa fa-car">VIN码</span></th>
									<th><span class="fa fa-car">最新公里数</span></th>
									<th><span class="fa fa-car">保险到期日</span></th>
									<th><span class="fa fa-car">年检到期日</span></th>
									<th><span class="fa fa-car">备注</span></th>
									<th><span class="fa fa-car">操作</span></th>
								</tr>
							</thead>
							<tbody id="carinfo1">
							
							</tbody>
						</table>
						<table class="table" id="addcar" style="display:none;">
							<tr>
								<td><input type="text" class="form-control btn-xs" placeholder="车牌号(必填)" id="addCarid"></td>
								<td><input type="text" class="form-control btn-xs" placeholder="VIN" id="addVin"></td>
								<td><input type="text" class="form-control btn-xs" placeholder="最新公里数" id="addKm"></td>
								<td><input type="date" class="form-control btn-xs" placeholder="保险到期日" id="addBxDate" style="width:140px;"></td>
								<td><input type="date" class="form-control btn-xs" placeholder="年检到期日" id="addNjDate" style="width:140px;"></td>
								<td><input type="text" class="form-control btn-xs" placeholder="备注" id="addTips"></td>
								<td colspan=2><input type="button" class="btn btn-primary btn-sm" onclick="scar()" value="提交" /></td>
							</tr>
						</table>
					</div>
					<input type="button" class="btn btn-primary btn-sm" onclick="addcar(this)" value="增加车辆" />
				</div>
				<div class="modal-footer">
					
				</div>
			</div>
		</div>
	</div>	
	
	
<!-- 模态弹出窗内容  添加消费 -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="cz">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
					<span class="fa fa-times fa-lg">X</span></span></span><span class="sr-only" id="CloseczWin">X</span>
				</button>
				<h4 class="modal-title">充值</h4>
				</div>
				<div class="modal-body">
					<tr id="addcz1" >
						<td colspan=1>
							<input type='text' class="form-control btn-xs" id="czmoney" onChange="isnum(this)" placeholder="请输入充值金额">
						</td>
						<td colspan=2>
							<select class="form-control btn-xs" id="czfsa">
								<option value="0">选择支付方式</option>
								<option value="1">支付宝</option>
								<option value="2">微信</option>
								<option value="3">现金</option>
								<option value="4">银联卡</option>
								<option value="5">其他</option>
							</select>
						</td>
						<td><input type="text" class="form-control btn-xs" placeholder="备注信息" id="cztips"></td>
						<td><input type="button" value="提交" class="btn btn-primary btn-sm" onclick="tjcz(this)" /></td>
					</tr>	
				</div>
		</div>
	</div>
</div>
<!-- 模态弹出窗内容  用户详情 -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="khinfo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
					<span class="fa fa-times fa-lg">x</span></span></span><span class="sr-only">X</span>
				</button>
				<h4 class="modal-title">客户信息</h4>
				</div>
				<div class="modal-body">
					<div class="modal-header">
						<div class="round" style="margin:0px 0px  10px 45%;" >
							<a href="#">
								<img id="khhead" src="<?php echo "https://ss0.bdstatic.com/7Ls0a8Sm1A5BphGlnYG/sys/portrait/item/c5cae7a78be58880e6b299e4b881e9b1bcdf9e.jpg?1474134957"; ?>" width="80px" height="80px" style="z-index:1001;" ;>	 
							</a>
						</div>
						<b style="color:#000;margin:40px 0px 0px 40%;font-size:16px;" id="khvip"></b>
						<b class='btn btn-warning btn-xs' style='margin-left:20px;' id="khlv">V</b>
						<div style="width:500px;padding-left:50px;margin:5px 0px 5px 0px;display:flex;justify-content:center;" align="center"> 
							<hr class='expline' title='当前经验:1500/3000' id='eline1'>  
							<hr class='expline2'id='eline2'>
						</div>
					</div>	
					<table class="table table-bordered table-condensed table-hover table-striped">
						<tbody id='khinfotab'>
							<tr><td>姓名</td><td>XXX</td></tr>
							<tr><td>手机</td><td>XXXXXXXXXXX</td></tr>
							<tr><td>默认车辆</td><td>XXXXXXX</td></tr>
							<tr><td >备注信息</td><td>XXX</td></tr> 
							<tr><td >微信</td><td><a href="#" onClick="">XX</a></td></tr>
						</tbody>
					</table>
				</div>
			
				<div class="modal-body" style="width:100%;text-align:center;margin-right:auto;margin-left:35%;">
					<img id="khqr" style="display:none;"  width=150 height=150 src=""/>
				</div>
		</div>
	</div>
</div>	

<!-- 模态弹出窗内容  添加消费 -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="JieSuan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
					<span class="fa fa-times fa-lg"></span></span></span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">结算</h4>
				</div>
				<div class="modal-body">
						
				</div>
		</div>
	</div>
</div>	

<!-- 模态弹出窗内容  结算 -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="jiesuan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
					<span class="fa fa-times fa-lg">X</span></span></span><span class="sr-only">X</span>
				</button>
				<h4 class="modal-title">订单结算</h4>
				</div>
				<div class="modal-body">
					<tr id="addcz1" >
						<td colspan=1>
							<input type='text' class="form-control btn-xs" id="czmoney" onChange="isnum(this)" placeholder="请输入充值金额">
						</td>
						<td colspan=2>
							<select class="form-control btn-xs" id="czfsa">
								<option value="0">选择支付方式</option>
								<option value="1">支付宝</option>
								<option value="2">微信</option>
								<option value="3">现金</option>
								<option value="4">银联卡</option>
								<option value="5">其他</option>
							</select>
						</td>
						<td><input type="text" class="form-control btn-xs" placeholder="备注信息" id="cztips"></td>
						<td><input type="button" value="提交" class="btn btn-primary btn-sm" onclick="tjcz()" /></td>
					</tr>	
				</div>
		</div>
	</div>
</div>
	
	
<!-- 模态弹出窗内容  添加消费 -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addxf2">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
						<span class="fa fa-times fa-lg"></span></span></span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">添加消费</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><span class="fa fa-calendar-times-o"> 日期</span></th>
									<th><span class="fa fa-wrench"> 项目</span></th>
									<th><span class="fa fa-money"> 金额</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="date" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs" /></td>
									<td><input type="text" class="form-control btn-xs"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<input type="button" class="btn btn-primary btn-sm" value="添加消费" />
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>	

<!-- 模态弹出窗内容 -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addcar">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
						<span class="fa fa-times fa-lg"></span></span></span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">添加车辆</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><span class="fa fa-calendar-times-o"> 品牌</span></th>
									<th><span class="fa fa-wrench"> 车型</span></th>
									<th><span class="fa fa-money"> 购车日期</span></th>
									<th><span class="fa fa-car"> 车牌</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs"></td>
									<td><input type="date" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs"></td>
								</tr>
							</tbody>
						</table>
						<input type="button" class="btn btn-primary btn-sm" value="新建车辆">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">保存</button>
				</div>
			</div>
		</div>
	</div>	
	
	
<!-- 模态弹出窗内容 添加消费 -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="addxf2">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><span class="fa fa-times fa-lg"></span></span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">快速添加消费</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th><span class="fa fa-calendar-times-o"> 日期</span></th>
									<th><span class="fa fa-wrench"> 项目</span></th>
									<th><span class="fa fa-money"> 金额</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="date" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs"></td>
									<td><input type="text" class="form-control btn-xs"></td>
								</tr>
							</tbody>
						</table>
						<input type="button" class="btn btn-primary btn-sm" value="添加消费" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">保存</button>
				</div>
			</div>
		</div>
	</div>
<!--新建项目 弹窗开始-->
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="AddNewItem" tabindex="-1" style="margin-top:8%;">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><span class="fa fa-times fa-lg">X</span><span class="sr-only"></span></button>
					<h4 class="modal-title">添加项目</h4>
				</div>
				<div class="modal-body">
					
						<div class="row" style="margin:0px 2px;">
									<div class="input-group">
										<span class="input-group-addon">项目名称</span>
										<input type="text"  id="itemname" class="form-control" onfocus="Namefocus(this)" onkeypress="AddItemKeydown(this)" placeholder='项目名称' /> 
									</div> 
						</div>
					
					<br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary" data-dismiss="modal" onClick="AddItem()" id='SaveItemButton'>保存</button>
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
					<button class="close" data-dismiss="modal">
						<span class="fa fa-times fa-lg" id="closeCreateShopButton">X</span>
						<span class="sr-only">X</span>
					</button>
					<h4 class="modal-title">新建商品</h4>
				</div>
				<div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">配件名称</span>
									<input type="text" class="form-control" id="sname" placeholder="必填"/>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">配件品牌</span>
									<input type="text" class="form-control" id="spp" placeholder="必填"/>
								</div>
							</div>
							
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">配件成本</span>
									<input type="text" class="form-control" id="scb" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">建议售价</span>
									<input type="text" class="form-control" id="sdj" />
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" >进货数量</span>
									<input type="text" class="form-control" id="ssl" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon">适用车型</span>
									<input type="text" class="form-control" id="car"/>
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
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary" onclick="sshop()">保存</button>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--商品选择弹窗开始-->
<div class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="chosesp" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content text-center">
			<div class="modal-header">
				<button type="button" class="pull-right" data-dismiss="modal">
					<span class="fa fa-times fa-lg" id="closeChoseShopButton">X</span>
					<span class="sr-only">X</span>
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
							<!--后台读取-->
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
	<div class="modal fade" data-target="modal"  id="JieSuanMsgBox" tabindex="-1" style="z-index:9999;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">结算失败</h4>
				</div>
				<div class="modal-body">
				<h4 id="PayErrorMsg">客户余额不足 已从该客户余额中扣取X元，剩余Y元未结算 请选择结算方式2</h4>
				<div style="margin-top:50px;margin-left:30px;">
					<div id="X" style="width:100%;height:300px;">
						<div style='width:50%;float:left;'>
							<select class="form-control" style='width:90%;' id='PayMode' onChange='PayModeChange(this)'>
								<option value='cz'>充值</option>
								<option value='zfb'>支付宝</option>
								<option value='weixin'>微信</option>
								<option value="cash">现金</option>
								<option value="UnionPay">银联</option>
							</select>
							<div style="width:90%;background:#FFF;">
								<img id="JiesuanLogo" src="<?php ?>" style='width:100%;margin-top:50px;' />
							</div>
						</div>
						<div style='width:200px;height:200px;background:#000;float:left;margin-left:25px;'>
							<img id="PayQrcode" src='img/chongzhi-qr.png' width="200" height="200"/>
						</div>
						<div id="PayAmountBox" style="margin-top:50px;">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" id="PayTitle">充值金额</span>
									<input type="text"  id="ChongzhiAmount"placeholder="请输入充值金额" class="form-control"  onfocus='Namefocus(this)' onchange="isNum(this)" />
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="input-group">
									<span class="input-group-addon" id="PayTitle">支付方式</span>
									<select class="form-control" id="ChongzhiMode"  onfocus='Namefocus(this)'>
										<option value='0'>请选择支付方式</option>
										<option value='1'>支付宝</option>
										<option value='2'>微信</option>
										<option value="3">现金</option>
										<option value="4">银联</option>
										<option value='5'>其他</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					
						<div class="row" style="margin-top:0px;">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary"  onclick="Pay(0,0,this)">确定</button>
							</div>
						</div>
				</div>
		</div>
	</div>
	
</body>
<script>//document.getElementById("JiesuanTestButton1").click()</script>
</html>