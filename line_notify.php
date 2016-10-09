<?php
date_default_timezone_set('UTC');

define('ACCESS_TOKEN', 'アクセストークンを指定');

function sendNotify($msg = '...') {
    $notify_url = 'https://notify-api.line.me/api/notify';
    return exec("curl " . $notify_url . " -H 'Authorization: Bearer " . ACCESS_TOKEN . "' -d 'message=" . $msg . "'");
}

function getSunData() {

    $generateURL = function() {
        $sun_url = 'http://labs.bitmeister.jp/ohakon/api/?mode=sun_moon_rise_set';

        // 任意の座標を指定
        $lat = '35.8554';
        $lng = '139.6512';
    
        $url = $sun_url
            . '&year='. date('Y')
            . '&month=' . date('m')
            . '&day=' . date('d')
            . '&lat=' . $lat
            . '&lng=' . $lng;
        return $url;
    };

    $rs = simplexml_load_file($generateURL());

    if($rs) return $rs;
    else return false;
}

function getWeatherData() {
    // お住まいの地域のYahoo天気RSSのURL
    $weatherURL = 'http://rss.weather.yahoo.co.jp/rss/days/3310.xml';
    $rs = simplexml_load_file($weatherURL);
    if($rs) return $rs;
    else return false;
}

$sunData = getSunData();
$weatherData = getWeatherData();
$msg;

if($sunData && $weatherData) {
    
    $msg = '【' . date('Y年m月d日(D)') . '岩手県内陸の天気】　　　　　' .  //適宜変更
        $weatherData->channel->item->description . ',　　　　　　' .
        '日出時刻:' . $sunData->rise_and_set->sunrise_hm . ',　　　　　　　　' .
        '日没時刻:' . $sunData->rise_and_set->sunset_hm;

} else {
    $msg = '天気情報を取得中にエラーが発生しました。';
}

var_dump(sendNotify($msg));