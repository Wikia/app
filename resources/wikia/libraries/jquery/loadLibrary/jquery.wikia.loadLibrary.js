/**
 * Loads library file if it's not already loaded and fires callback
 *
 * For "internal" use only. Please use $.loadFooBar() functions in extension code.
 */
$.loadLibrary = function (name, files, typeCheck, callback, failureFn) {
	'use strict';

	var dfd = new jQuery.Deferred();

	if (typeCheck === 'undefined') {
		$().log('loading ' + name, 'loadLibrary');

		// cast single string to an array
		files = (typeof files === 'string') ? [files] : files;

		$.getResources(files, function () {
			$().log(name + ' loaded', 'loadLibrary');

			if (typeof callback === 'function') {
				callback();
			}
		},failureFn).
			// implement promise pattern
			then(function () {
				dfd.resolve();
			}).
			fail(function () {
				dfd.reject();
			});
	} else {
		$().log(name + ' already loaded', 'loadLibrary');

		if (typeof callback === 'function') {
			callback();
		}

		dfd.resolve();
	}

	return dfd.promise();
};

/**
 * Libraries loader functions follows
 */

// load YUI using ResourceLoader
$.loadYUI = function (callback) {
	'use strict';
    return mw.loader.use('wikia.yui').done(callback);
};

// jquery.wikia.modal.js in now a part of AssetsManager package
// @deprecated no need to lazy load it
$.loadModalJS = function (callback) {
	'use strict';
	if (typeof callback === 'function') {
		callback();
	}
};

// load various jQuery libraries (if not yet loaded)
$.loadJQueryUI = function (callback) {
	'use strict';
	return mw.loader.use('wikia.jquery.ui').done(callback);
};

// autocomplete plugin - not to be confused autocomplete feature of jQuery UI
// @deprecated use $.ui.autocomplete
$.loadJQueryAutocomplete = function (callback) {
	'use strict';
	return mw.loader.use('jquery.autocomplete').done(callback);
};

$.loadJQueryAIM = function (callback) {
	'use strict';
	return mw.loader.use('wikia.aim').done(callback);
};

$.loadMustache = function (callback) {
	'use strict';
	return mw.loader.use('jquery.mustache').done(callback);
};

$.loadHandlebars = function (callback) {
	'use strict';
	return mw.loader.use('wikia.handlebars').done(callback);
};

$.loadGoogleMaps = function (callback) {
	'use strict';
	var dfd = new jQuery.Deferred(),
		onLoaded = function () {
			if (typeof callback === 'function') {
				callback();
			}
			dfd.resolve();
		};

	// Google Maps API is loaded
	if (typeof (window.google && window.google.maps) !== 'undefined') {
		onLoaded();
	} else {
		window.onGoogleMapsLoaded = function () {
			delete window.onGoogleMapsLoaded;
			onLoaded();
		};

		// load GoogleMaps main JS and provide a name of the callback to be called when API is fully initialized
		$.loadLibrary('GoogleMaps',
			[{
				url: 'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
				type: 'js'
			}],
			typeof (window.google && window.google.maps)
		).
		// error handling
		fail(function () {
			dfd.reject();
		});
	}

	return dfd.promise();
};

/**
 * Load the facebook JS library, either v1.x or v2.x
 * @param {function} callback Function to be called after library is loaded
 * @returns {jQuery} Returns a jQuery promise
 */
$.loadFacebookAPI = function (callback) {
	'use strict';

	if (window.wgEnableFacebookClientExt) {
		// v2.x functionality
		window.fbAsyncInit = function () {
			window.FB.init({
				appId: window.fbAppId,
				xfbml: true,
				cookie: true,
				version: 'v2.1'
			});
		};

		return $.loadLibrary('Facebook API',
			window.fbScript || '//connect.facebook.net/en_US/sdk.js',
			typeof window.FB,
			function () {
				if (typeof callback === 'function') {
					callback();
				}
			}
		);
	} else {
		// v1.x functionality
		return $.loadLibrary('Facebook API',
			window.fbScript || '//connect.facebook.net/en_US/all.js',
			typeof window.FB,
			function () {
				// always initialize FB API when SDK is loaded on-demand
				if (window.onFBloaded) {
					window.onFBloaded();
				}

				callback();
			}
		);
	}
};

/**
 * Load the facebook API on every page until the upgrade to v2.x is stable and parser cache has cleared.
 * Needed for XFBML tags to render with stale parser cache.
 * DO NOT rely on this library always being loaded.
 * Estimated removal date: Nov. 27 2014
 */
$($.loadFacebookAPI);

$.loadGooglePlusAPI = function (callback) {
	'use strict';
	return $.loadLibrary('Google Plus API',
		'//apis.google.com/js/plusone.js',
		typeof (window.gapi && window.gapi.plusone),
		callback
	);
};

$.loadTwitterAPI = function (callback) {
	'use strict';
	return $.loadLibrary('Twitter API',
		'//platform.twitter.com/widgets.js',
		typeof (window.twttr && window.twttr.widgets),
		callback
	);
};
