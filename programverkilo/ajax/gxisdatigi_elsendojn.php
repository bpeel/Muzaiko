<?php

require_once('../lib/sql_petoj.php');
include_once('../lib/funkcioj.php');

if (!isset($_REQUEST['opeco']) && !isset($_REQUEST['programero_id'])) {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => "Mankas parametroj."));
  exit();
}

$programero_id = $_REQUEST['programero_id'];
$opeco = $_REQUEST['opeco'];

if ($opeco != 'unuopa' && $opeco != 'pluropa') {
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => 'La parametro "opeco" devas esti "unuopa" aux "pluropa"'));
  exit();
}

$datoj = $_REQUEST['elsendo_dato'];
$komenchoroj = $_REQUEST['elsendo_komenchoro'];
$finhoroj = $_REQUEST['elsendo_finhoro'];

konektigxi_al_datumbazo();

try {
  if ($opeco == 'pluropa') {
    $sql_peto = sql_forvisxi_elsendojn($programero_id);
    peti_datumbazon($sql_peto);
  }
  if ($opeco == 'unuopa' || count($datoj) > 0) {
    if ($opeco == 'unuopa')
      $sql_peto = sql_krei_elsendon($programero_id, $datoj, $komenchoroj, $finhoroj);
    else
      $sql_peto = sql_krei_elsendojn($programero_id, $datoj, $komenchoroj, $finhoroj);
    peti_datumbazon($sql_peto);
    $sql_peto = sql_akiri_elsendojn($programero_id);
    $datumoj = peti_datumbazon($sql_peto);
    $horizontalo = mysql_fetch_row($datumoj);
    $elsendoj = '<ol class="datoj">'.$horizontalo[0].'</ol><div><a href="#" class="rapida_aldono">Rapida aldono</a></div>';
    $lasta_elsendo = $horizontalo[1];
  } else {
    $elsendoj = '<ol class="datoj"></ol><div><a href="#" class="rapida_aldono">Rapida aldono</a></div>';
    $lasta_elsendo = '';
  }
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  header('Content-type: application/json');
  print json_encode(array('rezulto' => 'eraro', 'mesagxo' => $e->getMessage()));
  exit();
}

malkonektigxi_de_datumbazo();

header('Content-type: application/json');
print json_encode(array('rezulto' => 'sukceso', 'elsendoj' => $elsendoj, 'lasta_elsendo' => $lasta_elsendo));

?>
