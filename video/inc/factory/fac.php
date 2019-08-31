<?php
include_once(__DIR__.'/../model/data.php');
include_once(__DIR__.'/../model/file.php');
include_once(__DIR__.'/../tools/tools.php');

class fac {
    /**
     * 获取数据库链接
     */
    public static function getMyPdo() {
        return data::getPdo();
    }

    /**
     * 获取总数
     * string $type 类型，“movie”为电影，“set”为电影集，“tvshow”为剧集，“season”为季，“episode”为集
     * string $id 查询用的编号
     * return intval $count
     */
    public static function getCount($pdo, $type="movie", $id="") {
        $count = 0;
        switch ($type) {
            case "movie":
                $count = data::getMovieCount($pdo);
                break;
            case "set":
                $count = data::getSetCount($pdo, $id);
                break;
            case "tvshow":
                $count = data::getTVShowCount($pdo);
                break;
            case "season":
                break;
            case "episode":
                break;
        }
        return $count;
    }
    /**
     * 获取电影列表信息
     */
    public static function getMovieList($pdo, $start=0, $page_count=0, $id="") {
        $list = array();
        if("" == $id) {
            $array = data::getMovie($pdo, $start, $page_count);
        }else {
            $array = data::getSet($pdo, $start, $page_count, $id);
        }
        $dom = new DOMDocument();
        foreach($array as $a) {
            $dom->loadXML('<xml>'.$a['poster'].'</xml>');
            $pic = tools::dom2Array($dom->documentElement);
            $m = array();
            if(isset($a['idSet'])){
                $m['id']      = $a['idSet'];
                $m['name']    = $a['strSet'];
                $m['size']    = '';
                $m['pic_url'] = empty($pic)?"":tools::getPic($pic, 2, 1);
            } else {
                $m['id']      = $a['idMovie'];
                $m['name']    = $a['name'];
                $m['size']    = file::get_file_size($a['path'], true);
                $m['pic_url'] = empty($pic)?"":tools::getPic($pic, 1, 1);
            }
            $m['premiered'] = $a['premiered'];
            $list[] = $m;
        }
        return $list;
    }
    /**
     * 获取电影详细信息
     */
    public static function getMoiveInfo($pdo, $id) {
        $info = array();
        $array = data::getMovieInfo($pdo, $id);
        //获取电影音视频流媒体信息
        $f_id = $array[0]['idFile'];
        $msv = data::getMovieStreamVideoInfo($pdo, $f_id);
        $msa = data::getMovieStreamAudioInfo($pdo, $f_id);
        //获取电影海报及同人画
        $dom = new DOMDocument();
        $dom->loadXML('<xml>'.$array[0]['poster'].'</xml>');
        $poster = tools::dom2Array($dom->documentElement);
        $dom->loadXML($array[0]['backdrop']);
        $back = tools::dom2Array($dom->documentElement);
        $info['name']       = $array[0]['name'];
        $info['slogan']     = $array[0]['slogan'];
        $info['synopsis']   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$array[0]['synopsis'];
        $info['type']       = $array[0]['type'];
        $info['company']    = $array[0]['company'];
        $info['country']    = $array[0]['country'];
        $info['poster_url'] = empty($poster)?"":tools::getPic($poster, 1, 0);
        $info['back_url']   = empty($back)?"":tools::getPic($back, 0, 0);
        $info['premiered']  = $array[0]['premiered'];
        $info['size']       = file::get_file_size($array[0]['path'], true);
        $info['rating']     = $array[0]['rating'];
        $info['imdb_url']   = conf::$imdb_pre_addr.$array[0]['uniqueid_value'].'/';
        $info['video_codec'] = conf::$video[$msv[0]['strVideoCodec']][0];
        $info['video_codec_link'] = conf::$video[$msv[0]['strVideoCodec']][1];
        $info['video_aspect'] = round($msv[0]['fVideoAspect'],2);
        $info['video_duration'] = ceil($msv[0]['iVideoDuration']/60).'分钟';
        $info['audio_codec'] = conf::$audio[$msa[0]['strAudioCodec']][0];
        $info['audio_codec_link'] = conf::$audio[$msa[0]['strAudioCodec']][1];
        $info['audio_channels'] = conf::$audio_channels[$msa[0]['iAudioChannels']];
        return $info;
    }
    /**
     * 获取剧集列表
     */
    public static function getTVShowList($pdo, $start=0, $page_count=0) {
        $list = array();
        $array = data::getTVShow($pdo, $start, $page_count);
        $dom = new DOMDocument();
        foreach($array as $a) {
            $dom->loadXML('<xml>'.$a['poster'].'</xml>');
            $pic = tools::dom2Array($dom->documentElement);
            $s = array();
            $s['id'] = $a['idShow'];
            $s['name'] = $a['name'].'(共'.$a['totalSeasons'].'季)';
            $img = empty($pic)?"":tools::getPic($pic, 1, 1);
            if(null == $img) {
                $img = tools::getPic($pic, 1, 0);
            }
            $s['pic_url'] = $img;
            $s['premiered'] = $a['premiered'];
            $list[] = $s;
        }
        return $list;
    }
    /**
     * 获取剧集信息
     */
    public static function getTVShowInfo($pdo, $id) {
        $info = array();
        $array = data::getTVShowInfo($pdo, $id);
        $dom = new DOMDocument();
        $dom->loadXML('<xml>'.$array[0]['poster'].'</xml>');
        $poster = tools::dom2Array($dom->documentElement);
        $dom->loadXML('<xml>'.$array[0]['backdrop'].'</xml>');
        $backs = tools::dom2Array($dom->documentElement);
        $back = isset($backs['fanart'][0])?is_array($backs['fanart'][0])?$backs['fanart'][0]:$backs['fanart'][1]:$backs['fanart'];
        $info['name'] = $array[0]['name'];
        $info['synopsis'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array[0]['synopsis'];
        $info['type'] = $array[0]['type'];
        $info['company'] = $array[0]['company'];
        $info['poster_url'] = empty($poster)?"":tools::getPic($poster, 1, 0);
        $back_url = empty($back)?"":tools::getPic($back, 0, 0);
        $info['back_url'] = (!empty($poster) && false===strpos($back_url, 'https://'))?$back['url'].$back_url:$back_url;
        $info['premiered'] = $array[0]['premiered'];
        $info['size'] = file::get_file_size($array[0]['path'], true);
        $info['rating'] = $array[0]['rating'];
        $info['tmdb_url'] = empty($array[0]['uniqueid_value'])?'':conf::$tmdb_pre_addr.$array[0]['uniqueid_value'].'/';
        $info['total_count'] = $array[0]['totalCount'];
        $info['total_season'] = $array[0]['totalSeasons'];
        return $info;
    }
    
}

?>