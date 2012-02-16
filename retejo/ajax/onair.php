<?php
/*	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();*/
?>

<script type="text/javascript" src="ajax/jquery-1.6.2.min.js"></script>

<!-- skriptoj -->
<script type="text/javascript">
  /*function updateCurrentSong(){
          $('#kanto').load('ajax/current_song.php');
  }
  setInterval("updateCurrentSong()", 10000);
  function updateCurrentListeners(){
          $('#statistikoj').load('ajax/nombro_da_auxskultantoj.php');
  }
  setInterval("updateCurrentListeners()", 10000);*/
</script>

<!-- kantinformoj -->
<div id="now-playing">
  <div class="titolo">Nun estas ludata…</div>
  <div id="kanto">Pro la superŝarĝo de la servilo, ni portempe malŝaltis<br />la montrado de la informoj pri la aktuale ludata kanto<br />kaj la nombro de aŭskultantoj. Ni pardonpetaspro la<br />ĝeno, kaj esperas reŝalti ilin baldaŭ.</div>
<!--   <h1>Nombro da aŭskultantoj</h1> -->
  <div id="statistikoj"></div>
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
