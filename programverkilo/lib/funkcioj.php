<?php

# La agordoj troviĝas en dosiero en la formo .ini. Ni ŝarĝos ĝin nur
# unu fojon.
if (!isset($programagordoj)) {
  $programagordoj = parse_ini_file("/var/muzaiko/programagordoj.ini");
}

function format_programero($text) {
  $text = preg_replace('/\[(\S+)\s+([^\]]+)\]/', '<a href="$1">$2</a>', $text);
  $text = preg_replace('/\*([^\*]+)\*/', '<i>$1</i>', $text);
  return $text;
}

function format_permesilo($nomo, $bildo, $url = null) {
  $permesilo = '';
  if ($nomo) {
    $permesilo = $nomo;
    if ($bildo)
      $permesilo = '<img src="./images/permesiloj/'.$bildo.'" alt="'.$nomo.'" title="'.$nomo.'" />';
    if ($url)
      $permesilo = '<a href="'.$url.'">'.$permesilo.'</a>';
  }
  return $permesilo;
}

function konektigxi_al_datumbazo() {
  global $programagordoj;
  if (!mysql_connect($programagordoj['db_host'], $programagordoj['db_user'], $programagordoj['db_passwd']))
    throw new Exception(mysql_error());
  if (!mysql_select_db($programagordoj['db_db']))
    throw new Exception(mysql_error());
  if (!mysql_set_charset('utf8'))
    throw new Exception(mysql_error());
}

function peti_datumbazon($sql_peto) {
  if ($datumoj = mysql_query($sql_peto))
    return $datumoj;
  else
    throw new Exception(mysql_error());
}

function malkonektigxi_de_datumbazo() {
  mysql_close() or die(mysql_error());
}

function is_in_sorted_array($needle, $haystack)
{
  /* Binary search for the file assuming the haystack is sorted */
  $min = 0;
  $max = count($haystack);

  while ($max > $min)
    {
      $mid = floor(($max + $min) / 2);

      if ($haystack[$mid] == $needle)
        return TRUE;
      else if ($haystack[$mid] < $needle)
        $min = $mid + 1;
      else
        $max = $mid;
    }

  return FALSE;
}

function get_unused_files()
{
  global $programagordoj;

  konektigxi_al_datumbazo();

  /* Get a sorted list of all the files already used */
  $result = mysql_query("select `nomo` from `sondosiero` order by `nomo` " .
                        "collate utf8_bin");

  malkonektigxi_de_datumbazo();

  $used_files = array();
  while ($row = mysql_fetch_array($result, MYSQL_NUM))
    $used_files[] = stripslashes($row[0]);
  mysql_free_result($result);

  /* Get a list of all the files on the system but filter out all the
     ones that are already used */
  $unused_files = array();
  $dirname = $programagordoj["loko_de_programeroj"];
  $dir = opendir($dirname)
    or die("failed to list sound files");
  while (($fn = readdir($dir)) !== FALSE)
    if ($fn[0] != "." &&
        !is_dir($dirname . "/" . $fn) &&
        !is_in_sorted_array($fn, $used_files))
      $unused_files[] = $fn;
  closedir($dir);

  sort($unused_files);

  return $unused_files;
}

function get_files_for_program($program_id)
{
  konektigxi_al_datumbazo();
  $result = mysql_query("select `nomo` from `sondosiero` " .
                        "where `programero` = " . $program_id . " " .
                        "order by `nomo` collate utf8_bin")
    or die("mysql error " . mysql_error());
  malkonektigxi_de_datumbazo();
  $files = array();
  while ($row = mysql_fetch_array($result, MYSQL_NUM))
    $files[] = stripslashes($row[0]);
  mysql_free_result($result);

  return $files;
}

?>
