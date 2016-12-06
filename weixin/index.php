<title>微信开发测试</title>
<?php

	require '/lib/index.class.php';
	$index=new index();
	echo $index->checkSignature();
	/*$index=new index();
	$index->index();*/
?>
