<?php
include('./inc/inc.php');
include('./programcalendar.php');
page_header('Bonvenon al Muzaiko!', '');
?>
<p>
  <img src="images/earphones.gif" alt="" title="" class="left_img" />
  <b>Muzaiko estas tuttempa tutmonda tutmojosa tutesperanta radio!</b> Ni ludas por vi 24 horojn en tago muzikon, programerojn, novaĵojn, informojn, raportojn, arkivaĵojn kaj multe pli!
</p>
<p>
Nun aŭskulteblas la provelsendo, dum kio la teknika teamo laboras por sendependiĝo de Radionomy, por ebligi pli facilan aŭskultadon de Muzaiko kaj elŝutadon de la babila sonmaterialo. Dum tiu tempo ni petas vian helpon, aŭ se vi ne havas tempon por helpi, vian paciencon!
</p>
<p>
  Nia retejo ankoraŭ ne tute pretas - sed se vi volas scii pli aŭ ŝatus kunlabori, bonvolu kontakti nin ĉe <b>info (ĉe) muzaiko.info</b>!
</p>

<?php
  // preparu la hodiauxan daton laux UTC por poste
  date_default_timezone_set('UTC');

// ************************* KALENDARO **************************************


printf('<h1>Hodiaŭa programo</h1>');

$query = "SELECT DATE_FORMAT(date_begin, '%H:%i'), DATE_FORMAT(date_end, '%H:%i'), description FROM programero, elsendo WHERE programero.id = elsendo.programero_id AND DATE(date_begin) = CURDATE()";

mysql_connect($programo_host, $programo_uzantnomo, $programo_pasvorto) or die(mysql_error());
mysql_select_db($programo_datumbazo) or die(mysql_error());

$result = mysql_query($query);

mysql_close();

printf('<ul>');
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	printf('<li>%s&ndash;%s UTC: %s</li>', $row[0], $row[1], format_programero(htmlspecialchars(stripslashes($row[2]))));
}
printf('</ul>kaj poste tiuj tri horoj ripetiĝas dum la tuta tago.');


$d = getdate(time());

$cal = new ProgramCalendar;
$cal->setStartDay(1);

$jaro = (empty($_GET['jaro']) || !ctype_digit($_GET['jaro'] )) ? 0 : $_GET['jaro'] ;
$monato = (empty($_GET['monato']) || !ctype_digit($_GET['monato'] )) ? 0 : $_GET['monato'] ;
$tago = (empty($_GET['tago']) || !ctype_digit($_GET['tago'] )) ? 0 : $_GET['tago'] ;

printf('<h1 id="programo">Tuttempa programo</h1><div id="programa_bloko"><div id="kalendara_bloko" style="margin-bottom: 10px;">');

if ($jaro == 0 && $monato == 0)
	echo $cal->getCurrentMonthView();
else
	echo $cal->getMonthView($monato, $jaro);

printf('</div>');

if ($jaro != 0 && $monato != 0 && $tago != 0) {
	$query = "SELECT DATE_FORMAT(date_begin, '%H:%i'), DATE_FORMAT(date_end, '%H:%i'), description FROM programero, elsendo WHERE programero.id = elsendo.programero_id AND YEAR(date_begin) = $jaro AND MONTH(date_begin) = $monato AND DAY(date_begin) = $tago";

	mysql_connect($programo_host, $programo_uzantnomo, $programo_pasvorto) or die(mysql_error());
	mysql_select_db($programo_datumbazo) or die(mysql_error());

	$result = mysql_query($query);

	mysql_close();

	printf('%s:<ul>', date('Y/m/d', mktime(0, 0, 0, $monato, $tago, $jaro)));
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		printf('<li>%s&ndash;%s UTC: %s</li>', $row[0], $row[1], format_programero(htmlspecialchars(stripslashes($row[2]))));
	}
	printf('</ul>kaj poste tiuj tri horoj ripetiĝas dum la tuta tago.</div>');
}

