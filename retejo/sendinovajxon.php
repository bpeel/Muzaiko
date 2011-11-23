<?php
include('inc/inc.php');

include_once '/var/muzaiko/novajxalisto.php';

if (empty($_POST['kontrauxspamo'])) {
	if (empty($_POST['nomo']) || empty($_POST['retposxtadreso']) || empty($_POST['retposxtadresokonfirmo']) || empty($_POST['titolo']) || empty($_POST['enhavo'])) {
		header('Location: http://muzaiko.info/partoprenu?eraro=1&nomo='.urlencode($_POST['nomo']).'&retposxtadreso='.urlencode($_POST['retposxtadreso']).'&retposxtadresokonfirmo='.urlencode($_POST['retposxtadresokonfirmo']).'&titolo='.urlencode($_POST['titolo']).'&enhavo='.urlencode($_POST['enhavo']).'#verku-novajxojn');
		exit();
	}
	if ($_POST['retposxtadreso'] != $_POST['retposxtadresokonfirmo']) {
		header('Location: http://localhost/retejo/partoprenu?eraro=2&nomo='.urlencode($_POST['nomo']).'&retposxtadreso='.urlencode($_POST['retposxtadreso']).'&retposxtadresokonfirmo='.urlencode($_POST['retposxtadresokonfirmo']).'&titolo='.urlencode($_POST['titolo']).'&enhavo='.urlencode($_POST['enhavo']).'#verku-novajxojn');
		exit();
	}
	$ret = mail($recipient, 'Proponita novaĵo: '.$_POST['titolo'], 'Tiu ĉi novaĵo estas proponita de '.$_POST['nomo'].' <'.$_POST['retposxtadreso'].">.\n\n".$_POST['enhavo'], 'From: '.$_POST['nomo'].' <'.$_POST['retposxtadreso'].">\r\nContent-type: text/plain; charset=utf-8");
	page_header('Sendi novaĵon');
	if ($ret)
		echo '<div class="sukceso"><p>Via novaĵo estis sukcese sendita. Vi ricevos respondon baldaŭ. Dankon!</p><p>Eble vi emas <a href="./partoprenu#verku-novajxojn">verki plian novaĵon</a>? :-)</p></div>';
	else
		echo '<div class="eraro">Via novaĵo ne estis sendita pro teknika problemo. Provu sendi ĝin retpoŝtmesaĝe al '.$recipient.'. Dankon!</div><div><h1>'.$_POST['titolo'].'</h1>'.$_POST['enhavo'].'</div>';
}

right();
right_contents();
page_footer();
