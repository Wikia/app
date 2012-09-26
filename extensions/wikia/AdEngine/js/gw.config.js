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

	var selfDomain = location.protocol + '//' + location.host
		, scriptsDomain = window.wgCdnRootUrl
		, jQueryUrl = window.wgJqueryUrl[0]
		, documentWriteScript
		, checkHandler;

	// Save the original document.write method
	document.nativeWrite = document.write;

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
		if (tagName === 'script' && attrs.src) {
			if (attrs.src.indexOf(scriptsDomain) === 0
				|| attrs.src.indexOf(selfDomain) === 0
				|| attrs.src.indexOf(jQueryUrl) === 0
			) {
				documentWriteScript(attrs);
				return false;
			}
		}
		return true;
	};

	// If ads in head are enabled register check handler for ghostwriter
	if (window.wgLoadAdsInHead) {
		ghostwriter.handlers = ghostwriter.handlers || {};
		ghostwriter.handlers.check = checkHandler;
	}

}(window, document, location, ghostwriter));
