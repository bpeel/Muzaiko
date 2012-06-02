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

function inkluzivuDosierojn(elemento_prefikso)
{
  movuDosierojn(document.getElementById(elemento_prefikso + "-nedosieroj"),
                document.getElementById(elemento_prefikso + "-jesdosieroj"));
}

function malinkluzivuDosierojn(elemento_prefikso)
{
  movuDosierojn(document.getElementById(elemento_prefikso + "-jesdosieroj"),
                document.getElementById(elemento_prefikso + "-nedosieroj"));
}

function gxisdatiguSondosierojn(elemento_prefikso, formularo)
{
  var redaktkamparo = document.getElementById(formularo);
  var jesElemo = document.getElementById(elemento_prefikso + "-jesdosieroj");

  $('input[name="sondosiero[]"]', $('#' + formularo)).remove();

  for (elemo = jesElemo.firstChild; elemo; elemo = elemo.nextSibling)
  {
    if (elemo.nodeType == 1)
    {
      var ido = document.createElement("input");
      ido.setAttribute("type", "hidden");
      ido.setAttribute("name", "sondosiero[]");
      ido.setAttribute("value", elemo.value);
      redaktkamparo.appendChild(ido);
    }
  }
}

