/*global jQuery, Wikia*/
(function ($) {
	'use strict';

	/**
	 * Generic loading for external JS libraries, including success and failure handling
	 * @param {string} name Name of the library being loaded (used for logging)
	 * @param {string} url URL of library file to be loaded
	 * @param {*} typeCheck Expression to check if library is already loaded
	 * @returns {jQuery} Returns a jQuery deferred object
	 */
	function loadExternalLibrary(name, url, typeCheck) {
		var $deferred = $.Deferred();

		if (window.wgNoExternals) {
			// Don't load external libraries if this flag is set. Mainly used for metrics.
			$deferred.reject();
		} else if (typeCheck === 'undefined') {
			addScriptToPage(url, $deferred);
		} else {
			Wikia.log(
				name + ' already loaded',
				Wikia.log.levels.feedback,
				'loadExternalLibrary'
			);
			$deferred.resolve();
		}

		return $deferred;
	}

	/**
	 * Load a library via script tag injection.
	 * Originally adopted from facebook's developer pages but modified for reuse
	 * Note that it relies on an arbitrary script tag already being in the DOM (which is always the case in our stack)
	 * @param {string} url Library resource
	 * @param {jQuery} $deferred Deferred object to be returned to callee. Passed by reference.
	 * @returns {jQuery}
	 */
	function addScriptToPage(url, $deferred) {
		var firstScriptTag = document.getElementsByTagName('script')[0],
			scriptTag = document.createElement('script');

		scriptTag.src = url;
		scriptTag.onload = function () {
			// update deferred object, which is passed by reference
			$deferred.resolve();
		};
		scriptTag.onerror = function () {
			// update deferred object, which is passed by reference
			$deferred.reject();
		};

		firstScriptTag.parentNode.insertBefore(scriptTag, firstScriptTag);
	}

	// public methods

	$.loadReCaptcha = function () {
		var url = 'https://www.google.com/recaptcha/api.js?hl=' + window.wgUserLanguage;
		return loadExternalLibrary('ReCaptcha', url, typeof window.grecaptcha);
	};

})(jQuery);
