/*global define*/
define('ext.wikia.adEngine.slot.wikiaBarBoxad2', [
	'jquery',
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.eventDispatcher',
	'wikia.cache'
], function ($, log, window, document, adHelper, eventDispatcher, cache) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.wikiaBarBoxad2',

		slotName = 'WIKIA_BAR_BOXAD_2',
		visibleOffsetTop = 500,
		visibleOffsetBottom = 1200,
		loadOffsetBottom = 1400,
		loadOffsetTop = 300,
		minPageHeight = 1600,

		now = window.wgNow || new Date(),
		impressionCacheKey = 'wikiaBarBoxad2_impressions',
		forgetImpressionsAfterTime = 3600, // an hour
		impressionCapping = window.wgAdDriverWikiaBarBoxad2ImpressionCapping || [],

		$slot,
		pageHeight = window.document.documentElement.scrollHeight,
		wikiaBar = window.WikiaBar,
		disabled = false;

	function isBetween(value, top, bottom) {
		return top && bottom && (value >= top && value <= bottom);
	}

	/**
	 * Apply the page impression capping. Return true if ad should be requested.
	 * Return false if ad should not be requested.
	 *
	 * @returns {boolean}
	 */
	function applyCapImpression() {
		var impressionNo = parseInt(cache.get(impressionCacheKey, now), 10) || 0;

		impressionNo += 1;
		cache.set(impressionCacheKey, impressionNo, forgetImpressionsAfterTime, now);

		return (impressionCapping.indexOf(impressionNo) !== -1);
	}

	function onScroll() {
		var scroll = window.scrollY || document.documentElement.scrollTop;

		if (disabled) {
			return;
		}

		if (!$slot && isBetween(scroll, loadOffsetTop, loadOffsetBottom)) {
			if (applyCapImpression()) {
				log(['Adding new slot', slotName], 'debug', logGroup);

				$slot = $('<div class="wikia-ad noprint"></div>');
				$slot.attr('id', slotName);
				$slot.hide();
				$slot.appendTo('.WikiaSiteWrapper');

				window.adslots2.push([slotName]);
			} else {
				log(['Impression capped. Not requesting the ad', slotName], 'debug', logGroup);

				$(window).off('scroll.wikiaBarBoxad2');
				disabled = true;
			}
		}

		if ($slot) {
			if (isBetween(scroll, visibleOffsetTop, visibleOffsetBottom)) {
				wikiaBar.hideContainer();
				$slot.show();
			} else {
				wikiaBar.showContainer();
				$slot.hide();
			}
		}
	}

	function shouldBeLoaded() {

		if (pageHeight > minPageHeight) {
			return true;
		}

		log(['Page is too short!', slotName], 'debug', logGroup);

		return false;
	}

	function fillInSlotCallback(slot) {

		var skyscraperOffset;

		if (slot[0] === 'LEFT_SKYSCRAPER_2') {

			skyscraperOffset = $('#LEFT_SKYSCRAPER_2').offset() || {};

			if (skyscraperOffset.top) {
				visibleOffsetBottom = skyscraperOffset.top - 150;
			}

			if (visibleOffsetBottom <= visibleOffsetTop) {
				visibleOffsetTop = visibleOffsetBottom = false;
			}

			log(['Found LEFT_SKYSCRAPER_2, new visible offsets', [visibleOffsetTop, visibleOffsetBottom]], 'debug', logGroup);
		}

	}

	function init() {
		log(['init', slotName], 'debug', logGroup);

		if (shouldBeLoaded()) {
			eventDispatcher.bind('ext.wikia.adEngine fillInSlot', fillInSlotCallback, true);

			log(['Register event listener', slotName], 'debug', logGroup);

			onScroll();

			$(window).on('scroll.wikiaBarBoxad2', adHelper.throttle(onScroll, 250));
		}
	}

	return {
		init: init
	};

});
