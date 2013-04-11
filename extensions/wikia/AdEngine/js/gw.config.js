/**
 * Make sure scripts from local domains are loaded using regular
 * document.write, not ghostwriter's replacement.
 *
 * Also revert the default ghostwriter behavior of replacing the
 * regular document.write with a safeguard.
 *
 * This is needed to force the synchronization our scripts need.
 *
 * Right now, we only need this hack if ads are loaded in <head>,
 * but it should be safe to enable this "hack" globally.
 *
 * This file needs to be included right after ghostwriter's library.
 */

(function (window, document, location, ghostwriter, abTest) {
	'use strict';;

	// Save the original document.write method
	document.nativeWrite = document.write;

	// Decide whether the script should be written natively (return true)
	// or can be safely handled by ghostwriter (return false)
	function shouldUseNativeWrite(src) {
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
	}

	// Natively document.write script tag with given attrs
	function documentWriteTag(tagName, attrs) {
		var name,
			html = '<' + tagName;

		for (name in attrs) {
			if (attrs.hasOwnProperty(name)) {
				html += ' ' + name + '="' + attrs[name] + '"';
			}
		}
		html += '><\/' + tagName + '>';
		document.nativeWrite(html);
	}

	// If script is ours, load it natively using documentWriteTag
	// and return false, otherwise return true
	function checkHandler(tagName, attrs) {
		// Optional logging
		var logging = (location.search.indexOf('gwconfiglog=1') !== -1);

		if (logging) { window.console.log('gw.config.js: checkHandler: ', tagName, attrs); }

		if (tagName === 'script' && attrs.src && shouldUseNativeWrite(attrs.src)) {
			if (logging) { window.console.log('gw.config.js: checkHandler: natively writing script ' + attrs.src); }
			documentWriteTag('script', attrs);
			if (logging) { window.console.log('gw.config.js: checkHandler: end of ' + attrs.src); }
			return false;
		}

		if (tagName === 'div' && attrs['class'] === 'twtr-widget') {
			if (logging) { window.console.log('gw.config.js: checkHandler: natively writing twitter div'); }
			documentWriteTag('div', attrs);
			if (logging) { window.console.log('gw.config.js: checkHandler: end of twitter div'); }
			return false;
		}

		if (logging) { window.console.log('gw.config.js: checkHandler: let GW write'); }
		return true;
	}

	var useGw = !abTest.inGroup('GHOSTWRITER_VS_POSTSCRIBE', 'POSTSCRIBE');

	// If ads in head are enabled register check handler for ghostwriter
	if (useGw) {
		ghostwriter.handlers = ghostwriter.handlers || {};
		ghostwriter.handlers.check = checkHandler;

		// We need to reverse what happens in ghostwriter function setDocumentOverrides
		ghostwriter(document.documentElement, {
			done: function () {
				ghostwriter.flushloadhandlers();
			}
		}); // this initializes ghostwriter without doing much harm
		document.write = document.nativeWrite;
	}

}(window, document, location, ghostwriter, Wikia.AbTest));
