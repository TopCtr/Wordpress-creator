/**
 * @description Script for admin page.
 *
 * @param {Object} $ jQuery shortcut for jQuery library.
 * @see http://learn.jquery.com/using-jquery-core/avoid-conflicts-other-libraries/
 * @see https://github.com/wbotelhos/raty
 **/
jQuery(document).ready(function($) {
    //jQuery('.peeek-loading').fadeOut(300, function() {$(this).remove(); });
    function calculatedSum() {
        var sum = 0;
        for (var i = 0; i < list.length; i++) {
            sum += parseFloat(list[i].value) || 0;
        }
        sum = sum / list.length;
        list[list.length - 1].value = Math.round(sum / 0.5) * 0.5;
    }


    var list = document.querySelectorAll('.ranking-flds');
    for (var i = 0; i < list.length; i++) {
        list[i].addEventListener('change', calculatedSum);
    }


    var markAll = document.getElementById('mark-all');
    if(markAll)
    markAll.addEventListener('click', function(e) {
        var paymentOptionsList = document.querySelectorAll('.payment-options-checkbox');
        // debugger;
        for (var i = paymentOptionsList.length - 1; i >= 0; i--) {
            paymentOptionsList[i].checked = true;
        };


    });



});