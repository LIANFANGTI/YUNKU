<?php
   	require_once 'function.php';
 ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>订单管理</title>
		<link rel="stylesheet" href="css/index.css" />
        <script src="js/js.js"></script>
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/1-2.js"></script>
		<!-- bt框架-->
			<script src="js/bootstrap.min.js"></script>
			<link href="css/bootstrap.min.css" rel="stylesheet" />
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- bt框架End-->
	</head>
                                              
	<body>
		<div id="main">
		    <div class="box">
				<div class="box_title" onClick="$('#cxtj').toggle(200);$('#cx').toggle(300);$('#cx').toggle(100);">
					<h4 class="caption">查询条件</h4>
				</div>
                <div class="box_content" id="cxtj"  style="display:none;">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-1 control-label">单号</label><div class="col-sm-3"><input type="text" class="form-control" id="bid" onKeyUp="cxbill(this)"  placeholder="请输入单号" /></div>
							<label class="col-sm-1 control-label">姓名</label><div class="col-sm-3"><input type="text" class="form-control" id="bkh"  onKeyUp="cxbill()" placeholder="请输入客户姓名" /></div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">结算状态</label>
							<div class="col-sm-3">
								<select class="form-control">
									<option>未选择</option>
									<option>已结算</option>
									<option>未结算</option>
								</select>
							</div>
							<label class="col-sm-1 control-label">结算方式</label>
							<div class="col-sm-3">
								<select class="form-control">
									<option>未选择</option>
									<option>支付宝</option>
									<option>微信</option>
									<option>现金</option>
									<option>其它</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">业务类型</label>
							<div class="col-sm-3">
								<select class="form-control">
									<option>未选择</option>
									<option>洗车</option>
									<option>美容</option>
									<option>保养</option>
									<option>改装</option>
									<option>其它</option>
								</select>
							</div>
							<label class="col-sm-1 control-label">接待人员</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
		
   
			<hr />
            <div class="table1">
			<table  class="table table-bordered table-condensed table-hover table-striped" id="cxbill">
				<tr>
					<td>序号</td>
					<td>单号</td>
					<td>开单日期</td>
					<td>客户名称</td>
					<td>联系手机</td>
					<td>车牌号</td>
					<!--<td>车型</td>-->
					<td>接待人</td>
					<td>应收金额</td>
					<!--<td>已收金额</td>
					<td>尚欠金额</td>-->
					<td>结算日期</td>
					<td>结算方式</td>
					<td>业务状态</td>
					<td>结算状态</td>
					<td>业务类型</td>
					<td>备注</td>
                    <td>操作</td>
				</tr>
                <?php 
				    isset($_GET["page"])?$pg=$_GET["page"]:$pg=1;
					$db->select("bill","count(*) as ct","del and company=".$cp."");$bills = $db->fetchArray(MYSQL_ASSOC);
					$zjl=$bills[0]["ct"];
					if($zjl!=0){
						$page = new Page($zjl,10); 
						$db->select("bill", "*","del and company=".$cp."  ".$page->limit1()."");$bills = $db->fetchArray(MYSQL_ASSOC);
						$c=0;
						
						foreach($bills as $row){
							$c++;
							//echo $row["kehu"]."<br>";
							$db->select("kehu", "*", "id=".$row["kehu"]."");$kehu = $db->fetchArray(MYSQL_ASSOC);
							
							$jsfs="<select><option>支
							付宝付款</option><option>微信付款</option><option>现金付款</option>
										   <option>合作商付款</option></select>";
							$ywzt="<select><option>完成中</option><option>已完成</option></select>";
							$ywlx="<select><option>美容</option><option>维修</option><option>保养</option>
										   <option>改装</option></select>";
							echo"<tr>
								<td>".$c."</td>
								<td><a href='ebill.php?bid=".$row["id"]."'>".$row["bid"]."</a></td>
								<td>".$row["date"]."</td>
								<td>".$kehu[0]["name"]."</td>
								<td>".$kehu[0]["phone"]."</td>
								<td>".$kehu[0]["carid"]."</td>
								
								<td>员工一</td>
								<td><b style='color:#b67f00;'>".($row["zje"]*1)."￥</b></td>

								<td>".$row["jsdate"]."</td>
								<td>".$jsfs."</td>
								<td>".$ywzt."</td>
								<td>".jszt($row["zt"])."</td>
								<td>".btype($row["btype"])."</td>
								<td>".$row["tips"]."</td>
								<td><input type='button' class='btn btn-danger btn-xs' value='删除' onClick='dbill(".$row["id"].")'></td>
							</tr>";
						}
						 echo "<tr><td colspan='18'> <div class='page'>".$page->showpage()."</td></tr></div>"; 
				}else {
						echo "<tr><td colspan='18'>暂无交易订单</td></tr></div>";
						}
					
					
					


	
	
	?>

				
			</table>
          </div>
		</div>

	</body>

</html>