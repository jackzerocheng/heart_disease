<?php
//生成图片
$key = $_GET['key'];
$type = $_GET['type'];
require '../Coder/pageShow.php';
$img1 = new DataShow();
$img1->main($key,$type);
?>