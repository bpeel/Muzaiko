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

    $artists = trim(addslashes(malcxapeligu($xml->track->artists)));
    $title = trim(addslashes(malcxapeligu($xml->track->title)));

    mysql_connect($servilo,$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");

    $ligilo_vk='';
    $ligilo_vk_mp3='';

    $query_vk="SELECT Ligoj_al_diskoservo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VKK%' AND Ligoj_al_diskoservo!='0'";
    $result=mysql_query($query_vk);
    if($result)
    {
      $ligilo_vk = mysql_fetch_row($result);
      $ligilo_vk = $ligilo_vk[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    }

    $query_vk_mp3="SELECT Ligoj_al_la_elsxutejo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VKK%' AND Ligoj_al_la_elsxutejo!='0'";
    $result=mysql_query($query_vk_mp3);
    if($result)
    {
      $ligilo_vk_mp3 = mysql_fetch_row($result);
      $ligilo_vk_mp3 = $ligilo_vk_mp3[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    }

    mysql_close();

    if (empty($ligilo_vk)) {
      $ligilo_vk = 'http://vinilkosmo.com';
      $myFile = "nekonata.log";
      $fh = fopen($myFile, 'a') or die("can't open file");
      fwrite($fh, "== ligilo_vk ne trovata ==\n");
      fwrite($fh, $xml->track->artists . " - " . $xml->track->title . "\n");
      fwrite($fh, $query_vk . ";\n");
      fclose($fh);
    }
    if (empty($ligilo_vk_mp3)) {
      $ligilo_vk_mp3 = 'http://vinilkosmo-mp3.com';
      $myFile = "nekonata.log";
      $fh = fopen($myFile, 'a') or die("can't open file");
      fwrite($fh, "== ligilo_vk_mp3 ne trovata ==\n");
      fwrite($fh, $xml->track->artists . " - " . $xml->track->title . "\n");
      fwrite($fh, $query_vk_mp3 . ";\n");
      fclose($fh);
    }

    echo '</br><a target="_blank" href="' . $ligilo_vk . '">Fizika albumo</a> - <a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>';
  }
}
?>
