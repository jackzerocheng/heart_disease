<?php
//echo 'download starting';

//   file_get_contents  太慢了！
//$url='http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/new.data';
//$html = file_get_contents($url);
//echo $html;

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

$url = 'http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/processed.cleveland.data';
$content = getContent($url);
echo $content;
produceFile($content);
?>