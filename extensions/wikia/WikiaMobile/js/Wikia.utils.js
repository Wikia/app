/**
 * This is a Wikia 'framework'
 * or rather bunch of util functions to help developing
 * WikiaMobile skin
 *
 * we decided not to use any frameworks as all we actually need is
 * addEventListener, find some elements and do some operations on array
 *
 * Frameworks like Zepto or jqMobi are nice
 * but with a cost of downloading another 9/10kb of data
 * If we don't have to load it its a win, and we dont
 *
 * This is just a place for functions that otherwise need some bigger boilerplates
 */
(function(w){
	"use strict";

	var htmlProto = HTMLElement.prototype,
		fired,
		//then use AssetsManager config to group them together
		processedSassUrls = {},
		isProcessedSassUrl,
		isJs = /\.js(\?(.*))?$/,
		isCss = /\.css(\?(.*))?$/,
		isSass = /\.scss/;

	function getAssetsManagerQuery(path, type, params){
		return window.wgAssetsManagerQuery.
			replace('%1$s', type).
			replace('%2$s', path).
			replace('%3$s', encodeURIComponent(Wikia.param(params || window.sassParams))).
			replace('%4$d', window.wgStyleVersion);
	}

	//'polyfill' for a conistent matchesSelector
	htmlProto.matchesSelector = htmlProto.matchesSelector ||
		htmlProto.webkitMatchesSelector ||
		htmlProto.mozMatchesSelector ||
		htmlProto.oMatchesSelector;

	w.addEventListener('DOMContentLoaded', function(){
		fired = true;
	});

	var Wikia = function(func){
		fired ? func() : w.addEventListener('DOMContentLoaded', func);
	};

	Wikia.not = function(selector, elements){
		var ret = [];

		if(elements && selector){
			elements = Array.prototype.slice.call(elements);

			for(var i = 0, l = elements.length; i < l; i++){
				if(!elements[i].matchesSelector(selector)){
					ret[ret.length] = elements[i];
				}
			}
		}

		return ret;
	};

	Wikia.param = function(params){
		var ret = [];

		if(params) {
			for(var param in params){
				if(params.hasOwnProperty(param)){
					ret[ret.length] = (param + '=' + params[param]);
				}
			}
		}

		return ret.join('&');
	};

	Wikia.ajax = function(attr){
		var type = (attr.type && attr.type.toUpperCase()) || 'GET',
			dataType = (attr.dataType && attr.dataType.toLowerCase()) || 'json',
			data = attr.data || {},
			success = attr.success || function(){},
			error = attr.error || function(){},
			url = attr.url || wgScriptPath,
			async = (attr.async !== false);

		var req = new XMLHttpRequest();

		if(type === 'GET' && data){
			url += (url.indexOf('?') > -1 ? '&' : '?') + Wikia.param(data);
			data = null;
		}

		req.open(type, url, async);
		req.onreadystatechange = function (ev) {
			if (req.readyState === 4) {
				var data = ev.target.responseText,
					status = req.status;

				if((status >= 200 && status < 300) || status === 304){

					if(dataType === 'json') data = JSON.parse(data);

					success(data, status, req);
				} else {
					error(data, status, req);
				}

			}
		};
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		req.send(data ? Wikia.param(data) : null);
	};

	Wikia.getSassURL = function(rootURL, scssFilePath, params) {
		if(!isProcessedSassUrl) isProcessedSassUrl = new RegExp(getAssetsManagerQuery('.*', 'sass', '###').replace(encodeURIComponent(Wikia.param('###')), '.*').replace(/\//g, '\\/'));

		var url = processedSassUrls[scssFilePath];

		if(!url){
			//a regex check is faster than a useless function call, inform the caller he's doing it wrong ;)
			if(isProcessedSassUrl.test(scssFilePath))
				throw 'the specified path is already a valid SASS URL';

			processedSassUrls[scssFilePath] = url = rootURL + getAssetsManagerQuery(scssFilePath, 'sass', params);
		}

		return url;
	};

	Wikia.getSassCommonURL = function(scssFilePath, params) {
		return Wikia.getSassURL(wgCdnRootUrl, scssFilePath, params);
	};

	Wikia.getSassLocalURL = function(scssFilePath, params) {
		return Wikia.getSassURL(wgServer, scssFilePath, params);
	};

	Wikia.getScript = function( resource, onComplete ) {
		var scriptElement = document.createElement( 'script' );
		scriptElement.src = resource;
		scriptElement.onload = onComplete;
		document.head.appendChild( scriptElement );
	};

	Wikia.getResources = function( resources, callback ) {
		var length = resources.length,
			remaining = length,
			resource,
			type;

		function onComplete(){
			remaining--;

			// all files have been downloaded
			if(remaining === 0 && typeof callback === 'function')
				callback();
		}

		// download files
		for ( var n = 0; n < length; n++ ) {
			resource = resources[n];

			if(resource && resource.type && resource.url){
				// JS files and Asset Manager groups are scripts
				type = resource.type;
				resource = resource.url;
			}else{
				type = null;
			}

			if(typeof resource === 'function'){
				resource.call(Wikia, onComplete);
			}else if(type === 'css' || isCss.test(resource) || isSass.test(resource)){
				Wikia.getCSS(resource, onComplete);
			}else if(type === 'js' || isJs.test(resource)){
				Wikia.getScript(resource, onComplete);
			}else{
				throw 'unknown resource format (' + resource + ')';
			}
		}
	};

	Wikia.nirvana = {
		sendRequest: function(attr){
			var sortedDict = {},
				type = (attr.type && attr.type.toUpperCase()) || 'POST',
				format = (attr.format && attr.format.toLowerCase()) || 'json',
				formats = {'json':1, 'jsonp':1, 'html':1},
				data = attr.data || {},
				keys = Object.keys(data).sort(),
				callback = attr.callback || function(){},
				onErrorCallback = attr.onErrorCallback || function(){},
				url = attr.scriptPath || wgScriptPath;

			if(!(attr.controller || attr.method))
				throw "controller and method are required";

			if(!(format in formats))
				throw "Only Json, Jsonp and Html format are allowed";

			for(var i = 0; i < keys.length; i++) {
				sortedDict[keys[i]] = data[keys[i]];
			}

			Wikia.ajax({
				url: url + '/wikia.php?' + Wikia.param({
					//Iowa strips out POST parameters, Nirvana requires these to be set
					//so we're passing them in the GET part of the request
					controller: attr.controller.replace(/Controller$/, ''),
					method: attr.method,
					format: format
				}),
				dataType: format,
				type: type,
				data: data,
				success: callback,
				error: onErrorCallback
			});
		},

		getJson: function(controller, method, data, callback, onErrorCallback){
			Wikia.nirvana.sendRequest({
				controller: controller,
				method: method,
				data: data,
				type: 'GET',
				callback: callback,
				onErrorCallback: onErrorCallback
			});
		},

		postJson: function(controller, method, data, callback, onErrorCallback){
			Wikia.nirvana.sendRequest({
				controller: controller,
				method: method,
				data: data,
				callback: callback,
				onErrorCallback: onErrorCallback
			});
		}
	};

	Wikia.extend = function(target){
		var args = Array.prototype.slice.call(arguments, 1),
			l = args.length,
			i = 0,
			arg;

		for(; i < l; i++){
			arg = args[i];
			for (var key in arg)
				if (arg[key] !== undefined) target[key] = arg[key];
		}

		return target;
	};

	//expose it to the world
	//$ is forbackward compatability
	w.Wikia = Wikia;
	w.$ = Wikia;
})(this, document);