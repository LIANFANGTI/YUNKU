// JavaScript Document
var itemok=0;
var winh=1;
var winw=1;
var companyID=document.getElementById("cp")!=undefined?document.getElementById("cp").value:0;
BUTTONID=MSGBOXID=DATETIMEID=0;
AjaxPath="http://"+window.location.host+"/zdcar2/ajax.php?v=1";  
//***************************************************【关闭窗口】*********************************************************
function closeb(obj){
	var obj1=document.getElementById(obj)
	obj1.style.display="none"
	document.getElementById("back").style.display="none"
}
//***************************************************【打开弹出啊窗口】*********************************************************
function add(obj){
	var obj1=document.getElementById(obj);
	var win_width=document.documentElement.clientWidth
	var box_width=obj1.style.width
		//alert("*"+box_width+"*")
		box_width=box_width.substring(0,box_width.length-2)
	var left=(win_width*0.5)-(box_width*0.5)
	
	//alert("可见宽度为"+win_width+"\n弹窗宽度为"+box_width+"\nLeft=("+win_width+"/2)-("+box_width+"/2)="+left+"")
	obj1.style.marginLeft=left+"px"
	obj1.style.display="block";

	document.getElementById("back").style.display="block";
}

function close2(){
	$('#ckehu').fadeToggle(100);$('#back').fadeToggle(100);
	}
//***************************************************【展开或收起栏目】*********************************************************
function display(obj){
	//alert(obj)
	var obj1=document.getElementById(obj)
	$(obj1).fadeToggle(300);
	}
	
//*****************************************************【新建一行函数】*********************************************************
function addtr(table){      
    var tb= document.getElementById(table);
	var c=tb.rows.length-2
	var content="<td>"+(c+1)+"</td>"+
				"<td class='maxtd'><input type='text' class='input_td form-control input-group-xs' id='khname1' onBlur='c(this,\"sava_kh\")' onclick='cls(this)' placeholder='客户姓名(必填)'></td>"+
				"<td class='maxtd'><input type='text' class='input_td form-control'  id='khphone' onBlur='c(this,\"sava_kh\")' onclick='cls(this)' placeholder='联系电话(必填)'></td>"+
				"<td class='maxtd'><input type='text' class='input_td form-control' id='khcar' onBlur='c(this,\"sava_kh\")' onclick='cls(this)' placeholder='车型(必填)'></td>"+
				"<td class='maxtd'><input type='text'class='input_td form-control' id='khcarid' onBlur='c(this,\"sava_kh\")' onclick='cls(this)' placeholder='车牌(必填)' ></td>"+
				"<td class='maxtd'><input type='text' class='input_td form-control' id='khtips' onBlur='c(this,\"sava_kh\")' onclick='cls(this)' placeholder='备注(选填)' ></td>"+
				"<td class='maxtd'><button onclick='javascript:savakh()' class='btn btn-success btn-xs' id='sava_kh'>保存</button></td>"
$('<tr>'+content+'</tr>').insertAfter($('#kehutb tr:eq('+(c)+')')); //再倒数第一行前加入一行
	enable("addkh",false)
	enable("sava_kh",false)	
}
//***************************************************【客户选择函数】*********************************************************
function ckehu(tab,rowindex,id){
	var name=document.getElementById("khname")  
	var tel=document.getElementById("khtel") 
	var a=$('#kehutb tr:eq('+(rowindex+1)+') td:nth-child(2)').html();  //选择当前行号的第二列的值
	var b=$('#kehutb tr:eq('+(rowindex+1)+') td:nth-child(3)').html();  //选择当前行号的第二列的值
	var khid=document.getElementById("khid")
	//alert(a)

	closeb("ckehu")
	name.value=a
	khid.value=id 
	tel.value=b
	$.post("ajax.php",{khid:id,atype:"CarList"},function(data,aaa){
		carid.innerHTML=data
	})
}

