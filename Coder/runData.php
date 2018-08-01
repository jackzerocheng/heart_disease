<?php
require 'DB.php';

class runData{

    //读取数据文件，以二维数组存储
    public function getFile($fileName, $delimter = ','){
        $fileName = '../Data/' . $fileName;
        $file = fopen($fileName,'r') or die('unable to read file');

        $rs =array();
        $count = 0;
        while (! feof($file)){  //按行读取
            $line = fgets($file);
            $rs[$count][] = (explode($delimter,$line));
            $count++;
        }
        fclose($file);
        return $rs;
    }

    //返回文本字符串
    public function getStrFile($fileName){
        $fileName = '../Data/' . $fileName;
        return file_get_contents($fileName);

    }

    //写SQL文件，原有文件将被覆盖
    public function setFile($fileName,$arr,$tableName = 'tbl_disease'){
        $fileName = '../Data/' . $fileName;
        if(file_exists($fileName))
        {
            unlink($fileName);
        }
        $file = fopen($fileName,'w') or die('unable to write file');
        $count = 0;
        fwrite($file,"truncate table $tableName;\n");
        foreach ($arr as $key => $values){
            if($values != null && $values[0] !=['']){
                $arr2 = $values[0];
                $arr2[13] = trim($arr2[13]);  //去掉最后一个数的空格
                $arr2 = $this->checkNum($arr2);   // 排除非数值类型的数据
                $sql = "insert into $tableName (age,sex,cp,trestbps,chol,fbs,restecg,thalach,exang,oldpeak,slop,ca,thal,status) values ($arr2[0],$arr2[1],$arr2[2],$arr2[3],$arr2[4],$arr2[5],$arr2[6],$arr2[7],$arr2[8],$arr2[9],$arr2[10],$arr2[11],$arr2[12],$arr2[13]);\n";
                echo ++$count;
                echo '----' . $sql."<br>";
                fwrite($file,$sql);
            }
        }

        fclose($file);
    }

    // j将每一行的数据做判断，是否是数值型
    // 不是转化为-1      不要该数据
    private function checkNum($arr){
        for($i = 0;$i<count($arr);$i++){
            if(!is_numeric($arr[$i])){
                echo "-------------值： $arr[$i] 该数据出错了---------\n";
                $arr[$i] = -1;
            }
        }
        return $arr;
    }

    //执行SQL文件
    public function execSql($sqlName){
        $content = $this->getStrFile($sqlName);
        $arrSQL = explode(';',$content);   //  无法执行多条SQL，拆分执行
        $db =new DB();
        $rs = $db->dataInsert($arrSQL,1);
        $db->DBclose();
        return $rs;
    }

    public function printAll(){
        $db = new DB();
        $tmp = $db->selectAll();
        $db->DBclose();
        return $tmp;
    }

    public function demo(){
        echo 'start<br>';
        $arr = getFile('test.data');

        setFile('datainsert.sql',$arr);
        echo 'finish<br>';
    }
}


?>