?>

<div style="margin-top: 20px;"><strong>Trovu ĉiujn programerojn <a href="./programeroj2">ĉi tie</a></strong>!</div>

<?php

// *********************** / KALENDARO **************************************
/*
  //echo date('H:i:s d/m/Y').'<br>';
  $hodiaux = strtotime(date('Y-m-d'));
  //$hodiaux = strtotime(date('2011-09-03'));


  // preparu la programcxenojn
  $hodiauxa_programo = "Programo ne trovita. Verŝajne la programisto dormas. Sed ne zorgu, Radio Muzaiko tamen rulas! :)";
  $antauxa_programo = "";

$arr = array(
"2011/10/09"
=>
"
<li>00:00-01:00 UTC: Esperantistoj aktivas prezentas intervjuon kun Katalin KOVÁTS pri la novtipaj lingvoekzamenoj de UEA-ITK, bazitaj sur la <a href=\"http://edukado.net/ekzamenoj/ker\">Komuna Eŭropa Referenckadro</a></li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: La programo de Esperantistaj muzikistoj prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
"
,
"2011/10/08"
=>
"
<li>00:00-01:00 UTC: Michael Boris MANDIROLA kaj Francesco MAURELLI rakontas pri la daŭripova flanko de vegetarismo</li>
<li>01:00-02:00 UTC: Esperantistoj aktivas prezentas intervjuon kun Chuck SMITH pri blogado ĉe <a href=\"http://transparent.com/esperanto\">transparent.com/esperanto</a>, la intervjuon muntis: RIKKER Bálint</li>
<li>02:00-03:00 UTC: Kulturaj minutoj prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
"
,
"2011/10/07"
=>
"
<li>00:00-01:00 UTC: Intervjuo kun Brunetto Casini kaj Laura Brazzabeni pri la organiza flanko de la Itala Kongreso</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://www.podkasto.net/2011/07/03/la-72a-elsendo/\" target=\"_blank\">Varsovia Vento</a>, Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
<li>02:00-03:00 UTC: Pri la vivo de TEJO-volontuloj rakontas Marteno Minich (elsendo el la arĥivoj de Muzaiko)</li>
"
,
"2011/10/06"
=>
"
<li>00:00-01:00 UTC: Stefano Keller rakontas pri siaj agadoj kiel estrarano pri eksteraj rilatoj de UEA (unua parto)</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/10/05"
=>
"
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri hundoj, dua parto; Platano prezentas intervjuon kun Flo pri la fajro ĉe <a href=\"http://vinilkosmo.com/\" target=\"_blank\">Vinilkosmo</a> kaj raporteton pri la konferenco pri Fukuŝima</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
"
,
"2011/10/04"
=>
"
<li>00:00-01:00 UTC: Aleks Kadar (sekretario) kaj Axel Rousseau (prezidanto) rakontas pri la agadoj de UFE - Espéranto-France</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
"
,
"2011/10/03"
=>
"
<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de Esperantistaj muzikistoj prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas la Italan Kongreson. Kia estis la <a href=\"http://italakongreso.esperantoitalia.it/78/index_it.html\" target=\"_blank\">78a Itala Kongreso</a> por la partoprenantoj? Por tion ekscii, aŭskultu la spertojn de Rossana Guasconi kaj Manuel Giorgini</li>
<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a href=\"http://www.transparent.com/esperanto/\" target=\"_blank\">transparent.com/esperanto</a>; Fabeloj: <a href=\"http://eo.wikipedia.org/wiki/Julia_Noe\" target=\"_blank\">Julia Noe</a> laŭtlegas fabelon \"La fabelo kaj la vero\"</li>
"
,
"2011/10/02"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/10/01"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas prezentas</i>: Chuck Smith, la kreinto de la Esperanta Vikipedio rakontas pri la detaloj</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri hundo; Platano prezentas intervjuon kun Flo pri la fajro ĉe <a href=\"http://vinilkosmo.com\" target=\"_blank\">Vinilkosmo</a> kaj raporteton pri la konferenco pri Fukuŝima</li>
<li>02:00-03:00 UTC: <i>Volontulado tra la mondo</i> prezentas: Probal Dasgupta rakontas pri siaj spertoj kiel volontulo en la Centra Oficejo</li>
"
,
"2011/09/30"
=>
"
<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario \"Kaj nun ni estu eŭropanoj\"</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://www.podkasto.net/2011/07/03/la-72a-elsendo/\">Varsovia Vento</a>, Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
<li>02:00-03:00 UTC: Pri la vivo de TEJO-volontuloj rakontas Marteno Minich (elsendo el la arĥivoj de Muzaiko)
"
,
"2011/09/29"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/28"
=>
"
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj; Platano prezentas intervjuon kun Flo pri la fajro ĉe <a href=\"http://vinilkosmo.com\" target=\"_blank\">Vinilkosmo</a> kaj raporteton pri la konferenco pri Fukuŝima</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
"
,
"2011/09/27"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
"
,
"2011/09/26"
=>
"
<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target=\"_blank\" href=\"http://www.transparent.com/esperanto/\">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target=\"_blank\" href=\"http://eo.wikipedia.org/wiki/Julia_Noe\">Julia Noe</a> laŭtlegas fabelon \"La fabelo kaj la vero\"</li>
"
,
"2011/09/25"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/24"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas prezentas</i>: Chuck Smith, la kreinto de la Esperanta Vikipedio rakontas pri la detaloj</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri hundo</li>
<li>02:00-03:00 UTC: <i>Volontulado tra la mondo</i> prezentas: Probal Dasgupta rakontas pri siaj spertoj kiel volontulo en la Centra Oficejo</li>
"
,
"2011/09/23"
=>
"
<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario \"Kaj nun ni estu eŭropanoj\"</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://www.podkasto.net/2011/07/03/la-72a-elsendo/\">Varsovia Vento</a>, Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
<li>02:00-03:00 UTC: Pri la vivo de TEJO-volontuloj rakontas Marteno Minich (elsendo el la arĥivoj de Muzaiko)
"
,
"2011/09/22"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/21"
=>
"
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
"
,
"2011/09/20"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
"
,
"2011/09/19"
=>
"
<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target=\"_blank\" href=\"http://www.transparent.com/esperanto/\">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target=\"_blank\" href=\"http://eo.wikipedia.org/wiki/Julia_Noe\">Julia Noe</a> laŭtlegas fabelon \"La fabelo kaj la vero\"</li>
"
,
"2011/09/18"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/17"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas prezentas</i>: Chuck Smith, la kreinto de la Esperanta Vikipedio rakontas pri la detaloj</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri hundo</li>
<li>02:00-03:00 UTC: <i>Volontulado tra la mondo</i> prezentas: Probal Dasgupta rakontas pri siaj spertoj kiel volontulo en la Centra Oficejo</li>
"
,
"2011/09/16"
=>
"
<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario \"Kaj nun ni estu eŭropanoj\"</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://www.podkasto.net/2011/07/03/la-72a-elsendo/\">Varsovia Vento</a>, Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
<li>02:00-03:00 UTC: Pri la vivo de TEJO-volontuloj rakontas Marteno Minich (elsendo el la arĥivoj de Muzaiko)
"
,
"2011/09/15"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/14"
=>
"
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
"
,
"2011/09/13"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
"
,
"2011/09/12"
=>
"
<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target=\"_blank\" href=\"http://www.transparent.com/esperanto/\">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target=\"_blank\" href=\"http://eo.wikipedia.org/wiki/Julia_Noe\">Julia Noe</a> laŭtlegas fabelon \"La fabelo kaj la vero\"</li>
"
,
"2011/09/11"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/10"
=>
"
<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario \"Kaj nun ni estu eŭropanoj\"</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a href=\"http://radioverda.com/\" target=\"_blank\">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
<li>02:00-03:00 UTC: TEJO Tutmonde prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
"
,
"2011/09/09"
=>
"
<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario \"Kaj nun ni estu eŭropanoj\"</li>
<li>01:00-02:00 UTC: El la arĥivejo de <a target=\"_blank\" href=\"http://www.podkasto.net/2011/07/03/la-72a-elsendo/\">Varsovia Vento</a> Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/08"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
,
"2011/09/07"
=>
"
<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target=\"_blank\" href=\"http://www.transparent.com/esperanto/\">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target=\"_blank\" href=\"http://eo.wikipedia.org/wiki/Julia_Noe\">Julia Noe</a> laŭtlegas fabelon \"La fabelo kaj la vero\"</li>
"
,
"2011/09/06"
=>
"
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
"
,
"2011/09/05"
=>
"
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
"
,
"2011/09/04"
=>
"
<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
"
);

foreach ($arr as $dato => $programo) {
  if ($hodiaux == strtotime(date($dato))) {
    $hodiauxa_programo = $programo;
  }
  elseif ( strtotime(date("2011/10/01")) <= strtotime(date($dato)) and strtotime(date($dato)) < $hodiaux ) {
    $antauxa_programo = $antauxa_programo . "<li>" . $dato . ":<ul>";
    $antauxa_programo = $antauxa_programo . $programo;
    $antauxa_programo = $antauxa_programo . "</ul> kaj poste tiuj tri horoj ripetiĝis dum la tuta tago. </li> <br>";
  }
}


*/

