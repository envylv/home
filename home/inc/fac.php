<?php
include_once 'data.php';
include_once 'conf.php';
class fac {
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
				$html .= "<div id='d_".$t."'>
	<span class='content' style='width:30px;text-align: center'><input type='checkbox' id='c_".$t."'/></span>
	<span class='content' style='width:680px;padding-left: 20px'>".$name."</span>
	<span class='content' style='width:150px'>".$v[2]."</span>
	<span class='content' style='width:80px;text-align: right'>".$v[3]."</span>
</div>";
			}else{
				$total_t = $id?$id."_total":"total";
				$total = "<div id='d_".$total_t."'>
	<span class='content' style='width:30px;text-align: center'></span>
	<span class='content' style='width:680px;padding-left: 20px'></span>
	<span class='content' style='width:150px'></span>
	<span class='content' style='width:80px;text-align: right'>总计：".$v."</span>
</div>";
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