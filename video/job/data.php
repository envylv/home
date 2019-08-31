<?php
/**
 * 获取文件属性，主要是最后修改时间和大小
 */
class data{
    /**
    *   获取绑定硬盘的个数
    *   @return int
    */
    public static function getDiskCount(){
        $count = 0;
        $data = array();
        exec('mount | grep disk | wc -l',$data);
        $count = intval($data[0]);
        return $count;
    }

    /**
    *   获取指定文件的信息
    *   文件修改日期为time样子的字符串、文件类型为字符串（目录、普通文件等）
    *   @param string $path 带目录的文件名
    *   @return array $data 格式为(文件修改日期，文件类型)
    */
    public static function getFileCDate($path){
        $data = array();
        $data[] = filectime($path);
        $data[] = filetype($path);
        // exec('stat '.conf::replaceText($path).' --format="%Z|%F"', $data);
        // $data = explode('|',$data[0]);
        return $data;
    }

    /**
    *   获取指定文件的大小
    *   @param string $path 带目录的文件名
    *   @return string 为易于阅读的格式的文件大小
    */
    public static function getFileSize($path){
        $data = array();
        exec('du '.conf::replaceText($path)." -hs | awk '{print $1}'",$data);
        return $data[0];
    }

    /**
    *   获取指定目录下的所有儿子的信息
    *   @param string $path 带目录的文件名
    *   @return array 二位数组，每个元素都是一个格式为(文件大小，带目录的文件名)的数组
    */
    public static function getSub($path){
        $data = array();
        $array = array();
        exec('du '.conf::replaceText($path).'/* -hs',$data);
        foreach($data as $v){
            $d = explode("\t",$v);
            $array[] = $d;
        }
        return $array;
    }

    public static function getFile($path){
        $data = array();
        exec('find '.$path.' -type f ! -name .DS_Store ! -name ._.DS_Store',$data);
        return $data;
    }

    /**
    *   建立数据连接
    *   @return new PDO
    */
    public static function getMyPdo(){
        $dsn = sprintf("mysql:host=%s;port=%d;dbname=%s;charset=UTF8",conf::$db["host"],conf::$db["port"],conf::$db["db"]);
        $pdo = new PDO($dsn, conf::$db["user"], conf::$db["pass"]);
        return $pdo;
    }

    /**
    *   清空数据库中数据
    *   @param PDO $pdo 数据连接
    *   @return boolean
    */
    public static function clearDB($pdo){
        $sql = "DELECT FROM video";
        $sth = $pdo->prepare($sql);
        return $sth->execute();
    }

    /**
    *   在数据库中插入内容
    *   @param PDO $pdo 数据连接
    *   @param array $params 参数数组
    *   @return boolean
    */
    public static function insertDB($pdo,$params){
        $sql = "INSERT INTO video(`id`,`name`,`size`,`parent_id`,`mod_time`,`has_sub`) VALUES(:id, :name, :size, :parent_id, :mod_time, :has_sub)";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id",$params["id"]);
        $sth->bindValue(":name",$params["name"]);
        $sth->bindValue(":size",$params["size"]);
        $sth->bindValue(":parent_id",$params["parent_id"]);
        $sth->bindValue(":mod_time",$params["mod_time"]);
        $sth->bindValue(":has_sub",$params["has_sub"]);
    }
}
?>
