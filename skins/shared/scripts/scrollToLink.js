/*
 * @define wikia.scrollToLink
 * module used to handle links inside the article (eg. #link)
 *
 * @author Bartosz 'V.' Bentkowski
 */

define('wikia.scrollToLink', ['jquery'], function($) {
	'use strict';
	var offsetToScroll, init, handleLinkTo, getOffsetTop, pushIntoHistory, validateHref;

	/**
	 * Initialize module - handle window load and hook into links.
	 *
	 * @param {Numeric} offset to subtract from target's offset
	 * @return {String}
	 */
	init = function(offset) {
		offsetToScroll = offset;

		handleLinkTo(window.location.hash);

		// we need to use jquery here, because it handles events differently than vanilla
		$('body').on('click', 'a', function(event){
			if (handleLinkTo(this.getAttribute('href'))) {
				event.preventDefault();
			}
		});
	};

	/**
	 * Get top offset of element
	 *
	 * @param {Object} element
	 * @return {Numeric}
	 */
	getOffsetTop = function(element) {
		return parseInt(element.getBoundingClientRect().top + window.pageYOffset - document.documentElement.clientTop, 10);
	};

	/**
	 * Normalize HREF (if it's in proper format) or return empty string
	 *
	 * @param {String} href to normalize
	 * @return {String}
	 */
	validateHref = function(href) {
		return (href.indexOf("#") === 0 && href.length > 1) ? href.slice(1) : '';
	};


	/**
	 * Handler for HREFs
	 *
	 * @param {String} href that we want to handle
	 * @return {Bool}
	 */
	handleLinkTo = function(href) {
		if(!!(href = validateHref(href))) {
			var target = document.getElementById(href),
				targetOffset;

			if (!!target) {
				targetOffset = getOffsetTop(target);

				// we need to use jquery here, because we want smooth and working universal animation (scroll up/down)
				$('html, body').animate({ scrollTop: targetOffset - offsetToScroll });
				if (pushIntoHistory({}, document.title, window.location.pathname + '#' + href)) {
					return true;
				}
			}
		}
		return false;
	};


	/**
	 * Push into history (if possible) and return proper state
	 *
	 * @param {object} state
	 * @param {String} title
	 * @param {String} url
	 * @return {Bool}
	 */
	pushIntoHistory = function(state, title, url) {
		if(history && "pushState" in history) {
			history.pushState(state, title, url);
			return true;
		}
		return false;
	};

	// return interface
	return {
		init: init
	};
});