//***************************************************【项目选择函数】*********************************************************
function citem(tab,rowindex,itemid){
	var iid=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(2)').html();//获取当前选择行的第二列（编号）
	var iname=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(3)').html();//获取当前选择行的第三列（名称）
	var money=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(4)').html();//获取当前选择行的第四列（单价）
	var itype=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(5)').html();//获取当前选择行的第五列（类型）
	var ips=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(6)').html();//获取当前选择行的第六列（备注）
	itemid-=1
	//alert(iname+"\n"+rowindex)	
		b=$('#itemtb tr:eq(1) td:nth-child(1)').html();
		if(b=="暂无项目请添加"){$('#itemtb tr:eq('+(1)+')').remove();}
		a=$("#itemtb").find("tr").length
		var select1="<select class='input_td' >"+
							"<option>人员1</option>"+
							"<option>人员2</option>"+
							"<option>人员3</option>"+
					"</select>"
		var content="<td>"+(a)+"</td>"+
				 "<td>"+iid+"</td>"+
				 "<td id='iid"+(a)+"' name='itemid' class="+itemid+">"+iname+"</td>"+
				/* "<td ><input type='text' value='"+money+"' id='imoney"+(a-1)+"' class='input_td' disabled style='width:50px;'></td>"+*/
				 "<td><input type='text' name='itemgs' class='input_td' title='工时' onChange='zje()' id='gs"+(a-1)+"' style='width:20px'/></td>"+
				 /*"<td><input type='text'class='input_td'title='优惠' onChange='changermb("+(a-1)+",\"item\")' id='iyh"+(a-1)+"' style='width:40px'/>%</td>"+
				  "<td id='irmb"+(a-1)+"'>0元</td>"+*/
				 "<td><input type='date'class='input_td' style='width:110px'/></td>"+
				 "<td><input type='date'class='input_td'/></td>"+
				 "<td>"+select1+"</td>"+
				 "<td>"+itype+"</td>"+
				 "<td><input type='text' class='input_td' id='tips' style='width:100px;'/></td>"+
				 "<td><button class='btn btn-danger btn-xs' onclick=\"delrow('itemtb',"+(a-1)+")\" >删除</button></td>"
				 
		$('<tr>'+content+'</tr>').insertAfter($('#itemtb tr:eq('+(a-2)+')')); //再倒数第一行前加入一行
		closeb("citem")
}


//***************************************************【商品选择函数】*********************************************************
function cshop(tab,rowindex,shopid){
	var sid=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(2)').html();//获取当前选择行的第二列（编号）
	var sname=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(3)').html();//获取当前选择行的第三列（名称）
	var spingp=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(4)').html();//获取当前选择行的第四列（品牌）
	var scar=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(7)').html();//获取当前选择行的第五列（适用车型）
	var sguige=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(5)').html();//获取当前选择行的第六列（单位）
	var sdj=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(8)').html();//获取当前选择行的第六列（单价）
	var skc=$('#'+tab+' tr:eq('+rowindex+') td:nth-child(6)').html();//获取当前选择行的第六列（库存）
	//alert("编码："+sid+"\n名称"+sname+"\n品牌"+spingp+"\n车型"+scar+"\n单位"+sguige+"\n单价"+sdj+"")
	//alert(iname+"\n"+rowindex)	

		b=$('#shoptb tr:eq(1) td:nth-child(1)').html();
		if(b=="暂无商品请添加"){$('#shoptb tr:eq('+(1)+')').remove();}
		a=$("#shoptb").find("tr").length
		var select1="<select class='input_td' >"+
							"<option>人员1</option>"+
							"<option>人员2</option>"+
							"<option>人员3</option>"+
					"</select>"
		var content="<td>"+(a-1)+"</td>"+
			"<td title='编码'>"+sid+"</td>"+
		    "<td id='sid"+(a-1)+"' class="+shopid+">"+sname+"</td>"+
			"<td title='品牌'>"+spingp+"</td>"+
			"<td>无</td>"+
			"<td>"+scar+"</td>"+
			"<td>"+sguige+"</td>"+
			"<td ><input type='text' value='"+sdj+"' id='smoney"+(a-1)+"'  title='单价' class='input_td' disabled style='width:50px;'></td>"+
			 "<td><input type='text' class='input_td' title='数量' onChange='changermb("+(a-1)+",\"shop\");cgkc("+skc+","+(a-1)+")' id='sl"+(a-1)+"' style='width:20px'/>"+sguige+"</td>"+
			 "<td><input type='text' class='input_td' title='优惠' onChange='changermb("+(a-1)+",\"shop\")' id='syh"+(a-1)+"' style='width:20px'/>%</td>"+
			"<td id='srmb"+(a-1)+"' title='金额'>0元</td>"+     
			"<td title='领料人员'>"+select1+"</td>"+
			"<td><input type='text'class='input_td' title='备注'/></td>"+
			"<td><button class='toolbt' onclick=\"del(0,'aitem')\" >删除</button></td>"
				 
		$('<tr>'+content+'</tr>').insertAfter($('#shoptb tr:eq('+(a-2)+')')); //再倒数第一行前加入一行
		closeb("csp")
}


function cgkc(skc,i){
	var ssl=$("#sl"+i).val()
	if(ssl>skc){
		alert("库存不足");
		$("#sl"+i).val(skc)	
	}
	//alert("该商品库存为："+skc+"\n数量为："+ssl)
}

