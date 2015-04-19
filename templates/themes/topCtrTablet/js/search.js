/**
 * Debounce so filtering doesn't happen every millisecond
 */
function debounce(fn, threshold) {
    var timeout;
    return function debounced() {
        if (timeout)
            clearTimeout(timeout);

        function delayed() {
            fn();
            timeout = null;
        }
        timeout = setTimeout(delayed, threshold || 100);
    }
}


$(function() {

    // quick search regex
    var qsRegex;
    // init Isotope
    var $container = $('.isotope').isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows',
        getSortData: {
            name: '.name',
            bouns: '.bouns',
            'min-bet': '.min-bet',
            'min-deposit': '.min-deposit',
            'calculated-sum': function(itemElem) { // function
                var weight = $(itemElem).find('.calculated-sum').css('background-image');
                return parseFloat(weight.replace(/\D/g, ''));
            }
        },
        filter: function() {
            return qsRegex ? $(this).text().match(qsRegex) : true;
        }
    });

    // use value of search field to filter
    var $quicksearch = $('#quicksearch').keyup(debounce(function() {
        qsRegex = new RegExp($quicksearch.val(), 'gi');
        $container.isotope();
    }, 200));



    // bind sort button click
    $('#sorts').on('click', 'button', function() {
        var sortValue = $(this).attr('data-sort-value');
        $container.isotope({
            sortBy: sortValue
        });
    });

    // change is-checked class on buttons
    $('.button-group').each(function(i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });
    });

});