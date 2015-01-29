/*global require*/
require([
	'ext.wikia.adEngine.adSlotsInContent'
], function (adSlotsInContent) {
	'use strict';
	adSlotsInContent.init($(adSlotsInContent.selector));
});
