<?php
	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();
?>
<p class="showtitle"><?=$show_data['title']?></p>
<p class="nowplaying"><?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>
