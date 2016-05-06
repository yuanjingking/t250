<?php
header("Content-Type: text/html;charset=utf-8");


date_default_timezone_set('Asia/Shanghai');
define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */

session_set_cookie_params(24*3600); 
session_start();
//引入Zend库
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");

$app->bootstrap()->run();

?>
