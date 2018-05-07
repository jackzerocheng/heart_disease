<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/7
 * Time: 下午1:36
 */
class DB{
    private $conn;
    private $secureKey = 1;

    function __construct()
    {
        $this->conn = mysqli_connect('localhost','root','root','heart_disease') or die('cannot connect to mysql');
    }

    public function DBclose(){
        $this->conn->close();
    }

    //查询某一列的值
    public function selectByKey($key){
        $arr =array();
        $sql = "select $key from tbl_disease";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_row($result)){
            $arr[] = $row[0];
        }

        return $arr;
    }

    //返回记录总数
    public function printCount(){
        $sql = 'select count(*) from tbl_disease';
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    //插入数据，仅内部调用
    public function dataInsert($sql,$secureKey){
        $rt = false;
        if($this->secureKey !== $secureKey)
            return;
        $result = mysqli_query($this->conn,$sql);
        if($result)
        {
            if(mysqli_affected_rows($this->conn) > 0){
                $rt = true;
            }
        }

        return $rt;
    }

}

?>
