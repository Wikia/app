var path = require('path');

// Fake a worker-like interface so we can test it in-process
// workers in node's webworker module don't seem to report errors very well.
if (typeof module == "object") {
	module.exports = {
		postMessage: function(data) {
			var msg = {data: JSON.parse(JSON.stringify(data))};
			setTimeout(function() {
				onmessage(msg);
			}, 0);
		},
		onmessage: function(msg) {}
	};

	if (typeof postMessage === 'undefined') {
		postMessage = function(data) {
			var msg = {data: JSON.parse(JSON.stringify(data))};
			setTimeout(function() {
				module.exports.onmessage(msg)
			}, 0);
		}
	}
}

// The worker context for some reason doesn't let us adjust globals,
// so farming the good stuff out to a module which can.
var didInit = false;
var myWorker = {
	postMessage: postMessage,
	onmessage: function(msg) {
		var data = msg.data;
		if (data.action == 'init') {
			if (didInit) {
				throw new Error('second init request');
			}
			// Running as a worker in node.js we have to set the working directory
			// or we won't be able to find our local files.
			//
			// It's a bit annoying. ;)
			process.chdir(data.dir);
			require(path.join(data.dir, 'roundtrip-test.js')).init(myWorker);
			didInit = true;
		} else {
			throw new Error('Must init first!');
		}
	}
};

onmessage = function(msg) {
	return myWorker.onmessage(msg);
}

