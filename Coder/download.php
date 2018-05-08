<?php
//   下载文件脚本

// 获取页面内容
function getContent($url){
    $ch = curl_init();
    $timeout = 10;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);

    return $file_contents;
}

//写入文件
function produceFile($content,$fileName = 'download.txt'){
    $fileName = '../Data/' . $fileName;
    if(file_exists($fileName)){
        unlink($fileName);
    }
    $file = fopen($fileName,'w') or die('unable to write file');
    fwrite($file,$content);
    fclose($file);
}
echo "<a href='javascript:window.history.go(-1);'>返回上一页</a><br>";
$url = 'http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/processed.cleveland.data';
$content = getContent($url);

echo '下载数据内容为(文件在Data目录下)<br>'.$content;
produceFile($content);
?>