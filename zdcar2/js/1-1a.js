
zje1=0;
//�����ύ
var lft={abc:1,bcd:"aaa"}
function sb(){
	var items=document.getElementsByName("itemgs");
	var bkh=document.getElementById("khid").value;
    var bty=document.getElementById("b_type").value;
	var cp=$("#cp").val();
	var carid=$("#carid").val();
	var bps="";
	
	//alert(bkh+":"+bty+":"+cp+":"+carid)
	if(items.length>0&&bkh!=""&& bty!=0 ){
		$.post("ajax.php",{zje:zje1,bkh:bkh,ber:bty,bps:bps,company:cp,carid:carid,atype:"abill"},function(data,aaa){
			bbid=data.substring(data.indexOf("idΪ")+4,data.length-16);
			var iids=document.getElementsByName("itemid");
			var ItemTips=document.getElementsByName("ItemTips");
			//alert(iids.length)
			for(i=0;i<iids.length;i++){	
			   iid=iids[i].className;
			  $.post("ajax.php",{bid:bbid,i:i,cs:iids.length,iid:iid,gs:items[i].value,yh:0,stime:0,etime:0,gr:"Ա��1",tips:ItemTips[i],atype:"aitem"},function(data,aaa){
				   //alert(data)
			  }); 			
				//var Billbm=cut(data,"[bm]","[/bm]");
				//if(data.indexOf("��ӽ�����ת")!=-1){alert("�����½��ɹ�");location.replace("1-2.php")}
			}
				document.getElementById("billbm").value=cut(data,"[bm]","[/bm]");
				alert("����:["+cut(data,"[bm]","[/bm]")+"]���ɳɹ�");
				doPrint();
			   location.href="index.php";
			  // doPrint()
		})
	}else{
		alert("�����ƶ�����Ϣ");
	}
}
function QaddCar(obj){
	
	if(obj.value==-1){
		//MSGBOX("��ӳ���");
	Addcar(obj);
	}else{
		caridValue=obj.value;
		document.getElementById("date_bx").value=SELECT_B("car2","date_bx","carid="+caridValue,true);//��ȡ�ñ��յ����� 
		document.getElementById("date_nj").value=SELECT_B("car2","date_nj","carid="+caridValue);//��ȡ����쵽���� 
		document.getElementById("date_xsz").value=SELECT_B("car2","date_xsz","carid="+caridValue,true);//��ȡ��ʻ֤������ 
		document.getElementById("near_km").value=SELECT_B("car2","km","carid="+caridValue,true)?SELECT_B("car2","km","carid="+caridValue,true)+"����":0+"����";//��ȡ��ʻ֤������ 
		
		
	}
}

