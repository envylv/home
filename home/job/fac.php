<?php
/**
 * 对获取的文件数据进行整合，转换成需要的格式
 */
class fac{
    /**
    *   获取指定目录的大小、最后修改日期、文件类型、带目录的文件名
    *   @param string $path 带目录的文件名
    *   @param string $p_k 父id
    *   @param string $size 文件大小，默认为空
    *   @return array，格式为(大小，最后修改日期，文件类型、带目录的文件名)
    */
    private static function makeFileInfo($path,$p_k='0',$size=''){
        $array = array();
        if(!$path){
            $path = conf::$root.'/'.conf::$disk.'1/'.conf::$movie_dir;
        }
        $data = data::getFileCDate($path);
        $array[0] = ($size=='')?data::getFileSize($path):$size;
        $array[1] = conf::formatDate($data[0]);
        $array[2] = $data[1]=='dir';
        $array[3] = $path;
        $array[4] = $p_k;
        return $array;
    }

    /**
    *   循环获取子目录的数据保存到数组
    *   @param array 原始数组
    *   @return array
    */
    public static function makeSubDataArray($array){
        if(empty($array)){
            $array = self::makeDataArray();
        }
        $key = max(array_keys($array))+1;
        $sub_array = array();
        foreach($array as $k=>$v){
            if($v[2]){
                $sub_arr = data::getSub($v[3]);
                foreach($sub_arr as $sub_k=>$sub_v){
                    $sub_array[$key] = self::makeFileInfo($sub_v[1],$k,$sub_v[0]);
                    $key++;
                }
            }
        }
        if(!empty($sub_array)){
            $array += $sub_array + self::makeSubDataArray($sub_array);
        }
        return $array;
    }

    /**
    *   根据获取的硬盘个数组合需要保存到数据库中的数组
    *   @return array
    */
    private static function makeDataArray(){
        $array = array();
        $disk_count = data::getDiskCount();
        for($i=1;$i<=$disk_count;$i++){
            $array[$i] = self::makeFileInfo(conf::$root.'/'.conf::$disk.$i.'/'.conf::$movie_dir);
        }
        return $array;
    }

    /**
    *   将数据写入数据库
    *   @param PDO $pdo 数据库连接
    *   @param array $array 待写入数组
    *   @return int 数量
    */
    public static function writeDB($pdo,$array){
        $param = array();
        foreach ($array as $key => $value) {
            $param["id"] = $key;
            $param["name"] = $value[3];
            $param["size"] = $value[0];
            $param["parent_id"] = $value[4];
            $param["mod_time"] = $value[1];
            $param["has_sub"] = $value[2]?1:0;
            data::insertDB($pdo,$param);
        }
        return count($array);
    }
}
?>
