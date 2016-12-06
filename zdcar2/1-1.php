<!DOCTYPE html>
<?php
	require_once 'function.php';
	$db->select("kehu","*","company=".$cp." and del");
	$kehu = $db->fetchArray(MYSQL_ASSOC);
	$db->select("item","*","company=".$cp." ");
	$item = $db->fetchArray(MYSQL_ASSOC);
	$db->select("shop","*","company=".$cp." and del");
	$shop = $db->fetchArray(MYSQL_ASSOC);
    //print_r($result); //打印所有数组元素
	isset($_GET["khid"])?$khid=$_GET["khid"]:$khid=0;
	//echo $khid;
	                	if($khid){
						$khname=kh($khid,"name");
						$khphone=kh($khid,"phone");	
					}else{
						$khname="请选择客户";
						$khphone="";		
					}
		//echo $khname."<br>".$khphone;			
	$rq=date('Ymd');
	$bm="XM".$rq;
?>

<html>

	<head>
		<meta charset="utf-8" />
		<title>云库汽车管理系统</title>
		<link rel="stylesheet" href="css/index.css" type="text/css" />
        <script src="js/js.js"></script>
         <script src="js/khinfo.js"></script>
        <script src="js/jquery-1.10.2.js"></script>
	</head>

	<body onLoad="onload('page')">
   		<input type="hidden" value="<?php echo $cp; ?>" id="cp"/>
		<div class="back" id="back" ></div>
		<div id="main">
 			<div class="box">
           		<div class="box_title"><h4 class="caption">开单信息</h4>
              	 	<div class="close"><input type="button" class="botton" value="保存" onClick="save_bill()" id="save_bill"/></div>
             </div>
            	<div class="box_content">
                <?php

					
				?>
                    <fieldset style="width:95%; padding:0px 20px 5px 40px; border-color:rgba(255,255,255,0.4) ">
                    	<legend>客户选择</legend>
                        客户：<input type="text"  id="khname" class="text" value="<?php echo $khname;?>"  onClick="add('ckehu')" onblur="c(this,'save_bill')"/>
                        客户电话：<input type="text" id="khtel" value="<?php echo $khphone;?>"  class="text" onDblClick="add('qrbox')"  disabled/>
						<input type="hidden" id="khid" value="<?php echo $khid;?>" />
  
                    	<select  type="text" id="b_type" class="text" >
                            <option value="0">选择订单类型</option>
							<option value="1">美容</option>
                            <option value="2">维修</option>
                            <option value="3">保养</option>
                            <option value="4">改装</option>
                        </select>
                        <input type="text"  id="bps" class="text" placeholder="订单备注" style="width:55%" >
                                              <img src="../yunku/images/test.png" title="手机填写" style=" cursor:pointer; float:right;" onClick="add('qrbox')" width="30" height="30"/>
                    </fieldset>
                    <fieldset style="border:0px">
                    	<h1 style="margin:20px 40px; float:right;color:#f9af02;" id="rmbs">订单总价：0元</h1>
                        <input type="hidden" value="" id="billzj">
                    </fieldset>
					
               		<div class="box" >	<div class="box_title" onclick="$('#weixiuc').toggle(500);"><h4 class="caption">维修项目</h4>
                	<div class="close">
                        <input type="button" value="新建" class="toolbt" onClick="add('additem');enable('sava_item',false)">
                        <input type="button" value="选择" class="toolbt" onClick="add('citem')">
                	</div>
                </div>
            	<div class="box_content" id="weixiuc">
                    <div class="table1">
                        <table cellpadding="0" cellspacing="0" id="itemtb">
                            <tr>
                                <td> 序号 </td>
                                <td>项目编码</td>
                                <td>项目名称</td>
                                <td>单价</td>
                                <td>工时</td>
                                <td>优惠</td>
                                <td>金额</td>
                                <td>开始时间</td>
                                <td>完工时间</td>
                                <td>施工人员</td>
                                <td>项目分类</td>
                                <td>备注</td>
                                <td>操作</td>
                            </tr>
                            <tr>
                                <td colspan="13">暂无项目请添加</td>
                            </tr>
                            <tr>
                                <td colspan="13"><input type="button" value="添加项目" class="botton" onClick="add('citem')"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="boxbt"><h3 class="mny" id="itemrmb"></h3></div>
                </div>
                </div><!--项目栏目-->
					<div class="box"><div class="box_title" onClick="$('#xuanzesp').toggle(500);">
                    	<h4 class="caption">商品选择</h4>
                		<div class="close">
                        	<input type="button" value="新建" class="toolbt" onClick="add('addsp')">
                       	 	<input type="button" value="选择" class="toolbt" onClick="add('csp')">
                		</div>
                	</div>
                    <div class="box_content" id="xuanzesp">
                        <div class="table1">                    <table cellpadding="0" cellspacing="0" id="shoptb">
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
                                <td>优惠</td>
                                <td>金额</td>
                                <td>领料人员</td>
                                <td>商品备注</td>
                                <td>操作</td>
                            </tr>
                            <tr>
                                <td colspan="14">暂无商品请添加</td>
                            </tr>
                            <tr>
                            	<td colspan="14"><input type="button" value="添加" class="botton" onClick="add('csp')"></td>
                            </tr>
                        </table></div>  
                    </div>
                    <div class="boxbt"><h3 class="mny" id="shoprmb"></h3></div></div><!--商品栏目-->
               </div> 
		  </div>
       </div>          	
         
            
