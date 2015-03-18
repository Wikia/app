(function ($) {
	'use strict';

	/**
	 * Generic loading for external JS libraries, including success and failure handling
	 * Originally adopted from facebook's developer pages but modified for reuse
	 * @param {string} name Name of the library being loaded (used for logging)
	 * @param {string} url URL of library file to be loaded
	 * @param {*} typeCheck Expression to check if library is already loaded
	 * @returns {jQuery} Returns a jQuery deferred object
	 */
	$.loadExternalLibrary = function (name, url, typeCheck) {
		var scriptTag,
			firstScriptTag,
			$deferred = $.Deferred();

		if (typeCheck === 'undefined') {
			firstScriptTag = document.getElementsByTagName('script')[0];
			scriptTag = document.createElement('script');

			scriptTag.src = url;
			scriptTag.onload = function () {
				$deferred.resolve();
			};
			scriptTag.onerror = function () {
				$deferred.reject();
			};

			firstScriptTag.parentNode.insertBefore(scriptTag, firstScriptTag);
		} else {
			Wikia.log(
				name + ' already loaded',
				Wikia.log.levels.feedback,
				'loadExternalLibrary'
			);
			$deferred.resolve();
		}

		return $deferred;
	};

	/**
	 * Load the facebook JS library v2.x
	 * @param {function} [callback] (Deprecated) Function to be executed when library is loaded.
	 * Prefer using the returned deferred object.
	 * @returns {jQuery} Returns a jQuery promise
	 * @see https://developers.facebook.com/docs/javascript/quickstart/v2.2
	 */
	$.loadFacebookSDK = function (callback) {
		// create our own deferred object to resolve after FB.init finishes
		var $deferred = $.Deferred(),
			url = window.fbScript || '//connect.facebook.net/en_US/sdk.js';

		// ShareButton code still uses the callback, but it's deprecated.
		if (typeof callback === 'function') {
			$deferred.done(callback);
		}

		// If the FB SDK successfully loads, show the fb login button
		$deferred.done(function () {
			$('.sso-login').removeClass('hidden');
		});

		if (typeof window.FB === 'object') {
			// Since we have our own deferred object, we need to resolve it if FB is already loaded.
			// We can't rely on the type check inside $.loadExternalLibrary.
			$deferred.resolve();
		} else {
			// This is invoked by Facebook once the SDK is loaded.
			window.fbAsyncInit = function () {
				window.FB.init({
					appId: window.fbAppId,
					cookie: true,
					version: 'v2.1'
				});

				// resolve after FB has finished inititalizing
				$deferred.resolve();
			};

			$.when($.loadExternalLibrary('FacebookSDK', url, typeof window.FB))
				.fail(function () {
					$deferred.reject();
				});
		}

		return $deferred;
	};

	$.loadReCaptcha = function () {
		var url = 'https://www.google.com/recaptcha/api.js?hl=' + window.wgUserLanguage;
		return $.loadExternalLibrary('ReCaptcha', url, typeof window.grecaptcha);
	};

})(jQuery);
