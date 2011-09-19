<?php
header('Content-Type: text/html;charset=utf-8');

// include('inc/utils.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');

// echo cxapeligu('cx gx hx jx sx ux Cx Gx Hx Jx Sx Ux</br>');

$url = 'http://api.radionomy.com/currentsong.cfm?radiouid=14694a7d-9023-4db1-86b4-d85d96cba181&apikey=a3ca21ce-5d81-4162-8fda-bbe2f0aff941&type=xml&callmeback=yes';
$current_song_file = 'current_song.xml';
$radionomy_access_log_file = 'radionomy_access.log';
$right_timestamp_file = 'right_timestamp.txt';
if (file_exists($right_timestamp_file)) {
        $right_timestamp = file_get_contents($right_timestamp_file);
        if (time() > $right_timestamp) {
		if ($xml_from_radionomy = file_get_contents($url)) {
                	file_put_contents($current_song_file, $xml_from_radionomy);
			file_put_contents($radionomy_access_log_file, date('r') . "\n", FILE_APPEND);
                	$xml = simplexml_load_file($current_song_file);
			$callmeback = $xml->track->callmeback;
			if ($callmeback) {
                		file_put_contents($right_timestamp_file, time() + $callmeback / 1000);
			} else {
				file_put_contents($radionomy_access_log_file, "Unable to get callbackme!!! Adding 5 minutes to the timestamp\n", FILE_APPEND);
				file_put_contents($right_timestamp_file, time() + 60 * 5);
			}
		} else {
			$xml = FALSE;
		}
        } else {
		$xml = simplexml_load_file($current_song_file);
	}
} else {
        $xml = FALSE;
}

// Tempa malaktivado gxis kiam Radionomy denove akceptas niajn petojn
// $xml = simplexml_load_file($url);
//$xml=FALSE;

if($xml ===  FALSE)
{
	echo "Neebla ricevi la kantinformojn el Radionomy. :(";
}
else {
	if (empty($xml->track->artists)) {
	  echo cxapeligu($xml->track->title);
	}
	else {
	  if (!empty($xml->track->artists) && !empty($xml->track->title)) {
	    echo cxapeligu($xml->track->artists . " - " . $xml->track->title);
	
	    include('/var/muzaiko/datumbazensalutiloj.php');
	
	    $artists = trim(addslashes(malcxapeligu($xml->track->artists)));
	    $title = trim(addslashes(malcxapeligu($xml->track->title)));
	
	    mysql_connect($servilo,$username,$password);
	    @mysql_select_db($database) or die( "Neebla elekti la datumbazon");
	
	    $ligilo_vk='';
	    $ligilo_vk_mp3='';
	
	    $query_vk="SELECT Ligoj_al_diskoservo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VK%' AND Ligoj_al_diskoservo!='0'";
	    $result=mysql_query($query_vk);
	    if($result)
	    {
	      $ligilo_vk = mysql_fetch_row($result);
	      $ligilo_vk = $ligilo_vk[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
	    }
	
	    $query_vk_mp3="SELECT Ligoj_al_la_elsxutejo FROM vinilkosmo_tabelo WHERE Noms_albums_complets_et_Titres_par_piste_unitaire='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VK%' AND Ligoj_al_la_elsxutejo!='0'";
	    $result=mysql_query($query_vk_mp3);
	    if($result)
	    {
	      $ligilo_vk_mp3 = mysql_fetch_row($result);
	      $ligilo_vk_mp3 = $ligilo_vk_mp3[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
	    }
	
	    mysql_close();
	
	    $protokoldosiero="nekonata.log";
	    if (empty($ligilo_vk)) {
	//       $ligilo_vk = 'http://vinilkosmo.com';
	      $file = file_get_contents($protokoldosiero);
	      if(!strpos($file, $query_vk)) {
	        $myFile = $protokoldosiero;
	        $fh = fopen($myFile, 'a') or die("can't open file");
	        fwrite($fh, "== ligilo_vk ne trovata ==\n");
	        fwrite($fh, $xml->track->artists . " - " . $xml->track->title . "\n");
	        fwrite($fh, $query_vk . ";\n");
	        fclose($fh);
	      }
	    }
	    if (empty($ligilo_vk_mp3)) {
	//       $ligilo_vk_mp3 = 'http://vinilkosmo-mp3.com';
	      $file = file_get_contents($protokoldosiero);
	      if(!strpos($file, $query_vk_mp3)) {
	        $myFile = $protokoldosiero;
	        $fh = fopen($myFile, 'a') or die("can't open file");
	        fwrite($fh, "== ligilo_vk_mp3 ne trovata ==\n");
	        fwrite($fh, $xml->track->artists . " - " . $xml->track->title . "\n");
	        fwrite($fh, $query_vk_mp3 . ";\n");
	        fclose($fh);
	      }
	    }
	
	    if ( !empty($ligilo_vk) && !empty($ligilo_vk_mp3) ) {
	      echo '</br><a target="_blank" href="' . $ligilo_vk . '">Fizika albumo</a> - <a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>';
	    }
	    if ( !empty($ligilo_vk) && empty($ligilo_vk_mp3) ) {
	      echo '</br><a target="_blank" href="' . $ligilo_vk . '">Fizika albumo</a>';
	    }
	    if ( empty($ligilo_vk) && !empty($ligilo_vk_mp3) ) {
	      echo '</br><a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>';
	    }
	
	  }
	}
}

?>
