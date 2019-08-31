<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $info['name'];?></title>
    <link href="/css/view.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="back">
    <div class="back_mask"></div>
    <img src="<?php echo $info['back_url']; ?>"/>
</div>
<div class="poster">
    <img src="<?php echo $info['poster_url']; ?>"/>
</div>
<div class="main">
    <div class="head">
        <div class="title"><?php echo $info['name'];?></div>
    </div>
    <div class="body">
        <div class="prop">
            <span class="key">类型</span>
            <span class="value"><?php echo $info['type']; ?></span>
            <span class="key">发行公司</span>
            <span class="value"><?php echo $info['company']; ?></span>
            <span class="key">首映日期</span>
            <span class="value"><?php echo $info['premiered'];?></span>
            <span class="key">评分</span>
            <span class="value"><?php echo $info['rating'];?></span>
            <span class="key">视频大小</span>
            <span class="value"><?php echo $info['size'];?></span>
            <span class="key">季、集信息</span>
            <span class="value">共<?php echo $info['total_season']; ?>季，<?php echo $info['total_count']; ?>集</span>
        </div>
        <div class="synopsis"><?php echo $info['synopsis'];?></div>
        <?php
        if(!empty($info['tmdb_url'])) {
        ?>
        <div class="link"><a href="<?php echo $info['tmdb_url'];?>" target="_blank">前往TMDB链接查看更多内容</a></div>
        <?php
        }
        ?>
    </div>
</div>
</body>
</html>