//*******************************************************【订单价格计算】***********************************************************
var gsa=[0],gsb=[0]
var yha=[0],yhb=[0]
var dja=[0],djb=[0]
var rmba=[0],rmbb=[0]
var zrmba=[0],zrmbb=[0]
zrmba=0,zrmbb=0
var rmbc=[0]
function changermb(rindex,type){
	//alert("价格更新函数启动")
	var rmbs=document.getElementById("rmbs") //订单总价获取
	var ot
	if(type=="item"){
		//alert("更新为项目金额")
		 zrmba=0 
		 var a=$("#itemtb").find("tr").length-2
		 var td=$('#shoptb tr:eq(1) td:nth-child(1)').html();
		 if(td=="暂无项目请添加")a=a-1
		 //alert("获取到的项目数为"+a)
		 rmba.length=0
		 for(var i=1;i<=a;i++){
			  gsa[i]=$("#gs"+i).val() 
			  yha[i]=$("#iyh"+i).val()//项目优惠获取
			  dja[i]=document.getElementById("imoney"+i).value //单价获取
			  if(yha[i]==""){yha[i]=0};
			  rmba[i]=dja[i]*gsa[i]-(dja[i]*gsa[i]*(yha[i]/100))
			  document.getElementById("irmb"+i).innerHTML=rmba[i]+"元" //各项项目价格输出
		 }
		 var str=""
		 $.each(rmba,function(name,value) {if(name!="0"){zrmba=zrmba+value;str+="+"+value;} });//项目总价计算
		 //alert(str+"="+zrmba)
		 ot=document.getElementById("itemrmb")	//项目总价输出对象获取
		 ot.innerHTML="总金额:"+zrmba+"元"//项目总价输出
		 //alert("项目金额更新完毕")
	}else{
		 //alert("更新为商品金额")
		 zrmbb=0
		 var a=$("#shoptb").find("tr").length-2
		 var td=$('#shoptb tr:eq(1) td:nth-child(1)').html();
		 if(td=="暂无商品请添加")a=a-1
		 //alert("获取到单元格内容为"+td)
		 //alert("获取到当前商品数为"+a)
		 rmbb.length=0;
		 for(var i=1;i<=a;i++){
			  gsb[i]=$("#sl"+i).val() 
			  yhb[i]=$("#syh"+i).val()//项目优惠获取
			  djb[i]=document.getElementById("smoney"+i).value //单价获取
			 // alert("smoney"+i+"获取成功")
			  if(yhb[i]==""){yhb[i]=0} 
			  rmbb[i]=djb[i]*gsb[i]-(djb[i]*gsb[i]*(yhb[i]/100))
			  //alert("第"+i+"项商品的价格为"+rmbb[i]+"元")
			  document.getElementById("srmb"+i).innerHTML=rmbb[i]+"元"//各项商品价格输出
		 }
		 $.each(rmbb,function(name,value) {if(name!="0"){zrmbb=zrmbb+value;} });  //商品总价计算alert("rmbb["+name+"]="+value)
		 ot=document.getElementById("shoprmb")	//商品总价输出对象获取
		 ot.innerHTML="总金额:"+zrmbb+"元"//商品总价输出
		 //alert("商品金额更新完毕，更新后商品总额为"+zrmbb)
	}
    rmbs.innerHTML="订单总额:"+(zrmba+zrmbb)+"元"
	document.getElementById("billzj").value=(zrmba+zrmbb)
}

//***************************************************【按钮disabled属性控制函数】*************************************************
function enable(obj,value){
	//alert(value);alert($(obj).val())
	//$(obj).attr("disabled",value);
	var obj1=document.getElementById(obj)
	if(value){
		//alert("可用")
		obj1.disabled=""
		obj1.style.backgroundColor="#f9af02"
		obj1.style.borderColor="#b67f00"
	}else{
		//alert("不可用")
		obj1.disabled=1
		obj1.style.backgroundColor ="#666"
		obj1.style.borderColor="#333"
	}
}
//***************************************************【保存新建商品函数】**********************************************************
var sname,sdw,scb,skc,spp,sdj,scar
function s_shop(){
	
	 /*数据获取*/
	 sname=$("#sname").val(); //商品名称
	 sdw=$("#sdw").val();//商品单位
	 scb=$("#scb").val();//商品成本
	 sdj=$("#sdj").val();//商品单价
	 skc=$("#skc").val();//商品库存
	 spp=$("#spp").val();//商品品牌
	 scar=$("#scar").val();//适用车型
	cp=$("#cp").val()
	if(k(sname)&&k(sdw)&&k(scb)&&k(skc)&&k(spp)&&k(scar)&&k(sdj)){
			 alert(sname+","+sdw+","+scb+","+sdj+","+skc+","+spp+","+scar)
     //-**********************************************************************************************************AJAX数据提交
    $.post("ajax.php",{sname:sname,sdw:sdw,scb:scb,skc:skc,spp:spp,scar:scar,cp:cp,sdj:sdj,atype:"addshop"},function(data,aaa){
		nid=data.substring(data.indexOf("为")+2,data.length-16);
		alert("新添加的商品id为："+nid)
        var a=$("#ashoptb").find("tr").length-1
		alert("a="+a)
		var content="<td>"+(a)+"</td>"+
				 "<td>SP00"+nid+"</td>"+
				 "<td>"+sname+"</td>"+
				 "<td>"+spp	+"</td>"+
				 "<td>"+sdw+"</td>"+
				 "<td>"+scar+"</td>"+
				 "<td>"+sdj+"</td>"+
				 "<td><button class='toolbt' onclick='cshop(\"ashoptb\","+(a)+","+nid+")' >选择</button></td>"
		$('<tr>'+content+'</tr>').insertAfter($('#ashoptb tr:eq('+(a-1)+')')); //再倒数第一行前加入一行
		//enable("addkh",true)
		//alert("用户名字："+khname+"\n电话："+khpho+"\n地址："+khadd+"\n车型："+khcar+"\n车牌："+khcarid+"\n备注："+khps)
			});
		}		
		closeb("addsp")
}
























