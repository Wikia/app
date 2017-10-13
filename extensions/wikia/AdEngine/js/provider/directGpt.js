/*global define, require*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slot.service.kiloAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.aRecoveryEngine.instartLogic.recovery'),
	require.optional('ext.wikia.aRecoveryEngine.pageFair.recovery'),
	require.optional('ext.wikia.aRecoveryEngine.sourcePoint.recovery')
], function (
	adContext,
	uapContext,
	factory,
	kiloAdUnitBuilder,
	megaAdUnitBuilder,
	slotTweaker,
	instartLogic,
	pageFair,
	sourcePoint
) {
	'use strict';

	var context = adContext.getContext(),
		sraEnabled = !context.opts.disableSra,
		atfSlots = [
			'TOP_LEADERBOARD',
			'GPT_FLUSH'
		];

	if (sraEnabled) {
		atfSlots.push('TOP_RIGHT_BOXAD', 'INVISIBLE_SKIN');
	}

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
				size: '3x3,728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
				loc: 'top'
			},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'}
		},
		{
			afterSuccess: function (slotName) {
				slotTweaker.removeDefaultHeight(slotName);
				if (!uapContext.isBfaaLoaded()) {
					slotTweaker.removeTopButtonIfNeeded(slotName);
					slotTweaker.adjustLeaderboardSize(slotName);
				}
			},
			isInstartLogicRecoverable: instartLogic ? instartLogic.isSlotRecoverable : false,
			isPageFairRecoverable: pageFair ? pageFair.isSlotRecoverable : false,
			isSourcePointRecoverable: sourcePoint ? sourcePoint.isSlotRecoverable : false,
			sraEnabled: sraEnabled,
			atfSlots: atfSlots,
			getAdUnitBuilder: function () {
				return context.opts.megaAdUnitBuilderEnabled ? megaAdUnitBuilder : kiloAdUnitBuilder;
			},
			highlyViewableSlots: [
				'INCONTENT_BOXAD_1',
				'INCONTENT_PLAYER',
				'INVISIBLE_HIGH_IMPACT_2'
			]
		}
	);
});
