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
        <div class="slogan"><?php echo $info['slogan'];?></div>
    </div>
    <div class="body">
        <div class="prop">
            <span class="key">类型</span>
            <span class="value"><?php echo $info['type']; ?></span>
            <span class="key">发行公司</span>
            <span class="value"><?php echo $info['company']; ?></span>
            <span class="key">国家</span>
            <span class="value"><?php echo $info['country']; ?></span>
            <span class="key">首映日期</span>
            <span class="value"><?php echo $info['premiered'];?></span>
            <span class="key">评分</span>
            <span class="value"><?php echo $info['rating'];?></span>
            <span class="key">视频大小</span>
            <span class="value"><?php echo $info['size'];?></span>
        </div>
        <div class="media">
            <ul>
                <?php
                    if('0分钟' == $info['video_duration']) {
                        echo '<li><img src="/images/blueray.png"/></li>';
                    } else {
                ?>
                <li title="影片时间"><?php echo $info['video_duration'];?></li>
                <li title="视频格式"><a href="<?php echo $info['video_codec_link'];?>" target="_blank"><img src="<?php echo $info['video_codec'];?>"/></a></li>
                <li title="音频格式"><a href="<?php echo $info['audio_codec_link'];?>" target="_blank"><img src="<?php echo $info['audio_codec'];?>"/></a></li>
                <li title="声道"><img src="<?php echo $info['audio_channels'];?>"/></li>
                <li title="宽高比"><?php echo $info['video_aspect'];?></li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <div class="synopsis"><?php echo $info['synopsis'];?></div>
        <div class="link"><a href="<?php echo $info['imdb_url'];?>" target="_blank">前往IMDB链接查看更多内容</a></div>
    </div>
</div>
</body>
</html>