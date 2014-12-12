require([
	'wikia.document', 'wikia.stickyElement', 'venus.layout'
], function(doc, stickyElement, layout) {
	'use strict';
	/*
	 * TODO: This file will/should be rafactored after beta release:
	 * https://wikia-inc.atlassian.net/browse/CON-2241
	 */

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100,
		$source = $(navigationElement),
		$target = $(boundBoxElement),
		$bottomTarget = $('main'),
		stickyElementObject = stickyElement.spawn(),
		adPoolerSelector = '#TOP_LEADERBOARD.standard-leaderboard,' +
			'#TOP_LEADERBOARD [data-gpt-creative-size], ' +
			'#TOP_LEADERBOARD [id^="Liftium_"]',
		adLogicPoolerCount = 0,
		adLogicLastHeight = 0,
		adLogicPoolerMaxCount = 50,
		adLogicPoolerTimeout = 250,
		adLogicPoolerDefaultLeaderboardHeight = 90,
		contentPadding,
		additionalSourceOffset,
		sourcePosition,
		sourceLimit,
		targetBottom;

	/**
	 * Pool for changed TOP_LEADERBOARD's height (can be very lazy-loaded)
	 */
	function adLoadPooler() {
		var $el = $(adPoolerSelector),
			height, size;

		if ($el.length === 0 && adLogicPoolerCount < adLogicPoolerMaxCount) {
			adLogicPoolerCount += 1;

			// absent, schedule another check
			setTimeout(adLoadPooler, adLogicPoolerTimeout);
		} else {
			// present, calculate height
			size = $el.data('gpt-creative-size'); // it returns array with [width, height]

			height = size ? size[1] : adLogicPoolerDefaultLeaderboardHeight;

			// update only if height differs
			if (height !== adLogicLastHeight) {
				adLogicLastHeight = height;
				stickyElementObject.updateSize();
			}
		}
	}
	$(adLoadPooler);

	// this function is needed for additional margin for screens >= 1024px
	// (because header is getting float: left on medium and higher breakpoints)
	function adjustValueFunction(value, type) {
		switch(type) {
			case 'topScrollLimit':
			case 'topSticked':
				if ($('.mw-content-text').css('clear') === 'none') {
					return value + $('.article-header').outerHeight(true);
				}
			/* falls through */
			default:
				return value;
		}
	}

	function adjustPositionFunction(scrollY) {
		contentPadding = parseInt( $target.css('padding-bottom'), 10);
		additionalSourceOffset = additionalTopOffset + globalNavigationHeight + contentPadding;
		sourcePosition = scrollY + additionalSourceOffset + $source.outerHeight(true);
		sourceLimit = $bottomTarget.offset().top + $bottomTarget.outerHeight(true);
		targetBottom = $bottomTarget.position().top +
			$bottomTarget.outerHeight(true) -
			$source.outerHeight(true);

		if (sourcePosition > sourceLimit) {
			stickyElementObject.sourceElementPosition('absolute', 'top', targetBottom - contentPadding);
			return true;
		} else {
			return false;
		}
	}

	// Sticky navigation
	stickyElementObject.init({
		sourceElement: navigationElement,
		alignToElement: boundBoxElement,
		topFixed: globalNavigationHeight + additionalTopOffset,
		minWidth: layout.breakpoints.smallMin,
		adjustFunc: adjustValueFunction,
		adjustPositionFunc: adjustPositionFunction
	});
});
