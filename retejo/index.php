<?php
include('inc/inc.php');
page_header('Bonvenon al Muzaiko!', '');
?>
<p>
<img src="images/earphones.gif" alt="" title="" class="left_img" />
<b>Muzaiko estas tuttempa tutmonda tutmojosa tutesperanta radio!</b> Ni ludas por vi 24 horojn en tago muzikon, programerojn, novaĵojn, informojn, raportojn, arkivaĵojn kaj multe pli!
</p>
<p>Nia retejo ankoraŭ ne tute pretas - sed se vi volas scii pli aŭ ŝatus kunlabori, bonvolu kontakti nin ĉe <b>info (ĉe) muzaiko.info</b>!</p>

<?php
// preparu la hodiauxan daton laux UTC por poste
date_default_timezone_set('UTC');
//echo date('H:i:s d/m/Y').'<br>';
$hodiaux = strtotime(date('Y-m-d'));
//$hodiaux = strtotime(date('2011-09-03'));
?>

<div class="title">La hodiaŭa programo</div>

<div>

<?php echo date('Y/m/d').':'; ?>
	  <ul>
<?php	if ($hodiaux == strtotime(date('2011-09-11'))) { ?>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a href="http://radioverda.com/" target="_blank">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-10'))) { ?>
			<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario "Kaj nun ni estu eŭropanoj"</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a href="http://radioverda.com/" target="_blank">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
			<li>02:00-03:00 UTC: TEJO Tutmonde prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-09'))) { ?>
			<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario "Kaj nun ni estu eŭropanoj"</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a target="_blank" href="http://www.podkasto.net/2011/07/03/la-72a-elsendo/">Varsovia Vento</a> Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-08'))) { ?>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-07'))) { ?>
	     <li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
	     <li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
	     <li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target="_blank" href="http://www.transparent.com/esperanto/">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target="_blank" href="http://eo.wikipedia.org/wiki/Julia_Noe">Julia Noe</a> laŭtlegas fabelon "La fabelo kaj la vero"</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-06'))) { ?>
			<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
			<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
			<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-05'))) { ?>
			<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
<?php	} ?>
<?php	if ($hodiaux == strtotime(date('2011-09-04'))) { ?>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
<?php	} ?>
	  <!-- komuna al cxiu programo: -->
	  </ul>
	  kaj poste tiuj tri horoj ripetiĝos dum la tuta tago.

</div>

<div class="title">Antaŭaj programoj</div>

<ul>

<div>
  <ul>

<?php	if ($hodiaux > strtotime(date('2011-09-11'))) { ?>
     <li>
	   2011/09/11:
      <ul>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a href="http://radioverda.com/" target="_blank">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-10'))) { ?>
     <li>
	   2011/09/10:
      <ul>
			<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario "Kaj nun ni estu eŭropanoj"</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a href="http://radioverda.com/" target="_blank">Radio Verda</a> Jessica Grasso elektis por vi interesaĵojn pri bicikloj</li>
			<li>02:00-03:00 UTC: TEJO Tutmonde prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-09'))) { ?>
     <li>
	   2011/09/09:
      <ul>
			<li>00:00-01:00 UTC: Intervjuo de Aleks Kadar kun Bertrand Hugon pri la seminario "Kaj nun ni estu eŭropanoj"</li>
			<li>01:00-02:00 UTC: El la arĥivejo de <a target="_blank" href="http://www.podkasto.net/2011/07/03/la-72a-elsendo/">Varsovia Vento</a> Platano kunmetis por vi intervjuon pri la Kinofestivalo</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-08'))) { ?>
     <li>
	   2011/09/08:
      <ul>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-07'))) { ?>
     <li>
	   2011/09/07:
      <ul>
	     <li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
	     <li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
	     <li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target="_blank" href="http://www.transparent.com/esperanto/">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target="_blank" href="http://eo.wikipedia.org/wiki/Julia_Noe">Julia Noe</a> laŭtlegas fabelon "La fabelo kaj la vero"</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-06'))) { ?>
     <li>
	   2011/09/06:
      <ul>
			<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
			<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
			<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-05'))) { ?>
     <li>
	   2011/09/05:
      <ul>
			<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>
<?php	if ($hodiaux > strtotime(date('2011-09-04'))) { ?>
     <li>
	   2011/09/04:
      <ul>
			<li>00:00-01:00 UTC: <i>Kulturaj minutoj</i> prezentas projekton pri nova antologio en Britio kaj la internacian koruson Interkant'</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Vegetaranismo tra la mondo</i> vizitas Brition</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>
<?php	} ?>

    <li>
	   2011/09/03:
      <ul>
	     <li>00:00-01:00 UTC: <i>Gramatikaĵo</i>; La programo de <i>Esperantistaj muzikistoj</i> prezentas intervjuon kun ĴomArt kaj Nataŝa</li>
	     <li>01:00-02:00 UTC: <i>Raportoj el eventoj</i> prezentas IREM, JuSKA kaj Café Esperanto en Parizo</li>
	     <li>02:00-03:00 UTC: <i>Esperantistoj aktivas</i> prezentas intervjuon kun Chuck Smith pri blogado ĉe <a target="_blank" href="http://www.transparent.com/esperanto/">transparent.com/esperanto</a>; <i>Fabeloj</i>: <a target="_blank" href="http://eo.wikipedia.org/wiki/Julia_Noe">Julia Noe</a> laŭtlegas fabelon "La fabelo kaj la vero"</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/09/02:
      <ul>
			<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
			<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
			<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/09/01:
      <ul>
			<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
			<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
			<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/17 - 2011/08/31: 5a provelsendo:
      <ul>
			<li>00:00-01:00 UTC: <i>Esperantistoj aktivas</i> prezentas Céline Bernard, kiu rakontos al ni pri la grupo en la urbo de Orange, en Francio</li>
			<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
			<li>02:00-03:00 UTC: En la kadro de la programo <i>Bibliotekoj tra la mondo</i>, radio Muzaiko vizitas la Britan Bibliotekon</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/16: 4a provelsendo:
      <ul>
			<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
			<li>01:00-02:00 UTC: <i>TEJO Tutmonde</i> prezentas intervjuon de Dan Mrázek kun la novelektita prezidento de TEJO, Łukasz Żebrowski</li>
			<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

    <li>
      2011/08/07 - 2011/08/15: 3a provelsendo:
      <ul>
	<li>00:00-01:00 UTC: <i>Raportoj el eventoj</i> prezentas raportojn pri IJK, JuSKA kaj TAKE</li>
	<li>01:00-02:00 UTC: <i>Saluton, Radiemuloj!</i> prezentas la Polan retradion en Esperanto</li>
	<li>02:00-03:00 UTC: <i>Universitataj sistemoj tra la mondo</i> prezentas la valonan sistemon en Belgio</li>
      </ul>
      kaj poste tiuj tri horoj ripetiĝis dum la tuta tago.
    </li>
    <br>

  </ul>
</div>

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
