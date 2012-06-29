<!DOCTYPE html>
<html lang="eo">
  <head>
    <meta charset="utf-8">
    <title>Aldoni muzikan verkon</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
  </head>
  <body>
    <header>
      <h1>Aldoni muzikan verkon</h1>
    </header>
    <div id="content">
      <?php
$sql_peto = <<<EOF
INSERT INTO muzaiko_datumbazo(Artistoj, Titolo, Ligoj_al_diskoservo, Ligoj_al_la_elsxutejo, Ligoj_al_muzikteksto, Ligoj_al_retpagxo, Ligoj_al_CD1D, REF, ISRC_Kodoj, Dauxroj, Verkistoj, Komponistoj, Arangxistoj, Adaptistoj, Produktistoj_kaj_redaktantoj, Jaroj, Eldonejo, RY_Artistoj, RY_Titolo)
VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);
EOF;
        function validigi($kampo) {
          return (empty($kampo) ? 'NULL' : "'".addslashes($kampo)."'");
        }
        if (isset($_POST['muzika-verko'])) {
          $sql = sprintf($sql_peto, validigi($_POST['artisto']), validigi($_POST['titolo']), validigi($_POST['diskoservo']), validigi($_POST['elsxutejo']), validigi($_POST['muzikteksto']), validigi($_POST['retpagxo']), validigi($_POST['cd1d']), validigi($_POST['ref']), validigi($_POST['isrc']), validigi($_POST['dauxro']), validigi($_POST['verkisto']), validigi($_POST['komponisto']), validigi($_POST['arangxisto']), validigi($_POST['adaptisto']), validigi($_POST['produktisto-redaktanto']), validigi($_POST['jaro']), validigi($_POST['eldonejo']), validigi($_POST['ry-artisto']), validigi($_POST['ry-titolo']));
          $programagordoj = parse_ini_file("/var/muzaiko/programagordoj.ini");
          mysql_connect($programagordoj['kantdb_host'], $programagordoj['kantdb_user'], $programagordoj['kantdb_passwd']) or die(mysql_error());
          mysql_select_db($programagordoj['kantdb_db']) or die(mysql_error());
          mysql_set_charset('utf8') or die(mysql_error());
          mysql_query($sql) or die(mysql_error());
          print('<div id="sukcesmesagxo">Nova muzika verko sukcese registrita.</div>');
          mysql_close() or die(mysql_error());
        }
      ?>
      <form method="post">
        <ol>
          <li>
            <label for="artisto">Artisto</label>
            <input type="text" name="artisto" id="artisto" />
          </li>
          <li>
            <label for="titolo">Titolo</label>
            <input type="text" name="titolo" id="titolo" />
          </li>
          <li>
            <label for="diskoservo">URL al la diskoservo</label>
            <input type="text" name="diskoservo" id="diskoservo" />
          </li>
          <li>
            <label for="elsxutejo">URL al la elŝutejo</label>
            <input type="text" name="elsxutejo" id="elsxutejo" />
          </li>
          <li>
            <label for="muzikteksto">URL al la muzikteksto</label>
            <input type="text" name="muzikteksto" id="muzikteksto" />
          </li>
          <li>
            <label for="retpagxo">URL al la retpaĝo</label>
            <input type="text" name="retpagxo" id="retpagxo" />
          </li>
          <li>
            <label for="cd1d">URL al CD1D</label>
            <input type="text" name="cd1d" id="cd1d" />
          </li>
          <li>
            <label for="ref">REF</label>
            <input type="text" name="ref" id="ref" />
          </li>
          <li>
            <label for="isrc">ISRC-kodo</label>
            <input type="text" name="isrc" id="isrc" />
          </li>
          <li>
            <label for="dauxro">Daŭro</label>
            <input type="text" name="dauxro" id="dauxro" />
          </li>
          <li>
            <label for="verkisto">Verkisto</label>
            <input type="text" name="verkisto" id="verkisto" />
          </li>
          <li>
            <label for="komponisto">Komponisto</label>
            <input type="text" name="komponisto" id="komponisto" />
          </li>
          <li>
            <label for="arangxisto">Aranĝisto</label>
            <input type="text" name="arangxisto" id="arangxisto" />
          </li>
          <li>
            <label for="adaptisto">Adaptisto</label>
            <input type="text" name="adaptisto" id="adaptisto" />
          </li>
          <li>
            <label for="produktisto-redaktanto">Produktisto kaj redaktanto</label>
            <input type="text" name="produktisto-redaktanto" id="produktisto-redaktanto" />
          </li>
          <li>
            <label for="jaro">Jaro</label>
            <input type="text" name="jaro" id="jaro" />
          </li>
          <li>
            <label for="eldonejo">Eldonejo</label>
            <input type="text" name="eldonejo" id="eldonejo" />
          </li>
          <li>
            <label for="ry-artisto">RY-artisto</label>
            <input type="text" name="ry-artisto" id="ry-artisto" />
          </li>
          <li>
            <label for="ry-titolo">RY-titolo</label>
            <input type="text" name="ry-titolo" id="ry-titolo" />
          </li>
          <li>
            <input type="submit" name="muzika-verko" value="Registri" />
          </li>
        </ol>
      </form>
    </div>
  </body>
</html>