//***************************************************【保存新建项目函数】**********************************************************
var sid,sname,itype,imoney,ierror
function s_item(){
	 /*数据获取*/
	 iid=$("#itemid").val(); //项目编码
	 iname=$("#itemname").val();//项目名称
	 itype=$("#itemtype").val();//项目类型
	 imoney=$("#money").val();//项目单价
	 ierror=$("#error").val();//项目故障
	 cp=$("#cp").val();//公司id获取
	if(k(iid)&&k(iname)&&k(itype)&&k(imoney)&&k(ierror)){
     //-**********************************************************************************************************AJAX数据提交
    $.post("ajax.php",{iid:iid,iname:iname,itype:itype,imoney:imoney,ierror:ierror,cp:cp,atype:"additem"},function(data,aaa){
		alert(data)
		nid=data.substring(data.indexOf("为")+2,data.length-16);
		//alert("新添加的商品id为："+nid)
		var a=$("#aitemtb").find("tr").length-1
		var content="<td>"+(a)+"</td>"+
				 "<td>"+iid+"</td>"+
				 "<td>"+iname+"</td>"+
				 "<td>"+imoney+"</td>"+
				 "<td>"+itype+"</td>"+
				 "<td>"+ierror+"</td>"+
				 "<td><button class='toolbt' onclick='citem(\"aitemtb\","+(a)+","+nid+")' >选择</button></td>"
		$('<tr>'+content+'</tr>').insertAfter($('#aitemtb tr:eq('+(a-1)+')')); //再倒数第一行前加入一行
		//enable("addkh",true)
		//alert("用户名字："+khname+"\n电话："+khpho+"\n地址："+khadd+"\n车型："+khcar+"\n车牌："+khcarid+"\n备注："+khps)

   });
	/*************************在项目选择列表中插入一行*************************/
		}		
		//closeb("additem")
}
function sitem(){
	 iid=$("#itemid").val(); //项目编码
	 iname=$("#itemname").val();//项目名称
	 itype=$("#itemtype").val();//项目类型
	 imoney=$("#money").val();//项目单价
	 ierror=$("#error").val();//项目故障
	 cp=$("#cp").val();//公司id获取	
	alert(itype)
	  $.post("ajax.php",{iid:iid,iname:iname,itype:itype,imoney:imoney,ierror:ierror,cp:cp,atype:"additem"},function(data,aaa){
		  //alert(data)
          reloaditem()
		  // $.post("ajax.php",{iid:iid,iname:iname,itype:itype,imoney:imoney,ierror:ierror,cp:cp,atype:"additem"};
		  // $.post("ajax.php",{cp:cp,atype:"reloaditem"};
		})
}

function reloaditem(){
		 $.post("ajax.php",{cp:cp,atype:"reloaditem"},function(data,aaa){
			  itemstb.innerHTML=data
		  });
}
//***************************************************【保存新建用户函数】*******************************************************
var khname,khpho,khadd,khcar,khcarid
function savakh(){
	khname=$("#khname1").val();khpho=$("#khphone").val();khadd=$("#khaddr").val();
	khcar=$("#khcar").val();khcarid=$("#khcarid").val();khps=$("#khtips").val()
	cp=$("#cp").val()
	if(k(khname)&&k(khpho)&&k(khadd)&&k(khcar)&&k(khcarid)){
		$.post("ajax.php",{khname:khname,khpho:khpho,khadd:khadd,khcar:khcar,khcarid:khcarid,khps:khps,cp:cp,atype:"addkh"},function(data,aaa){
			khid=cut(data,"[newid]","[/newid]");
			$.post("ajax.php",{pp:khcar,kh:khid,carid:khcarid,car:"",atype:"addkhcar"},function(data,aaa){
				alert(data);
			});
		});
		enable("addkh",true)
		//GetkehuList(khname,1)
			//alert("用户名字："+khname+"\n电话："+khpho+"\n地址："+khadd+"\n车型："+khcar+"\n车牌："+khcarid+"\n备注："+khps)
	}		
}
//***************************************************【保存新建客户结束】*********************************************************

