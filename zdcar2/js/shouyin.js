
cp=document.getElementById("cp").value; 
U=document.getElementById("u").value;
PayKehuId=0;
PayBillID=0;
REMAIN=0;
iMoneys=[];
iTips= [];
/*回车事件1*/
function enter(value){
	if(event.keyCode==13){
		khcx(value,1)
	}
}
/*客户查询*/
function khcx(val,page){ 

	cxbill.style.display='none';
	$("#TableBody").hide();
	var SearchMode=RadioValue("SearchMode")
	if(SearchMode=="kehu"){
		SouSuo.placeholder="请输入姓名或手机号进行检索";
		$.post("ajax.php",{cp:cp,page:page,val:val,atype:"SearchKehu"},function(data,aaa){
			a=cut(data,"(((",")))")
			//alert(cp)
			//alert(data)
			if(data.indexOf("匹配")!=-1){
				//alert("无匹配数据")
				viptb.style.display="none"
				isnulltb.style.display="block"
			}else{
				isnulltb.style.display="none"
				viptb.style.display="block"
				viptba.innerHTML=a;
			}
		})
	}else if(SearchMode=="bill"){
		isnulltb.style.display="none";
		viptb.style.display="none";
		$("#TableBody").hide();
		$("#cxbill").show(); 
		SouSuo.placeholder="请输入订单编号或开单客户或日期进行检索";  
		var Bill=Ajax2({val:val,cp:cp,page:page,atype:"SearchBill"});
		cxbill.innerHTML=Cut2(Bill,"searchbill")
	}else if(SearchMode=="shop"){
		//alert(page)
		isnulltb.style.display="none";
		viptb.style.display="none";
		$("#TableBody").show();
		SouSuo.placeholder="请输入商品名称或编码或品牌进行检索";
		$.post("ajax.php",{val:val,cp:cp,page:page,atype:"SearchShop"},function(data,aaa){TableBody.innerHTML=cut(data,"[ashop]","[/ashop]")}) 
	}else if(SearchMode=="item"){
		isnulltb.style.display="none";
		viptb.style.display="none";
		$("#TableBody").show();
		SouSuo.placeholder="请输入项目编码或项目名称或项目分类进行检索";
		$.post("ajax.php",{val:val,cp:cp,page:page,atype:"SearchItem"},function(data,aaa){TableBody.innerHTML=cut(data,"[aitem]","[/aitem]")}) 
	}else if(SearchMode=="car"){
		SouSuo.placeholder="请输入车牌号或车辆品牌或客户信息进行检索";
		isnulltb.style.display="none";
		viptb.style.display="none";
		$("#TableBody").show();
		$.post("ajax.php",{val:val,cp:cp,page:page,atype:"SearchCar"},function(data,aaa){TableBody.innerHTML=GaoLiang(cut(data,"[acar]","[/acar]"),val)}) 
	}
	//alert(val)
}
/*充值记录*/
function czjl(id,page){
	$.post("ajax.php",{kh:id,page:page,atype:"ShowCzjl"},function(data,aaa){
		//alert(data)
		czjla.innerHTML=cut(data,"[czjl2]","[/czjl2]")
		KehuInfo.innerHTML=cut(data,"[info]","[/info]")
	})
}

/*消费记录*/
function xfjl(kh,page){
	
	xfjla.innerHTML=Cut2(Ajax2({kh:kh,page:page,atype:"xfjl"}),"xfjl")+"<input id='khid' type='hidden' value="+kh+"/>";

	CarList.innerHTML=Ajax2({kh:kh,atype:"GetCarList"});

	document.getElementById("khid").value=kh

	
	/*DEBUG*/
	printr("调用函数名称xfjl(kh,page)\n--------------------------------------");
	printr("Ajax请求了消费记录 请求模式:xfjl");
	printr("Ajax请求了用户车辆列表 请求模式:GetCarList");
	printr("将客户id:"+kh+"赋给了 隐藏域 input-#khid");
}
/*车辆显示*/
function car(id){
	carinfo1.innerHTML=Ajax3({kh:id,atype:"car2"});
		
}

function DelCar(carid,khid){
	if(confirm("删除车辆后数据将无法恢复 是否确认删除")){
		$.post("ajax.php",{carid:carid,atype:"delcar"},function(data,aaa){
			//alert(data)
			if(data.indexOf("成功")!=-1){
				alert("删除成功");
				car(khid)
			}else{
				alert("删除失败\n————————————————\n错误原因:\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n"+data)
			}
			
		})
	}
}

