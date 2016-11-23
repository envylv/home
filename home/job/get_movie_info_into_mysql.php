<?php
include_once 'fac.php';
include_once 'data.php';
include_once 'config.php';

date_default_timezone_set('Asia/Shanghai');

$start_time = time();
echo conf::output("开始执行\n");
echo conf::output("开始生成要存入数据库的数组...\n");
$array = fac::makeSubDataArray(array());
$array_end_time = time();
echo conf::output("数组生成完毕！用时".($array_end_time-$start_time)."秒\n");
$db_start_time = time();
echo conf::output("连接数据库...\n");
$pdo = data::getMyPdo();
echo conf::output("数据库连接成功，清理数据中...\n");
$del_count = data::clearDB($pdo);
$db_clear_time = time();
echo conf::output("数据清理完毕！用时".($db_clear_time-$db_start_time)."秒，共清理".$del_count."条数据\n");
$db_write_start_time = time();
echo conf::output("开始写入数据库...\n");
$count = fac::writeDB($pdo,$array);
$db_write_end_time = time();
echo conf::output("写入数据库完毕！用时".($db_write_end_time-$db_write_start_time)."秒，共写入".$count."条数据\n");
echo conf::output("执行完毕！总用时".($db_write_end_time-$start_time)."秒\n");
?>
