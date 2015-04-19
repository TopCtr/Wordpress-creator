"use strict";
var inquirer = require("inquirer");
var _ = require("underscore");
var fs = require('fs');
var url = require('url');
var colors = require('colors');
var exec = require('child_process');
var settings = require('./settings');
var fsHelper = require('./fs.helper');
var spiner = require('./spiner');
var wordpressGetter = require('./wordpressGetter');
var sqlManager = require('./sqlManager');
var wpConfigWriter = require('./wpConfigWriter');

var hostname;

var questions = [{
  type: "input",
  name: "siteUrl",
  message: "What's the url of the site?",
  // default: 'http://fff.com',
  validate: function(value) {
    var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
    // Declare function as asynchronous, and save the done callback
    var done = this.async();
    if (!urlregex.test(value)) {
      done("You need to provide a valid URL");
    } else {
      done(true);
    }
  },
  filter: function(value) {
    return value.toLowerCase();
  }
}];

inquirer.prompt(questions, function(answers) {
  hostname = url.parse(answers.siteUrl).hostname;
  wordpressGetter.getWordpress(hostname);
  sqlManager.createWpDatabase(setupWpConfig);
});

function setupWpConfig(details) {
  details.hostname = hostname;
  wpConfigWriter.writeWpConfigFile(details);
  copyDefaults(hostname);
}

function copyDefaults(hostname) {
  var currentWorkingDirectory = settings.basePath + hostname + '/wp-content/';

  console.log("Cope default theme to " + currentWorkingDirectory + 'themes');
  exec.execSync('cp -avr /home/ec2-user/wordpressGenerator/templates/themes/topCtrTablet .', {
    cwd: currentWorkingDirectory + 'themes'
  });

  console.log("Cope default plugins to " + currentWorkingDirectory + 'plugins');
  exec.execSync('cp -avr /home/ec2-user/wordpressGenerator/templates/plugins/* .', {
    cwd: currentWorkingDirectory + 'plugins'
  });

  appendToVHost(hostname);
}



function appendToVHost(hostname) {
  var vhostTxt = fs.readFileSync(settings.templatesPath + 'vhost.txt', "utf8");

  vhostTxt = _.template(vhostTxt);
  vhostTxt = vhostTxt({
    hostname: hostname
  });

  fs.writeFileSync('/home/ec2-user/wordpressGenerator/tmp/vhost.txt', vhostTxt);


  var ip = exec.execSync('dig +short myip.opendns.com @resolver1.opendns.com');
  console.log("\n\n" + ">> ".blue + "Setup is almost done.");

  console.log("Point the domain " + hostname.blue + " to " + ip.toString().trim());

  console.log("Please run:\n\t sudo node appendVHost.js");
  console.log("To complete setup process.");
}
