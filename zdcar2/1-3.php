<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>销售退货开单</title>
		<link rel="stylesheet" href="css/index.css" />
		<script src="js/js.js"></script>
	</head>

	<body>
		<div class="back" id="back"> </div>
		<div class="box">
			<div class="box_title">
				<h4 class="caption"> 开单信息 </h4>
				<div class="close">
					<input type="button" class="botton" value="保存" />
				</div>
			</div>
			<div class="boxbt">
				<div class="box">
					<div class="box_title">
						<h4 class="caption">商品明细</h4>
                        <div class="close">
						<input type="button" value="新建" class="toolbt" onClick="showdiv()" />
						<input type="button" value="选择" class="toolbt" onClick="showdiv1()" />
                        </div>
					</div>
					<div id="bg"></div>

						<div id="bg1"></div>
						<div id="show1">
							<div class="showdiv">

								<div>
									<input type="search" value="请输入关键字" class="text" />
									<input type="button" value="搜索" class="botton" />
								</div>
								<br />
								<br />
								<div>
									<table class="table1" cellspacing="0">
										<tr>

											<td>商品编码</td>
											<td>商品名称</td>
											<td>品牌</td>
											<td>适用车型</td>
											<td>单位</td>
											<td>销售价</td>
											<td>库存</td>
											<td>操作</td>
										</tr>
										<tr>
											<td colspan="8">没有数据</td>
											<!--
                                                                     	作者：1003316758@qq.com
                                                                     	时间：2016-01-06
                                                                     	描述：这里读取出来的数据，是要自动形成一个列表，如有必要可翻页
                                                                     -->
										</tr>
									</table>

								</div>
							</div>
							<input id="btnclose" type="button" value="保存" class="botton" onclick="hidediv1()" />
							<input id="btnclose" type="button" value="关闭" class="botton" onclick="hidediv1()" />
						</div>
					</div>
					<!--
                	作者：1003316758@qq.com
                	时间：2016-01-05
                	描述：分界线
                -->
					<div class="divtable">
						<table class="table1" cellpadding="0" cellspacing="0">
							<tr>
								<td>序号</td>
								<td>商品编码</td>
								<td>商品名称</td>
								<td>品牌</td>
								<td>规格</td>
								<td>适用车型</td>
								<td>单位</td>
								<td>销售单价</td>
								<td>数量</td>
								<td>优惠</td>
								<td>金额</td>
								<td>领料人员</td>
								<td>商品备注</td>
								<td>操作</td>
							</tr>
							<tr>
								<td colspan="14" class="">暂无项目清添加</td>
							</tr>
						</table>
					</div>
                  </div>
                  </div>
	</body>

</html>