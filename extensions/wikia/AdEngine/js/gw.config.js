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
		var i, srcDomain;

		// Check if script source is a full URL. If not it may be
		// a relative URL, so we'll use native write for it
		if (src.search(/^[a-z]+:\/\/[a-z0-9\.\-]+\//) === -1) {
			return true;
		}

		// For scripts matching CDN URL, use native write
		if (src.indexOf(window.wgCdnRootUrl) === 0) {
			return true;
		}

		// For scripts in current domain and for scripts in
		// wikia.com domain (resource loader on production)
		// use native write. This case also catches the
		// legacy domain for assets: images.wikia.com
		srcDomain = src.split('/')[2];
		if (srcDomain === location.host || srcDomain.search(/\.wikia\.com$/) !== -1) {
			return true;
		}

		// For scripts whose URLs are from wgJqueryUrl
		// use native document.write as well
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
		// Optional logging
		var logging = (location.search.indexOf('gwconfiglog=1') !== -1);

		if (logging) { window.console.log('gw.config.js: checkHandler: ', tagName, attrs); }

		if (tagName === 'script' && attrs.src && shouldUseNativeWrite(attrs.src)) {
			if (logging) { window.console.log('gw.config.js: checkHandler: natively writing script ' + attrs.src); }
			documentWriteScript(attrs);
			if (logging) { window.console.log('gw.config.js: checkHandler: end of ' + attrs.src); }
			return false;
		}

		if (logging) { window.console.log('gw.config.js: checkHandler: let GW write'); }
		return true;
	};

	// If ads in head are enabled register check handler for ghostwriter
	if (window.wgLoadAdsInHead) {
		ghostwriter.handlers = ghostwriter.handlers || {};
		ghostwriter.handlers.check = checkHandler;
	}

}(window, document, location, ghostwriter));
