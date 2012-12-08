(function ()
 {
   var aktuala_titolo = null;
   var cxiuj_titoloj;
   var auxskultilo;
   var titoloj_div;
   var plenekranilo;
   var plenekrandiv;
   var plenekranilo_timeout;

   function akiru_tempon (a, b, c, d)
   {
     return (parseInt (d, 10) +
             parseInt (c, 10) * 1000 +
             parseInt (b, 10) * 60000 +
             parseInt (a, 10) * 60000000);
   }

   function aldonu_titolon (rez, lasta_fino, komenco, teksto)
   {
     var linifino;
     var elemoj;
     var lasta_loko = 0;

     /* Se estas paŭzo inter la lasta titolo kaj la nova, aldonu novan
      * blankan titolon */
     if (rez.length > 0 && lasta_fino < komenco)
       rez.push ([lasta_fino]);

     elemoj = [komenco];

     while ((linifino = teksto.indexOf ("\n", lasta_loko)) >= 0)
     {
       if (linifino > lasta_loko)
       {
         var parto = teksto.substring (lasta_loko, linifino);
         elemoj.push (document.createTextNode (parto));
       }
       elemoj.push (document.createElement ("br"));
       lasta_loko = linifino + 1;
     }
     if (lasta_loko < teksto.length)
       elemoj.push (document.createTextNode (teksto.substring (lasta_loko)));

     rez.push (elemoj);
   }

   function akiru_titolojn (teksto)
   {
     var re = /(?:^|\n)[0-9]+\n([0-9]{2}):([0-9]{2}):([0-9]{2}),([0-9]{3}) --> ([0-9]{2}):([0-9]{2}):([0-9]{2}),([0-9]{3})\n/;
     var rez = [];
     var lasta_komenco = 0;
     var lasta_fino = 0;
     var antauxlasta_fino = 0;

     while (true)
     {
       var trovajxo = re.exec (teksto);

       if (!trovajxo)
         break;

       var titolo = teksto.substring (0, trovajxo.index);
       if (/[^\s]/.exec (titolo))
         aldonu_titolon (rez, antauxlasta_fino, lasta_komenco, titolo);

       antauxlasta_fino = lasta_fino;
       lasta_komenco = akiru_tempon (trovajxo[1],
                                   trovajxo[2],
                                   trovajxo[3],
                                   trovajxo[4]);
       lasta_fino = akiru_tempon (trovajxo[5],
                                  trovajxo[6],
                                  trovajxo[7],
                                  trovajxo[8]);

       teksto = teksto.substring (trovajxo.index + trovajxo[0].length);
     }

     if (/[^\s]/.exec (teksto))
     {
       aldonu_titolon (rez, antauxlasta_fino, lasta_komenco, teksto);
       rez.push ([lasta_fino]);
     }

     return rez;
   }

   function time_update_cb ()
   {
     var aktuala_tempo = auxskultilo.currentTime * 1000.0;
     var min = 0, maks = cxiuj_titoloj.length;

     /* Duuma tranĉo por trovi la aktualan titolon */
     while (maks > min)
     {
       var mez = Math.floor ((maks + min) / 2);
       var mez_tempo = cxiuj_titoloj[mez][0];

       if (mez_tempo < aktuala_tempo)
         min = mez + 1;
       else
         maks = mez;
     }

     var nova_titolo = cxiuj_titoloj[min > 0 ? min - 1 : 0];

     if (nova_titolo != aktuala_titolo)
     {
       var i;

       titoloj_div.innerHTML = "";
       for (i = 1; i < nova_titolo.length; i++)
         titoloj_div.appendChild (nova_titolo[i]);

       titoloj_div.style.top =
         Math.round (plenekrandiv.offsetHeight / 2.0 -
                     titoloj_div.offsetHeight / 2.0) + "px";

       aktuala_titolo = nova_titolo;
     }
   }

   function movo_en_plenekrandiv_cb ()
   {
     plenekranilo.style.display = "block";
     if (plenekranilo_timeout)
       window.clearTimeout (plenekranilo_timeout);
     plenekranilo_timeout = window.setTimeout (function () {
       plenekranilo_timeout = false;
       plenekranilo.style.display = "none";
     }, 1000);
   }

   function estas_plenekrana ()
   {
     return ((document.fullScreenElement &&
              document.fullScreenElement !== null) ||
             document.webkitFullScreenElement ||
             document.mozFullScreenElement)
   }

   function plenekranilo_klako_cb ()
   {
     if (estas_plenekrana ())
     {
       if (document.exitFullScreen)
         document.exitFullScreen ();
       else if (document.mozCancelFullScreen)
         document.mozCancelFullScreen ();
       else if (document.webkitCancelFullScreen)
         document.webkitCancelFullScreen ();
     }
     else if (plenekrandiv.requestFullScreen)
       plenekrandiv.requestFullScreen ();
     else if (plenekrandiv.mozRequestFullScreen)
       plenekrandiv.mozRequestFullScreen ();
     else if (plenekrandiv.webkitRequestFullScreen)
       plenekrandiv.webkitRequestFullScreen ();
   }

   function komencu ()
   {
     var datumelem = document.getElementById ("subtitoldatumo");

     cxiuj_titoloj = akiru_titolojn (datumelem.textContent);

     if (cxiuj_titoloj.length > 1)
     {
       titoloj_div = document.getElementById ("titoloj");
       auxskultilo = document.getElementById ("auxskultilo");
       auxskultilo.addEventListener ("timeupdate", time_update_cb, false);

       if (titoloj_div.requestFullScreen ||
           titoloj_div.mozRequestFullScreen ||
           titoloj_div.webkitRequestFullScreen)
       {
         plenekranilo = document.getElementById ("plenekranilo")
         plenekranilo.addEventListener ("mousedown",
                                        plenekranilo_klako_cb,
                                        false);

         plenekrandiv = document.getElementById ("plenekrandiv");
         plenekrandiv.addEventListener ("mousemove",
                                        movo_en_plenekrandiv_cb,
                                        false);
       }
     }
   }

   if (window.addEventListener)
     window.addEventListener ("load", komencu, false);
 }) ();
