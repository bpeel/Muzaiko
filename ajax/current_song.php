<?php
$url = 'http://api.radionomy.com/currentsong.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181&type=xml';
$xml = simplexml_load_file($url);

if (empty($xml->track->artists)) {
  echo $xml->track->title;
}
else {
  if (!empty($xml->track->artists) && !empty($xml->track->title)) {
    echo $xml->track->artists . " - " . $xml->track->title;

    $ligilo_vk = 'http://vinilkosmo.com';
    $ligilo_vk_mp3 = 'http://vinilkosmo-mp3.com';

//     if (!empty($ligilo_vk)) {
//       $ligilcxeno .= $ligilo_vk;
//     }
//     if (!empty($ligilo_vk_mp3)) {
//     }

    echo '</br><a target="_blank" href="' . $ligilo_vk . '">Fizikan albumon</a> - <a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>';
  }
}

$username="vk_uzanto";
$password="vinilkosmo_pasvorto";
$database="vinilkosmo";
$table="vinilkosmo_tabelo";

$artists='La testo';

mysql_connect('127.0.0.1:3306',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM $table";

$query="SELECT Ligoj_al_diskoservo FROM $table WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$artists'";
$query2="SELECT Ligoj_al_la_elsxutejo FROM $table WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$artists'";

$result=mysql_query($query);
$users_name = mysql_fetch_row($result);
$users_name = $users_name[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.

echo '</br>';
echo $users_name;

$result2=mysql_query($query2);
$users_name2 = mysql_fetch_row($result2);
$users_name2 = $users_name2[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.

echo '</br>';
echo $users_name2;

$query="select Ligoj_al_la_elsxutejo from vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='Amu min' AND Artistoj='JhomArt & Natasha' AND REF NOT LIKE 'VKK%' AND Ligoj_al_la_elsxutejo!='0'";
$result=mysql_query($query);
$users_name = mysql_fetch_row($result);
$users_name = $users_name[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
echo '</br>';
echo $users_name;

$query="select Ligoj_al_la_elsxutejo from vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='Amu min' AND Artistoj='JhomArt & Natasha' AND REF NOT LIKE 'VKK%'";
$result=mysql_query($query);
$users_name = mysql_fetch_row($result);
$users_name = $users_name[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
echo '</br>';
echo $users_name;

$query="select Ligoj_al_la_elsxutejo from vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='Amu min' AND Artistoj='JhomArt & Nathjhkjhasha' AND REF NOT LIKE 'VKK%'";
$result=mysql_query($query);
$users_name = mysql_fetch_row($result);
$users_name = $users_name[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
echo '</br>';
echo $users_name;

mysql_close();

?>
