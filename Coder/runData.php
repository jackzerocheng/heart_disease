<?php

class runData{


    //读取数据文件，以二维数组存储
    public function getFile($fileName){
        $fileName = '../Data/' . $fileName;
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
    public function setFile($fileName,$arr){
        $fileName = '../Files/' . $fileName;
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
                $arr2 = checkNum($arr2);   // 排除非数值类型的数据
                $sql = "insert into tbl_disease (age,sex,cp,trestbps,chol,fbs,restecg,thalach,exang,oldpeak,slop,ca,thal,status) values ($arr2[0],$arr2[1],$arr2[2],$arr2[3],$arr2[4],$arr2[5],$arr2[6],$arr2[7],$arr2[8],$arr2[9],$arr2[10],$arr2[11],$arr2[12],$arr2[13]);\n";
                echo ++$count;
                echo '    ' . $sql."<br>";
                fwrite($file,$sql);
            }
        }

        fclose($file);
    }

    // j将每一行的数据做判断，是否是数值型
    // 不是转化为0
    private function checkNum($arr){
        for($i = 0;$i<count($arr);$i++){
            if(!is_numeric($arr[$i])){
                $arr[$i] = -1;
            }
        }
        return $arr;
    }

    public function demo(){
        echo 'start<br>';
        $arr = getFile('test.data');

        setFile('datainsert.sql',$arr);
        echo 'finish<br>';
    }
}


?>