<?php




    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }

    // Defining the basic cURL function
    function curl($url) {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
        );

        $ch = curl_init();  // Initialising cURL
        curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }


    $server = "us-cdbr-iron-east-04.cleardb.net";
    $username = "b9edbb1bdd8a6b";
    $password = "379ac343";
    $db = "heroku_08be9207ed67154";

    $conn = new mysqli($server, $username, $password, $db);
    $conn->query("SET NAMES 'utf8'");

    /* check connection */
    if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $conn1->connect_error);
        exit();
    }


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

			/*

			        GETNAME by $userId

			*/

			$url = 'https://api.line.me/v2/bot/profile/'. $userId ;

			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
				$ch = curl_init();
				//curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$output = curl_exec($ch);
				curl_close($ch);
				//echo $output;
				//var_dump($output);
			 $profile = json_decode($output, true);
			//echo "DisplayName : " . $profile['displayName'];

			$userName = $profile['displayName'];

			if ($text == "ข่าวหุ้น")
			{

				$scraped_page = curl("http://www.kaohoon.com/online/content/category/9/Breaking-News");    // Downloading IMDB home page to variable $scraped_page
				$scraped_data = scrape_between($scraped_page, "<h1>Breaking News</h1>", "<strong>1</strong>");   // Scraping downloaded dara in $scraped_page for content between <title> and </title> tags

				$newsresult = explode("<hr />",$scraped_data);

				$result = "";

				for ($x = 1; $x <= 5; $x++) {

				    $contentres = str_replace("<p>","<h>",str_replace("h3","h",str_replace("h5","h",$newsresult[$x])));

				    $contentresd = explode("<h>",$contentres);

				    //split link & topic
				    $contentresdsplit = explode(">",str_replace("</h>","",$contentresd[1]));
				    //echo "NEWS : " . $x . "</BR>";
				    //echo "header : ". str_replace("</a","",$contentresdsplit[1]) . "</BR>";
				    //echo "date : " . $contentresd[2] . "</BR>";
				    //echo "link : " . str_replace("<a href=","",str_replace('"','',$contentresdsplit[0])) . "</BR>";
				    //echo "==================================" . "</BR>";

				    $result .= "NEWS : " . $x  . chr(13). chr(10);
				    $result .= "header : ". str_replace("</a","",$contentresdsplit[1])  . chr(13). chr(10);
				    $result .= "date : " . $contentresd[2]  . chr(13). chr(10);
				    $result .= "link : " . str_replace("<a href=","",str_replace('"','',$contentresdsplit[0]))  . chr(13). chr(10);
				    $result .= "=================================="  . chr(13). chr(10);

				}

				//echo $result;
				$ansfund = $result;
			}
			else if ($text == "สรุปตลาดหุ้น")
			{
				$scraped_page = curl("http://techdeewa.herokuapp.com/loadstocksummary.php");
				$ansfund = $scraped_page;
			}
			else if ($text == "ราคาทองคำ")
			{
				$scraped_page = curl("http://techdeewa.herokuapp.com/loadgoldsummary.php");
				$ansfund = $scraped_page;

			}
			else if ($text == "ราคาน้ำมันดิบ")
			{

				$scraped_page = curl("http://techdeewa.herokuapp.com/loadoilsummary.php");
				$ansfund = $scraped_page;


			}
			else if ($text == "อัตราแลกเปลี่ยน")
			{


				$scraped_page = curl("http://techdeewa.herokuapp.com/loadexratesummary.php");
				$ansfund = $scraped_page;

			}
			else
			{

				$ansfund = '';

				$file_handle = fopen("mutualfund.csv", "r");
				while (!feof($file_handle) ) {
				$line_of_text = fgetcsv($file_handle, 874);
				  if (strtoupper($text) == strtoupper($line_of_text[3]) )
				  {
				    $ansfund .=  "FUND : " . $line_of_text[0] . chr(13). chr(10);
				    $ansfund .= "NAME : " . $line_of_text[2] . chr(13). chr(10);
				    $ansfund .= "CODE : " . $line_of_text[3] . chr(13). chr(10);
				    $ansfund .= "ASSET : " . $line_of_text[4] . chr(13). chr(10);
				    $ansfund .= "NAV  " . $line_of_text[5] . chr(13). chr(10);
				    $ansfund .= "================================" . chr(13). chr(10);
				  }
				}
				fclose($file_handle);

				if ($ansfund == ''){

					//$ansfund = "ไม่พบกองทุนที่ท่านค้นหา กรุณาลองใหม่อีกครั้ง". chr(13). chr(10);
					//$ansfund .= "ข่าวสารวงการหุ้น". chr(13). chr(10);
					//$ansfund .= "http://www.kaohoon.com/online/content/category/9/Breaking-News";
					$ansfund = "ไม่พบข้อมูลที่ท่านค้นหา กรุณาลองใหม่อีกครั้ง". chr(13). chr(10);
					$ansfund .= "keyword แนะนำ". chr(13). chr(10);
					$ansfund .= "ข่าวหุ้่น". chr(13). chr(10);
					$ansfund .= "สรุปตลาดหุ้น". chr(13). chr(10);
					$ansfund .= "ราคาทองคำ". chr(13). chr(10);
					$ansfund .= "ราคาน้ำมันดิบ". chr(13). chr(10);
					$ansfund .= "อัตราแลกเปลี่ยน". chr(13). chr(10);


          ////////////////////////////////////////////////////////////////////
      // logdb unknown



      /* Prepare an insert statement */
      $sqlstr = "INSERT INTO `heroku_08be9207ed67154`.`unknown_inputs` (`input`,`userid`,`username`,`timestamp`) ";
      $sqlstr .= "VALUES (?,?,?, now())";
      $stmt = $conn->prepare($sqlstr);


      $stmt->bind_param("sss", $val1, $val2, $val3);

      //log chat to DB
      $val1 = $text; // input
      $val2 = $userId; // userid
      $val3 = $userName; // username


          /* Execute the statement */
          $stmt->execute();
				}

			}
			//$answer = 'ตอบกลับ : ' . $text . ' from ' . $userId . chr(13). chr(10);
			$answer = 'ตอบกลับ : ' . $text . ' ของ ' . $userName . chr(13). chr(10);
			$answer .= $ansfund;

			if ($text == "ทดสอบ")
			{
//				$messages = array();

				/*
				$messages [0]["type"]= 'text';
				$messages [0]["text"]= 'answer1';

				$messages [1]["type"]= 'text';
				$messages [1]["text"]= 'answer2';
				*/
//				array_push($messages, array('type' => 'text', 'text' => 'answer1'));
//				array_push($messages, array('type' => 'text', 'text' => 'answer2'));

				$actions =  array();
				array_push($actions, array('type' => 'message', 'label' => 'Yes', 'text' => 'yes'));
				array_push($actions, array('type' => 'message', 'label' => 'No', 'text' => 'no'));

				/*
				$template = array();
				array_push($template, array('type' => 'confirm', 'text' => 'Are you sure?', 'actions' => $actions));
				*/

				$template = [
				  'type' => 'confirm',
				  'text' => 'Are you sure?',
				  'actions' => $actions
				  ];

				$confirm = [
				  'replyToken' => $replyToken,
				  'type' => 'template',
				  'alttext' => 'confirmation template',
				  'template' => $template
				];
				
			}
			else
			{
			
				$messages = array(); //Your array that you want to push the value into

				array_push($messages, array('type' => 'text', 'text' => $answer));
				
			/*
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $answer
				];
			*/	
			}
//////////////////////////////////////////////////////////////////////////////







          /* Prepare an insert statement */
          $sqlstr = "INSERT INTO `heroku_08be9207ed67154`.`chatbot` (`userid`,`messageid`,`username`,`messagetext`,`replytext`,`datetimeresponse`)";
          $sqlstr .= "VALUES(?,?,?,?,?,now())";
          $stmt = $conn->prepare($sqlstr);

          $stmt->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);

          //log chat to DB
          $val1 = $userId; // userid
          $val2 = ''; // messageid
          $val3 = $userName; // username
          $val4 = $text; // messagetext
          $val5 = $ansfund; //replytext

          /* Execute the statement */
          $stmt->execute();

          /* close statement */
          $stmt->close();

      $conn->close();


/////////////////////////////////////////////////////////////////////////////

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			
			/*
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			*/

				$data = [
					'replyToken' => $replyToken,
					'messages' => $confirm,
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
