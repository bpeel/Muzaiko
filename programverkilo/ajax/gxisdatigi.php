<?php

require_once('../lib/sql_petoj.php');
include_once('../lib/funkcioj.php');

if (!isset($_REQUEST['tabelo']) || !isset($_REQUEST['kolumno'])
      || !isset($_REQUEST['valoro']) || !isset($_REQUEST['horizontalo'])
      || !isset($_REQUEST['tipo'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => "Mankas parametroj"));
  exit();
}

$tabelo = $_REQUEST['tabelo'];
$kolumno = $_REQUEST['kolumno'];
$valoro = $_REQUEST['valoro'];
$horizontalo = $_REQUEST['horizontalo'];
$tipo = $_REQUEST['tipo'];

konektigxi_al_datumbazo();

try {
  if ($tabelo == 'programero' && $kolumno == 'parolanto') {
    $sql_peto = sql_forvisxi_parolantojn($horizontalo);
    peti_datumbazon($sql_peto);
    if ($valoro && $valoro != 'null' && count($valoro) > 0) {
      $sql_peto = sql_aldoni_parolantojn($horizontalo, $valoro);
      peti_datumbazon($sql_peto);
    }
  } else {
    $sql_peto = sql_gxisdatigi($tabelo, $kolumno, $valoro, $horizontalo);
    peti_datumbazon($sql_peto);
  }
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => "valoro='$valoro' count='".count($valoro)."' $sql_peto ".$e->getMessage()));
  exit();
}

$rezultato = '';

switch ($tipo) {
  case 'listo':
    try {
      $sql_peto = sql_akiri_listelementon($kolumno, $valoro);
      $datumoj = peti_datumbazon($sql_peto);
      $horizontalo = mysql_fetch_row($datumoj);
      $rezultato = $horizontalo[0];
    } catch (Exception $e) {
      malkonektigxi_de_datumbazo();
      header('Content-type: application/json');
      print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $sql_peto.' '.$e->getMessage()));
      exit();
    }
    break;
  case 'multilisto':
    if ($valoro && $valoro != 'null' && count($valoro) > 0) {
      try {
        $sql_peto = sql_akiri_listelementojn($kolumno, $valoro);
        $datumoj = peti_datumbazon($sql_peto);
        $horizontalo = mysql_fetch_row($datumoj);
        $rezultato = $horizontalo[0];
      } catch (Exception $e) {
        malkonektigxi_de_datumbazo();
        header('Content-type: application/json');
        print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $sql_peto.' '.$e->getMessage()));
        exit();
      }
    } else {
      $rezultato = '';
    }
    break;
  case 'arangxita_teksto':
    $rezultato = format_programero($valoro);
    break;
  case 'teksto':
  default:
    $rezultato = $valoro;
    break;
}

if ($tabelo == 'programero' && $kolumno == 'permesilo') {
  try {
    $sql_peto = sql_legi_horizontalon($kolumno, $valoro);
    $datumoj = peti_datumbazon($sql_peto);
  } catch (Exception $e) {
    malkonektigxi_de_datumbazo();
    header('Content-type: application/json');
    print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $sql_peto.' '.$e->getMessage()));
    exit();
  }
  $horizontalo = mysql_fetch_assoc($datumoj);
  $rezultato = format_permesilo(
    $horizontalo['nomo'],
    $horizontalo['bildo']);
}

malkonektigxi_de_datumbazo();

header('Content-type: application/json');
print json_encode(array('rezulto' => 'sukceso', 'mesagxo' => $rezultato));

?>
