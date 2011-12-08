<?php
header('Content-Type: text/html;charset=utf-8');

// include('inc/utils.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/inc/inc.php');

// echo cxapeligu('cx gx hx jx sx ux Cx Gx Hx Jx Sx Ux</br>');

include('/var/muzaiko/datumbazensalutiloj.php');

$radiouid = "14694a7d-9023-4db1-86b4-d85d96cba181";
$apikey = $radionomy_sxlosilo;
$cover = "no";
$cache = './cache_api.txt';
$cacheCall = './cache_callapi.txt';
$date = "-1";

// plej granda nombro de literoj antaux ol trancxi la cxenon
$maxlen = 60;

if (substr(decoct(@fileperms($cacheCall)), 3, 3) != "777" && substr(decoct(@fileperms($cacheCall)), 3, 3) != "644" && !@chmod($cacheCall, 0777)) {
	$teksto = 'Erreur ! Vous devez autoriser en écriture le fichier cache_callapi.txt';
   echo wordwrap ( $teksto ,  $maxlen , "<br>" , true);
	exit;
}

if (substr(decoct(@fileperms($cache)), 3, 3) != "777" && substr(decoct(@fileperms($cache)), 3, 3) != "644" && !@chmod($cache, 0777)) {
	$teksto = 'Erreur ! Vous devez autoriser en écriture le fichier cache_api.txt';
   echo wordwrap ( $teksto ,  $maxlen , "<br>" , true);
	exit;
}

if ($lines = file($cacheCall)) {
	$date = (isset($lines[1]) ? $lines[1] : '-1');
	$time = $lines[0];
	$expire = time() - $time;
} else {
	$expire = time() - 1;
}

if (@file_exists($cache) && $date > $expire && file_get_contents($cache) != "") {
	$xml = @simplexml_load_file($cache);
} else {
	@file_put_contents($cacheCall, "200"."\n".time());
	$context = stream_context_create(array('http' => array('timeout' => 30)));
	touch($cache);
	$xml = @file_get_contents('http://api.radionomy.com/currentsong.cfm?radiouid='.$radiouid.'&callmeback=yes&type=xml'.(!empty($apikey) ? '&apikey='.$apikey : '').''.(!empty($cover) ? '&cover='.$cover : '').'', 0, $context);
	if(!$xml)
		$xml = @simplexml_load_file($cache);
	else {
		@file_put_contents($cache, $xml);
		$xml = @simplexml_load_file($cache);
		$expireNext = ($xml->track->callmeback / 1000);
		if ($expireNext < 10)
			$expireNext = 60;
		@file_put_contents($cacheCall, $expireNext."\n".time());
	}
}

if($xml ===  FALSE)
{
	$teksto = "Neebla ricevi la kantinformojn el Radionomy. :(";
   echo wordwrap ( $teksto ,  $maxlen , "<br>" , true);
}
else {
	if (empty($xml->track->artists)) {
	  $teksto = cxapeligu($xml->track->title);
     echo wordwrap ( $teksto ,  $maxlen , "<br>" , true);
	}
	else {
	  if (!empty($xml->track->artists) && !empty($xml->track->title)) {
	    $teksto = cxapeligu($xml->track->artists . " - " . $xml->track->title);
       echo wordwrap ( $teksto ,  $maxlen , "<br>" , true);
	
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
