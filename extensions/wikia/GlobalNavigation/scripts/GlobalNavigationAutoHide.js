//This code is made for AB Test purposes and shouldn't be loaded by default
(function (win, $) {
	'use strict';

	var $globalNav = $('#globalNavigation'),
		$hubsEntryPoint = $('#hubsEntryPoint'),
		$accountNavigation = $('#AccountNavigation'),
		$searchInput = $('#searchInput'),
		animateObj = {},
		navHeight = 57,
		navVisible = navHeight,
		isUsed,
		isVenus = $('body').hasClass('skin-venus'),
		cssAttr = isVenus ? 'top' : 'marginTop',
		cssStartingValue = isVenus ? 0 : -navHeight,
		previousScrollTop = win.scrollY,
		currentState,
		scrollDelta,
		scrollDown,
		scrollValue;


	function globalNavScroll() {
		currentState = win.scrollY;
		scrollValue = currentState - previousScrollTop;
		scrollDown = scrollValue > 0;
		scrollDelta = Math.abs(scrollValue);
		isUsed = $hubsEntryPoint.hasClass('active') ||
			$accountNavigation.hasClass('active') ||
			$searchInput.is(':focus');

		//Only do something when scroll is bigger than 5px
		//Some random threshold might be adjust later
		if (!isUsed && scrollDelta > 5) {
			//If scroll down
			if (scrollDown) {
				if (scrollDelta > navHeight || navVisible - scrollDelta < 0) {
					animateObj[cssAttr] = cssStartingValue - navHeight;
					$globalNav.animate(animateObj, 100, 'linear');
					navVisible = 0;
				} else {
					animateObj[cssAttr] -= scrollDelta;
					$globalNav.animate(animateObj, 100, 'linear');
					navVisible = navVisible - scrollDelta;
				}
				//If scroll up
			} else {
				if (scrollDelta > navHeight || navVisible + scrollDelta >= 57) {
					animateObj[cssAttr] = cssStartingValue;
					$globalNav.animate(animateObj, 100, 'linear');
					navVisible = navHeight;
				} else {
					animateObj[cssAttr] += scrollDelta;
					$globalNav.animate(animateObj, 100, 'linear');
					navVisible = navVisible + scrollDelta;
				}
			}
		}
		previousScrollTop = currentState;
	}

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
	$(win).on('scroll', throttle(globalNavScroll, 100));
})(window, jQuery);
