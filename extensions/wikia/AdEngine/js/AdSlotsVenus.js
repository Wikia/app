/*global require*/
require([
	'jquery',
	'wikia.document',
	'ext.wikia.adEngine.adSlotsInContent'
], function ($, doc, adSlotsInContent) {
	'use strict';

	function init () {
		adSlotsInContent.init($(adSlotsInContent.selector));
	}

	$(doc).ready(init);
});
