<?php
include('inc/inc.php');
page_header('Statistikoj');


function create_graph($output, $start, $consolidation_tendency, $width) {
  $rrd_file_name = '/var/muzaiko/auxskultantoj.rrd';
  $options = array(
    "--start", $start,
    "--width", $width,
    "DEF:nombro=$rrd_file_name:auxskultantoj:$consolidation_tendency",
    "DEF:minimuma=$rrd_file_name:auxskultantoj:MIN",
    "DEF:maksimuma=$rrd_file_name:auxskultantoj:MAX",
    "VDEF:minnombro=minimuma,MINIMUM",
    "VDEF:maksnombro=maksimuma,MAXIMUM",
    "VDEF:meznombro=nombro,AVERAGE",
    "AREA:nombro#A00020:Nombro da aŭskultantoj laŭ la tempo",
    "GPRINT:minnombro:Minimuma nombro da aŭskultintoj\: %.0lf",
    "GPRINT:maksnombro:Maksimuma nombro da aŭskultintoj\: %.0lf",
    "GPRINT:meznombro:Meza nombro da aŭskultintoj\: %.0lf"
  );

  $ret = rrd_graph($output, $options, count($options));
  if (! $ret) {
    echo "<b>Graph error: </b>".rrd_error()."<br />\n";
  }
}

$emo = 'AVERAGE';

if (!empty($_GET['emo'])) {
	switch ($_GET['emo']) {
		case 'mezo':
			$emo = 'AVERAGE';
			break;
		case 'minimumo':
			$emo = 'MIN';
			break;
		case 'maksimumo':
			$emo = 'MAX';
			break;
	}
}

create_graph("grafoj/lasta-horo.png", "-1h", $emo, 400);
create_graph("grafoj/lasta-tago.png", "-1d", $emo, 400);
create_graph("grafoj/lasta-semajno.png", "-1w", $emo, 400);
create_graph("grafoj/lasta-monato.png", "-1m", $emo, 400);
create_graph("grafoj/lasta-jaro.png", "-1y", $emo, 400);
create_graph("grafoj/lasta-jardeko.png", "-10y", $emo, 400);

/*
create_graph("preciza-lasta-horo.png", "-1h", "AVERAGE", 60);
create_graph("preciza-lasta-tago.png", "-1d", "AVERAGE", 1440);
create_graph("preciza-lasta-semajno.png", "-1w", "AVERAGE", 2016);
create_graph("preciza-lasta-monato.png", "-1m", "AVERAGE", 3976);
create_graph("preciza-lasta-jaro.png", "-1y", "AVERAGE", 8784);
create_graph("preciza-lasta-jardeko.png", "-10y", "AVERAGE", 3660);
*/

?>

<div>
  <p>La nombro da aŭskultantoj estas registrita ĉiuminute. Krom tiu pri la lasta horo, la grafoj estas montritaj laŭ malgranda rezolucio, forigante la detalojn. La mezo de pluraj mezuroj estas kalkulita por fari unu mezuron, kiu estas montrita kiel unu kolumno, kies la larĝo estas unu rastrumero. Tio signifas, ke la maksimuma nombro da aŭskultintoj povas ne esti videbla.</p>
  <p>Tamen, la grafoj povas esti desegnita, ne laŭ la mezo, sed laŭ la maksimumo aŭ laŭ la minimumo, uzante la sekvajn ligilojn.</p>
  <ul>
   <li><a href="?emo=maksimumo">Desegni la grafojn laŭ la maksimumo (optimiste)</a></li>
   <li><a href="?emo=mezo">Desegni la grafojn laŭ la mezo (kutime)</a></li>
   <li><a href="?emo=minimumo">Desegni la grafojn laŭ la minimumo (pesimiste)</a></li>
  </ul>
  <p>Se la ŝanĝoj ne videblas, freŝigu la paĝon tajpante la klavon F5.</p>
</div>


<h2>Lasta horo</h2>
<div><img src="grafoj/lasta-horo.png" /></div>
<h2>Lasta tago</h2>
<div><img src="grafoj/lasta-tago.png" /></div>
<h2>Lasta semajno</h2>
<div><img src="grafoj/lasta-semajno.png" /></div>
<h2>Lasta monato</h2>
<div><img src="grafoj/lasta-monato.png" /></div>
<h2>Lasta jaro</h2>
<div><img src="grafoj/lasta-jaro.png" /></div>
<h2>Lasta jardeko</h2>
<div><img src="grafoj/lasta-jardeko.png" /></div>

<!--
<h2>Lasta horo</h2>
<div><a href="./preciza-lasta-horo.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-horo.png" /></a></div>
<h2>Lasta tago</h2>
<div><a href="./preciza-lasta-tago.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-tago.png" /></a></div>
<h2>Lasta semajno</h2>
<div><a href="./preciza-lasta-semajno.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-semajno.png" /></a></div>
<h2>Lasta monato</h2>
<div><a href="./preciza-lasta-monato.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-monato.png" /></a></div>
<h2>Lasta jaro</h2>
<div><a href="./preciza-lasta-jaro.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-jaro.png" /></a></div>
<h2>Lasta jardeko</h2>
<div><a href="./preciza-lasta-jardeko.png" title="Klaku por vidi la grafon laŭ la plej taŭga rezolucio"><img src="lasta-jardeko.png" /></a></div>
-->


<?php

right();
right_contents();
page_footer();
