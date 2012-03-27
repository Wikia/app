/**
 * Generates performance metrics using head-less WebKit-based browser
 *
 * phantomjs required - http://code.google.com/p/phantomjs/wiki/BuildInstructions
 */

var page = require('webpage').create(),
	system = require('system'),
	address;

if (system.args.length === 1) {
	console.log('Usage: metrics.js <URL>');
	phantom.exit();
}

address = system.args[1];

// log total page load time
page.onLoadStarted = function () {
    page.startTime = new Date();
};

// count requests made
page.requests = 0;
page.onResourceRequested = function(res) {
	page.requests++;
}

// load the emit and print out the metrics
page.open(address, function(status) {
	switch(status) {
		case 'success':
			var metrics = {
				loadTime: new Date() - page.startTime,
				requests: page.requests
			};

			// evaluate DOM complexity
			 metrics.nodes = page.evaluate(function () {
			 	return document.getElementsByTagName('*').length;
			 });

			 // other metrics
			 metrics.cookiesRaw = page.evaluate(function () {
			 	return document.cookie.length;
			 });

			 metrics.localStorage = page.evaluate(function () {
			 	return window.localStorage.length;
			 });

			// emit the results
			console.log(JSON.stringify(metrics));
			break;

		default:
			console.log(false);
	}

	// otherwise phantomjs will never terminate
	phantom.exit();
});
