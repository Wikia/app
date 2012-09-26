/**
 * Make sure scripts from local domains are loaded using regular
 * document.write, not ghostwriter's replacement.
 *
 * This is needed to force synchronization our scripts need.
 *
 * Right now, we only need this hack if ads are loaded in <head>,
 * but it should be safe to enable this "hack" globally
 */

(function(window, document, location, ghostwriter) {
	'use strict';

	var documentWriteScript
		, checkHandler
		, shouldUseNativeWrite;

	// Save the original document.write method
	document.nativeWrite = document.write;

	// Decide whether the script should be written natively (return true)
	// or can be safely handled by ghostwriter (return false)
	shouldUseNativeWrite = function(src) {
		var i;

		if (src.indexOf(location.protocol + '//' + location.host) === 0 // the same host
			|| src.indexOf(window.wgCdnRootUrl) === 0                   // regular script location
			|| src.indexOf('http://images.wikia.com/') === 0            // legacy script location
		) {
			return true;
		}

		// What's inside wgJqueryUrl should also be written natively
		if (window.wgJqueryUrl) {
			for (i = 0; i < window.wgJqueryUrl.length; i += 1) {
				if (src.indexOf(window.wgJqueryUrl[i]) === 0) {
					return true;
				}
			}
		}

		// External scripts should not block
		return false;
	};

	// Natively document.write script tag with given attrs
	documentWriteScript = function(attrs) {
		var name
			, html = '<script';

		for (name in attrs) {
			if (attrs.hasOwnProperty(name)) {
				html += ' ' + name + '="' + attrs[name] + '"';
			}
		}
		html += '><\/script>';
		document.nativeWrite(html);
	};

	// If script is ours, load it natively using documentWriteScript
	// and return false, otherwise return true
	checkHandler = function(tagName, attrs) {
		if (tagName === 'script' && attrs.src && shouldUseNativeWrite(attrs.src)) {
			documentWriteScript(attrs);
			return false;
		}
		return true;
	};

	// If ads in head are enabled register check handler for ghostwriter
	if (window.wgLoadAdsInHead) {
		ghostwriter.handlers = ghostwriter.handlers || {};
		ghostwriter.handlers.check = checkHandler;
	}

}(window, document, location, ghostwriter));
