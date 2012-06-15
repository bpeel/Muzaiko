<!DOCTYPE html>
<html lang="eo">
  <head>
    <meta charset="utf-8">
    <title>Programverkilo</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="css/custom-theme/jquery-ui-1.8.18.custom.css" type="text/css"  media="screen">
    <link rel="stylesheet" href="css/jquery.dataTables_themeroller.css" type="text/css"  media="screen">
    <link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css"  media="screen">
    <link rel="stylesheet" href="css/programverkilo.css" type="text/css"  media="screen">
  </head>
  <body>
    <div id="sxargado-fono"></div>
    <div id="sxargado-mesagxo">Pretiĝado de la paĝo…</div>
    <header>
    </header>
    <div id="langetoj">
      <nav>
        <ul>
          <li><a href="#programeroj">Programeroj</a></li>
          <li><a href="#parolantoj">Parolantoj</a></li>
          <li><a href="#produktantoj">Produktantoj</a></li>
          <li><a href="#temoj">Temoj</a></li>
          <li><a href="#sekcioj">Sekcioj</a></li>
          <li><a href="#permesiloj">Permesiloj</a></li>
          <li><a href="#helpo">Helpo</a></li>
        </ul>
      </nav>
      <?php
        require_once('./lib/sql_petoj.php');
        require_once('./lib/funkcioj.php');

        try {
          konektigxi_al_datumbazo();
        } catch (Exception $e) {
          malkonektigxi_de_datumbazo();
          print "<script>alert('Eraro: " . $e->getMessage() . "');</script>";
          exit();
        }

        function ricevi_datumojn($tabelo) {
          global $sql_legi;
          try {
            $datumoj = peti_datumbazon($sql_legi[$tabelo]);
          } catch (Exception $e) {
            malkonektigxi_de_datumbazo();
            print "<script>alert('Eraro: " . $e->getMessage() . "');</script>";
            exit();
          }
          return $datumoj;
        }
      ?>
      <div id="programeroj">
        <table id="tabelo-programero">
          <thead>
            <tr>
              <th>Titolo</th>
              <th>Skizo</th>
              <th>Elsendoj</th>
              <th>Komento</th>
              <th>Sondosieroj</th>
              <th>Parolintoj</th>
              <th>Produktinto</th>
              <th>Temo</th>
              <th>Sekcio</th>
              <th>Permesilo</th>
              <th>Lasta elsendo</th>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('programero');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['titolo'].'</td>'
                  .'<td>'.format_programero($horizontalo['skizo']).'</td>'
                  .'<td><ol class="datoj">'.$horizontalo['datoj'].'</ol>'
                  .'<div><a href="#" class="rapida_aldono">Rapida aldono</a></div>'
                  .'</td>'
                  .'<td>'.$horizontalo['komento'].'</td>'
                  .'<td><ul class="sondosieroj">'.$horizontalo['sondosiero'].'</ul></td>'
                  .'<td><ul class="parolantoj">'.$horizontalo['parolanto'].'</ul></td>'
                  .'<td>'.$horizontalo['produktanto'].'</td>'
                  .'<td>'.$horizontalo['temo'].'</td>'
                  .'<td>'.$horizontalo['sekcio'].'</td>'
                  .'<td>'
                    .format_permesilo(
                      $horizontalo['permesilo_nomo'],
                      $horizontalo['permesilo_bildo'])
                    .'</td>'
                  .'<td>'.$horizontalo['lasta_elsendo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-programero" title="Krei programeron">
          <ol>
            <li>
              <label for="programero-titolo">Titolo</label>
              <input type="text" id="programero-titolo" name="titolo" style="width:670px" />
            </li>
            <li>
              <label for="programero-skizo">Skizo</label>
              <textarea id="programero-skizo" name="skizo" style="width:670px;height:40px"></textarea>
            </li>
            <li>
              <label for="programero-unua-elsendo-dato">Unua elsendo</label>
              <input type="text" id="programero-unua-elsendo-dato" class="datelektilo" name="unua_elsendo_dato" />
              <input type="text" id="programero-unua-elsendo-komenchoro" class="horelektilo" name="unua_elsendo_komenchoro" />-<input type="text" id="programero-unua-elsendo-finhoro" class="horelektilo" name="unua_elsendo_finhoro" />
            </li>
            <li>
              <label for="programero-komento">Komento</label>
              <textarea id="programero-komento" name="komento" style="width:670px;height:40px"></textarea>
            </li>
            <li>
              <label for="kreformularo-nedosieroj">Sondosieroj</label>
              <div style="display:inline-block">
                <div style="display:inline-block">
                  Neinkluzivotaj dosieroj:<br />
                  <select id="kreformularo-nedosieroj" multiple="multiple" size="8" style="width:300px">
                  </select>
                </div>
                <div style="display:inline-block;padding-left:20px;vertical-align:top">
                  <button onclick="inkluzivuDosierojn('kreformularo')" type="button">→</button><br />
                  <button onclick="malinkluzivuDosierojn('kreformularo')" type="button">←</button>
                </div>
                <div style="display:inline-block;padding-left:20px">
                  Inkluzivotaj dosieroj:<br />
                  <select id="kreformularo-jesdosieroj" multiple="multiple" size="8" style="width:300px">
                  </select>
                </div>
              </div>
            </li>
            <li>
              <label for="programero-parolanto">Parolintoj</label>
              <select multiple="multiple" id="programero-parolanto" name="parolanto_id[]"></select>
            </li>
            <li>
              <label for="programero-produktanto">Produktinto</label>
              <select id="programero-produktanto" name="produktanto_id"></select>
            </li>
            <li>
              <label for="programero-temo">Temo</label>
              <select id="programero-temo" name="temo_id"></select>
            </li>
            <li>
              <label for="programero-sekcio">Sekcio</label>
              <select id="programero-sekcio" name="sekcio_id"></select>
            </li>
            <li>
              <label for="programero-permesilo">Permesilo</label>
              <select id="programero-permesilo" name="permesilo_id"></select>
            </li>
          </ol>
        </form>
        <form id="formularo-programero-elsendo-datoj" title="Redakti la elsendojn">
          <ol>
          </ol>
          <input type="button" id="butono-aldoni-elsendon" value="Aldoni elsendon" />
        </form>
        <form id="formularo-programero-sondosieroj" title="Redakti la sondosierojn">
          <div style="display:inline-block">
            <div style="display:inline-block">
              Neinkluzivotaj dosieroj:<br />
              <select id="redaktformularo-nedosieroj" multiple="multiple" size="8" style="width:300px">
              </select>
            </div>
            <div style="display:inline-block;padding-left:20px;vertical-align:top">
              <button onclick="inkluzivuDosierojn('redaktformularo')" type="button">→</button><br />
              <button onclick="malinkluzivuDosierojn('redaktformularo')" type="button">←</button>
            </div>
            <div style="display:inline-block;padding-left:20px">
              Inkluzivotaj dosieroj:<br />
              <select id="redaktformularo-jesdosieroj" multiple="multiple" size="8" style="width:300px">
              </select>
            </div>
          </div>
        </form>
      </div>
      <div id="parolantoj">
        <table id="tabelo-parolanto">
          <thead>
            <tr>
              <th>Nomo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('parolanto');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['nomo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-parolanto" title="Krei parolanton">
          <ol>
            <li>
              <label for="parolanto-nomo">Nomo</label>
              <input type="text" id="parolanto-nomo" name="nomo" />
            </li>
          </ol>
        </form>
      </div>
      <div id="produktantoj">
        <table id="tabelo-produktanto">
          <thead>
            <tr>
              <th>Nomo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('produktanto');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['nomo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-produktanto" title="Krei produktanton">
          <ol>
            <li>
              <label for="produktanto-nomo">Nomo</label>
              <input type="text" id="produktanto-nomo" name="nomo" />
            </li>
          </ol>
        </form>
      </div>
      <div id="temoj">
        <table id="tabelo-temo">
          <thead>
            <tr>
              <th>Nomo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('temo');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['nomo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-temo" title="Krei temon">
          <ol>
            <li>
              <label for="temo-nomo">Nomo</label>
              <input type="text" id="temo-nomo" name="nomo" />
            </li>
          </ol>
        </form>
      </div>
      <div id="sekcioj">
        <table id="tabelo-sekcio">
          <thead>
            <tr>
              <th>Nomo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('sekcio');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['nomo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-sekcio" title="Krei sekcion">
          <ol>
            <li>
              <label for="sekcio-nomo">Nomo</label>
              <input type="text" id="sekcio-nomo" name="nomo" />
            </li>
          </ol>
        </form>
      </div>
      <div id="permesiloj">
        <table id="tabelo-permesilo">
          <thead>
            <tr>
              <th>Nomo</th>
              <th>URL</th>
              <th>Bildo</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $datumoj = ricevi_datumojn('permesilo');
              while ($horizontalo = mysql_fetch_assoc($datumoj)) {
                print('<tr id="'.$horizontalo['DT_RowId'].'">'
                  .'<td>'.$horizontalo['nomo'].'</td>'
                  .'<td>'.$horizontalo['url'].'</td>'
                  .'<td>'.$horizontalo['bildo'].'</td>'
                  .'</tr>');
              }
            ?>
          <tbody>
        </table>
        <form id="formularo-permesilo" title="Krei permesilon">
          <ol>
            <li>
              <label for="permesilo-nomo">Nomo</label>
              <input type="text" id="permesilo-nomo" name="nomo" />
            </li>
            <li>
              <label for="permesilo-url">URL</label>
              <input type="text" id="permesilo-url" name="url" />
            </li>
            <li>
              <label for="permesilo-bildo">Bildo</label>
              <input type="text" id="permesilo-bildo" name="bildo" />
            </li>
          </ol>
        </form>
      </div>
      <div id="helpo">
        <h1>Ĝeneralaĵoj pri la programverkilo</h1>
        <p>La unua kaj defaŭlta langeto, <i>Programeroj</i>, permesas konsulti kaj mastrumi la informojn pri ĉiuj programeroj. La langetoj <i>Parolantoj</i>, <i>Produktantoj</i>, <i>Temoj</i>, <i>Sekcioj</i> kaj <i>Permesiloj</i> kolektas datumlistojn uzeblaj en ĉiu programero.</p>
        <h1>Trovi elementon</h1>
        <p>Povas esti malfacile trovi elementon en grandega tabelo. Por trovi elementon, uzu unuopan aŭ plurajn ilo(j)n proponita(j)n:</p>
        <ul>
          <li>serĉu ŝlosilvortojn uzante la serĉilon, kiu troviĝas super la tabelo, dekstre ;</li>
          <li>klaku sur la titolo de iu kolumno por ordigi la elementojn laŭ tiu kolumno ;</li>
          <li>foliumu la paĝojn de la tabelo pere de la paĝilon, kiu troviĝas sub la tabelo, dekstre.</li>
        </ul>
        La kolumno <i>Elsendoj</i> ordiĝas laŭ la lasta elsendo.
        <h1>Krei novan elementon en tabelo</h1>
        <p>Klaku sur la butono <i>Krei &lt;elementon&gt;</i>, plenigu la formularon kaj klaku sur <i>Registri</i>. Se ne estas problemo, la nova elemento estos aldonita al la tabelo. Eblas ke ĝi ne estu tuj videbla ĉar ĝi troviĝas en alia paĝo de la tabelo.</p>
        <h1>Redakti informojn de elemento</h1>
        <p>Duoblklaku la ĉelon en kiu troviĝas la redaktota datumo, redaktu ĝin laŭvole kaj klaku sur <i>Registri</i> por konservi la ŝanĝojn. La elsendoj de la programeroj povas esti redaktataj per plia maniero, kiu estas pli rapida por simple aldoni elsendon: unuoblklaku sur la ligilo <i>Rapida aldono</i>, plenigu la kampojn kaj klaku sur <i>Registri</i>.</p>
        <h1>Forviŝi elementon</h1>
        <p>Klaku sur la linio de la forviŝota elemento por ke ĝi flaviĝu, klaku sur la butono <i>Forviŝi la elektitan &lt;elementon&gt;</i> kaj konfirmu. La elemento estos tuj forviŝita.</p>
      </div>
      <?php
        malkonektigxi_de_datumbazo();
      ?>
    </div>
    <footer>
    </footer>
  </body>
  <script src="js/jquery-1.7.1.min.js"></script>
  <script src="js/jquery-ui-1.8.18.custom.min.js"></script>
  <script src="js/jquery.ui.datepicker-eo.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/jquery.jeditable.mini.js"></script>
  <script src="js/jquery.jeditable.multiselect.js"></script>
  <script src="js/jquery.ui.timepicker.js"></script>
  <script src="js/jquery.ui.timepicker-eo.js"></script>
  <script src="js/sondosieroj.js"></script>
  <script src="js/programverkilo.js"></script>
</html>
