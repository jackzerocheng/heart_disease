
<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/8
 * Time: 下午3:36
 * view前来调用，各方式实现
 */
error_reporting(E_ALL || ~E_NOTICE);
require 'runData.php';

echo "<a href='javascript:window.history.go(-1);'>返回上一页</a><br>";

$type = $_GET['type'];
if(empty($type))
{
    echo  '出错了，好像被外星人干扰了～～';
    die;
}

$run = new runData();
//   1：生成SQL  2：导入SQL  3：数据查看
switch($type){
    case 1:
        $train_arr = $run->getFile('train_data.txt', ',');
        $test_arr = $run->getFile('test_data.txt' , ',');
        if(sizeof($train_arr) > 1 && sizeof($test_arr) > 1 ){
            echo '数组大小'.sizeof($train_arr).'<br>';
            echo 'SQL文件已经生成！Data/datainsert.sql<br>';
            //$randInt = mt_rand(1,10);
            $run->setFile('datainsert.sql',$train_arr,'tbl_disease');
            $run->setFile('testdatainsert.sql',$test_arr,'tbl_disease_test');
        }
        else
        {
            echo '数据文件异常，请检查后重试～～<br>';
        }
        break;
    case 2:
        if($run->execSql('datainsert.sql'))
            echo '训练数据插入成功!';
        else
            echo '训练数据插入失败!';
        if($run->execSql('testdatainsert.sql'))
            echo '测试数据插入成功!';
        else
            echo '测试数据插入失败!';
        break;
    case 3:
        echo "<a href='http://localhost:8888/phpmyadmin/'>数据管理</a><br>";
        var_dump($run->printAll());
        break;
    default:
        echo "<script>alert('请选择正确的事');</script>";
        break;
}
?>