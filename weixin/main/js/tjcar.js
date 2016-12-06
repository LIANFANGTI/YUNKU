//Javascript document

car=""
function chose(value,pp){
	document.getElementById("dropdownMenu1").innerHTML=pp+"-"+value
	car=pp;
	//alert(value)
	
}
function save(){
	var kh_V=document.getElementById("khid").value;
	var vin_V=document.getElementById("vin").value;
	var carid_V=document.getElementById("carid").value;
	var km_V=document.getElementById("km").value;
	var date_bx_V=document.getElementById("date_bx").value;
	var date_nj_V=document.getElementById("date_nj").value;
	var tips_V=document.getElementById("tips").value;
	if(!EXIST("car2","carid",carid_V)){
		if(vin_V!=""&&km_V!=""&&date_bx_V!=""&&date_nj_V!=""){
			INFO=INSERT("car2",{kh:kh_V,carid:carid_V,km:km_V,tips:tips_V,date_bx:date_bx_V,date_nj:date_nj_V,vin:vin_V});
		}else{
			alert("信息不正确")
		}
	}else{
		alert("该车辆已存在","","添加车辆");
	}
	//
   
	/*if(carid!=""&&pp.indexOf("选择")==-1&&km!=""&&buydate!=""){
		$.post("http://www.zduber.com/zdcar2/ajax.php",{kh:kh,carid:carid,pp:car,car:pp,km:km,bdate:buydate,tips:tips,atype:"addcar"},function(data,aaa){
			if(data.indexOf("成功")!=-1){
				location.replace("car.php")	
			}
			})
		
	}else{alert("信息不正确")}*/
	//alert(carid+"\n"+pp+"\n"+km+"\n"+buydate+"\n"+tips)
}