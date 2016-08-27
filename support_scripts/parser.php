<?php

header("Content-Type: text/html; charset=utf-8");
echo phpversion();

include('simple_html_dom.php');

$html = file_get_html('https://www.kinopoisk.ru/top/');

$kp = array();
for ($i=1; $i < 252; $i++) {

  foreach($html->find('#top250_place_'.$i) as $e) {
    $move = array();

    foreach($e->find('.all') as $a) {
      $name = $a->plaintext;
      $move[name] = mb_convert_encoding($name, 'utf-8', "windows-1251");
      $move[link] = $a->href;

    }

    foreach($e->find('.text-grey') as $a) {
      $move[e_name] = $a->plaintext;

    }

    foreach($e->find('.continue') as $a) {
      $move[evaluation] = $a->plaintext;

    }
  }

  $kp[$i] = $move;
}
print_r($kp);
$kp_json = json_encode($kp);
file_put_contents("kp.json", $kp_json);
/*
echo "<br><br><br>";

$kp_str = file_get_contents("kp.json");
$kp_str = json_decode($kp_str, true);
print_r($kp_str);
*/
?>
