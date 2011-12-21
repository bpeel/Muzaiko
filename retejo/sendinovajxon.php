<?php
include('inc/inc.php');

include_once '/var/muzaiko/novajxalisto.php';

function eraro($n) {
	header('Location: http://muzaiko.info/partoprenu?eraro='.$n.'&nomo='.urlencode($_POST['nomo']).'&retposxtadreso='.urlencode($_POST['retposxtadreso']).'&retposxtadresokonfirmo='.urlencode($_POST['retposxtadresokonfirmo']).'&titolo='.urlencode($_POST['titolo']).'&enhavo='.urlencode($_POST['enhavo']).'&fontoj='.urlencode($_POST['fontoj']).'#verku-novajxojn');
	exit();
}

function valida_retadreso($email) {
	$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';
	$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';

	$regex = '/^' . $atom . '+' .
		'(\.' . $atom . '+)*' .
		'@' .
		'(' . $domain . '{1,63}\.)+' .
		$domain . '{2,63}$/i';

	return preg_match($regex, $email);
}

if (empty($_POST['kontrauxspamo'])) {
	if (empty($_POST['nomo']) || empty($_POST['retposxtadreso']) || empty($_POST['retposxtadresokonfirmo']) || empty($_POST['titolo']) || empty($_POST['enhavo']) || empty($_POST['fontoj'])) {
		eraro(1);
	}
	if ($_POST['retposxtadreso'] != $_POST['retposxtadresokonfirmo']) {
		eraro(2);
	}
	if (!valida_retadreso($_POST['retposxtadreso'])) {
		eraro(3);
	}
	$ret = mail($recipient, 'Proponita novaĵo: '.$_POST['titolo'], 'Tiu ĉi novaĵo estas proponita de '.$_POST['nomo'].' <'.$_POST['retposxtadreso'].">.\n\n".$_POST['enhavo']."\n\nFonto(j):\n".$_POST['fontoj'], "From: Proponitaj novaĵoj <proponitaj-novajxoj@muzaiko.info>\r\nContent-type: text/plain; charset=utf-8");
	page_header('Sendi novaĵon');
	if ($ret)
		echo '<div class="sukceso"><p>Via novaĵo estis sukcese sendita. Vi ricevos respondon baldaŭ. Dankon!</p><p>Eble vi emas <a href="./partoprenu#verku-novajxojn">verki plian novaĵon</a>? :-)</p></div>';
	else
		echo '<div class="eraro">Via novaĵo ne estis sendita pro teknika problemo. Provu sendi ĝin retpoŝtmesaĝe al '.$recipient.'. Dankon!</div><div><h1>'.$_POST['titolo'].'</h1>'.$_POST['enhavo'].'</div>';
}

right();
right_contents();
page_footer();