<!--弹窗部分代码-->
		<div class="toolbox" id="additem" style="width:800px;">          	<div class="box_title">
            	<h4 class="caption">新建项目</h4>
                <div class="close" onClick="closeb('additem')">×</div>
            
            </div>
                <div class="box_content">
                	<div class="items">
  
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
                     	<select class="text" id="error" onBlur="c(this,'save_item')">
                        	<option>车胎故障</option>
                            <option>车身刮伤</option>
                            <option>发动机故障</option>
                            <option>其他</option>
                        </select>
                     </div>
                    </div>
                </div>
                <div class="boxbt">
                	<input type="button" value="保存" class="botton"  id="save_item" onClick="s_item()" ></div></div><!--项目添加-->
        <div class="toolbox" id="citem" style="width:800px;"><div class="box_title" ><h4 class="caption">项目选择</h4>
                 	
                	<div class="close"onClick="closeb('citem')">×</div>
                </div>
                <div class="box_content" >
                	<div class="table1">
				<table cellpadding="0" cellspacing="0" id="aitemtb">
					<tr>
						<td> 序号 </td>
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
								    // if($i>6)break;
									echo "<tr class=a".$i.">";
										echo"<td>".($i+1)."</td>";
										echo"<td>".$row["itemid"]."</td>";
										echo"<td>".$row["itemname"]."</td>";
										echo"<td>".$row["money"]."</td>";
										echo"<td>".$row["item_type"]."</td>";
										echo"<td>".$row["tips"]."</td>";
										echo"<td><button class='toolbt' onclick='citem(\"aitemtb\",".($i+1).",".$row["id"].")'>选择</button></td>";
									echo"</tr>";
									$i++;
								}
							?>
                    <tr>
                    	<td colspan="13"><input type="button" value="新建项目" class="botton" onClick="add('additem')"></td>
                    </tr>
				</table>
			</div>
                </div>
                <div class="boxbt"></div></div><!--项目选择-->
        <div class="toolbox" id="csp" style="width:800px;">          		<div class="box_title" ><h4 class="caption">商品选择</h4>
                 	
                	<div class="close" onClick="closeb('csp')">×</div>
                    
                </div>
                <div class="box_content">
