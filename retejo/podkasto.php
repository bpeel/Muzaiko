<?php
include('inc/inc.php');
include('podkasto/podkastajxoj.php');

page_header('Podkasto', NULL,
            "<link rel=\"alternate\" type=\"application/rss+xml\" " .
            "title=\"Podkasto de Muzaiko\" " .
            "href=\"podkasto/podkasto.rss\">");
?>
<div style="float:right; padding-left:2.5em">
<a href="podkasto/podkasto.rss">
<img src="images/Feed-icon.png" alt="Fluo de la podkasto"
     style="border:none" />
</a>
</div>
<p>
La podkasto estas ĉiutaga muntaĵo de la parolaj partoj de Muzaiko. Ĝi
ĝisdatiĝas je la 3a laŭ UTC ĉiumatene. Por aŭskulti la podkaston per
via podkastilo (ekzemple per iTunes), klaku la dekstran organĝan bildon.
</p>
<?php
foreach ($podkastajxoj as $pk)
{
?>
<h2>Elsendo de <?= $pk['dato'] ?></h2>
<p>
<audio controls="controls">
<source src="<?= $pk['mp3'] ?>" type="audio/mp3"></source>
<source src="<?= $pk['ogg'] ?>" type="audio/ogg"></source>
Klaku <a href="<?= $pk['mp3'] ?>">ĉi tie</a> por aŭdi la sonon.
</audio>
</p>
<?= $pk['priskribo'] ?>
<?php
}
?>
<?php
right();
right_contents();
page_footer();
?>