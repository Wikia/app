/**
 * JS script performing lint check over JS files. It should be run using nodejs.
 *
 * Usage:
 *   nodejs run-jslint.js --jslint=<absolute path to jslint.js> --file=<file to check>
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

// require generic functions
var print = require("sys").print,
	parseArgs = require('./utils').parseArgs,
	formatKnownGlobalsComment = require('./utils').formatKnownGlobalsComment;

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
	// perform no white space indentation check
	indent: 0,
	// max. number of errors to report
	maxerr: 750,
	// tolerate uncapitalized constructors
	newcap: true,
	// tolerate dangling _ in identifiers
	nomen: true,
	// tolerate ++ and -- operators
	plusplus: true,
	// tolerate . and [^...]. in /RegExp/
	regexp: true,
	// tolerate missing 'use strict' pragma
	sloppy: true,
	// tolerate many var statements per function
	vars: true,
	// tolerate messy white space
	white: true
};

// parse command line options
var args = parseArgs(process.argv);

// check arguments
if (!args.jslint || !args.file) {
	print("You need to provide a path to jslint and file name to lint\n");
	process.exit(1);
}

// load jslint
var jslint = require(args.jslint).JSLINT;

// check the existance of jslint
if (typeof jslint == 'undefined') {
	print("Unable to import jslint\n");
	process.exit(1);
}

// read the file's content
var fileSrc;

try {
	fileSrc = require("fs").readFileSync(args.file, "utf8");
}
catch(ex) {
	print(ex.message);
	process.exit(1);
}

// check usage of globals
var globalsComment = (args.knownGlobals ? formatKnownGlobalsComment(args.knownGlobals.split(',')) : '');

 // add extra directives for jslint
fileSrc = globalsComment + fileSrc;

// lint it
jslint(fileSrc, OPTIONS);

// prepare output object
var result = {
	errors: jslint.errors,
	tool: "JSLint edition " + jslint.edition  + ' (nodejs ' + process.version + ')'
};

// detect hardcoded stuff (BugId:12757)
var lines = fileSrc.split("\n"),
	hardcodedRegExp = /['"]([^"']+blank.gif|\/skins\/|\/extensions\/|\/wiki\/)/,
	matches;

for(var n=0, len = lines.length; n < len; n++) {
	matches = lines[n].match(hardcodedRegExp);

	if (matches) {
		// ignore URLs to SASS files as they contain "hardcoded" /extensions and /skins paths
		if (lines[n].indexOf('.scss') > -1) {
			continue;
		}

		// add an issue to the list
		result.errors.push({
			id: '(error)',
			raw: 'Found hardcoded value',
			evidence: lines[n],
			line: n + 1,
			character: lines[n].indexOf(matches[1]) + 1,
			reason: 'Found hardcoded value: "' + matches[1] + '"'
		});
	}
}

// return JSON-encoded result
print(JSON.stringify(result));