<?php
require "vendor/autoload.php";
$access_token = 'nyOBAZu5wApfSs1OKyNJeZAn3XoH+2P32+Eb2tnwjzc1cxUeuj8xXhTNR4LjioHaN0hQ2ruxInP5+A+/USUgtip4uakzkcyczJFPl5FV+ZYWP9SzzrNNp2r6n19wiVpEL03JRvr4cn4Vtw+DY59oxQdB04t89/1O/w1cDnyilFU=';
$channelSecret = '4e8b5316e1cccc37441768b4b6a0076a';
$idPush = 'U7aa4b07453d2c0769a23376118879a75'
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($idPush, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();