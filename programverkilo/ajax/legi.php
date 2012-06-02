<?php

require_once('sql_petoj.php');
require_once('funkcioj.php');

if (empty($_REQUEST['tabelo'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => 'Mankas parametroj'));
  exit();
}

$tabelo = $_REQUEST['tabelo'];

konektigxi_al_datumbazo();

try {
  $sql_peto = sql_legi($tabelo);
  $datumoj = peti_datumbazon($sql_peto);
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

malkonektigxi_de_datumbazo();

$horizontaloj = array();
while ($horizontalo = mysql_fetch_assoc($datumoj)) {
  if ($tabelo == 'programero') {
    $horizontalo['skizo'] = format_programero($horizontalo['skizo']);
    $horizontalo['permesilo'] = format_permesilo($horizontalo['permesilo_nomo'],
                                                  $horizontalo['permesilo_bildo'],
                                                  $horizontalo['permesilo_url']);

  }
  $horizontaloj[] = $horizontalo;
}

header('Content-type: application/json');
print json_encode(array('aaData' => $horizontaloj));

?>
