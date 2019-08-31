<?php
include_once(__DIR__.'/../../config/conf.php');

class data {
    /**
    *   建立数据连接
    *   @return new PDO
    */
    public static function getPdo(){
        $dns = sprintf("mysql:host=%s;port=%d;dbname=%s;charset=UTF8",conf::$db["host"],conf::$db["port"],conf::$db["db"]);
        $pdo = new PDO($dns, conf::$db["user"], conf::$db["pass"]);
        return $pdo;
    }

    /**
     * 获取电影总数
     */
    public static function getMovieCount($pdo) {
        $count = 0;
        $sql = "SELECT count(*) FROM (
            SELECT idMovie, idSet FROM movie_view  WHERE ISNULL(idSet)
            UNION
            SELECT idMovie, idSet AS poster FROM (
                SELECT idMovie, idSet FROM movie_view WHERE !ISNULL(idSet) ORDER BY premiered DESC
            ) AS t
            GROUP BY t.idSet
        ) AS tt";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $a = $sth->fetchAll();
        $count = $a[0];
        return $count;
    }
    /**
     * 获取电影列表
     * 
     */
    public static function getMovie($pdo, $start=0, $page_count=0) {
        $movie = array();
        $sql = "SELECT * FROM (
            SELECT idMovie, idSet, strSet, c00 AS `name`, c08 AS poster, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path, premiered FROM movie_view  WHERE ISNULL(idSet)
            UNION
            SELECT idMovie, idSet, strSet, `name`, GROUP_CONCAT(poster) AS poster, path, premiered FROM (
                SELECT idMovie, idSet, strSet, c00 AS `name`, c08 AS poster, '' AS path, premiered FROM movie_view WHERE !ISNULL(idSet) ORDER BY premiered DESC
            ) AS t
            GROUP BY t.idSet
        ) AS tt
        ORDER BY tt.premiered DESC LIMIT ".$start.", ".$page_count;
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $movie = $sth->fetchAll();
        return $movie;
    }

    /**
     * 获取电影详细信息
     */
    public static function getMovieInfo($pdo, $id) {
        $mf = array();
        $sql = "SELECT idFile, c00 AS `name`, c01 AS synopsis, c03 AS slogan, c14 AS `type`, c18 AS company, c21 AS country, c08 AS poster, c20 AS backdrop, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path,premiered, rating, uniqueid_value FROM movie_view WHERE idMovie = :id";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $mf = $sth->fetchAll();
        return $mf;
    }

    /**
     * 获取电影流媒体中视频信息
     */
    public static function getMovieStreamVideoInfo($pdo, $id) {
        $msv = array();
        $sql = "SELECT strVideoCodec, fVideoAspect, iVideoDuration FROM streamdetails WHERE iStreamType = 0 AND idFile = :id";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $msv = $sth->fetchAll();
        return $msv;
    }

    /**
     * 获取电影流媒体中音频信息
     */
    public static function getMovieStreamAudioInfo($pdo, $id) {
        $msa = array();
        $sql = "SELECT strAudioCodec, iAudioChannels FROM streamdetails WHERE iStreamType = 1 AND idFile = :id LIMIT 1";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $msa = $sth->fetchAll();
        return $msa;
    }

    /**
     * 获取电影集中电影数量
     */
    public static function getSetCount($pdo, $id) {
        $count = 0;
        $sql = "SELECT COUNT(*) FROM movie WHERE idSet = :id";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $a = $sth->fetchAll();
        $count = $a[0];
        return $count;
    }

    /**
     * 获取电影集中电影列表
     */
    public static function getSet($pdo, $start=0, $page_count=0, $id) {
        $movie = array();
        $sql = "SELECT idMovie, c00 AS `name`, c08 AS poster, IF('index.bdmv'=strFileName, LEFT(strPath, (LENGTH(strPath) - 5)), CONCAT(strPath, strFileName)) AS path, premiered FROM movie_view WHERE idSet=:id ORDER BY premiered LIMIT ".$start.", ".$page_count;
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $movie = $sth->fetchAll();
        return $movie;
    }

    /**
     * 获取剧集数量
     */
    public static function getTVShowCount($pdo) {
        $count = 0;
        $sql = "SELECT COUNT(*) FROM tvshow_view";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $a = $sth->fetchAll();
        $count = $a[0];
        return $count;
    }

    /**
     * 获取电视剧列表
     */
    public static function getTVShow($pdo, $start=0, $page_count=0) {
        $show = array();
        $sql = "SELECT idShow, c00 AS `name`, totalSeasons, c06 AS poster, c05 AS premiered FROM tvshow_view ORDER BY c05 DESC LIMIT ".$start.", ".$page_count;
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $show = $sth->fetchAll();
        return $show;
    }

    /**
     * 获取剧集详细信息
     */
    public static function getTVShowInfo($pdo, $id) {
        $sf = array();
        $sql = "SELECT idShow, c00 AS `name`, c01 AS synopsis, c06 AS poster, c05 AS premiered, c08 AS `type`, c11 AS backdrop, c14 AS company, strPath AS `path`, totalCount, totalSeasons, rating, IF('tmdb'=uniqueid_type, uniqueid_value, '') AS uniqueid_value FROM tvshow_view WHERE idShow = :id";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $sf = $sth->fetchAll();
        return $sf;
    }

    /**
     * 获取电视剧季列表
     */
    public static function getSeason($pdo, $show_id) {
        $season = array();
        $sql = "SELECT idSeason, season, aired FROM season_view WHERE idShow = :show_id ORDER BY season";
        $param = array(":show_id"=>$show_id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $season = $sth->fetchAll();
        return $season;
    }

    /**
     * 获取电视剧集信息
     */
    public static function getEpisode($pdo, $id, $has_season=1) {
        $episode = array();
        $id_type = $has_season?'idSeason':'idShow';
        $sql = "SELECT idEpisode, c00 AS `name`, c01 AS synopsis, CONCAT(strPath, strFileName) AS path, c05 AS premiered, c13 FROM episode_view WHERE ";
        $sql += $id_type + " = :id ORDER BY CONVERT(c13, SIGNED)";
        $param = array(":id"=>$id);
        $sth = $pdo->prepare($sql);
        $sth->execute($param);
        $episode = $sth->fetchAll();
        return $episode;
    }
}
?>