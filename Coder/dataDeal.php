
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

//   1：生成SQL  2：导入SQL  3：数据查看
$type = $_GET['type'];
echo "<a href='javascript:window.history.go(-1);'>返回上一页</a><br>";
if(empty($type))
{
    echo  '出错了，好像被外星人干扰了～～';
    die;
}

$run = new runData();
switch($type){
    case 1:
        echo 'SQL文件已经生成！Data/datainsert.sql<br>';
        $arr = $run->getFile('download.txt');
        $run->setFile('datainsert.sql',$arr);
        break;
    case 2:
        if($run->execSql('datainsert.sql'))
            echo '执行成功!';
        else
            echo '执行失败!';
        break;
    case 3:
        echo "<a href='localhost:8888/phpmyadmin'>数据管理</a><br>";
        var_dump($run->printAll());
        break;
    default:
        echo "<script>alert('请选择正确的事');</script>";
        break;
}
?>