function addcz(){
 var kh=document.getElementById("khid").value
 $("#addcz1").toggle(1000)
 //alert(kh)
}
function addcar(e){
	 $("#addcar").toggle(1000);
	 if(e.value=="增加车辆"){
		 e.value="取消";
		 e.className="btn btn-warning btn-sm";
	 }else{
		 e.value="增加车辆";
		 e.className="btn btn-primary btn-sm";
	 }
	// alert(e.value)
}
/*车辆添加*/
function scar(){
	var KH=document.getElementById("khid").value
	var CARID=document.getElementById("addCarid").value
	var VIN=document.getElementById("addVin").value
	var ADDKM=document.getElementById("addKm").value
	var ADDBXDATE=document.getElementById("addBxDate").value
	var ADDNJDATE=document.getElementById("addNjDate").value
	var ADDTIPS=document.getElementById("addTips").value
	
	if(CARID.length==7){
		if(!EXIST("car2","carid",CARID)){
			var R=INSERT("car2",{kh:KH,carid:CARID,vin:VIN,km:ADDKM,date_bx:ADDBXDATE,date_nj:ADDNJDATE,tips:ADDTIPS},true);
			if(R.state){
				alert("添加成功");
				car(KH);	
			}else{
				alert(R.info);
			}
		}
	}else{
		alert("车牌号格式错误")
	}
	
}
function SetDefaultCar(kh,carid){
	$.post("ajax.php",{kh:kh,carid:carid,atype:"SetDefaultCar"},function(data,aaa){
		car(kh);
		//alert(data);
	})
}
/*添加充值*/
function tjcz(e){
	 e.disabled=true; 
	 var kh=document.getElementById("khid").value;
	 var czje=document.getElementById("czmoney").value;
	 var zffs=document.getElementById("czfsa").value;
	 var tips=document.getElementById("cztips").value;
	 var USERID=document.getElementById("USERID").value;
	// alert(cp)
	
	 //alert(kh+"|"+czje+"|"+zffs+"|"+tips)
	 //alert(tips)
	 if(czje!=""){
	 	if(zffs!=0){
			var data=Ajax2({kh:kh,cp:cp,je:czje,zf:zffs,tips:tips,COMPANY:cp,USERID:USERID,atype:"hycz"});
			  if(data.indexOf("成功")!=-1){
				  czjl(kh)
				  khcx(SouSuo.value,1)
				   e.disabled=false;
				   document.getElementById("czmoney").value="";
				   document.getElementById("cztips").value="";
				   document.getElementById("CloseczWin").click();	 
				   
				   alert("充值成功")
			  }else{
				  alert(data)
			  }
		}else{
			alert("请选择支付方式")
		}
	}else{
		alert("请输入充值金额")
	}
	
}
/*添加客户*/
function skehu(){
	var name=document.getElementById("kname").value
	var phone=document.getElementById("kphone").value
	var carid=document.getElementById("carid").value
	if(name!=""&&phone.length==11){
		$.post("ajax.php",{khname:name,cp:cp,khadd:"",khpho:phone,khcar:"",khcarid:carid,khps:"无",atype:"addkh"},function(data,aaa){
			if(data.indexOf("成功")!=-1){	
				alert("保存成功")
				khcx(name,1)
				//document.getElementById("sou").value=name
			}
		})
	}else{
		alert("信息填写不正确\n1.请检查用户姓名是否填写\n2.手机号码格式是否正确");
	}
}
/*客户信息*/
function khinfo(khid){
	khmsg=Ajax2({atype:"khinfo",khid:khid});
	//alert(khmsg) 
	document.getElementById("khinfotab").innerHTML=cut(khmsg,"[khinfotab]","[/khinfotab]");
	document.getElementById("khvip").innerHTML=cut(khmsg,"[vip]","[/vip]");
	document.getElementById("khlv").innerHTML="V"+cut(khmsg,"[khdj]","[/khdj]");
	document.getElementById("khhead").src=cut(khmsg,"[khhead]","[/khhead]");
	document.getElementById("khqr").src=Cut2(khmsg,"qrimg");
	
	loadExpLine(Cut2(khmsg,"exp"),cut(khmsg,"[khdj]","[/khdj]"));
	
}

