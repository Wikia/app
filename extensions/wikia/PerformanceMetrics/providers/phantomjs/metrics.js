/*global phantom:true, console:true, require:true */

/**
 * Generates performance metrics using head-less WebKit-based browser
 *
 * phantomjs required - http://code.google.com/p/phantomjs/wiki/BuildInstructions
 *
 */
var request = require('webpage').create,
	system = require('system'),
	address;

if (system.args.length === 1) {
	console.log('Usage: metrics.js <URL> --username=foo --password=bar');
	phantom.exit();
}

var page = request();

function parseArgs(args) {
	var res = {};

	args.forEach(function(val) {
		if (val.indexOf('--') === 0) {
			val = val.substring(2);
			var idx = val.indexOf('='),
				key = val.substring(0, idx),
				value = val.substring(idx+1);

			res[key] = value;
		}
	});

	return res;
}

// calculate DOM complexity
function getDomComplexity(page) {
	var metrics = page.evaluate(function() {
		var shortTags = [
			'script',
			'link',
			'hr',
			'br',
			'img'
		];

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
							metrics.nodes++;
							break;

						case Node.COMMENT_NODE:
							metrics.nodes++;

							// count the length of all HTML comments (including <!-- --> brackets)
							metrics.commentsSize += childNodes[i].length + 7 /* <!-- --> */;
							break;
					}
				}
			}
			else {
				// count HTML elements with no content
				if (node.nodeType === Node.ELEMENT_NODE && shortTags.indexOf(node.nodeName.toLowerCase()) === -1) {
					//metrics.emptyNodes++;
				}
			}
		}

		var metrics = {
			elements: 0,
			nodes: 0,
			//emptyNodes: 0,
			commentsSize: 0,
			depthStack: [] // tmp
		},
		node = document.getElementsByTagName('html')[0];

		processNode(node, metrics);

		return metrics;
	});

	// inline <script> tags
	var inlineJSmetrics = page.evaluate(function() {
		var nodes = document.getElementsByTagName('script'),
			count = 0,
			length = 0;

		for (var i=0, len = nodes.length; i<len; i++) {
			if (!nodes[i].src) {
				count++;
				length += nodes[i].innerText.length;
			}
		}

		return {
			count: count,
			length: length
		};
	});

	metrics.bodyHTMLSize = page.evaluate(function() {
		return document.body.outerHTML.length;
	});

	// add length of code in inline JS scripts
	metrics.inlineScriptsCount = inlineJSmetrics.count;
	metrics.inlineScriptsLength = inlineJSmetrics.length;

	// process depth calculation
	metrics.depthStack = metrics.depthStack.sort(function(a, b) {return a - b;});

	var sum = 0, len = metrics.depthStack.length, pos = parseInt(len / 2, 10);
	metrics.depthStack.forEach(function(val) {sum += val;});

	metrics.maxElementsDepth = metrics.depthStack[metrics.depthStack.length - 1];
	metrics.avgElementsDepth = (sum / len).toFixed(2);
	metrics.medElementsDepth = (pos % 2 == 1) ? metrics.depthStack[pos] : ((metrics.depthStack[pos] + metrics.depthStack[pos-1]) / 2);

	delete metrics.depthStack;
	return metrics;
}

// get all JS globals (BugId:29463)
function getGlobals(page) {
	// @see https://github.com/madrobby/dom-monster/blob/master/src/dommonster.js#L645
	return page.evaluate(function() {
		function $tagname(tagname) {
			var nodes = document.getElementsByTagName(tagname),
			retValue = [];

			for (var i = nodes.length - 1; i >= 0; i = i - 1) {
				retValue[i] = nodes[i];
			}

			return retValue;
		}

		function ignore(name){
			var allowed = ['Components','XPCNativeWrapper','XPCSafeJSObjectWrapper','getInterface','netscape','GetWeakReference'],
			i = allowed.length;
			while(i--){
				if(allowed[i] === name) {
					return true;
				}
			}
			return false;
		}

		function nametag(attr){
			var ele = nametag.cache = nametag.cache || $tagname('*'), i = ele.length;
			while(i--){
				if(ele[i].name && ele[i].name == attr) {
					return true;
				}
			}
			return false;
		}

		var global = (function(){ return this })(), properties = {}, prop, found = [], clean, iframe = document.createElement('iframe');
		iframe.style.display = 'none';
		iframe.src = 'about:blank';
		document.body.appendChild(iframe);

		clean = iframe.contentWindow;

		for(prop in global){
			if(!ignore(prop) && !/^[0-9]/.test(prop) && !(document.getElementById(prop) || {}).nodeName && !nametag(prop)){
				properties[prop] = true;
			}
		}

		for(prop in clean){
			if(properties[prop]){
				delete properties[prop];
			}
		}

		for(prop in properties){
			found.push(prop.split('(')[0]);
		}

		return found;
	});
}

