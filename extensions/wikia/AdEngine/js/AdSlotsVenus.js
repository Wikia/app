/*global require*/
require([
	'jquery',
	'wikia.document',
	'ext.wikia.adEngine.adSlotsInContent'
], function ($, document, adSlotsInContent) {
	'use strict';

	function init () {
		adSlotsInContent.init($(adSlotsInContent.selector));
	}

	$(document).ready(init);
});
