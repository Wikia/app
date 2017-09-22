/*global require*/
require(
	['wikia.scrollToLink', 'wikia.window', 'jquery', 'wikia.browserDetect'],
	function(scrollToLink, win, $, browserDetect) {
		'use strict';
		var offset = 0;

		/**
		 * @desc scroll to anchor
		 * @param {Event} event
		 */
		function scrollToAnchor(event) {
			if (scrollToLink.handleScrollTo(win.location.hash, offset) || browserDetect.isIOS7orLower()) {
				// prevent only if we managed to scroll to desired ID
				event.preventDefault();
				return false;
			}
		}

		/**
		 * @desc Function for third party extensions - bleed it to window
		 * @param {Element} element
		 */
		win.GlobalNavigationScrollToElement = function(element) {
			scrollToLink.scrollToElement(element, offset);
		};


		$(function() {
			var $win = $(win),
				spacingBelowGlobalNav = 10,
				globalNavigationHeight = $('#globalNavigation').outerHeight(true);

			// offset is negative - we want scroll BEFORE element's top offset
			// also scroll a bit, so element won't be stuck to GlobalNavigation
			offset = -(globalNavigationHeight + spacingBelowGlobalNav);

			$win.on('hashchange load', scrollToAnchor);
		});
	});
