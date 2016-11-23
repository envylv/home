<?php
include_once 'conf.php';
class data{
    public function getData($path){
        $path = conf::$root.$path."/";
        $array = array();
        $content = array();
        exec('sudo ls '.$path.' -lh',$array);
        foreach ($array as $key => $value) {
            if(0==$key){
                $content[$key] = str_replace('total','',trim($value));
            }else{
                while(strpos(trim($value),'  ')){
                    $value = str_replace('  ',' ',$value);
                }
                $tmp = split(' ', trim($value));
                $content[$key][] = $tmp[0][0];
                $content[$key][] = $tmp[8];
                $tmp[7] = (strlen($tmp[7])==4)? $tmp[7] : date('Y');
                $content[$key][] = date('Y年m月d日',strtotime($tmp[5].' '.$tmp[6].' '.$tmp[7]));
                $content[$key][] = $tmp[4];
            }
        }
        return $content;
    }
}
?>
