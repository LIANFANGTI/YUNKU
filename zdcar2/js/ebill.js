 bid=document.getElementById("bid").value
 cp=document.getElementById("cp").value
function acitem(itemid){
	var iid=itemid;
	var bid=document.getElementById("bid").value;
	$.post("ajax.php",{bid:bid,iid:iid,gs:0,yh:0,stime:0,etime:0,gr:"员工1",tips:"无",atype:"aitem"},function(data,aaa){}); 
	delxm(0,bid)
}
function yhchange(){
	val=document.getElementById("YHTYPE").value
	YhTitle=document.getElementById("YhTitle");
	YhVal=document.getElementById("yhvalue").value;
	YhMsg=document.getElementById("yhmsg");
	
	if(val==1){
		YhTitle.innerHTML="请输入优惠折扣(%)";
		if(YhVal==""){
			YhMsg.innerHTML="金额=原价X折扣="+zje+"x100%="+zje+"元";
		}else{
			YhMsg.innerHTML="金额=原价X折扣="+zje+"x"+YhVal+"%="+Math.round(zje*(YhVal/100))+"元";
		};
		
	}else{
		
		YhTitle.innerHTML="请输入优惠金额(元)";
		if(YhVal==""){
			YhMsg.innerHTML="金额=原价-减免="+zje+"-0="+zje+"元"; 
		}else{
			YhMsg.innerHTML="金额=原价-减免="+zje+"-"+YhVal+"="+(zje-YhVal)+"元";
		};
	}
} 
function yhsave(){
	bid=document.getElementById("bid").value;
	type=document.getElementById("YHTYPE").value;
	val=document.getElementById("yhvalue").value;
    tips=document.getElementById("yhtips").value;

	yhmsg=Ajax2({"bid":bid,type:type,val:val,tips:tips,atype:"setyh"})
		//alert(yhmsg); 
	if(yhmsg.indexOf("成功")!=-1){
		alert("保存成功");
		document.getElementById("yhclose").click();
		location.reload()
	}else{
		alert(yhmsg);
	}
	
}
function acshop(sid,bid,kc,sname){
	//alert(sid+":"+bid+":"+kc)
	var kh=document.getElementById("khid") 
	sl=prompt("请输入<="+kc+"的所需数量\n\n商品名称:"+ sname +"\n\n当前库存剩余:["+kc+"]")
	if(sl>0&&sl<=kc){
		$.post("ajax.php",{bid:bid,sid:sid,gs:sl,yh:0,gr:"员工1",tips:"无",atype:"ashop"},function(data,aaa){history.go(-0);}) 
		
	}else if(sl>0){
		alert("库存不足") 
	}else{
		alert("输入错误")
	}

	//closeb("csp")
}
/*刷新已添加商品列表*/
function reloadsp(){
	$.post("ajax.php",{bid:bid,atype:"reloadsp"},function(data,aaa){ashop.innerHTML=cut(data,"[ashop]","[/ashop]")})
}
/*刷新公司商品列表*/
function ReloadShop(){
	var cp=document.getElementById("cp").value
	var bid=document.getElementById("bid").value
	$.post("ajax.php",{cp:cp,bid:bid,atype:"ReloadShop1"},function(data,aaa){ShopTab.innerHTML=cut(data,"[ashop]","[/ashop]")});
}
/*
function reloadt(tab){
	var bid=document.getElementById("bid").value
	if(tab=="aitem"){ tabn="itemtb";str="项目";col=12;}else{ tabn="shoptb";str="商品";col=14;}
	tabb=document.getElementById(tabn)
	$.post("ajax.php",{id:0,bid:bid,table:tab,atype:"del"},function(data,aaa){tabb.innerHTML=data
		if(tab=="aitem"){changermb(0,"item");}else{changermb(0,"shop");}
	})
}
*/
function crm(rindex,type){
    var bid=document.getElementById("bid").value
	var rmbs=document.getElementById("rmbs") //订单总价获取
	var ot
	if(type=="aitem"){
		var gs=document.getElementById("gs"+rindex).value
		var iyh=document.getElementById("iyh"+rindex).value
	    var aiid=document.getElementById("aiid"+rindex).className	
		$.post("ajax.php",{id:aiid,gsl:gs,isyh:iyh,table:type,atype:"upais"},function(data,aaa){reloadt(type)})
	}else{
		//alert(bid+rmbs.length)
		var sl=document.getElementById("sl"+rindex).value
		//var syh=document.getElementById("syh"+rindex).value
		var asid=document.getElementById("asid"+rindex).className
		$.post("ajax.php",{id:asid,gsl:sl,isyh:1,table:type,atype:"upais"},function(data,aaa){
			reloadt(type);
		})
		//alert(asid+","+sl+","+syh)
	}
   // rmbs.innerHTML="订单总额:"+(zrmba+zrmbb)+"元"
}
function cgxm(id){
//项目内容改动
	var bid=document.getElementById("bid").value
	var gs=document.getElementById("gs"+id).value
	var st=document.getElementById("st"+id).value
	var et=document.getElementById("et"+id).value
	var ps=document.getElementById("ps"+id).value
	$.post("ajax.php",{id:id,gs:gs,st:st,et:et,ps:ps,atype:"cgxm"},function(data,aaa){delxm(0,bid);})
}
function update(){
	var bid=document.getElementById("bid").value
	var khid=document.getElementById("khid").value
	
	var btype=document.getElementById("b_type").value
	//alert("订单类型:"+btype)
	var bps=document.getElementById("bps").value
	var zje=(zrmba+zrmbb)
	//alert(bid+","+khname+","+error+","+bps+","+zje)
	$.post("ajax.php",{bid:bid,khid:khid,btype:btype,bps:bps,zje:zje,atype:"upbill"},function(data,aaa){})
	alert("保存成功")
	window.close()
	//alert("订单总金额为"+(bid))
}

