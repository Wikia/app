/**
 * JS script performing lint check over CSS files. It should be run using nodejs.
 *
 * Usage:
 *   nodejs run-csslint.js --csslint=<absolute path to csslint.js> --file=<file to check>
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

// require generic functions
var print = require("sys").print,
parseArgs = require('./utils').parseArgs;

// rules CSSLint should apply when linting
// @see http://csslint.net/about.html
var RULESET = {
	'duplicate-properties': true,
	'empty-rules': true,
	'errors': true,
	'important': true,
	'zero-units': true
};

// parse command line options
var args = parseArgs(process.argv);

// check arguments
if (!args.csslint || !args.file) {
	print("You need to provide a path to csslint and file name to lint\n");
	process.exit(1);
}

// load csslint
var csslint = require(args.csslint).CSSLint;

// check the existance of csslint
if (typeof csslint == 'undefined') {
	print("Unable to import csslint\n");
	process.exit(1);
}

// read the file's content
var fileSrc;

try {
	fileSrc = require("fs").readFileSync(args.file, "utf8");
} catch(ex) {
	print(ex.message);
	process.exit(1);
}

// import our custom lint rules
var extraRules = require('./csslint-rules').rules;

// be less restrictive in SASS mode (experimental feature!)
if (/.scss$/.test(args.file)) {
	// use fake "errors" rule do override build-in "errors" handling
	csslint.addRule(extraRules.errors);

	// try to validate SASS files
	csslint.addRule(extraRules.sass);
	RULESET.sass = true;
}

// catch IE6 specific fixes (* html #foo)
csslint.addRule(extraRules.ie6);
RULESET.ie6 = true;

// check CSS properties for typos
csslint.addRule(extraRules.checkProperties);
RULESET.checkProperties = true;

// lint it
var errors = csslint.verify(fileSrc, RULESET).messages;

// prepare output object
var result = {
	errors: errors,
	tool: "CSS Lint v" + csslint.version + ' (nodejs ' + process.version + ')',
	inSassMode: !!RULESET.sass
};

// inform about running in SASS mode
if (result.inSassMode) {
	result.tool += ' in SASS mode';
}

// return JSON-encoded result
print(JSON.stringify(result));