function loadExpLine(exp,lv){
	
	
	var Line1=document.getElementById("eline1");
	var Line2=document.getElementById("eline2");
	var NLV=Number(lv)+1;
	var NEXP=(NLV*(NLV+1)/2)*50;
	var L1W=200*(exp/NEXP);
	var L2W=200-L1W;
	Line1.style.width=L1W+"px";
	Line2.style.width=L2W+"px";
	Line1.title="当前经验:"+exp+"/"+NEXP;
	
}
function aaaa(){
	//alert(1);
	$("#khqr").toggle(1000);
	//document.getElementById("qrcode").style.display="none";
	
}
function khinfosave(){
	khid=document.getElementById("khid").value
	khname=document.getElementById("khname").value;
	khphone=document.getElementById("khphone").value;
	khtips=document.getElementById("khtips").value;
	kisMsg=Ajax2({khname:khname,khphone:khphone,khtips:khtips,khid:khid,atype:"khinfosave"});	
	//alert(kisMsg);
}
function SaveKehu(){
	var KehuName=$("#KehuName").val();
	var KehuPhone=$("#KehuPhone").val()
	var KehuCarid=$("#KehuCarid").val()
	var CompanyID=$("#cp").val()
	var KehuInfoInput=document.getElementsByName("KehuInfoInput")
	var KehuInpuError=0
	for(i=0;i<KehuInfoInput.length;i++){
		if(KehuInfoInput[i].value==""){
			KehuInfoInput[i].style.borderColor="#fb6f6f";
			KehuInpuError++;
		}
	}
	if(KehuInfoInput[1].value.length!=11){KehuInpuError++;KehuInfoInput[1].style.borderColor="#fb6f6f";}
	if(KehuInpuError>0){
		alert("信息不正确");
	}else{ 
		var AjaxData={"atype":"Addkehu","KehuCarid":KehuCarid,"CompanyID":CompanyID,"KehuName":KehuName,"KehuPhone":KehuPhone,KehuTips:0}
		var SaveKehuMsg=Ajax("ajax.php","post",AjaxData,false);
        if(SaveKehuMsg.indexOf("车辆存在")!=-1){
			alert("该车辆已存在");
			KehuInfoInput[2].style.borderColor="#fb6f6f";
		}else if(SaveKehuMsg.indexOf("成功")!=-1){
			var KehuID=cut(SaveKehuMsg,"[newid]","[/newid]");
			var CarInfo={"KehuID":KehuID,"Carid":KehuCarid,"KehuCarvin":0,"KehuCarkm":0,"atype":"AddKehuCar"}
			var SaveCarMsg=Ajax("ajax.php","post",CarInfo,false);
		    if(SaveCarMsg.indexOf("成功")!=-1){
				alert("保存用户成功") 
				khcx(KehuName,1)
			}
		}else{
			alert(cut(SaveKehuMsg,"[ErrorMsg]","[/ErrorMsg]"))
		}
		//
	} 
	//<button class="btn btn-primary btn-xs" data-dismiss="modal" onclick="ChoseKehu(5,7370)">选择</button>
	//<button class="btn btn-primary btn-xs" data-dismiss="modal" onclick="ChoseKehu(0,7371)">选择</button>
	
}


/*页面加载*/
function pageload(){
	var Request = new Object();
	Request = GetRequest();
	var val=decodeURI(Request["val"]);
	var mode=decodeURI(Request["mode"]);
	if(mode!='undefined'){
		if(val=='undefined'){val=""};
		switch(mode){
			case "kehu":

			break;
			case "bill":
				ChoseRadio("SearchMode","bill");
			break;
			case "shop":
				ChoseRadio("SearchMode","shop");
			break;
			case "item":
				ChoseRadio("SearchMode","item");
			break;
			case "car":
				ChoseRadio("SearchMode","car");
			break;
		}
		khcx(val,1);
		SouSuo.value=val;
		//addcz.show();

	}else{
	 khcx("",1)
	}
	
}
/**/
function ChoseRadio(RadioName,value){
	RadioObj=document.getElementsByName(RadioName)
	//alert(RadioObj.length)
	for(i=0;i<RadioObj.length;i++){
		if(RadioObj[i].value==value){
			RadioObj[i].checked=true;
		}
	}
	
}
//获取URl参数函数
function GetRequest() {
  var url = location.search; //获取url中"?"符后的字串
   var theRequest = new Object();
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}
//获取同一个Name的Radio值函数
function RadioValue(name){
	var SearchMode=document.getElementsByName("SearchMode")
	for(i=0;i<SearchMode.length;i++){
		if(SearchMode[i].checked) return SearchMode[i].value
	}
}
function GaoLiang(str,a){
		return  str.replace(a,"<b style='color:red;'>"+a+"</b>");
		//str.replace(a,"<b style='color:red;'>"+a+"</b>")
	//return str;
}

function itemMoneyChange(e){
	index=e.getAttribute("index");
	value=e.value
	iMoneys[index]=value;
	printr("\n==========iMoney数组===========\n");
	printr(iMoneys)
	printr(iTips)
	isnum(e);
	zje();
}
function itemTipsChange(e){
	index=e.getAttribute("index");
	value=e.value
	iTips[index]=value;
	printr("\n==========TIPS数组===========\n");
	printr(iMoneys)
	console.log("Log level");
	console.debug("Debug level");
	console.info("Info level");
	console.warn("Warn level");
	console.error("Error level");
	printr(iTips)

}
/*快捷消费-项目删除*/
function DelItem(obj){  
	row = obj.parentNode.parentNode//A标签所在行
	var tb = row.parentNode; //当前表格
    var rowIndex = row.rowIndex; //A标签所在行下标
	//alert(rowIndex-1)
	tb.deleteRow(rowIndex-2); //删除当前行
	var ItemNumber=document.getElementsByName("ItemNumber")
	//序号重新排序
	//alert(ItemNumber.length)
	for(i=-1;i<ItemNumber.length-1;i++){
		ItemNumber[i+1].innerHTML=XuHao(i+2);
		printr("ItemNumber["+(i+1)+"].innerHTML=XuHao("+(i+2)+")");
	}
	
	
	
	
	
	zje();
	
	//$('#addxfa tr:eq('+(index)+')').remove();
}

