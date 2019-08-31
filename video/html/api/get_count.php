<?php
include_once(__DIR__.'/../../inc/factory/fac.php');

$type = $_POST['type'];
$id   = isset($_POST['id'])?$_POST['id']:'';
if(!$type){
    die();
}
$pdo   = fac::getMyPdo();
$count = fac::getCount($pdo, $type, $id);
echo $count[0];
?>