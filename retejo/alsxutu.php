<?php
include('inc/inc.php');
page_header('Alŝuti dosieron');

$target_dir = '/mnt/musashi.fr/ftp/htmlformularo';
$recipient = 'admin@muzaiko.info';
$size_limit = 30000000;

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

//      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//      echo "Type: " . $_FILES["file"]["type"] . "<br />";
//      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
if (isset($_POST['submit']) && $_POST['kontrauxspamo'] == '') {
  if (empty($_POST['name'])) {
    echo '<div class="eraro">Via nomo ne estis enmetita.</div>';
  } else {
    if (empty($_POST['email']) || !valida_retadreso($_POST['email'])) {
      echo '<div class="eraro">Via retpoŝtadreso ne estas valida.</div>';
    } else {
      if (empty($_FILES['file']['name'])) {
        echo '<div class="eraro">Vi ne elektis alŝutotan dosieron.</div>';
      } else {
        if ($_FILES['file']['size'] > $size_limit) {
          echo '<div class="eraro">La dosiero estas tro granda (> 30 MB).</div>';
        } else if ($_FILES['file']['error'] > 0) {
            switch ($_FILES['file']['error']) {
              case 1: // UPLOAD_ERR_INI_SIZE
                echo '<div class="eraro">La dosiero transpasas la grandecon permisita de PHP.</div>';
                break;
              case 2: // UPLOAD_ERR_FORM_SIZE
                echo '<div class="eraro">La dosiero transpasas la grandecon permisita de la HTML-formularo.</div>';
                break;
              case 3: // UPLOAD_ERR_PARTIAL
                echo '<div class="eraro">La alŝutado de la dosiero estis ial ĉesigita.</div>';
                break;
              case 4: // UPLOAD_ERR_NO_FILE
                echo '<div class="eraro">La dosiero havas 0 kiel grandeco.</div>';
                break;
            }
        } else {
          $filename = $_FILES['file']['name'];
          $array = 'abcdefghijklmnopqrstuvwxyz';
          while (file_exists($target_dir.'/'.$filename)) {
            $filename = $array[mt_rand(0, 26)].$_FILES['file']['name'];
          }
          $filename = $target_dir.'/'.$filename;
          if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
            mail($recipient, 'Nova dosiero alŝutita per la HTML-formularo', 'Nova dosiero estis alŝutita de '.$_POST['name'].' <'.$_POST['email'].'>. Ĝi troviĝas ĉe: '.$filename, "From: Alŝutitaj dosieroj <alŝutitaj-dosieroj@muzaiko.info>\r\nContent-type: text/plain; charset=utf-8");
            echo '<div class="sukceso"><p>Via dosiero estis sukcese alŝutita. Vi ricevos respondon baldaŭ. Dankon!</p><p>Vi povas alŝuti pliajn dosierojn se vi emas. :-)</p></div>';
          } else {
            echo '<div class="eraro">Via dosiero ne estis sukcese kopiita pro teknika problemo.</div>';
          }
        }
      }
    }
  }
}

?>

<div class="formularo">
  <p>Alŝutante dosieron per tiu ĉi formularo, vi publikigas ĝin laŭ
permesilo <a href="http://creativecommons.org/licenses/by-sa/2.0/deed.eo">CC-by-sa</a>. Se vi ne konsentas, ne alŝutu sed kontaktu nin
rekte.</p>
  <form action="" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Alŝuti dosieron</legend>
      <ol style="">
        <li>
          <label for="name">Via nomo</label>
          <input type="text" name="name" id="name" />
        </li>
        <li>
          <label for="email">Via retpoŝtadreso</label>
          <input type="text" name="email" id="email" />
        </li>
        <li>
          <label for="file">Via alŝutota dosiero</label>
          <input type="file" name="file" id="file" />
        <li class="kontrauxspamajxo">
          <label for="kontrauxspamo">Ne plenigu tiun kampon</label>
          <input type="text" name="kontrauxspamo" id="kontrauxspamo" />
        </li>
        <li>
          <input type="submit" name="submit" value="Alŝuti la dosieron" />
        </li>
      </ol>
    </fieldset>
  </form>
</div>

<?php
right();
right_contents();
page_footer();