/*快捷消费-零件删除*/
function DelShop(obj){
	row = obj.parentNode.parentNode//A标签所在行
	var tb = row.parentNode; //当前表格
    var rowIndex = row.rowIndex; //A标签所在行下标
	//alert(rowIndex)
	tb.deleteRow(rowIndex-2); //删除当前行
	//var aa=document.getElementsByName("ItemNum")
	//序号重新排序
	//for(i=0;i<aa.length;i++){
	//	aa[i].innerHTML=XuHao(i+2)
	//}
	zje()
	//$('#addxfa tr:eq('+(index)+')').remove();
}

/*快捷消费添加项目*/
function AddItemRow(ItemName,ItemId){
	 itemMoneys=document.getElementsByName("itemMoneys");
	 itemIds=document.getElementsByName("itemIds");
	 itemTips=document.getElementsByName("itemTips");
	 itemNames=document.getElementsByName("itemNames"); 
	 Itemr=document.getElementById("itemr");
	 Content=createContent(itemMoneys.length,ItemId,ItemName,"","");
	 Itemr.innerHTML+=Content;
	 var Index=itemMoneys.length-1;
	 iMoneys[Index]="";
	 iTips[Index]="";
	/*  iMoneys[Index]=ItemId;
	 
	iIds=iMoneys=iNames=iTips= [];	 
	 Content=createContent(itemMoneys.length,ItemId,ItemName,"","");
	 C="";
	Itemr.innerHTML+=Content;
	for(i=0;i<itemMoneys.length;i++){
		if(i<itemMoneys.length-1){
		 C+=createContent(i,itemIds[i].value,itemNames[i].value,itemMoney[i].value,itemTips[i].value);
		}else{
			C+=Content;
		}
	}*/
	
	
	for(i=0;i<itemMoneys.length;i++){
		itemMoneys[i].value=iMoneys[i];
		itemTips[i].value=iTips[i];
		
		
	}
	zje()
	/*for(i=0;i<XiaoFei.length;i++){
		alert(XiaoFei[i].value+"|"+ITEMNAME[i].value+"|"+Tips[i].value+"|")
		Content+="<tr><td name='ItemNum'>"+XuHao(XiaoFei.length+1)+"</td>"+
				"<td><input type='text' value="+XiaoFei[i].value+" style='width:60px;' class='input_td' name='xfje'onchange='itemMoneyChange(this)' placeholder='金额'></td>"+
				"<td>"+
					"<input type='text' style='width:200px; disabled name='itemname' class='btn btn-info btn-sm ' placeholder='请输入项目名称' style='width:100px;' value='test'>"+
					"<input type='hidden'  name='itemids' value='"+IID[i].value+"'>"+
				"</td>"+
				"<td ><input type='text' class='input_td'  style='width:100px;' name='ItemTips' placeholder='备注' value="+Tips[i].value+"></td>"+
				"<td><input type='text' class='input_td' disabled style='width:100px;' name='izje' placeholder='0元'></td>"+
				"<td><b class='btn btn-danger btn-xs' onclick='DelItem(this)'>X</b></td></tr>";
	}*/
	

	//alert(XiaoFei.length)*/
}

function createContent(index,itemID,itemName,itemMoney,itemTips){
	var C2="<tr>"+
				"<td name='ItemNumber'>"+XuHao(index+1)+"</td>"+
				"<td><input type='text' style='width:60px;' index='"+index+"' class='input_td' name='itemMoneys' onchange='itemMoneyChange(this)' placeholder='工时费'>"+itemMoney+"</td>"+
				"<td>"+
					"<input type='text' style='width:200px; disabled name='itemNames' class='btn btn-info btn-sm ' placeholder='请输入项目名称' style='width:100px;' value='"+itemName+"'>"+
					"<input type='hidden'  name='itemIds' value='"+itemID+"'>"+
				"</td>"+
				"<td ><input type='text' class='input_td' index='"+index+"' style='width:100px;' name='itemTips' placeholder='备注' onchange='itemTipsChange(this)'>"+itemTips+"</td>"+
				"<td><input type='text' class='input_td' disabled style='width:100px;' name='izje' placeholder='0元'></td>"+
				"<td><b class='btn btn-danger btn-xs' onclick='DelItem(this)'>X</b></td></tr>";
	return C2;
}
function showi(){
	printr("\n==========iMoney数组===========\n");
	printr(iMoneys)
	printr("\n===============================\n");
	printr("\n==========TIPS数组===========\n");
		printr(iTips)
	printr("\n===============================\n");
}


