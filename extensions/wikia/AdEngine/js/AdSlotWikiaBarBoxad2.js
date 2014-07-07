/*global require*/
require([
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
		pageHeight = window.document.documentElement.scrollHeight,

		wikiaBar = $('.WikiaBarWrapper'),
		wikiaBarCollapse = $('.WikiaBarCollapseWrapper'),
		slotAdded = false;

	function onScroll() {

		var scroll = window.scrollY || document.documentElement.scrollTop;
		if (!slotAdded && (scroll > 300 && scroll < 1600)) {
			slotAdded = true;

			$('.WikiaSiteWrapper').append('<div id="'+ slotname + '" class="wikia-ad noprint hidden"></div>');

			window.adslots2.push([ slotname,null,"AdEngine2" ]);
		}

		if (slotAdded && (scroll > 500 && scroll < 1000)) {
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
		return window.wgShowAds && pageHeight > 1600;
	}

	$(function(){
		log(['Init', slotname], 'debug', logGroup);

		if (shouldBeLoaded()) {
			log(['Register event listener', slotname], 'debug', logGroup);

			onScroll();
			window.addEventListener('scroll', adHelper.throttle(onScroll, 250));
		}
	});

});
