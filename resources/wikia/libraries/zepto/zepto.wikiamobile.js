(function(Wikia){
	"use strict";

	//TODO: split this library in different files: zepto.resources.js, zepto.loader.js, etc.
	//then use AssetsManager config to group them together

	/** @private **/

	var processedSassUrls = {},
		isProcessedSassUrl = new RegExp(getAssetsManagerQuery('.*', 'sass', '###').replace(encodeURIComponent($.param('###')), '.*').replace(/\//g, '\\/')),
		isJs = /\.js(\?(.*))?$/,
		isCss = /\.css(\?(.*))?$/,
		isSass = /\.scss/;

	function getAssetsManagerQuery(path, type, params){
		return window.wgAssetsManagerQuery.
			replace('%1$s', type).
			replace('%2$s', path).
			replace('%3$s', encodeURIComponent($.param(params || window.sassParams))).
			replace('%4$d', window.wgStyleVersion);
	}

	/* @public */
	
	//process scripts injected via innerHTML which are not executed by default
	//this would run once again also the ones that where not added to the element
	//dynamically so use with care.
//	HTMLElement.prototype.executeScripts = function(){
//		var scripts = this.getElementsByTagName('script'),
//			x = 0,
//			y = scripts.length,
//			d = document,
//			h = d.head,
//			o,
//			s;
//
//		for(; x < y; x++){
//			o = scripts[x];
//			s = d.createElement('script');
//			s.innerText = o.innerText;
//			h.appendChild(s);
//			o.parentNode.removeChild(o);
//		}
//	}

	Wikia.getSassURL = function(rootURL, scssFilePath, params) {

		var url = processedSassUrls[scssFilePath];

		if(!url){
			//a regex check is faster than a useless function call, inform the caller he's doing it wrong ;)
			if(isProcessedSassUrl.test(scssFilePath))
				throw 'the specified path is already a valid SASS URL';

			url = processedSassUrls[scssFilePath] = rootURL + getAssetsManagerQuery(scssFilePath, 'sass', params);
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
			if(remaining == 0 && typeof callback == 'function')
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

			if(typeof resource == 'function'){
				resource.call($, onComplete);
			}else if(type == 'css' || isCss.test(resource) || isSass.test(resource)){
				$.getCSS(resource, onComplete);
			}else if(type == 'js' || isJs.test(resource)){
				$.getScript(resource, onComplete);
			}else{
				throw 'unknown resource format (' + resource + ')';
			}
		}
	};

	/**
	* Loads library file if it's not already loaded and fires callback
	*/
//	Wikia.loadLibrary = function(name, file, typeCheck, callback, failureFn) {
//		if (typeCheck === 'undefined'){
//			$.getScript(
//				file,
//				function() {
//					if (typeof callback == 'function') callback();
//				},
//				failureFn
//			);
//		}else
//			if(typeof callback == 'function') callback();
//	};

//	$.loadGoogleMaps = function(callback) {
//		window.onGoogleMapsLoaded = function() {
//			delete window.onGoogleMapsLoaded;
//			if (typeof callback === 'function') {
//				callback();
//			}
//		};
//
//		$.loadLibrary('GoogleMaps',
//			'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
//			typeof (window.google && google.maps),
//			function() {}
//		);
//	};

	Wikia.sendRequest = function(attr){
			var type = (attr.type && attr.type.toUpperCase()) || 'POST',
				format = (attr.format && attr.format.toLowerCase()) || 'json',
				formats = {'json':1, 'jsonp':1, 'html':1},
				data = attr.data || {},
				callback = attr.callback || function(){},
				onErrorCallback = attr.onErrorCallback || function(){},
				url = attr.scriptPath || wgScriptPath;

			if(!(attr.controller || attr.method))
				throw "controller and method are required";

			if(!(format in formats))
				throw "Only Json, Jsonp and Html format are allowed";

			$.ajax({
				url: url + '/wikia.php?' + $.param({
					//Iowa strips out POST parameters, Nirvana requires these to be set
					//so we're passing them in the GET part of the request
					controller: attr.controller,
					method: attr.method,
					format: format
				}),
				dataType: format,
				type: type,
				data: data,
				success: callback,
				error: onErrorCallback
			});
	};

	Wikia.param = function(params){
		var ret = [];
		if(params) {
			for(var param in params){
				if(params.hasOwnProperty(param)){
					ret.push(param + '=' + params[param]);
				}
			}
		}
		return ret.join('&');
	};


//		getJson: function(controller, method, data, callback, onErrorCallback){
//			Wikia.nirvana.sendRequest({
//				controller: controller,
//				method: method,
//				data: data,
//				type: 'GET',
//				callback: callback,
//				onErrorCallback: onErrorCallback
//			});
//		},
//
//		postJson: function(controller, method, data, callback, onErrorCallback){
//			Wikia.nirvana.sendRequest({
//				controller: controller,
//				method: method,
//				data: data,
//				callback: callback,
//				onErrorCallback: onErrorCallback
//			});
//		}
})(Wikia);
