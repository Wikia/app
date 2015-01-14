(function ($) {
	'use strict';

	/**
	 * Loads library file if it's not already loaded and fires callback
	 *
	 * For "internal" use only. Please use $.loadFooBar() functions in extension code.
	 */
	$.loadLibrary = function (name, files, typeCheck, callback, failureFn) {
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
				}, failureFn).
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
		return mw.loader.use('wikia.yui').done(callback);
	};

	// jquery.wikia.modal.js in now a part of AssetsManager package
	// @deprecated no need to lazy load it
	$.loadModalJS = function (callback) {
		if (typeof callback === 'function') {
			callback();
		}
	};

	// load various jQuery libraries (if not yet loaded)
	$.loadJQueryUI = function (callback) {
		return mw.loader.use('wikia.jquery.ui').done(callback);
	};

	// autocomplete plugin - not to be confused autocomplete feature of jQuery UI
	// @deprecated use $.ui.autocomplete
	$.loadJQueryAutocomplete = function (callback) {
		return mw.loader.use('jquery.autocomplete').done(callback);
	};

	$.loadJQueryAIM = function (callback) {
		return mw.loader.use('wikia.aim').done(callback);
	};

	$.loadMustache = function (callback) {
		return mw.loader.use('jquery.mustache').done(callback);
	};

	$.loadHandlebars = function (callback) {
		return mw.loader.use('wikia.handlebars').done(callback);
	};

	$.loadGoogleMaps = function (callback) {
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
			$.loadLibrary(
				'GoogleMaps',
				[{
					url: 'http://maps.googleapis.com/maps/api/js?sensor=false&callback=onGoogleMapsLoaded',
					type: 'js'
				}],
				typeof (window.google && window.google.maps)
			).
				fail(function () {
					dfd.reject();
				});
		}

		return dfd.promise();
	};

	/**
	 * Load the facebook JS library v2.x
	 * @returns {jQuery} Returns a jQuery promise
	 * @see https://developers.facebook.com/docs/javascript/quickstart/v2.2
	 */
	$.loadFacebookAPI = function () {
		// create our own deferred object to resolve after FB.init finishes
		var $deferred = $.Deferred();

		// This is invoked by Facebook once the SDK is loaded.
		window.fbAsyncInit = function () {
			window.FB.init({
				appId: window.fbAppId,
				xfbml: true,
				cookie: true,
				version: 'v2.1'
			});
			$deferred.resolve();
		};

		// originally adopted from facebook's developer pages but modified for clarity
		(function (document) {
			var fbScriptTag,
				firstScriptTag = document.getElementsByTagName('script')[0],
				id = 'facebook-jssdk';

			if (document.getElementById(id)) {
				if (window.FB) {
					$deferred.resolve();
				} else {
					$deferred.reject();
				}
				return;
			}

			fbScriptTag = document.createElement('script');
			fbScriptTag.id = id;
			fbScriptTag.src = window.fbScript || '//connect.facebook.net/en_US/sdk.js';
			fbScriptTag.onerror = function () {
				$deferred.reject();
			};
			firstScriptTag.parentNode.insertBefore(fbScriptTag, firstScriptTag);
		})(document);

		return $deferred;
	};

	$.loadGooglePlusAPI = function (callback) {
		return $.loadLibrary('Google Plus API',
			'//apis.google.com/js/plusone.js',
			typeof (window.gapi && window.gapi.plusone),
			callback
		);
	};

	$.loadTwitterAPI = function (callback) {
		return $.loadLibrary('Twitter API',
			'//platform.twitter.com/widgets.js',
			typeof (window.twttr && window.twttr.widgets),
			callback
		);
	};

})(jQuery);
