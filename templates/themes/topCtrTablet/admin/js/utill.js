function showLoading() {
    jQuery('.peeek-loading').fadeIn();
}

function hideLoading() {
    jQuery('.peeek-loading').fadeOut(300, function() {
     jQuery(this).remove();
 });
}


var addListItem = function(list, container) {
    var item = list[0];
    list.splice(0, 1); // Remove the first element of the array

    item.positionType = 'list';
    var icon = document.createElement('span');
    icon.classList.add('dashicons');
    icon.classList.add('dashicons-menu');
    var txt = document.createTextNode(item.title);
    var indicator = document.createElement("p");
    indicator.classList.add('position-type-indicator');
    indicator.textContent = 'L';

    var button = document.createElement('button');
    button.classList.add('editBtn');
    button.textContent = "Edit";
    button.id = item.itmId;
    button.disabled = false;
    var li = document.createElement('li');
    li.classList.add('ui-state-default');
    li.appendChild(icon);
    li.appendChild(txt);
    li.appendChild(button);
    li.appendChild(indicator);


    li.dataset.itmId = item.itmId;
    li.dataset.title = item.title;
    li.dataset.positionType = 'list';
    li.dataset.itemList = JSON.stringify(list);

    container.appendChild(li);
}


/**
 * @description addItem
 * dfgdfg dfg dfg
 * @param {[type]} item      [description]
 * @param {[type]} container [description]
 */
 var addItem = function(item, container, withoutButtonAndIndicator, disableButton) {
    var $ = jQuery;
    var icon = document.createElement('span');
    icon.classList.add('dashicons');
    icon.classList.add('dashicons-menu');
    var txt = document.createTextNode(item.title);
    var indicator = document.createElement("p");
    indicator.classList.add('position-type-indicator');

    if (!item.positionType) // kind of default..
        item.positionType = 'fixed';

    switch (item.positionType) {
        case 'fixed':
        indicator.textContent = 'F';
        break;
        case 'random':
        indicator.textContent = 'R';
        break;
        case 'list':
        indicator.textContent = 'L';
        break;
        default:
        indicator.textContent = 'F';
        break;
    }
    var button = document.createElement('button');
    button.classList.add('editBtn');
    button.textContent = "Edit";
    button.id = item.itmId;
    button.disabled = disableButton;
    var li = document.createElement('li');
    li.classList.add('ui-state-default');
    li.appendChild(icon);
    li.appendChild(txt);
    if (withoutButtonAndIndicator !== true) {
        li.appendChild(button);
        li.appendChild(indicator);
    }
    if (!item.itmId)
        debugger;
    li.dataset.itmId = item.itmId;
    li.dataset.title = item.title;
    li.dataset.positionType = item.positionType;
    container.appendChild(li);
}

function updatePagePostsByList() {
    pagePosts.set(function(posts) {
        var pageList = document.getElementById('page-list').querySelectorAll('li');
        var arr = [];
        for (var i = 0; i < pageList.length; i++) {
            if (pageList[i].dataset.positionType !== 'list') {
                var obj = {
                    title: pageList[i].dataset.title,
                    itmId: pageList[i].dataset.itmId,
                    positionType: pageList[i].dataset.positionType
                };
                if (obj.title) {
                    arr.push(obj);
                }
            } else {
                var priorityArr = [];
                    priorityArr.push({ // The post itself
                        title: pageList[i].dataset.title,
                        itmId: pageList[i].dataset.itmId
                    });
                    try {
                        var postList = JSON.parse(pageList[i].dataset.itemList);
                        priorityArr = priorityArr.concat(postList);
                    } catch (err) {
                        //   debugger;
                    }
                    arr.push(priorityArr);
                }
            };
            return arr;
        });
}



function difference(a, b) {
    //debugger;
    var onlyInA = a.filter(function(current) {
        return b.filter(function(current_b) {
            return current_b.itmId == current.itmId;
        }).length === 0;
    });
    return onlyInA;
}