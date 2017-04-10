<?php
date_default_timezone_set('UTC');

require_once './config.php';
require_once './functions.php';

$sunData = getSunData();
$weatherData = getWeatherData();
$msg;

if($sunData && $weatherData) {

  // 適宜修正
  $msg = PHP_EOL
    . '岩手県内陸の天気' . PHP_EOL . PHP_EOL
    . '【' . date('Y年m月d日(D)') . '】' . PHP_EOL
    . $weatherData->channel->item->description . PHP_EOL
    . '日出時刻:' . $sunData->rise_and_set->sunrise_hm . PHP_EOL
    . '日没時刻:' . $sunData->rise_and_set->sunset_hm . PHP_EOL . PHP_EOL
    . '【' . date('Y年m月d日(D)', strtotime('+1 day')) . '】' . PHP_EOL
    . $weatherData->channel->item[2]->description . PHP_EOL;

} else {
    $msg = '天気情報を取得中にエラーが発生しました。';
}


var_dump(sendNotify($msg));
