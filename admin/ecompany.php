<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
ini_set('display_errors','On'); 
	if(!isset($_GET["cid"]))die("参数错误");
	require_once '../lib/fun.php';
	$COMPANY=SELECT("company","*","id=".$_GET["cid"]);	
	$COMPANY_ID=$_GET["cid"];
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $COMPANY[0]["name"];?></title>
    <meta charset="utf-8" />
   
    <script src="../zdcar2/js/js.js"></script>
    <script src="js/jquery-1.10.2.js"></script>

	<!-- bt框架-->
		<link href="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
		<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>
	<!-- bt框架End-->
	<style>
		.mian1{
			width:100px;
			margin: 0;
			background: url(img/bg.jpg);
			repeat:repeat;
			color: #797979;
			repeat-y=none;
		}
		.in{
			width:200px;
		}
		.font-yahei{
			font-family: Microsoft YaHei,'宋体' , Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;
		}
	</style>
</head>

<body onbeforeunload="alert('保存成功')">



    <?php 
		
        //print_r($COMPANY);

	
	?>

<div style='margin:100px;width:80%;' class='text-center'>
  <table class="table table-bordered table-condensed table-hover table-striped">
   <tr>
		<td colspan=4>
			<h2 class='font-yahei'><img  src='<?php echo  $COMPANY[0]["logo"]; ?>' width=80 height=80 class='img-circle' onClick='UPDATE_LOGO("<?php echo $_GET["cid"]; ?>")'>
			<?php echo $COMPANY[0]["name"];?>有限公司</h2>
		</td>
   </tr>
   <tr>
		<td>公司名:</td>
		<td><input id='carid' class="form-control in"   type='text' placeholder='公司名称'   value='<?php echo $COMPANY[0]["name"]; ?>'    onchange="UPDATE_COMPANY('name',this)" /></td>
		<td>管理员:</td>
		<td>
			<select id='admin'   class="form-control in" onchange="UDATECAR('vin',this)"/>
				<?php
				   $USERS=SELECT("user","*","del and company=".$_GET["cid"]);
					foreach($USERS as $ROW){
						if($ROW["id"]==$COMPANY[0]["admin"]){$SED="selected";}else{$SED="";};
						echo "<option $SED >".$ROW["user"]."</option>";
					}
				?>
			</select>		
		</td>
	</tr>
   <tr>
		<td>APPID:</td>
		<td colspan=3><input id='pp'  class="form-control input-xs"  type='text' placeholder='微信公众号APPID'   value='<?php echo $COMPANY[0]["APPID"]; ?>'      onchange="UPDATE_WX_INFO('APPID',this)" /></td>
		
   </tr>
   <tr>
		<td>SECRET:</td>
		<td colspan=3><input id='vin'    class="form-control input-xs"    type='password'  placeholder='微信公众号SECRET'       value='<?php echo $COMPANY[0]["SECRET"]; ?>'       onchange="UPDATE_WX_INFO('SECRET',this)" onfocus="this.type='text'" onblur="this.type='password'" /></td>
   </tr>
    <tr>
		<td>接口连接:</td>
		<?php
			$API_URL="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$COMPANY[0]["APPID"]."&redirect_uri=http%3a%2f%2fwww.zduber.com%2fweixin%2flogin%2fcallback.php&response_type=code&scope=snsapi_userinfo&state=".$COMPANY[0]["id"]."#wechat_redirect";
			$SHORT_URL="http://".toShortUrl($API_URL);
			UPDATEA("company","LOGIN_API",$SHORT_URL,"id=$COMPANY_ID");
		?>
		<td ><input id='API_URL'     class="form-control input-xxs"     type='text'  value='<?php echo $SHORT_URL; ?>'       onchange="" /></td>
		<td><input type='button' class='btn btn-success btn-sm' value='复制' onclick="copy()"/></td>
		<td><img src='<?php echo  QR($SHORT_URL,'L',5); ?>' width=80 height=80 /></td>
   </tr>
  <tr class='text-center'>
	 <td colspan=4 ><input type='button' class='btn btn-success btn-xs' value='保存' onclick="ok(<?php echo $COMPANY_ID; ?>)"/></td> 
	 
  </tr>
 
  
  </table>
	
</div>
<script>
	function save(){
			/*	carid='<?php echo $carid;?>';
				//alert(carid)
				CARID=document.getElementById("carid").value,
				car=document.getElementById("car").value,
				pp=document.getElementById("pp").value,
				buydate=document.getElementById("buydate").value,
				vin=document.getElementById("vin").value,
				km=document.getElementById("km").value,
				tips=document.getElementById("tips").value,
		$.post("http://"+window.location.host+"/zdcar2/ajax.php",{carid:carid,carid2:carid2,car:car,pp:pp,buydate:buydate,vin:vin,km:km,tips:tips,atype:"ecar"},function(data,aaa){
				//alert(data);
			})*/
	}
	function copy(){
		txt=123;
		if (window.clipboardData) {  
        window.clipboardData.clearData();  
        window.clipboardData.setData("Text", txt);  
        alert("复制成功！")  
    } else if (navigator.userAgent.indexOf("Opera") != -1) {  
        window.location = txt;  
        alert("复制成功！");  
    } else if (window.netscape) {  
        try {  
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
        } catch (e) {  
            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");  
        }  
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);  
        if (!clip)  
            return;  
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);  
        if (!trans)  
            return;  
        trans.addDataFlavor('text/unicode');  
        var str = new Object();  
        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);  
        var copytext = txt;  
        str.data = copytext;  
        trans.setTransferData("text/unicode", str, copytext.length * 2);  
        var clipid = Components.interfaces.nsIClipboard;  
        if (!clip)  
            return false;  
        clip.setData(trans, null, clipid.kGlobalClipboard);  
        alert("复制成功！")  
    }else if(copy){  
        copy(txt);  
        alert("复制成功！")  
    }  
       
	}
	function UPDATE_COMPANY(COL,E){
		var VAL=E.value;
		//alert(COL)
		COMPANY_ID=<?php echo $_GET["cid"]; ?>
		
	    R=UPDATE("company",COL,VAL,"id="+COMPANY_ID);
		//prompt(1,Cut2(R,"sql"));
		
	}
	function ok(COMPANY_ID){
		alert('保存成功','','保存车辆');
		to("admin-user.php?cid="+COMPANY_ID);
	}
	function UPDATE_WX_INFO(COL,E){
		if(confirm("您修改了"+COL+"信息,是否保存修改")){
			var VAL=E.value;
			COMPANY_ID=<?php echo $_GET["cid"]; ?>;
			R=UPDATE("company",COL,VAL,"id="+COMPANY_ID);
		}
	}
function UPDATE_LOGO(id){
	var SRC=prompt("请粘贴外链src链接",""); 
	if(SRC!=""&&SRC!=null){
	  UPDATE("company","logo",SRC,"id="+id);
	  alert("更新成功");
	  Reload();
	}
}  

function setCopy(_sTxt){
try{
if(window.clipboardData) {
    window.clipboardData.setData("Text", _sTxt);
} else if(window.netscape) {
    netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
    var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
    if(!clip) return;
    var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
    if(!trans) return;
    trans.addDataFlavor('text/unicode');
    var str = new Object();
    var len = new Object();
    var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
    var copytext = _sTxt;
    str.data = copytext;
    trans.setTransferData("text/unicode", str, copytext.length*2);
    var clipid = Components.interfaces.nsIClipboard;
    if (!clip) return false;
    clip.setData(trans, null, clipid.kGlobalClipboard);
}
}catch(e){}
}
</script>
</body>
</html>