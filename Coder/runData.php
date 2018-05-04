<?php
//读取数据文件，以二维数组存储
function getFile($fileName){
	$file = fopen($fileName,'r') or die('unable to read file');
	
	$rs =array();
	$count = 0;
	while (! feof($file)){
		$line = fgets($file);
		$rs[$count][] = explode(',',$line);
		$count++;
	}
	fclose($file);
	return $rs;
}

//写SQL文件，原有文件将被覆盖
function setFile($fileName,$arr){
	echo 'number:'.count($arr).'<br>';
	if(file_exists($fileName))
	{
		unlink($fileName);
	}
	$file = fopen($fileName,'w') or die('unable to write file');
	$count = 0;
	foreach ($arr as $key => $values){
		if($values !== null){
			$arr2 = $values[0];
			$sql = "insert into heart_disease (age,sex,cp,trestbps,chol,fbs,restecg,thalach,exang,oldpeak,slop,ca,thal,status)
			values ($arr2[0],$arr2[1],$arr2[2],$arr2[3],$arr2[4],$arr2[5],$arr2[6],
			$arr2[7],$arr2[8],$arr2[9],$arr2[10],$arr2[11],$arr2[12],$arr2[13]);\n";
			echo ++$count;
			echo $sql."<br>";
			fwrite($file,$sql);
		}
	}
	
	fclose($file);
}
echo 'start<br>';
$arr = getFile('../Data/test.data');

setFile('../Files/datainsert.sql',$arr);
echo 'finish<br>';
?>