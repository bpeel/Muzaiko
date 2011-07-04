<?php

function current_song() {
	return trim(file_get_contents('/radio/playing.txt'));
}

function current_show($time=-1, $error_on_missing=false) {
	if ($time==-1) $time = time();
	$fname = TRIGGERDIR.date('Ymd_H0002', $time);
	
	$trigger = readlink($fname);
	if ($trigger==FALSE) {
		if ($error_on_missing) return NULL;
		$clock = 'default';
	} else {
		$clock = basename($trigger);
	}
	
	return get_clock_public_data($clock);
}
