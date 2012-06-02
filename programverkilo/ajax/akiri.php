<?php

require_once('../lib/sql_petoj.php');
require_once('../lib/funkcioj.php');

konektigxi_al_datumbazo();

if (empty($_REQUEST['tabelo']) || empty($_REQUEST['kolumno'])
      || empty($_REQUEST['horizontalo'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => "Mankas parametroj"));
  exit();
}

$tabelo = $_REQUEST['tabelo'];
$kolumno = $_REQUEST['kolumno'];
$horizontalo = $_REQUEST['horizontalo'];

try {
  $sql_peto = sql_akiri($tabelo, $kolumno, $horizontalo);
  $datumoj = peti_datumbazon($sql_peto);
} catch (Exception $e) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

$horizontalo = mysql_fetch_row($datumoj);
$rezultato = $horizontalo[0];

malkonektigxi_de_datumbazo();

print $rezultato;

?>
