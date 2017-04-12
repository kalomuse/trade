<?php

/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/17
 * Time: 上午10:05
 */
class DB {
    private $servername = "127.0.0.1";
    private $username = "kalomuse";
    private $password = "qy199276";
    private $dbname = "trade";
    public $con = '';

    function __construct() {
        $con = new mysqli($this->servername, $this->username, $this->password,  $this->dbname);
        if ($con->connect_error) {
            die("连接失败: " . $con->connect_error);
        }
        $this->con = $con;
    }

    public function query($table, $where='') {
        if(!$where) {
            $set = mysqli_query($this->con, "select * from $table where deleted=0 order by id desc");
        } else {
            $set = mysqli_query($this->con, "select * from $table where $where and deleted=0 order by id desc");
        }

        $res = array();
        while($row = mysqli_fetch_array($set)) {
            $res[] = $row;
        }
        return $res;
    }

    public function update($table, $set, $where) {
        $sql = '';
        foreach ($set as $key => $value) {
            if(is_array($value)) {
                if($value['no_str']) {
                    $sql .= "$key = " .$value['value']. ",";
                } else {
                    $sql .= "$key = '" .$value['value']. "',";
                }
            } else {
                $sql .= "$key = '$value',";
            }
        }
        $sql = rtrim($sql, ",");

        $res = mysqli_query($this->con, "update $table set $sql where $where");
        return $res;
    }

    public function insert($table, $set) {
        $key = '';
        $value = '';
        foreach ($set as $k => $v) {
            $key .= "`$k`,";
            $value .= "'$v',";
        }
        $key = rtrim($key, ",");
        $value = rtrim($value, ",");
        $res = mysqli_query($this->con, "insert into $table($key) value($value)");
        return $res;
    }

    public function __destruct() {
        mysqli_close($this->con);
    }
}