//***************************************************【检测对象值是否为空】*******************************************************
function k(a){if(a=="")return false; else return true;}
//****************************************************************************************************************************
var tok=[0]
//***************************************【检测输入值是否符合要求控制提交按钮是否可用】************************************************
function c(obj,bt){
	if(k(obj.value)){obj.style.boxShadow="-1px -1px 5px #0F0 inset"}
	else{obj.style.boxShadow="-1px -1px 5px #F00 inset"}
	khname=$("#khname1").val();khpho=$("#khphone").val();khadd=$("#khaddr").val();
	khcar=$("#khcar").val();khcarid=$("#khcarid").val();khps=$("#khtips").val()
	enable(bt,true)
	switch(bt){
		case "save_item":
			if(k($("#itemid").val())&&  //项目编码不为空
			   k($("#itemname").val())&&
			   k($("#itemtype").val())&&
			   k($("#error").val())&&
			   k($("#money").val())){enable(bt,true)}else{enable(bt,false)}
		break;
		case "save_kh":
			if(k(khname)&&k(khpho)&&k(khadd)&&k(khcar)&&k(khcarid)){enable(bt,true)}else{enable(bt,false)}
		break;
	}
}

//****************************************************************************************************************************
//***********************************************【输入框获取焦点时清空内容还原样式】************************************************
function cls(obj){
	if(!k(obj.value)){
		obj.style.boxShadow="0px 0px 0px #0F0 inset"
		obj.value=""	
	}
}
//****************************************************************************************************************************
//*************************************************【输入客户信息筛选用户列表】****************************************************
function tjcx(){
	var tj=document.getElementById("tj").value
	var cp=document.getElementById("cp").value
	$.post("ajax.php",{tj:tj,cp:cp,atype:"tjcx"}, function(data,aaa){document.getElementById("kehutb").innerHTML=data});//data为返回的数据  ，aaa为状态
	//以post方式 传送 数据至ajax.php  
}
//**********************************************************【订单保存订单】***************************************************
function save_bill(){
 var bkh=document.getElementById("khid").value
 var bty=document.getElementById("b_type").value
	var bps=""
 var ci,cs
 var a=$('#itemtb tr:eq(1) td:nth-child(1)').html();
 var b=$('#shoptb tr:eq(1) td:nth-child(1)').html();

 //获取ci(添加的项目数)cs(添加的商品数)
 if(a=="暂无项目请添加"&&b=="暂无商品请添加"){ci=cs=0
 }else if(a=="暂无项目请添加"&&b!="暂无商品请添加"){ci=0, cs=$("#shoptb").find("tr").length-2
 }else if(a!="暂无项目请添加"&&b=="暂无商品请添加"){ci=$("#itemtb").find("tr").length-2;cs=0
 }else{ci=$("#itemtb").find("tr").length-2;cs=$("#shoptb").find("tr").length-2}


 
 
 /***********************************************数据提交*************************************************************/

 //订单保存
	if(bkh!="请选择客户"&&bty!="选择订单类型"&&k(bps)&&(ci>0||cs>0)){
	 cp=$("#cp").val()
	 khid=document.getElementById("khid").value
	 zje=document.getElementById("billzj").value
     $.post("ajax.php",{zje:zje,bkh:bkh,ber:bty,bps:bps,company:cp,atype:"abill"},function(data,aaa){
			 //alert("订单信息提交返回值：\n"+data);
			 bbid=data.substring(data.indexOf("为")+2,data.length-16); 
			 for(i=1;i<=ci;i++){
			   var iid=document.getElementById("iid"+i).className   	
			   $.post("ajax.php",{khid:khid,bid:bbid,i:i,cs:ci,iid:iid,gs:gsa[i],yh:yha[i],stime:0,etime:0,gr:"员工1",tips:"无",atype:"aitem"},function(data,aaa){}); 
			    if(data.indexOf("添加结束跳转")!=-1){alert("订单新建成功");location.replace("1-2.php")}
			 }
			//商品信息提交
			for(i=1;i<=cs;i++){
			  var sid=document.getElementById("sid"+i).className
			  //alert("工时/优惠"+i+":"+gsb[i]+"/"+yhb[i])
			  $.post("ajax.php",{khid:khid,bid:bbid,sid:sid,gs:gsb[i],yh:yhb[i],i:i,cs:cs,gr:"员工1",tips:"无",atype:"ashop"},function(data,aaa){
				  
				 // alert("商品信息提交返回值：\n"+data);
				  if(data.indexOf("添加结束跳转")!=-1){alert("订单新建成功");location.replace("1-2.php")}
				  
				  });
			}
						

    }); 

	}else if(cs<=0||ci<=0){
 	alert("请添加订单内容")
 }else{
	alert("请填写正确信息")	 
 }
}
/*************************************************【删除已选项项目（商品）函数】******************************************************/
function del(id,tab){
	var bid=0
	if(tab=="aitem"){ tabn="itemtb";str="项目";col=12;
	}else{ tabn="shoptb";str="商品";col=14;}
	a=$("#"+tabn+"").find("tr").length
	if(confirm("该操作无法撤销 ，是否确认删除？","温馨提示")){
		for(var i=1;i<a;i++){
			//if($('#'+tabn+' tr:eq('+i+')').hasClass(id)){$('#'+tabn+' tr:eq('+i+')').remove();}	
		}
		//alert(bid)
		tabb=document.getElementById(tabn)
		
		$.post("ajax.php",{id:id,bid:bid,table:tab,atype:"del"},function(data,aaa){tabb.innerHTML=data
		if(tab=="aitem"){changermb(0,"item");}else{changermb(0,"shop");}
		
		})
		

		
	}
}
/*字符串剪切函数 格式cut(zifu)*/
function cut(str,left,right){
	var start=str.indexOf(left)+left.length
	var end=str.indexOf(right)
	return str.substring(start,end)
}
function Cut2(Str,Word){
	if(Str.indexOf("["+Word+"]")!=-1&&Str.indexOf("[/"+Word+"]")!=-1){
	 return cut(Str,"["+Word+"]","[/"+Word+"]");
	}else{
	 return "空";
	}
}


