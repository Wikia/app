/*global define*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	'wikia.document'
], function (slotTweaker, log, doc) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function show() {
		slot.classList.add('bfab-template');
		slotTweaker.makeResponsive(slot.id);

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
