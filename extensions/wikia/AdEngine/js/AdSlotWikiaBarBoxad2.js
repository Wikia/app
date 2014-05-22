/*global define*/
define('ext.wikia.adEngine.slot.wikiaBarBoxad2', [
	'jquery',
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.slotTweaker'
], function ($, log, window, document, adHelper, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.wikiaBarBoxad2',
		slotname = 'WIKIA_BAR_BOXAD_2',
		initialized = false,
		pageHeight = window.document.documentElement.scrollHeight,

		wikiaBar = $('.WikiaBarWrapper'),
		wikiaBarCollapse = $('.WikiaBarCollapseWrapper'),
		slotAdded = false;

	function onScroll() {

		if (!slotAdded && (window.scrollY > 300 && window.scrollY < 1600)) {
			slotAdded = true;

			$('.WikiaSiteWrapper').append('<div id="'+ slotname + '" class="wikia-ad noprint"></div>');

			window.adslots2.push([ slotname,null,"AdEngine2" ]);
		}

		if (slotAdded && (window.scrollY > 500 && window.scrollY < 1000)) {
			if (wikiaBar.length && wikiaBar[0].style.display === 'none') {
				return;
			}
			wikiaBar[0].style.display = 'none';
			wikiaBarCollapse[0].style.display = 'none';

			slotTweaker.show(slotname);
		} else {
			if (wikiaBar.length && wikiaBar[0].style.display === '') {
				return;
			}
			wikiaBar[0].style.display = '';
			wikiaBarCollapse[0].style.display = '';

			slotTweaker.hide(slotname);
		}

	}

	function shouldBeLoaded() {
		return pageHeight > 1600;
	}

	function init() {
		log(['init'], 5, logGroup);

		if (initialized) {
			return;
		}

		if (shouldBeLoaded()) {
			onScroll();
			window.addEventListener('scroll', adHelper.throttle(onScroll, 250));
		}


		initialized = true;
	}

	return {
		init: init
	};
});
