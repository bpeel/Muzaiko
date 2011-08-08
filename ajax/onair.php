<?php
	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();
?>
<script type="text/javascript" src="ajax/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function updateCurrentSong(){
	$('#onair').load('ajax/current_song.php');
}
setInterval("updateCurrentSong()", 5000);
</script>
<div id="onair-block"><span id="onair-title">Ludita:</span><br /><span id="onair"><?php include('ajax/current_song.php'); ?></span></div>
<p class="showtitle"><?=$show_data['title']?></p>
<p class="nowplaying"><?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>
