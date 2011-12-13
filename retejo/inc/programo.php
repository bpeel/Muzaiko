<?php
# La agordoj troviĝas en dosiero en la formo .ini. Ni ŝarĝos ĝin nur
# unu fojon.
if (!isset($programagordoj))
  {
    $programagordoj = parse_ini_file("/var/muzaiko/programagordoj.ini");
  }

function konektu_al_programo()
{
  global $programagordoj;

  mysql_connect($programagordoj["db_host"],
                $programagordoj["db_user"],
                $programagordoj["db_passwd"]) or die(mysql_error());

  mysql_select_db($programagordoj["db_db"]) or die(mysql_error());

  mysql_set_charset("utf8");
}
?>
