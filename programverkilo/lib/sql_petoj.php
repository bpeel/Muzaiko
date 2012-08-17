<?php

$tabeloj = array(
  'programero' => array('titolo' => 'nedeviga',
                        'skizo' => 'deviga',
                        'komento' => 'nedeviga',
                        'produktanto_id' => 'nedeviga',
                        'temo_id' => 'nedeviga',
                        'sekcio_id' => 'nedeviga',
                        'permesilo_id' => 'nedeviga'),
  'parolanto' => array('nomo' => 'deviga'),
  'produktanto' => array('nomo' => 'deviga'),
  'temo' => array('nomo' => 'deviga'),
  'sekcio' => array('nomo' => 'deviga'),
  'permesilo' => array('nomo' => 'deviga',
                        'url' => 'nedeviga',
                        'bildo' => 'nedeviga')
);

$listoj = array('produktanto',
                'parolanto',
                'temo',
                'sekcio',
                'permesilo'
);

$sql_legi = array();

$sql_legi['programero'] = <<<EOF
SELECT programero.id AS DT_RowId,
  IFNULL(programero.id, '') AS numero,
  IFNULL(programero.titolo, '') AS titolo,
  IFNULL(programero.skizo, '') AS skizo,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      elsendo.dato,
      TIME_FORMAT(
        elsendo.komenchoro, ' (%H:%i ‑ '
      ),
      TIME_FORMAT(
        elsendo.finhoro, '%H:%i)</li>'
      )
      SEPARATOR ''
    ), ''
  ) AS datoj,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      parolanto.nomo,
      '</li>'
      ORDER BY parolanto.nomo ASC
      SEPARATOR ''
    ), ''
  ) AS parolanto,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      sondosiero.nomo,
      '</li>'
      ORDER BY sondosiero.nomo ASC
      SEPARATOR ''
    ), ''
  ) AS sondosiero,
  IFNULL(
    MAX(
      CONCAT(
        dato,
        ' (',
        TIME_FORMAT(komenchoro, '%H:%i'),
        ' - ',
        TIME_FORMAT(finhoro, '%H:%i'),
        ')'
      )
    ), ''
  ) AS lasta_elsendo,
  IFNULL(programero.komento, '') AS komento,
  IFNULL(produktanto.nomo, '') AS produktanto,
  IFNULL(temo.nomo, '') AS temo,
  IFNULL(sekcio.nomo, '') AS sekcio,
  IFNULL(permesilo.nomo, '') AS permesilo_nomo,
  IFNULL(permesilo.url, '') AS permesilo_url,
  IFNULL(permesilo.bildo, '') AS permesilo_bildo
FROM programero
LEFT OUTER JOIN elsendo
ON elsendo.programero_id = programero.id
LEFT OUTER JOIN programero_parolanto
ON programero_parolanto.programero_id = programero.id
LEFT OUTER JOIN parolanto
ON parolanto.id = programero_parolanto.parolanto_id
LEFT OUTER JOIN sondosiero
ON sondosiero.programero = programero.id
LEFT OUTER JOIN produktanto
ON produktanto.id = programero.produktanto_id
LEFT OUTER JOIN temo
ON temo.id = programero.temo_id
LEFT OUTER JOIN sekcio
ON sekcio.id = programero.sekcio_id
LEFT OUTER JOIN permesilo
ON permesilo.id = programero.permesilo_id
GROUP BY programero.id
EOF;

$sql_legi['parolanto'] = <<<EOF
SELECT parolanto.id AS DT_RowId,
  parolanto.nomo AS nomo
FROM parolanto
EOF;

$sql_legi['produktanto'] = <<<EOF
SELECT produktanto.id AS DT_RowId,
  produktanto.nomo AS nomo
FROM produktanto
EOF;

$sql_legi['temo'] = <<<EOF
SELECT temo.id AS DT_RowId,
  temo.nomo AS nomo
FROM temo
EOF;

$sql_legi['sekcio'] = <<<EOF
SELECT sekcio.id AS DT_RowId,
  sekcio.nomo AS nomo
FROM sekcio
EOF;

$sql_legi['permesilo'] = <<<EOF
SELECT permesilo.id AS DT_RowId,
  permesilo.nomo AS nomo,
  IFNULL(permesilo.url, '') AS url,
  IFNULL(permesilo.bildo, '') AS bildo
