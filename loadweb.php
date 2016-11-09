<?php

//header("content-type:application/json");

    // Defining the basic scraping function
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


        $scraped_page = curl("http://www.kaohoon.com/online/content/category/9/Breaking-News");    // Downloading IMDB home page to variable $scraped_page
        $scraped_data = scrape_between($scraped_page, "<h1>Breaking News</h1>", "<strong>1</strong>");   // Scraping downloaded dara in $scraped_page for content between <title> and </title> tags

        $newsresult = explode("<hr />",$scraped_data);
        //$result = json_encode($result);

        //echo $scraped_data; // Echoing $scraped data, should show "The Internet Movie Database (IMDb)"

        //echo $scraped_data;


        //var_dump($result);

        //echo $result[1];

        //$resd = str_replace("p","h",str_replace("h3","h",str_replace("h5","h",$result[1])));

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

            $result .= "NEWS : " . $x . "</BR>";
            $result .= "header : ". str_replace("</a","",$contentresdsplit[1]) . "</BR>";
            $result .= "date : " . $contentresd[2] . "</BR>";
            $result .= "link : " . str_replace("<a href=","",str_replace('"','',$contentresdsplit[0])) . "</BR>";
            $result .= "==================================" . "</BR>";

        }



        echo $result;

        //var_dump($resd1);

        //$result = "";

?>
