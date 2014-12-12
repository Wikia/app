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
		inContentSlots = [
			['INCONTENT_2C', 'ad-in-content-c', 'INCONTENT_2B', 'ad-in-content-b',  'INCONTENT_2A', 'ad-in-content-a'],
			['INCONTENT_1C', 'ad-in-content-c', 'INCONTENT_1B', 'ad-in-content-b', 'INCONTENT_1A', 'ad-in-content-a']
		],
		minOffset = 750 + 250, // 250 = height of the ad
		adHtml = '<div class="ad-in-content ad-in-content-current"><div class="wikia-ad default-height"></div></div>',
		labelHtml = '<label class="wikia-ad-label"></label>';

	function init() {
		log(['init'], 'debug', logGroup);

		var i,
			j,
			len,
			remainingSlots,
			slotsToPut = inContentSlots.length,
			container = doc.getElementById('mw-content-text'),
			previousAdOffset = container.offsetTop,
			headers = container.querySelectorAll(headersSelector),
			labelText = $('.wikia-ad-label').first().text(),
			slotName,
			slotHtml,
			slotClass,
			$slot;

		for (j = inContentSlots.length - 1; j >= 0; j -= 1) {

			remainingSlots = inContentSlots[j].slice(); // clone

			for (i = 0, len = headers.length; i < len && slotsToPut; i += 1) {
				if (headers[i].offsetTop > previousAdOffset + minOffset) {
					slotName = remainingSlots.shift();
					slotClass = remainingSlots.shift();
					slotHtml = adHtml.replace('default-height', 'default-height ' + slotClass);

					if (adPlacementChecker.injectAdIfItFits(slotHtml, container, headers[i], headers[i + 1])) {
						previousAdOffset = headers[i].offsetTop;
						slotsToPut -= 1;

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

	$(doc).ready(init);
});
