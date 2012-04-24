/*global phantom:true, console:true, require:true */

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

// calculate DOM complexity
function getDomComplexity(page) {
	var metrics = page.evaluate(function() {
		// run this in the "scope" of the browser
		function processNode(node, metrics, depth) {
			var childNodes = node.childNodes;

			// we're going deeper and deeper
			depth = depth || 0;
			depth++;

			// count the current node
			metrics.elements++;
			metrics.nodes++;
			metrics.depthStack.push(depth);

			// recursively process child nodes
			if (childNodes && childNodes.length) {
				for (var i = 0, len = childNodes.length; i < len; i++) {
					switch(childNodes[i].nodeType) {
						case Node.ELEMENT_NODE:
							processNode(childNodes[i], metrics, depth);
							break;

						case Node.TEXT_NODE:
						case Node.COMMENT_NODE:
							metrics.nodes++;
							break;
					}
				}
			}
		};

		var metrics = {
			elements: 0,
			nodes: 0,
			depthStack: [] // tmp
		},
		node = document.getElementsByTagName('html')[0];

		processNode(node, metrics);

		return metrics;
	});

	// process depth calculation
	metrics.depthStack = metrics.depthStack.sort(function(a, b) {return a - b});

	var sum = 0, len = metrics.depthStack.length, pos = parseInt(len / 2);
	metrics.depthStack.forEach(function(val) {sum += val});

	metrics.maxElementsDepth = metrics.depthStack[metrics.depthStack.length - 1];
	metrics.avgElementsDepth = (sum / len).toFixed(2);
	metrics.medElementsDepth = (pos % 2 == 1) ? metrics.depthStack[pos] : ((metrics.depthStack[pos] + metrics.depthStack[pos-1]) / 2);

	delete metrics.depthStack;
	return metrics;
};

// track onDOMready event
page.onInitialized = function () {
	page.startTime = Date.now();

	// emulate window.performance
	// @see https://groups.google.com/d/topic/phantomjs/WnXZLIb_jVc/discussion
    page.evaluate(function() {
    	window.timingLoadStarted = Date.now();
        document.addEventListener("DOMContentLoaded", function() {
        	window.timingDOMContentLoaded = Date.now();
        }, false);
        window.addEventListener("load", function(){
        	window.timingOnLoad = Date.now();
        }, false);
    });
};

// monitor requests made (BugId:26332)
page.requests = [];
page.onResourceRequested = function(res) {
	//console.log('req [#' + res.id + ']: ' + res.url  + ' (' +  JSON.stringify({time:res.time}) + ')');

	page.requests[res.id] = {
		url: res.url,
		sendTime: res.time
	};
};

page.contentLength = 0;
page.resourceTypes = {
	html: 0,
	css: 0,
	js: 0,
	images: 0,
	other: 0,
	base64: 0
};

page.resourceSize = {
	html: 0,
	css: 0,
	js: 0,
	images: 0,
	other: 0,
	base64: 0
};

page.onResourceReceived = function(res) {
	var entry = page.requests[res.id],
		type = 'other';

	//console.log(JSON.stringify(res));
	//console.log('recv [' + res.stage + ' #' + res.id + ']: ' + res.url + ' (' +  JSON.stringify({time:res.time}) + ')');

	switch (res.stage) {
		case 'start':
			entry.recvStartTime = res.time;
			entry.timeToFirstByte = res.time - entry.sendTime;
			entry.contentLength = res.bodySize || 0;
			break;

		case 'end':
			entry.recvEndTime = res.time;
			entry.lastByte = res.time - entry.sendTime;
			entry.receive = entry.lastByte - entry.timeToFirstByte;

			res.headers.forEach(function(header) {
				switch (header.name) {
					// TODO: why it's not gzipped?
					case 'Content-Length':
						entry.contentLength = parseInt(header.value, 10);
						page.contentLength += entry.contentLength;
						break;

					// detect content type
					case 'Content-Type':
						// parse header value
						var value = header.value.split(';').shift();

						switch(value) {
							case 'text/html':
								type = 'html';
								break;

							case 'text/css':
								type = 'css';
								break;

							case 'application/x-javascript':
							case 'text/javascript':
								type = 'js';
								break;

							case 'image/png':
							case 'image/jpeg':
							case 'image/gif':
								type = 'images';
								break;
						}

						// detect base64 encoded images
						if (entry.url.indexOf('data:') === 0) {
							type = 'base64';
						}
				}
			});

			entry.type = type;

			page.resourceTypes[type]++;
			page.resourceSize[type] += entry.contentLength;

			//console.log('recv: ' + entry.url);
			console.log('> resource [#' + res.id +'] ' + JSON.stringify(entry));
			//console.log('> resource [#' + res.id +'] ' + JSON.stringify(res));
			break;
	}
};

page.onConsoleMessage = function (msg) {
	console.log('log: ' + msg);
};

page.onLoadFinished = function(status) {
	var now = Date.now();

	switch(status) {
		case 'success':
			var url = page.evaluate(function() {
				return document.location.toString();
			}),
			metrics = {
				requests: page.requests.length,
				contentLength: page.contentLength,
				timeToFirstByte: (page.requests[1] && page.requests[1].timeToFirstByte),
				timeToLastByte: (page.requests[1] && page.requests[1].lastByte),
				loadTime: now  - page.startTime
			};

			// count per each resource type
			for (var type in page.resourceTypes) {
				metrics[type + 'Count'] = page.resourceTypes[type];
			};

			// size per each resource type
			for (var type in page.resourceSize) {
				metrics[type + 'Size'] = page.resourceSize[type];
			};

			// onDOMready
			metrics.onDOMready = page.evaluate(function() {
				return window.timingDOMContentLoaded - (window.wgNow || window.timingLoadStarted);
			});

			metrics.onLoad = page.evaluate(function() {
				return (window.timingOnLoad || Date.now()) - (window.wgNow || window.timingLoadStarted);
			});

			// evaluate DOM complexity
			var domMetrics = getDomComplexity(page);
			for (var key in domMetrics) {
				metrics[key] = domMetrics[key];
			}

			// other metrics
			metrics.cookiesRaw = page.evaluate(function () {
				return document.cookie.length;
			});

			metrics.localStorage = page.evaluate(function () {
				return window.localStorage.length;
			});

			// emit the results
			var report = {
				url: url,
				metrics: metrics
			};

			console.log(JSON.stringify(report));
			break;

		default:
			console.log(false);
	}

	// otherwise phantomjs will never terminate
	phantom.exit();
};

// load the emit and print out the metrics
address = system.args[1];
page.open(address);
