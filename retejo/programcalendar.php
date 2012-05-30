<?php

include('php-calendar.php');
include_once('inc/programo.php');

class ProgramCalendar extends Calendar {
	function getCalendarLink($monato, $jaro) {
		$s = getenv('SCRIPT_NAME');
		return "$s?jaro=$jaro&monato=$monato#programo";
	}

	function getDateLink($tago, $monato, $jaro) {
		$query = "SELECT * FROM elsendo WHERE YEAR(date_begin) = $jaro AND MONTH(date_begin) = $monato AND DAY(date_begin) = $tago";
		konektu_al_programo();
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
    var $monthNames = array("Januaro", "Februaro", "Marto", "Aprilo", "Majo", "Junio",
                            "Julio", "Aŭgusto", "Septembro", "Oktobro", "Novembro", "Decembro");
}