FROM permesilo
EOF;

$sql_legi_horizontalon['parolanto'] = $sql_legi['parolanto'] . ' WHERE parolanto.id = %d';
$sql_legi_horizontalon['produktanto'] = $sql_legi['produktanto'] . ' WHERE produktanto.id = %d';
$sql_legi_horizontalon['temo'] = $sql_legi['temo'] . ' WHERE temo.id = %d';
$sql_legi_horizontalon['sekcio'] = $sql_legi['sekcio'] . ' WHERE sekcio.id = %d';
$sql_legi_horizontalon['permesilo'] = $sql_legi['permesilo'] . ' WHERE permesilo.id = %d';
$sql_legi_horizontalon['programero'] = <<<EOF
SELECT programero.id AS DT_RowId,
  IFNULL(programero.id, '') AS numero,
  IFNULL(programero.titolo, '') AS titolo,
  IFNULL(programero.skizo, '') AS skizo,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      elsendo.dato,
      TIME_FORMAT(
        elsendo.komenchoro, ' (%%H:%%i ‑ '
      ),
      TIME_FORMAT(
        elsendo.finhoro, '%%H:%%i)</li>'
      )
      SEPARATOR ''
    ), ''
  ) AS datoj,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      parolanto.nomo,
      '</li>'
      ORDER BY parolanto.nomo ASC
      SEPARATOR ''
    ), ''
  ) AS parolanto,
  IFNULL(
    GROUP_CONCAT(
      DISTINCT
      '<li>',
      sondosiero.nomo,
      '</li>'
      ORDER BY sondosiero.nomo ASC
      SEPARATOR ''
    ), ''
  ) AS sondosiero,
  IFNULL(
    MAX(
      CONCAT(
        dato,
        ' (',
        TIME_FORMAT(komenchoro, '%H:%i'),
        ' - ',
        TIME_FORMAT(finhoro, '%H:%i'),
        ')'
      )
    ), ''
  ) AS lasta_elsendo,
  IFNULL(programero.komento, '') AS komento,
  IFNULL(produktanto.nomo, '') AS produktanto,
  IFNULL(temo.nomo, '') AS temo,
  IFNULL(sekcio.nomo, '') AS sekcio,
  IFNULL(permesilo.nomo, '') AS permesilo_nomo,
  IFNULL(permesilo.url, '') AS permesilo_url,
  IFNULL(permesilo.bildo, '') AS permesilo_bildo
FROM programero
LEFT OUTER JOIN elsendo
ON elsendo.programero_id = programero.id
LEFT OUTER JOIN programero_parolanto
ON programero_parolanto.programero_id = programero.id
LEFT OUTER JOIN parolanto
ON parolanto.id = programero_parolanto.parolanto_id
LEFT OUTER JOIN sondosiero
ON sondosiero.programero = programero.id
LEFT OUTER JOIN produktanto
ON produktanto.id = programero.produktanto_id
LEFT OUTER JOIN temo
ON temo.id = programero.temo_id
LEFT OUTER JOIN sekcio
ON sekcio.id = programero.sekcio_id
LEFT OUTER JOIN permesilo
ON permesilo.id = programero.permesilo_id
WHERE programero.id = %d
GROUP BY programero.id
EOF;

$sql_listi = <<<EOF
SELECT id AS valoro,
  nomo AS teksto
FROM %s
ORDER BY teksto ASC
EOF;

$sql_gxisdatigi = <<<EOF
UPDATE %s
SET %s = %s
WHERE id = %d;
EOF;

$sql_akiri = <<<EOF
SELECT %s
FROM %s
WHERE id = %d;
EOF;

$sql_akiri_listelementon = <<<EOF
SELECT nomo AS teksto
FROM %s
WHERE id = %d;
EOF;

$sql_akiri_listelementojn = <<<EOF
SELECT
  IFNULL(
    GROUP_CONCAT(
      '<li>',
      nomo,
      '</li>'
      SEPARATOR ''
    ), ''
  ) AS teksto
FROM %s
WHERE id = %s;
EOF;

$sql_krei = <<<EOF
INSERT INTO %s(%s)
VALUES(%s);
EOF;

$sql_forvisxi = <<<EOF
DELETE
FROM %s
WHERE id = %d;
EOF;

$sql_forvisxi_elsendojn = <<<EOF
DELETE
FROM elsendo
WHERE programero_id = %d;
EOF;

