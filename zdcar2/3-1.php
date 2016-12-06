<!DOCTYPE html>
<html>
<?php
   	require_once 'function.php';
 ?>
	<head>
		<meta charset="utf-8" />
		<title>商品管理</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
		<script src="js/js.js?v=<?php echo $time;?>"></script>
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/3-1.js?v=<?php echo $time;?>""></script>
			<!-- bt框架-->
			<script src="js/bootstrap.min.js"></script>
			<link href="css/bootstrap.min.css" rel="stylesheet" /> 
			<link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- bt框架End-->
	</head>

	<body>
		<div class="main">
			<div class="box">
				<div class="box_title"><h4 class="caption">仓库</h4>
				</div>
                	<table class="table1">
                    	<tr><td><input type="search"  class="form-control" onKeyUp="SearchShop(this.value,1)" id="tj" placeholder="输入商品关键字或编码"/></td></tr>
                    </table>
					<table class="table table-striped table-bordered table-hover">
						<tbody id="ShopTab"></tbody>
					</table>
				

			</div>
		</div>
	<div class="modal fade" data-target="modal" data-keyboard="false" data-backdrop="static" id="ShopUp" tabindex="-1">
			<div class="modal-dialog modal-xs">
				<div class="modal-content">
					<div class="modal-header">
						<button class="pull-right" data-dismiss="modal"><span class="fa fa-times fa-lg"></span><span class="sr-only"></span></button>
						<h4 class="modal-title">商品上传</h4>
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
										<input type="text" class="form-control text-center" id="thsl" placeholder="输入退数量">
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
	<div class="modal fade" data-target="modal"  id="addsp" tabindex="-1" style="z-index:9999;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal">
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
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<button class="btn btn-primary" onclick="sshop()">保存</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>

</html>