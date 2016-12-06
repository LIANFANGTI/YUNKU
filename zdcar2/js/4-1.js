// JavaScript Document
function akehu(){
		name=document.getElementById("name").value
		tel=document.getElementById("tel").value
		carid=document.getElementById("carid").value
		cart=document.getElementById("cart").value
		color=document.getElementById("color").value
		nkm=document.getElementById("nkm").value
		nbkm=document.getElementById("nbkm").value
		nbtime=document.getElementById("nbtime").value
		nback=document.getElementById("nback").value
		nbx=document.getElementById("nbx").value
		bxcp=document.getElementById("bxcp").value
		tips=document.getElementById("tips").value
		cp=document.getElementById("cp").value
		if(k(name)&&k(tel)&&k(carid)){
			$.post("ajax.php",{name:name,tel:tel,carid:carid,cart:cart,color:color,nkm:nkm,nbkm:nbkm,nbtime:nbtime,nback:nback,nbx:nbx,bxcp:bxcp,tips:tips,cp:cp,atype:"akh"},function(data,aaa){})
				//alert("公司:"+cp+name+tel+cart+color+nkm+nbkm+nbtime+nback+nbx+bxcp+"，备注："+tips)
					closeb("akehu")
		}else{
			//alert("请填写正确信息")	
		}	
}

function delkh(id,pg){
		if(confirm("该操作无法撤销，是否删除该操作")){
				$.post("ajax.php",{kid:id,atype:"dkh"},function(data,aaa){window.location.href="4-1.php?page="+pg;})
		}
}



function xfjla(id){
	
	var xfjl1=document.getElementById("xfjltb")
	$.post("ajax.php",{kh:id,atype:"xfjl"},function(data,aaa){
		//alert(data1)
		xfjl1.innerHTML=data
	})	
}

function tjcx(info){
	var cp=document.getElementById("cp").value
	var info=document.getElementById("tj").value
	var khinfo=document.getElementById("khinfo")
	$.post("ajax.php",{info:info,cp:cp,atype:"khinfo"},function(data,aaa){
		//alert(data)
	})
}
