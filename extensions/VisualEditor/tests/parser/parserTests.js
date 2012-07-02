/**
 * Initial parser tests runner for experimental JS parser
 *
 * This pulls all the parserTests.txt items and runs them through the JS
 * parser and JS HTML renderer. Currently no comparison is done on output,
 * as a direct string comparison won't be very encouraging. :)
 *
 * Needs smarter compare, as well as search-y helpers.
 *
 * @author Brion Vibber <brion@pobox.com>
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
 */

(function() {



console.log( "Starting up JS parser tests" );

var fs = require('fs'),
	path = require('path'),
	jsDiff = require('diff'),
	colors = require('colors'),
	util = require( 'util' ),
	jsdom = require( 'jsdom' ),
	HTML5 = require('html5').HTML5,  //TODO is this fixup for tests only, or part of real parsing...
	PEG = require('pegjs'),
	// Handle options/arguments with optimist module
	optimist = require('optimist');

// track files imported / required
var fileDependencies = [];

// Fetch up some of our wacky parser bits...

var basePath = path.join(path.dirname(path.dirname(process.cwd())), 'modules');

function _require(filename) {
	var fullpath = path.join( basePath, filename );
	fileDependencies.push( fullpath );
	return require( fullpath );
}

function _import(filename, symbols) {
	var module = _require(filename);
	symbols.forEach(function(symbol) {
		global[symbol] = module[symbol];
	});
}


// For now most modules only need this for $.extend and $.each :)
global.$ = require('jquery');

var pj = path.join;

// Our code...

var testWhiteList = require('./parserTests-whitelist.js').testWhiteList;

_import(pj('parser', 'mediawiki.parser.environment.js'), ['MWParserEnvironment']);
_import(pj('parser', 'mediawiki.parser.js'), ['ParserPipeline']);

// WikiDom and serializers
//_require(pj('es', 'es.js'));
//_require(pj('es', 'es.Html.js'));
//_require(pj('es', 'serializers', 'es.AnnotationSerializer.js'));
//_require(pj('es', 'serializers', 'es.HtmlSerializer.js'));
//_require(pj('es', 'serializers', 'es.WikitextSerializer.js'));
//_require(pj('es', 'serializers', 'es.JsonSerializer.js'));


function ParserTests () {

	this.argv = optimist.usage( 'Usage: $0', {
		'quick': {
			description: 'Suppress diff output of failed tests',
			'boolean': true,
			'default': false
		},
		'quiet': {
			description: 'Suppress notification of passed tests (shows only failed tests)',
			'boolean': true,
			'default': false
		},
		'color': {
			description: 'Enable color output Ex: --no-color',
			'boolean': true,
			'default': true
		},
		'cache': {
			description: 'Get tests cases from cache file ' + this.cache_file,
			'boolean': true,
			'default': false
		},
		'filter': {
			description: 'Only run tests whose descriptions which match given regex',
			alias: 'regex'
		},
		'whitelist': {
			description: 'Alternatively compare against manually verified parser output from whitelist',
			'default': true,
			'boolean': true
		},
		'help': {
			description: 'Show this help message',
			alias: 'h'
		},
		'disabled': {
			description: 'Run disabled tests (option not implemented)',
			'default': false,
			'boolean': true
		},
		'printwhitelist': {
			description: 'Print out a whitelist entry for failing tests. Default false.',
			'default': false,
			'boolean': true
		},
		'wikidom': {
			description: 'Print out a WikiDom conversion of the HTML DOM',
			'default': false,
			'boolean': true
		},
		'debug': {
			description: 'Print debugging information',
			'default': false,
			'boolean': true
		},
		'trace': {
			description: 'Print trace information (light debugging)',
			'default': false,
			'boolean': true
		}
	}
	).check( function(argv) {
		if( argv.filter === true ) {
			throw "--filter need an argument";
		}
	}
	).argv; // keep that


	if( this.argv.help ) {
		optimist.showHelp();
		process.exit( 0 );
	}
	this.test_filter = null;
	if( this.argv.filter ) { // null is the 'default' by definition
		try {
			this.test_filter = new RegExp( this.argv.filter );
		} catch(e) {
			console.error( "\nERROR> --filter was given an invalid regular expression.");
			console.error( "ERROR> See below for JS engine error:\n" + e + "\n" );
			process.exit( 1 );
		}
		console.log( "Filtering title test using Regexp " + this.test_filter );
	}
	if( !this.argv.color ) {
		colors.mode = 'none';
	}

	// Name of file used to cache the parser tests cases
	this.cache_file = "parserTests.cache";



	this.testFileName = '../../../../phase3/tests/parser/parserTests.txt'; // 'default'
	this.testFileName2 = '../../../../tests/parser/parserTests.txt'; // Fallback. Not everyone fetch at phase3 level 

	if (this.argv._[0]) {
		// hack :D
		this.testFileName = this.argv._[0] ;
		this.testFileName2 = null;
	}

	try {
		this.testParser = PEG.buildParser(fs.readFileSync('parserTests.pegjs', 'utf8'));
	} catch (e2) {
		console.log(e2);
	}

	this.cases = this.getTests(); 

	this.articles = {};

	//this.htmlwindow = jsdom.jsdom(null, null, {parser: HTML5}).createWindow();
	//this.htmlparser = new HTML5.Parser({document: this.htmlwindow.document});
	this.htmlparser = new HTML5.Parser();

	// Test statistics
	this.passedTests = 0;
	this.passedTestsManual = 0;
	this.failParseTests = 0;
	this.failTreeTests = 0;
	this.failOutputTests = 0;

	// Create a new parser environment
	this.env = new MWParserEnvironment({ 
		fetchTemplates: false,
		debug: this.argv.debug,
		trace: this.argv.trace,
		wgScriptPath: ''
	});
}


/**
 * Get an object holding our tests cases. Eventually from a cache file
 */
ParserTests.prototype.getTests = function () {

	// Startup by loading .txt test file
	var testFile;
	try {
		testFile = fs.readFileSync(this.testFileName, 'utf8');
		fileDependencies.push( this.testFileName );
	} catch (e) {
		// Try opening fallback file
		if( this.testFileName2 !== '' ) {
			try {
				testFile = fs.readFileSync( this.testFileName2, 'utf8' );
				fileDependencies.push( this.testFileName2 );
			}
			catch( e3 ) { console.log( e3 ); }
		}
	}
	if( !this.argv.cache ) {
		// Cache not wanted, parse file and return object 
		return this.parseTestCase( testFile );
	}

	// Find out modification time of all files depencies and then hashes those
	// as a unique value using sha1.
	var mtimes = '';
	fileDependencies.sort().forEach( function (file) {
		mtimes += fs.statSync( file ).mtime;
	});
	var sha1 = require('crypto').createHash('sha1')
		.update( mtimes ).digest( 'hex' );

	// Look for a cache_file 
	var cache_content;
	var cache_file_digest;
	try {
		console.log( "Looking for cache file " + this.cache_file );
		cache_content = fs.readFileSync( this.cache_file, 'utf8' );
		// Fetch previous digest
		cache_file_digest = cache_content.match( /^CACHE: (\w+)\n/ )[1];
	} catch( e4 ) {
		// cache file does not exist
	}

	if( cache_file_digest === sha1 ) {
		// cache file match our digest.
		console.log( "Loaded tests cases from cache file" );
		// Return contained object after removing first line (CACHE: <sha1>)
		return JSON.parse( cache_content.replace( /.*\n/, '' ) );
	} else {
		// Write new file cache, content preprended with current digest
		console.log( "Cache file either inexistant or outdated" );
		var parse = this.parseTestCase( testFile );
		if ( parse !== undefined ) {
			console.log( "Writing parse result to " + this.cache_file );
			fs.writeFileSync( this.cache_file,
				"CACHE: " + sha1 + "\n" + JSON.stringify( parse ),
				'utf8'
			);
		}
		// We can now return the parsed object
		return parse; 
	}
};

/**
 * Parse given tests cases given as plaintext
 */
ParserTests.prototype.parseTestCase = function ( content ) {
	console.log( "Parsing tests case from file, this takes a few seconds ..." );
	try {
		console.log( "Done parsing." );
		return this.testParser.parse(content);
	} catch (e) {
		console.log(e);
	}
	return undefined;
};

ParserTests.prototype.processArticle = function( index, item ) {
	var norm = this.env.normalizeTitle(item.title);
	//console.log( 'processArticle ' + norm );
	this.articles[norm] = item.text;
	process.nextTick( this.processCase.bind( this, index + 1 ) );
};


/* Normalize the expected parser output by parsing it using a HTML5 parser and
 * re-serializing it to HTML. Ideally, the parser would normalize inter-tag
 * whitespace for us. For now, we fake that by simply stripping all newlines.
 */
ParserTests.prototype.normalizeHTML = function (source) {
	// TODO: Do not strip newlines in pre and nowiki blocks!
	source = source.replace(/[\r\n]/g, '');
	try {
		this.htmlparser.parse('<body>' + source + '</body>');
		return this.htmlparser.document.getElementsByTagName('body')[0]
			.innerHTML
			// a few things we ignore for now..
			.replace(/\/wiki\/Main_Page/g, 'Main Page')
			// do not expect a toc for now
			.replace(/<table[^>]+?id="toc"[^>]*>.+?<\/table>/mg, '')
			// do not expect section editing for now
			.replace(/(<span class="editsection">\[.*?<\/span> *)?<span[^>]+class="mw-headline"[^>]*>(.*?)<\/span>/g, '$2')
			// general class and titles, typically on links
			.replace(/(title|class|rel)="[^"]+"/g, '')
			// strip red link markup, we do not check if a page exists yet
			.replace(/\/index.php\?title=([^']+)&amp;action=edit&amp;redlink=1/g, '$1')
			// the expected html has some extra space in tags, strip it
			.replace(/<a +href/g, '<a href')
			.replace(/" +>/g, '">');
	} catch(e) {
        console.log("normalizeHTML failed on" + 
				source + " with the following error: " + e);
		console.trace();
		return source;
	}
		
};

// Specialized normalization of the wiki parser output, mostly to ignore a few
// known-ok differences.
ParserTests.prototype.normalizeOut = function ( out ) {
	// TODO: Do not strip newlines in pre and nowiki blocks!
	return out.replace(/[\r\n]| data-[a-zA-Z]+="[^">]*"/g, '')
				.replace(/<!--.*?-->\n?/gm, '');
};

ParserTests.prototype.formatHTML = function ( source ) {
	// Quick hack to insert newlines before some block level start tags
	return source.replace(
			/(?!^)<((div|dd|dt|li|p|table|tr|td|tbody|dl|ol|ul|h1|h2|h3|h4|h5|h6)[^>]*)>/g,
											'\n<$1>');
};



ParserTests.prototype.printTitle = function( item, failure_only ) {
	if( failure_only ) {
		console.log('FAILED'.red + ': ' + item.title.yellow);
		return;
	}
	console.log('=====================================================');
	console.log('FAILED'.red + ': ' + item.title.yellow);
	console.log(item.comments.join('\n'));
	if (item.options) {
		console.log("OPTIONS".cyan + ":");
		console.log(item.options + '\n');
	}
	console.log("INPUT".cyan + ":");
	console.log(item.input + "\n");
};



ParserTests.prototype.processTest = function ( index, item ) {

	if (!('title' in item)) {
		console.log(item);
		throw new Error('Missing title from test case.');
	}
	if (!('input' in item)) {
		console.log(item);
		throw new Error('Missing input from test case ' + item.title);
	}
	if (!('result' in item)) {
		console.log(item);
		throw new Error('Missing input from test case ' + item.title);
	}

	this.parserPipeline.once( 'document', 
				this.processResult.bind( this, index, item ) 
			);

	// Start the pipeline by feeding it the input
	this.parserPipeline.parse( item.input );

};

ParserTests.prototype.processResult = function ( index, item, doc ) {
	// Check for errors
	if (doc.err) {
		this.printTitle(item);
		this.failParseTests++;
		console.log('PARSE FAIL', res.err);
	} else {
		// Check the result vs. the expected result.
		this.checkResult( item, doc.body.innerHTML );

		if ( this.argv.wikidom ) {
			// Test HTML DOM -> WikiDOM conversion
			this.printWikiDom( parserPipeline.getWikiDom() );
		}

	}
	// Now call schedule the next test, if any
	process.nextTick( this.processCase.bind( this, index + 1 ) );
};

ParserTests.prototype.checkResult = function ( item, out ) {
	var normalizedOut = this.normalizeOut(out);
	var normalizedExpected = this.normalizeHTML(item.result);
	if ( normalizedOut !== normalizedExpected ) {
		if (this.argv.whitelist &&
				item.title in testWhiteList &&
				this.normalizeOut(testWhiteList[item.title]) ===  normalizedOut) {
					if( !this.argv.quiet ) {
						console.log( 'PASSED (whiteList)'.green + ': ' + item.title.yellow );
					}
					this.passedTestsManual++;
					return;
				}
		this.printTitle( item, this.argv.quick );
		this.failOutputTests++;

		if( !this.argv.quick ) {
			console.log('RAW EXPECTED'.cyan + ':');
			console.log(item.result + "\n");

			console.log('RAW RENDERED'.cyan + ':');
			console.log(this.formatHTML(out) + "\n");

			var a = this.formatHTML(normalizedExpected);

			console.log('NORMALIZED EXPECTED'.magenta + ':');
			console.log(a + "\n");

			var b = this.formatHTML(normalizedOut);

			console.log('NORMALIZED RENDERED'.magenta + ':');
			console.log(this.formatHTML(this.normalizeOut(out)) + "\n");
			var patch = jsDiff.createPatch('wikitext.txt', a, b, 'before', 'after');

			console.log('DIFF'.cyan +': ');

			// Strip the header from the patch, we know how diffs work..
			patch = patch.replace(/^[^\n]*\n[^\n]*\n[^\n]*\n[^\n]*\n/, '');

			var colored_diff = patch.split( '\n' ).map( function(line) {
				// Add some colors to diff output
				switch( line.charAt(0) ) {
					case '-':
						return line.red;
					case '+':
						return line.blue;
					default:
						return line;
				}
			}).join( "\n" );


			console.log( colored_diff );

			if(this.argv.printwhitelist) {
				console.log("WHITELIST ENTRY:".cyan);
				console.log("testWhiteList[" + 
						JSON.stringify(item.title) + "] = " + 
						JSON.stringify(out) +
						";\n");
			}
		}
	} else {
		this.passedTests++;
		if( !this.argv.quiet ) {
			console.log( 'PASSED'.green + ': ' + item.title.yellow );
		}
	}
};


/**
 * Print out a WikiDom conversion of the HTML DOM
 */
ParserTests.prototype.printWikiDom = function ( body ) {
	console.log('WikiDom'.cyan + ':');
	console.log( body );
};


/**
 * Colorize given number if <> 0
 *
 * @param count Integer: a number to colorize
 * @param color String: 'green' or 'red'
 */
ParserTests.prototype.ColorizeCount = function ( count, color ) {
	if( count === 0 ) {
		return count;
	}

	// We need a string to use colors methods 
	count = count.toString();
	// FIXME there must be a wait to call a method by its name
	switch( color ) {
		case 'green': return count.green;
		case 'red':   return count.red;

		default:      return count;
	}
};

ParserTests.prototype.reportSummary = function () {

	var failTotalTests = (this.failParseTests + this.failTreeTests +
			this.failOutputTests);

	console.log( "==========================================================");
	console.log( "SUMMARY: ");

	if( failTotalTests !== 0 ) {
		console.log( this.ColorizeCount( this.passedTests    , 'green' ) + 
				" passed");
		console.log( this.ColorizeCount( this.passedTestsManual , 'green' ) + 
				" passed from whitelist");
		console.log( this.ColorizeCount( this.failParseTests , 'red'   ) + 
				" parse failures");
		console.log( this.ColorizeCount( this.failTreeTests  , 'red'   ) + 
				" tree build failures");
		console.log( this.ColorizeCount( this.failOutputTests, 'red'   ) + 
				" output differences");
		console.log( "\n" );
		console.log( this.ColorizeCount( this.passedTests + this.passedTestsManual , 'green'   ) + 
				' total passed tests, ' +
				this.ColorizeCount( failTotalTests , 'red'   ) + " total failures");

	} else {
		if( this.test_filter !== null ) {
			console.log( "Passed " + ( this.passedTests + this.passedTestsManual ) + 
					" of " + this.passedTests + " tests matching " + this.test_filter + 
					"... " + "ALL TESTS PASSED!".green );
		} else {
			// Should not happen if it does: Champagne!
			console.log( "Passed " + this.passedTests + " of " + this.passedTests + 
					" tests... " + "ALL TESTS PASSED!".green );
		}
	}
	console.log( "==========================================================");

};

ParserTests.prototype.main = function () {
	console.log( "Initialisation complete. Now launching tests." );
	//var parserEnv = new MWParserEnvironment({
	//	tagHooks: {
	//		'ref': MWRefTagHook,
	//		'references': MWReferencesTagHook
	//	}
	//});

	this.env.pageCache = this.articles;
	this.parserPipeline = new ParserPipeline( this.env );

	this.comments = [];

	this.processCase( 0 );
};

ParserTests.prototype.processCase = function ( i ) {
	if ( i < this.cases.length ) {
		var item = this.cases[i];
		//console.log( 'processCase ' + i + JSON.stringify( item )  );
		if ( typeof item == 'object' ) {
			switch(item.type) {
				case 'article':
					this.comments = [];
					this.processArticle( i, item );
					break;
				case 'test':
					if( this.test_filter && 
						-1 === item.title.search( this.test_filter ) ) {
						// Skip test whose title does not match --filter
						process.nextTick( this.processCase.bind( this, i + 1 ) );
						break;
					}
					// Add comments to following test.
					item.comments = this.comments;
					this.comments = [];
					this.processTest( i, item );
					break;
				case 'comment':
					this.comments.push( item.comment );
					process.nextTick( this.processCase.bind( this, i + 1 ) );
					break;
				default:
					this.comments = [];
					process.nextTick( this.processCase.bind( this, i + 1 ) );
					break;
			}
		} else {
			process.nextTick( this.processCase.bind( this, i + 1 ) );
		}
	} else {
		// print out the summary
		this.reportSummary();
	}
};

// Construct the ParserTests object and run the parser tests
new ParserTests().main();


})();