function billjx(){
	var ywzt=$("#ywzt").val()
	var jsfs=$("#jsfs").val()	
	alert("结算方式:"+jsfs+"\n业务状态："+ywzt)
	if(ywzt&jsfs){
		alert("结算成功")	
	}else{
		alert("订单状态不正确")	
	}
}
mmax=0
spid=0
asid=0
function tuihuo(id,spname,sl,sp){
	var khid=document.getElementById("khid").value
	//var bid1=document.getElementById("bid").value
	$("#thsl").val(0)
	$("#spname").val(spname)
	$("#max").html(sl)
	//$("#range").moves
	mmax=sl
	asid=id
	spid=sp
	add("th")
	

	//alert(id)
	//alert(sp)
	//alert(sl)
			
}
function subth(){
var thsl=document.getElementById("thsl").value
var khid=document.getElementById("khid").value
var thyy=document.getElementById("thyy").value
var cp=document.getElementById("cp").value
var bid=document.getElementById("bid").value
//alert(cp+"\nbid:"+bid)
del=mmax-thsl
//if(!del){alert("将会删除商品")}else{alert("还剩余"+del+"个")}
$.post("ajax.php",{asid:asid,cp:cp,bid:bid,sid:spid,khid:khid,thsl:thsl,thyy:thyy,del:del,atype:"spth"},function(data,aaa){
		if(data.indexOf("成功")!=-1){alert("退货成功");history.go(-0)}else{alert(data)}
		
	})
//alert("退货数量"+thsl+"\n退货原因"+thyy+"\n商品id"+sid+"\n客户id"+khid)
	
}

//更改滑块
function range(){
	var val=$("#range").val()
	val=Math.floor((val/100)*mmax)
	$("#thsl").val(val)
	
}
//退货数量进制转换
function cg(){
	var thsl=Math.floor($("#thsl").val())	
	$("#range").val(Math.floor(thsl/mmax*100))
}
//退货数量增加
function up(){
	var thsl=Math.floor($("#thsl").val())
	if(thsl<mmax){
		thsl++
		rval=Math.floor(thsl/mmax*100)
		$("#thsl").val(thsl);$("#range").val(rval)}//else{alert("max="+mmax+"\nthsl="+thsl)}
}
//退货数量减少
function down(){
	var thsl=Math.floor($("#thsl").val())
	if(thsl>0){
		thsl--
		rval=Math.floor(thsl/mmax*100)
		$("#thsl").val(thsl);$("#range").val(rval)}
}

//已添加项目删除
function delxm(id,bid){
	if(id){
		if(confirm("该操作无法撤销 ，是否确认删除？","超温馨的提示")){
			$.post("ajax.php",{aiid:id,bid:bid,atype:"delxm"},function(data,aaa){
				xmdata.innerHTML=cut(data,"[aitem]","[/aitem]")
			})
		}			
	}else{
			$.post("ajax.php",{aiid:id,bid:bid,atype:"delxm"},function(data,aaa){
				xmdata.innerHTML=cut(data,"[aitem]","[/aitem]")
			})		
	}
	
}

