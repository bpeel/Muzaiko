<?php
include('inc/inc.php');
page_header('Muziko');
?>
<p>
<img src="images/earphones.gif" alt="" title="" class="left_img" />
<b>Muzaiko ludas la plej mojosan muzikon en Esperantujo!</b> Krom niaj <a href="/programeroj">muzikaj programeroj</a>, ni ankaŭ prezentas muzikon dum niaj aliaj programeroj. Tiu muziko venas de nia <i>muzikolisto</i>, kiun redaktas por vi ĉiusemajne la muziko-teamo de Muzaiko!
</p>
<div class="title">La A-Listo</div>
<?php
# this doesn't work because the admin files have been removed
#	$playlist = (read_playlist('default_a'));
#	foreach ($playlist as $item)
#		print '<b>'.$item['artist'].'</b>&nbsp; - '.$item['title'].'<br />';
?>
<div class="title">La B-Listo</div>
<?php
#	$playlist = (read_playlist('default_b'));
#	foreach ($playlist as $item)
#		print '<b>'.$item['artist'].'</b>&nbsp; - '.$item['title'].'<br />';
?>
<?php
right();
right_contents();
page_footer();
