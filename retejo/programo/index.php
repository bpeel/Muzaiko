<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
include_once('../inc/programo.php');

function is_in_sorted_array($needle, $haystack)
{
  /* Binary search for the file assuming the haystack is sorted */
  $min = 0;
  $max = count($haystack);

  while ($max > $min)
    {
      $mid = floor(($max + $min) / 2);

      if ($haystack[$mid] == $needle)
        return TRUE;
      else if ($haystack[$mid] < $needle)
        $min = $mid + 1;
      else
        $max = $mid;
    }

  return FALSE;
}

function get_unused_files($jes_dosieroj)
{
  global $programagordoj;

  /* Get a sorted list of all the files already used */
  $result = mysql_query("select `nomo` from `sondosiero` order by `nomo` " .
                        "collate utf8_bin");
  $used_files = array();
  while ($row = mysql_fetch_array($result, MYSQL_NUM))
    $used_files[] = stripslashes($row[0]);
  mysql_free_result($result);

  /* Get a list of all the files on the system but filter out all the
     ones that are already used */
  $unused_files = array();
  $dir = opendir($programagordoj["loko_de_programeroj"])
    or die("failed to list sound files");
  while (($fn = readdir($dir)) !== FALSE)
    if ($fn[0] != "." &&
        !is_in_sorted_array($fn, $used_files) &&
        !is_in_sorted_array($fn, $jes_dosieroj))
      $unused_files[] = $fn;
  closedir($dir);

  sort($unused_files);

  return $unused_files;
}

function get_files_for_program($program_id)
{
  $result = mysql_query("select `nomo` from `sondosiero` " .
                        "where `programero` = " . $program_id . " " .
                        "order by `nomo` collate utf8_bin")
    or die("mysql error " . mysql_error());
  $files = array();
  while ($row = mysql_fetch_array($result, MYSQL_NUM))
    $files[] = stripslashes($row[0]);
  mysql_free_result($result);

  return $files;
}

function generate_file_selection($redaktado, $redaktado_id)
{
  print("<script type=\"text/javascript\">\n");
  include("programo-js.php");
  print("</script>\n");

  if ($redaktado)
    {
      if (isset($_POST["sondosieroj"]))
        $jes_dosieroj = $_POST["sondosieroj"];
      else
        $jes_dosieroj = get_files_for_program($redaktado_id);
    }
  else
    $jes_dosieroj = array();

  print("<p>Sondosieroj por la podkasto:</p>\n" .
        "<div>\n" .
        "<div style=\"display:inline-block;padding-left:20px\">\n" .
        "Neinkluzivotaj dosieroj:<br />\n" .
        "<select id=\"nedosieroj\" multiple=\"multiple\" size=\"8\" " .
        "style=\"width:300px\">\n");

  foreach (get_unused_files($jes_dosieroj) as $file)
    print("<option>" . htmlentities($file) . "</option>\n");

  print("</select>\n" .
        "</div>\n" .
        "<div style=\"display:inline-block;padding-left:20px;" .
        "vertical-align:top\">\n" .
        "<button onclick=\"inkluzivuDosierojn()\" " .
        "type=\"button\">→</button><br />\n" .
        "<button onclick=\"malinkluzivuDosierojn()\" " .
        "type=\"button\">←</button>\n" .
        "</div>\n" .
        "<div style=\"display:inline-block;padding-left:20px\">\n" .
        "Inkluzivotaj dosieroj:<br />" .
        "<select id=\"jesdosieroj\" multiple=\"multiple\" size=\"8\" " .
        "style=\"width:300px\">\n");

  foreach ($jes_dosieroj as $file)
    print("<option>" . htmlentities($file) . "</option>\n");

  print("</select>\n" .
        "</div>\n" .
        "</div>\n");
}

