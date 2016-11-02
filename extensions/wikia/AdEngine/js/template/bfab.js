/*global define, require*/
define('ext.wikia.adEngine.template.bfab', [
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	'wikia.document',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (slotTweaker, log, doc, recoveryTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function show(params) {
		slot.classList.add('bfab-template');
		slotTweaker.makeResponsive(slot.id, params.aspectRatio);

		if (recoveryTweaker && recoveryTweaker.isTweakable()) {
			slotTweaker.onReady(slot.id, function (iframe) {
				recoveryTweaker.tweakSlot(slot.id, iframe);
			});
		}

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
