/* Esperanto initialisation for the jQuery time picker plugin. */
/* Written by Gérald Gounot (gerald@gounot.eu) */
jQuery(function($){
    $.timepicker.regional['eo'] = {
                hourText: 'Horoj',
                minuteText: 'Minutoj',
                amPmText: ['AM', 'PM'],
                closeButtonText: 'Fermi',
                nowButtonText: 'Nun',
                deselectButtonText: 'Malelektigi' }
    $.timepicker.setDefaults($.timepicker.regional['eo']);
});
