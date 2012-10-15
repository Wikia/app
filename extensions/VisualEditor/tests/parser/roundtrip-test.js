module.exports.init = function(worker) {
	var fs = require('fs'),
		path = require('path');

	// Fetch up some of our wacky parser bits...

	//var basePath = '../modules/';
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

	// XXX: Avoid a global here!
	global.PEG = require('pegjs');

	// Our code...
	_import('ext.parserPlayground.serializer.js', ['MWTreeSerializer']);
	_import('ext.parserPlayground.pegParser.js', ['PegParser']);

	// Preload the grammar file...
	PegParser.src = fs.readFileSync(path.join(basePath, 'pegParser.pegjs.txt'), 'utf8');

	var parser = new PegParser(),
		serializer = new MWTreeSerializer();

	function sendResult(expected, received, msg) {
		worker.postMessage({
			expected: expected,
			received: received,
			msg: msg
		});
	}

	roundTripTest = function(text, msg) {
		parser.parseToTree(text, function(tree, err) {
			if (err) throw new Error(err);
			serializer.treeToSource(tree, function(newText, err) {
				if (err) throw new Error(err);
				sendResult(text, newText, msg);
			})
		})
	}

	worker.onmessage = function(msg) {
		var data = msg.data;
		if (data.action == 'roundTrip') {
			roundTripTest(data.text, data.msg);
		} else {
			throw new Error('unknown action ' + data.action);
		}
	}
};