$sql_krei_elsendon = <<<EOF
INSERT INTO elsendo(programero_id, dato, komenchoro, finhoro)
VALUES(%d, '%s', '%s', '%s');
EOF;

$sql_krei_elsendojn = <<<EOF
INSERT INTO elsendo(programero_id, dato, komenchoro, finhoro)
VALUES%s;
EOF;

$sql_akiri_elsendojn = <<<EOF
SELECT
  IFNULL(
    GROUP_CONCAT(
      '<li>',
      elsendo.dato,
      TIME_FORMAT(
        elsendo.komenchoro, ' (%%H:%%i ‑ '
      ),
      TIME_FORMAT(
        elsendo.finhoro, '%%H:%%i)</li>'
      )
      SEPARATOR ''
    ), ''
  ) AS elsendoj,
  IFNULL(
    MAX(
      CONCAT(
        dato,
        ' (',
        TIME_FORMAT(komenchoro, '%%H:%%i'),
        ' - ',
        TIME_FORMAT(finhoro, '%%H:%%i'),
        ')'
      )
    ), ''
  ) AS lasta_elsendo
FROM elsendo
WHERE programero_id = %d;
EOF;

$sql_akiri_sondosierojn = <<<EOF
SELECT
  IFNULL(
    GROUP_CONCAT(
      '<li>',
      nomo,
      '</li>'
      SEPARATOR ''
    ), ''
  ) AS teksto
FROM sondosiero
WHERE programero = %s;
EOF;

$sql_forvisxi_sondosierojn = <<<EOF
DELETE
FROM sondosiero
WHERE programero = %d;
EOF;

$sql_aldoni_sondosierojn = <<<EOF
INSERT INTO sondosiero(programero, nomo)
VALUES%s;
EOF;

$sql_forvisxi_parolantojn = <<<EOF
DELETE
FROM programero_parolanto
WHERE programero_id = %d;
EOF;

$sql_aldoni_parolantojn = <<<EOF
INSERT INTO programero_parolanto(programero_id, parolanto_id)
VALUES%s;
EOF;

function sql_legi($tabelo)
{
  global $sql_legi;

  if (!array_key_exists($tabelo, $sql_legi))
    return false;
  return $sql_legi[$tabelo];
}

function sql_legi_horizontalon($tabelo, $id)
{
  global $sql_legi_horizontalon;

  if (!array_key_exists($tabelo, $sql_legi_horizontalon))
    return false;
  return sprintf($sql_legi_horizontalon[$tabelo], $id);
}

function sql_listi($listo)
{
  global $listoj, $sql_listi;

  if (!in_array($listo, $listoj))
    return false;
  return sprintf($sql_listi, $listo);
}

function sql_gxisdatigi($tabelo, $kolumno, $valoro, $id)
{
  global $tabeloj, $sql_gxisdatigi;

  if (!array_key_exists($tabelo, $tabeloj))
    throw new Exception('La petata tabelo "'.$parametroj['tabelo'].'" ne ekzistas');
  if (!array_key_exists($kolumno, $tabeloj[$tabelo])) {
    if (array_key_exists($kolumno . '_id', $tabeloj[$tabelo]))
      $kolumno = $kolumno . '_id';
    else
      throw new Exception('La petata kampo "'.$kolumno.'" ne ekzistas');
  }
  if (empty($valoro) && $tabeloj[$tabelo][$kolumno] == 'deviga')
    throw new Exception('La kampo "'.$kolumno.'" devas esti plenigita');
  if (preg_match('/_id$/', $kolumno)) {
    if ($valoro == 0)
      $valoro = 'NULL';
    else
      $valoro = addslashes($valoro);
  } else {
    $valoro = "'".addslashes($valoro)."'";
  }
  return sprintf($sql_gxisdatigi, $tabelo, $kolumno, $valoro, $id);
}

function sql_akiri($tabelo, $kolumno, $id)
{
  global $tabeloj, $sql_akiri;

  if (!array_key_exists($tabelo, $tabeloj))
    return false;
  if (!array_key_exists($kolumno, $tabeloj[$tabelo])) {
    if (array_key_exists($kolumno . '_id', $tabeloj[$tabelo]))
      $kolumno = $kolumno . '_id';
    else
      return false;
  }
  return sprintf($sql_akiri, $kolumno, $tabelo, $id);
}

