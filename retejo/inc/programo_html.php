<?php
// ************************* KALENDARO **************************************

require_once('inc/utils.php');
include_once('./programcalendar.php');
include_once('./inc/programo.php');

printf('<h1>Aktuala programo</h1>');

include('aktuala-hortabelo.php');
print("<script type=\"text/javascript\">\n");
include('hortabelo.js');
print("</script>\n");

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
	$query = "SELECT TIME_FORMAT(komenchoro, '%H:%i'), TIME_FORMAT(finhoro, '%H:%i'), skizo FROM programero, elsendo WHERE programero.id = elsendo.programero_id AND YEAR(dato) = $jaro AND MONTH(dato) = $monato AND DAY(dato) = $tago ORDER BY komenchoro ASC";

	konektu_al_programo();

	$result = mysql_query($query);

	mysql_close();

	printf('<div>%s:<ul>', date('Y/m/d', mktime(0, 0, 0, $monato, $tago, $jaro)));
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		printf('<li>%s&ndash;%s UTC: %s</li>', $row[0], $row[1], format_programero(htmlspecialchars(stripslashes($row[2]))));
	}
	printf('</ul>kaj poste tiuj tri horoj ripetiĝas dum la tuta tago.</div>');
}

?>

<div style="margin-top: 20px;"><strong>Trovu ĉiujn programerojn <a href="./programeroj2">ĉi tie</a></strong>!</div>
