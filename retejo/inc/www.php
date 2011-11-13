<?php

function page_header($title, $headtitle=NULL) {
	if ($headtitle===NULL) $headtitle = $title;
	if ($headtitle!='') $headtitle .= ' - ';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function dodates() {

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$headtitle?>Muzaiko</title>
<link rel="stylesheet" type="text/css" href="images/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="images/style_calendar.css" media="screen" />
</head>

<body>
<div id="main_container">

<div id="header">
<div id="logo"><a href="."><img src="images/emblemo.png" alt="emblemo" title="" border="0" /></a></div>
	<div class="on_air">
	  <?php include('ajax/onair.php'); ?>
	</div>
<!--	<div class="on_air">
	  <php include('ajax/nombro_da_auxskultantoj_ajax.php'); ?> 
	</div>-->
</div>

<div id="menu">
<ul>
	<li><a class="current" href="." title="">hejmo</a></li>
	<li><a href="./auxskultu" title="">aŭskultu</a></li>
	<li><a href="./programeroj" title="">programeroj</a></li>
	<!--<li><a href="/muziko" title="">muziko</a></li>-->
	<li><a href="./subtenu" title="">subtenu</a></li>
	<li><a href="./reklamu" title="">reklamu</a></li>
	<li><a href="./financoj" title="">financoj</a></li>
	<li><a href="./partoprenu" title="">partoprenu</a></li>
	<li><a href="./kontaktu" title="">kontaktu</a></li>
</ul>
</div>
<div class="left_content">
<h1><?=$title?></h1>
<?php
}

//Malbela rapida solvo
//function right($title='Pri Muzaiko') {
function right($title='') {
?>
</div>

<div class="right_content">
<a href="/auxskultu" onClick="window.open('http://www.radionomy.com/en/radio/muzaikoinfo/listen');"><img src="images/auxskultu_radionomy.png" alt="Klaku tie por aŭskulti radio Muzaiko per Radionomy." title="" class="listen_live" border="0" /></a>
<a href="/auxskultu" onClick="window.open('http://listen.radionomy.com/muzaikoinfo.m3u');"><img src="images/auxskultu_muzikludilo.png" alt="Klaku tie por aŭskulti radio Muzaiko per via muzikludilo." title="" class="listen_live" border="0" /></a>
<!--<div class="title"><?=$title?></div>-->

<div class="dekstra_titolo">Aŭskultu:</div>
<div class="dekstra_teksto">
<ul>
	<li>Per <a target="_blank" href="http://www.radionomy.com/en/radio/muzaikoinfo/listen#">Radionomy</a></li>
	<li>Per via preferata <a href="http://listen.radionomy.com/muzaikoinfo.m3u">muzikludilo</a></li>
	<li>Rekte en via retumilo per <a target="_blank" href="http://listen.radionomy.com/muzaikoinfo">muzikluda kromprogramo</a></li>
</ul>
</div>

<div class="dekstra_titolo">Eksciu pli pri Muzaiko ĉe:</div>
<div class="dekstra_teksto">
<ul>
	<li><a href="http://www.esperanto-junularo.hu/2011/06/nova-projekto-kreos-tuttempan-radion-en.html">la retpaĝo de HEJ</a></li>
	<li><a href="http://tejo.org/tejo-aktuale/index.php?num=2011-06-15">TEJO-aktuale</a></li>
	<li><a href="http://esperanto.cri.cn/641/2011/06/17/1s125271.htm">Ĉina Radio Internacia</a></li>
	<li><a href="http://www.tejo.org/eo/node/1249">La blogo de TEJO Tutmonde</a></li>
	<li><a href="http://www.liberafolio.org/2011/muzaiko-planas-sendi-retradion-en-esperanto-senpauze">Libera Folio</a></li>
</ul>
</div>

<div class="dekstra_titolo">Babilu kun ni tujmesaĝe:</div>
<div class="dekstra_teksto">
<ul>
	<li>Per via IRC kliento ĉe #Muzaiko@freenode.net</li>
	<li><a href="http://webchat.freenode.net?channels=Muzaiko&uio=d4">Per TTT IRC kliento</a> (tajpu kromnomon en la "Nickname" kampo, solvu la CAPTCHA kaj klaku sur "Connect")</li>
</ul>
</div>

<div class="dekstra_titolo">Partneroj:</div>
<a target="_blank" href="http://vinilkosmo.com"><img src="images/vinilkosmo.gif" alt="logotipo de vinilkosmo.com kun ligilo al gxi"></a>
<a target="_blank" href="http://vinilkosmo-mp3.com"><img src="images/vinilkosmo-mp3.gif" alt="logotipo de vinilkosmo-mp3.com kun ligilo al gxi"></a>

</div>

<!-- aŭ vervive dum aranĝoj kiel
<a href="http://www.kongreso2011.org/">TAKE</a>,
<a href="http://www.ijk-67.retejo.info/">IJK</a>,
<a href="http://eo.lernu.net/pri_lernu/renkontighoj/SES/2011/index.php">SES</a>,
<a href="http://www.festo.lautre.net/">FESTO</a>
aŭ <a href="http://ijs.hu/eo">IJS</a> -->.


</div>

<?php
}

function right_contents() {
?>
     
<!-- 
    <div class="right_news">
    	<div class="news_date">30.02</div>
        <div class="news_content">
        <span class="red">Lorem ipsum dolor sit amet</span><br />
Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
		</div>  
    </div>  
  
    
    <div class="right_news">
    	<div class="news_date">30.02</div>
        <div class="news_content">
        <span class="red">Lorem ipsum dolor sit amet</span><br />
Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
		</div>  
    </div>    
    
    
    <div class="right_news">
    	<div class="news_date">30.02</div>
        <div class="news_content">
        <span class="red">Lorem ipsum dolor sit amet</span><br />
Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
		</div>  
    </div>   
    
    
     <div class="right_news">
    	<div class="news_date">30.02</div>
        <div class="news_content">
        <span class="red">Lorem ipsum dolor sit amet</span><br />
Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
		</div>  
    </div>
-->
    
<?php
}

function page_footer($homelink=true) {
?>
</div>



<div id="footer">
<div class="footer_links">                      
<a href="." title="">hejmo</a>
<a href="./auxskultu" title="">aŭskultu</a>
<a href="./programeroj" title="">programeroj</a>
<!-- <a href="/muziko" title="">muziko</a> -->
<a href="./subtenu" title="">subtenu</a>
<a href="./reklamu" title="">reklamu</a>
<a href="./financoj" title="">financoj</a>
<a href="./partoprenu" title="">partoprenu</a>
<a href="./kontaktu" title="">kontaktu</a>
</div>
<div class="copyright">
&copy; Muzaiko 2011. Ŝablono de <a class="acopyright" href="http://csstemplatesmarket.com" target="_blank">CSS Templates Market</a>
</div>
</div>
</div>
<script language="javascript">
var date=new Date();
var tzoffset=date.getTimezoneOffset()*-60;
date.setDate(date.getDate()+365);
document.cookie='tzoffset='+tzoffset+'; expires='+date.toUTCString();
var ad=document.getElementsByTagName('div'), i=0, a;
for (var i=0; (a=ad[i])!=null; i++) {
	if (a.className!='show_date') continue;
	if (a.id==0) continue;
	var d = new Date(parseInt(a.id));
	var h = d.getHours();
	var s = h+':00';
	if (h<10) s='0'+s;
	a.innerHTML = s;
}
</script>
</body>
</html>
<?php
}
