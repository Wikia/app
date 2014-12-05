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
		isVenus = win.skin === 'venus',
		cssAttr = isVenus ? 'top' : 'marginTop',
		cssStartingValue = isVenus ? 0 : -navHeight,
		previousScrollTop = win.pageYOffset,
		currentState,
		scrollDelta,
		scrollDown,
		scrollValue;


	function globalNavScrollNoTouch() {
		currentState = win.pageYOffset;
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

	function globalNavScrollTouch() {
		currentState = win.pageYOffset;
		isUsed = $hubsEntryPoint.hasClass('active') ||
			$accountNavigation.hasClass('active') ||
			$searchInput.is(':focus');
		if (!isUsed && Math.abs(currentState - previousScrollTop) > 10) {
			if (currentState > previousScrollTop && previousScrollTop > 0) {
				animateObj[cssAttr] = cssStartingValue - navHeight;
				$globalNav.animate(animateObj, 100);
			} else {
				animateObj[cssAttr] = cssStartingValue;
				$globalNav.animate(animateObj, 100);
			}
			previousScrollTop = currentState;
		}
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

	function showAllNav() {
		animateObj[cssAttr] += navHeight - navVisible;
		$globalNav.animate(animateObj, 100, 'linear');
		navVisible = navHeight;
	}

	$globalNav.on('hubs-menu-opened', showAllNav);
	$globalNav.on('user-login-menu-opened', showAllNav);
	$searchInput.on('focus', showAllNav);
	if ('ontouchstart' in win) {
		$(win).on('scroll', throttle(globalNavScrollTouch, 100));
	} else {
		$(win).on('scroll', throttle(globalNavScrollNoTouch, 100));
	}
})(window, jQuery);
