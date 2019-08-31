<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>电影列表</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="js/list.js"></script>
    <link href="css/list.css" rel="stylesheet" type="text/css">
</head>
<body id='<?php echo isset($_GET['id'])?$_GET['id']:"";?>' type='<?php echo isset($_GET['type'])?$_GET['type']:"";?>'>
    <div id='list' class="list">
        <ul id='list_ul'></ul>
    </div>
</body>
</html>