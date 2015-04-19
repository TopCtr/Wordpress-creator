HTMLSelectElement.prototype.setSelectedElement = function(text) {
    for (var i = 0; i < this.options.length; i++) {
        if (this.options[i].text.toLowerCase() === text.toLowerCase()) {
            this.selectedIndex = i;
            break;
        }
    }
};


HTMLSelectElement.prototype.getSelected = function() {
    return this.options[this.selectedIndex].text;
};

HTMLElement.prototype.clean = function() {
    while (this.hasChildNodes())
        this.removeChild(this.lastChild);
};

HTMLElement.prototype.removeChildWithDataSet = function(val) {
    for (var i = this.childNodes.length - 1; i >= 0; i--) {
        var dataset = this.childNodes[i].dataset;
        if (typeof dataset !== 'undefined') {
            for (var d in dataset) {
                if (dataset[d] === val) {
                    this.removeChild(this.childNodes[i]);
                }
            };

        }
    };
}