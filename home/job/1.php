<?php
include_once 'data.php';

function findByDir($arr,$p){
    $new_arr = array();
    foreach($arr as $a_v){
        if(false!==strpos($a_v,$p)){
            $new_arr[] = $a_v;
        }
    }
    return $new_arr;
}
$path_a = array();
$path = '/home/Envy/disk1/movie/';
$array = data::getFile($path);
foreach($array as $v){
    $v = str_replace($path,'',$v);
    $a = explode('/',$v);
    $p = $path;
    for($i=0;$i<count($a)-1;$i++){
        $p .= $a[$i].'/';
        if(!in_array($p,$path_a)){
            $path_a[] = $p;
        }
    }
}
foreach($path_a as $path_a_v){
    print_r(findByDir($array,$path_a_v));
    exit;
}
    print_r($path_a);exit;
?>