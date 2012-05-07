/*global phantom:true, console:true, require:true */

/**
 * Generates performance metrics using head-less WebKit-based browser
 *
 * phantomjs required - http://code.google.com/p/phantomjs/wiki/BuildInstructions
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
};

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

// count JS globals (BugId:29463)
function countGlobals(page) {
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

			//console.log(JSON.stringify(found));

			return found.length;
	});
};

// track onDOMready event
page.onInitialized = function () {
	console.log('open URL: ' + address);

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

page.redirects = 0;
page.notFound = 0;

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
			entry.recvEndTime = res.time;
			entry.lastByte = res.time - entry.sendTime;
			entry.receive = entry.lastByte - entry.timeToFirstByte;
			entry.status = res.status || 200 /* for base64 data */;

			switch (entry.status) {
				case 301:
				case 302:
					page.redirects++;
					break;

				case 404:
					page.notFound++;
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
				redirects: page.redirects,
				notFound: page.notFound,
				timeToFirstByte: (page.requests[1] && page.requests[1].timeToFirstByte),
				timeToLastByte: (page.requests[1] && page.requests[1].lastByte),
				totalLoadTime: now  - page.startTime
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

			// global JS variables
			metrics.globalVariables = countGlobals(page);

			// other metrics
			metrics.cookiesRaw = page.evaluate(function() {
				return document.cookie.length;
			});

			metrics.localStorage = page.evaluate(function() {
				return window.localStorage.length;
			});

			// debug stuff
			console.log('# User name: ' + page.evaluate(function() {
				return window.wgUserName;
			}));

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

// parse script arguments
var args = parseArgs(system.args);

var address = system.args[1],
	username = args.username || false,
	password = args.password || false;

// log me in
if (username !== false && password !== false) {
	var apiUrl = address.substring(0, address.indexOf('.com/') + 4) + '/api.php';

	console.log('API url: ' + apiUrl);

	// obtain log in token
	var postData = 'action=login&format=json&lgname=' + username + '&lgpassword=' + password,
		apiReq = request(),
		apiReq2 = request();

	apiReq.onResourceReceived = apiReq2.onResourceReceived = function(res) {
		if (res.stage == 'end') {
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