function jisuan(){
	var bid=document.getElementById("bid").value;//订单ID
	var gs=document.getElementsByName("gs");//项目工时
	var dj=document.getElementsByName("sdj");//商品单价集合
	var sl=document.getElementsByName("ssl");//商品数量集合
	var sjes=document.getElementsByName("sdj");//商品金额集合
	var spje=document.getElementById("spje").value;//商品总额
	var zgs=0,zspje=0;
	for(var i=0;i<gs.length;i++){
		zgs+=parseInt(gs[i].value);
	}
	for(var i=0;i<sjes.length;i++){
		//alert(parseInt(dj[i].value)+"|"+ parseInt(sl[i].value))
		zspje+=parseInt(dj[i].value)*parseInt(sl[i].value)
	}
	itemrmb.innerHTML="总计:"+zgs+"元";
	zje=zgs+zspje; //总金额=总工时+总商品金额
	//rmbs.innerHTML="订单总额:"+zje+"元";
	document.getElementById("shoprmb").innerHTML=zspje+"元"
	
	$.post("ajax.php",{bid:bid,zje:zje,atype:"update-bill-zje"},function(data,aaa){
		//alert(data)
	});	
}
function AddItemRow(ItemName,ItemId){
	var XiaoFei=document.getElementsByName("xfje")
	var content="<tr><td name='ItemNum'>"+XuHao(XiaoFei.length+1)+"</td>"+
				"<td><input type='text' style='width:60px;' class='input_td' name='xfje'onchange='isnum(this);zje()' placeholder='金额'></td>"+
				"<td>"+
					"<input type='text' style='width:200px; id='item' disabled name='items' class='btn btn-info btn-sm ' placeholder='请输入项目名称' style='width:100px;' value='"+ItemName+"'>"+
					"<input type='hidden'  name='itemids' value='"+ItemId+"'>"+
				"</td>"+
				"<td ><input type='text' class='input_td'  style='width:100px;' name='ItemTips' placeholder='备注'></td>"+
				"<td><input type='text' class='input_td' disabled style='width:100px;' name='izje' placeholder='0元'></td>"+
				"<td><b class='btn btn-danger btn-xs' onclick='DelItem(this)'>X</b></td></tr>";
	var Itemr=document.getElementById("itemr");
	Itemr.innerHTML+=content;
	zje()
}
function AddItem(){ 
	 iname=$("#itemname").val();//项目名称
	 itype=$("#b_type2").val();//项目类型
	 itips=$("#itips").val();//项目备注
	 cp=$("#cp").val();//公司id获取	
	 if(iname!=""){
		$.post("ajax.php",{iid:0,tips:itips,iname:iname,itype:0,imoney:0,ierror:0,cp:cp,atype:"additem"},function(data,aaa){
		  var itemid=cut(data,"[newid]","[/newid]")
		  acitem(itemid)
		})
	}else{
		alert("请填写项目名称");
	}
}

function AddItemButton(){
	var ItemNameInput=document.getElementById("itemname");
	ItemNameInput.value="";
	setTimeout( function(){ItemNameInput.focus();},1000);
	
}

/*添加项目时按回车事件*/
function AddItemKeydown(obj){
	  event = event || window.event;
	  
	  if(event.keyCode==13){
		  if(obj.value==""){
			  obj.style.borderColor="#fb6f6f";
		  }else{
			  document.getElementById("SaveItemButton").click()
		  }
      } 
}

/*订单结算*/
function bill_js(bid,kh){
	khname=document.getElementById("khname").value
	$.post("ajax.php",{bid:bid,kh:kh,atype:"bill-js"},function(data,aaa){ 
		if(data.indexOf("不足")==-1){
			alert("结算成功");
			location.href="shouyin.php"
		}else{
			/*if(confirm("结算失败，余额不足\n是否立即充值？")){
				switch(prompt("请选择充值面额\n1:50元\n2:100元\n3:300元\n4:500元\n5:1000元\n输入相应序号选择充值金额")){
					case "1":czje=50;break;
					case "2":czje=100;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "3":czje=300;break;
					case "4":czje=500;break;
					case "5":czje=1000;break;
					default:alert("输入错误")
				}
				switch(prompt("请选择充值面额\n1:微信支付\n2:支付宝\n3:现金\n4:其他\n输入相应序号选择充值方式")){
					case "1":czfs="微信支付";break;
					case "2":czfs="支付宝";break;
					case "3":czfs="现金支付";break;
					case "4":czfs="其他";break;
					default:alert("输入错误")
				}
				
				tips=prompt("备注信息"))
			}*/
			
			alert("结算失败 余额不足 请充值\n\n请在弹出的页面中点击 充值记录>添加充值");
			window.open("shouyin.php?kh="+khname);
		}
	});	
}

