<?php
echo 'download starting';

$file=fopen('http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/new.data',"r");
header("Content-Type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: ".filesize('http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/new.data'));
header("Content-Disposition: attachment; filename=newdata");
echo fread($file,filesize('http://archive.ics.uci.edu/ml/machine-learning-databases/heart-disease/new.data'));
fclose($file);

?>