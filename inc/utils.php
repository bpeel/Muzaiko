<?php

function current_song() {
	return trim(file_get_contents('/radio/playing.txt'));
}

function current_show($time=-1, $error_on_missing=false) {
        // FIXME: This function no longer works because the admin files
	// are no longer available
        return array ("title" => "Ia Kanto",
                      "clock" => 0,
                      "desc" => "Mojosaĵo");
}