// track onDOMready event
page.onInitialized = function () {
	console.log('open URL: ' + address);

	page.startTime = Date.now();
	pingRequestMonitor();

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

	// AB testing setup
	// @see /extensions/wikia/AbTesting/js/AbTest.js
	if (abGroup) {
		page.evaluate(new Function("window.Wikia.AbTest.treatmentGroups = {'1': '" + abGroup + "'};"));
	}
};

// monitor requests made (BugId:26332)
page.requests = [];
page.currentRequests = 0;
page.onResourceRequested = function(res) {
	//console.log('req [#' + res.id + ']: ' + res.url  + ' (' +  JSON.stringify({time:res.time}) + ')');

	page.requests[res.id] = {
		url: res.url,
		sendTime: res.time
	};

	page.currentRequests++;
	pingRequestMonitor();
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

page.redirects = [];
page.notFound = [];

page.onResourceReceived = function(res) {
	var entry = page.requests[res.id],
		type = 'other';

	//console.log(JSON.stringify(res));
	//console.log('recv [' + res.stage + ' #' + res.id + ']: ' + res.url + ' (' +  JSON.stringify({time:res.time}) + ')');

	switch (res.stage) {
		case 'start':
			entry.recvStartTime = res.time;
			entry.timeToFirstByte = res.time - entry.sendTime;

			// FIXME: buggy
			// @see http://code.google.com/p/phantomjs/issues/detail?id=169
			entry.contentLength = res.bodySize || 0;
			break;

		case 'end':
			page.currentRequests--;
			pingRequestMonitor();

			entry.recvEndTime = res.time;
			entry.lastByte = res.time - entry.sendTime;
			entry.receive = entry.lastByte - entry.timeToFirstByte;
			entry.status = res.status || 200 /* for base64 data */;

			switch (entry.status) {
				case 301:
				case 302:
					page.redirects.push(res.url);
					break;

				case 404:
					page.notFound.push(res.url);
					break;
			}

			res.headers.forEach(function(header) {
				switch (header.name) {
					// TODO: why it's not gzipped?
					// because: http://code.google.com/p/phantomjs/issues/detail?id=156
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
						break;

					// detect content encoding
					case 'Content-Encoding':
						if (header.value === 'gzip') {
							entry.gzip = true;
						}
						break;

					// detect varnish hit
					case 'X-Cache':
						if (header.value.indexOf('HIT') === 0) {
							entry.hit = true;
						}
						break;
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

// monitor number of open requests
page.requestsMonitor = [];
page.httpRequestsDone = 0;
var pingRequestMonitorTimeout;

function pingRequestMonitor() {
	if (page.startTime) {
		var entry = {
			timestamp: Date.now() - page.startTime,
			cnt: page.currentRequests
		};
		page.requestsMonitor.push(entry);

		if (pingRequestMonitorTimeout) {
			clearTimeout(pingRequestMonitorTimeout);
		}

		page.httpRequestsDone = entry.timestamp;

		// when the last HTTP request was completed
		if (entry.cnt === 0) {
			// generate the report when all HTTP request are done
			pingRequestMonitorTimeout = setTimeout(function() {
				renderMetrics();
			}, 5000);
		}
	}
}

// grab console.log messages
page.logLines = [];
page.onConsoleMessage = function (msg) {
	console.log('log: ' + msg);
	page.logLines.push(msg);
};

// page loading is cpmpleted
page.onLoadFinished = function(status) {
	switch(status) {
		case 'success':
			page.loadFinished = Date.now();
			break;

		default:
			console.log(false);
			phantom.exit();
	}
};

// timeout
setTimeout(function() {
	renderMetrics();
}, 15000);

// calculate metrics and emit them to the console as JSON-encoded string
function renderMetrics() {
	var now = page.loadFinished,
	url = page.evaluate(function() {
		return document.location.toString();
	}),
	metrics = {
		requests: page.requests.length,
		contentLength: page.contentLength,
		redirects: page.redirects.length,
		notFound: page.notFound.length,
		timeToFirstByte: (page.requests[1] && page.requests[1].timeToFirstByte) || 0,
		timeToLastByte: (page.requests[1] && page.requests[1].lastByte) || 0,
		totalLoadTime: now  - page.startTime
	},
	// notices for --verbose mode
	notices = [];

	// count per each resource type
	for (var type in page.resourceTypes) {
		metrics[type + 'Count'] = page.resourceTypes[type];
	}

	// size per each resource type
	for (var type in page.resourceSize) {
		metrics[type + 'Size'] = page.resourceSize[type];
	}

	// onDOMready
	metrics.onDOMreadyTime = page.evaluate(function() {
		return window.timingDOMContentLoaded - (window.wgNow || window.timingLoadStarted);
	});

	metrics.windowOnLoadTime = page.evaluate(function() {
		return (window.timingOnLoad || Date.now()) - (window.wgNow || window.timingLoadStarted);
	});

	// evaluate DOM complexity
	var domMetrics = getDomComplexity(page);
	for (var key in domMetrics) {
		metrics[key] = domMetrics[key];
	}

	// redirects and 404s
	if (page.redirects.length > 0) {
		notices.push('Redirects: ' + page.redirects.join(', '));
	}
	if (page.notFound.length > 0) {
		notices.push('Not found: ' + page.notFound.join(', '));
	}

	// global JS variables
	var globals = getGlobals(page);

	metrics.globalVariables = globals.length;
	notices.push('JS globals (' + globals.length + '): ' + globals.join(', '));

	// other metrics
	metrics.cookiesRaw = page.evaluate(function() {
		return document.cookie.length;
	});

	metrics.localStorage = page.evaluate(function() {
		return window.localStorage.length;
	});

	// AdDriver timing (BugId:33298)
	var AdDriverRegExp = {
		started: /AdDriver started loading after (\d+) ms/,
		finished: /AdDriver finished at (\d+) ms/
	};

	page.logLines.forEach(function(msg) {
		var matches;

		if (matches = msg.match(AdDriverRegExp.started)) {
			// ignore repeating message
			metrics.adDriverStart = metrics.adDriverStart || parseInt(matches[1]);
		}
		else if (matches = msg.match(AdDriverRegExp.finished)) {
			// take the last message into consideration
			metrics.adDriverDone = parseInt(matches[1]);
		}
	});

	// debug stuff
	notices.push('Logged in as ' + page.evaluate(function() {
		return window.wgUserName !== null ? window.wgUserName : '<anon>';
	}));

	notices.push('A/B testing group: ' + page.evaluate(function() {
		return window.Wikia.AbTest.getTreatmentGroup(1);
	}));

	// add log lines to notices
	page.logLines.forEach(function(msg) {
		notices.push('Console: ' + msg);
	});

	// requests monitor
	notices.push('HTTP connections monitor:');
	var lastTimestamp = 0;
	page.requestsMonitor.forEach(function(entry) {
		if (entry.timestamp - lastTimestamp < 20) {
			return;
		}

		lastTimestamp = entry.timestamp;

		var msg = 'at ' + entry.timestamp + ' ms - ' + entry.cnt,
			spacer = new Array(30 - msg.length).join(' '),
			stars = new Array(entry.cnt+1).join('*');

		notices.push(msg + spacer + stars);
	});

	metrics.httpRequestsDone = page.httpRequestsDone;
	notices.push('at ' + page.httpRequestsDone + ' ms - DONE');

	// emit the results
	var report = {
		url: url,
		metrics: metrics,
		notices: notices
	};

	console.log(JSON.stringify(report));
	phantom.exit();
}

/*
 * Run metrics
 */

// parse script arguments
var args = parseArgs(system.args);

var address = system.args[1],
	username = args.username || false,
	password = args.password || false,
	abGroup = args.abGroup || false; // A/B testing group ID

// log me in
if (username !== false && password !== false) {
	var apiUrl = address.substring(0, address.indexOf('.com/') + 4) + '/api.php';

	console.log('API url: ' + apiUrl);

	// obtain log in token
	var postData = 'action=login&format=json&lgname=' + username + '&lgpassword=' + password,
		apiReq = request(),
		apiReq2 = request();

	apiReq.onResourceReceived = apiReq2.onResourceReceived = function(res) {
		if (res.stage === 'end') {
			console.log('# Headers: ' + JSON.stringify(res.headers));
		}
	};

	apiReq.open(apiUrl, 'post', postData, function() {
		console.log(apiReq.plainText);

		var data = JSON.parse(apiReq.plainText),
			token = data.login.token;

		console.log('# Token obtainted: ' + token);

		apiReq2.open(apiUrl, 'post', postData + '&lgtoken=' + token, function() {
			console.log('# Logged in');

			page.open(address);
		});
	});
}
// anon request
else {
	page.open(address);
}
