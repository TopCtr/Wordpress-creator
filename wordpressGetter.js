var fs       = require('fs');
var colors   = require('colors');
var exec     = require('child_process');
var settings = require('./settings');
var fsHelper = require('./fs.helper');
var spiner   = require('./spiner');


/**
* @description Gettnig Wordpress and extracting it to the right place.
* @param hostname {string}
*/
module.exports.getWordpress = function(hostname) {

  if (fsHelper.isExists(settings.basePath + hostname)) {
    console.log(">> ".red + "The Folder: " + (settings.basePath + hostname).blue + " is allredy exists.");
    process.exit(1);
  } else {
    fs.mkdirSync(settings.basePath + hostname);
    console.log("Create Folder: " + (settings.basePath + hostname).blue);
    var currentWorkingDirectory = settings.basePath + hostname;

    spiner.spin('Downloading Wordpress');
    // exec.execSync('wget -q https://wordpress.org/latest.tar.gz', {
    //   cwd: currentWorkingDirectory
    // });

    exec.execSync('cp ' + settings.templatesPath + 'latest.tar.gz .', {
      cwd: currentWorkingDirectory
    });

    spiner.stop("Wordpress Downloaded\n");

    console.log(">> ".blue + "Extracting latest.tar.gz");
    exec.execSync('tar -xzf latest.tar.gz', {
      cwd: currentWorkingDirectory
    });

    console.log(">> ".blue + "Moving files to server root folder (" + currentWorkingDirectory + ")");
    exec.execSync('mv wordpress/* ./', {
      cwd: currentWorkingDirectory
    });

    console.log(">> ".blue + "Removing redundant files");
    exec.execSync('rm -rf wordpress license.txt readme.html wp-config-sample.php latest.tar.gz', {
      cwd: currentWorkingDirectory
    });

  }

}