/*判断是否为微信浏览器*/
function is_weixn(){  
    var ua = navigator.userAgent.toLowerCase();  
    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
        return true;  
    } else {  
        return false;  
    }  
}  
/*删除行*/
function delrow(tab,rowid){
$('#'+tab+' tr:eq('+(rowid)+')').remove();	
}
function MsgBorder(str){
	var line1="╔"+string(str.length*1.5,"═")+"╗\n";
	var line2="║"+str+"║\n";
	var line3="╚"+string(str.length*1.5,"═")+"╝";
	return line1+line2+line3;
	
}
/*生成N个指定字符函数*/
function string(n,str){var b="";for(i=0;i<n;i++){b+=str;};return b;}
/*Ajax封装*/
function Ajax(URL,Type,AjaxData,Async){
	var AjaxRes
	$.ajax({
            type:Type,
			url:URL,
			data:AjaxData,
				async:false,
				error:function(json){alert("Ajax出错,请检查\n["+URL+"]\n页面的代码。");printr(json)},    
				success:function(res){
				AjaxRes=res;	
			} 
		
		});
	return AjaxRes;
}
function UPLOADFILE(FILE){
	var AjaxRes
	alert(AjaxData);
	/*$.ajax({
            type:"post",
			url:AjaxPath,
			data:AjaxData,
				async:false,
				error:function(json){alert("Ajax出错,请检查\n["+URL+"]\n页面的代码。");printr(json)},    
				success:function(res){
				AjaxRes=res;	
			} 
		
		});
	return AjaxRes;*/
}

function Ajax2(AjaxData){
	return Ajax(AjaxPath,"post",AjaxData,false); 
}
function Ajax3(AjaxData){
	return Cut2(Ajax(AjaxPath,"post",AjaxData,false),AjaxData.atype);
}

function Namefocus(e){
	e.style.borderColor="#ccc";
}

function isNum(e){
	 if(isNaN(e.value)){
		 e.value="";
	 }
}


function printr(a,M){ 
	switch(M){
		case"error":
			console.error(a)
		break;
		case"info":
			console.info(a)
		break;
		case"warn":
			console.warn(a)
		break;
		case"debug":
			console.debug(a);
		break;
		case"success":
			console.log('%c '+a+'', 'color: #0F0');
		break;
		
		default:
			console.log(a);
		break;
	}
}
//去除数组中重复项 
function unique(arr) {
	var result = [], hash = {};
	for (var i=0,elem;(elem=arr[i])!=null;i++)if(!hash[elem]){
		result.push(elem);
		hash[elem] = true;
	}
	return result;
}

function UPDATE(TABLE,COL,VAL,CONDITION,DEBUG){
	var MSG=Ajax2({TABLE:TABLE,COL:COL,VAL:VAL,CONDITION:CONDITION,atype:"UPDATE"}); 
	var backInfo=Cut2(MSG,"info");
	if(backInfo.indexOf("成功")!=-1){STATE=true;}else{STATE=false;}
	var sql=Cut2(MSG,"sql");
	if(DEBUG!=undefined&&DEBUG){
		debugInfo="=========================\n"+
					"UPDATE(数据表,字段,值,条件,DEBUG)\n"+
					"表名:"+TABLE+"\n"+
					"字段名:"+COL+"\n"+
					"值:"+VAL+"\n"+
					"条件:"+CONDITION+"\n"+
					"SQL语句:"+sql+"\n"+
					"执行状态:"+STATE+"\n"+
					"返回信息:"+backInfo+"\n"+
					"执行时间:"+DATE()+"\n"+
				    "\n=========================";
		printr(debugInfo);
	}
	var Return={state:STATE,info:backInfo};
	return Return;
}

