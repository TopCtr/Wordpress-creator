/**
 * Entry point for the admin
 */
window.addEventListener('load', function() {
    $ = jQuery;
    if (typeof allOfThePosts !== 'undefined') // Find the difference
        allOfThePosts = difference(allOfThePosts, pagePosts.getAsArrayOfObjects())
    else
        console.log('typeof allOfThePosts is undefined');

    var pageList = document.getElementById('page-list');

    pagePosts.get().forEach(function(item, i) {
        $('.placeholder').remove();
        if (_.isArray(item) === true)
            addListItem(item, pageList);
        else
            addItem(item, pageList, false, false);

    });
    var availableList = document.getElementById('available-list');
    allOfThePosts.forEach(function(item, i) {
        addItem(item, availableList, false, true);
    });

    $("ul.droptrue").sortable({
        connectWith: "ul",
        items: 'li',
        receive: function(event, ui) {
            var button = ui.item[0].querySelector('button');
            button.disabled = true;
            ui.item[0].dataset.positionType = 'fixed';
            ui.item[0].querySelector('.position-type-indicator').textContent = 'F';
            if (ui.item[0].dataset.itemList) {
                var listToRecover = JSON.parse(ui.item[0].dataset.itemList);
                listToRecover.forEach(function(item) {
                    addItem(item, availableList, false, false);
                });
            }
            //debugger;
        }
    });
    var handleDragEndEvent = function(event, ui) {
        var button = ui.item[0].querySelectorAll('button')[0];
        button.disabled = false;
        $('.placeholder').remove();
        var data = ui.item[0].dataset;
        updatePagePostsByList();
    };

    $("ul.dropfalse").sortable({
        connectWith: "ul",
        handle: 'span',
        receive: handleDragEndEvent,
        change: handleDragEndEvent,
        update: handleDragEndEvent
    });
    $("#available-list, #page-list, #spot-list, #priority-available-list").disableSelection();



    $(".editBtn").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var pageList = document.getElementById('page-list').querySelectorAll('li');
        var me = e.target.parentElement;
        for (var i = 0; i < pageList.length; i++) {
            if (pageList[i] === me) {
                editableIndex = i;
                break;
            }
        };
        openDialog();

    });
    setupDialog();
});

function hideLoadingAfterLoadFinish() {
    var ed = document.getElementById('content_ifr');
    if (ed == null)
        ed = document.querySelectorAll('.wp-editor-area');

    if (ed == null) {
        setTimeout(hideLoadingAfterLoadFinish, 500);
        return;
    }

    ed.onload = function() {
        hideLoading();
    }
    setTimeout(function() {
        hideLoading();
    }, 3000);
}

hideLoadingAfterLoadFinish();