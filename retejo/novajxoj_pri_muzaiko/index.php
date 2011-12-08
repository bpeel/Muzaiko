<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="eo">
	<head>
		<title>Verki novaĵon</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div id="header">
			<h1><a href=".">Administrado de la novaĵoj pri muzaiko</a></h1>
		</div>
		<div id="content">
		<?php
			require_once('/var/muzaiko/novajxojdatumbazensalutiloj.php');

			$success = array();
			$errors = array();

			mysql_connect($novajxoj_host, $novajxoj_uzantnomo, $novajxoj_pasvorto) or die(mysql_error());
			mysql_select_db($novajxoj_pri_datumbazo) or die(mysql_error());

			if (isset($_POST['registrado'])) {
				$update = false;
				if (!empty($_POST['update']))
					$update = $_POST['update'];
				if ($update && !ctype_digit($_POST['update']))
					array_push($errors, 'La identigilo de la novaĵo ne estas valida!');
				if (empty($_POST['titolo']))
					array_push($errors, 'La titolo de la novaĵo devu esti plenigita!');
				if (empty($_POST['enhavo']))
					array_push($errors, 'La enhavo de la novaĵo devu esti plenigita!');
				if (empty($errors)) {
					if ($update)
						$query = "UPDATE novajxo SET titolo = '".addslashes($_POST['titolo'])."', enhavo = '".addslashes($_POST['enhavo'])."', redaktado_dato = NOW() WHERE id = ".$update;
					else
						$query = "INSERT INTO novajxo(titolo, enhavo, dato) VALUES('".addslashes($_POST['titolo'])."', '".addslashes($_POST['enhavo'])."', NOW())";
					if (!mysql_query($query)) {
						array_push($errors, 'Novaĵo "'.htmlspecialchars($_POST['titolo']).'" ne registrebla. Kontaktu <a href="mailto:admin@muzaiko.info">administriston</a>.');
					} else {
						array_push($success, 'Novaĵo "'.htmlspecialchars($_POST['titolo']).'" sukcese registrita.');
					}
				}
			}

			$redaktado = false;
			$redaktado_id = null;
			$redaktado_titolo = null;
			$redaktado_enhavo = null;

			if (isset($_GET['redakti'])) {
				if (ctype_digit($_GET['redakti'])) {
					$query = "SELECT titolo, enhavo FROM novajxo WHERE id = ".$_GET['redakti'];
					if ($result = mysql_query($query)) {
						$row = mysql_fetch_array($result, MYSQL_NUM);
						$redaktado = true;
						$redaktado_id = $_GET['redakti'];
						$redaktado_titolo = $row[0];
						$redaktado_enhavo = $row[1];
					}
				}
			}

			$forigado = false;
			$forigado_id = null;
			$forigado_titolo = null;

			if (isset($_GET['forigi'])) {
				if (ctype_digit($_GET['forigi'])) {
					$query = "SELECT titolo FROM novajxo WHERE id = ".$_GET['forigi'];
					if ($result = mysql_query($query)) {
						$row = mysql_fetch_array($result, MYSQL_NUM);
						$forigado = true;
						$forigado_id = $_GET['forigi'];
						$forigado_titolo = $row[0];
					}
				}
			}

			if (isset($_POST['forigi_jes'])) {
				if (empty($_POST['id'])) {
					array_push($errors, 'La identigilo de la novaĵo devu esti enmetita!');
				} else if (!ctype_digit($_POST['id'])) {
					array_push($errors, 'La identigilo de la novaĵo ne estas valida!');
				} else {
					$query = "DELETE FROM novajxo WHERE id = ".$_POST['id'];
					mysql_query($query);
					array_push($success, 'Novaĵo sukcese forigita.');
				}
			}

			if (!empty($success)) {
				echo '<div class="success">Sukcesoj:<ul>';
				foreach ($success as $value)
					echo '<li>'.$value.'</li>';
				echo '</ul></div>';
			}
			if (!empty($errors)) {
				echo '<div class="errors">Eraroj:<ul>';
				foreach ($errors as $value)
					echo '<li>'.$value.'</li>';
				echo '</ul></div>';
			}

			if ($forigado) {
				printf('<div class="warning"><strong>Atento!</strong><p>Ĉu vi vere volas forigi la novaĵon "%s"?</p><form action="." method="post"><input type="hidden" name="id" value="%s" /><input type="submit" name="forigi_jes" value="Jes" /> <input type="submit" name="forigi_ne" value="Ne" /></form></div>', $forigado_titolo, $forigado_id);
			} else {
				$input_titolo = '';
				$input_enhavo = '';
				if (isset($_GET['redakti'])) {
					$input_titolo = htmlspecialchars(stripslashes($redaktado_titolo));
					$input_enhavo = htmlspecialchars(stripslashes($redaktado_enhavo));
				} else if (isset($_POST['registrado']) && !empty($errors)) {
					if ($_POST['registrado'] == 'Registri la ŝanĝojn') {
						$redaktado = true;
						$redaktado_id = htmlspecialchars($_POST['update']);
					}
					$input_titolo = htmlspecialchars($_POST['titolo']);
					$input_enhavo = htmlspecialchars($_POST['enhavo']);
				}
		?>
		<fieldset>
			<div id="text_format">
				La Markdown-a sintakso estas uzata por formati la tekston (<a href="http://michelf.com/projects/php-markdown/concepts/">baza sintakso (en)</a>, <a href="http://michelf.com/projects/php-markdown/extra/">ekstra sintakso (en)</a>). Se vi uzas titolojn, bonvolu komenci ekde la tria nivelo (===).
			</div>
			<legend><?php echo ($redaktado ? 'Redakti' : 'Aldoni') ?> novaĵon</legend>
			<form action="." method="post">
			<ol>
				<li><input type="hidden" name="update" value="<?php echo ($redaktado ? $redaktado_id : '') ?>" /></li>
				<li><label for="titolo">Titolo</label>
				<input type="text" name="titolo" id="titolo" class="titolo_input" placeholder="Titolo de la novaĵo" value="<?php echo $input_titolo; ?>" /></li>
				<li><label for="enhavo">Enhavo</label>
				<textarea rows="10" cols="100" name="enhavo" id="enhavo" class="enhavo_input" placeholder="Enhavo de la novaĵo"><?php echo $input_enhavo; ?></textarea></li>
				<li><input type="submit" name="registrado" value="<?php echo ($redaktado ? 'Registri la ŝanĝojn' : 'Registri tiun novaĵon') ?>" />
				<input type="submit" name="nuligi" value="Nuligi" /></li>
			</ol>
			</form>
		</fieldset>
		<?php
			}
		?>

		<h2>Novaĵoj</h2>

		<table>
			<tr>
				<th>Novaĵo</th>
				<th>Redakti</th>
				<th>Forigi</th>
			</tr>

<?php
include_once "../markdown.php";

$query = "SELECT id, titolo, enhavo, DATE_FORMAT(dato, '%Y/%m/%d %H:%i') FROM novajxo ORDER BY dato DESC";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	printf('<tr><td><h1>%s</h1><div class="dato">Publikigita la %s UTC</div><div>%s</div></td>', htmlspecialchars(stripslashes($row[1])), $row[3], Markdown(stripslashes($row[2])));
	printf('<td><a href="?redakti=%s" title="Redakti ĉi tiun novaĵon"><img src="images/redakti.png" alt="Redakti ĉi tiun novaĵon" /></a></td><td><a href="?forigi=%s" title="Forigi ĉi tiun novaĵon"><img src="images/forigi.png" alt="Forigi ĉi tiun novaĵon" /></a></td></tr>', $row[0], $row[0]);
}

mysql_close();

?>

		</table>
		</div>
	</body>
</html>

