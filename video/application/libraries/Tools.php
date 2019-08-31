<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tools {
    //格式化时间
    public function formatDate($date, $has_time = false){
        $reg = '';
        if($has_time){
            $reg = 'Y-m-d H:i:s';
        }else{
            $reg = 'Y-m-d';
        }
        return date($reg,intval($date));
    }
    //使用linux命令的时候替换文件名中的字符
    public function replaceText($text){
        $regEx   = array('&',' ','(',')','[',']',';','"',"'");
        $replace = array('\&','\ ','\(','\)','\[','\]','\;','\"',"\'");
        return str_replace($regEx, $replace, $text);
    }

    /**
     * 将dom节点转换成数组
     * DOMElement $node
     * return Array
     */
    public function dom2Array($node) {
        $array = array();
        if ($node->hasAttributes()) {
          foreach ($node->attributes as $attr) {
            $array[$attr->nodeName] = $attr->nodeValue;
          }
        }
        if ($node->hasChildNodes()) {
            if ($node->childNodes->length == 1) {
                $array[$node->firstChild->nodeName] = self::dom2Array($node->firstChild);
            } else {
                foreach ($node->childNodes as $childNode) {
                    if ($childNode->nodeType != XML_TEXT_NODE) {
                        $array[$childNode->nodeName][] = self::dom2Array($childNode);
                    }
                }
            }
        } else {
            $array = $node->nodeValue;
        }
        return $array;
    }

    /**
     * 获取图片地址
     * Array $array 通过数据库中读取的dom节点转换成的数组
     * int $type 图片类型，0为电影背景图，1为电影海报，2为电影集海报
     * boolean $is_pre 是否读取预览图，默认是
     * return string
     */
    public function getPic($array, $type = 1, $is_pre = 1) {
        $url = '';
        $attr_str = $is_pre?'preview':'#text';
        if(isset($array['thumb'][$attr_str])) {
            $url = $array['thumb'][$attr_str];
        } else {
            switch ($type) {
                case 0:
                    $url = $array['thumb'][0][$attr_str];
                    break;
                case 1:
                    if(isset($array['thumb'])) {
                        foreach($array['thumb'] as $p) {
                            if(!isset($p['aspect']) || 'poster' == $p['aspect']) {
                                $url = isset($p[$attr_str])?$p[$attr_str]:null;
                                break;
                            }
                        }
                    }
                    break;
                case 2:
                    foreach($array['thumb'] as $p) {
                        if(!$p['aspect'] || 'set' == $p['aspect']) {
                            $url = $p[$attr_str];
                            break;
                        }
                    }
                    if('' == $url) {
                        foreach($array['thumb'] as $p) {
                            if(!$p['aspect'] || 'poster' == $p['aspect']) {
                                $url = $p[$attr_str];
                                break;
                            }
                        } 
                    }
                    break;
            }
        }
        return $url;
    }
    
    /**
     * 根据路径获取文件大小
     */
    public function get_file_size($pre_path, $path, $format = false) {
        $size = '';
        $path = str_replace('smb://192.168.3.8/', $pre_path, $path);
        $exec = 'du -s'.(($format)?'h':'').'L '.$this->replaceText($path)." | awk '{print $1}'";
        exec($exec, $a);
        $size = $a[0];
        return $size;
    }
}
