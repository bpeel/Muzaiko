<?php
include('inc/inc.php');
page_header('Novaĵoj pri Muzaiko');
?>

<!-- <h1 id="verku-novajxojn">Novaĵoj pri Muzaiko</h1> -->

<!-- ================= -->
<?php

include_once "markdown.php";

mysql_connect($novajxoj_host, $novajxoj_uzantnomo, $novajxoj_pasvorto) or die(mysql_error());
mysql_select_db($novajxoj_pri_datumbazo) or die(mysql_error());

$query = "SELECT COUNT(*) FROM novajxo";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_NUM);
$news_count = $row[0];
$news_display_limit = 3;
$news_pages_count = ceil($news_count / $news_display_limit);
$current_page = (isset($_GET['p']) && ctype_digit($_GET['p'])) ? $_GET['p'] : 1;

$query = "SELECT titolo, enhavo, DATE_FORMAT(dato, '%Y/%m/%d %H:%i'), IF(redaktado_dato > (dato + 120), DATE_FORMAT(redaktado_dato, '%Y/%m/%d %H:%i'), NULL)  FROM novajxo ORDER BY dato DESC LIMIT ".(($current_page - 1) * $news_display_limit).', '.$news_display_limit;
$result = mysql_query($query);

mysql_close();

/* montri novaĵoj */
echo '<div id="novajxoj">';
if (mysql_num_rows($result) == 0) {
	echo 'Neniu publikigita novaĵo.';
}
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	        printf('<div class="novajxo"><h2 class="novajxo_titolo">%s</h2><div class="novajxo_dato">Publikigita je la %s UTC%s</div><div class="novajxo_enhavo">%s</div></div>', htmlspecialchars(stripslashes($row[0])), $row[2], (($row[3] == NULL) ? '' : " (redaktita je la $row[3] UTC)"), Markdown(stripslashes($row[1])));
}
echo '</div>';


/* montri paĝojn */
if ($news_pages_count > 1) {
	echo '<div id="novajxoj_pagxoj"><ol>';
	if ($current_page > 1)
		echo '<li><a href="./?p='.($current_page-1).'#novajxoj" title="">antaŭaj novaĵoj</a></li>';
	for ($i = 1; $i < ($news_pages_count + 1); $i++) {
		echo '<li><a href="./?p='.$i.'#novajxoj"'.(($current_page == $i) ? 'class="elektita_pagxo"' : '').'>'.$i.'</a></li>';
	}
	if ($current_page < $news_pages_count)
		echo '<li><a href="./?p='.($current_page+1).'#novajxoj" title="">postaj novaĵoj</a></li>';
	echo '</ol></div>';
}

?>

<!-- ================= -->
<h1 id="verku-novajxojn">Novaĵoj el la tuta mondo, por la tuta mondo</h1>

<?php

include_once "markdown.php";

mysql_connect($novajxoj_host, $novajxoj_uzantnomo, $novajxoj_pasvorto) or die(mysql_error());
mysql_select_db($novajxoj_de_datumbazo) or die(mysql_error());

$query = "SELECT COUNT(*) FROM novajxo";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_NUM);
$news_count = $row[0];
$news_display_limit = 3;
$news_pages_count = ceil($news_count / $news_display_limit);
$current_page = (isset($_GET['p']) && ctype_digit($_GET['p'])) ? $_GET['p'] : 1;

$query = "SELECT titolo, enhavo, DATE_FORMAT(dato, '%Y/%m/%d %H:%i'), IF(redaktado_dato > (dato + 120), DATE_FORMAT(redaktado_dato, '%Y/%m/%d %H:%i'), NULL)  FROM novajxo ORDER BY dato DESC LIMIT ".(($current_page - 1) * $news_display_limit).', '.$news_display_limit;
$result = mysql_query($query);

mysql_close();

/* montri novaĵoj */
echo '<div id="novajxoj">';
if (mysql_num_rows($result) == 0) {
	echo 'Neniu publikigita novaĵo.';
}
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	        printf('<div class="novajxo"><h2 class="novajxo_titolo">%s</h2><div class="novajxo_dato">Publikigita je la %s UTC%s</div><div class="novajxo_enhavo">%s</div></div>', htmlspecialchars(stripslashes($row[0])), $row[2], (($row[3] == NULL) ? '' : " (redaktita je la $row[3] UTC)"), Markdown(stripslashes($row[1])));
}
echo '</div>';


