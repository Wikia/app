/*
 * @define wikia.scrollToLink
 * module used to handle links inside the article (eg. #link)
 *
 * @author Bartosz 'V.' Bentkowski
 */

define('wikia.scrollToLink', ['wikia.window'], function(window) {
	'use strict';

	/**
	 * Get top offset of element
	 *
	 * @param {Object} element
	 * @return {Number}
	 */
	function getOffsetTop (element) {
		return (element.getBoundingClientRect().top +
			window.pageYOffset -
			window.document.documentElement.clientTop) | 0;
	}

	/**
	 * Sanitize HREF (if it's in proper format) or return empty string
	 *
	 * @param {String} href to sanitize
	 * @return {String}
	 */
	function sanitizeHref (href) {
		return (href.indexOf("#") === 0 && href.length > 1) ? href.slice(1) : '';
	}


	/**
	 * Handler for HREFs
	 *
	 * @param {String} href that we want to handle
	 * @param {Number} offsetToScroll
	 * @return {Bool}
	 */
	function handleLinkTo (href, offsetToScroll) {
		var sanitizedHref = sanitizeHref(href), target, targetOffset;

		if(!!sanitizedHref) {
			target = document.getElementById(sanitizedHref);

			if (!!target) {
				targetOffset = getOffsetTop(target);
				window.scrollTo(0, targetOffset - (offsetToScroll || 0));
				return (pushIntoHistory({}, document.title, window.location.pathname + href));
			}
		}
		return false;
	}


	/**
	 * Push into history (if possible) and return proper state
	 *
	 * @param {Object} state
	 * @param {String} title
	 * @param {String} url
	 * @return {Bool}
	 */
	function pushIntoHistory (state, title, url) {
		if(history && "pushState" in history) {
			history.pushState(state, title, url);
			return true;
		}
		return false;
	}

	// return interface
	return {
		handleLinkTo: handleLinkTo
	};
});
