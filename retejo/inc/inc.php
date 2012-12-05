<?php

set_include_path('/var/www/www.muzaiko.info/public/scripts');

define('AUDIODIR', '/radio/audio/');
define('PLAYLISTDIR', '/radio/playlist/');
define('CLOCKINDIR', '/radio/clock.in/');
define('CLOCKDIR', '/radio/clock/');
define('TRIGGERDIR', '/radio/trigger/');
define('TRIGGERCLOCKDIR', '/radio/trigger.clock/');

require_once('inc/db.php');
require_once('inc/www.php');
require_once('inc/utils.php');
