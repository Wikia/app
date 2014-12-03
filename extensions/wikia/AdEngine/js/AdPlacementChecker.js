/*global define*/
define('ext.wikia.adEngine.adPlacementChecker', ['jquery', 'wikia.log'], function ($, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adPlacementChecker';

	function canReflow($el) {
		var ret = $el.css('display') === 'block' &&
			$el.css('float') === 'none' &&
			$el.css('overflow') === 'visible';

		log(['canReflow', $el, ret], 'info', logGroup);

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
	function injectAdIfItFits(adHtml, container, header, nextHeader) {
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

		function checkConditions() {
			if ($insertAfter.width() < originalContentWidth) {
				log(['checkConditions', 'the preceding element is too narrow'], 'info', logGroup);
				return false;
			}
			if (!canReflow($firstElement) && $firstElement.width() > newContentWidth) {
				log(['checkConditions', 'the first element is too wide and does not adapt: ' +
					$firstElement.width() + '>' + newContentWidth], 'info', logGroup);
				return false;
			}
			if ($fitBefore.width() < originalContentWidth) {
				log(['checkConditions', 'the next section would not have the full width'], 'info', logGroup);
				return false;
			}
			if (heightDiff > maxHeightDiff) {
				log(['checkConditions', 'height difference is too big: ' +
					heightDiff + '>' + maxHeightDiff.toFixed(1)], 'info', logGroup);
				return false;
			}

			log(['checkConditions', 'ad fits and height difference is acceptable: ' +
				heightDiff + '<' + maxHeightDiff.toFixed(1)], 'info', logGroup);
			return true;
		}

		log(['injectAdIfItFits', container, header, nextHeader], 'info', logGroup);

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

		log(['injectAdIfItFits', conditionsMet, $insertAfter, $fitBefore, $firstElement], 'info', logGroup);

		return conditionsMet;
	}

	return {
		injectAdIfItFits: injectAdIfItFits
	};
});
