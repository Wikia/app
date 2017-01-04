/*global define*/
/*jslint nomen: true*/
/*jshint camelcase: false*/
define('ext.wikia.adEngine.provider.diana', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.taboolaHelper',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window',
	'wikia.document'
], function (adContext, recoveryHelper, slotTweaker, taboolaHelper, geo, instantGlobals, log, window, document) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.diana',
		slotMap = {
			'TOP_LEADERBOARD': {
				width: '105 0',
				height: '300'
			},
			'TOP_RIGHT_BOXAD': {
				width: '300',
				height: '1050'
			}
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slot) {
		var container = document.createElement('img'),
			mappedSlot = slotMap[slot.name];

		slot.pre('success', function () {
			slotTweaker.removeDefaultHeight(slot.name);
			slotTweaker.adjustLeaderboardSize(slot.name);
		});

		container.src = "http://lorempixel.com/" + mappedSlot.width + "/" + mappedSlot.height + "/cats";
		log(['fillInSlot', slot.name], 'debug', logGroup);

		container.id = mappedSlot.id;
		slot.container.appendChild(container);
		slot.success();
	}

	return {
		name: 'Diana',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
