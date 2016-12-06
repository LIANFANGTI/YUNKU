
<html>
<head>
	<title>PHP文件上传测试</title>
</head>
<form id='formid' style='display:none;' action="uploadFileTest.php" method="post" enctype="multipart/form-data" >
	<input name='atype' value="UPLOADFILE"/><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    选择图片: <input type="file" name="testFile" value="" id='selectFile' onChange="cg(this)"><br>
</form>  
<img src='' width=100 height=100 id='testImg' />
   
    <input type="button" value="upload" onclick="su()" /><br>
	
	<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
	<script src="http://www.zduber.com/zdcar2/js/js.js"></script>
	<script>
	 function su(){
		 selectFile.click();
		 
	 }
	 function cg(e){
		  
		//a=$('#formid').serialize();
	   // testFileValue=testFile.value;
		//alert(e.value);
		//Ajax2($('#formid').serialize())
		formid.
		testImg.src=e.value
	 }
		
	
	</script>
  

</html>