function tjcz(){
	 var kh=document.getElementById("khid").value
	 //alert(tips)
	 	$.post("ajax.php",{kh:kh,cp:cp,je:czje,zf:zffs,atype:"hycz"},function(data,aaa){
		  if(data.indexOf("成功")!=-1){
			  czjl(kh)
			   $("#addcz1").toggle(10)
		  /* }else{ */
			  alert(data)
		  }
	})
	
}

function downsl(ashopid,obj){
	//alert(obj)
	$.post("ajax.php",{ashopid:ashopid,atype:"downsl"},function(data,aaa){
		if(data.indexOf("不足")==-1){
			document.getElementById(obj).value=cut(data,"[sl]","[/sl]")
			document.getElementById("srmb"+ashopid).innerHTML=cut(data,"[money1]","[/money1]")+"元"
			
			jisuan()
			//alert(cut(data,"[money1]","[/money1]"))
		}
		
		//alert(cut(data,"[sl]","[/sl]")) 
		//history.go(0)
		//alert(data)
	})
}
function upsl(ashopid,obj){
	$.post("ajax.php",{ashopid:ashopid,atype:"upsl"},function(data,aaa){
		if(data.indexOf("不足")==-1){
			document.getElementById(obj).value=cut(data,"[sl]","[/sl]")
			document.getElementById("srmb"+ashopid).innerHTML=cut(data,"[money1]","[/money1]")+"元"
			jisuan()
			//alert()
		}
		//alert(cut(data,"[sl]","[/sl]"))
		//history.go(0)
		//alert(data)
	})
}

function sshop(){
		var sname=document.getElementById("sname").value;
		var skc=document.getElementById("ssl").value;
		var sdj=document.getElementById("sdj").value;
		var scb=document.getElementById("scb").value;
		var spp=document.getElementById("spp").value;
		var guige=0; 
		
		var xinghao=0;
		var gys=0;
		var gysphone=0;
		
		var etime=document.getElementById("etime").value;
		var akc=document.getElementById("akc").value;
		var scar=document.getElementById("car").value;
		var cp=document.getElementById("cp").value;
		var U=document.getElementById("u").value;
		if(sname!=""&&spp!=""){
			shopInfo={sdw:"",sname:sname,skc:skc,sdj:sdj,scb:scb,spp:spp,sgg:guige,etime:etime,akc:akc,scar:scar,company:cp,xinghao:xinghao,gys:gys,gysphone:gysphone}; 
			var shop=INSERT("shop",shopInfo,true);
			printr(shop);
			if(shop.state){
				alert("保存成功")
				document.getElementById("tj").value=sname;
				document.getElementById("closeAddsp").click();
				SearchShop(sname,1)
			}
			//var log=INSERT("log",{date:DATE(),U:U,type:"添加",obj:"商品",value:shop.newid,value2:});
			
			//alert("提交成功")
		}else{ 
			alert("请完善信息商品信息");
		}
}

function SearchShop(val,page){
	cp=document.getElementById("cp").value
	var bid=document.getElementById("bid").value
	$.post("ajax.php",{bid:bid,val:val,cp:cp,page:page,atype:"SearchShop2"},function(data,aaa){
		ShopTab.innerHTML=cut(data,"[ashop]","[/ashop]")
	}) 
}
function ChangeShopMoney(ASPID,OBJ,Money){
	var NewMoney=prompt("请输入要修改的价格",OBJ.value)
	
	if(!isNaN(NewMoney)&&NewMoney!=null){
		$.post("ajax.php",{NewMoney:NewMoney,ASPID:ASPID,atype:"ChangeShopMoney"},function(data,aaa){
			OBJ.value=NewMoney
			jisuan()
			
			//alert(data)
		})
			
	}
	
}

function updateBillInfo(e){
	col=e.id;
	val=e.value;
	billId=bid.value;
	UPDATE("bill",col,val,"id="+billId,true)
	//alert(col+val+billId);
}


function ReloadAShop(){
	
}
function test(){
		$.post("http://ijy.zjvtit.edu.cn/m/login/",
		  {
		    username:123,
		    password:123
		  },
		  function(data, status){ 
              alert(data);
			  //alert("OPID:"+id+";"+"STATE:"+status+";"+"RESULT:"+result+";");
            
        })
	
}















