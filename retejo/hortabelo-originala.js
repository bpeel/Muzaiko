/* Listo de la programeroj devos jam esti en tabelo nomata
   'programo'. Ĉiu parto estas tri-parta tabelo kun la formo:
   [ komenctempo, fintempo, nomo ]
   Ĉiu tempo estas la nombro da sekundoj post la epoko
*/

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
     time = new Date (time * 1000);
     return (formatTimePart (time.getHours ()) + ":" +
             formatTimePart (time.getMinutes ()));
   }

   var i;

   /* Oridigu la programon laŭ la komenctempo */
   programo.sort (function (a, b) { return a[0] - b[0] });

   /* Trovu la limojn de la tempoj por la tuto programo */
   var komenco = programo[0][0];
   var fino = programo[programo.length - 1][1];

   /* Kiom da sekundoj pasis ekde la komenco de la programo? */
   var now = new Date ();
   var sekundoj_ekde_komenco = now.getTime () / 1000 - komenco;

   /* Se la programo ne jam komenciĝis, estas ia problemo do ni rezignu */
   if (sekundoj_ekde_komenco < 0)
     return;

   /* Kalkulu kiom da sekundoj jam pasis en la ripetata programo */
   var dauxro = fino - komenco;
   var pasintaj = sekundoj_ekde_komenco % dauxro;
   /* Kiu ripeto ludiĝas nun? */
   var nuna_ripeto = Math.floor (sekundoj_ekde_komenco / dauxro);
   /* Kalkulu kiam komenciĝis la nuna ripeto */
   var komenco_de_nuna_ripeto = komenco + nuna_ripeto * dauxro;

   /* Trovu la nunan ludatan programeron */
   var nuna_programo = null;
   for (i = 0; i < programo.length; i++)
   {
     if (pasintaj + komenco >= programo[i][0] &&
         pasintaj + komenco < programo[i][1])
     {
       nuna_programo = i;
       break;
     }
   }

   /* Se neniu programo troviĝis, estas ia eraro do ni rezignu */
   if (nuna_programo === null)
     return;

   /* Provu trovi la nomon de la tempozono el la nuna ĉena tempo */
   var match;
   var tempozono;
   if ((match = /\(([A-Z]+)\)$/.exec (now.toString ())))
     tempozono = match[1];
   else
     /* Rezignu */
     return;

   /* Registru hokfunkcion por ke kiam la paĝo fine elŝutiĝas ni
    * anstataŭigos la aktualan programon per la nova */
   var hokfunkcio = function () {
     var i;

     var programo_elem = document.getElementById ("programo");
     programo_elem.innerHTML = "";

     /* Komenciĝu per la nuna programo */
     i = nuna_programo;
     do
     {
       var programero = programo[i];
       var elem = document.createElement ("li");
       var programerokomenco = programero[0] - komenco + komenco_de_nuna_ripeto;
       var programerofino = programero[1] - komenco + komenco_de_nuna_ripeto;
       var tempo =
         (formatTime (programerokomenco) + "\u2013" +
          formatTime (programerofino) + " " + tempozono + ": ");

       elem.appendChild (document.createTextNode (tempo));

       var nomelemento = document.createElement ("span");
       /* La nomo de le programero jam estas en HTML */
       nomelemento.innerHTML = programero[2];
       elem.appendChild (nomelemento);

       programo_elem.appendChild (elem);

       if (++i >= programo.length)
       {
         komenco_de_nuna_ripeto += dauxro;
         i = 0;
       }
     } while (i != nuna_programo);
   };

   if (window.addEventListener)
     window.addEventListener ("load", hokfunkcio, false);
   else if (window.attachEvent)
     window.attachEvent ("onload", hokfunkcio);
 }) ();
