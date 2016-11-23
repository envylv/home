<?php
include_once 'data.php';
include_once 'conf.php';
class fac {
    const html = "<div id='d_#THE_ID'>
<span class='content' style='width:30px;text-align: center'><input type='checkbox' id='c_#THE_ID'/></span>
<span class='content' style='width:680px;padding-left: 20px'>#THE_NAME</span>
<span class='content' style='width:150px'>#THE_DATE</span>
<span class='content' style='width:80px;text-align: right'>#THE_SIZE</span>
</div>";
    const html_total = "<div id='d_#THE_TOTAL_ID'>
<span class='content' style='width:30px;text-align: center'></span>
<span class='content' style='width:680px;padding-left: 20px'></span>
<span class='content' style='width:150px'></span>
<span class='content' style='width:80px;text-align: right'>总计：#THE_TOTAL_SIZE</span>
</div>";
    private static ex = array("#THE_ID","#THE_NAME","#THE_DATE","#THE_SIZE");
    private static ex_total = array("#THE_TOTAL_ID","#THE_TOTAL_SIZE");

    public function makeHtml($id,$path){
        self::filter($path);
        $array = data::getData($path);
        $html = '';
        $total = '';
        foreach($array as $k=>$v){
            if($k){
                $t = $id?$id.'_'.$k:$k;
                $name = $v[0]!=='-'? '<a href="javascript:;" id="a_'.$t.'" path="'.$path.'">'.$v[1].'</a>': $v[1];
                if($id){
                    $blank = "";
                    $b_count = count(explode("_",$id));
                    for($i=1;$i<$b_count;$i++){
                        $blank .= "&nbsp;&nbsp;";
                    }
                    $name = $blank.$name;
                }
                $name = $id?"&nbsp;&nbsp;".$name:$name;
                $r_str = array($t,$name,$v[2],$v[3]);
                $html .= str_replace(self::ex,$r_str,self::html);
            }else{
                $total_t = $id?$id."_total":"total";
                $r_total_str = array($total_t,$v);
                $total = str_replace(self::ex_total,$r_total_str,self::html_total);
            }
        }
        return $html.$total;
    }

    private static function filter($path){
        foreach (conf::$filter_chars as $char) {
            if(false!==strpos($path,$char)){
                echo '<script language="javascript">alert("Illegal operation!!");</script>';
                die();
            }
        }
    }
}
?>
