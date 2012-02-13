/* -*- js -*- */

function movuDosierojn(elElemento, alElemento)
{
  var elemo, sekva;
  var aldonloko;

  aldonloko = alElemento.firstChild;

  for (elemo = elElemento.firstChild; elemo; elemo = sekva)
  {
    sekva = elemo.nextSibling;

    if (elemo.nodeType == 1 && elemo.selected)
    {
      elElemento.removeChild(elemo);
      elemo.selected = false;

      /* La elementoj devus esti ankoraŭ ordigitaj en ambaŭ patraj
       * elementoj do ni serĉu la elementon kiu troviĝu post la
       * nova */
      while (aldonloko &&
             (aldonloko.nodeType != 1 ||
              aldonloko.text < elemo.text))
        aldonloko = aldonloko.nextSibling;
      if (aldonloko)
        alElemento.insertBefore(elemo, aldonloko);
      else
        alElemento.appendChild(elemo);
    }
  }
}

function inkluzivuDosierojn()
{
  movuDosierojn(document.getElementById("nedosieroj"),
                document.getElementById("jesdosieroj"));
}

function malinkluzivuDosierojn()
{
  movuDosierojn(document.getElementById("jesdosieroj"),
                document.getElementById("nedosieroj"));
}

function gxisdatiguSondosierojn()
{
  var redaktkamparo = document.getElementById("redaktkamparo");
  var jesElemo = document.getElementById("jesdosieroj");

  for (elemo = jesElemo.firstChild; elemo; elemo = elemo.nextSibling)
  {
    if (elemo.nodeType == 1)
    {
      var ido = document.createElement("input");
      ido.setAttribute("type", "hidden");
      ido.setAttribute("name", "sondosieroj[]");
      ido.setAttribute("value", elemo.value);
      redaktkamparo.appendChild(ido);
    }
  }
}
