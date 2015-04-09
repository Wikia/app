/*global define*/
/*jslint nomen: true*/
/*jshint camelcase: false*/
define('ext.wikia.adEngine.provider.szymon', [
	'wikia.log',
	'wikia.document'
], function (log, document) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.szymon';

	function canHandleSlot(slot) {
		log(['canHandleSlot', slot, slot === 'TOP_LEADERBOARD'], 'info', logGroup);
		return slot === 'TOP_LEADERBOARD';
	}

	function fillInSlot(slotname, success) {
		var slot = document.getElementById(slotname),
			adTemplate = '<img src="http://lorempixel.com/728/90/" alt="{lorempixel}" />';

		log(['fillInSlot', slotname, adTemplate], 'debug', logGroup);
		slot.innerHTML = adTemplate;

		success();
	}

	return {
		name: 'szymon',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};

});
