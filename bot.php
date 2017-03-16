<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/config.php";
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($longToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
// print_r($bot);
$json = file_get_contents("php://input");
$file = fopen("/log/log.json","a+");
fwrite($file,$json."\n");
fclose($file);


// $signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
// try {
//   $events = $bot->parseEventRequest($json, $signature);
// } catch (Exception $e) {
//   var_dump($e); //錯誤內容
// }
