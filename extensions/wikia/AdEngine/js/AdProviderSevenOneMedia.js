/*global require*/

var AdProviderSevenOneMedia = function (log, window, tracker, $, sevenOneMedia) {
	'use strict';

	var logGroup = 'AdProviderSevenOneMedia',
		slotMap = {
			TOP_RIGHT_BOXAD: 'rectangle1',
			HOME_TOP_RIGHT_BOXAD: 'rectangle1',

//			PREFOOTER_LEFT_BOXAD: 'promo1',

			TOP_LEADERBOARD: 'topads',
			HOME_TOP_LEADERBOARD: 'topads',
			HUB_TOP_LEADERBOARD: 'topads'
		};

	function canHandleSlot(slot) {
		log(['canHandleSlot', slot], 'debug', logGroup);

		var slotname = slot[0];

		if (slotMap[slotname]) {
			log(['canHandleSlot', slot, true], 'debug', logGroup);
			return true;
		}

		log(['canHandleSlot', slot, false], 'debug', logGroup);
		return false;
	}

	function makeTopAds() {
		$('#TOP_BUTTON_WIDE').remove();
		$('#WikiaTopAds').after([
			'<div id="ads-outer" class="noprint">',
			'	<div id="ad-popup1" class="ad-wrapper"></div>',
			'	<div id="TOP_BUTTON_WIDE"></div>',
			'	<div id="ad-fullbanner2-outer">',
			'		<div id="ad-fullbanner2" class="ad-wrapper" style="visibility: hidden"></div>',
			'	</div>',
			'	<div id="ad-skyscraper1-outer">',
			'		<div id="ad-skyscraper1" class="ad-wrapper" style="display: none"></div>',
			'	</div>',
			'</div>'
		].join(''));
	}

	function handleTopButton(info) {
		// Start TOP_BUTTON_WIDE if leaderboard is of standard size
		if (info.slotname === 'fullbanner2' && !info.isSpecialAd) {
			log('fullbanner2 is not a special ad', 'debug', logGroup);
			var $slot = $('#ad-fullbanner2'),
				height = $slot.height(),
				width = $slot.width();

			if (height >= 90 && height <= 95 && width === 728) {
				log('fullbanner2 has standard size, enabling TOP_BUTTON_WIDE', 'debug', logGroup);
				window.adslots2.push(['TOP_BUTTON_WIDE.force']);
			}
		}
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot], 'info', logGroup);

		var slotname = slot[0],
			slotDeName = slotMap[slotname],
			$slot;

		function clearDefaultHeight() {
			$('#' + slotname).removeClass('default-height');
		}

		if (slotDeName === 'topads') {
			makeTopAds();
			sevenOneMedia.pushAd('popup1');
			sevenOneMedia.pushAd('fullbanner2', {afterFinish: handleTopButton});
			sevenOneMedia.pushAd('skyscraper1');
			sevenOneMedia.flushAds();
		}

		if (slotDeName.match(/^(rectangle1|promo[123])$/)) {
			$slot = $('<div class="ad-wrapper" style="display: none"></div>');
			$slot.attr('id', 'ad-' + slotDeName);
			$('#' + slotname).append($slot);
			sevenOneMedia.pushAd(slotDeName, {beforeFinish: clearDefaultHeight});
			sevenOneMedia.flushAds();
		}
	}

	return {
		name: 'SevenOneMedia',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
