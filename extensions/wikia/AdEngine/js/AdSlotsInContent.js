/*global define*/
define('ext.wikia.adEngine.adSlotsInContent',[
	'jquery',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adPlacementChecker'
], function ($, doc, log, win, adPlacementChecker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.venus',
		selector = '#mw-content-text > h2, #mw-content-text > h3, #mw-content-text > section > h2',
		inContentMedrecs = [
			['INCONTENT_1C', 'INCONTENT_1B', 'INCONTENT_1A'],
			['INCONTENT_2C', 'INCONTENT_2B', 'INCONTENT_2A'],
			['INCONTENT_3C', 'INCONTENT_3B', 'INCONTENT_3A']
		],
		inContentLeaderboards = ['INCONTENT_LEADERBOARD_1', 'INCONTENT_LEADERBOARD_2', 'INCONTENT_LEADERBOARD_3'],
		slotsAdded = 0,
		maxSlots = 3,
		minOffset = 1100,
		offsetMap = [[0, minOffset]],
		adHtml = '<div class="ad-in-content" style="clear:right;float:right;">' +
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
		//Set headerOffset to 0 for the prepended null
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
		win.adslots2.push(slot.name);

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

	function init(elements) {
		log(['init'], 'debug', logGroup);

		container = $('#mw-content-text');
		labelText = $('.wikia-ad-label').html();
		elementsBeforeSlots = elements;
		addMedrecs();
		addLeaderBoards();

		$('.wikia-ad', container).prepend($(labelHtml).text(labelText));
	}

	$(doc).ready(init);

	return {
		init: init,
		selector: selector
	};
});
