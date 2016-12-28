<?php
/**
 * Twitter API SEARCH
 * Selim Hallaç
 * selimhallac@gmail.com
 */

//https://dev.twitter.com/rest/reference/get/search/tweets
//https://mods.me/
//https://github.com/techdeewa/thsplitlib

include "twitteroauth.php";
include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'THSplitLib/segment.php');

$consumer_key = "pfIvJnT5DOhCsaHUWUy51Aoa4";
$consumer_secret = "CFPK5eLYOwVKnA4WrODtwPolNxb46OiuyYKCLez0bqIBL2Hrdq";
$access_token = "4364745913-X7KqrHZzwqHyAOMS6u41k0OgghJkeUJlDBcYNM0";
$access_token_secret = "LsCT8obowyooAUBtL2DIz2UtnX3Uv1jPYGw3Qqb4WQfIo";

//%40 = @
//%23 = #
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Twitter API SEARCH</title>
</head>
<body>
<form action="" method="post">
  <label>Search : <input type="text" name="keyword" value="<?=$_POST["keyword"]?>"/></label>
  <br/>
  <?= urlencode($_POST["keyword"]);?>
  <hr/>
</form>
<?php

if (isset($_POST["keyword"])){

  //var_dump($tweets);
  $twitter = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
  $tweets = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q='.urlencode($_POST["keyword"]).'&result_type=recent&count=50');
?>
    <?php foreach ($tweets->statuses as $key => $tweet) { ?>
        <img src="<?=$tweet->user->profile_image_url;?>" /><br/>
        <?=$tweet->user->name;?>(@<?=$tweet->user->screen_name;?>)<br>
        <?=$tweet->text; ?><br>
        <!--<?=$tweet->text; ?><br> -->

        ====>Split: <?php
          $segment = new Segment();
          $result = $segment->get_segment_array($tweet->text);
          echo implode('|', $result);
        ?><br>
        <hr/>
    <?php } ?>
<?php } ?>

</body>
</html>
