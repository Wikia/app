/*
 * @define wikia.scrollToLink
 * module used to handle links inside the article (eg. #link)
 *
 * @author Bartosz 'V.' Bentkowski
 */

define('wikia.scrollToLink',
	['wikia.window', 'wikia.querystring', 'wikia.history', 'jquery'],
	function(win, qs, hist, $) {
		'use strict';

		/**
		 * @desc Get top offset of element
		 * @param {Object} element
		 * @return {Number} rounded down top offset of element
		 */
		function getOffsetTop(element) {
			var offsetTop = $(element).offset().top;

			return offsetTop | 0; // floor, because it can be a float number
		}

		/**
		 * @desc Scroll screen to given element
		 * @param {Element} element
		 * @param {Number} offsetToScroll
		 */
		function scrollToElement(element, offsetToScroll) {
			var targetOffset = getOffsetTop(element);

			win.setTimeout(function(){ win.scrollTo(win.pageXOffset, targetOffset + offsetToScroll); }, 1);
		}

		/**
		 * @desc Handler for HREFs
		 * @param {String} href that we want to handle
		 * @param {Number} offsetToScroll that's added to target's offsetTop
		 * @return {Boolean}
		 */
		function handleScrollTo(href, offsetToScroll) {
			offsetToScroll = offsetToScroll || 0;

			var sanitizedHref = qs().sanitizeHref(href),
				doc = win.document,
				target;

			if (!!sanitizedHref) {
				// as IDs can have dots inside, we can't call $(sanitizedHref) here
				target = doc.getElementById(sanitizedHref);

				if (!!target) {
					scrollToElement(target, offsetToScroll);

					return hist.pushState({}, doc.title, win.location.pathname + '#' + sanitizedHref);
				}
			}
			return false;
		}

		// return API
		return {
			handleScrollTo: handleScrollTo,
			scrollToElement: scrollToElement
		};
});
