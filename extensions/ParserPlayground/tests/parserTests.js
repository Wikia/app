/*
 Wikia Change Start
 @test-exclude This is not a unit test
 Wikia Change End
 */
/**
 * Initial parser tests runner for experimental JS parser
 *
 * This pulls all the parserTests.txt items and runs them through the JS
 * parser and JS HTML renderer. Currently no comparison is done on output,
 * as a direct string comparison won't be very encouraging. :)
 *
 * Needs smarter compare, as well as search-y helpers.
 *
 * 2011-07-20 <brion@pobox.com>
 */

var fs = require('fs'),
	path = require('path');

// @fixme wrap more or this setup in a common module

// Fetch up some of our wacky parser bits...

var basePath = path.join(path.dirname(process.cwd()), 'modules');
function _require(filename) {
	return require(path.join(basePath, filename));
}

function _import(filename, symbols) {
	var module = _require(filename);
	symbols.forEach(function(symbol) {
		global[symbol] = module[symbol];
	})
}

// For now most modules only need this for $.extend and $.each :)
global.$ = require('jquery');

// hack for renderer
global.document = $('<div>')[0].ownerDocument;

// Local CommonJS-friendly libs
global.PEG = _require('lib.pegjs.js');

// Our code...
_import('mediawiki.parser.environment.js', ['MWParserEnvironment']);
_import('ext.cite.taghook.ref.js', ['MWRefTagHook']);

_import('ext.parserPlayground.serializer.js', ['MWTreeSerializer']);
_import('ext.parserPlayground.renderer.js', ['MWTreeRenderer']);
_import('ext.parserPlayground.pegParser.js', ['PegParser']);

// Preload the grammar file...
PegParser.src = fs.readFileSync(path.join(basePath, 'pegParser.pegjs.txt'), 'utf8');

var parser = new PegParser();

var testFileName = '../../../tests/parser/parserTests.txt'; // default
if (process.argv.length > 2) {
	// hack :D
	testFileName = process.argv[2];
	console.log(testFileName);
}

try {
        var testParser = PEG.buildParser(fs.readFileSync('parserTests.pegjs', 'utf8'));
} catch (e) {
	console.log(e);
}

var testFile = fs.readFileSync(testFileName, 'utf8');


try {
	var cases = testParser.parse(testFile);
} catch (e) {
	console.log(e);
}

var articles = {};

function normalizeTitle(name) {
	if (typeof name !== 'string') {
		throw new Error('nooooooooo not a string');
	}
	name = name.replace(/[\s_]+/g, '_');
	name = name.substr(0, 1).toUpperCase() + name.substr(1);
	if (name == '') {
		throw new Error('Invalid/empty title');
	}
	return name;
}

function fetchArticle(name) {
	var norm = normalizeTitle(name);
	if (norm in articles) {
		return articles[norm];
	}
}

function processArticle(item) {
	var norm = normalizeTitle(item.title);
	articles[norm] = item.text;
}

function nodeToHtml(node) {
	return $('<div>').append(node).html();
}

function processTest(item) {
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
	console.log(item.title);

	parser.parseToTree(item.input + "\n", function(tree, err) {
		console.log('INPUT:');
		console.log(item.input + "\n");
		if (err) {
			console.log('PARSE FAIL', err);
		} else {
			var environment = new MWParserEnvironment({
				tagHooks: {
					'ref': MWRefTagHook,
					'references': MWReferencesTagHook
				}
			});
			var renderer = new MWTreeRenderer(environment);
			renderer.treeToHtml(tree, function(node, err) {
				if (err) {
					console.log('RENDER FAIL', err);
				} else {
					console.log('EXPECTED:');
					console.log(item.result + "\n");
					
					console.log('RENDERED:');
					console.log(node.innerHTML + "\n");
				}
			});
		}
	});
}

cases.forEach(function(item) {
	if (typeof item == 'object') {
		if (item.type == 'article') {
			processArticle(item);
		} else if (item.type == 'test') {
			processTest(item);
		}
	}
});
