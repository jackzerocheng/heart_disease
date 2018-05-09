<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/7
 * Time: 下午2:49
 * 展示页
 */
require 'DB.php';
require 'PrintPage.php';

class DataShow{
    private $db;
    private $xValue;   //存储x轴数值
    private $yValue;   //存储y轴数值

    function __construct()
    {
        $this->db = new DB();
        $this->xValue = array();
        $this->yValue = array();
    }

    //输出  折线图 or 柱形图 or 饼图
    public function main($key,$type){
        //从数据库中 获取 对应 某个特征值 的 数据
        $xData = $this->db->selectByKey($key);
        
        //   对数据进行预处理，排序
        $xData = $this->sort($xData);
        //   处理数据，得到X轴、Y轴数据
        $this->getKeyArr($xData);

        //初始化  画图函数
        $printpage = new PrintPage();
        $width = 500;
        $height = 300;
        switch($type){
            case 1:$printpage->printLinechart($this->yValue,$width,$height,$this->xValue);break;
            case 2:$printpage->printHistogram($this->yValue,$width,$height,$this->xValue);break;
            case 3:$printpage->printPie($this->yValue,$width,$height,$this->xValue);break;
            default:
                echo '<h5>error!</h5>';break;
        }

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

    //将排序好的数组放入   得到X轴、Y轴的数据
    public function getKeyArr($arr){
        $rs = array(); //存  X轴数据
        $tmp = array();// 存  Y轴数据
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
                $rs[] = "$temp ~ $start";
            }

            $this->xValue = $rs;    //  得到x轴数据

            $count = 0;
            $this->yValue = [0,0,0,0,0];
            //   得到Y轴数据
            while($count < $len){
                switch($arr[$count]){
                    //根据值判断
                    case $arr[$count] < $xArr[0]:$this->yValue[0]++;break;
                    case $arr[$count] < $xArr[1]:$this->yValue[1]++;break;
                    case $arr[$count] < $xArr[2]:$this->yValue[2]++;break;
                    case $arr[$count] < $xArr[3]:$this->yValue[3]++;break;
                    case $arr[$count] < $xArr[4]:$this->yValue[4]++;break;
                    default:break;
                }
                $count++;
            }
        }
        else{
            //   最大和最小相差不到5，将所有非重复值列入X轴
            $rs[0] = $arr[0];
            $tmp[0] = 1;
            $count = 0;
            for($i = 1;$i < $len;$i++){
                if($rs[$count] != $arr[$i])
                {
                    $rs[] = $arr[$i];
                    $tmp[] = 1;
                    $count++;
                }
                else{
                    $tmp[$count] += 1;
                }
            }

            $this->xValue = $rs;
            $this->yValue = $tmp;
        }

    }

    // for test
    public function getxValue(){
        return $this->xValue;
    }

    //  for test
    public function getyValue(){
        return $this->yValue;
    }

    public function demo(){
        $test = new DataShow();
        $test->main('id',1);
    }
}