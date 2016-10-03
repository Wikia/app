/*global define, require*/
define('ext.wikia.adEngine.provider.netzathleten', [
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.window'
], function (slotTweaker, eventDispatcher, doc, lazyQueue, win) {
	'use strict';

	var initialized = false,
		libraryUrl = '//s.adadapter.netzathleten-media.de/API-1.0/NA-828433-1/naMediaAd.js',
		cmdQueue = [],
		slotMap = {
			TOP_LEADERBOARD: 'SUPERBANNER',
			TOP_RIGHT_BOXAD: 'MEDIUM_RECTANGLE',
			PREFOOTER_LEFT_BOXAD: 'MEDIUM_RECTANGLE',
			MOBILE_TOP_LEADERBOARD: 'TOP',
			MOBILE_IN_CONTENT: 'MID',
			MOBILE_PREFOOTER: 'BOTTOM'
		};

	function loadLibrary() {
		var script = doc.createElement('script');

		script.src = libraryUrl;
		script.async = true;
		script.onload = function () {
			cmdQueue.start();
		};

		doc.head.appendChild(script);
	}

	function init() {
		lazyQueue.makeQueue(cmdQueue, function (callback) {
			callback();
		});

		loadLibrary();

		eventDispatcher.dispatch('wikia.not_uap');
		cmdQueue.push(function () {
			win.naMediaAd.setValue('homesite', false);
		});
		initialized = true;
	}

	function canHandleSlot(slotName) {
		return !!slotMap[slotName];
	}

	function fillInSlot(slot) {
		var container = doc.createElement('div');

		slotTweaker.show(slot.name);
		slotTweaker.removeDefaultHeight(slot.name);
		container.id = 'naMediaAd_' + slotMap[slot.name];
		slot.container.appendChild(container);

		cmdQueue.push(function () {
			win.naMediaAd.includeAd(slotMap[slot.name]);
		});
	}

	init();

	return {
		name: 'NetzAthleten',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
