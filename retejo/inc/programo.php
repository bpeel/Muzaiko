<?php
require('/var/muzaiko/programdatumbazensalutiloj.php');

function konektu_al_programo()
{
  global $programo_host, $programo_uzantnomo;
  global $programo_pasvorto, $programo_datumbazo;

  mysql_connect($programo_host,
                $programo_uzantnomo,
                $programo_pasvorto) or die(mysql_error());

  mysql_select_db("programo") or die(mysql_error());
  mysql_select_db($programo_datumbazo) or die(mysql_error());

  mysql_set_charset("utf8");
}
?>
