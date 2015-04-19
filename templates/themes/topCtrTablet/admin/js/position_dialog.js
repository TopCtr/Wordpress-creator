/**
 * @description Handle change event on the "Behavior" select box.
 * @return {void}
 */
function selectChange() {
    var $ = jQuery;
    var val = $('#behavior-select').val().toLowerCase();
    if (val !== 'list')
        $('#priority-list-warp').hide("slow");
    else {
        $('#priority-list-warp').show("fast");
        var availableList = document.getElementById('available-list').querySelectorAll('li');
        var destination = document.getElementById('priority-available-list');
        destination.clean();
        for (var i = 0; i < availableList.length; i++) {
            var itm = {
                itmId: availableList[i].dataset.itmId,
                title: availableList[i].dataset.title,
                positionType: availableList[i].dataset.positionType
            }
            addItem(itm, destination, true, true);
        }
    };


    var pageList = document.getElementById('page-list').querySelectorAll('li');
    var itemToEdit = pageList[editableIndex];
    var indicator = itemToEdit.querySelector('.position-type-indicator');
    var restoreItems = false;
    switch (val) {
        case 'fixed':
            itemToEdit.dataset.positionType = 'fixed';
            indicator.textContent = 'F';
            restoreItems = true;
            break;
        case 'random':
            itemToEdit.dataset.positionType = 'random';
            indicator.textContent = 'R';
            restoreItems = true;
            break;
        case 'list':
            itemToEdit.dataset.positionType = 'list';
            indicator.textContent = 'L';
            break;
    }
    if (restoreItems === true) {
        try {
            var itemsToRestore = JSON.parse(itemToEdit.dataset.itemList);
        } catch (e) {
            var itemsToRestore = [];
        } finally {
            delete itemToEdit.dataset.itemList;

            var destination = document.getElementById('available-list');

            itemsToRestore.forEach(function(itm) {
                addItem(itm, destination, false, false);
            });

            document.getElementById('spot-list').clean();
            document.getElementById('priority-available-list').clean();
            // debugger;
        }
    }

    updatePagePostsByList();
}


/**
 * @description Create the dialog and assign it to the global variable 'theDialog'
 * @return {void}
 */
var setupDialog = function() {
    var $ = jQuery;

    var handleDragEndEvent = function(event, ui) {
        var pageList = document.getElementById('page-list').querySelectorAll('li');
        var itemToEdit = pageList[editableIndex];
        itemToEdit.dataset.positionType = 'list';

        var itemOnSpot = document.getElementById('spot-list').querySelectorAll('li');
        var arr = [];
        for (var i = 0; i < itemOnSpot.length; i++) {
            var obj = {
                itmId: itemOnSpot[i].dataset.itmId,
                title: itemOnSpot[i].dataset.title,
            }
            arr.push(obj);
        };

        for (var i = 0; i < arr.length; i++) {
            var allTheItems = document.getElementById('available-list').querySelectorAll('li');
            for (var j = 0; j < allTheItems.length; j++) {
                if (allTheItems[j].dataset.itmId === arr[i].itmId)
                    document.getElementById('available-list').removeChild(allTheItems[j]);
            };
        };

        itemToEdit.dataset.itemList = JSON.stringify(arr);
        updatePagePostsByList();
    };

    $("ul.droptrue-ailable-brands").sortable({
        connectWith: "ul",
        items: 'li',
        receive: function(event, ui) {
            var availableList = document.getElementById('available-list');
            var itm = {
                title: ui.item[0].dataset.title,
                itmId: ui.item[0].dataset.itmId,
                positionType: 'fixed'
            };
            addItem(itm, availableList, false, false);
        },
        update: handleDragEndEvent
    });

    $("ul.dropfalse-ailable-brands").sortable({
        connectWith: "ul",
        handle: 'span',
        update: handleDragEndEvent
    });


    $("#dialog-message").dialog({
        modal: true,
        autoOpen: false,
        buttons: {
            "Got it": function() {
                $(this).dialog("close");
            }
        }
    });

    $("#behavior-select").on('change', selectChange);


    theDialog = $("#dialog-form").dialog({
        autoOpen: false,
        height: 700,
        width: 700,
        modal: true,
        resizable: false,
        closeOnEscape: false,
        show: {
            effect: "slide",
            duration: 300
        },
        hide: {
            effect: "drop",
            duration: 300
        },

        open: function() {
            $('.ui-widget-overlay').hide().fadeIn();
        },
        beforeClose: function() {
            var val = $('#behavior-select').val().toLowerCase();
            if (val === 'list') {
                var itemOnSpot = document.getElementById('spot-list').querySelectorAll('li');
                if (itemOnSpot.length == 0) {
                    $(theDialog).effect('shake', {}, 500, function() {
                        $("#dialog-message").dialog("open");
                    });
                    return false;
                }
            } else {
                $('.ui-widget-overlay:first').clone().appendTo('body').show().fadeOut(300, function() {
                    $(this).remove();
                });
                return true;
            }
        },
        buttons: {
            OK: function() {
                $(this).dialog("close");
            }
            //,Cancel: function() {$(this).dialog("close");}
        }
    });


}




/**
 * @description Show the dialog
 * @return {void}
 */
var openDialog = function() {
    var $ = jQuery;
    var pageList = document.getElementById('page-list').querySelectorAll('li');
    var itemToEdit = pageList[editableIndex];
    var ttl = 'Edit: ' + itemToEdit.textContent.substring(0, itemToEdit.textContent.length - 5);

    $("span.ui-dialog-title")[1].textContent = ttl;

    var behaviorSelect = document.getElementById('behavior-select');
    var positionType = itemToEdit.dataset.positionType;

    switch (positionType) {
        case 'fixed':
            behaviorSelect.setSelectedElement('fixed');
            break;
        case 'random':
            behaviorSelect.setSelectedElement('random');
            break;
        case 'list':
            behaviorSelect.setSelectedElement('list');
            break;
    }


    selectChange();
    theDialog.dialog("open");

    if (positionType === 'list') {
        var itemsInTheList = JSON.parse(itemToEdit.dataset.itemList);
        itemsInTheList = [{
            itmId: itemToEdit.dataset.itmId,
            title: itemToEdit.dataset.title
        }].concat(itemsInTheList);
        var spotList = document.getElementById('spot-list');
        var priorityAvailableList = document.getElementById('priority-available-list');
        spotList.clean();
        for (var i = 0; i < itemsInTheList.length; i++) {
            priorityAvailableList.removeChildWithDataSet(itemsInTheList[i].itmId);
        };
        for (var i = 0; i < itemsInTheList.length; i++) {
            addItem(itemsInTheList[i], spotList, true, true);
        };
        debugger;
        // var availableList = document.getElementById('spot-list').querySelectorAll('li');
        // var destination = document.getElementById('priority-available-list');
    }



}