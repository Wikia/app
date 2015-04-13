/*global define*/
define('ext.wikia.adEngine.adSlotsInContent', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adPlacementChecker',
	'ext.wikia.adEngine.slotTweaker',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, adPlacementChecker, slotTweaker, $, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.inContent',
		selector = '#mw-content-text > h2, #mw-content-text > h3, #mw-content-text > section > h2',
		inContentMedrecs = [
			['INCONTENT_1C', 'INCONTENT_1B', 'INCONTENT_1A'],
			['INCONTENT_2C', 'INCONTENT_2B', 'INCONTENT_2A'],
			['INCONTENT_3C', 'INCONTENT_3B', 'INCONTENT_3A']
		],
		inContentLeaderboards = ['INCONTENT_LEADERBOARD_1', 'INCONTENT_LEADERBOARD_2', 'INCONTENT_LEADERBOARD_3'],
		slotsAdded = 0,
		maxSlots,
		minOffset = 1100,
		offsetMap = [[0, minOffset]],
		adHtml = '<div class="ad-in-content">' +
			'<div id="%%ID%%" class="wikia-ad default-height"></div></div>',
		labelHtml = '<label class="wikia-ad-label"></label>',

		container,
		elementsBeforeSlots,
		labelText;

	function isValidOffset(offset) {
		var i, len;

		for (i = 0, len = offsetMap.length; i < len; i += 1) {
			if (offset > offsetMap[i][0] && offset < offsetMap[i][1]) {
				return false;
			}
		}
		return true;
	}

	function getSlotParams(slotName) {
		if (!slotName) {
			return ;
		}

		var html = adHtml.replace('%%ID%%', slotName);

		if (/leaderboard/i.test(slotName)) {
			html = html.replace('ad-in-content', 'ad-in-content-lb');
		}

		return {
			name: slotName,
			html: html
		};
	}

	function pushSlot(type, slot, header, headerNext) {
		var headerOffset = header ? header.offsetTop : 0;

		if (!isValidOffset(headerOffset)) {
			return false;
		}

		if (type === 'medrec' && !adPlacementChecker.injectAdIfMedrecFits(slot.html, container, header, headerNext)) {
			return false;
		}

		if (type === 'leaderboard' && !adPlacementChecker.injectAdIfLeaderboardFits(slot.html, container, header)) {
			return false;
		}

		slotsAdded += 1;
		offsetMap.push([headerOffset - minOffset, headerOffset + minOffset]);
		win.adslots2.push([slot.name]);
		slotTweaker.hackChromeRefresh(slot.name);
		return true;
	}

	function addMedrecs() {
		var i,
			j,
			len,
			slot;
		inContentMedrecs.forEach(function (remainingSlots, index) {
			for (i = 0, len = elementsBeforeSlots.length; i < len && slotsAdded < maxSlots; i += 1) {
				remainingSlots = inContentMedrecs[index].slice();
				for (j = remainingSlots.length - 1; j >= 0; j -= 1) {
					slot = getSlotParams(remainingSlots.shift());
					if (pushSlot('medrec', slot, elementsBeforeSlots[i], elementsBeforeSlots[i + 1])) {
						return;
					}
				}
			}
		});
	}

	function addLeaderBoards() {
		var i,
			len,
			remainingSlots,
			slot;

		remainingSlots = inContentLeaderboards.slice();
		slot = getSlotParams(remainingSlots.shift());
		for (i = 0, len = elementsBeforeSlots.length; i < len && slot && slotsAdded < maxSlots; i += 1) {
			if (pushSlot('leaderboard', slot, elementsBeforeSlots[i])) {
				slot = getSlotParams(remainingSlots.shift());
			}
		}
	}

	/**
	 * @param {array} elements
	 * @param {number} maxSlotsNumber
	 */
	function init(elements, maxSlotsNumber) {
		log(['init'], 'debug', logGroup);

		//Default number of available slots is 3
		maxSlots = maxSlotsNumber || 3;
		container = $('#mw-content-text');

		if (container.height() < minOffset) {
			// Only show the ads on pages that are long enough
			log(['init', 'Page too short. Not putting any ads here'], 'debug', logGroup);
			return;
		}

		labelText = $('.wikia-ad-label').html();
		elementsBeforeSlots = elements;
		addMedrecs();
		addLeaderBoards();

		$('.wikia-ad', container).prepend($(labelHtml).text(labelText));
	}

	return {
		init: init,
		selector: selector
	};
});