/*快捷消费 添加商品*/
function ChoseShop(sid,sdj,skc,sname){
	//alert(sid)
	var Shops=document.getElementsByName("spsl")
	//alert("当前有"+(Shops.length+2)+"行 将新数据插入在第"+(Shops.length+2)+"行前")
	var content="<td name='ShopNum'>"+XuHao(Shops.length+1)+"</td>"+
				"<td><input type='text' style='width:60px;' class='input_td' name='spsl'onchange='isnum(this);zje()' placeholder='数量' value='1'></td>"+
				"<td>"+
					"<input type='text' style='width:200px; id='item' name='items' class='btn btn-warning btn-sm ' placeholder='商品名称' style='width:100px;' value='"+sname+"'>"+
					"<input type='hidden'  name='shopids' value='"+sid+"'>"+
				"</td>"+
				"<td><input type='text' style='width:60px;' class='btn btn-success btn-xs' name='spdj' onchange='isnum(this);zje()' placeholder='单价' value='"+sdj+"'>元</td>"+
				"<td><input type='text' class='input_td' disabled style='width:100px;' name='szje' placeholder='0元'></td>"+
				"<td><b class='btn btn-danger btn-xs' onclick='DelShop(this)'>X</b></td>";
				document.getElementById("shops").innerHTML+=content;
				zje()
}
MoneyAll=0;
/*价格计算*/
function zje(){
	var Money=document.getElementsByName("itemMoneys");//项目价格
	var Izje=document.getElementsByName("izje");//项目总金额显示（没什么卵用）
	var Spsl=document.getElementsByName("spsl");//零件数量
	var Spdj=document.getElementsByName("spdj");//零件单价
	var Szje=document.getElementsByName("szje");//零件价格计算
	MoneyAll=0;
	for(i=0;i<Money.length;i++){
		if(Money[i].value!=""){a=Money[i].value;}else{a=0};
		Izje[i].value=parseInt(a)+"元";
		MoneyAll+=parseInt(a);
		
	}
	for(i=0;i<Spsl.length;i++){
		if(Spsl[i].value!=""){
			a=parseInt(Spsl[i].value);
			b=parseInt(Spdj[i].value);
		}else{
			a=0
			b=parseInt(Spdj[i].value)
		};
		Szje[i].value=(a*b)+"元";
		MoneyAll+=(a*b);
	}
	document.getElementById("zje").innerHTML="总计:"+MoneyAll+"元";
}

/*数字判断*/
function isnum(obj){
	if(isNaN(obj.value)||(obj.value<0)){
		obj.value="";
	}
	
}
/*提交订单*/
function SubmitBill1(){
	var USERID=document.getElementById("USERID").value
	alert(USERID);
}
function SubmitBill(PayYN){
	var Car=document.getElementById("CarList").value //车牌号
	var bty=document.getElementById("b_type").value //订单类型
	var USERID=document.getElementById("USERID").value//操作人员
	
	var Moneys=document.getElementsByName("itemMoneys")   //项目金额
	var Items=document.getElementsByName("itemIds") //项目id
	var Tipss=document.getElementsByName("itemTips")//项目备注
	
	var ShopSl=document.getElementsByName("spsl") //商品数量
	var ShopId=document.getElementsByName("shopids")//商品id
	var ShopDj=document.getElementsByName("spdj")//商品单价
	var ShopMoney=document.getElementsByName("szje")//商品金额
	
	var MoneyError=ItemError=Error=ErrorMsg="",ErrorCount=0;
	if(Car==0){ErrorCount++;Error+="\n"+ErrorCount+"、未选择维修车辆"}
	if(bty==0){ErrorCount++;Error+="\n"+ErrorCount+"、未选择订单类型"}
	for(i=0;i<Moneys.length;i++){
		if(Moneys[i].value==""){ErrorCount++;MoneyError+="\n"+ErrorCount+"、项目"+cut(XuHao(i+1),"<b>","</b>")+"的价格不能为空";}
	}
	for(i=0;i<ShopId.length;i++){
		if(ShopSl[i]==""){ErrorCount++;ErrorMsg+="";}
	}

	//7   徐黎斌7195
	//alert("From LianHuangJi:功能测试中、敬请期待。")
	var khid=$("#khid").val();
	//alert("当前客户为："+khid)
	var bps="";
	//alert(Items.length+"|"+ShopId.length+"|"+Moneys.length)
	if((Items.length>0||ShopId.length>0)&&khid!=""&&bty!=0&&Car!=0&&ItemError==""&&MoneyError==""){
		//alert(MoneyAll)
		var NEWBILL=INSERT("bill",{zje:MoneyAll,money:MoneyAll,kehu:khid,bid:0,btype:bty,tips:bps,company:cp,carid:Car,U:USERID,date:DATE()},true);
		printr(NEWBILL);
		if(NEWBILL.state){

			BillId=NEWBILL.newid;
			UPDATE("bill","bid","KD"+DATE(1)+BillId,"id="+BillId);//更新订单编号
			var BINFO=SELECT("bill","*","id="+BillId);
			BINFO=BINFO[0];
			//%u为%v创建了订单<a href='%v'>%v</a> 维修车辆%v	
			LOG2(U,"addbill",[["kehu","name","id",BINFO["kehu"]],BillId,BINFO["bid"],BINFO["carid"]]);
			for(i=0;i<Moneys.length;i++){	
			    iid=Items[i].value;
				INSERT("aitem",{bid:BillId,iid:iid,gs:Moneys[i].value,yh:0,stime:0,etime:0,gr:"员工1",tips:Tipss[i].value},true);
			}
			
			for(i=0;i<ShopSl.length;i++){
				Ajax2({COMPANY:cp,USERID:USERID,khid:0,bid:BillId,sid:ShopId[i].value,gs:ShopSl[i].value,i:0,cs:0,gr:"员工1",tips:"无",atype:"ashop"});
			}
			if(PayYN){
				BillPay(BillId,khid,1,document.getElementById("quickPayButton"));
			}else{
				alert("订单保存成功");
				to("shouyin.php?mode=bill");
			}
		Renew();
		}
		
		//history.go(0) 
		//alert("结算成功")
	}else{
		alert("结算失败！出现以下"+ErrorCount+"个错误:\n---------------------------------------"+Error+MoneyError+ItemError)
	}
	
	/*

	if(Items.length>0&&bkh!=""&& bty!=0&& carid!=0 ){
		$.post("ajax.php",{zje:zje1,bkh:bkh,ber:bty,bps:bps,company:cp,carid:carid,atype:"abill"},function(data,aaa){		
	}*/
}
/*数字转序号*/
function XuHao(val){
	if(parseInt(val)<=10){
		switch(parseInt(val)){
			case 1:return"<b>"+"①"+"</b>";break;
			case 2:return"<b>"+"②"+"</b>";break;
			case 3:return"<b>"+"③"+"</b>";break;
			case 4:return"<b>"+"④"+"</b>";break;
			case 5:return"<b>"+"⑤"+"</b>";break;
			case 6:return"<b>"+"⑥"+"</b>";break;
			case 7:return"<b>"+"⑦"+"</b>";break;
			case 8:return"<b>"+"⑧"+"</b>";break;
			case 9:return"<b>"+"⑨"+"</b>";break;
			case 10:return"<b>"+"⑩"+"</b>";break;
			default:return "<b>"+"ERO"+"</b>";break;
		}
	}else{
		return "<b>"+val+"</b>";
	}
}
//初始化快捷消费
function Renew(){
	document.getElementById("itemr").innerHTML="";
	document.getElementById("shops").innerHTML="";
	document.getElementById("CarList").innerHTML="";
	document.getElementById("CloseButton").click(); 
	zje();
}
/*快捷消费-订单结算*/
function bill_js(bid,kh){
	//alert("测试内容:当前结算的是客户"+kh+"的订单")
	//khname=document.getElementById("khname").value
	$.post("ajax.php",{bid:bid,kh:kh,atype:"bill-js",C:cp},function(data,aaa){ 
		if(data.indexOf("不足")==-1){
			khcx(SouSuo.value,1);
			QuXiaoXiaoFei()
			document.getElementById("kjxf").style.display="none";
			xfjl(kh);
			document.getElementsByClassName("modal-backdrop in")[0].style.display="none"
			alert("结算成功");
			
			//return true;
		}else{
			khcx(SouSuo.value,1);
			alert("结算失败");
			var Msg=(cut(data,"[nomoney]","[/nomoney]"));
			PayFailed(bid,kh,Msg)
		}
	});	
}

