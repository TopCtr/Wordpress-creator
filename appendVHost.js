var fs = require('fs');
var fsHelper = require('./fs.helper');


fsHelper.isRootUser(function() {
  var textToAppend = fs.readFileSync('/home/ec2-user/wordpressGenerator/tmp/vhost.txt', "utf8");
  var vhostConf = fs.readFileSync('/etc/httpd/conf.d/vhost.conf', "utf8");

  console.log(">> ".blue + "Adding the following to /etc/httpd/conf.d/vhost.conf");
  console.log(textToAppend);

  fs.writeFileSync('/etc/httpd/conf.d/vhost.conf', vhostConf + textToAppend);
  fs.unlinkSync('/home/ec2-user/wordpressGenerator/tmp/vhost.txt');

  console.log(">> ".blue + "To restart Apache type:\n\tsudo service httpd restart");

});