<div class="table1">
                        <table cellpadding="0" cellspacing="0" id="ashoptb">
                            <tr>
                                <td> 序号 </td>
                                <td>商品编码</td>
                                <td>商品名称</td>
                                <td>品牌</td>
                                <td>单位</td>
                                <td>库存</td>                           
                                <td>适用车型</td>
                                <td>销售价格</td>
                                <td>操作</td>
                            </tr>
                            
							<?php 
                                  $i=0;
								 
                                  foreach($shop as $row){
                                    // if($i>6)break;
									 echo "<input type='hidden' value='".$row["skc"]."' id='skc".$i."'>";
                                     echo "<tr class=a".$i.">";
                                     echo"<td>".($i+1)."</td>";
                                     echo"<td>".$row["sbm"]."</td>";
                                     echo"<td>".$row["sname"]."</td>";
                                     echo"<td>".$row["spp"]."</td>";
                                     echo"<td>".$row["sdw"]."</td>";
									 echo"<td>".$row["skc"]."</td>";
                                     echo"<td>".$row["scar"]."</td>";
									 echo"<td>".$row["sdj"]."</td>";
                                     echo"<td><button class='toolbt' onclick='cshop(\"ashoptb\",".($i+1).",".$row["sid"].")'>选择</button></td>";
                                     echo"</tr>";
                                     $i++;
                                   }
							?>                             
                      
                            <tr>
                            	<td colspan="14"><input type="button" value="添加" class="botton" onClick="add('addsp')"></td>
                            </tr>
                        </table>
                      </div>
                </div>
              <!--  <div class="boxbt"></div></div><!--商品选择
        <div class="toolbox" id="addsp" style="width:800px;">            	<div class="box_title">
                    <h4 class="caption">新建商品</h4>
                    <div class="close" onClick="closeb('addsp')">×</div>
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
                </div> -->
                <div class="boxbt"> <input type="button" value="保存" class="botton" onclick="s_shop()" /></div></div><!--商品添加-->
        <div class="toolbox" id="ckehu" style="width:800px;"><div class="box_title" ><h4 class="caption">客户选择</h4> <div class="close" onClick="close2()">×</div></div>
                <div class="box_content" style="height:300px; overflow:auto; margin:0px;">
                    <div class="table1">
 						                       <table cellpadding="0" cellspacing="0">
                          <tr><td colspan="8">
                                   <input type="search"  class="input_td" onKeyUp="tjcx()" id="tj" placeholder="输入账户信息查询"/>
                          </td></tr
                        ></table>
                            <table cellpadding="0" cellspacing="0" id="kehutb">
                                
                                <tr>
                                    <td>序号</td>
                                    <td>姓名</td>
                                    <td>联系电话</td>
                                    <td>通讯地址</td>
                                    <td>车型</td>
                                    <td>车牌</td>
                                    <td>备注</td>
                                    <td>操作</td>
                                </tr>
                                
                             <?php 
                                $i=0;
                                    foreach($kehu as $row){
                                         //if($i>6)break;
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
                                    <input id="addkh"  type="button"  class="botton" value="新建客户" onClick="addtr('kehutb')"/></td>
                                </tr>
                           </table>
                    </div>
                </div>
                <div class="boxbt"></div></div><!--客户选择-->
        <div class="toolbox" id="qrbox" style="width:400px; height:400px; display:none;"><div class="box_title" style="text-align:center;">
                	<h4 class="caption">扫一扫</h4>
                    <h4 class="close" onClick="closeb('qrbox')">×</h4>
                </div>
                <div class="box_content">
                  <div id="debug" style="color:red; overflow:hidden; height:50px; display:none;"></div>
                	<?php
										//../QRcode/phpqrcode.php
						include "../QRcode/qrlib.php"; 
						function qrpng($data){
						$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
						$PNG_WEB_DIR = 'temp/';
						if (!file_exists($PNG_TEMP_DIR))
        					mkdir($PNG_TEMP_DIR);
						$filename = $PNG_TEMP_DIR.'test.png';
						$errorCorrectionLevel = 'L'; //容错率 L M Q H
    					if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        					$errorCorrectionLevel = $_REQUEST['level'];    
						$matrixPointSize = 5;    //尺寸 1-10
    					if (isset($_REQUEST['size']))
        					$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
						if (isset($_REQUEST['data'])) { 
    					if (trim($_REQUEST['data']) == '')
            				die('data cannot be empty! <a href="?">back</a>');
            			$filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        				QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
  					  } else {    
  		     		 QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);     
    } 
  			  echo '<img id="qrcode"  src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; 
				}
						$key=time();
						echo "<input type='hidden' id='key' value='".$key."'>";
						echo "<div class='qrcode'>";
    					qrpng("http://www.zduber.com/zdcar2/kehuinfo.php?key=".$key."&cp=".$cp);
						echo"</div>";
					?>
                   <div id="msg" class="label-tips">扫描成功，请根据提示在手机上填写相应信息。</div>           
                </div></div><!--二维码弹窗-->       
	</body>
</html>