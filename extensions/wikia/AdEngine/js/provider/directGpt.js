/*global define*/
/*jshint maxlen: 150*/
define('ext.wikia.adEngine.provider.directGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker'
], function (
	adContext,
	factory,
	slotTweaker
) {
	'use strict';

	var context = adContext.getContext(),
		sraEnabled = !context.opts.disableSra,
		firstCallSlots = [
			'TOP_LEADERBOARD',
			'GPT_FLUSH'
		];

	if (sraEnabled) {
		firstCallSlots.push('TOP_BOXAD', 'INVISIBLE_SKIN');
	}

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGpt',
		'DirectGpt',
		'gpt',
		{
			BOTTOM_LEADERBOARD:         {size: '3x3,728x90,970x250', loc: 'footer'},
			GPT_FLUSH:                  {flushOnly: true},
			INCONTENT_BOXAD_1:          {size: '120x600,160x600,300x250,300x600', loc: 'hivi'},
			INCONTENT_PLAYER:           {size: '1x1', loc: 'middle'},
			INVISIBLE_HIGH_IMPACT_2:    {loc: 'hivi'},
			INVISIBLE_SKIN:             {size: '1000x1000,1x1', loc: 'top'},
			TOP_LEADERBOARD:            {
				size: '3x3,728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150,1024x416,1440x585',
				loc: 'top'
			},
			TOP_BOXAD:                  {
				size: '300x250,300x600,300x1050',
				loc: 'top',
				pos: ['TOP_BOXAD', 'TOP_RIGHT_BOXAD']
			}
		},
		{
			afterSuccess: function (slotName) {
				slotTweaker.removeDefaultHeight(slotName);
			},
			atfSlots: [
				'TOP_LEADERBOARD',
				'TOP_BOXAD'
			],
			sraEnabled: sraEnabled,
			firstCallSlots: firstCallSlots,
			highlyViewableSlots: [
				'INCONTENT_BOXAD_1',
				'INCONTENT_PLAYER',
				'INVISIBLE_HIGH_IMPACT_2',
				'TOP_BOXAD'
			],
			testSrc: 'test'
		}
	);
});
