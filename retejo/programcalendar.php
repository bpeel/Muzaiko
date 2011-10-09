<?php

include('php-calendar.php');

class ProgramCalendar extends Calendar {
	function getCalendarLink($monato, $jaro) {
		$s = getenv('SCRIPT_NAME');
		return "$s?jaro=$jaro&monato=$monato";
	}

	function getDateLink($tago, $monato, $jaro) {
		$query = "SELECT * FROM elsendo WHERE YEAR(date_begin) = $jaro AND MONTH(date_begin) = $monato AND DAY(date_begin) = $tago";
		include('/var/muzaiko/programdatumbazensalutiloj.php');
		mysql_connect($programo_host, $programo_uzantnomo, $programo_pasvorto) or die(mysql_error());
		mysql_select_db($programo_datumbazo) or die(mysql_error());
		$result = mysql_query($query);
		mysql_close();
		$link = '';
		if (mysql_num_rows($result) > 0) {
			$s = getenv('SCRIPT_NAME');
                	$link = "$s?jaro=$jaro&monato=$monato&tago=$tago#programo";
		}
		return $link;
	}
    /*
        The labels to display for the days of the week. The first entry in this array
        represents Sunday.
    */
    var $dayNames = array("Dim", "Lun", "Mar", "Mer", "Ĵaŭ", "Ven", "Sab");
    
    /*
        The labels to display for the months of the year. The first entry in this array
        represents January.
    */
    var $monthNames = array("Januaro", "Februaro", "Marto", "Aprilo", "Majo", "Juniu",
                            "Julio", "Aŭgusto", "Septembro", "Octobro", "Novembro", "Decembro");
}

