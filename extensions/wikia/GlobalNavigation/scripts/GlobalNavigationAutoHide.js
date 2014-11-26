/**
 * This script is created for the purpose of Global Navigation AB testing only
 *
 * It should be treated as a prototype.
 */
(function (win, $) {
	'use strict';

	var $globalNav = $('#globalNavigation'),
		$hubsEntryPoint = $('#hubsEntryPoint'),
		$accountNavigation = $('#AccountNavigation'),
		$searchInput = $('#searchInput'),
		previousScrollTop = window.scrollY;

	/**
	 * @desc hides / shows global nav shile scrolling up and down
	 */
	function globalNavScroll() {
		var state = window.scrollY,
			isUsed = $hubsEntryPoint.hasClass('active') ||
				$accountNavigation.hasClass('active') ||
				$searchInput.is(':focus');

		console.log(isUsed);

		if (state > previousScrollTop && previousScrollTop > 0 && !isUsed) {
			$globalNav.animate({top: '-57px'}, 250);
		} else {
			$globalNav.animate({top: '0'}, 250);
		}

		previousScrollTop = state;
	}

	/**
	 * @desc simple throttle implementation
	 * @param {Function} fn - function to be throttled
	 * @param {Number} threshold - delay in ms
	 * @returns {Function}
	 */
	function throttle(fn, threshold) {
		var last, deferTimer;

		return function () {
			var self = this,
				now = +new Date(),
				args = arguments;

			if (last && now < last + threshold) {
				win.clearTimeout(deferTimer);

				deferTimer = win.setTimeout(function () {
					last = now;
					fn.apply(self, args);
				}, threshold);
			} else {
				last = now;
				fn.apply(self, args);
			}
		};
	}

	$(win).on('scroll', throttle(globalNavScroll, 250));

})(window, jQuery);
