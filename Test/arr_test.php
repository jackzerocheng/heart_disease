<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/6/2
 * Time: 上午11:18
 */

$fileName = '../Data/test_data.txt';

$file = fopen($fileName,'r') or die('unable to read file');

$rs =array();
$count = 0;
while (! feof($file)){  //按行读取
    $line = (fgets($file));
    $rs[$count][] = (explode(' ',$line));
    $count++;
}
fclose($file);
var_dump($rs);
