<?php
  $timestampLast = file_get_contents("timestamp");
  $xml = file_get_contents("https://www.kinopoisk.ru/trailer_new_film.rss");

  $trailers = new SimpleXMLElement($xml);

  $movies = $trailers->channel->item;
  $newTrailers = array();


  $timestampNew = strtotime($trailers->channel->item[0]->pubDate);

  if ($timestampLast != $timestampNew) {
    foreach ($movies as $key => $value) {
      $timestamp = strtotime($value->pubDate);
      if ($timestamp <= $timestampLast) {
        break;
      }
      $newTrailers[] = $value->link;
    }

    $newTrailers = array_reverse($newTrailers);

    $timestampLast = $timestampNew;

    file_put_contents('timestamp', $timestampLast);

    foreach ($newTrailers as $key => $value) {

      $trailersJson = array('message' => array('message_id' => '',
                                      'chat' => array('id' => '-1001068873763'),
                                      'text' => '/trailers',
                                      'link' => strval($value))
      );


      $url = 'http://goslingbot.herokuapp.com/robot.php';
      $handle = curl_init($url);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($handle, CURLOPT_TIMEOUT, 60);
      curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($trailersJson));
      curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
      curl_exec($handle);
      curl_close($handle);
    }
  }
echo "Work!";
?>
