<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = 'http://envylv.3322.org:10080';

$config['index_page'] = '';

$config['uri_protocol']	= 'REQUEST_URI';

$config['url_suffix'] = '';

$config['language']	= 'english';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = FALSE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = FALSE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['allow_get_array'] = TRUE;

$config['log_threshold'] = 0;

$config['log_path'] = '';

$config['log_file_extension'] = '';

$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path'] = '';

$config['cache_query_string'] = FALSE;

$config['encryption_key'] = '';

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';

//下面是应用使用的配置
//默认路径前缀
$config['pre_path'] = '/home/Envy/';
//imdb网址前缀
$config['imdb_pre_addr'] = 'https://www.imdb.com/title/';
//themoviedb网址前缀
$config['tmdb_pre_addr'] = 'https://www.themoviedb.org/tv/';
//视频编码
$config['video'] = array(
    'h264'       => array('/images/h264.png', 'https://zh.wikipedia.org/wiki/H.264/MPEG-4_AVC'),
    'hevc'       => array('/images/h265.png','https://zh.wikipedia.org/wiki/%E9%AB%98%E6%95%88%E7%8E%87%E8%A7%86%E9%A2%91%E7%BC%96%E7%A0%81'),
    'mpeg2video' => array('/images/mpeg.png','https://zh.wikipedia.org/wiki/MPEG-2'),
    'mpeg4'      => array('/images/mp4.png','https://zh.wikipedia.org/wiki/MPEG-4'),
);
//音频编码
$config['audio'] = array(
    'aac'      => array('/images/aac.png','https://zh.wikipedia.org/wiki/%E9%80%B2%E9%9A%8E%E9%9F%B3%E8%A8%8A%E7%B7%A8%E7%A2%BC'),
    'ac3'      => array('/images/ac3.png','https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97'),
    'dca'      => array('/images/dts.png','https://zh.wikipedia.org/wiki/DTS'),
    'eac3'     => array('/images/eac3.png','https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97#%E6%9D%9C%E6%AF%94%E6%95%B8%E4%BD%8DPlus'),
    'dtshd_ma' => array('/images/dtshd.png', 'https://zh.wikipedia.org/wiki/DTS-HD_Master_Audio'),
    'opus'     => array('/images/opus.png', 'https://zh.wikipedia.org/wiki/Opus_(%E9%9F%B3%E9%A2%91%E6%A0%BC%E5%BC%8F)'),
    'truehd'   => array('/images/truehd.png', 'https://zh.wikipedia.org/wiki/%E6%9D%9C%E6%AF%94%E6%95%B0%E5%AD%97#%E6%9D%9C%E6%AF%94TrueHD'),
    'flac'     => array('/images/flac.png', 'https://zh.wikipedia.org/wiki/FLAC'),
    'mp2'      => array('/images/mp2.png', 'https://zh.wikipedia.org/wiki/MPEG-1_Audio_Layer_II'),
    'mp3'      => array('/images/mp3.png', 'https://zh.wikipedia.org/wiki/MP3'),
);
//声道
$config['audio_channels'] = array(
    '6' => '/images/5.1.png',
    '2' => '/images/2.png',
    '5' => '/images/4.1.png',
    '8' => '/images/7.1.png',
    '7' => '/images/5.2.png',
    '1' => '/images/1.png',
);