<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/7
 * Time: 下午2:49
 * 展示页
 */
require 'DB.php';

class DataShow{
    private $db;

    function __construct()
    {
        $this->db = new DB();
    }

    public function dealData($key){
        $xData = $this->db->selectByKey($key);
    }

    //简单冒泡排序
    public function sort($arr){
        for($i=0;$i<count($arr);$i++)
        {
            for($j=$i;$j<count($arr);$j++)
            {
                if($arr[$i]>$arr[$j])
                {
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }

        return $arr;
    }

    //将排序好的数组放入   输出键值对   范围=>数量
    public function getKeyArr($arr){
        $rs = array();
        $len = count($arr);
        if($arr[$len-1] > ($arr[0]+5))
        {
            $spaceLen = ($arr[$len-1] - $arr[0])/5;
            $xArr = array();
            $start = $arr[0];
            for($i = 0;$i <5;$i++){
                $temp = $start;
                $start = $start + $spaceLen;
                $xArr[] = $start;
                $rs["$temp ~ $start"] = 0;
            }

            $count = 0;
            while($count < $len){
                switch($arr[$count]){
                    //根据值判断
                }
            }
        }
        return $rs;
    }
}

$arr=[1,2,3,4,5,6,7,8,9,10];
$test = new DataShow();
var_dump($test->getKeyArr($arr));