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

// options for CSSLint
// @see http://csslint.net/about.html
var RULES = {
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
}
catch(ex) {
	print(ex.message);
	process.exit(1);
}

// be less restrictive in SASS mode
if (/.scss$/.test(args.file)) {
	// don't use build-in "errors" rule
	delete RULES.errors;

	csslint.addRule({
		id: 'sass',
		name: 'SASS specific checks',
		desc: 'This rule looks for SASS specific syntax.',
		browsers: 'All',

		init: function(parser, reporter) {
			var rule = this;

			parser.addListener('error', function(event) {
				switch(event.message) {
					// filter them out
					case '@import not allowed here.':
						break;

					// pass an error
					default:
						reporter.error(event.message, event.line, event.col, rule);
				}
			});
		}
	});

	RULES.sass = true;
}

// lint it
var errors = csslint.verify(fileSrc, RULES).messages;

// prepare output object
var result = {
	fileChecked: args.file,
	errors: errors,
	tool: "CSS Lint v" + csslint.version,
	inSassMode: !!RULES.sass
};

// return JSON-encoded result
print(JSON.stringify(result));

//process.exit(1);