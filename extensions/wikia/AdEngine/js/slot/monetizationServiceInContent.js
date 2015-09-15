/*global define*/

define('ext.wikia.adEngine.slot.monetizationServiceInContent', [
	'ext.wikia.adEngine.adContext',
	'jquery',
	'wikia.log',
	'wikia.window'
], function (adContext, $, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.monetizationServiceInContent',
		slotInContent = 'in_content',
		slotName = 'MON_IN_CONTENT';

	function init() {
		log(['init', slotName, slotInContent], 'debug', logGroup);

		if (adContext.getContext().providers.monetizationService) {
			var $element = $('#mw-content-text > h2'),
				$content = $('<div/>').attr({'id': slotName, 'class': 'wikia-ad noprint default-height'});

			// Insert the ad above the 2nd <H2> tag. (Insert the ad above the 3rd <H2> tag if TOC exists)
			if ($element.size() >= 2) {
				log(['init', slotName, 'Add slot'], 'debug', logGroup);
				$element.eq(1).before($content);
			// Otherwise, insert to the end of content
			} else {
				log(['init', slotName, 'Add slot (end content)'], 'debug', logGroup);
				$content.addClass('end-content');
				$('#mw-content-text').append($content);
			}

			window.adslots2.push(slotName);
		}
	}

	return {
		init: init
	};
});
