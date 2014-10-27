define('GlobalNavigationiOSScrollFix', ['jquery', 'wikia.window'], function($, win) {
	'use strict';
	var cachedScrollY;

	/**
	 * Scroll window to top
	 * @param {jQuery} $element - jQuery object on which new class should be added
	 */
	function scrollToTop($element) {
		cachedScrollY = win.scrollY;
		$element.addClass('position-static');

		// SetTimeout is needed for iOS7 and iOS6
		// in order to wait for keyboard to appear before starting to scroll
		setTimeout(function () {
			win.scrollTo(win.scrollX, 0);
		}, 0);
	}

	/**
	 * Restore scrollY to position cached inside cachedScrollY var
	 * @param {jQuery} $element - jQuery object from which new class should be removed
	 */
	function restoreScrollY($element) {
		$element.removeClass('position-static');

		if (cachedScrollY) {
			win.scrollTo(win.scrollX, cachedScrollY);
		}
	}

	return {
		scrollToTop: scrollToTop,
		restoreScrollY: restoreScrollY
	};
});
