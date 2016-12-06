// JavaScript Document
function skh(){
		id=document.getElementById("kid").value
		name=document.getElementById("name").value
		tel=document.getElementById("tel").value
		vip=document.getElementById("vip").value
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
		pg=document.getElementById("pg").value
		//bxps=document.getElementById("bxps").value
		//carps=document.getElementById("carps").value
		
		
		
		$.post("ajax.php",{id:id,name:name,tel:tel,vip:vip,carid:carid,cart:cart,color:color,nkm:nkm,nbkm:nbkm,nbtime:nbtime,nback:nback,nbx:nbx,bxcp:bxcp,tips:tips,atype:"skh"},function(data,aaa){alert("保存成功");})
		
//alert("id="+id+")"+name+tel+vip+cart+color+nkm+nbkm+nbtime+nback+nbx+bxcp+"，备注："+tips)
}