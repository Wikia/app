define('ext.wikia.adEngine.monetizationsServiceHelper', [
	'jquery',
	'wikia.scriptwriter',
], function ($, scriptWriter) {
	'use strict';

	var isEndOfContent = false;

	function validateSlot(slotName) {
		if (slotName === 'below_category' && isEndOfContent) {
			return false;
		}

		return true;
	}

	function injectContent(slot, content, success) {
		scriptWriter.injectHtml(slot, content, function () {
			success();
		});
	}

	function addInContentSlot(slot) {
		var elementName = '#mw-content-text > h2',
			num = $(elementName).length,
			content = '<div id="' + slot + '" class="wikia-ad noprint default-height"></div>';

		// TOC exists. Insert the ad above the 3rd <H2> tag.
		if ($('#toc').length > 0 && num > 3) {
			$(elementName).eq(2).before(content);
		// TOC not exist. Insert the ad above the 2nd <H2> tag.
		} else if (num > 2) {
			$(elementName).eq(1).before(content);
		// Otherwise, insert to the end of content
		} else {
			$('#mw-content-text').append(content);
			isEndOfContent = true;
		}

		window.adslots2.push(slot);
	}

	return {
		addInContentSlot: addInContentSlot,
		validateSlot: validateSlot,
		injectContent: injectContent
	};
});
