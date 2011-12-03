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
create_graph("lasta-monato.png", "-1m");
create_graph("lasta-jaro.png", "-1y");

?>

<h1>Lasta hoto</h1>
<div><img src="lasta-horo.png" /></div>
<h1>Lasta tago</h1>
<div><img src="lasta-tago.png" /></div>
<h1>Lasta monato</h1>
<div><img src="lasta-monato.png" /></div>
<h1>Lasta jaro</h1>
<div><img src="lasta-jaro.png" /></div>

<?

right();
right_contents();
page_footer();
