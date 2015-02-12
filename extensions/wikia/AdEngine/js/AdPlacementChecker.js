/*global define*/
define('ext.wikia.adEngine.adPlacementChecker', ['jquery', 'wikia.log'], function ($, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adPlacementChecker';

	function canReflow($el) {
		var ret = $el.css('display') === 'block' &&
			$el.css('float') === 'none' &&
			$el.css('overflow') === 'visible';

		log(['canReflow', $el, ret], 'debug', logGroup);

		return ret;
	}

	/**
	 * Check if the ad fits in the content
	 *
	 * @param {String} adHtml       HTML to inject
	 * @param {Element} container   Container to check for height difference
	 * @param {Element=} header     Try insert ad after header element (or before first child otherwise)
	 * @param {Element=} nextHeader Following header after the ad
	 * @returns {boolean}           Whether the ad fits
	 */
	function injectAdIfMedrecFits(adHtml, container, header, nextHeader) {
		var $content = $(container),
			$ad = $(adHtml.toString()),
			$extraDivTop = $('<div></div>'),
			$extraDivBottom = $('<div></div>'),

			$insertAfter,   // insert the ad right after this element
			$fitBefore,     // the ad should fit in a way, that this element is untouched
			$firstElement,  // the first element in the section (will become the second)

			originalContentWidth,
			originalContentHeight,

			newContentWidth, // width of the content minus width of the ad
			heightDiff,
			maxHeightDiff,
			conditionsMet;

		function logInfo(result) {
			var padding = '                              ',
				name1 = $insertAfter.children().first().text().substring(0, 30) || 'unknown',
				name2 = $fitBefore.children().first().text().substring(0, 30) || 'unknown',
				msgPrefix = 'Between ' + name1 + ' and ' + name2 + padding,
				msg = msgPrefix.substring(0, 60).replace(/( *)$/, ':$1 ') + result;

			log(msg, 'info', logGroup);
		}

		function checkConditions() {
			if ($insertAfter.width() < originalContentWidth) {
				logInfo('ERROR: the preceding element is too narrow');
				return false;
			}
			if (!canReflow($firstElement) && $firstElement.width() > newContentWidth) {
				logInfo('ERROR: the first element is too wide and does not adapt: ' +
					$firstElement.width() + '>' + newContentWidth);
				return false;
			}
			if ($fitBefore.width() < originalContentWidth) {
				logInfo('ERROR: the next section would not have the full width');
				return false;
			}
			if (heightDiff > maxHeightDiff) {
				logInfo('ERROR: height difference is too big: ' + heightDiff + '>' + maxHeightDiff.toFixed(1));
				return false;
			}

			logInfo('SUCCESS: ad fits and height difference is acceptable: ' + heightDiff + '<' + maxHeightDiff.toFixed(1));
			return true;
		}

		log(['injectAdIfMedrecFits', container, header, nextHeader], 'debug', logGroup);

		$content.prepend($extraDivTop);
		$content.append($extraDivBottom);

		// Find out $insertAfter, $fitBefore and $firstElement
		$insertAfter = header ? $(header) : $extraDivTop;
		$fitBefore = nextHeader ? $(nextHeader) : $extraDivBottom;
		$firstElement = $insertAfter.next();

		// Calculate original dimensions
		originalContentWidth = $content.width();
		originalContentHeight = $content.height();

		// Add the ad now
		$insertAfter.after($ad);

		// If the first element is right-floating, move it below the ad
		if ($firstElement.css('float') === 'right') {
			$firstElement.addClass('clear-right-after-ad-in-content');
		}

		// Do the math!
		heightDiff = $content.height() - originalContentHeight;
		maxHeightDiff = (1.2 * $ad.outerWidth(true) * $ad.outerHeight(true) / originalContentWidth);
		newContentWidth = originalContentWidth - $ad.outerWidth(true);

		// Check the conditions
		conditionsMet = checkConditions();

		// Clean up, return value and log why
		$extraDivTop.remove();
		$extraDivBottom.remove();

		if (!conditionsMet) {
			$ad.remove();
			$firstElement.removeClass('clear-right-after-ad-in-content');
		}

		log(['injectAdIfMedrecFits', conditionsMet, $insertAfter, $fitBefore, $firstElement], 'debug', logGroup);

		return conditionsMet;
	}

	/**
	 * Check if the ad fits in the content
	 *
	 * @param {String} adHtml       HTML to inject
	 * @param {Element} container   Container to check for height difference
	 * @param {Element=} header     Try insert ad after header element (or before first child otherwise)
	 * @returns {boolean}           Whether the ad fits
	 */
	function injectAdIfLeaderboardFits(adHtml, container, header) {

		var $content = $(container),
			$ad = $(adHtml.toString()),
			$header = $(header),
			originalContentWidth,

			conditionsMet;

		function logInfo(result) {
			var padding = '                              ',
				name1 = $header.children().first().text().substring(0, 30) || 'unknown',
				msgPrefix = 'Before ' + name1 + ' ' + padding,
				msg = msgPrefix.substring(0, 60).replace(/( *)$/, ':$1 ') + result;

			log(msg, 'info', logGroup);
		}

		function checkConditions() {

			if (originalContentWidth < 728) {
				logInfo('ERROR: content width is not wide enough for leaderboard');
				return false;
			}
			if ($header.width() < originalContentWidth) {
				logInfo('ERROR: the section does not have the full width');
				return false;
			}

			logInfo('SUCCESS: ad fits');
			return true;
		}

		log(['injectAdIfLeaderboardFits', container, header], 'debug', logGroup);

		originalContentWidth = $content.width();

		conditionsMet = checkConditions();

		if (conditionsMet) {
			$ad.insertBefore($header);
		}

		log(['injectAdIfLeaderboardFits', conditionsMet, adHtml, container, header], 'debug', logGroup);

		return conditionsMet;
	}

	return {
		injectAdIfMedrecFits: injectAdIfMedrecFits,
		injectAdIfLeaderboardFits: injectAdIfLeaderboardFits
	};
});
