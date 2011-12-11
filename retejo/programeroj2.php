<?php
include('inc/inc.php');
include('inc/programo.php');
page_header('Programeroj');

konektu_al_programo ();

$query = "SELECT id, description FROM programero";
$result = mysql_query($query);
printf('<ul>');
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	printf('<li><a href="?programero=%s">%s</a></li>', $row[0], $row[1]);
	if (!empty($_GET['programero']) && ctype_digit($_GET['programero']) && $_GET['programero'] == $row[0]) {
		$query2 = "SELECT DATE_FORMAT(date_begin, '%Y/%m/%d %H:%i'), DATE_FORMAT(date_end, '%Y-%m-%d %H:%i') FROM programero, elsendo WHERE programero.id = elsendo.programero_id AND programero.id = ".$_GET['programero'];
		$result2 = mysql_query($query2);
		printf('<ul>');
		while ($row2 = mysql_fetch_array($result2, MYSQL_NUM)) {
			printf('<li>%s UTC &mdash; %s UTC</li>', $row2[0], $row2[1]);
		}
		printf('</ul>');
	}
}
printf('</ul>');

right();
right_contents();
page_footer();
