<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 获取电影总数
     */
    public function getMovieCount() {
        $count = 0;
        $sql = "SELECT * FROM (
            SELECT idMovie FROM movie_view  WHERE ISNULL(idSet)
            UNION
            SELECT idMovie FROM movie_view WHERE !ISNULL(idSet) GROUP BY idSet
        ) AS tt";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    /**
     * 获取电影列表
     * 
     */
    public function getMovie($start=0, $page_count=0) {
        $movie = array();
        $sql = "SELECT * FROM (
            SELECT idMovie, idSet, strSet, c00 AS `name`, c08 AS poster, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path, premiered FROM movie_view  WHERE ISNULL(idSet)
            UNION
            SELECT idMovie, idSet, strSet, c00 AS `name`, GROUP_CONCAT(c08) AS poster, '' AS path, max(premiered) FROM movie_view WHERE !ISNULL(idSet) GROUP BY idSet
        ) AS tt
        ORDER BY tt.premiered DESC LIMIT ".$start.", ".$page_count;
        $query= $this->db->query($sql);
        $movie = $query->result_array();
        return $movie;
    }

    /**
     * 获取电影详细信息
     */
    public function getMovieInfo($id) {
        $mf = array();
        $sql = "SELECT idFile, c00 AS `name`, c01 AS synopsis, c03 AS slogan, c14 AS `type`, c18 AS company, c21 AS country, c08 AS poster, c20 AS backdrop, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path,premiered, rating, uniqueid_value FROM movie_view WHERE idMovie = ?";
        $query = $this->db->query($sql, $id);
        $mf = $query->row_array();
        return $mf;
    }

    /**
     * 获取电影流媒体中视频信息
     */
    public function getMovieStreamVideoInfo($id) {
        $msv = array();
        $sql = "SELECT strVideoCodec, fVideoAspect, iVideoDuration FROM streamdetails WHERE iStreamType = 0 AND idFile = ?";
        $query = $this->db->query($sql, $id);
        $msv = $query->row_array();
        return $msv;
    }

    /**
     * 获取电影流媒体中音频信息
     */
    public function getMovieStreamAudioInfo($id) {
        $msa = array();
        $sql = "SELECT strAudioCodec, iAudioChannels FROM streamdetails WHERE iStreamType = 1 AND idFile = ? LIMIT 1";
        $query = $this->db->query($sql, $id);
        $msa = $query->row_array();
        return $msa;
    }

    /**
     * 获取电影集中电影数量
     */
    public function getSetCount($id) {
        $count = 0;
        $sql = "SELECT * FROM movie WHERE idSet = ?";
        $query = $this->db->query($sql, $id);
        $count = $query->num_rows();
        return $count;
    }

    /**
     * 获取电影集中电影列表
     */
    public function getSet($start=0, $page_count=0, $id) {
        $movie = array();
        $sql = "SELECT idMovie, c00 AS `name`, c08 AS poster, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path, premiered FROM movie_view WHERE idSet=? ORDER BY premiered LIMIT ".$start.", ".$page_count;
        $query = $this->db->query($sql, $id);
        $movie = $query->result_array();
        return $movie;
    }

    /**
     * 获取剧集数量
     */
    public function getTVShowCount() {
        $count = 0;
        $sql = "SELECT * FROM tvshow_view";
        $query = $this->db->query($sql);
        $count = $query->num_rows();
        return $count;
    }

    /**
     * 获取电视剧列表
     */
    public function getTVShow($start=0, $page_count=0) {
        $show = array();
        $sql = "SELECT idShow, c00 AS `name`, totalSeasons, c06 AS poster, c05 AS premiered FROM tvshow_view ORDER BY c05 DESC LIMIT ".$start.", ".$page_count;
        $query = $this->db->query($sql);
        $show = $query->result_array();
        return $show;
    }

    /**
     * 获取剧集详细信息
     */
    public function getTVShowInfo($id) {
        $sf = array();
        $sql = "SELECT idShow, c00 AS `name`, c01 AS synopsis, c06 AS poster, c05 AS premiered, c08 AS `type`, c11 AS backdrop, c14 AS company, strPath AS `path`, totalCount, totalSeasons, rating, IF('tmdb'=uniqueid_type, uniqueid_value, '') AS uniqueid_value FROM tvshow_view WHERE idShow = ?";
        $query = $this->db->query($sql, $id);
        $sf = $query->row_array();
        return $sf;
    }
}
