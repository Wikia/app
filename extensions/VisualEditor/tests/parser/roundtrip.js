var fs = require('fs'),
	jsDiff = require('diff'),
	Worker = require('webworker').Worker,
	DumpReader = require('./dumpReader.js').DumpReader;

function runTests() {
	function compareTest(a, b, msg) {
		if (a === b) {
			console.log('OK: ', msg);
			return true;
		} else {
			console.log('MISMATCH: ', msg);
			var patch = jsDiff.createPatch('wikitext.txt', a, b, 'before', 'after');
			console.log(patch);
			return false;
		}
	}

	var state = {
		doneReading: false,
		revsIn: 0,
		revsOut: 0
	};
	function checkState() {
		var remaining = state.revsIn - state.revsOut;
		console.log(remaining + ' in queue... ' + (state.revsOut + '/' + state.revsIn));
		if (remaining == 0) {
			console.log('are we done?', state.doneReading);
		}
		if (state.doneReading) {
			if (remaining <= 0) {
				console.log('done!');
				process.exit(0);
			}
		} else {
			if (remaining < queueLength && process.stdin.readable) {
				process.stdin.resume();
			}
		}
	}

	var nWorkers = 8;
	var queueLength = nWorkers * 2;
	var workerDir = __dirname;
	var workers = [];
	workerJs = require('path').join(workerDir, 'worker.js');
	for (var i = 0; i < nWorkers; i++) {
		var worker = new Worker(workerJs);
		worker.onerror = function(err) {
			console.log('worker error', err);
			process.exit(1);
		};
		worker.onclose = function() {
			console.log('worker closed');
		};
		worker.onmessage = function(msg) {
			var data = msg.data;
			compareTest(data.expected, data.received, data.msg);
			state.revsOut++;
			checkState();
		};
		workers[i] = worker;
	}
	//var worker = require(workerJs);
	function roundTripTest(text, msg) {
		var worker = workers[state.revsIn % nWorkers];
		state.revsIn++;
		var remaining = state.revsIn - state.revsOut;
		if (remaining >= queueLength) {
			// Throttle the input until we catch up!
			process.stdin.pause();
		}
		worker.postMessage({
			action: 'roundTrip',
			text: text,
			msg: msg
		});
	}

	// We need to tell the child process where its working directory is.
	workers.forEach(function(worker) {
		worker.postMessage({
			action: 'init',
			dir: workerDir
		});
	});

	roundTripTest('A plain single line paragraph.', 'single-line paragraph');
	//roundTripTest('A plain single line paragraph.\n\nA second paragraph after a blank.', 'two single-line paragraphs');

	var reader = new DumpReader();
	reader.on('end', function() {
		console.log('done reading!');
		state.doneReading = true;
		checkState();
	});
	reader.on('error', function(err) {
		console.log('error!', err);
		process.exit(1);
	});
	reader.on('revision', function(revision) {
		roundTripTest(revision.text, 'revision id ' + revision.id)
	});
	console.log('Reading!');
	process.stdin.setEncoding('utf8');
	process.stdin.resume();
	reader.read(process.stdin);

}

runTests();
