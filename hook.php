<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'nyOBAZu5wApfSs1OKyNJeZAn3XoH+2P32+Eb2tnwjzc1cxUeuj8xXhTNR4LjioHaN0hQ2ruxInP5+A+/USUgtip4uakzkcyczJFPl5FV+ZYWP9SzzrNNp2r6n19wiVpEL03JRvr4cn4Vtw+DY59oxQdB04t89/1O/w1cDnyilFU=';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$row = 0;
$iteml=array();
$item2=array();
$objCSV = fopen("production.csv", "r");
$search = '32';
if (($handle = fopen("production.csv", "r")) !== FALSE) {
  $row=0;
  $csv_row = array();
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    if ($data[2] == $search) {
      $csv_row[] = $data;
    }
  }
  fclose($handle);
  foreach ($csv_row as $row) {
    echo $row[3] . "<br />"; //type
    echo $row[4] . "<br />"; //description
    echo $row[5] . "<br />"; //frequency
    echo "<hr /><br />";
  }
}  
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
 
    while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
      $num = count($objArr);
      $item1[$row]=$objArr[0];
      $item2[$row]=$objArr[6];
      if(in_array($text,$item1)){
        $key = array_search($text,$item1);
        $reply_message='ค่างวดของคุณคือ ('.$objArr[$key].') บาท('.$row.')';
      }
      else
      $reply_message = 'กรุณากรอกรหัสสมาชิกของคุณ';
     // $reply_message = 'ระบบได้รับข้อความ ('.$text.') ของคุณแล้ว ('.$event['source']['userId'].')';
      $row++;
   }

  fclose($objCSV);   }
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
echo $key;
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