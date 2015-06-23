/*global define*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, slotTweaker, log, win) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.directGpt',
		atfFlushed = false,
		pendingSlots = [],
		delayedSlotsQueue = [],
		slotMap = {
			CORP_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			CORP_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			GPT_FLUSH:                  {flushOnly: true},
			HOME_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			HUB_TOP_LEADERBOARD:        {size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			INCONTENT_1A:               {size: '300x250', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_BOXAD_1:          {size: '300x250', loc: 'middle'},
			INCONTENT_LEADERBOARD_1:    {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_PLAYER:           {size: '640x400', 'loc': 'middle', 'pos': 'incontent_player'},
			INVISIBLE_SKIN:             {size: '1000x1000,1x1', loc: 'top'},
			LEFT_SKYSCRAPER_2:          {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '160x600', loc: 'footer'},
			MODAL_INTERSTITIAL_1:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_2:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_3:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_4:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_5:       {size: '300x250,300x600,728x90,970x250,160x600', loc: 'modal'},
			MODAL_INTERSTITIAL:         {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_RECTANGLE:            {size: '300x100', loc: 'modal'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_LEADERBOARD:            {size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'}
		},
		atfSlots = [
			'CORP_TOP_LEADERBOARD',
			'CORP_TOP_RIGHT_BOXAD',
			'HOME_TOP_LEADERBOARD',
			'HOME_TOP_RIGHT_BOXAD',
			'HUB_TOP_LEADERBOARD',
			'INVISIBLE_SKIN',
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'GPT_FLUSH'
		],
		provider;

	function delayBtfSlot(slotName, slotElement, success, hop) {
		log(['delayBtfSlot', slotName], 'debug', logGroup);
		if (atfSlots.indexOf(slotName) > -1) {
			if (!atfFlushed) {
				pendingSlots.push(slotName);
			}
			provider.fillInSlot(slotName, slotElement, success, hop);
			return;
		}

		atfFlushed = true;
		delayedSlotsQueue.push({
			slotName: slotName,
			slotElement: slotElement,
			success: success,
			hop: hop
		});
	}

	function blockBtfSlot(slotName, success) {
		log(['blockBtfSlot', slotName], 'debug', logGroup);
		success({
			adType: 'blocked'
		});
		slotTweaker.hide(slotName);
	}

	function fillInSlotWithDelay(slotName, slotElement, success, hop) {
		log(['fillInSlotWithDelay', slotName], 'debug', logGroup);
		if (context.opts.delayBtf) {
			if (!atfFlushed || pendingSlots.length > 0) {
				delayBtfSlot(slotName, slotElement, success, hop);
				return;
			}

			if (win.ads.runtime.disableBtf && atfSlots.indexOf(slotName) === -1) {
				blockBtfSlot(slotName, success);
				return;
			}
		}

		provider.fillInSlot(slotName, slotElement, success, hop);
	}

	function pushDelayedQueue() {
		log('pushDelayedQueue', 'debug', logGroup);
		delayedSlotsQueue.forEach(function (slot) {
			fillInSlotWithDelay(slot.slotName, slot.slotElement, slot.success, slot.hop);
		});
	}

	function removePendingSlotAndPushDelayedQueue(slotName) {
		log('pushDelayedQueue', 'debug', logGroup);
		if (!context.opts.delayBtf) {
			return;
		}
		var index = pendingSlots.indexOf(slotName);
		if (index > -1) {
			pendingSlots.splice(index, 1);
			if (pendingSlots.length === 0 && delayedSlotsQueue.length) {
				pushDelayedQueue();
			}
		}
	}

	provider = factory.createProvider(
		logGroup,
		'DirectGpt',
		'gpt',
		slotMap,
		{
			beforeSuccess: function (slotName) {
				log(['beforeSuccess', slotName], 'debug', logGroup);
				slotTweaker.removeDefaultHeight(slotName);
				slotTweaker.removeTopButtonIfNeeded(slotName);
				slotTweaker.adjustLeaderboardSize(slotName);
				removePendingSlotAndPushDelayedQueue(slotName);
			},
			beforeHop: function (slotName) {
				log(['beforeHop', slotName], 'debug', logGroup);
				removePendingSlotAndPushDelayedQueue(slotName);
			},
			sraEnabled: true
		}
	);

	return {
		name: provider.name,
		canHandleSlot: provider.canHandleSlot,
		fillInSlot: fillInSlotWithDelay
	};
});
