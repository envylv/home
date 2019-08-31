<?php
/**
 * 配置文件
 * $root 用户根目录
 * $disk 分盘前缀
 * $movie_dir 电影目录
 * $db 数据库信息
 */
class conf{
    public static $root = "/home/Envy";
    public static $disk = "disk";
    public static $movie_dir = "movie";

    public static $db = array(
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'video',
        'pass' => 'video',
        'db'   => 'home_video'
    );

    /**
    *   格式化日期
    *   @param string $date time样子的日期字符串
    *   @return string 格式化好的日期字符串
    */
    public static function formatDate($date){
        return date('Y-m-d H:i:s',intval($date));
    }

    public static function replaceText($text){
        $regEx = array('&',' ','(',')','[',']',';','"',"'");
        $replace = array('\&','\ ','\(','\)','\[','\]','\;','\"',"\'");
        return str_replace($regEx, $replace, $text);
    }

    public static function output($text){
        return date("[Y-m-d H:i:s] : ").$text;
    }
}

?>
