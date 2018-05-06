<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/6
 * Time: 下午6:40
 */
$a = '5.00';
$b = '?';
$c = '111';
echo '$a is number ? -'.is_numeric($a).'-<br>';
echo '$b is number ? -'. is_numeric($b).'-<br>';
echo '$c is number > -'. is_numeric($c).'-<br>';
if(!is_numeric($b))
    echo 'right';