function DELETE(TABLE,CONDITION,DEBUG){

	Info=Cut2(Ajax2({TABLE:TABLE,CONDITION:CONDITION,atype:"DELETE"}),"MSG");
	printr(Info);
	if(DEBUG!=undefined){
		printr( {info:Info,state:Info.indexOf("成功")!=-1?true:false});
	}
	return {info:Info,state:Info.indexOf("成功")!=-1?true:false};
}

function INSERT(TABLE,ARR,DEBUG){
	//说明: MSGBOX(表,字段数组,DEBUG)
	
	var MSG=Ajax2({TABLE:TABLE,ARR:ARR,atype:"INSERT"});
	backInfo=Cut2(MSG,"INSERT");
	newId=Cut2(MSG,"NEWID");
	if(backInfo.indexOf("成功")!=-1){STATE=true;}else{STATE=false;}
	if(DEBUG!=undefined&&DEBUG){
		arrString=JSON.stringify(ARR);
		printr("=========================\nINSERT(数据表,数组,DEBUG)\n________________________\n数据表:"+TABLE+"\n数组参数:"+arrString+"\n返回信息:"+backInfo+"\n运行状态:"+STATE+"\n执行时间："+DATE()+"\n=========================\n");
	}
	
	Return={state:STATE,info:backInfo,newid:newId};
	return Return;
	
}

function Robot(Q,M){
	return Ajax3({Question:Q,atype:"Robot",mod:M});
}

function Speaker(str){
	$('#SpeakerContent').html(str);
	$('#SpeakerContent').speech({
		"speech": 0,
		"speed": 15,
		"lang": "zh", 
		"bg": "./images/speech.png" 
	});
}

function MSGBOX(CONTENT,FUNCTION,TITLE,BUTTON,STYLE,WIDTH){
	//说明: MSGBOX(消息内容,按钮函数,消息框标题,按钮文字,按钮样式)
	
			if(TITLE==null)TITLE="来自网站的消息";
			if(CONTENT==null)CONTENT="函数使用格式为<br><b style='color:286090;' >MSGBOX</b>(<b>内容</b>,<b>函数</b>,<b>标题</b>,<b>按钮文字</b>)";
			if(BUTTON==null)BUTTON="确定";
			if(STYLE==null)STYLE="primary";
			BUTTONID++;
			FRAME="<div class='modal' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true' id='MSGBOX"+BUTTONID+"'>"+
		"<div class='modal-dialog' style='width:"+WIDTH+"px;'>"+
			"<div class='modal-content'>"+
				"<div class='modal-header'>"+
					"<button type='button' class='close' data-dismiss='modal' id='MSGBOXCLOSE"+BUTTONID+"'><span aria-hidden='true'>"+
						"<span class='fa fa-times fa-lg'></span></span></span><span class='sr-only'>Close</span>"+
					"</button>"+
					"<h4 class='modal-title'>"+TITLE+"</h4>"+
				"</div>"+
				"<div class='modal-body'>"+	
					CONTENT+
				"</div>"+
				"<div class='modal-footer text-center'>"+
					"<input type='button' id='MSGBOXBUTTON' value='"+BUTTON+"' class='btn btn-"+STYLE+" btn-sm' onclick='MSGBOXCLOSE"+BUTTONID+".click();"+FUNCTION+"' />"+
				"</div>"+
			"</div>"+
		"</div>"+
		"</div>"+
			"<a  style='display:none;' class='btn btn-primary btn-xs' data-toggle='modal' onclick='' href='#MSGBOX"+BUTTONID+"' id='MSGBOXBUTTON"+BUTTONID+"'>BUTTON</a>";
			 document.body.innerHTML+=FRAME;
			 document.getElementById("MSGBOX"+BUTTONID).style.display="block";
			 printr("MSGBOX"+BUTTONID+".style.dispaly="+document.getElementById("MSGBOX"+BUTTONID).style.display);
			document.getElementById("MSGBOXBUTTON"+BUTTONID).click();
			
}
function SELECTDAETIME(){
	
			DATETIMEID++;
			FRAME=" <input type='datetime-local' id='DATETIME"+DATETIMEID+"'/>";
			 document.body.innerHTML+=FRAME;
			document.getElementById('DATETIME"+DATETIMEID+"').click()	
}
		
