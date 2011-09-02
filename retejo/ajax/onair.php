<?php
/*	include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');
	$show_data = current_show();*/
?>

<script type="text/javascript" src="ajax/jquery-1.6.2.min.js"></script>

<!-- skriptoj -->
<script type="text/javascript">
  function updateCurrentSong(){
          $('#kanto').load('ajax/current_song.php');
//           $('#kanto2').load('ajax/current_song.php');
  }
  setInterval("updateCurrentSong()", 5000);
/*  function updateCurrentSong2(){*/
/*          $('#kanto2').load('ajax/current_song.php');*/
/*  }*/
/*  setInterval("updateCurrentSong2()", 5000); */
  function updateCurrentListeners(){
          $('#statistikoj').load('ajax/nombro_da_auxskultantoj.php');
  }
  setInterval("updateCurrentListeners()", 1000);
</script>

<!-- kantinformoj -->
<div id="now-playing">
  <h1>Nun estas ludata…</h1>
  <div id="kanto"></div>
<!--   <h1>Nombro da aŭskultantoj</h1> -->
  <div id="statistikoj"></div>
<!--  <h1>Nun estas ludata…</h1>
  <div id="kanto2"></div>-->
</div>

<script type="text/javascript">
  updateCurrentSong();
//   updateCurrentSong2();
  updateCurrentListeners();
</script>

<!--<p class="showtitle">< ?=$show_data['title']?></p>
<p class="nowplaying">< ?=current_song()?></p>
<p class="listenlive">Aŭskultu nun!</p>-->
