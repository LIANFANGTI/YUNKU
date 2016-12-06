// JavaScript Document
function cxbill(a){
var bid=document.getElementById("bid").value
var bkh=document.getElementById("bkh").value
var sdate=""
var edate=""
var cxbill=document.getElementById("cxbill")
var cp=document.getElementById("cp").value
var myDate = new Date();
var s=new Date();
s.setFullYear(1970);
s.setMonth(01);
s.setDate(01);
if(sdate=="")sdate="1970-1-1"
if(edate=="")edate=0

$.post("ajax.php",{bid:bid,bkh:bkh,sdate:sdate,edate:edate,cp:cp,atype:"cxbill"},function(data,aaa){cxbill.innerHTML=data}) 
//alert("单号："+bid+"\n客户："+bkh+"\n开始："+sdate+"\n结束： "+edate)	
}

function dbill(id){
	$.post("ajax.php",{bid:id,atype:"dbill"},function(data,aaa){
		if(data.indexOf("成功")!=-1){
			alert("删除成功");
			location.reload()
		}else{
			alert(data)
		}
	}) 	
}