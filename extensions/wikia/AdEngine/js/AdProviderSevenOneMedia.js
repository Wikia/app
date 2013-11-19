/*global require*/

var AdProviderSevenOneMedia = function (log, window, tracker, $, sevenOneMedia) {
	'use strict';

	var logGroup = 'AdProviderSevenOneMedia',
		slotMap = {
			TOP_RIGHT_BOXAD: 'rectangle1',
			HOME_TOP_RIGHT_BOXAD: 'rectangle1',

//			PREFOOTER_LEFT_BOXAD: 'promo1',

			TOP_LEADERBOARD: 'topAds',
			HOME_TOP_LEADERBOARD: 'topAds',
			HUB_TOP_LEADERBOARD: 'topAds',

			SEVENONEMEDIA_FLUSH: 'trackEnd'
		},
		trackedSize = {
			rectangle1: '300x250',
			promo1: '300x250',
			topAds: '728x90',
			trackEnd: '1x1'
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

	// TODO: ADEN-492 don't duplicate it everywhere, ok?
	function formatTrackTime(t, max) {
		if (isNaN(t)) {
			log('Error, time tracked is NaN: ' + t, 'debug', logGroup);
			return "NaN";
		}

		if (t < 0) {
			log('Error, time tracked is a negative number: ' + t, 'debug', logGroup);
			return "negative";
		}

		t /= 1000;
		if (t > max) {
			return "more_than_" + max;
		}

		return t.toFixed(1);
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot], 'info', logGroup);

		var slotname = slot[0],
			slotDeName = slotMap[slotname],
			slotsize = slotDeName && trackedSize[slotDeName],
			$slot,
			hopTimer = new Date().getTime();

		function clearDefaultHeight() {
			$('#' + slotname).removeClass('default-height');
		}

		function trackSuccess() {
			var hopTime = new Date().getTime() - hopTimer;
			log('slotTimer2 end for ' + slotname + ' after ' + hopTime + ' ms (success)', 'debug', logGroup);
			tracker.track({
				eventName: 'liftium.hop2',
				ga_category: 'success2/sevenonemedia',
				ga_action: 'slot ' + slotname,
				ga_label: formatTrackTime(hopTime, 5),
				trackingMethod: 'ad'
			});
		}

		tracker.track({
			eventName: 'liftium.slot2',
			ga_category: 'slot2/' + slotsize,
			ga_action: slotname,
			ga_label: 'sevenonemedia',
			trackingMethod: 'ad'
		});

		if (slotDeName === 'topAds') {
			makeTopAds();
			sevenOneMedia.pushAd('popup1');
			sevenOneMedia.pushAd('fullbanner2', {afterFinish: handleTopButton});
			sevenOneMedia.pushAd('skyscraper1', {afterFinish: trackSuccess});
			sevenOneMedia.flushAds();
		}

		if (slotDeName.match(/^(rectangle1|promo[123])$/)) {
			$slot = $('<div class="ad-wrapper" style="display: none"></div>');
			$slot.attr('id', 'ad-' + slotDeName);
			$('#' + slotname).append($slot);
			sevenOneMedia.pushAd(slotDeName, {beforeFinish: clearDefaultHeight, afterFinish: trackSuccess});
			sevenOneMedia.flushAds();
		}

		if (slotDeName === 'trackEnd') {
			sevenOneMedia.trackEnd(slotname);
		}
	}

	return {
		name: 'SevenOneMedia',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
