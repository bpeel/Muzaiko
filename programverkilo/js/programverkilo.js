$(document).ready(function(){
    $('#sxargado-mesagxo').fadeOut();
    $('#sxargado-fono').fadeOut();
});
$.fn.exists = function () {
    return this.length !== 0;
}
$(function() {
    $('#langetoj').tabs();

    var lasta_elsendo_kolumno = 10;

    var tabelo_programeroj = fari_tabelo({
        'tabelo': 'programero',
        'kolumnoj': [
            { 'nomo': 'titolo', 'tipo': 'teksto' },
            { 'nomo': 'skizo', 'tipo': 'arangxita_teksto', 'kromagordoj':
                { 'sType': 'html' }},
            { 'nomo': 'datoj', 'tipo': 'listo_de_datoj', 'kromagordoj':
                { 'iDataSort': lasta_elsendo_kolumno }},
            { 'nomo': 'komento', 'tipo': 'teksto' },
            { 'nomo': 'sondosiero', 'tipo': 'duobla_listo', 'kromagordoj':
                { 'sType': 'html' }},
            { 'nomo': 'parolanto', 'tipo': 'multilisto', 'kromagordoj':
                { 'sType': 'html' }},
            { 'nomo': 'produktanto', 'tipo': 'listo' },
            { 'nomo': 'temo', 'tipo': 'listo' },
            { 'nomo': 'sekcio', 'tipo': 'listo' },
            { 'nomo': 'permesilo', 'tipo': 'listo' },
            { 'nomo': 'lasta_elsendo', 'tipo': 'kasxita_datumo', 'kromagordoj':
                { 'bSearchable': false, 'bVisible': false }}
        ]
    });

    var tabelo_parolantoj = fari_tabelo({
        'tabelo': 'parolanto',
        'kolumnoj': [
            { 'nomo': 'nomo', 'tipo': 'teksto' }
        ]
    });

    var tabelo_produktantoj = fari_tabelo({
        'tabelo': 'produktanto',
        'kolumnoj': [
            { 'nomo': 'nomo', 'tipo': 'teksto' }
        ]
    });

    var tabelo_temo = fari_tabelo({
        'tabelo': 'temo',
        'kolumnoj': [
            { 'nomo': 'nomo', 'tipo': 'teksto' }
        ]
    });

    var tabelo_sekcio = fari_tabelo({
        'tabelo': 'sekcio',
        'kolumnoj': [
            { 'nomo': 'nomo', 'tipo': 'teksto' }
        ]
    });

    var tabelo_permesilo = fari_tabelo({
        'tabelo': 'permesilo',
        'kolumnoj': [
            { 'nomo': 'nomo', 'tipo': 'teksto' },
            { 'nomo': 'url', 'tipo': 'teksto' },
            { 'nomo': 'bildo', 'tipo': 'teksto' }
        ]
    });

    var datepicker_agordoj = {
        dateFormat: 'yy-mm-dd',
        showOtherMonths: true,
        selectOtherMonths: true,
        minDate: new Date(2011, 4 - 1, 10)
    };

    var timepicker_agordoj = {
       hours: { starts: 3, ends: 7 },
       minutes: { custom: [00, 15, 20, 30, 40, 45, 50] },
       showPeriodLabels: false,
       defaultTime: ''
    };

    $('.datelektilo').datepicker(datepicker_agordoj);

    $('.horelektilo').timepicker(timepicker_agordoj);

    $('#programero-unua-elsendo-dato').on('change', function() {
        if ($('#programero-unua-elsendo-dato').val() != ''
                && $('#programero-unua-elsendo-komenchoro').val() == ''
                && $('#programero-unua-elsendo-finhoro').val() == '') {
            $('#programero-unua-elsendo-komenchoro').val('03:00');
            $('#programero-unua-elsendo-finhoro').val('04:00');
        }
    });

    function ligi_komenchoron_kaj_finhoron(komenchoro_enigo, finhoro_enigo) {
        komenchoro_enigo.on('change', function() {
            var komenchoro = komenchoro_enigo.val().match(/(\d{2}):(\d{2})/);
            var finhoro = parseInt(komenchoro[1]) + 1;
            if (finhoro < 10)
                finhoro = '0' + finhoro;
            finhoro += ':' + komenchoro[2];
            finhoro_enigo.val(finhoro);
        });
    }

    ligi_komenchoron_kaj_finhoron($('#programero-unua-elsendo-komenchoro'),
            $('#programero-unua-elsendo-finhoro'));

    var elsendnumero = 0;

    $('#butono-aldoni-elsendon').on('click', function() {
         aldoni_elsendon('', '', '');
    });

    var lasta_rapida_aldono_ujo = null;

    function kasxi_rapide_aldonan_formularon() {
        if (lasta_rapida_aldono_ujo) {
            lasta_rapida_aldono_ujo.html('<a href="#" class="rapida_aldono">Rapida aldono</a>');
            var ligilo = $('.rapida_aldono', lasta_rapida_aldono_ujo);
            montri_rapide_aldonan_formularon(ligilo);
            lasta_rapida_aldono_ujo = null;
        }
    }

    function montri_rapide_aldonan_formularon(ligilo) {
        ligilo.on('click', function() {
            var td = $(this).closest('td')[0];
            var lasta_elsendo = $('ol li:last', td).text()
                .match(/(\d{4}-\d{2}-\d{2}).+\((\d{2}:\d{2}).+(\d{2}:\d{2})\)/);
            var komenchoro = '03:00';
            var finhoro = '04:00';
            if (lasta_elsendo) {
                komenchoro = lasta_elsendo[2];
                finhoro = lasta_elsendo[3];
            }
            var html = '<form>'
                + '<input type="text" class="datelektilo" name="elsendo_dato" />'
                + '<input type="text" class="horelektilo" name="elsendo_komenchoro" value="' + komenchoro + '" />'
                + '-<input type="text" class="horelektilo" name="elsendo_finhoro" value="' + finhoro + '" />'
                + '<input type="submit" value="Registri" />'
                + ' <input type="button" value="Nuligi" />'
                + '</form>';
            var ujo = $($(this).closest('div')[0]);
            ujo.html(html);
            ligi_komenchoron_kaj_finhoron($('input[name="elsendo_komenchoro"]', ujo),
                $('input[name="elsendo_finhoro"]', ujo));
            $('.datelektilo', ujo).datepicker(datepicker_agordoj);
            $('.horelektilo', ujo).timepicker(timepicker_agordoj);
            $('input[value="Registri"]', ujo).on('click',
                { 'tdElemento': td, 'formularo': $('form', ujo) },
                function(event) {
                    var programero_id = $(event.data.tdElemento).closest('tr')[0].id;
                    $.post('./ajax/gxisdatigi_elsendojn.php?opeco=unuopa&programero_id=' + programero_id,
                        event.data.formularo.serialize(),
                        function(respondo) {
                            if (respondo.rezulto == 'sukceso') {
                                var aPos = tabelo_programeroj.fnGetPosition(event.data.tdElemento);
                                tabelo_programeroj.fnUpdate(respondo.elsendoj, aPos[0], aPos[1], false);
                                tabelo_programeroj.fnUpdate(respondo.lasta_elsendo, aPos[0], lasta_elsendo_kolumno, false);
                                montri_rapide_aldonan_formularon($('.rapida_aldono', event.data.tdElemento));
                            } else {
                                alert('Eraro: ' + respondo.mesagxo);
                            }
                        }
                    );
                    return false;
                }
            );
            $('input[value="Nuligi"]', ujo).on('click', function() {
                kasxi_rapide_aldonan_formularon();
            });
            kasxi_rapide_aldonan_formularon();
            lasta_rapida_aldono_ujo = ujo;
            return false;
        });
    }

    var antauxa_valoro;

    function fari_tabelo(agordoj) {
        function init_horizontalo(tabelo, trElemento) {
            $(trElemento).click(function(e) {
                if ($(this).hasClass('row_selected')) {
                    $(this).removeClass('row_selected');
                } else {
                    tabelo.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                }
            });
            $('td', trElemento).each(function(tdIndekso, tdElemento) {
                if (agordoj.kolumnoj[tdIndekso].tipo == 'kasxita_datumo') {
                } else if (agordoj.kolumnoj[tdIndekso].tipo == 'listo_de_datoj') {
                    $(tdElemento).on('dblclick', function() {
                        redakti_listo_de_datoj(this, trElemento.id);
                    });
                    montri_rapide_aldonan_formularon($('a.rapida_aldono', tdElemento));
                } else if (agordoj.kolumnoj[tdIndekso].tipo == 'duobla_listo') {
                    $(tdElemento).on('dblclick', function() {
                        $('#formularo-programero-sondosieroj')
                            .data('programero_id', trElemento.id)
                            .data('tdElemento', tdElemento)
                            .dialog('open');
                    });
                } else {
                    var redaktagordoj = {};
                    if (agordoj.kolumnoj[tdIndekso].tipo == 'teksto') {
                        redaktagordoj['type'] = 'textarea';
                    } else if (agordoj.kolumnoj[tdIndekso].tipo == 'arangxita_teksto') {
                        redaktagordoj['type'] = 'textarea';
                        redaktagordoj['loadurl'] = './ajax/akiri.php?tabelo=' + agordoj.tabelo + '&kolumno=' + agordoj.kolumnoj[tdIndekso].nomo + '&horizontalo=' + trElemento.id;
                    } else if (agordoj.kolumnoj[tdIndekso].tipo == 'listo') {
                        redaktagordoj['type'] = 'select';
                        redaktagordoj['loadurl'] = './ajax/listi.php?listo=' + agordoj.kolumnoj[tdIndekso].nomo;
                    } else if (agordoj.kolumnoj[tdIndekso].tipo == 'multilisto') {
                        redaktagordoj['type'] = 'multiselect';
                        redaktagordoj['loadurl'] = './ajax/listi.php?listo=' + agordoj.kolumnoj[tdIndekso].nomo;
                    }
                    redaktagordoj['name'] = 'valoro';
                    redaktagordoj['submit'] = 'Registri';
                    redaktagordoj['cancel'] = 'Nuligi';
                    redaktagordoj['placeholder'] = '';
                    redaktagordoj['event'] = 'dblclick';
                    redaktagordoj['callback'] = function(sValue, y) {
                        var respondo = JSON.parse(sValue, null);
                        var aPos = tabelo.fnGetPosition(this);
                        if (respondo.rezulto == 'sukceso') {
                            tabelo.fnUpdate(respondo.mesagxo, aPos[0], aPos[1], false);
                        } else {
                            tabelo.fnUpdate(antauxa_valoro, aPos[0], aPos[1], false);
                            alert('Eraro: ' + respondo.mesagxo);
                        }
                    };
                    redaktagordoj['submitdata'] = function ( value, settings ) {
                        antauxa_valoro = value;
                        return {
                            "horizontalo": trElemento.id,
                            "kolumno": agordoj.kolumnoj[tdIndekso].nomo
                        };
                    };
                    $(tdElemento).editable('./ajax/gxisdatigi.php?tabelo=' + agordoj.tabelo + '&tipo=' + agordoj.kolumnoj[tdIndekso].tipo, redaktagordoj);
                }
            });
        }

        var kolumnoj = [];
        $.each(agordoj.kolumnoj, function(indekso, kolumno) {
            var agordoj = { 'mDataProp': kolumno.nomo };
            if (kolumno.kromagordoj)
                $.extend(agordoj, kolumno.kromagordoj);
            kolumnoj.push(agordoj);
        });
        var tabelo = $('#tabelo-' + agordoj.tabelo).dataTable({
            'aoColumns': kolumnoj,
            'bJQueryUI': true,
            'sPaginationType': 'full_numbers',
            'sDom': '<"H"lf<"#butonoj-' + agordoj.tabelo + '">r>t<"F"ip>',
            'oLanguage': {
                'sProcessing':   'Komputante…',
                'sLengthMenu':   'Montri _MENU_ elementojn',
                'sZeroRecords':  'Neniu elemento por montri',
                'sInfo':         'Montrado de la elementoj _START_ ĝis _END_ el _TOTAL_ elementoj',
                'sInfoEmpty':    'Montrado de la elementoj 0 ĝis 0 el 0 elementoj',
                'sInfoFiltered': '(filtrita el _MAX_ elementoj entute)',
                'sInfoPostFix':  '',
                'sSearch':       'Serĉi:',
                'sUrl':          '',
                'oPaginate': {
                    'sFirst':    'Unua',
                    'sPrevious': 'Antaŭa',
                    'sNext':     'Posta',
                    'sLast':     'Lasta'
                }
            }
        });
        $('div#butonoj-' + agordoj.tabelo).html('<div style="margin-left: 160px;">'
                                + '<input type="button" id="krebutono-'
                                + agordoj.tabelo + '" value="Krei '
                                + agordoj.tabelo + 'n" />'
                                + '<input type="button" id="forvisxbutono-'
                                + agordoj.tabelo + '" value="Forviŝi la elektitan '
                                + agordoj.tabelo + 'n" /></div>');
        $.each(tabelo.fnGetNodes(), function(trIndekso, trElemento) {
            init_horizontalo(tabelo, trElemento);
        });

        /*
         * Kreformularo
         */

        var formularo = $('#formularo-' + agordoj.tabelo);

        formularo.dialog({
            autoOpen: false,
            closeOnEscape: true,
            closeText: 'Fermi',
            draggable: true,
            modal: true,
            width: ((agordoj.tabelo == 'programero') ? '800px' : '300px'),
            resizable: true,
            buttons: {
                'Registri': function() {
                    if (agordoj.tabelo == 'programero') {
                        gxisdatiguSondosierojn('kreformularo', 'formularo-' + agordoj.tabelo);
                    }
                    $.post('./ajax/krei.php?tabelo=' + agordoj.tabelo, formularo.serialize(), function(respondo) {
                        if (respondo.rezulto == 'sukceso') {
                            init_horizontalo(tabelo, tabelo.fnGetNodes(tabelo.fnAddData(respondo.datumoj)));
                            $('#kreformularo-jesdosieroj option').remove();
                            formularo.dialog('close');
                        } else {
                            alert('Eraro: ' + respondo.mesagxo);
                        }
                    });
                },
                'Nuligi': function() {
                    $(this).dialog('close');
                }
            },
            close: function() {
                formularo[0].reset();
            }
        });

        function malplenigi_listojn_de_kreformularo(agordoj) {
            $('#formularo-' + agordoj.tabelo + ' select option').remove();
        }

        function plenigi_listojn_de_kreformularo(agordoj) {
            $.each(agordoj.kolumnoj, function(indekso, kolumno) {
                if (kolumno.tipo == 'listo' || kolumno.tipo == 'multilisto') {
                    $.getJSON('./ajax/listi.php?listo=' + kolumno.nomo, function (elementoj) {
                        for (var valoro in elementoj)
                            $('<option>').val(valoro).text(elementoj[valoro]).appendTo($('#' + agordoj.tabelo + '-' + kolumno.nomo));
                    })
                }
            });

            if (agordoj.tabelo == 'programero') {
                $.get('./ajax/listi_sondosierojn.php?kiujn=neuzitajn', function(elementoj) {
                    $('#kreformularo-nedosieroj').html(elementoj);
                });
            }
        }

        /*
         * Krebutono
         */

        $('#krebutono-' + agordoj.tabelo).on('click', function(e) {
            malplenigi_listojn_de_kreformularo(agordoj);
            plenigi_listojn_de_kreformularo(agordoj);
            formularo.dialog('open');
        });

        /*
         * Forviŝbutono
         */

        $('#forvisxbutono-' + agordoj.tabelo).on('click', function(e) {
            var elektitaj_horizontaloj = tabelo.$('tr.row_selected');
            if (elektitaj_horizontaloj.length !== 0) {
                if (confirm('Ĉu vi vere volas forviŝi la elektitan ' + agordoj.tabelo + 'n?')) {
                    $.post('./ajax/forvisxi.php?tabelo=' + agordoj.tabelo, { 'id': elektitaj_horizontaloj[0].id }, function(respondo) {
                        if (respondo.rezulto == 'sukceso') {
                            tabelo.fnDeleteRow(elektitaj_horizontaloj[0]);
                        } else {
                            alert('Eraro: ' + respondo.mesagxo);
                        }
                    });
                }
            } else {
                alert('Neniu ' + agordoj.tabelo + ' elektita.');
            }
        });

        return tabelo;

    }

    $('#formularo-programero-elsendo-datoj').dialog({
        autoOpen: false,
        closeOnEscape: true,
        closeText: 'Fermi',
        draggable: true,
        modal: true,
        width: '400px',
        resizable: true,
        buttons: {
            'Registri': function() {
                var formularo = $(this);
                $.post('./ajax/gxisdatigi_elsendojn.php?opeco=pluropa&programero_id=' + formularo.data('programero_id'), $('#formularo-programero-elsendo-datoj').serialize(), function(respondo) {
                    if (respondo.rezulto == 'sukceso') {
                        var aPos = tabelo_programeroj.fnGetPosition(formularo.data('tdElemento'));
                        tabelo_programeroj.fnUpdate(respondo.elsendoj, aPos[0], aPos[1], false);
                        tabelo_programeroj.fnUpdate(respondo.lasta_elsendo, aPos[0], lasta_elsendo_kolumno, false);
                        montri_rapide_aldonan_formularon($('.rapida_aldono', formularo.data('tdElemento')));
                        formularo.dialog('close');
                    } else {
                        alert('Eraro: ' + respondo.mesagxo);
                    }
                });
            },
            'Nuligi': function() {
                $(this).dialog('close');
            }
        },
        open: function(event, ui) {
            $('#butono-aldoni-elsendon').focus();
        },
        close: function() {
            $('#formularo-programero-elsendo-datoj')[0].reset();
        }
    });

    function redakti_listo_de_datoj(tdElemento, programero_id) {
        forigi_elsendojn();
        var arr = $('li', tdElemento).map(function(i, el) {
            var elsendo = $(el).text().match(/(\d{4}-\d{2}-\d{2}).+\((\d{2}:\d{2}).+(\d{2}:\d{2})\)/);
            aldoni_elsendon(elsendo[1], elsendo[2], elsendo[3]);
        });
        $('#formularo-programero-elsendo-datoj .datelektilo').datepicker('disable');
        $('#formularo-programero-elsendo-datoj .horelektilo').timepicker('disable');
        $('#formularo-programero-elsendo-datoj')
            .data('programero_id', programero_id)
            .data('tdElemento', tdElemento)
            .dialog('open');
        $('#formularo-programero-elsendo-datoj .datelektilo').datepicker('enable');
        $('#formularo-programero-elsendo-datoj .horelektilo').timepicker('enable');
    }

    function forigi_elsendojn() {
        $('#formularo-programero-elsendo-datoj>ol>li').remove();
    }

    function aldoni_elsendon(dato, komenchoro, finhoro) {
        if ((komenchoro == null || komenchoro == '') && (finhoro == null || finhoro == '')) {
            for (var i = elsendnumero; i > 0; i--) {
                if ($('#elsendo-' + i).exists()) {
                    if (komenchoro == null || komenchoro == '')
                        komenchoro = $('#elsendo-komenchoro-' + i).val();
                    if (finhoro == null || finhoro == '')
                        finhoro = $('#elsendo-finhoro-' + i).val();
                }
            }
        }
        if (komenchoro == null || komenchoro == '')
            komenchoro = '03:00';
        if (finhoro == null || finhoro == '')
            finhoro = '04:00';
        elsendnumero++;
        var html_elsendo = $('<li id="elsendo-' + elsendnumero + '">'
            + '<label for="elsendo-dato-' + elsendnumero + '">Elsendo</label>'
            + '<input type="text" id="elsendo-dato-' + elsendnumero
            + '" class="datelektilo" name="elsendo_dato[]" value="' + dato + '" />'
            + '<input type="text" id="elsendo-komenchoro-' + elsendnumero
            + '" class="horelektilo" name="elsendo_komenchoro[]" value="' + komenchoro + '" />'
            + '-<input type="text" id="elsendo-finhoro-' + elsendnumero
            + '" class="horelektilo" name="elsendo_finhoro[]" value="' + finhoro + '" />'
            + ' <input type="button" value="Forigi" />'
            + '</li>');
        $('#formularo-programero-elsendo-datoj>ol').append(html_elsendo);
        $('#elsendo-' + elsendnumero + '>input.datelektilo').datepicker(datepicker_agordoj);
        $('#elsendo-' + elsendnumero + '>input.horelektilo').timepicker(timepicker_agordoj);
        ligi_komenchoron_kaj_finhoron($('#elsendo-komenchoro-' + elsendnumero),
                $('#elsendo-finhoro-' + elsendnumero));
        $('#elsendo-' + elsendnumero + '>input[type=button]').on('click', function() {
            $(this).closest('li').fadeOut(function() {
                $(this).remove();
            });
        });
        return $('#elsendo-' + elsendnumero);
    }

    $('#formularo-programero-sondosieroj').dialog({
        autoOpen: false,
        closeOnEscape: true,
        closeText: 'Fermi',
        draggable: true,
        modal: true,
        width: '750px',
        resizable: true,
        buttons: {
            'Registri': function() {
                var formularo = $(this);
                gxisdatiguSondosierojn('redaktformularo', 'formularo-programero-sondosieroj');
                $.post('./ajax/gxisdatigi_sondosierojn.php?programero_id=' + formularo.data('programero_id'), $('#formularo-programero-sondosieroj').serialize(), function(respondo) {
                    if (respondo.rezulto == 'sukceso') {
                        var aPos = tabelo_programeroj.fnGetPosition(formularo.data('tdElemento'));
                        tabelo_programeroj.fnUpdate(respondo.sondosieroj, aPos[0], aPos[1], false);
                        formularo.dialog('close');
                    } else {
                        alert('Eraro: ' + respondo.mesagxo);
                    }
                });
            },
            'Nuligi': function() {
                $(this).dialog('close');
            }
        },
        open: function(event, ui) {
            $('#redaktformularo-nedosieroj option').remove();
            $('#redaktformularo-jesdosieroj option').remove();
            $.get('./ajax/listi_sondosierojn.php?kiujn=neuzitajn', function(elementoj) {
                $('#redaktformularo-nedosieroj').html(elementoj);
            });
            $.get('./ajax/listi_sondosierojn.php?kiujn=uzitajn&programero_id=' + $(this).data('programero_id'), function(elementoj) {
                $('#redaktformularo-jesdosieroj').html(elementoj);
            });
        }
    });

});
