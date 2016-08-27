<?php
  $kp = file_get_contents("kp.json");
  $kp = json_decode($kp, true);
  $random = mt_rand(1, count($kp) - 1);

  $movie = 'Гослинг рекомендует вам посмотреть <a href="https://www.kinopoisk.ru'.$kp[$random][link].'">';
  if ($kp[$random][name]) {
    $movie .= $kp[$random][name];
  }
  if ($kp[$random][name] && $kp[$random][e_name]) {
    $movie .= ' / ';
  }
  if ($kp[$random][e_name]) {
    $movie .= $kp[$random][e_name];
  }
  $movie .= '</a> на '.$random.' месте с рейтингом '.round($kp[$random][evaluation], 1);

?>
