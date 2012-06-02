<?php

require_once('../lib/sql_petoj.php');
require_once('../lib/funkcioj.php');

konektigxi_al_datumbazo();

$tabelo = $_REQUEST['tabelo'];

try {
  $sql_peto = sql_krei($_REQUEST);
  peti_datumbazon($sql_peto);
  $id = mysql_insert_id();
  if ($tabelo == 'programero' && !empty($_REQUEST['unua_elsendo_dato'])) {
    $sql_peto = sql_krei_elsendon($id,
                                  $_REQUEST['unua_elsendo_dato'],
                                  $_REQUEST['unua_elsendo_komenchoro'],
                                  $_REQUEST['unua_elsendo_finhoro']);
    peti_datumbazon($sql_peto);
  }
  if ($tabelo == 'programero' && !empty($_REQUEST['parolanto_id']) && count($_REQUEST['parolanto_id']) > 0) {
    $sql_peto = sql_aldoni_parolantojn($id, $_REQUEST['parolanto_id']);
    peti_datumbazon($sql_peto);
  }
  if ($tabelo == 'programero' && !empty($_REQUEST['sondosiero']) && count($_REQUEST['sondosiero']) > 0) {
    $sql_peto = sql_aldoni_sondosierojn($id, $_REQUEST['sondosiero']);
    peti_datumbazon($sql_peto);
  }
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $sql_peto . ' - ' . $e->getMessage()));
  exit();
}

try {
  $sql_peto = sql_legi_horizontalon($tabelo, $id);
  $datumoj = peti_datumbazon($sql_peto);
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

malkonektigxi_de_datumbazo();

$horizontalo = mysql_fetch_assoc($datumoj);

if ($tabelo == 'programero') {
    $horizontalo['skizo'] = format_programero($horizontalo['skizo']);
    $horizontalo['datoj'] = '<ol class="datoj">'.$horizontalo['datoj'].'</ol><div><a href="#" class="rapida_aldono">Rapida aldono</a></div>';
    $horizontalo['sondosiero'] = '<ul class="sondosieroj">'.$horizontalo['sondosiero'].'</ul>';
    $horizontalo['parolanto'] = '<ul class="parolantoj">'.$horizontalo['parolanto'].'</ul>';
    $horizontalo['permesilo'] = format_permesilo($horizontalo['permesilo_nomo'],
                                                  $horizontalo['permesilo_bildo']);
}

header('Content-type: application/json');
print json_encode(array('rezulto' => 'sukceso', 'datumoj' => $horizontalo));

?>
