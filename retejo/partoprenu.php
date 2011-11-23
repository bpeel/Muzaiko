<?php
include('inc/inc.php');
page_header('Partoprenu');
?>
<p>
Muzaiko estas kunlabora retradioprojekto. Se vi ŝatas fari intervjuojn, jam
faras podkastojn, muzikon, aŭ interesiĝas pri la teĥnika, organiza flanko,
vi estas tre bonvena en la teamo! Skribu al <b>info (ĉe) muzaiko.info</b> por
pli da informoj.
</p>

<p>
	Vi povas ankaux aliĝi al unu el niaj Gugl-grupoj:
	<ul>
		<li><a href="https://groups.google.com/group/retradio-projekto" target="_blank" name="retradio-projekto">retradio-projekto</a></li>
		<li><a href="https://groups.google.com/group/retradio-novajxoj" target="_blank" name="retradio-novajxoj">retradio-novaĵoj</a></li>
		<li><a href="https://groups.google.com/group/varbado-pri-retradio" target="_blank" name="varbado-pri-retradio">varbado-pri-retradio</a></li>
		<li><a href="https://groups.google.com/group/retradio-retpagxo" target="_blank" name="retradio-retpagxo">retradio-retpagxo</a></li>
		<li><a href="https://groups.google.com/group/retradio-legxaj-kaj-budgxetaj-aferoj" target="_blank" name="retradio-legxaj-kaj-budgxetaj-aferoj">retradio-leĝaj-kaj-budĝetaj-aferoj</a></li>
	</ul>
</p>

<p>
	Diversaj retpaĝoj rilatitaj al muzaiko.info:
	<ul>
		<li><a href="http://www.radionomy.com/en/radio/muzaikoinfo" target="_blank">Muzaiko ĉe Radionomy</a></li>
		<li><a href="ftp://muzaiko.info/" target="_blank">FTP por elŝutaĵojn</a></li>
 		<li><a href="http://vikio.muzaiko.info/" target="_blank">Vikio</a></li>
 		<li><a href="http://cimoj.muzaiko.info/" target="_blank">Cimŝpurilo</a></li>
<!-- 		<li><a href="http://muzaiko.info/sengit/drupal7/" target="_blank">Provpaĝo kun Drupalo</a></li>
		<li><a href="https://github.com/bpeel/Muzaiko" target="_blank">git deponejo por la kodo de la retpaĝo kaj aliaj aĵoj</a></li>
 --> 	</ul>
</p>

<h1 id="verku-novajxojn">Verku novaĵojn</h1>

<div id="verku-novajxon-content">
	<p>Se vi emas, vi povas verki novaĵojn, kiuj eble estos laŭtlegata de Muzaiko. La reguloj por ĝuste verki novaĵojn troviĝas <a href="http://vikio.muzaiko.info/index.php/Novaĵo">ĉe la vikio</a>.</p> 
	<p>Pensu ke la novaĵoj devu esti koncizaj, facilkompreneblaj, kaj laŭeble neŭtralaj. Ĉiam menciu la fonton, bonvolu!</p>

  <?php
  	if (!empty($_GET['eraro'])) {
		if ($_GET['eraro'] == 1)
			echo '<div class="eraro">Bonvolu plenigi ĉiujn kampojn.</div>';
		else if ($_GET['eraro'] == 2)
			echo '<div class="eraro">Via retpoŝtadreso kaj sia konfirmo ne estas same.</div>';
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
        <li id="kontrauxspamajxo"><label for="kontrauxspamo">Ne plenigu tiun kampon</label><input type="text" name="kontrauxspamo" id="kontrauxspamo" /></li>
        <li><input type="submit" name="novajxo" value="Sendi" /></li>
      </ol>
    </fieldset>
  </form>
</div>

<?php
right();
right_contents();
page_footer();
