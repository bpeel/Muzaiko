<?php
include('inc/inc.php');
page_header('Bonvenon al Muzaiko!', '');
?>
<p>
<img src="images/earphones.gif" alt="" title="" class="left_img" />
<b>Muzaiko estas tuttempa tutmojosa tutesperanta radio!</b> Ni ludas por vi 24 horojn en tago muzikon, programerojn, novaĵojn, informojn, raportojn, arkivaĵojn kaj multe pli!
</p>
<p>Nia retejo ankoraŭ ne tute pretas - sed se vi volas scii pli aŭ ŝatus kunlabori, bonvolu kontakti nun ĉe <b>info (ĉe) muzaiko.info</b>!</p>
<div class="title">La hodiaŭa programo</div>

<div>
La hodiaŭa elsendo (01/09/2011):
<ul>
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
</ul>
kaj poste tiuj tri horoj ripetiĝos dum la tuta tago.
</div>

<div class="title">Antaŭaj programoj</div>

<ul>

<li>17/08/2011-01/09/2011: 5a provelsendo:
<ul>
<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu
rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: En la kadro de la programo Bibliotekoj tra la mondo radio
Muzaiko vizitas la Britan Bibliotekon</li>
</ul>
kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.

<li>16/08/2011: 4a provelsendo:
<ul>
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
</ul>
kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.</li>

<li>07/08/2011 - 15/08/2011: 3a provelsendo:
<ul>
<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
</ul>
kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.</li>

</ul>

<?php
	function print_show($hour, $title, $desc, $num=0) {
		?>
		<div class="left_shows">
		<div class="show_date" id="<?=$num?>"><?=$hour?></div>
		<div class="show_text_content">
		<div class="show_title"><?=$title?></div>
		<?=$desc?></div></div>
		<?php
	}
	
	// has the client provided an offset?
	// if not, use UTC
	$offset = 0;
	$utc = false;
	if (isset($_COOKIE['tzoffset'])) {
		$offset = $_COOKIE['tzoffset'];
	} else {
		$utc = true;
	}
	
	$time = time()-120;
	$show = current_show($time);
	$seen = array($show['clock']);
/*	print_show('nun', $show['title'], $show['desc']);
	
	while (true) {
		$time += 3600;
		$show = current_show($time, false);
		if (!$show) break;
		if (in_array($show['clock'], $seen)) break;
		$seen[] = $show['clock'];
		
		$hour = date('H:00', $time+$offset);
		if ($utc) $hour .= ' UTC';
		print_show($hour, $show['title'], $show['desc'], $time.'000');
	}*/
	
right();
right_contents();
page_footer();
