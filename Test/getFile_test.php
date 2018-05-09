<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/8
 * Time: 下午10:08
 */
require '../Coder/runData.php';
$test = new runData();
$arr = $test->getFile('empty.txt');
var_dump($arr);
echo sizeof($arr);
if($arr = null)
{
    echo 'right';
}