function BillPay(bid,kh,PayMode,e){
	e.disabled=true;
	printr("--------------------------------------------------");
	printr("当前调用函数:BillPay("+bid+","+kh+","+PayMode+")");
	if(PayMode==1){PayMode="cz";}
	printr("当前PayMod:"+PayMode);
	var PayInfo={"bid":bid,"kh":kh,"PayMode":PayMode,"atype":"bill-js",C:cp};
	var PayMsg=Ajax("ajax.php","post",PayInfo,true);
	printr("发起Ajax请求,请求数据:");
	
	printr(PayInfo);
	printr("返回信息"+PayMsg);
	if(PayMsg.indexOf("不足")==-1){
		khcx(SouSuo.value,1);
		e.disabled=false; 
		alert("结算成功");
		var BINFO=SELECT("bill","*","id="+bid);
		BINFO=BINFO[0];
	   // "%u<b style='color:#f0f'>结算</b>了订单<b><a href='http://www.zduber.com/zdcar2/ebill.php?bid=%v'>%v</a></b>,订单客户:%v,订单金额:%v";
		LOG2(U,"billpay",[bid,BINFO["bid"],["kehu","name","id",BINFO["kehu"]],BINFO["money"]]);
		xfjl(kh,1)
		//PrintXP(bid);  
	}else{
		khcx(SouSuo.value,1);
		var Msg=(cut(PayMsg,"[nomoney]","[/nomoney]"));  
		REMAIN=Cut2(PayMsg,"REMAIN");
		PayKehuId=kh;
		PayBillID=bid;
		document.getElementById("PayErrorMsg").innerHTML=Msg;
		document.getElementById("JiesuanTestButton").click();
	}
	printr("BillPay()函数结束");

}
function PayFailed(bid,kh,Mgs){

	
}

