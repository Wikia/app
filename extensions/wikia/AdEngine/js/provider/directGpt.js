/*global define*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.btfBlocker',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, slotTweaker, btfBlocker, log, win) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.directGpt',
		slotMap = {
			CORP_TOP_LEADERBOARD:       {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			CORP_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			GPT_FLUSH:                  {flushOnly: true},
			HOME_TOP_LEADERBOARD:       {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			HUB_TOP_LEADERBOARD:        {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			INCONTENT_BOXAD_1:          {size: '120x600,160x600,300x250,300x600', loc: 'hivi'},
			INCONTENT_PLAYER:           {size: '1x1', loc: 'middle'},
			INCONTENT_LEADERBOARD:      {size: '1x1,728x90,300x250,468x60', loc: 'hivi'},
			INVISIBLE_HIGH_IMPACT_2:    {loc: 'hivi'},
			INVISIBLE_SKIN:             {size: '1000x1000,1x1', loc: 'top'},
			LEFT_SKYSCRAPER_2:          {size: '120x600,160x600,300x250,300x600,300x1050', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '120x600,160x600,300x250,300x600', loc: 'footer'},
			MODAL_INTERSTITIAL_1:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_2:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_3:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_4:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_5:       {size: '300x250,300x600,728x90,970x250,160x600', loc: 'modal'},
			MODAL_INTERSTITIAL:         {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_MIDDLE_BOXAD:     {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_LEADERBOARD:            {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'}
		},
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD'
		],
		provider;

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
				btfBlocker.onSlotResponse(slotName);
			},
			beforeCollapse: function (slotName) {
				btfBlocker.onSlotResponse(slotName);
			},
			beforeHop: function (slotName) {
				log(['beforeHop', slotName], 'debug', logGroup);
				btfBlocker.onSlotResponse(slotName);
			},
			sraEnabled: true,
			recoverableSlots: recoverableSlots
		}
	);

	btfBlocker.init('oasis', provider.fillInSlot);

	return {
		name: provider.name,
		canHandleSlot: provider.canHandleSlot,
		fillInSlot: btfBlocker.fillInSlotWithDelay
	};
});
