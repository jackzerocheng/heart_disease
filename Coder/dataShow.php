<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/8
 * Time: 下午10:25
 * view前来调用
 * 惨不忍睹的代码
 */
error_reporting(E_ALL || ~E_NOTICE);
require 'DB.php';
$type = $_GET['type'];
if(empty($type))
{
    echo  '出错了，好像被外星人干扰了～～';
    die;
}

?>

<html>
<head>
    <title>

        <?php
        //  1:折线图  2：柱形图  3：饼图
        switch ($type){
            case 1:echo '折线图';break;
            case 2:echo '柱形图';break;
            case 3:echo '饼图';break;
            default:
                break;
        }
        ?>

    </title>
</head>
<body>
<div style="width: 500px;height: 500px;margin-left: 0px;">

<?php

$keys = ['age','sex','cp','trestbps','chol','fbs','restecg',
    'thalach','exang','oldpeak','slop','ca','thal','status'];

$strvalue = ['年龄','性别','胸部疼痛类型','血压','胆固醇','空腹血糖','心电图结果',
    '最大心跳数','运动时是否心绞痛','运动相对于休息的STdepression','心电图ST segment的倾斜度','透视检查看到的血管数','缺陷种类','患病情况'];

$db = new DB();
$train_max = array();
$train_min = array();
$test_max = array();
$test_min = array();

echo '<table style="text-align: center">';
echo "<tr><td colspan='3'><a href='javascript:window.history.go(-1);'>返回上一页</a></td></tr>";
echo "<tr><td colspan='3'>特征值下患病数据与正常数据的分析</td></tr>";
echo "<tr>";
echo "<td>特征值</td><td>患病数据</td><td>正常数据</td>";
echo "</tr>";
//  1:折线图  2：柱形图  3：饼图
for($i = 0;$i < count($keys);$i++)
{
    //   写入特征值的最大值和最小值
    $train_max[] = $db->getMax($keys[$i]);
    $train_min[] = $db->getMin($keys[$i]);
    $test_max[] = $db->getTestMax($keys[$i]);
    $test_min[] = $db->getTestMin($keys[$i]);

    if($db->getMax($keys[$i]) <= $db->getMin($keys[$i]))
    {
        echo $keys[$i].'最大值最小值出错了-----------<br>';
    }

    echo "<tr><td>$keys[$i] - $strvalue[$i]</td>";
    echo "<td><img src='image.php?key=$keys[$i]&type=$type' ></td>";
    echo "<td><img src='imageNormal.php?key=$keys[$i]&type=$type' ></td>";
    echo "</tr>";
}
echo '</table>';

///
///     记录最大最小值，为逻辑回归算法提供数据
///
$maxTrainName = '../Data/key_train_max.txt';
$minTrainName = '../Data/key_train_min.txt';

$maxTestName = '../Data/key_test_max.txt';
$minTestName = '../Data/key_test_min.txt';

echo "训练数据最大最小值\n";
var_dump($train_max);
var_dump($train_min);
echo "测试数据最大最小值\n";
var_dump($test_max);
var_dump($test_min);

writeFile($maxTrainName,implode(',',$train_max));
writeFile($minTrainName,implode(',',$train_min));

writeFile($maxTestName,implode(',',$test_max));
writeFile($minTestName,implode(',',$test_min));

function writeFile($fileName,$message)
{
    if(file_exists($fileName))
    {
        unlink($fileName);
    }

    $file = fopen($fileName,'w') or die('cannot write file');

    fwrite($file,$message);

    fclose($file);
}
?>

</div>
</body>
</html>
