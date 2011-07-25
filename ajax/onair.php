<?php
	include_once('/var/www/inc/inc.php');
	$show_data = current_show();
?>
<p class="showtitle"><?=$show_data['title']?></p>
<p class="nowplaying"><?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>
