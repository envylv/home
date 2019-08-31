<?php
include_once(__DIR__.'/../../inc/factory/fac.php');

$type = isset($_POST['type'])?$_POST['type']:"";
$start = $_POST['start'];
$num = $_POST['num'];
$id = isset($_POST['id'])?$_POST['id']:'';
if(!$num){
    die();
}
$pdo = fac::getMyPdo();
if('tvshow' == $type) {
    $array = fac::getTVShowList($pdo, $start, $num);
} else {
    $array = fac::getMovieList($pdo, $start, $num, $id);
}
echo json_encode($array);
?>