function DATE(MOD){
	//说明:返回服务器当前时间
	if(MOD==undefined){
		return Ajax3({MOD:0,atype:"GetDATE"});
	}else{
		return Ajax3({MOD:MOD,atype:"GetDATE"}); 
	}
}
	
	
function SELECTA(TABLE,COL,VALUE,RETURN){
	//说明:SELECTA(表,字段,值,返回字段) 返回:字符串
	return Cut2(Ajax2({TABLE:TABLE,COL:COL,VALUE:VALUE,RETURN:RETURN,atype:"SELECTA"}),RETURN);
}

function SELECT_C(ARR){
	//说明: String SELECT_C(Array[表名,字段,条件字段,条件值])
	printr(ARR);
	return SELECT_B(ARR[0],ARR[1],ARR[2]+"="+ARR[3]);
}
function SELECT_B(TABLE,COL,CONDITION,DEBUG){
	//说明SELECT_B(表,字段,条件,DEBUG)
	R=Ajax2({TABLE:TABLE,COL:COL,CONDITION:CONDITION,atype:"SELECTB"}); 
	SQL=Cut2(R,"sql");
	EMSG=Cut2(R,"ERROR"); 
	INFO=Cut2(R,"SELECTB");
	if(DEBUG!=undefined&&DEBUG){
		printr("===============================\n字段:"+COL+"\n表:"+TABLE+"\n条件:"+CONDITION+"\nSQL语句:"+SQL+"\n错误信息:"+EMSG+"\n返回信息:"+INFO+"\n时间:"+DATE()+"\n===============================\n");
	}
	 return INFO; 
	
	
}
function SELECT(TABLE,COL,CONDITION,DEBUG){
	//说明 SELECT(表,字段,条件,DEBUG);
	SQL={TABLE:TABLE,COL:COL,CONDITION};
	jsonString=Ajax3({SQL:SQL,atype:"SELECT"});
	OBJ=JSON.parse(jsonString);
	return OBJ;
}
function TABLE(C,STYLE){
	return "<table class='table' style='border:0px;"+STYLE+"'>"+C+"</table>"; 
}


function EXIST(TABLE,COL,VAL){
//说明:EXIST(表,字段,值) 返回:True | False
	var R=Ajax2({TABLE:TABLE,COL:COL,VALUE:VAL,atype:"EXIST"});
	if(Cut2(R,"code")=="YES"){return true;}else{return false;}
}
function EXISTS(TABLE,CONDITION){ 
//说明:EXISTS(表,查询条件) 返回:True | False  查找是否存在该记录
	var R=Ajax2({TABLE:TABLE,CONDITION:CONDITION,atype:"EXISTS"});
	//alert(R);
	if(Cut2(R,"code")=="YES"){return true;}else{return false;} 
}

function LOGS(U,T,O,V1,V2,C){
	//说明 LOGS(操作者ID,记录类型,记录对象,预留值1,预留值2,公司ID)
	LOGINFO={U:U,TYPE:T,OBJ:O,V1:V1,V2:V2,C:C,atype:"LOG"};
	printr(LOGINFO); 
	printr(Ajax2(LOGINFO));
}
/*字符串出现次数统计*/
function substr_count(STR,SUBSTR){
	//说明:int substr_count(字符串,被查找字符串);
	return (STR.split(SUBSTR)).length-1
}
/*字符串替换*/
function replace(STR,SUBSTR,TOSTR,ALL){
	//说明 String replace(字符串,要查找的字符,替换成的字符,是否全局替换);
	b=new RegExp("("+SUBSTR+")",ALL?"g":"");
	return STR.replace(b,TOSTR);

}

function LOG2(USER,STRING,ARR){
	//说明:Object LOG2(Int 操作者ID,String 字符格式,Array[[表名,字段名,条件字段,条件字段值],...])	
	var ERROR=0
	if(!EXISTS("logstr","name="+STRING)){
		printr("添加记录失败！模板"+STRING+"不存在","error");
	}else{
		MUBAN=SELECT_C(["logstr","STRING","name",STRING]);
		if(ARR.length!=substr_count(MUBAN,"%v")){
			printr("参数错误");
		}else{
			INSERT("log2",{STRING:STRING,JSON:JSON.stringify(ARR),C:companyID,date:DATE(),U:USER},true);
			STRING=replace(MUBAN,"%u",SELECT_B("user","name","id="+USER));//替换用户名
			for(i=0;i<ARR.length;i++){
				STRING=replace(STRING,"%v",(ARR[i] instanceof Array)?SELECT_C(ARR[i]):ARR[i]);
			}
			printr("成功生成记录:"+STRING,"success");
		}	
	}
	
}


function to(URL){
	window.location.replace(URL);
}
function logout(){
	printr(Ajax2({atype:"logout"}));
	Ajax2({atype:"logout"});
	location.reload();
}

function yesno(str){
	//说明: Boolean yesno(String str); 
	if(confirm(str)){
		return true;
	}else{
		return false;
	}
}
var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();








