<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/config1.php";
// use LINE\LINEBot;
// use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;
// use LINE\LINEBot\Message\MultipleMessages;
// use LINE\LINEBot\Message\RichMessage\Markup;
// echo $channelID;
// die();
// $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($longToken);
// $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
// // print_r($bot);
// $json = file_get_contents("php://input");
// $file = fopen("/log/log.json","a+");
// fwrite($file,$json."\n");
// fclose($file);

$json_string = file_get_contents('php://input');

$file = fopen(__DIR__."/log/log.json", "a+");
fwrite($file, $json_string."\n");
$json_obj = json_decode($json_string);

$event = $json_obj->{"events"}[0];
$type  = $event->{"message"}->{"type"};
$message = $event->{"message"};
$reply_token = $event->{"replyToken"};

$post_data = [
  "replyToken" => $reply_token,
  "messages" => [
    [
      "type" => "text",
      "text" => $message->{"text"}
    ]
  ]
];
fwrite($file, json_encode($post_data)."\n");

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$longToken
    //'Authorization: Bearer '. TOKEN
));
$result = curl_exec($ch);
fwrite($file, $result."\n");
fclose($file);
curl_close($ch);


// $signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
// try {
//   $events = $bot->parseEventRequest($json, $signature);
// } catch (Exception $e) {
//   var_dump($e); //錯誤內容
// }
