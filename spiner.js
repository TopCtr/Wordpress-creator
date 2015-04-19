var BottomBar = require("./node_modules/inquirer/lib/ui/bottom-bar");
var ui;
var setIntervalId;

module.exports.spin = function(text) {
  if (!text)
    text = '';
  var loader = ["/ " + text, "| " + text, "\\ " + text, "- " + text];
  var i = 4;

  ui = new BottomBar({
    bottomBar: loader[i % 4]
  });
  setIntervalId = setInterval(function() {
    ui.updateBottomBar(loader[i++ % 4]);
  }, 300);

}

module.exports.stop = function(text) {
  if (!text)
    text = '';
  ui.updateBottomBar(text);
  clearInterval(setIntervalId);
  ui = null;
}
