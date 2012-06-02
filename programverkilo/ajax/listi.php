<?php

require_once('../lib/sql_petoj.php');
include_once('../lib/funkcioj.php');

if (empty($_REQUEST['listo'])) {
  printf('Mankas parametroj');
  exit();
}

$listo = $_REQUEST['listo'];

konektigxi_al_datumbazo();

try {
  $sql_peto = sql_listi($listo);
  $datumoj = peti_datumbazon($sql_peto);
} catch (Exception $e) {
  malkonektigxi_de_datumbazo();
  print($e.getMessage());
  exit();
}

malkonektigxi_de_datumbazo();

if ($listo != 'parolanto')
  $horizontaloj = array(0 => '-- nenio --');
while ($horizontalo = mysql_fetch_assoc($datumoj)) {
  $horizontaloj[$horizontalo['valoro']] = $horizontalo['teksto'];
}

header('Content-type: application/json');
print json_encode($horizontaloj);

?>
