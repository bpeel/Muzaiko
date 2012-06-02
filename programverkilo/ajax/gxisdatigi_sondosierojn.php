<?php

require_once('../lib/sql_petoj.php');
require_once('../lib/funkcioj.php');

if (!isset($_REQUEST['programero_id'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => 'Mankas la parametro "programero_id".'));
  exit();
}

$programero_id = $_REQUEST['programero_id'];

$dosieroj = $_REQUEST['sondosiero'];

konektigxi_al_datumbazo();

try {
  $sql_peto = sql_forvisxi_sondosierojn($programero_id);
  peti_datumbazon($sql_peto);
  if ($dosieroj && count($dosieroj) > 0) {
    $sql_peto = sql_aldoni_sondosierojn($programero_id, $dosieroj);
    peti_datumbazon($sql_peto);
    $sql_peto = sql_akiri_sondosierojn($programero_id);
    $datumoj = peti_datumbazon($sql_peto);
    $horizontalo = mysql_fetch_row($datumoj);
    $sondosieroj = '<ul class="sondosieroj">'.$horizontalo[0].'</ul>';
  } else {
    $sondosieroj = '<ul class="sondosieroj"></ul>';
  }
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

malkonektigxi_de_datumbazo();

header('Content-type: application/json');
print json_encode(array('rezulto' => 'sukceso', 'sondosieroj' => $sondosieroj));

?>
