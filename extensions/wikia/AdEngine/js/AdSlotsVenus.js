/*global define*/
define('ext.wikia.adEngine.slot.venus', [
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
		minOffset = 750,
		adLabel = $('.wikia-ad-label').first().text();

	function insertSlot(slotname, header) {
		var $div = $('<div/>');

		$div.addClass('ad-in-content');
		$div.html('<div class="wikia-ad default-height"><label class="wikia-ad-label"></label></div>');
		$('label', $div).text(adLabel);
		$('div', $div).attr('id', slotname);

		$(header).after($div);

		win.adslots2.push([slotname]);
	}

	function init() {
		log(['init'], 'debug', logGroup);

		var i,
			len,
			previousAdOffset = 0,
			remainingSlots = inContentSlots.slice(), // clone
			slotsToPut = remainingSlots.length,
			contentText = doc.getElementById('mw-content-text'),
			fakeAdHtml = '<div class="ad-in-content" style="width: 300px; height: 250px"></div>',
			headers = contentText.querySelectorAll(headersSelector);

		for (i = 0, len = headers.length; i < len && slotsToPut; i += 1) {

			if (headers[i].offsetTop > previousAdOffset + minOffset) {
				if (adPlacementChecker.doesAdFit(fakeAdHtml, contentText, headers[i], headers[i + 1])) {
					slotsToPut -= 1;
					insertSlot(remainingSlots.shift(), headers[i]);
					previousAdOffset = headers[i].offsetTop + headers[i].offsetHeight;
				}
			}
		}
	}

	return {
		init: init
	};
});
