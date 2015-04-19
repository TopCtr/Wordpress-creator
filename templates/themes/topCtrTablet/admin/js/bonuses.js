function insertTextAtCursor(el, text) {
    var val = el.value,
        endIndex, range;
    if (typeof el.selectionStart != "undefined" && typeof el.selectionEnd != "undefined") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, el.selectionStart) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length;
    } else if (typeof document.selection != "undefined" && typeof document.selection.createRange != "undefined") {
        el.focus();
        range = document.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}

var globalPosts = {
    validate: function(arrToValidate) {
        for (var i = arrToValidate.length - 1; i >= 0; i--) {
            if (typeof arrToValidate[i].itmId === "string")
                arrToValidate[i].itmId = parseInt(arrToValidate[i].itmId, 10);
            if (typeof arrToValidate[i].bonusText !== "string")
                arrToValidate[i].bonusText = '';
        };
        return arrToValidate;
    },
    get: function() {
        var value = document.getElementById('postBonusesJSON').value;
        if (value === "" || typeof value === undefined)
            return [];
        var arr = JSON.parse(value);


        arr = globalPosts.validate(arr);
        return arr;
    },
    set: function(callback) {
        var val = globalPosts.get();
        var res = callback(val);
        if (typeof res === "string")
            document.getElementById('postBonusesJSON').value = res;
        else if (typeof res === "object") {
            var arr = globalPosts.validate(res);
            arr = JSON.stringify(arr);
            document.getElementById('postBonusesJSON').value = arr;
        } else
            throw new TypeError("res is undefined");
    }
};


function setupGlobalPosts() {
    globalPosts.set(function(posts) {
        var _allOfThePosts = ALL_THE_POSTS.concat();
        _allOfThePosts = _allOfThePosts.map(function(item) {
            return {
                itmId: item.itmId,
                title: item.title
            }
        });

        _allOfThePosts = _allOfThePosts.filter(function(item) {
            for (var j = 0; j < posts.length; ++j) {
                if (item.itmId === posts[j].itmId)
                    return false
            }
            return true;
        });
        posts = posts.concat(_allOfThePosts);
        posts.sort(function(a, b) {
            if (a.title < b.title)
                return -1;
            if (a.title > b.title)
                return 1;
            return 0;
        });
        return posts;
    });
}


window.addEventListener('load', function() {
    var $ = jQuery;
    setupGlobalPosts();
    var bonusTextarea = document.getElementById('bonus-textarea');

    var editBonusDialog = $("#edit-bonus-dialog").dialog({
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

            var brandList = document.getElementById('bonus-posts-to-edit');

            brandList.clean();

            globalPosts.get().forEach(function(item) {
                var brand = document.createElement('span');
                var icon = document.createElement('div');
                icon.classList.add('dashicons');
                icon.classList.add('dashicons-edit');
                brand.appendChild(icon);
                var txt = document.createTextNode(item.title)
                brand.appendChild(txt);
                brand.classList.add('bonus-brand');
                brand.dataset.title = item.title;
                brand.dataset.itmId = item.itmId;
                brand.dataset.bonusText = item.bonusText;
                brandList.appendChild(brand);
                brand.addEventListener('click', function(e) {
                    bonuseIDToEdit = parseInt(e.target.dataset.itmId, 10);
                    bonusTextarea.value = e.target.dataset.bonusText;
                    // document.getElementById('current-edit').textContent = 'Editing ' + e.target.dataset.title;
                    var bnsList = document.querySelectorAll('#bonus-posts-to-edit span');
                    for (var i = bnsList.length - 1; i >= 0; i--) {
                        bnsList[i].classList.remove('bonus-brand-active');
                    }
                    e.target.classList.add('bonus-brand-active');
                    bonusTextarea.focus();
                });
            });

        },
        beforeClose: function() {
            $('.ui-widget-overlay:first').clone().appendTo('body').show().fadeOut(300, function() {
                $(this).remove();
            });
            return true;
        },
        buttons: {
            OK: function() {
                $(this).dialog("close");
            }
        }
    });


    bonusTextarea.addEventListener('keyup', function() {
        var bnsList = document.querySelectorAll('#bonus-posts-to-edit span');
        globalPosts.set(function(posts) {
            for (var i = posts.length - 1; i >= 0; i--) {
                if (posts[i].itmId === bonuseIDToEdit) {
                    posts[i].bonusText = bonusTextarea.value;
                }
            }
            for (var i = bnsList.length - 1; i >= 0; i--) {
                if (parseInt(bnsList[i].dataset.itmId, 10) === bonuseIDToEdit) {
                    bnsList[i].dataset.bonusText = bonusTextarea.value;
                }
            }
            return posts;
        });
    });

    document.getElementById('pound-btn').addEventListener('click', function() {
        insertTextAtCursor(bonusTextarea, '£');
    });
    document.getElementById('ero-btn').addEventListener('click', function() {
        insertTextAtCursor(bonusTextarea, '€');
    });




    $('#bonus-btn').click(function() {
        editBonusDialog.dialog("open");
    });
});