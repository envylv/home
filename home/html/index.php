<?php
include '../inc/fac.php';
if(isset($_POST['type']) && 'ajax'===$_POST['type']){
    $text = trim($_POST['text']);
    $id = trim($_POST['id']);
    echo fac::makeHtml($id,$text);
    exit;
}
?>
<!Doctype html>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv=Content-Type content="text/html;charset=utf-8">
<title>电影目录</title>
<link href="css/index.css" type="text/css" rel="stylesheet" />
<script src="/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/index.js"></script>
</head>
<body>
<div style="width:960px" class="border" id='content'>
<div id="title">
    <span class="content" style="width:30px;text-align: center;background-color: #aaa"><b>选择</b></span>
    <span class="content" style="width:680px;padding-left: 20px;background-color: #aaa"><b>电影名</b></span>
    <span class="content" style="width:150px;background-color: #aaa"><b>时间</b></span>
    <span class="content" style="width:80px;text-align: center;background-color: #aaa"><b>大小</b></span>
</div>
<?php
    echo fac::makeHtml('','');
?>
</div>
</body>
</html>