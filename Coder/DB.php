<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/7
 * Time: 下午1:36
 * 数据库操作文件
 */
class DB{
    private $conn;
    private $secureKey = 1;
    private $tableName;

    function __construct()
    {
        $this->conn = mysqli_connect('localhost','root','root','heart_disease') or die('cannot connect to mysql');
        $this->tableName = 'tbl_disease';
    }

    public function DBclose(){
        $this->conn->close();
    }

    //  返回所有数据
    public function selectAll(){
        $arr = array();
        $sql = "select * from $this->tableName";
        $rs = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_row($rs)){
            $arr[] = $row;
        }
        return $arr;
    }

    //查询某一列的值
    //  过滤所有的  -1  的值！！！
    //    $isDisease: 是否患病
    public function selectByKey($key,$isDisease){
        $arr =array();
        if($isDisease)
        {
            $sql = "select $key from $this->tableName where status>0";
        }
        else
        {
            $sql = "select $key from $this->tableName where status=0";
        }

        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_row($result)){
            if($row[0] != -1)
            {
                $arr[] = $row[0];
            }
        }

        return $arr;
    }

    public function getCountDisease($isDisease)
    {
        if($isDisease)
        {
            $sql = "select count(*) from $this->tableName where status>0";
        }
        else
        {
            $sql = "select count(*) from $this->tableName where status=0";
        }
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //返回记录总数
    public function printCount(){
        $sql = "select count(*) from $this->tableName";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //插入数据，仅内部调用
    public function dataInsert($sql,$secureKey){
        $rt = true;
        if($this->secureKey !== $secureKey)
            return;
        foreach ($sql as $key=>$value)
        {
            $value = trim($value);
            if($value !=null && $value != '')
            {
                $value = $value . ';';
                $result = mysqli_query($this->conn,$value);
                if(!$result)
                {
                    echo $value.'<br>';
                    $rt = false;
                }
            }
        }


        return $rt;
    }

    //  获取特征值中最大的数据
    public function getMax($key)
    {
        $sql = "Select max($key) from $this->tableName";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //    获取特征值中最小的数据
    public function getMin($key)
    {
        $sql = "Select min($key) from $this->tableName where $key <> -1";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //  获取特征值中最大的数据
    //  测试数据
    public function getTestMax($key, $table = 'tbl_disease_test')
    {
        $sql = "Select max($key) from $table";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //    获取特征值中最小的数据
    //    测试数据
    public function getTestMin($key, $table = 'tbl_disease_test')
    {
        $sql = "Select min($key) from $table where $key <> -1";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

}

?>
