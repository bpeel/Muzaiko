<?php

//  ne funkcias cxar mankas la dosiero
// function current_song() {
// 	return trim(file_get_contents('/radio/playing.txt'));
// }

function current_show($time=-1, $error_on_missing=false) {
        // FIXME: This function no longer works because the admin files
	// are no longer available
        return array ("title" => "Ia Kanto",
                      "clock" => 0,
                      "desc" => "Mojosaĵo");
}

function cxapeligu($signocxeno) {
  
  $signocxeno = str_replace('cx', 'ĉ', $signocxeno);
  $signocxeno = str_replace('gx', 'ĝ', $signocxeno);
  $signocxeno = str_replace('hx', 'ĥ', $signocxeno);
  $signocxeno = str_replace('jx', 'ĵ', $signocxeno);
  $signocxeno = str_replace('sx', 'ŝ', $signocxeno);
  $signocxeno = str_replace('ux', 'ŭ', $signocxeno);

  $signocxeno = str_replace('Cx', 'Ĉ', $signocxeno);
  $signocxeno = str_replace('Gx', 'Ĝ', $signocxeno);
  $signocxeno = str_replace('Hx', 'Ĥ', $signocxeno);
  $signocxeno = str_replace('Jx', 'Ĵ', $signocxeno);
  $signocxeno = str_replace('Sx', 'Ŝ', $signocxeno);
  $signocxeno = str_replace('Ux', 'Ŭ', $signocxeno);

  $signocxeno = str_replace('cX', 'ĉ', $signocxeno);
  $signocxeno = str_replace('gX', 'ĝ', $signocxeno);
  $signocxeno = str_replace('hX', 'ĥ', $signocxeno);
  $signocxeno = str_replace('jX', 'ĵ', $signocxeno);
  $signocxeno = str_replace('sX', 'ŝ', $signocxeno);
  $signocxeno = str_replace('uX', 'ŭ', $signocxeno);

  $signocxeno = str_replace('CX', 'Ĉ', $signocxeno);
  $signocxeno = str_replace('GX', 'Ĝ', $signocxeno);
  $signocxeno = str_replace('HX', 'Ĥ', $signocxeno);
  $signocxeno = str_replace('JX', 'Ĵ', $signocxeno);
  $signocxeno = str_replace('SX', 'Ŝ', $signocxeno);
  $signocxeno = str_replace('UX', 'Ŭ', $signocxeno);
  
  return $signocxeno;
}

function malcxapeligu($signocxeno) {
  
  $signocxeno = str_replace('ĉ', 'cx', $signocxeno);
  $signocxeno = str_replace('ĝ', 'gx', $signocxeno);
  $signocxeno = str_replace('ĥ', 'hx', $signocxeno);
  $signocxeno = str_replace('ĵ', 'jx', $signocxeno);
  $signocxeno = str_replace('ŝ', 'sx', $signocxeno);
  $signocxeno = str_replace('ŭ', 'ux', $signocxeno);

  $signocxeno = str_replace('Ĉ', 'Cx', $signocxeno);
  $signocxeno = str_replace('Ĝ', 'Gx', $signocxeno);
  $signocxeno = str_replace('Ĥ', 'Hx', $signocxeno);
  $signocxeno = str_replace('Ĵ', 'Jx', $signocxeno);
  $signocxeno = str_replace('Ŝ', 'Sx', $signocxeno);
  $signocxeno = str_replace('Ŭ', 'Ux', $signocxeno);
  
  return $signocxeno;
}

// vidu http://php.net/manual/en/function.date-default-timezone-set.php
function setTimezoneByOffset($offset)
    {
      $testTimestamp = time();
        date_default_timezone_set('UTC');
        $testLocaltime = localtime($testTimestamp,true);
        $testHour = $testLocaltime['tm_hour'];       

     
    $abbrarray = timezone_abbreviations_list();
    foreach ($abbrarray as $abbr)
    {
        //echo $abbr."<br>";
      foreach ($abbr as $city)
      {
                date_default_timezone_set($city['timezone_id']);
                $testLocaltime     = localtime($testTimestamp,true);
                $hour                     = $testLocaltime['tm_hour'];       
                $testOffset =  $hour - $testHour;
                if($testOffset == $offset)
                {
                    return true;
                }
      }
    }
    return false;
    } 
    
?>
