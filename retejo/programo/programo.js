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

function showCalendar(event)
{
    NewCssCal(this.id, 'yyyyMMdd', 'arrow', true, '24');
}

function fillEndDate(event)
{
    var date = this.value;
    var dateRegexp = /(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):\d{1,2}/;
    var match = dateRegexp.exec(date);
    if (!match)
        return;
    var newDate = new Date(parseInt(match[1]), parseInt(match[2]) - 1, parseInt(match[3]), parseInt(match[4]));
    newDate.setHours(newDate.getHours() + 1);
    var newMonth = newDate.getMonth() + 1;
    var newDay = newDate.getDate();
    var newHours = newDate.getHours();
    if (newMonth < 10) newMonth = '0' + newMonth;
    if (newDay < 10) newDay = '0' + newDay;
    if (newHours < 10) newHours = '0' + newHours;
    document.getElementById(this.id.replace('eko', 'fino')).value =
        newDate.getFullYear() + '-' + newMonth + '-' + newDay + ' '
        + newHours + ':00';
}

function addDateRow(beginDate, endDate) {
    if (typeof this.counter == 'undefined') {
        this.counter = 0;
    }

    this.counter++;

    var row = document.createElement('div');
    row.id = 'dato' + this.counter;
    html = '<label for="eko' + this.counter + '">Dato ' + this.counter + '</label> ';
    html += '<input type="text" class="dato_input" name="ekoj[]" id="eko' + this.counter + '" placeholder="Eko" ' + (beginDate != null ? 'value="' + beginDate + '" ' : '') + '/> ';
    html += '<input type="text" class="dato_input" name="finoj[]" id="fino' + this.counter + '" placeholder="Fino" ' + (endDate != null ? 'value="' + endDate + '" ' : '') + '/>';
    html += '<div class="delete_date_row" id="forigu' + this.counter + '" title="Forigu ĉi tiun daton"></div>';
    row.innerHTML = html;
    document.getElementById('datoj').appendChild(row);
    document.getElementById('eko' + this.counter).addEventListener('click', showCalendar, false);
    document.getElementById('eko' + this.counter).addEventListener('blur', fillEndDate, false);
    document.getElementById('fino' + this.counter).addEventListener('click', showCalendar, false);
    document.getElementById('forigu' + this.counter).addEventListener('click', deleteDateRow, false);

    //forigiDaton(" + counter + ")
}
function deleteDateRow(event) {
    document.getElementById('datoj').removeChild(document.getElementById('dato'+this.id.replace('forigu', '')));
}

