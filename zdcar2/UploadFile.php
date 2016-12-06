<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加用户</title>
</head>
<body>
    <form action="UploadFile.php" method="post"  enctype="multipart/form-data">
            <label for="file">Filename:</label>
            <input type="file" name="file" id="file" />
        <input type="submit" value="提交">
    </form>
<script>


</script>
</body>
</html>










<?php   
//$file='d:/www/image/'. $_FILES["file"]["name"];
//上面这句没必要
if ($_FILES["file"]["error"] > 0){ //如果文件错误信息大于0
    echo "错误信息: " . $_FILES["file"]["error"] . "<br />"; //chuchu 
}else{
	echo"<hr>";
	echo "上传文件信息<br>";
    echo "上传文件名: " . $_FILES["file"]["name"] . "<br />";
    echo "文件类型: " . $_FILES["file"]["type"] . "<br />";
    echo "文件大小 " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "缓存路径: " . $_FILES["file"]["tmp_name"] . "<br />";
	echo"<hr>";
	if (file_exists("upload/" . $_FILES["file"]["name"])){  
		echo "文件:".$_FILES["file"]["name"] . "已经存在，请勿重复上传";
    }else{
        //move_uploaded_file($_FILES["file"]["tmp_name"] ,$file );//这句不对
		//move_uploaded_file(目标文件,要移动到的路径);这里的目标文件是缓存路径,要移动到的路径
		//填 upload/" . $_FILES["file"]["name"]  就是 upload文件夹下的  如果想重复上传的话这里的文件名可以用时间戳
		move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"] );
        echo "上传成功:" . $file="upload/" . $_FILES["file"]["name"];
    }
}

echo "<hr><img width=100 height=100 src='$file'>";

