// @see http://www.stevesouders.com/blog/2009/04/27/loading-scripts-without-blocking/
var WikiaScriptLoader = function() {
	// benchmarking load time
	var self = this;
	this.start = window.wgNow.getTime() || this.getTime();

	this.addHandler(window, 'load', function() {self.onPageLoad.call(self)});

	// ID for script tags
	this.scriptId = 0;

	// detect Firefox / Opera / Chrome4 and use script DOM node injection for them
	var userAgent = navigator.userAgent.toLowerCase();
	this.useDOMInjection = (userAgent.indexOf('opera') != -1) ||
		(userAgent.indexOf('firefox') != -1) ||
		(userAgent.indexOf('chrome/4') != -1);

	// detect IE
	this.isIE = (userAgent.indexOf('opera') == -1) && (userAgent.indexOf('msie') != -1);

	// get reference to <head> tag
	this.headNode = document.getElementsByTagName('HEAD')[0];

	// debug
	this.log('init() after ' + (this.getTime() - this.start) + ' ms - ' + (this.useDOMInjection ? 'using script DOM node injection' : 'using document.write of <script> tag'));
};

WikiaScriptLoader.prototype = {
	// load script from provided URL and don't block another downloads
	// see pages 57 and 58 of "Even Faster Web Sites"
	loadScript: function(url, onloadCallback) {
		var id = 'wsl-' + (++this.scriptId);

		if (this.useDOMInjection) {
			this.loadScriptDOMInjection(id, url, onloadCallback);
		}
		else {
			this.loadScriptDocumentWrite(id, url, onloadCallback);
		}

		this.log('"' + url + '" is loading');
	},

	// use script DOM node injection method
	loadScriptDOMInjection: function(id, url, onloadCallback) {
		var self = this;

		// bencharking
		var start = this.getTime();

		// add <script> tag to <head> node
		var scriptNode = document.createElement('script');
		scriptNode.type = "text/javascript";
		scriptNode.src = url;
		scriptNode.id = id;

		// handle script onload event
		var scriptOnLoad = function() {
			scriptNode.onloadDone = true;

			self.log('"' + url + '" loaded in ' + (self.getTime() - start) + ' ms');

			if (typeof onloadCallback == 'function') {
				onloadCallback();
			}
		};

		scriptNode.onloadDone = false;
		scriptNode.onload = scriptOnLoad;
		scriptNode.onreadystatechange = function() {
			// for Opera
			if (scriptNode.readyState == 'loaded' && !scriptNode.onloadDone) {
				scriptOnLoad();
			}
		}

		// handle HTTP 404
		scriptNode.onerror = function() {
			self.log('loading "' + url + '" failed');
		};

		this.headNode.appendChild(scriptNode);
	},

	// use document.write method to add script tag
	loadScriptDocumentWrite: function(id, url, onloadCallback) {
		var self = this;

		// bencharking
		var start = this.getTime();

		document.write('<scr' + 'ipt id="' + id + '"src="' + url + '" type="text/javascript"></scr' + 'ipt>');

		// handle script onload event
		var scriptOnLoad = function() {
			self.log('"' + url + '" loaded in ' + (self.getTime() - start) + ' ms');

			if (typeof onloadCallback == 'function') {
				onloadCallback();
			}
		};

		if (typeof onloadCallback == 'function') {
			this.addHandler(window, 'load', scriptOnLoad);
		}
	},

	// load script content using AJAX request
	loadScriptAjax: function(url, onloadCallback) {
		var self = this;
		var xhr = this.getXHRObject();
		var start = this.getTime();

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				self.log('"' + url + '" loaded via AJAX in ' + (self.getTime() - start)  + ' ms');
				var jsCode = xhr.responseText;

				// execute downloaded JS
				var evalStart = self.getTime();

				// evaluate JS via eval() / inline <script> tag
				if (self.isIE) {
					// in IE eval is about 50% faster then inline script
					eval(jsCode);
				}
				else {
					var scriptNode = document.createElement('script');
					scriptNode.type = "text/javascript";
					scriptNode.text = jsCode;

					self.headNode.appendChild(scriptNode);
				}

				// debug
				self.log('"' + url + '" executed in ' + (self.getTime() - evalStart)  + ' ms');

				if (typeof onloadCallback == 'function') {
					onloadCallback();
				}
			}
		};

		xhr.open("GET", url, true);
		xhr.send('');

		this.log('"' + url + '" is loading via AJAX');
	},

	// log page loading time
	onPageLoad: function() {
		this.log('page loaded in ' + (this.getTime() - this.start) + ' ms');
	},

	// get current time in miliseconds
	getTime: function() {
		return (new Date()).getTime();
	},

	// add event handler
	addHandler: function(elem, type, func) {
		if (window.addEventListener) {
			window.addEventListener(type, func, false);
		}
		else if (window.attachEvent) {
			window.attachEvent('on' + type, func);
		}
	},

	// get XHR object
	getXHRObject: function() {
		var xhrObj = false;

		try {
			xhrObj = new XMLHttpRequest();
		}
		catch(e) {
			var types = ["Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];

			var len = types.length;
			for (var i=0; i<len; i++) {
				try {
					xhrObj = new ActiveXObject(types[i]);
				}
				catch(e) {
					continue;
				}
				break;
			}
		}

		return xhrObj;
	},

	// logging for Firefox/IE8/Opera
	log: function(msg) {
		if (typeof window.console != 'undefined') {
			window.console.log('WSL: ' + msg);
		}
		else if (typeof window.opera != 'undefined') {
			window.opera.postError('WSL: ' + msg);
		}
	}
}

window.wsl = new WikiaScriptLoader();
