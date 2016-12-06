<!DOCTYPE html>
<html>
<?php
require_once 'function.php';
?>
	<head>
		<meta charset="utf-8" />
		<title>云库汽车管理系统</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
	</head>

	<body>
		<div id="header">
			<ul>
				<li style="width:100px; margin:0px 0px 5px 20px;">
					<a href="../yunku/index.php"><img src="../yunku/images/yunku-logo-150X400-2.png"  height="40" width="" /></a>
				</li>
				<li>
					<a href="#"></a>
				</li>
				<li>
					<a href="#"></a>
				</li>

				<li><a href="1-1a.php" target="window">开单</a>
					<!-- <ul>
						<li><a href="1-1a.php" target="window">开单</a></li> -->
						<!--
                        	作者：1003316758@qq.com
                        	时间：2015-12-29
                        	描述：开单这一块，开完之后 还有一个状态，这个状态是款项结清了没有。
                        -->
						<!--<li><a href="1-2.php?" target="window">单据管理</a></li> -->
						<!-- <li><a href="1-3.php" target="window">销售退货开单</a></li> 
						<li><a href="1-4.php" target="window">销售退货管理</a></li>
						
                        	作者：1003316758@qq.com
                        	时间：2015-12-29
                        	描述：在页面的下方直接有一个汇总的功能，并且可以选择时间的范围
                        -->
					<!-- </ul> -->
				</li>
				<li>
					<a href="#"></a>
				</li>
				<li>
					<a href="shouyin.php" target="window">收银</a>
				</li>
				<!--<li><a href="#">采购</a>
					<ul>
						<li><a href="2-1.html" target="window">采购开单</a></li>
						<li><a href="2-2.html" target="window">采购单管理</a></li>
						<li><a href="2-3.html" target="window">采购退货开单</a></li>
						<li><a href="2-4.html" target="window">采购退货管理</a></li>
						<!--
                        	作者：1003316758@qq.com
                        	时间：2015-12-29
                        	描述：在页面的下方直接有一个汇总的功能，并且可以选择时间的范围
                       
					</ul> 
				</li>-->
				<li>
					<a href="#"></a>
				</li>
				<li><a href="#">仓库</a>
					<ul>
						<li><a href="3-1.php?" target="window">商品管理</a></li>
						<li><a href="3-2.php?" target="window">库存预警</a></li>
						<!--
                        	作者：1003316758@qq.com
                        	时间：2015-12-29
                        	描述：库存已经这一块 ，比如说库存<=10个，那么在可视化界面里面就会出现一个提示
                        		这个提示是说明库存不多了。-->
                       
					</ul> 

				</li>
				<!--<li><a href="#">客户</a>
					<ul>
						<li><a href="4-1.php" target="window">客户管理</a></li>
                        <!--<li><a href="/zdcar2/learn/index.php" target="window">客户消费记录</a></li>
						<li><a href="4-2.html" target="window">供应商管理</a></li>
						<!--<li><a href="4-3.html" target="window">会员卡办理</a></li>
						
                                                      	作者：1003316758@qq.com
                                                      	时间：2015-12-29
                                                      	描述：
                                                      	一、客户管理里面有客户的充值记录、消费金额、每次的消费时间和消费项目
                                                      	会员卡办理里面  选择会员卡套餐，
                                                      	套餐类型自己输入，类型有打折、年限、金额、等级
                                                     
					</ul>

				</li> -->
						<li>
					<a href="#"></a>
				</li>
				
				<li><a href="#">统计</a>
					<ul>
						<li><a href="5-1.php" target="window">营业额统计</a></li>
						<li><a href="5-2.html" target="window">会员卡统计</a></li>
					</ul>

				</li>
				<li>
					<!--<a href="vidio/" target="window">技术共享</a>-->
					<ul>
					</ul>

				</li>
				<li>
					<a href="#"></a>
				</li>
				<li>
					<a href="#"></a>
				</li>
				<li>
					<a href="#"></a>
				</li>
				<li>
					                	<div class="head">
                	<img  src="<?php echo $hd;?>" width="30" height="30">< 
					</div>
				</li>
				<li>

                    <a href="#">
						<?php echo $cpname; ?>
					</a>
					<!--
                        	作者：1003316758@qq.com
                        	时间：2015-12-28
                        	描述：这里的阿里巴巴就是用户的姓名
                        -->
					<ul>
						<li><a href="../yunku/logout.php">退出</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="main">
		<iframe id="window" name="window" src="shouyin.php">
			<!--框架内容-->
		</iframe>

		</div>

	</body>

</html>