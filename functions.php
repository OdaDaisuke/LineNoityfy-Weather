<?php
function sendNotify($msg = '...') {
    $msg = h($msg);
    return exec("curl " . APIURL_LINE_NOTIFY . " -H 'Authorization: Bearer " . ACCESS_TOKEN . "' -d 'message=" . $msg . "'");
}

/*
 * 日の出、日の入り情報を取得
 */
function getSunData() {

    $generateURL = function() {

        $url = APIURL_SUN_INFO
            . '&year='. date('Y')
            . '&month=' . date('m')
            . '&day=' . date('d')
            . '&lat=' . LATITUDE
            . '&lng=' . LONGITUDE;
        return $url;

    };

    $rs = simplexml_load_file($generateURL());

    if($rs) return $rs;
    else return false;
}

/*
 * 天気を取得
 */
function getWeatherData() {
    // お住まいの地域のYahoo天気RSSのURL
    $weatherURL = 'http://rss.weather.yahoo.co.jp/rss/days/3310.xml';
    $rs = simplexml_load_file($weatherURL);

    if($rs) return $rs;
    else return false;
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES);
}
