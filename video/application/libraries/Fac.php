<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fac {
    protected $CI;
    protected $config;

    public function __construct() {
        $this->CI = & get_instance();
        $this->config = $this->CI->config->config;
        $this->CI->load->model('Data');
        $this->CI->load->library('Tools');
    }
    /**
     * 获取总数
     * string $type 类型，“movie”为电影，“set”为电影集，“tvshow”为剧集，“season”为季，“episode”为集
     * string $id 查询用的编号
     * return intval $count
     */
    public function getCount($type="movie", $id="") {
        $count = 0;
        switch ($type) {
            case "movie":
                $count = $this->CI->Data->getMovieCount();
                break;
            case "set":
                $count = $this->CI->Data->getSetCount($id);
                break;
            case "tvshow":
                $count = $this->CI->Data->getTVShowCount();
                break;
        }
        return $count;
    }
    /**
     * 获取电影列表信息
     */
    public function getMovieList($start=0, $page_count=0, $id="") {
        $list = array();
        if("" == $id) {
            $array = $this->CI->Data->getMovie($start, $page_count);
        }else {
            $array = $this->CI->Data->getSet($start, $page_count, $id);
        }
        $dom = new DOMDocument();
        foreach($array as $a) {
            $dom->loadXML('<xml>'.$a['poster'].'</xml>');
            $pic = $this->CI->tools->dom2Array($dom->documentElement);
            $m = array();
            if(isset($a['idSet'])){
                $m['id']      = $a['idSet'];
                $m['name']    = $a['strSet'];
                $m['size']    = '';
                $m['pic_url'] = empty($pic)?"":$this->CI->tools->getPic($pic, 2, 1);
            } else {
                $m['id']      = $a['idMovie'];
                $m['name']    = $a['name'];
                $m['size']    = $this->CI->tools->get_file_size($this->config['pre_path'], $a['path'], true);
                $m['pic_url'] = empty($pic)?"":$this->CI->tools->getPic($pic, 1, 1);
            }
            $m['premiered'] = $a['premiered'];
            $list[] = $m;
        }
        return $list;
    }
    /**
     * 获取电影详细信息
     */
    public function getMoiveInfo($id) {
        $info = array();
        $array = $this->CI->Data->getMovieInfo($id);
        //获取电影音视频流媒体信息
        $f_id = $array['idFile'];
        $msv = $this->CI->Data->getMovieStreamVideoInfo($f_id);
        $msa = $this->CI->Data->getMovieStreamAudioInfo($f_id);
        //获取电影海报及同人画
        $dom = new DOMDocument();
        $dom->loadXML('<xml>'.$array['poster'].'</xml>');
        $poster = $this->CI->tools->dom2Array($dom->documentElement);
        $dom->loadXML($array['backdrop']);
        $back = $this->CI->tools->dom2Array($dom->documentElement);
        $info['name']       = $array['name'];
        $info['slogan']     = $array['slogan'];
        $info['synopsis']   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$array['synopsis'];
        $info['type']       = $array['type'];
        $info['company']    = $array['company'];
        $info['country']    = $array['country'];
        $info['poster_url'] = empty($poster)?"":$this->CI->tools->getPic($poster, 1, 0);
        $info['back_url']   = empty($back)?"":$this->CI->tools->getPic($back, 0, 0);
        $info['premiered']  = $array['premiered'];
        $info['size']       = $this->CI->tools->get_file_size($this->config['pre_path'], $array['path'], true);
        $info['rating']     = $array['rating'];
        $info['imdb_url']   = $this->config['imdb_pre_addr'].$array['uniqueid_value'].'/';
        $info['video_codec'] = $msv?$this->config['video'][$msv['strVideoCodec']][0]:'';
        $info['video_codec_link'] = $msv?$this->config['video'][$msv['strVideoCodec']][1]:'';
        $info['video_aspect'] = $msv?round($msv['fVideoAspect'],2):0;
        $info['video_duration'] = ($msv?ceil($msv['iVideoDuration']/60):0).'分钟';
        $info['audio_codec'] = $msa?$this->config['audio'][$msa['strAudioCodec']][0]:'';
        $info['audio_codec_link'] = $msa?$this->config['audio'][$msa['strAudioCodec']][1]:'';
        $info['audio_channels'] = $msa?$this->config['audio_channels'][$msa['iAudioChannels']]:'';
        return $info;
    }
    /**
     * 获取剧集列表
     */
    public function getTVShowList($start=0, $page_count=0) {
        $list = array();
        $array = $this->CI->Data->getTVShow($start, $page_count);
        $dom = new DOMDocument();
        foreach($array as $a) {
            $dom->loadXML('<xml>'.$a['poster'].'</xml>');
            $pic = $this->CI->tools->dom2Array($dom->documentElement);
            $s = array();
            $s['id'] = $a['idShow'];
            $s['name'] = $a['name'].'(共'.$a['totalSeasons'].'季)';
            $img = empty($pic)?"":$this->CI->tools->getPic($pic, 1, 1);
            if(null == $img) {
                $img = $this->CI->tools->getPic($pic, 1, 0);
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
    public function getTVShowInfo($id) {
        $info = array();
        $array = $this->CI->Data->getTVShowInfo($id);
        $dom = new DOMDocument();
        $dom->loadXML('<xml>'.$array['poster'].'</xml>');
        $poster = $this->CI->tools->dom2Array($dom->documentElement);
        $dom->loadXML('<xml>'.$array['backdrop'].'</xml>');
        $backs = $this->CI->tools->dom2Array($dom->documentElement);
        $back = isset($backs['fanart'][0])?is_array($backs['fanart'][0])?$backs['fanart'][0]:$backs['fanart'][1]:$backs['fanart'];
        $info['name'] = $array['name'];
        $info['synopsis'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array['synopsis'];
        $info['type'] = $array['type'];
        $info['company'] = $array['company'];
        $info['poster_url'] = empty($poster)?"":$this->CI->tools->getPic($poster, 1, 0);
        $back_url = empty($back)?"":$this->CI->tools->getPic($back, 0, 0);
        $info['back_url'] = (!empty($poster) && false===strpos($back_url, 'https://'))?$back['url'].$back_url:$back_url;
        $info['premiered'] = $array['premiered'];
        $info['size'] = $this->CI->tools->get_file_size($this->config['pre_path'], $array['path'], true);
        $info['rating'] = $array['rating'];
        $info['tmdb_url'] = empty($array['uniqueid_value'])?'':$this->config['tmdb_pre_addr'].$array['uniqueid_value'].'/';
        $info['total_count'] = $array['totalCount'];
        $info['total_season'] = $array['totalSeasons'];
        return $info;
    }
}
