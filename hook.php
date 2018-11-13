<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'nyOBAZu5wApfSs1OKyNJeZAn3XoH+2P32+Eb2tnwjzc1cxUeuj8xXhTNR4LjioHaN0hQ2ruxInP5+A+/USUgtip4uakzkcyczJFPl5FV+ZYWP9SzzrNNp2r6n19wiVpEL03JRvr4cn4Vtw+DY59oxQdB04t89/1O/w1cDnyilFU=';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
$row = 1;
$objCSV = fopen("production.csv", "r");
while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
    $num = count($data);
   echo $objArr[0]."".$objArr[1]."".$objArr[2]."".$objArr[3]."".$objArr[4]."".$objArr[5]."".$objArr[6]."</br>";
    $row++;
 }
fclose($objCSV);
echo $num;
if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
    if($text=='1001'){
      $reply_message='ค่างวดของคุณคือ 3,500 บาท';
    }
    else
    $reply_message = 'กรุณากรอกรหัสสมาชิกของคุณ';
   // $reply_message = 'ระบบได้รับข้อความ ('.$text.') ของคุณแล้ว ('.$event['source']['userId'].')';
   }
   else
    $reply_message = 'กรุณากรอกรหัสสมาชิกของคุณ';
  
  }
  else
   $reply_message = 'ระบบได้รับข้อความ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";
echo $reply_message;

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>