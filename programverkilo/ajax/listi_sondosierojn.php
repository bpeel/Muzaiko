<?php

include_once('../lib/funkcioj.php');

if (empty($_REQUEST['kiujn'])) {
  printf('Mankas parametro "kiujn".');
  exit();
}

$kiujn = $_REQUEST['kiujn'];

if ($kiujn != 'uzitajn' && $kiujn != 'neuzitajn') {
  printf('Parametro "kiujn" devas esti "uzitajn" aux "neuzitajn".');
  exit();
}

if ($kiujn == 'uzitajn' && empty($_REQUEST['programero_id'])) {
  printf('Parametro "programero_id" mankas.');
  exit();
}

$programero_id = $_REQUEST['programero_id'];

$dosieroj = (($kiujn == 'uzitajn') ? get_files_for_program($programero_id) : get_unused_files());

foreach ($dosieroj as $dosiero)
  print("<option>" . htmlentities($dosiero) . "</option>\n");

?>
