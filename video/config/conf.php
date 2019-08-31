<?php
/** 配置文件
 * 
 */
class conf {
    //默认路径前缀
    public static $pre_path = '/home/Envy/';
    //imdb网址前缀
    public static $imdb_pre_addr = 'https://www.imdb.com/title/';
    //themoviedb网址前缀
    public static $tmdb_pre_addr = 'https://www.themoviedb.org/tv/';
    //数据库连接
    public static $db = array(
        'host' => 'envylv.3322.org',
        'port' => 3306,
        'user' => 'kodi',
        'pass' => 'kodi',
        'db'   => 'HomeVideos116'
    );
    //视频编码
    public static $video = array(
        'h264'       => array('images/h264.png', 'https://zh.wikipedia.org/wiki/H.264/MPEG-4_AVC'),
        'hevc'       => array('images/h265.png','https://zh.wikipedia.org/wiki/%E9%AB%98%E6%95%88%E7%8E%87%E8%A7%86%E9%A2%91%E7%BC%96%E7%A0%81'),
        'mpeg2video' => array('images/mpeg.png','https://zh.wikipedia.org/wiki/MPEG-2'),
        'mpeg4'      => array('images/mp4.png','https://zh.wikipedia.org/wiki/MPEG-4'),
    );
    //音频编码
    public static $audio = array(
        'aac'      => array('images/aac.png','https://zh.wikipedia.org/wiki/%E9%80%B2%E9%9A%8E%E9%9F%B3%E8%A8%8A%E7%B7%A8%E7%A2%BC'),
        'ac3'      => array('images/ac3.png','https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97'),
        'dca'      => array('images/dts.png','https://zh.wikipedia.org/wiki/DTS'),
        'eac3'     => array('images/eac3.png','https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97#%E6%9D%9C%E6%AF%94%E6%95%B8%E4%BD%8DPlus'),
        'dtshd_ma' => array('images/dtshd.png', 'https://zh.wikipedia.org/wiki/DTS-HD_Master_Audio'),
        'opus'     => array('images/opus.png', 'https://zh.wikipedia.org/wiki/Opus_(%E9%9F%B3%E9%A2%91%E6%A0%BC%E5%BC%8F)'),
        'truehd'   => array('images/truehd.png', 'https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97#%E6%9D%9C%E6%AF%94TrueHD'),
        'flac'     => array('images/flac.png', 'https://zh.wikipedia.org/wiki/FLAC'),
        'mp2'      => array('images/mp2.png', 'https://zh.wikipedia.org/wiki/MPEG-1_Audio_Layer_II'),
        'mp3'      => array('images/mp3.png', 'https://zh.wikipedia.org/wiki/MP3'),
    );
    //声道
    public static $audio_channels = array(
        '6' => 'images/5.1.png',
        '2' => 'images/2.png',
        '5' => 'images/4.1.png',
        '8' => 'images/7.1.png',
        '7' => 'images/5.2.png',
        '1' => 'images/1.png',
    );
}
?>