/* montri paĝojn */
if ($news_pages_count > 1) {
	echo '<div id="novajxoj_pagxoj"><ol>';
	if ($current_page > 1)
		echo '<li><a href="./?p='.($current_page-1).'#novajxoj" title="">antaŭaj novaĵoj</a></li>';
	for ($i = 1; $i < ($news_pages_count + 1); $i++) {
		echo '<li><a href="./?p='.$i.'#novajxoj"'.(($current_page == $i) ? 'class="elektita_pagxo"' : '').'>'.$i.'</a></li>';
	}
	if ($current_page < $news_pages_count)
		echo '<li><a href="./?p='.($current_page+1).'#novajxoj" title="">postaj novaĵoj</a></li>';
	echo '</ol></div>';
}

?>

<!-- ================= -->

<h1 id="verku-novajxojn">Verku novaĵojn</h1>

<div id="verku-novajxon-content">
	<p>Verku novaĵojn por Muzaiko! (ekzemple pri via lando, aŭ pri interesaj temoj) La reguloj por verki novaĵojn troviĝas <a href="http://vikio.muzaiko.info/index.php/Novaĵo">ĉe la vikio</a>.</p>
	<p>Atentu pri ke la novaĵoj devas esti koncizaj, facilkompreneblaj, kaj laŭeble neŭtralaj. Ĉiam menciu la fonton, bonvolu!</p>

  <?php
  	if (!empty($_GET['eraro'])) {
		if ($_GET['eraro'] == 1)
			echo '<div class="eraro">Bonvolu plenigi ĉiujn kampojn.</div>';
		else if ($_GET['eraro'] == 2)
			echo '<div class="eraro">Via retpoŝtadreso kaj sia konfirmo ne estas same.</div>';
		else if ($_GET['eraro'] == 3)
			echo '<div class="eraro">Via retpoŝtadreso ŝajnas ne esti valida.</div>';
	}
  ?>

  <form method="post" action="http://muzaiko.info/sendinovajxon">
    <fieldset>
      <legend>Sendi novaĵon</legend>
      <ol>
        <li><label for="nomo">Via nomo</label><input type="text" name="nomo" id="nomo"<?php echo (empty($_GET['nomo']) ? '' : ' value="'.htmlspecialchars($_GET['nomo']).'"') ?> /></li>
        <li><label for="retposxtadreso">Via retpoŝtadreso</label><input type="text" name="retposxtadreso" id="retposxtadreso"<?php echo (empty($_GET['retposxtadreso']) ? '' : ' value="'.htmlspecialchars($_GET['retposxtadreso']).'"') ?> /></li>
        <li><label for="retposxtadresokonfirmo">Retajpu vian retpoŝtadreson</label><input type="text" name="retposxtadresokonfirmo" id="retposxtadresokonfirmo"<?php echo (empty($_GET['retposxtadresokonfirmo']) ? '' : ' value="'.htmlspecialchars($_GET['retposxtadresokonfirmo']).'"') ?> /></li>
        <li><label for="titolo">Titolo de la novaĵo</label><input type="text" name="titolo" id="titolo"<?php echo (empty($_GET['titolo']) ? '' : ' value="'.htmlspecialchars($_GET['titolo']).'"') ?> /></li>
        <li><label for="enhavo">Enhavo de la novaĵo</label><textarea cols="50" rows="20" name="enhavo" id="enhavo"><?php echo (empty($_GET['enhavo']) ? '' : htmlspecialchars($_GET['enhavo'])) ?></textarea></li>
        <li><label for="fontoj">Fonto(j) de la novaĵo</label><textarea cols="50" rows="5" name="fontoj" id="fontoj"><?php echo (empty($_GET['fontoj']) ? '' : htmlspecialchars($_GET['fontoj'])) ?></textarea></li>
        <li id="kontrauxspamajxo"><label for="kontrauxspamo">Ne plenigu tiun kampon</label><input type="text" name="kontrauxspamo" id="kontrauxspamo" /></li>
        <li><input type="submit" name="novajxo" value="Sendi" /></li>
      </ol>
    </fieldset>
  </form>
</div>
<!-- ================= -->

<?php
right();
right_contents();
page_footer();
