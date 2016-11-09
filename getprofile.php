<?php
$access_token = '9nrLlQp7Hd55PKTI20j0A/StX1fbO8MWQblh2Jf0dNc+uN7AjvI13IAjnTgGgfPPn2DGKE2lPTfvw2odlJBa/MQYZyDE7Mu1U0xbHUGFyru6n3AcOogiLlCeKOIKk3UQr83A9odZMo+N0eKf8/2migdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v2/bot/profile/Ufe79d34680fcd7c2cf50f61c797c3931';


$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);



        $ch = curl_init();        
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch);       
        curl_close($ch);
        echo $output;
?>
