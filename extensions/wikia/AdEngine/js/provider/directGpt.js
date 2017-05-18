/*global define, require*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.adEngine.lookup.openx.openXBidderHelper'),
	require.optional('ext.wikia.aRecoveryEngine.pageFair.recovery'),
	require.optional('ext.wikia.aRecoveryEngine.sourcePoint.recovery')
], function (uapContext, factory, slotTweaker, openXHelper, pageFair, sourcePoint) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGpt',
		'DirectGpt',
		'gpt',
		{
			BOTTOM_LEADERBOARD:         {size: '728x90', loc: 'footer'},
			GPT_FLUSH:                  {flushOnly: true},
			INCONTENT_BOXAD_1:          {size: '120x600,160x600,300x250,300x600', loc: 'hivi'},
			INCONTENT_PLAYER:           {size: '1x1', loc: 'middle'},
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
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
				loc: 'top'
			},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'}
		},
		{
			beforeSuccess: function (slotName) {
				slotTweaker.removeDefaultHeight(slotName);
				if (!uapContext.isUapLoaded()) {
					slotTweaker.removeTopButtonIfNeeded(slotName);
					slotTweaker.adjustLeaderboardSize(slotName);
				}
			},
			beforeHop: function(slotName) {
				openXHelper && openXHelper.addOpenXSlot(slotName);
			},
			isPageFairRecoverable: pageFair ? pageFair.isSlotRecoverable : false,
			isSourcePointRecoverable: sourcePoint ? sourcePoint.isSlotRecoverable : false,
			sraEnabled: true,
			atfSlots: [
				'INVISIBLE_SKIN',
				'TOP_LEADERBOARD',
				'TOP_RIGHT_BOXAD',
				'GPT_FLUSH'
			],
			highlyViewableSlots: [
				'INCONTENT_BOXAD_1',
				'INCONTENT_PLAYER',
				'INVISIBLE_HIGH_IMPACT_2'
			]
		}
	);
});