function PrintXP(bid){
 javascript:window.open('PrintXP.php?bid='+bid,'','width=250,height=1000,toolbar=no, status=no, menubar=no, resizable=yes, scrollbars=yes');
 return false;
}
function PrintBill(bid){
 javascript:window.open('PrintBill.php?bid='+bid,'','width=650,height=900,toolbar=no, status=no, menubar=no, resizable=yes, scrollbars=yes');
 return false;
}
/*支付方式选择*/
function PayModeChange(o){
	var logo=document.getElementById("JiesuanLogo");
	var PayQrcode=document.getElementById("PayQrcode");
	var PayAmountBox=document.getElementById("PayAmountBox");
	var PayTitle=document.getElementById("PayTitle");
	var PayAmount=document.getElementById("PayAmount");
	switch(o.value){
		case "cz":
			logo.src="img/chongzhi.png";
			PayQrcode.src="img/chongzhi-qr.png";
			PayAmountBox.style.display="block";
			PayTitle.innerHTML="充值金额";
			PayAmount.setAttribute("placeholder","请输入充值金额");
		break;
		case "zfb":
			logo.src="img/zhifubao-logo.png";
			PayQrcode.src="img/zhifubao-qr.png";
			PayAmountBox.style.display="none";
		break;
		case "weixin":
			logo.src="img/weixin-logo.png";
			PayQrcode.src="img/weixin-qr.png";
			PayAmountBox.style.display="none";
		break;
		case "cash":
			logo.src="img/cash-logo.png";
			PayQrcode.src="img/cash.png";
			PayAmountBox.style.display="none";
		break;
		case "UnionPay":
			logo.src="img/unionpay-logo.png";
			PayQrcode.src="img/union-qr.png";
			PayAmountBox.style.display="none";
			
		break;
	}
	
}

/*支付*/
function Pay(BillID,KehuID,e){
	var PayMode=document.getElementById("PayMode").value
	//alert(KehuID)
		switch(PayMode){
		case "cz":
			var ErrorCount=0,ErrorMsg="";
			var ChongzhiAmount=document.getElementById("ChongzhiAmount").value;
			var ChongzhiMode=document.getElementById("ChongzhiMode").value;
			var USERID=document.getElementById("USERID").value; 
		
			if(ChongzhiAmount==""){ErrorCount++;ErrorMsg+="请输入充值金额\n";document.getElementById("ChongzhiAmount").style.borderColor="#fb6f6f";}
			if(ChongzhiMode==0){ErrorCount++;ErrorMsg+="请选择支付方式\n";document.getElementById("ChongzhiMode").style.borderColor="#fb6f6f";}
			if(ErrorCount==0){
				var data=Ajax2({kh:PayKehuId,COMPANY:cp,je:ChongzhiAmount,USERID:USERID,zf:ChongzhiMode,tips:"",atype:"hycz"});
				if(data.indexOf("成功")!=-1){
					document.getElementById("JieSuanMsgBox").style.display="none";
					document.getElementsByClassName("modal-backdrop fade in")[0].style.display="none";
					BillPay(PayBillID,PayKehuId,PayMode,e)
				}else{
					alert(data);
				}
			}else{
				alert("错误:\n"+ErrorMsg);
			}
			//alert(ChongzhiAmount+ChongzhiMode)
			
		break;
		default:
			PayMsg=Ajax("ajax.php","post",{"bid":PayBillID,"kh":PayKehuId,"jsfs":PayMode,"atype":"bill-js2",C:cp},true);
			if(PayMsg.indexOf("成功")!=-1){
				document.getElementById("JieSuanMsgBox").style.display="none";
				document.getElementsByClassName("modal-backdrop fade in")[0].style.display="none";
				khcx(SouSuo.value,1);
				alert("结算成功");
				PrintXP(bid);
			}
		break;
		}
}

/*快捷消费-结算*/
function KJJieSuan(bid,kh,PayMode,e){
	printr("订单ID:"+bid+" 客户ID:"+kh);
	BillPay(bid,kh,1,e);
}
/*快捷消费-消费初始化*/
function QuXiaoXiaoFei(){
	/*var ItemCount=document.getElementsByName("xfje").length
	while((ItemCount=document.getElementsByName("xfje").length)>1){
		$('#addxfa tr:eq('+(ItemCount-1)+')').remove();
	}*/
	document.getElementById("itemr").innerHTML="<tr><th>序号</th><th>工时</th><th>项目名称</th><th>备注</th><th>金额</th><th>操作</th></tr><td colspan='6'><a href='#AddNewItem' class='btn btn-info btn-sm' data-toggle='modal' >添加项目</a></td></tr>"
	document.getElementById("shops").innerHTML="<tr><th>序号</th><th>数量</th><th>商品名称</th><th>单价</th><th>金额</th><th>操作</th></tr><tr><td colspan='6'><a class='btn btn-warning btn-sm' data-toggle='modal' href='#chosesp' onclick='SearchShop('',1)'>添加零件</a></tr>"
	
	zje.innerHTML="总计0元";
	MoneyAll=0;
	zje()
	$('#addxfa').hide();
	//alert(ItemCount)
}




/*快捷消费添加项目时的焦点获取跟文本框清空事件*/
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





