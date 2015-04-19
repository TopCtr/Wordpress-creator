var pagePosts = null;
pagePosts = {
    validate: function(arrToValidate) {
        for (var i = arrToValidate.length - 1; i >= 0; i--) {
            if (typeof arrToValidate[i].itmId === "string")
                arrToValidate[i].itmId = parseInt(arrToValidate[i].itmId, 10);
        };
        return arrToValidate;
    },
    get: function() {
        var value = document.getElementById('postJSON').value;
        if (value === "" || typeof value === undefined)
            return [];
        var arr = JSON.parse(value);
        arr = pagePosts.validate(arr);
        return arr;
    },
    getAsArrayOfObjects: function() {
        var arr = pagePosts.get();
        var res = [];
        arr.forEach(function(itm) {
            if (_.isArray(itm) == true)
                itm.forEach(function(innerItm) {
                    res.push(innerItm);
                });
            else
                res.push(itm);
        });
        return res;
    },
    set: function(callback) {
        var val = pagePosts.get();
        var res = callback(val);
        if (typeof res === "string")
            document.getElementById('postJSON').value = res;
        else if (typeof res === "object") {
            var arr = pagePosts.validate(res);
            arr = JSON.stringify(arr);
            document.getElementById('postJSON').value = arr;
        } else
            throw new TypeError("res is undefined");
    }
};
