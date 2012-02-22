<?php
/*	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();*/
?>

<script type="text/javascript" src="ajax/jquery-1.6.2.min.js"></script>

<!-- skriptoj -->
<script type="text/javascript">
  function updateCurrentSong(){
          $('#kanto').load('ajax/aktuala_kanto.html');
  }
  setInterval("updateCurrentSong()", 10000);
  function updateCurrentListeners(){
          $('#statistikoj').load('ajax/nombro_de_auxskultantoj.html');
  }
  setInterval("updateCurrentListeners()", 60000);
</script>

<!-- kantinformoj -->
<div id="now-playing">
  <div class="titolo">Nun estas ludata…</div>
  <div id="kanto"></div>
<!--   <h1>Nombro da aŭskultantoj</h1> -->
  <div>Nombro de aŭskultantoj (laŭ Radionomy, eble ne tute preciza):
       <span id="statistikoj"></span>
  </div>
<!--  <h1>Nun estas ludata…</h1>
  <div id="kanto2"></div>-->
</div>

<script type="text/javascript">
  updateCurrentSong();
  updateCurrentListeners();
</script>

<!--<p class="showtitle">< ?=$show_data['title']?></p>
<p class="nowplaying">< ?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>-->
