<?php
include_once(__DIR__.'/../../config/conf.php');
include_once(__DIR__.'/../tools/tools.php');

class file {
    /**
     * 根据路径获取文件大小
     */
    public static function get_file_size($path, $format = false) {
        $size = '';
        $path = str_replace('smb://192.168.3.8/', conf::$pre_path, $path);
        $exec = 'du -s'.(($format)?'h':'').'L '.tools::replaceText($path)." | awk '{print $1}'";
        exec($exec, $a);
        $size = $a[0];
        return $size;
    }
}
?>