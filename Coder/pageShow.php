<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/7
 * Time: 下午2:49
 * 展示页
 * 对数据进行处理
 */
require 'DB.php';
require 'PrintPage.php';

class DataShow{
    private $db;
    private $xValue;   //存储x轴数值
    private $yValue;   //存储y轴数值
    private $count;    //记录数

    function __construct()
    {
        $this->db = new DB();
        $this->xValue = array();
        $this->yValue = array();
    }

    //输出  折线图 or 柱形图 or 饼图
    public function main($key,$type,$isDisease){
        //从数据库中 获取 对应 某个特征值 的 数据
        $xData = $this->db->selectByKey($key,$isDisease);

        $this->count = $this->db->getCountDisease($isDisease);
        
        //   对数据进行预处理，排序
        $xData = $this->sort($xData);

        //var_dump($xData);die;
        // 数据归一化    将值归一到0到1，其中 取两位小数
        $xData = $this->guiYi($xData);
        //   处理数据，得到X轴、Y轴数据
        $this->getKeyArr($xData);
        //var_dump($this->xValue);var_dump($this->yValue);die;

        //对y轴数据进行处理，转化成百分比
        //$this->yValue = $this->percentData($this->yValue,$this->count);

        //初始化  画图函数
        $printpage = new PrintPage();
        $width = 600;
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
    // 从小到大排序
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
    //  输入 ： 有序数组
    //   归一化数组   值范围从0到1
    public function getKeyArr($arr){
        $rs = array(); //存  X轴数据
        $tmp = array();// 存  Y轴数据
        $len = count($arr);
        if($arr[$len-1] > ($arr[0]+5))
        {
            $spaceLen = ($arr[$len-1] - $arr[0])/5;  // 最大值减最小值，分五段
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
            //   最大和最小相差不到5
            //   取最多五个x轴坐标
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

            $a = array(); //  x轴
            $b = array();//   y轴
            $c = (int)(count($rs)/5);
            if($c >1)
            {
                //   x轴数据过多，需要做处理
                for($j = 0;$j<count($rs);)
                {
                    if($j == (count($rs) - 1))
                        break;

                    $start = $j;
                    //  防止最后一位溢出
                    if(($j + $c) >= count($rs))
                    {
                        $j = count($rs) - 1;
                    }
                    else
                    {
                        $j = $j + $c;
                    }

                    $a[] = "$rs[$start] ~ $rs[$j]";
                    $sum = 0; //  y轴计数
                    for($z = $start;$z < $j;$z++)
                    {
                        $sum += $tmp[$z];
                    }
                    $b[] = $sum;
                }

                $this->xValue = $a;
                $this->yValue = $b;
            }
            else
            {
                $this->xValue = $rs;
                $this->yValue = $tmp;
            }
        }

    }

    //   处理Db数据，进行归一化
    //   输入 ： 已排序的数组
    //    result=(val-min)/(max-min)
    public function guiYi($arr)
    {
        $len = count($arr); //数组长度
        $max = $arr[$len-1];
        $min = $arr[0];

        for($i = 0;$i < $len;$i++)
        {
            if(($max-$min) > 0)
            {
                //   保留两位小数
                $arr[$i] = number_format(($arr[$i] - $min) / ($max - $min),2);
            }
        }

        return $arr;
    }

    //  将数量转化为占比
    public function percentData($arr, $count)
    {
        for($i = 0;$i < count($arr);$i++)
        {
            $arr[$i] = (int)(($arr[$i]/$count)*100);
        }
        return $arr;
    }

    public function outputLog($message)
    {
        $message = $message + '\n';
        $file = fopen('../Data/disease.log','w') or die('cannot write file');
        fwrite($file,$message);
        fclose($file);
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
        $this->main('age',1,1);
    }
}
