/* Faru privatan nomspacon per funkcio */
(function ()
 {
   function formatTimePart (part)
   {
     part = part.toString ();
     if (part.length < 2)
       return "0" + part;
     else
       return part;
   }

   function formatTime (time)
   {
     return (formatTimePart (time.getHours ()) + ":" +
             formatTimePart (time.getMinutes ()));
   }

   function sxangxuHorojn (elem)
   {
     var ido;
     var komenco, fino;

     if ((komenco = elem.getAttribute ("komenctempo")) &&
         (fino = elem.getAttribute ("fintempo")))
     {
       var teksto = (formatTime (new Date (parseInt (komenco) * 1000)) +
                     "\u2013" +
                     formatTime (new Date (parseInt (fino) * 1000)));
       elem.innerHTML = "";
       elem.appendChild (document.createTextNode (teksto));
     }

     /* Rikure ankaŭ ŝanĝu ĉiujn idojn */
     for (ido = elem.firstChild; ido; ido = ido.nextSibling)
       if (ido.nodeType == 1)
         sxangxuHorojn (ido);
   }

   /* Registru hokfunkcion por ke kiam la paĝo fine elŝutiĝas ni
    * anstataŭigos UTCajn horojn per la loka horzono */
   var hokfunkcio = function () {
     var i;

     var programo_elem = document.getElementById ("aktualaprogramo");

     var noto = document.createElement ("div");
     noto.innerHTML = ("\u0108iuj horoj montri\u011das " +
                       "la\u016d via loka horzono.");
     noto.setAttribute ("id", "horzononoto");
     programo_elem.insertBefore (noto, programo_elem.firstChild);

     sxangxuHorojn (programo_elem);

     var limelem = document.getElementById ("ripetlimo");
     var limo = new Date ();
     limo.setUTCHours (4, 0);
     limelem.innerHTML = (formatTime (limo) + " la\u016d " +
                          "via loka horzono");
   };

   if (window.addEventListener)
     window.addEventListener ("load", hokfunkcio, false);
   else if (window.attachEvent)
     window.attachEvent ("onload", hokfunkcio);
 }) ();
