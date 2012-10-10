/**
 * WikiaScriptLoader
 * @see http://www.stevesouders.com/blog/2009/04/27/loading-scripts-without-blocking/
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

/**
 * @namespace WikiaScriptLoader
 */

(function(window){

	var WikiaScriptLoader = {};

	/**
	 * @private
	 */

	// detect Firefox 3.x (ignore Fx4.0 beta - RT #91718/BugId:3622) / Opera and use script DOM node injection for them
	//our code strongly relies on the scripts' loading to block any further
	//JS execution (on Edit and Special pages also the page loading process),
	//on some browsers injecting nodes doesn't ensure the execution to be
	//blocked, in that case fall back to document.write
	var userAgent = navigator.userAgent.toLowerCase(),
	useDOMInjection = (userAgent.indexOf('opera') != -1) || (userAgent.indexOf('firefox/3.') != -1),
	headNode = document.getElementsByTagName('HEAD')[0],
	NodeFactories = {
		js: function(url, options){
			var script = document.createElement('script');
			script.src = url;
			script.type = "text/javascript";
			script.async = false;
			script.onLoadDone = false;
			script.onLoadCallback = options.callback || null;
			script.onload = function() {
				if (!this.onLoadDone && typeof this.onLoadCallback == 'function') {
					this.onLoadCallback();
					this.onLoadDone = true;
				}
			};
			//for Opera
			script.onreadystatechange = function() {
				if (!this.onloadDone && this.readyState == 'loaded' && typeof this.onLoadCallback == 'function') {
					this.onLoadCallback();
					this.onLoadDone = true;
				}
			};

			return script;
		},
		css: function(url, options){
			var link = document.createElement('link');
			link.href = url;
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.media = options.media || '';

			return link;
		}
	},
	counter = 0;

	//X-Browser isArray(), including Safari
	function isArray(obj){
		return obj instanceof Array;
	}

	function injectNode(type, urls, options){
		options = options || {};

		if(!isArray(urls)) {
			urls = [urls];
		}

		var node,
		url,
		finalCallback,
		opts;

		if(options.callback){
			finalCallback = function(){
				counter--;

				if(counter == 0){
					options.callback();
				}
			}
		}

		if(type == 'js'){
			opts = {callback: finalCallback};
			counter += urls.length;
		} else {
			opts = options;
		}

		for(var x = 0, y = urls.length; x < y; x++){
			headNode.appendChild(NodeFactories[type](urls[x], opts));
		}
	}

	function buildScript(urls) {
		var output = '';
		if(!isArray(urls))
			urls = [urls];

		for(var x = 0, y = urls.length; x < y; x++){
			if (typeof urls[x] === 'string') {
				output += '<scr' + 'ipt src="' + urls[x] + '" type="text/javascript"></scr' + 'ipt>';
			}
		}
		return output;
	}

	function writeScript(urls, callback){
		var output = buildScript(urls);

		document.write(output);

		// handle onload event
		if (typeof callback == 'function') {
			var handler = function(){
				callback();
			};

			if(window.addEventListener)
				window.addEventListener('load', handler, false);
			else if(window.attachEvent)
				window.attachEvent('onload', handler);
		}
	}

	/**
	 * @public
	 */

	WikiaScriptLoader.buildScript = buildScript;

	WikiaScriptLoader.loadScript = function(urls, callback){
		if(useDOMInjection)
			injectNode('js', urls, {callback: callback});
		else
			writeScript(urls, callback);
	};

	WikiaScriptLoader.loadCSS = function(urls, media) {
		injectNode('css', urls, {media: media});
	};

	window.wsl = WikiaScriptLoader;

})(window);
