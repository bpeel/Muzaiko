<?php
include_once ("inc/programo.php");

function akiru_horon ()
{
  if (array_key_exists ("testhoro", $_GET))
    {
      $horo = $_GET["testhoro"];
      if ($horo && preg_match ("/^[0-9]+$/", $horo))
        return $horo;
    }

  return time ();
}

function sercxu_programon_por_dato ($dato)
{
  $rezulto = mysql_query ("select unix_timestamp(`date_begin`), " .
                          "unix_timestamp(`date_end`), " .
                          "`description` " .
                          "from `programero` inner join `elsendo` " .
                          "on `programero`.`id` = `elsendo`.`programero_id` " .
                          "where date(`date_begin`) = date('" .
                          mysql_real_escape_string ($dato) . "') " .
                          "order by `date_begin`");
  $programo = array ();
  while ($vico = mysql_fetch_array ($rezulto, MYSQL_NUM))
    array_push ($programo, array ($vico[0], $vico[1], stripslashes ($vico[2])));
  mysql_free_result ($rezulto);

  return $programo;
}

function reordigu_programon ($programo)
{
  /* Trovu la limojn de la tempoj por la tuto programo */
  $komenco = $programo[0][0];
  $fino = $programo[count ($programo) - 1][1];

  /* Kiom da sekundoj pasis ekde la komenco de la programo? */
  $now = akiru_horon ();
  $sekundoj_ekde_komenco = $now - $komenco;

  /* Kalkulu kiom da sekundoj jam pasis en la ripetata programo */
  $dauxro = $fino - $komenco;
  $pasintaj = $sekundoj_ekde_komenco % $dauxro;
  /* Kiu ripeto ludiĝas nun? */
  $nuna_ripeto = intval (floor ($sekundoj_ekde_komenco / $dauxro));
  /* Kalkulu kiam komenciĝis la nuna ripeto */
  $komenco_de_nuna_ripeto = $komenco + $nuna_ripeto * $dauxro;

  /* Trovu la nunan ludatan programeron */
  for ($i = 0; $i < count ($programo); $i++)
    {
      $programero = $programo[$i];

      if ($pasintaj + $komenco >= $programero[0] &&
          $pasintaj + $komenco < $programero[1])
        {
          $nuna_programero = $i;
          break;
        }
    }

  /* Se neniu programo troviĝis, estas ia eraro do ni rezignu */
  if (is_null ($nuna_programero))
    return $programo;

  /* Kreu novan tabelon uzanta la horojn de la aktuala ripeto */
  $reordigita_programo = array ();

  /* Komenciĝu per la nuna programo */
  $i = $nuna_programero;
  do
    {
      $programero = $programo[$i];

      array_push ($reordigita_programo,
                  array ($programero[0] - $komenco + $komenco_de_nuna_ripeto,
                         $programero[1] - $komenco + $komenco_de_nuna_ripeto,
                         $programero[2]));

      if (++$i >= count ($programo))
        {
          $komenco_de_nuna_ripeto += $dauxro;
          $i = 0;
        }
    } while ($i != $nuna_programero);

  return $reordigita_programo;
}

function eligu_hortabelon ()
{
  global $programo_host, $programo_uzantnomo, $programo_pasvorto;
  global $programo_datumbazo;

  konektu_al_programo ();

  /* Serĉu la programeron kiu komenciĝos plej proksime al la nuna horo
     sen komenci post nun */
  $rezulto = mysql_query ("select `date_begin` " .
                          "from `elsendo` " .
                          "where `date_begin` < from_unixtime (" .
                          akiru_horon () . ") " .
                          "order by `date_begin` desc " .
                          "limit 1");
  $vico = mysql_fetch_array ($rezulto, MYSQL_NUM)
    or die ("Neniu programero troviĝis");

  mysql_free_result ($rezulto);

  /* Serĉu ĉiujn programerojn kiuj komenciĝos dum la sama tago kiel la
     trovita programero */
  $aktuala_programo = sercxu_programon_por_dato ($vico[0]);

  /* Ŝanĝu la programon al la aktuala ripeto */
  $aktuala_programo = reordigu_programon ($aktuala_programo);

  /* Kontrolu ĉu estas programero kiu ludiĝos dum ĉi tiu ripeto de la
     trovita programo */
  $komenco_de_aktuala_programo = $aktuala_programo[0][0];
  $fino_de_aktuala_programo =
    $aktuala_programo[count ($aktuala_programo) - 1][1];

  $rezulto = mysql_query ("select `date_begin` " .
                          "from `elsendo` " .
                          "where `date_begin` < " .
                          "from_unixtime(" . $fino_de_aktuala_programo
                          . ") and `date_end` > " .
                          "from_unixtime(" . $komenco_de_aktuala_programo
                          . ") limit 1");

  $vico = mysql_fetch_array ($rezulto, MYSQL_NUM);
  mysql_free_result ($rezulto);

  $kvanto_de_ripetotoj = count ($aktuala_programo);

  if ($vico)
    {
      $venonta_programo = sercxu_programon_por_dato ($vico[0]);
      $komenco_de_venonta_programo = $venonta_programo[0][0];
      $fino_de_venonta_programo =
        $venonta_programo[count ($venonta_programo) - 1][1];

      $len = count ($aktuala_programo);

      /* Forigu la programerojn kiuj kolizios kun la venonta programo */
      while ($len > 0 &&
             $aktuala_programo[$len - 1][0] < $fino_de_venonta_programo &&
             $aktuala_programo[$len - 1][1] > $komenco_de_venonta_programo)
        {
          array_pop ($aktuala_programo);
          $len--;
        }

      /* Kunigu ambaŭ programojn */
      $aktuala_programo = array_merge ($aktuala_programo, $venonta_programo);

      $kvanto_de_ripetotoj = count ($venonta_programo);
    }

  mysql_close ();

  print ("<div id=\"aktualaprogramo\"><ul>\n");
  foreach ($aktuala_programo as $programero)
    print ("<li><span komenctempo=\"" . $programero[0] . "\" " .
           "fintempo=\"" . $programero[1] . "\">" .
           gmdate ('H:i', $programero[0]) . "&ndash;" .
           gmdate ('H:i', $programero[1]) . " UTC</span>: " .
           format_programero (htmlspecialchars ($programero[2])) .
           "</li>\n");
  print ("</ul>\n" .
         "kaj poste la lastaj " . $kvanto_de_ripetotoj .
         " programeroj ripetiĝos ĝis <span id=\"ripetlimo\">" .
         "la 3a UTC</span>.\n" .
         "</div>\n");
}

eligu_hortabelon ();
?>
