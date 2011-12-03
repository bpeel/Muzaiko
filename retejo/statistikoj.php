<?php
include('inc/inc.php');
page_header('Statistikoj');

$rrd_file_name = '/var/muzaiko/auxskultantoj.rrd';

function create_graph($output, $start) {
  $options = array(
    "--start", $start,
    "DEF:tauxskultantoj=/var/muzaiko/auxskultantoj.rrd:auxskultantoj:AVERAGE",
    "AREA:tauxskultantoj#FF0000:Nombro da aŭskultantoj"
  );

  $ret = rrd_graph($output, $options, count($options));
  if (! $ret) {
    echo "<b>Graph error: </b>".rrd_error()."\n";
  }
}

create_graph("lasta-horo.png", "-1h");
create_graph("lasta-tago.png", "-1d");
create_graph("lasta-semajno.png", "-1w");
create_graph("lasta-monato.png", "-1m");
create_graph("lasta-jaro.png", "-1y");
create_graph("lasta-jardeko.png", "-10y");

?>

<h2>Lasta horo</h2>
<div><img src="lasta-horo.png" /></div>
<h2>Lasta tago</h2>
<div><img src="lasta-tago.png" /></div>
<h2>Lasta semajno</h2>
<div><img src="lasta-semajno.png" /></div>
<h2>Lasta monato</h2>
<div><img src="lasta-monato.png" /></div>
<h2>Lasta jaro</h2>
<div><img src="lasta-jaro.png" /></div>
<h2>Lasta jardeko</h2>
<div><img src="lasta-jardeko.png" /></div>

<?

right();
right_contents();
page_footer();
