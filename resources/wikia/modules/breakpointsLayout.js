define('wikia.breakpointsLayout',  function() {
	'use strict';

	var WIDTH_OUTSIDE_MIN = 768,
		CONTENT_BORDER = 1,
		BREAKPOINT_LARGE_CONTENT_WIDTH = 1238,
		BREAKPOINT_LARGE_PADDING_WIDTH = 30,
		BREAKPOINT_MEDIUM_CONTENT_WIDTH = 1024,
		BREAKPOINT_MEDIUM_PADDING_WIDTH = 20,
		BREAKPOINT_MIN_CONTENT_WIDTH = 768,
		BREAKPOINT_MIN_PADDING_WIDTH = 24,
		RIGHT_RAIL_WIDTH_PLUS_SPACING = 320;

	function getArticleContentMaxWidth(isWidePage) {
		var articleWidth = BREAKPOINT_LARGE_CONTENT_WIDTH - 2 * BREAKPOINT_LARGE_PADDING_WIDTH;
		return isWidePage ? articleWidth : articleWidth - RIGHT_RAIL_WIDTH_PLUS_SPACING;
	}
	function getArticleContentMediumWidth(isWidePage) {
		var articleWidth = BREAKPOINT_MEDIUM_CONTENT_WIDTH - 2 * BREAKPOINT_MEDIUM_PADDING_WIDTH;
		return isWidePage ? articleWidth : articleWidth - RIGHT_RAIL_WIDTH_PLUS_SPACING;
	}

	function getArticleContentMinWidth() {
		return BREAKPOINT_MIN_CONTENT_WIDTH - 2 * (BREAKPOINT_MIN_PADDING_WIDTH + CONTENT_BORDER);
	}

	function getArticlePadding() {
		return BREAKPOINT_MEDIUM_PADDING_WIDTH;
	}

	function getArticleWidth(breakpoint, isWidePage) {
		var maxArticleWidth = getArticleContentMaxWidth(isWidePage),
			mediumArticleWidth = getArticleContentMediumWidth(isWidePage),
			minArticleWidth = getArticleContentMinWidth();

		switch(breakpoint) {
			case 'current':
				return mediumArticleWidth;
			case 'max':
				return maxArticleWidth;
			case 'min':
				return minArticleWidth;
			default:
				//Return medium for default because it's the most used scenario
				return mediumArticleWidth;
		}
	}

	/**
	 * Get minimum supported article width in pixels
	 *
	 * @return {number} Maximum article width in pixels
	 */
	function getArticleMinWidth() {
		return WIDTH_OUTSIDE_MIN;
	}


	return {
		getArticleWidth: getArticleWidth,
		getArticleMinWidth: getArticleMinWidth,
		getArticlePadding: getArticlePadding
	};

});
