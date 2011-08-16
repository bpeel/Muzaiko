<?php
$url = 'http://api.radionomy.com/currentsong.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181&type=xml';
$xml = simplexml_load_file($url);

// include('inc/utils.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');

// echo cxapeligu('cx gx hx jx sx ux Cx Gx Hx Jx Sx Ux</br>');

if (empty($xml->track->artists)) {
  echo $xml->track->title;
}
else {
  if (!empty($xml->track->artists) && !empty($xml->track->title)) {
    echo $xml->track->artists . " - " . $xml->track->title;

    include('/etc/datumbazensalutiloj.php');

    $artists = $xml->track->artists;
    $title = $xml->track->title;

    mysql_connect($servilo,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");

    $query="SELECT Ligoj_al_diskoservo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VKK%' AND Ligoj_al_diskoservo!='0'";
    $result=mysql_query($query);
    $ligilo_vk = mysql_fetch_row($result);
    $ligilo_vk = $ligilo_vk[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.

    $query="SELECT Ligoj_al_la_elsxutejo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VKK%' AND Ligoj_al_la_elsxutejo!='0'";
    $result=mysql_query($query);
    $ligilo_vk_mp3 = mysql_fetch_row($result);
    $ligilo_vk_mp3 = $ligilo_vk_mp3[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.

    mysql_close();

    if (empty($ligilo_vk)) {
      $ligilo_vk = 'http://vinilkosmo.com';
    }
    if (empty($ligilo_vk_mp3)) {
      $ligilo_vk_mp3 = 'http://vinilkosmo-mp3.com';
    }

    echo '</br><a target="_blank" href="' . $ligilo_vk . '">Fizikan albumon</a> - <a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>';
  }
}
?>
