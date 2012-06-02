<?php

require_once('../lib/sql_petoj.php');
require_once('../lib/funkcioj.php');

if (empty($_REQUEST['tabelo']) || empty($_REQUEST['id'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => 'Mankas parametroj'));
  exit();
}

$tabelo = $_REQUEST['tabelo'];
$id = $_REQUEST['id'];

konektigxi_al_datumbazo();

try {
  $sql_peto = sql_forvisxi($tabelo, $id);
  peti_datumbazon($sql_peto);
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

malkonektigxi_de_datumbazo();

header('Content-type: application/json');
print json_encode(array('rezulto' => 'sukceso'));

?>
