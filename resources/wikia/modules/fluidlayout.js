/**
 * Helper module defining the fluid layout properties.
 *
 * @author: Jacek 'mech' Wozniak <mech(at)wikia-inc.com>
 */

define('wikia.fluidlayout',  function() {
	'use strict';

	var WIDTH_OUTSIDE_MIN = 768,
		WIDTH_OUTSIDE_MAX = 1300,
		WIDTH_OUTSIDE = 1030,
		WIDTH_GUTTER = 20,
		ARTICLE_BORDER_WIDTH = 1,
		WIDTH_ADSKIN = 170,
		BREAKPOINT_SMALL = 1023,
		RIGHT_RAIL_WIDTH = 300;

	/**
	 * Public API method for getting the maximum width to which an article can be resized
	 *
	 * @return {number} Maximum article width in pixels
	 */
	function getMinArticleWidth() {
		return WIDTH_OUTSIDE_MIN;
	}

	/**
	 * Public API method for getting the minimum width of an article
	 *
	 * @return {number} Minimum article width in pixels
	 */
	function getMaxArticleWidth() {
		return WIDTH_OUTSIDE_MAX;
	}

	/**
	 * Public API method for getting the amount of padding or margin to separate elements in our layout.
	 *
	 * @return {number} Padding value in pixels
	 */
	function getWidthGutter() {
		return WIDTH_GUTTER;
	}

	/**
	 * Public API method for getting the article border size
	 *
	 * @returns {number} Border size in pixels
	 */
	function getArticleBorderWidth() {
		return ARTICLE_BORDER_WIDTH;
	}

	/**
	 * Public API method for getting the horizontal padding added to the elements in out layout.
	 *
	 * @returns {number} Padding width in pixels
	 */
	function getWidthPadding() {
		return WIDTH_GUTTER / 2;
	}

	/**
	 * Return the width breakpoint at which right rail is displayed
	 *
	 * @return {number} Breakpoint value in pixels
	 */
	function getBreakpointSmall() {
		return BREAKPOINT_SMALL;
	}

	/**
	 * Return the width breakpoint at which wiki background appears
	 *
	 * @return {number} Breakpoint value in pixels
	 */
	function getBreakpointContent() {
		return WIDTH_OUTSIDE;
	}

	/**
	 * Return the width breakpoint at which article content starts to stretch
	 *
	 * @return {number} Breakpoint value in pixels
	 */
	function getBreakpointFluid() {
		return WIDTH_OUTSIDE + 2 * WIDTH_ADSKIN;
	}

	/**
	 * Return the smallest breakpoint, which is at the same time the minimum supported width
	 *
	 * @return {number} Breakpoint value in pixels
	 */
	function getBreakpointMin() {
		return WIDTH_OUTSIDE_MIN;
	}

	/**
	 * Return the biggest breakpoint, after which everything is at its maximum width and we just start increasing the
	 * page borders
	 *
	 * @return {number} Breakpoint value in pixels
	 */
	function getBreakpointMax() {
		return WIDTH_OUTSIDE_MAX + 2 * WIDTH_ADSKIN;
	}

	/**
	 * Return the width of right rail
	 *
	 * @return {number} Right rail width in pixels
	 */
	function getRightRailWidth() {
		return RIGHT_RAIL_WIDTH;
	}

	/** @public **/
	return {
		getMinArticleWidth: getMinArticleWidth,
		getMaxArticleWidth: getMaxArticleWidth,
		getWidthGutter: getWidthGutter,
		getArticleBorderWidth: getArticleBorderWidth,
		getWidthPadding: getWidthPadding,
		getBreakpointSmall: getBreakpointSmall,
		getBreakpointContent: getBreakpointContent,
		getBreakpointFluid: getBreakpointFluid,
		getBreakpointMin: getBreakpointMin,
		getBreakpointMax: getBreakpointMax,
		getRightRailWidth: getRightRailWidth
	};

});