function Addcar(obj){
	var carida="";
	while((carida=prompt(MsgBorder("�����복�ƺ�","����")+"\n",carida))!=null&&carida.length!=7){
		alert(MsgBorder("���ƺŸ�ʽ�����!"));
	}	
	if(carida!=null){
		var kh=document.getElementById("khid").value;
		var pp=car1=bdate="/";
		R=INSERT("car2",{kh:kh,carid:carida,tips:"������"},true);
		if(R.state){
			UPDATE("kehu","carid",carida,"id="+kh)
			carid.innerHTML=Ajax2({kh:kh,atype:"GetCarList"});
		}
		/*
		$.post("ajax.php",{kh:kh,cp:cp,pp:pp,bdate:bdate,carid:carida,tips:tipsc1,car:car1,atype:"addcar"},function(data,aaa){
			//alert(carid=cut(data,"[newid]","[/newid]"))
			
			//alert(data);
			if(data.indexOf("�ɹ�")!=-1){
				alert("�ɹ���ӳ���"+carid);
			}else{
				alert(cut(data,"[acarerror]","[/acarerror]"));
			}
			
			$.post("ajax.php",{kh:kh,atype:"GetCarList"},function(data,aaa){
				carid.innerHTML=data;
			})	
		})*/
	}
}
function SaveBill(){
	var USERID=document.getElementById("USERID").value;
	//alert(USERID) 
	var BillKehuID=document.getElementById("khid").value;
	var BillType=document.getElementById("b_type").value;
	var ItemMoney=document.getElementsByName("ItemMoney");
	var ItemId=document.getElementsByName("itemid");
	var ItemTips=document.getElementsByName("ItemTips");
	var CompanyID=$("#cp").val();
	var BillCarid=$("#carid").val();
	var carNewKm=$("#new_km").val();
	var TotalMoney=zje1;
	var ErrorCount=0,ErrorMsg="";
	if(BillType==0){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ�񶩵�����\n";};
	if(BillKehuID==0){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ��ͻ�\n";}
	if(!BillCarid||BillCarid==-1){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ��ά�޳���\n";}
	if(!(ItemMoney.length)){
		ErrorCount++;ErrorMsg+=ErrorCount+"���������Ŀ\n";
	}else{
		for(i=0;i<ItemMoney.length;i++){
			if(ItemMoney[i].value==""){
				ErrorCount++;ErrorMsg+=ErrorCount+"������д��Ŀ"+(i+1)+"�Ĺ�ʱ��\n";
			}
		}
	}
	if(ErrorCount>0){
		Msgtext="����:��������ʧ�� ��������"+ErrorCount+"������\n";
		alert(Msgtext+ErrorMsg);
	}else{
		var BillInfo={"TotalMoney":TotalMoney,"BillKehuID":BillKehuID,"BillType":BillType,"CompanyID":CompanyID,USERID:USERID,"BillCarid":BillCarid,atype:"AddBill"}
		var SaveBillMsg=Ajax("ajax.php","post",BillInfo,false);
		//alert(SaveBillMsg);
		if(SaveBillMsg.indexOf("�ɹ�")!=-1){
			var BillID=cut(SaveBillMsg,"[billid]","[/billid]");
			var BillBm=cut(SaveBillMsg,"[bm]","[/bm]");
			document.getElementById("billbm").value=BillBm;
			var AitemErrorCount=0,AitemErrorMSg="";
			for(i=0;i<ItemMoney.length;i++){
				//alert(ItemId[i].className)
				var AitemInfo={"ItemMoney":ItemMoney[i].value,"ItemTips":ItemTips[i].value,"ItemID":ItemId[i].className,"BillID":BillID,"atype":"AddItem"};
				var SaveAitemMsg=Ajax("ajax.php","post",AitemInfo,false);
				if(SaveAitemMsg.indexOf("�ɹ�")==-1){
					AitemErrorCount++;AitemErrorMSg+="��Ŀ"+(i+1)+"�������\n";
				}
			}
			if(!AitemErrorCount){
				alert("����["+BillBm+"]���ɳɹ�!");
				doPrint();
			    location.href="shouyin.php";
			}
			
		}else{
			alert("�������ɳ��� ������Ϣ:\n"+SaveBillMsg);
		}
	}
}

function SaveBill2(){
	var USERID=document.getElementById("USERID").value;
	//alert(USERID) 
	var BillKehuID=document.getElementById("khid").value;
	var BillType=document.getElementById("b_type").value;
	var ItemMoney=document.getElementsByName("ItemMoney");
	var ItemId=document.getElementsByName("itemid");
	var ItemTips=document.getElementsByName("ItemTips");
	var CompanyID=$("#cp").val();
	var BillCarid=$("#carid").val();
	var carNewKm=$("#new_km").val();
	UPDATE("car2","km",carNewKm,"carid='"+BillCarid+"'",true);
	var TotalMoney=zje1;
	var ErrorCount=0,ErrorMsg="";
	if(BillType==0){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ�񶩵�����\n";};
	if(BillKehuID==0){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ��ͻ�\n";}
	if(!BillCarid||BillCarid==-1){ErrorCount++;ErrorMsg+=ErrorCount+"����ѡ��ά�޳���\n";}
	if(!(ItemMoney.length)){
		ErrorCount++;ErrorMsg+=ErrorCount+"���������Ŀ\n";
	}else{
		for(i=0;i<ItemMoney.length;i++){
			if(ItemMoney[i].value==""){
				ErrorCount++;ErrorMsg+=ErrorCount+"������д��Ŀ"+(i+1)+"�Ĺ�ʱ��\n";
			}
		}
	}
	if(ErrorCount>0){
		Msgtext="����:��������ʧ�� ��������"+ErrorCount+"������\n";
		alert(Msgtext+ErrorMsg);
	}else{
		var SaveBillMsg=INSERT("bill",{zje:TotalMoney,U:USERID,money:TotalMoney,kehu:BillKehuID,btype:BillType,carid:BillCarid,carkm:carNewKm,date:DATE(),company:CompanyID},true);
		if(SaveBillMsg.state){
			BillID=SaveBillMsg.newid;
			UPDATE("bill","bid","KD"+DATE(2)+BillID,"id="+BillID);
			//UPDATE("bill","bid",);
			BillBm=SELECT_B("bill","bid","id="+BillID,true);
			document.getElementById("billbm").value=BillBm;
			
		
			var AitemErrorCount=0,AitemErrorMSg="";
			for(i=0;i<ItemMoney.length;i++){
				var R=INSERT("aitem",{iid:ItemId[i].className,bid:BillID,gs:ItemMoney[i].value,tips:ItemTips[i].value},true);
			    if(!R.state){
					AitemErrorCount++;
					AitemErrorMSg+="��Ŀ"+(i+1)+"����ʱ����������Ϣ:"+R.info+"\n";
				}
				
			}
			if(!AitemErrorCount){
				alert("����["+BillBm+"]���ɳɹ�!");
				doPrint();
			    to("shouyin.php");
			}
			
		}else{
			alert("�������ɳ��� ������Ϣ:\n"+SaveBillMsg.info);
		}
	}
}

function updateCarInfo(e){
	var carId=document.getElementById("carid").value;
	var COL=e.id;
	var VAL=e.value;
	if(carId!=0){
		UPDATE("car2",COL,VAL,"carid='"+carId+"'",true);
		
	}
	
	//UPDATE(TABLE,COL,VAL,CONDITION);
		
}

function zje(){
	var items=document.getElementsByName("ItemMoney");
	var a=0;
	for(i=0;i<items.length;i++){ 
		if(items[i].value==''){b=0;}else{b=parseInt(items[i].value);}
		a+=b;
	}
	zje1=a;
	rmbs.innerHTML="�ܼ�"+a+"Ԫ";
	
}
function doPrint(){
	main.style.display="none";
	printBody.style.display="block";
	CompanyName.innerHTML=CpName.value;
	Sdate.innerHTML="<b>����ʱ��:</b>"+billTime.value;
	KhName.innerHTML="<b>�ͻ�����:</b>"+document.getElementById("khname").value;
	Carid.innerHTML="<b>����:</b>"+carid.value;
	phone.innerHTML="<b>�ͻ��绰:</b>"+khtel.value;
	DingDanBM.innerHTML="NO."+billbm.value;
	var BillItemList=document.getElementById("BillItemList");
	var ItemId=document.getElementsByName("itemid");
	var ItemTips=document.getElementsByName("ItemTips");
	var ItemMoney=document.getElementsByName("ItemMoney");
	var ItemName=document.getElementsByName("ItemName");
	BillItemList.innerHTML="";
	for(i=0;i<ItemMoney.length;i++){
		BillItemList.innerHTML+="<tr><td colspan='2' class='text-center'>"+ItemName[i].innerHTML+"</td><td colspan='2' class='text-center'>"+ItemMoney[i].value+"Ԫ</td><td colspan='2'>&nbsp;</td><td colspan='2'>"+ItemTips[i].value+"</td></tr>";
	}
	for(i=0;i<16-ItemMoney.length;i++){
		BillItemList.innerHTML+='<tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr>';
	}
	window.print();	
}
function closePrint() {
        main.style.display="block";
		printBody.style.display="none";
}
function ChoseItem(index){
	var ItemId=document.getElementsByName("ItemId").item(index).value;
	var ItemBm=document.getElementsByName("ItemBm").item(index).innerHTML;
	var ItemName=document.getElementsByName("ItemName").item(index).innerHTML;
	var ItemType=document.getElementsByName("ItemType").item(index).innerHTML;
	var a=document.getElementsByName("ItemAdd").length;
	//b=$('#itemtb tr:eq(1) td:nth-child(1)').html();
	if($('#itemtb tr:eq(1) td:nth-child(1)').html()=="������Ŀ�����"){$('#itemtb tr:eq('+(1)+')').remove();}
	var ItemTab="<td>"+(a+1)+"</td>"+
				"<td name='itemid' class="+ItemId+">"+ItemBm+"</td>"+
				"<td>"+ItemName+"</td>"+
				"<td width=100><input type='text' class='input_td' name='itemgs' onchange='zje()'></td>"+
				"<td width=100><input type='date' class='input_td' name=''></td>"+
				"<td width=100><input type='date' class='input_td' ></td>"+
				"<td>Ա��1</td>"+
				"<td>"+ItemType+"</td>"+
				"<td width=100><input type='text' class='input_td' ></td>"+
				"<td><button name='DelItemButton'class='btn btn-danger btn-xs' onclick=\"DelItem(this)\" >ɾ��</button></td>";
	$("<tr name='ItemAdd'>"+ItemTab+"</tr>").insertAfter($('#itemtb tr:eq('+(a)+')')); 

}

function ChoseItem2(ItemId1,ItemBm1,ItemName1,ItemType1){
	var ItemId=ItemId1;
	var ItemBm=ItemBm1;
	var ItemName=ItemName1;
	var ItemType=ItemType1;
	var a=document.getElementsByName("ItemAdd").length;
	//b=$('#itemtb tr:eq(1) td:nth-child(1)').html();
	if($('#itemtb tr:eq(1) td:nth-child(1)').html()=="������Ŀ�����"){$('#itemtb tr:eq('+(1)+')').remove();}
	var ItemTab="<td>"+(a+1)+"</td>"+
				"<td name='ItemName'>"+ItemName+"</td>"+
				"<td width=100><input type='text' class='input_td' name='ItemMoney' onchange='isNum(this);zje();'></td>"+
				"<td width=100><input type='text' class='input_td' name='ItemTips' ></td>"+
				"<td><button name='DelItemButton'class='btn btn-danger btn-xs' onclick=\"DelItem(this)\" >ɾ��</button></td>";
	$("<tr name='ItemAdd'>"+ItemTab+"</tr>").insertAfter($('#itemtb tr:eq('+(a)+')')); 

}
function DelItem(obj){
	row = obj.parentNode.parentNode;//A��ǩ������
	var tb = row.parentNode; //��ǰ���
    var rowIndex = row.rowIndex; //A��ǩ�������±�
	tb.deleteRow(rowIndex); //ɾ����ǰ��
	zje();
	
	//alert(document.getElementsByName("DelItemButton"));
	//alert(rowIndex)
	//$('#itemtb tr:eq('+(index+1)+')').remove();
}
function BtypeChange(obj){
	company=document.getElementById("cp").value;
	Btype=obj.value;
	$.post("ajax.php",{cp:company,Btype:Btype,atype:"ReloadItemList"},function(data,aaa){
	    document.getElementById("itemstb").innerHTML=data;
	 }); 
}

function AddItem(){
	 iname=$("#itemname").val();//��Ŀ����
	 itype=$("#b_type2").val();//��Ŀ����
	 ierror=$("#error").val();//��Ŀ����
	 itips=$("#tips").val();//��Ŀ��ע
	 cp=$("#cp").val();//��˾id��ȡ	
	 if(iname!=""){
		$.post("ajax.php",{iid:0,tips:itips,iname:iname,itype:itype,imoney:0,ierror:ierror,cp:cp,atype:"additem"},function(data,aaa){
		  //alert(data)
		  ItemID=cut(data,"[newid]","[/newid]");
		  ItemName=cut(data,"[iname]","[/iname]");
		  ItemType=cut(data,"[itype]","[/itype]");
		  ItemBM=cut(data,"[ibm]","[/ibm]");
		  ChoseItem2(ItemID,ItemBM,ItemName,ItemType);
		  ItemLength=document.getElementsByName("items").length;
			//alert("����ǰ"+ItemLength)
		 /* $.post("ajax.php",{cp:cp,atype:"reloaditem"},function(data,aaa){
			  itemstb.innerHTML=data
			  ItemLength=document.getElementsByName("items").length
			  //alert("���º�"+ItemLength)
			  ChoseItem(ItemLength-1);
		  });*/
		  /*
          alert(ReloadItem())
		  ItemLength=document.getElementsByName("items").length
		   alert("���º�"+ItemLength)
		 ItemLength=document.getElementsByName("items").length
		 alert("���һ����Ŀ"+ItemLength)
		  ChoseItem(ItemLength-1);*/
		  // $.post("ajax.php",{iid:iid,iname:iname,itype:itype,imoney:imoney,ierror:ierror,cp:cp,atype:"additem"};
		  // $.post("ajax.php",{cp:cp,atype:"reloaditem"};
		})
	}else{
		alert("����д��Ŀ����");
	}
}
returndata="";
function ReloadItem(){
		alert("���¼�����Ŀ�б�")
		 $.post("ajax.php",{cp:cp,atype:"reloaditem"},function(data,aaa){
			 return returndata=data;
			  itemstb.innerHTML=data;
		  });
		  return returndata;
}

function GetkehuList(val,page){
	var cp=document.getElementById("cp").value;
	$.post("ajax.php",{cp:cp,page:page,val:val,atype:"KehuList"},function(data,aaa){
			document.getElementById("KehuList").innerHTML=cut(data,"[kehulist]","[/kehulist]");
	  });
}

function ChoseKehu(RowIndex,khid){
	KehuName=SELECT_B("kehu","name","id="+khid); //��ȡ�û���
	KehuPhone=SELECT_B("kehu","phone","id="+khid);//��ȡ�û��绰
	jszEdate=SELECT_B("kehu","jsz","id="+khid);//��ȡ��ʻ֤
	document.getElementById("khname").value=KehuName;   //��ֵ�û���
	document.getElementById("khtel").value=KehuPhone;   //��ֵ�û��绰
	document.getElementById("khid").value=khid;   	    //��ֵ�ͻ�ID
	carid.innerHTML=Ajax2({khid:khid,atype:"CarList"});
	caridValue=carid.value;
	document.getElementById("date_bx").value=SELECT_B("car2","date_bx","carid="+caridValue,true);//��ȡ�ñ��յ����� 
	document.getElementById("date_nj").value=SELECT_B("car2","date_nj","carid="+caridValue);//��ȡ����쵽���� 
	document.getElementById("date_xsz").value=SELECT_B("car2","date_xsz","carid="+caridValue,true);//��ȡ��ʻ֤������ 
	document.getElementById("near_km").value=SELECT_B("car2","km","carid="+caridValue,true)+"ǧ��";//��ȡ��ʻ֤������ 
    zhezhao=document.getElementsByClassName("modal-backdrop fade in");
	for(i=0;i<zhezhao.length;i++){
		zhezhao[i].style.display="none";
	}
	
}

function SaveKehu(){
	var KehuName=$("#KehuName").val();
	var KehuPhone=$("#KehuPhone").val();
	var KehuCarid=$("#KehuCarid").val();
	var KehuCarvin=$("#KehuCarvin").val();
	var KehuCarkm=$("#KehuCarkm").val();
	var KehuTips=$("#KehuTips").val();
	var CompanyID=$("#cp").val();
	var KehuInfoInput=document.getElementsByName("KehuInfoInput");
	var KehuInpuError=0;
	for(i=0;i<KehuInfoInput.length;i++){
		printr("�����ֶ�"+i+"��ֵ:"+KehuInfoInput[i].value+"\n"); 
		if(KehuInfoInput[i].value==""){
			
			KehuInfoInput[i].style.borderColor="#fb6f6f";
			KehuInpuError++;
		}
	}
	if(KehuInfoInput[0].value.length!=11){KehuInpuError++;KehuInfoInput[1].style.borderColor="#fb6f6f";}
	printr("���ֶθ���:"+KehuInfoInput.length+"�������"+KehuInpuError+"\n");
	if(KehuInpuError>0){
		alert("��Ϣ����ȷ");
	}else{ 
		var AKIF=INSERT("kehu",{carid:KehuCarid,company:CompanyID,name:KehuName,phone:KehuPhone,tips:KehuTips},true);
		printr(AKIF);
		if(AKIF.state){
			var ACIF=INSERT("car2",{kh:AKIF.newid,carid:KehuCarid,vin:KehuCarvin,km:KehuCarkm},true);
			if(ACIF.state){
				alert("�����û��ɹ�");
				document.getElementById("AddKehu").style.display="none";
				GetkehuList(KehuName,1);
			}
		}
	} 
	
	
}
function AddItemButton(){
	var ItemNameInput=document.getElementById("itemname");
	ItemNameInput.value="";
	setTimeout( function(){ItemNameInput.focus();},1000);
	
}


function AddItemKeydown(obj){
	  event = event || window.event;
	  if(event.keyCode==13){
		  if(obj.value==""){
			  obj.style.borderColor="#fb6f6f";
		  }else{
			  document.getElementById("SaveItemButton").click();
		  }
      } 
}


function Namefocus(e){
	e.style.borderColor="#ccc"; 
}
















