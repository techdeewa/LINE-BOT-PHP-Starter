<?

/*
curl -X POST \
-H 'Content-Type:application/json' \
-H 'Authorization: Bearer {ENTER_ACCESS_TOKEN}' \
-d '{
    "to": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "messages":[
        {
            "type":"text",
            "text":"Hello, world1"
        },
        {
            "type":"text",
            "text":"Hello, world2"
        }
    ]
}' https://api.line.me/v2/bot/message/push
*/

$messages = [
  'type' => 'text',
  'text' => 'hello world'
];

$data = [
  'to' => 'Ufe79d34680fcd7c2cf50f61c797c3931',
  'messages' => $messages,
];


$access_token = '9nrLlQp7Hd55PKTI20j0A/StX1fbO8MWQblh2Jf0dNc+uN7AjvI13IAjnTgGgfPPn2DGKE2lPTfvw2odlJBa/MQYZyDE7Mu1U0xbHUGFyru6n3AcOogiLlCeKOIKk3UQr83A9odZMo+N0eKf8/2migdB04t89/1O/w1cDnyilFU=';

$post = json_encode($data);

$url = 'https://api.line.me/v2/bot/message/push';

$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

?>