?>
<!--
<div class="title">La hodiaŭa programo</div>

<div>
    <?php echo date('Y/m/d').':'; ?>
    <ul>
      <?php /*echo $hodiauxa_programo;*/ ?>
    </ul>
    kaj poste tiuj tri horoj ripetiĝos dum la tuta tago.
</div>

<div class="title">Antaŭaj programoj</div>

<div>
  <ul>
    <?php /*echo $antauxa_programo;*/ ?>
-->
<!--     <li>
      2011/09/03:
      <ul>
	<li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
	<li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
	<li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target="_blank" href="http://www.transparent.com/esperanto/">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target="_blank" href="http://eo.wikipedia.org/wiki/Julia_Noe">Julia Noe</a> laŭtlegas fabelon "La fabelo kaj la vero"</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/09/02:
      <ul>
	<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
	<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
	<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/09/01:
      <ul>
	<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
	<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
	<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/17 - 2011/08/31: 5a provelsendo:
      <ul>
	<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
	<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
	<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/16: 4a provelsendo:
      <ul>
	<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
	<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
	<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/07 - 2011/08/15: 3a provelsendo:
      <ul>
	<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
	<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
	<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
 -->
  </ul>
</div>

<?php
  function print_show($hour, $title, $desc, $num=0) {
?>

<div class="left_shows">
  <div class="show_date" id="<?=$num?>">
    <?=$hour?>
  </div>
  <div class="show_text_content">
    <div class="show_title">
      <?=$title?>
    </div>
    <?=$desc?>
  </div>
</div>

<?php
  }
  
  // has the client provided an offset?
  // if not, use UTC
  $offset = 0;
  $utc = false;
  if (isset($_COOKIE['tzoffset'])) {
  $offset = $_COOKIE['tzoffset'];
  } else {
  $utc = true;
  }

  $time = time()-120;
  $show = current_show($time);
  $seen = array($show['clock']);

  /* print_show('nun', $show['title'], $show['desc']);

  while (true) {
  $time += 3600;
  $show = current_show($time, false);
  if (!$show) break;
  if (in_array($show['clock'], $seen)) break;
  $seen[] = $show['clock'];

  $hour = date('H:00', $time+$offset);
  if ($utc) $hour .= ' UTC';
  print_show($hour, $show['title'], $show['desc'], $time.'000');
  }*/

  right();
  right_contents();
  page_footer();
