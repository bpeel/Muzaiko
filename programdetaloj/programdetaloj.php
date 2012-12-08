<?php

$INC_DIR = dirname (__FILE__) . "/inc";
require_once ($INC_DIR . "/inc.php");
require_once ($INC_DIR . "/programo.php");

function montru_kampon ($linio, $kampo, $titolo, $enhavo)
{
  if ($enhavo || $linio[$kampo])
    {
      echo ("<tr><td class=\"kampo\">$titolo</td><td>");

      if ($enhavo)
        echo ($enhavo);
      else
        echo (format_programero (htmlspecialchars ($linio[$kampo])));

      echo ("</td></tr>\n");
    }
}

function kuiri_tekston ($teksto)
{
  return preg_replace ('/[0-9]+\n' .
                       '[0-9]+:[0-9]+:[0-9]+,[0-9]+ --> ' .
                       '[0-9]+:[0-9]+:[0-9]+,[0-9]+\n/',
                       "",
                       $teksto);
}

function sonfonto ($id, $tipo)
{
  return ("<source src=\"/public/sondosieroj/programero" .
          $id . "." . $tipo . "\" " .
          "type=\"audio/" . $tipo . "\" />\n");
}

function format_permesilo ($nomo, $bildo, $url = null)
{
  if ($nomo)
    {
      if ($bildo)
        $permesilo =
          "<img src=\"/public/images/permesiloj/" .
          htmlentities ($bildo) .
          "\" alt=\"" .
          htmlentities ($nomo) . "\" title=\"" .
          htmlentities ($nomo) ."\" />";
      else
        $permesilo = htmlentities ($nomo);

      if ($url)
        $permesilo =
          "<a href=\"" . htmlentities ($url) . "\">" .
          $permesilo .
          "</a>";
    }
  else
    $permesilo = "";

  return $permesilo;
}

konektu_al_programo ();

$rez = mysql_query ("select `programero`.`id`, " .
                    "`programero`.`titolo`, " .
                    "`programero`.`skizo`, " .
                    "`permesilo`.`nomo` as `permesilo_nomo`, " .
                    "`permesilo`.`bildo` as `permesilo_bildo`, " .
                    "`permesilo`.`url` as `permesilo_url`, " .
                    "`programero`.`teksto`, " .
                    "count(`sondosiero`.`nomo`) as `sondosieroj` " .
                    "from `programero` " .
                    "left join `permesilo` " .
                    "on `permesilo`.`id` = `programero`.`permesilo_id` " .
                    "left join `sondosiero` " .
                    "on `sondosiero`.`programero` = `programero`.`id` " .
                    "where `programero`.`id` = '" .
                    mysql_real_escape_string ($_REQUEST["id"]) ."' " .
                    "group by `programero`.`id`");

while ($linio = mysql_fetch_array ($rez, MYSQL_ASSOC))
  {
    if ($linio["titolo"])
      echo ("<h2>" . htmlspecialchars ($linio["titolo"]) . "</h2>\n");

    echo ("<table id=\"detaltabelo\">\n");

    montru_kampon ($linio, "skizo", "Skizo");

    $kruda_teksto = $linio["teksto"];
    $kuirita_teksto = kuiri_tekston ($kruda_teksto);

    if ($linio["permesilo_nomo"])
      montru_kampon ($linio, "permesilo_nomo", "Permesilo",
                     format_permesilo ($linio["permesilo_nomo"],
                                       $linio["permesilo_bildo"],
                                       $linio["permesilo_url"]));

    if ($linio["sondosieroj"] > 0)
      {
        $auxskultilo =
          "<audio controls=\"controls\" id=\"auxskultilo\">\n" .
          sonfonto ($linio["id"], "mp3") .
          sonfonto ($linio["id"], "ogg") .
          "</audio>\n";

        /* Se la teksto havas tempojn ni ankaŭ lasos spacon por montri
         * la titolojn dum ĝi ludiĝas */
        if ($kruda_teksto != $kuirita_teksto)
          {
            $auxskultilo .=
              "<div id=\"titoloj\" style=\"" .
              "font-size:large;padding:1em;" .
              "background-color:rgb(200,200,255);" .
              "height:4em;text-align:center\"" .
              "></div>\n" .
              "<script type=\"text/javascript\" " .
              "src=\"/public/js/subtitoloj.js\">\n" .
              "</script>\n" .
              "<div id=\"subtitoldatumo\" style=\"display:none\">" .
              htmlspecialchars ($kruda_teksto) .
              "</div>\n";
          }

        montru_kampon ($linio, "sondosieroj", "Aŭskultu", $auxskultilo);
      }

    montru_kampon ($linio, "teksto", "Teksto",
                   nl2br (htmlspecialchars ($kuirita_teksto)));

    echo ("</table>\n");
  }

mysql_free_result ($rez);
?>
