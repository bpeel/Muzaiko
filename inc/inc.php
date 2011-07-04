<?php

mysql_pconnect('localhost', 'root', 'zamenhof');
mysql_select_db('muzaiko');

set_include_path('/var/www');

define('AUDIODIR', '/radio/audio/');
define('PLAYLISTDIR', '/radio/playlist/');
define('CLOCKINDIR', '/radio/clock.in/');
define('CLOCKDIR', '/radio/clock/');
define('TRIGGERDIR', '/radio/trigger/');
define('TRIGGERCLOCKDIR', '/radio/trigger.clock/');

require_once('inc/db.php');
require_once('inc/www.php');
require_once('inc/utils.php');

require_once('admin/inc/clock.php');

