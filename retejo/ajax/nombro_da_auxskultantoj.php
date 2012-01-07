<?php

$url = 'http://api.radionomy.com/currentaudience.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181';
// $handle = fopen($url, "r");

$handle = file_get_contents($url);
echo 'Nombro de aŭskultantoj (laŭ Radionomy, eble ne tute preciza): ' . $handle;

?>
