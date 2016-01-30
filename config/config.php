<?php
ini_set('display_errors','on');
ini_set('default_charset', 'UTF-8');
ob_start("ob_gzhandler");
header('P3P: CP="CAO PSA OUR"');
date_default_timezone_set('Asia/Calcutta');
session_cache_limiter( 'nocache' );
session_cache_limiter( 'public' );
session_start();
//define ('DB_USER',       	'adminKAdv5FJ');
//define ('DB_PASSWORD',   	'HQydkmh5wU_Y');
define ('DB_USER',       	'root');
define ('DB_PASSWORD',   	'root');
define ('DB_HOST',       	'localhost');
//define ('DB_NAME',       	'php');
define('DB_NAME','deams');
define ('ADMIN_APP_ROOT', 		$_SERVER['DOCUMENT_ROOT'].'/php/admin');
define ('ADMIN_APP_HTTP',  		'http://' . $_SERVER['SERVER_NAME']."/php/admin");
define ('ADMIN_IMAGE_PATH',		ADMIN_APP_HTTP.'/images');
define ('ADMIN_CSS_PATH',		ADMIN_APP_HTTP.'/css');
define ('ADMIN_JS_PATH',		ADMIN_APP_HTTP.'/js');
define ('ADMIN_LIB_PATH',		ADMIN_APP_ROOT.'/lib');
define ('ADMIN', 'Administrator');
/*===========CAN BE MOVED TO OUTSIDE CONFIG AND INCLUDE THAT CONFIG HERE*/
define ('APP_HTTP', 			'http://' . $_SERVER['SERVER_NAME'].'/php');
define ('APP_HTTPS',            'https://' . $_SERVER['SERVER_NAME'].'/php');
define ('APP_ROOT', 			$_SERVER['DOCUMENT_ROOT'].'/php');
define ('MAIN_APP_HTTP',        APP_HTTP);
define ('LIB_PATH',				APP_ROOT.'/lib');
define ('THUMBNAIL_PATH',		APP_ROOT.'/images/thumbnails');
define ('THUMBNAIL_HTTP_PATH',	APP_HTTP.'/images/thumbnails');
define ('IMAGE_PATH',			APP_HTTP.'/images');
define ('JS_PATH',				APP_HTTP.'/js');
define ('CSS_PATH',				APP_HTTP.'/css');
define ('UPLOADED_IMAGES',		APP_ROOT.'/images/uploads');
define ('UPLOADED_THUMBNAILS',	APP_ROOT.'/images/uploads/thumbnails');
define ('ERROR_EMAIL', 'subashchandraa@gmail.com');
define ('LOG_FILE',  APP_ROOT.'/log/amsLog.txt');
define ('ERROR_DISPLAY', '0'); //0 = no display, 1 = basic error msg , 2 = Detailed Error Message
define ('CATCH_ERROR', '4');
define ('DEBUG_ERROR', '0');
define ('ERROR_LOG_TYPE', '1'); // 1 - log error msgs, 2 = send error msg as email , 3 =both (send and log)
include LIB_PATH.'/Db.php';
$oDb = new Db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
//echo APP_HTTP;
//print_r($oDb);
//exit();
