/**
 * Helper module defining layout properties.
 *
 * @author: Jacek 'mech' Wozniak <mech(at)wikia-inc.com>
 */

define('wikia.layout',  function() {
	'use strict';

	var MIN_ARTICLE_WIDTH = 768,
		MAX_ARTICLE_WIDTH = 1300;

	/**
	 * Public API method for getting the maximum width to which an article can be resized
	 *
	 * @return {number} Maximum article width in pixels
	 */
	function getMinArticleWidth() {
		return MIN_ARTICLE_WIDTH;
	}

	/**
	 * Public API method for getting the minimum width of an article
	 *
	 * @return {number} Minimum article width in pixels
	 */
	function getMaxArticleWidth() {
		return MAX_ARTICLE_WIDTH;
	}

	/** @public **/

	return {
		getMinArticleWidth: getMinArticleWidth,
		getMaxArticleWidth: getMaxArticleWidth
	}

});
