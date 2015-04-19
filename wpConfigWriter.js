"use strict";
var fs               = require('fs');
var colors           = require('colors');
var exec             = require('child_process');
var settings         = require('./settings');
var generatePassword = require('password-generator');
var _                = require("underscore");

/**
 * @description Write wp-config.php files according to templates from templates folder.
 * @param details details {object} object with the following properties:
 *  - wordpressUserName     - User Name for wordpress DB
 *  - wordpressUserPassword - Password for wordpress DB
 *  - wordpressDb           - The of wordpress Db
 */
module.exports.writeWpConfigFile = function(details) {

  var wpConfig = fs.readFileSync(settings.templatesPath + 'wp-config.php', "utf8");

  var saltArr = []; // @see https://api.wordpress.org/secret-key/1.1/salt
  for (var i = 0; i < 10; i++) {
    saltArr.push(generatePassword(65, false));
  }
  wpConfig = _.template(wpConfig);

  // Fill the template with details
  wpConfig = wpConfig({
    DB_USER     : details.wordpressUserName,
    DB_PASSWORD : details.wordpressUserPassword,
    DB_NAME     : details.wordpressDb,
    saltArr     : saltArr,
    tablePrefix : generatePassword(3, false)
  });

  console.log("Create Folder: " + (settings.baseConfigPath + '/' + details.hostname).blue);
  fs.mkdirSync(settings.baseConfigPath + '/' + details.hostname);

  console.log("Create wp-config.php in " + (settings.baseConfigPath + '/' + details.hostname + '/wp-config.php').blue);
  fs.writeFileSync(settings.baseConfigPath + '/' + details.hostname + '/wp-config.php', wpConfig);


  var wpConfigRequire = fs.readFileSync(settings.templatesPath + 'wp-config.require.php', "utf8");
  wpConfigRequire = _.template(wpConfigRequire);
  wpConfigRequire = wpConfigRequire({
    hostname: details.hostname
  });

  console.log("Create wp-config.php in " + (settings.basePath + details.hostname + '/wp-config.php').blue);
  fs.writeFileSync(settings.basePath + details.hostname + '/wp-config.php', wpConfigRequire);

}
