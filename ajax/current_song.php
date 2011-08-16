<?php
$url = 'http://api.radionomy.com/currentsong.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181&type=xml';
$xml = simplexml_load_file($url);

if (empty($xml->track->artists)) {
  echo $xml->track->title;
}
else {
  echo $xml->track->artists . " - " . $xml->track->title;
  echo '</br><a target="_blank" href="http://vinilkosmo.com">Aĉetu fizikan albumon</a> aŭ <a target="_blank" href="http://vinilkosmo-mp3.com">elŝutu MP3</a>';
}

?>
