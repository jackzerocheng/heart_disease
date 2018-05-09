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

echo "<a href='javascript:window.history.go(-1);'>返回上一页</a><br>";

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
<div style="width: 500px;height: 500px;margin: auto;">

<?php

$keys = ['age','sex','cp','trestbps','chol','fbs','restecg',
    'thalach','exang','oldpeak','slop','ca','thal','status'];
echo '<table>';
//  1:折线图  2：柱形图  3：饼图
for($i = 0;$i < count($keys);$i++)
{
    echo "<tr><td>$keys[$i]</td><td>";
    echo "<img src='image.php?key=$keys[$i]&type=$type' >";
    echo "</td></tr>";
}
echo '</table>';
?>

</div>
</body>
</html>
