<?php
$access_token = '9nrLlQp7Hd55PKTI20j0A/StX1fbO8MWQblh2Jf0dNc+uN7AjvI13IAjnTgGgfPPn2DGKE2lPTfvw2odlJBa/MQYZyDE7Mu1U0xbHUGFyru6n3AcOogiLlCeKOIKk3UQr83A9odZMo+N0eKf8/2migdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken

			$userId = $event['source']['userId'];
			
			$replyToken = $event['replyToken'];

			$answer = 'ตอบกลับ : ' . $text . ' from ' . $userId . chr(13). chr(10);
			
			
			$file_handle = fopen("mutualfund.csv", "r");
			while (!feof($file_handle) ) {
			$line_of_text = fgetcsv($file_handle, 874);
			  if ($text == $line_of_text[3] )
			  {
			    $answer .=  "FUND : " . $line_of_text[0] . chr(13). chr(10);
			    $answer .= "NAME : " . $line_of_text[2] . chr(13). chr(10);
			    $answer .= "CODE : " . $line_of_text[3] . chr(13). chr(10);
			    $answer .= "ASSET : " . $line_of_text[4] . chr(13). chr(10);
			    $answer .= "NAV  " . $line_of_text[5] . chr(13). chr(10);
			    $answer .= "======================================================================" . chr(13). chr(10);  
			  }
			}
			fclose($file_handle);
			
			
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $answer
			];


			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";

php?>
