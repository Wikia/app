/*global require*/
require([
	'jquery',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adPlacementChecker'
], function ($, doc, log, win, adPlacementChecker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.venus',
		headersSelector = '#mw-content-text > h2, #mw-content-text > h3, #mw-content-text > section > h2',
		inContentMedrecs = [
			['INCONTENT_2C', 'ad-in-content-c', 'INCONTENT_2B', 'ad-in-content-b', 'INCONTENT_2A', 'ad-in-content-a'],
			['INCONTENT_1C', 'ad-in-content-c', 'INCONTENT_1B', 'ad-in-content-b', 'INCONTENT_1A', 'ad-in-content-a']
		],
		inContentLeaderboards = ['INCONTENT_LEADERBOARD_1', 'INCONTENT_LEADERBOARD_2'],
		slotsAdded = 0,
		maxSlots = 2,
		minOffset = 750 + 125, // 250 = height of the ad
		offsetMap = [ [ -minOffset, minOffset ] ],
		adHtml = '<div class="ad-in-content ad-in-content-current"><div class="wikia-ad default-height"></div></div>',
		labelHtml = '<label class="wikia-ad-label"></label>',


		container,
		headers,
		labelText;

	function isValidOffset(offset) {

		var i, len;

		for (i = 0, len = offsetMap.length; i < len; i += 1 ) {
			if (offset > offsetMap[i][0] && offset < offsetMap[i][1]) {
				return false;
			}
		}

		return true;
	}

	function processAddedSlot() {

	}


	function addMedrecs() {

		var i,
			j,
			len,
			remainingSlots,
			slotName,
			slotHtml,
			slotClass,
			$slot;

		for (i = inContentMedrecs.length - 1; i >= 0 && slotsAdded < maxSlots; i -= 1) {
			remainingSlots = inContentMedrecs[i].slice();

			for (j = 0, len = headers.length; j < len && slotsAdded < maxSlots; j += 1) {

				if (isValidOffset(headers[i].offsetTop)) {
					slotName = remainingSlots.shift();
					slotClass = remainingSlots.shift();
					slotHtml = adHtml.replace('default-height', 'default-height ' + slotClass);

					if (adPlacementChecker.injectAdIfItFits(slotHtml, container, headers[j], headers[j + 1])) {

						offsetMap.push([headers[j].offsetTop - minOffset, headers[j].offsetTop + minOffset]);
						slotsAdded += 1;

						$slot = $('.ad-in-content-current', container);
						$slot.removeClass('ad-in-content-current');

						$slot.find('.wikia-ad')
							.attr('id', slotName)
							.removeClass(slotClass)
							.append($(labelHtml).text(labelText));
						win.adslots2.push([slotName]);

						break;
					}
				}

			}
		}

	}

	function addLeaderBoards() {

		var i,
			len,
			remainingSlots,
			slotName,
			slotHtml,
			$slot,

			originalContentWidth;

		remainingSlots = inContentLeaderboards.slice();

		originalContentWidth = container.clientWidth;

		for (i = 0, len = headers.length; i < len && slotsAdded < maxSlots; i += 1) {

			if (isValidOffset(headers[i].offsetTop) && headers[i].clientWidth + 20 >= originalContentWidth) {
				slotName = remainingSlots.shift();
				slotHtml = adHtml.replace('ad-in-content', 'ad-in-content-lb');

				headers[i].insertAdjacentHTML('beforebegin', slotHtml);

				offsetMap.push([headers[i].offsetTop - minOffset, headers[i].offsetTop + minOffset]);
				slotsAdded += 1;

				$slot = $('.ad-in-content-current', container);
				$slot.removeClass('ad-in-content-current');

				$slot.find('.wikia-ad')
					.attr('id', slotName)
					.append($(labelHtml).text(labelText));

				win.adslots2.push([slotName]);

			}
		}

	}



	function init() {
		log(['init'], 'debug', logGroup);

		container = doc.getElementById('mw-content-text');
		headers = container.querySelectorAll(headersSelector);
		labelText = $('.wikia-ad-label').html();

		addMedrecs();
		addLeaderBoards();

	}

	$(doc).ready(init);
});
