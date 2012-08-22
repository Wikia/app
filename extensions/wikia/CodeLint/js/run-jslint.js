/**
 * JS script performing lint check over JS files. It should be run using nodejs.
 *
 * Usage:
 *   nodejs run-jslint.js --jslint=<absolute path to jslint.js> --file=<file to check>
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 */

var IGNORE_STATEMENT = '/* JSlint ignore */';

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
	// comments starting with TODO should be allowed.
	todo: true,
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

// additional, Wikia specific rules
var regExpRules = require('./jslint-wikia-rules.js').rules,
	commentRegExp = /^\s*\*|\/\//;

// scan each line
var lines = fileSrc.split("\n"),
	line,
	matches;

for(var n=0, len = lines.length; n < len; n++) {
	line = lines[n];

	// check for IGNORE_STATEMENT
	if (line.indexOf(IGNORE_STATEMENT) > -1) {
		// filter out issues reported by "core" JSLint rules
		result.errors = result.errors.filter(function(item) {
			return (item && item.line == (n+1)) ?  false /* error should be ignored */ : true;
		});
		continue;
	}

	// ignore comment lines
	if (commentRegExp.test(line)) {
		continue;
	}

	regExpRules.forEach(function(rule) {
		matches = line.match(rule.regexp);

		if (matches) {
			// omit lines that match 'dontMatch' rule field
			if (rule.dontMatch && rule.dontMatch.test(line)) {
				return;
			}

			var reason = (typeof rule.reason === 'function') ? rule.reason.call(this, matches, line, lines[n+1]) : rule.reason;
			if (reason === false) {
				return;
			}

			// add an issue to the list
			result.errors.push({
				id: '(error)',
				raw: rule.name,
				evidence: line,
				line: n + 1,
				character: line.indexOf(matches[1]) + 1,
				reason: reason
			});
		}
	});
}

// return JSON-encoded result
print(JSON.stringify(result));
