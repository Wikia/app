/*global define*/
define('ext.wikia.adEngine.slot.wikiaBarBoxad2', [
	'jquery',
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slotTweaker'
], function ($, log, window, document, adHelper, eventDispatcher, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.wikiaBarBoxad2',
		slotname = 'WIKIA_BAR_BOXAD_2',
		pageHeight = window.document.documentElement.scrollHeight,

		wikiaBar = window.WikiaBar,
		slotAdded = [],
		visibleOffsetTop = 500,
		visibleOffsetBottom = 1200,
		loadOffsetBottom = 1400,
		loadOffsetTop = 300;

	function isBetween(value, top, bottom) {
		return top && bottom && ( value >= top && value <= bottom );
	}

	function onScroll() {

		var scroll = window.scrollY || document.documentElement.scrollTop;

		if (!slotAdded.length && isBetween(scroll, loadOffsetTop, loadOffsetBottom)) {
			log(['Adding new slot', slotname], 9, logGroup);

			slotAdded = $('<div id="' + slotname + '" class="wikia-ad noprint" style="display: none;"></div>').appendTo('.WikiaSiteWrapper');

			window.adslots2.push([ slotname ]);
		}

		if (slotAdded.length) {

			console.log(scroll, visibleOffsetTop, visibleOffsetBottom, isBetween(scroll, visibleOffsetTop, visibleOffsetBottom));

			if (isBetween(scroll, visibleOffsetTop, visibleOffsetBottom)) {
				wikiaBar.hideContainer();
				slotAdded.show();
			} else {
				wikiaBar.showContainer();
				slotAdded.hide();
			}

		}
	}

	function shouldBeLoaded() {

		if (pageHeight > 1600) {
			return true;
		}

		log(['Page is too short!', slotname], 9, logGroup);

		return false;
	}

	function fillInSlotCallback(slot) {

		var skyscraperOffset;

		if (slot[0] === 'LEFT_SKYSCRAPER_2') {

			skyscraperOffset = $('LEFT_SKYSCRAPER_2').offset() || {};

			if (skyscraperOffset.top) {
				visibleOffsetBottom = skyscraperOffset.top - 150;
			}

			if (visibleOffsetBottom <= visibleOffsetTop) {
				visibleOffsetTop = visibleOffsetBottom = false;
			}

			log(['Found LEFT_SKYSCRAPER_2, new visible offsets', [visibleOffsetTop, visibleOffsetBottom] ], 9, logGroup);
		}

	}

	function init() {
		log(['Init', slotname], 9, logGroup);

		if (shouldBeLoaded()) {
			eventDispatcher.bind('ext.wikia.adEngine fillInSlot', fillInSlotCallback, true);

			log(['Register event listener', slotname], 9, logGroup);

			onScroll();

			window.addEventListener('scroll', adHelper.throttle(onScroll, 250));
		}
	}

	return {
		init: init
	};

});
