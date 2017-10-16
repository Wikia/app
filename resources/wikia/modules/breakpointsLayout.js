define('wikia.breakpointsLayout',  function() {
	'use strict';

	var WIDTH_OUTSIDE_MIN = 768,
		CONTENT_BORDER = 1,
		BREAKPOINT_LARGE_CONTENT_WIDTH = 1238,
		BREAKPOINT_LARGE_PADDING_WIDTH = 30,
		BREAKPOINT_MEDIUM_CONTENT_WIDTH = 1064,
		BREAKPOINT_MEDIUM_PADDING_WIDTH = 20,
		BREAKPOINT_MIN_CONTENT_WIDTH = 768,
		BREAKPOINT_MIN_PADDING_WIDTH = 24,
		RIGHT_RAIL_WIDTH_PLUS_SPACING = 320;

	/**
	 * @param {boolean} isWidePage
	 * @returns {number}
	 */
	function getArticleContentMaxWidth(isWidePage) {
		var articleWidth = BREAKPOINT_LARGE_CONTENT_WIDTH - 2 * BREAKPOINT_LARGE_PADDING_WIDTH;
		return isWidePage ? articleWidth : articleWidth - RIGHT_RAIL_WIDTH_PLUS_SPACING;
	}

	/**
	 * @param {boolean} isWidePage
	 * @returns {number}
	 */
	function getArticleContentMediumWidth(isWidePage) {
		var articleWidth = BREAKPOINT_MEDIUM_CONTENT_WIDTH - 2 * BREAKPOINT_MEDIUM_PADDING_WIDTH;
		return isWidePage ? articleWidth : articleWidth - RIGHT_RAIL_WIDTH_PLUS_SPACING;
	}

	/**
	 * @returns {number}
	 */
	function getArticleContentMinWidth() {
		return BREAKPOINT_MIN_CONTENT_WIDTH - 2 * (BREAKPOINT_MIN_PADDING_WIDTH + CONTENT_BORDER);
	}

	/**
	 * @returns {number}
	 */
	function getArticlePadding() {
		return BREAKPOINT_MEDIUM_PADDING_WIDTH;
	}

	/**
	 * @returns {number}
	 */
	function getRailWidthWithSpacing() {
		return RIGHT_RAIL_WIDTH_PLUS_SPACING;
	}

	/**
	 * @returns {number}
	 */
	function getLargeContentWidth() {
		return BREAKPOINT_LARGE_CONTENT_WIDTH;
	}

	/**
	 *
	 * @param {string} breakpoint
	 * @param {boolean} isWidePage
	 * @returns {number}
	 */
	function getArticleWidth(breakpoint, isWidePage) {
		switch(breakpoint) {
			case 'current':
				return getArticleContentMediumWidth(isWidePage);
			case 'max':
				return getArticleContentMaxWidth(isWidePage);
			case 'min':
				return getArticleContentMinWidth();
			default:
				//Return medium for default because it's the most used scenario
				return getArticleContentMinWidth();
		}
	}

	/**
	 * @return {number}
	 */
	function getArticleMinWidth() {
		return WIDTH_OUTSIDE_MIN;
	}


	return {
		getArticleMinWidth: getArticleMinWidth,
		getArticlePadding: getArticlePadding,
		getArticleWidth: getArticleWidth,
		getLargeContentWidth: getLargeContentWidth,
		getRailWidthWithSpacing: getRailWidthWithSpacing
	};

});
