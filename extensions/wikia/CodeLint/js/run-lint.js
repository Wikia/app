/**
 * JS script performing lint check over JS/CSS files. It should be run using nodejs.
 *
 * Usage:
 *   nodejs run-lint.js --jslint=<absolute path to jslint.js> --file=<file to check>
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

// require generic functions
var print = require("sys").print,
	parseArgs = require('./utils').parseArgs;

// options for JSLint
// @see http://www.jslint.com/lint.html
var OPTIONS = {
	// assume JS is to be run in the browser
	browser: true,
	// tolerate type confusion
	confusion: true,
	// tolerate == and != operators
	eqeq: true,
	// tolerate unfiltered for in
	forin: true,
	// strict white space indentation
	indent: false,
	// max. number of errors to report
	maxerr: 750,
	// tolerate ++ and -- operators
	plusplus: true,
	// tolerate missing 'use strict' pragma
	sloppy: true,
	// tTolerate many var statements per function
	vars: true,
	// tolerate messy white space
	white: true
};

// parse command line options
var args = parseArgs(process.argv);

// check arguments
if (!args.jslint || !args.file) {
	print("You need provide a path to jslint and file name to lint");
	process.exit(1);
}

// load jslint
var jslint = require(args.jslint).JSLINT;

// check the existance of jslint
if (typeof jslint == 'undefined') {
	print("Unable to import jslint");
	process.exit(1);
}

// read the file
var file = require("fs").readFileSync(args.file, "utf8");

// lint it
jslint(file, OPTIONS);

// prepare output object
var result = {
	jslint: jslint.edition,
	nodejs: process.version,
	fileChecked: args.file,
	errors: jslint.errors
};

// return JSON-encoded result
print(JSON.stringify(result));