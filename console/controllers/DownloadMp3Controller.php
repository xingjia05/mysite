<?php

namespace console\controllers;

use yii\console\Controller;

class DownloadMp3Controller extends Controller {

    public function actionUrl() {
//        $listUrl = 'http://www.liaoliaoy.com/listenbook/disk/audio/20170517/185152cd7rjmin.mp3';
        $listUrl = 'http://www.liaoliaoy.com/listenbook/apis/audio_list.php?page=4&pagesize=20&room_id=497&user_id=22116';
        $listPage = file_get_contents($listUrl);
        $listPage = json_decode($listPage, TRUE);
        foreach ($listPage['result'] as $link) {
            $url = 'http://www.liaoliaoy.com/listenbook/disk/audio/' . $link['audio_path'];
//            $this->getFile($url);
            echo "download {$link['audio_name']} : {$url} done.\n";
        }
    }

    function getFile($url) {
        $fileName = '/data/audio/mwhg/' . substr($url, strrpos($url, '/') + 1);
        $fileSize = @filesize($url);
        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Transfer-Encoding: binary");
        header("Content-Type:audio/mpeg MP3");
        header("Content-Length: " . $fileSize);
        header("Content-Disposition: attachment; filename=" . $fileName);
        $file = file_get_contents($url);
        $fp = fopen($fileName, 'w');
        fwrite($fp, $file);
        fclose($fp);
    }
    
    public function actionIndex() {
//        $listUrl = 'http://www.liaoliaoy.com/listenbook/disk/audio/20170517/185152cd7rjmin.mp3';
        $listUrl = 'http://www.liaoliaoy.com/listenbook/apis/audio_list.php?page=4&pagesize=20&room_id=497&user_id=22116';
        $listPage = file_get_contents($listUrl);
        $listPattern = '/<div id="primarycontent">.*<div class="footer">/is';
        preg_match($listPattern, $listPage, $page);
        $listPage = $page[0];
        unset($page);
        $listLinks = explode('<a href="', $listPage);
        unset($listLinks[0]);
        foreach ($listLinks as $k => $link) {
            $link = substr($link, 0, strpos($link, '">'));
            $detalPage = file_get_contents($link);
            $pattern = '/<embed src=".*" mce_src=".*" width="380"/is';
            preg_match($pattern, $detalPage, $urls);

            $url = str_replace('<embed src="', 'http://www.englishmorning.com/', $urls[0]);
            $url = str_replace('" mce_src="', 'http://www.englishmorning.com/', $urls[0]);
            $url = str_replace('" width="380"', '', $url);
            unset($urls);
            $listLinks[$k] = $url;
        }
        foreach ($listLinks as $url) {
            getFile($url);
            echo "download {$url} done./n";
        }

        function getFile($url) {
            $fileName = substr($url, strrpos($url, '/') + 1);
            $fileSize = @filesize($url);
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Transfer-Encoding: binary");
            header("Content-Type:audio/mpeg MP3");
            header("Content-Length: " . $fileSize);
            header("Content-Disposition: attachment; filename=" . $fileName);
            $file = file_get_contents($url);
            $fp = fopen($fileName, 'w');
            fwrite($fp, $file);
            fclose($fp);
        }

    }
}