/*快捷添加-车辆*/
function QaddCar(obj){
	if(obj.value==-1){
		Addcar(obj)
	}
}
function Addcar(obj){
	var carid="";
	while((carid=prompt(MsgBorder("请输入车牌号","必填")+"\n",carid))!=null&&carid.length!=7){
		alert(MsgBorder("车牌号格式入错误!"))
	}	
	if(carid!=null&&(tipsc1=prompt(MsgBorder("请填写备注信息")+"\n","快捷添加"))!=null){
		var kh=document.getElementById("khid").value
		var pp=car1=bdate="/"
		$.post("ajax.php",{kh:kh,cp:cp,pp:pp,bdate:bdate,carid:carid,tips:tipsc1,car:car1,atype:"addcar"},function(data,aaa){
			//alert(carid=cut(data,"[newid]","[/newid]"))
			
			//alert(data);
			if(data.indexOf("成功")!=-1){
				alert("成功添加车辆"+carid)
			}else{
				alert(cut(data,"[acarerror]","[/acarerror]"))
			}
			
			$.post("ajax.php",{kh:kh,atype:"GetCarList"},function(data,aaa){
				CarList.innerHTML=data;
			})	
		})
	}
}
/*保存新建商品*/
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
			$.post("ajax.php",{
								sdw:"",
								sname:sname, 
								skc:skc,
								sdj:sdj,
								scb:scb,
								spp:spp,
								guige:guige,
								etime:etime,
								akc:akc,
								scar:scar,
								cp:cp,
								xinghao:xinghao,
								gys:gys,
								gysphone:gysphone,
								atype:"addshop",
								USERID:U
							  },function(data,aaa){
				if(data.indexOf("成功")!=-1){ 
					alert("添加成功")
					document.getElementById("closeCreateShopButton").click();
					SearchShop(sname,1);
				}else{
					alert(data)
				}
			})
			//alert("提交成功")
		}else{ 
			alert("请完善信息商品信息");
		}
}
function AddItem(){
	 iname=$("#itemname").val();//项目名称
	 itype=$("#b_type2").val();//项目类型
	 itips=$("#itips").val();//项目备注
	 cp=$("#cp").val();//公司id获取	
	 if(iname!=""){
		$.post("ajax.php",{iid:0,tips:itips,iname:iname,itype:0,imoney:0,ierror:0,cp:cp,atype:"additem"},function(data,aaa){
		  var itemid=cut(data,"[newid]","[/newid]")
		  AddItemRow(iname,itemid)
		})
	}else{
		alert("请填写项目名称");
	}
}

/*进入管理模式*/
function AdminMode(mode){
	edits=document.getElementsByName("edit")
	if(mode.value=="管理模式"){
		if((pwd=prompt("请输入管理密码"))=="123456"){
		AdminBtn.colSpan=2;
		for(i=0;i<edits.length;i++){edits[i].style.display="block"}
		mode.value="退出管理"
		mode.className='btn btn-success form-control'
		}else if(pwd!=null){
			alert("密码错误")
		}
	}else{
		AdminBtn.colSpan=1;
		for(i=0;i<edits.length;i++){edits[i].style.display="none"}		
		mode.value="管理模式"	
		mode.className='btn btn-danger form-control'
	}
}
/*商品查找函数*/
function SearchShop(val,page){
	cp=document.getElementById("cp").value
	//var bid=document.getElementById("bid").value
	$.post("ajax.php",{bid:0,val:val,cp:cp,page:page,atype:"SearchShop3"},function(data,aaa){
		ShopTab.innerHTML=cut(data,"[ashop]","[/ashop]")
	}) 
}


function ajaxtest(){
	$.post("ajax.php",{val:"xiaoyao",atype:"testajax"},function(data,aaa){
		alert(cut(data,"[fh]","[/fh]"))
		
	}) 
}

/*测试函数*/
function test(){
	alert(MsgBorder("功能测试中、敬请期待。"))
}

/*消息边框*/
function MsgBorder(str){
	var line1="╔"+string(str.length*1.5,"═")+"╗\n";
	var line2="║"+str+"║\n";
	var line3="╚"+string(str.length*1.5,"═")+"╝";
	return line1+line2+line3;
	
}
/*隐藏对象*/
function hide(obj){
	row = obj.parentNode.parentNode//A标签所在行
	var tb = row.parentNode; //当前表格
    var rowIndex = row.rowIndex; //A标签所在行下标
	//$(obj).toggle(1000)
	tb.deleteRow(rowIndex); //删除当前行
	 
}
/*删除订单*/
function DeleteBill(id){
	if(yesno("警告:该操作无法撤销,是否确认删除该订单")){
		var BINFO=SELECT("bill","*","id="+id);
		BINFO=BINFO[0];
		printr(BINFO); 
		var DINFO=DELETE("bill","id="+id,true);
		if(DINFO.state){
			KEHU=BINFO["kehu"];
			LOG2(U,"delbill",[BINFO["bid"],BINFO["id"],["kehu","name","id",KEHU],BINFO["money"]]);
		}
	}
}

/*生成N个指定字符函数*/
function string(n,str){var b="";for(i=0;i<n;i++){b+=str;};return b;}




