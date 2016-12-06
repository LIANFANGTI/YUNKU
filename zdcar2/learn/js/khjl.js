// JavaScript Document
function czjl(kh){
	var cp=document.getElementById("cp").value
	var czjl=document.getElementById("czbody")
	$.post("../ajax.php",{kh:kh,cp:cp,atype:"czjl"},function(data,aaa){
		czjl.innerHTML=data
	})
}
function car(kh){
	var cp=document.getElementById("cp").value
	var clxx=document.getElementById("carbody")
	$.post("../ajax.php",{kh:kh,cp:cp,atype:"car"},function(data,aaa){
		clxx.innerHTML=data
	})
}

function subcz(){
	var cp=document.getElementById("cp").value
	var kh=document.getElementById("khid").value
	var zf=document.getElementById("jsfs").value
	var je=document.getElementById("je").value
	if(zf!=0){
	$.post("../ajax.php",{kh:kh,cp:cp,zf:zf,je:je,atype:"hycz"},function(data,aaa){
		if(data.indexOf("插入成功")!=-1){
				alert("充值成功")
				czjl(kh)
			}else{
				alert(data)
			}
	})
	}else{
		alert("请选择支付方式"+zf)	
	}
}
function addcar(){
	var pp=document.getElementById("pp").value
	var kh=document.getElementById("khid").value
	var car1=document.getElementById("car").value
	var carid=document.getElementById("carid").value
	var vin=document.getElementById("vin").value
	var bdate=document.getElementById("bdate").value
	if(carid!=""){
	$.post("../ajax.php",{pp:pp,kh:kh,car:car1,carid:carid,bdate:bdate,vin:vin,atype:"addcar"},function(data,aaa){
		if(data.indexOf("插入成功")!=-1){
				alert("添加成功")
				car(kh)
				$("#addcar").toggle(200)
			}else{
				alert(data)
			}
	})
	}else{
		alert("车牌号不能为空")	
	}
}
function upcar(cid){
	var pp=document.getElementById("pp").value
	var kh=document.getElementById("khid").value
	var car1=document.getElementById("car").value
	var carid=document.getElementById("carid").value
	var vin=document.getElementById("vin").value
	var bdate=document.getElementById("bdate").value	
		$.post("../ajax.php",{cid:cid,pp:pp,kh:kh,car:car1,carid:carid,bdate:bdate,vin:vin,atype:"upcar"},function(data,aaa){alert(data)})
}
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
function xfjla(id){
	
	var xfjl1=document.getElementById("xfjltb")
	$.post("../ajax.php",{kh:id,atype:"xfjl"},function(data,aaa){
		//alert(data)
		xfjl1.innerHTML=data
	})	
}

 function wol(){
	var mydateInput = document.getElementById("xdate");
	var date = new Date();
	var dateString = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
	mydateInput.value=dateString;
 }
 function addxfjl(){
var cp=document.getElementById("cp").value
	var xdate=document.getElementById("xdate").value
	var btype=document.getElementById("b_type").value
	var iid=document.getElementById("item").value
	var sl=document.getElementById("xfje").value
	var addr="杭州"
	var khid=document.getElementById("khid").value
	var tips=document.getElementById("tips").value
	var ci=document.getElementById("itemr").rows.length-1
	//alert("共"+ci+"个项目")
	
	var items=document.getElementsByName("item")
	var tipss=document.getElementsByName("tips")
	var moneys=document.getElementsByName("xfje")
	var str="客户id："+khid+"\t订单类型："+btype+"\n"
	for(i=0;i<moneys.length;i++){
		str+="项目"+(i+1)+"ID:"+items.item(i).value+"---"+
			 "项目"+(i+1)+"金额:"+moneys.item(i).value+"---"+
			 "项目"+(i+1)+"备注:"+tipss.item(i).value+"\n"
	}
	//alert(str)
	
	//alert("公司"+cp+"\n日期"+xdate+"\n项目id"+iid+"\n金额"+sl+"\n地址"+addr+"\n客户："+khid+"\n订单类型"+btype+"\n备注"+tips)
	$.post("../ajax.php",{bkh:khid,ber:btype,bps:"0",company:cp,zje:zje(),atype:"abill"},function(data,aaa){
			 bbid=data.substring(data.indexOf("为")+2,data.length-16);
			//alert(bbid)
				for(i=0;i<moneys.length;i++){
			$.post("../ajax.php",{khid:khid,yh:0,i:(i+1),cs:moneys.length,bid:bbid,iid:items.item(i).value,gs:moneys.item(i).value,stime:xdate,etime:0,gr:"员工1",tips:tipss.item(i).value,atype:"aitem"},function(data,aaa){
				//alert(data)
				if(data.indexOf("跳转")!=-1){
						alert("消费记录添加成功")
						xfjla(khid)
						document.getElementById("xfje").value=""
						$('#addxf').toggle(200)
					}
				})	
			}
		
	})
	
		 
	 
}


function zje(){
	var money=document.getElementsByName("xfje")
	//alert("zje元素共有"+money.length)
	var zjee=0
	for(i=0;i<=money.length-1;i++){
		if(money.item(i).value==""){a=0}else{a=parseInt(money.item(i).value)}
		zjee+=a
			//alert("money.item("+i+").value="+money.item(i).value)
	}
	document.getElementById("zje").innerHTML="总金额："+zjee+"元"	
	return zjee;
	//alert("订单总额为"+zjee)
}
//添加项目里的行
