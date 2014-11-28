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
		inContentSlots = ['INCONTENT_BOXAD_1', 'INCONTENT_BOXAD_2'],
		minOffset = 750 + 300, // 300 = height of the ad
		adHtml = '<div class="ad-in-content ad-in-content-current"><div class="wikia-ad default-height"></div></div>',
		labelHtml = '<label class="wikia-ad-label"></label>';

	function init() {
		log(['init'], 'debug', logGroup);

		var i,
			len,
			remainingSlots = inContentSlots.slice(), // clone
			slotsToPut = remainingSlots.length,
			container = doc.getElementById('mw-content-text'),
			previousAdOffset = container.offsetTop,
			headers = container.querySelectorAll(headersSelector),
			labelText = $('.wikia-ad-label').first().text(),
			slotname,
			$slot;

		for (i = 0, len = headers.length; i < len && slotsToPut; i += 1) {
			if (headers[i].offsetTop > previousAdOffset + minOffset) {
				if (adPlacementChecker.injectAdIfItFits(adHtml, container, headers[i], headers[i + 1])) {
					slotname = remainingSlots.shift();
					previousAdOffset = headers[i].offsetTop;
					slotsToPut -= 1;

					$slot = $('.ad-in-content-current', container);
					$slot.removeClass('ad-in-content-current');
					$slot.find('.wikia-ad').attr('id', slotname).append($(labelHtml).text(labelText));
					win.adslots2.push([slotname]);
				}
			}
		}
	}

	$(doc).ready(init);
});
