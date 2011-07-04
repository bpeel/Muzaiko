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
	print_show('nun', $show['title'], $show['desc']);
	
	while (true) {
		$time += 3600;
		$show = current_show($time, false);
		if (!$show) break;
		if (in_array($show['clock'], $seen)) break;
		$seen[] = $show['clock'];
		
		$hour = date('H:00', $time+$offset);
		if ($utc) $hour .= ' UTC';
		print_show($hour, $show['title'], $show['desc'], $time.'000');
	}
	
right();
right_contents();
page_footer();
