/*global define*/

define('ext.wikia.adEngine.slot.monetizationServiceInContent', [
	'ext.wikia.adEngine.adContext',
	'jquery',
	'wikia.log',
	'wikia.window',
], function (adContext, $, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.monetizationServiceInContent',
		slotName = 'MON_IN_CONTENT';

	function init() {
		var slotInContent = 'in_content',
			elementName = '#mw-content-text > h2',
			$content = $('<div/>').attr({'id': slotName, 'class': 'wikia-ad noprint default-height'});

		log(['init', slotName, slotInContent], 'debug', logGroup);

		// Insert the ad above the 2nd <H2> tag. (Insert the ad above the 3rd <H2> tag if TOC exists)
		if ($(elementName).length >= 2) {
			log(['init', slotName, 'Add slot'], 'debug', logGroup);
			$(elementName).eq(1).before($content);
			addBelowCategorySlot();
		// Otherwise, insert to the end of content
		} else {
			log(['init', slotName, 'Add slot (end content)'], 'debug', logGroup);
			$content.addClass('end-content');
			$('#mw-content-text').append($content);
		}

		window.adslots2.push(slotName);
	}

	function addBelowCategorySlot() {
		var slotBelowCategory = 'MON_BELOW_CATEGORY';

		log(['addBelowCategorySlot', slotBelowCategory], 'debug', logGroup);

		if ($.inArray(slotBelowCategory, window.adslots2) < 0) {
			log(['addBelowCategorySlot', slotBelowCategory, 'Add slot'], 'debug', logGroup);
			window.adslots2.push(slotBelowCategory);
		}
	}

	return {
		init: init
	};
});
