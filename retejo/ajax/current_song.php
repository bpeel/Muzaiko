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

$tabelo = 'muzaiko_datumbazo';

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
else {//xml true

  // preparu programtekston
  $nuna_programo = '';
  $ligu = false;
  if ( !empty($xml->track->artists) ) {
    $nuna_programo = $nuna_programo . cxapeligu($xml->track->artists);
    $ligu = true;
  }
  if ( !empty($xml->track->title) ) {
    if ( $ligu )
    {
      $nuna_programo = $nuna_programo . ' - ';
    }
    $nuna_programo = $nuna_programo . cxapeligu($xml->track->title);
    $ligu = true;
  }
  echo wordwrap ( $nuna_programo,  $maxlen , "<br>" , true);

  // preparu ligiltekston
  mysql_connect($servilo,$username,$password);
  @mysql_select_db($database) or die( "Neebla elekti la datumbazon");

  $ligilo_vk='';
  $ligilo_vk_mp3='';
  $ligilo_CD1D='';
  $ligilo_muzikteksto='';
  $ligilo_retpagxo='';

  $sercxiloj='';
  if ( !empty($xml->track->artists) && !empty($xml->track->title) ) { //muziko
    $artists = trim(addslashes(malcxapeligu($xml->track->artists)));
    $title = trim(addslashes(malcxapeligu($xml->track->title)));
    $sercxiloj="Titolo='$title' AND Artistoj='$artists' AND REF NOT LIKE 'VK%'";
  }
  elseif ( empty($xml->track->artists) && !empty($xml->track->title) ) { // novajxoj, ktp
    $title = trim(addslashes(malcxapeligu($xml->track->title)));
    $sercxiloj="Titolo='$title' AND REF NOT LIKE 'VK%'";
  }
  elseif ( !empty($xml->track->artists) && empty($xml->track->title) ) { // Kio estas tio???
    $artists = trim(addslashes(malcxapeligu($xml->track->artists)));
    $sercxiloj="Artistoj='$artists' AND REF NOT LIKE 'VK%'";
  }

  $protokolu=false;
//   $linio_ekzistas=false;
  if (!empty($sercxiloj))
  {
    $query_gxenerala="SELECT * FROM $tabelo WHERE $sercxiloj";
    $result_gxenerala=mysql_query($query_gxenerala);
    if($result_gxenerala)
    {
      $linio_gxenerala = mysql_fetch_row($result_gxenerala);
      $linio_gxenerala = $linio_gxenerala[0];
//       $linio_ekzistas=true;
    } else { $protokolu=true; }

    $query_vk="SELECT Ligoj_al_diskoservo FROM $tabelo WHERE $sercxiloj AND Ligoj_al_diskoservo!='0'";
    $result=mysql_query($query_vk);
    if($result)
    {
      $ligilo_vk = mysql_fetch_row($result);
      $ligilo_vk = $ligilo_vk[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    } else { $protokolu=true; }

    $query_vk_mp3="SELECT Ligoj_al_la_elsxutejo FROM $tabelo WHERE $sercxiloj AND Ligoj_al_la_elsxutejo!='0'";
    $result=mysql_query($query_vk_mp3);
    if($result)
    {
      $ligilo_vk_mp3 = mysql_fetch_row($result);
      $ligilo_vk_mp3 = $ligilo_vk_mp3[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    } else { $protokolu=true; }

    $query_CD1D="SELECT Ligoj_al_CD1D FROM $tabelo WHERE $sercxiloj AND Ligoj_al_CD1D!='0'";
    $result=mysql_query($query_CD1D);
    if($result)
    {
      $ligilo_CD1D = mysql_fetch_row($result);
      $ligilo_CD1D = $ligilo_CD1D[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    } else { $protokolu=true; }

    $query_muzikteksto="SELECT Ligoj_al_muzikteksto FROM $tabelo WHERE $sercxiloj AND Ligoj_al_muzikteksto!='0'";
    $result=mysql_query($query_muzikteksto);
    if($result)
    {
      $ligilo_muzikteksto = mysql_fetch_row($result);
      $ligilo_muzikteksto = $ligilo_muzikteksto[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    } else { $protokolu=true; }

    $query_retpagxo="SELECT Ligoj_al_retpagxo FROM $tabelo WHERE $sercxiloj AND Ligoj_al_retpagxo!='0'";
    $result=mysql_query($query_retpagxo);
    if($result)
    {
      $ligilo_retpagxo = mysql_fetch_row($result);
      $ligilo_retpagxo = $ligilo_retpagxo[0]; // mysql_fetch_row returns an array. we only want the Name so we just set it excluseively.
    } else { $protokolu=true; }
  } // fino de if (!empty($sercxiloj))

  mysql_close();

  if(empty($linio_gxenerala)) { $protokolu=true; }
  if(empty($ligilo_vk)) { $protokolu=true; }
  if(empty($ligilo_vk_mp3)) { $protokolu=true; }
  if(empty($ligilo_CD1D)) { $protokolu=true; }
  if(empty($ligilo_muzikteksto)) { $protokolu=true; }
  if(empty($ligilo_retpagxo)) { $protokolu=true; }

  if ($protokolu)
  {
    // protokolu netrovatajn ligilojn
    $protokoldosiero="nekonata.log";
    $file = file_get_contents($protokoldosiero);
    $markilo = "== " . $xml->track->artists . " - " . $xml->track->title . " ==";
    if(!strpos($file, $markilo)) { // kontrolu cxu gxi jam ekzistas
      $fh = fopen($protokoldosiero, 'a') or die("can't open file");
      fwrite($fh, $markilo . "\n");
      fwrite($fh, $query_gxenerala . ";\n");
      if (!empty($linio_gxenerala)) {
        fwrite($fh, $linio_gxenerala . ";\n");
        if (empty($ligilo_vk)) {
          fwrite($fh, "-->ligilo_vk ne trovata\n");
          fwrite($fh, $query_vk . ";\n");
        }
        if (empty($ligilo_vk_mp3)) {
          fwrite($fh, "-->ligilo_vk_mp3 ne trovata\n");
          fwrite($fh, $query_vk_mp3 . ";\n");
        }
        if (empty($ligilo_CD1D)) {
          fwrite($fh, "-->ligilo_CD1D ne trovata\n");
          fwrite($fh, $query_CD1D . ";\n");
        }
        if (empty($ligilo_muzikteksto)) {
          fwrite($fh, "-->ligilo_muzikteksto ne trovata\n");
          fwrite($fh, $query_muzikteksto . ";\n");
        }
        if (empty($ligilo_retpagxo)) {
          fwrite($fh, "-->ligilo_retpagxo ne trovata\n");
          fwrite($fh, $query_retpagxo . ";\n");
        }

      }
      else {
        fwrite($fh, "-->Neniu tiela linio trovita en la datumbazo. :( \n");
      }
      fclose($fh);
    }

  }

  // fine kreu por montri la ligiltekston
  $ligiloj_trovitaj = false;
  $ligilteksto = '</br>';
  if ( !empty($ligilo_vk) and strcmp($ligilo_vk , '-1')!=0 )
  {
    if ( $ligiloj_trovitaj )
    {
      $ligilteksto = $ligilteksto . ' - ';
    }
    $ligilteksto = $ligilteksto . '<a target="_blank" href="' . $ligilo_vk . '">Fizika albumo</a>';
    $ligiloj_trovitaj = true; 
  }
  if ( !empty($ligilo_vk_mp3) and strcmp($ligilo_vk_mp3 , '-1')!=0 )
  {
    if ( $ligiloj_trovitaj )
    {
      $ligilteksto = $ligilteksto . ' - ';
    }
    $ligilteksto = $ligilteksto . '<a target="_blank" href="' . $ligilo_vk_mp3 . '">MP3</a>'; 
    $ligiloj_trovitaj = true; 
  }
  if ( !empty($ligilo_CD1D) and strcmp($ligilo_CD1D , '-1')!=0 )
  {
    if ( $ligiloj_trovitaj )
    {
      $ligilteksto = $ligilteksto . ' - ';
    }
    $ligilteksto = $ligilteksto . '<a target="_blank" href="' . $ligilo_CD1D . '">CD1D</a>';
    $ligiloj_trovitaj = true;
  }
  if ( !empty($ligilo_muzikteksto) and strcmp($ligilo_muzikteksto , '-1')!=0 )
  {
    if ( $ligiloj_trovitaj )
    {
      $ligilteksto = $ligilteksto . ' - ';
    }
    $ligilteksto = $ligilteksto . '<a target="_blank" href="' . $ligilo_muzikteksto . '">Muzikteksto</a>'; 
    $ligiloj_trovitaj = true; 
  }
  if ( !empty($ligilo_retpagxo) and strcmp($ligilo_retpagxo , '-1')!=0 )
  {
    if ( $ligiloj_trovitaj )
    {
      $ligilteksto = $ligilteksto . ' - ';
    }
    $ligilteksto = $ligilteksto . '<a target="_blank" href="' . $ligilo_retpagxo . '">Retpaĝo</a>';
    $ligiloj_trovitaj = true; 
  }
  if ( $ligiloj_trovitaj )
  {
    echo $ligilteksto;
  }

}//xml true

?>
