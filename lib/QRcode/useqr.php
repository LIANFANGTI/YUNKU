<?php

    					include "../QRcode/qrlib.php"; 
				function qrpng($data){
						$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
						$PNG_WEB_DIR = 'temp/';
						if (!file_exists($PNG_TEMP_DIR))
        					mkdir($PNG_TEMP_DIR);
						$filename = $PNG_TEMP_DIR.'test.png';
						$errorCorrectionLevel = 'L'; //容错率 L M Q H
    					if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        					$errorCorrectionLevel = $_REQUEST['level'];    
						$matrixPointSize = 10;    //尺寸 1-10
    					if (isset($_REQUEST['size']))
        					$matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
						if (isset($_REQUEST['data'])) { 
    					if (trim($_REQUEST['data']) == '')
            				die('data cannot be empty! <a href="?">back</a>');
            			$filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        				QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
  					  } else {    
  		     		 QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);     
    } 
  			  echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; 
				}

 ?>