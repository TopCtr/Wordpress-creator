"use strict";
var mysql            = require('mysql');
var inquirer         = require("inquirer");
var colors           = require('colors');
var generatePassword = require('password-generator');

var connection;
var wordpressUserName = '';
var wordpressUserPassword = '';
var wordpressDb = '';
var callback;



var connectionQuestions = [{
  type    : "input",
  name    : "pass",
  message : "Enter password for MYSQL root user",
  validate: function(value) {
    var done = this.async();
    if (value == '') {
      done("Error!".bold.red + " You can't leave it empty");
      return false;
    }

    connection = mysql.createConnection({
      host     : 'localhost',
      user     : 'root',
      password : value
    });

    connection.connect(function(err) {
      if (!err) {
        console.log('successfully connect to database');
        done(true);
      } else {
        done("Error!".bold.red + " Error Code: " + err.code);
      }
    });
  }
}];


var dbQuestions = [{
  type: "input",
  name: "dbName",
  message: "Enter database name:",
  validate: function(dbName) {
    var done = this.async();
    if (dbName == '') {
      done("Error!".bold.red + " You can't leave it empty");
      return false;
    }

    // Check if database already exists
    connection.query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" + dbName + "'", function(err, rows, fields) {
      if (err)
        throw err;

      if (rows.length === 0)
        done(true);
      else
        done("Error!".bold.red + " Database with name " + dbName.inverse + " already exists. Choose difrent name for database.");
    });


  }
}];


var userQuestions = [{
  type: "input",
  name: "userName",
  message: "Enter user name:",
  validate: function(userName) {
    var done = this.async();
    if (userName == '') {
      done("Error!".bold.red + " You can't leave it empty");
      return false;
    }
    if (userName.length > 16) {
      done("Error!".bold.red + " MySQL user names can be up to 16 characters long. " + userName.inverse + " is " + userName.length + "  characters long.");
      return false;
    }

    // Is the userName already exists?
    connection.query("SELECT User FROM mysql.user WHERE User = '" + userName + "'", function(err, rows, fields) {
      if (err)
        throw err;

      if (rows.length === 0)
        done(true); // user not exists - we are good to go!
      else
        done("Error!".bold.red + " User with name " + userName.inverse + " already exists. Choose difrent name.");
    });
  }
}];


/**
 * @description Create database for wordpress and a user with all privileges for it
 * @param {Function} cb
 */
module.exports.createWpDatabase = function(cb) {
  callback = cb;
  inquirer.prompt(connectionQuestions, function(answers) {
    inquirer.prompt(dbQuestions, function(answer) {
      // console.log(answer.dbName);
      createDatabase(answer.dbName);
    });
  });
};




/**
* @description Create database for wordpress
* @param dbName {string} Name for the database
*/
function createDatabase(dbName) {
  // dbName = 'tttt'; //remove me
  wordpressDb = dbName;

  connection.query("CREATE DATABASE IF NOT EXISTS `" + dbName + "`", function(err, rows, fields) {
    if (err)
      throw err;

    // The DB was createed - createing the user
    inquirer.prompt(userQuestions, function(answer) {
      createUser(answer.userName);
    });

  });
}



/**
* @description Create user for wordpress DB
* @param userName {string} Name for the new user.
*/
function createUser(userName) {
  var pass = generatePassword(18, false);

  wordpressUserName = userName;
  wordpressUserPassword = pass;
  connection.query("CREATE USER '" + userName + "'@'localhost' IDENTIFIED BY '" + pass + "'", function(err, rows, fields) {
    if (err)
      throw err;
    grantAllPrivileges();
  });
}


/**
* @description Grant all privileges on wordpress DB to our user.
*/
function grantAllPrivileges() {
  connection.query("GRANT ALL PRIVILEGES ON `" + wordpressDb + "`.* TO \"" + wordpressUserName + "\"@\"localhost\"", function(err, rows, fields) {
    if (err)
      throw err;
    flushPrivileges();
  });
}


/**
* @description Flush privileges end execute callback
*/
function flushPrivileges() {
  connection.query("FLUSH PRIVILEGES", function(err, rows, fields) {
    if (err)
      throw err;

    var dbDetails = {
      wordpressUserName: wordpressUserName,
      wordpressUserPassword: wordpressUserPassword,
      wordpressDb: wordpressDb
    }

    callback(dbDetails);
    connection.end();
  });
}
