// JavaScript Document
/*商品删除*/
SearchShop("",1)
function delsp(sid){
	if(confirm("该操作无法撤销")){
	 $.post("ajax.php",{sid:sid,atype:"delsp"},function(data,aaa){location.replace("/zdcar2/3-1.php?") })
    }else{
		alert(sid)
	}
}
/*安全库存设置*/
function akc(sid){
	sakc=prompt("请输入要设置的安全库存");
	if(sakc!=null){
		//alert("+"+sakc+"+")
	 $.post("ajax.php",{sid:sid,akc:sakc,atype:"akc"},function(data,aaa){alert("设置成功");location.replace("/zdcar2/3-1.php?"); })	
	}
}
/*新建商品*/
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
					history.go(-0);
				}else{
					alert(data)
				}
			})
			//alert("提交成功")
		}else{ 
			alert("请完善信息商品信息");
		}
}
function delShop(sid){
	if(confirm("确定删除配件吗。")){
		DELETE("shop","sid="+sid);
		SearchShop("",1);
	}
}
function AddShop(sid,page){
	Num=prompt("请输入您要增加的量");
	USERID=document.getElementById("u").value; 
	COMPANY=document.getElementById("cp").value; 
	if(!isNaN(Num)){
		if(Num!=null){
			AddShopMsg=Ajax2({atype:"AddShopNumber",Num:Num,sid:sid,USERID:USERID,COMPANY:COMPANY});
			if(AddShopMsg.indexOf("成功")!=-1){
				alert("添加成功");
				SearchShop("",page);
			}else{
				alert(AddShopMsg);
			}
		}
	}
}
	 
function ShopUpload(sid,kc,page){
	Num=prompt("请输入您要上传的数量");
	USERID=document.getElementById("u").value; 
	COMPANY=document.getElementById("cp").value; 
	if(!isNaN(Num)){
		if(Num!=null){
			if(Num<=kc){
				UploadShopMsg=Ajax2({atype:"UploadShop",Num:Num,sid:sid,USERID:USERID,COMPANY:COMPANY}); 
				if(UploadShopMsg.indexOf("成功")!=-1){ 
					alert("添加成功");
					SearchShop("",page); 
				}else{
					alert(UploadShopMsg);
				}
			}else{
				alert("库存不足");
			}
	}
	}
		
}

function SearchShop(val,page){
	cp=document.getElementById("cp").value;
	$.post("ajax.php",{bid:0,val:val,cp:cp,page:page,atype:"SearchShop"},function(data,aaa){
		printr(Cut2(data,"sql"))
		ShopTab.innerHTML=cut(data,"[ashop]","[/ashop]")
	}) 
}
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
