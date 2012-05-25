/**
 * @author Jacek 'mech' Wozniak
 *
 * This file contains chat loggin class and some socket.io logger related hacks.
 * 
 */

var config = require("./server_config.js");

// available log levels
var logLevels = {
	CRITICAL: 0,
	ERROR: 1,
	WARNING: 2,
	NOTICE: 3,
	INFO: 4,
	DEBUG: 5
};

function Logger(level, stream) {
	level = level ? level.toUpperCase():null;
	this.logLevel = (level in logLevels) ? logLevels[level] : logLevels.INFO;
  this.logLevel = 0;
	this.stream = stream || process.stdout;
}

Logger.prototype = {
    log: function(levelStr, args) {
    	levelStr = levelStr.toUpperCase();
    	if ( logLevels[levelStr] <= this.logLevel ) {
            var msg = '';
        	for(var i = 0 ; i < args.length ; i++) {
        	    if (typeof args[i] == "string") {
        		    msg += args[i] + ' ';
        		} else {
        			msg += JSON.stringify(args[i]) + ' ';
        		}
      	    }
        	this.stream.write(
//                  '[' + new Date + ']' + ' ' +
            	levelStr + ' ' + msg + '\n'
              );
        }
    },
    
    isDebug: function() {
    	return (this.logLevel >= logLevels.DEBUG);
    }
};

/**
 * Generate logging methods for all log levels (logger.error, logger.debug etc...)
 */
function createLogMethod(level) {
	Logger.prototype[level.toLowerCase()] = function () {
		this.log.apply(this, [level, arguments]);
	};		
};

for(var level in logLevels) {
	createLogMethod(level);
};

var logger = new Logger( config.logLevel );	// singleton
exports.logger = logger;

/*
 * socket.io compatibility section below
 * HACKS HACKS HACKS...
 * 
 * socket.io logger uses console.log to output log info. so here we override console.log and try
 * to determine the message log level from msg
 */

//helper method - converts arguments enumerable to mutable array
function toArray(enu) {
  var arr = [];

  for (var i = 0, l = enu.length; i < l; i++)
    arr.push(enu[i]);

  return arr;
};

var socketIOLogPrefixes = {
	'error:' : 'ERROR',
	'warn:': 'WARNING',
	'info:': 'INFO',
	'debug:': 'DEBUG'
};

console.log = function(msg) {
	// translate console.log calls from socket.io logger to our logger calls
	if ( (typeof arguments[0] == "string") && (arguments[0] in socketIOLogPrefixes) ) {
		// detect socket.io message prefix and delegate the call to proper log level
		logger.log(socketIOLogPrefixes[arguments[0]], toArray(arguments).slice(1));
		return;
	}
	// default log level for console.log is INFO
	logger.log('INFO', arguments);
};

console.error = function(err) {
	// default log level for console.error is ERROR
	logger.log('ERROR', arguments);
};


//convert log.js log level to socketio log level (so we don't get unnecessary calls to console.log)
exports.getSocketIOLogLevel = function() {
	var socketIOLogLevels = {	
			DEBUG: 3,
			INFO: 2,
			NOTICE: 2,
			WARNING: 1,
			ERROR: 0,
			CRITICAL: 0
	};
	return socketIOLogLevels[config.logLevel.toUpperCase()];
};
