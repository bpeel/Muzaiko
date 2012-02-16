<?php
/*	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();*/
?>

<script type="text/javascript" src="ajax/jquery-1.6.2.min.js"></script>

<!-- statistikoj -->
<script type="text/javascript">
  function updateCurrentListeners(){
          $('#statistikoj').load('ajax/nombro_da_auxskultantoj.php');
  }
  setInterval("updateCurrentListeners()", 10000);
</script>

<div id="now-playing">
  <h1>Nombro de aŭskultantoj</h1>
  <div id="statistikoj"></div>
</div>

<script type="text/javascript">
  updateCurrentListeners();
</script>

<!--<p class="showtitle">< ?=$show_data['title']?></p>
<p class="nowplaying">< ?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>-->
