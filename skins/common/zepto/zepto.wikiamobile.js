(function($){
	//TODO: split this library in different files: zepto.resources.js, zepto.loader.js, etc.
	//then use AssetsManager config to group them together
	$.getSassCommonURL = function( scssFilePath, params ) {
		return wgCdnRootUrl + wgAssetsManagerQuery.replace('%1$s', 'sass').replace('%4$d', wgStyleVersion).replace('%3$s', escape($.param(params ? params : sassParams))).replace('%2$s', scssFilePath);
	};

	$.getScript = function( resource, onComplete ) {
		var scriptElement = document.createElement( 'script' );
		scriptElement.src = resource;
		scriptElement.onload = onComplete;
		document.head.appendChild( scriptElement );
	};

	$.getResources = function( resources, callback ) {
		var isJs = /\.js(\?(.*))?$/,
			isCss = /\.css(\?(.*))?$/,
			isSass = /\.scss/,
			remaining = length = resources.length;

		var onComplete = function(){
			remaining--;

			// all files have been downloaded
			if(remaining == 0 && typeof callback == 'function')
				callback();
		};

		// download files
		for ( var n = 0; n < length; n++ ) {
			var resource = resources[n];
			if(typeof resource == 'function'){
				resource.call($, onComplete);
			}else if(isJs.test(resource)){
				$.getScript(resource, onComplete);
			}else if(isCss.test(resource)){
				$.getCSS(resource, onComplete);
			}else if(isSass.test(resource)){
				$.getCSS($.getSassCommonURL(resource), onComplete);
			}else{
				throw 'unknown resource format';
			}
		};
	};

	/**
	* Loads library file if it's not already loaded and fires callback
	*/
	$.loadLibrary = function(name, file, typeCheck, callback, failureFn) {
		if (typeCheck === 'undefined'){
			$.getScript(
				file,
				function() {
					if (typeof callback == 'function') callback();
				},
				failureFn
			);
		}else
			if(typeof callback == 'function') callback();
	};

	$.loadGoogleMaps = function(callback) {
		window.onGoogleMapsLoaded = function() {
			delete window.onGoogleMapsLoaded;
			if (typeof callback === 'function') {
				callback();
			}
		};

		$.loadLibrary('GoogleMaps',
			'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
			typeof (window.google && google.maps),
			function() {}
		);
	};

	$.nirvana = {
		sendRequest: function(attr){
			var type = (attr.type &&  attr.type.toUpperCase()) || 'POST',
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
		},

		getJson: function(controller, method, data, callback, onErrorCallback){
			$.nirvana.sendRequest({
				controller: controller,
				method: method,
				data: data,
				type: 'GET',
				format: 'json',
				callback: callback,
				onErrorCallback: onErrorCallback
			});
		},

		postJson: function(controller, method, data, callback, onErrorCallback){
			$.nirvana.sendRequest({
				controller: controller,
				method: method,
				data: data,
				type: 'POST',
				format: 'json',
				callback: callback,
				onErrorCallback: onErrorCallback
			});
		}
	};
})(Zepto);