function konservu_sondosierojn($programero_id, &$success, &$errors)
{
  mysql_query("delete from `sondosiero` where `programero` = '" .
              addslashes($programero_id) . "'");

  if (empty($_POST['sondosieroj']))
    return;

  foreach ($_POST['sondosieroj'] as $dosiero)
    {
      $res = mysql_query("insert into `sondosiero` (`programero`, `nomo`) " .
                         "values ('" . addslashes($programero_id) . "', '" .
                         addslashes($dosiero) . "')");

      if ($res)
        array_push($success,
                   "Dosiero \"" . htmlentities($dosiero) .
                   "\" sukcese registrita");
      else
        array_push($errors,
                   "Dosiero \"" . htmlentities($dosiero) .
                   "\" malsukcese registrita");
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="eo">
	<head>
		<title>Verki la programon</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="datetimepicker_css.js"></script>
		<script src="../cxapeligado.js"></script>
	</head>
	<body>
		<div id="header">
			<h1><a href=".">Administrado de la programo</a></h1>
		</div>
		<div id="content">
		<?php
			$success = array();
			$errors = array();

			function format_programero($text) {
				$text = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $text);
				$text = preg_replace('/\*([^\*]+)\*/', '<i>$1</i>', $text);
				return $text;
			}

			function is_date($array) {
				if (empty($array))
					return false;
				foreach ($array as $value) {
					if (!empty($value))
						return true;
				}
				return false;
			}

			function is_valid_datetime($datetime) {
				if (preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})(:([0-9]{2}))?$/', $datetime, $matches)) {
					$year = intval($matches[1]);
					$month = intval($matches[2]);
					$day = intval($matches[3]);
					$hours = intval($matches[4]);
					$minutes = intval($matches[5]);
					$seconds = intval($matches[7]);

					return (checkdate($month, $day, $year) && $hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59 && $seconds >= 0 && $seconds <= 59);
				} else
					return false;
			}

			konektu_al_programo();

			if (isset($_POST['registrado'])) {
				$update = false;
				if (!empty($_POST['update']))
					$update = $_POST['update'];
				if ($update && !ctype_digit($_POST['update'])) {
					array_push($errors, 'La identigilo de la programero ne estas valida!');
				} else if (empty($_POST['programero'])) {
					array_push($errors, 'La titolo de la programero devu esti enmetita!');
				} else if (!is_date($_POST['ekoj']) || !is_date($_POST['finoj'])) {
					array_push($errors, 'Almenaŭ unu dato devu esti enmetita!');
				} else {
					if ($update)
						$query = "UPDATE programero SET description = '".addslashes($_POST['programero'])."' WHERE id = ".$update;
					else
						$query = "INSERT INTO programero(description) VALUES('".addslashes($_POST['programero'])."')";
					if (!mysql_query($query)) {
						array_push($errors, 'Programero "'.format_programero(htmlspecialchars($_POST['programero'])).'" ne registrebla. Kontaktu <a href="mailto:admin@muzaiko.info">administriston</a>.');
					} else {
						array_push($success, 'Programero "'.format_programero(htmlspecialchars($_POST['programero'])).'" sukcese registrita.');

						if ($update) {
							$programero_id = $update;
							$query = "DELETE FROM elsendo WHERE programero_id = ".$programero_id;
							mysql_query($query);
						} else
							$programero_id = mysql_insert_id();

						foreach ($_POST['ekoj'] as $key => $value) {
							if (is_valid_datetime($_POST['ekoj'][$key]) && is_valid_datetime($_POST['finoj'][$key])) {
								$query = "INSERT INTO elsendo(date_begin, date_end, programero_id) VALUES('".addslashes($_POST['ekoj'][$key])."', '".addslashes($_POST['finoj'][$key])."', $programero_id)";
								if (mysql_query($query))
									array_push($success, 'Ekdato "'.htmlspecialchars($_POST['ekoj'][$key]).'" kaj findato "'.htmlspecialchars($_POST['finoj'][$key]).'" sukcese registritaj.');
								else
									array_push($errors, 'Ekdato "'.htmlspecialchars($_POST['ekoj'][$key]).'" kaj findato "'.htmlspecialchars($_POST['finoj'][$key]).'" ne registreblaj. Kontaktu <a href="mailto:admin@muzaiko.info">administriston</a>.');
							} else
								array_push($errors, 'Ekdato "'.htmlspecialchars($_POST['ekoj'][$key]).'" kaj findato "'.htmlspecialchars($_POST['finoj'][$key]).'" ne registreblaj. Ĉu ili estas validaj?');
						}

                                                konservu_sondosierojn($programero_id, $success, $errors);
					}


				}
			}

			$redaktado = false;
			$redaktado_id = null;
			$redaktado_titolo = null;
			$redaktado_ekdatoj = array();
			$redaktado_findatoj = array();

			if (isset($_GET['redakti'])) {
				if (ctype_digit($_GET['redakti'])) {
					$query = "SELECT description FROM programero WHERE id = ".$_GET['redakti'];
					if ($result = mysql_query($query)) {
						$row = mysql_fetch_array($result, MYSQL_NUM);
						$redaktado = true;
						$redaktado_id = $_GET['redakti'];
						$redaktado_titolo = $row[0];
						$query = "SELECT DATE_FORMAT(date_begin, '%Y-%m-%d %H:%i'), DATE_FORMAT(date_end, '%Y-%m-%d %H:%i') FROM elsendo WHERE programero_id = ".$redaktado_id;
						$result = mysql_query($query);
						while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
							array_push($redaktado_ekdatoj, $row[0]);
							array_push($redaktado_findatoj, $row[1]);
						}
					}
				}
			}

			$forigado = false;
			$forigado_id = null;
			$forigado_titolo = null;

			if (isset($_GET['forigi'])) {
				if (ctype_digit($_GET['forigi'])) {
					$query = "SELECT description FROM programero WHERE id = ".$_GET['forigi'];
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
					array_push($errors, 'La identigilo de la programero devu esti enmetita!');
				} else if (!ctype_digit($_POST['id'])) {
					array_push($errors, 'La identigilo de la programero ne estas valida!');
				} else {
					$query = "DELETE FROM programero WHERE id = ".$_POST['id'];
					mysql_query($query);
					$query = "DELETE FROM elsendo WHERE programero_id = ".$_POST['id'];
					mysql_query($query);
					array_push($success, 'Programero sukcese forigita.');
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
				printf('<div class="warning"><strong>Atento!</strong><p>Ĉu vi vere volas forigi la programeron "%s" kaj ĝiajn datojn?</p><form action="." method="post"><input type="hidden" name="id" value="%s" /><input type="submit" name="forigi_jes" value="Jes" /> <input type="submit" name="forigi_ne" value="Ne" /></form></div>', $forigado_titolo, $forigado_id);
			} else {
		?>
		<fieldset>
			<legend><?php echo ($redaktado ? 'Redakti' : 'Aldoni novan') ?> programeron</legend>
			<form action="." method="post" id="redaktkamparo">
				<input type="hidden" name="update" value="<?php echo ($redaktado ? $redaktado_id : '') ?>" />
				<label for="programero">Programero</label>
				<input type="text" name="programero" class="programero_input" placeholder="Titolo de la programero" value="<?php echo (isset($_GET['redakti']) ? htmlspecialchars(stripslashes($redaktado_titolo)) : '') ?>" /><br />
				<div id="text_format">
					<p>Por fari ligilon, faru tiel: <code>[teksto de la ligilon](adreso)</code>. Ekzemplo: <code>Bonvenon ĉe [Radio Muzaiko](http://www.muzaiko.info/)</code> produktos "Bonvenon ĉe <a href="http://www.muzaiko.info/">Radio Muzaiko</a>".</p>
					<p>Por fari kursivan tekston, faru tiel: <code>*kursiva teksto*</code>. Ekzemplo: <code>Bonvenon ĉe *Radio Muzaiko*</code> produktos "Bonvenon ĉe <i>Radio Muzaiko</i>".</p>
				</div>
				<div id="datoj">
						<?php
							$counter = 1;
							if ($redaktado) {
								$counter = 0;
								foreach ($redaktado_ekdatoj as $key => $value) {
									$counter++;
									printf('<div id="dato%s">', $counter);
									printf('<label for="eko%s">Dato %s</label>&nbsp;', $counter, $counter);
									printf('<input type="text" class="dato_input" name="ekoj[]" id="eko%s" placeholder="Eko" value="%s" onclick="javascript:NewCssCal(\'eko%s\', \'yyyyMMdd\', \'arrow\', true, \'24\', false)" />&nbsp;', $counter, $redaktado_ekdatoj[$key], $counter);
									printf('<input type="text" class="dato_input" name="finoj[]" id="fino%s" placeholder="Fino" value="%s" onclick="javascript:NewCssCal(\'fino%s\', \'yyyyMMdd\', \'arrow\', true, \'24\', false)" />&nbsp;', $counter, $redaktado_findatoj[$key], $counter);
									printf('<a href="#" title="Forigi ĉi tiun daton" onclick="javascript:forigiDaton(%s)"><img src="images/forigi_malgranda.png" alt="Forigi ĉi tiun daton" /></a>', $counter);
									printf('</div>');
								}
							} else {
						?>
					<div id="dato1">
						<label for="eko1">Dato 1</label>
						<input type="text" class="dato_input" name="ekoj[]" id="eko1" placeholder="Eko"  onclick="javascript:NewCssCal('eko1', 'yyyyMMdd', 'arrow', true, '24', false)" />
						<input type="text" class="dato_input" name="finoj[]" id="fino1" placeholder="Fino" onclick="javascript:NewCssCal('fino1', 'yyyyMMdd', 'arrow', true, '24', false)" />
						<a href="#" title="Forigi ĉi tiun daton" onclick="javascript:forigiDaton(1)"><img src="images/forigi_malgranda.png" alt="Forigi ĉi tiun daton" /></a>
					</div>
						<?php
							}
						?>
				</div>
				<input type="button" value="Aldoni daton" onclick="aldoniDaton();" /><br />
				<?php generate_file_selection($redaktado, $redaktado_id); ?>
				<input type="submit" name="registrado" value="<?php echo ($redaktado ? 'Registri la ŝanĝojn' : 'Registri tiun novan programeron') ?>" onclick="gxisdatiguSondosierojn();" />
				<input type="submit" name="nuligi" value="Nuligi" />
			</form>
		</fieldset>
		<?php
			}
		?>

		<script type="text/javascript">
			var counter = <?php echo $counter; ?>;
			function aldoniDaton() {
				counter++;
				var newdiv = document.createElement('div');
				newdiv.id = 'dato'+counter;
				newdiv.innerHTML = "<label for=\"eko" + counter + "\">Dato " + counter + "</label> <input type=\"text\" class=\"dato_input\" name=\"ekoj[]\" id=\"eko" + counter + "\" placeholder=\"Eko\" onclick=\"javascript:NewCssCal('eko" + counter + "', 'yyyyMMdd', 'arrow', true, '24')\" /> <input type=\"text\" class=\"dato_input\" name=\"finoj[]\" id=\"fino" + counter + "\" placeholder=\"Fino\" onclick=\"javascript:NewCssCal('fino" + counter + "', 'yyyyMMdd', 'arrow', true, '24')\" /> <a href=\"#\" title=\"Forigi ĉi tiun daton\" onclick=\"javascript:forigiDaton(" + counter + ")\"><img src=\"images/forigi_malgranda.png\" alt=\"Forigi ĉi tiun daton\" /></a>";
				document.getElementById('datoj').appendChild(newdiv);
			}
			function forigiDaton(id) {
				document.getElementById('datoj').removeChild(document.getElementById('dato'+id));
			}
		</script>

		<h2>Programeroj</h2>

		<table>
			<tr>
				<th>Programero</th>
				<th class="date_column">Datoj</th>
				<th>Redakti</th>
				<th>Forigi</th>
			</tr>

<?php

$query = "SELECT id, description FROM programero, elsendo WHERE id = programero_id GROUP BY id ORDER BY date_begin ASC";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	printf('<tr><td>%s</td><td class="date_column"><ul>', format_programero(htmlspecialchars(stripslashes($row[1]))));
	$query2 = "SELECT DATE_FORMAT(date_begin, '%Y-%m-%d&nbsp;%H:%i'), DATE_FORMAT(date_end, '%Y-%m-%d&nbsp;%H:%i') FROM elsendo WHERE programero_id = ".$row[0];
	$result2 = mysql_query($query2);
	while ($row2 = mysql_fetch_array($result2, MYSQL_NUM)) {
		printf('<li>%s &mdash; %s</li>', $row2[0], $row2[1]);
	}
	printf('</ul></td><td><a href="?redakti=%s" title="Redakti ĉi tiun programeron"><img src="images/redakti.png" alt="Redakti ĉi tiun pogrameron" /></a></td><td><a href="?forigi=%s" title="Forigi ĉi tiun programeron"><img src="images/forigi.png" alt="Forigi ĉi tiun pogrameron" /></a></td></tr>', $row[0], $row[0]);
}



/*
$query = "SELECT programero.id, DATE_FORMAT(date_begin, '%Y-%m-%d %H:%i'), DATE_FORMAT(date_end, '%Y-%m-%d %H:%i'), description FROM programero, elsendo WHERE programero.id = elsendo.programero_id ORDER BY date_begin ASC";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	printf('<tr><td>%s</td><td>%s</td><td>%s</td><td><a href="?redakti=%s">Redakti</a></td><td><a href="?forigi=%s">Forigi</a></td></tr>', $row[1], $row[2], $row[3], $row[0], $row[0]);
}
*/
mysql_close();

?>

		</table>
		</div>
	</body>
</html>