function sql_akiri_listelementon($listo, $id)
{
  global $listoj, $sql_akiri_listelementon;

  if (!in_array($listo, $listoj))
    return false;
  return sprintf($sql_akiri_listelementon, $listo, $id);
}

function sql_akiri_listelementojn($listo, $idj)
{
  global $listoj, $sql_akiri_listelementojn;

  if (!in_array($listo, $listoj))
    return false;
  return sprintf($sql_akiri_listelementojn, $listo, join(' OR id = ', $idj));
}

function sql_krei($parametroj)
{
  global $tabeloj, $sql_krei;

  $sxlosiloj = array();
  $valoroj = array();
  if (array_key_exists($parametroj['tabelo'], $tabeloj)) {
    foreach ($tabeloj[$parametroj['tabelo']] as $parametro => $devigeco) {
      if (empty($parametroj[$parametro]) && $devigeco == 'deviga') {
        throw new Exception('La kampo "'.$parametro.'" devas esti plenigita');
      } else {
        array_push($sxlosiloj, $parametro);
        if (preg_match('/_id$/', $parametro)) {
          if ($parametroj[$parametro] == 0)
            $parametroj[$parametro] = 'NULL';
          array_push($valoroj, addslashes($parametroj[$parametro]));
        } else
          array_push($valoroj, "'".addslashes($parametroj[$parametro])."'");
      }
    }
  } else {
    throw new Exception('La petata tabelo "'.$parametroj['tabelo'].'" ne ekzistas');
  }
  return sprintf($sql_krei,
                  $parametroj['tabelo'],
                  join(', ', $sxlosiloj),
                  join(', ', $valoroj)
                );
}

function sql_forvisxi($tabelo, $id)
{
  global $tabeloj, $sql_forvisxi;

  if (!array_key_exists($tabelo, $tabeloj))
    return false;
  return sprintf($sql_forvisxi, $tabelo, $id);
}

function sql_forvisxi_elsendojn($programero_id) {
  global $sql_forvisxi_elsendojn;
  return sprintf($sql_forvisxi_elsendojn, $programero_id);
}

function sql_krei_elsendon($programero_id, $dato, $komenchoro, $finhoro) {
  global $sql_krei_elsendon;
  return sprintf($sql_krei_elsendon, $programero_id, $dato, $komenchoro, $finhoro);
}

function sql_krei_elsendojn($programero_id, $datoj, $komenchoroj, $finhoroj) {
  global $sql_krei_elsendojn;
  $horizontaloj = array();
  for ($i = 0; $i < count($datoj); $i++)
    array_push($horizontaloj, "($programero_id,'".$datoj[$i]."','".$komenchoroj[$i]."','".$finhoroj[$i]."')");
  return sprintf($sql_krei_elsendojn, join(',', $horizontaloj));
}

function sql_akiri_elsendojn($programero_id) {
  global $sql_akiri_elsendojn;
  return sprintf($sql_akiri_elsendojn, $programero_id);
}

function sql_akiri_sondosierojn($programero_id) {
  global $sql_akiri_sondosierojn;
  return sprintf($sql_akiri_sondosierojn, $programero_id);
}

function sql_forvisxi_sondosierojn($programero_id) {
  global $sql_forvisxi_sondosierojn;
  return sprintf($sql_forvisxi_sondosierojn, $programero_id);
}

function sql_aldoni_sondosierojn($programero_id, $sondosieroj) {
  global $sql_aldoni_sondosierojn;
  $horizontaloj = array();
  for ($i = 0; $i < count($sondosieroj); $i++)
    array_push($horizontaloj, "($programero_id, '".addslashes($sondosieroj[$i])."')");
  return sprintf($sql_aldoni_sondosierojn, join(',', $horizontaloj));
}

function sql_forvisxi_parolantojn($programero_id) {
  global $sql_forvisxi_parolantojn;
  return sprintf($sql_forvisxi_parolantojn, $programero_id);
}

function sql_aldoni_parolantojn($programero_id, $parolantoj_id) {
  global $sql_aldoni_parolantojn;
  $horizontaloj = array();
  for ($i = 0; $i < count($parolantoj_id); $i++)
    array_push($horizontaloj, "($programero_id, ".addslashes($parolantoj_id[$i]).")");
  return sprintf($sql_aldoni_parolantojn, join(',', $horizontaloj));
}

?>
