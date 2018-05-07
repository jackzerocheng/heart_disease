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
    echo 'right<br>';


$arr = ['1'=>1];
echo $arr['1'];



//数组测试
$arr = [1,2,3,4,5,6,7,8,9,10];
$len = count($arr);
if($arr[$len-1] > ($arr[0]+5))
{
    $spaceLen = ($arr[$len-1] - $arr[0])/5;
    $xArr = array();
    for($i = 0;$i <5;$i++){
        $xArr[] = $arr[0] + $spaceLen*($i+1);
    }
}
var_dump($xArr);
