/*global require*/
require(
	['wikia.scrollToLink', 'wikia.window', 'jquery', 'wikia.browserDetect'],
	function(scrollToLink, win, $, browserDetect) {
		'use strict';
		var offset = 0;

		/**
		 * @desc handler for hashchange event
		 * @param {Event} event
		 */
		function hashChangeHandler(event) {
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
				$globalNavigation = $('#globalNavigation'),
				globalNavigationHeight = $globalNavigation.height();

			//If location contains hash hide global navigation when page loads.
			//top:0 hides global navigation because it has "margin-top:-47px".
			if (win.location.hash) {
				$globalNavigation.css({
					top: -1 * globalNavigationHeight
				});

				$win.on('load', function() {
					win.setTimeout(function() {
						win.scrollTo(0, win.scrollY + offset);
						$globalNavigation.animate({top: 0}, 500);
					}, 0);
				});
			}

			// offset is negative - we want scroll BEFORE element's top offset
			// also scroll a bit, so element won't be sticked to GlobalNavigation
			offset = -(globalNavigationHeight + spacingBelowGlobalNav);

			$win.on('hashchange', hashChangeHandler);
		});
});
