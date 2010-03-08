// @see http://www.stevesouders.com/blog/2009/04/27/loading-scripts-without-blocking/
var WikiaScriptLoader = function() {
	// detect Firefox / Opera and use script DOM node injection for them
	var userAgent = navigator.userAgent.toLowerCase();
	this.useDOMInjection = (userAgent.indexOf('opera') != -1) ||
		(userAgent.indexOf('firefox') != -1);

	// detect IE
	this.isIE = (userAgent.indexOf('opera') == -1) && (userAgent.indexOf('msie') != -1);

	// get reference to <head> tag
	this.headNode = document.getElementsByTagName('HEAD')[0];
};

WikiaScriptLoader.prototype = {
	// load script from provided URL and don't block another downloads
	// see pages 57 and 58 of "Even Faster Web Sites"
	loadScript: function(url, onloadCallback) {
		if (this.useDOMInjection) {
			this.loadScriptDOMInjection(url, onloadCallback);
		}
		else {
			this.loadScriptDocumentWrite(url, onloadCallback);
		}
	},

	// use script DOM node injection method
	loadScriptDOMInjection: function(url, onloadCallback) {
		// add <script> tag to <head> node
		var scriptNode = document.createElement('script');
		scriptNode.type = "text/javascript";
		scriptNode.src = url;

		// handle script onload event
		var scriptOnLoad = function() {
			scriptNode.onloadDone = true;

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

		this.headNode.appendChild(scriptNode);
	},

	// use document.write method to add script tag
	loadScriptDocumentWrite: function(url, onloadCallback) {
		document.write('<scr' + 'ipt src="' + url + '" type="text/javascript"></scr' + 'ipt>');

		// handle script onload event
		var scriptOnLoad = function() {
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

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				var jsCode = xhr.responseText;

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

				if (typeof onloadCallback == 'function') {
					onloadCallback();
				}
			}
		};

		xhr.open("GET", url, true);
		xhr.send('');
	},

	// load CSS
	loadCSS: function(url, media) {
		var link = document.createElement('link');
		link.rel = 'stylesheet';
		link.type = 'text/css';
		link.media = (media || '');
		link.href = url;
		this.headNode.appendChild(link);
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
	}
}

window.wsl = new WikiaScriptLoader();
