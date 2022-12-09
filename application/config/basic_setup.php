<?php
$weburl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$weburl .= "://".$_SERVER['HTTP_HOST'];
$weburl .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
define('WEB_URL',$weburl.'index.php/');
define('WEB_PATH',$weburl.'theme/');
define('ATTACHMENT_PATH',$weburl);
$rootPath = (isset($_SERVER['DOCUMENT_ROOT']))?$_SERVER['DOCUMENT_ROOT']:'/var/www/html/task';
define('ROOT_PATH',$rootPath.'/');
define('FILE_UPLOAD_PATH',$rootPath.'/uploads/');
define('DB_HOSTNAME','localhost');//192.168.1.29 'localhost'
define('DB_USERNAME','root');//
define('DB_PASSWORD','Abhi@12345');//password root
define('DB_DATABASE','task_pro'); //realcube_test_db oa
?>
