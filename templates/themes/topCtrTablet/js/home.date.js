Date.locale = {
    en: {
        month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }
};

Date.prototype.getMonthName = function(lang) {
    lang = lang && (lang in Date.locale) ? lang : 'en';
    return Date.locale[lang].month_names[this.getMonth()];
};

Date.prototype.getMonthNameShort = function(lang) {
    lang = lang && (lang in Date.locale) ? lang : 'en';
    return Date.locale[lang].month_names_short[this.getMonth()];
};

$(function() {
    var dateTitle = document.getElementById('date-title');

    var d = new Date();
    dateTitle.textContent =
     d.getMonthName()
     + (' ' + d.getUTCDate()).slice(-2)
     + " , " + d.getUTCFullYear()
     + " " + ("0" + d.getHours()).slice(-2)
     + ":" + ("0" + d.getUTCMinutes()).slice(-2);
     
});